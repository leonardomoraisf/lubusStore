<?php

namespace App\Http\Middleware;

use WilliamCosta\DatabaseManager\Database;

class VerifyUserVisit
{

    /**
     * Method to create visit cookie and input in db
     * @return boolean
     */
    private static function setUniqueVisit()
    {
        // SET COOKIE
        setcookie('visit', 'true', time() + (60 * 60 * 24 * 7));
        // CREATE DB VISIT
        (new Database('`tb_users.visits`'))->insert([
            'date' =>  date('Y-m-d'),
        ]);

        // RETURN SUCCESS
        return true;
    }

    /**
     * Method to execute the middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        // VERIFY MAINTENANCE STATUS OF PAGE
        if (!isset($_COOKIE['visit'])) {
            self::setUniqueVisit();
        }

        // EXECUTE NEXT MIDDLEWARE LEVEL
        return $next($request);
    }
}
