<form method="get">
	<input type="text" name="test[text][first]">
	<input type="radio" name="test[radio]" value="first">first
	<input type="radio" name="test[radio]" value="second">second
	<input type="submit" value="Submit">
</form>
<xmp><?print_r($_GET)?></xmp>
<hr><?show_source(__FILE__)?>