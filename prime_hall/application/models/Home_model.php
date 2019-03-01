<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function search_zip($table, $search){

        if(empty($search) || empty($table)){
            return false;
        }

        if($this->table_exists($table) == 0){
            return false;
        }

        $this->db->where('status', '1');

        $this->db->group_start();
        $this->db->like('zip', $search, 'after');
        $this->db->or_like('primary_city', $search, 'after');
        $this->db->group_end();

        $data = $this->db->get($table)->result_array();

        return $data;

    }

    public function check_zip_by_code($table, $search){

        if(empty($search) || empty($table)){
            return false;
        }

        if($this->table_exists($table) == 0){
            return false;
        }

        $this->db->where('zip',$search);
        $this->db->where('status', '1');

        $data = $this->db->get($table)->row_array();

        if(empty($data)){

            return false;
        }

        return true;
    }

    public function table_exists($table_name){

        if(empty($table_name)){
            return false;
        }

        $sql = "SHOW TABLES LIKE '".strtolower($table_name)."'";

        $data = $this->db->query($sql)->result_array();

        if (empty($data)){
            return 0;
        }

        return 1;
    }

}
?>