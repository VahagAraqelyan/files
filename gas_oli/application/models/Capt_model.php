<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Capt_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }



    public function get_captcha_data($word, $ip){

        $expiration = time() - 1800;

        $this->db->where('captcha_time < ', $expiration)->delete('captcha');


        $sql = "SELECT *  FROM captcha 
                WHERE word = BINARY '".$this->db->escape_str($word)."' AND 
                      ip_address = '".$ip."' AND 
                      captcha_time > '".$expiration."'";

        $data=$this->db->query($sql)->row();

        if(empty($data)){

            return false;

        }


        $this->db->where('captcha_id = '.$data->captcha_id)->delete('captcha');

        return true;

    }

    public function insert_captcha($ip, $word){

        $data = array(
            'captcha_time' => time(),
            'ip_address' => $ip,
            'word' => $word
        );

        $this->db->insert('captcha', $data);

    }


}
?>