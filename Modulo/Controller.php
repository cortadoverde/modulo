<?php
/**
 * @PSR-0: Modulo\Controller
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

class Controller extends Object
{
    public $layout = 'Layout';

    public $data = array();

    public function __construct(Request $request, Response $response )
    {
        $this->request = $request;
        $this->response = $response;
        AliasLoader::getInstance( __TEMPLATES__ , array() );
    }

    public function render()
    {
        switch( $this->response->type ) {
            case 'json' : 
                $this->response->body = $this->render_json();
                break;
            default:
                $this->response->body = $this->render_html();
                break;
        }
    }

    public function addAlias( $name , $value = false )
    {
        if( is_array( $name ) ) {
            AliasLoader::getInstance()->setAliases( $name, $value );
            return;
        }

        AliasLoader::getInstance()->set($name, $value);
    }

    public function render_html()
    {
        // Set Global Data transport
        $engine = new \Mustache_Engine(array(
            'loader'            => new \Mustache_Loader_FilesystemLoader( __TEMPLATES__ ),
            'partials_loader'   => AliasLoader::getInstance()
        ));

        return $engine->render( $this->layout, $this );
    }

    public function render_json()
    {
        return json_encode( $this->data );
    }
}
