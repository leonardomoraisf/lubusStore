<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Page
{
    /**
     * Método que retorna a view
     * @return string
     */
    public static function getPage($links,$script_links,$preloader,$header,$sidebar,$footer,$content,$page)
    {
        $links = View::render('views/includes/'.$links);
        $script_links = View::render('views/includes/'.$script_links);
        $header = View::render('views/includes/'.$header);
        $preloader = View::render('views/includes/'.$preloader);
        $sidebar = View::render('views/includes/'.$sidebar);
        $footer = View::render('views/includes/'.$footer);
        $footer = View::render('views/includes/'.$footer);
        return View::render('views/pages/page', [
            'links' => $links,
            'script_links' => $script_links,
            'preloader' => $preloader,
            'sidebar' => $sidebar,
            'footer' => $footer,
            'header' => $header,
            'content' => $content,
            'page' => $page
        ]);
    }
}
