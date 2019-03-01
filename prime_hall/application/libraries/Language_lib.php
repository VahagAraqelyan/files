<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Language_lib {

    private $CI;

    public function __construct(){

        $this->CI=get_instance();
    }

    public function switch_language(){

        $language_dir = $this->CI->uri->segment(1);

        if(empty($language_dir)){

            $language_dir = 'am';
        }

        if($this->CI->router->class == $language_dir){

            $language_dir = 'am';
        }

        if($language_dir != 'am' && $language_dir != 'ru' && $language_dir != 'en'){

            $language_dir = 'am';
        }

        return $language_dir;
    }
}