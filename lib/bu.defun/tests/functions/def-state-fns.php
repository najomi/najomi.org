<?php
// def_state_fns принимает 4 аргумента: 
// - название для функции возвращающей нормальное значение
// - ................................. инвертированное значение
// - функция, которая устанавливает значение
// - ................ возвращает значение
// Ниже рассмотрен пример авторизации пользователя, с хранением значения в
// в сессии:
session_start();
def_state_fns('is_user', 'is_guest',
	      function($v){
		      $_SESSION['is_user'] = $v;
	      },
	      function(){
		      return isset($_SESSION['is_user']) ? $_SESSION['is_user'] : false;
	      });

$pr = function(){
	$tf = function($v){ echo ($v ? 'true' : 'false')."\n";};
	$tf(is_user());
	$tf(is_guest());
};
//default state
$pr();

//inverse state
is_user(true);
$pr();

//set over is_guest();
is_guest(true);
$pr();

?>
---
false
true
true
false
false
true
