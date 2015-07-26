<?php
header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('Europe/Moscow');
ini_set('display_errors','on');

define('BASE_DIRECTORY',dirname(__FILE__));
define('CACHE_DIRECTORY',dirname(__FILE__).'/cache');
define('FSTAB',BASE_DIRECTORY.'/fstab.php');
define('ROUTE_FILE',BASE_DIRECTORY.'/etc/route.php');



function query_path(){
	if(isset($_SERVER['REQUEST_URI']))
		return $_SERVER['REQUEST_URI'];

}

$_SERVER['REDIRECT_QUERY_STRING'] = query_path();
define('RAW_HTTP_STRING', $_SERVER['REDIRECT_QUERY_STRING']);


function bu_getHostName(){
	if(isset($_SERVER['HTTP_HOST']))
		return $_SERVER['HTTP_HOST'];
	return 'test';
}
define('HTTP_HOST',bu_getHostName());
if (stristr(PHP_OS, 'WIN'))
    set_include_path('.;'.BASE_DIRECTORY);
else
    set_include_path('.:'.BASE_DIRECTORY);

