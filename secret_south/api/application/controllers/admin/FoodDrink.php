<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class FoodDrink extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model("FoodDrink_model");
    }

    public function add_food_drink(){

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

      /*  $mixinf = $this->session->userdata('id').$this->session->userdata('name').$this->input->ip_address();
        $admin_mixinf = $this->encrypt_admin_pass($mixinf);
      */
        $lat        = $this->input->post('lat');
        $lng        = $this->input->post('lng');
        $name       = $this->input->post('name');
        $partner_id = $this->input->post('partner_id');
        $desc       = $this->input->post('desc');
        $address    = $this->input->post('address');
     
        if(empty($name)){
            $response['message'] = 'Food/Drink name is required';
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

        if(empty($partner_id)){
            $response['message'] = 'Food/Drink partner is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }
        
        if(empty($desc)){
            $response['message'] = 'Food/Drink desc is required';
            $response['status']  = '0';
            echo  json_encode($response);
            return false;
        }

        $url = '../uploads/food_drink';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $config['upload_path'] = $url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
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
            'name'        => $name,
            'address'     => $address,
            'partner_id'  => $partner_id,
            'description' => $desc,
            'lat'         => $lat,
            'lng'         => $lng,
            'img'         => $file_info['file_name']
        ];

        $result = $this->FoodDrink_model->insert_food_drink($insert_data);

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

    private function encrypt_admin_pass($pass){

        if(empty($pass)){
            return false;
        }

        $salt = $this->config->item('salt');

        $pass = sha1($pass.$salt);

        return $pass;
    }
}