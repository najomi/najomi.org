<?php
class BuCache{
    public static function exists($path){
        if(file_exists(BuCore::fstab('cache').'/'.$path))
            return true;
    }
    public static function get($path){
        if(!file_exists(BuCore::fstab('cache').'/'.$path))
            throw new Exception('Нельзя читать из несуществующего кэша');
        return unserialize(file_get_contents(BuCore::fstab('cache').'/'.$path));
    }
    public static function set($path,$data){
        $dir = dirname($path);
        if(!file_exists(BuCore::fstab('cache').'/'.$dir))
            mkdir(BuCore::fstab('cache').'/'.$dir,0777,true);
        file_put_contents(BuCore::fstab('cache').'/'.$path,serialize($data));
    }
    public static function delete($path){
        unlink(BuCore::fstab('cache').'/'.$path);
    }

}
?>
