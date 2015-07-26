<?php
foreach(but_last(w('one two three')) as $v)
	echo $v."\n";
---
one
two