<?php
// Используя def возможно создавать статические функции внутри классов. Классы
// не должны быт объявленны ранее.
// Синтаксически это похоже на модули в ruby. 
def("hello::world", function($what){
		echo "Hello, {$what}!";
	});

hello::world('waserd');
---
Hello, waserd!
