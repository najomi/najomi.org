--TEST--
HTML_FormPersister: bad type="xxx"
--FILE--
<?php
require dirname(__FILE__) . '/init.php';
ob_start(array('HTML_FormPersister', 'ob_formpersisterhandler'));
$_POST['a'] = "b"
?>
<form method="get">
<input type="bad" name="a">
</form>

--EXPECT--
<form method="get" action="">
<input type="bad" name="a" value="b">
</form>
