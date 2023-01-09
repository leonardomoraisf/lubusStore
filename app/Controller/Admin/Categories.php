<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Models\Entity\Categorie as EntityCategorie;
use App\Utils\Utilities;

class Categories extends Page
{
    /**
     * Method to catch items render
     * @param Request $request
     * @return string
     */
    private static function getCategorieItems(){
        // Categories
        $itens = '';

        // RESULTS
        $results = Utilities::getList('`tb_categories`',null,'id DESC');

        // RENDER ITEM
        while($obCategories = $results->fetchObject(EntityCategorie::class))
        $itens .= View::render('views/admin/categorie/item', [
            'id' => $obCategories->id,
            'name' => $obCategories->name,
            'description' => $obCategories->description,
            'date' => date('d/m/Y',strtotime($obCategories->date)),
            'img' => UPLOADS.'/categories/'.$obCategories->img,
        ]);

        return $itens;

    }

    /**
     * Method to return view
     * @param Request $request
     * @return string
     */
    public static function getCategories()
    {
        $elements = parent::getElements();
        return View::render('views/admin/categories', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Categories',
            'itens' => self::getCategorieItems(),
            'active_categories' => 'active',
        ]);

    }

    /**
     * Method to return form categorie view
     * @return string
     */
    public static function getFormCategorie()
    {
        $elements = parent::getElements();
        return View::render('views/admin/forms_categorie', [
            'preloader' => $elements['preloader'],
            'links' => $elements['links'],
            'sidebar' => $elements['sidebar'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
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

        return self::getFormCategorie();
        
    }

    /**
     * Method to return view
     * @return string
     */
    public static function getEditCategorie($request,$cat_id)
    {
        if($cat_id == ''){
            // REDIRECT TO CATEGORIES PAGE
            $request->getRouter()->redirect('/dashboard/categories');
        }else{
            $results = Utilities::getRow('`tb_categories`','id ='.$cat_id,null);
            if($results->rowCount() == 1){
                $elements = parent::getElements();
                $obCategorie = $results->fetchObject(EntityCategorie::class);
                return View::render('views/admin/edit_categorie', [
                    'preloader' => $elements['preloader'],
                    'links' => $elements['links'],
                    'sidebar' => $elements['sidebar'],
                    'header' => $elements['header'],
                    'footer' => $elements['footer'],
                    'scriptlinks' => $elements['scriptlinks'],
                    'id' => $obCategorie->id,
                    'name' => $obCategorie->name,
                    'description' => $obCategorie->description,
                    'date' => date('d/m/Y',strtotime($obCategorie->date)),
                    'img' => UPLOADS.'/categories/'.$obCategorie->img,
                    'active_categories' => 'active',
                ]);
            }else{
                // REDIRECT TO CATEGORIES PAGE
                $request->getRouter()->redirect('/dashboard/categories');
            }
        }
    }

}
