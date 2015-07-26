<?php
// Используя обратный слэш можно создавать функции внутри другого нэймспэйса
def('foo\bar\baz\hello', function(){ echo "Hello!"; });
foo\bar\baz\hello();
?>
---
Hello!
