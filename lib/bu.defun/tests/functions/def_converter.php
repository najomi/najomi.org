<?php
// def_converter служит для создания преобразующих функций. Она создаёт 2
// функции: к примеру down_to_up - для преобразования 1 аргумента, и
// downs_to_ups для преобразования массива аргументов.
def_converter('down', 'up', function($s){return strtoupper($s);});
echo down_to_up('hello')."\n";
foreach(downs_to_ups(array('wor', 'ld')) as $v)
	echo $v."\n";
?>
---
HELLO
WOR
LD

