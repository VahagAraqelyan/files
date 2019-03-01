<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_keys_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function get_key_info($key){

        if(empty($key)){
            return false;
        }

        $this->db->where('key', $key);

        $result = $this->db->get('admin_keys')->row_array();

        return $result;

    }

    public function add_new_key($data){

        if(empty($data['admin_id']) || empty($data['key'])){
            return false;
        }

        return $this->db->insert('admin_keys', $data);

    }

    public function update_key($data, $admin_id){

        if(empty($data) || empty($admin_id)){
            return false;
        }

        $this->db->where('admin_id', $admin_id);
        return $this->db->update('admin_keys', $data);

    }

    public function get_key_by_admin_id($admin_id){

        if(empty($admin_id)){
            return false;
        }

        $this->db->where('admin_id', $admin_id);

        $result = $this->db->get('admin_keys')->row_array();

        return $result;

    }

    public function get_all_keys(){

        $this->db->select('admins.admin_name, admins.user_id, admins.login_with_key, admins.admin_id AS adm_id, admin_keys.*, admin_keys.id AS key_id');
        $this->db->from('admins');
        $this->db->join('admin_keys', 'admins.admin_id = admin_keys.admin_id', 'left');
        $this->db->where('admins.root_admin<>', '1');

        $result = $this->db->get()->result_array();

        return $result;

    }

    public function update_keys_statuse(){

        $where = [
            'end_date <' => date('Y-m-d')
        ];

        return $this->db->update('admin_keys', ['status' => '0'], $where);

    }

}
?>