<?php

namespace App\Controller\Api;

use App\Model\Entity\Product as EntityProduct;
use App\Model\Entity\Category as EntityCategory;
use \WilliamCosta\DatabaseManager\Pagination;
use \WilliamCosta\DatabaseManager\Database;
use App\Utils\Utilities;
use \Exception;

class Product extends Api
{

    /**
     * Method to catch items render
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getProductItems($request, &$obPagination)
    {
        // Products
        $itens = [];

        // TOTAL REG QUANTITY
        $totalQuantity = (new Database('`tb_products`'))->select(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        // ACTUAL PAGE
        $queryParams = $request->getQueryParams();
        $actualPage = $queryParams['page'] ?? 1;

        // PAGINATION INSTANCE
        $obPagination = new Pagination($totalQuantity, $actualPage, 5);

        // RESULTS
        $results = (new Database('`tb_products`'))->select(null, 'id DESC', $obPagination->getLimit());

        // RENDER ITEM
        while ($obProduct = $results->fetchObject(EntityProduct::class)) {
            $obCategory = EntityCategory::getCategoryById($obProduct->cat_id);
            $itens[] = [
                'id' => (int)$obProduct->id,
                'name' => $obProduct->name,
                'description' => $obProduct->description,
                'date' => date('d/m/Y', strtotime($obProduct->date)),
                'img' => $obProduct->img,
                'price' => 'R$ ' . number_format($obProduct->price, 2, ',', ' '),
                'discount_price' => 'R$ ' . number_format($obProduct->discount_price, 2, ',', ' '),
                'category_id' => $obCategory->id,
                'category_name' => $obCategory->name,
            ];
        }

        return $itens;
    }

    /**
     * Method to return view
     * @param Request $request
     * @return string
     */
    public static function getProducts($request)
    {
        return [
            'products' => self::getProductItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
        ];
    }

    /**
     * Method to return one product details
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getProduct($request, $id)
    {
        // VERIFY PRODUCT ID
        if (!is_numeric($id)) {
            throw new Exception("The id '" . $id . "' is not valid.", 400);
        }

        // SEARCH PRODUCT
        $obProduct = EntityProduct::getProductById($id);

        // VERIFY IS EXISTS
        if (!$obProduct instanceof EntityProduct) {
            throw new Exception("Product " . $id . " not found.", 404);
        }

        $obCategory = EntityCategory::getCategoryById($obProduct->cat_id);
        // RETURN PRODUCT DETAILS
        return [
            'id' => (int)$obProduct->id,
            'name' => $obProduct->name,
            'description' => $obProduct->description,
            'date' => date('d/m/Y', strtotime($obProduct->date)),
            'img' => $obProduct->img,
            'price' => 'R$ ' . number_format($obProduct->price, 2, ',', ' '),
            'discount_price' => 'R$ ' . number_format($obProduct->discount_price, 2, ',', ' '),
            'category_id' => $obCategory->id,
            'category_name' => $obCategory->name,
        ];
    }

    /**
     * Method to register a new categorie
     * @param Request $request
     * @return string
     */
    public static function setNewProduct($request)
    {

        $obUtilities = new Utilities;

        // POST VARS
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        // VALIDATIONS
        if (!isset($postVars['name']) or !isset($postVars['description']) or !isset($postVars['price']) or !isset($postVars['discount_price']) or !isset($postVars['category_id'])) {
            throw new Exception("Fields 'name', 'description', 'price', 'discount_price', 'category_id' and 'image' is mandatory!", 400);
        }
        if ($postVars['name'] == '' or $postVars['description'] == '' or $postVars['price'] == '' or $postVars['discount_price'] == '' or $postVars['category_id'] == '') {
            throw new Exception("Fields 'name', 'description', 'price', 'discount_price', 'category_id' and 'image' is mandatory!", 400);
        }
        if (strlen($postVars['description']) > 400) {
            throw new Exception("Maximum of 400 characters in the 'description' field!", 400);
        }
        if ($postVars['price'] <= 0 || $postVars['discount_price'] <= 0) {
            throw new Exception("Prices must be positive!", 400);
        }

        // SEARCH if exists category on db
        $obCategory = EntityCategory::getCategoryById($postVars['category_id']);
        if (!$obCategory instanceof EntityCategory) {
            throw new Exception("Category with that 'category_id' = '" . $postVars['category_id'] . "' not found!", 400);
        }

        if (empty($postFiles['image']['tmp_name'])) {
            throw new Exception("The product needs an image! Field name = 'image'.", 400);
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($postFiles['image'])) {
            $upload = $obUtilities->uploadFile($postFiles['image'], 'products/');
        } else {
            throw new Exception("Sorry, the image size or type is not permitted!", 400);
        }

        // NEW PRODUCT INSTANCE
        $obProduct = new EntityProduct;

        $obProduct->name = $postVars['name'];
        $obProduct->description = $postVars['description'];
        $obProduct->price = number_format((float)$postVars['price'], 2, '.', ' ');
        $obProduct->discount_price = number_format((float)$postVars['discount_price'], 2, '.', ' ');
        $obProduct->cat_id = $obCategory->id;
        $obProduct->img = $upload;

        $obProduct->register();

        // RETURN DETAILS OF REGISTERED PRODUCT
        return [
            'id' => (int)$obProduct->id,
            'name' => $obProduct->name,
            'description' => $obProduct->description,
            'date' => date('d/m/Y', strtotime($obProduct->date)),
            'img' => $obProduct->img,
            'price' => 'R$ ' . number_format($obProduct->price, 2, ',', ' '),
            'discount_price' => 'R$ ' . number_format($obProduct->discount_price, 2, ',', ' '),
            'category_id' => $obCategory->id,
            'category_name' => $obCategory->name,
        ];
    }

