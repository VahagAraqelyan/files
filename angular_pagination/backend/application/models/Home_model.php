<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_product($data){

        if(empty($data)){

            return false;
        }

         $this->db->insert('product2', $data);
    }

        public function get_product($id = NULL){
        
        $one = false;

        if(!empty($id)){

             $this->db->where('id', $id);
             $one = true;
        }

        if($one){

             $result =  $this->db->get('product2')->row_array();

        }else{
             $result =  $this->db->get('product2')->result_array();
        }

        return $result;
    }

    public function update_likes($id,$data){

        if(empty($id) || empty($data)){

            return false;
        }

         $this->db->where('id', $id);

        $this->db->update('product2', $data);
    }

}
?>