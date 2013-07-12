<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2013 VINADES.,JSC. All rights reserved
 * @Createdate Sat, 30 Mar 2013 09:06:49 GMT
 */

if( ! defined( 'NV_IS_UPDATE' ) )
	die( 'Stop!!!' );

$nv_update_config = array( );

$nv_update_config['type'] = 1;
// Kieu nang cap 1: Update; 2: Upgrade

$nv_update_config['packageID'] = 'NVUDNKV35';
// ID goi cap nhat

$nv_update_config['formodule'] = "";
// Cap nhat cho module nao, de trong neu la cap nhat NukeViet, ten thu muc module neu la cap nhat module

// Thong tin phien ban, tac gia, ho tro
$nv_update_config['release_date'] = 1372606588;
$nv_update_config['author'] = "VINADES.,JSC (contact@vinades.vn)";
$nv_update_config['support_website'] = "http://nukeviet.vn/phpbb/viewforum.php?f=149";
$nv_update_config['to_version'] = "3.5.01";
$nv_update_config['allow_old_version'] = array( "3.4.02.r1929", "3.5.00.r3500" );
$nv_update_config['update_auto_type'] = 2;
// 0:Nang cap bang tay, 1:Nang cap tu dong, 2:Nang cap nua tu dong

$nv_update_config['lang'] = array( );
$nv_update_config['lang']['vi'] = array( );
$nv_update_config['lang']['en'] = array( );

// Tiếng Việt
$nv_update_config['lang']['vi']['nv_dellfile'] = 'Xóa các file không sử dụng';
$nv_update_config['lang']['vi']['nv_update_mod_banner'] = 'Nâng cấp module banner';
$nv_update_config['lang']['vi']['nv_update_mod_upload'] = 'Nâng cấp module upload';
$nv_update_config['lang']['vi']['nv_update_mod_news'] = 'Nâng cấp module news';
$nv_update_config['lang']['vi']['nv_up_finish'] = 'Nâng cấp version';

// English
$nv_update_config['lang']['en']['nv_dellfile'] = 'Delete unused files';
$nv_update_config['lang']['en']['nv_update_mod_banner'] = 'Update module Banner';
$nv_update_config['lang']['en']['nv_update_mod_upload'] = 'Update module upload';
$nv_update_config['lang']['en']['nv_update_mod_news'] = 'Update module news';
$nv_update_config['lang']['en']['nv_up_finish'] = 'Update version';

// Require level: 0: Khong bat buoc hoan thanh; 1: Canh bao khi that bai; 2: Bat buoc hoan thanh neu khong se dung nang cap.
// r: Revision neu la nang cap site, phien ban neu la nang cap module

$nv_update_config['tasklist'] = array( );
$nv_update_config['tasklist'][] = array(
	'r' => '3500',
	'rq' => 1,
	'l' => 'nv_dellfile',
	'f' => 'nv_dellfile'
);

$nv_update_config['tasklist'][] = array(
	'r' => '3500',
	'rq' => 2,
	'l' => 'nv_update_mod_banner',
	'f' => 'nv_update_mod_banner'
);

$nv_update_config['tasklist'][] = array(
	'r' => '3500',
	'rq' => 2,
	'l' => 'nv_update_mod_news',
	'f' => 'nv_update_mod_news'
);

$nv_update_config['tasklist'][] = array(
	'r' => '3500',
	'rq' => 2,
	'l' => 'nv_update_mod_upload',
	'f' => 'nv_update_mod_upload'
);

