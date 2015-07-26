<form method="get">
	<input type="text" 
		name="test[text][first]"
		value="<?=@$_REQUEST['test']['text']['first']?>"
	>
	<input type="radio" name="test[radio]" value="first"
		<?=@$_REQUEST['test']['radio']=='first'? 'checked':''?>
	>first
	<input type="radio" name="test[radio]" value="second"
		<?=@$_REQUEST['test']['radio']=='second'? 'checked':''?>
	>second
	<input type="submit" value="Submit">
</form>
<xmp><?print_r($_GET)?></xmp>
<hr><?show_source(__FILE__)?>