<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Utilities;

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
        $unique_visitors_today = Utilities::getList('`tb_users.visits`','date = '.strtotime(date('Y-m-d')), null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        $unique_visitors = Utilities::getList('`tb_users.visits`', null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        $users_regs = Utilities::getList('`tb_users`', null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        parent::getObUser($obUser);
        $elements = parent::getElements();
        return View::render('views/admin/home', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Dashboard',
            'user_name' => $obUser->name,
            'user_img' => UPLOADS . '/admin_users/' . $obUser->img,
            'user_position' => $obUser->catchPosition($obUser->position),
            'box_new_orders' => $box_new_orders,
            'box_today_unique_visitors' => $box_today_unique_visitors,
            'box_unique_visitors' => $box_unique_visitors,
            'box_user_regs' => $box_user_regs,
            'unique_visitors_today' => $unique_visitors_today,
            'unique_visitors' => $unique_visitors,
            'users_regs' => $users_regs,
        ]);
    }

}