$nv_update_config['tasklist'][] = array(
	'r' => '3501',
	'rq' => 2,
	'l' => 'nv_up_finish',
	'f' => 'nv_up_finish'
);
function nv_dellfile( )
{
	global $nv_update_baseurl, $db, $db_config;
	$return = array(
		'status' => 1,
		'complete' => 1,
		'next' => 1,
		'link' => 'NO',
		'lang' => 'NO',
		'message' => '',
	);

	$error_msg = array( );
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/authors", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/database", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/language", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/modules", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/settings", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/siteinfo", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/themes", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/upload", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/webtools", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/includes/getloadavg.php" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}
	$del = nv_deletefile( NV_ROOTDIR . "/includes/core/wysyiwyg_functions.php" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/includes/ini/langs_multi.ini" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/includes/phpmailer/language", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/js/jquery/jquery.validate.js" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/js/popcalendar", true );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/settings/banip.tpl" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/settings/uploadconfig.tpl" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/webtools/googlecode.tpl" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	$del = nv_deletefile( NV_ROOTDIR . "/themes/admin_default/modules/webtools/main.tpl" );
	if( empty( $del[0] ) )
	{
		$error_msg[] = $del[1];
	}

	if( ! empty( $error_msg ) )
	{
		$return['status'] = 0;
		$return['complete'] = 0;
		$return['message'] = implode( '<br>', $error_msg );
	}
	return $return;
}

