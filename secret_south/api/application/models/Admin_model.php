<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    public function get_login_info($username,$password){

        if(empty($username) || empty($password)){
            return false;
        }

        $this->db->where('email', $username);
        $this->db->where('password', $password);

        $result = $this->db->get('admins')->row_array();

        if(empty($result)){

            return false;
        }

        return $result;
    }
}