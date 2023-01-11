<?php

namespace App\Http\Middleware;

use WilliamCosta\DatabaseManager\Database;
use \App\Utils\Utilities;
use \App\Session\Admin\Login as SessionAdminLogin;

class VerifyAdminSession
{

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {   

        $obLoginToken = (new Database('`tb_login.tokens`'))->select("`user_id` = ".$_SESSION['admin']['user']['id']." AND token = ".'"'.$_SESSION['admin']['user']['login_token'].'"');
        if($obLoginToken->rowCount() == 0){

            SessionAdminLogin::logout();
            $request->getRouter()->redirect('/dashboard/login?status=double');
            
        }

        // CONTINUOUS EXECUTION
        return $next($request);
        
    }
}