function nv_update_mod_banner( )
{
	global $nv_update_baseurl, $db, $db_config;

	//Xóa các trường không sử dụng trong CSDL module bannner
	$db->sql_query( "ALTER TABLE `" . NV_BANNERS_GLOBALTABLE . "_rows`
	  DROP `file_name_tmp`,
	  DROP `file_alt_tmp`,
	  DROP `click_url_tmp`" );

	$db->sql_query( "ALTER TABLE `" . NV_BANNERS_GLOBALTABLE . "_rows` ADD `imageforswf` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER `file_alt`" );
	$db->sql_query( "ALTER TABLE `" . NV_BANNERS_GLOBALTABLE . "_rows` ADD `target` VARCHAR( 10 ) NOT NULL DEFAULT '_blank' AFTER `click_url`" );

	define( 'NV_IS_MODADMIN', true );

	$lang_module['client_list'] = '';
	$lang_module['add_client'] = '';
	$lang_module['plans_list'] = '';
	$lang_module['add_plan'] = '';
	$lang_module['banners_list'] = '';
	$lang_module['add_banner'] = '';
	$lang_module['target_blank'] = '';
	$lang_module['target_top'] = '';
	$lang_module['target_self'] = '';
	$lang_module['target_parent'] = '';
	require_once (NV_ROOTDIR . "/modules/banners/admin.functions.php");
	nv_CreateXML_bannerPlan( );

	$return = array(
		'status' => 1,
		'complete' => 1,
		'next' => 1,
		'link' => 'NO',
		'lang' => 'NO',
		'message' => '',
	);

	return $return;
}

//Module Upload
function nv_udlistUploadDir( $dir, $real_dirlist = array() )
{
	$real_dirlist[] = $dir;

	if( ($dh = @opendir( NV_ROOTDIR . '/' . $dir )) !== false )
	{
		while( false !== ($subdir = readdir( $dh )) )
		{
			if( preg_match( "/^[a-zA-Z0-9\-\_]+$/", $subdir ) )
			{
				if( is_dir( NV_ROOTDIR . '/' . $dir . '/' . $subdir ) )
					$real_dirlist = nv_udlistUploadDir( $dir . '/' . $subdir, $real_dirlist );
			}
		}

		closedir( $dh );
	}

	return $real_dirlist;
}

function nv_getFileInfo( $pathimg, $file )
{
	clearstatcache( );

	$array_images = array(
		"gif",
		"jpg",
		"jpeg",
		"pjpeg",
		"png"
	);
	$array_flash = array(
		'swf',
		'swc',
		'flv'
	);
	$array_archives = array(
		'rar',
		'zip',
		'tar'
	);
	$array_documents = array(
		'doc',
		'xls',
		'chm',
		'pdf',
		'docx',
		'xlsx'
	);

	unset( $matches );
	preg_match( "/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/", $file, $matches );

	$info = array( );
	$info['name'] = $file;
	if( isset( $file{17} ) )
	{
		$info['name'] = substr( $matches[1], 0, (13 - strlen( $matches[2] )) ) . "..." . $matches[2];
	}

	$info['ext'] = $matches[2];
	$info['type'] = "file";

	$stat = @stat( NV_ROOTDIR . '/' . $pathimg . '/' . $file );
	$info['filesize'] = $stat['size'];

	$info['src'] = 'images/file.gif';
	$info['srcwidth'] = 32;
	$info['srcheight'] = 32;
	$info['size'] = "|";
	$ext = strtolower( $matches[2] );

	if( in_array( $ext, $array_images ) )
	{
		$size = @getimagesize( NV_ROOTDIR . '/' . $pathimg . '/' . $file );
		$info['type'] = "image";
		$info['src'] = $pathimg . '/' . $file;
		$info['srcwidth'] = $size[0];
		$info['srcheight'] = $size[1];
		$info['size'] = $size[0] . "|" . $size[1];

		if( $size[0] > 80 or $size[1] > 80 )
		{
			if( ($_src = nv_get_viewImage( $pathimg . '/' . $file, 80, 80 )) !== false )
			{
				$info['src'] = $_src[0];
				$info['srcwidth'] = $_src[1];
				$info['srcheight'] = $_src[2];
			}
			else
			{
				if( $info['srcwidth'] > 80 )
				{
					$info['srcheight'] = round( 80 / $info['srcwidth'] * $info['srcheight'] );
					$info['srcwidth'] = 80;
				}

				if( $info['srcheight'] > 80 )
				{
					$info['srcwidth'] = round( 80 / $info['srcheight'] * $info['srcwidth'] );
					$info['srcheight'] = 80;
				}
			}
		}
	}
	elseif( in_array( $ext, $array_flash ) )
	{
		$info['type'] = "flash";
		$info['src'] = 'images/flash.gif';

		if( $matches[2] == "swf" )
		{
			$size = @getimagesize( NV_ROOTDIR . '/' . $pathimg . '/' . $file );
			if( isset( $size, $size[0], $size[1] ) )
			{
				$info['size'] = $size[0] . "|" . $size[1];
			}
		}
	}
	elseif( in_array( $ext, $array_archives ) )
	{
		$info['src'] = 'images/zip.gif';
	}
	elseif( in_array( $ext, $array_documents ) )
	{
		$info['src'] = 'images/doc.gif';
	}

	$info['userid'] = 0;
	$info['mtime'] = $stat['mtime'];

	return $info;
}

/**
 * nv_get_viewImage()
 *
 * @param mixed $fileName
 * @return
 */
function nv_get_viewImage( $fileName )
{
	global $array_thumb_config;
	if( preg_match( "/^" . nv_preg_quote( NV_UPLOADS_DIR ) . "\/(([a-z0-9\-\_\/]+\/)*([a-z0-9\-\_\.]+)(\.(gif|jpg|jpeg|png)))$/i", $fileName, $m ) )
	{
		$viewFile = NV_FILES_DIR . '/' . $m[1];
		if( file_exists( NV_ROOTDIR . '/' . $viewFile ) )
		{
			$size = @getimagesize( NV_ROOTDIR . '/' . $viewFile );
			return array(
				$viewFile,
				$size[0],
				$size[1]
			);
		}
		else
		{
			$m[2] = rtrim( $m[2], '/' );
			$thumb_config = ( isset( $array_thumb_config[NV_UPLOADS_DIR . '/' . $m[2]] )) ? $array_thumb_config[NV_UPLOADS_DIR . '/' . $m[2]] : $array_thumb_config[''];
			$viewDir = NV_FILES_DIR;
			if( ! empty( $m[2] ) )
			{
				if( ! is_dir( NV_ROOTDIR . '/' . $m[2] ) )
				{
					$e = explode( "/", $m[2] );
					$cp = NV_FILES_DIR;
					foreach( $e as $p )
					{
						if( is_dir( NV_ROOTDIR . '/' . $cp . '/' . $p ) )
						{
							$viewDir .= '/' . $p;
						}
						else
						{
							$mk = nv_mkdir( NV_ROOTDIR . '/' . $cp, $p );
							if( $mk[0] > 0 )
							{
								$viewDir .= '/' . $p;
							}
						}
						$cp .= '/' . $p;
					}
				}
			}
			include_once (NV_ROOTDIR . "/includes/class/image.class.php");
			$image = new image( NV_ROOTDIR . '/' . $fileName, NV_MAX_WIDTH, NV_MAX_HEIGHT );
			if( $thumb_config['thumb_type'] == 4 )
			{
				$thumb_width = $thumb_config['thumb_width'];
				$thumb_height = $thumb_config['thumb_height'];
				$maxwh = max( $thumb_width, $thumb_height );
				if( $image->fileinfo['width'] > $image->fileinfo['height'] )
				{
					$thumb_config['thumb_width'] = 0;
					$thumb_config['thumb_height'] = $maxwh;
				}
				else
				{
					$thumb_config['thumb_width'] = $maxwh;
					$thumb_config['thumb_height'] = 0;
				}
			}
			$image->resizeXY( $thumb_config['thumb_width'], $thumb_config['thumb_height'] );
			if( $thumb_config['thumb_type'] == 4 )
			{
				$image->cropFromCenter( $thumb_width, $thumb_height );
			}
			$image->save( NV_ROOTDIR . '/' . $viewDir, $m[3] . $m[4], $thumb_config['thumb_quality'] );
			$create_Image_info = $image->create_Image_info;
			$error = $image->error;
			$image->close( );
			if( empty( $error ) )
			{
				return array(
					$viewDir . '/' . basename( $create_Image_info['src'] ),
					$create_Image_info['width'],
					$create_Image_info['height']
				);
			}
		}
	}
	else
	{
		$size = @getimagesize( NV_ROOTDIR . '/' . $fileName );
		return array(
			$fileName,
			$size[0],
			$size[1]
		);
	}
	return false;
}

function nv_update_mod_upload( )
{
	global $nv_update_baseurl, $db, $db_config, $nv_Request;
	$return = array(
		'status' => 1,
		'complete' => 1,
		'next' => 1,
		'link' => 'NO',
		'lang' => 'NO',
		'message' => '',
	);

	$nstep = $nv_Request->get_int( 'nstep', 'get', 0 );
	if( $nstep == 0 )
	{
		$db->sql_query( "CREATE TABLE `" . NV_UPLOAD_GLOBALTABLE . "_dir` (
		  `did` int(11) NOT NULL AUTO_INCREMENT,
		  `dirname` varchar(255) NOT NULL,
		  `time` int(11) NOT NULL DEFAULT '0',
		  `thumb_type` tinyint(4) NOT NULL DEFAULT '0',
		  `thumb_width` smallint(6) NOT NULL DEFAULT '0',
		  `thumb_height` smallint(6) NOT NULL DEFAULT '0',
		  `thumb_quality` tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`did`),
		  UNIQUE KEY `name` (`dirname`)
		) ENGINE=MyISAM" );
		$db->sql_query( "INSERT INTO `" . NV_UPLOAD_GLOBALTABLE . "_dir` (`did`, `dirname`, `time`, `thumb_type`, `thumb_width`, `thumb_height`, `thumb_quality`) VALUES ('-1', '', 0, 3, 100, 150, 90)" );
		$db->sql_query( "UPDATE `" . NV_UPLOAD_GLOBALTABLE . "_dir` SET `did` = '0' WHERE `did` = '-1'" );

		$db->sql_query( "CREATE TABLE `" . NV_UPLOAD_GLOBALTABLE . "_file` (
		  `name` varchar(255) NOT NULL,
		  `ext` varchar(10) NOT NULL DEFAULT '',
		  `type` varchar(5) NOT NULL DEFAULT '',
		  `filesize` int(11) NOT NULL DEFAULT '0',
		  `src` varchar(255) NOT NULL DEFAULT '',
		  `srcwidth` int(11) NOT NULL DEFAULT '0',
		  `srcheight` int(11) NOT NULL DEFAULT '0',
		  `size` varchar(50) NOT NULL DEFAULT '',
		  `userid` int(11) NOT NULL DEFAULT '0',
		  `mtime` int(11) NOT NULL DEFAULT '0',
		  `did` int(11) NOT NULL DEFAULT '0',
		  `title` varchar(255) NOT NULL DEFAULT '',
		  UNIQUE KEY `did` (`did`,`title`),
		  KEY `userid` (`userid`),
		  KEY `type` (`type`)
		) ENGINE=MyISAM" );

		$real_dirlist = array( );
		$allow_upload_dir = array(
			'images',
			NV_UPLOADS_DIR
		);

		foreach( $allow_upload_dir as $dir )
		{
			$real_dirlist = nv_udlistUploadDir( $dir, $real_dirlist );
		}

		foreach( $real_dirlist as $info )
		{
			$db->sql_query( "INSERT INTO `" . NV_UPLOAD_GLOBALTABLE . "_dir` (`did`, `dirname`, `time`, `thumb_type`, `thumb_width`, `thumb_height`, `thumb_quality`) VALUES (NULL, '" . $info . "', '0', '0', '0', '0', '0')" );
		}
		$return['next'] = 0;
	}
	else
	{
		list( $did, $pathimg ) = $db->sql_fetchrow( $db->sql_query( "SELECT `did`, `dirname` FROM `" . NV_UPLOAD_GLOBALTABLE . "_dir` WHERE `time`=0 AND `did` > 0 LIMIT 1" ) );
		if( $did )
		{
			$tempFile = NV_ROOTDIR . "/" . NV_FILES_DIR . "/dcache/" . md5( $pathimg );
			$results = array( );
			if( file_exists( $tempFile ) )
			{
				$dir_time = filectime( $tempFile );
				$results = file_get_contents( $tempFile );
				$results = unserialize( $results );
				foreach( $results as $title => $info )
				{
					$db->sql_query( "INSERT INTO `" . NV_UPLOAD_GLOBALTABLE . "_file`
						(`name`, `ext`, `type`, `filesize`, `src`, `srcwidth`, `srcheight`, `size`, `userid`, `mtime`, `did`, `title`)
						VALUES ('" . $info[0] . "', '" . $info[1] . "', '" . $info[2] . "', " . $info[3] . ", '', " . $info[5] . ", " . $info[6] . ", '" . $info[7] . "', " . $info[8] . ", " . $info[9] . ", " . $did . ", '" . $title . "')" );
				}
			}
			else
			{
				$dir_time = 1;
				if( $dh = opendir( NV_ROOTDIR . "/" . $pathimg ) )
				{
					$array_hidefolders = array(
						".",
						"..",
						"index.html",
						".htaccess",
						".tmp"
					);

					while( ($title = readdir( $dh )) !== false )
					{
						if( in_array( $title, $array_hidefolders ) )
							continue;

						if( preg_match( "/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/", $title, $m ) )
						{
							$info = nv_getFileInfo( $pathimg, $title );
							$info['did'] = $did;
							$info['title'] = $title;
							$info['userid'] = 0;
							$db->sql_query( "INSERT INTO `" . NV_UPLOAD_GLOBALTABLE . "_file`
								(`name`, `ext`, `type`, `filesize`, `src`, `srcwidth`, `srcheight`, `size`, `userid`, `mtime`, `did`, `title`)
								VALUES ('" . $info['name'] . "', '" . $info['ext'] . "', '" . $info['type'] . "', " . $info['filesize'] . ", '" . $info['src'] . "', " . $info['srcwidth'] . ", " . $info['srcheight'] . ", '" . $info['size'] . "', " . $info['userid'] . ", " . $info['mtime'] . ", " . $did . ", '" . $title . "')" );
						}
					}
					closedir( $dh );
					$dir_time = NV_CURRENTTIME;
				}
			}
			$db->sql_query( "UPDATE `" . NV_UPLOAD_GLOBALTABLE . "_dir` SET `time` = '" . $dir_time . "' WHERE `did` = " . $did );
			$return['next'] = 0;
			$return['message'] = $pathimg;
		}
		else
		{
			nv_deletefile( NV_ROOTDIR . "/" . NV_FILES_DIR . "/dcache", true );
			nv_deletefile( NV_ROOTDIR . "/" . NV_FILES_DIR . "/images", true );
		}
	}
	if( empty( $return['next'] ) )
	{
		$return['complete'] = 0;
		$return['link'] = $nv_update_baseurl . '&nstep=' . ++$nstep;
	}
	return $return;
}

function nv_update_mod_news( )
{
	global $nv_update_baseurl, $db, $db_config, $nv_Request;
	$return = array(
		'status' => 1,
		'complete' => 1,
		'next' => 1,
		'link' => 'NO',
		'lang' => 'NO',
		'message' => '',
	);

	$nstep = $nv_Request->get_int( 'nstep', 'post,get', 0 );
	if( $nstep == 0 )
	{
		$array_update_mod_news = array( );
		$result = $db->sql_query( "SELECT `lang` FROM `" . $db_config['prefix'] . "_setup_language` WHERE `setup`=1" );
		while( list( $nlang ) = $db->sql_fetchrow( $result ) )
		{
			// Get all module of news
			$result1 = $db->sql_query( "SELECT `title`, `module_data` FROM `" . $db_config['prefix'] . "_" . $nlang . "_modules` WHERE `module_file`='news'" );
			while( list( $ntitle, $ndata ) = $db->sql_fetchrow( $result1 ) )
			{
				$array_update_mod_news[] = array(
					"nlang" => $nlang,
					"ntitle" => $ntitle,
					"ndata" => $ndata
				);
			}
		}

		if( ! empty( $array_update_mod_news ) )
		{
			$nid = 0;
			$nstep = 1;
			$return['complete'] = 0;
			$return['next'] = 0;
			$return['link'] = $nv_update_baseurl . '&nid=' . $nid . '&nstep=' . $nstep;
			$nv_Request->set_Session( 'update_mod_news', serialize( $array_update_mod_news ) );
		}
	}
	else
	{
		$array_update_mod_new = unserialize( $nv_Request->get_string( 'update_mod_news', 'session' ) );
		$nid = $nv_Request->get_int( 'nid', 'post,get', 0 );
		if( isset( $array_update_mod_new[$nid] ) )
		{
			$_mod = $array_update_mod_new[$nid];

			$module_name = $_mod['ntitle'];
			$module_data = $_mod['ndata'];
			$nv_prefixlang = $db_config['prefix'] . '_' . $_mod['nlang'];

			$sql = "SELECT `id`, `listcatid`, `homeimgfile`,  `homeimgthumb` FROM `" . $nv_prefixlang . "_" . $module_data . "_rows` WHERE  `status` < 100 LIMIT  0, 100";
			$result = $db->sql_query( $sql );
			if( $db->sql_numrows( $result ) )
			{
				while( $item = $db->sql_fetch_assoc( $result ) )
				{
					$array_img = ( ! empty( $item['homeimgthumb'] )) ? explode( "|", $item['homeimgthumb'] ) : $array_img = array(
						"",
						""
					);
					$homeimgthumb = 0;
					if( $item['homeimgfile'] != "" and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . $item['homeimgfile'] ) and $array_img[0] != "" and file_exists( NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name . '/' . $array_img[0] ) )
					{
						$path = dirname( $item['homeimgfile'] );
						if( ! empty( $path ) )
						{
							if( ! is_dir( NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name . '/' . $path ) )
							{
								$e = explode( "/", $path );
								$cp = NV_FILES_DIR . '/' . $module_name;
								foreach( $e as $p )
								{
									if( is_dir( NV_ROOTDIR . '/' . $cp . '/' . $p ) )
									{
										$viewDir .= '/' . $p;
									}
									else
									{
										$mk = nv_mkdir( NV_ROOTDIR . '/' . $cp, $p );
										if( $mk[0] > 0 )
										{
											$viewDir .= '/' . $p;
										}
									}
									$cp .= '/' . $p;
								}
							}
						}
						if( @rename( NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name . '/' . $array_img[0], NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name . '/' . $item['homeimgfile'] ) )
						{
							$homeimgthumb = 1;
						}
						else
						{
							$homeimgthumb = 2;
						}
					}
					elseif( nv_is_url( $item['homeimgfile'] ) )
					{
						$homeimgthumb = 3;
					}
					elseif( $item['homeimgfile'] != "" and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . $item['homeimgfile'] ) )
					{
						$homeimgthumb = 2;
					}
					$db->sql_query( "UPDATE `" . $nv_prefixlang . "_" . $module_data . "_rows` SET `homeimgthumb`= '" . $homeimgthumb . "', `status`=`status`+100 WHERE `id` =" . $item['id'] );
					$catids = explode( ",", $item['listcatid'] );
					foreach( $catids as $catid )
					{
						$db->sql_query( "UPDATE `" . $nv_prefixlang . "_" . $module_data . "_" . $catid . "` SET `homeimgthumb`= '" . $homeimgthumb . "' WHERE `id` =" . $item['id'] );
					}
				}
				$nstep++;
				$return['message'] = $_mod['nlang'] . ': ' . $_mod['ntitle'];
				$return['complete'] = 0;
				$return['next'] = 0;
				$return['link'] = $nv_update_baseurl . '&nid=' . $nid . '&nstep=' . $nstep;
			}
			else
			{
				$db->sql_query( "UPDATE `" . $nv_prefixlang . "_" . $module_data . "_rows` SET `status`=`status`-100 WHERE `status`>=100" );
				$sql = "SELECT `catid` FROM `" . $nv_prefixlang . "_" . $module_data . "_cat`";
				$result = $db->sql_query( $sql );
				while( $item = $db->sql_fetch_assoc( $result ) )
				{
					$db->sql_query( "ALTER TABLE `" . $nv_prefixlang . "_" . $module_data . "_" . $item['catid'] . "` CHANGE `homeimgthumb` `homeimgthumb` TINYINT(4) NOT NULL DEFAULT '0'" );
				}
				nv_deletefile( NV_ROOTDIR . "/" . NV_FILES_DIR . "/" . $module_data . "/block", true );
				nv_deletefile( NV_ROOTDIR . "/" . NV_FILES_DIR . "/" . $module_data . "/thumb", true );

				$nid++;
				if( isset( $array_update_mod_new[$nid] ) )
				{
					$_mod = $array_update_mod_new[$nid];
					$return['message'] = $_mod['nlang'] . ': ' . $_mod['ntitle'];
					$return['complete'] = 0;
					$return['next'] = 0;
					$return['link'] = $nv_update_baseurl . '&nid=' . $nid . '&nstep=' . $nstep;
				}
			}
		}
	}
	return $return;
}

function nv_up_finish( )
{
	global $nv_update_baseurl, $db, $db_config;
	$return = array(
		'status' => 1,
		'complete' => 1,
		'next' => 1,
		'link' => 'NO',
		'lang' => 'NO',
		'message' => '',
	);

	$mod_version = "3.5.01 1372606588";
	$db->sql_query( "UPDATE `" . $db_config['prefix'] . "_setup_modules` SET `mod_version`='" . $mod_version . "' WHERE `module_file` IN ('about', 'banners', 'contact', 'news', 'voting', 'search', 'users', 'download', 'weblinks', 'statistics', 'faq', 'menu', 'rss')" );

	$db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'version', '3.5.01')" );
	$db->sql_query( "REPLACE INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'revision', '3501')" );

	nv_save_file_config_global( );

	return $return;
}
?>