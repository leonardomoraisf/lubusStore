<?php

namespace App\Controller\Admin;
use App\Utils\View;

class Alert{

    /**
     * Method to return a success message
     * @param string $msg
     * @return string
     */
    public static function getSuccess($msg){

        return View::render('views/admin/includes/alert/status',[
            'type' => 'success',
            'msg' => $msg,
        ]);

    }

        /**
     * Method to return a error message
     * @param string $msg
     * @return string
     */
    public static function getError($msg){

        return View::render('views/admin/includes/alert/status',[
            'type' => 'danger',
            'msg' => $msg,
        ]);

    }

}