<?php
// def_alias - создаёт алиас для функции. 
def('one', function(){ echo 1; });
def_alias('one', 'two');
one();
two();
?>
---
11
