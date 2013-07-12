<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2013 VINADES.,JSC. All rights reserved
 * @Createdate Sat, 30 Mar 2013 09:06:49 GMT
 */

if( ! defined( 'NV_IS_UPDATE' ) )
	die( 'Stop!!!' );

define( 'NV_ADMIN', true );
define( 'NV_MAINFILE', true );

//Thoi gian bat dau phien lam viec
define( 'NV_START_TIME', array_sum( explode( " ", microtime( ) ) ) );

//Khong cho xac dinh tu do cac variables
$db_config = $global_config = $module_config = $client_info = $user_info = $admin_info = $sys_info = $lang_global = $lang_module = $rss = $nv_vertical_menu = $array_mod_title = $content_type = $submenu = $select_options = $error_info = $countries = $newCountry = array( );
$page_title = $key_words = $canonicalUrl = $mod_title = $editor_password = $my_head = $my_footer = $description = $contents = "";
$editor = false;

$sys_info['disable_classes'] = (($disable_classes = ini_get( "disable_classes" )) != "" and $disable_classes != false) ? array_map( 'trim', preg_split( "/[\s,]+/", $disable_classes ) ) : array( );
$sys_info['disable_functions'] = (($disable_functions = ini_get( "disable_functions" )) != "" and $disable_functions != false) ? array_map( 'trim', preg_split( "/[\s,]+/", $disable_functions ) ) : array( );

if( extension_loaded( 'suhosin' ) )
{
	$sys_info['disable_functions'] = array_merge( $sys_info['disable_functions'], array_map( 'trim', preg_split( "/[\s,]+/", ini_get( "suhosin.executor.func.blacklist" ) ) ) );
}

$sys_info['ini_set_support'] = (function_exists( 'ini_set' ) and ! in_array( 'ini_set', $sys_info['disable_functions'] )) ? true : false;

//Xac dinh thu muc goc cua site
define( 'NV_ROOTDIR', str_replace( '\\', '/', realpath( pathinfo( __file__, PATHINFO_DIRNAME ) . '/../' ) ) );

//Ket noi voi cac file constants, config
require (NV_ROOTDIR . "/includes/constants.php");

if( file_exists( NV_ROOTDIR . "/" . NV_CONFIG_FILENAME ) )
{
	require ( realpath( NV_ROOTDIR . "/" . NV_CONFIG_FILENAME ));
}
else
{
	die( 'sys not install' );
}
$global_config['engine_allowed'] = array( );
$global_config['cookie_httponly'] = 1;
$global_config['idsite'] = 0;
$global_config['statistics_timezone'] = 'Asia/Bangkok';
$global_config['date_pattern'] = 'l, d-m-Y';
$global_config['time_pattern'] = 'H:i';
$global_config['searchEngineUniqueID'] = '';
$global_config['cookie_secure'] = 0;
$global_config['nv_unick_type'] = 4;

// Tài khoản chỉ được sử dụng Unicode, không có các ký tự đặc biệt
$global_config['nv_upass_type'] = 0;
// Mật khẩu cần kết hợp số và chữ

