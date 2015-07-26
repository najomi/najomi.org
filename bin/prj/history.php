<?php
$layout->title = 'Поваренная книга программиста';
$str = `cd data; git log --pretty=format:'%H %at %s' --summary`;
echo "<pre>";
$r = array();
foreach(explode("\n\n", $str) as $block){
        list($meta, $files) = explode("\n", $block."\n\n", 2);
        $meta = trim($meta);
        list($hash, $time, $comment) = explode(" ", $meta, 3);
        $files = explode("\n", trim($files));
        $r[] = compact('hash', 'time', 'comment', 'files');
}
print_R($r);
#echo nl2br($str);


