<?php
try{
	signal("warning");
}catch(bu\def\UncatchedSignalException $e){
	echo "catched";
}
?>
---
catched