require (NV_ROOTDIR . "/" . NV_DATADIR . "/config_global.php");
if( ! defined( 'NV_UPASSMAX' ) )
{
	//so ky tu toi da cua password doi voi user
	define( 'NV_UPASSMAX', 20 );

	//so ky tu toi thieu cua password doi voi user
	define( 'NV_UPASSMIN', 5 );

	//so ky tu toi da cua ten tai khoan doi voi user
	define( 'NV_UNICKMAX', 20 );

	//so ky tu toi thieu cua ten tai khoan doi voi user
	define( 'NV_UNICKMIN', 4 );

	define( 'NV_LIVE_COOKIE_TIME', 31104000 );

	// Ma HTML duoc chap nhan
	define( 'NV_ALLOWED_HTML_TAGS', 'embed, object, param, a, b, blockquote, br, caption, col, colgroup, div, em, h1, h2, h3, h4, h5, h6, hr, i, img, li, p, span, strong, sub, sup, table, tbody, td, th, tr, u, ul' );

	//Chống IFRAME
	define( 'NV_ANTI_IFRAME', 0 );
}
$search = array(
	'&amp;',
	'&#039;',
	'&quot;',
	'&lt;',
	'&gt;',
	'&#x005C;',
	'&#x002F;',
	'&#40;',
	'&#41;',
	'&#42;',
	'&#91;',
	'&#93;',
	'&#33;',
	'&#x3D;',
	'&#x23;',
	'&#x25;',
	'&#x5E;',
	'&#x3A;',
	'&#x7B;',
	'&#x7D;',
	'&#x60;',
	'&#x7E;'
);
$replace = array(
	'&',
	'\'',
	'"',
	'<',
	'>',
	'\\',
	'/',
	'(',
	')',
	'*',
	'[',
	']',
	'!',
	'=',
	'#',
	'%',
	'^',
	':',
	'{',
	'}',
	'`',
	'~'
);
$nv_parse_ini_timezone = array(
	'Pacific/Midway' => array(
		'winter_offset' => '-39600',
		'summer_offset' => '-39600'
	),
	'Pacific/Pago_Pago' => array(
		'winter_offset' => '-39600',
		'summer_offset' => '-39600'
	),
	'Pacific/Niue' => array(
		'winter_offset' => '-39600',
		'summer_offset' => '-39600'
	),
	'Pacific/Tahiti' => array(
		'winter_offset' => '-36000',
		'summer_offset' => '-36000'
	),
	'Pacific/Rarotonga' => array(
		'winter_offset' => '-36000',
		'summer_offset' => '-36000'
	),
	'Pacific/Apia' => array(
		'winter_offset' => '-36000',
		'summer_offset' => '-36000'
	),
	'Pacific/Fakaofo' => array(
		'winter_offset' => '-36000',
		'summer_offset' => '-36000'
	),
	'Pacific/Marquesas' => array(
		'winter_offset' => '-34200',
		'summer_offset' => '-34200'
	),
	'Pacific/Gambier' => array(
		'winter_offset' => '-32400',
		'summer_offset' => '-32400'
	),
	'US/Alaska' => array(
		'winter_offset' => '-32400',
		'summer_offset' => '-28800'
	),
	'Pacific/Pitcairn' => array(
		'winter_offset' => '-28800',
		'summer_offset' => '-28800'
	),
	'US/Pacific' => array(
		'winter_offset' => '-28800',
		'summer_offset' => '-25200'
	),
	'US/Arizona' => array(
		'winter_offset' => '-25200',
		'summer_offset' => '-25200'
	),
	'US/Mountain' => array(
		'winter_offset' => '-25200',
		'summer_offset' => '-21600'
	),
	'America/Belize' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'America/Costa_Rica' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'America/Guatemala' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'America/El_Salvador' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'America/Managua' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'America/Tegucigalpa' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-21600'
	),
	'Pacific/Easter' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-21600'
	),
	'US/Central' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-18000'
	),
	'America/Mexico_City' => array(
		'winter_offset' => '-21600',
		'summer_offset' => '-18000'
	),
	'America/Bogota' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Cayman' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Guayaquil' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Jamaica' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Lima' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Nassau' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Port-au-Prince' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Panama' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-18000'
	),
	'America/Havana' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-14400'
	),
	'America/New_York' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-14400'
	),
	'US/Eastern' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-14400'
	),
	'America/Toronto' => array(
		'winter_offset' => '-18000',
		'summer_offset' => '-14400'
	),
	'America/Anguilla' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Antigua' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Aruba' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Barbados' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Caracas' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Curacao' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Dominica' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Grenada' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Guadeloupe' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Guyana' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/La_Paz' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Santo_Domingo' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/St_Kitts' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/St_Lucia' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Martinique' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Port_of_Spain' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Puerto_Rico' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/St_Thomas' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/St_Vincent' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Tortola' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-14400'
	),
	'America/Santiago' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-14400'
	),
	'Canada/Atlantic' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-10800'
	),
	'Atlantic/Bermuda' => array(
		'winter_offset' => '-14400',
		'summer_offset' => '-10800'
	),
	'America/Montevideo' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-10800'
	),
	'Antarctica/Rothera' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-10800'
	),
	'America/Paramaribo' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-10800'
	),
	'America/Argentina/Buenos_Aires' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-10800'
	),
	'America/Cayenne' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-10800'
	),
	'America/Sao_Paulo' => array(
		'winter_offset' => '-7200',
		'summer_offset' => '-10800'
	),
	'America/St_Johns' => array(
		'winter_offset' => '-12600',
		'summer_offset' => '-9000'
	),
	'America/Godthab' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-7200'
	),
	'America/Asuncion' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-7200'
	),
	'Atlantic/Stanley' => array(
		'winter_offset' => '-10800',
		'summer_offset' => '-7200'
	),
	'America/Noronha' => array(
		'winter_offset' => '-7200',
		'summer_offset' => '-7200'
	),
	'Atlantic/South_Georgia' => array(
		'winter_offset' => '-7200',
		'summer_offset' => '-7200'
	),
	'Atlantic/Cape_Verde' => array(
		'winter_offset' => '-3600',
		'summer_offset' => '-3600'
	),
	'Atlantic/Azores' => array(
		'winter_offset' => '-3600',
		'summer_offset' => '0'
	),
	'Africa/Abidjan' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Accra' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Bamako' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Banjul' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Bissau' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Casablanca' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Conakry' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Dakar' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Freetown' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Lome' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Monrovia' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Nouakchott' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Ouagadougou' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Atlantic/Reykjavik' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Africa/Sao_Tome' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Europe/Lisbon' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'UTC' => array(
		'winter_offset' => '0',
		'summer_offset' => '0'
	),
	'Europe/Dublin' => array(
		'winter_offset' => '0',
		'summer_offset' => '3600'
	),
	'Europe/London' => array(
		'winter_offset' => '0',
		'summer_offset' => '3600'
	),
	'Africa/Algiers' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Bangui' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Brazzaville' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Douala' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Kinshasa' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Malabo' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Lagos' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Libreville' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Luanda' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Ndjamena' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Niamey' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Porto-Novo' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Tunis' => array(
		'winter_offset' => '3600',
		'summer_offset' => '3600'
	),
	'Africa/Windhoek' => array(
		'winter_offset' => '7200',
		'summer_offset' => '3600'
	),
	'Europe/Amsterdam' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Andorra' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Belgrade' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Berlin' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Bratislava' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Brussels' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Budapest' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Bucharest' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Chisinau' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Copenhagen' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Gibraltar' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Istanbul' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Kiev' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Ljubljana' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Luxembourg' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Malta' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Monaco' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Oslo' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Madrid' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Paris' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Prague' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Rome' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/San_Marino' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Sarajevo' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Skopje' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Stockholm' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Vatican' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Tirane' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Vaduz' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Vienna' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Zagreb' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Zurich' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Europe/Warsaw' => array(
		'winter_offset' => '3600',
		'summer_offset' => '7200'
	),
	'Africa/Blantyre' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Bujumbura' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Cairo' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Gaborone' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Harare' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Johannesburg' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Kigali' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Lusaka' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Maputo' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Maseru' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Mbabane' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Africa/Tripoli' => array(
		'winter_offset' => '7200',
		'summer_offset' => '7200'
	),
	'Europe/Athens' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Europe/Riga' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Europe/Helsinki' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Europe/Tallinn' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Europe/Sofia' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Amman' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Beirut' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Damascus' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Gaza' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Jerusalem' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Asia/Nicosia' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Europe/Vilnius' => array(
		'winter_offset' => '7200',
		'summer_offset' => '10800'
	),
	'Africa/Addis_Ababa' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Indian/Antananarivo' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Asmara' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Dar_es_Salaam' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Kampala' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Khartoum' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Mogadishu' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Nairobi' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Africa/Djibouti' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Bahrain' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Kuwait' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Indian/Comoro' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Baghdad' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Aden' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Europe/Moscow' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Qatar' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Asia/Riyadh' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Indian/Mayotte' => array(
		'winter_offset' => '10800',
		'summer_offset' => '10800'
	),
	'Europe/Minsk' => array(
		'winter_offset' => '10800',
		'summer_offset' => '14400'
	),
	'Asia/Dubai' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Asia/Muscat' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Asia/Tbilisi' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Indian/Mahe' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Indian/Mauritius' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Indian/Reunion' => array(
		'winter_offset' => '14400',
		'summer_offset' => '14400'
	),
	'Asia/Yerevan' => array(
		'winter_offset' => '14400',
		'summer_offset' => '18000'
	),
	'Asia/Tehran' => array(
		'winter_offset' => '12600',
		'summer_offset' => '16200'
	),
	'Asia/Kabul' => array(
		'winter_offset' => '16200',
		'summer_offset' => '16200'
	),
	'Asia/Baku' => array(
		'winter_offset' => '16200',
		'summer_offset' => '18000'
	),
	'Asia/Ashgabat' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Asia/Dushanbe' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Asia/Karachi' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Indian/Kerguelen' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Indian/Maldives' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Asia/Samarkand' => array(
		'winter_offset' => '18000',
		'summer_offset' => '18000'
	),
	'Asia/Calcutta' => array(
		'winter_offset' => '19800',
		'summer_offset' => '19800'
	),
	'Asia/Katmandu' => array(
		'winter_offset' => '20700',
		'summer_offset' => '20700'
	),
	'Asia/Yekaterinburg' => array(
		'winter_offset' => '18000',
		'summer_offset' => '21600'
	),
	'Indian/Chagos' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Bishkek' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Colombo' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Dhaka' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Qyzylorda' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Thimphu' => array(
		'winter_offset' => '21600',
		'summer_offset' => '21600'
	),
	'Asia/Rangoon' => array(
		'winter_offset' => '23400',
		'summer_offset' => '23400'
	),
	'Asia/Almaty' => array(
		'winter_offset' => '21600',
		'summer_offset' => '25200'
	),
	'Asia/Bangkok' => array(
		'winter_offset' => '25200',
		'summer_offset' => '25200'
	),
	'Asia/Jakarta' => array(
		'winter_offset' => '25200',
		'summer_offset' => '25200'
	),
	'Asia/Phnom_Penh' => array(
		'winter_offset' => '25200',
		'summer_offset' => '25200'
	),
	'Asia/Saigon' => array(
		'winter_offset' => '25200',
		'summer_offset' => '25200'
	),
	'Asia/Vientiane' => array(
		'winter_offset' => '25200',
		'summer_offset' => '25200'
	),
	'Asia/Krasnoyarsk' => array(
		'winter_offset' => '25200',
		'summer_offset' => '28800'
	),
	'Asia/Brunei' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Kuala_Lumpur' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Macau' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Manila' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Hong_Kong' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Australia/Perth' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Shanghai' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Singapore' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Taipei' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Ulaanbaatar' => array(
		'winter_offset' => '28800',
		'summer_offset' => '28800'
	),
	'Asia/Irkutsk' => array(
		'winter_offset' => '28800',
		'summer_offset' => '32400'
	),
	'Asia/Seoul' => array(
		'winter_offset' => '32400',
		'summer_offset' => '32400'
	),
	'Asia/Tokyo' => array(
		'winter_offset' => '32400',
		'summer_offset' => '32400'
	),
	'Asia/Dili' => array(
		'winter_offset' => '32400',
		'summer_offset' => '32400'
	),
	'Pacific/Palau' => array(
		'winter_offset' => '32400',
		'summer_offset' => '32400'
	),
	'Australia/Darwin' => array(
		'winter_offset' => '34200',
		'summer_offset' => '34200'
	),
	'Australia/Adelaide' => array(
		'winter_offset' => '37800',
		'summer_offset' => '34200'
	),
	'Asia/Yakutsk' => array(
		'winter_offset' => '32400',
		'summer_offset' => '36000'
	),
	'Australia/Brisbane' => array(
		'winter_offset' => '36000',
		'summer_offset' => '36000'
	),
	'Pacific/Guam' => array(
		'winter_offset' => '36000',
		'summer_offset' => '36000'
	),
	'Pacific/Port_Moresby' => array(
		'winter_offset' => '36000',
		'summer_offset' => '36000'
	),
	'Pacific/Saipan' => array(
		'winter_offset' => '36000',
		'summer_offset' => '36000'
	),
	'Australia/Sydney' => array(
		'winter_offset' => '39600',
		'summer_offset' => '36000'
	),
	'Australia/Lord_Howe' => array(
		'winter_offset' => '39600',
		'summer_offset' => '37800'
	),
	'Asia/Vladivostok' => array(
		'winter_offset' => '36000',
		'summer_offset' => '39600'
	),
	'Pacific/Guadalcanal' => array(
		'winter_offset' => '39600',
		'summer_offset' => '39600'
	),
	'Pacific/Ponape' => array(
		'winter_offset' => '39600',
		'summer_offset' => '39600'
	),
	'Pacific/Efate' => array(
		'winter_offset' => '39600',
		'summer_offset' => '39600'
	),
	'Pacific/Noumea' => array(
		'winter_offset' => '39600',
		'summer_offset' => '39600'
	),
	'Pacific/Norfolk' => array(
		'winter_offset' => '41400',
		'summer_offset' => '41400'
	),
	'Asia/Magadan' => array(
		'winter_offset' => '39600',
		'summer_offset' => '43200'
	),
	'Pacific/Fiji' => array(
		'winter_offset' => '43200',
		'summer_offset' => '43200'
	),
	'Pacific/Tarawa' => array(
		'winter_offset' => '43200',
		'summer_offset' => '43200'
	),
	'Pacific/Funafuti' => array(
		'winter_offset' => '43200',
		'summer_offset' => '43200'
	),
	'Pacific/Majuro' => array(
		'winter_offset' => '43200',
		'summer_offset' => '43200'
	),
	'Pacific/Nauru' => array(
		'winter_offset' => '43200',
		'summer_offset' => '43200'
	),
	'Pacific/Auckland' => array(
		'winter_offset' => '46800',
		'summer_offset' => '43200'
	),
	'Pacific/Chatham' => array(
		'winter_offset' => '49500',
		'summer_offset' => '45900'
	),
	'Pacific/Enderbury' => array(
		'winter_offset' => '46800',
		'summer_offset' => '46800'
	),
	'Pacific/Tongatapu' => array(
		'winter_offset' => '46800',
		'summer_offset' => '46800'
	),
	'Pacific/Kiritimati' => array(
		'winter_offset' => '50400',
		'summer_offset' => '50400'
	)
);
$global_config['my_domains'] = str_replace( $search, $replace, $global_config['my_domains'] );
$global_config['cookie_prefix'] = str_replace( $search, $replace, $global_config['cookie_prefix'] );
$global_config['ftp_path'] = str_replace( $search, $replace, $global_config['ftp_path'] );
$global_config['session_prefix'] = str_replace( $search, $replace, $global_config['session_prefix'] );
$global_config['upload_logo'] = str_replace( $search, $replace, $global_config['upload_logo'] );
$global_config['rewrite_endurl'] = str_replace( $search, $replace, $global_config['rewrite_endurl'] );
$global_config['rewrite_exturl'] = str_replace( $search, $replace, $global_config['rewrite_exturl'] );
$global_config['site_timezone'] = str_replace( $search, $replace, $global_config['site_timezone'] );
$global_config['gzip_method'] = 0;

