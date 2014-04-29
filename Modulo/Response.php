<?php
/**
 * @PSR-0: Modulo\Response
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

class Response extends Object
{
    private $header;

    public $body;

    public $type = 'html';

    public function render()
    {
        Mime::setType( $this );
        echo $this->body;
    }
}
