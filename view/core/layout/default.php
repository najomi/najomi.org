<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo bu::view('header/charset');?>
    <?php echo bu::view('header/meta',
                        array('title'=>$title, 
                              'keywords'=>$keywords, 
                              'description'=>$description));?>
    <?php echo bu::view('header/blueprint');?>
    <style>
    #header{
        height: 30px;
    }
    #footer{
        text-align: center;
    }
    </style>
</head>
<body>
<div class="container">
    <div class='span-22 prepend-1' id='header'> 
        <div class='span-4 prepend-19 last' id='header'> 
        </div> 
    </div> 

    <div class='span-22 prepend-1'> 
	<?php echo bu::act('flash_block');?>
    </div>
    <div class='span-22 prepend-1'> 
        <h1 class='alt'><?php echo $title?></h1>
        <div class='span-15 prepend-2'>
            <?php echo $content?>
        </div>
    </div>
    <div class='span-22 prepend-1' id='footer'>
        <a href='http://bubujka.ru/'><img src='<?php echo bu::pub('bu_logo.png');?>'></a>
    </div> 
</div>
</body>
</html>
