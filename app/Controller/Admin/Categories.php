<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Category as EntityCategory;
use App\Model\Entity\AdminUser;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Utils\Utilities;

class Categories extends Page
{

    public static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // STATUS
        if (!isset($queryParams['status'])) return '';

        // STATUS MESSAGES
        switch ($queryParams['status']) {
            case 'deleted':
                return Alert::getSuccess("Category deleted successfully!");
                break;
        }
    }

    /**
     * Method to catch items render
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getCategoryItems($request, &$obPagination)
    {
        // Categories
        $itens = '';

        // TOTAL REG QUANTITY
        $totalQuantity = Utilities::getList('`tb_categories`', null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        // ACTUAL PAGE
        $queryParams = $request->getQueryParams();
        $actualPage = $queryParams['page'] ?? 1;

        // PAGINATION INSTANCE
        $obPagination = new Pagination($totalQuantity, $actualPage, 5);

        // RESULTS
        $results = Utilities::getList('`tb_categories`', null, 'id DESC', $obPagination->getLimit());

        // RENDER ITEM
        while ($obCategories = $results->fetchObject(EntityCategory::class))
            $itens .= View::render('views/admin/includes/categories/item', [
                'cat_id' => $obCategories->id,
                'cat_name' => $obCategories->name,
                'cat_description' => $obCategories->description,
                'cat_date' => date('d/m/Y', strtotime($obCategories->date)),
                'cat_img' => UPLOADS . '/categories/' . $obCategories->img,
            ]);

        return $itens;
    }

    /**
     * Method to return view
     * @param Request $request
     * @return string
     */
    public static function getCategories($request)
    {
        parent::getObUser($obUser);
        $elements = parent::getElements();
        return View::render('views/admin/categories', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Categories',
            'itens' => self::getCategoryItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'active_categories' => 'active',
            'user_name' => $obUser->name,
            'user_img' => UPLOADS . '/admin_users/' . $obUser->img,
            'status' => self::getStatus($request),
        ]);
    }

    /**
     * Method to return form categorie view
     * @return string
     */
    public static function getFormCategory($request, $errorMessage = null, $successMessage = null)
    {

        $statusError = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $statusSuccess = !is_null($successMessage) ? Alert::getSuccess($successMessage) : '';

        parent::getObUser($obUser);
        $elements = parent::getElements();
        return View::render('views/admin/forms_categorie', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'New Category',
            'menu_open_forms' => 'menu-open',
            'active_forms' => 'active',
            'active_forms_category' => 'active',
            'statusError' => $statusError,
            'statusSuccess' => $statusSuccess,
            'user_name' => $obUser->name,
            'user_img' => UPLOADS . '/admin_users/' . $obUser->img,
        ]);
    }

    /**
     * Method to register a new categorie
     * @param Request $request
     * @return string
     */
    public static function setFormCategory($request)
    {

        $obUtilities = new Utilities;

        // POST DATA
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        $name = $postVars['name'];
        $description = $postVars['description'];
        $img = $postFiles['file'];

        // VALIDATIONS
        if ($name == '' || $description == '') {
            return self::getFormCategory($request, "There are empty fields!");
        }
        if (strlen($description) > 280) {
            return self::getFormCategory($request, "Maximum of 280 characters!");
        }
        if (empty($img['tmp_name'])) {
            return self::getFormCategory($request, "The categorie needs an image!");
        }

        // SEARCH Category by name
        $dbCategory = EntityCategory::getCategoryByName($name);
        if ($dbCategory instanceof EntityCategory) {
            return self::getFormCategory($request, "A categorie with that name already exists!");
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($img)) {
            $upload = $obUtilities->uploadFile($img, 'categories/');
        } else {
            return Categories::getFormCategory($request, "Sorry, the image size or type is not permited!");
        }

        // NEW CATEGORIE INSTANCE
        $obCategorie = new EntityCategory;

        $obCategorie->register($upload, $name, $description);

        return self::getFormCategory($request, null, "Category registered sucefully!");
    }

    /**
     * Method to return view
     * @return string
     */
    public static function getEditCategory($request, $cat_id, $errorMessage = null, $successMessage = null)
    {
        $statusError = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $statusSuccess = !is_null($successMessage) ? Alert::getSuccess($successMessage) : '';

        $obCategory = EntityCategory::getCategoryById($cat_id);
        if (!$obCategory instanceof EntityCategory) {
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/dashboard/categories');
        } else {
            parent::getObUser($obUser);
            $elements = parent::getElements();
            return View::render('views/admin/edit_category', [
                'preloader' => $elements['preloader'],
                'links' => $elements['links'],
                'sidebar' => $elements['sidebar'],
                'header' => $elements['header'],
                'footer' => $elements['footer'],
                'scriptlinks' => $elements['scriptlinks'],
                'title' => $obCategory->name,
                'cat_name' => $obCategory->name,
                'cat_description' => $obCategory->description,
                'cat_img' => UPLOADS . '/categories/' . $obCategory->img,
                'active_categories' => 'active',
                'statusError' => $statusError,
                'statusSuccess' => $statusSuccess,
                'user_name' => $obUser->name,
                'user_img' => UPLOADS . '/admin_users/' . $obUser->img,
            ]);
        }
    }

    public static function setEditCategory($request, $cat_id)
    {

        $obUtilities = new Utilities;

        $obCategorie = EntityCategory::getCategoryById($cat_id);
        if (!$obCategorie instanceof EntityCategory) {
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/dashboard/categories');
        }

        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        $name = $postVars['name'];
        $description = $postVars['description'];
        $img = $postFiles['file'];

        if ($img['tmp_name'] == '') {

            if ($name == '' || $description == '') {
                return self::getEditCategory($request, $cat_id, "There are empty fields!");
            }
            if (strlen($description) > 280) {
                return self::getEditCategory($request, $cat_id, "Maximum of 280 characters!");
            }

            if ($name != $obCategorie->name) {

                // SEARCH Category by name
                $dbCategory = EntityCategory::getCategoryByName($name);
                if ($dbCategory instanceof EntityCategory) {
                    return self::getEditCategory($request, $cat_id, "A category with that name already exists!");
                }

                $obCategorie->updateWithoutImg($name, $description);

                // REDIRECT
                return self::getEditCategory($request, $cat_id, null, "Category updated successfully!");
            }

            $obCategorie->updateWithoutImg($name, $description);

            // REDIRECT
            return self::getEditCategory($request, $cat_id, null, "Category updated successfully!");
            
        } else {


            if ($name == '' || $description == '') {
                return self::getEditCategory($request, $cat_id, "There are empty fields!");
            }
            if (strlen($description) > 280) {
                return self::getEditCategory($request, $cat_id, "Maximum of 280 characters!");
            }

            if ($name != $obCategorie->name) {

                // SEARCH Category by name
                $dbCategory = EntityCategory::getCategoryByName($name);
                if ($dbCategory instanceof EntityCategory) {
                    return self::getEditCategory($request, $cat_id, "A category with that name already exists!");
                }

                // IMAGE VALIDATION
                if ($obUtilities->validateImage($img)) {
                    $upload = $obUtilities->uploadFile($img, 'categories/');
                } else {
                    return Categories::getEditCategory($request, $cat_id, "Sorry, the image size or type is not permited!");
                }

                $obCategorie->updateWithImg($obCategorie->img, $name, $description, $upload);

                // REDIRECT
                return self::getEditCategory($request, $cat_id, null, "Category updated successfully!");
            }

            // IMAGE VALIDATION
            if ($obUtilities->validateImage($img)) {
                $upload = $obUtilities->uploadFile($img, 'categories/');
            } else {
                return Categories::getEditCategory($request, $cat_id, "Sorry, the image size or type is not permited!");
            }

            $obCategorie->updateWithImg($obCategorie->img, $name, $description, $upload);

            // REDIRECT
            return self::getEditCategory($request, $cat_id, null, "Category updated successfully!");

        }
    }

    /**
     * Method to return delete categorie view
     * @return string
     */
    public static function getDeleteCategory($request, $cat_id)
    {
        if ($cat_id == '') {
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/dashboard/categories');
        }
        $obCategory = EntityCategory::getCategoryById($cat_id);
        if (!$obCategory instanceof EntityCategory) {
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/dashboard/categories');
        } else {
            parent::getObUser($obUser);
            $elements = parent::getElements();
            return View::render('views/admin/delete_category', [
                'preloader' => $elements['preloader'],
                'links' => $elements['links'],
                'sidebar' => $elements['sidebar'],
                'header' => $elements['header'],
                'footer' => $elements['footer'],
                'scriptlinks' => $elements['scriptlinks'],
                'title' => 'Confirm Delete',
                'cat_name' => $obCategory->name,
                'cat_img' => UPLOADS . '/categories/' . $obCategory->img,
                'active_categories' => 'active',
                'user_name' => $obUser->name,
                'user_img' => UPLOADS . '/admin_users/' . $obUser->img,
            ]);
        }
    }

    /**
     * Method to return post delete and delete category
     * @param Request $request
     * @param integer $cat_id
     */
    public static function setDeleteCategory($request, $cat_id)
    {
        // CATCH CATEGORY
        $obCategory = EntityCategory::getCategoryById($cat_id);

        // INSTANCE VALIDATOR
        if (!$obCategory instanceof EntityCategory) {
            $request->getRouter()->redirect('/dashboard/categories');
        }

        // DELETE CATEGORY
        $obCategory->delete();

        // REDIRECT
        $request->getRouter()->redirect('/dashboard/categories?status=deleted');
    }
}
