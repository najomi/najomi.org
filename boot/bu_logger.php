<?php
class buLogger{
    private static $_log = false;
    public static function log($name=false,$group=false,$data = false){
        self::$_log .= bu::view('debug_bar/log_message',array('time'=>time(),
                                                              'name'=>$name,
                                                              'group'=>$group,
                                                              'data'=>$data),true);
    }
    public static function getLog(){
        return self::$_log;
    }
}
?>
