<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:30
 */

if( ! defined( 'NV_IS_MOD_DOWNLOAD' ) ) die( 'Stop!!!' );

//if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
$list_cats = nv_list_cats( true );

//dang thao luan
if( $nv_Request->isset_request( 'ajax', 'post' ) )
{
	if( ! empty( $list_cats ) )
	{
		$in = implode( ',', array_keys( $list_cats ) );

		$id = $nv_Request->get_int( 'id', 'post', 0 );
		$data = $error = array();
		if( $id )
		{
			$query = 'SELECT id, who_comment, groups_comment FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $id . ' AND catid IN (' . $in . ') AND status=1 AND comment_allow=1';
			list( $id, $who_comment, $groups_comment ) = $db->query( $query )->fetch( 3 );
			if( $id )
			{
				if( nv_set_allow( $who_comment, $groups_comment ) )
				{
					$uname = $nv_Request->get_title( 'uname', 'post', '', 1 );
					$uemail = $nv_Request->get_title( 'uemail', 'post', '' );
					$subject = $nv_Request->get_title( 'subject', 'post', '', 1 );
					$content = $nv_Request->get_textarea( 'content', '', NV_ALLOWED_HTML_TAGS );
					$seccode = $nv_Request->get_title( 'seccode', 'post', '' );
					$post_id = 0;

					if( defined( 'NV_IS_USER' ) )
					{
						$uname = ! empty( $user_info['full_name'] ) ? $user_info['full_name'] : $user_info['username'];
						$uemail = $user_info['email'];
						$post_id = $user_info['userid'];
					}

					if( ! nv_capcha_txt( $seccode ) )
					{
						$error[] = $lang_module['comment_error2'];
					}

					if( empty( $uname ) or nv_strlen( $uname ) < 3 )
					{
						$error[] = $lang_module['comment_error3'];
					}

					if( ( $validemail = nv_check_valid_email( $uemail ) ) != '' )
					{
						$error[] = $validemail;
					}

					if( empty( $subject ) or nv_strlen( $subject ) < 3 )
					{
						$error[] = $lang_module['comment_error4'];
					}

					if( empty( $content ) or nv_strlen( $content ) < 3 )
					{
						$error[] = $lang_module['comment_error5'];
					}

					$download_config = nv_mod_down_config();
					if( $download_config['is_autocomment_allow'] )
					{
						$status = 1;
					}
					else
					{
						$status = 0;
					}
					if( ! empty( $error ) )
					{
						echo implode( "\n", $error );
						die();
					}
					$content = nv_nl2br( $content, '<br />' );

					try
					{
						$sth = $db->prepare( "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_comments
							(fid, subject, post_id, post_name, post_email, post_ip, post_time, content, admin_reply, admin_id, status) VALUES (
							" . $id . ",:subject, " . $post_id . ", :uname, :uemail, :post_ip, " . NV_CURRENTTIME . ", :content, '', 0, " . $status . ")" );

						$sth->bindParam( ':subject', $subject, PDO::PARAM_STR );
						$sth->bindParam( ':uname', $uname, PDO::PARAM_STR );
						$sth->bindParam( ':uemail', $uemail, PDO::PARAM_STR );
						$sth->bindParam( ':post_ip', $client_info['ip'], PDO::PARAM_STR );
						$sth->bindParam( ':content', $content, PDO::PARAM_STR );
						$sth->execute();

						if( $status )
						{
							$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET comment_hits=comment_hits+1 WHERE id=' . $id );
						}

					}
					catch (PDOException $e)
					{
						$error[] = $lang_module['comment_error6'];
					}

					if( ! empty( $error ) )
					{
						echo implode( "\n", $error );
						die();
					}
					elseif( $status == 1 )
					{
						die( 'OK' );
					}
					else
					{
						die( 'WAIT' );
					}
				}
			}
		}
	}
}

//list_comment
$generate_page = '';
if( $nv_Request->isset_request( 'list_comment', 'get' ) )
{
	if( ! empty( $list_cats ) )
	{
		$in = implode( ',', array_keys( $list_cats ) );

		$id = $nv_Request->get_int( 'list_comment', 'get', 0 );

		if( $id )
		{
			$array = array();
			$users = array();
			$admins = array();

			$page = $nv_Request->get_int( 'page', 'get', 0 );
			$per_page = 15;

			$db->sqlreset()
				->select( 'COUNT(*)' )
				->from( NV_PREFIXLANG . '_' . $module_data . '_comments a' )
				->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . ' b ON a.fid = b.id LEFT JOIN ' . $db_config['dbsystem'] . '.' . NV_USERS_GLOBALTABLE . ' c ON a.post_id =c.userid' )
				->where( 'a.fid=' . $id . ' AND a.status=1 AND b.catid IN (' . $in . ') AND b.status=1 AND b.comment_allow=1' );

			$all_page = $db->query( $db->sql() )->fetchColumn();
			if( $all_page )
			{
				$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=getcomment&amp;list_comment=' . $id;

				$today = mktime( 0, 0, 0, date( 'n' ), date( 'j' ), date( 'Y' ) );
				$yesterday = $today - 86400;

				$db->select('a.id AS id, a.subject AS subject, a.post_id AS post_id, a.post_name AS post_name, a.post_email AS post_email,
						a.post_ip AS post_ip, a.post_time AS post_time, a.content AS content, a.admin_reply AS admin_reply, a.admin_id AS admin_id,
						c.email as email, c.full_name as full_name, c.photo as photo, c.view_mail as view_mail')
					->order( 'a.post_time DESC' )
					->limit( $per_page )
					->offset( $page );

				$result = $db->query( $db->sql() );
				while( $row = $result->fetch() )
				{
					$post_name = $row['post_name'];
					if( ! $row['post_id'] )
					{
						$post_name .= ' (' . nv_EncodeEmail( $row['post_email'] ) . ', ' . $row['post_ip'] . ')';
						$row['photo'] = '';
					}
					else
					{
						$row['post_email'] = ( $row['view_mail'] ) ? $row['email'] : '';
						$row['post_name'] = $row['full_name'];
						if( defined( 'NV_IS_MODADMIN' ) )
						{
							if( isset( $users[$row['post_id']] ) )
							{
								$users[$row['post_id']][] = ( int )$row['id'];
							}
							else
							{
								$users[$row['post_id']] = array( $row['id'] );
							}
							$post_name = '<a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=users&amp;' . NV_OP_VARIABLE . '=edit&amp;userid=' . $row['post_id'] . '">' . $post_name . '</a>';
						}
					}

					$post_time = ( int )$row['post_time'];
					if( $post_time >= $today )
					{
						$post_time = $lang_module['today'] . ', ' . date( 'H:i', $post_time );
					}
					elseif( $post_time >= $yesterday )
					{
						$post_time = $lang_module['yesterday'] . ', ' . date( 'H:i', $post_time );
					}
					else
					{
						$post_time = nv_date( 'd/m/Y H:i', $post_time );
					}

					$admin_reply = '';
					if( ! empty( $row['admin_id'] ) and ! empty( $row['admin_reply'] ) )
					{
						if( defined( 'NV_IS_ADMIN' ) )
						{
							if( isset( $admins[$row['admin_id']] ) )
							{
								$admins[$row['admin_id']][] = ( int )$row['id'];
							}
							else
							{
								$admins[$row['admin_id']] = array( $row['id'] );
							}
							$admin_reply = $row['admin_reply'];
						}
						else
						{
							$admin_reply = $lang_module['comment_admin_note'] . ': ' . $row['admin_reply'];
						}
					}

					$array[$row['id']] = array(
						'id' => ( int )$row['id'],
						'post_name' => $post_name,
						'post_email' => $row['post_email'],
						'photo' => $row['photo'],
						'post_ip' => $row['post_ip'],
						'post_time' => $post_time,
						'subject' => $row['subject'],
						'comment' => $row['content'],
						'admin_reply' => $admin_reply,
						'edit_link' => NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=comment&amp;edit=1&amp;id=' . $row['id'],
						'del_link' => NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=comment'
					);
				}

				if( ! empty( $users ) )
				{
					$in = array_keys( $users );
					$in = array_unique( $in );
					$in = implode( ',', $in );

					$query = 'SELECT view_mail, userid FROM ' . $db_config['dbsystem'] . '.' . NV_USERS_GLOBALTABLE . ' WHERE userid IN (' . $in . ')';
					$result = $db->query( $query );
					while( list( $view_mail, $userid ) = $result->fetch( 3 ) )
					{
						if( isset( $users[$userid] ) )
						{
							foreach( $users[$userid] as $id )
							{
								if( ! empty( $array[$id]['post_email'] ) and ( defined( 'NV_IS_ADMIN' ) or $view_mail ) )
								{
									$array[$id]['post_email'] = nv_EncodeEmail( $array[$id]['post_email'] );
									$array[$id]['post_name'] .= ' (' . $array[$id]['post_email'] . ', ' . $array[$id]['post_ip'] . ')';
								}
								else
								{
									$array[$id]['post_email'] = '';
								}
							}
						}
					}
				}

				if( ! empty( $admins ) )
				{
					$in = array_keys( $admins );
					$in = array_unique( $in );
					$in = implode( ',', $in );

					$query = 'SELECT userid AS admin_id, username AS admin_login, full_name AS admin_name FROM ' . $db_config['dbsystem'] . '.' . NV_USERS_GLOBALTABLE . ' WHERE userid IN (' . $in . ')';
					$result = $db->query( $query );
					while( list( $admin_id, $admin_login, $admin_name ) = $result->fetch( 3 ) )
					{
						$admin_name = ! empty( $admin_name ) ? $admin_name : $admin_login;

						if( isset( $admins[$admin_id] ) )
						{
							foreach( $admins[$admin_id] as $id )
							{
								$array[$id]['admin_reply'] = $lang_module['comment_admin_note'] . ' <a href="' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=authors&amp;id=' . $admin_id . '">' . $admin_name . '</a>: ' . $array[$id]['admin_reply'];
							}
						}
					}
				}
				$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page, true, true, 'nv_urldecode_ajax', 'list_comments' );
			}
			$contents = show_comment( $array, $generate_page );
			die( $contents );
		}
	}

	die( $lang_module['comment_error7'] );
}

?>