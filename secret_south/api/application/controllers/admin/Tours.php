<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Tours extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model("Tours_model");
    }

    public function add_tours(){

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

        $lat           = $this->input->post('lat');
        $lng           = $this->input->post('lng');
        $name          = $this->input->post('name');
        $tours_type_id = $this->input->post('tours_type_id');
        $address       = $this->input->post('address');
        $partner_id    = $this->input->post('partner_id');
     
        if(empty($name)){
            $response['message'] = 'Tour name is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($lat)){
            $response['message'] = 'Food/Drink latitude is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($lng)){
            $response['message'] = 'Food/Drink longitude is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }


        if(empty($address)){
            $response['message'] = 'Tour address is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($tours_type_id)){
            $response['message'] = 'Tour type is required';
            $response['status'] = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($partner_id)){
            $response['message'] = 'Partner is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }


        $url = '../uploads/tour';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $config['upload_path'] = $url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|png';
        $config['max_size'] = 4096;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('upload_image') == false) {

            $data['errors'] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $insert_data = [
            'name'          => $name,
            'address'       => $address,
            'tours_type_id' => $tours_type_id,
            'lat'           => $lat,
            'lng'           => $lng,
            'img'           => $file_info['file_name'],
            'partner_id'    => $partner_id,
        ];

        $result = $this->Tours_model->insert_tours($insert_data);

        if(!$result){
            $response['message'] = 'Data not saved please try again.';
            $response['status']  = '0';
        }

        echo json_encode($response);
    }

    public function add_tour_type(){

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

        $mixinf = $this->session->userdata('id').$this->session->userdata('name').$this->input->ip_address();
        $admin_mixinf = $this->encrypt_admin_pass($mixinf);

        $request_body =  file_get_contents('php://input');

        $req = json_decode($request_body);

        if(empty($req->mixinf != $admin_mixinf)){
            $response['message'] = 'Error!';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        if(empty($req->name)){
            $response['message'] = 'Tour type name is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $insert_data = [
            'tour_name' => $req->name
        ];

        $result = $this->Tours_model->insert_tours_type($insert_data);

        if(!$result){
            $response['message'] = 'Data not saved please try again.';
            $response['status']  = '0';
        }

        echo json_encode($response);

    }

    public function get_tour_type(){


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

        $result = $this->Tours_model->get_tours_type();

        if(empty($result)){
            $response['message'] = 'Empty Data';
            $response['status']  = '0';
        }

        $response['result'] = $result;
        echo  json_encode($response);
    }

    public function get_tour(){


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

        $result = $this->Tours_model->get_tours_and_type();

        if(empty($result)){
            $response['message'] = 'Empty Data';
            $response['status']  = '0';
        }

        $response['result'] = $result;
        echo  json_encode($response);
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