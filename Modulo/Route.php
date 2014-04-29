<?php
/**
 * @PSR-0: Modulo\Route
 *
 * (c) Pablo Adrian Samudia <p.a.samu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Pablo Samudia <p.a.samu@gmail.com>
 * @copyright cortadoverde.com
 */

namespace Modulo;

class Route
{

    private static $routes;

    public static function setRoutes( array $routes )
    {
        self::$routes = $routes;
    }

    public static function setRoute( array $setting ) 
    {
        self::$routes[] = $setting;
    }

    public static function factory( Request $request )
    {
        // evaluar si el request coincide con alguna expresion generada 
        // al router
        foreach( self::$routes AS $route )
        {
            if( ( $data = self::evaluate( $route, $request ) ) !== false ) {
                return $data;
            }
        }
        return false;
    }

    public static function evaluate( $route, Request $request )
    {

        
        if( preg_match('#'. $route['exp'].'#is', $request->RELATIVE_URI ) ) {
            return $route;
        }
        return false;
    }
}
