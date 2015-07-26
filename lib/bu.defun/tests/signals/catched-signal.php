<?php
catcher('warning', function(){ echo "catched"; });
signal("warning");
---
catched
