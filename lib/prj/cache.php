<?php
function is_need_cache($v = null){
	if(!bu::config('rc/cache'))
		return false;
	static $r = false;
	if(!is_null($v))
		$r = $v;
	return $r;
}

function mkd($pth){
	@mkdir($pth, 0775);
	@chmod($pth, 0775);
}

function cache_it($pth, $html){
	$pth = trim($pth, '/');
	$dir = dirname($pth);
	$t = 'cache/';
	foreach(explode('/',$dir) as $v){
		$t.=$v.'/';
		mkd($t);
	}
	file_put_contents('cache/'.$pth.'.html', $html);
	chmod('cache/'.$pth.'.html', 0775);
}