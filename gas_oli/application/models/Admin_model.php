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
              email='".$this->db->escape_str($username)."'";

        if(empty($this->db->query($sql)->row()->count)){

            return false;

        }

        $sql="SELECT * FROM admins 
              WHERE 
              email='".$this->db->escape_str($username)."' AND
              password='".$this->db->escape_str($password)."'";


        return $this->db->query($sql)->row();

    }

    public function last_login($id){

        $sql="UPDATE admins SET 
              last_login_date='".date('Y-m-d H:i:s')."'
              WHERE
              id='".$this->db->escape_str($id)."'";
        $this->db->query($sql);

    }

    public function get_account_info($id){

        $sql="SELECT id, name, email, root_admin FROM admins 
              WHERE 
              id='".$this->db->escape_str($id)."' ";

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

    public function get_admin_info($admin_id = NULL, $root = false){

        if(empty($admin_id)){
            return false;
        }

        if(!$root){
            $this->db->where('root_admin <>', '1');
        }

        return $this->db->get_where('admins', ['admin_id' => $admin_id])->row_array();

    }

    public function get_all_admins($root = false,$crt = NULL){

        if(!$root){
            $this->db->where('root_admin <>', '1');
        }

        if(!empty($crt)){
            $this->db->where($crt);
        }

        $result =  $this->db->get('admins')->result_array();

        return $result;
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

    public function update_admin($data,$id){

        if(empty($data) || empty($id)){
            return false;
        }

        $this->db->where('id',$id);
        $result = $this->db->update('admins', $data);

        if(empty($result)){
            return false;
        }

        return $result;

    }


    public function delete_admin($admin_id){

        if(empty($admin_id)){
            return false;
        }

        return $this->db->delete('admins', ['id' => $admin_id]);

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

    public function add_incorrect_attempts($admin_id){

        $this->db->set('incorrect_attempts', 'incorrect_attempts+1', FALSE);
        $this->db->where('admin_id', $admin_id);

        return $this->db->update('admins');

    }

}
?>