<?php
/**
 * @PSR-0: Modulo\Admin\Upload
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

class Upload extends Controller
{

    public function init()
    {
        $this->save_data = __UPLOAD__ .'/data.json';
    }
    public function file()
    {
        if( $this->request->request_method == 'POST') {
            print_r($_POST);
            print_r($_FILES);
            echo UPLOAD_ERR_OK;
            $this->process_csv();
        } else {
            $this->addAlias('Content', 'Admin/Forms/FileUpload');
            $this->render();
        }
    }

    public function view()
    {
        $this->response->type = 'json';
        $file = new \Modulo\File($this->save_data);
        $this->data = json_decode( $file->read() ) ;
        $this->render();
    }

    private function process_csv()
    {
        if ($_FILES['csv']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['csv']['tmp_name'])) {
            
            $scope      = 0;
            $Rows       = array();
            $separator  = isset( $_POST['separator'] ) ? $_POST['separator'] : ';';
            
            $CsvString  = file_get_contents($_FILES['csv']['tmp_name']);
            
            $Line       = str_getcsv($CsvString, "\n"); //parse the rows
            
            foreach($Line as $Row) {
                $Rows[] = str_getcsv($Row, $separator); //parse the items in rows
            }
            
            $this->save_file( json_encode( $Rows ) );

            //print_r($Rows); 
        }
    }

    private function save_file( $data )
    {
        if( ( $file = \Modulo\File::create($this->save_data) ) === false ) {
            return false;
        }

        $file->write($data)->close();

    }
    
}
