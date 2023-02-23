<?php

namespace App\Controller\Utils;

use App\Utils\View;

class Error extends Page{

    /**
     * Method to return 404 page
     * @param string $msg
     * @return string
     */
    public static function get404($request){

        $elements = parent::getElements();
        return View::render('views/404',[
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => '404 Error',
        ]);

    }

}