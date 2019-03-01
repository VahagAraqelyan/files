<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Order extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->library('captcha_lib');
        $this->load->library('payment_lib');
        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Check_price_model");
        $this->load->model("Manage_price_model");
        $this->load->model("Billing_model");
        $this->load->model("Order_model");
        $this->load->model("Lists_model");
        $this->config->load('order');
        $this->load->library('Price_lib');
        $this->load->library('General_email');

    }

    public function order_processing($order_id){

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            show_404();
            return false;
        }

        if(empty($order_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        $this->check_admin_freeze($order_info);
        $admin_tool = $this->check_admin_freeze($order_info, true);

        if(empty($order_info)){
            show_404();
        }

        $this->Order_model->set_order_last_use($order_id);

        $incurance_data = $this->Order_model->get_incurance($order_id);


        $insurance = 0;
        $max_incurance = 0;

        if(!empty($incurance_data)){
            foreach ($incurance_data as $data){

                $insurance += $data['insurance'];
                $max_incurance += $data['incurance_fee'];

            }
        }

        if(!empty($incurance_data)){

            foreach ($incurance_data as $index => $incurance){

                if(empty($incurance['incurance_fee'])){

                    $incurance_data[$index]['incurance_fee'] = 0;
                    $incurance_data[$index]['insurance'] = $order_info['free_insurance'];
                }
            }

            $data['incurance'] = $incurance_data;

        }else{

            $data['prod'] = $this->Order_model->get_luggage_order($order_id);
        }

        $data['incurance'] = $incurance_data;
        $data['country'] = [];
        $data['delivery_info'] = [];

        $delivery_label = $this->Order_model->get_delivery_label($order_id);

        if(!empty($delivery_label)){

            $data['delivery_info'] = $delivery_label;
        }
        $country = $this->Users_model->get_countries($delivery_label['country_id']);

        if(!empty($country[0]['country'])){

            $data['country'] = $country[0]['country'];
        }

        $procesing_fee =$this->Manage_price_model->get_processing_fee($delivery_label['country_id']);

        if(!empty($procesing_fee[0])){

            $data['procesing_fee'] = $procesing_fee[0];
        }

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);

        $price = 0;
        if(!empty($price_array) && !empty($price_array['original_price'])){
            $price = $price_array['original_price'];
        }
        $data['sender_class']   = $this->_check_info_isset($order_id, 'pick_up');
        $data['delivery_class'] = $this->_check_info_isset($order_id, 'delivery');
        $data['payment_class']  = $this->_check_info_isset($order_id, 'credit_card');
        $data['item_name'] = $order_info['signature'];
        $data['passport_info'] = [];
        $data['travel'] = [];

        if($order_info['order_type'] == 1){

            $passport_info  = $this->Order_model->get_order_passport_info($order_id);
            $travel = $this->Order_model->get_travel($order_id);
        }

        if(!empty($passport_info)){

            $data['passport_info'] = $passport_info;

        }

        if(!empty($travel)){

            $data['travel'] = $travel;
        }

        $data['luggage_info'] = $this->Order_model->get_luggage_order($order_id);

        $data['incurance_fee']       = $max_incurance;
        $data['title']               = $this->price_lib->get_status_title($order_info['shipping_status']);
        $data['incurance_zero']      = $insurance;
        $data['order_info']          = $order_info;
        $data['order_info']['price'] = $price;
        $data_prod                   = $this->_set_luggage_order($order_id);

        $data['count'] = $data_prod['count'];
        unset($data_prod['count']);

        $data['data_prod'] = $data_prod;
        $this->load->config('payment_config');

        $data['public_key']        = $this->config->item('stripe_public_key');
        $data['sender_info']       = $this->Order_model->get_pickup_info($order_id);
        $data['content']           = 'frontend/price_page/order_processing';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';
        $data['admin_tool']        = $admin_tool;

        $del_ifo = $this->Order_model->get_delivery_info($order_id);
        $pick_up_inf = $this->Order_model->get_pickup_info($order_id);
        $incurance_info =  $this->_set_incurance($order_id,$pick_up_inf['pickup_country_id'],$order_info['shipping_type']);
        $data['incurance_info'] = $incurance_info;
        $data['delivery_state'] = '';
        $data['pickup_state']   =  '';

        $delivery_state = $this->Order_model->get_states_by_id($del_ifo['delivery_state']);

        if(!empty($delivery_state)){

            $data['delivery_state'] = $delivery_state['State'];
        }

        $pickup_state = $this->Order_model->get_states_by_id($pick_up_inf['pickup_state']);

        if(!empty($pickup_state)){

            $data['pickup_state'] = $pickup_state['State'];
        }

        $data['pickup_country_id'] = $pick_up_inf['pickup_country_id'];

        if(!empty($del_ifo['delivery_country_id'])){
            $data['delivery_country_id'] = $del_ifo['delivery_country_id'];
        }

        $user = $this->ion_auth->user()->row();

        $data['info']=[
            'user_name'          => $user->first_name,
            'account_num'        => $user->account_name
        ];

        $this->load->view('frontend/site_main_template', $data);

    }

    public function custom_documents($order_id = NULL,$tab_panel = NULL){

        $this->_check_login(true);

        if(empty($order_id)){
            show_404();
            return false;
        }

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];

        if(!empty($item_list)){

            $data['order_item_list'] = $item_list;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        if($order_info['shipping_type'] != 1){

            show_404();
            return false;
        }

        $data['sender_info'] = $this->Order_model->get_pickup_info($order_id);
        $data['delivery_info'] = $this->Order_model->get_delivery_info($order_id);

        $country = $this->Users_model->get_countries($data['delivery_info']['delivery_country_id']);

        if(!empty($country[0]['iso2'])){

            $iso = $country[0]['iso2'];
        }

        $country_profile = $this->Manage_price_model->get_country_profile($iso);

        if(empty($country_profile)){

            $data['custom_value'] = 0;
        }else{

            $data['custom_value'] = $country_profile[0]['custom_value'];
        }

        $data['item_name'] = $this->Lists_model->get_data_by_list_key('item_name');

        $data['passport_info'] = [];
        $data['travel'] = [];

        $passport_info  = $this->Order_model->get_order_passport_info($order_id);
        $travel = $this->Order_model->get_travel($order_id);


        if(!empty($passport_info)){

            $data['passport_info'] = $passport_info;

        }

        if(!empty($travel)){

            $data['travel'] = $travel;
        }

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);
        $price = 0;
        if(!empty($price_array) && !empty($price_array['original_price'])){
            $price = $price_array['original_price'];
        }

        $country_info = $this->Users_model->get_countries($data['delivery_info']['delivery_country_id'], true);

        if(!empty($country_info['country'])){

            $data['country'] = $country_info['country'];
        }

        $data['order_info'] = $order_info;
        $data['tab'] = $tab_panel;
        $data['order_info']['price'] = $price;
        $data['title']         = $this->price_lib->get_status_title($order_info['shipping_status']);
        $data['content'] = 'frontend/orders/international/custom_documents';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        $data['info']=[
            'user_name'          => $user->first_name,
            'account_num'        => $user->account_name
        ];

        $this->load->view('frontend/site_main_template', $data);

    }

    /*    public function send_item_list_email($order_id){

            if(empty($order_id)){
                return false;
            }

            $item_list = $this->Order_model->get_item_list($order_id);
            $user = $this->ion_auth->user()->row();
            $order_info = $this->Order_model->get_order_info($order_id,$user->id);
            $passport_info  = $this->Order_model->get_order_passport_info($order_id);
            $travel = $this->Order_model->get_travel($order_id);

            if((empty($item_list) && empty($order_info['signature'])) || empty($passport_info) || empty($travel) ){

                return false;
            }

            $send_data = [
                'order_number'   => $order_info['order_id'],
                'country_to'     => NULL,
                'comertial'      => NULL,
                'quantity'       => NULL,
                'declared_value' => NULL,
                'order_id'       => $order_info['order_id'],
            ];


            $delivery_info = $this->Order_model->get_delivery_info($order_id);
            $quantity = 0;
            $declared_value = 0;
            foreach ($item_list as $single){

                $quantity += $single['item_count'];
                $declared_value += $single['item_price'];
            }

            $send_data['quantity'] = $quantity;
            $send_data['declared_value'] = $declared_value;
            $send_data['comertial'] = 'Commercial Use';
            $send_data['email'] = $user->email;
            $send_data['username'] = $user->username;
            $key = 'item_list_comertial_use';

            if($order_info['order_type'] == 1){
                $send_data['comertial'] = 'Personal Effects';
                $key = 'item_list_personal_effect';
            }

            $send_data['country_to'] = $delivery_info['delivery_country_id'];

            $email_data = array(
                'email'     =>  $user->email,
                'to_name'   =>  $user->username,
                'subject'   => 'Thank you for submitting the item list for custom clearance – ' . $user->account_name,
                'variables' =>  $send_data
            );

            $this->general_email->send_email($key,$email_data);

        }*/

    public function custom_documents_view($order_id){

        $this->_check_login(true);

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];

        if(!empty($item_list)){

            $data['order_item_list'] = $item_list;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id,$user->id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        if($order_info['shipping_type'] != 1){

            show_404();
            return false;
        }

        $data['sender_info']  = $this->Order_model->get_pickup_info($order_id);

        $data['delivery_info'] = $this->Order_model->get_delivery_info($order_id);
        $country = $this->Users_model->get_countries($data['delivery_info']['delivery_country_id']);

        if(!empty($country[0]['iso2'])){

            $iso = $country[0]['iso2'];
        }

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];
        /*$data['status_array'] = $this->config->item('status_array');*/
        $data['title']         = $this->price_lib->get_status_title($order_info['shipping_status']);
        $travel_info_file = $this->Order_model->get_travel_files($order_id,$user->id);

        $data['travel_info_file'] = [];

        if(!empty($travel_info_file)){

            $data['travel_info_file'] = $travel_info_file;
        }
        if(!empty($item_list)){

            $data['order_item_list'] = $item_list;
        }

        $country_id = $data['delivery_info']['delivery_country_id'];
        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info)){

            show_404();
            return false;
        }

        if(empty($country_profile)){

            $data['custom_value'] = 0;
        }else{

            $data['custom_value'] = $country_profile[0]['custom_value'];
        }

        $data['uploaded_document'] = $this->Order_model->get_order_form_document($order_id);

        $data['form_files'] = $this->Manage_price_model->get_currier_document($country_id, '1');

        $data['country_info'] = $country_info;
        $country_profile = $this->Manage_price_model->get_country_profile($iso);

        if(empty($country_profile)){

            $data['custom_value'] = 0;
        }else{

            $data['custom_value'] = $country_profile[0]['custom_value'];
        }

        $data['item_name'] = $this->Lists_model->get_data_by_list_key('item_name');

        $data['passport_info'] = [];
        $data['travel'] = [];

        $passport_info  = $this->Order_model->get_order_passport_info($order_id);
        $travel = $this->Order_model->get_travel($order_id);

        if(!empty($passport_info)){

            $data['passport_info'] = $passport_info;

        }

        $data['all_countries'] = [];
        $all_countries = $this->Users_model->get_countries();

        if(!empty($all_countries)){
            $data['all_countries'] = $all_countries;
        }

        if(!empty($travel)){

            $data['travel_info'] = $travel;
        }

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);
        $price = 0;
        if(!empty($price_array) && !empty($price_array['original_price'])){
            $price = $price_array['original_price'];
        }

        $data['order_info'] = $order_info;
        $data['content'] = 'frontend/orders/international/custom_document_view';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        $data['info']=[
            'user_name'          => $user->first_name,
            'account_num'        => $user->account_name
        ];

        $this->load->view('frontend/site_main_template', $data);

    }

    public function new_order(){

        $this->_check_login(true);

        if(empty($this->input->cookie('order'))){
            // redirect them to the home page
            redirect('home/home_page', 'refresh');
            return false;
        }

        $shipping_data = $this->price_lib->shipping_data_from_cookie();

        if(empty($shipping_data)){
            redirect('home/home_page', 'refresh');
            return false;
        }

        $selected = $this->input->cookie('ship_met');

        if(empty($selected)){
            redirect('home/home_page', 'refresh');
            return false;
        }

        $country_from = $this->Users_model->get_countries($shipping_data['country_from'], true);
        $country_to   = $this->Users_model->get_countries($shipping_data['country_to'], true);

        if(empty($country_from) || empty($country_to)){
            redirect('home/home_page', 'refresh');
            return false;
        }

        $product_arr   = json_decode($this->input->cookie('order'),true);
        $count_product = $this->_get_count_by_cookie($product_arr);

        if($shipping_data['country_from'] == $shipping_data['country_to'] && $shipping_data['country_from'] == '226'){

            $result = $this->price_lib->_domestic_shipping($shipping_data['country_from'], $shipping_data['city_from'], $shipping_data['city_to'], $shipping_data['date'], $shipping_data['luggages'], $shipping_data['special']);
            $shipping_type = '2';

        }elseif($shipping_data['country_from'] != $shipping_data['country_to']){

            $result = $this->price_lib->_international_shipping($shipping_data['country_from'], $shipping_data['country_to'], $shipping_data['date'], $shipping_data['luggages'], $shipping_data['special']);
            $shipping_type = '1';
        }

        $select = explode('->',$selected);

        if(count($select) != 2){
            redirect('home/home_page', 'refresh');
        }

        if(empty($result[$select[0]][$select[1]])){
            redirect('home/home_page', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        $currier = $select[0];

        $currier_info = $this->Order_model->get_carrier_by_name($currier);

        if(empty($currier_info)){
            redirect('home/home_page', 'refresh');
            return false;
        }

        $type = str_replace('_',' ',$select[1]);

        $selected = $result[$select[0]][$select[1]];

        if(!empty($selected['count'])){

            $day_count = $selected['count'];
        }else{

            $day_count = preg_replace('/[^0-9]+/', '', $select[1]);
        }

        if($shipping_type == '1'){

            if(stripos($type, 'outbound') !== false){

                $country_id = $shipping_data['country_from'];

            }elseif (stripos($type, 'inbound') !== false){
                $country_id = $shipping_data['country_to'];

            }

            $all_insurance = $this->Manage_price_model->get_international_insurance($country_id);

        }elseif ($shipping_type == '2'){

            $all_insurance = $this->Manage_price_model->get_domestic_insurance($shipping_data['country_from']);
        }


        $insurance = NULL;
        if(!empty($all_insurance)){

            foreach ($all_insurance as $incurance){

                if(empty($incurance['insurance_fee']) && !empty($incurance['insurance_amount'])){

                    $insurance = $incurance['insurance_amount'];
                }
            }
        }

        $zone = NULL;
        if(!empty($selected['zone'])){
            $zone = $selected['zone'];
        }

        $insert_order_data = [
            'user_id'             => $user->id,
            'price'               => $selected['price'],
            'free_insurance'      => $insurance,
            'shipping_type'       => $shipping_type,
            'shipping_status'     => INCOMPLETE_STATUS[0],
            'created_date'        => date('Y-m-d H:i:s'),
            'currier_name'        => $currier,
            'currier_shippo_id'   => $currier_info['shippo_id'],
            'send_type'           => $type,
            'origin_send_type'    => $type,
            'origin_carrier_name' => $currier,
            'card_id'             => NULL,
            'delivery_day_count'  => $day_count,
            'pick_up_check'       => $this->_check_pick_up($currier, $type, $shipping_data['date'], $shipping_type, $shipping_data['country_from']),
            'domestic_zone'       => $zone
        ];

        if(empty($this->input->cookie('changed_order'))){
            $insert_order_data['order_id'] = $this->_generate_order_id($user);
        }

        $user_info = $this->Users_model->get_user_info($user->id);

        $zip_code_1 = preg_replace('/[^0-9]+/', '', $shipping_data['city_from']);
        $zip_code_2 = preg_replace('/[^0-9]+/', '', $shipping_data['city_to']);

        $table_name_from = strtolower('lts_'.$country_from['iso2'].'_zipcode');
        $table_name_to = strtolower('lts_'.$country_to['iso2'].'_zipcode');

        $data_from = $this->Order_model->get_data_by_zip_code($table_name_from, $zip_code_1);
        $data_to = $this->Order_model->get_data_by_zip_code($table_name_to, $zip_code_2);

        if(!empty($data_from)){

            $state_1 = $data_from['full_state'];
            $city_1  = $data_from['primary_city'];
        }else{

            $state_1 = NULL;
            $city_1  = NULL;
        }

        if(!empty($data_to)){

            $state_2 = $data_to['full_state'];
            $city_2  = $data_to['primary_city'];

        }else{

            $state_2 = NULL;
            $city_2  = NULL;
        }

        $state_from = $this->Order_model->get_states_by_name($state_1, $country_from['id']);
        $state_to   = $this->Order_model->get_states_by_name($state_2, $country_to['id']);

        if(!empty($state_from['Stateid'])){

            $state_from = $state_from['Stateid'];
        }else{
            $state_from = NULL;
        }

        if(!empty($state_to['Stateid'])){

            $state_to = $state_to['Stateid'];
        }else{
            $state_to = NULL;
        }

        $us_id = NULL;

        $us = $this->Users_model->get_us_country(true);

        if(!empty($us)){
            $us_id = $us['id'];
        }

        $insert_delivery_label = [
            'country_id'  => $us_id,
        ];

        /*$insert_delivery_label = [
            'country_id'  => $shipping_data['country_from'],
        ];*/

        if($shipping_type == 1){

            $time = '09:00am to 06:00pm';

            $pick_up_data = [
                'pickup_country_id'  => $shipping_data['country_from'],
                'shipping_date'      => $shipping_data['date'],
                'pickup_postal_code' => $zip_code_1,
                'pickup_city'        => $city_1,
                'pickup_state'       => $state_from,
                'pick_up'            => NULL
            ];

            $delivery_data = [
                'delivery_country_id'  => $shipping_data['country_to'],
                'delivery_date'        => $selected['date'],
                'delivery_postal_code' => $zip_code_2,
                'delivery_city'        => $city_2,
                'delivery_state'       => $state_to,
                'delivery_time'        => $time
            ];

        }else{

            if(empty($data_from) || empty($data_to)){
                redirect('home/home_page', 'refresh');
            }

            $names = explode('_',$select[1]);

            $this->load->config('check_price');

            $times = $this->config->item('times');

            $time = $times['default'];

            if(in_array('morning', $names)){
                $time = $times['morning'];
            }

            if(in_array('afternoon', $names)){
                $time = $times['afternoon'];
            }

            if(end($names) == '+Sat'){
                $time = $times['sat'];
            }

            $pick_up_data = [
                'pickup_postal_code' => $zip_code_1,
                'pickup_city'        => $data_from['primary_city'],
                'pickup_state'       => $state_from,
                'pickup_country_id'  => $shipping_data['country_from'],
                'shipping_date'      => $shipping_data['date'],
                'pick_up'            => NULL,
            ];

            $delivery_data = [
                'delivery_postal_code' => $zip_code_2,
                'delivery_city'        => $data_to['primary_city'],
                'delivery_state'       => $state_to,
                'delivery_country_id'  => $shipping_data['country_to'],
                'delivery_date'        => $selected['date'],
                'delivery_time'        => $time
            ];
        }

        $price_details = $selected['price_details'];

        $billing_array = [
            'order_id'         => NULL,
            'user_id'          => $user->id,
            'type'             => 'estimate',
            'shipping_fee'     => $price_details['shipping_fee'],
            'oversize_fee'     => $price_details['oversize_fee'],
            'process_fee'      => $price_details['processing_fee'],
            'special_handling' => $price_details['special_handling'],
            'account_credit'   => $user_info['account_credit']
        ];

        if(!empty($price_details['saturday_delivery_fee'])){
            $billing_array['shipping_fee'] = $billing_array['shipping_fee'] + $price_details['saturday_delivery_fee'];
        }
        // UPDATE ORDER

        if(!empty($order_id = $this->input->cookie('changed_order'))){

            unset($insert_order_data['shipping_status']);

            if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
                show_404();
                return false;
            }

            $billing_array['promotion_code'] = NULL;
            $billing_array['insurance_fee']  = NULL;

            $insert_order_data['interest_discount'] = NULL;
            $insert_order_data['discount_code']     = NULL;
            $insert_order_data['update_order']      = 1;
            $billing_array['pickup_fee']            = NULL;

            if(!$this->check_admin_freeze($order_id, true)){
                $insert_order_data['shipping_status'] = INCOMPLETE_STATUS[0];
            }

            if(!$this->Order_model->update_order($order_id, $insert_order_data)){
                show_404();
                return false;
            }

            $old_pick_up = $this->Order_model->get_pickup_info($order_id);
            $old_delivery = $this->Order_model->get_delivery_info($order_id);

            $pick_up_data['pick_up']           = NULL;
            $pick_up_data['pickup_time']       = NULL;
            $pick_up_data['pickup_price']      = NULL;


            if($pick_up_data['pickup_country_id'] != $old_pick_up['pickup_country_id'] || $pick_up_data['pickup_postal_code'] != $old_pick_up['pickup_postal_code']){

                $pick_up_data['sender_first_name'] = NULL;
                $pick_up_data['sender_last_name']  = NULL;
                $pick_up_data['sender_phone']      = NULL;
                $pick_up_data['sender_email']      = NULL;
                $pick_up_data['pickup_company']    = NULL;
                $pick_up_data['pickup_address1']   = NULL;
                $pick_up_data['pickup_address2']   = NULL;
                $pick_up_data['pickup_remark']     = NULL;

            }else{

                $pick_up_data['pickup_city']  = $old_pick_up['pickup_city'];
                $pick_up_data['pickup_state'] = $old_pick_up['pickup_state'];
            }

            if($delivery_data['delivery_country_id'] != $old_delivery['delivery_country_id'] || $delivery_data['delivery_postal_code'] != $old_delivery['delivery_postal_code']){

                $delivery_data['receiver_first_name'] = NULL;
                $delivery_data['receiver_last_name']  = NULL;
                $delivery_data['receiver_phone']      = NULL;
                $delivery_data['receiver_email']      = NULL;
                $delivery_data['without_signature']   = NULL;
                $delivery_data['delivery_company']    = NULL;
                $delivery_data['delivery_address1']   = NULL;
                $delivery_data['delivery_address2']   = NULL;
                $delivery_data['delivery_remark']     = NULL;

            }else{

                $delivery_data['delivery_city'] = $old_delivery['delivery_city'];
                $delivery_data['delivery_state'] = $old_delivery['delivery_state'];
            }

            $insert_delivery_label['order_id'] = $order_id;

            $pick_up_data['order_id'] = $order_id;
            $delivery_data['order_id'] = $order_id;

            $last_billing = $this->Billing_model->check_last_billing($order_id);
            $billing_type = $last_billing['next'];

            $billing_array['type'] = $billing_type;
            $billing_array['order_id'] = $order_id;

            if($billing_array['type'] != 'estimate'){
                $billing_array['status'] = '1';
            }

            $crt = [
                'order_id' => $order_id,
                'type'     => $billing_type
            ];

            $ititial = $this->Billing_model->get_billing($crt);

            if(empty($ititial)){

                $this->Billing_model->insert_billing_info($billing_array);

            }else{

                $this->Billing_model->update_billing_info($billing_array, $order_id, $billing_type);
            }

            $select_items = $this->_order_select_items($product_arr, $order_id, $selected['country']);

            $this->Order_model->update_pickup_info($pick_up_data, $order_id);
            $this->Order_model->update_delivery_info($delivery_data, $order_id);

            // Order item updating
            $this->update_order_items($order_id,$select_items);

            $this->Order_model->delete_order_incurance($order_id);
            $this->_insert_insurance($order_id);
            $this->Order_model->update_delivery_label($insert_delivery_label, $order_id);

            delete_cookie('order');
            delete_cookie('changed_order');
            delete_cookie('ship_met');

            set_cookie('from_update', 'true', 3600);

            redirect('order/order_processing/'.$order_id, 'refresh');

            return true;

        }

        if(empty($order_id = $this->Order_model->insert_order($insert_order_data))){

            redirect('home/home_page', 'refresh');

        }else{

            $this->Order_model->update_total_order_count($user->id);
        }

        $pick_up_data['order_id'] = $order_id;
        $delivery_data['order_id'] = $order_id;
        $insert_delivery_label['order_id'] = $order_id;
        $billing_array['order_id'] = $order_id;

        $select_items = $this->_order_select_items($product_arr, $order_id, $selected['country']);

        $this->Order_model->insert_pickup_info($pick_up_data);
        $this->Order_model->insert_delivery_info($delivery_data);
        $this->Order_model->insert_order_items($select_items);
        $this->Order_model->insert_delivery_label($insert_delivery_label);
        $this->Billing_model->insert_billing_info($billing_array);
        $this->_insert_insurance($order_id);

        delete_cookie('order');
        delete_cookie('ship_met');

        redirect('order/order_processing/'.$order_id, 'refresh');

    }

    public function ax_update_item_or_service(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $user = $this->ion_auth->user()->row();

        $data['errors'] = [];
        $data['success'] = [];

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $pick_up_info   = $this->Order_model->get_pickup_info($order_id);
        $delivery_info  = $this->Order_model->get_delivery_info($order_id);
        $order_products = $this->Order_model->get_luggage_order($order_id);

        if(empty($pick_up_info) || empty($delivery_info) || empty($order_products)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $cookie_order = $this->_get_order_data_for_cookie($order_products);

        if(empty($cookie_order)){
            $data['errors'][] = 'Incorrect luggage information';
            echo json_encode($data);
            return false;
        }

        $cookie_order['country_from']  = $pick_up_info['pickup_country_id'];
        $cookie_order['country_to']    = $delivery_info['delivery_country_id'];
        $cookie_order['city_from']     = $pick_up_info['pickup_postal_code'];
        $cookie_order['city_to']       = $delivery_info['delivery_postal_code'];
        $cookie_order['shipping_date'] = $pick_up_info['shipping_date'];

        $json = json_encode($cookie_order);

        set_cookie('order', $json, 3600);
        set_cookie('changed_order', $order_id, 3600);

        $data['success'] = 'true';
        echo json_encode($data);

    }

    private function update_order_items($order_id, $new_items){

        $old_items = $this->Order_model->get_luggage_order($order_id);

        if(empty($new_items)){
            return false;
        }

        $insert_array = [];

        foreach($new_items as $new_index => $single_new_item){

            $isset = false;

            foreach($old_items as $old_index => $single_old_item){

                // IF FIND SOME LUGGAGE
                if(
                    $single_new_item['luggage_name'] == $single_old_item['luggage_name'] &&
                    $single_new_item['type_name']    == $single_old_item['type_name'] &&
                    $single_new_item['weight' ]      == $single_old_item['weight' ] &&
                    $single_new_item['width']        == $single_old_item['width'] &&
                    $single_new_item['height']       == $single_old_item['height'] &&
                    $single_new_item['length']       == $single_old_item['length']
                ){

                    unset($old_items[$old_index]);
                    $isset = true;
                    break;
                }

            }

            if(!$isset){
                $insert_array[] = $single_new_item;
            }

        }

        $delete_array = $old_items;

        if(!empty($delete_array)){
            foreach($delete_array as $single){
                $this->delete_order_luggage($single['id'], $order_id);
            }
        }

        if(!empty($insert_array)){
            $this->Order_model->insert_order_items($insert_array);
        }

    }

    private function delete_order_luggage($luggage_id, $order_id){

        $luggage_info_temp = $this->Order_model->get_luggage_temp_info($order_id, $luggage_id);
        $luggage_info      = $this->Order_model->get_order_files($order_id, NULL, NULL, $luggage_id);

        $url = FCPATH . 'uploaded_documents/orders_files/' . $order_id . '/';

        if(!empty($luggage_info_temp)){

            $url1 = $url.$luggage_info_temp['file_name'];

            if (file_exists($url1)) {
                unlink($url1);
            }

            $this->Order_model->delete_luggage_temp_info($order_id, $luggage_id);
        }


        if(!empty($luggage_info)){

            $url2 = $url.$luggage_info['file_name'];

            if (file_exists($url2)) {
                unlink($url2);
            }

            $this->Order_model->delete_luggage_files($order_id, $luggage_id);

        }

        $this->Order_model->delete_order_single_item($luggage_id);

    }

    public function _get_order_data_for_cookie($order_products){

        $prod_array_for_json = [];

        foreach ($order_products as $single){

            if($single['luggage_name'] == 'Special Boxes'){

                if(!empty($prod_array_for_json['special'][$single['special_index']])){

                    $prod_array_for_json['special'][$single['special_index']]['count'] += 1;
                }else {

                    $prod_array_for_json['special'][$single['special_index']] = [
                        'count' => 1,
                        'weight' => $single['label_weight'],
                        'width'  => $single['label_width'],
                        'length' => $single['label_length'],
                        'height' => $single['label_height']
                    ];
                }


                continue;
            }

            $key = $single['type_id'].'_'.$single['luggage_id'];

            if(!empty($prod_array_for_json['luggage'][$key])){

                $prod_array_for_json['luggage'][$key] += 1;
            }else {

                $prod_array_for_json['luggage'][$key] = 1;
            }

        }

        return $prod_array_for_json;

    }

    public function ax_update_sender_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            return false;
        }

        $order_id            = trim($this->security->xss_clean($this->input->post('order_id')));
        $sender_first_name   = trim($this->security->xss_clean($this->input->post('first_name'))); //* dom inter
        $sender_last_name    = trim($this->security->xss_clean($this->input->post('last_name'))); //* dom inter
        $sender_phone        = trim($this->security->xss_clean($this->input->post('phone'))); //* dom inter
        $sender_email        = trim($this->security->xss_clean($this->input->post('email')));
        $pickup_company      = trim($this->security->xss_clean($this->input->post('organization')));
        $pickup_address1     = trim($this->security->xss_clean($this->input->post('address1'))); //* dom inter
        $pickup_address2     = trim($this->security->xss_clean($this->input->post('address2')));
        $pickup_postal_code  = trim($this->security->xss_clean($this->input->post('postal_code'))); //* dom inter
        $pickup_city         = trim($this->security->xss_clean($this->input->post('city'))); //* dom inter
        $pickup_state        = trim($this->security->xss_clean($this->input->post('state'))); //* dom inter
        $pickup_remark       = trim($this->security->xss_clean($this->input->post('remark')));
        $pickup_time         = trim($this->security->xss_clean($this->input->post('pickup_time')));
        $pickup              = trim($this->security->xss_clean($this->input->post('pick_up')));
        $validation_count    = trim($this->security->xss_clean($this->input->post('sender_address_validation')));

        $pick_up_info = $this->Order_model->get_pickup_info($order_id);
        $country_info = $this->Users_model->get_countries($pick_up_info['pickup_country_id'], true);

        $this->load->library('Fedex_lib');

        if(empty($pick_up_info)){
            return false;
        }

        $user = $this->ion_auth->user()->row();
        $us = $this->Users_model->get_us_country();

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [INCOMPLETE_STATUS[0],SUBMITTED_STATUS[0]]);

        if(empty($order_info)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(!empty($sender_email) && !$this->valid->is_email($sender_email)){
            $data['errors'][] = 'Invalid email address';
            echo json_encode($data);
            return false;
        }

        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $count = count($order_luggages);

        $this->Order_model->set_order_last_use($order_id);

        $type = $this->Order_model->get_order_type($order_id);

        if(empty($type)){
            $data['errors'][] = 'Incorrect shipping type.';
            echo json_encode($data);
            return false;
        }

        if(empty($pickup) && !empty($order_info['pick_up_check'])){

            $data['errors'][] = 'Please select Pick Up or Drop Off';
            echo json_encode($data);
            return false;

        }elseif(empty($order_info['pick_up_check'])){

            $pickup = '1';
        }

        if($pickup == '2' && empty($pickup_time)){

            $data['errors'][] = 'Please select Pick Up time.';
            echo json_encode($data);
            return false;

        }

        if(empty($sender_first_name)){
            $data['errors'][] = 'First Name is required';
            echo json_encode($data);
            return false;
        }

        if(empty($sender_last_name)){
            $data['errors'][] = 'Last Name is required';
            echo json_encode($data);
            return false;
        }

        if(empty($sender_phone)){
            $data['errors'][] = 'Phone number is required';
            echo json_encode($data);
            return false;
        }

        if(empty($pickup_address1)){
            $data['errors'][] = 'Address is required';
            echo json_encode($data);
            return false;
        }

        $pickup_name = NULL;

        ////// international /////
        if($type == 1) {

            if($pick_up_info['pickup_country_id'] == $us[0]['id'] && !$this->valid->is_id($pickup_state)){

                $data['errors'][] = 'Invalid state';
                echo json_encode($data);
                return false;

            }

            if (empty($pickup_city)) {

                $data['errors'][] = 'City is required';
                echo json_encode($data);
                return false;
            }

            if (empty($pickup_state) && $pick_up_info['pickup_country_id'] == $us[0]['id']) {

                $data['errors'][] = 'State is required';
                echo json_encode($data);
                return false;
            }

            if (empty($pickup_postal_code) && $pick_up_info['pickup_country_id'] == $us[0]['id']) {

                $data['errors'][] = 'Postal Code is required';
                echo json_encode($data);
                return false;
            }

            $pickup_name = $this->Order_model->get_states_by_id($pickup_state);

            if(!empty($pickup_name['State'])) {
                $pickup_name = $pickup_name['State'];
            }

        }else{

            $pickup_name = $this->Order_model->get_states_by_id($pick_up_info['pickup_state']);

            if(!empty($pickup_name['State'])) {
                $pickup_name = $pickup_name['State'];
            }

        }

        $pick_up_price = 0;

        if(!empty($pickup) && $pickup == '2'){

            $pick_up_price = $this->_get_pick_up_fee($pick_up_info['pickup_country_id'], $order_id, $pick_up_info['shipping_date']);

        }

        $this->Order_model->delete_shedule_pickup($order_id);

        if(!empty($data['errors'])){
            echo json_encode($data);
            return false;
        }

        $update_data = [
            'sender_first_name'  => $sender_first_name,
            'sender_last_name'   => $sender_last_name,
            'sender_phone'       => $sender_phone,
            'sender_email'       => $sender_email,
            'pickup_company'     => $pickup_company,
            'pickup_address1'    => $pickup_address1,
            'pickup_address2'    => $pickup_address2,
            'pickup_postal_code' => $pickup_postal_code,
            'pickup_city'        => $pickup_city,
            'pickup_state'       => $pickup_state,
            'pickup_remark'      => $pickup_remark,
            'pick_up'            => $pickup,
            'pickup_time'        => $pickup_time,
            'pickup_price'       => $pick_up_price
        ];

        $address_data = [
            'company'          => $pickup_company,
            'country_id'       => $pick_up_info['pickup_country_id'],
            'address1'         => $pickup_address1,
            'address2'         => $pickup_address2,
            'city'             => $pickup_city,
            'state_id'         => $pickup_state,
            'zip_code'         => $pickup_postal_code,
            'user_id'          => $user->id
        ];

        $traveller_data = [
            'first_name'    => $sender_first_name,
            'last_name'     => $sender_last_name,
            'phone'         => $sender_phone,
            'email'         => $sender_email,
            'user_id'       => $user->id
        ];

        $label_data = [
            'address1'    => $pickup_address1,
            'address2'    => $pickup_address2
        ];

        $fedex_validation = [

            'ref_id' => 'Sender',

            'address' => [
                'address_1'    => $pickup_address1,
                'address_2'    => $pickup_address2,
                'zip_code'     => $pick_up_info['pickup_postal_code'],
                'city'         => $pickup_city,
                'state'        => $pickup_name,
                'country_iso2' => $country_info['iso2']
            ],

        ];

        if($type == 2) {

            /*unset($update_data['pickup_postal_code']);
            unset($update_data['pickup_city']);
            unset($update_data['pickup_state']);*/

            $label_data['postal_code']    = $pick_up_info['pickup_postal_code'];
            $label_data['city']           = $pick_up_info['pickup_city'];

            $address_data['zip_code']     = $pick_up_info['pickup_postal_code'];
            $address_data['city']         = $pick_up_info['pickup_city'];
            $address_data['state_id']     = $pick_up_info['pickup_state'];

            $fedex_validation['address']['zip_code'] = $pick_up_info['pickup_postal_code'];
            $fedex_validation['address']['city']     = $pick_up_info['pickup_city'];

        }

        //if($pick_up_info['pickup_country_id'] == $us[0]['id']){
//
        //    $validation_result = $this->fedex_lib->address_validation($fedex_validation);
//
        //    if($validation_result['status'] != 'OK' && $validation_count == 0){
        //        $data['errors'] = $validation_result['errors'];
        //        echo json_encode($data);
        //        return false;
        //    }
//
        //}

        if(!$this->Order_model->update_pickup_info($update_data, $order_id)){
            $data['errors'][] = 'Can`t fill data to db.';
        }else{
            $data['success'][] = 'Data successfully saved.';
        }

        $traveller_data_temp = $traveller_data;
        $traveller_data_temp['user_id'] = '0';

        if(empty($this->Users_model->check_traveller($traveller_data, $traveller_data_temp))){
            $this->_add_traveler($traveller_data);
        }

        $address_data_temp = $address_data;
        $address_data_temp['user_id'] = '0';

        if(empty($this->Users_model->check_address($address_data, $address_data_temp))){
            $this->_add_address($address_data);
        }

        $billing_array = [
            'pickup_fee' => $pick_up_price*$count,
            'status'     => '1'
        ];

        $next_billing = $this->Billing_model->check_last_billing($order_id);

        $crt = [
            'type'     => $next_billing['next'],
            'order_id' => $order_id
        ];

        $billing_isset = $this->Billing_model->get_billing($crt);

        if(empty($billing_isset)){

            $billing_array['order_id'] = $order_id;
            $billing_array['user_id']  = $user->id;
            $billing_array['type']     = $next_billing['next'];

            $this->Billing_model->auto_fill_insert($billing_array);

        }else{

            $this->Billing_model->update_billing_info($billing_array, $order_id, $next_billing['next']);
        }

        echo json_encode($data);

    }


    public function ax_update_receiver_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            return false;
        }

        $order_id              = trim($this->security->xss_clean($this->input->post('order_id')));
        $receiver_first_name   = trim($this->security->xss_clean($this->input->post('first_name'))); //* dom inter
        $receiver_last_name    = trim($this->security->xss_clean($this->input->post('last_name'))); //* dom inter
        $receiver_phone        = trim($this->security->xss_clean($this->input->post('phone'))); //* dom inter
        $receiver_email        = trim($this->security->xss_clean($this->input->post('email')));
        $delivery_company      = trim($this->security->xss_clean($this->input->post('organization')));
        $delivery_address1     = trim($this->security->xss_clean($this->input->post('address1'))); //* dom inter
        $delivery_address2     = trim($this->security->xss_clean($this->input->post('address2')));
        $delivery_postal_code  = trim($this->security->xss_clean($this->input->post('postal_code'))); //* dom inter
        $delivery_city         = trim($this->security->xss_clean($this->input->post('city'))); //* dom inter
        $delivery_state        = trim($this->security->xss_clean($this->input->post('state'))); //* dom inter
        $delivery_remark       = trim($this->security->xss_clean($this->input->post('remark')));
        $signature             = trim($this->security->xss_clean($this->input->post('signature')));
        $validation_count      = trim($this->security->xss_clean($this->input->post('reciver_address_validation')));

        $delivery_info = $this->Order_model->get_delivery_info($order_id);
        $this->load->library('Fedex_lib');
        $country_info = $this->Users_model->get_countries($delivery_info['delivery_country_id'], true);

        if(empty($delivery_info)){

            return false;
        }

        $user = $this->ion_auth->user()->row();
        $us = $this->Users_model->get_us_country();

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [INCOMPLETE_STATUS[0],SUBMITTED_STATUS[0]]);

        if(empty($order_info)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $this->Order_model->set_order_last_use($order_id);

        $type = $this->Order_model->get_order_type($order_id);

        if(empty($type)){
            $data['errors'][] = 'Incorrect shipping type.';
            echo json_encode($data);
            return false;
        }

        if(!empty($receiver_email) && !$this->valid->is_email($receiver_email)){
            $data['errors'][] = 'Invalid email address';
            echo json_encode($data);
            return false;
        }

        if(empty($receiver_first_name)){
            $data['errors'][] = 'First Name is required';
            echo json_encode($data);
            return false;
        }

        if(empty($receiver_last_name)){
            $data['errors'][] = 'Last Name is required';
            echo json_encode($data);
            return false;
        }

        if(empty($receiver_phone)){
            $data['errors'][] = 'Phone number is required';
            echo json_encode($data);
            return false;
        }

        if(empty($delivery_address1)){
            $data['errors'][] = 'Address is required';
            echo json_encode($data);
            return false;
        }

        $delivery_state_name = NULL;

        ////// international /////
        if($type == 1) {

            if(!$this->valid->is_id($delivery_state) && $delivery_info['delivery_country_id'] == $us[0]['id']){

                $data['errors'][] = 'Invalid state';
                echo json_encode($data);
                return false;

            }elseif(!empty($delivery_state)){

                $delivery_state_name = $this->Order_model->get_states_by_id($delivery_state);
                $delivery_state_name = $delivery_state_name['State'];
            }

            if (empty($delivery_city)) {
                $data['errors'][] = 'City is required';
                echo json_encode($data);
                return false;
            }

            if (empty($delivery_state) && $delivery_info['delivery_country_id'] == $us[0]['id']) {
                $data['errors'][] = 'State is required';
                echo json_encode($data);
                return false;
            }

            if (empty($delivery_postal_code) && $delivery_info['delivery_country_id'] == $us[0]['id']) {
                $data['errors'][] = 'Postal Code is required';
                echo json_encode($data);
                return false;
            }

        }else{

            $delivery_state_name = $this->Order_model->get_states_by_id($delivery_info['delivery_state']);

            if(!empty($delivery_state_name['State'])) {
                $delivery_state_name = $delivery_state_name['State'];
            }

        }

        if(!empty($data['errors'])){
            echo json_encode($data);
            return false;
        }

        $update_data = [
            'order_id'             => $order_id,
            'receiver_first_name'  => $receiver_first_name,
            'receiver_last_name'   => $receiver_last_name,
            'receiver_phone'       => $receiver_phone,
            'receiver_email'       => $receiver_email,
            'without_signature'    => $signature,
            'delivery_company'     => $delivery_company,
            'delivery_address1'    => $delivery_address1,
            'delivery_address2'    => $delivery_address2,
            'delivery_postal_code' => $delivery_postal_code,
            'delivery_city'        => $delivery_city,
            'delivery_state'       => $delivery_state,
            'delivery_country_id'  => $delivery_info['delivery_country_id'],
            'delivery_remark'      => $delivery_remark
        ];

        $address_data = [
            'company'     => $delivery_company,
            'country_id'  => $delivery_info['delivery_country_id'],
            'address1'    => $delivery_address1,
            'address2'    => $delivery_address2,
            'city'        => $delivery_city,
            'state_id'    => $delivery_state,
            'zip_code'    => $delivery_postal_code,
            'user_id'          => $user->id
        ];

        $traveller_data = [
            'first_name'  => $receiver_first_name,
            'last_name'   => $receiver_last_name,
            'phone'       => $receiver_phone,
            'email'       => $receiver_email,
            'user_id'       => $user->id
        ];

        $fedex_validation = [

            'ref_id' => 'Receiver',

            'address' => [
                'address_1'    => $delivery_address1,
                'address_2'    => $delivery_address2,
                'zip_code'     => $delivery_info['delivery_postal_code'],
                'city'         => $delivery_city,
                'state'        => $delivery_state_name,
                'country_iso2' => $country_info['iso2']
            ],

        ];


        if($type == 2) {

            /*unset($update_data['delivery_postal_code']);
            unset($update_data['delivery_city']);
            unset($update_data['delivery_state']);*/

            $address_data['zip_code'] = $delivery_info['delivery_postal_code'];
            $address_data['city']     = $delivery_info['delivery_city'];
            $address_data['state_id'] = $delivery_info['delivery_state'];

            $fedex_validation['address']['zip_code'] = $delivery_info['delivery_postal_code'];
            $fedex_validation['address']['city']     = $delivery_info['delivery_city'];

        }

        //if($delivery_info['delivery_country_id'] == $us[0]['id']){
//
        //    $validation_result = $this->fedex_lib->address_validation($fedex_validation);
//
        //    if($validation_result['status'] != 'OK' && $validation_count == 0){
        //        $data['errors'] = $validation_result['errors'];
        //        echo json_encode($data);
        //        return false;
        //    }
//
        //}

        if(!$this->Order_model->update_delivery_info($update_data, $order_id)){
            $data['errors'][] = 'Can`t fill data to db.';
        }else{
            $data['success'][] = 'Data successfully saved.';
        }

        $traveller_data_temp = $traveller_data;
        $traveller_data_temp['user_id'] = '0';

        if(empty($this->Users_model->check_traveller($traveller_data, $traveller_data_temp))){
            $this->_add_traveler($traveller_data);
        }

        $address_data_temp = $address_data;
        $address_data_temp['user_id'] = '0';

        if(empty($this->Users_model->check_address($address_data, $address_data_temp))){
            $this->_add_address($address_data);
        }

        echo json_encode($data);

    }


    public function _generate_order_id($user){

        if(empty($user->id) || empty($user->account_name)){
            return false;
        }

        $count = $this->Order_model->get_order_count($user->id);

        $count++;

        return $user->account_name.'-'.$count;

    }

    public function _get_pick_up_fee($country_id, $order_id, $shipping_date){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;

        }

        $result = $this->Order_model->get_pick_up_fee($country_id);
        $order  = $this->Order_model->get_order_info($order_id);

        if(empty($order)){
            return false;
        }

        if($order['shipping_type'] == 1){

            $ret = 'international';

        }else{

            if(stripos($order['shipping_type'], 'basic') !== false){

                $ret = 'domestic_basic';

            }else{

                $ret = 'domestic_express';

            }

        }

        if(date('w', strtotime($shipping_date)) == 6){
            $ret = 'saturday_pickup';
        }

        if(empty($result[$ret])){
            return 0;
        }

        return $result[$ret];

    }

    public function ax_sender_pickup_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;

        }

        $data['errors'] = [];
        $data['success'] = [];

        $order_id        = trim($this->security->xss_clean($this->input->post('order_id')));
        $sender_id       = trim($this->security->xss_clean($this->input->post('sender_id')));
        $post_data       = $this->security->xss_clean($this->input->post());
        $chenged_trav    = $this->security->xss_clean($this->input->post('chenged'));
        $chenged_address = $this->security->xss_clean($this->input->post('chenged_address'));
        $user            = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        $data['count'] = count($order_luggages);

        $order                = $this->Order_model->get_order_info($order_id);
        $data['order']        = $order;
        $sender_info          = $this->Order_model->get_pickup_info($order_id);
        $data['country']      = $this->Users_model->get_countries($sender_info['pickup_country_id'])[0]['country'];
        $data['pickup_time']  = $this->_get_pick_up_time($order_id);
        $data['pickup_price'] = $this->_get_pick_up_fee($sender_info['pickup_country_id'],$order_id, $sender_info['shipping_date']);
        $data['action']       = 'view';
        $data['address_book'] = [];
        $data['pickup']       = trim($this->security->xss_clean($this->input->post('pickup')));
        $data['drop']         = trim($this->security->xss_clean($this->input->post('drop')));

        $required = ['sender_first_name', 'sender_last_name', 'sender_phone', 'pickup_address1', 'pickup_city', 'pickup_state'];

        $data['pickup_state'] = '';

        if(!$this->_check_info_isset($order_id, 'pick_up') && empty($sender_id)){

            $data['action'] = 'add';

        }

        $pickup_state = $this->Order_model->get_states_by_id($sender_info['pickup_state']);

        if(!empty($pickup_state)){

            $data['pickup_state'] = $pickup_state['State'];
        }

        $state = $this->Users_model->get_states($sender_info['pickup_country_id']);
        $data['state']  = [];

        if(!empty($state)){

            $data['state'] = $state;
        }

        $data['butt_name'] = 'Save';

        if(!empty($sender_id)){

            $data['butt_name'] = 'Edit';
            $sender_info = $this->Order_model->get_pickup_info($order_id,$sender_id);

            if(empty($sender_info)){

                $data['errors'][] = 'Incorrect order information.';
                echo json_encode($data);
                return false;
            }

            $data['action'] = 'add';
        }

        $my_traveller = $this->Users_model->get_traveler_list($user->id);
        $data['traveller'] = [];

        if(!empty($my_traveller)){

            $data['traveller'] = $my_traveller['travel_list'];

        }

        $address_book_cr = [
            'user_id'    => $user->id,
            'zip_code'   => $sender_info['pickup_postal_code'],
            'country_id' => $sender_info['pickup_country_id']
        ];

        if($order['shipping_type'] == '1'){

            unset($address_book_cr['zip_code']);
        }

        $or_crt = $address_book_cr;
        $or_crt['user_id'] = '0';

        $my_address_book = $this->Users_model->get_address_book_list($address_book_cr, NULL, $or_crt);

        if(!empty($my_address_book)){

            $data['address_book'] = $my_address_book['address_book'];

        }

        if($data['action'] == 'add'){

            $traveller_id = trim($this->security->xss_clean($this->input->post('trav_id')));
            $data['traveller_info'] =   $this->_return_data_for_sender_pickup($traveller_id,$user->id);
            $address_book_id = trim($this->security->xss_clean($this->input->post('add_id')));
            $data['address_info']   =   $this->_return_address_data($address_book_id,$user->id,$order['shipping_type'],true);

            $data['add_id'] = $address_book_id;
            $data['trav_id'] = $traveller_id;
        }

        $data['sender_info'] = $sender_info;
        $data['order_info'] = $order;

        $state_info = $this->Order_model->get_states_by_id($sender_info['pickup_state']);
        $data['sender_info']['pickup_state_name'] = $state_info['State'];

        if($chenged_trav && $order['shipping_type'] == '2'){

            $data['sender_info']['pickup_company'] = $post_data['organization'];
            $data['sender_info']['pickup_address1'] = $post_data['address1'];
            $data['sender_info']['pickup_remark'] = $post_data['remark'];
            $data['sender_info']['pickup_time'] = $post_data['pickup_val'];

        }elseif ($chenged_trav && $order['shipping_type'] == '1'){

            $data['sender_info']['pickup_company'] = $post_data['organization'];
            $data['sender_info']['pickup_address1'] = $post_data['address1'];
            $data['sender_info']['pickup_postal_code'] = $post_data['postal_code'];
            $data['sender_info']['pickup_city'] = $post_data['city'];
            $data['sender_info']['pickup_state'] = $post_data['state'];
            $data['sender_info']['pickup_remark'] = $post_data['remark'];
            $data['sender_info']['pickup_time'] = $post_data['pickup_val'];
        }

        if($chenged_address){

            $data['sender_info']['sender_first_name'] = $post_data['first_name'];
            $data['sender_info']['sender_last_name'] = $post_data['last_name'];
            $data['sender_info']['sender_phone'] = $post_data['phone'];
            $data['sender_info']['sender_email'] = $post_data['email'];
            $data['sender_info']['pickup_time'] = $post_data['pickup_val'];
        }

        $this->load->view('frontend/orders/sender_pickup_info', $data);

    }

    public function _get_pick_up_time($order_id){

        if(empty($order_id) || !$this->ion_auth->logged_in()){

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        $return_data = [];

        if(strripos($order_info['send_type'],'outbound') !== false){

            $return_data = $this->config->item('outband_service');
        }

        else if(strripos($order_info['send_type'],'inbound') !== false){

            $return_data = $this->config->item('inbound_service');
        }

        else if(strripos($order_info['send_type'],'international') !== false){

            $return_data = $this->config->item('outband_service');
        }

        else if(strripos($order_info['send_type'],'basic') !== false){

            $return_data = $this->config->item('basic');

        }else{

            $return_data = $this->config->item('express');
        }

        if(empty($return_data)){

            return false;
        }

        return $return_data;
    }

    public function ax_receiver_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;

        }

        $data['errors'] = [];
        $data['success'] = [];

        $order_id        = trim($this->security->xss_clean($this->input->post('order_id')));
        $delivery_id     = trim($this->security->xss_clean($this->input->post('delivery_id')));
        $data_post       = $this->security->xss_clean($this->input->post());
        $changed_trav    = $this->security->xss_clean($this->input->post('chenged_trav'));
        $chenged_address = $this->security->xss_clean($this->input->post('chenged_address'));
        $user            = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $receiver_info = $this->Order_model->get_delivery_info($order_id);
        $order = $this->Order_model->get_order_info($order_id);
        $data['country'] = $this->Users_model->get_countries($receiver_info['delivery_country_id'])[0]['country'];
        $data['action'] = 'view';
        $data['signature'] = trim($this->security->xss_clean($this->input->post('signature')));

        if(!$this->_check_info_isset($order_id, 'delivery') && empty($delivery_id)){

            $data['action'] = 'add';

        }

        $data['state']  = [];

        $data['delivery_state'] = '';

        $state = $this->Users_model->get_states($receiver_info['delivery_country_id']);

        $delivery_state = $this->Order_model->get_states_by_id($receiver_info['delivery_state']);

        if(!empty($delivery_state)){

            $data['delivery_state'] = $delivery_state['State'];
        }

        if(!empty($state)){

            $data['state'] = $state;
        }

        $data['butt_name'] = 'Save';

        if(!empty($delivery_id)){

            $data['butt_name'] = 'Edit';

            $receiver_info = $this->Order_model->get_delivery_info($order_id,$delivery_id);

            if(empty($receiver_info)){

                $data['errors'][] = 'Incorrect order information.';
                echo json_encode($data);
                return false;
            }

            $data['action'] = 'add';
        }


        $my_traveller = $this->Users_model->get_traveler_list($user->id);
        $data['traveller'] = [];

        if(!empty($my_traveller)){

            $data['traveller'] = $my_traveller['travel_list'];


        }

        $data['order'] = $order;
        $data['address_book'] = [];
        $data['order_info'] = $order;

        $address_book_cr = [

            'user_id'    => $user->id,
            'zip_code'   =>$receiver_info['delivery_postal_code'],
            'country_id' => $receiver_info['delivery_country_id']

        ];

        if($order['shipping_type'] == '1'){

            unset($address_book_cr['zip_code']);
        }

        $or_crt = $address_book_cr;
        $or_crt['user_id'] = '0';

        $my_address_book = $this->Users_model->get_address_book_list($address_book_cr, NULL);

        if(!empty($my_address_book)){

            $data['address_book'] = $my_address_book['address_book'];

        }

        if($data['action'] == 'add'){

            $traveller_id = trim($this->security->xss_clean($this->input->post('trav_id')));
            $data['traveller_info'] =   $this->_return_data_for_sender_pickup($traveller_id,$user->id);
            $address_book_id = trim($this->security->xss_clean($this->input->post('add_id')));
            $data['address_info']   =   $this->_return_address_data($address_book_id,$user->id,$order['shipping_type'],true);
            $data['add_id'] = $address_book_id;
            $data['trav_id'] = $traveller_id;
        }

        $data['receiver_info'] = $receiver_info;

        $state_info = $this->Order_model->get_states_by_id($receiver_info['delivery_state']);
        $data['receiver_info']['delivery_state_name'] = $state_info['State'];

        if($changed_trav && $order['shipping_type'] == '2'){

            $data['receiver_info']['delivery_company'] = $data_post['organization'];
            $data['receiver_info']['delivery_address1'] = $data_post['address1'];
            $data['receiver_info']['delivery_remark'] = $data_post['remark'];

        }elseif ($changed_trav && $order['shipping_type'] == '1'){


            $data['receiver_info']['delivery_company'] = $data_post['organization'];
            $data['receiver_info']['delivery_address1'] = $data_post['address1'];
            $data['receiver_info']['delivery_postal_code'] = $data_post['postal_code'];
            $data['receiver_info']['delivery_city']   = $data_post['city'];
            $data['receiver_info']['delivery_state']  = $data_post['state'];
            $data['receiver_info']['delivery_remark'] = $data_post['remark'];
        }

        if($chenged_address){

            $data['receiver_info']['receiver_first_name'] = $data_post['first_name'];
            $data['receiver_info']['receiver_last_name']  = $data_post['last_name'];
            $data['receiver_info']['receiver_phone']      = $data_post['phone'];
            $data['receiver_info']['receiver_email']      = $data_post['email'];
        }

        $this->load->view('frontend/orders/receiver_delivery_info', $data);

    }

    public function ax_payment_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));
        $edit = trim($this->security->xss_clean($this->input->post('edit')));
        $fill = trim($this->security->xss_clean($this->input->post('fill')));

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $data['credit_card_number'] = NULL;
        $order_info = $this->Order_model->get_order_info($order_id, $user->id);
        $data['order'] = $order_info;
        $cards_count = $this->Order_model->get_credit_card_count_by_id($user->id);

        $card_info = NULL;

        if(!empty($order_info['card_id'])) {

            $card_info = $this->Order_model->get_credit_card_by_id($user->id, NULL, $order_info['card_id']);
        }

        if(!empty($order_info['card_id']) && empty($card_info)){
            $this->Order_model->delete_order_card($order_id);
        }

        $data['action'] = 'add';

        if(!empty($card_info)){

            $data['action'] = 'view';
        }

        $data['discount_action'] = 'view';

        if(empty($order_info['discount_code'])){

            $data['discount_action'] = 'add';
        }

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);
        $price = 0;

        if(!empty($price_array) && !empty($price_array['original_price'])){

            $price = $price_array['original_price'];
        }

        $data['all_price'] = $price;
        $data['price_array'] = $price_array;

        $data['order_info'] = $order_info;


        if(empty($card_info) && !empty($cards_count) && $cards_count >2){

            $data['action'] = 'full_cards';

        }elseif(!empty($card_info)){

            $data['country'] = $this->Users_model->get_countries($card_info['country_id'])[0]['country'];
            $states = $this->Users_model->get_states($card_info['country_id']);

            $data['all_states'] = $states;
            $state = $this->Order_model->get_states_by_id($card_info['state_id']);

            if(!empty($state['State'])){

                $data['state'] = $state['State'];
            }else{

                $data['state'] = '';
            }

        }

        $all_cards  = $this->Order_model->get_credit_card_by_id($user->id);

        $data['cards_info'] = $all_cards;
        $data['card_data'] = $card_info;
        $data['cards_count'] = $cards_count;
        $data['countries'] = $this->Users_model->get_countries();

        if(!empty($card_info) && !empty($edit)){
            $data['action'] = 'add';
            $data['edit'] = true;
            $data['credit_card_number'] = '***';
        }

        $this->load->view('frontend/orders/payment_info', $data);

    }

    public function ax_discount(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);
        $data['order'] = $order_info;

        $data['discount_action'] = 'view';

        if(empty($order_info['discount_code'])){

            $data['discount_action'] = 'add';
        }

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);
        $price = 0;

        if(!empty($price_array) && !empty($price_array['original_price'])){

            $price = $price_array['original_price'];
        }

        $data['all_price'] = $price;
        $data['price_array'] = $price_array;

        $this->load->view('frontend/orders/discount', $data);

    }

    public function ax_update_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));
        $card_id  = trim($this->security->xss_clean($this->input->post('card_id')));


        $data['errors'] = [];
        $data['success'] = [];

        if(empty($order_id) || empty($card_id)){

            $data['errors'][] = 'Incorrect information';
            echo json_encode($data);
            return false;
        }

        $user = $this->ion_auth->user()->row();

        // DELETE CARD
        if($card_id == 'new'){

            if(!$this->Order_model->check_order_by_id($user->id, $order_id)){

                $data['errors'][] = 'Undefined order.';
            }else{

                $this->Order_model->delete_order_card($order_id);
            }

            echo json_encode($data);
            return true;
        }

        if(empty($this->set_credit_card($order_id,$card_id))){

            $data['errors'][] = 'Incorrect information';
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [INCOMPLETE_STATUS[0],SUBMITTED_STATUS[0]]);

        $this->Order_model->set_order_last_use($order_id);

        echo json_encode($data);

    }

    public function _order_select_items($data, $order_id, $country_id){

        if (!$this->ion_auth->logged_in()) {

            return false;

        }

        if(empty($data)){

            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            return false;
        }

        $carrier = $this->Order_model->get_carrier_by_name($order_info['currier_name']);

        $this->load->config('check_price');
        $fee_limits = $this->config->item('international_fee_limit');

        $return_arr = [];
        //$special_handling_array = [];

        $all_total_count = 0;

        if(!empty($data['special'][1]['count'])){
            $all_total_count += $data['special'][1]['count'];
        }

        if(!empty($data['special'][2]['count'])){
            $all_total_count += $data['special'][2]['count'];
        }

        if(!empty($data['special'][3]['count'])){
            $all_total_count += $data['special'][3]['count'];
        }

        if(!empty($data['luggage'])){
            $all_total_count += array_sum($data['luggage']);
        }

        if(!empty($data['luggage'])){

            foreach ($data['luggage'] as $index => $prod){

                $prod_name = explode('_',$index);
                if(count($prod_name) != 2){

                    return false;
                }

                $type = $this->Luggage_model->get_luggage_types($prod_name[0]);
                $prods = $this->Luggage_model->get_luggage_by_id($prod_name[1]);
                $domestic_info = $this->Manage_price_model->get_domestic($country_id, $prods['product_id']);

                $charge_weight = $domestic_info[0]['charge_weight'];
                $label_weight  = $domestic_info[0]['api_weight'];
                $label_width   = $domestic_info[0]['api_width'];
                $label_length  = $domestic_info[0]['api_length'];
                $label_height  = $domestic_info[0]['api_height'];

                if($order_info['shipping_type'] == '2'){

                    if(stripos($order_info['send_type'],'express') !== FALSE){

                        $special_handling = $domestic_info[0]['domestic_express'];
                    }else{

                        $special_handling = $domestic_info[0]['domestic_basic'];
                    }

                }else{

                    $international_price = $this->Check_price_model->get_international_fee($country_id, $carrier['id'], $prods['product_id']);

                    $special_handling = 0;

                    foreach($fee_limits as $fee_limit){

                        if($all_total_count >=  $fee_limit['from'] && $all_total_count <=  $fee_limit['to']){

                            if(!empty($international_price[$prods['product_id']][$fee_limit['column']])){

                                $special_handling = $international_price[$prods['product_id']][$fee_limit['column']];
                            }

                            break;
                        }
                    }

                    //$special_handling_array[] = $special_handling;
                }

                $count = $prod;

                while($count > 0){

                    $return_arr[] = [
                        'order_id'             => $order_id,
                        'luggage_name'         => $prods['luggage_name'],
                        'type_name'            => $type[0]['type_name'],
                        'image'                => $type[0]['image_class'],
                        'weight'               => $prods['weight'],
                        'width'                => $prods['calc_width'],
                        'height'               => $prods['calc_height'],
                        'length'               => $prods['calc_length'],
                        'type_id'              => $prods['type_id'],
                        'special_index'        => NULL,
                        'tracking_number'      => NULL,
                        'track_url'            => NULL,
                        'truck_id'             => NULL,
                        'luggage_id'           => $prods['product_id'],
                        'special_handling'     => $special_handling,
                        'charge_weight'        => $charge_weight,
                        'origin_charge_weight' => $charge_weight,
                        'label_weight'         => $label_weight,
                        'label_width'          => $label_width,
                        'label_height'         => $label_height,
                        'label_length'         => $label_length
                    ];

                    $count = $count - 1;

                }

            }
        }

        if(!empty($data['special'])){

            $this->config->load('check_price');

            if($order_info['shipping_type'] == '2'){
                $special_fee_array = $this->Check_price_model->get_boxes_domestic($country_id);
            }else{
                $special_fee_array = $this->Check_price_model->get_boxes_international($country_id);
            }

            foreach ($data['special'] as $index => $select_items){

                if(!empty($select_items)){

                    $special_handling = 0;

                    $weight = floatval($select_items['weight']) + $this->config->item('special_box_add_data')['weight'];
                    $width  = floatval($select_items['width'])  + $this->config->item('special_box_add_data')['width'];
                    $height = floatval($select_items['height']) + $this->config->item('special_box_add_data')['height'];
                    $length = floatval($select_items['length']) + $this->config->item('special_box_add_data')['length'];

                    $charge_weight = max(ceil($weight), ceil($width * $height * $length / 139));

                    foreach($this->config->item('special_box_sizes_ranges') as $range){

                        if($charge_weight >= $range['from'] && $charge_weight <= $range['to']){

                            if($order_info['shipping_type'] == '2'){

                                if(stripos($order_info['send_type'],'express') !== FALSE){

                                    $special_handling = $special_fee_array[strtolower($range['size'])]['domestic_express'];
                                }else{

                                    $special_handling = $special_fee_array[strtolower($range['size'])]['domestic_basic'];
                                }


                            }else {

                                foreach($fee_limits as $fee_limit){

                                    if($all_total_count >=  $fee_limit['from'] && $all_total_count <=  $fee_limit['to']){

                                        if(!empty($special_fee_array[strtolower($range['size'])][$carrier['id']][$fee_limit['column']])){

                                            $special_handling = $special_fee_array[strtolower($range['size'])][$carrier['id']][$fee_limit['column']];
                                        }

                                        break;
                                    }
                                }
                                //$special_handling_array[] = $special_handling;
                            }

                            break;

                        }

                    }

                    $count = $select_items['count'];

                    while($count > 0){

                        $return_arr[] = [
                            'order_id'             => $order_id,
                            'luggage_name'         => 'Special Boxes',
                            'type_name'            => 'Boxes',
                            'image'                => 'icon-box',
                            'weight'               => $weight,
                            'width'                => $width,
                            'height'               => $height,
                            'length'               => $length,
                            'special_index'        => $index,
                            'tracking_number'      => NULL,
                            'track_url'            => NULL,
                            'truck_id'             => NULL,
                            'type_id'              => NULL,
                            'luggage_id'           => NULL,
                            'special_handling'     => $special_handling,
                            'charge_weight'        => $charge_weight,
                            'origin_charge_weight' => $charge_weight,
                            'label_weight'         => $select_items['weight'],
                            'label_width'          => $select_items['width'],
                            'label_height'         => $select_items['height'],
                            'label_length'         => $select_items['length']
                        ];

                        $count = $count - 1;

                    }

                }
            }

        }

        /*if($order_info['shipping_type'] == '1'){
            foreach($return_arr as $index => $single){
                $return_arr[$index]['special_handling'] = max($special_handling_array);
            }
        }*/

        return $return_arr;

    }

    public function _add_traveler($data){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;
        }

        if($this->Users_model->insert_traveler($data)){

            return true;
        }

        return false;

    }

    public function _add_address($data){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;
        }

        $data['add_date'] = date('Y-m-d H:i:s');

        if($this->Users_model->insert_address_book($data)){

            return true;
        }

        return false;

    }

    public function _return_data_for_sender_pickup($traveller_id,$user_id){

        if ($this->input->method() != 'post' || !$this->ion_auth->logged_in()) {

            return false;

        }

        if(empty($traveller_id) || empty($user_id)){

            $return_data = [
                'first_name' => '',
                'last_name'  => '',
                'phone'      => '',
                'email'      => ''
            ];
            return $return_data;
        }

        $check_traveller = $this->Users_model->get_traveler_list($user_id,$traveller_id);

        if(empty($check_traveller)){

            $return_data = [
                'first_name' => '',
                'last_name'  => '',
                'phone'      => '',
                'email'      => ''
            ];

            return $return_data;
        }

        $check_traveller = $check_traveller['travel_list'][0];
        $return_data = [

            'first_name' => $check_traveller['first_name'],
            'last_name'  => $check_traveller['last_name'],
            'phone'      => $check_traveller['phone'],
            'email'      => $check_traveller['email']

        ];


        return $return_data;
    }

    public function _return_address_data($address_id, $user_id, $type, $checked = NULL){

        $return_data = [
            'organization' => '',
            'address1'     => '',
            'address2'     => '',
            'postal_code'  => '',
            'city'         => '',
            'state'        => '',
            'remark'       => ''
        ];

        if(empty($address_id) || empty($user_id) || empty($type)){


            return $return_data;
        }

        $address_book_cr = ['user_id' => $user_id,'address_book.id' => $address_id];
        $or_cr = $address_book_cr;
        $or_cr['user_id'] = '0';

        $check_address = $this->Users_model->get_address_book_list($address_book_cr, NULL, $or_cr);

        if(empty($check_address)){

            return $return_data;
        }

        $check_address = $check_address['address_book'][0];

        if($type == '1'){

            $return_data = [

                'organization' => $check_address['company'],
                'address1'     => $check_address['address1'],
                'address2'     => $check_address['address2'],
                'postal_code'  => $check_address['zip_code'],
                'city'         => $check_address['city'],
                'remark'       => $check_address['comment']
            ];

            if(!empty($check_address['state_id'])){

                $state = $this->Order_model->get_states_by_id($check_address['state_id']);

            }elseif (!$checked){

                $state = $check_address['state_id'];

            } else{

                $state = '';
            }

            $return_data['state'] = $state;

        }else{

            $return_data = [

                'organization' => $check_address['company'],
                'address1'     => $check_address['address1'],
                'address2'     => $check_address['address2'],
                'remark'       => $check_address['comment']
            ];
        }


        return $return_data;

    }

    public function set_credit_card($order_id = NULL,$card_id = NULL){

        if (!$this->ion_auth->logged_in()) {

            return false;

        }

        $echo = false;

        if(empty($order_id) || empty($card_id)){

            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
            $card_id  = trim($this->security->xss_clean($this->input->post('card_id')));
            $echo = true;
        }

        $user = $this->ion_auth->user()->row();

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [INCOMPLETE_STATUS[0],SUBMITTED_STATUS[0]]);

        if(empty($order_info)){
            $data['errors'][] = 'Incorrect order information.';
        }

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Undefined order.';
        }

        $card_info = $this->Order_model->get_credit_card_by_id($user->id, NULL, $card_id);

        if(empty($card_info)){
            $data['errors'][] = 'Undefined credit card.';
        }

        if(!$this->Order_model->set_order_card($order_id, $card_id)){
            $data['errors'][] = 'Can not set card for order.';
        }

        if(!empty($data['errors'])){

            if($echo){
                echo json_encode($data);
            }

            return false;

        }

        $data['success'] = 'Credit card successfully saved';

        if($echo){
            echo json_encode($data);
        }

        return true;

    }

    public function _set_luggage_order($order_id){

        if (!$this->ion_auth->logged_in() || empty($order_id)) {

            show_404();
            return false;

        }

        $return_data = [];

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        if(empty($order_luggages)){

            return false;
        }

        foreach ($order_luggages as $index => $luggage){

            if($luggage['luggage_name'] ==  'Special Boxes'){


                $return_data[$luggage['type_name']]['image'] =  $luggage['image'];

                if(!empty($return_data[$luggage['type_name']][$luggage['luggage_name']])){

                    $return_data[$luggage['type_name']][$luggage['luggage_name']] += 1;
                }else{

                    $return_data[$luggage['type_name']][$luggage['luggage_name']] = 1;
                }

            }else{

                $return_data[$luggage['type_name']]['image'] =  $luggage['image'];

                if(!empty($return_data[$luggage['type_name']][$luggage['luggage_name']])){

                    $return_data[$luggage['type_name']][$luggage['luggage_name']]['count'] += 1;

                }else{

                    $return_data[$luggage['type_name']][$luggage['luggage_name']] = [
                        'count'        => 1,
                        'sizes_image'  => $luggage['sizes_image'],
                    ];
                }

            }
        }

        $return_data['count'] = count($order_luggages);

        return $return_data;

    }

    public function ax_insurance(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $sender_info = $this->Order_model->get_pickup_info($order_id);

        if(empty($sender_info['pickup_country_id'])){

            $data['errors'][] = 'Incorrect order information.';

            return false;
        }

        $country_id = $sender_info['pickup_country_id'];

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order = $this->Order_model->get_order_info($order_id);

        $data['order'] = $order;
        $incurance_data_for_table = $this->Order_model->get_incurance($order_id);

        $incurance_info =  $this->_set_incurance($order_id,$country_id,$order['shipping_type']);

        if(!empty($incurance_data_for_table)){

            foreach ($incurance_data_for_table as $insurance_data){

                $incurance_info['incurance'][$insurance_data['order_luggage_id']] = $insurance_data;

            }

        }
        $result['incurance_info'] = $incurance_info['incurance'];

        if(empty($incurance_data_for_table)){

            if(!empty($incurance_info)){

                $order_data =  $this->Order_model->get_luggage_order($order_id);

                $order_luggaege_count = count($order_data);

                if($incurance_info['total_count'] != $order_luggaege_count){

                    $data['errors'][] = 'Incorrect order information.';
                    echo json_encode($data);
                    return false;
                }
            }
        }

        if(empty($result) || count($result['incurance_info']) != $incurance_info['total_count']){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;

        }

        if(!empty($incurance_info['insurance_price'])){


            $result['insurance_price'] = $incurance_info['insurance_price'];
            $result['total_count']     = $incurance_info['total_count'];
            $data['incurance'] = $result;
        }

        $data['type'] = $order['shipping_type'];
        $data['action']  =  'add';

        $this->load->view('frontend/orders/order_incurance', $data);

    }

    public function ax_incurance_view(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $incurance_data = $this->Order_model->get_incurance($order_id);

        $insurance = 0;
        $max_incurance = 0;

        if(!empty($incurance_data)){
            foreach ($incurance_data as $data){

                $insurance += $data['insurance'];
                $max_incurance += $data['incurance_fee'];

            }
        }
        if(!empty($incurance_data)){
            foreach ($incurance_data as $data){

                $insurance += $data['insurance'];
                $max_incurance += $data['incurance_fee'];

            }
        }

        if(!empty($incurance_data)){

            foreach ($incurance_data as $index => $incurance){

                if(empty($incurance['incurance_fee'])){

                    $incurance_data[$index]['incurance_fee'] = 0;
                    $incurance_data[$index]['insurance'] = $order_info['free_insurance'];
                }
            }

            $data['incurance'] = $incurance_data;

        }else{

            $data['prod'] = $this->Order_model->get_luggage_order($order_id);
        }

        $pick_up_inf = $this->Order_model->get_pickup_info($order_id);
        $incurance_info =  $this->_set_incurance($order_id,$pick_up_inf['pickup_country_id'],$order_info['shipping_type']);
        $data['incurance_info'] = $incurance_info;

        $data['incurance'] = $incurance_data;
        $data['order_info'] = $order_info;

        $this->load->view('frontend/orders/incurance_view', $data);
    }

    public function ax_delivery_label_view(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['country'] = "";
        $data['delivery_info'] = [];
        $data['state'] = "";
        $data['order_info'] = $order_info;
        $delivery_label = $this->Order_model->get_delivery_label($order_id);

        if(!empty($delivery_label)){

            $data['delivery_info'] = $delivery_label;
        }
        $country = $this->Users_model->get_countries($delivery_label['country_id']);

        if(!empty($country[0]['country'])){

            $data['country'] = $country[0]['country'];

        }

        $state = $this->Order_model->get_states_by_id($delivery_label['state_id']);

        if(!empty($state)){

            $data['state'] = $state['State'];
        }

        $this->load->view('frontend/orders/label_delivery_view', $data);

    }


    public function ax_update_insurance(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $incurance_select_value = $this->security->xss_clean($this->input->post('incurance_id'));

        $data['errors']        = [];
        $data['success']       = [];
        $data['insurance']     = [];
        $data['max_incurance'] = [];
        $user = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $this->Order_model->set_order_last_use($order_id);

        $sender_info = $this->Order_model->get_pickup_info($order_id);

        if(empty($sender_info['pickup_country_id'])){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }



        if(empty($incurance_select_value)){

            $data['errors'][] = "Please select insurance";
            echo json_encode($data);
            return false;
        }

        $country_id = $sender_info['pickup_country_id'];

        $order = $this->Order_model->get_order_info($order_id);
        $incurance_info =  $this->_set_incurance($order_id,$country_id,$order['shipping_type']);
        $extra_fee = 0;
        $max_incurance = 0;
        $insert_data = [];
        foreach ($incurance_select_value as $item => $value){

            if(empty($value)){

                continue;
            }


            $incurance_select_id = $value;

            if($order['shipping_type'] == '1'){

                    if(stripos($order['send_type'], 'outbound') !== false){
                        $sender_info = $this->Order_model->get_pickup_info($order_id);
                        $country_id = $sender_info['pickup_country_id'];

                    }elseif (stripos($order['send_type'], 'inbound') !== false){
                        $receiver_info = $this->Order_model->get_delivery_info($order_id);
                        $country_id = $receiver_info['delivery_country_id'];

                    }

                $all_insurance = $this->Manage_price_model->get_international_insurance($country_id,$incurance_select_id);

            }elseif ($order['shipping_type'] == '2' ){

                $all_insurance = $this->Manage_price_model->get_domestic_insurance($country_id,$incurance_select_id);

            }


            if(!empty($all_insurance)){

                $extra_fee     += $all_insurance[0]['insurance_amount'];
                $max_incurance += $all_insurance[0]['insurance_fee'];

                $insert_data[$item] = [
                    'incurance_id'  => $all_insurance[0]['id'],
                    'insurance'     => $all_insurance[0]['insurance_amount'],
                    'incurance_fee' => $all_insurance[0]['insurance_fee'],
                ];

                $insert_data[$item]['luggage_name'] = $incurance_info['incurance'][$item]['luggage_name'];
                $insert_data[$item]['type_name'] = $incurance_info['incurance'][$item]['type_name'];
                $insert_data[$item]['weight'] = $incurance_info['incurance'][$item]['weight'];
                $insert_data[$item]['order_id'] = $incurance_info['incurance'][$item]['order_id'];
                $insert_data[$item]['order_luggage_id'] = $incurance_info['incurance'][$item]['order_luggage_id'];
            }

        }

        $this->Order_model->delete_order_incurance($order_id);

        if(empty($insert_data)){

            $data['errors'][] = "Please select insurance";
            echo json_encode($data);
            return false;
        }

        $this->Order_model->insert_incurance($insert_data);

        $data['insurance']     = floatval($extra_fee);
        $data['max_incurance'] = floatval($max_incurance);
        $data['success']       = 'Update data saved';

        $billing_array = [
            'insurance_fee'  => $data['max_incurance'],
            'status'         => '1'
        ];

        $next_billing = $this->Billing_model->check_last_billing($order_id);

        $crt = [
            'type'     => $next_billing['next'],
            'order_id' => $order_id
        ];

        $billing_isset = $this->Billing_model->get_billing($crt);

        if(empty($billing_isset)){

            $billing_array['order_id'] = $order_id;
            $billing_array['user_id']  = $user->id;
            $billing_array['type']     = $next_billing['next'];

            $this->Billing_model->auto_fill_insert($billing_array);

        }else{

            $this->Billing_model->update_billing_info($billing_array, $order_id, $next_billing['next']);
        }

        echo json_encode($data);

    }

    public function _set_incurance($order_id,$country_id,$type){

        if (!$this->ion_auth->logged_in() || empty($order_id) || empty($country_id)|| empty($type)) {

            return false;

        }

        $return_data = [];

        $order_data =  $this->Order_model->get_luggage_order($order_id);
        $order_info =  $this->Order_model->get_order_info($order_id);

        if($order_info['shipping_type'] == 1){

            if(stripos($order_info['send_type'], 'outbound') !== false){

                $sender_info = $this->Order_model->get_pickup_info($order_id);
                $country_id = $sender_info['pickup_country_id'];

            }elseif (stripos($order_info['send_type'], 'inbound') !== false){


                $receiver_info = $this->Order_model->get_delivery_info($order_id);
                $country_id = $receiver_info['delivery_country_id'];
            }
        }

        foreach ($order_data as $index => $luggages){

            $return_data['incurance'][$luggages['id']] = [

                'luggage_name'     => $luggages['luggage_name'],
                'weight'           => $luggages['weight'],
                'type_name'        => $luggages['type_name'],
                'order_id'         => $order_id,
                'order_luggage_id' => $luggages['id'],
                'insurance'        => $order_info['free_insurance'],
                'incurance_fee'    => 0

            ];
        }

        $return_data['total_count'] = count($order_data);

        if($type == '1'){

            $all_insurance = $this->Manage_price_model->get_international_insurance($country_id);

        }else{

            $all_insurance = $this->Manage_price_model->get_domestic_insurance($country_id,NULL,true);
        }

        foreach ($all_insurance as $index => $insurance){

            if(empty($insurance['insurance_amount']) && empty($insurance['insurance_fee'])){

                continue;
            }

            $return_data['insurance_price'][] = [
                'insurance_amount' => $insurance['insurance_amount'],
                'insurance_fee'    => $insurance['insurance_fee'],
                'insurance_id'     => $insurance['id'],

            ];
        }

        return $return_data;
    }

    public function _insert_insurance($order_id){


        if (!$this->ion_auth->logged_in() || empty($order_id)) {

            return false;

        }

        $insert_data = [];

        $order_data =  $this->Order_model->get_luggage_order($order_id);
        $order_info =  $this->Order_model->get_order_info($order_id);

        if(empty($order_info['free_insurance'])){

            return false;
        }

        foreach ($order_data as $index => $luggages){

            $insert_data[] = [

                'luggage_name'     => $luggages['luggage_name'],
                'weight'           => $luggages['weight'],
                'type_name'        => $luggages['type_name'],
                'order_id'         => $order_id,
                'order_luggage_id' => $luggages['id'],
                'insurance'        => $order_info['free_insurance'],
                'incurance_fee'    => 0

            ];
        }

        if(!$this->Order_model->insert_incurance($insert_data)){

            return false;
        }


    }

    public function get_price_incurance($data = NULL,$type = NULL,$country_id = NULL){

        if (!$this->ion_auth->logged_in()) {

            return false;

        }

        $echo = false;

        if(empty($data) || empty($type)){

            $data  = $this->security->xss_clean($this->input->post('incurance_id'));
            $type  = trim($this->security->xss_clean($this->input->post('type')));
            $country_id  = trim($this->security->xss_clean($this->input->post('country_id')));
            $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));
            $echo = true;
        }

        if(empty($data || $type)|| empty($country_id)){

            return false;

        }

        $order = $this->Order_model->get_order_info($order_id);

        $return_data['extra_fee']     = 0;
        $return_data['max_incurance'] = 0;

        if(!empty($data)){

            foreach ($data as $index => $insurance_ids){

                $return_data['select_num'][$index] = $insurance_ids;

                if(empty($insurance_ids)){

                    continue;
                }

                $all_insurance = [];

                if($type == '1'){

                    if(stripos($order['send_type'], 'outbound') !== false){

                        $sender_info = $this->Order_model->get_pickup_info($order_id);
                        $country_id = $sender_info['pickup_country_id'];

                    }elseif (stripos($order['send_type'], 'inbound') !== false){


                        $receiver_info = $this->Order_model->get_delivery_info($order_id);
                        $country_id = $receiver_info['delivery_country_id'];
                    }

                    $all_insurance = $this->Manage_price_model->get_international_insurance($country_id,$insurance_ids);

                }elseif ($type == '2' ){

                    $all_insurance = $this->Manage_price_model->get_domestic_insurance($country_id,$insurance_ids);

                }

                if(!empty($all_insurance)){

                    $return_data['extra_fee']     += $all_insurance[0]['insurance_amount'];
                    $return_data['max_incurance'] += $all_insurance[0]['insurance_fee'];
                }

            }

            if($echo){

                echo json_encode($return_data);

            }else{

                return $return_data;
            }


        }

    }

    public function ax_delivery_label(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $post_data = $this->security->xss_clean($this->input->post());
        $trav_changed = trim($this->security->xss_clean($this->input->post('trav_changed')));
        $adress_changed = trim($this->security->xss_clean($this->input->post('adress_changed')));

        $data['errors']         = [];
        $data['success']        = [];
        $data['address_info']   =[];
        $data['traveller_info'] =[];
        $data['add_id']         =[];
        $data['trav_id']        =[];

        $user = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order = $this->Order_model->get_order_info($order_id);

        $delivery_label = $this->Order_model->get_delivery_label($order_id);
        $data['delivery_info'] = [];

        if(!empty($delivery_label)){

            $data['delivery_info'] = $delivery_label;
        }

        $my_traveller = $this->Users_model->get_traveler_list($user->id);
        $data['traveller'] = [];

        if(!empty($my_traveller)){

            $data['traveller'] = $my_traveller['travel_list'];


        }

        $address_book_cr = [

            'user_id'    => $user->id,
            'country_id' => $delivery_label['country_id']

        ];

        $my_address_book = $this->Users_model->get_address_book_list($address_book_cr);

        if(!empty($my_address_book)){

            $data['address_book'] = $my_address_book['address_book'];

        }

        $traveller_id = trim($this->security->xss_clean($this->input->post('trav_id')));
        $address_book_id = trim($this->security->xss_clean($this->input->post('add_id')));

        if(!empty($traveller_id)){

            $data['traveller_info'] =   $this->_return_data_for_sender_pickup($traveller_id,$user->id);
            $data['trav_id'] = $traveller_id;

        }

        if(!empty($address_book_id)){

            $data['address_info']   =   $this->_return_address_data($address_book_id,$user->id,'1');
            $data['add_id'] = $address_book_id;
        }

        $data['country'] = $this->Users_model->get_countries($delivery_label['country_id']);
        $data['states'] = $this->Users_model->get_states($delivery_label['country_id']);

        if(!empty($adress_changed)){

            $data['delivery_info']['first_name'] = $post_data['first_name'];
            $data['delivery_info']['last_name'] = $post_data['last_name'];
            $data['delivery_info']['phone'] = $post_data['phone'];
            $data['delivery_info']['email'] = $post_data['email'];
            $data['delivery_info']['state_id'] = $data['address_info']['state'];
        }

        if(!empty($trav_changed)){

            $data['delivery_info']['company'] = $post_data['company'];
            $data['delivery_info']['address1'] = $post_data['address1'];
            $data['delivery_info']['address2'] = $post_data['address2'];
            $data['delivery_info']['postal_code'] = $post_data['postal_code'];
            $data['delivery_info']['city'] = $post_data['city'];
            $data['delivery_info']['state_id'] = $post_data['state_region'];
            $data['delivery_info']['remark'] = $post_data['remark'];
        }

        $this->load->view('frontend/orders/delivery_label',$data);
    }

    public function ax_save_delivery_label(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $first_name = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name = trim($this->security->xss_clean($this->input->post('last_name')));
        $phone = trim($this->security->xss_clean($this->input->post('phone')));
        $email = trim($this->security->xss_clean($this->input->post('email')));
        $company = trim($this->security->xss_clean($this->input->post('company')));
        $address1 = trim($this->security->xss_clean($this->input->post('address1')));
        $address2 = trim($this->security->xss_clean($this->input->post('address2')));
        $postal_code = trim($this->security->xss_clean($this->input->post('postal_code')));
        $city = trim($this->security->xss_clean($this->input->post('city')));
        $state_id = trim($this->security->xss_clean($this->input->post('state_region')));
        $remark = trim($this->security->xss_clean($this->input->post('remark')));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $user = $this->ion_auth->user()->row();

        $data['errors'] = [];
        $data['success'] = [];

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        $update_data = [

            'order_id'    => $order_id,
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'phone'       => $phone,
            'email'       => $email,
            'company'     => $company,
            'address1'    => $address1,
            'address2'    => $address2,
            'postal_code' => $postal_code,
            'city'        => $city,
            'state_id'    => $state_id,
            'remark'      => $remark,
        ];

        if(!$this->Order_model->update_delivery_label($update_data, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $data['success'][] = 'All data  saved';

        echo json_encode($data);

    }


    public function ax_drop_off_map(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $zip_code = trim($this->security->xss_clean($this->input->post('zip_code')));

        $state_place = '';
        $postal_code = '';

        $user = $this->ion_auth->user()->row();

        $data['errors'] = [];
        $data['success'] = [];
        $data['action'] = true;

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if($order_info['shipping_type'] == '1'){
            $data['international'] = true;
        }

        $data['order_info'] = $order_info;

        if(!empty($zip_code)){

            $state_explode = explode('-',$zip_code);

            if(!empty($state_explode[1])){

                $state_place = $state_explode[1];
            }

            if(strtolower($order_info['currier_name']) != 'dhl'){
                $zip_code = preg_replace('/[^0-9]+/', '', $zip_code);

            }elseif (strtolower($order_info['currier_name']) == 'dhl'){

                $postal_code = preg_replace('/[^0-9]+/', '', $zip_code);
            }

        }

        $sender_info = $this->Order_model->get_pickup_info($order_id);

        $data['country_id'] = $sender_info['pickup_country_id'];
        $data['country_info'] = $this->Users_model->get_countries($data['country_id'], true);
        $data['carrier_info'] = $this->Order_model->get_carrier_by_name($order_info['currier_name']);

        $this->load->library('Google_api');

        // DHL CURL
        if(strtolower($order_info['currier_name']) == 'dhl'){

            $county = $this->Users_model->get_countries($sender_info['pickup_country_id']);

            if(empty($postal_code)) {
                $postal_code = $sender_info['pickup_postal_code'];
            }

            if($county[0]['id'] != '226'){

                $postal_code = $zip_code;

            }

            if(!empty($county[0]['country'])){

                $country = $county[0]['country'];
                $search = $country.' '.$postal_code.' '.$state_place.' dhl location';

            }else{

                $search = $zip_code.' '.$state_place.' dhl location';
            }

            $country_id = $county[0]['id'];

            $location = [
                'lat' => 0,
                'lng' => 0
            ];

            $info = NULL;

            if(!empty($zip_code)){
                $info = $this->google_api->get_place_id($postal_code, true);

            }

            if(empty($info)){

                $data['action'] = false;
            }else{

                $location = $info['results'][0]['geometry']['location'];
            }

            $data['lat'] = $location['lat'];
            $data['lng'] = $location['lng'];

            $data['action'] = 'google';
            $data['zip_code'] = $zip_code;
            $data['postal_code'] = $postal_code;
            $data['search'] = $search;
            $data['country_id'] = $country_id;

            $this->load->view('frontend/orders/dropoff', $data);

            return false;

        }
        // END DHL

        $location = [
            'lat' => 0,
            'lng' => 0
        ];

        if(empty($zip_code)) {
            $zip_code = $sender_info['pickup_postal_code'];
        }

        $info = NULL;

        if(!empty($zip_code)){
            $info = $this->google_api->get_place_id($zip_code, true);
        }

        if(empty($info)){

            $data['action'] = false;
        }else{

            $location = $info['results'][0]['geometry']['location'];
        }

        $data['lat'] = $location['lat'];
        $data['lng'] = $location['lng'];

        $data['store_type'] = strtolower($order_info['currier_name']);

        $radius_array = [5, 10, 15, 50];

        foreach ($radius_array as $radius){

            $loc_info = $this->_genxml($zip_code,$data['lat'],$data['lng'],$radius, $data['store_type']);

            if(!empty($loc_info['info'])){
                break;
            }

        }

        if(empty($loc_info['info'])){
            $loc_info = $this->_genxml($zip_code, $data['lat'], $data['lng'], $radius, $data['store_type'], true);
        }

        if(empty($loc_info['info'])){
            $data['action'] = false;
        }

        $data['xml'] = $loc_info['xml'];
        $data['info'] = $loc_info['info'];
        $data['zip_code'] = $zip_code;

        $this->load->view('frontend/orders/dropoff', $data);

    }


    public function _genxml($zip_code, $center_lat, $center_lng, $radius, $store_type, $all_types = NULL) {

        switch ($store_type) {
            case 'ups':

                $end_point = "https://onlinetools.ups.com/ups.app/xml/Locator";
                $accessKey = '2D1BCDF403AC62EE';
                $userId = 'mikeulker';
                $password = 'Aie 10017';


                $xml_ups = '<?xml version="1.0"?>
						<AccessRequest xml:lang="en-US">
							<AccessLicenseNumber>'.$accessKey.'</AccessLicenseNumber>
							<UserId>'.$userId.'</UserId>
							<Password>'.$password.'</Password>
						</AccessRequest>
						<?xml version="1.0"?>
						<LocatorRequest xml:lang="en-US">
							<Request>
								<TransactionReference/>
								<RequestAction>Locator</RequestAction>
								<RequestOption>1</RequestOption>
							</Request>
							<OriginAddress>
								<Geocode>
									<Latitude>'.$center_lat.'</Latitude>
									<Longitude>'.$center_lng.'</Longitude>
								</Geocode>
								<AddressKeyFormat>
									<CountryCode>US</CountryCode>
								</AddressKeyFormat>
							</OriginAddress>
							<Translate>
								<LanguageCode>ENG</LanguageCode>
						</Translate>
						<UnitOfMeasurement>
							<Code>MI</Code>
							<Description>Miles</Description>
						</UnitOfMeasurement>
						<LocationSearchCriteria>
							<AccessPointSearch>
								<AccessPointStatus>01</AccessPointStatus>
							</AccessPointSearch>
							<MaximumListSize>50</MaximumListSize>
							<SearchRadius>'.$radius.'</SearchRadius>
							<SearchOption>
								<OptionType>
									<Code>01</Code>
								</OptionType>
								<OptionCode>
									<Code>002</Code>
								</OptionCode>
							</SearchOption>
						</LocationSearchCriteria>
					</LocatorRequest>';


                $response = $this->_send_postdata($end_point, $xml_ups);

                if(empty($response->SearchResults->DropLocation)){
                    return false;
                }


                $xml_doc = new DOMDocument("1.0");
                $markers = $xml_doc->createElement("markers");
                $child   = $xml_doc->appendChild($markers);
                $info = [];

                foreach($response->SearchResults->DropLocation as $single){

                    $distance     = $single->Distance->Value;
                    $units        = strtolower($single->Distance->UnitOfMeasurement->Code);
                    $company_name = $single->AddressKeyFormat->ConsigneeName;
                    $phone_number = $single->PhoneNumber;
                    $street       = $single->AddressKeyFormat->AddressLine;
                    $city         = $single->AddressKeyFormat->PoliticalDivision2;
                    $state        = $single->AddressKeyFormat->PoliticalDivision1;
                    $postal_code  = $single->AddressKeyFormat->PostcodePrimaryLow;
                    $latitude     = $single->Geocode->Latitude;
                    $longitude    = $single->Geocode->Longitude;
                    $store_closes = $single->OperatingHours->StandardHours->DayOfWeek[1]->CloseHours;
                    $store_closes = date("g:i a", strtotime($store_closes));

                    $last_drop_off_time_ground = $single->LatestGroundDropOffTime;
                    $last_drop_off_time_air = $single->LatestAirDropOffTime;

                    if(!empty($company_name)){

                        $info[] = [
                            'name'    => $company_name,
                            'phone'   => $phone_number,
                            'street'  => $street,
                            'city'    => $city,
                            'state'   => $state,
                            'dist'    => $distance,
                            'time_gr' => get12hoursTim($last_drop_off_time_ground),
                            'time_ai' => get12hoursTim($last_drop_off_time_air)
                        ];
                    }
                    $markers = $xml_doc->createElement("marker");
                    $newchild = $child->appendChild($markers);
                    $newchild->setAttribute("name", $company_name);
                    $newchild->setAttribute("address", $street . ', ' .$city . ', ' . $state . ' ' . $postal_code);
                    $newchild->setAttribute("phone", $phone_number);
                    $newchild->setAttribute("lat", $latitude);
                    $newchild->setAttribute("lng", $longitude);
                    $newchild->setAttribute("type", 'ups');
                    $newchild->setAttribute("distance", $distance . ' ' . $units);
                    $newchild->setAttribute("store_closes", $store_closes);

                }

                return array( 'xml' => $xml_doc->saveXML(), 'info' => $info );

                break;

            case 'fedex':

                //$this->load->library('drop_off_locations');
                //$result = $this->drop_off_locations->get_fedex_locations($radius, $zip_code);
//
                //if(empty($result)){
                //    return array( 'xml' => '', 'info' => [] );
                //}
//
                //return $result;

                require_once( APPPATH . 'libraries/ext/fedex/fedex-common.php5');
                $path_to_wsdl = APPPATH . 'libraries/ext/fedex/LocationsService_v7.wsdl';

                ini_set("soap.wsdl_cache_enabled", "0");
                // disable notice, warnings, error
                ini_set("error_reporting", "0");

                $dom = new DOMDocument("1.0");
                $node = $dom->createElement("markers");
                $parnode = $dom->appendChild($node);


                $client = new SoapClient($path_to_wsdl, array('trace' => 1));

                $request['WebAuthenticationDetail'] = array(
                    'ParentCredential' => array(
                        'Key' => getProperty('parentkey'),
                        'Password' => getProperty('parentpassword')
                    ),
                    'UserCredential' => array(
                        'Key' => getProperty('key'),
                        'Password' => getProperty('password')
                    )
                );

                $request['ClientDetail'] = array(
                    'AccountNumber' => getProperty('shipaccount'),
                    'MeterNumber' => getProperty('meter')
                );

                $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Search Locations Request using PHP ***');
                $request['Version'] = array(
                    'ServiceId' => 'locs',
                    'Major' => '7',
                    'Intermediate' => '0',
                    'Minor' => '0'
                );

                $request['EffectiveDate'] = date('Y-m-d');

                $bNearToPhoneNumber = false;
                if($bNearToPhoneNumber) {
                    $request['LocationsSearchCriterion'] = 'PHONE_NUMBER';
                    $request['PhoneNumber'] = getProperty('searchlocationphonenumber');
                }
                else {
                    $request['LocationsSearchCriterion'] = 'ADDRESS';
                    $request['Address'] =  array(
                        'PostalCode' => $zip_code,
                        'CountryCode' => 'US'
                    );
                }

                $request['MultipleMatchesAction'] = 'RETURN_ALL';
                $request['SortDetail'] = array(
                    'Criterion' => 'DISTANCE',
                    'Order' => 'LOWEST_TO_HIGHEST'
                );
                $request['Constraints'] = array(

                    'RadiusDistance' => array(
                        'Value' => $radius,
                        'Units' => 'MI'
                    ),
                    'ExpressDropOfTimeNeeded' => '15:00:00.00',
                    'ResultFilters' => 'EXCLUDE_LOCATIONS_OUTSIDE_STATE_OR_PROVINCE',
                    //	'SupportedRedirectToHoldServices' => array('FEDEX_EXPRESS', 'FEDEX_GROUND', 'FEDEX_GROUND_HOME_DELIVERY'),
                    'RequiredLocationAttributes' => array(
                        //'ACCEPTS_CASH','ALREADY_OPEN'
                    ),
                    'ResultsRequested' => 100,
                    //	'LocationContentOptions' => array('HOLIDAYS'),

                );

                if(!$all_types){
                    $request['Constraints']['LocationTypesToInclude'] = array('FEDEX_OFFICE');
                } else {
                    $request['Constraints']['LocationTypesToInclude'] = array('FEDEX_OFFICE', 'FEDEX_AUTHORIZED_SHIP_CENTER');
                }

                $request['DropoffServicesDesired'] = array(
                    'Express' => 1,
                    'FedExStaffed' => 1,
                    'FedExSelfService' => 1,
                    'FedExAuthorizedShippingCenter' => 1,
                    'HoldAtLocation' => 1
                );

                try{
                    if(setEndpoint('changeEndpoint')){
                        $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                    }

                    $response = $client ->searchLocations($request);

                    $info = [];

                    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){

                        foreach($response->AddressToLocationRelationships->DistanceAndLocationDetails as $key => $value) {

                            if(is_array($value) || is_object($value)) {

                                $hours = $value->LocationDetail->NormalHours;

                                $distance = round($value->Distance->Value, 1);
                                $units = strtolower($value->Distance->Units);

                                $company_name = $value->LocationDetail->LocationContactAndAddress->Contact->CompanyName;
                                $phone_number = $value->LocationDetail->LocationContactAndAddress->Contact->PhoneNumber;

                                $street = $value->LocationDetail->LocationContactAndAddress->Address->StreetLines;
                                $city = $value->LocationDetail->LocationContactAndAddress->Address->City;
                                $state = $value->LocationDetail->LocationContactAndAddress->Address->StateOrProvinceCode;
                                $postal_code = $value->LocationDetail->LocationContactAndAddress->Address->PostalCode;

                                //$geo_codes = $value->LocationDetail->GeographicCoordinates;
                                $map_url = $value->LocationDetail->MapUrl;

                                $coords = get_coordinates($map_url);

                                $store_closes = $value->LocationDetail->NormalHours[0]->OperationalHours; //OPEN_ALL_DAY

                                if($store_closes == 'OPEN_ALL_DAY') {
                                    $store_closes = 'Closed';
                                }
                                else {
                                    $store_closes = $value->LocationDetail->NormalHours[0]->Hours->Ends;
                                }

                                if(is_array($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails[0]->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $value->LocationDetail->CarrierDetails[2]->EffectiveLatestDropOffDetails->Time;

                                }elseif(is_object($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $last_pickup_orange;

                                }

                                if(!empty($street)) {
                                    $info[] = [
                                        'name' => $company_name,
                                        'phone' => $phone_number,
                                        'street' => $street,
                                        'city' => $city,
                                        'state' => $state,
                                        'dist' => $distance,
                                        'time_gr' => 'Last Pickup ' .  get12hoursTime($last_pickup_green),
                                        'time_ai' => 'Last Pickup ' .  get12hoursTime($last_pickup_orange),
                                        'zip_code' => $postal_code
                                    ];
                                }

                                $node = $dom->createElement("marker");
                                $newnode = $parnode->appendChild($node);
                                $newnode->setAttribute("name", $company_name);
                                $newnode->setAttribute("type", "fedex");
                                $newnode->setAttribute("address", $street . ', ' .$city . ', ' . $state . ' ' . $postal_code);
                                $newnode->setAttribute("phone", $phone_number);
                                $newnode->setAttribute("lat", $coords[0]);
                                $newnode->setAttribute("lng", $coords[1]);
                                $newnode->setAttribute("distance", $distance . ' ' . $units);
                                $newnode->setAttribute("last_pickup_orange", get12hoursTime($last_pickup_orange));
                                $newnode->setAttribute("last_pickup_green", get12hoursTime($last_pickup_green));
                                $newnode->setAttribute("store_closes", get12hoursTime($store_closes));
                                $newnode->setAttribute("dist", $distance);
                            }
                        }

                        return array( 'xml' => $dom->saveXML(), 'info' => $info );

                    }
                    else{
                        // printError($client, $response);
                    }
                }
                catch (SoapFault $exception) {

                    printFault($exception, $client);
                }

                break;
            case 'dhl':

                break;
        }
    }


    private function _send_postdata($end_point, $xml_ups) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_ups);

        if (curl_errno($ch)) {
            echo curl_errno($ch) ;
            echo curl_error($ch);
        }
        else {
            $response = curl_exec($ch);
            $xml_to_array_resp = new SimpleXMLElement($response);
            curl_close($ch);
            return $xml_to_array_resp;
        }

    }


    public function ax_get_order_fee(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $price_array = $this->price_lib->get_order_fee($order_id, $user->id);
        $price = 0;

        if(!empty($price_array) && !empty($price_array['original_price'])){
            $price = $price_array['original_price'];
        }

        echo '$'.$price;

    }

    public function _get_count_by_cookie($data){

        if(empty($data)){

            return false;
        }

        $count = 0;
        if(!empty($data['luggage'])){

            foreach ($data['luggage'] as $kay => $products){

                $count += $products;

            }
        }

        foreach ($data['special'] as  $special_size){

            if(!empty($special_size)){

                $count += $special_size['count'];
            }
        }

        return $count;

    }


    private function _check_info_isset($order_id, $inf_name){

        if (empty($order_id) || empty($inf_name)) {
            return false;
        }

        $response = true;

        switch ($inf_name) {

            case 'credit_card':

                $user = $this->ion_auth->user()->row();

                $order_info = $this->Order_model->get_order_info($order_id, $user->id);

                if(empty($order_info['card_id'])){

                    $response = false;
                }


                break;


            case 'pick_up':

                $sender_info = $this->Order_model->get_pickup_info($order_id);

                $required = ['sender_first_name', 'sender_last_name', 'sender_phone', 'pickup_address1', 'pickup_city', 'pick_up'];

                foreach($required as $single){

                    if(empty($sender_info[$single])){

                        $response = false;
                        break;
                    }
                }

                break;


            case 'delivery':

                $receiver_info = $this->Order_model->get_delivery_info($order_id);

                $required = ['receiver_first_name', 'receiver_last_name', 'receiver_phone', 'delivery_address1', 'delivery_city'];

                foreach($required as $single){

                    if(empty($receiver_info[$single])){

                        $response = false;
                        break;
                    }

                }

                break;

            case 'item_list':

                $order_info = $this->Order_model->get_order_info($order_id);

                if(empty($order_info) || empty($order_info['signature'])){

                    $response = false;
                    break;
                }

                $item_list = $this->Order_model->get_item_list($order_id);

                if(empty($item_list)){

                    $response = false;
                }

                break;

            case 'passport':

                $passport_info  = $this->Order_model->get_order_passport_info($order_id);

                if(empty($passport_info)){

                    $response = false;
                }

                break;

            case 'travel':

                $travel = $this->Order_model->get_travel($order_id);

                if(empty($travel)){

                    $response = false;
                }

                break;


            default:

                $response = false;

        }

        return $response;

    }

    public function ax_set_discount(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $code     = trim($this->security->xss_clean($this->input->post('code')));

        $user = $this->ion_auth->user()->row();

        $data['errors'] = [];
        $data['success'] = [];

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $result = $this->_set_interest_discount($order_id, $code);

        if(empty($result)){

            $data['errors'][] = 'Invalid code.';
        }else{

            $data['success'] = 'Discount code successfully applied.';
        }

        if(!empty($data['errors'])){
            echo json_encode($data);
            return false;
        }

        $billing_array = [
            'promotion_code'  => $result['amount'],
            'promotion_type'  => $result['type'],
            'status'          => '1'
        ];

        $next_billing = $this->Billing_model->check_last_billing($order_id);

        $crt = [
            'type'     => $next_billing['next'],
            'order_id' => $order_id
        ];

        $billing_isset = $this->Billing_model->get_billing($crt);

        if(empty($billing_isset)){

            $billing_array['order_id'] = $order_id;
            $billing_array['user_id']  = $user->id;
            $billing_array['type']     = $next_billing['next'];

            $this->Billing_model->auto_fill_insert($billing_array);

        }else{

            $this->Billing_model->update_billing_info($billing_array, $order_id, $next_billing['next']);
        }

        echo json_encode($data);

    }

    private function _set_interest_discount($order_id, $discount_code){

        if(empty($order_id) || empty($discount_code)){
            return false;
        }

        $this->load->model('Promotion_model');

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            return false;
        }

        $discount_info = $this->Order_model->get_discount_code_info($discount_code);

        if(empty($discount_info)){
            return false;
        }

        if($discount_info['date_to'] != '0000-00-00' && $discount_info['date_to'] < date('Y-m-d')){
            return false;
        }

        if($discount_info['date_from'] != '0000-00-00' && $discount_info['date_from'] > date('Y-m-d')){
            return false;
        }

        if($discount_info['count_of_use'] != '-10' && $discount_info['count_of_use'] < 1){
            return false;
        }

        if($discount_info['count_of_use'] != '-10' && $discount_info['count_of_use'] < 1){
            return false;
        }

        if($discount_info['status'] != '1'){
            return false;
        }

        $service_type = $discount_info['promotion_type'];

        $this->load->config('promotion');

        $config_array = $this->config->item('promotion_types');

        if(!isset($config_array[$service_type])){
            return false;
        }

        if(!empty($config_array[$service_type])){

            $shipping_type = $config_array[$service_type]['shipping_type'];

            if($shipping_type != $order_info['shipping_type']){
                return false;
            }

            if(!empty($config_array[$service_type]['service_type'])){

                $service_type = $config_array[$service_type]['service_type'];

                if(stripos($order_info['send_type'], $service_type) === FALSE){
                    return false;
                }

            }

        }

        if(!empty($discount_info['amount_p']) && $discount_info['amount_p'] > 0){

            $discount_type = '1';
            $amount = $discount_info['amount_p'];

        }elseif(!empty($discount_info['amount_d']) && $discount_info['amount_d'] > 0){

            $discount_type = '2';
            $amount = $discount_info['amount_d'];
        }

        if(empty($discount_type)){
            return false;
        }

        $discount_id = $discount_info['id'];

        $result = $this->Order_model->set_order_discount($order_id, $discount_info['code'], $amount, $discount_type, $discount_id);

        if(empty($result)){
            return false;
        }

        if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){

            $this->Promotion_model->use_promotion($discount_id);

            if(!empty($order_info['discount_id'])){

                $this->Promotion_model->add_promotion($order_info['discount_id']);
            }
        }

        $return_array = [
            'amount' => $amount,
            'type'   => $discount_type
        ];

        return $return_array;

    }


    public function ax_check_order(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            show_404();
            return false;
        }

        $this->load->model('Promotion_model');

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];

        $user = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id)){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(!$this->_check_info_isset($order_id, 'pick_up') || !$this->_check_info_isset($order_id, 'delivery') || !$this->_check_info_isset($order_id, 'credit_card')){

            $data['errors'][] = 'All information must be completed';
            echo json_encode($data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if($order_info['shipping_type'] == '1'){

            $pay_info = $this->price_lib->get_order_fee($order_id, $user->id);

            if(!empty($pay_info['pay_from_credit']) && empty($data['errors'])){

                $account_credit = floatval($user->account_credit) - floatval($pay_info['pay_from_credit']);

                if(!$this->Users_model->update_user(['account_credit' => $account_credit], $user->id)){

                    $data['errors'] = 'Can not charging from account credit';

                }else{

                    $this->Order_model->set_order(['credit_paid' => $pay_info['pay_from_credit']], ['id' => $order_id]);

                    $insert_data = [
                        'user_id'     => $user->id,
                        'order_id'    => $order_id,
                        'card_id'     => 0,
                        'card_number' => 'From credit',
                        'date'        => date('Y-m-d H:i:s'),
                        'amount'      => $pay_info['pay_from_credit'],
                        'type'        => 1,
                        'status'      => 1
                    ];

                    $this->Order_model->insert_payment_history($insert_data);
                    $this->Users_model->change_total_paid($user->id, $pay_info['pay_from_credit']);

                }

            }

            $this->Order_model->change_order_status($order_id, SUBMITTED_STATUS[0]);
        }

        if(!empty($order_info['discount_id'])){

            $result = $this->Promotion_model->use_promotion($order_info['discount_id']);
        }

        $charge_info = $this->price_lib->get_order_fee($order_id, $user->id);

        if(empty($charge_info)){
            $data['errors'][] = 'Incorrect fee information.';
            echo json_encode($data);
            return false;
        }

        $billing_array = [
            'pickup_fee'     => $charge_info['pick_up'],
            'insurance_fee'  => $charge_info['insurance'],
            'account_credit' => $charge_info['account_credit'],
        ];

        if(!empty($charge_info['discount_p'])){
            $billing_array['promotion_code'] = $charge_info['discount_p'];
            $billing_array['promotion_type'] = '1';
        }else{
            $billing_array['promotion_code'] = $charge_info['discount_d'];
            $billing_array['promotion_type'] = '2';
        }

        $this->Billing_model->update_billing_info($billing_array, $order_id, 'estimate');
        $this->config->load('general_email');
        if($order_info['shipping_type'] == 1 && $order_info['update_order'] != 1){

            $subject = 'Thank you for your order, please complete the item list.  – '.$order_info['order_id'];
            $subject_description = ' Hi '.$user->first_name." ".$user->last_name.' , thank you for submitting an international order. Because a detailed item list is necessary for the custom clearance, please complete the list by clicking the item list link in this email.  Thanks.';
            $this->_send_label_charge_email($order_id,$user->id,'international_submited_order',$subject,$subject_description);
            $this->_send_label_charge_email($order_id,$user->id,'international_submited_order',$subject,$subject_description, $this->config->item('server_email'));

        }else if($order_info['shipping_type'] == 1 && $order_info['update_order'] == 1){

            $subject = 'Thank you for updating order ' . $order_info['order_id'];
            $subject_description = 'Hi ' . $user->first_name . " " . $user->last_name. ', your order ' . $order_info['order_id'] . ' has been updated successfully. We are preparing shipping labels and will send it to you soon.  Thanks.';
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description, $this->config->item('server_email'));
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description);

        }

        $data['order_id'] = $order_info['id'];
        $data['type']     = $order_info['shipping_type'];

        echo json_encode($data);

    }

    public function ax_charge_order_pay(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            show_404();
            return false;
        }

        $data['errors'] = [];

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['order_id'] = $order_id;

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(!empty($order_info['аmount_paid']) || !empty($order_info['credit_paid'])){

            $data['errors'][] = 'Fee for this order already charged.';

            $this->Order_model->change_order_status($order_id, SUBMITTED_STATUS[0]);
            $this->config->load('general_email');

            if($order_info['shipping_type'] == 2 ){

                $subject = 'Thank you for submitting shipping order – '.$order_info['order_id'];
                $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', thank you for submitting order '.$order_info['order_id'].'. We will process the order and send you shipping labels soon. ';
                $this->_send_label_charge_email($order_id,$user->id,'dom_submited_no_charge',$subject,$subject_description, $this->config->item('server_email'));
                $this->_send_label_charge_email($order_id,$user->id,'dom_submited_no_charge',$subject,$subject_description);

            }

            echo json_encode($data);
            return false;
        }

        $card_info = $this->Order_model->get_credit_card_by_id($user->id, NULL, $order_info['card_id']);

        if(empty($card_info)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;
        }

        $pay_info = $this->price_lib->get_order_fee($order_id, $user->id);

        if(!empty($pay_info['pay_from_credit']) && empty($data['errors'])){

            $account_credit = floatval($user->account_credit) - floatval($pay_info['pay_from_credit']);

            if(!$this->Users_model->update_user(['account_credit' => $account_credit], $user->id)){

                $data['errors'] = 'Can not charging from account credit';

            }else{

                $this->Order_model->set_order(['credit_paid' => $pay_info['pay_from_credit']], ['id' => $order_id]);

                $insert_data = [
                    'user_id'     => $user->id,
                    'order_id'    => $order_id,
                    'card_id'     => 0,
                    'card_number' => 'From credit',
                    'date'        => date('Y-m-d H:i:s'),
                    'amount'      => $pay_info['pay_from_credit'],
                    'type'        => 1,
                    'status'      => 1
                ];

                $this->Order_model->insert_payment_history($insert_data);
                $this->Users_model->change_total_paid($user->id, $pay_info['pay_from_credit']);

            }

        }

        if(!empty($pay_info['pay_from_card'])){

            $amount = $pay_info['pay_from_card'];

            $payment_array = [
                'currency'    => 'USD',
                'description' => 'Pay for Order :'.$order_info['order_id'].', User id :'.$user->account_name,
                'customer_id' => $card_info['customer_id'],
                'card'        => $card_info['card_id'],
                'amount'      => intval($amount*100),
            ];

            $result = $this->payment_lib->do_paymant_from_customer($payment_array);

            $card_info_stripe = $this->payment_lib->get_card_info($payment_array['customer_id'], $payment_array['card']);

            $cvc_check = false;
            $street_check = false;
            $address_zip_check = false;
            $risk_check = false;

            if(!empty($card_info_stripe['cvc_check']) && $card_info_stripe['cvc_check'] == 'pass'){
                $cvc_check = true;
            }

            if(!empty($card_info_stripe['address_line1_check']) && $card_info_stripe['address_line1_check'] == 'pass'){
                $street_check = true;
            }

            if(!empty($card_info_stripe['address_zip_check']) && $card_info_stripe['address_zip_check'] == 'pass'){
                $address_zip_check = true;
            }

            if(!empty($result['outcome']['risk_level']) && $result['outcome']['risk_level'] != 'elevated'){
                $risk_check = true;
            }

            $update_credit_card_info = [
                'street_check'      => $street_check,
                'zip_check'         => $address_zip_check,
                'risk_check'        => $risk_check,
                'cvc_check'         => $cvc_check,
            ];

            $this->Users_model->edit_credit_card($card_info['id'],$update_credit_card_info);

            if(!empty($result->status) && $result->status == 'succeeded'){

                $this->Order_model->set_order(['аmount_paid' => $amount], ['id' => $order_id]);

                $insert_data = [
                    'user_id'     => $user->id,
                    'order_id'    => $order_id,
                    'card_id'     => $order_info['card_id'],
                    'charge_id'   => $result->id,
                    'card_number' => $card_info['card_number'],
                    'date'        => date('Y-m-d H:i:s'),
                    'amount'      => $amount,
                    'status'      => 1,
                    'type'        => 1
                ];

                $this->Order_model->insert_payment_history($insert_data);
                $this->Users_model->change_total_paid($user->id, $amount);

            }else{

                $this->save_credit_card_error($order_id, $result, $card_info['card_number']);
                $data['errors'] = $result;
            }

        }

        if(empty($data['errors'])){

            $data['success'] = 'Order fee successfully charged.';

            $this->Order_model->change_order_status($order_id, PROCESSED_STATUS[0]);

            $data_insert = [
                'update_date' => date('Y-m-d H:i:s'),
                'status'      => '0'
            ];

            $this->Billing_model->update_billing_info($data_insert, $order_id, 'initial');

        }else{

            $this->Order_model->change_order_status($order_id, SUBMITTED_STATUS[0]);

            if($order_info['shipping_type'] == 2 && $order_info['update_order'] != 1){

                $subject = ' Thank you for submitting shipping order – '.$order_info['order_id'];
                $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', thank you for submitting order '.$order_info['order_id'].'. We will process the order and send you shipping labels soon. ';
                $this->_send_label_charge_email($order_id,$user->id,'dom_submited_no_charge',$subject,$subject_description);
            }

        }

        echo json_encode($data);

    }

    public function ax_create_shipment(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            echo show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];

        if($this->Order_model->check_label_creating($order_id)){

            $data['errors'][] = 'Labels already created.';
            echo json_encode($data);
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $pay_info = $this->price_lib->get_order_fee($order_id, $user->id);

        if(isset($pay_info['original_price']) && $pay_info['original_price'] >= 750){

            $this->Order_model->insert_label_error($order_id, 'Order amount greater than $750. Labels will not be created.');
            $this->submit_no_label($order_info,$user);
            $data['errors'][] = 'Label creating disabled.';
            echo json_encode($data);
            return false;
        }

        $credit_card_info = $this->Users_model->get_credit_cards(['id' => $order_info['card_id']]);

        if(empty($credit_card_info[0]) || empty($credit_card_info[0]['cvc_check']) || empty($credit_card_info[0]['street_check']) || empty($credit_card_info[0]['zip_check']) || empty($credit_card_info[0]['risk_check'])){

            $this->Order_model->insert_label_error($order_id, 'The credit card under the risk. Please check it');
            $this->submit_no_label($order_info,$user);
            $data['errors'][] = 'Label creating disabled.';
            echo json_encode($data);
            return false;
        }

        $address_validation = $this->validate_order_address($order_id);

        if($address_validation['status'] != 'OK'){

            $this->Order_model->insert_label_error($order_id, 'Address validation errors -> '.implode(' ', $address_validation['message']));
            $this->submit_no_label($order_info,$user);
            $data['errors'][] = 'Invalid address can not create label.';
            echo json_encode($data);
            return false;
        }

        $result = $this->_create_shipment($order_id, $user->id);

        if(!empty($result['warnings'])){
            $this->Order_model->insert_label_error($order_id, $result['warnings']);
        }
        $this->config->load('general_email');
        if($order_info['update_order'] == 1){

            $subject = 'Thank you for updating order ' . $order_info['order_id'];
            $subject_description = 'Hi ' . $user->first_name . " " . $user->last_name. ', your order ' . $order_info['order_id'] . ' has been updated successfully. We are preparing shipping labels and will send it to you soon.  Thanks.';
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description);
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description, $this->config->item('server_email'));

            $this->Order_model->update_order($order_id, ['update_order' => 0]);
        }

        if($result['status'] != 'OK'){

            $this->Order_model->insert_label_error($order_id, $result['errors']);

            $this->submit_no_label($order_info,$user);

            $data['errors'] = 'Thank you for payment. Your shipping labels will be ready as soon as possible.';
            echo json_encode($data);
            return false;

        }else{

            $this->Order_model->update_order($order_id, ['sys_label' => 1]);
        }

        $this->ax_create_label_pdf($order_id);

        if($this->Order_model->check_label_creating($order_id)){

            $this->config->load('general_email');
            if($order_info['update_order'] != 1) {

                $subject = 'Your shipping label is ready - ' . $order_info['order_id'];
                $subject_description = 'Hi ' . $user->first_name . " " . $user->last_name . ', your shipping label for order ' . $order_info['order_id'] . ' is ready,' . $order_info['currier_name'] . ' Please print out shipping labels and instruction via a link enclosed in this email. Thanks.   ';
                $this->_send_label_charge_email($order_id, $user->id, 'charge_and_label', $subject, $subject_description);
                $this->_send_label_charge_email($order_id, $user->id, 'charge_and_label', $subject, $subject_description,$this->config->item('server_email'));
            }

        }

        echo json_encode($data);

    }

    private function submit_no_label($order_info,$user){

        $this->config->load('general_email');
        if($order_info['update_order'] != 1){
            $subject = 'Your order  is confirmed - '.$order_info['order_id'];
            $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', thank you for submitting order '.$order_info['order_id'].'. We will process the order and send you shipping labels soon. ';

            $this->_send_label_charge_email($order_info['id'],$user->id,'submited_no_label',$subject,$subject_description);
            $this->_send_label_charge_email($order_info['id'],$user->id,'submited_no_label',$subject,$subject_description,$this->config->item('server_email'));

        }

    }

    public function ax_cancel_order(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];

        $user = $this->ion_auth->user()->row();

        if(!$this->Order_model->check_order_by_id($user->id, $order_id, PROCESSED_STATUS[0])){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);
        $delivery_label = $this->Order_model->get_delivery_label($order_id);
        $procesing_fee =$this->Manage_price_model->get_processing_fee($delivery_label['country_id']);

        $data_inf = [
            'order_number'   => $order_info['order_id'],
            'processing_fee' => $procesing_fee,
            'order_id'       => $order_id
        ];

        $data_inf['first_name'] = $user->first_name;
        $data_inf['last_name'] = $user->last_name;
        $subject_description = '';
        $subject = 'Your order has been cancelled – ' . $user->account_name;

        $last = $this->Billing_model->check_last_billing($order_id);
        $final_billing = $last['last_billing'];

        if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){

            $this->Order_model->change_order_status($order_id, SUBMITTED_CANCEL_STATUS[0]);
            $this->Order_model->add_cancel_count($order_id);

            $view = 'cancel_before_processed';
            $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', your order has been cancelled successfully and your credit card was not charged for this order.  We are looking forward providing you services soon. Thanks.';
            $subject = 'Your order has been cancelled - '. $user->account_name;
        }elseif($order_info['shipping_status'] == PROCESSED_STATUS[0]){



            $label_shipment = $this->Order_model->get_label_shipment($order_id);
            $subject = 'Your order cancellation request has been submitted  – ' . $user->account_name;
            if(!empty($label_shipment['tracking_number'])){

                $view = 'cancel_after_processed';
                $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', thanks for submitting a cancellation request for your order. We will complete the cancellation and process the refund within 15 days. Please feel free to contact us if you have any question. Thanks.';

            }else{

                $view = 'cancel_after_send_labels';
                $subject_description = 'Hi '.$user->first_name." ".$user->last_name.', thanks for submitting a cancellation request for your order. We will complete the cancellation and process the refund within 15 days. Please feel free to contact us if you have any question. Thanks.';

            }

            $this->Order_model->add_cancel_count($order_id);
            $this->Order_model->change_order_status($order_id, PROCESSED_CANCEL_STATUS[0]);

        }

        $data_inf['subject_description'] = $subject_description;
        $data_inf['delivery_fee'] = $final_billing['label_delivery_fee'];

        $email_data = array(
            'email'     => $user->email,
            'to_name'   => $user->username,
            'variables' => $data_inf,
            'subject'  => $subject,
        );

        $this->general_email->send_email($view,$email_data);


        echo json_encode($data);

    }


    public function ax_item_list(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $delivery_info = $this->Order_model->get_delivery_info($order_id);

        if(empty($delivery_info)){

            show_404();
            return false;
        }

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];

        $data['action'] = 'add';

        if(!empty($item_list)){

            $data['order_item_list'] = $item_list;
        }

        if(!empty($item_list) && !empty($order_info['signature'])){

            $data['action'] = 'view';
        }

        $country_id = $delivery_info['delivery_country_id'];
        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info)){

            show_404();
            return false;
        }

        $data['item_name'] = $this->Lists_model->get_data_by_list_key('item_name');

        $data['country_info'] = $country_info[0];
        $data['order_info'] = $order_info;

        $country_profile = $this->Manage_price_model->get_country_profile($data['country_info']['iso2']);

        if(empty($country_profile)){

            $data['custom_value'] = 0;
        }else{

            $data['custom_value'] = $country_profile[0]['custom_value'];
        }

        $data['uploaded_document'] = $this->Order_model->get_order_form_document($order_id);

        $data['form_files'] = $this->Manage_price_model->get_currier_document($country_id, '1');

        $this->load->view('frontend/orders/international/item_list.php', $data);

    }

    public function ax_delete_signature(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user = $this->ion_auth->user()->row();
        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        $data['success'] = [];
        $data['errors'] = [];

        if(empty($order_info)){

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(!$this->Order_model->delete_signature($order_id)){

            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $data['success'] = 'All data updated';
        echo json_encode($data);
        return false;
    }

    public function ax_save_order_item_list(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $data['success'] = [];
        $data['errors'] = [];
        $data['error_boolean'] = false;

        $items_names  = $this->security->xss_clean($this->input->post('names'));
        $items_counts = $this->security->xss_clean($this->input->post('counts'));
        $items_prices = $this->security->xss_clean($this->input->post('prices'));
        $signature    = trim($this->security->xss_clean($this->input->post('signature')));
        $order_id     = trim($this->security->xss_clean($this->input->post('order_id')));
        $editable     = trim($this->security->xss_clean($this->input->post('editable')));
        $order_type   = trim($this->security->xss_clean($this->input->post('order_type')));

        if(!is_array($items_names) || !is_array($items_counts) || !is_array($items_prices)){
            $data['errors'][] = 'Incorrect item list information.';
            echo json_encode($data);
            return false;
        }

        if(empty($order_type)){

            $data['errors'][] = 'Please select Personal Effects or Commercial Use.';
            echo json_encode($data);
            return false;
        }

        $items_names  = array_filter($items_names);
        $items_counts = array_filter($items_counts);
        $items_prices = array_filter($items_prices);

        foreach($items_names as $index => $single){

            if(empty($single) || empty($items_counts[$index]) || $items_counts[$index] <= 0 ||  empty($items_prices[$index]) || $items_prices[$index] <= 0){
                $data['errors'][] = 'To submit the item list, please fill in all fields. Thanks.';
                $data['error_boolean'] = true;
                echo json_encode($data);
                return false;
            }

        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);

        if(empty($order_info) || $order_info['shipping_type'] != '1'){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if(empty($items_names) || empty($items_counts) || empty($items_prices)){
            $data['errors'][] = 'To submit the item list, please fill in all fields. Thanks.';
            $data['error_boolean'] = true;
            echo json_encode($data);
            return false;
        }

        if(empty($order_info['signature']) && empty($this->check_base64_img($signature))){
            $data['errors'][] = 'Signature field is required.';
            echo json_encode($data);
            return false;
        }

        if(count($items_names) != count($items_counts) || count($items_names) != count($items_prices)){
            $data['errors'][] = 'To submit the item list, please fill in all fields. Thanks.';
            $data['error_boolean'] = true;
            echo json_encode($data);
            return false;
        }

        $batch_insert_array = [];
        $total_item_count = 0;
        $total_declared = 0;
        foreach($items_counts as $index => $count){

            $data_part['item_count'] = intval($count);

            if($data_part['item_count'] <= 0){

                $data['errors'][] = 'Count can not be 0';
                echo json_encode($data);
                return false;
            }

            $total_item_count += intval($count);
            $total_declared   += ($items_prices[$index]*intval($count));

            $data_part['item_name'] = $items_names[$index];
            $data_part['item_price']   = $items_prices[$index];
            $data_part['order_id']     = $order_id;

            $batch_insert_array[] = $data_part;

        }

        $order_info_update_data = ['order_type' => $order_type];

        $this->Order_model->update_order($order_id, $order_info_update_data);

        if(!empty($editable)){

            $this->Order_model->delete_item_list($order_id);
        }

        if(!$this->Order_model->insert_batch_item_list($batch_insert_array)){

            $data['errors'][] = 'Error filling data to Database.';
            echo json_encode($data);
            return false;

        }

        if(empty($this->check_base64_img($signature))){
            echo json_encode($data);
            return false;
        }

        if(!$this->Order_model->set_signature($order_id, $signature)){

            $data['errors'][] = 'Error filling data to Database.';
        }else{

            //   $this->send_item_list_email($order_id);
            $data['success'] = 'All data sucessfully inserted';
        }

        $delivery_inf = $this->Order_model->get_delivery_info($order_id);

        if(empty($delivery_inf['delivery_country_id'])){
            $country_info = '';

        }else{
            $country_info = $this->Users_model->get_countries($delivery_inf['delivery_country_id'], true);
        }

        $user = $this->ion_auth->user()->row();

        if($order_type == 2){

            $subject_desc = 'Hi '.$user->first_name." ".$user->last_name.' , thank you for submitting item list for your international order.  We will send you shipping labels and custom document soon. Thanks.';

        }else{

            $subject_desc = 'Hi '.$user->first_name." ".$user->last_name.', thank you for submitting item list for your international order.  We recommend our customers to provide the passport, visa and travel itinerary copies as well for custom clearance of personal effects. We will send you shipping labels and custom document soon. Thanks';
        }


        $variable_data = [
            'quantity'            => $total_item_count,
            'declared_value'      => $total_declared,
            'username'            => $user->first_name.' '.$user->last_name,
            'order_number'        => $order_info['order_id'],
            'country_to'          => $country_info['country'],
            'order_id'            => $order_info['id'],
            'subject_description' => $subject_desc
        ];

        $email_data = array(
            'email'     => $user->email,
            'to_name'   => $user->username,
            'subject'   => 'Thank you for submitting the item list for custom clearance  – ' . $user->account_name,
            'variables' => $variable_data
        );

        if($order_type == 1){

            $this->general_email->send_email('item_list_personal_effect',$email_data);

        }else{

            $this->general_email->send_email('item_list_comertial_use',$email_data);

        }

        echo json_encode($data);

    }


    public function ax_upload_order_form_file(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }



        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['success'] = [];
        $data['errors'] = [];

        $files = $this->Order_model->get_order_form_document($order_id);

        if(count($files) >= 3){

            $data['errors'][] = 'Sorry you can upload only 3 files';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH.'uploaded_documents/'.$user->id.'/orders_documents/';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url.$order_id.'/';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $config['upload_path'] = $url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
        $config['max_size']	= 4096;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $insert_data=[
            'user_id'        => $user->id,
            'order_id'       => $order_id,
            'show_file_name' => $file_info['client_name'],
            'file_name'      => $file_info['file_name'],
            'add_date'       => date('Y-m-d H:i:s')
        ];

        if(!$result = $this->Order_model->insert_order_form_document($insert_data)){

            $data['errors'][] = 'Can not insert file info';

        }else{

            $data['file_id']        = $result;
            $data['order_id']       = $order_info['id'];
            $data['show_file_name'] = $insert_data['show_file_name'];
            $data['file_name']      = $insert_data['file_name'];
            $data['success']        = 'Document uploaded successfully.';

        }


        echo json_encode($data);

    }

    public function ax_delete_order_form_file(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $file_id = trim($this->security->xss_clean($this->input->post('file_id')));

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        if(!$this->valid->is_id($file_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $file_info = $this->Order_model->get_order_form_document($order_id, $file_id);

        if(empty($file_info)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $url = FCPATH.'uploaded_documents/'.$user->id.'/orders_documents/'.$order_id.'/'.$file_info[0]['file_name'];

        if(file_exists($url)){

            if(unlink($url)){

                $remove = true;
            }else{

                $remove = false;
            }

        }else{

            $remove = true;
        }

        if($remove){

            $this->Order_model->delete_order_form_document($order_id, $file_id);
        }else{

            $data['errors'][] = 'Can not remove document';
        }

        $data['success'] = 'Document has been deleted';

        echo json_encode($data);

    }

    public function ax_order_passport_info(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        if(empty($order_id)){

            return false;
        }

        $user = $this->ion_auth->user()->row();

        $data['order_info'] =   $order_info = $this->Order_model->get_submitted_order($user->id, $order_id);
        $passport_info  = $this->Order_model->get_order_passport_info($order_id);

        $data['passport_info'] = [
            'passport_number' => '',
            'passport_country_id' => 0,
        ];

        $data['all_countries'] = [];

        if(!empty($passport_info)){

            $data['passport_info'] = $passport_info;
        }

        $all_countries = $this->Users_model->get_countries();

        if(!empty($all_countries)){
            $data['all_countries'] = $all_countries;
        }



        $this->load->view('frontend/orders/international/passport.php', $data);
    }

    public function ax_save_order_passport_info(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id        = trim($this->security->xss_clean($this->input->post('order_id')));
        $passport_number = trim($this->security->xss_clean($this->input->post('pas_number')));
        $country_id      = trim($this->security->xss_clean($this->input->post('country_id')));

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [SUBMITTED_STATUS[0],PROCESSED_STATUS[0]]);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        if($order_info['order_type'] == 2){

            $data['errors'][] = 'You cant set passport info for Commercial Use';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH.'uploaded_documents/'.$user->id;

        if(!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url.'/orders_documents';

        if(!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url.'/'.$order_id;

        if(!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url.'/';

        if(!empty($_FILES)){

            foreach ($_FILES as $input_name => $single){

                if($input_name != 'passport_file' && $input_name != 'visa_file'){
                    continue;
                }

                $config['upload_path'] = $url;
                $config['allowed_types'] = 'pdf|jpg|jpeg';
                $config['max_size']	= 10240;
                $config['file_name'] = random_string('numeric', 10);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload($input_name) == false) {

                    $data['errors'][] = $this->upload->display_errors();
                    echo json_encode($data);
                    return false;

                }

                $file_info = $this->upload->data();

                $insert_data[$input_name] = $file_info['file_name'];

            }

            // $this->send_item_list_email($order_id);

        }


        $passport_info = $this->Order_model->get_order_passport_info($order_id);

        if(empty($passport_info)){

            $insert_data['user_id']             = $user->id;
            $insert_data['order_id']            = $order_id;
            $insert_data['passport_number']     = $passport_number;
            $insert_data['passport_country_id'] = $country_id;

            if(!$this->Order_model->insert_passport_info($insert_data)){

                $data['errors'][] = 'Error filling data.';

                if(!empty($insert_data['passport_file'])){
                    unlink($url.$insert_data['passport_file']);
                }
                if(!empty($insert_data['visa_file'])){
                    unlink($url.$insert_data['visa_file']);
                }

            }else{

                $data['success'] = 'Data successfully saved.';
            }

            echo json_encode($data);
            return false;

        }

        $insert_data['passport_number']     = $passport_number;
        $insert_data['passport_country_id'] = $country_id;

        if(!$this->Order_model->update_order_passport_info($insert_data,$order_id)){

            $data['errors'][] = 'Error filling data.';

        }else{

            if(file_exists($url.$passport_info['passport_file']) && !empty($insert_data['passport_file']) && !empty($passport_info['passport_file'])){

                unlink($url.$passport_info['passport_file']);
            }

            if(file_exists($url.$passport_info['visa_file']) && !empty($insert_data['visa_file']) && !empty($passport_info['visa_file'])){

                unlink($url.$passport_info['visa_file']);
            }

            $data['success'] = 'Data successfully saved.';
        }

        echo json_encode($data);
        return false;

    }

    public function ax_delete_passport_file(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));
        $file_name  = trim($this->security->xss_clean($this->input->post('file_name')));
        $type_name  = trim($this->security->xss_clean($this->input->post('type_name')));

        if(empty($order_id) || empty($file_name)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [SUBMITTED_STATUS[0],PROCESSED_STATUS[0]]);

        if(empty($order_info)){

            $data['errors'][] = 'Invalid information';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH.'uploaded_documents/'.$user->id.'/orders_documents/'.$order_id.'/'.$file_name;

        if(file_exists($url)){

            unlink($url);
        }

        $update_data = [ $type_name => NULL ];

        if(!$this->Order_model->update_order_passport_info($update_data,$order_id)){

            $data['errors'][] = 'Error filling data.';
            echo json_encode($data);
            return false;
        }


        $data['success'] = 'Data successfully saved.';

        echo json_encode($data);

    }

    public function travel_itinerary_info(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));

        if(empty($order_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $data['order_info'] = $this->Order_model->get_submitted_order($user->id, $order_id);
        $sender_info = $this->Order_model->get_pickup_info($order_id);
        $receiver_info = $this->Order_model->get_delivery_info($order_id);

        $country_from = $this->Users_model->get_countries($sender_info['pickup_country_id'], true);
        $country_to = $this->Users_model->get_countries($receiver_info['delivery_country_id'], true);

        $data['country_from'] = [];
        $data['country_to'] = [];


        if(!empty($country_from)){

            $data['country_from'] = $country_from['country'];

        }

        if(!empty($country_to)){

            $data['country_to'] = $country_to['country'];

        }

        $user = $this->ion_auth->user()->row();

        $travel_info = $this->Order_model->get_travel($order_id,$user->id);

        $data['travel_info'] = [
            'arriving_by'           => '',
            'arrival_city'          => '',
            'arrival_date'          => '',
            'arrival_ticked_number' => '',
            'arrival_cruise_name'   => '',
            'leaving_by'            => '',
            'departure_city'        => '',
            'departure_date'        => '',
            'ticked_number'         => '',
            'departure_cruise_name' => '',
        ];

        if(!empty($travel_info)){

            $data['travel_info'] = $travel_info;
        }

        $travel_info_file = $this->Order_model->get_travel_files($order_id,$user->id);

        $data['travel_info_file'] = [];

        if(!empty($travel_info_file)){

            $data['travel_info_file'] = $travel_info_file;
        }

        $this->load->view('frontend/orders/international/travel.php', $data);

    }

    public function ax_save_travel_itinerary(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $arriving_by           = intval($this->security->xss_clean($this->input->post('arriving_by')));
        $arrival_city          = trim($this->security->xss_clean($this->input->post('arrival_city')));
        $arrival_date          = trim($this->security->xss_clean($this->input->post('arrival_date')));
        $arrival_ticked_number = trim($this->security->xss_clean($this->input->post('arrival_ticked_number')));
        $arrival_cruise_name   = trim($this->security->xss_clean($this->input->post('arrival_cruise_name')));
        $leaving_by            = intval($this->security->xss_clean($this->input->post('leaving_by')));
        $departure_city        = trim($this->security->xss_clean($this->input->post('departure_city')));
        $departure_date        = trim($this->security->xss_clean($this->input->post('departure_date')));
        $ticked_number         = trim($this->security->xss_clean($this->input->post('ticked_number')));
        $departure_cruise_name = trim($this->security->xss_clean($this->input->post('departure_cruise_name')));
        $order_id              = trim($this->security->xss_clean($this->input->post('order_id')));

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [SUBMITTED_STATUS[0],PROCESSED_STATUS[0]]);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        if($order_info['order_type'] == 2){

            $data['errors'][] = 'You cant set travel itinerary for Commercial Use';
            echo json_encode($data);
            return false;
        }


        if($leaving_by > 3 || $leaving_by < 0 || $arriving_by > 3 || $arriving_by < 0){

            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $insert_array = [
            'user_id'               => $user->id,
            'order_id'              => $order_id,
            'arriving_by'           => $arriving_by,
            'arrival_city'          => $arrival_city,
            'arrival_date'          => $arrival_date,
            'arrival_ticked_number' => $arrival_ticked_number,
            'arrival_cruise_name'   => $arrival_cruise_name,
            'leaving_by'            => $leaving_by,
            'departure_city'        => $departure_city,
            'departure_date'        => $departure_date,
            'ticked_number'         => $ticked_number,
            'departure_cruise_name' => $departure_cruise_name
        ];

        $trav_info = $this->Order_model->get_travel($order_id,$user->id);

        if(empty($trav_info)){

            if(!$this->Order_model->insert_trav_info($insert_array)){
                $data['errors'][] = 'Error filling data to database';
                echo json_encode($data);
                return false;
            }

        }else{

            unset($insert_array['order_id']);
            unset($insert_array['user_id']);

            if(!$this->Order_model->update_trav_info($insert_array, $order_id)){
                $data['errors'][] = 'Error update data';
                echo json_encode($data);
                return false;
            }

        }

        if(!empty($_FILES)){

            $files = $this->Order_model->get_travel_files($order_id);

            if(count($files) >= 3){

                $data['errors'][] = 'Sorry you can upload only 3 files';
                echo json_encode($data);
                return false;
            }

            $url = FCPATH . 'uploaded_documents/' . $user->id;

            if (!is_dir($url)) {
                mkdir($url, 0775, TRUE);
            }

            $url = $url.'/orders_documents';

            if (!is_dir($url)) {
                mkdir($url, 0775, TRUE);
            }

            $url = $url .'/'. $order_id . '/';

            if (!is_dir($url)) {
                mkdir($url, 0775, TRUE);
            }

            $config['upload_path'] = $url;
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
            $config['max_size'] = 4096;
            $config['file_name'] = random_string('numeric', 10);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('doc') == false) {

                $data['errors'][] = $this->upload->display_errors();
                echo json_encode($data);
                return false;

            }

            $file_info = $this->upload->data();

            $insert_file_info = [
                'user_id' => $user->id,
                'order_id' => $order_id,
                'client_name' => $file_info['client_name'],
                'file_name' => $file_info['file_name']
            ];

            if(!$this->Order_model->insert_itinerary_files($insert_file_info)){

                $data['errors'][] = 'Error filling data to database';
                echo json_encode($data);
                return false;
            }

        }// end file upload


        $data['success'] = 'Data successfully saved';
        // $this->send_item_list_email($order_id);
        echo json_encode($data);

    }

    public function ax_delete_itineary_files(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $file_id = trim($this->security->xss_clean($this->input->post('file_id')));

        if(!$this->valid->is_id($order_id)){

            show_404();
            return false;
        }

        if(!$this->valid->is_id($file_id)){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id, [SUBMITTED_STATUS[0],PROCESSED_STATUS[0]]);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $file_info = $this->Order_model->get_travel_files($order_id, NULL, $file_id);

        if(empty($file_info)){

            $data['errors'][] = 'Undefined file.';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH.'uploaded_documents/'.$user->id.'/orders_documents/'.$order_id.'/'.$file_info[0]['file_name'];

        if(file_exists($url)){

            if(unlink($url)){
                $remove = true;
            }else{
                $remove = false;
            }
        }else{

            $remove = true;
        }

        if($remove){

            $this->Order_model->delete_itinerary_document($order_id, $file_id);
        }else{

            $data['errors'][] = 'Can not remove document';
        }

        $data['success'] = 'Document has been deleted';

        echo json_encode($data);

    }

    public function ax_get_trucking_history(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $trucking_info = trim($this->security->xss_clean($this->input->post('truck_inf')));

        $info_array = explode('_', $trucking_info);

        if(count($info_array) != 3){
            show_404();
            return false;
        }

        $order_id        = $info_array[0];
        $luggaeg_id      = $info_array[1];
        $trucking_number = $info_array[2];

        $user = $this->ion_auth->user()->row();

        $order_info = $this->Order_model->get_order_info($order_id, $user->id);

        if(empty($order_info)){
            show_404();
            return false;
        }

        $luggage_info = $this->Order_model->get_one_luggage_order($order_id, $luggaeg_id);

        if(empty($luggage_info)){
            show_404();
            return false;
        }

        if($luggage_info['tracking_number'] != $trucking_number){
            show_404();
            return false;
        }

        $this->load->library('Shippo_lib');

        $carrier_name = $this->shippo_lib->get_carrier_name_for_shipo($order_info['currier_name']);

        $data = [
            'errors' => [],
            'info'   => []
        ];

        if(empty($carrier_name)){

            $data['errors'][] = 'No data.';
            $this->load->view('frontend/orders/trucking_history_template.php', $data);
            return false;
        }

        if(!is_array($carrier_name)){

            $result = $this->shippo_lib->get_trucking_status($trucking_number, $carrier_name);

        }else{

            foreach($carrier_name as $single_name){

                $result = $this->shippo_lib->get_trucking_status($trucking_number, $single_name);

                if(!empty($result['status'])){
                    break;
                }

            }
        }

        if(empty($result['data']['trucking_history'])){

            $data['errors'][] = 'No data.';

        }else{

            $data['info'] = $result;
        }


        $this->load->view('frontend/orders/trucking_history_template.php', $data);

    }

    public function user_file($file_name,$order_id){

        $this->_check_login();

        if(empty(trim($order_id)) || empty(trim($file_name))){

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $file_path = FCPATH.'uploaded_documents/'.$user->id.'/orders_documents/'.$order_id.'/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /*header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);*/
        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        exit;

    }

    public function _create_shipment($order_id, $user_id){

        if(!$this->ion_auth->logged_in()) {
            echo show_404();
            return false;
        }

        $responce = [
            'status' => 'OK',
            'errors' => [],
            'data'   => []
        ];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if($order_info['shipping_type'] == '1'){
            return $responce;
        }

        $this->load->library('Google_api');

        $sender_info           = $this->Order_model->get_pickup_info($order_id);
        $receiver_info         = $this->Order_model->get_delivery_info($order_id);
        $sender_country_info   = $this->Users_model->get_countries($sender_info['pickup_country_id'], true);
        $receiver_country_info = $this->Users_model->get_countries($receiver_info['delivery_country_id'], true);
        $order_items           = $this->Order_model->get_luggage_order($order_id);
        $sender_state_info     = $this->Order_model->get_states_by_id($sender_info['pickup_state']);
        $receiver_state_info   = $this->Order_model->get_states_by_id($receiver_info['delivery_state']);
        $orde_ins              = $this->Order_model->get_incurance($order_id);

        $type = $this->_get_order_send_type($order_info['send_type'], $order_info['currier_name']);

        if(empty($sender_state_info)){

            $google_info = $this->google_api->search_place($sender_info['pickup_state']);

            if(!empty($google_info)){
                $sender_state_info = $google_info['address_components'][1]['short_name'];
            }

        }else{

            $sender_state_info = $sender_state_info['s_code'];
        }

        if(empty($receiver_state_info)){

            $google_info = $this->google_api->search_place($receiver_info['delivery_state']);

            if(!empty($google_info)){
                $receiver_state_info = $google_info['address_components'][1]['short_name'];
            }

        }else{
            $receiver_state_info = $receiver_state_info['s_code'];
        }

        $this->load->library('Shippo_lib');

        $order_extra = [];

        $shipper = [
            'name'    => $sender_info['sender_first_name'].' '.$sender_info['sender_last_name'],
            'phone'   => $sender_info['sender_phone'],
            'street1' => $sender_info['pickup_address1'],
            'city'    => $sender_info['pickup_city'],
            'state'   => $sender_state_info,
            'zip'     => $sender_info['pickup_postal_code'],
            'country' => $sender_country_info['iso2'],
            'street2' => $sender_info['pickup_address2'],
            'email'   => $sender_info['sender_email'],
            'company' => $sender_info['pickup_company']
        ];

        $receiver = [
            'name'    => $receiver_info['receiver_first_name'].' '.$receiver_info['receiver_last_name'],
            'phone'   => $receiver_info['receiver_phone'],
            'street1' => $receiver_info['delivery_address1'],
            'city'    => $receiver_info['delivery_city'],
            'state'   => $receiver_state_info,
            'zip'     => $receiver_info['delivery_postal_code'],
            'country' => $receiver_country_info['iso2'],
            'street2' => $receiver_info['delivery_address2'],
            'email'   => $receiver_info['receiver_email'],
            'company' => $receiver_info['delivery_company']
        ];

        $order_extra['reference_1'] = 'LTS '.$order_info['order_id'];

        if(stripos($order_info['send_type'], '+sat') !== FALSE){
            $order_extra['saturday_delivery'] = true;
        }

        $order_extra['signature_confirmation'] = 'STANDARD';
        //$order_extra['authority_to_leave'] = true;

        if (!empty($receiver_info['without_signature'])){
            unset($order_extra['signature_confirmation']);
        }

        foreach($order_items as $single){

            $data = array(
                'weight'        => $single['label_weight'],
                'length'        => $single['label_length'],
                'width'         => $single['label_width'],
                'height'        => $single['label_height'],
                'distance_unit' => 'in',
                'mass_unit'     => 'lb',
                'metadata'      => $single['id']
            );

            if(!empty($ins = $this->Order_model->get_luggage_insurance($single['id']))){

                if (empty($receiver_info['without_signature']) && $ins < 500){
                    $ins = 500;
                }

                $data['extra'] = [
                    'insurance' => array(
                        'amount' => $ins,
                        'currency' => 'USD',
                        'provider' => 'FEDEX'
                    )
                ];

            }

            $items[] = $data;
        }

        if(!empty($orde_ins)){
            $order_extra['COD'] = [
                'payment_method' => 'SECURED_FUNDS',
                'currency'       => 'USD'
            ];
        }else{
            $order_extra['COD'] = [
                'payment_method' => 'ANY',
                'currency'       => 'USD'
            ];
        }

        $check_from = $this->shippo_lib->validate_address($shipper);
        $check_to   = $this->shippo_lib->validate_address($receiver);

        if($check_from['status'] != 'OK'){

            return $check_from;
        }

        if($check_to['status'] != 'OK'){

            return $check_to;
        }


        $this->shippo_lib->set_order_extra($order_extra);
        $create_check = $this->shippo_lib->set_address($shipper, $receiver);
        $items_check = $this->shippo_lib->set_percels($items);

        if($create_check['status'] != 'OK'){

            return $create_check;
        }

        if($items_check['status'] != 'OK'){

            return $items_check;
        }

        $response = $this->shippo_lib->create_shipment($order_info['currier_shippo_id'], $type, $sender_info['shipping_date']);

        if($response['status'] != 'OK'){
            return $response;
        }

        $this->load->library('Label_lib');

        $web_hook_reg = true;

        foreach($response['data']['transactions'] as $single){

            $w_img = FCPATH.'assets/images/label_logo.png';
            $label_img = $single['label_url'];

            $img_info = $this->label_lib->get_label_img($order_id, $single['tracking_number'], $label_img);

            if(empty($img_info)){
                continue;
            }

            $label_img = $img_info['name'];

            //$this->label_lib->set_watermark($img_info['patch'], $w_img, $order_info['currier_name']);

            $this->load->library('image_lib');

            $config['source_image'] = $img_info['patch'];
            $config['rotation_angle'] = '90';

            $this->image_lib->initialize($config);

            $this->image_lib->rotate();

            $update_data = [
                'tracking_number' => $single['tracking_number'],
                'truck_id'        => $single['object_id'],
                'track_url'       => $single['tracking_url']
            ];

            if(!empty($label_img)){

                $file_data = [
                    'order_id'   => $order_id,
                    'file_type'  => 'label',
                    'file_name'  => $label_img,
                    'luggage_id' => $single['id']
                ];

                $this->Order_model->insert_order_file($file_data);

            }

            $this->Order_model->set_trucking_info($single['id'], $update_data);


            if(!$this->shippo_lib->register_webhook($order_info['currier_name'],$single['tracking_number'])){

                $web_hook_reg = false;
            }

        }

        $this->Order_model->update_order($order_id, ['webhook_reg' => $web_hook_reg]);

        return $response;

    }

    public function _get_order_send_type($type, $currier){

        $currier = strtolower($currier);
        $type    = strtolower($type);
        $day     = preg_replace('/[^0-9]+/', '', $type);

        if(stripos($type, 'basic') !== FALSE){

            $send = 'basic';
        }else{

            $send = 'express';
        }

        if(stripos($type, 'morning') !== FALSE){

            $dname = 'morning';
        }else{

            $dname = 'afternoon';
        }

        if(stripos($type, '+sat') !== FALSE){

            $dname = 'afternoon';
        }

        if(stripos($currier, 'fedex') !== FALSE){

            $currier = 'fedex';

        }elseif(stripos($currier, 'ups') !== FALSE){

            $currier = 'ups';
        }

        $return_data = [
            'fedex' => [
                'express' => [
                    '1' => [
                        'morning'   => 'fedex_priority_overnight',
                        'afternoon' => 'fedex_standard_overnight'
                    ],
                    '2' => [
                        'morning'   => 'fedex_2_day_am',
                        'afternoon' => 'fedex_2_day'
                    ],
                    '3' => [
                        'morning'   => 'no',
                        'afternoon' => 'fedex_express_saver'
                    ],
                ],
                'default' => 'fedex_ground'
            ],
            'ups' => [
                'express' => [
                    '1' => [
                        'morning'   => 'ups_next_day_air',
                        'afternoon' => 'ups_next_day_air_saver'
                    ],
                    '2' => [
                        'morning'   => 'ups_second_day_air_am',
                        'afternoon' => 'ups_second_day_air'
                    ],
                    '3' => [
                        'morning'   => 'no',
                        'afternoon' => 'ups_3_day_select'
                    ],
                ],
                'default' => 'ups_ground'
            ],

        ];


        if(!empty($return_data[$currier][$send][$day][$dname])){

            return $return_data[$currier][$send][$day][$dname];
        }

        if(empty($return_data[$currier]['default'])){
            return NULL;
        }

        return $return_data[$currier]['default'];

    }

    public function _check_pick_up($currier, $type, $date, $shipping_type, $country){

        $currier = strtolower($currier);
        $type    = strtolower($type);

        $holidays   = $this->Check_price_model->get_holidays([$country]);
        $d_holidays = $this->Check_price_model->get_dinamic_holidays([$country]);
        $week_day   = date('l', strtotime($date));
        $basic      = (stripos($type, 'basic') !== FALSE)?true:false;
        $is_holiday = false;

        if((!empty($holidays) && in_array($date, $holidays)) || (!empty($d_holidays) && in_array(substr($date,-5,5), $d_holidays))){
            $is_holiday = true;
        }

        if($currier == 'fedex' && $shipping_type == '2' && $basic == true && ($date == date('Y-m-d') || $week_day == 'Sunday' || $week_day == 'Saturday' || $is_holiday == true)){

            return 0;
        }

        if(($currier == 'fedex' || $currier == 'ups') && $basic == false && ($week_day == 'Sunday' || $is_holiday == true)){

            return 0;
        }

        if($currier == 'dhl' && $basic == false && $shipping_type == '1' && ($week_day == 'Sunday' || $week_day == 'Saturday' || $is_holiday == true)){

            return 0;
        }

        return 1;

    }

    private function check_base64_img($base64_temp){

        $base64 = explode(',',$base64_temp);

        if(empty($base64[1])){
            return false;
        }

        $base64 = $base64[1];

        $img_data = base64_decode($base64, true);

        if(empty($img_data)){
            return false;
        }

        if(strlen($img_data) < 1226){
            return false;
        }

        return true;

    }

    public function label_file($order_id, $file_name = NULL){

        if(!$this->valid->is_id($order_id) || empty(trim($file_name))){

            show_404();
            return false;
        }

        $this->_check_login();

        $file_path = FCPATH.'uploaded_documents/orders_files/'.$order_id.'/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /* header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename='.basename($file_path));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
         header('Pragma: public');
         header('Content-Length: ' . filesize($file_path));*/

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        /* ob_clean();
         flush();
         readfile($file_path);*/
        exit;

    }

    public function currier_file($iso, $file_name = NULL){

        $this->_check_login();

        if(empty(trim($file_name)) || empty(trim($file_name))){

            show_404();
            return false;
        }

        $file_path = FCPATH.'uploaded_documents/manage_price/'.$iso.'/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /* header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename='.basename($file_path));
         header('Content-Transfer-Encoding: binary');
         header('Expires: 0');
         header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
         header('Pragma: public');
         header('Content-Length: ' . filesize($file_path));

         ob_clean();
         flush();
         readfile($file_path);*/
        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        exit;

    }

    public function get_labels($order_id = NULL){

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $labels = $this->_label_info($order_id);

        if(empty($labels)){

            show_404();
            return false;
        }

        $data['sender_info']   = $this->Order_model->get_pickup_info($order_id);
        $data['delivery_info'] = $this->Order_model->get_delivery_info($order_id);
        $data['sender_state'] = '';
        $data['delivery_state'] = '';

        if(empty($data['sender_info']) || empty($data['delivery_info'])){

            show_404();
            return false;
        }


        $data['label_info'] = $labels;
        $data['order_info'] = $order_info;

        $sender_state = $this->Order_model->get_states_by_id($data['sender_info']['pickup_state']);

        if(!empty($sender_state['State'])){
            $data['sender_state'] = $sender_state['State'];
        }

        $delivery_state = $this->Order_model->get_states_by_id($data['delivery_info']['delivery_state']);

        if(!empty($delivery_state['State'])){
            $data['delivery_state'] = $delivery_state['State'];
        }

        $this->load->view('frontend/orders/order_label_info',$data);

    }

    public function _label_info($order_id){

        if(empty($order_id) ){

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $luggage_info = $this->Order_model->get_luggage_and_label($order_id);

        foreach ($luggage_info as $index => $luggages){

            if(empty($luggages['file_name'])){

                unset($luggage_info[$index]);
            }
        }

        if(empty($luggage_info)){

            return false;
        }

        return $luggage_info;
    }

    public function check_admin_freeze($order_info_or_id, $type = NULL){

        $this->load->library('Admin_security');

        if(!is_array($order_info_or_id)){
            $order_info_or_id = $this->Order_model->get_order_info($order_info_or_id);
        }

        if(!empty($order_info_or_id['freeze_by_admin']) && !empty($order_info_or_id['freeze_date_time'])){

            $freeze      = $order_info_or_id['freeze_by_admin'];
            $freeze_time = $order_info_or_id['freeze_date_time'];
        }

        if(empty($freeze) || empty($freeze_time)){
            return false;
        }

        $now = date('Y-m-d H:i:s');

        $freeze_limit = date('Y-m-d H:i:s', strtotime($freeze_time.' +'.FREEZE_INTERVAL.' minutes'));

        if($now >= $freeze_limit){
            return false;
        };

        if($type === true){
            return true;
        }

        if($this->ion_auth->logged_in() && $this->admin_security->is_admin()){
            return false;
        }

        $now = date_create($now);
        $freeze_limit = date_create($freeze_limit);

        $interval = date_diff($now, $freeze_limit, true);

        $data['minutes'] = $interval->i;

        if($data['minutes'] == 0){
            $data['minutes'] = $interval->s.' seconds.';
        }else{
            $data['minutes'] =  $data['minutes'].'  minutes.';
        }

        $user = $this->ion_auth->user()->row();

        $data['content']             = 'frontend/orders/freeze_template';
        $data['navigation_buffer']   = 'frontend/dashboard_navigation';
        $data['info']['user_name']   = '';
        $data['info']['account_num'] = '';

        if(!empty($user->first_name) && !empty($user->account_name)) {
            $data['info']['user_name'] = $user->first_name;
            $data['info']['account_num'] = $user->account_name;
        }

        echo $this->load->view('frontend/site_main_template', $data, true);

        exit;

    }

    public function ax_admin_save_adjust(){

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $user = $this->ion_auth->user()->row();

        $freeze = $this->check_admin_freeze($order_id, true);

        if(empty($freeze)){
            show_404();
            exit;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $charge_info = $this->price_lib->get_order_fee($order_id, $user->id);

        if(empty($charge_info)){
            $data['errors'][] = 'Incorrect fee information.';
            echo json_encode($data);
            return false;
        }

        $billing_array = [
            'pickup_fee'     => $charge_info['pick_up'],
            'insurance_fee'  => $charge_info['insurance'],
            'account_credit' => $charge_info['account_credit'],
            'status'         => '1'
        ];

        $next_billing = $this->Billing_model->check_last_billing($order_id);

        if($next_billing['next'] == 'estimate'){
            $next_billing['next'] = 'initial';
        }

        $crt = [
            'type'     => $next_billing['next'],
            'order_id' => $order_id
        ];

        $billing_isset = $this->Billing_model->get_billing($crt);

        if(empty($billing_isset)){

            $billing_array['order_id'] = $order_id;
            $billing_array['user_id']  = $order_info['user_id'];
            $billing_array['type']     = $next_billing['next'];

            $this->Billing_model->auto_fill_insert($billing_array);

        }else{

            $this->Billing_model->update_billing_info($billing_array, $order_id, $next_billing['next']);
        }

        if($order_info['update_order'] == 1){

            $this->config->load('general_email');
            $subject = 'Thank you for updating order ' . $order_info['order_id'];
            $subject_description = 'Hi ' . $user->first_name . " " . $user->last_name. ', your order ' . $order_info['order_id'] . ' has been updated successfully. We are preparing shipping labels and will send it to you soon.  Thanks.';
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description);
            $this->_send_label_charge_email($order_id, $user->id, 'admin_edit_items_services', $subject, $subject_description,$this->config->item('server_email'));

            $this->Order_model->update_order($order_id, ['update_order' => 0]);
        }

        $data['success'] = 'All changes successfully saved';

        echo json_encode($data);

    }

    public function _send_label_charge_email($order_id,$user_id,$view,$subject,$subject_description = NULL,$email = NULL){

        if(empty($order_id) || empty($user_id) || empty($view) || empty($subject)){

            return false;
        }

        $crt = [
            'order_shipping.id' => $order_id
        ];

        $user = $this->ion_auth->user()->row();

        $send_data = $this->Order_model->get_orders($crt, $limit = NULL, $order_by = 'order_shipping.id', $order_type = 'DESC',$row = true);

        if(empty($send_data['card_id'])){
            $send_data['card_inf'] = '';

        }else{
            $card_info = $this->Order_model->get_credit_card_by_id($user_id,NULL,$send_data['card_id']);
            $send_data['card_inf'] = substr($card_info['card_number'],-4,4);
        }
        $incurance_fee = floatval($this->Order_model->get_insurance_fee($order_id));
        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $send_data['luggage_info'] = $order_luggages;
        $send_data['incurance_fee'] = $incurance_fee;
        $send_data['price'] = $this->price_lib->get_order_fee($order_id, $user_id);
        $labels = $this->Order_model->get_order_files($send_data['real_id'],'label');
        $send_data['labels'] = $labels;
        $send_data['country_from'] = '';
        $send_data['country_to'] = '';
        $send_data['state_name_delivery'] = '';
        $send_data['state_name_sender'] = '';
        $country_1 = $this->Users_model->get_countries($send_data['pickup_country_id'],true);
        $country_2   = $this->Users_model->get_countries($send_data['delivery_country_id'],true);
        $send_data['declared_value'] = $this->Order_model->get_sum_item_list($send_data['real_id']);
        $send_data['quantity']       = $this->Order_model->get_item_list_count($send_data['real_id']);
        $send_data['subject_description']       = $subject_description;
        $user_info = $this->Users_model->get_user_info($user_id);

        if(empty($user_info)){
            return false;
        }

        $send_data['first_name'] = $user_info['first_name'];
        $send_data['last_name'] = $user_info['last_name'];

        if(!empty($country_1['country'])){
            $send_data['country_from'] = $country_1['country'];

            if($country_1['id'] == '226'){
                $send_data['country_from'] = str_replace('(USA)','',$send_data['country_from']);
            }
        }

        if(!empty($country_2['country'])){
            $send_data['country_to'] = $country_2['country'];

            if($country_2['id'] == '226'){
                $send_data['country_to'] = str_replace('(USA)','',$send_data['country_to']);
            }
        }

        $delivery_state = $this->Order_model->get_states_by_id($send_data['delivery_state']);

        if(!empty($delivery_state['State'])){
            $send_data['state_name_delivery'] = $delivery_state['State'];
        }

        $sender_state = $this->Order_model->get_states_by_id($send_data['pickup_state']);

        if(!empty($sender_state['State'])){
            $send_data['state_name_sender'] = $sender_state['State'];
        }

        if(!empty($email)){
            $send_email = $email;
        }else{
            $send_email = $user->email;
        }

        $email_data = array(
            'email'     => $send_email,
            'to_name'   => $user->username,
            'subject'   => $subject,
            'variables' => $send_data
        );

        $this->general_email->send_email($view,$email_data);

    }


    private function ax_create_label_pdf($order_id = NULL){

        $this->load->library('Pdf_lib');

        if(empty($order_id)) {

            if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

                show_404();
                return false;
            }

            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        }

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            $data['errors'][] = 'Undefined order information.';
            return $data;
        }

        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $old_file       = $this->Order_model->get_order_files($order_id, 'label');

        if(empty($order_luggages)){
            $data['errors'][] = 'Undefined luggage information.';
            return $data;
        }

        if(count($order_luggages) != count($old_file)){
            $data['errors'][] = 'Please upload and submit all labels.';
            return $data;
        }

        $save_dir = FCPATH.'/labels';
        $file_name = $order_info['order_id'].'_label.pdf';
        $url = base_url('admin/order/label_print/'.$order_id);

        if(!is_dir($url)){
            mkdir($url, 0775);
        }

        $this->ax_delete_label_pdf($order_id, true);

        $result = $this->pdf_lib->html_to_pdf($url, $save_dir, $file_name);

        if(!$result){
            $data['errors'][] = 'Can not create invoice.';
            return $data;
        }

        if(!$this->Order_model->update_order($order_id, ['labels_pdf' => $file_name])){
            $data['errors'][] = 'Can not fill data to Database.';
        }

        return true;

    }

    public function ax_delete_label_pdf($order_id = NULL, $return = false){

        // $this->check_admin_login();

        $this->load->library('Pdf_lib');

        if(empty($order_id)) {

            if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
                show_404();
                return false;
            }

            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        }

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            if(!$return){
                $data['errors'][] = 'Undefined order information.';
                echo json_encode($data);
            }

            return false;
        }

        if(empty($order_info['labels_pdf'])){

            if(!$return) {
                $data['errors'][] = 'Undefined pdf file.';
                echo json_encode($data);
            }

            return false;
        }

        $save_dir = FCPATH.'/labels/'.$order_info['labels_pdf'];

        if(is_file($save_dir)){
            unlink($save_dir);
        }

        if(!$this->Order_model->update_order($order_id, ['labels_pdf' => ''])){

            if(!$return) {
                $data['errors'][] = 'Can not fill data to Database.';
                echo json_encode($data);
            }
            return false;

        }

        if(!$return) {
            echo json_encode($data);
        }else{
            return true;
        }

    }

    public function ax_fill_fields(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {
            return false;
        }

        $state_id    = trim($this->security->xss_clean($this->input->post('state')));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $city     = trim($this->security->xss_clean($this->input->post('city')));
        $address = trim($this->security->xss_clean($this->input->post('address')));
        $zip_code = trim($this->security->xss_clean($this->input->post('zip_code')));

        $data = [
            'errors' => [],
            'success' => []
        ];

        $order_info = $this->Order_model->get_order_info($order_id);
        $sender_info = $this->Order_model->get_pickup_info($order_id);

        if(empty($order_info)){

            $data['errors'][] = 'Undefined order information.';
            echo json_encode($data);
            return false;
        }

        if($order_info['shipping_status'] > SUBMITTED_STATUS[0]){

            $data['errors'][] = 'Cant update info';
            echo json_encode($data);
            return false;
        }

        $data['state_id'] = '';

        $state = $this->Order_model->get_states_by_name($state_id,$sender_info['pickup_country_id']);

        if(empty($state)){

            $state = $this->Order_model->get_states_by_short_name($state_id,$sender_info['pickup_country_id']);
        }

        $data['info'] = [];

        $update_data = [
            'pickup_address1'    => $address,
            'pickup_postal_code' => $zip_code,
            'pickup_city'        => $city,
            'pickup_state'       => $state['Stateid'],
            'pick_up'            =>'1'
        ];

        if(empty($state)){

            unset($update_data['pickup_state']);
        }

        if(!$this->Order_model->update_pickup_info($update_data, $order_id)){
            $data['errors'][] = 'Can`t fill data to db.';
        }else{

            $data['info'] = $update_data;
            $data['success'][] = 'Data successfully saved.';
        }


        echo json_encode($data);
    }


    public function convert_pdf($order_id){

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $file_path = FCPATH.'labels/'.$order_info['labels_pdf'];

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /*header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);*/

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);

    }

    public function check_order_status($order_id = NULL){

        if(empty($order_id)){
            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            show_404();
            return false;
        }

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('user/login', 'refresh');

        } else if($order_info['shipping_status']>SUBMITTED_STATUS[0]){

            redirect('dashboard/view_order/'.$order_id, 'refresh');

        }else{

            redirect('order/order_processing/'.$order_id, 'refresh');
        }
    }

    private function save_credit_card_error($order_id, $message, $card_num = ''){

        $this->load->model('Order_model');

        if(empty($order_id)) {
            return false;
        }

        if(is_array($message)){
            $message = implode(",", $message);
        }

        $insert_data = [
            'order_id' => $order_id,
            'admin_name' => 'Stripe',
            'add_date' => date('Y-m-d H:i:s'),
            'message' => 'Card number:'.$card_num.' - '.$message
        ];

        if(!$this->Order_model->insert_finicial_notes($insert_data)){
            return false;
        }

        return true;

    }

    private function validate_order_address($order_id){

        $this->load->library('Shippo_lib');

        $return_result = [
            'status' => 'OK',
            'message' => [],
        ];

        $sender_address = $this->Order_model->get_pickup_info($order_id);
        $receiver_address = $this->Order_model->get_delivery_info($order_id);

        if(empty($sender_address) || empty($sender_address['pickup_address1'])){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Sender address can not be empty.';
            return $return_result;

        }

        if(empty($receiver_address) || empty($receiver_address['delivery_address1'])){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Receiver address can not be empty.';
            return $return_result;

        }

        //Get Countries info
        $pic_country = $this->Users_model->get_countries($sender_address['pickup_country_id'], true);
        $del_country = $this->Users_model->get_countries($receiver_address['delivery_country_id'], true);

        if(empty($pic_country)){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Sender country can not be empty.';
            return $return_result;

        }

        if(empty($del_country)){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Receiver country can not be empty.';
            return $return_result;
        }

        // Get States info
        $pic_state = $this->Order_model->get_states_by_id($sender_address['pickup_state']);
        $del_state = $this->Order_model->get_states_by_id($receiver_address['delivery_state']);

        if(empty($pic_state)){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Sender state can not be empty.';
            return $return_result;
        }

        if(empty($del_state)){

            $return_result['status'] = 'ERROR';
            $return_result['message'][] = 'Receiver state can not be empty.';
            return $return_result;
        }

        $pic_addr_for_validate = [
            "name"    => $sender_address['sender_first_name'].' '.$sender_address['sender_last_name'],
            "company" => $sender_address['pickup_company'],
            "street1" => $sender_address['pickup_address1'],
            "street2" => $sender_address['pickup_address2'],
            "city"    => $sender_address['pickup_city'],
            "state"   => $pic_state['s_code'],
            "zip"     => $sender_address['pickup_postal_code'],
            "country" => $pic_country['iso2'],
            "email"   => $sender_address['sender_email'],
            "phone"   => $sender_address['sender_phone']
        ];

        $del_addr_for_validate = [
            "name"    => $receiver_address['receiver_first_name'].' '.$receiver_address['receiver_last_name'],
            "company" => $receiver_address['delivery_company'],
            "street1" => $receiver_address['delivery_address1'],
            "street2" => $receiver_address['delivery_address2'],
            "city"    => $receiver_address['delivery_city'],
            "state"   => $del_state['s_code'],
            "zip"     => $receiver_address['delivery_postal_code'],
            "country" => $del_country['iso2'],
            "email"   => $receiver_address['receiver_email'],
            "phone"   => $receiver_address['receiver_phone']
        ];

        if(strtolower($pic_addr_for_validate['country']) == 'us'){

            $sender = $this->shippo_lib->validate_address($pic_addr_for_validate);
            $sender = $sender['data'];

            if(empty($sender['validation_results'])){

                $return_result['status'] = 'ERROR';
                $return_result['message'][] = 'Can not connect to Shippo.';
            }

            if(empty($sender['validation_results']['is_valid'])){

                $return_result['status'] = 'ERROR';
                $return_result['message'][] = 'Sender address is not valid.';
            }

        }

        if(strtolower($del_addr_for_validate['country']) == 'us'){

            $receiver = $this->shippo_lib->validate_address($del_addr_for_validate);
            $receiver = $receiver['data'];

            if(empty($receiver['validation_results'])){

                $return_result['status'] = 'ERROR';
                $return_result['message'][] = 'Can not connect to Shippo.';
            }

            if(empty($receiver['validation_results']['is_valid'])){

                $return_result['status'] = 'ERROR';
                $return_result['message'][] = 'Receiver address is not valid.';
            }

        }

        return $return_result;

    }

    public function _check_login($show_404 = false){

        if (!$this->ion_auth->logged_in() && !$show_404) {
            // redirect them to the login page
            show_404();
            return false;

        }else if(!$this->ion_auth->logged_in()){
            redirect('user/login', 'refresh');
            return false;
        }
    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }

    }

}

?>