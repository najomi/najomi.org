<?php
def_md('foo\bar', 5, function(){ echo '.'; return "1\n"; });
def_md('foo::bar', 5, function(){ echo '.'; return "2\n"; });
echo foo\bar();
echo foo\bar();
echo foo::bar();
echo foo::bar();
?>
---
.1
1
.2
2