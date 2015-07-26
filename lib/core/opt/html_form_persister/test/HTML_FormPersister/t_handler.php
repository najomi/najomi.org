<?php
include_once "../../lib/config.php";
include_once "HTML/FormPersister.php"; 
ob_start(array('HTML_FormPersister', 'ob_formPersisterHandler'));
?>
<h2>Modify something, press Submit and see that all modified fields are preserved!</h2>
<form>
  <input type=text name=txt1 default="1.1">
  <input type=text name=txt2[b] default="3.3">
  <input type=text name=txt2[] default="2.1">
  <input type=text name=txt2[] default="2.2">
  <input type=text name=txt3[a][] default="3.1">
  <input type=text name=txt3[a][] default="3.2">
  <input type=text name=txt4 default="4.1">

  <br>
  <textarea name=area1 default="ssss"></textarea>
  <textarea name=area2[]></textarea>
  <textarea name=area2[]></textarea>

  <br>
  <input type=radio name=rad1 value=r label="right"> |
  <input type=radio name=rad1 value=l label="left^"> |
  <input type=radio name=rad1 value=u> |
  <input type=radio name=rad1 value=d> |||
  <input type=radio name=rad2[a] value=u default=u> |
  <input type=radio name=rad2[a] value=d> |||

  <br>
  <input type=checkbox name=chk1[] value=aaa default>
  <input type=checkbox name=chk1[] value=bbb> |||
  <input type=checkbox name=chk2[a] value=xxx>
  <input type=checkbox name=chk2[b] value=yyy> |||

  <br>
  <select name=sel1 size="3">
    <option value=a>aaaaaaaaaaaaa
    <option value=b>bbbbbbbbbbbbb
    <option value=c>ccccccccccccc
  </select>
  <select name=sel2[] multiple size="3" bb="eaaa">
    <option value=a>aaaaaaaaaaaaa
    <option value=b>bbbbbbbbbbbbb
    <option value=c>ccccccccccccc
  </select>
  <select name=sel3 multiple size="3">
    <option value=a>aaaaaaaaaaaaa
    <option value=b>bbbbbbbbbbbbb
    <option value=c>ccccccccccccc
  </select>

  <br>
  <input type=submit>
  <input type=submit confirm="Are you sure?">
</form>

<h2>Source code is very simple</h2>
<?show_source(__FILE__)?>
