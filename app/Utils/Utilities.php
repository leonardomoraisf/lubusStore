<?php

namespace App\Utils;

use WilliamCosta\DatabaseManager\Database;
use App\Utils\MySql;

class Utilities{

    /**
     * Method to validate string data
     * @param string $data
     * @return String
     */
    public static function validateData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    /**
     * Method valid images
     * @param string $image
     * @return Boolean
     */
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

    /**
     * Method to upload file
     * @param string $file
     * @param string $dir
     * @return String
     */
    public static function uploadFile($file,$dir){
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $targetDir = $_ENV['UPLOADS_DIR'].$dir;
        $fileExt = explode('.',$fileName);
        $fileExt = $fileExt[count($fileExt) - 1];
        $uniqName = uniqid().'.'.$fileExt;
        if(move_uploaded_file($fileTmpName,$targetDir.$uniqName)){
            return $uniqName;
        }else{
            return false;
        }
    }

    /**
     * Method to delete file
     * @param string $file
     * @param string $dir
     */
    public static function deleteFile($file,$dir){
        $targetDir = $_ENV['UPLOADS_DIR'].$dir;
        @unlink($targetDir.$file);
    }

    /**
     * Method to return a list of datas
     * @param string $table
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getList($table = '',$where = null, $order = null, $limit = null, $fields = '*'){
        return(new Database($table))->select($where,$order,$limit,$fields);
    }

    /**
     * Method to return a row of data
     * @param string $table
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getRow($table = '',$where = null, $order = null, $limit = null, $fields = '*'){
        return(new Database($table))->select($where,$order,$limit,$fields);
    }
    
}