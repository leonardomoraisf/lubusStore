<?php

namespace App\Controller\Public;

use App\Utils\View;
use App\Utils\Utilities;
use App\Model\Entity\Category as EntityCategory;

class Home extends Page
{

    /**
     * Method to catch items render
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getCategoryItems($request)
    {
        // Categories
        $itens = '';

        // RESULTS
        $results = Utilities::getList('`tb_categories`', null, 'id DESC');
        
        // ACTUAL URL WITHOUT GETS
        $url = $request->getRouter()->getCurrentUrl();

        // RENDER ITEM
        while ($obCategories = $results->fetchObject(EntityCategory::class))
            $itens .= View::render('views/public/includes/categories/item', [
                'cat_name' => $obCategories->name,
                'cat_img' => UPLOADS . '/categories/' . $obCategories->img,
                'cat_link' => $url . '/categoria/' . $obCategories->id,
            ]);

        return $itens;
    }

    /**
     * Method to return home view
     * @return string
     */
    public static function getHome($request)
    {
        $secao_descritiva = View::render('views/public/includes/home/secao_descritiva');
        $secao_categorias = View::render('views/public/includes/home/secao_categorias');
        $secao_depoimentos = View::render('views/public/includes/home/secao_depoimentos');
        $secao_duvidas = View::render('views/public/includes/home/secao_duvidas');
        $secao_newsletter = View::render('views/public/includes/home/secao_newsletter');

        $elements = parent::getElements();
        return View::render('views/public/home', [
            'links' => $elements['links'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Página inicial',
            'secao_descritiva' => $secao_descritiva,
            'secao_categorias' => $secao_categorias,
            'secao_depoimentos' => $secao_depoimentos,
            'secao_duvidas' => $secao_duvidas,
            'secao_newsletter' => $secao_newsletter,
            'home_active' => 'active',
            'itens' => self::getCategoryItems($request),
        ]);
    }
}
