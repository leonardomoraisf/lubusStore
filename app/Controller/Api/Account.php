<?php

namespace App\Controller\Api;

use App\Model\Entity\AdminUser as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Utils\Utilities;
use App\Utils\Bcrypt;
use \Exception;

class Account extends Api
{

    /**
     * Method to catch users
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItems($request, &$obPagination)
    {
        // Categories
        $itens = [];

        // TOTAL REG QUANTITY
        $totalQuantity = Utilities::getList('`tb_admin.users`', null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        // ACTUAL PAGE
        $queryParams = $request->getQueryParams();
        $actualPage = $queryParams['page'] ?? 1;

        // PAGINATION INSTANCE
        $obPagination = new Pagination($totalQuantity, $actualPage, 5);

        // RESULTS
        $results = Utilities::getList('`tb_admin.users`', null, 'id DESC', $obPagination->getLimit());

        // RENDER ITEM
        while ($obUser = $results->fetchObject(EntityUser::class))
            $itens[] = [
                'id' => (int)$obUser->id,
                'name' => $obUser->name,
                'email' => $obUser->email,
                'position' => $obUser->catchPosition($obUser->position),
            ];

        return $itens;
    }

    /**
     * Method to return registered Users
     * @param Request $request
     * @return array
     */
    public static function getUsers($request)
    {
        return [
            'admin_users' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
        ];
    }

    /**
     * Method to return one category details
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getUser($request, $id)
    {
        // VERIFY CATEGORY ID
        if (!is_numeric($id)) {
            throw new Exception("The id '" . $id . "' is not valid.", 400);
        }

        // SEARCH CATEGORY
        $obUser = EntityUser::getAdminUserById($id);

        // VERIFY IS EXISTS
        if (!$obUser instanceof EntityUser) {
            throw new Exception("User " . $id . " not found.", 404);
        }

        // RETURN CATEGORY DETAILS
        return [
            'id' => (int)$obUser->id,
            'name' => $obUser->name,
            'email' => $obUser->email,
            'position' => $obUser->catchPosition($obUser->position),
        ];
    }

    /**
     * Method to return post register user
     * @param Request $request
     */
    public static function setNewAccount($request)
    {

        $obUtilities = new Utilities;

        // POST DATA
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        // VALIDATIONS
        if (!isset($postVars['user']) or !isset($postVars['name']) or !isset($postVars['email']) or !isset($postVars['password']) or !isset($postVars['position'])) {
            throw new Exception("There are empty fields! Fields: 'user', 'name', 'email', 'password', 'position', 'image'.", 400);
        }
        if ($postVars['user'] == '' or $postVars['name'] == '' or $postVars['email'] == '' or $postVars['password'] == '' or $postVars['position'] == '') {
            throw new Exception("There are empty fields! Fields: 'user', 'name', 'email', 'password', 'position', 'image'.", 400);
        }
        if (filter_var($postVars['email'], FILTER_VALIDATE_EMAIL) == false) {
            throw new Exception("This email is not valid", 400);
        }
        if (strlen($postVars['password']) < 6) {
            throw new Exception("The password must contain at least 6 characters!", 400);
        }
        if (empty($postFiles['image'])) {
            throw new Exception("The user needs an image! Field : 'image'.", 400);
        }

        // SEARCH ADMIN USER BY USER
        $dbAdminUser = EntityUser::getAdminUserByUser($postVars['user']);
        if ($dbAdminUser instanceof EntityUser) {
            throw new Exception("An account with that username already exists!", 400);
        }

        // SEARCH ADMIN USER BY EMAIL
        $dbAdminUser = EntityUser::getAdminUserByEmail($postVars['email']);
        if ($dbAdminUser instanceof EntityUser) {
            throw new Exception("An account with that email already exists!", 400);
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($postFiles['image'])) {
            $upload = $obUtilities->uploadFile($postFiles['image'], 'admin_users/');
        } else {
            throw new Exception("Sorry, the image size or type is not permited!", 400);
        }

        // NEW CATEGORIE INSTANCE
        $obAdminUser = new EntityUser;

        $obAdminUser->name = $postVars['name'];
        $obAdminUser->user = $postVars['user'];
        $obAdminUser->email = $postVars['email'];
        $obAdminUser->password = Bcrypt::hash($postVars['password']);
        $obAdminUser->position = $postVars['position'];
        $obAdminUser->img = $upload;

        $obAdminUser->register();

        // RETURN DETAILS OF REGISTERED USER
        return [
            'id' => (int)$obAdminUser->id,
            'user' => $obAdminUser->user,
            'name' => $obAdminUser->name,
            'email' => $obAdminUser->email,
            'position' => $obAdminUser->catchPosition($obAdminUser->position),
        ];
    }

