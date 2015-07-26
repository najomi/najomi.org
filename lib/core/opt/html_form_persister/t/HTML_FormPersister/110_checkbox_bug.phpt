--TEST--
HTML_FormPersister: checkbox bug
--FILE--
<?php
require dirname(__FILE__) . '/init.php';
ob_start(array('HTML_FormPersister', 'ob_formpersisterhandler'));
$_POST['a'] = true;
$_POST['b'] = true;
$_POST['c'] = false;
$_POST['d'] = false;
?>
<form method="get">
<input type="checkbox" name="a">
</form>

<form method="get">
<input type="checkbox" name="b" value="1">
</form>

<form method="get">
<input type="checkbox" name="c">
</form>

<form method="get">
<input type="checkbox" name="d" value="1">
</form>

--EXPECT--
<form method="get" action="">
<input type="checkbox" name="a" value="on" checked="checked">
</form>

<form method="get" action="">
<input type="checkbox" name="b" value="1" checked="checked">
</form>

<form method="get" action="">
<input type="checkbox" name="c" value="on">
</form>

<form method="get" action="">
<input type="checkbox" name="d" value="1">
</form>
