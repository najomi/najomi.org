<?php
// def_text_inspector - оборачивает функцию, так что можно следить за её
// вызовом, переданными аргументами и возвращаемыми значениями
set_time_limit(1);
def('inc', function($i){
		echo "Increment {$i}\n";
		return $i + 1;
	});

def_text_inspector('inc');
echo inc(3, 'hello');
?>
---
>> Calling 'inc' function with arguments:
>> - 3
>> - hello
Increment 3
>> return value is '4'
4