    public static function setEditAccount($request, $id)
    {

        $obUser = EntityUser::getAdminUserById($id);
        if (!$obUser instanceof EntityUser) {
            throw new Exception("User " . $id . " not found.", 404);
        }

        // POST DATA
        $postVars = $request->getPostVars();

        // VALIDATIONS
        if (!isset($postVars['user']) || !isset($postVars['name']) || !isset($postVars['email']) || !isset($postVars['password']) || !isset($postVars['position'])) {
            throw new Exception("There are empty fields! Fields: 'user', 'name', 'email', 'password'.", 400);
        }
        if ($postVars['user'] == '' or $postVars['name'] == '' or $postVars['email'] == '' or $postVars['password'] == '' or $postVars['position'] == '') {
            throw new Exception("There are empty fields! Fields: 'user', 'name', 'email', 'password'.", 400);
        }
        if (filter_var($postVars['email'], FILTER_VALIDATE_EMAIL) == false) {
            throw new Exception("This email is not valid", 400);
        }
        if (strlen($postVars['password']) < 6) {
            throw new Exception("The password must contain at least 6 characters!", 400);
        }

        if ($postVars['user'] != $obUser->user) {

            // SEARCH ADMIN USER BY USER
            $dbAdminUser = EntityUser::getAdminUserByUser($postVars['user']);
            if ($dbAdminUser instanceof EntityUser) {
                throw new Exception("An account with that username already exists!", 400);
            }

            $obUser->user = $postVars['user'];
            $obUser->name = $postVars['name'];
            $obUser->email = $postVars['email'];
            $obUser->password = Bcrypt::hash($postVars['password']);
            $obUser->position = $postVars['position'];

            $obUser->apiUpdate();

            // RETURN DETAILS OF REGISTERED USER
            return [
                'id' => (int)$obUser->id,
                'user' => $obUser->user,
                'name' => $obUser->name,
                'email' => $obUser->email,
                'position' => $obUser->catchPosition($obUser->position),
            ];

        } else if ($postVars['email'] != $obUser->email) {

            // SEARCH ADMIN USER BY EMAIL
            $dbAdminUser = EntityUser::getAdminUserByEmail($postVars['email']);
            if ($dbAdminUser instanceof EntityUser) {
                throw new Exception("An account with that email already exists!", 400);
            }

            $obUser->user = $postVars['user'];
            $obUser->name = $postVars['name'];
            $obUser->email = $postVars['email'];
            $obUser->password = Bcrypt::hash($postVars['password']);
            $obUser->position = $postVars['position'];

            $obUser->apiUpdate();

            // RETURN DETAILS OF REGISTERED USER
            return [
                'id' => (int)$obUser->id,
                'user' => $obUser->user,
                'name' => $obUser->name,
                'email' => $obUser->email,
                'position' => $obUser->catchPosition($obUser->position),
            ];
        }

        $obUser->user = $postVars['user'];
        $obUser->name = $postVars['name'];
        $obUser->email = $postVars['email'];
        $obUser->password = Bcrypt::hash($postVars['password']);
        $obUser->position = $postVars['position'];

        $obUser->apiUpdate();

        // RETURN DETAILS OF REGISTERED USER
        return [
            'id' => (int)$obUser->id,
            'user' => $obUser->user,
            'name' => $obUser->name,
            'email' => $obUser->email,
            'position' => $obUser->catchPosition($obUser->position),
        ];
    }

    public static function setDeleteAccount($request, $id)
    {
        $obUser = EntityUser::getAdminUserById($id);
        if (!$obUser instanceof EntityUser) {
            throw new Exception("User " . $id . " not found.", 404);
        }

        // DELETE USER
        $obUser->delete();

        // RETURN DELETE SUCCESS
        return [
            'success' => true,
        ];
    }

    /**
     * Method to return the actual user connected
     * @param Request $request
     * @return array
     */
    public static function getCurrentUser($request){
        // ACTUAL USER
        $obUser = $request->user;
        // RETURN DETAILS OF REGISTERED USER
        return [
            'id' => (int)$obUser->id,
            'user' => $obUser->user,
            'name' => $obUser->name,
            'email' => $obUser->email,
            'position' => $obUser->catchPosition($obUser->position),
        ];

    }

}
