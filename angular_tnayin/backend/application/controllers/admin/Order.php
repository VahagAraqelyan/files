<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Order extends CI_Controller
{

    private $admin_dir;
    private $admin_alias = ADMIN_PANEL_URL . '/';
    private $order_count = 12;

    public function __construct()
    {

        parent::__construct();

        $this->load->model("Ion_auth_model");
        $this->load->model("Users_model");
        $this->load->model("Manage_price_model");
        $this->load->model('Lists_model');
        $this->load->model("Order_model");
        $this->load->model("Billing_model");
        $this->load->model("Invoice_model");
        $this->load->model("Dashboard_model");

        $this->load->library('Captcha_lib');
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->load->library('Price_lib');
        $this->load->library('General_email');

        $this->lang->load('auth');
        $this->config->load('order');
        $this->admin_dir = $this->admin_security->admin_dir();


    }

    public function order_detail($order_id = NULL)
    {

        $this->check_admin_login();

        if (empty($order_id) || (!is_numeric($order_id) || intval($order_id) < 0)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $luggage_info = $this->Order_model->get_luggage_order($order_id);

        if (empty($luggage_info)) {

            show_404();
            return false;
        }

        $temp_info = $this->Order_model->get_order_temp_info($order_id);

        $this->load->config('order');
        $data['all_statuses'] = $this->config->item('status_change_types');

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];

        if (!empty($item_list)) {

            $data['order_item_list'] = $item_list;
        }

        $all_currier = $this->Manage_price_model->get_curriers();
        $data['all_currier'] = [];

        if (!empty($all_currier)) {

            $data['all_currier'] = $all_currier;
        }

        if (!empty($temp_info['tracking_save'])) {

            $my_carrier = $this->Order_model->get_carrier_by_name($temp_info['shipping_carrier']);
        } else {

            $my_carrier = $this->Order_model->get_carrier_by_name($order_info['currier_name']);
        }

        if (empty($my_carrier)) {

            show_404();
            return false;
        }

        $carrier_info = $this->ax_change_carrier($order_id, $my_carrier['id'], $order_info['user_id']);

        $data['carrier_info'] = [];
        $data['my_carrier'] = $my_carrier;

        if (!empty($carrier_info)) {
            $data['carrier_info'] = $carrier_info;
        }

        $data['order_price'] = $this->price_lib->get_order_fee($order_id, $order_info['user_id']);
        $data['account_message'] = $this->Users_model->get_user_message_board($order_info['user_id']);
        $data['order_message'] = $this->Order_model->get_account_order_message($order_id);
        $data['item_name'] = $this->Lists_model->get_data_by_list_key('item_name');
        $data['sender_info'] = $this->Order_model->get_pickup_info($order_id);
        $data['delivery_info'] = $this->Order_model->get_delivery_info($order_id);
        $order_info['original_send_type'] = $order_info['send_type'];
        $order_info['send_type'] = str_ireplace(' +Sat', '', $order_info['send_type']);
        $data['order'] = $order_info;
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;
        $data['item_list'] = $this->_check_info_isset($order_id, 'item_list', $order_info['user_id']);
        $data['passport'] = $this->_check_info_isset($order_id, 'passport', $order_info['user_id']);
        $data['travel'] = $this->_check_info_isset($order_id, 'travel', $order_info['user_id']);
        $data['order_file_types'] = $this->config->item('order_file_types');
        $data_id['id'] = $order_info['user_id'];
        $data['user_info'] = $this->Users_model->search_users($data_id);
        $data['errors'] = $this->Order_model->get_order_errors($order_id);
        $data['type_files'] = [];
        $data['shedule'] = $this->Order_model->get_shedule_pick_up($order_id);
        $data['label_shipment'] = $this->Order_model->get_label_shipment($order_id);
        $data['delivery_label'] = $this->Order_model->get_delivery_label($order_id);
        $data['label_dif'] = $this->label_address_dif_check($order_id);
        $type_files = $this->Order_model->get_order_files($order_id);
        $data['luggage_info'] = $luggage_info;
        $data['title'] = $this->price_lib->get_status_title($order_info['shipping_status']);
        $data['fee'] = $this->_get_order_pick_up_fee($order_id);
        $data['freeze'] = $this->_check_user_freez($order_id);
        $data['currier_name'] = $this->Order_model->get_carrier_by_name($order_info['currier_name']);

        $data['label_carrier_info'] = [];

        if (!empty($data['label_shipment']['carrier_id'])) {

            $label_carrier_info = $this->ax_change_carrier($order_id, $data['label_shipment']['carrier_id'], $order_info['user_id'], true);

            if (!empty($label_carrier_info)) {
                $data['label_carrier_info'] = $label_carrier_info;
            }
        }

        if (!empty($temp_info['pickup_save'])) {

            $data['shedule']['time_from'] = $temp_info['time_from'];
            $data['shedule']['time_to'] = $temp_info['time_to'];
            $data['shedule']['con'] = $temp_info['con'];
            $data['shedule']['date'] = $temp_info['date'];
            $data['shedule']['temp'] = true;

        }

        if (!empty($temp_info['label_save'])) {

            $data['label_shipment']['shipping_date'] = $temp_info['shipping_date'];
            $data['label_shipment']['delivery_date'] = $temp_info['delivery_date'];
            $data['label_shipment']['carrier_id'] = $temp_info['carrier_id'];
            $data['label_shipment']['tracking_number'] = $temp_info['tracking_number'];
            $data['label_shipment']['shipping_type'] = $temp_info['shipping_type'];
            $data['label_shipment']['temp'] = true;

            $label_carrier_info = $this->ax_change_carrier($order_id, $temp_info['carrier_id'], $order_info['user_id'], true);

            if (!empty($label_carrier_info)) {
                $data['label_carrier_info'] = $label_carrier_info;
            }

        }

        $temp_data = $this->Order_model->get_single_trucking_temp_info(NULL, $order_id);

        if (!empty($temp_info['tracking_save'])) {

            $data['order']['send_type'] = $temp_info['trucking_service_type'];
            $data['order']['original_send_type'] = $temp_info['trucking_service_type'];
            $data['order']['temp'] = true;

        }

        if (!empty($temp_data)) {
            $data['order']['temp'] = true;
        }

        if (!empty($type_files)) {

            $data['type_files'] = $type_files;
        }

        if (!empty($data['item_list']) && !empty($data['passport']) && !empty($data['travel'])) {

            $data['custom_class'] = 'fa fa-check delivered-icon';

        } else {

            $data['custom_class'] = 'fa fa-exclamation created-icon';
        }

        $country_from = $this->Users_model->get_countries($data['sender_info']['pickup_country_id']);
        $country_to = $this->Users_model->get_countries($data['delivery_info']['delivery_country_id']);

        if (!empty($country_from)) {

            $data['country_from'] = $country_from;
        }

        if (!empty($country_to)) {

            $data['country_to'] = $country_to;
        }

        $data['state_name_delivery'] = '';
        $data['state_name_sender'] = '';

        $country_prof_info = $this->Order_model->get_country_profile($country_from[0]['iso2'], $my_carrier['id']);

        $data['country_prof_info'] = [
            'partner_web' => '',
            'website' => '',
            'password' => ''
        ];

        if (!empty($country_prof_info)) {

            $data['country_prof_info'] = $country_prof_info;
        }

        $delivery_state = $this->Order_model->get_states_by_id($data['delivery_info']['delivery_state']);

        if (!empty($delivery_state['State'])) {
            $data['state_name_delivery'] = $delivery_state['State'];
        }

        $sender_state = $this->Order_model->get_states_by_id($data['sender_info']['pickup_state']);

        if (!empty($sender_state['State'])) {
            $data['state_name_sender'] = $sender_state['State'];
        }

        $data['travel_price'] = floatval($this->Order_model->get_sum_item_list($order_id));

        $data['insurance_info'] = $this->_return_insurance($order_id);

        $data['content'] = 'backend/admin/admin_order_processing';

        $this->load->view('backend/back_template', $data);

    }

    public function ax_update_order_status()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id     = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id      = trim($this->security->xss_clean($this->input->post('user_id')));
        $order_status = trim($this->security->xss_clean($this->input->post('order_status')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $this->load->config('order');
        $all_statuses = $this->config->item('status_change_types');

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            $data['errors'][] = 'Incorrect order info.';
            echo json_encode($data);
            return false;
        }

        $correct_statuses = $all_statuses[$order_info['shipping_status']];

        $correct = false;

        foreach ($correct_statuses as $single) {
            if ($single[0] == $order_status) {
                $correct = true;
                break;
            }
        }

        if (!$correct) {
            $data['errors'][] = 'Incorrect status.';
            echo json_encode($data);
            return false;
        }

        if ($order_status == PROCESSED_CANCEL_STATUS[0] || $order_status == SUBMITTED_CANCEL_STATUS[0]) {

            $this->Order_model->update_payment_history(['button_isset' => '0'], ['order_id' => $order_id, 'button_isset' => '1']);

            $this->Billing_model->global_update_billing_info(array('status' => '0'), array('order_id' => $order_id));

            $billing_array = [
                'shipping_fee' => '0',
                'pickup_fee' => '0',
                'process_fee' => '0',
                'insurance_fee' => '0',
                'special_handling' => '0',
                'oversize_fee' => '0',
                'remote_area_fee' => '0',
                'promotion_code' => '0',
                'promotion_type' => '0',
                'admin_discount' => '0',
                'account_credit' => '0',
                'cancel_fee' => '0',
                'address_change_fee' => '0',
                'shipment_holding' => '0',
                'label_delivery_fee' => '0',
                'tax_fee' => '0',
                'other_fee' => '0',
                'type' => 'final',
                'order_id' => $order_id,
                'user_id' => $order_info['user_id'],
                'status' => '1'
            ];

            $this->Billing_model->delete_billing_info(array('order_id' => $order_id, 'type' => 'final'));
            $this->Billing_model->insert_billing_info($billing_array);

            if (!$this->Order_model->check_trucking_number_isset_for_order($order_id)) {
                $this->Order_model->update_luggage_info(array('charge_weight' => '0'), $order_id);
            }

        }elseif (($order_info['shipping_status'] == PROCESSED_CANCEL_STATUS[0] || $order_info['shipping_status'] == SUBMITTED_CANCEL_STATUS[0]) && $order_info['status_change_by'] == '1' && $order_status != CLOSED_STATUS[0]) {

            $this->Billing_model->delete_billing_info(array('order_id' => $order_id, 'type' => 'final'));
        }

        if (!$this->Order_model->change_order_status($order_id, $order_status, true)) {

            $data['errors'][] = 'Error updating data';

        } else {

            $data['success'][] = 'Update has ben successfully';

            if($order_status == DELIVERY_STATUS[0]){

                $user_info = $this->Users_model->get_user_info($user_id);

                $subject = 'Your order has been delivered successfully - ' . $order_info['order_id'];
                $subject_description = 'Hi ' . $user_info['first_name'] . " " . $user_info['last_name'] . ', your order ' . $order_info['order_id'] . ' has been delivered successfully. Thank you very much for your business. We are looking forward to providing you services again.';
                $this->_send_email_variable($order_id, $user_id, 'change_delivery_status', $subject, $subject_description);
            }
        }


        echo json_encode($data);

    }

    public function ax_update_claim()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            $data['errors'][] = 'Incorrect order info.';
            echo json_encode($data);
            return false;
        }

        $lost_claim = $this->input->post('lost_claim');
        $damage_claim = $this->input->post('damage_claim');
        $payment_dispute = $this->input->post('payment_dispute');
        $billing_claim = $this->input->post('billing_claim');

        $order_update_data = [
            'lost_claim' => $lost_claim,
            'damage_claim' => $damage_claim,
            'payment_dispute' => $payment_dispute,
            'billing_claim' => $billing_claim
        ];

        if (!$this->Order_model->update_order($order_id, $order_update_data)) {

            $data['errors'][] = 'Error updating data';

        } else {

            $data['success'][] = 'Update has ben successfully';
        }

        echo json_encode($data);

    }

    public function ax_account_order_message()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $message = trim($this->security->xss_clean($this->input->post('message')));

        $data['errors'] = [];
        $data['success'] = [];
        $data['type'] = [];

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (empty($message)) {

            return false;
        }

        $admin_info = $this->Admin_model->get_account_info($this->session->userdata('admin_id'));

        $insert_data = [

            'order_id' => $order_id,
            'admin_name' => $admin_info->admin_name,
            'add_date' => date('Y-m-d H:i:s'),
            'message' => $message
        ];

        if (!$this->Order_model->insert_account_order_message($insert_data)) {

            $data['errors'][] = false;
            echo json_encode($data);
            return false;
        }

        $data['success'][] = true;
        echo json_encode($data);

    }


    public function ax_get_account_order_message()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];
        $data['success'] = [];

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }


        $data['messages'] = $this->Order_model->get_account_order_message($order_id);

        $this->load->view('backend/admin/order/order_account_message', $data);

    }

    public function ax_update_sender_info()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $sender_phone = trim($this->security->xss_clean($this->input->post('phone'))); //* dom inter
        $pickup_company = trim($this->security->xss_clean($this->input->post('organization')));
        $pickup_address1 = trim($this->security->xss_clean($this->input->post('address1'))); //* dom inter
        $pickup_address2 = trim($this->security->xss_clean($this->input->post('address2')));
        $pickup_remark = trim($this->security->xss_clean($this->input->post('remark')));
        $first_name = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name = trim($this->security->xss_clean($this->input->post('last_name')));
        $email = trim($this->security->xss_clean($this->input->post('email')));
        $postal_code = trim($this->security->xss_clean($this->input->post('pickup_postal_code')));
        $city = trim($this->security->xss_clean($this->input->post('pickup_city')));
        $state = trim($this->security->xss_clean($this->input->post('state')));

        $pick_up_info = $this->Order_model->get_pickup_info($order_id);

        if (empty($pick_up_info)) {
            return false;
        }

        $us = $this->Users_model->get_us_country();

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if (empty($sender_phone)) {
            $data['errors'][] = 'Phone number is required';
            echo json_encode($data);
            return false;
        }


        if ($pick_up_info['pickup_country_id'] != $us[0]['id'] && empty($pickup_address1)) {
            $data['errors'][] = 'Address is required';
            echo json_encode($data);
            return false;
        }

        if (!empty($data['errors'])) {
            echo json_encode($data);
            return false;
        }

        $update_data = [
            'sender_phone' => $sender_phone,
            'pickup_company' => $pickup_company,
            'pickup_address1' => $pickup_address1,
            'pickup_address2' => $pickup_address2,
            'pickup_remark' => $pickup_remark,
            'sender_first_name' => $first_name,
            'sender_last_name' => $last_name,
            'sender_email' => $email,
            'pickup_postal_code' => $postal_code,
            'pickup_city' => $city,
            'pickup_state' => $state
        ];

        if ($order_info['shipping_type'] == 2) {

            unset($update_data['pickup_city']);
            unset($update_data['pickup_state']);
            unset($update_data['pickup_postal_code']);
        }

        /* if($pick_up_info['pickup_country_id'] != $us[0]['id']){
            unset($update_data['pickup_address1']);
            unset($update_data['pickup_address2']);
        }*/

        if (!$this->Order_model->update_pickup_info($update_data, $order_id)) {
            $data['errors'][] = 'Can`t fill data to db.';
        } else {
            $data['success'][] = 'Data successfully saved.';
        }

        echo json_encode($data);

    }

    public function ax_update_receiver_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $receiver_phone = trim($this->security->xss_clean($this->input->post('phone'))); //* dom inter
        $delivery_company = trim($this->security->xss_clean($this->input->post('organization')));
        $delivery_address1 = trim($this->security->xss_clean($this->input->post('address1'))); //* dom inter
        $delivery_address2 = trim($this->security->xss_clean($this->input->post('address2')));
        $delivery_remark = trim($this->security->xss_clean($this->input->post('remark')));
        $receiver_first_name = trim($this->security->xss_clean($this->input->post('first_name'))); //* dom inter
        $receiver_last_name = trim($this->security->xss_clean($this->input->post('last_name'))); //* dom inter
        $receiver_email = trim($this->security->xss_clean($this->input->post('email')));
        $postal_code = trim($this->security->xss_clean($this->input->post('delivery_postal_code')));
        $delivery_city = trim($this->security->xss_clean($this->input->post('delivery_city')));
        $delivery_state = trim($this->security->xss_clean($this->input->post('delivery_state')));

        $delivery_info = $this->Order_model->get_delivery_info($order_id);

        if (empty($delivery_info)) {
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }


        if (empty($receiver_phone)) {
            $data['errors'][] = 'Phone number is required';
            echo json_encode($data);
            return false;
        }

        $us = $this->Users_model->get_us_country();

        if ($delivery_info['delivery_country_id'] != $us[0]['id'] && empty($delivery_address1)) {

            $data['errors'][] = 'Address is required';
            echo json_encode($data);
            return false;
        }

        if (!empty($data['errors'])) {
            echo json_encode($data);
            return false;
        }

        $update_data = [
            'order_id' => $order_id,
            'receiver_phone' => $receiver_phone,
            'delivery_company' => $delivery_company,
            'delivery_address1' => $delivery_address1,
            'delivery_address2' => $delivery_address2,
            'delivery_remark' => $delivery_remark,
            'receiver_first_name' => $receiver_first_name,
            'receiver_last_name' => $receiver_last_name,
            'receiver_email' => $receiver_email,
            'delivery_postal_code' => $postal_code,
            'delivery_city' => $delivery_city,
            'delivery_state' => $delivery_state,
        ];

        if ($order_info['shipping_type'] == 2) {

            unset($update_data['delivery_postal_code']);
            unset($update_data['delivery_city']);
            unset($update_data['delivery_state']);
        }

        if (!$this->Order_model->update_delivery_info($update_data, $order_id)) {
            $data['errors'][] = 'Can`t fill data to db.';
        } else {
            $data['success'][] = 'Data successfully saved.';
        }

        echo json_encode($data);

    }

    public function set_credit_card(){

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $card_id = trim($this->security->xss_clean($this->input->post('card_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (empty($order_id) || empty($card_id) || empty($user_id)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, ['0', '1', '2', '3']);

        if (empty($order_info)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if (!$this->Order_model->set_order_card($order_id, $card_id)) {

            $data['errors'][] = 'Can not set card for order.';
            echo json_encode($data);
            return false;
        }

        $data['success'] = 'Credit card successfully saved';

        echo json_encode($data);

    }

    public function ax_edit_delivery_info()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $delivery_info = $this->Order_model->get_delivery_info($order_id);
        $order_info = $this->Order_model->get_order_info($order_id);
        $data['order_info'] = $order_info;
        $country = $this->Users_model->get_countries($delivery_info['delivery_country_id']);
        $data['delivery_info'] = $delivery_info;
        if (!empty($country)) {

            $data['country'] = $country[0]['country'];
        }

        $us = $this->Users_model->get_us_country(true);

        $data['us'] = 0;

        if (!empty($us['country'])) {
            $data['us'] = $us['id'];
        }

        $data['state'] = [];

        $state = $this->Users_model->get_states($delivery_info['delivery_country_id']);
        if (!empty($state)) {

            $data['state'] = $state;
        }

        $delivery_state = $this->Order_model->get_states_by_id($delivery_info['delivery_state']);

        $data['state_name'] = '';

        if (!empty($delivery_state['State'])) {
            $data['state_name'] = $delivery_state['State'];
        }

        $this->load->view('backend/admin/order/admin_delivery_info', $data);
    }

    public function ax_edit_sender_info()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $sender_info = $this->Order_model->get_pickup_info($order_id);
        $order_info = $this->Order_model->get_order_info($order_id);
        $data['order'] = $order_info;
        $country = $this->Users_model->get_countries($sender_info['pickup_country_id']);
        $data['sender_info'] = $sender_info;
        if (!empty($country)) {

            $data['country'] = $country[0]['country'];
        }

        $us = $this->Users_model->get_us_country(true);

        $data['us'] = 0;

        if (!empty($us['country'])) {
            $data['us'] = $us['id'];
        }

        $data['state'] = [];

        $state = $this->Users_model->get_states($sender_info['pickup_country_id']);

        if (!empty($state)) {

            $data['state'] = $state;
        }

        $sender_state = $this->Order_model->get_states_by_id($sender_info['pickup_state']);
        $data['state_name'] = '';
        if (!empty($sender_state['State'])) {
            $data['state_name'] = $sender_state['State'];
        }

        $this->load->view('backend/admin/order/admin_sender_info', $data);
    }

    private function _return_insurance($order_id)
    {

        $this->check_admin_login();

        if (empty($order_id)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $luggage_insurance = $this->Order_model->get_luggage_and_label($order_id);

        $return_array = [];

        if (empty($luggage_insurance)) {
            return false;
        }

        $total = 0;
        $all_labels = true;

        $temp_data = $this->Order_model->get_trucking_temp_info($order_id);

        foreach ($luggage_insurance as $index => $insurance) {

            if (empty($insurance['insurance'])) {

                $luggage_insurance[$index]['insurance'] = floatval($order_info['free_insurance']);
            }

            if (!empty($temp_data[$insurance['lug_id']]['trucking_number'])) {

                $luggage_insurance[$index]['tracking_number'] = $temp_data[$insurance['lug_id']]['trucking_number'];
                $luggage_insurance[$index]['temp_number'] = true;

            }

            if (!empty($temp_data[$insurance['lug_id']]['file_name'])) {

                $luggage_insurance[$index]['temp_label_file'] = $temp_data[$insurance['lug_id']]['file_name'];
                $luggage_insurance[$index]['file_id'] = $temp_data[$insurance['lug_id']]['id'];
            }

            if (empty($temp_data[$insurance['lug_id']]['file_name']) && empty($luggage_insurance[$index]['file_name'])) {
                $all_labels = false;
            }

            $total += floatval($luggage_insurance[$index]['insurance']);

        }

        $return_array['info'] = $luggage_insurance;
        $return_array['total'] = $total;
        $return_array['label_check'] = $all_labels;

        return $return_array;

    }

    public function ax_delete_label_file($order_id = NULL, $id = NULL)
    {

        $this->check_admin_login();
        $ajax = false;

        if ($this->input->method() == 'post' && $this->input->is_ajax_request() && empty($order_id) && empty($id)) {

            $ajax = true;
            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
            $id = trim($this->security->xss_clean($this->input->post('luggage_id')));

        }

        if (!$this->valid->is_id($order_id)) {

            if ($ajax) {
                show_404();
            }
            return false;
        }

        $temp_array = explode('_', $id);
        $temp = false;

        if (count($temp_array) == 2 && $temp_array[0] == 'temp') {

            $temp = true;
            $id = $temp_array[1];

            $luggage_info = $this->Order_model->get_single_trucking_temp_info($id, $order_id);

        } else {

            $luggage_info = $this->Order_model->get_order_files($order_id, NULL, $id);
        }

        $data['errors'] = [];
        $data['success'] = [];

        if (empty($luggage_info) && $temp == false) {

            $data['errors'][] = 'Undefined document.';
            echo json_encode($data);
            return false;

        }

        $url = FCPATH . 'uploaded_documents/orders_files/' . $order_id . '/' . $luggage_info['file_name'];

        if (file_exists($url)) {

            if (unlink($url)) {

                $remove = true;
            } else {

                $remove = false;
            }

        } else {

            $remove = true;
        }

        if (!$temp) {

            if ($remove) {

                $this->Order_model->delete_order_files($order_id, $id);
            } else {

                $data['errors'][] = 'Can not remove document';
            }

        } else {

            if ($remove) {

                $this->Order_model->update_trucking_temp_info(
                    ['id' => $id],
                    ['file_name' => NULL]
                );

            } else {

                $data['errors'][] = 'Can not remove document';
            }

        }

        $data['success'] = 'Document has been deleted';

        if ($ajax) {
            echo json_encode($data);
        }

        return true;
    }

    public function ax_custom_document()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $editable = trim($this->security->xss_clean($this->input->post('editable')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }


        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data = $this->_get_item_list($order_id, $user_id, $editable);
        $passport_info = $this->_get_passport_info($order_id);
        $travel = $this->_get_travel($order_id, $user_id);
        $data = array_merge($data, $passport_info, $travel);
        $delivery_info = $this->Order_model->get_delivery_info($order_id);
        $data['note'] = [];
        $data['item_list'] = $this->_check_info_isset($order_id, 'item_list', $user_id);
        $data['passport'] = $this->_check_info_isset($order_id, 'passport', $user_id);
        $data['travel'] = $this->_check_info_isset($order_id, 'travel', $user_id);
        $data['order_info'] = $order_info;
        if (!empty($delivery_info['delivery_country_id'])) {

            $data['note'] = $this->Manage_price_model->get_currier_comment('1', $delivery_info['delivery_country_id'], '', true);
        }

        $this->load->view('backend/admin/order/custom_document', $data);

    }

    public function get_signature_file($order_id){

        $this->check_admin_login();

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            show_404();
        }

        if(empty($order_info['signature'])){
            show_404();
        }

        $data = $order_info['signature'];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $url = FCPATH.'temp_images';
        $file_name = $order_info['order_id'].'_signature.png';

        if(!is_dir($url)){
            mkdir($url, 0775, TRUE);
        }

        $url = $url.'/'.$file_name;

        file_put_contents($url, $data);

        if(!is_file($url)){
            show_404();
            exit();
        }

        $config['image_library'] = 'gd2';
        $config['source_image'] = $url;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 240;
        $config['height']       = 25;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();

        $file = file_get_contents($url);

        unlink($url);

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_name, $file);
        exit();

    }

    public function ax_billing_payment()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $this->load->config('order');

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }

        $final_billing_info = NULL;

        $charge = $this->Billing_model->check_last_billing($order_id);

        if ($charge['next'] != 'initial' && $charge['next'] != 'estimate') {
            $final_billing_info = $this->_get_order_final_billing_info($order_id, $user_id);
        }

        $crt = ['user_id' => $user_id];
        $data['charge_payment'] = $pay_history = $this->Order_model->get_pay_history($order_id, $crt);
        $data['order_message'] = $this->Order_model->get_finicial_notes($order_id);
        $billing_inf = $this->get_billing_table_array($order_id);

        $data['billing_table'] = $billing_inf['types'];
        $data['button_isset'] = $billing_inf['button'];
        $data['auto_complete_array'] = array_filter($billing_inf['auto_complete_array']);

        $data['order_info'] = $this->Order_model->get_order_info($order_id, $user_id);
        $data['cards_info'] = $this->_get_credit_card($order_id, $user_id);
        $data['final_billing_info'] = $final_billing_info;
        $data['invoices_link'] = $this->get_invoice_link($order_id);

        $created_invoice = $this->Invoice_model->get_created_invoice($order_id);
        $data['invoices'] = $created_invoice;
        $data['reasons'] = $this->config->item('admin_reason');

        $data['order_credits'] = $this->Order_model->get_all_order_credits($order_id);

        $this->load->view('backend/admin/order/billing_payment', $data);

    }

    private function get_billing_table_array($order_id)
    {

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            return false;
        }

        $billings = $this->Billing_model->get_all_billing($order_id);

        $array = [
            'id' => NULL,
            'order_id' => $order_id,
            'type' => NULL,
            'shipping_fee' => NULL,
            'pickup_fee' => NULL,
            'process_fee' => NULL,
            'insurance_fee' => NULL,
            'special_handling' => NULL,
            'oversize_fee' => NULL,
            'remote_area_fee' => NULL,
            'admin_discount' => NULL,
            'promotion_code' => NULL,
            'promotion_type' => NULL,
            'account_credit' => NULL,
            'cancel_fee' => NULL,
            'address_change_fee' => NULL,
            'shipment_holding' => NULL,
            'label_delivery_fee' => NULL,
            'tax_fee' => NULL,
            'other_fee' => NULL,
            'update_date' => NULL,
            'status' => NULL,
        ];

        $return_array = [
            'estimate' => $array,
            'initial' => $array,
            'adjust_1' => $array,
            'adjust_2' => $array,
            'final' => $array
        ];

        $return_array['estimate']['type'] = 'estimate';
        $return_array['initial']['type'] = 'initial';
        $return_array['adjust_1']['type'] = 'adjust_1';
        $return_array['adjust_2']['type'] = 'adjust_2';
        $return_array['final']['type'] = 'final';
        $button = NULL;
        $last_update = NULL;

        if (!empty($billings)) {

            foreach ($billings as $single) {

                $return_array[$single['type']] = $single;

                if ($single['status'] == 1) {
                    $button = $single['type'];
                }

            }

            $old_button = $button;

            $last_update = $this->Billing_model->check_last_billing($order_id);
            $last_update = $last_update['last_billing'];

            if ($last_update['type'] == 'estimate' && $order_info['shipping_status']) {

                $return_array['initial']['status'] = 1;

                $button = 'initial';

            } elseif ($last_update['type'] == 'initial' && $last_update['status'] == 0) {

                $return_array['final']['status'] = 1;

                $button = 'final';

            } elseif (($last_update['type'] == 'adjust_1' || $last_update['type'] == 'adjust_2')) {

                $return_array['final']['status'] = 1;

                $button = 'final';
            }

            if (empty($return_array[$button]['shipping_fee']) && !empty($old_button)) {
                $button = $old_button;
            }

        }

        if($order_info['shipping_status'] == CLOSED_STATUS[0]){
            foreach($return_array as $key => $single){
                $return_array[$key]['status'] = 0;
            }
            $button = NULL;
        }


        $return_array = [
            'types'               => $return_array,
            'button'              => $button,
            'auto_complete_array' => $last_update
        ];

        return $return_array;

    }

    public function ax_submit_billing_info($data = NULL, $user_id = NULL, $order_id = NULL, $type = NULL)
    {

        $this->check_admin_login();

        $return = true;

        if (empty($data)) {

            $type = trim($this->security->xss_clean($this->input->post('type')));

            $data['shipping_fee'] = trim($this->security->xss_clean($this->input->post($type . '_shipping_fee')));
            $data['pickup_fee'] = trim($this->security->xss_clean($this->input->post($type . '_pickup_fee')));
            $data['process_fee'] = trim($this->security->xss_clean($this->input->post($type . '_process_fee')));
            $data['insurance_fee'] = trim($this->security->xss_clean($this->input->post($type . '_insurance_fee')));
            $data['special_handling'] = trim($this->security->xss_clean($this->input->post($type . '_special_handling')));
            $data['oversize_fee'] = trim($this->security->xss_clean($this->input->post($type . '_oversize_fee')));
            $data['remote_area_fee'] = trim($this->security->xss_clean($this->input->post($type . '_remote_area_fee')));
            $data['promotion_code'] = trim($this->security->xss_clean($this->input->post($type . '_promotion_code')));
            $data['promotion_type'] = trim($this->security->xss_clean($this->input->post($type . '_promotion_type')));
            $data['admin_discount'] = trim($this->security->xss_clean($this->input->post($type . '_admin_discount')));
            $data['account_credit'] = trim($this->security->xss_clean($this->input->post($type . '_account_credit')));
            $data['cancel_fee'] = trim($this->security->xss_clean($this->input->post($type . '_cancel_fee')));
            $data['address_change_fee'] = trim($this->security->xss_clean($this->input->post($type . '_address_change_fee')));
            $data['shipment_holding'] = trim($this->security->xss_clean($this->input->post($type . '_shipment_holding')));
            $data['label_delivery_fee'] = trim($this->security->xss_clean($this->input->post($type . '_label_delivery_fee')));
            $data['tax_fee'] = trim($this->security->xss_clean($this->input->post($type . '_tax_fee')));
            $data['other_fee'] = trim($this->security->xss_clean($this->input->post($type . '_other_fee')));
            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
            $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
            $data['promotion_code'] = str_ireplace(['%', '$'], '', $data['promotion_code']);
            $data['promotion_code'] = floatval($data['promotion_code']);
            $return = false;

        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        $return_data['errors'] = [];
        $return_data['success'] = '';

        if (empty($type)) {

            $return_data['errors'][] = 'Incorrect information.';
            if (!$return) {
                echo json_encode($return_data);
            }
            return $return_data;
        }

        if (empty($order_info)) {

            $return_data['errors'][] = 'Incorrect order information.';
            if (!$return) {
                echo json_encode($return_data);
            }
            return $return_data;
        }

        $card_id = $order_info['card_id'];

        if (empty($card_id)) {

            $return_data['errors'][] = 'Please set credit card.';
            if (!$return) {
                echo json_encode($return_data);
            }
            return $return_data;
        }

        $card_info = $this->Order_model->get_credit_card_by_id($user_id, NULL, $card_id);

        if (empty($card_info)) {

            $return_data['errors'][] = 'Undefined credit card';
            if (!$return) {
                echo json_encode($return_data);
            }
            return $return_data;
        }

        if (empty($data)) {
            if (!$return) {
                echo json_encode($return_data);
            }
            return $return_data;
        }


        $billing_isset = $this->Billing_model->get_billing(['type' => $type, 'order_id' => $order_id]);

        if (empty($billing_isset)) {

            $insert_data = $data;
            $insert_data['type'] = $type;
            $insert_data['order_id'] = $order_id;
            $insert_data['user_id'] = $user_id;
            $insert_data['status'] = '1';

            if (!$this->Billing_model->insert_billing_info($insert_data)) {

                $return_data['errors'][] = 'Can not fill data to database';
                if (!$return) {
                    echo json_encode($return_data);
                }
                return $return_data;
            }

        } else {

            if (!$this->Billing_model->update_billing_info($data, $order_id, $type)) {

                $return_data['errors'][] = 'Can not update billing data';
                if (!$return) {
                    echo json_encode($return_data);
                }
                return $return_data;
            }
        }

        $total = 0;
        $promo = false;

        foreach ($data as $key => $value) {

            if ($key == 'promotion_type') {
                continue;
            }

            if ($key == 'promotion_code') {

                if ($data['promotion_type'] == '2') {

                    $total = $total - floatval($value);

                } else {

                    $promo = true;
                }

                continue;
            }

            if ($key == 'admin_discount' || $key == 'account_credit') {

                $total = $total - floatval($value);
            } else {

                $total = $total + floatval($value);
            }

        }

        if ($promo) {
            $total = $total - floatval($total * $data['promotion_code'] / 100);
        }

        if ($total < 0) {
            $total = 0;
        }

        $card_charge = 0;
        $credit_charge = 0;
        $refund = 0;

        $payment_history = $this->Order_model->get_pay_history($order_id, ['status' => '1']);

        if (!empty($payment_history)) {

            foreach ($payment_history as $single) {

                if ($single['type'] == 2) {
                    $refund = $refund + $single['amount'];
                    continue;
                }

                if ($single['card_number'] == 'From credit' && empty($single['charge_id'])) {
                    $credit_charge = $credit_charge + $single['amount'];
                } else if (!empty($single['charge_id'])) {
                    
                    $card_charge = $card_charge + $single['amount'];
                }

            }
        }

        if ($card_charge + $credit_charge - $refund < $total) {
            $card_number = $card_info['card_number'];
            $pay_type = 1;
            $new_amount = $total - $card_charge - $credit_charge + $refund;
        } else {
            $card_number = '-';
            $pay_type = 2;
            $new_amount = $card_charge + $credit_charge - $total - $refund;
        }

        $insert_data = [
            'user_id' => $user_id,
            'order_id' => $order_id,
            'card_id' => $card_id,
            'card_number' => $card_number,
            'charge_id' => NULL,
            'date' => date('Y-m-d H:i:s'),
            'amount' => $new_amount,
            'type_name' => $type,
            'type' => $pay_type,
            'status' => '0',
            'button_isset' => '1'
        ];

        $crt = [
            'order_id' => $order_id,
            'user_id' => $user_id,
            'type_name' => $type,
            'status' => '0',
        ];

        $payment_history = $this->Order_model->get_pay_history($order_id, $crt);

        if (empty($payment_history)) {

            if (!$this->Order_model->insert_payment_history($insert_data)) {

                $return_data['errors'][] = 'Can not update billing data';

            } else {

                $return_data['success'] = $type . ' successful submited.';
            }

        } else {

            if (!$this->Order_model->update_payment_history($insert_data, $crt)) {

                $return_data['errors'][] = 'Can not update billing data';

            } else {

                $return_data['success'] = 'Successful submit.';
            }

        }

        if (empty($return_data['errors']) && $type == 'final') {

            $crt = [
                'order_id' => $order_id,
                'type !=' => 'final'
            ];

            $this->Billing_model->global_update_billing_info(['status' => '0'], $crt);

        }

        if (!$return) {
            echo json_encode($return_data);
        }
        return $return_data;

    }

    public function ax_charge_or_refund()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $this->load->library('Payment_lib');

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $data_id = trim($this->security->xss_clean($this->input->post('data_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));


        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        $return_data['errors'] = [];
        $return_data['success'] = '';

        if (empty($order_info)) {

            $return_data['errors'][] = 'Incorrect order information.';
            echo json_encode($return_data);
            return false;
        }

        $operation = $this->Order_model->get_pay_history($order_id, ['id' => $data_id, 'status' => '0', 'button_isset' => '1']);

        if (empty($operation)) {

            $return_data['errors'][] = 'Incorrect operation.';
            echo json_encode($return_data);
            return false;
        }

        $operation = $operation[0];
        $refund_card_numbers = [];

        //REFUND
        if ($operation['type'] == 2 && $operation['amount'] > 0) {

            $refund_amount = $operation['amount'];

            $payment_history = $this->Order_model->get_pay_history($order_id, ['status' => '1', 'type' => '1'], 'DESC');
            $refund_id = '';

            foreach ($payment_history as $single) {

                if ($refund_amount <= 0) {
                    break;
                }

                $amount = $single['amount'];

                if ($amount > $refund_amount) {

                    $new_amount = floatval($amount) - floatval($refund_amount);
                    $refund_amount = 0;


                } else {

                    $refund_amount = floatval($refund_amount) - floatval($amount);
                    $new_amount = 0;

                }

                $dif = $amount - $new_amount;

                if ($single['card_number'] == 'From credit' && $single['status'] == '1') {

                    if (!$this->Users_model->change_user_credit($user_id, $dif, '+')) {
                        $refund_amount += $dif;
                        continue;
                    }

                    if ($new_amount == 0) {

                        $this->Order_model->update_payment_history(['status' => '0'], ['id' => $single['id']]);

                    } else {

                        $this->Order_model->update_payment_history(['amount' => $new_amount], ['id' => $single['id']]);
                    }

                    array_unshift($refund_card_numbers, 'To credit');

                    continue;

                }else if($single['card_number'] == 'From credit' && $single['status'] == '0'){
                    continue;
                }

                if (!empty($single['charge_id'])) {

                    $refund_data = [
                        'charge' => $single['charge_id'],
                        'amount' => $dif * 100
                    ];

                    $result = $this->payment_lib->refund($refund_data);

                    if (!empty($result->status) && $result->status == 'succeeded') {

                        $refund_id = $refund_id . $result->id . ',';
                        $refund_card_numbers[] = $single['card_number'];
                        continue;

                    }

                    $caharge_info = $this->payment_lib->get_charge_info($single['charge_id']);

                    if (empty($caharge_info->status) || $caharge_info->status != 'succeeded') {
                        $refund_amount += $dif;
                        continue;
                    }

                    $real_refund = $caharge_info->amount - $caharge_info->amount_refunded;

                    $new_dif = $dif * 100 - $real_refund;
                    $refund_amount += $new_dif / 100;

                    $refund_data = [
                        'charge' => $single['charge_id'],
                        'amount' => $real_refund
                    ];

                    $result = $this->payment_lib->refund($refund_data);

                    if (empty($result->status) || $result->status != 'succeeded') {

                        $refund_amount += $real_refund / 100;

                    } else {

                        $refund_card_numbers[] = $single['card_number'];
                        $refund_id = $refund_id . $result->id . ',';
                    }

                }

            }

            $refund_id = substr($refund_id, 0, -1);

            if ($refund_amount > 0 && $operation['amount'] > 0) {

                $error_refund_amount = $operation['amount'] - $refund_amount;

                $insert_data = [
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'card_id' => 0,
                    'card_number' => implode(',', $refund_card_numbers),
                    'date' => date('Y-m-d H:i:s'),
                    'amount' => $error_refund_amount,
                    'charge_id' => $refund_id,
                    'type' => 2,
                    'status' => 1
                ];

                if ($error_refund_amount > 0) {

                    $this->Order_model->insert_payment_history($insert_data);

                    $update_data = [
                        'amount' => $refund_amount,
                        'card_number' => '-'
                    ];

                    $this->Order_model->update_payment_history($update_data, ['id' => $operation['id']]);
                }

                $return_data['errors'][] = 'Incorrect refund amount. System refund only - $ ' . $error_refund_amount . '.';
                echo json_encode($return_data);
                return false;

            } else {

                $update_data = [
                    'card_number' => implode(',', $refund_card_numbers)
                ];

                if(!empty($refund_id)){
                    $update_data['charge_id'] = $refund_id;
                }

                $this->Order_model->update_payment_history($update_data, ['id' => $operation['id']]);

            }

        }

        //CHARGE
        if ($operation['type'] == 1 && $operation['amount'] > 0) {

            $charge_amount = $operation['amount'] * 100;

            if (empty($order_info['card_id']) || !$this->valid->is_id($order_info['card_id'])) {

                $data['errors'][] = 'Please set credit card.';
                echo json_encode($data);
                return false;
            }

            $card_info = $this->Order_model->get_credit_card_by_id($user_id, NULL, $order_info['card_id']);
            $user_info = $this->Users_model->get_user_info($user_id);

            if (empty($user_info)) {

                $data['errors'][] = 'Undefined User.';
                echo json_encode($data);
                return false;
            }

            $payment_array = [
                'currency' => 'USD',
                'description' => 'Pay for Order :' . $order_info['order_id'] . ', User id :' . $user_info['account_name'],
                'customer_id' => $card_info['customer_id'],
                'card' => $card_info['card_id'],
                'amount' => $charge_amount,
            ];

            $result = $this->payment_lib->do_paymant_from_customer($payment_array);

            if (!empty($result->status) && $result->status == 'succeeded') {

                $this->Order_model->set_order(['аmount_paid' => $charge_amount / 100], ['id' => $order_id]);

                $update_data = [
                    'card_id' => $order_info['card_id'],
                    'charge_id' => $result->id,
                    'card_number' => $card_info['card_number'],
                    'date' => date('Y-m-d H:i:s'),
                    'amount' => $charge_amount / 100,
                    'status' => 1,
                    'button_isset' => '0'
                ];

                $this->Order_model->update_payment_history($update_data, ['id' => $operation['id']]);
                $this->Users_model->change_total_paid($user_id, $charge_amount / 100);

            } else {

                $data['errors'][] = $result;
                echo json_encode($data);
                return false;
            }

        }

        $this->Order_model->update_payment_history(['status' => '1'], ['id' => $operation['id']]);
        $this->Order_model->update_payment_history(['button_isset' => '0'], ['order_id' => $order_id, 'button_isset' => '1']);
        $this->Billing_model->update_billing_info(['status' => '0'], $order_id, $operation['type_name']);

        echo json_encode($return_data);
        return false;

    }

    public function ax_get_credit_card()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $card_id = trim($this->security->xss_clean($this->input->post('card_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (empty($order_id) || empty($card_id) || empty($user_id)) {

            show_404();
            return false;
        }

        $card_info = $this->_get_credit_card($order_id, $user_id);

        if (!empty($card_info['card_info'])) {

            $data['card_info'] = $card_info['card_info'];
        }

        $this->load->view('backend/admin/order/card_info', $data);
    }

    public function _get_credit_card($order_id, $user_id)
    {

        $this->check_admin_login();

        $all_cards = $this->Order_model->get_credit_card_by_id($user_id);

        if (!empty($all_cards)) {

            $return_data['all_cards'] = $all_cards;
            $order_info = $this->Order_model->get_order_info($order_id, $user_id);

            if (empty($order_info)) {

                show_404();
                return false;
            }

            $return_data['card_info'] = [];

            if (!empty($order_info['card_id'])) {

                $return_data['card_info'] = $this->Order_model->get_credit_card_by_id($user_id, NULL, $order_info['card_id']);

                if (!empty($return_data['card_info'])) {

                    $country_info = $this->Users_model->get_countries($return_data['card_info']['country_id']);
                    $state = $this->Order_model->get_states_by_id($return_data['card_info']['state_id']);

                    $return_data['card_info']['state'] = NULL;
                    $return_data['card_info']['country'] = NULL;

                    if (!empty($country_info[0]['country'])) {

                        $return_data['card_info']['country'] = $country_info[0]['country'];

                    }

                    if (!empty($state['State'])) {

                        $return_data['card_info']['state'] = $state['State'];

                    }
                }
            }

            return $return_data;
        }
    }

    public function _get_item_list($order_id, $user_id, $editable = NULL)
    {

        $this->check_admin_login();

        if (empty($order_id) || empty($user_id)) {

            return false;
        }

        $data['item_name'] = $this->Lists_model->get_data_by_list_key('item_name');
        $delivery_info = $this->Order_model->get_delivery_info($order_id);
        $order_info = $this->Order_model->get_submitted_order($user_id, $order_id);
        if (empty($delivery_info)) {

            show_404();
            return false;
        }

        $item_list = $this->Order_model->get_item_list($order_id);
        $data['order_item_list'] = [];


        if (!empty($item_list)) {

            $data['order_item_list'] = $item_list;
        }

        $data['action'] = 'add';

        if (!empty($item_list)) {

            $data['action'] = 'view';

        }

        if (!empty($editable)) {

            $data['action'] = 'add';
        }

        $country_id = $delivery_info['delivery_country_id'];
        $country_info = $this->Users_model->get_countries($country_id);

        if (empty($country_info)) {

            show_404();
            return false;
        }

        $data['country_info'] = $country_info[0];

        $country_profile = $this->Manage_price_model->get_country_profile($data['country_info']['iso2']);

        if (empty($country_profile)) {

            $data['custom_value'] = 0;
        } else {

            $data['custom_value'] = $country_profile[0]['custom_value'];
        }

        $data['uploaded_document'] = $this->Order_model->get_order_form_document($order_id);

        $data['form_files'] = $this->Manage_price_model->get_currier_document($country_id, '1');

        return $data;

    }


    public function _get_travel($order_id, $user_id)
    {

        $this->check_admin_login();

        if (empty($order_id)) {

            show_404();
            return false;
        }

        $travel_info = $this->Order_model->get_travel($order_id, $user_id);

        $data['travel_info'] = [
            'arriving_by' => '',
            'arrival_city' => '',
            'arrival_date' => '',
            'arrival_ticked_number' => '',
            'arrival_cruise_name' => '',
            'leaving_by' => '',
            'departure_city' => '',
            'departure_date' => '',
            'ticked_number' => '',
            'departure_cruise_name' => '',
        ];

        if (!empty($travel_info)) {

            $data['travel_info'] = $travel_info;
        }

        $travel_info_file = $this->Order_model->get_travel_files($order_id, $user_id);

        $data['travel_info_file'] = [];

        if (!empty($travel_info_file)) {

            $data['travel_info_file'] = $travel_info_file;
        }

        return $data;
    }

    public function _get_passport_info($order_id)
    {

        $this->check_admin_login();

        if (empty($order_id)) {

            return false;
        }

        $passport_info = $this->Order_model->get_order_passport_info($order_id);

        $data['passport_info'] = [
            'passport_number' => '',
            'passport_country_id' => 0,
        ];

        $data['all_countries'] = [];

        if (!empty($passport_info)) {

            $data['passport_info'] = $passport_info;
        }

        $all_countries = $this->Users_model->get_countries();

        if (!empty($all_countries)) {
            $data['all_countries'] = $all_countries;
        }

        return $data;
    }

    public function ax_delete_signature()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        $data['success'] = [];
        $data['errors'] = [];

        if (empty($order_info)) {

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if (!$this->Order_model->delete_signature($order_id)) {

            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $data['success'] = 'All data updated';
        echo json_encode($data);
        return false;
    }

    private function _check_info_isset($order_id, $inf_name, $user_id)
    {

        $this->check_admin_login();

        if (empty($order_id) || empty($inf_name)) {
            return false;
        }

        $response = true;

        switch ($inf_name) {

            case 'credit_card':


                $order_info = $this->Order_model->get_order_info($order_id, $user_id);

                if (empty($order_info['card_id'])) {

                    $response = false;
                }


                break;


            case 'pick_up':

                $sender_info = $this->Order_model->get_pickup_info($order_id);

                $required = ['sender_first_name', 'sender_last_name', 'sender_phone', 'pickup_address1', 'pickup_city', 'pick_up'];

                foreach ($required as $single) {

                    if (empty($sender_info[$single])) {

                        $response = false;
                        break;
                    }
                }

                break;


            case 'delivery':

                $receiver_info = $this->Order_model->get_delivery_info($order_id);

                $required = ['receiver_first_name', 'receiver_last_name', 'receiver_phone', 'delivery_address1', 'delivery_city'];

                foreach ($required as $single) {

                    if (empty($receiver_info[$single])) {

                        $response = false;
                        break;
                    }

                }

                break;

            case 'item_list':

                $order_info = $this->Order_model->get_order_info($order_id);

                if (empty($order_info) || empty($order_info['signature'])) {

                    $response = false;
                    break;
                }

                $item_list = $this->Order_model->get_item_list($order_id);

                if (empty($item_list)) {

                    $response = false;
                }

                break;

            case 'passport':

                $passport_info = $this->Order_model->get_order_passport_info($order_id);

                if (empty($passport_info)) {

                    $response = false;
                }

                break;

            case 'travel':

                $travel = $this->Order_model->get_travel($order_id);

                if (empty($travel)) {

                    $response = false;
                }

                break;


            default:

                $response = false;

        }

        return $response;

    }


    public function ax_save_order_item_list()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['success'] = [];
        $data['errors'] = [];
        $data['error_boolean'] = false;

        $items_names = $this->security->xss_clean($this->input->post('names'));
        $items_counts = $this->security->xss_clean($this->input->post('counts'));
        $items_prices = $this->security->xss_clean($this->input->post('prices'));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $editable = trim($this->security->xss_clean($this->input->post('editable')));
        $order_type = trim($this->security->xss_clean($this->input->post('order_type')));

        if (!is_array($items_names) || !is_array($items_counts) || !is_array($items_prices)) {
            $data['errors'][] = 'Incorrect item list information.';
            echo json_encode($data);
            return false;
        }


        $items_names = array_filter($items_names);
        $items_counts = array_filter($items_counts);
        $items_prices = array_filter($items_prices);

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info) || $order_info['shipping_type'] != '1') {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }


        if (empty($items_names) || empty($items_counts) || empty($items_prices)) {
            $data['errors'][] = 'To submit the item list, please fill in all fields. Thanks.';
            $data['error_boolean'] = true;
            echo json_encode($data);
            return false;
        }

        if (count($items_names) != count($items_counts) || count($items_names) != count($items_prices)) {
            $data['errors'][] = 'To submit the item list, please fill in all fields. Thanks.';
            $data['error_boolean'] = true;
            echo json_encode($data);
            return false;
        }

        if (empty($order_type)) {

            $data['errors'][] = 'Please select Personal Effects or Commercial Use.';
            echo json_encode($data);
            return false;
        }

        $batch_insert_array = [];

        foreach ($items_counts as $index => $count) {

            $data_part['item_count'] = intval($count);

            if ($data_part['item_count'] <= 0) {

                $data['errors'][] = 'Count can not be 0';
                echo json_encode($data);
                return false;
            }

            $data_part['item_name'] = $items_names[$index];
            $data_part['item_price'] = $items_prices[$index];
            $data_part['order_id'] = $order_id;

            $batch_insert_array[] = $data_part;

        }

        $order_info_update_data = ['order_type' => $order_type];

        $this->Order_model->update_order($order_id, $order_info_update_data);


        if (!empty($editable)) {

            $this->Order_model->delete_item_list($order_id);
        }

        if (!$this->Order_model->insert_batch_item_list($batch_insert_array)) {

            $data['errors'][] = 'Error filling data to Database.';
            echo json_encode($data);
            return false;

        }

        $user_info = $this->Users_model->get_user_info($user_id);


        echo json_encode($data);
    }

    public function ax_delete_order_form_file()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $file_id = trim($this->security->xss_clean($this->input->post('file_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($file_id)) {

            show_404();
            return false;
        }

        if (!empty($user_id)) {

            $order_info = $this->Order_model->get_submitted_order($user_id, $order_id);

        }

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $file_info = $this->Order_model->get_order_form_document($order_id, $file_id);

        if (empty($file_info)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/' . $order_id . '/' . $file_info[0]['file_name'];

        if (file_exists($url)) {

            if (unlink($url)) {

                $remove = true;
            } else {

                $remove = false;
            }

        } else {

            $remove = true;
        }

        if ($remove) {

            $this->Order_model->delete_order_form_document($order_id, $file_id);
        } else {

            $data['errors'][] = 'Can not remove document';
        }

        $data['success'] = 'Document has been deleted';

        echo json_encode($data);

    }

    public function label_file($order_id, $file_name = NULL)
    {

        if (!$this->valid->is_id($order_id) || empty(trim($file_name))) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $file_path = FCPATH . 'uploaded_documents/orders_files/' . $order_id . '/' . $file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);

/*      header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);*/
        exit;

    }

    private function check_base64_img($base64_temp)
    {

        $base64 = explode(',', $base64_temp);

        if (empty($base64[1])) {
            return false;
        }

        $base64 = $base64[1];

        $xml = base64_decode($base64, true);

        if (empty($xml)) {
            return false;
        }

        if (strpos($xml, 'd="') === false) {
            return false;
        }

        return true;

    }

    public function ax_change_carrier($order_id = NULL, $carrier_id = NULL, $user_id = NULL, $label = NULL)
    {

        $this->check_admin_login();

        if ($this->input->method() == 'post' && $this->input->is_ajax_request()) {

            $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
            $carrier_id = trim($this->security->xss_clean($this->input->post('carrier_id')));
            $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
            $label = trim($this->security->xss_clean($this->input->post('label')));
            $ret = true;

        }

        if (!$this->valid->is_id($order_id) || !$this->valid->is_id($carrier_id) || !$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $this->load->library('Csv_lib');

        $data['errors'] = [];
        $data['success'] = '';

        $currier_info = $this->Manage_price_model->get_curriers($carrier_id);

        if (empty($currier_info)) {

            $data['errors'] = 'Undefined currier.';
            echo json_encode($data);
            return false;
        }

        $currier_info = $currier_info[0];

        $pick_up = $this->Order_model->get_pickup_info($order_id);

        if (empty($pick_up)) {

            $data['errors'] = 'Order did not have pick up information.';
            echo json_encode($data);
            return false;
        }

        $delivery_info = $this->Order_model->get_delivery_info($order_id);

        if (empty($delivery_info)) {

            $data['errors'] = 'Order did not have delivery information.';
            echo json_encode($data);
            return false;
        }

        $country_info = $this->Users_model->get_countries($pick_up['pickup_country_id'], true);
        $country_info_2 = $this->Users_model->get_countries($delivery_info['delivery_country_id'], true);

        $data = [];

        if ($order_info['shipping_type'] == '2') {

            $table_name = strtolower($country_info['iso2'] . '_domestic');;

            if ($this->Order_model->check_carrier_service_isset($table_name, $carrier_id)) {

                $array = $this->csv_lib->get_config('Domestic');
                $array = $array['checking_array'];

                foreach ($array as $index => $single) {
                    $key = str_replace('_', ' ', $single);
                    $data[$key] = $key;
                }
            }

        } elseif ($order_info['shipping_type'] == '1' && $label == true) {

            $table_name = strtolower($country_info['iso2'] . '_domestic');;

            if ($this->Order_model->check_carrier_service_isset($table_name, $carrier_id)) {

                $array = $this->csv_lib->get_config('Domestic');
                $array = $array['checking_array'];

                foreach ($array as $index => $single) {
                    $key = str_replace('_', ' ', $single);
                    $data[$key] = $key;
                }
            }

        } elseif ($order_info['shipping_type'] == '1') {

            $table_name1 = strtolower($country_info['iso2'] . '_international_price');
            $table_name2 = strtolower($country_info_2['iso2'] . '_international_price');

            if ($this->Order_model->check_carrier_service_isset($table_name2, $carrier_id, 'express')) {
                $data['Inbound Express'] = 'inbound express';
            }
            if ($this->Order_model->check_carrier_service_isset($table_name2, $carrier_id, 'economy')) {
                $data['Inbound Economy'] = 'inbound economy';
            }

            if ($this->Order_model->check_carrier_service_isset($table_name1, $carrier_id, 'express')) {
                $data['Outbound Express'] = 'outbound express';
            }
            if ($this->Order_model->check_carrier_service_isset($table_name1, $carrier_id, 'economy')) {
                $data['Outbound Economy'] = 'outbound economy';
            }

        }

        $view_data = [
            'action' => 'service_type',
            'types' => $data
        ];

        if (!empty($ret)) {

            $this->load->view('frontend/orders/small_ajax_templates.php', $view_data);
            return false;
        }

        return $data;

    }

    public function ax_save_tracking_info($return = false, $cahnge_data = NULL)
    {

        if(!$return){
            if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
                show_404();
                return false;
            }
        }

        $this->load->library('shippo_lib');

        $this->check_admin_login();

        if(!$return){

            $order_id         = trim($this->security->xss_clean($this->input->post('order_id')));
            $carrier_id       = trim($this->security->xss_clean($this->input->post('carrier_id')));
            $user_id          = trim($this->security->xss_clean($this->input->post('user_id')));
            $sending_type     = trim($this->security->xss_clean($this->input->post('sending_type')));
            $trucking_numbers = $this->security->xss_clean($this->input->post('numbers'));
            $saturday         = $this->security->xss_clean($this->input->post('sat_delivery'));

        }elseif(!empty($cahnge_data)){

            $order_id         = $cahnge_data['order_id'];
            $carrier_id       = $cahnge_data['carrier_id'];
            $user_id          = $cahnge_data['user_id'];
            $sending_type     = $cahnge_data['sending_type'];
            $trucking_numbers = $cahnge_data['numbers'];
            $saturday         = $cahnge_data['sat_delivery'];

        }else{

            return false;
        }

        $trucking_numbers = json_decode($trucking_numbers);

        $data['errors'] = [];

        if (!$this->valid->is_id($order_id) || !$this->valid->is_id($carrier_id) || !$this->valid->is_id($user_id)) {

            if(!$return) {
                show_404();
            }

            return false;

        }


        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], TRANSIT_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {

            if(!$return) {
                show_404();
            }

            return false;
        }

        $temp_data = $this->Order_model->get_single_trucking_temp_info(NULL, $order_id);
        $label_files = $this->Order_model->get_order_files($order_id, 'label');

        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $luggages_count = count($order_luggages);

        $currier_info = $this->Manage_price_model->get_curriers($carrier_id);

        if (empty($currier_info)) {

            $data['errors'][] = 'Undefined currier.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        if (empty($trucking_numbers)) {

            $data['errors'][] = 'Please set all trucking numbers.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        $trucking_numbers = (object)array_filter( array_map('trim',(array)$trucking_numbers));

        if (count((array)$trucking_numbers) != $luggages_count) {
            $data['errors'][] = 'Please set all trucking numbers.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        if ((count($temp_data) + count($label_files)) < $luggages_count) {

            $data['errors'][] = 'Please upload all trucking labels.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        $currier_info = $currier_info[0];

        $web_hook_reg = true;

        foreach ($trucking_numbers as $key => $value) {

            $luggage = $this->Order_model->get_one_luggage_order($order_id, $key);

            if (empty($luggage)) {
                continue;
            }

            $temp_array[] = $value;

            if ($this->Order_model->trucking_number_in_use($value, $order_id)) {

                $data['errors'][] = 'Trucking number ' . $value . ' already set for another luggage.';

                if(!$return) {
                    echo json_encode($data);
                    return false;
                }else{
                    return $data;
                }

            }

            if ($luggage['tracking_number'] != $value) {
                $number_bool = true;
            }

            $update_numbers[] = [
                'id' => $luggage['id'],
                'tracking_number' => $value,
                'track_url' => NULL,
                'truck_id' => NULL
            ];


            if (!$this->shippo_lib->register_webhook($order_info['currier_name'], $value)) {

                $web_hook_reg = false;
            }

        }

        $this->Order_model->update_order($order_id, ['webhook_reg' => $web_hook_reg]);

        if ($saturday) {
            $sending_type = $sending_type . ' +Sat';
        }

        if ($order_info['currier_name'] != $currier_info['currier_name'] || $order_info['send_type'] != $sending_type) {

            if(stripos($sending_type, 'basic') !== FALSE && $order_info['shipping_type'] == '2'){

                $old_pickup_info       = $this->Order_model->get_pickup_info($order_info['id']);
                $zip_1                 = $old_pickup_info['pickup_postal_code'];
                $country               = $this->Users_model->get_countries($old_pickup_info['pickup_country_id'], true);
                $old_delivery_info     = $this->Order_model->get_delivery_info($order_info['id']);
                $zip_2                 = $old_delivery_info['delivery_postal_code'];

                $distance_and_zone = $this->price_lib->get_domestic_distance_and_zone($country, $zip_1, $zip_2);

                if(empty($distance_and_zone)){
                    $data['errors'][] = 'Can not update service type please try again.';

                    if(!$return) {
                        echo json_encode($data);
                        return false;
                    }else{
                        return $data;
                    }

                }

                $sending_type = str_ireplace('*', $distance_and_zone['days'], $sending_type);

            }

            $update_order = [
                'currier_name' => $currier_info['currier_name'],
                'send_type' => $sending_type,
                'currier_shippo_id' => $currier_info['shippo_id']
            ];

        }

        $temp_data = $this->Order_model->get_single_trucking_temp_info(NULL, $order_id);

        if (!empty($temp_data)) {

            foreach ($temp_data as $single) {

                if (!empty($single['file_name'])) {

                    $old_file = $this->Order_model->get_order_files($order_id, 'label', NULL, $single['luggage_id']);

                    if (!empty($old_file)) {
                        $this->ax_delete_label_file($order_id, $old_file['id']);
                    }

                    $file_data = [
                        'order_id' => $order_id,
                        'file_type' => 'label',
                        'file_name' => $single['file_name'],
                        'luggage_id' => $single['luggage_id']
                    ];

                    $this->Order_model->insert_order_file($file_data);

                }

            }

            $this->Order_model->delete_trucking_temp_info($order_id);

            $number_bool = true;

        }

        $this->Order_model->update_order_temp_info($order_id, ['tracking_save' => 0]);

        if (empty($update_order) && empty($number_bool)) {

            $data['errors'][] = 'You did not change anything';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        if (!empty($update_order) && empty($this->Order_model->update_order($order_id, $update_order))) {

            $data['errors'][] = 'Can not fill order information.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        if (!empty($update_numbers) && empty($this->Order_model->update_order_luggages_batch($update_numbers))) {

            $data['errors'][] = 'Can not fill trucking numbers.';

            if(!$return) {
                echo json_encode($data);
                return false;
            }else{
                return $data;
            }

        }

        $order_create_info = $this->price_lib->get_order_create_info($order_id);

        $delivery_update['delivery_date'] = $order_create_info['days'][$order_create_info['day_count']];

        $delivery_update['delivery_date'] = $delivery_update['delivery_date']['date'];

        $this->Order_model->update_delivery_info($delivery_update, $order_id);

        $this->Order_model->update_order($order_id, ['delivery_day_count' => $order_create_info['day_count']]);

        $pdf_result = $this->ax_create_label_pdf($order_id, true);

        if (!empty($pdf_result['errors'])) {

            $data['errors'][] = 'All data successfully updated but : ' . $pdf_result['errors'][0].' -> for label creating.';

        } else {

            $data['success'] = 'All data successfully updated.';
        }

        if (empty($return)) {

            $user_info = $this->Users_model->get_user_info($order_info['user_id']);

            $subject = 'Luggage To Ship: your shipping label is ready - ' . $order_info['order_id'];
            $subject_description = ' Hi ' . $user_info['first_name'] . " " . $user_info['last_name'] . ', your shipping label is ready, ' . $order_info['currier_name'] . ' tracking number: ' . $order_luggages[0]['tracking_number'] . '. Please find the print link in this email to print out the labels and instructions.  Thanks';
            $this->_send_email_variable($order_id, $order_info['user_id'], 'submit_tracking_only', $subject, $subject_description);

        }

        if(!$return) {
            echo json_encode($data);
            return true;
        }else{
            return $data;
        }

    }

    public function ax_save_temp_tracking_info()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->load->library('shippo_lib');

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $carrier_id = trim($this->security->xss_clean($this->input->post('carrier_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $sending_type = trim($this->security->xss_clean($this->input->post('sending_type')));
        $trucking_numbers = $this->security->xss_clean($this->input->post('numbers'));
        $trucking_numbers = json_decode($trucking_numbers);
        $saturday = $this->security->xss_clean($this->input->post('sat_delivery'));

        $data['errors'] = [];

        if (!$this->valid->is_id($order_id) || !$this->valid->is_id($carrier_id) || !$this->valid->is_id($user_id)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $currier_info = $this->Manage_price_model->get_curriers($carrier_id);

        if (empty($currier_info)) {

            $data['errors'] = 'Undefined currier.';
            echo json_encode($data);
            return false;
        }

        $currier_info = $currier_info[0];

        foreach ($trucking_numbers as $key => $value) {

            $luggage = $this->Order_model->get_one_luggage_order($order_id, $key);

            if (empty($luggage)) {
                continue;
            }

            if ($luggage['tracking_number'] != $value) {
                $number_bool = true;
            } else {
                continue;
            }

            $update_numbers[] = [
                'id' => $luggage['id'],
                'tracking_number' => $value,
            ];

        }


        $update_order = [
            'order_id' => $order_id,
            'shipping_carrier' => $currier_info['currier_name'],
            'trucking_service_type' => $sending_type,
            'tracking_save' => '1'
        ];


        $this->Order_model->update_or_insert_order_temp($update_order);

        if (!empty($update_numbers)) {
            $this->Order_model->update_or_insert_trucking_temp($update_numbers, $order_id);
        }

        $this->Order_model->update_order_temp_info($order_id, ['tracking_save' => 1]);

        $data['success'] = 'All data successfully saved.';
        echo json_encode($data);

    }


    public function ax_upload_order_files()
    {

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $doc_type = trim($this->security->xss_clean($this->input->post('doc_type')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $luggage_id = trim($this->security->xss_clean($this->input->post('luggage_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $data['errors'] = [];

        if (empty($_FILES)) {
            return false;
        }

        $patch = FCPATH . 'uploaded_documents/orders_files';

        if (!is_dir($patch)) {
            mkdir($patch, 0775, TRUE);
        }

        $patch = $patch . '/' . $order_id . '/';

        if (!is_dir($patch)) {
            mkdir($patch, 0775, TRUE);
        }


        $config['upload_path'] = $patch;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 10240;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        if($doc_type == 'fedex_second_label' && ($file_info['image_width'] < $file_info['image_height'])){

            $this->load->library('image_lib');

            $config['source_image'] = $file_info['full_path'];
            $config['rotation_angle'] = '90';

            $this->image_lib->initialize($config);

            if (!$this->image_lib->rotate()) {
                echo $this->image_lib->display_errors();
            }
        }


        $old_file = $this->Order_model->get_order_files($order_id, $doc_type);

        $file_types = $this->config->item('order_file_types');

        $file_data = [
            'order_id' => $order_id,
            'file_type' => $doc_type,
            'file_name' => $file_info['file_name'],
            'luggage_id' => $luggage_id
        ];

        if ($doc_type == 'label') {

            if ($file_info['image_width'] < $file_info['image_height']) {

                $this->load->library('image_lib');

                $config['source_image'] = $file_info['full_path'];
                $config['rotation_angle'] = '90';

                $this->image_lib->initialize($config);

                if (!$this->image_lib->rotate()) {
                    echo $this->image_lib->display_errors();
                }

            }

            $temp = [
                'luggage_id' => $luggage_id,
                'order_id' => $order_id,
                'file_name' => $file_info['file_name']
            ];

            $isset = $this->Order_model->check_isset_trucking_temp_info(['order_id' => $order_id, 'luggage_id' => $luggage_id]);

            if (!empty($isset)) {

                $this->Order_model->update_trucking_temp_info(['luggage_id' => $luggage_id], $temp);

            } else {

                $temp['trucking_number'] = NULL;
                $this->Order_model->insert_trucking_temp_info($temp);
            }

        } else {

            if (!empty($old_file) && !$file_types[$doc_type]['multiselect'] && count($old_file) == 1) {

                $this->ax_delete_label_file($order_id, $old_file[0]['id']);

                if(!$file_types[$doc_type]['multiselect']){

                    if (is_dir($patch.$old_file[0]['file_name'])) {
                        unlink($patch.$old_file[0]['file_name']);
                    }

                }

            }else if(!empty($old_file) && !$file_types[$doc_type]['multiselect']){

                foreach ($old_file as $single){

                    $this->ax_delete_label_file($order_id, $single['id']);

                    if(!$file_types[$doc_type]['multiselect']){
                        if (is_dir($patch.$single['file_name'])) {
                            unlink($patch . $single['file_name']);
                        }
                    }

                }
            }

            $this->Order_model->insert_order_file($file_data);

        }

        $this->Order_model->update_order($order_id, ['sys_label' => 0]);

        echo json_encode($data);

    }

    public function ax_admin_create_shipment()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $data['errors'] = [];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0]]);

        if (empty($order_info)) {

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        //if ($order_info['shipping_type'] == '1') {
//
        //    $data['errors'][] = 'For international order label auto creation not supported.';
        //    echo json_encode($data);
        //    return false;
//
        //}

        $result = $this->_create_shipment($order_id, $user_id);

        if (!empty($result['warnings'])) {
            $this->Order_model->insert_label_error($order_id, $result['warnings']);
        }

        if ($result['status'] != 'OK') {

            $this->Order_model->insert_label_error($order_id, $result['errors']);

            if (!empty($result['warnings'])) {
                $this->Order_model->insert_label_error($order_id, $result['warnings']);
            }

            $data['errors'] = $result['errors'];
            echo json_encode($data);
            return false;

        } else {

            $this->Order_model->update_order($order_id, ['sys_label' => 1]);

        }

        echo json_encode($data);

    }


    public function _create_shipment($order_id, $user_id)
    {

        $this->check_admin_login();

        $this->load->library('Shippo_lib');

        $responce = [
            'status' => 'OK',
            'errors' => [],
            'data' => []
        ];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if ($order_info['shipping_type'] == '1') {

            $customs_item = array(
                'description'=> 'T-Shirt',
                'quantity'=> '20',
                'net_weight'=> '1',
                'mass_unit'=> 'lb',
                'value_amount'=> '200',
                'value_currency'=> 'USD',
                'origin_country'=> 'US');

            $this->shippo_lib->set_custom_items($customs_item);

            $dec_options = [
                'certify' => 'true',
                'certify_signer' => 'Simon Kreuz'
            ];

            $declaration_result = $this->shippo_lib->create_custom_declaration($dec_options);

            if ($declaration_result['status'] != 'OK') {

                return $declaration_result;
            }

            //return $responce;
        }

        $this->load->library('Google_api');

        $sender_info = $this->Order_model->get_pickup_info($order_id);
        $receiver_info = $this->Order_model->get_delivery_info($order_id);
        $sender_country_info = $this->Users_model->get_countries($sender_info['pickup_country_id'], true);
        $receiver_country_info = $this->Users_model->get_countries($receiver_info['delivery_country_id'], true);
        $order_items = $this->Order_model->get_luggage_order($order_id);
        $sender_state_info = $this->Order_model->get_states_by_id($sender_info['pickup_state']);
        $receiver_state_info = $this->Order_model->get_states_by_id($receiver_info['delivery_state']);
        $orde_ins = $this->Order_model->get_incurance($order_id);

        $type = $this->_get_order_send_type($order_info['send_type'], $order_info['currier_name'], $order_info['shipping_type']);

        if (empty($sender_state_info)) {

            $google_info = $this->google_api->search_place($sender_info['pickup_state']);

            if (!empty($google_info)) {
                $sender_state_info = $google_info['address_components'][1]['short_name'];
            }

        } else {

            $sender_state_info = $sender_state_info['s_code'];
        }

        if (empty($receiver_state_info)) {

            $google_info = $this->google_api->search_place($receiver_info['delivery_state']);

            if (!empty($google_info)) {
                $receiver_state_info = $google_info['address_components'][1]['short_name'];
            }

        } else {

            $receiver_state_info = $receiver_state_info['s_code'];
        }

        $order_extra = [];

        $shipper = [
            'name' => $sender_info['sender_first_name'] . ' ' . $sender_info['sender_last_name'],
            'phone' => $sender_info['sender_phone'],
            'street1' => $sender_info['pickup_address1'],
            'city' => $sender_info['pickup_city'],
            'state' => $sender_state_info,
            'zip' => $sender_info['pickup_postal_code'],
            'country' => $sender_country_info['iso2'],
            'street2' => $sender_info['pickup_address2'],
            'email' => $sender_info['sender_email'],
            'company' => $sender_info['pickup_company']
        ];

        $receiver = [
            'name' => $receiver_info['receiver_first_name'] . ' ' . $receiver_info['receiver_last_name'],
            'phone' => $receiver_info['receiver_phone'],
            'street1' => $receiver_info['delivery_address1'],
            'city' => $receiver_info['delivery_city'],
            'state' => $receiver_state_info,
            'zip' => $receiver_info['delivery_postal_code'],
            'country' => $receiver_country_info['iso2'],
            'street2' => $receiver_info['delivery_address2'],
            'email' => $receiver_info['receiver_email'],
            'company' => $receiver_info['delivery_company']
        ];

        $order_extra['reference_1'] = 'LTS '.$order_info['order_id'];

        if (stripos($order_info['send_type'], '+sat') !== FALSE) {
            $order_extra['saturday_delivery'] = true;
        }

        $order_extra['signature_confirmation'] = 'STANDARD';
        //$order_extra['authority_to_leave'] = true;

        if (!empty($receiver_info['without_signature'])){
            unset($order_extra['signature_confirmation']);
        }

        foreach ($order_items as $single) {

            $data = array(
                'weight' => $single['label_weight'],
                'length' => $single['label_length'],
                'width' => $single['label_width'],
                'height' => $single['label_height'],
                'distance_unit' => 'in',
                'mass_unit' => 'lb',
                'metadata' => $single['id']
            );

            if (!empty($ins = $this->Order_model->get_luggage_insurance($single['id'])) && $order_info['shipping_type'] != '1') {

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

        if (!empty($orde_ins)) {

             $order_extra['COD'] = [
                 'payment_method' => 'SECURED_FUNDS',
                 'currency' => 'USD'
             ];

        } else {

             $order_extra['COD'] = [
                 'payment_method' => 'ANY',
                 'currency' => 'USD'
             ];
        }

        $this->shippo_lib->set_order_extra($order_extra);
        $create_check = $this->shippo_lib->set_address($shipper, $receiver);
        $items_check = $this->shippo_lib->set_percels($items);

        if ($create_check['status'] != 'OK') {

            return $create_check;
        }

        if ($items_check['status'] != 'OK') {

            return $items_check;
        }

        if ($order_info['shipping_type'] == '1') {

            $response = $this->shippo_lib->create_shipment($order_info['currier_shippo_id'], $type, $sender_info['shipping_date'], true);

        }else{

            $response = $this->shippo_lib->create_shipment($order_info['currier_shippo_id'], $type, $sender_info['shipping_date']);
        }

        if ($response['status'] != 'OK') {
            return $response;
        }

        $patch = FCPATH . 'uploaded_documents/orders_files';

        if (!is_dir($patch)) {
            mkdir($patch, 0775, TRUE);
        }

        $this->load->library('Label_lib');

        $web_hook_reg = true;
        $temp_data = [];

        foreach ($response['data']['transactions'] as $single) {

            $w_img = FCPATH . 'assets/images/label_logo.png';
            $label_img = $single['label_url'];

            $img_info = $this->label_lib->get_label_img($order_id, $single['tracking_number'], $label_img);

            if (empty($img_info)) {
                continue;
            }

            $label_img = $img_info['name'];

            //$this->label_lib->set_watermark($img_info['patch'], $w_img, $order_info['currier_name']);

            $this->load->library('image_lib');

            $config['source_image'] = $img_info['patch'];
            $config['rotation_angle'] = '90';

            $this->image_lib->initialize($config);

            $this->image_lib->rotate();

            $temp_data[] = [
                'id' => $single['id'],
                'tracking_number' => $single['tracking_number'],
                'file_name' => $label_img,
            ];

            if (!$this->shippo_lib->register_webhook($order_info['currier_name'], $single['tracking_number'])) {

                $web_hook_reg = false;
            }

        }

        $this->Order_model->update_or_insert_trucking_temp($temp_data, $order_id);

        $this->Order_model->update_order($order_id, ['webhook_reg' => $web_hook_reg]);

        return $response;

    }

    public function _get_order_send_type($type, $currier, $order_type)
    {

        $this->check_admin_login();

        $currier = strtolower($currier);
        $type = strtolower($type);
        $day = preg_replace('/[^0-9]+/', '', $type);

        //INTERNATIONAL

        if($order_type == '1'){

            if (stripos($type, 'express') !== FALSE) {

                $send = 'express';
            } else {

                $send = 'economy';
            }

            if (stripos($currier, 'fedex') !== FALSE) {

                $currier = 'fedex';

            } elseif (stripos($currier, 'dhl') !== FALSE) {

                $currier = 'dhl';
            }

            $return_data = [
                'fedex' => [
                    'express' => 'fedex_international_priority',
                    'economy' => 'fedex_international_economy',
                    'default' => 'fedex_international_economy'
                ],
                'dhl' => [
                    'express' => 'aaa',
                    'economy' => 'aaa',
                    'default' => 'bbbbb'
                ],
            ];

            if (!empty($return_data[$currier][$send])) {

                return $return_data[$currier][$send];
            }

            return $return_data[$currier]['default'];

        }


        // DOMESTIC

        if (stripos($type, 'basic') !== FALSE) {

            $send = 'basic';
        } else {

            $send = 'express';
        }

        if (stripos($type, 'morning') !== FALSE) {

            $dname = 'morning';
        } else {

            $dname = 'afternoon';
        }

        //if(stripos($type, '+sat') !== FALSE) {

        //    $dname = 'sat';
        //}

        if (stripos($currier, 'fedex') !== FALSE) {

            $currier = 'fedex';

        } elseif (stripos($currier, 'ups') !== FALSE) {

            $currier = 'ups';
        }

        $return_data = [
            'fedex' => [
                'express' => [
                    '1' => [
                        'morning' => 'fedex_priority_overnight',
                        'afternoon' => 'fedex_standard_overnight'
                    ],
                    '2' => [
                        'morning' => 'fedex_2_day_am',
                        'afternoon' => 'fedex_2_day',
                    ],
                    '3' => [
                        'morning' => 'no',
                        'afternoon' => 'fedex_express_saver'
                    ],
                ],
                'default' => 'fedex_ground'
            ],
            'ups' => [
                'express' => [
                    '1' => [
                        'morning' => 'ups_next_day_air',
                        'afternoon' => 'ups_next_day_air_saver'
                    ],
                    '2' => [
                        'morning' => 'ups_second_day_air_am',
                        'afternoon' => 'ups_second_day_air'
                    ],
                    '3' => [
                        'morning' => 'no',
                        'afternoon' => 'ups_3_day_select'
                    ],
                ],
                'default' => 'ups_ground'
            ]
        ];


        if (!empty($return_data[$currier][$send][$day][$dname])) {

            return $return_data[$currier][$send][$day][$dname];
        }

        return $return_data[$currier]['default'];

    }

    public function ax_upload_order_form_file()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }


        $order_info = $this->Order_model->get_submitted_order($user_id, $order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data['success'] = [];
        $data['errors'] = [];

        $files = $this->Order_model->get_order_form_document($order_id);

        if (count($files) >= 3) {

            $data['errors'][] = 'Sorry you can upload only 3 files';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url . $order_id . '/';

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

        $insert_data = [
            'user_id' => $user_id,
            'order_id' => $order_id,
            'show_file_name' => $file_info['client_name'],
            'file_name' => $file_info['file_name'],
            'add_date' => date('Y-m-d H:i:s')
        ];

        if (!$this->Order_model->insert_order_form_document($insert_data)) {

            $data['errors'][] = 'Can not insert file info';

        } else {

            $data['success'] = 'Document uploaded successfully.';

        }

        echo json_encode($data);

    }

    public function ax_save_order_passport_info()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $passport_number = trim($this->security->xss_clean($this->input->post('pas_number')));
        $country_id = trim($this->security->xss_clean($this->input->post('country_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        if ($order_info['order_type'] == 2) {

            $data['errors'][] = 'You cant set passport info for Commercial Use';
            echo json_encode($data);
            return false;
        }


        $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $url = $url . $order_id . '/';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        if (!empty($_FILES)) {

            foreach ($_FILES as $input_name => $single) {

                if ($input_name != 'passport_file' && $input_name != 'visa_file') {
                    continue;
                }

                $config['upload_path'] = $url;
                $config['allowed_types'] = 'pdf|jpg|jpeg';
                $config['max_size'] = 10240;
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

        }


        $passport_info = $this->Order_model->get_order_passport_info($order_id);

        if (empty($passport_info)) {

            $insert_data['user_id'] = $user_id;
            $insert_data['order_id'] = $order_id;
            $insert_data['passport_number'] = $passport_number;
            $insert_data['passport_country_id'] = $country_id;

            if (!$this->Order_model->insert_passport_info($insert_data)) {

                $data['errors'][] = 'Error filling data.';

                if (!empty($insert_data['passport_file'])) {
                    unlink($url . $insert_data['passport_file']);
                }
                if (!empty($insert_data['visa_file'])) {
                    unlink($url . $insert_data['visa_file']);
                }

            } else {

                $data['success'] = 'Data successfully saved.';
            }

            echo json_encode($data);
            return false;

        }

        $insert_data['passport_number'] = $passport_number;
        $insert_data['passport_country_id'] = $country_id;

        if (!$this->Order_model->update_order_passport_info($insert_data, $order_id)) {

            $data['errors'][] = 'Error filling data.';

        } else {

            if (file_exists($url . $passport_info['passport_file']) && !empty($insert_data['passport_file']) && !empty($passport_info['passport_file'])) {

                unlink($url . $passport_info['passport_file']);
            }

            if (file_exists($url . $passport_info['visa_file']) && !empty($insert_data['visa_file']) && !empty($passport_info['visa_file'])) {

                unlink($url . $passport_info['visa_file']);
            }

            $data['success'] = 'Data successfully saved.';
        }

        echo json_encode($data);
        return false;

    }

    public function ax_delete_passport_file()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $file_name = trim($this->security->xss_clean($this->input->post('file_name')));
        $type_name = trim($this->security->xss_clean($this->input->post('type_name')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        if (empty($order_id) || empty($file_name)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            $data['errors'][] = 'Invalid information';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/' . $order_id . '/' . $file_name;

        if (file_exists($url)) {

            unlink($url);
        }

        $update_data = [$type_name => NULL];

        if (!$this->Order_model->update_order_passport_info($update_data, $order_id)) {

            $data['errors'][] = 'Error filling data.';
            echo json_encode($data);
            return false;
        }


        $data['success'] = 'Data successfully saved.';

        echo json_encode($data);

    }

    public function user_file($file_name, $order_id, $user_id)
    {

        $this->check_admin_login();

        if (empty(trim($order_id)) || empty(trim($file_name))) {

            show_404();
            return false;
        }

        $file_path = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/' . $order_id . '/' . $file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

       /* header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
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

    public function ax_save_travel_itinerary()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $arriving_by = intval($this->security->xss_clean($this->input->post('arriving_by')));
        $arrival_city = trim($this->security->xss_clean($this->input->post('arrival_city')));
        $arrival_date = trim($this->security->xss_clean($this->input->post('arrival_date')));
        $arrival_ticked_number = trim($this->security->xss_clean($this->input->post('arrival_ticked_number')));
        $arrival_cruise_name = trim($this->security->xss_clean($this->input->post('arrival_cruise_name')));
        $leaving_by = intval($this->security->xss_clean($this->input->post('leaving_by')));
        $departure_city = trim($this->security->xss_clean($this->input->post('departure_city')));
        $departure_date = trim($this->security->xss_clean($this->input->post('departure_date')));
        $ticked_number = trim($this->security->xss_clean($this->input->post('ticked_number')));
        $departure_cruise_name = trim($this->security->xss_clean($this->input->post('departure_cruise_name')));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));


        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        if ($order_info['order_type'] == 2) {

            $data['errors'][] = 'You cant set travel itinerary for Commercial Use';
            echo json_encode($data);
            return false;
        }


        if ($leaving_by > 3 || $leaving_by < 0 || $arriving_by > 3 || $arriving_by < 0) {

            $data['errors'][] = 'Incorrect information.';
            echo json_encode($data);
            return false;
        }

        $insert_array = [
            'user_id' => $user_id,
            'order_id' => $order_id,
            'arriving_by' => $arriving_by,
            'arrival_city' => $arrival_city,
            'arrival_date' => $arrival_date,
            'arrival_ticked_number' => $arrival_ticked_number,
            'arrival_cruise_name' => $arrival_cruise_name,
            'leaving_by' => $leaving_by,
            'departure_city' => $departure_city,
            'departure_date' => $departure_date,
            'ticked_number' => $ticked_number,
            'departure_cruise_name' => $departure_cruise_name
        ];

        $trav_info = $this->Order_model->get_travel($order_id, $user_id);

        if (empty($trav_info)) {

            if (!$this->Order_model->insert_trav_info($insert_array)) {
                $data['errors'][] = 'Error filling data to database';
                echo json_encode($data);
                return false;
            }

        } else {

            unset($insert_array['order_id']);
            unset($insert_array['user_id']);

            if (!$this->Order_model->update_trav_info($insert_array, $order_id)) {
                $data['errors'][] = 'Error update data';
                echo json_encode($data);
                return false;
            }

        }

        if (!empty($_FILES)) {

            $files = $this->Order_model->get_travel_files($order_id);

            if (count($files) >= 3) {

                $data['errors'][] = 'Sorry you can upload only 3 files';
                echo json_encode($data);
                return false;
            }

            $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/';

            if (!is_dir($url)) {
                mkdir($url, 0775, TRUE);
            }

            $url = $url . $order_id . '/';

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
                'user_id' => $user_id,
                'order_id' => $order_id,
                'client_name' => $file_info['client_name'],
                'file_name' => $file_info['file_name']
            ];

            if (!$this->Order_model->insert_itinerary_files($insert_file_info)) {

                $data['errors'][] = 'Error filling data to database';
                echo json_encode($data);
                return false;
            }

        }// end file upload


        $data['success'] = 'Data successfully saved';
        echo json_encode($data);

    }

    public function ax_delete_itineary_files()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $file_id = trim($this->security->xss_clean($this->input->post('file_id')));

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (!$this->valid->is_id($file_id)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_submitted_order($user_id, $order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $file_info = $this->Order_model->get_travel_files($order_id, NULL, $file_id);

        if (empty($file_info)) {

            $data['errors'][] = 'Undefined file.';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH . 'uploaded_documents/' . $user_id . '/orders_documents/' . $order_id . '/' . $file_info[0]['file_name'];

        if (file_exists($url)) {

            if (unlink($url)) {
                $remove = true;
            } else {
                $remove = false;
            }
        } else {

            $remove = true;
        }

        if ($remove) {

            $this->Order_model->delete_itinerary_document($order_id, $file_id);
        } else {

            $data['errors'][] = 'Can not remove document';
        }

        $data['success'] = 'Document has been deleted';

        echo json_encode($data);

    }

    public function ax_save_shedule_pick_up($return = false, $changing_data = NULL)
    {

        $this->check_admin_login();

        if(!$return){
            if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

                show_404();
                return false;
            }
        }

        $data['errors'] = [];
        $data['success'] = '';

        if(!$return){

            $order_id     = trim($this->security->xss_clean($this->input->post('order_id')));
            $user_id      = trim($this->security->xss_clean($this->input->post('user_id')));
            $pick_up_date = trim($this->security->xss_clean($this->input->post('pick_up_date')));
            $time_from    = trim($this->security->xss_clean($this->input->post('time_from')));
            $time_to      = trim($this->security->xss_clean($this->input->post('time_to')));
            $con          = trim($this->security->xss_clean($this->input->post('con')));

        }elseif(!empty($changing_data)) {

            $order_id     = $changing_data['order_id'];
            $user_id      = $changing_data['user_id'];
            $pick_up_date = $changing_data['pick_up_date'];
            $time_from    = $changing_data['time_from'];
            $time_to      = $changing_data['time_to'];
            $con          = $changing_data['con'];

        }else{

            return false;
        }


        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], TRANSIT_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {

            if(!$return){
                show_404();
            }
            return false;
        }

        $order_create_info = $this->price_lib->get_order_create_info($order_id, $pick_up_date);

        if (empty($order_create_info)) {

            if(!$return){
                show_404();
            }
            return false;
        }

        $pick_up_info = $order_create_info['pickup_info'];

        if (empty($pick_up_date)) {
            $data['errors'][] = 'Please set Pick up Date';
        }

        if (empty($con)) {
            $data['errors'][] = 'Please set Pick up Con#';
        }

        if (!empty($data['errors'])) {

            if(!$return){

                echo json_encode($data);
                return false;

            }else{
                return $data;
            }

        }

        $update_data = [
            'order_id' => $order_id,
            'date' => $pick_up_date,
            'time_from' => $time_from,
            'time_to' => $time_to,
            'con' => $con,
            'old_pick_up' => $pick_up_info['shipping_date'] . '/' . $pick_up_info['pickup_time']
        ];

        $old_data = $this->Order_model->get_shedule_pick_up($order_id);

        $changes = true;

        if (!empty($old_data)) {

            $data_dublicate = $update_data;
            unset($data_dublicate['old_pick_up']);
            $changes = $this->check_changing_array($old_data, $data_dublicate);

        }

        if (!$changes) {

            $data['errors'][] = 'You did not change anything.';
            if(!$return){

                echo json_encode($data);
                return false;

            }else{
                return $data;
            }

        }

        if (empty($old_data)) {

            if (!$this->Order_model->insert_shedule_pick_up($update_data)) {
                $data['errors'][] = 'Can not fill data to database.';
            }

        } else {

            unset($update_data['order_id']);

            if (!empty($old_data['old_pick_up'])) {
                unset($update_data['old_pick_up']);
            }

            if (!$this->Order_model->update_shedule_pick_up($order_id, $update_data)) {
                $data['errors'][] = 'Can not update data to database.';
            }
        }

        if (!empty($data['errors'])) {
            if(!$return){

                echo json_encode($data);
                return false;

            }else{
                return $data;
            }
        }

        $this->Order_model->update_order_temp_info($order_id, ['pickup_save' => 0]);

        $pick_up_info = $this->Order_model->get_pickup_info($order_id);

        $pick_up_price = $this->_get_pick_up_fee($pick_up_info['pickup_country_id'], $order_id, $pick_up_info['shipping_date']);

        $update_data = [
            'pick_up' => '2',
            'pickup_time' => $time_from . ' to ' . $time_to,
            'pickup_price' => $pick_up_price,
            'shipping_date' => $pick_up_date
        ];

        $delivery_update['delivery_date'] = $order_create_info['days'][$order_create_info['day_count']];
        $delivery_update['delivery_date'] = $delivery_update['delivery_date']['date'];

        $this->Order_model->update_pickup_info($update_data, $order_id);
        $this->Order_model->update_delivery_info($delivery_update, $order_id);

        if (empty($data['errors'])) {
            $data['success'] = 'Data successfully saved.';
        }

        if (empty($return)) {
            $user_info = $this->Users_model->get_user_info($order_info['user_id']);
            $subject = 'Your pick up is scheduled - ' . $order_info['order_id'];
            $subject_description = 'Hi '. $user_info['first_name'] . " " . $user_info['last_name'] .', we have scheduled a pick up for your shipment. Pick up date: <pick up date>, pick up time: <pick up time>. Please check this email for detailed pick up information. Thanks.';
            $this->_send_email_variable($order_id, $order_info['user_id'], 'submit_pickup_only', $subject,$subject_description);
        }

        if(!$return){

            echo json_encode($data);
            return false;

        }else{

            return $data;
        }

    }


    public function ax_save_pick_up_temp()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $pick_up_date = trim($this->security->xss_clean($this->input->post('pick_up_date')));
        $time_from = trim($this->security->xss_clean($this->input->post('time_from')));
        $time_to = trim($this->security->xss_clean($this->input->post('time_to')));
        $con = trim($this->security->xss_clean($this->input->post('con')));

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        if (empty($pick_up_date)) {
            $data['errors'][] = 'Please set Pick up Date';
        }

        if (empty($con)) {
            $data['errors'][] = 'Please set Pick up Con#';
        }

        if (!empty($data['errors'])) {
            echo json_encode($data);
            return false;
        }

        $pick_up_data = [
            'order_id' => $order_id,
            'date' => $pick_up_date,
            'time_from' => $time_from,
            'time_to' => $time_to,
            'con' => $con,
            'pickup_save' => '1'
        ];

        if (!$this->Order_model->update_or_insert_order_temp($pick_up_data)) {

            $data['errors'][] = 'Can not fill data to database.';
        } else {

            $data['success'] = 'Data successfully saved.';
        }

        echo json_encode($data);

    }

    public function ax_save_label_shipment($return = false, $changing_data = NULL)
    {

        $this->check_admin_login();

        if(!$return){
            if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

                show_404();
                return false;
            }
        }

        $data['errors'] = [];
        $data['success'] = '';


        if(!$return){

            $order_id        = trim($this->security->xss_clean($this->input->post('order_id')));
            $user_id         = trim($this->security->xss_clean($this->input->post('user_id')));
            $shipping_date   = trim($this->security->xss_clean($this->input->post('shipping_date')));
            $delivery_date   = trim($this->security->xss_clean($this->input->post('delivery_date')));
            $trucking_number = trim($this->security->xss_clean($this->input->post('trucking_num')));
            $currier_id      = trim($this->security->xss_clean($this->input->post('label_carrier')));
            $type            = trim($this->security->xss_clean($this->input->post('service_type')));

        }elseif(!empty($changing_data)){

            $order_id        = $changing_data['order_id'];
            $user_id         = $changing_data['user_id'];
            $shipping_date   = $changing_data['shipping_date'];
            $delivery_date   = $changing_data['delivery_date'];
            $trucking_number = $changing_data['trucking_num'];
            $currier_id      = $changing_data['label_carrier'];
            $type            = $changing_data['service_type'];

        }else{

            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], TRANSIT_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {

            if(!$return){

                show_404();
                return false;

            }else{

                return false;;
            }

        }

        if (empty($shipping_date)) {
            $data['errors'][] = 'Plead set shipping date.';
        }

        if (empty($delivery_date)) {
            $data['errors'][] = 'Plead set delivery date.';
        }

        if (empty($currier_id)) {
            $data['errors'][] = 'Plead set Csrrier.';
        }

        if (empty($type)) {
            $data['errors'][] = 'Plead set service type.';
        }

        if (!empty($data['errors'])) {

            if(!$return){

                echo json_encode($data);
                return false;

            }else{

                return $data;;
            }

        }

        $update_data = [
            'order_id' => $order_id,
            'shipping_date' => $shipping_date,
            'delivery_date' => $delivery_date,
            'carrier_id' => $currier_id,
            'tracking_number' => $trucking_number,
            'shipping_type' => $type,
            'viewed' => '1'
        ];

        $old_data = $this->Order_model->get_label_shipment($order_id, false);

        if (!empty($old_data)) {

            $data_dublicate = $update_data;
            unset($data_dublicate['viewed']);


        }

        if (empty($old_data)) {

            if (!$this->Order_model->insert_label_shipment($update_data)) {

                $data['errors'] = 'Can not fill data to database.';
            }

        } else {

            unset($update_data['order_id']);
            if (!$this->Order_model->update_label_shipment($order_id, $update_data)) {

                $data['errors'] = 'Can not update data to database.';
            }
        }

        if (empty($data['errors'])) {

            $data['success'] = 'Data successfully saved.';

        }else{

            if(!$return){

                echo json_encode($data);
                return false;

            }else{

                return $data;;
            }

        }

        $this->Order_model->update_order_temp_info($order_id, ['label_save' => 0]);

        if (empty($return)) {
            $user_info = $this->Users_model->get_user_info($order_info['user_id']);
            $subject = 'We are sending you an envelope with shipping labels and pouches ' . $order_info['order_id'];
            $subject_description = 'Hi ' . $user_info['first_name'] . " " . $user_info['last_name'] . ', we are sending you an envelope with shipping labels, instructions and pouches.  Please check this email for detailed information. Thanks';
            $this->_send_email_variable($order_id, $order_info['user_id'], 'submit_tag_only', $subject,$subject_description);
        }

        if(!$return){

            echo json_encode($data);
            return true;

        }else{

            return $data;;
        }

    }

    public function ax_save_label_shipment_temp()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = '';

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $shipping_date = trim($this->security->xss_clean($this->input->post('shipping_date')));
        $delivery_date = trim($this->security->xss_clean($this->input->post('delivery_date')));
        $trucking_number = trim($this->security->xss_clean($this->input->post('trucking_num')));
        $currier_id = trim($this->security->xss_clean($this->input->post('label_carrier')));
        $type = trim($this->security->xss_clean($this->input->post('service_type')));

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0], READY_STATUS[0]]);

        if (empty($order_info)) {

            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if (empty($shipping_date)) {
            $data['errors'][] = 'Please set shipping date.';
        }

        if (empty($delivery_date)) {
            $data['errors'][] = 'Please set delivery date.';
        }

        if (empty($currier_id)) {
            $data['errors'][] = 'Please set Carrier.';
        }

        if (empty($type)) {
            $data['errors'][] = 'Please set service type.';
        }


        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;
        }

        $update_data = [
            'order_id' => $order_id,
            'user_id' => $user_id,
            'shipping_date' => $shipping_date,
            'delivery_date' => $delivery_date,
            'carrier_id' => $currier_id,
            'shipping_type' => $type,
            'tracking_number' => $trucking_number,
            'label_save' => '1'
        ];

        if (!$this->Order_model->update_or_insert_order_temp($update_data)) {

            $data['errors'][] = 'Can not fill data to database.';
        } else {

            $data['success'] = 'Data successfully saved.';
        }

        echo json_encode($data);

    }

    private function label_address_dif_check($order_id)
    {

        $label = $this->Order_model->get_delivery_label($order_id);
        $address = $this->Order_model->get_pickup_info($order_id);

        if (empty($address)) {
            return true;
        }

        if (empty($label['address1']) && empty($label['phone']) && empty($label['postal_code']) && empty($label['city'])) {
            return true;
        }

        $checking_array = [
            'sender_phone' => 'phone',
            'pickup_address1' => 'address1',
            'pickup_address2' => 'address2',
            'pickup_postal_code' => 'postal_code',
            'pickup_city' => 'city',
            'pickup_country_id' => 'country_id',
            'sender_email' => 'email',
            'sender_first_name' => 'last_name',
            'sender_last_name' => 'first_name',
        ];

        foreach ($checking_array as $address_key => $label_key) {

            if ($address[$address_key] != $label[$label_key]) {
                return false;
            }
        }

        return true;

    }


    public function ax_delivery_label_view()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $data['country'] = "";
        $data['delivery_info'] = [];
        $data['state'] = "";
        $data['order_info'] = $order_info;
        $delivery_label = $this->Order_model->get_delivery_label($order_id);

        if (!empty($delivery_label)) {

            $data['delivery_info'] = $delivery_label;
        }
        $country = $this->Users_model->get_countries($delivery_label['country_id']);

        if (!empty($country[0]['country'])) {

            $data['country'] = $country[0]['country'];

        }

        $state = $this->Order_model->get_states_by_id($delivery_label['state_id']);

        if (!empty($state)) {

            $data['state'] = $state['State'];
        }

        $this->load->view('frontend/orders/label_delivery_view', $data);

    }

    public function _get_order_from_status($status_array, $action, $get_data, $page = NULL, $status_name, $order_by = NULL)
    {

        $this->check_admin_login();

        if (empty($status_array) || !is_array($status_array)) {

            show_404();
            return false;
        }

        if (!is_numeric($page) || $page <= 0) {

            $page = 1;

        }

        $search_data_in_view = [
            'order_id' => '',
            'first_name' => '',
            'email' => ''
        ];

        $search_data = [
            'order_shipping.order_id' => '',
            'users.first_name' => '',
            'users.email' => ''
        ];

        $search_fields = [
            'order_id',
            'first_name',
            'email'
        ];

        if (!empty($get_data)) {

            foreach ($get_data as $item => $value) {

                if (in_array($item, $search_fields)) {

                    $search_data_in_view[$item] = $value;
                }

            }

            foreach ($search_data as $index => $value) {

                $exp_index = explode('.', $index);

                if (array_intersect($search_data, $search_data_in_view)) {

                    $search_data[$index] = $search_data_in_view[$exp_index[1]];
                }
            }
        }

        $or_where = '';
        $crt = NULL;

        if ($action == 'new_order') {
            $or_where = [
                'order_shipping.shipping_status' => SUBMITTED_CANCEL_STATUS[0],
                'order_shipping.status_change_by' => '0',
            ];
        }

        if ($action == 'processed_order') {
            $or_where = [
                'order_shipping.shipping_status' => PROCESSED_CANCEL_STATUS[0],
                'order_shipping.status_change_by' => '0',
            ];
        }

        if ($action == 'delivered_canceled') {
            $or_where = '`order_shipping.status_change_by` = "1" AND (`order_shipping.shipping_status` = "' . SUBMITTED_CANCEL_STATUS[0] . '" OR `order_shipping.shipping_status` = "' . PROCESSED_CANCEL_STATUS[0] . '")';
        }

        if (!empty($this->input->get('order_type'))) {
            $type = $this->input->get('order_type');
            $type = ($type == 1) ? 1 : 2;
            $crt['order_shipping.shipping_type'] = $type;
        }

        $row_count = $this->order_count;
        $all_count = $this->Dashboard_model->all_get_count_order($status_array, $search_data, $or_where, $crt);

        $limit = [$row_count, ($page - 1) * $row_count];
        $all_orders = $this->Dashboard_model->get_all_order("", $limit, $status_array, $search_data, $or_where, $crt, NULL, $order_by);

        foreach ($all_orders as $index => $orders) {

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);
            $all_orders[$index]['user_info'] = $this->return_user_info($orders['user_id']);
            $all_orders[$index]['order_price'] = $this->price_lib->get_order_fee($orders['real_id'], $orders['user_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if (!empty($order_luggage['tracking'])) {

                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if (!empty($pickup_state['State'])) {
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if (!empty($delivery_state['State'])) {
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $type_files = $this->Order_model->get_order_files($orders['real_id'], 'label');

            if (!empty($type_files)) {

                $data['type_files'][$orders['real_id']][] = $type_files;
            }

            if (!empty($order_luggage['count'])) {

                $all_orders[$index]['luggage_count'] = $order_luggage['count'];
            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);

            $label_check = $this->label_address_dif_check($orders['real_id']);
            $all_orders[$index]['label_check'] = $label_check;

            if ($action == 'in_transit_order') {

                $notes_info = $this->Order_model->get_transit_order_notes($orders['real_id']);

                $all_orders[$index]['notes'] = '';

                if (!empty($notes_info['message'])) {
                    $all_orders[$index]['notes'] = $notes_info['message'];
                }
            }

            if ($action == 'delivered_canceled') {

                $all_orders[$index]['luggages'] = $this->Order_model->get_luggage_order($orders['real_id']);
                $crt = ['user_id' => $orders['user_id']];
                $all_orders[$index]['charge_payment'] = $this->Order_model->get_pay_history($orders['real_id'], $crt);
                $final_billing_info = NULL;

                $charge = $this->Billing_model->check_last_billing($orders['real_id']);

                if ($charge['next'] != 'initial' && $charge['next'] != 'estimate') {

                    $final_billing_info = $this->_get_order_final_billing_info($orders['real_id'], $orders['user_id']);
                }

                $all_orders[$index]['final_billing_info'] = $final_billing_info;

            }


        }

        // Initialize pagination config
        $config['base_url'] = base_url('admin/order/') . $action;
        $config['suffix'] = '/?' . $this->input->server('QUERY_STRING');
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_count;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li><a href="" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_url'] = base_url('admin/order/') . $action . '/?' . $this->input->server('QUERY_STRING');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'order_list');
        $config['use_page_numbers'] = TRUE;


        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data["link"] = $this->pagination->create_links();
        $data['action'] = $action;
        $data['all_orders'] = $all_orders;
        $data['order_name'] = $status_name;
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['cr'] = $search_data_in_view;
        /*$data['status_array'] = $this->config->item('status_array');*/
        $data['order_count'] = $this->order_count;
        $data['all_count'] = $all_count;
        return $data;

    }

    public function new_order($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [SUBMITTED_STATUS[0], SUBMITTED_CANCEL_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'new_order', $get_data, $page, 'New', ['pick_up_info.shipping_date', 'DESC']);
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);

    }

    public function uncompeted_order($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [INCOMPLETE_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'uncompeted_order', $get_data, $page, 'Incomplete order');
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);

    }

    public function processed_order($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [PROCESSED_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'processed_order', $get_data, $page, 'Processed', ['pick_up_info.shipping_date', 'DESC']);

        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);

    }

    public function ready_order($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [READY_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'ready_order', $get_data, $page, 'Ready', ['pick_up_info.shipping_date', 'DESC']);
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);
    }

    public function in_transit_order($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [TRANSIT_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'in_transit_order', $get_data, $page, 'In Transit', ['delivery_info.delivery_date', 'DESC']);
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);
    }

    public function delivered_canceled($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [DELIVERY_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'delivered_canceled', $get_data, $page, 'Delivered & Canceled');
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);
    }

    public function order_history($page = NULL)
    {

        $this->check_admin_login();

        $status_array = [CLOSED_STATUS[0], SUBMITTED_CANCEL_STATUS[0]];

        $get_data = $this->input->get();

        $data_info = $this->_get_order_from_status($status_array, 'order_history', $get_data, $page, 'Order History');
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        $data = array_merge($data_info, $data);

        $data['content'] = 'backend/admin/order/status_order';
        $this->load->view('backend/back_template', $data);
    }

    public function _return_luggage_order($order_id)
    {

        $this->check_admin_login();

        if (empty($order_id)) {

            return false;
        }

        $return_data = [];

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        if (empty($order_luggages)) {

            return false;
        }

        $total_weight = 0;

        foreach ($order_luggages as $index => $luggage) {

            $total_weight += floatval($luggage['charge_weight']);
        }

        $return_data['count'] = count($order_luggages);
        $return_data['total_weight'] = $total_weight;
        return $return_data;

    }

    public function return_luggage_count($order_id)
    {

        $this->check_admin_login();

        if (empty($order_id)) {

            return false;
        }

        $return_data = [];
        $data = [];

        $order_luggage = $this->Order_model->get_luggage_order($order_id);

        if (empty($order_luggage)) {

            return false;

        }

        foreach ($order_luggage as $luggage) {

            if (!empty($return_data[$luggage['type_name']][$luggage['luggage_name']])) {

                $return_data[$luggage['type_name']][$luggage['luggage_name']] += 1;

            } else {

                $return_data[$luggage['type_name']][$luggage['luggage_name']] = 1;
            }

            if (!empty($luggage['tracking_number'])) {

                $data[] = [
                    'tracking_number' => $luggage['tracking_number'],
                    'status_detail' => $luggage['status_detail'],
                    'shipping_status' => $luggage['shipping_status'],
                    'luggage_id' => $luggage['id']
                ];

            }
        }

        return ['count' => $return_data, 'tracking' => $data];

    }

    public function return_user_info($user_id)
    {

        $this->check_admin_login();

        if (empty($user_id)) {

            return false;
        }

        $search_data = ['id' => $user_id];

        $user_info = $this->Users_model->search_users($search_data);

        if (empty($user_info)) {

            return false;
        }

        return $user_info;
    }

    public function ax_get_trucking_history()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $trucking_info = trim($this->security->xss_clean($this->input->post('truck_inf')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $info_array = explode('_', $trucking_info);

        if (count($info_array) != 3) {
            show_404();
            return false;
        }

        $order_id = $info_array[0];
        $luggaeg_id = $info_array[1];
        $trucking_number = $info_array[2];

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $luggage_info = $this->Order_model->get_one_luggage_order($order_id, $luggaeg_id);

        if (empty($luggage_info)) {
            show_404();
            return false;
        }

        if ($luggage_info['tracking_number'] != $trucking_number) {
            show_404();
            return false;
        }

        $this->load->library('Shippo_lib');

        $carrier_name = $this->shippo_lib->get_carrier_name_for_shipo($order_info['currier_name']);

        $data = [
            'errors' => [],
            'info' => []
        ];

        if (empty($carrier_name)) {

            $data['errors'][] = 'No data.';
            $this->load->view('frontend/orders/trucking_history_template.php', $data);
            return false;
        }

        if (!is_array($carrier_name)) {

            $result = $this->shippo_lib->get_trucking_status($trucking_number, $carrier_name);

        } else {

            foreach ($carrier_name as $single_name) {

                $result = $this->shippo_lib->get_trucking_status($trucking_number, $single_name);

                if (!empty($result['status'])) {
                    break;
                }

            }
        }

        if (!empty($result['data']['current_status'])) {

            $current = $result['data']['current_status'];

            if (!empty($current->status)) {

                $insert_status = NULL;

                if ($current->status == 'TRANSIT') {

                    $insert_status = TRANSIT_STATUS[0];

                } elseif ($current->status == 'FAILURE') {

                    $insert_status = TRANSIT_STATUS[0];

                } elseif ($current->status == 'DELIVERED') {

                    $insert_status = DELIVERY_STATUS[0];
                }

                $luggage_info = $this->Order_model->get_luggage_info_by_number($trucking_number);

                if (empty($luggage_info)) {
                    return false;
                }

                $update_luggage_data = [
                    'shipping_status' => $insert_status,
                    'status_detail' => date('M-d-Y') . ' ' . $current->status_details
                ];

                $crt = [
                    'tracking_number' => $trucking_number
                ];

                $this->Order_model->update_luggage_info_crt($update_luggage_data, $crt);

                $this->check_and_change_order_status($order_id);

            }

        }

        if (empty($result['data']['trucking_history'])) {

            $data['errors'][] = 'No data.';

        } else {

            $data['info'] = $result;
        }

        $this->load->view('frontend/orders/trucking_history_template.php', $data);

    }

    public function ax_get_label_trucking()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $this->load->library('Shippo_lib');

        $data = [
            'errors' => [],
            'info' => []
        ];

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $label_shipment = $this->Order_model->get_label_shipment($order_id);

        if (empty($label_shipment)) {

            $data['errors'][] = 'No data.';
            $this->load->view('frontend/orders/trucking_history_template.php', $data);
            return false;
        }

        $currier_info = $this->Manage_price_model->get_curriers($label_shipment['carrier_id']);
        $trucking_number = $label_shipment['tracking_number'];

        if (empty($currier_info) || empty($trucking_number)) {

            $data['errors'][] = 'No data.';
            $this->load->view('frontend/orders/trucking_history_template.php', $data);
            return false;
        }

        $carrier_name = $this->shippo_lib->get_carrier_name_for_shipo($currier_info[0]['currier_name']);

        if (empty($carrier_name)) {

            $data['errors'][] = 'No data.';
            $this->load->view('frontend/orders/trucking_history_template.php', $data);
            return false;
        }

        if (!is_array($carrier_name)) {

            $result = $this->shippo_lib->get_trucking_status($trucking_number, $carrier_name);

        } else {

            foreach ($carrier_name as $single_name) {

                $result = $this->shippo_lib->get_trucking_status($trucking_number, $single_name);

                if (!empty($result['status'])) {
                    break;
                }

            }
        }

        if (empty($result['data']['trucking_history'])) {

            $data['errors'][] = 'No data.';

        } else {

            $data['info'] = $result;
        }

        $this->load->view('frontend/orders/trucking_history_template.php', $data);

    }

    private function check_and_change_order_status($order_id)
    {

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        if (empty($order_luggages)) {
            return false;
        }

        $count = count($order_luggages);
        $statuses = [];

        foreach ($order_luggages as $single_luggage) {

            if (empty($single_luggage['shipping_status'])) {
                continue;
            }

            if (empty($statuses[$single_luggage['shipping_status']])) {
                $statuses[$single_luggage['shipping_status']] = 1;
            } else {
                $statuses[$single_luggage['shipping_status']] += 1;
            }

        }

        foreach ($statuses as $status => $count_of_status) {
            if ($count_of_status == $count) {
                $this->Order_model->change_order_status($order_id, $status);
                break;
            }
        }

        return true;

    }

    public function _get_pick_up_fee($country_id, $order_id, $shipping_date)
    {

        $this->check_admin_login();

        $result = $this->Order_model->get_pick_up_fee($country_id);
        $order = $this->Order_model->get_order_info($order_id);

        if (empty($order)) {
            return false;
        }

        if ($order['shipping_type'] == 1) {

            $ret = 'international';

        } else {

            if (stripos($order['shipping_type'], 'basic') !== false) {

                $ret = 'domestic_basic';

            } else {

                $ret = 'domestic_express';

            }

        }

        if (date('w', strtotime($shipping_date)) == 6) {
            $ret = 'saturday_pickup';
        }

        if (empty($result[$ret])) {
            return 0;
        }

        return $result[$ret];

    }

    public function create_label_shipment()
    {

        $this->check_admin_login();

        $this->load->library('Google_api');

        $order_id = $this->input->post('order_id');
        $user_id = $this->input->post('user_id');

        $data['errors'] = [];
        $data['success'] = '';

        if (!$this->valid->is_id($user_id)) {
            $data['errors'][] = 'Incorrect user id';
            echo json_encode($data);
            return false;
        }

        if (!$this->valid->is_id($order_id)) {
            $data['errors'][] = 'Incorrect order id';
            echo json_encode($data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id, [INCOMPLETE_STATUS[0], SUBMITTED_STATUS[0], PROCESSED_STATUS[0]]);

        if (empty($order_info)) {
            $data['errors'][] = 'Undefined order';
            echo json_encode($data);
            return false;
        }

        $receiver_info = $this->Order_model->get_pickup_info($order_id);
        $receiver_country_info = $this->Users_model->get_countries($receiver_info['pickup_country_id'], true);
        $receiver_state_info = $this->Order_model->get_states_by_id($receiver_info['pickup_state']);
        $label_shipment = $this->Order_model->get_label_shipment($order_id);
        $temp_info = $this->Order_model->get_order_temp_info($order_id);
        $delivery_label = $this->Order_model->get_delivery_label($order_id);

        if (empty($label_shipment['shipping_date']) && empty($temp_info)) {
            $data['errors'][] = 'Please insert shipping date.';
            echo json_encode($data);
            return false;
        }

        if (!empty($temp_info) && !empty($temp_info['label_save'])) {

            $carrier_id = $temp_info['carrier_id'];
            $type = $temp_info['shipping_type'];
            $shipping_date = $temp_info['shipping_date'];

        } else {

            $carrier_id = $label_shipment['carrier_id'];
            $type = $label_shipment['shipping_type'];
            $shipping_date = $label_shipment['shipping_date'];

        }

        $carrier = $this->Manage_price_model->get_curriers($carrier_id);

        if (empty($carrier)) {
            $data['errors'][] = 'Undefined carrier account.';
            echo json_encode($data);
            return false;
        }

        $carrier_shippo_id = $carrier[0]['shippo_id'];

        $type = $this->_get_order_send_type($type, $carrier[0]['currier_name'], '2');

        $dif_check = $this->label_address_dif_check($order_id);

        if (empty($receiver_state_info)) {

            $google_info = $this->google_api->search_place($receiver_info['pickup_state']);

            if (!empty($google_info)) {
                $receiver_state_info = $google_info['address_components'][1]['short_name'];
            }

        } else {

            $receiver_state_info = $receiver_state_info['s_code'];
        }

        $this->load->library('Shippo_lib');
        $this->config->load('general_email');

        $shipper = [
            'name' => 'Luggage To Ship',
            'phone' => '18006786167',
            'street1' => '228 East',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10017',
            'country' => 'US',
            'street2' => '45th Street',
            'email'     => $this->config->item('server_email'),
            'company' => 'Luggage To Ship'
        ];

        if (empty($dif_check) && !empty($delivery_label['first_name']) && !empty($delivery_label['last_name']) && !empty($delivery_label['address1']) && !empty($delivery_label['postal_code'])) {

            $receiver_state_info = $this->Order_model->get_states_by_id($delivery_label['state_id']);

            if (empty($receiver_state_info)) {

                $google_info = $this->google_api->search_place($receiver_info['pickup_state']);

                if (!empty($google_info)) {
                    $receiver_state_info = $google_info['address_components'][1]['short_name'];
                }

            } else {

                $receiver_state_info = $receiver_state_info['s_code'];
            }

            $receiver = [
                'name' => $delivery_label['first_name'] . ' ' . $delivery_label['last_name'],
                'phone' => $delivery_label['phone'],
                'street1' => $delivery_label['address1'],
                'city' => $delivery_label['city'],
                'state' => $receiver_state_info,
                'zip' => $delivery_label['postal_code'],
                'country' => $receiver_country_info['iso2'],
                'street2' => $delivery_label['address2'],
                'email' => $delivery_label['email'],
                'company' => $delivery_label['company']
            ];

        } else {

            $receiver = [
                'name' => $receiver_info['sender_first_name'] . ' ' . $receiver_info['sender_last_name'],
                'phone' => $receiver_info['sender_phone'],
                'street1' => $receiver_info['pickup_address1'],
                'city' => $receiver_info['pickup_city'],
                'state' => $receiver_state_info,
                'zip' => $receiver_info['pickup_postal_code'],
                'country' => $receiver_country_info['iso2'],
                'street2' => $receiver_info['pickup_address2'],
                'email' => $receiver_info['sender_email'],
                'company' => $receiver_info['pickup_company']
            ];

        }

        $items[] = array(
            'weight' => '0.5',
            'length' => '1',
            'width' => '1',
            'height' => '1',
            'distance_unit' => 'in',
            'mass_unit' => 'lb',
            'metadata' => 'label' . $order_id
        );

        $order_extra['reference_1'] = 'Label '.$order_info['order_id'];

        // Specify the shipment container type
        $order_extra['container_type'] = 'Envelope';

        $this->shippo_lib->set_order_extra($order_extra);
        $create_check = $this->shippo_lib->set_address($shipper, $receiver);
        $items_check = $this->shippo_lib->set_percels($items);

        if ($create_check['status'] != 'OK') {

            $data['errors'] = $create_check;
            echo json_encode($data);
            return false;
        }

        if ($items_check['status'] != 'OK') {

            $data['errors'] = $create_check;
            echo json_encode($data);
            return false;
        }

        $response = $this->shippo_lib->create_shipment($carrier_shippo_id, $type, $shipping_date);

        if ($response['status'] != 'OK') {

            if(is_array($response['errors'])){

                foreach($response['errors'] as $index=>$single){
                    $response['errors'][$index] = str_ireplace("'", "`", $single);
                }

            }else{

                $response['errors'] = str_ireplace("'", "`", $response['errors']);
            }

            $data['errors'] = $response['errors'];
            echo json_encode($data);
            return false;
        }

        $patch = FCPATH . 'uploaded_documents/orders_files';

        if (!is_dir($patch)) {
            mkdir($patch, 0775, TRUE);
        }

        $patch = $patch . '/' . $order_id . '/';

        if (!is_dir($patch)) {
            mkdir($patch, 0775, TRUE);
        }

        $this->load->library('Label_lib');

        $single = $response['data']['transactions'][0];

        $tracking_number = $single['tracking_number'];

        $w_img = FCPATH . 'assets/images/label_logo.png';
        $label_img = $single['label_url'];

        $img_info = $this->label_lib->get_label_img($order_id, $single['tracking_number'], $label_img);

        if (empty($img_info)) {
            $data['errors'] = 'No label image.';
            echo json_encode($data);
            return false;
        }

        $this->Order_model->update_label_shipment($order_id, array('tracking_number' => $tracking_number));
        $this->Order_model->update_order_temp_info($order_id, array('tracking_number' => $tracking_number));

        $label_img = $img_info['name'];

        //$this->label_lib->set_watermark($img_info['patch'], $w_img, $order_info['currier_name']);

        if (!$this->update_or_insert_delivery_label($order_id, $label_img)) {

            $data['errors'] = 'Can not fill data to dattabase';

        } else {

            $data['success'] = 'All data successfully saved.';
        }

        echo json_encode($data);

    }

    public function ax_calc_remote_area_fee()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $remote_val = trim($this->security->xss_clean($this->input->post('remote_val')));

        $data['remote_area_fee'] = '';
        $data['errors'] = [];

        if ($remote_val != 1 && $remote_val != 2) {

            show_404();
        }

        if ($remote_val == 1) {

            $this->Order_model->update_delivery_info(['remote_area_fee' => 0], $order_id);

            $data['remote_area_fee'] = 'No remote area fee';
            echo json_encode($data);
            return false;
        }

        $remote_area_fee = $this->_return_remote_area_fee($order_id);

        if (empty($remote_area_fee)) {
            $data['remote_area_fee'] = 'No remote area fee';
            echo json_encode($data);
            return false;
        }

        $update_data = [
            'remote_area_fee' => $remote_area_fee
        ];

        if (!$this->Order_model->update_delivery_info($update_data, $order_id)) {
            $data['errors'][] = 'Can`t fill data to db.';
        } else {
            $data['success'][] = 'Data successfully saved.';
        }

        $data['remote_area_fee'] = $remote_area_fee;
        echo json_encode($data);
    }

    public function _return_remote_area_fee($order_id)
    {

        if (empty($order_id)) {

            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);
        $order_luggage = $this->Order_model->get_luggage_order($order_id);
        $my_carrier = $this->Order_model->get_carrier_by_name($order_info['currier_name']);

        if (empty($order_info) || empty($order_luggage) || empty($my_carrier)) {
            return false;
        }

        $sender_info = $this->Order_model->get_pickup_info($order_id);

        if (empty($sender_info)) {
            return false;
        }

        $country_id = $sender_info['pickup_country_id'];

        if ($order_info['send_type'] == 1) {

            if (stripos($order_info['send_type'], 'inbound') !== false) {

                $delivery_info = $this->Order_model->get_delivery_info($order_id);

                if (empty($delivery_info)) {
                    return false;
                }

                $country_id = $delivery_info['delivery_country_id'];
            }
        }

        $currier_id = $my_carrier['id'];

        $over_size_crt = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type' => $order_info['shipping_type']
        ];

        $over_size = $this->Manage_price_model->get_over_size($over_size_crt);

        if (empty($over_size[0]['per_lbs'])) {

            return 'No remote area fee';
        }

        $total_weight = 0;

        foreach ($order_luggage as $index => $luggages) {

            $charge = $this->Manage_price_model->get_domestic($country_id, $luggages['luggage_id']);

            if (!empty($charge[0]['charge_weight'])) {

                $charge_weight = $charge[0]['charge_weight'];

            } else {

                $charge_weight = $luggages['weight'];
            }

            $total_weight += $charge_weight;
        }

        $pre_lbs = $over_size[0]['per_lbs'];

        $remote_area_fee = intval($pre_lbs * $total_weight);

        if (!empty($over_size[0]['min'])) {

            $min = intval($over_size[0]['min']);

            if ($remote_area_fee < $min) {

                $remote_area_fee = $min;
            }
        }

        return $remote_area_fee;
    }

    public function _get_order_pick_up_fee($order_id)
    {

        $this->check_admin_login();

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            return false;
        }

        $pick_up_info = $this->Order_model->get_pickup_info($order_id);

        $pick_up_price = $this->_get_pick_up_fee($pick_up_info['pickup_country_id'], $order_id, $pick_up_info['shipping_date']);

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        $count = count($order_luggages);

        $pick_up_fee = floatval($pick_up_price * $count);

        $return_array = [
            'pick_up' => number_format($pick_up_fee, 2, '.', '')
        ];


        return $return_array;

    }

    public function manage_order($order_id = NULL)
    {

        $this->check_admin_login();

        $order_info = $this->Order_model->get_order_info($order_id, NULL, [SUBMITTED_STATUS[0]]);

        if (empty($order_info)) {
            echo 'Incorrect Order.';
            return false;
        }

        $user_id = $order_info['user_id'];

        $result = $this->admin_security->login_by_user($user_id);

        if ($result['status'] != 'OK') {
            echo $result['errors'][0];
            return false;
        }

        $this->Order_model->lock_order($order_id);

        redirect('order/order_processing/' . $order_id, 'refresh');

    }

    public function ax_drop_off_map(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $zip_code = trim($this->security->xss_clean($this->input->post('zip_code')));

        $state_place = '';

        $data['errors'] = [];
        $data['success'] = [];
        $data['action'] = true;

        $order_info = $this->Order_model->get_order_info($order_id);

        if(empty($order_info)){
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        if($order_info['shipping_type'] == '1'){
            $data['international'] = true;
        }

        if(!empty($zip_code)){

            $state_explode = explode('-',$zip_code);

            if(!empty($state_explode[1])){

                $state_place = $state_explode[1];
            }

            if(strtolower($order_info['currier_name']) != 'dhl'){
                $zip_code = preg_replace('/[^0-9]+/', '', $zip_code);
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

            if(!empty($county[0]['country'])){

                $country = $county[0]['country'];
                $search = $country.' '.$zip_code.' '.$state_place.' dhl location';
                $url = $this->google_api->google_map_multi_search($search);

            }else{

                $search = $zip_code.' '.$state_place.' dhl location';
                $url = $this->google_api->google_map_multi_search($search);
            }

            $data['action'] = 'google';
            $data['search'] = $search;
            $data['url'] = $url;

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

    public function _genxml($zip_code, $center_lat, $center_lng, $radius, $store_type, $all_types = NULL)
    {

        $this->check_admin_login();

        switch ($store_type) {
            case 'ups':

                $end_point = "https://onlinetools.ups.com/ups.app/xml/Locator";
                $accessKey = '2D1BCDF403AC62EE';
                $userId = 'mikeulker';
                $password = 'Aie 10017';


                $xml_ups = '<?xml version="1.0"?>
						<AccessRequest xml:lang="en-US">
							<AccessLicenseNumber>' . $accessKey . '</AccessLicenseNumber>
							<UserId>' . $userId . '</UserId>
							<Password>' . $password . '</Password>
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
									<Latitude>' . $center_lat . '</Latitude>
									<Longitude>' . $center_lng . '</Longitude>
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
							<SearchRadius>' . $radius . '</SearchRadius>
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

                if (empty($response->SearchResults->DropLocation)) {
                    return false;
                }


                $xml_doc = new DOMDocument("1.0");
                $markers = $xml_doc->createElement("markers");
                $child = $xml_doc->appendChild($markers);
                $info = [];
                foreach ($response->SearchResults->DropLocation as $single) {

                    $distance = $single->Distance->Value;
                    $units = strtolower($single->Distance->UnitOfMeasurement->Code);
                    $company_name = $single->AddressKeyFormat->ConsigneeName;
                    $phone_number = $single->PhoneNumber;
                    $street = $single->AddressKeyFormat->AddressLine;
                    $city = $single->AddressKeyFormat->PoliticalDivision2;
                    $state = $single->AddressKeyFormat->PoliticalDivision1;
                    $postal_code = $single->AddressKeyFormat->PostcodePrimaryLow;
                    $latitude = $single->Geocode->Latitude;
                    $longitude = $single->Geocode->Longitude;
                    $store_closes = $single->OperatingHours->StandardHours->DayOfWeek[1]->CloseHours;
                    $store_closes = date("g:i a", strtotime($store_closes));

                    $last_drop_off_time_ground = $single->LatestGroundDropOffTime;
                    $last_drop_off_time_air = $single->LatestAirDropOffTime;

                    if (!empty($company_name)) {

                        $info[] = [
                            'name' => $company_name,
                            'phone' => $phone_number,
                            'street' => $street,
                            'city' => $city,
                            'state' => $state,
                            'dist' => $distance,
                            'time_gr' => $last_drop_off_time_ground($last_drop_off_time_ground),
                            'time_ai' => $last_drop_off_time_ground($last_drop_off_time_air)
                        ];
                    }
                    $markers = $xml_doc->createElement("marker");
                    $newchild = $child->appendChild($markers);
                    $newchild->setAttribute("name", $company_name);
                    $newchild->setAttribute("address", $street . ', ' . $city . ', ' . $state . ' ' . $postal_code);
                    $newchild->setAttribute("phone", $phone_number);
                    $newchild->setAttribute("lat", $latitude);
                    $newchild->setAttribute("lng", $longitude);
                    $newchild->setAttribute("type", 'ups');
                    $newchild->setAttribute("distance", $distance . ' ' . $units);
                    $newchild->setAttribute("store_closes", $store_closes);

                }

                return array('xml' => $xml_doc->saveXML(), 'info' => $info);

                break;

            case 'fedex':

                //$this->load->library('drop_off_locations');
                //$result = $this->drop_off_locations->get_fedex_locations($radius, $zip_code);

                //if(empty($result)){
                //    return array( 'xml' => '', 'info' => [] );
                //}

                //return $result;

                require_once(APPPATH . 'libraries/ext/fedex/fedex-common.php5');
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
                if ($bNearToPhoneNumber) {
                    $request['LocationsSearchCriterion'] = 'PHONE_NUMBER';
                    $request['PhoneNumber'] = getProperty('searchlocationphonenumber');
                } else {
                    $request['LocationsSearchCriterion'] = 'ADDRESS';
                    $request['Address'] = array(
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
                    'RequiredLocationAttributes' => array(//'ACCEPTS_CASH','ALREADY_OPEN'
                    ),
                    'ResultsRequested' => 100,
                    //	'LocationContentOptions' => array('HOLIDAYS'),

                );

                if (!$all_types) {
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

                try {
                    if (setEndpoint('changeEndpoint')) {
                        $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                    }

                    $response = $client->searchLocations($request);

                    $info = [];

                    if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {

                        foreach ($response->AddressToLocationRelationships->DistanceAndLocationDetails as $key => $value) {

                            if (is_array($value) || is_object($value)) {

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

                                if ($store_closes == 'OPEN_ALL_DAY') {
                                    $store_closes = 'Closed';
                                } else {
                                    $store_closes = $value->LocationDetail->NormalHours[0]->Hours->Ends;
                                }

                                if(is_array($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails[0]->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $value->LocationDetail->CarrierDetails[2]->EffectiveLatestDropOffDetails->Time;

                                }elseif(is_object($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $last_pickup_orange;

                                }

                                if (!empty($street)) {
                                    $info[] = [
                                        'name' => $company_name,
                                        'phone' => $phone_number,
                                        'street' => $street,
                                        'city' => $city,
                                        'state' => $state,
                                        'dist' => $distance,
                                        'time_gr' => 'Last Pickup ' . $hours[5]->Hours->Ends,
                                        'time_ai' => 'Last Pickup ' . $hours[0]->Hours->Ends
                                    ];
                                }
                                $node = $dom->createElement("marker");
                                $newnode = $parnode->appendChild($node);
                                $newnode->setAttribute("name", $company_name);
                                $newnode->setAttribute("type", "fedex");
                                $newnode->setAttribute("address", $street . ', ' . $city . ', ' . $state . ' ' . $postal_code);
                                $newnode->setAttribute("phone", $phone_number);
                                $newnode->setAttribute("lat", $coords[0]);
                                $newnode->setAttribute("lng", $coords[1]);
                                $newnode->setAttribute("distance", $distance . ' ' . $units);
                                $newnode->setAttribute("last_pickup_orange", get12hoursTime($last_pickup_orange));
                                $newnode->setAttribute("last_pickup_green", get12hoursTime($last_pickup_green));
                                $newnode->setAttribute("store_closes", get12hoursTime($store_closes));
                            }
                        }

                        return array('xml' => $dom->saveXML(), 'info' => $info);

                    } else {
                        // printError($client, $response);
                    }
                } catch (SoapFault $exception) {

                    printFault($exception, $client);
                }

                break;
            case 'dhl':

                break;
        }
    }

    public function search_zip_code(){

        if ($this->input->method() != "post" || !$this->input->is_ajax_request()) {
            return false;
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

    public function ax_delivery_label()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
        $post_data = $this->security->xss_clean($this->input->post());
        $trav_changed = trim($this->security->xss_clean($this->input->post('trav_changed')));
        $adress_changed = trim($this->security->xss_clean($this->input->post('adress_changed')));

        $data['errors'] = [];
        $data['success'] = [];
        $data['address_info'] = [];
        $data['traveller_info'] = [];
        $data['add_id'] = [];
        $data['trav_id'] = [];

        if (!$this->Order_model->get_order_info($order_id, $user_id)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order = $this->Order_model->get_order_info($order_id);

        $delivery_label = $this->Order_model->get_delivery_label($order_id);
        $data['delivery_info'] = [];

        if (!empty($delivery_label)) {

            $data['delivery_info'] = $delivery_label;
        }

        $my_traveller = $this->Users_model->get_traveler_list($user_id);
        $data['traveller'] = [];

        if (!empty($my_traveller)) {

            $data['traveller'] = $my_traveller['travel_list'];


        }

        $address_book_cr = [

            'user_id' => $user_id,
            'country_id' => $delivery_label['country_id']

        ];

        $my_address_book = $this->Users_model->get_address_book_list($address_book_cr);

        if (!empty($my_address_book)) {

            $data['address_book'] = $my_address_book['address_book'];

        }

        $traveller_id = trim($this->security->xss_clean($this->input->post('trav_id')));
        $address_book_id = trim($this->security->xss_clean($this->input->post('add_id')));

        if (!empty($traveller_id)) {

            $data['traveller_info'] = $this->_return_data_for_sender_pickup($traveller_id, $user_id);
            $data['trav_id'] = $traveller_id;

        }

        if (!empty($address_book_id)) {

            $data['address_info'] = $this->_return_address_data($address_book_id, $user_id, '1');
            $data['add_id'] = $address_book_id;
        }

        $data['country'] = $this->Users_model->get_countries($delivery_label['country_id']);
        $data['states'] = $this->Users_model->get_states($delivery_label['country_id']);

        if (!empty($adress_changed)) {

            $data['delivery_info']['first_name'] = $post_data['first_name'];
            $data['delivery_info']['last_name'] = $post_data['last_name'];
            $data['delivery_info']['phone'] = $post_data['phone'];
            $data['delivery_info']['email'] = $post_data['email'];
            $data['delivery_info']['state_id'] = $data['address_info']['state'];
        }

        if (!empty($trav_changed)) {

            $data['delivery_info']['company'] = $post_data['company'];
            $data['delivery_info']['address1'] = $post_data['address1'];
            $data['delivery_info']['address2'] = $post_data['address2'];
            $data['delivery_info']['postal_code'] = $post_data['postal_code'];
            $data['delivery_info']['city'] = $post_data['city'];
            $data['delivery_info']['state_id'] = $post_data['state_region'];
            $data['delivery_info']['remark'] = $post_data['remark'];
        }

        $this->load->view('frontend/orders/delivery_label', $data);
    }

    public function ax_save_delivery_label()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

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
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $data['errors'] = [];
        $data['success'] = [];

        if (!$this->Order_model->get_order_info($order_id, $user_id)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        $update_data = [

            'order_id' => $order_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            'company' => $company,
            'address1' => $address1,
            'address2' => $address2,
            'postal_code' => $postal_code,
            'city' => $city,
            'state_id' => $state_id,
            'remark' => $remark,
        ];

        if (!$this->Order_model->update_delivery_label($update_data, $order_id)) {
            $data['errors'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $data['success'][] = 'All data  saved';

        echo json_encode($data);

    }

    public function _return_data_for_sender_pickup($traveller_id, $user_id)
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post') {

            return false;

        }

        if (empty($traveller_id) || empty($user_id)) {

            $return_data = [
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'email' => ''
            ];
            return $return_data;
        }

        $check_traveller = $this->Users_model->get_traveler_list($user_id, $traveller_id);

        if (empty($check_traveller)) {

            $return_data = [
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'email' => ''
            ];

            return $return_data;
        }

        $check_traveller = $check_traveller['travel_list'][0];
        $return_data = [

            'first_name' => $check_traveller['first_name'],
            'last_name' => $check_traveller['last_name'],
            'phone' => $check_traveller['phone'],
            'email' => $check_traveller['email']

        ];


        return $return_data;
    }

    public function _return_address_data($address_id, $user_id, $type, $checked = NULL)
    {

        $this->check_admin_login();

        $return_data = [
            'organization' => '',
            'address1' => '',
            'address2' => '',
            'postal_code' => '',
            'city' => '',
            'state' => '',
            'remark' => ''
        ];

        if (empty($address_id) || empty($user_id) || empty($type)) {

            return $return_data;
        }

        $address_book_cr = ['user_id' => $user_id, 'address_book.id' => $address_id];

        $check_address = $this->Users_model->get_address_book_list($address_book_cr);

        if (empty($check_address)) {

            return $return_data;
        }

        $check_address = $check_address['address_book'][0];

        if ($type == '1') {

            $return_data = [

                'organization' => $check_address['company'],
                'address1' => $check_address['address1'],
                'address2' => $check_address['address2'],
                'postal_code' => $check_address['zip_code'],
                'city' => $check_address['city'],
                'remark' => $check_address['comment']
            ];

            if (!empty($check_address['state_id'])) {

                $state = $this->Order_model->get_states_by_id($check_address['state_id']);

            } elseif (!$checked) {

                $state = $check_address['state_id'];

            } else {

                $state = '';
            }

            $return_data['state'] = $state;

        } else {

            $return_data = [

                'organization' => $check_address['company'],
                'address1' => $check_address['address1'],
                'address2' => $check_address['address2'],
                'remark' => $check_address['comment']
            ];
        }


        return $return_data;

    }

    public function update_or_insert_delivery_label($order_id, $label_img)
    {

        $this->check_admin_login();

        if (empty($order_id) || empty($label_img)) {
            return false;
        }

        $old_file_info = $this->Order_model->get_delivery_label_file($order_id);

        if (!empty($old_file_info)) {

            $url = $patch = FCPATH . 'uploaded_documents/orders_files/' . $order_id . '/' . $old_file_info['file_name'];

            if (file_exists($url)) {
                unlink($url);
            }

            if (!$this->Order_model->update_delivery_label_file($order_id, $label_img)) {
                return false;
            }

        } else {

            $file_data = [
                'order_id' => $order_id,
                'file_type' => 'label_shipping',
                'file_name' => $label_img,
                'luggage_id' => '0'
            ];

            if (!$this->Order_model->insert_order_file($file_data)) {
                return false;
            }

        }

        return true;

    }

    public function send_changes_email($order_id, $email_title, $changed_data)
    {

        $this->check_admin_login();

        if (empty($changed_data) || empty($order_id)) {
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            return false;
        }

        $user_id = $order_info['user_id'];

        $user = $this->Users_model->get_user_info($user_id);

        if (empty($user)) {
            return false;
        }

        $data['title'] = $email_title;
        $data['content'] = [];

        foreach ($changed_data as $title => $changes) {

            $part['body'] = '';

            $part['title'] = '<h3>' . $title . '</h3>';

            if (!empty($changes['title_tag'])) {
                $part['title'] = '<' . $changes['title_tag'] . ' class="change_title">' . $title . '</' . $changes['title_tag'] . '>';
            }

            if (is_array($changes)) {

                foreach ($changes as $change_title => $value) {

                    $part['body'] .= '<p><b>' . $change_title . '</b> -> ' . $value . '</p>';
                }

            } else {

                $part['body'] = $changes;
            }

            $data['content'][] = $part;

        }

        $header_content = $this->get_email_header();
        $main_coontent = $this->load->view('email_templates/order_changes_email', $data, true);
        $footer_content = $this->get_email_footer();

        $body = $this->load->view(
            'email_templates/main_template',
            array(
                'header_content' => $header_content,
                'main_content' => $main_coontent,
                'footer_content' => $footer_content
            ),
            true
        );

        $email_data = array(
            'email' => $user['email'],
            'to_name' => $user['username'],
            'subject' => $email_title . ' – ' . $order_info['order_id'],
            'message' => $body
        );

        $result = $this->_send_email($email_data);


        if ($result->_status_code != 202) {
            return false;
        }

        return true;

    }

    public function _send_email($email_data)
    {

        $this->check_admin_login();

        $this->load->library('email_lib');

        return $res = $this->email_lib->sendgrid_email($email_data);

    }

    private function get_email_header()
    {

        $header_data = [
            'logo_image' => base_url() . 'assets/email-resources/logo.png',
            'phone_image' => base_url() . 'assets/email-resources/phone.png',
            'mail_image' => base_url() . 'assets/email-resources/mail.png',
        ];

        return $this->load->view('email_templates/header', $header_data, true);

    }

    private function get_email_footer()
    {

        $footer_data = [
            'twitter_image' => base_url() . 'assets/email-resources/twitter.png',
            'fb_image' => base_url() . 'assets/email-resources/facebook.png',
            'google_image' => base_url() . 'assets/email-resources/googleplus.png',
            'pinterest_image' => base_url() . 'assets/email-resources/pinterest.png'
        ];

        return $this->load->view('email_templates/footer', $footer_data, true);

    }

    public function ax_label_check()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post') {

            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $order_info = $this->Order_model->get_order_info($order_id);

        $data['errors'] = [];
        $data['order_id'] = $order_id;

        if (empty($order_info)) {

            $data['errors'] = 'Undefined  Order';
            echo json_encode($data);
            return false;
        }

        $labels = $this->_label_info($order_id);

        if (empty($labels)) {

            $data['errors'] = 'Please upload label images and trucking numbers to see the shipment label.';
            echo json_encode($data);
            return false;
        }

        echo json_encode($data);

    }

    public function label_print($order_id = NULL)
    {

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $labels = $this->_label_info($order_id);

        $data['errors'] = [];

        if (empty($labels)) {
            $data['errors'] = 'Please upload label images and trucking numbers to see the shipment label.';
            echo json_encode($data);
            return false;
        }

        foreach ($labels as $single) {

            if (empty($single['file_name'])) {

                continue;
            }
        }

        $data['sender_info'] = $this->Order_model->get_pickup_info($order_id);
        $data['delivery_info'] = $this->Order_model->get_delivery_info($order_id);
        $data['sender_state'] = '';
        $data['delivery_state'] = '';

        if (empty($data['sender_info']) || empty($data['delivery_info'])) {

            show_404();
            return false;
        }

        $data['label_info'] = $labels;

        $sender_state = $this->Order_model->get_states_by_id($data['sender_info']['pickup_state']);

        if (!empty($sender_state['State'])) {
            $data['sender_state'] = $sender_state['State'];
        }

        $delivery_state = $this->Order_model->get_states_by_id($data['delivery_info']['delivery_state']);

        if (!empty($delivery_state['State'])) {
            $data['delivery_state'] = $delivery_state['State'];
        }

        $temp_info = $this->Order_model->get_order_temp_info($order_id);

        if (!empty($temp_info['tracking_save'])) {

            $order_info['currier_name'] = $temp_info['shipping_carrier'];
        }

        $data['order_info'] = $order_info;

        if($order_info['shipping_type'] == '1'){

            $data['first_label'] = $data['label_info'][0];

            if(fmod($data['first_label']['weight'],1) == 0){

                $data['first_label']['weight'] = intval($data['first_label']['weight']);

            }else{

                $data['first_label']['weight'] = number_format($data['first_label']['weight'],2, ".", "");

            }

            unset($data['label_info'][0]);

            $data['from_country']  = $this->Users_model->get_countries($data['sender_info']['pickup_country_id'], true);
            $data['to_country']    = $this->Users_model->get_countries($data['delivery_info']['delivery_country_id'], true);

            $data['itinerary_info']  = $this->Order_model->get_travel($order_id);

            $data['invoice_files']   = $this->Order_model->get_order_files($order_id, 'custom_invoice');
            $data['pasport_file']    = $this->Order_model->get_order_files($order_id, 'Passport_copy');
            $data['visa_file']       = $this->Order_model->get_order_files($order_id, 'Visa_copy');
            $data['itinerary_file']  = $this->Order_model->get_order_files($order_id, 'Travel_itinry');
            $data['personal_effect'] = $this->Order_model->get_order_files($order_id, 'Personal_effect_document');

            $data['first_invoice_count'] = 3;
            $data['invoice_count'] = 0;
            $data['first_label_count']   = 3;
            $data['label_count']   = 0;

            $data['dhl_last_page'] = false;

            if(stripos($order_info['currier_name'], 'dhl') !== FALSE){ // DHL

                $data['first_invoice_count'] = 2;
                $data['invoice_count'] = 2;
                $data['first_label_count']   = 1;
                $data['label_count']   = 1;

                $data['dhl_last_page'] = true;
                $data['dhl_last_page_img'] = $this->Order_model->get_order_files($order_id, 'Archive_review');;

            }elseif (stripos($order_info['currier_name'], 'fedex') !== FALSE){

                $data['type_files'] = [];
                $data['type_files'] = $this->Order_model->get_order_files($order_id,'fedex_second_label');
            }

        }

        if($order_info['shipping_type'] == '2'){

            $this->load->view('frontend/orders/order_label_info', $data);

        }elseif($order_info['shipping_type'] == '1'){

            $this->load->view('frontend/orders/inter_label_print', $data);
        }

    }

    public function _label_info($order_id)
    {

        if (empty($order_id)) {

            show_404();
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            show_404();
            return false;
        }

        $luggage_info = $this->Order_model->get_luggage_and_label_temp($order_id);

        foreach ($luggage_info as $index => $luggages) {

            if (empty($luggages['file_name'])) {

                $luggage_info_real = $this->Order_model->get_order_files($order_id, 'label', NULL, $luggages['lug_id']);

                $luggage_info[$index]['file_name'] = $luggage_info_real['file_name'];

            }

            if (empty($luggage_info[$index]['file_name'])) {

                unset($luggage_info[$index]);
            }
        }

        if (empty($luggage_info)) {

            return false;
        }

        return $luggage_info;
    }

    private function check_changing_array($data1, $data2, $count=false)
    {

        if (empty($data1) || empty($data2)) {
            return true;
        }

        if (!is_array($data1) || !is_array($data2)) {
            return false;
        }

        if (count($data1) < count($data2)) {
            $loop = $data1;
            $second = $data2;
        } else {
            $loop = $data2;
            $second = $data1;
        }

        foreach ($loop as $index => $value) {

            if (empty($second[$index])) {

                if(!empty($count)){
                    return true;
                }

                continue;

            }


            if ($value != $second[$index]) {
                return true;
            }

        }

        return false;

    }

    public function user_orders($user_id, $page = 1)
    {

        $this->check_admin_login();

        if (empty($user_id)) {
            show_404();
            return false;
        }

        $user = $this->Users_model->get_user_info($user_id);

        if (empty($user)) {
            show_404();
            return false;
        }

        $status = $order_id = trim($this->security->xss_clean($this->input->get('shipping_status')));
        $type = $order_id = trim($this->security->xss_clean($this->input->get('shipping_type')));

        $this->load->config('order');

        $table_head_array = [
            '#' => ['title' => '#'],
            'order_id' => ['title' => 'Order <br> Number & Name'],
            'created_date' => ['title' => 'Order <br /> Date & status'],
            'send_type' => ['title' => 'Service<br /> Type'],
            'Delivery' => ['title' => 'Label<br /> Delivery',],
            'shipping_date' => ['title' => 'Pickup<br /> Date & Time', 'order_type' => 'DESC'],
            'delivery_date' => ['title' => 'Delivery<br /> Date & Time', 'order_type' => 'DESC'],
            'From' => ['title' => 'From'],
            'To' => ['title' => 'To'],
            'desc' => ['title' => 'Total<br /> Luggage'],
            'count' => ['title' => 'Total Weight<br /> Cost'],
        ];

        $ordering = [
            'shipping_date',
            'delivery_date'
        ];

        $order_by_arr = [
            'ASC',
            'DESC'
        ];

        $order_by = NULL;
        $ordering_type = NULL;

        if (in_array(strtoupper($this->input->get('order_type')), $order_by_arr)) {
            $ordering_type = strtoupper($this->input->get('order_type'));
        }

        if (in_array(strtolower($this->input->get('order_by')), $ordering)) {

            $order_by = strtolower($this->input->get('order_by'));

            if (!empty($table_head_array[$order_by])) {

                $table_head_array[$order_by]['active'] = true;

                if ($ordering_type == 'DESC') {

                    $table_head_array[$order_by]['order_type'] = 'ASC';
                } else {

                    $table_head_array[$order_by]['order_type'] = 'DESC';
                }
            }
        }

        $crt = [
            'order_shipping.user_id' => $user_id
        ];

        if (!empty($status) && $this->valid->is_id($status)) {

            $crt['order_shipping.shipping_status'] = intval($status);

        }

        if (!empty($type) && $this->valid->is_id($type)) {

            $crt['order_shipping.shipping_type'] = intval($type);

        }

        $row_count = 20;

        $limit = [$row_count, ($page - 1) * $row_count];

        $count = $this->Order_model->get_orders_count($crt);

        $all_orders = $this->Order_model->get_orders($crt, $limit, $order_by, $ordering_type);

        $config['base_url'] = base_url('admin/order/user_orders/' . $user_id . '/');
        $config['suffix'] = '/?' . $this->input->server('QUERY_STRING');
        $config['total_rows'] = $count;
        $config['per_page'] = $row_count;
        $config['uri_segment'] = 5;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li><a href="" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_url'] = base_url('admin/order/user_orders/') . $user_id . '/?' . $this->input->server('QUERY_STRING');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'costumer_list');
        $config['use_page_numbers'] = TRUE;

        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;

        foreach ($all_orders as $index => $orders) {

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);
            $all_orders[$index]['user_info'] = $this->return_user_info($orders['user_id']);
            $all_orders[$index]['order_price'] = $this->price_lib->get_order_fee($orders['real_id'], $orders['user_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if (!empty($order_luggage['tracking'])) {

                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if (!empty($pickup_state['State'])) {
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if (!empty($delivery_state['State'])) {
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $type_files = $this->Order_model->get_order_files($orders['real_id'], 'label');

            if (!empty($type_files)) {

                $data['type_files'][$orders['real_id']][] = $type_files;
            }

            if (!empty($order_luggage['count'])) {

                $all_orders[$index]['luggage_count'] = $order_luggage['count'];
            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);

            $label_check = $this->label_address_dif_check($orders['real_id']);
            $all_orders[$index]['label_check'] = $label_check;

        }

        $data['status_array'] = $this->config->item('all_statuses');

        $data['orders'] = $all_orders;
        $data['user'] = $user;
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['table_head'] = $table_head_array;
        $data['crt'] = $crt;
        $data['all_count'] = $count;

        $data['content'] = 'backend/admin/order/user_orders';
        $this->load->view('backend/back_template', $data);

    }

    public function _get_order_final_billing_info($order_id, $user_id)
    {

        $this->load->model('Promotion_model');

        if (empty($order_id)) {
            return false;
        }

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {
            return false;
        }

        $promotion = NULL;

        if (!empty($order_info['discount_id'])) {
            $promotion = $this->Promotion_model->get_code_info_by_id($order_info['discount_id']);
        }

        $pickup = $this->Order_model->get_pickup_info($order_id);
        $delivery = $this->Order_model->get_delivery_info($order_id);

        $from = $this->Order_model->get_states_by_id($pickup['pickup_state'], true);
        $to = $this->Order_model->get_states_by_id($delivery['delivery_state'], true);

        $info = $this->Order_model->get_order_final_billing_info($order_id);

        if (empty($info)) {
            return false;
        }

        $total['total_insurance'] = 0;
        $total['total_handling'] = 0;
        $total['total_oversize'] = 0;
        $total['total_remote_area'] = 0;
        $total['total_address_change'] = 0;
        $total['total_shipment_holding'] = 0;
        $total['total_tax_and_duty'] = 0;
        $total['total_other'] = 0;
        $total['total_cost'] = 0;
        $total['total_actual_weight'] = 0;
        $total['total_billing_weight'] = 0;

        foreach ($info as $index => $inf) {

            if (empty($inf['insurance'])) {
                $info[$index]['insurance'] = floatval($order_info['free_insurance']);
            }

            $total['total_insurance'] += $inf['insurance'];
            $total['total_handling'] += $inf['special_handling_editable'];
            $total['total_oversize'] += $inf['oversize_fee'];
            $total['total_remote_area'] += $inf['remote_area_fee'];
            $total['total_address_change'] += $inf['address_change_fee'];
            $total['total_shipment_holding'] += $inf['shipment_holding_fee'];
            $total['total_tax_and_duty'] += $inf['tax_duty_fee'];
            $total['total_other'] += $inf['other_fee'];
            $total['total_cost'] += $inf['cost'];
            $total['total_actual_weight'] += $inf['actual_weight'];
            $total['total_billing_weight'] += $inf['lug_charge_weight'];

        }

        $return_array = [
            'order_info' => $order_info,
            'luggage' => $info,
            'from' => $from,
            'to' => $to,
            'promotion' => $promotion,
            'pickup_info' => $pickup,
            'delivery_info' => $delivery,
            'totals' => $total
        ];

        return $return_array;

    }

    public function ax_add_luggage_fee()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $luggage_id = trim($this->security->xss_clean($this->input->post('luggage_id')));
        $data_number = trim($this->security->xss_clean($this->input->post('data_number')));

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $luggages = $this->Order_model->get_order_final_billing_info($order_id, $luggage_id);

        if (empty($luggages)) {
            show_404();
        }

        $data['luggages'] = $luggages;
        $data['data_number'] = $data_number;

        $this->load->view('backend/admin/order/final_billing_info', $data);

    }

    public function ax_save_luggage_fee()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $luggage_id = trim($this->security->xss_clean($this->input->post('luggage_id')));
        $special_handling_fee = trim($this->security->xss_clean($this->input->post('special_handling')));
        $oversize_fee = trim($this->security->xss_clean($this->input->post('oversize_fee')));
        $remote_area_fee = trim($this->security->xss_clean($this->input->post('remote_area')));
        $address_change_fee = trim($this->security->xss_clean($this->input->post('address_change')));
        $shipment_holding_fee = trim($this->security->xss_clean($this->input->post('shipment_holding')));
        $tax_duty_fee = trim($this->security->xss_clean($this->input->post('tax_duty')));
        $other_fee = trim($this->security->xss_clean($this->input->post('other_fee')));

        $data['errors'] = [];
        $data['success'] = '';

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            $data['errors'][] = 'Undefined order.';
            echo json_encode($data);
            return false;
        }

        if ($this->check_order_final_charge($order_id)) {
            $data['errors'][] = 'Final charge already completed, you can not edit this section';
            echo json_encode($data);
            return false;
        }

        $billing_data = [
            'oversize_fee' => $oversize_fee,
            'remote_area_fee' => $remote_area_fee,
            'address_change_fee' => $address_change_fee,
            'shipment_holding_fee' => $shipment_holding_fee,
            'tax_duty_fee' => $tax_duty_fee,
            'other_fee' => $other_fee,
            'special_handling_editable' => $special_handling_fee
        ];

        if ($this->Order_model->check_single_final_billing_info($order_id, $luggage_id)) {

            $crt = ['order_id' => $order_id, 'order_lug_id' => $luggage_id];

            if (!$this->Order_model->update_single_final_billing($billing_data, $crt)) {
                $data['errors']['Can not fill data.'];
            }

        } else {

            $billing_data['order_id'] = $order_id;
            $billing_data['order_lug_id'] = $luggage_id;

            if (!$this->Order_model->insert_single_final_billing($billing_data)) {
                $data['errors']['Can not fill data.'];
            }
        }

        echo json_encode($data);

    }

    public function ax_save_final_billing()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $luggage_ids = $this->security->xss_clean($this->input->post('billing_luggage_id[]'));
        $actual_weights = $this->security->xss_clean($this->input->post('actual_weight[]'));
        $actual_widths = $this->security->xss_clean($this->input->post('actual_width[]'));
        $actual_heights = $this->security->xss_clean($this->input->post('actual_height[]'));
        $actual_lengths = $this->security->xss_clean($this->input->post('actual_length[]'));
        $costs = $this->security->xss_clean($this->input->post('costs[]'));
        $lost = $this->security->xss_clean($this->input->post('lost'));

        $data['errors'] = [];
        $data['success'] = '';

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            $data['errors'][] = 'Undefined order.';
            echo json_encode($data);
            return false;
        }

        if ($this->check_order_final_charge($order_id)) {
            $data['errors'][] = 'Final charge already completed, you can not edit this section';
            echo json_encode($data);
            return false;
        }

        foreach ($luggage_ids as $single_id) {

            if (!isset($costs[$single_id]) && !isset($actual_weights[$single_id]) && !isset($actual_widths[$single_id]) && !isset($actual_heights[$single_id]) && !isset($actual_lengths[$single_id])) {
                continue;
            }

            $check = true;

            if(!empty($lost) && array_search ($single_id, $lost) !== FALSE){

                $single_weight = 0;
                $single_width  = 0;
                $single_height = 0;
                $single_length = 0;
                $cost = 0;

                $check = false;

            }else{

                $single_weight = number_format(floatval($actual_weights[$single_id]));
                $single_width  = number_format(floatval($actual_widths[$single_id]));
                $single_height = number_format(floatval($actual_heights[$single_id]));
                $single_length = number_format(floatval($actual_lengths[$single_id]));
                $cost = number_format(floatval($costs[$single_id]));

            }

            if($check && empty($single_weight) && empty($single_width) && empty($single_height) && empty($single_length)){
                continue;
            }

            $single_data['order_id']      = $order_id;
            $single_data['order_lug_id']  = $single_id;
            $single_data['actual_width']  = $single_width;
            $single_data['actual_height'] = $single_height;
            $single_data['actual_length'] = $single_length;
            $single_data['actual_weight'] = $single_weight;
            $single_data['cost'] = $cost;

            if($check){
                $single_data = array_filter($single_data);
            }

            $temp = $single_data;

            unset($temp['cost']);
            unset($temp['order_id']);
            unset($temp['order_lug_id']);
            $count = count($temp);

            if ($count > 0 && $count < 4) {
                $data['errors'][] = 'Please fill in all the fields.';
                echo json_encode($data);
                return false;
            }

            $charge_weight = max(ceil($single_weight), ceil($single_width * $single_height * $single_length / 139));

            $this->Order_model->update_luggage_info(['charge_weight' => $charge_weight], $order_id, $single_id);

            if ($this->Order_model->check_single_final_billing_info($order_id, $single_id)) {

                $crt = ['order_id' => $order_id, 'order_lug_id' => $single_id];

                $this->Order_model->update_single_final_billing($single_data, $crt);

            } else {

                $this->Order_model->insert_single_final_billing($single_data);

            }

        }

        echo json_encode($data);

    }

    public function ax_final_billing_update_shipping_fee()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id = trim($this->security->xss_clean($this->input->post('user_id')));

        $data['errors'] = [];
        $data['success'] = '';

        $order_info = $this->Order_model->get_order_info($order_id, $user_id);

        if (empty($order_info)) {
            $data['errors'][] = 'Undefined order.';
            echo json_encode($data);
            return false;
        }

        if ($this->check_order_final_charge($order_id)) {
            $data['errors'][] = 'Final charge already completed, you can not edit this section';
            echo json_encode($data);
            return false;
        }

        $result = $this->price_lib->recalculate_shipping_fee($order_id);

        if (empty($result)) {
            $data['errors'][] = 'Error can not updating.';
            echo json_encode($data);
            return false;
        }

        $info = $this->Order_model->get_order_final_billing_info($order_id);

        if (empty($info)) {
            return false;
        }

        $total_handling = 0;
        $total_oversize = 0;
        $total_remote_area = 0;
        $total_address_change = 0;
        $total_shipment_holding = 0;
        $total_tax_and_duty = 0;
        $total_other = 0;

        foreach ($info as $index => $inf) {

            if (empty($inf['insurance'])) {
                $info[$index]['insurance'] = floatval($order_info['free_insurance']);
            }

            $total_handling += $inf['special_handling'];
            $total_oversize += $inf['oversize_fee'];
            $total_remote_area += $inf['remote_area_fee'];
            $total_address_change += $inf['address_change_fee'];
            $total_shipment_holding += $inf['shipment_holding_fee'];
            $total_tax_and_duty += $inf['tax_duty_fee'];
            $total_other += $inf['other_fee'];

        }

        $insert_data = [
            'shipping_fee' => $result['price_details']['shipping_fee'],
            'process_fee' => $result['price_details']['processing_fee'],
            'special_handling' => $total_handling,
            'oversize_fee' => $total_oversize,
            'remote_area_fee' => $total_remote_area,
            'address_change_fee' => $total_address_change,
            'shipment_holding' => $total_shipment_holding,
            'tax_fee' => $total_tax_and_duty,
            'other_fee' => $total_other
        ];

        $crt = [
            'order_id' => $order_id,
            'user_id' => $user_id,
            'type' => 'final'
        ];

        $isset = $this->Billing_model->get_billing($crt);

        if (!empty($isset)) {

            if (!$this->Billing_model->update_billing_info($insert_data, $order_id, 'final')) {
                $data['errors'][] = 'Can not fill data to db.';
            }

        } else {

            $insert_data = array_merge($insert_data, $crt);
            $insert_data['update_date'] = date('Y-m-d H:i:s');
            $insert_data['status'] = '1';

            if (!$this->Billing_model->auto_fill_insert($insert_data)) {
                $data['errors'][] = 'Can not fill data to db.';
            }

        }

        $data['success'] = 'Shipping Fee Succesfully Updated';

        echo json_encode($data);

    }

    public function check_order_final_charge($order_id)
    {

        $this->check_admin_login();

        $crt = [
            'status' => '1',
            'type_name' => 'final'
        ];

        $final_charge = $this->Order_model->get_pay_history($order_id, $crt);

        if (empty($final_charge)) {
            return false;
        }

        return true;

    }

    public function ax_submit_all()
    {

        $this->check_admin_login();

        $this->load->library('Shippo_lib');

        $order_id         = trim($this->security->xss_clean($this->input->post('order_id')));
        $user_id          = trim($this->security->xss_clean($this->input->post('user_id')));
        $pick_up_date     = trim($this->security->xss_clean($this->input->post('pick_up_date')));
        $time_from        = trim($this->security->xss_clean($this->input->post('time_from')));
        $time_to          = trim($this->security->xss_clean($this->input->post('time_to')));
        $con              = trim($this->security->xss_clean($this->input->post('con')));
        $shipping_date    = trim($this->security->xss_clean($this->input->post('shipping_date')));
        $delivery_date    = trim($this->security->xss_clean($this->input->post('delivery_date')));
        $trucking_number  = trim($this->security->xss_clean($this->input->post('trucking_num')));
        $label_carrier    = trim($this->security->xss_clean($this->input->post('label_carrier')));
        $type             = trim($this->security->xss_clean($this->input->post('service_type')));
        $carrier_id       = trim($this->security->xss_clean($this->input->post('carrier_id')));
        $sending_type     = trim($this->security->xss_clean($this->input->post('sending_type')));
        $trucking_numbers = $this->security->xss_clean($this->input->post('numbers'));
        $saturday         = $this->security->xss_clean($this->input->post('sat_delivery'));

        $trucking_numbers = json_decode($trucking_numbers);

        $data['errors'] = [];
        $data['success'] = '';

        $order_info = $this->Order_model->get_order_info($order_id);

        // VALIDATION

        if (empty($order_info)) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Incorrect order information.';
            echo json_encode($data);
            return false;
        }

        $pickup_action = true;
        $label_delivery_action = true;

        $pick_up_info = $this->Order_model->get_pickup_info($order_id);

        if (empty($shipping_date) && empty($delivery_date) && empty($label_carrier) && empty($type)) {

            $label_delivery_action = false;
        }

        if (empty($pick_up_date) && empty($con) && $pick_up_info['pick_up'] != '2') {
            $pickup_action = false;
        }

        $temp_data = $this->Order_model->get_single_trucking_temp_info(NULL, $order_id);
        $label_files = $this->Order_model->get_order_files($order_id, 'label');
        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $luggages_count = count($order_luggages);

        if (empty($trucking_numbers)) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Please set all trucking numbers.';
        }

        $trucking_numbers = (object)array_filter((array)$trucking_numbers);

        if (count((array)$trucking_numbers) != $luggages_count) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Please set all trucking numbers.';
        }

        if ((count($temp_data) + count($label_files)) < $luggages_count) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Please upload all trucking labels.';
        }

        $currier_info = $this->Manage_price_model->get_curriers($carrier_id);

        if (empty($carrier_id) || empty($currier_info)) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Please set trucking currier.';
        }

        if (empty($sending_type)) {
            $data['errors']['tracking_numbers_&_labels'][] = 'Please set sending type.';
        }

        if ($pickup_action) {

            $order_create_info = $this->price_lib->get_order_create_info($order_id, $pick_up_date);

            if (empty($order_create_info)) {
                $data['errors']['shedule_pick_up'][] = 'Fatal error can not get pickup info.';
            }

            $pick_up_info = $order_create_info['pickup_info'];

            if (empty($pick_up_date)) {
                $data['errors']['shedule_pick_up'][] = 'Please set Pick up Date.';
            }

            if (empty($con)) {
                $data['errors']['shedule_pick_up'][] = 'Please set Pick up Con#.';
            }

        }

        if($label_delivery_action) {

            if (empty($shipping_date)) {
                $data['errors']['label_shipment_&_summary'][] = 'Please set label shipping date.';
            }

            if (empty($delivery_date)) {
                $data['errors']['label_shipment_&_summary'][] = 'Please set label delivery date.';
            }

            $label_currier_info = $this->Manage_price_model->get_curriers($label_carrier);

            if (empty($label_carrier) || empty($label_currier_info)) {
                $data['errors']['label_shipment_&_summary'][] = 'Please set label delivery currier.';
            }

            if (empty($type)) {
                $data['errors']['label_shipment_&_summary'][] = 'Please set label delivery service type.';
            }

        }

        if (!empty($data['errors'])) {
            echo json_encode($data);
            return false;
        }

        /////////////////////////////////////////////

        /////// TRUCKING NUMBERS AND LABEL

        $currier_info = $currier_info[0];

        $web_hook_reg = true;

        $pickup_changes = true;

        foreach ($trucking_numbers as $key => $value) {

            $luggage = $this->Order_model->get_one_luggage_order($order_id, $key);

            if (empty($luggage)) {
                continue;
            }

            $update_numbers[] = [
                'id' => $luggage['id'],
                'tracking_number' => $value,
                'track_url' => NULL,
                'truck_id' => NULL
            ];


            if (!$this->shippo_lib->register_webhook($order_info['currier_name'], $value)) {

                $web_hook_reg = false;
            }

        }

        if ($saturday) {
            $sending_type = $sending_type . ' +Sat';
        }

        if ($order_info['currier_name'] != $currier_info['currier_name'] || $order_info['send_type'] != $sending_type) {

            $update_order = [
                'currier_name' => $currier_info['currier_name'],
                'send_type' => $sending_type,
                'currier_shippo_id' => $currier_info['shippo_id']
            ];

        }

        /////////////////////////////////////////////

        /////// PICKUP INF

        if ($pickup_action) {

            $update_data = [
                'order_id' => $order_id,
                'date' => $pick_up_date,
                'time_from' => $time_from,
                'time_to' => $time_to,
                'con' => $con,
                'old_pick_up' => $pick_up_info['shipping_date'] . '/' . $pick_up_info['pickup_time']
            ];

            $old_data_pickup = $this->Order_model->get_shedule_pick_up($order_id);

            if (!empty($old_data_pickup)) {

                $data_dublicate = $update_data;
                unset($data_dublicate['old_pick_up']);
                $pickup_changes = $this->check_changing_array($old_data_pickup, $data_dublicate);

            }

        }

        /////////////////////////////////////////////

        /////// DELIVERY INF

        if($label_delivery_action) {

            $update_data_delivery = [
                'order_id' => $order_id,
                'shipping_date' => $shipping_date,
                'delivery_date' => $delivery_date,
                'carrier_id' => $label_carrier,
                'tracking_number' => $trucking_number,
                'shipping_type' => $type,
                'viewed' => '1'
            ];

            $old_data_delivery = $this->Order_model->get_label_shipment($order_id, false);

            $label_delivery_changes = true;

            if (!empty($old_data_delivery)) {

                $data_dublicate = $update_data_delivery;
                unset($data_dublicate['viewed']);
                $label_delivery_changes = $this->check_changing_array($old_data_delivery, $data_dublicate, true);

            }

        }

        /////////////////////////////////////////////

        /////// DATABASE CHANGES

        // N1(TRUCKING NUMBERS AND LABEL) CHANGE

        $trucking_update_result = $this->ax_save_tracking_info(true, $this->input->post());

        if(empty($trucking_update_result)){

            $data['errors']['tracking_numbers_&_labels'][] = 'Can not update tracking numbers.';
            echo json_encode($data);
            return false;

        }elseif(!empty($trucking_update_result['errors'])){

            $data['errors']['tracking_numbers_&_labels'] = $trucking_update_result['errors'];
            echo json_encode($data);
            return false;
        }

        //

        // N2 (PICKUP INF) CHANGE

        if ($pickup_action && $pickup_changes) {

            $shedule_pickup_update_result = $this->ax_save_shedule_pick_up(true, $this->input->post());

            if (empty($shedule_pickup_update_result)) {

                $data['errors']['shedule_pick_up'][] = 'Can not update shedule pick up info.';
                echo json_encode($data);
                return false;

            } elseif (!empty($shedule_pickup_update_result['errors'])) {

                $data['errors']['shedule_pick_up'] = $shedule_pickup_update_result['errors'];
                echo json_encode($data);
                return false;
            }

        }

        //

        // N3 (DELIVERY INF) CHANGE

        if ($label_delivery_action && $label_delivery_changes) {

            $label_delivery_update_result = $this->ax_save_label_shipment(true, $this->input->post());

            if (empty($label_delivery_update_result)) {

                $data['errors']['label_shipment_&_summary'][] = 'Can not update label delivery info.';
                echo json_encode($data);
                return false;

            } elseif (!empty($label_delivery_update_result['errors'])) {

                $data['errors']['label_shipment_&_summary'] = $label_delivery_update_result['errors'];
                echo json_encode($data);
                return false;
            }

        }

        //

        $temp_update = [
            'label_save' => 0,
            'tracking_save' => 0,
            'pickup_save' => 0
        ];

        $this->Order_model->update_order_temp_info($order_id, $temp_update);

        /////////////////////////////////////////////

        $user_info = $this->Users_model->get_user_info($order_info['user_id']);
        $sender_info = $this->Order_model->get_pickup_info($order_id);

        $subject = 'Your order is ready  '." ". $order_info['order_id'];
        $subject_description = 'Hi ' . $user_info['first_name'] . " " . $user_info['last_name'] . ', we have your order ' . $order_info['order_id'] . ' ready! Please check this email for detailed tracking and pick up information. Thanks.';

        if ($sender_info['pick_up'] == 2) {

            $view = 'admin_submit_all';

        } else {

            $view = 'ready_order';
        }

        $submit_all_email = false;

        if($pickup_action){

            $submit_all_email = true;
        }

        $this->_send_email_variable($order_id, $order_info['user_id'], $view, $subject, $subject_description,$submit_all_email);

        if (empty($data['errors'])) {
            $data['success'] = 'All data successfully submitted.';
        }

        echo json_encode($data);

    }

    public function _check_user_freez($order_info_or_id)
    {

        $return_array = [
            'freeze' => false,
            'last' => ''
        ];

        if (!is_array($order_info_or_id)) {
            $order_info_or_id = $this->Order_model->get_order_info($order_info_or_id);
        }

        if (!empty($order_info_or_id['last_user_use'])) {
            $freeze_time = $order_info_or_id['last_user_use'];
        }

        $return_array['last'] = $order_info_or_id['last_user_use'];

        if (empty($freeze_time)) {
            return $return_array;
        }

        if (empty($order_info_or_id['user_modify'])) {
            return $return_array;
        }

        $now = date('Y-m-d H:i:s');

        $freeze_limit = date('Y-m-d H:i:s', strtotime($freeze_time . ' +' . FREEZE_INTERVAL . ' minutes'));

        if ($now < $freeze_limit) {
            $return_array['freeze'] = true;
        };

        return $return_array;

    }

    public function ax_get_finicial_notes()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data['errors'] = [];
        $data['success'] = [];

        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }


        $data['messages'] = $this->Order_model->get_finicial_notes($order_id);

        $this->load->view('backend/admin/order/order_finicial_message', $data);

    }

    public function ax_add_finicial_notes()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $message = trim($this->security->xss_clean($this->input->post('message')));

        $data['errors'] = [];
        $data['success'] = [];
        if (!$this->valid->is_id($order_id)) {

            show_404();
            return false;
        }

        if (empty($message)) {

            return false;
        }

        $admin_info = $this->Admin_model->get_account_info($this->session->userdata('admin_id'));

        $insert_data = [

            'order_id' => $order_id,
            'admin_name' => $admin_info->admin_name,
            'add_date' => date('Y-m-d H:i:s'),
            'message' => $message
        ];

        if (!$this->Order_model->insert_finicial_notes($insert_data)) {

            $data['errors'][] = 'Message wrong';
            echo json_encode($data);
            return false;
        }

        $data['success'][] = 'message succesfully added!';
        echo json_encode($data);
    }

    public function ax_save_transit_order_notes()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));
        $message = trim($this->security->xss_clean($this->input->post('message')));

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {
            show_404();
            return false;
        }

        $notes_info = $this->Order_model->get_transit_order_notes($order_id);

        $data = [
            'message' => $message,
        ];


        if (empty($notes_info)) {

            $data['order_id'] = $order_id;
            $this->Order_model->insert_transit_order_notes($data);

        } else {

            $this->Order_model->update_transit_notes($data, $notes_info['id']);
        }

    }

    public function ax_create_label_pdf($order_id = NULL, $return = false)
    {

        $this->check_admin_login();

        $this->load->library('Pdf_lib');

        if (empty($order_id)) {

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

        if (empty($order_info)) {

            $data['errors'][] = 'Undefined order information.';

            if (!$return) {
                echo json_encode($data);
            }

            return $data;
        }

        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $old_file = $this->Order_model->get_order_files($order_id, 'label');

        if (empty($order_luggages)) {

            $data['errors'][] = 'Undefined luggage information.';

            if (!$return) {
                echo json_encode($data);
            }

            return false;

        }

        if (count($order_luggages) != count($old_file)) {

            $data['errors'][] = 'Please upload and submit all labels.';

            if (!$return) {

                echo json_encode($data);
            }

            return $data;
        }

        $save_dir = FCPATH . '/labels';
        $file_name = $order_info['order_id'] . '_label.pdf';
        $url = base_url('admin/order/label_print/' . $order_id);

        if (!is_dir($save_dir)) {
            mkdir($url, 0775);
        }

        $this->ax_delete_label_pdf($order_id, true);

        $result = $this->pdf_lib->html_to_pdf($url, $save_dir, $file_name);

        if (!$result) {

            $data['errors'][] = 'Can not create pdf.';

            if (!$return) {
                echo json_encode($data);
            }

            return $data;
        }

        if (!$this->Order_model->update_order($order_id, ['labels_pdf' => $file_name])) {
            $data['errors'][] = 'Can not fill data to Database.';
        }

        if (!$return) {
            echo json_encode($data);
        }

        return $data;

    }

    public function ax_delete_label_pdf($order_id = NULL, $return = false)
    {

        $this->check_admin_login();

        $this->load->library('Pdf_lib');

        if (empty($order_id)) {

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

        if (empty($order_info)) {

            $data['errors'][] = 'Undefined order information.';

            if (!$return) {
                echo json_encode($data);
            }

            return $data;
        }

        if (empty($order_info['labels_pdf'])) {

            $data['errors'][] = 'Undefined pdf file.';

            if (!$return) {
                echo json_encode($data);
            }

            return $data;
        }

        $save_dir = FCPATH . '/labels/' . $order_info['labels_pdf'];

        if (is_file($save_dir)) {
            unlink($save_dir);
        }

        if (!$this->Order_model->update_order($order_id, ['labels_pdf' => ''])) {

            $data['errors'][] = 'Can not fill data to Database.';

            if (!$return) {
                echo json_encode($data);
            }

            return $data;

        }

        if (!$return) {
            echo json_encode($data);
        } else {
            return $data;
        }

    }

    public function billing_payment_admin_action(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $admin_action = trim($this->security->xss_clean($this->input->post('admin_action')));
        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data = [
            'errors' => [],
            'success' => ''
        ];

        if (empty($admin_action)) {

            $data['errors'][] = 'Please select action.';
            echo json_encode($data);
            return false;

        }

        if($admin_action == 'admin_credit'){

            $amount = trim($this->security->xss_clean($this->input->post('amount')));
            $reason = trim($this->security->xss_clean($this->input->post('reason')));

            if (empty($amount)) {
                $data['errors'][] = 'Please set amount.';
                echo json_encode($data);
                return false;
            }

            echo json_encode($this->add_admin_credit($order_id, $amount, $reason));

            return true;

        }

    }

    private function add_admin_credit($order_id, $amount, $reason){

        $this->check_admin_login();

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

           $data['errors'][] = 'Undefined order information.';

           return $data;

        }

        $insert_data = [
            'order_id' => $order_id,
            'user_id'  => $order_info['user_id'],
            'amount'   => $amount,
            'date'     => date('Y-m-d H:i:s'),
            'reason'   => $reason
        ];

        if(!$result = $this->Order_model->insert_admin_credit($insert_data)){

            $data['errors'][] = 'Can not fill data to db.';

            return $data;

        }

        $update = $this->Users_model->change_user_credit($order_info['user_id'], $amount, '+');

        if(!$update){

            $data['errors'][] = 'Can not update user data.';

        }

        return $data;

    }

    public function ax_delete_admin_credit(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $order_id  = trim($this->security->xss_clean($this->input->post('order_id')));
        $credit_id = trim($this->security->xss_clean($this->input->post('credit_id')));

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            $data['errors'][] = 'Undefined order information.';

            echo json_encode($data);

            return false;

        }

        $user_info = $this->Users_model->get_user_info($order_info['user_id']);
        $old_credit = $user_info['account_credit'];

        if (empty($user_info)) {

            $data['errors'][] = 'Undefined user.';

            echo json_encode($data);

            return false;

        }

        $credit_info = $this->Order_model->get_single_credit($credit_id);

        if (empty($credit_info) || $credit_info['order_id'] != $order_id) {

            $data['errors'][] = 'Undefined credit.';

            echo json_encode($data);

            return false;

        }

        if($credit_info['amount'] > $user_info['account_credit']){

            $data['errors'][] = 'User already use this credit.';

            echo json_encode($data);

            return false;

        }

        $this->Users_model->change_user_credit($order_info['user_id'], $credit_info['amount'], '-');

        $user_info = $this->Users_model->get_user_info($order_info['user_id']);

        if($old_credit == $user_info['account_credit']){

            $data['errors'][] = 'Can not update account credit.';

            echo json_encode($data);

            return false;

        }

        $this->Order_model->delete_admin_credit($credit_info['id']);

        echo json_encode($data);

    }

    public function _send_email_variable($order_id, $user_id, $view, $subject, $subject_description = NULL,$submit_all_email = NULL)
    {

        $this->check_admin_login();

        if (empty($order_id) || empty($user_id) || empty($view) || empty($subject)) {

            return false;
        }

        $crt = [
            'order_shipping.id' => $order_id
        ];

        $user_info = $this->Users_model->get_user_info($user_id);

        $send_data = $this->Order_model->get_orders($crt, $limit = NULL, $order_by = 'order_shipping.id', $order_type = 'DESC', $row = true);

        if (empty($send_data['card_id'])) {
            $send_data['card_inf'] = '';

        } else {
            $card_info = $this->Order_model->get_credit_card_by_id($user_id, NULL, $send_data['card_id']);
            $send_data['card_inf'] = substr($card_info['card_number'], -4, 4);
        }

        $incurance_fee = floatval($this->Order_model->get_insurance_fee($order_id));
        $order_luggages = $this->Order_model->get_luggage_order($order_id);
        $send_data['luggage_info'] = $order_luggages;

        $send_data['incurance_fee'] = $incurance_fee;
        $send_data['price'] = $this->price_lib->get_order_fee($order_id, $user_id);
        $country = $this->Users_model->get_countries($send_data['pickup_country_id'], true);
        $my_carrier = $this->Order_model->get_carrier_by_name($send_data['currier_name']);
        $labels = $this->Order_model->get_order_files($send_data['real_id'], 'label');
        $send_data['labels'] = $labels;
        $send_data['country_from'] = '';
        $send_data['quantity'] = '4';
        $send_data['declared_value'] = '7';
        $send_data['country_to'] = '';
        $send_data['state_name_delivery'] = '';
        $send_data['state_name_sender'] = '';
        $send_data['shedule']['con'] = '';
        $send_data['label_shipment']['tracking'] = '';
        $send_data['user_id'] = $user_id;
        $label_shipment = $this->Order_model->get_label_shipment($order_id);

        if (!empty($label_shipment['tracking_number'])) {

            $send_data['label_shipment']['tracking'] = $label_shipment['tracking_number'];
        }

        if (!empty($label_shipment['shipping_date'])) {

            $send_data['label_shipment']['shipping_date'] = $label_shipment['shipping_date'];
        }

        $country_1 = $this->Users_model->get_countries($send_data['pickup_country_id'], true);
        $country_2 = $this->Users_model->get_countries($send_data['delivery_country_id'], true);

        if (!empty($country_1['country'])) {
            $send_data['country_from'] = $country_1['country'];

            if($country_1['id'] == '226'){

                $send_data['country_from'] = str_replace('(USA)','',$send_data['country_from']);

            }
        }

        if (!empty($country_2['country'])) {
            $send_data['country_to'] = $country_2['country'];

            if($country_2['id'] == '226'){
                $send_data['country_to'] = str_replace('(USA)','',$send_data['country_to']);
            }
        }

        $delivery_state = $this->Order_model->get_states_by_id($send_data['delivery_state']);

        if (!empty($delivery_state['State'])) {
            $send_data['state_name_delivery'] = $delivery_state['State'];
        }

        $sender_state = $this->Order_model->get_states_by_id($send_data['pickup_state']);

        if (!empty($sender_state['State'])) {
            $send_data['state_name_sender'] = $sender_state['State'];
        }

        $country_prof_info_sender = $this->Order_model->get_country_profile($country['iso2'], $my_carrier['id']);
        $send_data['hotline'] = $country_prof_info_sender['hotline'];
        $send_data['submit_all_email'] = $submit_all_email;
        $send_data['shedule'] = $this->Order_model->get_shedule_pick_up($order_id);
        $send_data['subject_description'] = $subject_description;
        $new_drress = $this->Order_model->get_delivery_label($order_id);

        if(!empty($new_drress)){

            $send_data['new_address'] = $new_drress;
        }

        if (empty($user_info)) {
            return false;
        }

        $send_data['first_name'] = $user_info['first_name'];
        $send_data['last_name'] = $user_info['last_name'];


        $email_data = array(
            'email' => $user_info['email'],
            'to_name' => $user_info['username'],
            'subject' => $subject,
            'variables' => $send_data
        );

        $this->general_email->send_email($view, $email_data);

    }

    private function get_invoice_link($order_id)
    {

        $crt = [
            'status' => 1,
        ];

        $return_array = [];

        $history = $this->Order_model->get_pay_history($order_id, $crt);

        if (empty($history)) {
            return NULL;
        }

        foreach ($history as $single) {

            if(empty($single['charge_id'])){
                continue;
            }

            if ($single['type_name'] == '' || $single['type_name'] == 'Charge') {
                $single['type_name'] = 'initial';
            }

            if ($single['type_name'] == 'final' || $single['type_name'] == 'initial') {
                $return_array[] = [
                    'name' => $single['type_name'],
                    'url' => base_url('invoice/view/' . $order_id . '/' . $single['type_name'])
                ];
            }

        }


        return $return_array;

    }

    public function invoice_file($order_id, $name)
    {

        $this->check_admin_login();

        if (empty(trim($order_id)) || empty(trim($name))) {

            show_404();
            return false;
        }

        $file_path = FCPATH . 'invoices/' . $order_id . '/' . $name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /*header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
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

    public function ax_web_hook_reg(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $order_info = $this->Order_model->get_order_info($order_id);

        if (empty($order_info)) {

            $data['errors'][] = 'Undefined order information.';
            echo json_encode($data);
            return false;

        }

        $luggage = $this->Order_model->get_luggage_order($order_id);

        if (empty($luggage)) {

            $data['errors'][] = 'No luggage information.';
            echo json_encode($data);
            return false;

        }

        $this->load->library('Shippo_lib');

        $web_hook = true;

        foreach($luggage as $single){

            if (!$this->shippo_lib->register_webhook($order_info['currier_name'], $single['tracking_number'])) {
                $web_hook = false;
            }

            $carrier_name = $this->shippo_lib->get_carrier_name_for_shipo($order_info['currier_name']);

            $data = [
                'errors' => [],
                'info' => []
            ];

            if (empty($carrier_name)) {

                continue;
            }

            if (!is_array($carrier_name)) {

                $result = $this->shippo_lib->get_trucking_status($single['tracking_number'], $carrier_name);

            } else {

                foreach ($carrier_name as $single_name) {

                    $result = $this->shippo_lib->get_trucking_status($single['tracking_number'], $single_name);

                    if (!empty($result['status'])) {
                        break;
                    }

                }
            }

            if (!empty($result['data']['current_status'])) {

                $current = $result['data']['current_status'];

                if (!empty($current->status)) {

                    $insert_status = NULL;

                    if ($current->status == 'TRANSIT') {

                        $insert_status = TRANSIT_STATUS[0];

                    } elseif ($current->status == 'FAILURE') {

                        $insert_status = TRANSIT_STATUS[0];

                    } elseif ($current->status == 'DELIVERED') {

                        $insert_status = DELIVERY_STATUS[0];
                    }

                    $luggage_info = $this->Order_model->get_luggage_info_by_number($single['tracking_number']);

                    if (empty($luggage_info)) {
                        return false;
                    }

                    $update_luggage_data = [
                        'shipping_status' => $insert_status,
                        'status_detail' => date('M-d-Y') . ' ' . $current->status_details
                    ];

                    $crt = [
                        'id' => $single['id']
                    ];

                    $this->Order_model->update_luggage_info_crt($update_luggage_data, $crt);

                }

            }

        }

        $this->check_and_change_order_status($order_id);

        $this->Order_model->update_order($order_id, ['webhook_reg' => $web_hook]);

        if(!$web_hook){
            $data['errors'][] = 'Web hooks not registered.';
        }

        echo json_encode($data);

    }

    public function validate_order_address(){

        $this->check_admin_login();

        $order_id = trim($this->security->xss_clean($this->input->post('order_id')));

        $this->load->library('Shippo_lib');

        $data = [
            'errors'       => [],
            'result_data'  => []
        ];

        $sender_address = $this->Order_model->get_pickup_info($order_id);
        $receiver_address = $this->Order_model->get_delivery_info($order_id);

        if(empty($sender_address) || empty($sender_address['pickup_address1'])){
            $data['errors'][] = 'Sender address information can not be empty.';
        }

        if(empty($receiver_address) || empty($receiver_address['delivery_address1'])){
            $data['errors'][] = 'Receiver address information can not be empty.';
        }

        if(!empty($data['errors'])){
            $this->load->view('backend/address_validate_result', $data);
            exit();
        }

        //Get Countries info
        $pic_country = $this->Users_model->get_countries($sender_address['pickup_country_id'], true);
        $del_country = $this->Users_model->get_countries($receiver_address['delivery_country_id'], true);

        if(empty($pic_country)){
            $data['errors'][] = 'Sender country information can not be empty.';
        }

        if(empty($del_country)){
            $data['errors'][] = 'Receiver country information can not be empty.';
        }

        // Get States info
        $pic_state = $this->Order_model->get_states_by_id($sender_address['pickup_state']);
        $del_state = $this->Order_model->get_states_by_id($receiver_address['delivery_state']);

        if(empty($pic_state)){
            $data['errors'][] = 'Sender state information can not be empty.';
        }

        if(empty($del_state)){
            $data['errors'][] = 'Receiver state information can not be empty.';
        }

        if(!empty($data['errors'])){
            $this->load->view('backend/address_validate_result', $data);
            exit();
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

        $result = [
            'sender' => NULL,
            'receiver' => NULL
        ];

        if(strtolower($pic_addr_for_validate['country']) == 'us'){

            $result['sender'] = $this->shippo_lib->validate_address($pic_addr_for_validate);
            $result['sender'] = $result['sender']['data'];
        }

        if(strtolower($del_addr_for_validate['country']) == 'us'){

            $result['receiver'] = $this->shippo_lib->validate_address($del_addr_for_validate);
            $result['receiver'] = $result['receiver']['data'];
        }

        $result['sender']['origin'] = $pic_addr_for_validate;
        $result['receiver']['origin'] = $del_addr_for_validate;

        $data['result'] = $result;

        $this->load->view('backend/address_validate_result', $data);

    }

    public function report(){

        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;
        $data['content'] = 'backend/report';
        $this->load->view('backend/back_template', $data);
    }

    private function check_admin_login()
    {

        if (!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }

    }
}