<?php
class Session{
    
    public static function start(){
        session_start();
    }
    public static function get($path){
        if(isset($_SESSION[bu::config('session/prefix')][$path]))
            return $_SESSION[bu::config('session/prefix')][$path];
        else
            return false;
    }
    public static function set($path,$value){
        $_SESSION[bu::config('session/prefix')][$path] = $value;
    }
    public static function clear($path){
        unset($_SESSION[bu::config('session/prefix')][$path]);
    }
}
?>
