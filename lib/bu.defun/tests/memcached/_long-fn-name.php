<?php
$nm = str_repeat("a", 500);
def_md($nm, 5, function($a){ echo '.'; return "$a\n"; });
echo call_user_func_array($nm, array(1));
echo call_user_func_array($nm, array(1));
echo call_user_func_array($nm, array(2));

?>
---
.1
1
.2