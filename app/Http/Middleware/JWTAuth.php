<?php

namespace App\Http\Middleware;

use \App\Model\Entity\AdminUser as EntityUser;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key as Key;
use Exception;

class JWTAuth
{

    /**
     * Method to return an authenticated user instance
     * @param Request $request
     * @return AdminUser
     */
    private function getJWTAuthUser($request)
    {

        // HEADERS
        $headers = $request->getHeaders();

        // PURE JWT TOKEN
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';

        try {
            // DECODE
            $decoded = (array)JWT::decode($jwt, new Key($_ENV['JWT_KEY'], 'HS256'));
        } catch (\Exception $e) {
            // THROW ERROR
            throw new Exception("Invalid token!", 403);
        }

        // USER
        $user = $decoded['user'] ?? '';

        // CATCH ADMIN USER BY USER
        $obUser = EntityUser::getAdminUserByUser($user);

        // RETURN USER
        return $obUser instanceof EntityUser ? $obUser : false;
    }

    /**
     * Method to valid the access JWT
     * @param Request $request
     */
    private function auth($request)
    {

        // VERIFY USER
        if ($obUser = $this->getJWTAuthUser($request)) {

            $request->user = $obUser;

            return true;
        }

        // THROW ERROR
        throw new Exception("Access denied!", 403);
    }

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {

        // CALL JWT AUTH METHOD
        $this->auth($request);

        // EXECUTE NEXT MIDDLEWARE LEVEL
        return $next($request);
    }
}
