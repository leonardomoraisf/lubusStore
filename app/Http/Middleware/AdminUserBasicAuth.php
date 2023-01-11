<?php

namespace App\Http\Middleware;

use \App\Model\Entity\AdminUser;
use \App\Utils\Bcrypt;
use Exception;

class AdminUserBasicAuth
{

    /**
     * Method to return an authenticated user instance
     * @return AdminUser
     */
    private function getBasicAuthUser(){

        // VERIFY EXISTENCE OF ACCESS DATA
        if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])){
            return false;
        }

        // CATCH ADMIN USER BY USER
        $obUser = AdminUser::getAdminUserByUser($_SERVER['PHP_AUTH_USER']);
        
        // VERIFY INSTANCE
        if(!$obUser instanceof AdminUser){
            return false;
        }

        // VALID PASSWORD AND RETURN USER
        return Bcrypt::check($_SERVER['PHP_AUTH_PW'],$obUser->password) ? $obUser : false;

    }

    /**
     * Method to valid the access
     * @param Request $request
     */
    private function basicAuth($request){

        // VERIFY USER
        if($obUser = $this->getBasicAuthUser()){

            $request->user = $obUser;

            return true;
            
        }

        // THROW ERROR
        throw new Exception("Username or password is invalid!",403);

    }

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request,$next){

        // CALL BASIC AUTH METHOD
        $this->basicAuth($request);

        // EXECUTE NEXT MIDDLEWARE LEVEL
        return $next($request);

    }

}
