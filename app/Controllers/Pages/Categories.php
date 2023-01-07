<?php

namespace App\Controllers\Pages;

use App\Utils\View;
use App\Models\Entity\Categorie as EntityCategorie;
use App\Utils\Utilities;
use WilliamCosta\DatabaseManager\Pagination;

class Categories extends Page
{
    /**
     * Method to catch items render
     * @param Request $request
     * @return string
     */
    private static function getCategorieItems($request){
        // Categories
        $itens = '';

        // RESULTS
        $results = Utilities::getList('`tb_categories`',null,'id DESC');

        // RENDER ITEM
        while($obCategories = $results->fetchObject(EntityCategorie::class))
        $itens .= View::render('views/pages/categorie/item', [
            'id' => $obCategories->id,
            'name' => $obCategories->name,
            'description' => $obCategories->description,
            'date' => date('d/m/Y',strtotime($obCategories->date)),
            'img' => UPLOADS.'/categories/'.$obCategories->img,
        ]);

        return $itens;

    }

    /**
     * Método que retorna a view
     * @param Request $request
     * @return string
     */
    public static function getCategories($request)
    {
        $fullPage = parent::getFullPage();
        return View::render('views/pages/categories', [
            'preloader' => $fullPage['preloader'],
            'links' => $fullPage['links'],
            'sidebar' => $fullPage['sidebar'],
            'header' => $fullPage['header'],
            'footer' => $fullPage['footer'],
            'scriptlinks' => $fullPage['scriptlinks'],
            'title' => 'Categories',
            'itens' => self::getCategorieItems($request),
            'active_categories' => 'active',
        ]);

    }

    /**
     * Método que retorna a view
     * @return string
     */
    public static function getFormCategorie($request)
    {
        $fullPage = parent::getFullPage();
        return View::render('views/pages/forms_categorie', [
            'preloader' => $fullPage['preloader'],
            'links' => $fullPage['links'],
            'sidebar' => $fullPage['sidebar'],
            'header' => $fullPage['header'],
            'footer' => $fullPage['footer'],
            'scriptlinks' => $fullPage['scriptlinks'],
            'title' => 'New Categorie',
            'menu_open_forms' => 'menu-open',
            'active_forms' => 'active',
            'active_forms_categorie' => 'active',

        ]);
    }

    /**
     * Method to register a new categorie
     * @param Request $request
     * @return string
     */
    public static function insertCategorie($request){
        // NEW CATEGORIE INSTANCE
        $obCategorie = new EntityCategorie;

        $obCategorie->register($request);

        return self::getFormCategorie($request);
        
    }

    /**
     * Método que retorna a view
     * @return string
     */
    public static function getEditCategorie($request,$categorie_id)
    {
        if($categorie_id == ''){
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/categories');
        }else{
            $results = Utilities::getRow('`tb_categories`','id ='.$categorie_id,null);
            if($results->rowCount() == 1){
                $fullPage = parent::getFullPage();
                $obCategorie = $results->fetchObject(EntityCategorie::class);
                return View::render('views/pages/edit_categorie', [
                    'preloader' => $fullPage['preloader'],
                    'links' => $fullPage['links'],
                    'sidebar' => $fullPage['sidebar'],
                    'header' => $fullPage['header'],
                    'footer' => $fullPage['footer'],
                    'scriptlinks' => $fullPage['scriptlinks'],
                    'id' => $obCategorie->id,
                    'name' => $obCategorie->name,
                    'description' => $obCategorie->description,
                    'date' => date('d/m/Y',strtotime($obCategorie->date)),
                    'img' => UPLOADS.'/categories/'.$obCategorie->img,
                    'active_categories' => 'active',
                ]);
            }else{
                // REDIRECT TO CATEGORIES PAGE
                $request->getRouter()->redirect('/categories');
            }
        }
    }

}
