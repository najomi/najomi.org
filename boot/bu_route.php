<?php
class BuRoute{
    private static $instance = false;
    private static $httpString = false;
    private static $route = false;
    private function __construct(){}

    public static function getInstance(){
        if(!self::$instance) self::$instance = new Route();
        return self::$instance;
    }
    public static function setHttpString($var){
        self::$httpString = $var;
    }
    private static function getHttpString(){
        return self::$httpString;
    }

    private static function getRouteList(){
        if(!self::$route){
            $config = bu::config('route');
            $newRoute = array();
            if($config)
                foreach($config as $k=>$v){
                    $newK = str_replace(':any','.*',$k);
                    $newK = str_replace(':num','[0-9]+',$newK);
                    $newRoute[$newK] = $v;
                }
            self::$route = $newRoute;
        }
        return self::$route;
    }
    private static function removeTrailingSlashes($string){
        //zaebalsa sostavlat regylarnoe virazhenie.
        return  preg_replace('@^/(.+[^/])/*$@','$1',$string);
    }
    private static function findFirstMatchingRoute($httpString){
        foreach (self::$route as $k=>$v){
            if(preg_match('@^'.$k.'$@',$httpString)) return $k;
        }
    }
    public static function doIt(){
        $routeList = self::getRouteList();
        $httpString = self::getHttpString();
        $httpString = self::removeTrailingSlashes($httpString);
        $k = self::findFirstMatchingRoute($httpString);
        if(array_key_exists($k,$routeList))
            $httpString = preg_replace('@^'.$k.'$@',$routeList[$k],$httpString);
        return '/'.$httpString;
    }
}
?>
