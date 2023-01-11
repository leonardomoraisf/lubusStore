<?php

namespace App\Utils\Users;

use WilliamCosta\DatabaseManager\Database;


class User
{

    /**
     * Method to return how many today visits has in db
     * @return integer
     */
    public static function countTodayVisits()
    {
        $conn = (new Database('`tb_users.visits`'))->setConnection();
        $date = date('Y-m-d');
        $count = $conn->prepare("SELECT * FROM `tb_users.visits` WHERE date = ?");
        $count->execute(array($date));
        return $count->rowCount();
    }
}
