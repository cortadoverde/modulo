<?php
/**
 * @PSR-0: Modulo\Request
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

class Request extends Object
{
    private $_env;

    private $header;

    private $body;

    private $params;

    public function __construct()
    {
         
    }

    public function on_construct( $base = false, $server = false  )
    {
        $this->_env = $server === false ? $_SERVER : $server;
        $this->base = $base;
        $this->extract();
    }   

    private function extract ()
    {
        $this->extract_header();
        $this->extract_params();
    }

    private function extract_header()
    {
        $indices = array( 
            'HTTP_HOST', 'HTTPS_HOST', 'HTTP_USER_AGENT', 'HTTP_ACCEPT', 'REQUEST_SCHEME', 'SCRIPT_FILENAME', 
            'REQUEST_URI', 'REQUEST_METHOD', 'SERVER_PROTOCOL'
        );

        

        $this->header = array_intersect_key($this->_env, array_flip( $indices ) );
        $this->header['REQUEST_URI'] = rtrim( $this->parse_request_uri( $this->header['REQUEST_URI'] ), '/' );
        $this->header['RELATIVE_URI'] = str_replace($this->base, '', $this->header['REQUEST_URI']); 
        $this->header['RELATIVE_URI'] = $this->header['RELATIVE_URI'] == '' ? '/' : $this->header['RELATIVE_URI'];
        $this->header['FULL_URL'] = 
            'http' 
            . ( 
                isset( $this->header['HTTPS_HOST'] ) ? 's://' . $this->header['HTTPS_HOST'] : '://' . $this->header['HTTP_HOST'] 
                ) 
            . $this->header['REQUEST_URI'];
    }

    public function parse_request_uri( $request_uri )
    {
        if( ( $pos = strpos($request_uri, '?') ) !== false ) {
            return substr($request_uri, 0, $pos);
        }
        return $request_uri;
    }

    public function extract_params() 
    {
        $this->extract_params_get();
        if( $this->header['REQUEST_METHOD'] == 'POST' ) {
            $this->extract_params_post();
        }   
    }

    public function extract_params_get()
    {
        $this->params['GET'] = $_GET;
    }

    public function extract_params_post()
    {
        $this->params['POST'] = $_POST;
    }

    public function get( $param, $request_method = 'get' )
    {
        $method = strtoupper( $request_method );
        if( isset( $this->params[$method][$param] ) ) {
            return $this->params[$method][$param];
        }
        return false;
    }

    public function post( $param )
    {
        return $this->get( $param, 'post');
    }

    public function __get( $data )
    {
        $data = strtoupper($data);
        if( isset( $this->header[$data] ) ) {
            return $this->header[$data];
        }
        return false;
    }

}
