<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Steersman_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_steersman($data){

        if(empty($data)){
            return false;
        }

        $this->db->insert('steersman',$data);

        return $this->db->insert_id();
    }

    public function update_steersman($id,$update_data){


        if(empty($id) || empty($update_data)){
            return false;
        }

        $this->db->where('id',$id);

        $result = $this->db->update('steersman',$update_data);
        return $result;
    }

    public function delete_crew($id){

        if(empty($id)){
            return false;
        }

        return $this->db->delete('steersman', array('id' => $id));

    }

    public function get_steersman($id){

        if(empty($id)){
            return false;
        }

        $this->db->where('id',$id);

        $result = $this->db->get('steersman')->row_array();

        return $result;
    }

    public function get_all_driver_count($cr = NULL){

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        $count = $this->db->count_all_results('steersman');

        return $count;
    }

    public function get_driver($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }


        $result = $this->db->get('steersman')->result_array();

        return $result;
    }

    public function get_all_driver($limit = NULL,$cr = NULL,$ordering){

        if(empty($ordering) || empty($limit)){

            return false;
        }

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);
        }

        $this->db->order_by($ordering[0], $ordering[1]);

        $this->db->limit($limit[0], $limit[1]);

        $result = $this->db->get('steersman')->result_array();

        return $result;
    }
}