$global_config['statistics_timezone'] = str_replace( $search, $replace, $global_config['statistics_timezone'] );
$global_config['date_pattern'] = str_replace( $search, $replace, $global_config['date_pattern'] );
$global_config['time_pattern'] = str_replace( $search, $replace, $global_config['time_pattern'] );
$global_config['searchEngineUniqueID'] = str_replace( $search, $replace, $global_config['searchEngineUniqueID'] );

unset( $search, $replace );

if( ! is_array( $global_config['allow_sitelangs'] ) )
{
	$global_config['allow_sitelangs'] = ! empty( $global_config['allow_sitelangs'] ) ? explode( ",", $global_config['allow_sitelangs'] ) : array( );
	$global_config['allow_adminlangs'] = ! empty( $global_config['allow_adminlangs'] ) ? explode( ",", $global_config['allow_adminlangs'] ) : array( );
	$global_config['openid_servers'] = ! empty( $global_config['openid_servers'] ) ? explode( ",", $global_config['openid_servers'] ) : array( );
}

$global_config['allowed_html_tags'] = array_map( "trim", explode( ',', NV_ALLOWED_HTML_TAGS ) );

//Xac dinh IP cua client
require (NV_ROOTDIR . '/includes/class/ips.class.php');
$ips = new ips( );
$client_info['ip'] = $ips->remote_ip;
if( $client_info['ip'] == "none" )
	die( 'Error: Your IP address is not correct' );

