<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class home extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Home_model");

    }

    public function index(){

        $this->home_page();
    }

    public function home_page(){


    }

    public function zip_code_isset(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            return false;

        }

        $country_id = $this->input->post('country');

        if(!$this->valid->is_id($country_id)){
            return false;
        }

        $country = $this->Users_model->get_countries($country_id);

        if(empty($country)){
            return false;
        }

        $iso2 = $country[0]['iso2'];

        $table_name = 'lts_'.strtolower($iso2).'_zipcode';

        $respons = $this->Home_model->table_exists($table_name);

        echo $respons;

    }

    public function search_zip_code(){

        if ($this->input->method() != "post" || !$this->input->is_ajax_request()) {
            show_404();
        }

        $search_string = trim($this->input->post("search"));
        $input_id = $this->input->post("inputid");
        $data['check_zip'] = true;
        $country_id =  $this->input->post("country_id");

        if(!$this->valid->is_id($country_id)){

            echo "no data";
            return false;

        }

        $country = $this->Users_model->get_countries($country_id);

        if(empty($country)){
            return false;
        }

        $iso2 = $country[0]['iso2'];

        $table_name = 'lts_'.strtolower($iso2).'_zipcode';

        $zipcode_array = $this->Home_model->search_zip($table_name, $search_string);

        if(empty($zipcode_array)){

           echo "no data";
            return false;

        }


        $data = [
            "zip_codes_array" => $zipcode_array,
            "input_id" => $input_id
        ];

        $this->load->view('frontend/home/answer_zip_code', $data);
    }


    public function check_zip_code(){

        if ($this->input->method() != "post" || !$this->input->is_ajax_request()) {
            return false;
        }

        $search_string = trim($this->input->post("search"));
        $data_name = trim($this->input->post("data_name"));
        $input_id = $this->input->post("inputid");
        $data['check_zip'] = true;
        $country_id =  $this->input->post("country_id");

        if(!$this->valid->is_id($country_id)){

            $data['check_zip'] = true;
            echo json_encode($data);
            return false;

        }

        if(empty($search_string)){

            $data['check_zip'] = true;
            echo json_encode($data);
            return false;
        }

        $us_id = $this->Users_model->get_us_country();
        if(!empty($us_id[0]['id'])){
            $us_id = $us_id[0]['id'];

        }else{
            $us_id = '';
        }

        if($country_id != $us_id){

            $data['check_zip'] = true;
            echo json_encode($data);
            return false;
        }

        $country = $this->Users_model->get_countries($country_id);

        if(empty($country)){
            return false;
        }

        $iso2 = $country[0]['iso2'];

        $table_name = 'lts_'.strtolower($iso2).'_zipcode';

        $search_string = preg_replace('/[^0-9]+/', '', $search_string);

        $zipcode_array = $this->Home_model->check_zip_by_code($table_name, $search_string);

        if(empty($zipcode_array)){

            $data['check_zip'] = false;
            $data['input_id'] = $input_id;
            $data['data_name'] = $data_name;
            echo json_encode($data);
            return false;

        }

        echo json_encode($data);

    }

    public function rsh(){
        var_dump(phpversion());
        var_dump(extension_loaded ('mbstring'));
        var_dump(extension_loaded ('gd'));
        var_dump(extension_loaded ('dom'));
    }

}

?>