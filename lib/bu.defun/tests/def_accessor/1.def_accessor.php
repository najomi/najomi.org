<?php
// def_accessor создаёт функцию, которая хранит в себе определённое значение и
// возвращает его при вызове. Ей можно передать в качестве аргумента новое
// значение
def_accessor('user');
if(is_null(user()))
	echo "null\n";
user('waserd');
echo user();
---
null
waserd