//Neu khong co IP
//define( 'NV_SERVER_IP', $ips->server_ip );
define( 'NV_FORWARD_IP', $ips->forward_ip );
define( 'NV_REMOTE_ADDR', $ips->remote_addr );
define( 'NV_CLIENT_IP', $client_info['ip'] );

//Xac dinh Quoc gia
require (NV_ROOTDIR . '/includes/countries.php');
$client_info['country'] = nv_getCountry_from_cookie( $client_info['ip'] );

//Mui gio
require (NV_ROOTDIR . '/includes/timezone.php');
define( 'NV_CURRENTTIME', isset( $_SERVER['REQUEST_TIME'] ) ? $_SERVER['REQUEST_TIME'] : time( ) );

$global_config['log_errors_list'] = NV_LOG_ERRORS_LIST;
$global_config['display_errors_list'] = NV_DISPLAY_ERRORS_LIST;
$global_config['send_errors_list'] = NV_SEND_ERRORS_LIST;
$global_config['error_log_path'] = NV_LOGS_DIR . '/error_logs';
$global_config['error_log_filename'] = NV_ERRORLOGS_FILENAME;
$global_config['error_log_fileext'] = NV_LOGS_EXT;

//Ket noi voi class Error_handler
require (NV_ROOTDIR . '/includes/class/error.class.php');
$ErrorHandler = new Error( $global_config );
set_error_handler( array(
	&$ErrorHandler,
	'error_handler'
) );

//Ket noi voi cac file cau hinh, function va template
require (NV_ROOTDIR . '/includes/ini.php');
require (NV_ROOTDIR . '/includes/utf8/' . $sys_info['string_handler'] . '_string_handler.php');
require (NV_ROOTDIR . '/includes/utf8/utf8_functions.php');
require (NV_ROOTDIR . '/includes/core/filesystem_functions.php');
require (NV_ROOTDIR . '/includes/core/cache_functions.php');
require (NV_ROOTDIR . '/includes/functions.php');
require (NV_ROOTDIR . '/includes/core/theme_functions.php');
require (NV_ROOTDIR . "/includes/class/xtemplate.class.php");
$global_config['allow_request_mods'] = NV_ALLOW_REQUEST_MODS != '' ? array_map( "trim", explode( ",", NV_ALLOW_REQUEST_MODS ) ) : "request";
$global_config['request_default_mode'] = NV_REQUEST_DEFAULT_MODE != '' ? trim( NV_REQUEST_DEFAULT_MODE ) : 'request';
$global_config['session_save_path'] = NV_SESSION_SAVE_PATH;

$language_array = nv_parse_ini_file( NV_ROOTDIR . '/includes/ini/langs.ini', true );

//Ket noi voi class xu ly request
require (NV_ROOTDIR . '/includes/class/request.class.php');
$nv_Request = new Request( $global_config, $client_info['ip'] );

define( 'NV_SERVER_NAME', $nv_Request->server_name );
//vd: mydomain1.com
define( 'NV_SERVER_PROTOCOL', $nv_Request->server_protocol );
//vd: http
define( 'NV_SERVER_PORT', $nv_Request->server_port );
//vd: 80
define( 'NV_MY_DOMAIN', $nv_Request->my_current_domain );
//vd: http://mydomain1.com:80
define( 'NV_HEADERSTATUS', $nv_Request->headerstatus );
//vd: HTTP/1.0
define( 'NV_USER_AGENT', $nv_Request->user_agent );
//HTTP_USER_AGENT
define( "NV_BASE_SITEURL", preg_replace( "/\/install$/", "/", $nv_Request->base_siteurl . '/' ) );

