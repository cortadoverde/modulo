<?php
/**
 * @PSR-0: Modulo\Mime
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

class Mime
{

    private static $mime = array(
        'text' => 'text/plain',
        'html' => 'text/html',
        'javascript' => 'text/javascript',
        'css'   => 'text/css',
        'json'  => 'application/json',
        'csv'   => 'application/vnd.ms-excel, text/plain',
        'form'  => 'application/x-www-form-urlencoded',
        'file'  => 'multipart/form-data',
        'xml'   => 'application/xml',
        'pdf'   => 'application/pdf' 
    );
    
    public static function setType( Response $response )
    {
        $type = ( isset ( $response->type ) && isset( self::$mime[$response->type] ) ) ? self::$mime[$response->type] : self::$mime['html'];
        header( 'Content-type: ' . $type );
    }
}
