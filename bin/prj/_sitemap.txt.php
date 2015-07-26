<?php
is_need_cache(true);
$links = array();
foreach(explode("\n", `cd data; find * -type f -name '[0-9]*'`) as $v)
	$links[] = $v;

foreach(explode("\n", `cd data; find * -type d`) as $v)
	$links[] = $v;

$links = array_unique($links);

echo implode("\n", map(function($v){ return "http://".http_host().'/'.$v; },
		       $links));
