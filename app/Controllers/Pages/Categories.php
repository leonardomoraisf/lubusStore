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
        $content = View::render('views/pages/categories', [
            'itens' => self::getCategorieItems($request),
        ]);
        return parent::getPage('links','script_links','preloader','header','sidebar','footer',$content,'categories');
    }

    /**
     * Método que retorna a view
     * @return string
     */
    public static function getFormCategorie()
    {
        $content = View::render('views/pages/forms_categorie', [
        ]);
        return parent::getPage('links','script_links','preloader','header','sidebar','footer',$content,'forms/categorie');
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
                $obCategorie = $results->fetchObject(EntityCategorie::class);
                $content = View::render('views/pages/edit_categorie', [
                    'id' => $obCategorie->id,
                    'name' => $obCategorie->name,
                    'description' => $obCategorie->description,
                    'date' => date('d/m/Y',strtotime($obCategorie->date)),
                    'img' => UPLOADS.'/categories/'.$obCategorie->img,
                ]);
                return parent::getPage('links','script_links','preloader','header','sidebar','footer',$content,'categories/edit');
            }else{
                // REDIRECT TO CATEGORIES PAGE
                $request->getRouter()->redirect('/categories');
            }
        }
    }

}
