<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Hook extends CI_Controller
{

    private $order_status_hook_arg = 'gabvasd51xfsked65sajs656as4dwqud5sf56';

    public function __construct()
    {

        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->load->model("Users_model");
        $this->load->model("Order_model");
        $this->load->model("Lists_model");
        $this->config->load('order');

    }

    public function order_status_hook($arg){

        if($arg != $this->order_status_hook_arg){
            show_404();
        }

        $bodyData = file_get_contents('php://input');

        if(empty($bodyData)){
            return false;
        }

        $data = json_decode($bodyData);

        if(empty($data->data->tracking_status)){
            return false;
        }

        $trucking_number = $data->data->tracking_number;
        $carrier         = $data->data->carrier;
        $status          = $data->data->tracking_status->status;
        $status_details  = $data->data->tracking_status->status_details;

        if (stripos($status, 'TRANSIT') !== FALSE) {

            $insert_status = TRANSIT_STATUS[0];

        } elseif (stripos($status, 'FAILURE') !== FALSE) {

            $insert_status = TRANSIT_STATUS[0];

        } elseif (stripos($status, 'DELIVERED') !== FALSE) {

            $insert_status = DELIVERY_STATUS[0];
        }

        $luggage_info = $this->Order_model->get_luggage_info_by_number($trucking_number);

        if(empty($luggage_info)){
            return false;
        }

        if(empty($luggage_info['shipping_status']) && $insert_status == TRANSIT_STATUS[0]){

            $insert_status == TRANSIT_STATUS[0];
        }

        $update_luggage_data = [
            'shipping_status' => $insert_status,
            'status_detail' => date('M-d-Y').' '.$status_details
        ];

        $this->Order_model->update_luggage_info($update_luggage_data, $luggage_info['order_id'], $luggage_info['id']);

        $this->check_and_change_order_status($luggage_info['order_id']);

    }

    private function check_and_change_order_status($order_id){

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        if(empty($order_luggages)){
            return false;
        }

        $count = count($order_luggages);
        $statuses = [];

        foreach($order_luggages as $single_luggage){

            if(empty($single_luggage['shipping_status'])){
                continue;
            }

            if(empty($statuses[$single_luggage['shipping_status']])){
                $statuses[$single_luggage['shipping_status']] = 1;
            }else{
                $statuses[$single_luggage['shipping_status']] += 1;
            }

        }

        foreach($statuses as $status => $count_of_status){
            if($count_of_status == $count){
                $this->Order_model->change_order_status($order_id, $status);
                break;
            }
        }

        return true;

    }

}
?>