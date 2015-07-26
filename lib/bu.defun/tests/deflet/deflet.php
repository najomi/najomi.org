<?php
// С помощью deflet можно выполнить участок кода, так что
// определённые/переопределённые функции не будут видны за его пределами
def_printfer("say", "one\n");
say();
deflet(function(){
		def_printfer("say", "two\n");
		say();
	});
say();
?>
---
one
two
one
