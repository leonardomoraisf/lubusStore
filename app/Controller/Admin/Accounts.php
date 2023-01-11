<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Model\Entity\AdminUser as EntityUser;
use App\Utils\View;
use App\Utils\Utilities;
use App\Utils\Bcrypt;

class Accounts extends Page
{

    /**
     * Method to catch items render
     * @param Request $request
     * @return string
     */
    private static function getPositionsItems($request)
    {

        // Positions
        $itens = '';

        // RESULTS
        $results = EntityUser::getPositions();

        foreach ($results as $key => $value) {
            $itens .= View::render('views/admin/includes/account/item', [
                'position_value' => $key,
                'position_name' => $value,
            ]);
        }

        return $itens;
    }

    /**
     * Method to return view
     * @param Request $request
     * @return string
     */
    public static function getFormAccount($request, $errorMessage = null, $successMessage = null)
    {
        $statusError = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $statusSuccess = !is_null($successMessage) ? Alert::getSuccess($successMessage) : '';

        $elements = parent::getElements();
        return View::render('views/admin/forms_account', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'New Account',
            'active_forms_account' => 'active',
            'active_forms' => 'active',
            'menu_open_forms' => 'menu-open',
            'statusError' => $statusError,
            'statusSuccess' => $statusSuccess,
            'positions' => self::getPositionsItems($request),
            'user_name' => $_SESSION['admin']['user']['name'],
            'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
            'user_position' => EntityUser::catchPosition($_SESSION['admin']['user']['position']),
        ]);
    }

    /**
     * Method to return post register user
     * @param Request $request
     */
    public static function setFormAccount($request)
    {
        
        $obUtilities = new Utilities;

        // POST DATA
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        $user = $postVars['user'];
        $name = $postVars['name'];
        $email = $postVars['email'];
        $password = $postVars['password'];
        $confirmPassword = $postVars['confirmPassword'];
        $position = $postVars['position'];
        $img = $postFiles['file'];

        // VALIDATIONS
        if ($user == '' || $name == '' || $email == '' || $password == '' || $confirmPassword == '' || $position == '') {
            return self::getFormAccount($request, "There are empty fields!");
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return self::getFormAccount($request, "This email is not valid");
        }
        if (strlen($password) < 6) {
            return self::getFormAccount($request, "The password must contain at least 6 characters!");
        }
        if ($password != $confirmPassword) {
            return self::getFormAccount($request, "Passwords do not match!");
        }
        if (empty($img['tmp_name'])) {
            return self::getFormAccount($request, "The user needs an image!");
        }

        // SEARCH ADMIN USER BY USER
        $dbAdminUser = EntityUser::getAdminUserByUser($user);
        if ($dbAdminUser instanceof EntityUser) {
            return self::getFormAccount($request, "An account with that username already exists!");
        }

        // SEARCH ADMIN USER BY EMAIL
        $dbAdminUser = EntityUser::getAdminUserByEmail($email);
        if ($dbAdminUser instanceof EntityUser) {
            return self::getFormAccount($request, "An account with that email already exists!");
        }

        if ($position > $_SESSION['admin']['user']['position']) {
            return self::getFormAccount($request, "You cannot register an account with a position higher than yours!");
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($img)) {
            $upload = $obUtilities->uploadFile($img, 'admin_users/');
        } else {
            return self::getFormAccount($request, "Sorry, the image size or type is not permited!");
        }

        // NEW CATEGORIE INSTANCE
        $obAdminUser = new EntityUser;

        $obAdminUser->name = $name;
        $obAdminUser->user = $user;
        $obAdminUser->email = $email;
        $obAdminUser->password = Bcrypt::hash($password);
        $obAdminUser->position = $position;
        $obAdminUser->img = $upload;

        $obAdminUser->register();

        return self::getFormAccount($request, null, "Account registered sucefully!");

    }
}
