<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 

test('<select onchange="compute()" name="count"><option value="0">0</option><option value="1">1</option>');
test('<select onchange="compute()" name="count"><option value="0">0</option><option value="1">1</option></select>');
test('<select onchange="compute()" name="count"><option value="0">0</option><option value="1">1</option></select>');
test('<select name="count"><option value="0">0</option><option value="1">1</option>');
test('<select name="count"><option value="0">0</option><option value="1">1</option></select>');

function getTime() {
	$_t = explode(" ", microtime());
	return $_t[ 1 ] + $_t[ 0 ];
}

function test($_html)
{
	$num = 10;
	$ob = new HTML_FormPersister();
	$_time = getTime();
	for ($i=0; $i<$num; $i++) {
		$_result = $ob->process( $_html );
	}
	$_time = (getTime() - $_time) / $num;
	printf("%.6fs - <tt>%s</tt><br>", $_time, htmlspecialchars($_html));
}
?>
<hr><?show_source(__FILE__)?>