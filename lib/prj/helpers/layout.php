<?php
def_alias('bu::layout', 'l');

def_accessor('title');
def_accessor('keywords');
def_accessor('description');

def('show_404', function(){
		write_log("404", RAW_HTTP_STRING);
                header("Status: 404 Not Found");
		draw_page('Страница не найдена', view('404'));
	});

def('draw_page', function($title, $content){
		title($title);
		echo dview('layout/default', $content);
	});
