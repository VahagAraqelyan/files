<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Luggage_model extends CI_Model {

    public function get_luggage_types($id = NULL){

        if(!empty($id) && $this->valid->is_id($id)){
            $this->db->where(['id' => $id]);
        }

        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('luggage_type')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_luggages_by_type($type_id){

        if(empty($type_id) || !$this->valid->is_id($type_id)){
            return false;
        }


        $this->db->order_by('ordering', 'ASC');
        $this->db->where(['type_id' => $type_id]);

        $result = $this->db->get('luggage_product')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_luggage_by_id($id){

        if(empty($id) || !$this->valid->is_id($id)){
            return false;
        }

        $this->db->where(['product_id' => $id]);

        $result = $this->db->get('luggage_product')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }


    public function get_all_luggage(){

        $result = $this->db->get('luggage_product')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

}
?>