<?php

namespace App\Controller\Admin;

use App\Utils\View;
use \App\Model\Entity\AdminUser;
use \App\Utils\Bcrypt;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{

    public static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // STATUS
        if (!isset($queryParams['status'])) return '';

        // STATUS MESSAGES
        switch ($queryParams['status']) {
            case 'double':
                return Alert::getError("There's someone on your account.");
                break;
        }
    }

    /**
     * Method to return login view
     * @param Request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        // status
        $error = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        $elements = parent::getElements();
        return View::render('views/admin/login', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'scriptlinks' => $elements['scriptlinks'],
            'status' => $error,
            'status_middle' => self::getStatus($request),
        ]);
    }

    /**
     * Method to define the user login
     * @param Request $request
     */
    public static function setLogin($request)
    {

        // POST VARS
        $postVars = $request->getPostVars();
        $user = $postVars['user'];
        $password = $postVars['password'];

        // VALIDATIONS
        if ($user == '' || $password == '') {
            return self::getLogin($request,"There are empty fields!");
        }

        // SEARCH USER BY USERNAME
        $obUser = AdminUser::getAdminUserByUser($user);
        if (!$obUser instanceof AdminUser) {
            return self::getLogin($request, "Incorrect username or password!");
        }

        /*
        if(!Bcrypt::check($password,$obUser->password)){
            return self::getLogin($request, "Incorrect username or password!");
        }
        */

        // CREATE LOGIN SESSION
        SessionAdminLogin::login($obUser);

        // REDIRECT TO HOME VIEW
        $request->getRouter()->redirect('/dashboard');

    }

    /**
     * Method to logout user
     * @param Request $request
     */
    public static function setLogout($request){

        // DESTROY USER SESSION
        SessionAdminLogin::logout();

        // REDIRECT TO LOGIN VIEW
        $request->getRouter()->redirect('/dashboard/login');

    }

}
