<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: GEVOR
 * Date: 10/11/2017
 * Time: 2:37 PM
 */

Class Pdf_lib {

    public function __construct()
    {

    }

    public function html_to_pdf($data, $save_dir, $file_name, $content = false){

        if($content){

        }else{

            $url = $data;

        }

        if(!is_dir($save_dir)){
            mkdir($save_dir, 0775, TRUE);
        }

        $save = $save_dir.'/'.$file_name;

        $comand = 'wkhtmltopdf '.$url.' '.$save;

        exec($comand);

        if(!file_exists($save)){
            return false;
        }

        return true;

    }



}

?>