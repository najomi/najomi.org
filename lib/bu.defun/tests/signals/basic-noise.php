<?php
def_printfer('p', "%s\n");
p(1);
noise('warning');
p(2);
catcher('warning', function(){ echo "warning!\n"; });
noise('warning');
p(3);
?>
---
1
2
warning!
3
