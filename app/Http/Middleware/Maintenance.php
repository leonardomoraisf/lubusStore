<?php

namespace App\Http\Middleware;
use Exception;

class Maintenance
{

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request,$next){
        
        // VERIFY MAINTENANCE STATUS OF PAGE
        if(MAINTENANCE == 'true'){
            throw new Exception("Maintenance page. Try again later.", 200);
        }

        // EXECUTE NEXT MIDDLEWARE LEVEL
        return $next($request);

    }

}
