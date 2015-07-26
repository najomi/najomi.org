<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 
ob_start();
?>
<form method="get">
	<input type="text" name="test[text][first]">
	<input type="radio" name="test[radio]" value="first">first
	<input type="radio" name="test[radio]" value="second">second
	<script>/*aaa*/</script>
	<input type="submit" value="Submit">
</form>
<pre><?print_r($_GET)?></pre>
<hr><?//show_source(__FILE__)?>
<?
$c = ob_get_contents(); ob_end_clean();
echo HTML_FormPersister::ob_formPersisterHandler($c);
?>