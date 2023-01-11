<?php

namespace App\Http\Middleware;
use App\Utils\Cache\File as CacheFile;

class Cache
{

    /**
     * Method to verify if actual request is cacheable
     * @param Request $request
     * @return boolean
     */
    private function isCacheable($request){
        
        //VALID CACHE TIME
        if($_ENV['CACHE_TIME'] <= 0){
            return false;
        }

        // VALID REQUEST METHOD
        if($request->getHttpMethod() != 'GET'){
            return false;
        }

        /*
        // VALID CACHE HEADER - ALLOW CLIENT CACHE THE ROUTE
        $headers = $request->getHeaders();
        if(isset($headers['Cache-Control']) and $headers['Cache-Control'] == 'no-cache'){
            return false;
        }
        */

        // CACHEABLE
        return true;
    }

    /**
     * Method to return cache hash
     * @param Request $request
     * @return string
     */
    private function getHash($request){

        // ROUTE URI
        $uri = $request->getRouter()->getUri();
        
        // QUERY PARAMS
        $queryParams = $request->getQueryParams();
        $uri .= !empty($queryParams) ? '?'.http_build_query($queryParams) : '';

        // REMOVE BARS AND RETURN HASH
        return rtrim('route-'.preg_replace('/[^0-9a-zA-Z]/','-',ltrim($uri,'/')),'-');

    }

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request,$next){
        
        // VERIFY ACTUAL REQUEST (CACHEABLE)
        if(!$this->isCacheable($request)) return $next($request);

        // CACHE HASH
        $hash = $this->getHash($request);

        // RETURN CACHE DATA
        return CacheFile::getCache($hash,$_ENV['CACHE_TIME'],function() use($request,$next){
            return $next($request);
        });
        
    }

}
