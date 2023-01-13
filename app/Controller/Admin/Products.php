<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Product as EntityProduct;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Model\Entity\AdminUser as EntityUser;
use App\Model\Entity\Category as EntityCategory;
use App\Utils\Utilities;
use WilliamCosta\DatabaseManager\Database;

class Products extends Page
{

    /**
     * Method to catch categories render
     * @param Request $request
     * @return string
     */
    private static function getCategoryItems($request)
    {
        // Categories
        $itens = '';

        // CONNECT DB
        $conn = (new Database())->setConnection();

        //CATEGORIES
        $categories = $conn->prepare('SELECT * FROM `tb_categories`');
        $categories->execute();

        foreach ($categories as $category) {
            $itens .= View::render('views/admin/includes/products/cat_item', [
                'cat_id' => $category['id'],
                'cat_name' => $category['name'],
            ]);
        }

        return $itens;
    }

    /**
     * Method to return status view
     * @param Request $request
     * @return string
     */
    public static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // STATUS
        if (!isset($queryParams['status'])) return '';

        // STATUS MESSAGES
        switch ($queryParams['status']) {
            case 'deleted':
                return Alert::getSuccess("Product deleted successfully!");
                break;
        }
    }

    /**
     * Method to catch items render
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getProductItems($request, &$obPagination)
    {
        // Categories
        $itens = '';

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
            $obCategorie = EntityCategory::getCategoryById($obProduct->cat_id);
            $itens .= View::render('views/admin/includes/products/item', [
                'p_id' => $obProduct->id,
                'p_name' => $obProduct->name,
                'p_date' => date('d/m/Y', strtotime($obProduct->date)),
                'p_img' => UPLOADS . '/products/' . $obProduct->img,
                'p_price' => number_format($obProduct->price, 2, ',', ' '),
                'p_dis_price' => number_format($obProduct->discount_price, 2, ',', ' '),
                'cat_img' => UPLOADS . '/categories/' . $obCategorie->img,
                'cat_name' => $obCategorie->name,
                'cat_link' => 'categories/' . $obCategorie->id . '/edit',
                'p_desc' => $obProduct->description,
            ]);
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
        $elements = parent::getElements();
        return View::render('views/admin/products', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Products',
            'itens' => self::getProductItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'active_products' => 'active',
            'user_name' => $_SESSION['admin']['user']['name'],
            'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
            'user_position' => EntityUser::catchPosition($_SESSION['admin']['user']['position']),
            'status' => self::getStatus($request),
        ]);
    }

    /**
     * Method to return form product view
     * @return string
     */
    public static function getFormProduct($request, $errorMessage = null, $successMessage = null)
    {

        $statusError = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $statusSuccess = !is_null($successMessage) ? Alert::getSuccess($successMessage) : '';

        $elements = parent::getElements();
        return View::render('views/admin/forms_product', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'New Product',
            'menu_open_forms' => 'menu-open',
            'active_forms' => 'active',
            'active_forms_product' => 'active',
            'categories' => self::getCategoryItems($request),
            'statusError' => $statusError,
            'statusSuccess' => $statusSuccess,
            'user_name' => $_SESSION['admin']['user']['name'],
            'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
            'user_position' => EntityUser::catchPosition($_SESSION['admin']['user']['position']),
        ]);
    }

    /**
     * Method to register a new categorie
     * @param Request $request
     * @return string
     */
    public static function setFormProduct($request)
    {

        $obUtilities = new Utilities;

        // POST DATA
        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        $name = $postVars['name'];
        $description = $postVars['description'];
        $price = $postVars['price'];
        $price = number_format($price, 2, '.', ' ');
        $discount_price = $postVars['discount_price'];
        $discount_price = number_format($discount_price, 2, '.', ' ');
        $cat_id = $postVars['cat_id'];
        $img = $postFiles['file'];

        // VALIDATIONS
        if ($name == '' || $description == '' || $price == '' || $discount_price == '' || $cat_id == '') {
            return self::getFormProduct($request,"There are empty fields!");
        }
        if (strlen($description) > 400) {
            return self::getFormProduct($request,"Maximum of 280 characters!");
        }
        if($price <= 0 || $discount_price <= 0){
            return self::getFormProduct($request,"Prices must be positive!");
        }
        if(empty($img['tmp_name'])){
            return self::getFormProduct($request,"The product needs an image!");
        }

        // IMAGE VALIDATION
        if ($obUtilities->validateImage($img)) {
            $upload = $obUtilities->uploadFile($img, 'products/');
        } else {
            return self::getFormProduct($request, "Sorry, the image size or type is not permited!");
        }

        // NEW Product INSTANCE
        $obProduct = new EntityProduct;

        $obProduct->name = $name;
        $obProduct->description = $description;
        $obProduct->price = (double)$price;
        $obProduct->discount_price = (double)$discount_price;
        $obProduct->cat_id = $cat_id;
        $obProduct->img = $upload;

        $obProduct->register();

        return self::getFormProduct($request, null, "Product registered sucefully!");
    }

    /**
     * Method to return view
     * @return string
     */
    public static function getEditProduct($request, $p_id, $errorMessage = null, $successMessage = null)
    {
        $statusError = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';
        $statusSuccess = !is_null($successMessage) ? Alert::getSuccess($successMessage) : '';

        $obProduct = EntityProduct::getProductById($p_id);
        if (!$obProduct instanceof EntityProduct) {
            // REDIRECT TO Products PAGE
            $request->getRouter()->redirect('/dashboard/products');
        } else {
            $obActualCategory = EntityCategory::getCategoryById($obProduct->cat_id);
            $elements = parent::getElements();
            return View::render('views/admin/edit_product', [
                'preloader' => $elements['preloader'],
                'links' => $elements['links'],
                'sidebar' => $elements['sidebar'],
                'header' => $elements['header'],
                'footer' => $elements['footer'],
                'scriptlinks' => $elements['scriptlinks'],
                'title' => $obProduct->name,
                'p_name' => $obProduct->name,
                'p_img' => UPLOADS . '/products/' . $obProduct->img,
                'p_desc' => $obProduct->description,
                'p_price' => $obProduct->price,
                'p_dis_price' => $obProduct->discount_price,
                'actual_cat_id' => $obActualCategory->id,
                'actual_cat_name' => $obActualCategory->name,
                'categories' => self::getCategoryItems($request),
                'active_products' => 'active',
                'statusError' => $statusError,
                'statusSuccess' => $statusSuccess,
                'user_name' => $_SESSION['admin']['user']['name'],
                'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
                'user_position' => EntityUser::catchPosition($_SESSION['admin']['user']['position']),
            ]);
        }
    }

    public static function setEditProduct($request, $p_id)
    {

        $obUtilities = new Utilities;

        $obProduct = EntityProduct::getProductById($p_id);
        if (!$obProduct instanceof EntityProduct) {
            // REDIRECT TO Products PAGE
            $request->getRouter()->redirect('/dashboard/products');
        }

        $postVars = $request->getPostVars();
        $postFiles = $request->getPostFiles();

        $name = $postVars['name'];
        $description = $postVars['description'];
        $price = $postVars['price'];
        $price = number_format($price, 2, '.', ' ');
        $discount_price = $postVars['discount_price'];
        $discount_price = number_format($discount_price, 2, '.', ' ');
        $cat_id = $postVars['cat_id'];
        $img = $postFiles['file'];

        if ($img['tmp_name'] == '') {

            if ($name == '' || $description == '' || $price == '' || $discount_price == '' || $cat_id == '') {
                return self::getEditProduct($request, $p_id, "There are empty fields!");
            }
            if (strlen($description) > 280) {
                return self::getEditProduct($request, $p_id, "Maximum of 280 characters!");
            }
            if($price <= 0 || $discount_price <= 0){
                return self::getEditProduct($request, $p_id, "Prices must be positive!");
            }

            $obProduct->name = $name;
            $obProduct->description = $description;
            $obProduct->price = (double)$price;
            $obProduct->discount_price = (double)$discount_price;
            $obProduct->cat_id = $cat_id;
            $obProduct->img = $obProduct->img;

            $obProduct->update();

            // REDIRECT
            return self::getEditProduct($request, $p_id, null, "Product updated successfully!");

        } else {

            if ($name == '' || $description == '' || $price == '' || $discount_price == '' || $cat_id == '') {
                return self::getEditProduct($request, $p_id, "There are empty fields!");
            }
            if (strlen($description) > 280) {
                return self::getEditProduct($request, $p_id, "Maximum of 280 characters!");
            }
            if($price <= 0 || $discount_price <= 0){
                return self::getEditProduct($request, $p_id, "Prices must be positive!");
            }

            // IMAGE VALIDATION
            if ($obUtilities->validateImage($img)) {
                $new_image = $obUtilities->uploadFile($img, 'products/');
            } else {
                return self::getEditProduct($request, $p_id, "Sorry, the image size or type is not permited!");
            }

            $obProduct->name = $name;
            $obProduct->description = $description;
            $obProduct->price = (double)$price;
            $obProduct->discount_price = (double)$discount_price;
            $obProduct->cat_id = $cat_id;

            $obProduct->updateWithImage($obProduct->img,$new_image);

            // REDIRECT
            return self::getEditProduct($request, $p_id, null, "Product updated successfully!");
        }
    }

    /**
     * Method to return delete product view
     * @return string
     */
    public static function getDeleteProduct($request, $p_id)
    {
        if ($p_id == '') {
            // REDIRECT TO Products PAGE
            $request->getRouter()->redirect('/dashboard/products');
        }
        $obProduct = EntityProduct::getProductById($p_id);
        if (!$obProduct instanceof EntityProduct) {
            // REDIRECT TO Product´s PAGE
            $request->getRouter()->redirect('/dashboard/products');
        } else {
            $elements = parent::getElements();
            return View::render('views/admin/delete_product', [
                'preloader' => $elements['preloader'],
                'links' => $elements['links'],
                'sidebar' => $elements['sidebar'],
                'header' => $elements['header'],
                'footer' => $elements['footer'],
                'scriptlinks' => $elements['scriptlinks'],
                'title' => 'Confirm Delete',
                'p_name' => $obProduct->name,
                'p_img' => UPLOADS . '/products/' . $obProduct->img,
                'active_products' => 'active',
                'user_name' => $_SESSION['admin']['user']['name'],
                'user_img' => UPLOADS . '/admin_users/' . $_SESSION['admin']['user']['img'],
                'user_position' => EntityUser::catchPosition($_SESSION['admin']['user']['position']),
            ]);
        }
    }

    /**
     * Method to return post delete and delete product
     * @param Request $request
     * @param integer $p_id
     */
    public static function setDeleteProduct($request, $p_id)
    {
        // CATCH Product
        $obProduct = EntityProduct::getProductById($p_id);

        // INSTANCE VALIDATOR
        if (!$obProduct instanceof EntityProduct) {
            $request->getRouter()->redirect('/dashboard/products');
        }

        // DELETE Product
        $obProduct->delete();

        // REDIRECT
        $request->getRouter()->redirect('/dashboard/products?status=deleted');
    }
}
