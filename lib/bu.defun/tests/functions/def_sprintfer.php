<?php
// def_sprintfer - делает тоже что и def_printfer, но используя функцию sprintf
def_sprintfer('h1', '<h1>%s</h1>');
$v = h1('hello!');
echo ">".$v."<";
?>
---
><h1>hello!</h1><
