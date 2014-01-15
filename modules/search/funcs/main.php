<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 24/8/2010, 2:0
 */

if( ! defined( 'NV_IS_MOD_SEARCH' ) ) die( 'Stop!!!' );

$array_mod = LoadModulesSearch();
$is_search = false;
$search = array(
	'key' => '',
	'len_key' => 0,
	'mod' => 'all',
	'logic' => 1, //OR
	'page' => 0,
	'is_error' => false,
	'errorInfo' => '',
	'content' => ''
);

if( $nv_Request->isset_request( 'q', 'get' ) )
{
	$is_search = true;

	$search['key'] = nv_substr( $nv_Request->get_title( 'q', 'get', '', 0 ), 0, NV_MAX_SEARCH_LENGTH );
	$search['logic'] = $nv_Request->get_int( 'l', 'get', $search['logic'] );
	$search['mod'] = $nv_Request->get_title( 'm', 'get', 'all', $search['mod'] );
	$search['page'] = $nv_Request->get_int( 'page', 'get', 0 );

	if( $search['logic'] != 1 ) $search['logic'] = 0;
	if( ! isset( $array_mod[$search['mod']] ) ) $search['mod'] = 'all';

	if( ! empty( $search['key'] ) )
	{
		$search['key'] = nv_unhtmlspecialchars( $search['key'] );
		if( ! $search['logic'] ) $search['key'] = preg_replace( array( "/^([\S]{1})\s/uis", "/\s([\S]{1})\s/uis", "/\s([\S]{1})$/uis" ), " ", $search['key'] );
		$search['key'] = strip_punctuation( $search['key'] );
		$search['key'] = trim( $search['key'] );
		$search['len_key'] = nv_strlen( $search['key'] );
		$search['key'] = nv_htmlspecialchars( $search['key'] );
	}

	if( $search['len_key'] < NV_MIN_SEARCH_LENGTH )
	{
		$search['is_error'] = true;
		$search['errorInfo'] = sprintf( $lang_module['searchQueryError'], NV_MIN_SEARCH_LENGTH );
	}
	else
	{
		if( ! empty( $search['mod'] ) and isset( $array_mod[$search['mod']] ) )
		{
			$mods = array( $search['mod'] => $array_mod[$search['mod']] );
			$limit = 10;
			$is_generate_page = true;
		}
		else
		{
			$mods = $array_mod;
			$limit = 3;
			$is_generate_page = false;
		}

		foreach( $mods as $m_name => $m_values )
		{
			$pages = $search['page'];
			$all_page = 0;
			$key = $search['key'];
			$dbkeyword = $db->dblikeescape( $search['key'] );
			$logic = $search['logic'] ? 'AND' : 'OR';

			$result_array = array();
			include NV_ROOTDIR . '/modules/' . $m_values['module_file'] . '/search.php' ;

			if( ! empty( $all_page ) and ! empty( $result_array ) )
			{
				$search['content'] .= search_result_theme( $result_array, $m_name, $m_values['custom_title'], $search, $is_generate_page, $limit, $all_page );
			}
		}

		if( empty( $search['content'] ) ) $search['content'] = $lang_module['search_none'] . ' &quot;' . $search['key'] . '&quot;';
	}
}

$contents = search_main_theme( $is_search, $search, $array_mod );

$page_title = $module_info['custom_title'];
if( ! empty( $search['key'] ) )
{
	$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $search['key'];
	if( $search['page'] > 1 )
	{
		$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $search['page'];
	}
}
$key_words = $description = 'no';
$mod_title = isset( $lang_module['main_title'] ) ? $lang_module['main_title'] : $module_info['custom_title'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';

?>