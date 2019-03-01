<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Ferry extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model("Ferry_model");

    }

    public function insert_ferry(){

        $response = [
            'status'  => '1',
            'message' => []
        ];

        if ($this->input->method() != 'post') {

            $response['message'] = 'error!';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }


        $request_body =  file_get_contents('php://input');

        $req = json_decode($request_body);

        if(empty($req->name)){
            $response['message'] = 'Ferry/Buss name is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->type)){
            $response['message'] = 'Type is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->email)){
            $response['message'] = 'Ferry/Buss Email  is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->maxPeople)){
            $response['message'] = 'Max People is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->minPeople)){
            $response['message'] = 'Min People is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->partner_id)){
            $response['message'] = 'Ferry/Buss partner is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if($req->minPeople>$req->maxPeople){
            $response['message'] = 'Min People is Max people';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $insert_data = [
            'name'       => $req->name,
            'email'      => $req->email,
            'max_people' => $req->maxPeople,
            'min_people' => $req->minPeople,
            'phone'      => $req->phone,
            'address'    => $req->address,
            'type'       => $req->type,
            'partner_id' => $req->partner_id,
        ];

        $result = $this->Ferry_model->insert_ferry($insert_data);

        if(!$result){
            $response['message'] = 'Data not saved please try again.';
            $response['status']  = '0';
        }

        echo json_encode($response);
    }

    public function get_all_ferry(){

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

        $result = $this->Ferry_model->get_ferry();

        if(empty($result)){
            $response['message'] = 'Empty Data';
            $response['status']  = '0';
        }

        $response['result'] = $result;
        echo  json_encode($response);
    }
}