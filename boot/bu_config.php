<?php
class buConfig{
    private function __construct(){}
    private static $configArray = array();

    private static function preloadCacheConfig(){
        if(!array_key_exists('cache',self::$configArray)){
            if(BuCache::exists('etc/'.md5('cache'))){
                self::$configArray['cache'] = BuCache::get('etc/'.md5('cache'));
            }else{
                self::$configArray['cache'] = self::readConfigFromFiles('cache');
                if(bu::config('cache/config'))
                    buCache::set('etc/'.md5('cache'),self::$configArray['cache']);
            }
        }
    }
    private static function tryToPreloadConfig($path){
        if(bu::config('cache/config') and BuCache::exists('etc/'.md5($path))){
            self::$configArray[$path] = BuCache::get('etc/'.md5($path));
        }else{
            self::$configArray[$path] = self::readConfigFromFiles($path);
            if(bu::config('cache/config'))
                BuCache::set('etc/'.md5($path),self::$configArray[$path]);
        }
    }
    public static function get($configFullPath){
        self::preloadCacheConfig();
        preg_match('@(.+)/([^/]+)@',$configFullPath,$match);
        $path = '';
        $key = '';
        if(isset($match[1]))
            $path = $match[1];
        if(isset($match[2]))
            $key = $match[2];

        if(!array_key_exists($configFullPath, self::$configArray) and
           !array_key_exists($path,self::$configArray)){
            $catched = 0;
            try{
                self::tryToPreloadConfig($path);
            }catch(Exception $e){
                $catched++;
            }
            try{
                self::tryToPreloadConfig($configFullPath);
            }catch(Exception $e){
                if($catched == 1)
                    throw $e;
            }

        }
        if(array_key_exists($configFullPath, self::$configArray))
            return self::$configArray[$configFullPath];
        if (array_key_exists($key,self::$configArray[$path])) 
            return self::$configArray[$path][$key]; 
        throw new Exception('Config key "'.$configFullPath.'" not exists');
    }
    public static function set($path,$value){
        $data = self::get($path);
        preg_match('@(.+)/([^/]+)@',$path,$match);
        $path = $match[1];
        $key = $match[2];
        self::$configArray[$path][$key] = $value;
        return $data;
    }
    private static function readConfigFromFiles($configPath){
        $config = array();
        $configCoreDir = BuCore::fstab('configCore').'/';
        $configPrjDir = BuCore::fstab('configPrj').'/';
        $configHostDir = BuCore::fstab('configHostDir').'/'.HTTP_HOST.'/';
        if( !file_exists($configCoreDir.$configPath.'.yaml') and
            !file_exists($configPrjDir.$configPath.'.yaml') and
            !file_exists($configHostDir.$configPath.'.yaml') ) 
            throw new Exception('Config file '.$configPath.' not exists');
        $config = array();
        foreach(array($configCoreDir,$configPrjDir,$configHostDir) as $v)
            if(file_exists($v.$configPath.'.yaml')) {
                ob_start();
                include($v.$configPath.'.yaml');
                $data = ob_get_contents();
                ob_end_clean();
                $newConfig = Spyc::YAMLLoad($data);
                $config = array_merge($config, $newConfig);
            }
        return $config;
    }
}
?>
