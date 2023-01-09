<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Home extends Page
{
    /**
     * Method to return home view
     * @return string
     */
    public static function getHome()
    {   
        $box_new_orders = View::render('views/admin/includes/home/box_new-orders');
        $box_today_unique_visitors = View::render('views/admin/includes/home/box_today-unique-visitors');
        $box_unique_visitors = View::render('views/admin/includes/home/box_unique-visitors');
        $box_user_regs = View::render('views/admin/includes/home/box_user-registrations');
        $elements = parent::getElements();
        return View::render('views/admin/home', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Dashboard',
            'box_new_orders' => $box_new_orders,
            'box_today_unique_visitors' => $box_today_unique_visitors,
            'box_unique_visitors' => $box_unique_visitors,
            'box_user_regs' => $box_user_regs,
        ]);
    }

}
