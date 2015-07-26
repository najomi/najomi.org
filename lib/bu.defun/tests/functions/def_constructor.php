<?php
// def_constructor принимает в качестве первого аргумента имя создаваемой
// функции. Функция будет конструировать массивы получая лишь значения для
// полей.
def_constructor('mk_user', 'name', 'age');
$one = mk_user('alex', 21);
$two = mk_user('sasha', 28);
foreach(array($one,$two) as $u){
	foreach($u as $k=>$v)
		echo $k.": ".$v."\n";
	echo "-\n";
}
---
name: alex
age: 21
-
name: sasha
age: 28
-
