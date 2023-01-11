<?php

namespace App\Utils\Cache;

class File{

    /**
     * Method to return cache path
     * @param string $hash
     * @return string
     */
    private static function getFilePath($hash){

        // CACHE DIR
        $dir = $_ENV['CACHE_DIR'];
        
        // VERIFY EXISTENCE
        if(!file_exists($dir)){
            mkdir($dir,0755,true);
        }

        // RETURN ARCH DIR
        return $dir.'/'.$hash;

    }

    /**
     * Method to record infos on cache
     * @param string $hash
     * @param mixed $content
     * @return boolean
     */
    private static function storageCache($hash,$content){
        
        // SERIALIZE RETURN
        $serialize = serialize($content);
        
        // CATCH PATH CACHE ARCH
        $cacheFile = self::getFilePath($hash);

        // RECORD INFOS ON ARCH
        return file_put_contents($cacheFile,$serialize);

    }

    /**
     * Method to return cache content
     * @param string $hash
     * @param integer $expiration
     * @return mixed
     */
    private static function getContentCache($hash,$expiration){

        // CATCH ARCH DIR
        $cacheFile = self::getFilePath($hash);
        
        // VERIFY ARCH EXISTENCE
        if(!file_exists($cacheFile)){
            return false;
        }

        // VALID EXPIRATION CACHE TIME
        $createTime = filectime($cacheFile);
        $diffTime = time() - $createTime;
        if($diffTime > $expiration){
            return false;
        }

        // RETURN REAL DATA
        $serialize = file_get_contents($cacheFile);
        return unserialize($serialize);

    }

    /**
     * Method to catch cache infos
     * @param string $hash
     * @param integer $expiration
     * @param Closure $function
     * @return mixed
     */
    public static function getCache($hash,$expiration,$function){
        // VERIFY IF EXISTS CONTENT RECORDED
        if($content = self::getContentCache($hash,$expiration)){
            return $content;
        }

        // FUNCTION EXECUTE
        $content = $function();

        // RECORD CACHE RETURN
        self::storageCache($hash,$content);

        // RETURN CONTENT
        return $content;

    }

}