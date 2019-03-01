<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ferry_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function  insert_ferry($data){

        if(empty($data)){
            return false;
        }

        return $this ->db->insert('ferry',$data);
    }

    public function get_ferry($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        return $this->db->get('ferry')->result_array();
    }
}