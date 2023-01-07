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
        $content = View::render('views/pages/home', [
            'box_new_orders' => $box_new_orders,
            'box_today_unique_visitors' => $box_today_unique_visitors,
            'box_unique_visitors' => $box_unique_visitors,
            'box_user_regs' => $box_user_regs
        ]);
        return parent::getPage('links','script_links','preloader','header','sidebar','footer',$content,'home');
    }
}
