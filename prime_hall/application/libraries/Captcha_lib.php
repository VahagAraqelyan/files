<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class captcha_lib {

    private $CI;

    public function __construct()
    {

        $this->CI=get_instance();

        $this->CI->load->model("Capt_model");


    }


    /*
    * @access public
    * @param  int $width, int $height, int $word_lenght
    * @return array
    */
    public function get_captcha($width = 100, $height = 40, $word_lenght = 4){

        $captcha_config = array(
            'word'          => random_string('alnum',$word_lenght),
            'img_path'      => './assets/captcha/',
            'img_url'       => base_url().'assets/captcha/',
            'font_path'     => './system/fonts/texb.ttf',
            'img_width'     => $width,
            'img_height'    => $height,
            'expiration'    => 1800,
            'word_length'   => 8,
            'font_size'     => 18,
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                'background' => array(245, 245, 245),
                'border' => array(229, 229, 229),
                'text' => array(0, 0, 0),
                'grid' => array(229, 229, 229)
            )
        );

        $captcha = create_captcha($captcha_config);

        $this->CI->Capt_model->insert_captcha($this->CI->input->ip_address(), $captcha["word"]);

        return $captcha;

    }



    public function is_captcha($word, $ip){

        if(empty($word) || empty($word)){

            return false;

        }

        $bool = $this->CI->Capt_model->get_captcha_data($word, $ip);


        if (!$bool)
        {
            return false;
        }

        return true;

    }


}

?>