<?php
// Оборачивая функцию с помощью def_wrapper возможно переопределять
// передаваемые аргументы
def('m2', function($i){ return $i * 2; });
def_wrapper('m2', function($call){ return $call(3); });
echo m2(2);
?>
---
6
