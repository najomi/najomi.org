<?phpinclude_once "../../lib/config.php";
include_once "HTML/FormPersister.php";
$ob = new HTML_FormPersister();

$options['some']['key'] = array('one' => 'From 1d array', 'two' => 'Other from 1d');
$options['other']['key'] = array(
  'Group1' => array('one'   => 'From 2d array',       'two'  => 'Another from 2d'),
  'Group2' => array('three' => 'Again from 2d array', 'four' => '2d vah-vah!'),
);

$code = trim(str_replace("\t","", '
  <br><form>
  <select name=sel-1>
    options[some][key]
  </select>
  <select name=sel0>
    <option value="0">0000</option>
    $options[some][key]
    <option value="1">1111</option>
  </select>
  <select name=sel1>
    <optgroup label="aaa">
      <option value="0">rrrrr</option>
      options[some][key]
    </optgroup>
    options[other][key]
  </select>
  <select name=sel2 size="1">
    <optgroup label="First">
      <option value=a>aaaaaaaaaaaaa
      <option value=b>bbbbbbbbbbbbb
    </optgroup>
    <optgroup label="Second">
      <option value=c>ccccccccccccc
    </optgroup>
  </select>
  <select name=sel3 size="3" bb="eaaa">
    <option value=a>aaaaaaaaaaaaa
    <option value=b selected>bbbbbbbbbbbbb
    <option value=c>ccccccccccccc
  </select>
  <select name=sel4 multiple size="3">
    <option value=a>aaaaaaaaaaaaa
    <option value=b>bbbbbbbbbbbbb
    <option value=c>ccccccccccccc
  </select>
  <input type="submit" value="&nbsp;OK&nbsp;">
  </form>
'));

$proc = $ob->process($code);
?>

<h2>Modify something, press Submit and see that all modified fields are preserved!</h2>

<?=$proc?>

<h2>Code before and after replacement (compare!)</h2>

<table width=100% height=50% cellpadding=1 cellspacing=0 border=0>
<tr>
  <td width="50%">
  	<b>Original HTML code:</b>
  	<pre id="left" onscroll="document.all.right.scrollTop=this.scrollTop" style="margin-top:0.3em; overflow:auto; height:auto; border:1px solid black"><font size=-1><?=preg_replace('/(default|label)/', '<font color="red">$1</font>', htmlspecialchars($code))?>
 	</td>
  <td valign="middle"><nobr><font size=+2><b>&gt;<br>&gt;<br>&gt;</b></td>
  <td>
  	<b>This HTML after processing using HTML_FormPersister:</b>
  	<pre id="right" style="margin-top:0.3em; overflow:auto; height:auto; border:1px solid black"><font size=-1><?=htmlspecialchars($proc)?>
  </td>
</tr>
</table>

<h2>GET data</h2>
<pre><?print_r($_GET)?></pre>

<h2>Source code</h2>
<?show_source(__FILE__)?>
