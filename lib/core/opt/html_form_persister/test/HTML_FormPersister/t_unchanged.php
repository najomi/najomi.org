<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 
ob_start();
?>
<form method="get">
	<input type="submit" value="&nbsp;&nbsp;Submit - must NOT contain plain &amp;nbsp; on the left!">
</form>
<?
$c = ob_get_contents(); ob_end_clean();
echo HTML_FormPersister::ob_formPersisterHandler($c);
?>