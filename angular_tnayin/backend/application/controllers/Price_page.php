<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Price_page extends CI_Controller{


    public function __construct(){

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Home_model");
        $this->load->model("Check_price_model");
        $this->load->model("Manage_price_model");
        $this->lang->load('auth');
        $this->load->model("Ion_auth_model");
    }

    public function index(){

        $this->price_page();
    }

    public function price_page(){

        $this->load->library('Price_lib');

        if(empty($this->input->cookie('order')) || $this->input->cookie('order') == 'null'){
            redirect('home', 'refresh');
        }

        $shipping_data = $this->price_lib->shipping_data_from_cookie();
        $data_prod = $this->price_lib->price_types_data();

        if(empty($shipping_data)){
            redirect('home/home_page', 'refresh');
        }

        $this->load->config('check_price');

        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $data['config_times'] = $this->config->item('times');

        $data['city_from']    = $shipping_data['city_from'];
        $data['city_to']      = $shipping_data['city_to'];
        $data['date']         = $shipping_data['date'];
        $county_from          = $this->Users_model->get_countries($shipping_data['country_from']);
        $county_to            = $this->Users_model->get_countries($shipping_data['country_to']);
        $data['country_from'] = $county_from[0]['country'];
        $data['country_to']   = $county_to[0]['country'];

        $data['product'] = $data_prod;

        $data['content'] = 'frontend/price_page/price_page';

        $result = NULL;

        if($shipping_data['country_from'] == $shipping_data['country_to'] && $shipping_data['country_from'] == '226'){

            $result = $this->price_lib->_domestic_shipping($shipping_data['country_from'], $shipping_data['city_from'], $shipping_data['city_to'], $shipping_data['date'], $shipping_data['luggages'], $shipping_data['special']);
            $data['domestic'] = $this->_group_by_time_domes($result);

        }elseif($shipping_data['country_from'] != $shipping_data['country_to']){

            $result = $this->price_lib->_international_shipping($shipping_data['country_from'], $shipping_data['country_to'], $shipping_data['date'], $shipping_data['luggages'], $shipping_data['special']);
            $data['international'] = $this->_group_by_date_inter($result);
        }

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $total_count = 0;

        foreach($data['product'] as $single_prod){
            $temp_prod = $single_prod;
            unset($temp_prod['image']);
            $total_count += array_sum($temp_prod);
        }

        $price_show = 'YES';

        if(empty($data['domestic']) && empty($data['international'])){
            $price_show = 'NO';
        }

        $log_data = [
            'country_from' => $data['country_from'],
            'city_from'    => $data['city_from'],
            'country_to'   => $data['country_to'],
            'city_to'      => $data['city_to'],
            'user_ip'      => $this->input->ip_address(),
            'date'         => date('Y-m-d H:i:s'),
            'total_count'  => $total_count,
            'price_show'   => $price_show
        ];

        $this->log_price_results($log_data);

        $this->load->view("frontend/site_main_template",$data);

    }


    private function _group_by_date_inter($array){

        if(empty($array)){
            return false;
        }

        $return_array = [];

        foreach($array as $curier_name => $currier){
            foreach($currier as $tname => $type){
                $data = [
                    'curier' => $curier_name,
                    'price' => $type['price'],
                    'logo' => $type['logo'],
                    'weekday' => $type['weekday'],
                    'count' => $type['count'],
                    'send_type' => $tname
                ];
                $return_array[$type['date']][]=$data;
            }
        }

        if(empty($return_array)){
            return false;
        }

        ksort($return_array);

        return $return_array;

    }

    public function _group_by_time_domes($array){

        if(empty($array)){
            return false;
        }

        $return_array = [];

        $date_array = [];

        foreach($array as $curier_name => $send_types){
            foreach($send_types as $tname => $data){
                $return_array[$tname][$curier_name] = $data;
                $date_array[$tname] = $data['date'];
            }
        }

        if(empty($return_array)){
            return false;
        }

        asort($date_array);

        $sort_data = [];

        foreach($date_array as $type => $data){

            if(stripos($type, 'basic') !== FALSE){
                $basic_type = $type;
                $basic_data = $data;
                continue;
            }

            $sort_data[$type] = $return_array[$type];
        }

        if(!empty($basic_type) && !empty($basic_data)){
            $sort_data[$basic_type] =  $return_array[$basic_type];
        }

        return $sort_data;

    }


    public function ax_checkup_login(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $logged_in = true;

        if(!$this->ion_auth->logged_in()){

            $logged_in = false;

        }

        echo json_encode($logged_in);

    }

    public function ax_login(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }
        $this->load->library('captcha_lib');

        $data['captcha'] = $this->captcha_lib->get_captcha();
        $data['info']['account_num'] = '';
        $data['info']['user_name'] = '';

        $this->load->view('frontend/price_page/price_login',$data);

    }

    private function log_price_results($log_data){

        $file_name = date('Y-m-d').'_price_report.csv';

        $url = FCPATH.'reports';

        if(!is_dir($url)){
            mkdir($url, 775, true);
        }

        $url = $url.'/'.$file_name;

        $main_row = "Date,IP,From_Country,From_Zip_code,To_Country,To_Zip_code,Total_Pieces,Price_Show\n";
        $add_row = $log_data['date'].','.$log_data['user_ip'].','.$log_data['country_from'].','.$log_data['city_from'].','.$log_data['country_to'].','.$log_data['city_to'].','.$log_data['total_count'].','.$log_data['price_show']."\n";

        if(file_exists($url)){

            file_put_contents($url, $add_row, FILE_APPEND);

        }else{

            $row = $main_row.$add_row;

            file_put_contents($url, $row);

        }

    }


}