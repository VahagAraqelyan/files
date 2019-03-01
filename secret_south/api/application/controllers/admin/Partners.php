<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Partners extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model("Partners_model");
    }

    public function add_partner(){

        $response = [
            'status'  => '1',
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

        if(empty($req->pass)){
            $response['message'] = 'Partner password is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->type)){
            $response['message'] = 'Partner type is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->firstName)){
            $response['message'] = 'Partner first name is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->lastName)){
            $response['message'] = 'Partner last name is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->email)){
            $response['message'] = 'Partner email is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $password = $this->encrypt_pass($req->pass);

        $insert_data = [
            'first_name' => $req->firstName,
            'last_name'  => $req->lastName,
            'email'      => $req->email,
            'password'   => $password,
            'type'       => $req->type,
        ];

        $result = $this->Partners_model->insert_partners($insert_data);

        if(!$result){
            $response['message'] = 'Data not saved please try again.';
            $response['status']  = '0';
        }

        echo json_encode($response);
    }

    public function get_partners(){

        $response = [
            'status'  => '1',
            'message' => []
        ];

        if ($this->input->method() != 'get') {

            $response['message'] = 'error!';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $result = $this->Partners_model->get_partners();

        if(empty($result)){
            $response['message'] = 'Empty Data';
            $response['status']  = '0';
        }

        $response['result'] = $result;
        echo  json_encode($response);

    }

    public function partner_login(){

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
            'email'    => $req->email,
            'password' => $password=$this->encrypt_pass($req->pass),
        ];

        $response['result'] = $this->_check_login($check_data);

        if(!empty($response['result'])){
            $response['status'] = 1;
        }

        echo json_encode($response);
    }

        public function _check_login($check_data){

        $partner_info=$this->Partners_model->get_partners($check_data,true);

        if(empty($partner_info)){
            return false;
        }

        $data=[
            'id'     => $partner_info['id'],
            'email'  => $partner_info['email'],
            'name'   => $partner_info['first_name'].$partner_info['last_name'],
            'type'   => $partner_info['type']
        ];

        $this->session->set_userdata($data);

        $return_data = [
            'status'  => 1,
            'admin_inf' =>$data
        ];

        return $return_data;

    }

    private function encrypt_pass($pass){

        if(empty($pass)){
            return false;
        }

        $salt = $this->config->item('salt');

        $pass = sha1($pass.$salt);

        return $pass;
    }
}