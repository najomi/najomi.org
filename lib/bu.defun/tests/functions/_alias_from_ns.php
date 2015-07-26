<?php
// Проверяем что можно сделать алиас на функцию из другого нэймспэйса
def('foo\bar\baz\hello', function(){ echo "Hello!"; });
def_alias('foo\bar\baz\hello', 'hello');
hello();
?>
---
Hello!
