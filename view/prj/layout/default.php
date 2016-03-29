<!doctype html>
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lobster&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <LINK REL="SHORTCUT ICON" HREF="<?=bu::pub('favicon.png')?>">
    <title><?=title()?></title>
    <meta name="keywords" content="<?=(is_array(keywords()) ? implode(', ', keywords()) : keywords())?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='/public/build.css' rel='stylesheet' type='text/css'>
</head>
<body>
  <div class="container">

    <div class="col-md-10 col-md-push-1">
      <div id='header'> Большая поваренная книга программиста.  </div>

      <div class="row">
        <div id='sub_header'>
          <?=view('menu')?>
        </div>
      </div>


      <div id='content'>
        <?=$data?>
      </div>
      <div id='footer'>
      <table>
      <tr>
       <td id='first_col'>
          <a href='/'>На главную</a>
       </td>
       <td id='second_col'>
       &nbsp;
       </td>
       <td style='text-align: right'>
         По любым вопросам: <a href='mailto:zendzirou@gmail.com'>zendzirou@gmail.com</a><br>
         Исходный код сайта: <a href='http://github.com/najomi/najomi.org'>gh:najomi/najomi.org</a><br>
         Данные: <a href='http://github.com/najomi/data'>gh:najomi/data</a><br>
       </td>
      </tr>
          </table>
        </div>
    </div>

  </div>

  <script src='/public/build.js'></script>

  <script data-no-instant>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    (function() {
      var cx = '014687314998932346798:20v3gebley0';
      var gcse = document.createElement('script');
      gcse.type = 'text/javascript';
      gcse.async = true;
      gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
          '//www.google.com/cse/cse.js?cx=' + cx;
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(gcse, s);
    })();

    ga('create', 'UA-9241103-3', 'najomi.org');
  </script>
</body>
</html>
