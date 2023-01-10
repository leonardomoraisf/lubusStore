<?php

namespace App\Controller\Api;

class Api{

    /**
     * Method to return api details
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){

        return[
            'name' => 'API - LubusStore',
            'version' => 'v1.0.0',
            'author' => 'Leonardo Morais Franca',
            'email' => 'mfrancaleonardo@gmail.com',
        ];

    }

    /**
     * Method to return pagination details
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    protected static function getPagination($request, $obPagination)
    {
        // QUERY PARAMS
        $queryParams = $request->getQueryParams();

        // PAGES
        $pages = $obPagination->getPages();

        // RETURN
        return [
            'currentPage' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
            'pageQuantity' => !empty($pages) ? count($pages) : 1,
        ];
    }

}