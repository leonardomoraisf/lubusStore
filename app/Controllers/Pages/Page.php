<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Page
{

    /**
     * Método que retorna o header
     * @return string
     */
    public static function getHeader(){
        return View::render('views/includes/header', [
        ]);
    }

    /**
     * Método que retorna a sidebar
     * @return string
     */
    public static function getSidebar(){
        return View::render('views/includes/sidebar', [
        ]);
    }

     /**
     * Método que retorna o footer
     * @return string
     */
    public static function getFooter(){
        return View::render('views/includes/footer', [
        ]);
    }

     /**
     * Método que retorna os links
     * @return string
     */
    public static function getLinks(){
        return View::render('views/includes/links', [
        ]);
    }

    /**
     * Método que retorna o preloader
     * @return string
     */
    public static function getPreLoader(){
        return View::render('views/includes/preloader', [
        ]);
    }

     /**
     * Método que retorna os links de script
     * @return string
     */
    public static function getScriptLinks(){
        return View::render('views/includes/scriptlinks', [
        ]);
    }

    public static function getFullPage($page = []){
        $page['footer'] = self::getFooter();
        $page['header'] = self::getHeader();
        $page['links'] = self::getLinks();
        $page['scriptlinks'] = self::getScriptLinks();
        $page['sidebar'] = self::getSidebar();
        $page['preloader'] = self::getPreLoader();
        return $page;
    }

}
