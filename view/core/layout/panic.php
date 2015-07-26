<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo bu::view('header/charset');?>
    <?php echo bu::view('header/meta',
                        array('title'=>$title, 
                              'keywords'=>$keywords, 
                              'description'=>$description));?>
</head>
<style>
h1{
    font-size: 20px;
    font-family: georgia;
    font-style: italic;
    font-weight: bold;
    background: black;
    color: white;
    padding: 7px 10px;;
    display: inline-block;

}
.container{
    width: 600px;
}
h2{
    padding: 7px 10px;
}
p{
    padding: 7px 10px;
    font-family: verdana;
}
textarea{
    padding: 7px 10px;
    width: 550px;
    overflow: auto;
    border: 1px solid black;
    height: 500px;
}
#help_info{
    display: block;
}
</style>
<body>
<div class="container">
        <h1 class='alt'>Что то пошло очень, ОЧЕНЬ не так!</h1>
            <h2><?php echo $content?></h2>
        <div id='help_info'> 
            <p>
            Иногда ошибки случаются. Как раз сейчас случилась одна из
            них. 
            </p>
            <p>
                Возможно было сделано совсем не то, что задумывалось
                программистом.  Может быть будет достаточно вернуться на
                страницу назад и попробовать сделать это "что-то" по
                другому.
            </p>
            
            <p>
                Если это не поможет, то напишите по адресу 
                <a href='mailto:<?php echo bu::config('rc/adminEmail');?>'>
                    <?php echo bu::config('rc/adminEmail');?></a>.
                Этот человек вероятнее всего имеет отношение к этому сайту и может
                попытаться что-то сделать.
            </p>
            <?php if($_POST):?>
            <p>
                Если до этого вы долго-долго что то писали и при
                отправке произошла эта ошибка, то это может оказаться
                здесь:
                <textarea><?php print_R($_POST);?></textarea>
            </p>
            <?php endif;?>
        </div>
</div>
</body>
</html>
