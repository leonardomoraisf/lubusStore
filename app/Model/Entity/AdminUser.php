<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;
use App\Utils\Utilities;

class AdminUser
{

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
     * @var string
     */
    public $position;

    /**
     * User image name
     * @var string
     */
    public $img;

    /**
     * Positions of Admins
     * @var array
     */
    public static $positions = [
        '1' => 'Manager',
        '2' => 'Administrator',
        '3' => 'CEO'
    ];

    /**
     * Method to return an user using the username
     * @param string $user
     * @return User
     */
    public static function getAdminUserByUser($user)
    {
        return (new Database('`tb_admin.users`'))->select('user = "' . $user . '"')->fetchObject(self::class);
    }

    /**
     * Method to return an user using the email
     * @param string $email
     * @return User
     */
    public static function getAdminUserByEmail($email)
    {
        return (new Database('`tb_admin.users`'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Method to return an user using the username
     * @param string $id
     * @return User
     */
    public static function getAdminUserById($id)
    {
        return (new Database('`tb_admin.users`'))->select('id = "' . $id . '"')->fetchObject(self::class);
    }

    public static function getPositions()
    {
        return self::$positions;
    }

    public static function catchPosition($position)
    {
        return self::$positions[$position];
    }

    /**
     * Register Account method
     */
    public function register()
    {
        // INSERT USER ON DB
        $this->id = (new Database('`tb_admin.users`'))->insert([
            'user' => $this->user,
            'password' => $this->password,
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
            'img' => $this->img
        ]);

        return true;
    }

    public function update()
    {
        // UPDATE USER
        return (new Database('`tb_admin.users`'))->update('id = ' . $this->id, [
            'user' => $this->user,
            'password' => $this->password,
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
            'img' => $this->img
        ]);
    }

    /**
     * Method to delete in db with the actual instance
     */
    public function delete()
    {
        Utilities::deleteFile($this->img, 'admin_users/');
        // DELETE CATEGORY
        return (new Database('`tb_admin.users`'))->delete('id = ' . $this->id);
    }
}
