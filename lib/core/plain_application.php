<?php
class PlainApplication{
	public function runController($__url){
		bu::timer('Controller start.','system');
		include($__url->getBinFile());
		bu::timer('Controller end.','system');
	}
}

