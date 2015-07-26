<?php

class bu{
    public static function timer($name = false, $group = false){
        buStatistic::timer($name,$group);
    }
    public static function log($name=false, $group=false, $data=false){
        buLogger::log($name,$group,$data);
    }

    public static function config($configFullPath, $value = false){
        include_once('boot/bu_config.php');
        if (count(func_get_args())==1)
            return buConfig::get($configFullPath);
        else
            return buConfig::set($configFullPath,$value);
    }

    public static function flash($key, $value = NULL){
        if(is_null($value)){
            $flashInfo = bu::session('flash');
            if(isset($flashInfo[$key]))
                return $flashInfo[$key]['text'];
        }else{
            $flashInfo = bu::session('flash');
            if($key=='error' and is_array($value))
                $text = bu::view('errors',array('errors'=>$value));
            else
                $text = $value;
            $flashInfo[$key] = array('text'=>$text,'valid'=>true);
            bu::session('flash',$flashInfo);
        }
    }
    public static function isValidRequest(){
        if(!preg_match('/(js|css|jpeg|jpg|gif|ico|png|rss)$/', 
                      strtolower(RAW_HTTP_STRING)))
            return true;
    }
    public static function isInvalidRequest(){
        return !bu::isValidRequest();
    }
    public static function session($key,$value = NULL){
        bu::lib('session');
        if (count(func_get_args())==1)
            return Session::get($key);
        else
            return Session::set($key,$value);
    }
    public static function currentLanguage(){
        $sessionLanguage = bu::session('language');
        if($sessionLanguage and preg_match('/^[a-z]{2}$/',$sessionLanguage))
            return $sessionLanguage;
        return self::config('rc/defaultLanguage');
    }
    public static function lang($path){
        return self::config('lang/'.self::currentLanguage().'/'.$path);
    }

    public static function view($_b_name, $_b_data = array()){
        if(!$_b_data)
            $_b_data = array();
        ob_start();
            foreach ($_b_data as $k => $v)
                $$k = $v;
            $_b_file = self::getViewFile($_b_name);
            if($_b_file != 'blank')
                include($_b_file); 
            $_b_view_html = ob_get_contents();
        ob_end_clean();
        return $_b_view_html;
    }
    public static function deprecated($text){
        $action = bu::config('rc/actionOnDeprecated');
        if(!$action)
            return ;
        if($action == 'exception')
            throw new Exception ($text);
        if($action == 'print')
            print ('--'.$text.'--');
    }
    public static function redirect($url){
        if($url=='back'){
            $pages = bu::session('pages');
            $url = $pages['previous'];
        }
        header('Location: '.$url);
        exit;
    }

    private static $_last_bu_url_instance = false;
    private static $_path = false;
    public static function setBuUrlInstance($i){
	    self::$_last_bu_url_instance = $i;
    }
    public static function args($segment = false){
	$i = self::$_last_bu_url_instance;
        $args = $i->getVars();
        if ($segment === false)
            return $args;
        if(!array_key_exists($segment, $args))
            return false;
        return $args[$segment];
    }
    public static function path($segment = false){
	if(self::$_path === false){
		$i = self::$_last_bu_url_instance;
		self::$_path = $i->getPath();
	}
        if ($segment === false)
            return self::$_path;
        if(!array_key_exists($segment, self::$_path))
            throw new Exception('Сегмент '.$segment.' отсутствует в'.
                                ' списке пути.');
        return self::$_path[$segment];
    }



    public static function act($_b_name, $_b_data = array()){
        if(!$_b_data)
            $_b_data = array();
        ob_start();
            foreach ($_b_data as $k => $v)
                $$k = $v;
            $_b_file = self::getActFile($_b_name);
            if($_b_file != 'blank')
                include($_b_file); 
            $_b_view_html = ob_get_contents();
        ob_end_clean();
        return $_b_view_html;
    }

    public static function hook($_b_name,$_b_data=array()){
        if(!$_b_data)
            $_b_data = array();
        foreach ($_b_data as $k => $v)
            $$k = $v;
        $_b_file = self::getHookFile($_b_name);
        if($_b_file != 'blank')
            return include($_b_file); 
    }
    public static function lib($path, $reload=false){
        $filePath = self::getLibFile($path);
        if($filePath == 'blank')
            return;
        if($reload)
            require($filePath);
        else
            require_once($filePath);
    }
    private static $_db = array();
    public static function db($configName='default'){
        if(!isset(self::$_db[$configName])){
            $config = bu::config('db/'.$configName);
            self::$_db[$configName] = new PDO($config['driver'].':host='.
                                          $config['host'].';dbname='.
                                          $config['database'],
                                          $config['user'],
                                          $config['password']);
        }
        return self::$_db[$configName];
    }
    private static $_ormPeer = array();
    public static function orm($path){
        self::lib('orm/'.$path);
        self::lib('orm/peer/'.$path);
        if(!isset(self::$_ormPeer[$path])){
            $className = str_replace('_','',$path).'OrmPeer';
            self::$_ormPeer[$path] = new $className();
        }
        return self::$_ormPeer[$path];
    }

    public static function layout(){
        bu::lib('bu/layout');
	return buLayout::getInstance();
    }

    public static function pub($path){
        return self::config('rc/browserPublicPath').$path;
    }

    public static function up($path){
        return self::config('rc/browserUploadPath').$path;
    }

    public static function url($path,$data = array()){
        $url = self::config('url/'.$path);
        if($data)
            foreach($data as $k=>$v)
                $url = str_replace(':'.$k,$v, $url);
        return $url;
    }
    private static function getFile($pathArray, $fstabPrefix, $exceptionString){
        if (is_string($pathArray))
            $pathArray = array($pathArray);
        $coreDir = BuCore::fstab($fstabPrefix.'Core').'/';
        $prjDir = BuCore::fstab($fstabPrefix.'Prj').'/';
        $hostDir = BuCore::fstab($fstabPrefix.'HostDir').'/'.HTTP_HOST.'/';
        foreach ($pathArray as $path){
            if($path=='blank')
                return 'blank';
            foreach(array($hostDir,$prjDir,$coreDir) as $v)
                if(file_exists($v.$path.'.php'))
                    return $v.$path.'.php';
		elseif(file_exists($v.$path.'/index'.'.php'))
                    return $v.$path.'/index'.'.php';

        }

        throw new Exception(sprintf($exceptionString, implode(', ',$pathArray)));
    }
    private static function getViewFile($pathArray){
        return self::getFile($pathArray, 'view', 'View: %s not exists');
    }
    private static function getHookFile($pathArray){
        return self::getFile($pathArray, 'hook', 'Hook: %s not exists');
    }
    private static function getActFile($pathArray){
        return self::getFile($pathArray, 'act', 'Action: %s not exists');
    }
    private static function getLibFile($pathArray){
        return self::getFile($pathArray, 'snip', 'Library: %s not exists');
    }



}
