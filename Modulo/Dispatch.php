<?php
/**
 * @PSR-0: Modulo\Dispatch
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

class Dispatch extends Object
{
    public static $request;

    public static $response;

    public static function run( Request $request, Response $response )
    {

        if( __DEBUG__ ) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        self::$request  =& $request;
        self::$response = $response;

        $default = array(
            'namespace' => '\\Modulo\\Error\\Mising',
            'action'    => 'controller',
            'args'      => array()
        );

        $app = Route::factory( $request );
        
        if( $app === false ) {
            $app = $default;
        } else {
            $app = array_merge( $default, $app);
        }

        if( self::invoke( $app['namespace'], $app['action'], $app['args'] ) === false ) {
            
           // trigger_error( sprintf( "[Debug]: \n\t namespace = %s \n\t action = %s \n\t args %s ", $app['namespace'], $app['action'], $app['args']) , E_USER_ERROR);
            
            trigger_error( 'No se encuentra un controlador valido para el manejo de errores, por favor solucionar este problema crando un controlador de Error en la aplicacion', E_USER_ERROR);
        
        }

        $response->render();

    }

    static private function _checkReflection( $namespace )
    {
        try {
            $r = new \ReflectionClass($namespace);
            return $r;
        } catch (\ReflectionException $e) {
            return false;
        }
        return false;
    }

    static public function invoke( $ns, $action, $args = array() ) 
    {
        if ( ( $r = self::_checkReflection( $ns ) ) !== false ) {

            self::$request->match = array('namespace' => $ns, 'action' => $action );

            if ( $r->isSubclassOf( 'Modulo\\Controller' ) ) {
                $instance = $r->newInstanceArgs( array( self::$request, self::$response ) );
            } else {
                $instance = $r->newInstance();
            }

            if( $r->hasMethod($action) ) {
                $method = $r->getMethod( $action );
                if( empty( $args ) ) {
                    return $method->invoke($instance);
                } else {
                    return $method->invokeArgs($instance, $args);
                }
            }
        }
        return false;
    }
}
