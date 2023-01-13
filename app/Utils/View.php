<?php

namespace App\Utils;

class View{

    /**
     * Default vars of view
     * @var array
     */
    private static $vars = [];

    /**
     * Method to define init data of class
     */
    public static function init($vars = []){
        self::$vars = $vars;
    }

    /**
     * Método que retorna o conteúdo da view
     * @param string $view
     * @return string
     */
    private static function getContentView($view){

        $file = __DIR__.'/../../resources/'.$view.'.php';
        return file_exists($file) ? file_get_contents($file) : '';

    }

    /**
     * Método que retorna o conteúdo renderizado da view
     * @param string $view
     * @param array $params (string/numeric)
     * @return string
     */
    public static function render($view, $vars = []){

        // VIEW CONTENT
        $contentView = self::getContentView($view);

        // MERGE VARS OF VIEW
        $vars = array_merge(self::$vars,$vars);

        //ARRAY KEYS
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        // RETURN RENDERED CONTENT
        return str_replace($keys,array_values($vars),$contentView);

    }
}