//vd: /ten_thu_muc_chua_site/
define( "NV_BASE_ADMINURL", $nv_Request->base_adminurl . '/' );
//vd: /ten_thu_muc_chua_site/admin/
define( 'NV_DOCUMENT_ROOT', $nv_Request->doc_root );
// D:/AppServ/www
if( ! defined( 'NV_EOL' ) )
{
	define( 'NV_EOL', (strtoupper( substr( PHP_OS, 0, 3 ) == 'WIN' ) ? "\r\n" : (strtoupper( substr( PHP_OS, 0, 3 ) == 'MAC' ) ? "\r" : "\n")) );
}
//Ngat dong
define( 'NV_UPLOADS_REAL_DIR', NV_ROOTDIR . '/' . NV_UPLOADS_DIR );
//Xac dinh duong dan thuc den thu muc upload
define( 'NV_CACHE_PREFIX', md5( $global_config['sitekey'] . NV_BASE_SITEURL ) );
//Hau to cua file cache

//Ngon ngu
require (NV_ROOTDIR . '/includes/language.php');
require (NV_ROOTDIR . "/language/" . NV_LANG_INTERFACE . "/global.php");

$global_config['cookie_path'] = $nv_Request->cookie_path;
//vd: /ten_thu_muc_chua_site/
$global_config['cookie_domain'] = $nv_Request->cookie_domain;
//vd: .mydomain1.com
$global_config['site_url'] = $nv_Request->site_url;
//vd: http://mydomain1.com/ten_thu_muc_chua_site
$global_config['my_domains'] = $nv_Request->my_domains;
//vd: "mydomain1.com,mydomain2.com"

$sys_info['register_globals'] = $nv_Request->is_register_globals;
//0 = khong, 1 = bat
$sys_info['magic_quotes_gpc'] = $nv_Request->is_magic_quotes_gpc;
// 0 = khong, 1 = co
$sys_info['sessionpath'] = $nv_Request->session_save_path;
//vd: D:/AppServ/www/ten_thu_muc_chua_site/sess/

$client_info['session_id'] = $nv_Request->session_id;
//ten cua session
$client_info['referer'] = $nv_Request->referer;
//referer
$client_info['is_myreferer'] = $nv_Request->referer_key;
//0 = referer tu ben ngoai site, 1 = referer noi bo, 2 = khong co referer
$client_info['selfurl'] = $nv_Request->my_current_domain . $nv_Request->request_uri;
//trang dang xem
$client_info['agent'] = $nv_Request->user_agent;
//HTTP_USER_AGENT
$client_info['session_id'] = $nv_Request->session_id;
//ten cua session
$global_config['sitekey'] = md5( $_SERVER['SERVER_NAME'] . NV_ROOTDIR . $client_info['session_id'] );

//Chan truy cap neu HTTP_USER_AGENT == 'none'
if( NV_USER_AGENT == "none" )
{
	trigger_error( 'We\'re sorry. The software you are using to access our website is not allowed. Some examples of this are e-mail harvesting programs and programs that will  copy websites to your hard drive. If you feel you have gotten this message  in error, please send an e-mail addressed to admin. Your I.P. address has been logged. Thanks.', 256 );
}

//Captcha
if( $nv_Request->isset_request( 'scaptcha', 'get' ) )
{
	include_once (NV_ROOTDIR . "/includes/core/captcha.php");
}

//Class ma hoa du lieu
require (NV_ROOTDIR . '/includes/class/crypt.class.php');
$crypt = new nv_Crypt( $global_config['sitekey'], NV_CRYPT_SHA1 == 1 ? 'sha1' : 'md5' );

//Bat dau phien lam viec cua MySQL
require (NV_ROOTDIR . '/includes/class/mysql.class.php');
$db_config['new_link'] = NV_MYSQL_NEW_LINK;
$db_config['persistency'] = NV_MYSQL_PERSISTENCY;
$db_config['collation'] = NV_MYSQL_COLLATION;
if( $db_config['dbhost'] == "localhost" )
{
	$db_config['dbhost'] = "127.0.0.1";
}
$db = new sql_db( $db_config );
if( ! empty( $db->error ) )
{
	$die = ! empty( $db->error['user_message'] ) ? $db->error['user_message'] : $db->error['message'];
	$die .= ! empty( $db->error['code'] ) ? ' (Code: ' . $db->error['code'] . ')' : '';
	trigger_error( $die, 256 );
}
unset( $db_config['dbpass'] );
$admin_cookie = $nv_Request->get_string( 'admin', 'session' );
$admin_online = $nv_Request->get_string( 'online', 'session' );

