<?php

namespace App\Controller\Api;
use App\Model\Entity\AdminUser as EntityUser;
use App\Utils\Bcrypt;
use \Firebase\JWT\JWT;
use \Exception;

class Auth extends Api{

    /**
     * Method to generate JWT token
     * @param Request $request
     * @return array
     */
    public static function generateToken($request){

        // POST VARS
        $postVars = $request->getPostVars();
        
        // VALID CAMPS
        if (!isset($postVars['user']) or !isset($postVars['password'])) {
            throw new Exception("There are empty fields! Fields: 'user', 'password'.", 400);
        }

        // SEARCH USER BY USER
        $obUser = EntityUser::getAdminUserByUser($postVars['user']);
        if(!$obUser instanceof EntityUser){
            throw new Exception("Incorrect username or password!", 400);
        }

        // VALID PASSWORD
        if(!Bcrypt::check($postVars['password'],$obUser->password)){
            throw new Exception("Incorrect username or password!", 400);
        }

        //PAYLOAD
        $payload = [
            'user' => $obUser->user,
        ];

        // RETURN GENERATED TOKEN
        return[
            'token' => JWT::encode($payload,$_ENV['JWT_KEY'],'HS256'),
        ];

    }

}