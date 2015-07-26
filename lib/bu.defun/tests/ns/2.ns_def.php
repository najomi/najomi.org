<?php
// Для создания нескольких функций в другом нэймспэйсе - стоит использовать
// функцию ns().
ns('foo\bar\baz', function(){
		def('one', function(){echo 1;});
		def('two', function(){echo 2;});
		def('three', function(){echo 3;});
		def_printfer('hello', 'Hello, %s');
	});

foo\bar\baz\one();
foo\bar\baz\two();
foo\bar\baz\three();
foo\bar\baz\hello('waserd');
---
123Hello, waserd

