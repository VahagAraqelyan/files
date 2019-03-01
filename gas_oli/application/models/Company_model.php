<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_company($data,$return_bool = NULL){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert('company',$data);

        if($return_bool){
            return $this->db->insert_id();
        }

        return $result;
    }

    public function get_company_id_by_name($name){

        if(empty($name)){
            return false;
        }

        $this->db->where('name', $name);

        $result =  $this->db->get('company')->row_array();

        if(empty($result)){
            return false;
        }

        return $result['id'];
    }

    public function get_all_company(){


        $result =  $this->db->get('company')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function get_company_by_crt($crt,$bool = false){

        if(empty($crt)){
            return false;
        }

        $this->db->where($crt);

        if(!$bool){
            return $result =  $this->db->get('company')->result_array();
        }

        return $result =  $this->db->get('company')->row_array();
    }

    public function update_company($id,$update_data){

        $this->db->where('id', $id);

        $result = $this->db->update('company', $update_data);

        return $result;

    }

    public function delete_company($id){

        if(empty($id)){
            return false;
        }

        return $this->db->delete('company', array('id' => $id));
    }

    public function get_company_name_by_id($id){


        if(empty($id)){
            return false;
        }

        $this->db->where('id', $id);

        $result =  $this->db->get('company')->row_array();

        if(empty($result)){
            return false;
        }

        return $result['name'];
    }

    public function get_company($limit = NULL,$cr = NULL,$ordering){

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

        $result = $this->db->get('company')->result_array();

        return $result;
    }

    public function get_company_count($cr = NULL){

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        $count = $this->db->count_all_results('company');

        return $count;
    }
}