<!doctype html>
<html>
<head>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <LINK REL="stylesheet" TYPE="text/css" HREF="<?php echo bu::pub('css/style.css') ?>">
    <LINK REL="stylesheet" TYPE="text/css" HREF="<?php echo bu::pub('default.css') ?>">
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
    <LINK REL="SHORTCUT ICON" HREF="<?=bu::pub('favicon.png')?>">
    <title><?=title()?></title>
    <meta name="keywords" content="<?=(is_array(keywords()) ? implode(', ', keywords()) : keywords())?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://yastatic.net/pcode/adfox/loader.js" crossorigin="anonymous"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K3WH5R9');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K3WH5R9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  <div class="container">

    <div class="col-md-10 col-md-push-1">
      <div id='header'> Большая поваренная книга программиста.  </div>

      <div class="row">
        <div id='sub_header'>
          <?=view('menu')?>
        </div>
      </div>

<!--
      <center>
      <a href='mailto:zendzirou@gmail.com'><img src='/public/hire.png' width='750px' style='border: 1px solid grey; margin: 20px 0px;'></a>
      </center>
-->
      <style>
        #adfox_161979761756957096 img{
          border-radius: 7px;
          border: 1px solid black;
        }
        #adfox_161979761756957096 {
          margin-bottom: 5px;
        }
      </style>
      <div id="adfox_161979761756957096"></div>


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
         Исходный код сайта: <a href='https://github.com/najomi/najomi.org'>gh:najomi/najomi.org</a><br>
         Данные: <a href='https://github.com/najomi/data'>gh:najomi/data</a><br>
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
  <script data-no-instant src="<?php echo bu::pub('instantclick.min.js') ?>"></script>

  <noscript><div><img src="https://mc.yandex.ru/watch/76744201" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

  <script data-no-instant>
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(76744201, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });

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

      ym(76744201, 'hit', location.pathname + location.search);
      ga('send', 'pageview', location.pathname + location.search);
    })

    setInterval(function(){
      d = document.getElementById('adfox_161979761756957096')
      if(d.__edited) { return; }

      window.Ya.adfoxCode.create({
          ownerId: 275375,
          containerId: 'adfox_161979761756957096',
          params: {
              pp: 'g',
              ps: 'cxoq',
              p2: 'gfjh'
          }
      });
      d.__edited = true;
    },1000);


    InstantClick.init();
  </script>
</body>
</html>
