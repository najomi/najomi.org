<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 
ob_start(array('HTML_FormPersister', 'ob_formPersisterHandler'));
$_POST['test']['text']['first'] = 'значение';
?>
<form method="get">
	<input type="text" name="test[text][first]">
</form>
<hr><?show_source(__FILE__)?>