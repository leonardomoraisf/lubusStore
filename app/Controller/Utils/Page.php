<?php

namespace App\Controller\Utils;

use App\Utils\View;

class Page
{

    /**
     * Method to return header
     * @return string
     */
    public static function getHeader()
    {
        return View::render('views/admin/includes/header', []);
    }

    /**
     * Method to return sidebar
     * @return string
     */
    public static function getSidebar()
    {
        return View::render('views/admin/includes/sidebar', []);
    }

    /**
     * Method to return footer
     * @return string
     */
    public static function getFooter()
    {
        return View::render('views/admin/includes/footer', []);
    }

    /**
     * Method to return css links
     * @return string
     */
    public static function getLinks()
    {
        return View::render('views/admin/includes/links', []);
    }

    /**
     * Method to return preloader
     * @return string
     */
    public static function getPreLoader()
    {
        return View::render('views/admin/includes/preloader', []);
    }

    /**
     * Method to return script links
     * @return string
     */
    public static function getScriptLinks()
    {
        return View::render('views/admin/includes/scriptlinks', []);
    }

    /**
     * Method to return the elements of a page
     * @return array
     */
    public static function getElements($elements = [])
    {
        $elements['footer'] = self::getFooter();
        $elements['header'] = self::getHeader();
        $elements['links'] = self::getLinks();
        $elements['scriptlinks'] = self::getScriptLinks();
        $elements['sidebar'] = self::getSidebar();
        $elements['preloader'] = self::getPreLoader();
        return $elements;
    }

    /**
     * Method to render pagination layout
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {

        // PAGES
        $pages = $obPagination->getPages();

        // VERIFY PAGES QUANTITY
        if (count($pages) <= 1) return '';

        // LINKS
        $links = '';

        // ACTUAL URL WITHOUT GETS
        $url = $request->getRouter()->getCurrentUrl();

        // GET
        $queryParams = $request->getQueryParams();

        // RENDER LINKS
        foreach ($pages as $page) {

            // CHANGE PAGE
            $queryParams['page'] = $page['page'];

            // LINK
            $link = $url . '?' . http_build_query($queryParams);

            // VIEW
            $links .= View::render('views/admin/includes/pagination/link', [
                'page' => $page['page'],
                'pagelink' => $link,
                'pageactive' => $page['current'] ? 'active' : '',
            ]);
        }

        // RENDER BOX PAGINATION
        return View::render('views/admin/includes/pagination/box', [
            'pages' => $links,
        ]);
    }
    
}
