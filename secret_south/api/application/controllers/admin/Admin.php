<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class admin extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Admin_model');
    }

    public function login(){

        $response = [
            'status'  => '0',
            'message' => [],
            'result'  => []
        ];

        if ($this->input->method() != 'post') {

            $response['message'] = 'error!';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }


        $request_body =  file_get_contents('php://input');

        $req = json_decode($request_body);

        if(empty($req->email)){
            $response['message'] = 'Please set email';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->pass)){
            $response['message'] = 'Please set password';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $check_data = [
            'email' => $req->email,
            'pass'  => $password=$this->encrypt_admin_pass($req->pass),
        ];

        $response['result'] = $this->_check_login($check_data);

        if(!empty($response['result'])){
            $response['status'] = 1;
        }

        echo json_encode($response);

    }

    public function _check_login($check_data){

        $admin_info=$this->Admin_model->get_login_info($check_data['email'], $check_data['pass']);

        if(empty($admin_info)){
            return false;
        }

        $mixinf = $admin_info['id'].$admin_info['name'].$this->input->ip_address();
        $mixinf = $this->encrypt_admin_pass($mixinf);

        $data=[
            'id'           => $admin_info['id'],
            'admin_email'  => $admin_info['email'],
            'admin_name'   => $admin_info['name'],
            'is_root'      => $admin_info['root_admin'],
            'admin_session_inf' => $mixinf
        ];

        $this->session->set_userdata($data);

        $return_data = [
            'status'  => 1,
            'admin_inf' =>$data
        ];

        return $return_data;

    }

    private function encrypt_admin_pass($pass){

        if(empty($pass)){
            return false;
        }

        $salt = $this->config->item('salt');

        $pass = sha1($pass.$salt);

        return $pass;
    }
}