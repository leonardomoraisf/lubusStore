<?php

namespace App\Http\Middleware;
use Exception;

class Api
{

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request,$next){

        // CHANGE CONTENT TYPE TO JSON
        $request->getRouter()->setContentType('application/json');

        // EXECUTE NEXT MIDDLEWARE LEVEL
        return $next($request);

    }

}
