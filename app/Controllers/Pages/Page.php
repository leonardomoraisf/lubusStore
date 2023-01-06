<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Page
{
    /**
     * Método que retorna a view
     * @return string
     */
    public static function getPage($links,$script_links,$preloader,$header,$sidebar,$footer,$content)
    {
        $links = View::render('includes/'.$links);
        $script_links = View::render('includes/'.$script_links);
        $preloader = View::render('includes/'.$preloader);
        $sidebar = View::render('includes/'.$sidebar);
        $footer = View::render('includes/'.$footer);
        $header = View::render('includes/'.$footer);
        return View::render('pages/page', [
            'links' => $links,
            'script_links' => $script_links,
            'preloader' => $preloader,
            'sidebar' => $sidebar,
            'footer' => $footer,
            'header' => $header,
            'content' => $content
        ]);
    }
}
