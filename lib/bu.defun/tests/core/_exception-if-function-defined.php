<?php
// Проверка на то что нельзя переопределить внутренние функции в php
try{
	def('print_r', function(){});
}catch(bu\def\CannotDef $e){
	echo 'catched!';
}
?>
---
catched!