$array_admin = unserialize( $admin_cookie );
$strlen = (NV_CRYPT_SHA1 == 1) ? 40 : 32;
if( ! isset( $array_admin['admin_id'] ) or ! is_numeric( $array_admin['admin_id'] ) or $array_admin['admin_id'] <= 0 or ! isset( $array_admin['checknum'] ) or ! preg_match( "/^[a-z0-9]{" . $strlen . "}$/", $array_admin['checknum'] ) )
{
	$admin_info = array( );
}
else
{
	$admin_info = array( );
	$query = "SELECT a.admin_id AS `admin_id`, a.lev AS `lev`, a.position AS `position`, a.check_num AS `check_num`, a.last_agent AS `current_agent`,
		a.last_ip AS `current_ip`, a.last_login AS `current_login`, a.files_level AS `files_level`, a.editor AS `editor`, b.userid AS `userid`,
		b.username AS `username`, b.email AS `email`, b.full_name AS `full_name`, b.view_mail AS `view_mail`, b.regdate AS `regdate`,
		b.sig AS `sig`, b.gender AS `gender`, b.photo AS `photo`, b.birthday AS `birthday`, b.in_groups AS `in_groups`, b.last_openid AS `last_openid`,
		b.password AS `password`, b.question AS `question`, b.answer AS `answer`
		FROM `" . $db_config['prefix'] . "_authors` a, `" . $db_config['prefix'] . "_users` b
		WHERE a.admin_id = " . $array_admin['admin_id'] . "
		AND a.lev!=0
		AND a.is_suspend=0
		AND b.userid=a.admin_id
		AND b.active=1
		LIMIT 1";
	$result = $db->sql_query( $query );
	if( $db->sql_numrows( $result ) == 1 )
	{
		$admin_info = $db->sql_fetch_assoc( $result );
		if( strcasecmp( $array_admin['checknum'], $admin_info['check_num'] ) != 0 or //check_num
		! isset( $array_admin['current_agent'] ) or empty( $array_admin['current_agent'] ) or strcasecmp( $array_admin['current_agent'], $admin_info['current_agent'] ) != 0 or //user_agent
		! isset( $array_admin['current_ip'] ) or empty( $array_admin['current_ip'] ) or strcasecmp( $array_admin['current_ip'], $admin_info['current_ip'] ) != 0 or //IP
		! isset( $array_admin['current_login'] ) or empty( $array_admin['current_login'] ) or strcasecmp( $array_admin['current_login'], intval( $admin_info['current_login'] ) ) != 0 )//current_login
		{
			$admin_info = array( );
		}
		else
		{
			define( 'NV_IS_ADMIN', true );
			if( $admin_info['lev'] == 1 or $admin_info['lev'] == 2 )
			{
				define( 'NV_IS_SPADMIN', true );
			}

			if( $admin_info['lev'] == 1 )
			{
				define( 'NV_IS_GODADMIN', true );
			}
		}
	}
}
if( defined( 'NV_IS_GODADMIN' ) )
{
	//Ten cac table cua CSDL dung chung cho he thong
	define( 'NV_AUTHORS_GLOBALTABLE', $db_config['prefix'] . '_authors' );
	define( 'NV_GROUPS_GLOBALTABLE', $db_config['prefix'] . '_groups' );
	define( 'NV_USERS_GLOBALTABLE', $db_config['prefix'] . '_users' );
	define( 'NV_SESSIONS_GLOBALTABLE', $db_config['prefix'] . '_sessions' );
	define( 'NV_LANGUAGE_GLOBALTABLE', $db_config['prefix'] . '_language' );

	define( 'NV_BANNERS_CLIENTS_GLOBALTABLE', $db_config['prefix'] . '_banners_clients' );
	define( 'NV_BANNERS_PLANS_GLOBALTABLE', $db_config['prefix'] . '_banners_plans' );
	define( 'NV_BANNERS_ROWS_GLOBALTABLE', $db_config['prefix'] . '_banners_rows' );
	define( 'NV_BANNERS_CLICK_GLOBALTABLE', $db_config['prefix'] . '_banners_click' );

	define( 'NV_CONFIG_GLOBALTABLE', $db_config['prefix'] . '_config' );
	define( 'NV_CRONJOBS_GLOBALTABLE', $db_config['prefix'] . '_cronjobs' );

	define( 'NV_PREFIXLANG', $db_config['prefix'] . '_' . NV_LANG_DATA );
	define( 'NV_MODULES_TABLE', NV_PREFIXLANG . '_modules' );
	define( 'NV_BLOCKS_TABLE', NV_PREFIXLANG . '_blocks' );
	define( 'NV_MODFUNCS_TABLE', NV_PREFIXLANG . '_modfuncs' );

	define( 'NV_COUNTER_TABLE', NV_PREFIXLANG . '_counter' );
	define( 'NV_SEARCHKEYS_TABLE', NV_PREFIXLANG . '_searchkeys' );
	define( 'NV_REFSTAT_TABLE', NV_PREFIXLANG . '_referer_stats' );

	//2) Thay đổi bộ gõ mudim
	$db->sql_query( "INSERT INTO `" . NV_CONFIG_GLOBALTABLE . "`
		(`lang`, `module`, `config_name`, `config_value`) VALUES
		('sys', 'global', 'mudim_displaymode', '1'),
		('sys', 'global', 'mudim_method', '4'),
		('sys', 'global', 'mudim_showpanel', '1'),
		('sys', 'global', 'mudim_active', '1')" );
	$global_config['mudim_active'] = 0;
	$global_config['googleAnalyticsID'] = '';
	if( file_exists( NV_ROOTDIR . '/images/logo.png' ) )
	{
		$global_config['site_logo'] = 'images/logo.png';
	}
	else
	{
		list( $site_logo ) = $db->sql_fetchrow( $db->sql_query( "SELECT `config_value` FROM `" . NV_CONFIG_GLOBALTABLE . "`  WHERE `lang` = '" . NV_LANG_INTERFACE . "' AND `module` = 'global' AND `config_name` = 'site_logo'" ) );
		$global_config['site_logo'] = $site_logo;
	}

	//3) Xóa getloadavg.php, bởi nó ít tác dụng mà khi bật lên làm chậm site
	$db->sql_query( "DELETE FROM `" . NV_CONFIG_GLOBALTABLE . "` WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'getloadavg'" );

	//4) Thay đổi giao diện admin
	$db->sql_query( "INSERT INTO `" . NV_USERS_GLOBALTABLE . "_config` (`config`, `content`, `edit_time`) VALUES('access_admin', 'a:6:{s:12:\"access_addus\";a:3:{i:1;b:1;i:2;b:1;i:3;b:1;}s:14:\"access_waiting\";a:3:{i:1;b:1;i:2;b:1;i:3;b:1;}s:13:\"access_editus\";a:3:{i:1;b:1;i:2;b:1;i:3;b:1;}s:12:\"access_delus\";a:2:{i:1;b:1;i:2;b:1;}s:13:\"access_passus\";a:3:{i:1;b:1;i:2;b:1;i:3;b:1;}s:13:\"access_groups\";a:3:{i:1;b:1;i:2;b:1;i:3;b:1;}}', 1355894514)" );

	//8) Tùy biến trường dữ liệu thành viên
	$db->sql_query( "CREATE TABLE IF NOT EXISTS `" . NV_USERS_GLOBALTABLE . "_field` (
		  `fid` int(11) NOT NULL AUTO_INCREMENT,
		  `field` varchar(25) NOT NULL,
		  `weight` int(10) unsigned NOT NULL DEFAULT '1',
		  `field_type` enum('textbox','textarea','editor','select','radio','checkbox','multiselect') NOT NULL DEFAULT 'textbox',
		  `field_choices` mediumtext NOT NULL,
		  `match_type` enum('none','alphanumeric','email','url','regex','callback') NOT NULL DEFAULT 'none',
		  `match_regex` varchar(250) NOT NULL DEFAULT '',
		  `func_callback` varchar(75) NOT NULL DEFAULT '',
		  `min_length` bigint(20) unsigned NOT NULL DEFAULT '0',
		  `max_length` bigint(20) unsigned NOT NULL DEFAULT '0',
		  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
		  `show_register` tinyint(3) unsigned NOT NULL DEFAULT '0',
		  `user_editable` enum('yes','once','never') NOT NULL DEFAULT 'yes',
		  `show_profile` tinyint(4) NOT NULL DEFAULT '1',
		  `class` varchar(50) NOT NULL,
		  `language` text NOT NULL,
		  `default_value` varchar(255) NOT NULL DEFAULT '',
		  PRIMARY KEY (`fid`),
		  UNIQUE KEY `field` (`field`)
		) ENGINE=MyISAM" );

	$db->sql_query( "INSERT INTO `" . NV_USERS_GLOBALTABLE . "_field` (`fid`, `field`, `weight`, `field_type`, `field_choices`, `match_type`, `match_regex`, `func_callback`, `max_length`, `required`, `show_register`, `user_editable`, `show_profile`, `class`, `language`) VALUES
		(1, 'website', 1, 'textbox', '', 'callback', '', 'nv_is_url', 255, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:7:\"Website\";i:1;s:0:\"\";}}'),
		(2, 'location', 2, 'textbox', '', 'none', '', '', 255, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:12:\"Địa chỉ\";i:1;s:0:\"\";}}'),
		(3, 'yim', 3, 'textbox', '', 'none', '', '', 40, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:18:\"Tài khoản Yahoo\";i:1;s:0:\"\";}}'),
		(4, 'telephone', 4, 'textbox', '', 'regex', '^[a-zA-Z0-9-_.,]{3,20}$', '', 100, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:15:\"Điện thoại\";i:1;s:0:\"\";}}'),
		(5, 'fax', 5, 'textbox', '', 'regex', '^[a-zA-Z0-9-_.,]{3,20}$', '', 100, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:3:\"Fax\";i:1;s:0:\"\";}}'),
		(6, 'mobile', 6, 'textbox', '', 'regex', '^[a-zA-Z0-9-_.,]{3,20}$', '', 100, 0, 0, 'yes', 1, '', 'a:1:{s:2:\"vi\";a:2:{i:0;s:10:\"Di động\";i:1;s:0:\"\";}}')" );

	$db->sql_query( "CREATE TABLE IF NOT EXISTS `" . NV_USERS_GLOBALTABLE . "_info` (
		  `userid` mediumint(8) unsigned NOT NULL,
		  `website` varchar(100) NOT NULL DEFAULT '',
		  `location` varchar(100) NOT NULL DEFAULT '',
		  `yim` varchar(100) NOT NULL DEFAULT '',
		  `telephone` varchar(100) NOT NULL DEFAULT '',
		  `fax` varchar(100) NOT NULL DEFAULT '',
		  `mobile` varchar(100) NOT NULL DEFAULT '',
		  PRIMARY KEY (`userid`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8" );

	$is = $db->sql_query( "INSERT INTO  `" . NV_USERS_GLOBALTABLE . "_info` SELECT `userid`, `website`, `location`, `yim`, `telephone`, `fax`, `mobile` FROM `" . NV_USERS_GLOBALTABLE . "`" );
	if( $is )
	{
		$db->sql_query( "ALTER TABLE `" . NV_USERS_GLOBALTABLE . "`
			  DROP `website`,
			  DROP `location`,
			  DROP `yim`,
			  DROP `telephone`,
			  DROP `fax`,
			  DROP `mobile`" );
	}
	$db->sql_query( "ALTER TABLE `" . NV_USERS_GLOBALTABLE . "_reg` ADD `users_info` MEDIUMTEXT NOT NULL" );
	
	$db->sql_query( "ALTER TABLE `" . NV_GROUPS_GLOBALTABLE . "` DROP `users`" );
	$db->sql_query( "ALTER TABLE `" . NV_GROUPS_GLOBALTABLE . "` ADD `idsite` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `act`,  ADD `number` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `idsite`,  ADD `siteus` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `number`");
	
	//9) Cấu hình đăng ký thành viên
	$db->sql_query( "INSERT INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES
		('sys', 'global', 'cookie_httponly', '" . $global_config['cookie_httponly'] . "'),
		('sys', 'global', 'admin_check_pass_time', '1800'),
		('sys', 'global', 'adminrelogin_max', '3'),
		('sys', 'global', 'cookie_secure', '" . $global_config['cookie_secure'] . "'),
		('sys', 'global', 'nv_unick_type', '" . $global_config['nv_unick_type'] . "'),
		('sys', 'global', 'nv_upass_type', '" . $global_config['nv_upass_type'] . "'),
		('sys', 'global', 'is_flood_blocker', '1'),
		('sys', 'global', 'max_requests_60', '40'),
		('sys', 'global', 'max_requests_300', '150'),
		('sys', 'global', 'nv_display_errors_list', '1'),
		('sys', 'global', 'display_errors_list', '1'),
		('sys', 'global', 'rewrite_op_mod', ''),
		('sys', 'define', 'nv_unickmin', '" . NV_UNICKMIN . "'),
		('sys', 'define', 'nv_unickmax', '" . NV_UNICKMAX . "'),
		('sys', 'define', 'nv_upassmin', '" . NV_UPASSMIN . "'),
		('sys', 'define', 'nv_upassmax', '" . NV_UPASSMAX . "'),
		('sys', 'define', 'nv_gfx_num', '6'),
		('sys', 'define', 'nv_gfx_width', '120'),
		('sys', 'define', 'nv_gfx_height', '25'),
		('sys', 'define', 'nv_max_width', '1500'),
		('sys', 'define', 'nv_max_height', '1500'),
		('sys', 'define', 'nv_live_cookie_time', '" . NV_LIVE_COOKIE_TIME . "'),
		('sys', 'define', 'nv_anti_iframe', '" . NV_ANTI_IFRAME . "'),
		('sys', 'define', 'nv_allowed_html_tags', '" . NV_ALLOWED_HTML_TAGS . "'),
		('sys', 'define', 'nv_live_session_time', '0'),
		('sys', 'define', 'nv_auto_resize', '1'),
		('sys', 'define', 'cdn_url', ''),
		('sys', 'define', 'dir_forum', '')" );

	//11) Thay đổi CSDL module users để phù hợp với chức năng tìm lại mật khẩu
	$db->sql_query( "ALTER TABLE `" . NV_CONFIG_GLOBALTABLE . "` CHANGE `passlostkey` `passlostkey` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''" );
	$db->sql_query( "DELETE FROM `" . NV_CONFIG_GLOBALTABLE . "_config` WHERE `config` = 'registertype'" );

	//12) Cập nhật chức năng không phân viết tài khoản chữ hoa và chữ thường.
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `md5username` = MD5(LOWER(`username`))" );

	//13) Quản lý menu ngang trong admin:
	$db->sql_query( "CREATE TABLE IF NOT EXISTS `" . NV_AUTHORS_GLOBALTABLE . "_module` (
		  `mid` int(11) NOT NULL AUTO_INCREMENT,
		  `module` varchar(55) NOT NULL,
		  `lang_key` varchar(50) NOT NULL DEFAULT '',
		  `weight` int(11) NOT NULL DEFAULT '0',
		  `act_1` tinyint(4) NOT NULL DEFAULT '0',
		  `act_2` tinyint(4) NOT NULL DEFAULT '1',
		  `act_3` tinyint(4) NOT NULL DEFAULT '1',
		  `checksum` varchar(32) NOT NULL DEFAULT '',
		  PRIMARY KEY (`mid`),
		  UNIQUE KEY `module` (`module`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8" );

	$db->sql_query( "INSERT INTO `" . NV_AUTHORS_GLOBALTABLE . "_module` (`mid`, `module`, `lang_key`, `weight`, `act_1`, `act_2`, `act_3`, `checksum`) VALUES
		(1, 'siteinfo', 'mod_siteinfo', 1, 1, 1, 1, ''),
		(2, 'authors', 'mod_authors', 2, 1, 1, 1, ''),
		(3, 'settings', 'mod_settings', 3, 1, 1, 0, ''),
		(4, 'database', 'mod_database', 4, 1, 0, 0, ''),
		(5, 'webtools', 'mod_webtools', 5, 1, 0, 0, ''),
		(6, 'language', 'mod_language', 6, 1, 1, 0, ''),
		(7, 'modules', 'mod_modules', 7, 1, 1, 0, ''),
		(8, 'themes', 'mod_themes', 8, 1, 1, 0, ''),
		(9, 'upload', 'mod_upload', 9, 1, 1, 1, '')" );

	$result = $db->sql_query( "SELECT * FROM `" . NV_AUTHORS_GLOBALTABLE . "_module` ORDER BY `weight` ASC" );
	while( $row = $db->sql_fetch_assoc( $result ) )
	{
		$checksum = md5( $row['module'] . "#" . $row['act_1'] . "#" . $row['act_2'] . "#" . $row['act_3'] . "#" . $global_config['sitekey'] );
		$db->sql_query( "UPDATE `" . NV_AUTHORS_GLOBALTABLE . "_module` SET `checksum` = '" . $checksum . "' WHERE `mid` = " . $row['mid'] );
	}
	//14) Mã hóa mật khẩu smtp, ftp
	if( isset( $global_config['smtp_password'] ) )
	{
		$ftp_user_pass = nv_base64_encode( $crypt->aes_encrypt( $global_config['ftp_user_pass'] ) );
		$smtp_password = nv_base64_encode( $crypt->aes_encrypt( $global_config['smtp_password'] ) );

		$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `config_value`=" . $db->dbescape_string( $ftp_user_pass ) . " WHERE `config_name` = 'ftp_user_pass' AND `lang` = 'sys' AND `module`='global' LIMIT 1" );
		$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `config_value`=" . $db->dbescape_string( $smtp_password ) . " WHERE `config_name` = 'smtp_password' AND `lang` = 'sys' AND `module`='site' LIMIT 1" );
	}

	//17) Thêm cấu hình thời gian lặp lại quá trình backup CSDL
	$db->sql_query( "INSERT INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'dump_interval', '1')" );

	//18) Thêm cấu hình idsite
	$db->sql_query( "INSERT INTO `" . NV_CONFIG_GLOBALTABLE . "` (`lang`, `module`, `config_name`, `config_value`) VALUES ('sys', 'global', 'idsite', '0')" );

	//19) Cập nhật cấu hình site
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'mailer_mode'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'smtp_host'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'smtp_username'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'smtp_password'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'smtp_port'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'smtp_ssl'" );

	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'online_upd'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'statistic'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'statistics_timezone'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'googleAnalyticsID'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'googleAnalyticsSetDomainName'" );

	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'closed_site'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'site_email'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'error_send_email'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'admin_theme'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'date_pattern'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'time_pattern'" );
	$db->sql_query( "UPDATE `" . NV_CONFIG_GLOBALTABLE . "` SET `module` = 'site' WHERE `lang` = 'sys' AND `module` = 'global' AND `config_name` = 'searchEngineUniqueID'" );

	require_once (NV_ROOTDIR . "/includes/core/admin_functions.php");
	if( ! nv_save_file_config_global( ) )
	{
		require_once (NV_ROOTDIR . "/language/" . NV_LANG_DATA . "/install.php");
		die( sprintf( $lang_module['file_not_writable'], NV_DATADIR . "/config_global.php" ) );
	}

	if( NV_LANG_INTERFACE == 'vi' )
	{
		$msg = 'Bạn cần xóa file /install/update_system.php sau đó nhấn phím F5 để tiếp tục nâng cấp site';
	}
	else
	{
		$msg = 'You need to delete the file / install / update_system.php then press F5 to continue to upgrade the site ';
	}
	nv_info_die( $lang_global['site_info'], $lang_global['site_info'], '<br><br>' . $msg );
}
else
{
	nv_info_die( $lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['module_for_admin'] );
}
?>