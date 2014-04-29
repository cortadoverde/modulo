<?php
/**
 * @PSR-0: Modulo\Front\Main
 *
 * (c) Pablo Adrian Samudia <p.a.samu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Pablo Samudia <p.a.samu@gmail.com>
 * @copyright cortadoverde.com
 */

namespace Modulo\Front;

class Main extends \Modulo\Controller
{
    public function index()
    {   
        //$this->response->type = 'json';

        $this->addAlias('Content', 'Front/Main');
        
        $this->data = array(
            'Provincias' => array(
                'Cordoba', 'Santa Fe'
            )
        );

        $this->render();
    
    }
}
