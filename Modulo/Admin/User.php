<?php
/**
 * @PSR-0: Modulo\Admin\User
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

class User extends Controller
{

    public function login()
    {

        if( isset( $_SESSION['user'] ) ) {
            header('Location: ' . $this->request->base . '/admin/upload');
        }
        if( $this->request->request_method == 'POST' ) {

            if ( ($data = $this->request->post('user') ) !== false ) {
                if (
                    ( isset ( $data['username'] ) && $data['username'] == __ADMIN_USER__ ) &&
                    ( isset ( $data['password'] ) && $data['password'] == __ADMIN_PWD__ )
                ) {
                    $_SESSION['user'] = true;
                    header('Location: ' . $this->request->base . '/admin/upload');
                } 
            }
            header('Location: ' . $this->request->base . '/admin/login');
        } else {
            $this->addAlias('Content', 'Admin/Forms/login');
            $this->render();
        }
    }

    public function logout()
    {
        unset( $_SESSION['user'] );
    }
    
}
