var hljs = require('highlight.js');
var $ = require('jquery');
var search = require('./search.js');
var ga = require('./ga.js');

var instantclick = require('instantclick');

instantclick.on('change', function() {
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('#search').replaceWith(search);

  ga('send', 'pageview', location.pathname + location.search);
});

instantclick.init();
