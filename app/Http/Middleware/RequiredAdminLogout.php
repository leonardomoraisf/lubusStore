<?php

namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;

class RequiredAdminLogout
{

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request,$next){
        
        //VERIFY USER LOGIN
        if(SessionAdminLogin::isLogged()){
            $request->getRouter()->redirect('/dashboard');
        }

        // CONTINUOUS EXECUTION
        return $next($request);

    }

}
