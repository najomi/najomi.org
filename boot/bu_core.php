<?php
    class BuCore{
        private static $_fstab = false;
        public static function fstab($key){
            if (!self::$_fstab) {
                include(FSTAB);
                self::$_fstab = $config;
            }
            if(array_key_exists($key,self::$_fstab))
                return self::$_fstab[$key];
            else
                throw new Exception('Fstab key:'.$key.' not exists ');
        }
    }
?>
