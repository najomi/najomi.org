<!doctype html>
<html>
<head>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <LINK REL="stylesheet" TYPE="text/css" HREF="<?php echo bu::pub('css/style.css')?>">
    <LINK REL="stylesheet" TYPE="text/css" HREF="<?php echo bu::pub('default.css')?>">
    <link href='http://fonts.googleapis.com/css?family=Lobster&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <LINK REL="SHORTCUT ICON" HREF="<?=bu::pub('favicon.png')?>">
    <title><?=title()?></title>
    <meta name="keywords" content="<?=(is_array(keywords()) ? implode(', ', keywords()) : keywords())?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <div class="container">

    <div class="col-md-10 col-md-push-1">
      <div id='header'> Большая поваренная книга программиста.  </div>
      <div id='sub_header'>
        <?=view('menu')?>
      </div>
      <center>
      <a href='mailto:zendzirou@gmail.com'><img src='/public/hire.png' width='750px' style='border: 1px solid grey; margin: 20px 0px;'></a>
      </center>
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


  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css">
  <script data-no-instant src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script data-no-instant src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script data-no-instant src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>
  <script data-no-instant src="<?php echo bu::pub('instantclick.min.js')?>"></script>
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
    var SEARCH = $('#search');

    ga('create', 'UA-9241103-3', 'najomi.org');

    hljs.tabReplace = '    ';
    hljs.initHighlightingOnLoad();

    InstantClick.on('change', function() {
      $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
      });
      $('#search').replaceWith(SEARCH);

      ga('send', 'pageview', location.pathname + location.search);
    })

    InstantClick.init();
  </script>
</body>
</html>
