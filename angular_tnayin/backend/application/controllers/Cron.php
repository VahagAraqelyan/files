<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Cron extends CI_Controller
{

    private $order_date_checking = 'ltsgve724fbe4a2b3417e9c2ba60ba863dc23afbd183b';
    private $send_email_checking = 'as456das54f5ss4email456sad4546e8r555as5';

    private $trucking_config     = [
        'arg'      => 'ltsgvhaksajdstsa84a9wqeqka665asd465asd984as1d2',
        'limit'    => '100',
    ];

    public function __construct(){

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Check_price_model");
        $this->load->model("Manage_price_model");
        $this->load->model("Order_model");
        $this->load->model("Billing_model");
        $this->load->library('General_email');

    }

    public function order_date_checking($arg = NULL){

        if($arg != $this->order_date_checking){
            show_404();
            exit;
        }

        $orders = $this->Order_model->get_all_orders_info([INCOMPLETE_STATUS[0]]);

        if(empty($orders)){
            return false;
        }

        $closed = 0;
        $errors = [];

        foreach($orders as $single){

            if(date('Y-m-d', strtotime($single['shipping_date']. ' + 3 days')) < date('Y-m-d')){

                $this->Order_model->update_payment_history(['button_isset' => '0'], ['order_id' => $single['id'], 'button_isset' => '1']);

                $this->Billing_model->global_update_billing_info(array('status' => '0'), array('order_id' => $single['id']));

                $billing_array = [
                    'shipping_fee'       => '0',
                    'pickup_fee'         => '0',
                    'process_fee'        => '0',
                    'insurance_fee'      => '0',
                    'special_handling'   => '0',
                    'oversize_fee'       => '0',
                    'remote_area_fee'    => '0',
                    'promotion_code'     => '0',
                    'promotion_type'     => '0',
                    'admin_discount'     => '0',
                    'account_credit'     => '0',
                    'cancel_fee'         => '0',
                    'address_change_fee' => '0',
                    'shipment_holding'   => '0',
                    'label_delivery_fee' => '0',
                    'tax_fee'            => '0',
                    'other_fee'          => '0',
                    'type'               => 'final',
                    'order_id'           => $single['id'],
                    'user_id'            => $single['user_id'],
                    'status'             => '1'
                ];

                $this->Billing_model->delete_billing_info( array('order_id' => $single['id'], 'type' => 'final'));
                $this->Billing_model->insert_billing_info($billing_array);

                if(!$this->Order_model->check_trucking_number_isset_for_order($single['id'])){
                    $this->Order_model->update_luggage_info(array('charge_weight' => '0'), $single['id']);
                }

                if(!$this->Order_model->change_order_status($single['id'], CLOSED_STATUS[0])){
                    $errors[] = 'Can not change order status order ID : '.$single['id'];
                    continue;
                }

                $user_info = $this->Users_model->get_user_info($single['user_id']);

                $view = 'cancel_before_processed';
                $data_inf['subject_description'] = 'Hi '.$user_info['first_name']." ".$user_info['last_name'].', thanks for submitting a cancellation request for your order. We will complete the cancellation and process the refund within 15 days. Please feel free to contact us if you have any question. Thanks.';

                $data_inf['first_name'] = $user_info['first_name'];
                $data_inf['last_name'] = $user_info['last_name'];
                $data_inf['order_id']  = $single['id'];
                $data_inf['order_number']  = $single['order_id'];

                $email_data = array(
                    'email'     => $user_info['email'],
                    'to_name'   => $user_info['username'],
                    'variables' => $data_inf,
                    'subject'  => 'Your order has been cancelled - '. $user_info['account_name'],
                );

                $this->Order_model->update_order($single['id'], array('status_change_by' => '1'));

                //$this->general_email->send_email($view,$email_data);

                $closed++;
            }

        }

        $response = [
            'errors' => count($errors),
            'closed' => $closed
        ];

        return $response;

    }

    public function send_email($arg = NULL){

        if($arg != $this->send_email_checking){
            show_404();
            exit;
        }

        $this->load->model('Dashboard_model');
        $this->load->model('Order_model');
        $this->load->model('Users_model');
        $this->load->library('General_email');

        $orders = $this->Dashboard_model->get_orders_for_email_cron(INCOMPLETE_STATUS[0]);

        var_export(count($orders));

        if(empty($orders)){
            return false;
        }

        foreach($orders as $single){

            $now = strtotime(date('Y-m-d H:i:s'));
            $date = strtotime($single['created_date']);

            $diff = round(abs($date - $now) / 60,2);
            $diff = intval($diff);

            if($diff < 30 || !empty($single['create_email_send'])){
                continue;
            }

            $user_info = $this->Users_model->get_user_info($single['user_id']);
            $delivery_data = $this->Order_model->get_delivery_info($single['id']);
            $pick_up_data = $this->Order_model->get_pickup_info($single['id']);

            if(empty($user_info) || empty($delivery_data) || empty($pick_up_data)){
                continue;
            }

            $country_info = $this->Users_model->get_countries($delivery_data['delivery_country_id'],true);

            if($single['shipping_type'] == 1){

                if(!empty($country_info)){

                    $country_or_city = $country_info['country'].' '.$delivery_data['delivery_city'];
                    $country_or_city2 = $country_info['country'];
                }

            }else{

                $country_or_city = $delivery_data['delivery_postal_code'];
                $country_or_city2 = $delivery_data['delivery_city'];
            }

            $info = [
                'first_name'          => $user_info['first_name'],
                'last_name'           => $user_info['last_name'],
                'shipping_type'       => $single['shipping_type'],
                'country_to'          => $country_info['country'],
                'city_to'             => $delivery_data['delivery_city'],
                'postal_code'         => $delivery_data['delivery_postal_code'],
                'shipping_date'       => $pick_up_data['shipping_date'],
                'subject_description' => 'Hi '.$user_info['first_name']." ".$user_info['last_name'].', you recently created a new shipping order to '.$country_or_city.' . If you have not submitted the order, simply login your account, complete and submit the order. Thanks.',
            ];

            $this->Order_model->update_total_order_count($single['user_id']);

            $email_data = array(
                'email'     => $user_info['email'],
                'to_name'   => $user_info['username'],
                'subject'   => 'Your Shipment To '.$country_or_city2.' – ' . $user_info['account_name'],
                'variables' => $info
            );

            $this->config->load('general_email');

            $email_data2 = array(
                'email'     => $this->config->item('server_email'),
                'to_name'   => $user_info['username'],
                'subject'   => 'Your Shipment To '.$country_or_city2.' – ' . $user_info['account_name'],
                'variables' => $info
            );

            $this->general_email->send_email('incomplete_order',$email_data);
            $this->general_email->send_email('incomplete_order',$email_data2);

            $this->Order_model->update_order($single['id'], array('create_email_send' => 1));

        }

    }


    public function get_trucking_statuses($arg = NULL){

        if($arg != $this->trucking_config['arg']){
            show_404();
            exit;
        }

        $this->load->model('Dashboard_model');
        $this->load->model('Order_model');
        $this->load->library('Shippo_lib');

        $limit    = $this->trucking_config['limit'];
        $statuses = [PROCESSED_STATUS[0], READY_STATUS[0], TRANSIT_STATUS[0]];

        $orders = $this->Dashboard_model->get_orders_for_cron($limit, $statuses);

        foreach($orders as $single_order){

            $luggages     = $this->Order_model->get_luggage_order($single_order['id']);

            $carrier_name = $this->shippo_lib->get_carrier_name_for_shipo($single_order['currier_name']);

            if(empty($luggages) || empty($carrier_name)){
                continue;
            }

            $transit = 0;
            $delivered = 0;

            foreach($luggages as $single_luggage){

                if(empty($single_luggage['tracking_number'])){
                    continue;
                }

                $trucking_history = $this->Order_model->get_trucking_history($single_luggage['tracking_number'], $single_luggage['id']);

                $row_count = count($trucking_history);

                if(!is_array($carrier_name)){

                    $result = $this->shippo_lib->get_trucking_status($single_luggage['tracking_number'], $carrier_name);

                    if(empty($result['status'])){
                        continue;
                    }

                    $history   = $result['data']['trucking_history'];
                    $current   = $result['data']['current_status'];
                    $truck_num = $result['data']['tracking_number'];

                }else{

                    foreach($carrier_name as $single_name){

                        $result = $this->shippo_lib->get_trucking_status($single_luggage['tracking_number'], $single_name);

                        if(!empty($result['status'])){

                            $history   = $result['data']['trucking_history'];
                            $current   = $result['data']['current_status'];
                            $truck_num = $result['data']['tracking_number'];
                            break;
                        }

                    }
                }

                if(empty($history) || empty($current) || empty($truck_num)){
                    continue;
                }

                if($current->status == 'TRANSIT'){

                    $transit ++;

                }else if($current->status == 'DELIVERED'){

                    $delivered ++;
                }

                if($row_count < count($history)){

                    $index = count($history)-1;

                    while($index > $row_count-1){

                        if(!empty($history[$index])){

                            $info = $history[$index];

                            $insert_data = [
                                'luggage_id'  => $single_luggage['id'],
                                'truck_num'   => $single_luggage['tracking_number'],
                                'status'      => $info->status,
                                'details'     => $info->status_details,
                                'location'    => $info->location->city.' '.$info->location->state.' '.$info->location->zip.' '.$info->location->country,
                                'status_date' => $info->status_date,
                                'date'        => date('Y-m-d H:i:s')
                            ];

                            $this->Order_model->insert_trucking_history($insert_data);

                        }

                        $index--;
                    }

                }

            }

            var_dump('order id =====> '.$single_order['id']);
            var_dump('luggages count =====> '.count($luggages));

            var_dump('Transit => '.$transit);
            var_dump('delivery => '.$delivered);
            var_dump('----------------------------------------');

        }

    }

    public function refund_verification_pay($argument = NULL){

        $this->load->config('payment_config');

        if($argument !==  $this->config->item('refund_argument')){

            show_404();

            return false;

        }

        $refund_data = $this->Users_model->get_verification_payments(['status' => '0']);

        if(empty($refund_data)){

            echo "No data\n";

            return false;

        }

        $success = [];
        $errors = [];
        $refund_amount = 0;

        foreach($refund_data as $charge){

            $result = $this->_refund($charge['charge_id']);

            if($result === true){

                $success[] = $charge['charge_id'];
                $refund_amount += $charge['amount'];
                $this->Users_model->change_verification_payment_status($charge['id'], '1');

            }else{

                $errors[] = [$charge['charge_id'] => $result];
                $this->Users_model->change_verification_payment_status($charge['id'], '0');

            }

        }

        echo "Errors: ".count($errors)."\n";
        echo "Success: ".count($success)."\n";

    }

    private function _refund($charge, $data = NULL){

        if(empty($charge)){

            return false;

        }

        $this->load->library('payment_lib');

        $data['charge'] = $charge;

        $result = $this->payment_lib->refund($data);

        if(!empty($result->status) && $result->status === 'succeeded'){

            return true;

        }

        return $result;

    }


}


?>