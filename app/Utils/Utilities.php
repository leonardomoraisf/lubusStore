<?php

namespace App\Utils;

use WilliamCosta\DatabaseManager\Database;

class Utilities{

    public static function validateData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    public static function validateImage($image){
        $allowTypes = array('jpg','png','jpeg');
        $imageSize = $image['size'];
        $imageName = $image['name'];
        $imageExt = explode('.',$imageName);
        $imageExt = $imageExt[count($imageExt) - 1];
        // Validate type
        if(in_array($imageExt, $allowTypes)){
            // Validate size
            $size = intval($imageSize / 1024); 
            if($size <= 5000){
                return true;
            }else{
                // Size not allowed
                return false;
            }
        }else{
            // Type not allowed
            return false;
        }
    }

    public static function uploadFile($file,$dir){
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $targetPcDir = 'D:\xampp\htdocs';
        $targetDir = $targetPcDir.'\lubus/uploads/'.$dir;
        $fileExt = explode('.',$fileName);
        $fileExt = $fileExt[count($fileExt) - 1];
        $uniqName = uniqid().'.'.$fileExt;
        if(move_uploaded_file($fileTmpName,$targetDir.$uniqName)){
            return $uniqName;
        }else{
            return false;
        }
    }

    public static function deleteFile($file,$dir){
        $targetPcDir = 'D:\xampp\htdocs';
        $targetDir = $targetPcDir.'\lubus/uploads/'.$dir;
        @unlink($targetDir.$file);
    }

    public static function redirect($url){
        echo '<script>window.location.href="'.$url.'"</script>';
        die();
    }

    /**
     * Method to return lists of data
     * @param string $table
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getList($table = '',$where = null, $order = null, $limit = null, $fields = '*'){
        return(new Database($table))->select($where,$order,$limit,$fields);
    }

    public static function getRow($table = '',$where = null, $order = null, $limit = null, $fields = '*'){
        return(new Database($table))->select($where,$order,$limit,$fields);
    }
}