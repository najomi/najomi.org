<?php
// import_ns - импортирует функции в глобальный нэймспэйс из другого.
namespace{
	require_once "load.php";
}
namespace foo\bar\baz{
	function one(){ echo 1; }
	function two(){ echo 2; }
	function three(){ echo 3; }
}
namespace{
	import_ns('foo\bar\baz');
	one();
	two();
	three();
}
?>
---
123
