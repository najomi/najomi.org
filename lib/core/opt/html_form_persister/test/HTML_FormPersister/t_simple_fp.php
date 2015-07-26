<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 
ob_start(array('HTML_FormPersister', 'ob_formPersisterHandler'));
?>
<form method="get">
	<input type="text" name="test[text][first]">
	<input type="radio" name="test[radio]" value="first">first
	<input type="radio" name="test[radio]" value="second">second
	<script></script>
	<input type="submit" value="Submit">
</form>
<xmp><?print_r($_GET)?></xmp>
<hr><?show_source(__FILE__)?>