<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partners_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_partners($data){

        if(empty($data)){
            return false;
        }

        return $this ->db->insert('partner',$data);
    }


    public function get_partners($cr = NULL,$bool = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        if(!$bool){
          $result =  $this->db->get('partner')->result_array();
        }else{

            $result = $this->db->get('partner')->row_array();
        }

        return $result;
    }
}