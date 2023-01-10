<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class AdminUser{

    /**
     * Admin user id
     * @var integer
     */
    public $id;

    /**
     * Username
     * @var string
     */
    public $user;

    /**
     * User password
     * @var string
     */
    public $password;

    /**
     * User name
     * @var string
     */
    public $name;

    /**
     * User email
     * @var string
     */
    public $email;

     /**
     * User position
     * @var integer
     */
    public $position;

    /**
     * User image name
     * @var string
     */
    public $img;

    /**
     * Method to return an user using the username
     * @param string $user
     * @return User
     */
    public static function getAdminUserByUser($user){
        return (new Database('`tb_admin.users`'))->select('user = "'.$user.'"')->fetchObject(self::class);
    }

    /**
     * Method to return an user using the username
     * @param string $id
     * @return User
     */
    public static function getAdminUserById($id){
        return (new Database('`tb_admin.users`'))->select('id = "'.$id.'"')->fetchObject(self::class);
    }

}