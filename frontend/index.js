var $ = require('jquery');

require('bootstrap/dist/css/bootstrap.css');
require('./css/style.css');

var hljs = require('highlight.js');
hljs.tabReplace = '    ';
hljs.initHighlightingOnLoad();
require('highlight.js/styles/default.css');


var instantclick = require('instantclick');
var SEARCH = $('#search');
instantclick.on('change', function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('#search').replaceWith(SEARCH);

  //ga('send', 'pageview', location.pathname + location.search);
});

instantclick.init();
