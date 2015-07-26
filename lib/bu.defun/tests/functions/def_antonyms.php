<?php
// def_antonyms - создаёт 2 функции, которые инверсируют булевые значения,
// оставляя все остальные без изменений.
def_antonyms('is_boy', 'is_girl',
	     function($name){
		     if($name == 'alexey')
			     return true;
		     if($name == 'lena')
			     return false;
		     if($name == 'string')
			     return 'string';
		     return null;
	     });

def('t', function($v){
		if(is_null($v))
			$text = "null";
		elseif($v === false)
			$text = "false";
		elseif($v === true)
			$text = "true";
		else
			$text = $v;
		echo $text."\n";
	});

t(is_boy('alexey'));
t(is_boy('lena'));
t(is_boy('fido'));
t(is_boy('string'));

t(is_girl('alexey'));
t(is_girl('lena'));
t(is_girl('fido'));
t(is_girl('string'));
?>
---
true
false
null
string
false
true
null
string
