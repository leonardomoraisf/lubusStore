<?php

namespace App\Controller\Api;

use App\Model\Entity\Category as EntityCategory;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Utils\Utilities;
use \Exception;

class Category extends Api
{

    /**
     * Method to catch categories
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getCategoryItems($request, &$obPagination)
    {
        // Categories
        $itens = [];

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
            $itens[] = [
                'id' => (int)$obCategories->id,
                'name' => $obCategories->name,
                'description' => $obCategories->description,
                'date' => $obCategories->date,
                'img' => $obCategories->img,
            ];

        return $itens;
    }

    /**
     * Method to return registered Categories 
     * @param Request $request
     * @return array
     */
    public static function getCategories($request)
    {
        return [
            'categories' => self::getCategoryItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
        ];
    }

    /**
     * Method to return one category details
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getCategory($request, $id)
    {
        // VERIFY CATEGORY ID
        if (!is_numeric($id)) {
            throw new Exception("The id '" . $id . "' is not valid.", 400);
        }

        // SEARCH CATEGORY
        $obCategory = EntityCategory::getCategoryById($id);

        // VERIFY IS EXISTS
        if (!$obCategory instanceof EntityCategory) {
            throw new Exception("Category " . $id . " not found.", 404);
        }

        // RETURN CATEGORY DETAILS
        return [
            'id' => (int)$obCategory->id,
            'name' => $obCategory->name,
            'description' => $obCategory->description,
            'date' => $obCategory->date,
            'img' => $obCategory->img,
        ];
    }

    /**
     * Method to register new category
     * @param Request $request
     */
    public static function setNewCategory($request)
    {

        $obUtilities = new Utilities;

        // POST VARS
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        // VALIDATIONS
        if (!isset($postVars['name']) or !isset($postVars['description'])) {
            throw new Exception("Fields 'name' and 'description' is mandatory!", 400);
        }
        if ($postVars['name'] == '' or $postVars['description'] == '') {
            throw new Exception("Fields 'name' and 'description' is mandatory!", 400);
        }
        if (strlen($postVars['description']) > 280) {
            throw new Exception("Maximum 280 characters in the 'description' field!", 400);
        }
        if (empty($postFiles['image']['tmp_name'])) {
            throw new Exception("The category needs an image! Field name = 'image'", 400);
        }

        // SEARCH Category by name
        $dbCategory = EntityCategory::getCategoryByName($postVars['name']);
        if ($dbCategory instanceof EntityCategory) {
            throw new Exception("A category with that name already exists!", 400);
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($postFiles['image'])) {
            $upload = $obUtilities->uploadFile($postFiles['image'], 'categories/');
        } else {
            throw new Exception("Sorry, the image size or type is not permitted!", 400);
        }

        // NEW CATEGORIE INSTANCE
        $obCategory = new EntityCategory;

        $obCategory->register($upload, $postVars['name'], $postVars['description']);

        // RETURN DETAILS OF REGISTERED CATEGORY
        return [
            'id' => (int)$obCategory->id,
            'name' => $obCategory->name,
            'description' => $obCategory->description,
            'date' => $obCategory->date,
            'img' => $obCategory->img,
        ];
    }

    /**
     * Method to update a category
     * @param Request $request
     * @param integer $id
     */
    public static function setEditCategory($request, $id)
    {

        $obCategory = EntityCategory::getCategoryById($id);
        if (!$obCategory instanceof EntityCategory) {
            throw new Exception("Category " . $id . " not found.", 404);
        }

        // POST VARS
        $postVars = $request->getPostVars();

        if (!isset($postVars['name']) || !isset($postVars['description'])) {
            throw new Exception("Fields 'name' and 'description' is mandatory!", 400);
        }
        if ($postVars['name'] == '' or $postVars['description'] == '') {
            throw new Exception("Fields 'name' and 'description' is mandatory!", 400);
        }
        if (strlen($postVars['description']) > 280) {
            throw new Exception("Maximum 280 characters in the 'description' field!", 400);
        }

        if ($postVars['name'] != $obCategory->name) {

            // SEARCH Category by name
            $dbCategory = EntityCategory::getCategoryByName($postVars['name']);
            if ($dbCategory instanceof EntityCategory) {
                throw new Exception("A category with that name already exists!", 400);
            }

            $obCategory->updateWithoutImg($postVars['name'], $postVars['description']);

            // RETURN DETAILS OF EDITED CATEGORY
            return [
                'id' => (int)$obCategory->id,
                'name' => $obCategory->name,
                'description' => $obCategory->description,
                'date' => $obCategory->date,
                'img' => $obCategory->img,
            ];
        }

        $obCategory->updateWithoutImg($postVars['name'], $postVars['description']);

        // RETURN DETAILS OF EDITED CATEGORY
        return [
            'id' => (int)$obCategory->id,
            'name' => $obCategory->name,
            'description' => $obCategory->description,
            'date' => $obCategory->date,
            'img' => $obCategory->img,
        ];
    }

    /**
     * Method to return post delete and delete category
     * @param Request $request
     * @param integer $id
     */
    public static function setDeleteCategory($request, $id)
    {
        // CATCH CATEGORY
        $obCategory = EntityCategory::getCategoryById($id);
        if (!$obCategory instanceof EntityCategory) {
            throw new Exception("Category " . $id . " not found.", 404);
        }

        // DELETE CATEGORY
        $obCategory->delete();

        // RETURN DELETE SUCCESS
        return [
            'success' => true,
        ];
    }
}
