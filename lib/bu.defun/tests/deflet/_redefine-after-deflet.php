<?php
// Проверяем что функцию можно переопределить, после того как она была
// объявлена в блоке deflet
deflet(function(){
		def('hello', function(){});
	});
def('hello', function(){ echo "worked"; });
hello();
?>
---
worked
