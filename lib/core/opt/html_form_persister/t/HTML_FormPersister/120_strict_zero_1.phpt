--TEST--
HTML_FormPersister: in_array() workaround (first case)
--FILE--
<?php
require dirname(__FILE__) . '/init.php';

ob_start(array('HTML_FormPersister', 'ob_formpersisterhandler'));
$_POST['_currencies'] = array(0);

?>
<form method="post">
<input type="checkbox" name="_currencies[]" value="RUB" />
<input type="checkbox" name="_currencies[]" value="EUR" />
<input type="checkbox" name="_currencies[]" value="USD" />
</form>

<form method="post">
<input type="checkbox" name="_currencies[]" value="0" />
<input type="checkbox" name="_currencies[]" value="1" />
</form>


--EXPECT--
<form method="post" action>
<input type="checkbox" name="_currencies[]" value="RUB" />
<input type="checkbox" name="_currencies[]" value="EUR" />
<input type="checkbox" name="_currencies[]" value="USD" />
</form>

<form method="post" action>
<input type="checkbox" name="_currencies[]" value="0" checked="checked" />
<input type="checkbox" name="_currencies[]" value="1" />
</form>


