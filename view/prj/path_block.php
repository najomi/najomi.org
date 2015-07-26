<div id="navigation">
	 <a href='/'>/</a> &rarr;
<?php
$path = bu::path();
$prefix = '/';
$last = $path[count($path)-1];
$last_i = count($path)-1;
foreach ($path as $k => $v){
    $category_path = trim($prefix.$v,'/');
    $c = Category::get($category_path);
    if ($k == $last_i){
	    if(preg_match('/^[0-9]+$/', $c->getName())){
		    echo '<b>пример #'.$id.'</b>'."\n";
	    }else{
		    echo '<b>'.$c->getName().'</b>'."\n";
	    }
    }else{
        echo '<a href="'.$prefix.$v.'">'.$c->getName().'</a> &rarr;'."\n";
    }
    $prefix = $prefix.$v.'/';
}
?>
</div>
