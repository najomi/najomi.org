<?php
def_printfer('puts',"%s\n");
puts('base>');
_catch("first", function(){
		puts('1>');
		_catch("second",function(){
				puts('2>');
				_catch("third", function(){
						puts('3>');
						_throw("second");
						puts('<3');
					});
				puts('<2');
			});
		puts('<1');
	});
puts('<base');
?>
---
base>
1>
2>
3>
<1
<base