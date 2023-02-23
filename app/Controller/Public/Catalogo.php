<?php

namespace App\Controller\Public;

use App\Utils\View;
use App\Utils\Utilities;
use App\Model\Entity\Product as EntityProduct;

class Catalogo extends Page
{

    /**
     * Method to catch items render
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getProductItems($request)
    {
        // Products
        $itens = '';

        // RESULTS
        $results = Utilities::getList('`tb_products`', null, 'likes DESC');
        
        // ACTUAL URL WITHOUT GETS
        $url = $request->getRouter()->getCurrentUrl();

        // RENDER ITEM
        while ($obProducts = $results->fetchObject(EntityProduct::class))
            $itens .= View::render('views/public/includes/catalogo/itens/produto', [
                'product_name' => $obProducts->name,
                'product_img' => UPLOADS . '/products/' . $obProducts->img,
                'prices' => ($obProducts->price !== $obProducts->discount_price) ? View::render('views/public/includes/catalogo/itens/price_with') : View::render('views/public/includes/catalogo/itens/price_without'),
                'product_price' => number_format($obProducts->price, 2, ',', ' '),
                'product_discount_price' => ($obProducts->price !== $obProducts->discount_price) ? number_format($obProducts->discount_price, 2, ',', ' ') : '',
                'sale' => ($obProducts->price !== $obProducts->discount_price) ? View::render('views/public/includes/catalogo/itens/sale') : '',
            ]);

        return $itens;
    }

    /**
     * Method to return home view
     * @return string
     */
    public static function getCatalogo($request)
    {
        $elements = parent::getElements();
        return View::render('views/public/catalogo', [
            'links' => $elements['links'],
            'header' => $elements['header'],
            'footer' => $elements['footer'],
            'scriptlinks' => $elements['scriptlinks'],
            'title' => 'Catálogo',
            'catalogo_active' => 'active',
            'most_liked' => self::getProductItems($request)
        ]);
    }
}
