<?php
/**
 * @PSR-0: Modulo\Admin\Controller 
 *
 * (c) Pablo Adrian Samudia <p.a.samu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Pablo Samudia <p.a.samu@gmail.com>
 * @copyright cortadoverde.com
 */

namespace Modulo\Admin;

class Controller extends \Modulo\Controller
{

    public $allow = array(
        'Modulo\\Admin\\User\\login',
        'Modulo\\Admin\\User\\logout'
    );

    public function __construct( \Modulo\Request $request, \Modulo\Response $response )
    {
        session_start();
        parent::__construct( $request, $response );
        $this->init();
        $this->check_session();
        
    }

    public function init()
    {
        
    }

    private function check_session()
    {
        $path = $this->request->match['namespace'] . '\\' . $this->request->match['action'];

        if( isset( $_SESSION['user'] ) ) {
            echo 'logueado';
            return true;
        }

        if( ! in_array( $path , $this->allow ) ) {
            header('Location: ' . $this->request->base .'/admin/login');
        }
        
    }



}
