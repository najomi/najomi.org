<?php
Class BuStatistic{
    public static function printa(){
        echo bu::act('debug_bar');
    }
    public static function getMicrotime(){
        list($us, $s) = explode(' ', microtime());
        $time = (float)$us+(float)$s;
        return (float)$time;
    }

    private static $_timeStatistic = array();
    private static $_timeGroups = array();
    private static $_firstTime = false;
    public static function timer($name = ' - ',$group = 'default'){
        $time = self::getMicrotime();
        self::$_timeStatistic[(string)$time] = $name;
        self::$_timeGroups[(string)$time] = $group;
    }
    public static function getTimerStatistic(){
        return self::$_timeStatistic;
    }
    public static function getTimerGroups(){
        return self::$_timeGroups;
    }
}
