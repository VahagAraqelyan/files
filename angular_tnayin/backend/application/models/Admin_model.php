<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function get_login_info($username, $password){

        if(empty($username) || empty($password)){
            return false;
        }

        $sql="SELECT COUNT(*) as count FROM admins 
              WHERE 
              user_id='".$this->db->escape_str($username)."'";

        if(empty($this->db->query($sql)->row()->count)){

            return false;

        }

        $sql="SELECT * FROM admins 
              WHERE 
              user_id='".$this->db->escape_str($username)."' AND
              password='".$this->db->escape_str($password)."' AND
              status <> 0";


        return $this->db->query($sql)->row();

    }

    public function last_login($id){

        $sql="UPDATE admins SET 
              last_login_date='".date('Y-m-d H:i:s')."',
              last_login_ip='".$this->input->ip_address()."'
              WHERE
              admin_id='".$this->db->escape_str($id)."'";
        $this->db->query($sql);

    }

    public function get_account_info($id){

        $sql="SELECT admin_id, admin_name, email, user_id, status FROM admins 
              WHERE 
              admin_id='".$this->db->escape_str($id)."' AND
              status <> 0";

        return $this->db->query($sql)->row();

    }

    public function update_profile_info($id, $data){

        if(empty($id) || empty($data)){

            return false;

        }

        return $this->db->update('admins', $data, array('admin_id' => $id));

    }

    public function last_update($id){

        return $this->db->update('admins',
            ['update_date' => date('Y-m-d H:i:s')],
            ['admin_id'    => $id]
        );

    }

    public function get_admin_perm($admin_id){

        $this->db->select('permission');

        $result =  $this->db->get_where('admin_perm', ['admin_id' => $admin_id])->result_array();

        if(!empty($result)){

            $temp = $result;

            $result = [];

            foreach($temp as $single){
                $result[] = $single['permission'];
            }

        }

        return $result;

    }

    public function get_admin_info($admin_id = NULL){

        if(empty($admin_id)){
            return false;
        }

        return $this->db->get_where('admins', ['admin_id' => $admin_id])->row_array();

    }

    public function get_all_admins(){

        return $this->db->get('admins')->result_array();

    }

    public function delete_admin_perm($admin_id = NULL){

        if(empty($admin_id)){
            return false;
        }

        return $this->db->delete('admin_perm', ['admin_id' => $admin_id]);

    }

    public function insert_batch_admin_perm($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert_batch('admin_perm', $data);

        return $result;

    }

    public function add_admin($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert('admins', $data);

        if(empty($result)){
            return false;
        }

        return $this->db->insert_id();

    }

    public function delete_admin($admin_id){

        if(empty($admin_id)){
            return false;
        }

        return $this->db->delete('admins', ['admin_id' => $admin_id]);

    }

    public function check_admin_login_id($login_id){

        $result =  $this->db->get_where('admins', ['user_id' => $login_id])->result_array();

        if(empty($result)){
            return true;
        }

        return false;

    }

    public function check_admin_email_id($email){

        $result =  $this->db->get_where('admins', ['email' => $email])->result_array();

        if(empty($result)){
            return true;
        }

        return false;

    }

}
?>