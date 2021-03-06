<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-2-2010 12:55
 */

if( ! defined( 'NV_IS_FILE_THEMES' ) ) die( 'Stop!!!' );

$module = $nv_Request->get_string( 'module', 'get', '' );
$bid = $nv_Request->get_int( 'bid', 'get,post', 0 );

$file = $db->query( 'SELECT file_name FROM ' . NV_BLOCKS_TABLE . '_groups WHERE bid=' . $bid )->fetchColumn();

echo "<option value=\"\">" . $lang_module['block_select'] . "</option>\n";

if( $module == 'global' )
{
	$block_file_list = nv_scandir( NV_ROOTDIR . '/includes/blocks', $global_config['check_block_global'] );

	foreach( $block_file_list as $file_name )
	{
		$sel = ( $file == $file_name ) ? ' selected' : '';
		unset( $matches );
		preg_match( $global_config['check_block_module'], $file_name, $matches );
		$load_config = ( file_exists( NV_ROOTDIR . '/includes/blocks/' . $matches[1] . '.' . $matches[2] . '.ini' ) ) ? 1 : 0;

		echo "<option value=\"" . $file_name . "|" . $load_config . "\" " . $sel . ">" . $matches[1] . " " . $matches[2] . " </option>\n";
	}
}
elseif( preg_match( $global_config['check_module'], $module ) )
{
	$sth = $db->prepare( 'SELECT module_file FROM ' . NV_MODULES_TABLE . ' WHERE title= :title' );
	$sth->bindParam( ':title', $module, PDO::PARAM_STR );
	$sth->execute();
	$module_file = $sth->fetchColumn();
	if( !empty( $module_file ) )
	{
		if( file_exists( NV_ROOTDIR . '/modules/' . $module_file . '/blocks' ) )
		{
			$block_file_list = nv_scandir( NV_ROOTDIR . '/modules/' . $module_file . '/blocks', $global_config['check_block_module'] );

			foreach( $block_file_list as $file_name )
			{
				$sel = ( $file == $file_name ) ? ' selected' : '';

				unset( $matches );
				preg_match( $global_config['check_block_module'], $file_name, $matches );

				$load_config = ( file_exists( NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini' ) ) ? 1 : 0;

				echo "<option value=\"" . $file_name . "|" . $load_config . "\" " . $sel . ">" . $matches[1] . " " . $matches[2] . " </option>\n";
			}
		}
	}
}

?>