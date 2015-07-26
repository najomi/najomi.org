<?php
def_printfer('p', "%s\n");
p(1);
catcher('warning', function(){ echo "warning!\n"; });
noise('warning');
p(2);
catcher('warning', function(){ echo "error!\n"; });
noise('warning');
p(3);
?>
---
1
warning!
2
error!
3
