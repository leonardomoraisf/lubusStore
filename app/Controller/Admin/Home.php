<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Utils\Utilities;
use App\Utils\Users\User as UtilsUser;
use WilliamCosta\DatabaseManager\Database;
use App\Model\Entity\AdminUser as EntityUser;

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
        $unique_visitors_today = UtilsUser::countTodayVisits();
        $unique_visitors = (new Database('`tb_users.visits`'))->select(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        $users_regs = (new Database('`tb_users`'))->select(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        $elements = parent::getElements();
        return View::render('views/admin/home', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Dashboard',
            'user_name' => $_SESSION['admin']['user']['name'],
            'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
            'user_position' => EntityUser::$positions[$_SESSION['admin']['user']['position']],
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
