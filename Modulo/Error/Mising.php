<?php
/**
 * @PSR-0: Modulo\Error\Mising
 *
 * (c) Pablo Adrian Samudia <p.a.samu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Pablo Samudia <p.a.samu@gmail.com>
 * @copyright cortadoverde.com
 */

namespace Modulo\Error;

class Mising extends \Modulo\Controller
{
    public function controller()
    {
        $this->response->body = 'Error, no se encontro la pagina <a href="'. $this->request->base .'/"> volver </a>';
    }
}
