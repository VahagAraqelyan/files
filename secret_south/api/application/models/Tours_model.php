<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tours_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_tours($data){

        if(empty($data)){
            return false;
        }

        return $this ->db->insert('tours',$data);
    }

    public function insert_tours_type($data){

        if(empty($data)){
            return false;
        }

        return $this ->db->insert('tours_type',$data);
    }

    public function get_tours($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        return $this->db->get('tours')->result_array();
    }

    public function get_tours_and_type($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        $this->db->select('tours.*,tours_type.tour_name AS type_name');
        $this->db->join('tours_type', 'tours_type.id = tours.tours_type_id');
        return $this->db->get('tours')->result_array();
    }

    public function get_tours_type($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        return $this->db->get('tours_type')->result_array();
    }
}