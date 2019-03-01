<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Invoice extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Billing_model");
        $this->load->model("Order_model");
        $this->config->load('order');
        $this->load->library('Price_lib');
        $this->load->model("Invoice_model");

    }

    public function view($order_id, $type, $ver_num = NULL, $return = false){

        if(empty($ver_num)){

            $this->check_admin_login();

        }elseif($ver_num != VIEW_INVOICE_CODE){

            return false;
        }

        if(empty($order_id) || empty($type)){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }

        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }
        }

        $user = $this->Users_model->get_user_info($order_info['user_id'], true);

        if(empty($user)){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }
        }

        $crt = [
            'order_id' => $order_id,
            'type'     => $type
        ];

        $data['title']       = ucfirst($type).' Invoice';
        $data['type']        = $type;
        $data['order_info']  = $order_info;
        $data['user_info']   = $user;

        $data['billing_info'] = $this->Billing_model->get_billing($crt);
        $data['billing_history'] = $this->Billing_model->get_all_billing($order_id);

        if(empty($data['billing_info'])){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }
        }

        if($data['billing_info']['status'] != 0){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }
        }

        $data['sender_info']   = $this->Order_model->get_pickup_info($order_id);
        $data['receiver_info'] = $this->Order_model->get_delivery_info($order_id);

        if(empty($data['sender_info']) || empty($data['receiver_info'])){

            if($return){

                return false;

            }else{

                show_404();
                exit;
            }
        }

        $data['from_country'] = $this->Users_model->get_countries($data['sender_info']['pickup_country_id'], true);
        $data['to_country']   = $this->Users_model->get_countries($data['receiver_info']['delivery_country_id'], true);

        $data['luggage_billing_info'] = $this->_get_billing_info($order_id);
        $data['payment_history']      = $this->Order_model->get_pay_history($order_id, ['status' => 1]);
        $data['insurance']            = $this->Order_model->get_insurance_sum($order_id);

        $data['promo_text'] = [
            'size' => '0%',
            'amount' => '$ 0.00'
        ];

        $sum = floatval($data['billing_info']['shipping_fee'])
            + floatval($data['billing_info']['pickup_fee'])
            + floatval($data['billing_info']['process_fee'])
            + floatval($data['billing_info']['insurance_fee'])
            + floatval($data['billing_info']['special_handling'])
            + floatval($data['billing_info']['oversize_fee'])
            + floatval($data['billing_info']['remote_area_fee'])
            - floatval($data['billing_info']['admin_discount'])
            - floatval($data['billing_info']['account_credit'])
            + floatval($data['billing_info']['cancel_fee'])
            + floatval($data['billing_info']['address_change_fee'])
            + floatval($data['billing_info']['shipment_holding'])
            + floatval($data['billing_info']['label_delivery_fee'])
            + floatval($data['billing_info']['tax_fee'])
            + floatval($data['billing_info']['other_fee']);

        if(!empty($data['billing_info']['promotion_type']) && $data['billing_info']['promotion_type'] == '1'){

            $promo = $sum*floatval($data['billing_info']['promotion_code'])/100;
            $sum = $sum - $promo;
            $data['promo_text_billing']['size']   = $data['billing_info']['promotion_code'].' %';
            $data['promo_text_billing']['amount'] = '$ '.number_format($promo, '2');
            $data['billing_info']['promotion_code'] = $promo;

        }else{

            $sum = $sum - $data['billing_info']['promotion_code'];
            $data['promo_text_billing']['size']   = '$ '.$data['billing_info']['promotion_code'];
            $data['promo_text_billing']['amount'] = '$ '.$data['billing_info']['promotion_code'];
        }

        $data['shipping_fee'] = number_format($sum, '2');
        $data['weight_difference'] = $this->check_final_charge($order_id);

        if($return === true){

            $content = $this->load->view('frontend/invoice', $data, true);
            return $content;

        }

        $this->load->view('frontend/invoice', $data);

    }

    public function ax_create_invoice(){

        $this-> check_admin_login();

        $this->load->library('Pdf_lib');

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $echo_data = [
          'errors' => [],
          'success' => []
        ];

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $invoice_type = trim($this->security->xss_clean($this->input->post('type')));

        $invoice = $this->view($order_id, $invoice_type, NULL, true);

        if(empty($invoice)){
            $echo_data['errors'][] = 'Can not get invoice content.';
            echo json_encode($echo_data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        $url = base_url('invoice/view/'.$order_id.'/'.$invoice_type.'/'.VIEW_INVOICE_CODE);
        $file_name = $order_info['order_id'].'_'.$invoice_type.'_invoice.pdf';
        $save_dir = FCPATH.'invoices/'.$order_id;

        $result = $this->pdf_lib->html_to_pdf($url, $save_dir, $file_name);

        if(!$result){
            $echo_data['errors'][] = 'Can not create invoice.';
            echo json_encode($echo_data);
            return false;
        }

        $data = [
            'order_id'      => $order_id,
            'user_id'       => $order_info['user_id'],
            'type'          => $invoice_type,
            'creation_date' => date('Y-m-d H:i:s'),
            'pdf_file'      => $file_name
        ];

        $old_invoice = $this->Invoice_model->get_created_invoice($order_id, $invoice_type);

        if(empty($old_invoice)){

            if(!$this->Invoice_model->create_invoice($data)){
                $echo_data['errors'][] = 'File created but can not fill data to db.';
            }

        }else{

            $this->Invoice_model->update_invoice($data, ['id' => $old_invoice[0]['id']]);
        }


        echo json_encode($echo_data);

    }

    public function ax_delete_invoice(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $id       = trim($this->security->xss_clean($this->input->post('id')));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            $data['errors'][] = 'Undefined order.';
            echo json_encode($data);
            return false;
        }

        $invoice_info = $this->Invoice_model->get_single_invoice($id);

        if(empty($invoice_info)){
            $data['errors'][] = 'Undefined invoice.';
            echo json_encode($data);
            return false;
        }

        $file_name = $invoice_info['pdf_file'];

        $crt = [
            'id'      => $id,
            'order_id' => $order_id
        ];

        if(!$this->Invoice_model->delete_invoice($crt)){
            $data['errors'][] = 'Can not remove info from database.';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH.'invoices/'.$order_id.'/'.$file_name;
        if(file_exists($url)){
            if(!unlink ($url)){
                $data['errors'][] = 'Info from db deleted but can not remove file.';
            }
        }

        echo json_encode($data);

    }

    private function _get_billing_info($order_id){

        $this->load->model('Promotion_model');

        if(empty($order_id)){
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            return false;
        }

        $promotion = NULL;

        if(!empty($order_info['discount_id'])){
            $promotion = $this->Promotion_model->get_code_info_by_id($order_info['discount_id']);
        }

        $info = $this->Order_model->get_order_final_billing_info($order_id);

        if(empty($info)){
            return false;
        }

        $total['total_insurance']        = 0;
        $total['total_handling']         = 0;
        $total['total_oversize']         = 0;
        $total['total_remote_area']      = 0;
        $total['total_address_change']   = 0;
        $total['total_shipment_holding'] = 0;
        $total['total_tax_and_duty']     = 0;
        $total['total_other']            = 0;
        $total['total_cost']             = 0;
        $total['total_actual_weight']    = 0;
        $total['total_billing_weight']   = 0;

        foreach ($info as $index => $inf){

            if(empty($inf['insurance'])){
                $info[$index]['insurance'] = floatval($order_info['free_insurance']);
            }

            $total['total_insurance']        += $inf['insurance'];
            $total['total_handling']         += $inf['special_handling_editable'];
            $total['total_oversize']         += $inf['oversize_fee'];
            $total['total_remote_area']      += $inf['remote_area_fee'];
            $total['total_address_change']   += $inf['address_change_fee'];
            $total['total_shipment_holding'] += $inf['shipment_holding_fee'];
            $total['total_tax_and_duty']     += $inf['tax_duty_fee'];
            $total['total_other']            += $inf['other_fee'];
            $total['total_cost']             += $inf['cost'];
            $total['total_actual_weight']    += $inf['actual_weight'];
            $total['total_billing_weight']   += $inf['lug_charge_weight'];

        }

        $return_array = [
            'luggage'          => $info,
            'promotion'        => $promotion,
            'totals'           => $total
        ];

        return $return_array;

    }

    private function check_final_charge($order_id){

        $crt = [
            'status'    => 1,
            'type_name' => 'final',
            'amount > ' => '0'
        ];

        $final = $this->Order_model->get_pay_history($order_id, $crt);

        if(empty($final)){
            return false;
        }

        return true;

    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            exit();
        }

        return true;

    }

}

?>