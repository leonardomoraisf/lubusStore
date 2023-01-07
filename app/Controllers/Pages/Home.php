<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Home extends Page
{
    /**
     * Método que retorna a view
     * @return string
     */
    public static function getHome()
    {   
        $box_new_orders = View::render('views/includes/home/box_new-orders');
        $box_today_unique_visitors = View::render('views/includes/home/box_today-unique-visitors');
        $box_unique_visitors = View::render('views/includes/home/box_unique-visitors');
        $box_user_regs = View::render('views/includes/home/box_user-registrations');
        $fullPage = parent::getFullPage();
        return View::render('views/pages/home', [
            'preloader' => $fullPage['preloader'],
            'links' => $fullPage['links'],
            'sidebar' => $fullPage['sidebar'],
            'header' => $fullPage['header'],
            'footer' => $fullPage['footer'],
            'scriptlinks' => $fullPage['scriptlinks'],
            'title' => 'Dashboard',
            'box_new_orders' => $box_new_orders,
            'box_today_unique_visitors' => $box_today_unique_visitors,
            'box_unique_visitors' => $box_unique_visitors,
            'box_user_regs' => $box_user_regs,
        ]);
    }

}
