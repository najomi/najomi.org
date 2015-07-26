<?php
// Проверяем что нельзя вызвать функцию, из-за пределов блока deflet
try{
	deflet(function(){
			def('hello', function(){});
		});
	hello();
}catch(bu\def\FnNotDefined $e){
	echo 'catched!';
}
?>
---
catched!