    public static function setEditProduct($request, $id)
    {

        $obProduct = EntityProduct::getProductById($id);
        if (!$obProduct instanceof EntityProduct) {
            throw new Exception("Product '" . $id . "' not found.", 400);
        }

        $postVars = $request->getPostVars();

        // VALIDATIONS
        if (!isset($postVars['name']) or !isset($postVars['description']) or !isset($postVars['price']) or !isset($postVars['discount_price']) or !isset($postVars['category_id'])) {
            throw new Exception("Fields 'name', 'description', 'price', 'discount_price' and 'category_id' is mandatory!", 400);
        }
        if ($postVars['name'] == '' or $postVars['description'] == '' or $postVars['price'] == '' or $postVars['discount_price'] == '' or $postVars['category_id'] == '') {
            throw new Exception("Fields 'name', 'description', 'price', 'discount_price' and 'category_id' is mandatory!", 400);
        }
        if (strlen($postVars['description']) > 400) {
            throw new Exception("Maximum of 400 characters in the 'description' field!", 400);
        }
        if ($postVars['price'] <= 0 || $postVars['discount_price'] <= 0) {
            throw new Exception("Prices must be positive!", 400);
        }

        // SEARCH if exists category on db
        $obCategory = EntityCategory::getCategoryById($postVars['category_id']);
        if (!$obCategory instanceof EntityCategory) {
            throw new Exception("Category with that 'category_id' = '" . $postVars['category_id'] . "' not found!", 400);
        }

        $obProduct->name = $postVars['name'];
        $obProduct->description = $postVars['description'];
        $obProduct->price = number_format((double)$postVars['price'], 2, '.', ' ');
        $obProduct->discount_price = number_format((double)$postVars['discount_price'], 2, '.', ' ');
        $obProduct->cat_id = $obCategory->id;

        $obProduct->update();

        // RETURN DETAILS OF REGISTERED PRODUCT
        return [
            'id' => (int)$obProduct->id,
            'name' => $obProduct->name,
            'description' => $obProduct->description,
            'date' => date('d/m/Y', strtotime($obProduct->date)),
            'img' => $obProduct->img,
            'price' => 'R$ ' . number_format($obProduct->price, 2, ',', ' '),
            'discount_price' => 'R$ ' . number_format($obProduct->discount_price, 2, ',', ' '),
            'category_id' => $obCategory->id,
            'category_name' => $obCategory->name,
        ];
    }

    /**
     * Method to return post delete and delete product
     * @param Request $request
     * @param integer $id
     */
    public static function setDeleteProduct($request, $id)
    {
         // CATCH PRODUCT
         $obProduct = EntityProduct::getProductById($id);
         if (!$obProduct instanceof EntityProduct) {
             throw new Exception("Product " . $id . " not found.", 404);
         }
 
         // DELETE Product
         $obProduct->delete();
 
         // RETURN DELETE SUCCESS
         return [
             'success' => true,
         ];

    }
}
