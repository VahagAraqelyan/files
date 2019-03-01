<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class home extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model("Home_model");
        $this->load->model("Ferry_model");
        $this->load->model("FoodDrink_model");
        $this->load->model("Partners_model");
        $this->load->model("Tours_model");
        $this->load->library('Google_api');

    }

    public function get_places(){

        $response = [
            'status'  => '1',
            'message' => [],
            'result'  => []
        ];

        if ($this->input->method() != 'get') {

            $response['message'] = 'error!';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $search = '';
        $result = [];

        $feryes = $this->Ferry_model->get_ferry();

        if(empty($feryes)){
             $response['message'] = 'Empty data';
             $response['status']  = '0';
        }

        $response['result'] = $feryes;
       
        echo  json_encode($response);
        
    }

    public function check_place(){

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

        $search = '';
        $result = [];

        $request_body =  file_get_contents('php://input');

        $req = json_decode($request_body);

        if(empty($req->type)){
            $response['message'] = 'Wrong data';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if($req->type == '1'){
            $data = $this->Ferry_model->get_ferry();
        }elseif($req->type == '2'){
            $data = $this->FoodDrink_model->get_food_drink();
        }else{
            $data = $this->Tours_model->get_tours();
        }

        if(empty($data)){
             $response['message'] = 'Empty data';
             $response['status']  = '0';
        }

        $response['result'] = $data;

        echo  json_encode($response);
    
    }

}

?>