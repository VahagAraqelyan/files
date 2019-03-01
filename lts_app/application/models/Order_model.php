<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    ///////INSERT FUNCTIONS


    public function insert_transit_order_notes($data){
        if(empty($data)){

            return false;
        }

        $this->db->insert('admin_transit_notes', $data);
    }

    public function insert_order($data){

        if(empty($data['user_id']) || empty($data['price']) || empty($data['order_id'])){
            return false;
        }

        $this->db->insert('order_shipping', $data);

        return $this->db->insert_id();

    }

    public function insert_order_items($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert_batch('order_luggages', $data);

        return $result;

    }

    public function insert_pickup_info($data){

        if(empty($data['order_id'])){
            return false;
        }

        $this->db->insert('pick_up_info', $data);

        return $this->db->insert_id();

    }

    public function insert_delivery_info($data){

        if(empty($data['order_id'])){
            return false;
        }

        $this->db->insert('delivery_info', $data);

        return $this->db->insert_id();

    }

    public function insert_delivery_label($data){

        if(empty($data['order_id'])){
            return false;
        }

        $this->db->insert('delivery_label', $data);

        $result =  $this->db->insert_id();
        return $result;

    }

    public function insert_incurance($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert_batch('order_incurance',$data);

        return $result;
    }

    public function insert_batch_item_list($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert_batch('order_item_list', $data);

        return $result;

    }

    public function insert_order_form_document($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('order_form_files',$data);

        return $result;

    }

    public function insert_finicial_notes($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('finical_notes',$data);

        return $result;
    }

    public function insert_passport_info($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('order_passport_visa',$data);

        return $result;

    }

    public function insert_trav_info($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('travel_itinerary',$data);

        return $result;

    }

    public function insert_itinerary_files($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('travel_itinerary_files',$data);

        return $result;

    }

    public function insert_account_order_message($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert('order_message',$data);
    }

    public function insert_label_error($order_id, $message){

        if(is_array($message)){

            $data = [];

            foreach($message as $single){
                $data[] = [
                    'order_id'      => $order_id,
                    'error_message' => $single,
                    'date'          => date('Y-m-d h:i:s')
                ];
            }

            return $this->db->insert_batch('order_label_create_errors', $data);

        }

        $data = [
            'order_id'      => $order_id,
            'error_message' => $message,
            'date'          => date('Y-m-d h:i:s')
        ];

        return $this->db->insert('order_label_create_errors',$data);

    }

    public function insert_order_file($data){

        if(empty($data['order_id']) || empty($data['file_name'])){
            return false;
        }

        return $this->db->insert('order_files',$data);

    }

    public function insert_shedule_pick_up($data){

        return $this->db->insert('order_shedule_pick_up',$data);
    }

    public function insert_label_shipment($data){

        return $this->db->insert('order_label_shipment_summary',$data);
    }

    public function insert_trucking_history($data){

        return $this->db->insert('trucking_history',$data);
    }

    public function insert_payment_history($data){

        return $this->db->insert('order_payment_history',$data);
    }

    public function insert_order_temp_info($data){

        return $this->db->insert('order_temp_info',$data);
    }

    public function insert_trucking_temp_info($data){

        return $this->db->insert('trucking_temp_info',$data);
    }

    public function insert_single_final_billing($data){

        return $this->db->insert('final_billing_info',$data);
    }

    public function insert_admin_credit($data){

        return $this->db->insert('admin_credit_history',$data);
    }

    ///////UPDATE FUNCTIONS

    public function update_transit_notes($data,$id){

        if(empty($id) || empty($data)){
            return false;
        }

        $where = [ 'id'   => $id ];

        $result = $this->db->update('admin_transit_notes', $data, $where);

        return $result;
    }

    public function update_delivery_label_file($order_id, $file_name){

        if(empty($order_id) || empty($file_name)){
            return false;
        }

        $where = [
            'order_id'   => $order_id,
            'file_type'  => 'label_shipping',
            'luggage_id' =>'0'
        ];

        $result = $this->db->update('order_files', array('file_name' => $file_name), $where);

        return $result;

    }

    public function update_label_shipment($order_id, $update_data){

        if(empty($order_id) || empty($update_data)){
            return false;
        }

        $result = $this->db->update('order_label_shipment_summary', $update_data, array('order_id' => $order_id));

        return $result;

    }

    public function update_shedule_pick_up($order_id, $update_data){

        if(empty($order_id) || empty($update_data)){
            return false;
        }

        return $this->db->update('order_shedule_pick_up', $update_data, array('order_id' => $order_id));

    }

    public function update_order($order_id, $update_data){

        if(empty($order_id) || empty($update_data)){
            return false;
        }

        return $this->db->update('order_shipping', $update_data, array('id' => $order_id));

    }

    public function update_pickup_info($update_data, $order_id){

        if(empty($order_id) || empty($update_data)){
            return false;
        }

        return $this->db->update('pick_up_info', $update_data, array('order_id' => $order_id));

    }

    public function update_delivery_info($update_data, $order_id){

        if(empty($order_id) || empty($update_data)){
            return false;
        }

        return $this->db->update('delivery_info', $update_data, array('order_id' => $order_id));

    }

    public function update_incurance($data,$criteria){

        if(empty($data) || empty($criteria)){
            return false;
        }

        $this->db->where($criteria);
        $result =  $this->db->update('order_incurance', $data);

        return $result;
    }

    public function update_delivery_label($data,$order_id){

        if(empty($data) || empty($order_id)){

            return false;
        }

        $this->db->where('order_id',$order_id);

        $result = $this->db->update('delivery_label', $data);

        return $result;

    }

    public function update_order_passport_info($data,$order_id){

        if(empty($data) || empty($order_id) || !$this->valid->is_id($order_id)){

            return false;
        }

        $this->db->where('order_id',$order_id);

        return $this->db->update('order_passport_visa', $data);

    }

    public function update_trav_info($data,$order_id){

        if(empty($data) || empty($order_id) || !$this->valid->is_id($order_id)){

            return false;
        }

        $this->db->where('order_id',$order_id);

        return $this->db->update('travel_itinerary', $data);

    }

    public function update_luggage_info($data,$order_id,$luggage_id = NULL){

        if(empty($data) || empty($order_id) || !$this->valid->is_id($order_id)){

            return false;
        }

        $this->db->where('order_id',$order_id);

        if(!empty($luggage_id)){

            $this->db->where('id',$luggage_id);
        }

        return $this->db->update('order_luggages', $data);

    }

    public function update_luggage_info_crt($data,$crt){

        if(empty($data) || empty($crt)){

            return false;
        }

        $this->db->where($crt);

        return $this->db->update('order_luggages', $data);

    }

    public function update_order_luggages_batch($data){

        $result = true;

        foreach($data as $single){

            $update = $single;

            if(empty($update['id'])){
                continue;
            }

            $this->db->where('id', $update['id']);

            unset($update['id']);

            if(!$this->db->update('order_luggages', $update)){

                $result = false;
            }

        }

        return $result;

    }

    public function update_total_order_count($user_id){

        if(empty($user_id)){
            return false;
        }

        $this->db->set('total_orders', 'total_orders+1', FALSE);
        $this->db->where('id', $user_id);

        return $this->db->update('users');

    }

    public function update_order_temp_info($order_id, $data){

        if(empty($order_id)){
            return false;
        }

        $this->db->where('order_id', $order_id);

        return $this->db->update('order_temp_info', $data);

    }

    public function update_trucking_temp_info($crt, $update_data){

        if(empty($crt)){
            return false;
        }

        $this->db->where($crt);

        return $this->db->update('trucking_temp_info', $update_data);

    }

    public function update_payment_history($update_data,  $crt = NULL){

        if(!empty($crt)){
            $this->db->where($crt);
        }

        return $this->db->update('order_payment_history', $update_data);

    }

    public function update_single_final_billing($update_data,  $crt = NULL){

        if(!empty($crt)){
            $this->db->where($crt);
        }

        return $this->db->update('final_billing_info', $update_data);

    }

    public function change_order_status($order_id, $status, $change_by = NULL){

        if(empty($order_id) || !isset($status)){
            return false;
        }

        if(!empty($change_by)){

            $change_by = 1;
        }else{

            $change_by = 0;
        }

        $result = $this->db->update('order_shipping', ['shipping_status' => $status, 'status_change_by' => $change_by], ['id' => $order_id]);

        return $result;

    }

    public function set_order_card($order_id, $card_id){

        if(empty($order_id) || empty($card_id)){
            return false;
        }

        $update_data = ['card_id' => $card_id];

        return $this->db->update('order_shipping', $update_data, array('id' => $order_id));

    }

    public function set_order($data,$criteria){

        if(empty($data) || empty($criteria)){
            return false;
        }

        $this->db->where($criteria);
        $result =  $this->db->update('order_shipping', $data);

        return $result;

    }

    public function set_order_discount($order_id, $code, $interest, $type, $id){

        if(empty($order_id) || empty($code)){
            return false;
        }

        $data = [
            'discount_code'     => $code,
            'interest_discount' => $interest,
            'discount_type'     => $type,
            'discount_id'       => $id
        ];

        $this->db->where(['id' => $order_id]);
        $result =  $this->db->update('order_shipping', $data);

        return $result;

    }

    public function set_signature($order_id, $signature){

        if(empty($order_id) || empty($signature)){
            return false;
        }

        $this->db->where(['id' => $order_id]);
        $result =  $this->db->update('order_shipping', ['signature' => $signature]);

        return $result;

    }

    public function set_trucking_info($luggage_id, $data){

        if(empty($luggage_id)){
            return false;
        }

        $this->db->where(['id' => $luggage_id]);
        $result =  $this->db->update('order_luggages', $data);

        return $result;

    }

    public function set_luggage_trucking_status($luggage_id, $status){

        if(empty($luggage_id)){
            return false;
        }

        $this->db->where(['id' => $luggage_id]);

        $result = $this->db->update('order_luggages', ['shipping_status' => $status]);

        return $result;

    }

    public function set_order_last_use($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->where(['id' => $order_id]);

        $result = $this->db->update('order_shipping', ['last_user_use' => date('Y-m-d H:i:s'), 'user_modify' => '1']);

        return $result;

    }

    public function lock_order($order_id, $lock = false){

        if(empty($order_id)){
            return false;
        }

        if(!$lock){
            $update_data = [
                'freeze_by_admin'  => '1',
                'freeze_date_time' => date('Y-m-d H:i:s')
            ];
        }else{
            $update_data = [
                'freeze_by_admin'  => NULL,
                'freeze_date_time' => NULL
            ];
        }

        return $this->db->update('order_shipping', $update_data, array('id' => $order_id));

    }

    public function add_cancel_count($order_id){

        $this->db->set('cancel_count', 'cancel_count+1', FALSE);
        $this->db->where('id', $order_id);

        return $this->db->update('order_shipping');

    }

    ///////DELETE FUNCTIONS

    public function delete_order_files($order_id,$id){

        if(empty($order_id || empty($id))){

            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('id', $id);
        $result = $this->db->delete('order_files');

        return $result;
    }

    public function delete_luggage_files($order_id,$luggage_id){

        if(empty($order_id || empty($id))){

            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('luggage_id', $luggage_id);
        $result = $this->db->delete('order_files');

        return $result;
    }

    public function delete_order_items($order_id){

        if(empty($order_id)){
            return false;
        }

        $result = $this->db->delete('order_luggages', array('order_id' => $order_id));

        return $result;

    }

    public function delete_order_single_item($id){

        if(empty($id)){
            return false;
        }

        $result = $this->db->delete('order_luggages', array('id' => $id));

        return $result;

    }

    public function delete_item_list($order_id){

        if(empty($order_id)){
            return false;
        }

        $result = $this->db->delete('order_item_list', array('order_id' => $order_id));

        return $result;

    }

    public function delete_order_incurance($order_id){

        if(empty($order_id)){
            return false;
        }

        $result = $this->db->delete('order_incurance', array('order_id' => $order_id));

        return $result;

    }

    public function delete_order_form_document($order_id, $file_id, $all = NULL){

        if(empty($order_id)){
            return false;
        }

        if(empty($all) && empty($file_id)){
            return false;
        }

        $crt = [
            'order_id' => $order_id,
            'id'       => $file_id
        ];

        if(!empty($all)){
            unset($crt['id']);
        }

        $result = $this->db->delete('order_form_files', $crt);

        return $result;

    }

    public function delete_itinerary_document($order_id, $file_id, $all = NULL){

        if(empty($order_id)){
            return false;
        }

        if(empty($all) && empty($file_id)){
            return false;
        }

        $crt = [
            'order_id' => $order_id,
            'id'       => $file_id
        ];

        if(!empty($all)){
            unset($crt['id']);
        }

        $result = $this->db->delete('travel_itinerary_files', $crt);

        return $result;

    }

    public function delete_signature($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->where('id', $order_id);

        $update_data = ['signature' => NULL];

        return $this->db->update('order_shipping', $update_data, array('id' => $order_id));
    }

    public function delete_order_card($order_id){

        if(empty($order_id)){
            return false;
        }

        $update_data = ['card_id' => NULL];

        return $this->db->update('order_shipping', $update_data, array('id' => $order_id));

    }

    public function delete_shedule_pickup($order_id){

        if(empty($order_id)){
            return false;
        }

        $crt = [
            'order_id' => $order_id,
        ];

        $result = $this->db->delete('order_shedule_pick_up', $crt);

        return $result;

    }

    public function delete_trucking_temp_info($order_id){

        if(empty($order_id)){
            return false;
        }

        $where =['order_id' => $order_id];

        return $result = $this->db->delete('trucking_temp_info', $where);

    }

    public function delete_luggage_temp_info($order_id, $luggage_id){

        if(empty($order_id)){
            return false;
        }

        $where =[
            'order_id' => $order_id,
            'luggage_id' => $luggage_id
        ];

        return $result = $this->db->delete('trucking_temp_info', $where);

    }

    public function delete_payment_history($order_id, $id = NULL){

        if(empty($order_id)){
            return false;
        }

        $where = ['order_id' => $order_id];

        if(!empty($id)){
            $where['id'] = $id;
        }

        return $result = $this->db->delete('order_payment_history', $where);

    }

    public function delete_admin_credit($id){

        if(empty($id)){
            return false;
        }

        $where = ['id' => $id];

        return $result = $this->db->delete('admin_credit_history', $where);

    }

    ///////GET (SELECT) FUNCTIONS

    public function get_transit_order_notes($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_id', $order_id);

         $result =  $this->db->get('admin_transit_notes')->row_array();

         return $result;
    }

    public function get_orders($crt, $limit = NULL, $order_by = 'order_shipping.id', $order_type = 'DESC',$row = NULL){

        $this->db->select('order_shipping.*, order_shipping.order_id AS order_number, order_shipping.id AS real_id, pick_up_info.*, delivery_info.*,users.first_name,users.last_name,users.account_name,users.id,users.email,users.username, order_shedule_pick_up.id AS shedule_id, order_label_shipment_summary.delivery_date AS label_date , order_label_shipment_summary.tracking_number AS label_trucking');
        $this->db->from('order_shipping');
        $this->db->join('pick_up_info', 'order_shipping.id = pick_up_info.order_id', 'left');
        $this->db->join('delivery_info', 'order_shipping.id = delivery_info.order_id', 'left');
        $this->db->join('users', 'order_shipping.user_id = users.id', 'left');
        $this->db->join('order_shedule_pick_up', 'order_shipping.id = order_shedule_pick_up.order_id', 'left');
        $this->db->join('order_label_shipment_summary', 'order_shipping.id = order_label_shipment_summary.order_id', 'left');
        $this->db->where($crt);

        if(!empty($limit) && is_array($limit) && count($limit) == 2) {
            $this->db->limit($limit[0], $limit[1]);
        }

        if(!empty($order_by) && !empty($order_type)){

            $this->db->order_by($order_by, $order_type);
        }

        if(!empty($row)){

            $result =  $this->db->get()->row_array();

        }else{

            $result =  $this->db->get()->result_array();
        }



        return $result;

    }

    public function get_orders_count($crt){

        $this->db->select('COUNT(id) AS count_total');

        $this->db->where($crt);

        $result =  $this->db->get('order_shipping')->row_array();

        return $result['count_total'];

    }

    public function get_order_files($order_id,$type = NULL,$id = NULL, $luggage_id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($type)){

            $this->db->where('file_type', $type);
        }

        $return_type = 1;

        if(!empty($id)){
            $this->db->where('id', $id);

            $return_type = 2;

        }

        if(!empty($luggage_id)){

            $this->db->where('luggage_id', $luggage_id);
            $return_type = 2;
        }

        $this->db->where('order_id', $order_id);


        if($return_type == 1){

            $result =  $this->db->get('order_files')->result_array();

        }else{

            $result =  $this->db->get('order_files')->row_array();
        }

        if(empty($result)){
            return NULL;
        }

        return $result;
    }

    public function get_order_info($order_id, $user_id = NULL, $status = NULL){

        if(empty($order_id)){

          return false;
        }

        $this->db->select('*');

        if(!empty($user_id)){

            $this->db->where('user_id', $user_id);
        }

        $this->db->where('id', $order_id);

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status',$status);

            }else{

                $this->db->where('shipping_status',$status);
            }
        }

        $result =  $this->db->get('order_shipping')->row_array();

        return $result;

    }

    public function get_order_crt($crt){

        if(empty($crt)){

            return false;
        }

        $this->db->where($crt);

        $result = $this->db->get('order_shipping')->result_array();

        return $result;

    }

    public function get_sum_item_list($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('SUM(item_price*item_count) as price');
        $this->db->where('order_id', $order_id);
        $result =  $this->db->get('order_item_list')->row_array();

        if(empty($result)){
            return 0;
        }

        return $result['price'];
}

    public function get_item_list_count($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('SUM(item_count) as count');
        $this->db->where('order_id', $order_id);
        $result =  $this->db->get('order_item_list')->row_array();

        if(empty($result)){
            return 0;
        }

        return $result['count'];
    }

    public function get_country_profile($country_iso,$currier_id){

        if(!isset($country_iso) || empty($currier_id)){
            return false;
        }

        $this->db->where('currier_id',$currier_id);
        $this->db->where('country_iso',$country_iso);

        $result =  $this->db->get('country_profile')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_all_orders_info($statuses = NULL){

        $this->db->select('order_shipping.*, pick_up_info.shipping_date');
        $this->db->from('order_shipping');
        $this->db->join('pick_up_info', 'order_shipping.id = pick_up_info.order_id', 'left');

        if(!empty($statuses) && is_array($statuses)){
            $this->db->where_in('shipping_status',$statuses);
        }

        $result =  $this->db->get()->result_array();

        return $result;

    }

    public function get_account_order_message($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->order_by("add_date", "DESC");
        return $this->db->get('order_message')->result_array();
    }

    public function get_finicial_notes($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->order_by("add_date", "DESC");
        return $this->db->get('finical_notes')->result_array();

    }

    public function get_pay_history($order_id = NULL, $crt = NULL, $order = 'ASC'){

        $where = [];

        if(!empty($order_id)){

            $where = ['order_id' => $order_id];
        }

        if(!empty($crt)){

            $where = array_merge($where,$crt);
        }

        $this->db->where($where);
        $this->db->order_by('date', $order);

        $result =  $this->db->get('order_payment_history')->result_array();

        if(empty($result)){

            return false;
        }

        return $result;
    }

    public function get_order_count($user_id){

        if(empty($user_id)){
            return false;
        }

        $this->db->where('user_id', $user_id);

        return $this->db->get('order_shipping')->num_rows();
    }

    public function get_pickup_info($order_id,$id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        $this->db->where('order_id', $order_id);

        return $this->db->get('pick_up_info')->row_array();
    }

    public function get_delivery_info($order_id,$id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        $this->db->where('order_id', $order_id);

        return $this->db->get('delivery_info')->row_array();
    }

    public function get_order_type($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('shipping_type');
        $this->db->where('id', $order_id);
        $result = $this->db->get('order_shipping')->row_array();

        if(empty($result)){
            return false;
        }

        return $result['shipping_type'];

    }

    public function get_luggage_order($order_id,$luggage_id = NULL){

        if(empty($order_id)){

            return false;
        }

        $this->db->select('order_luggages.*, luggage_product.sizes_image');
        $this->db->where('order_id', $order_id);

        if(!empty($luggage_id)){
            $this->db->where('id', $luggage_id);
        }

        $this->db->join('luggage_product', 'order_luggages.luggage_id = luggage_product.product_id', 'left');
        return $this->db->get('order_luggages')->result_array();

    }

    public function get_one_luggage_order($order_id,$luggage_id){

        if(empty($order_id) || empty($luggage_id)){

            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('id', $luggage_id);
        return $this->db->get('order_luggages')->row_array();

    }

    public function get_luggage_and_label($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_luggages.order_id', $order_id);

        $this->db->select('order_luggages.*, order_luggages.id AS lug_id,order_luggages.luggage_id AS lug_real_id, order_luggages.luggage_name AS lug_name, order_luggages.weight AS lug_weight, order_luggages.order_id AS real_id, order_files.*, order_files.id AS file_id,order_incurance.*,luggage_product.sizes_image');
        $this->db->from('order_luggages');
        $this->db->join('order_files', 'order_luggages.id = order_files.luggage_id', 'left');
        $this->db->join('order_incurance', 'order_luggages.id = order_incurance.order_luggage_id', 'left');
        $this->db->join('luggage_product', 'order_luggages.luggage_id = luggage_product.product_id', 'left');
        $this->db->order_by('order_luggages.id', 'ASC');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_luggage_and_label_temp($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_luggages.order_id', $order_id);

        $this->db->select('order_luggages.*, order_luggages.id AS lug_id,order_luggages.luggage_id AS lug_real_id, order_luggages.luggage_name AS lug_name, order_luggages.type_name AS types, order_luggages.weight AS lug_weight, order_luggages.order_id AS real_id, trucking_temp_info.*, trucking_temp_info.id AS file_id,order_incurance.*,luggage_product.sizes_image');
        $this->db->from('order_luggages');
        $this->db->join('trucking_temp_info', 'order_luggages.id = trucking_temp_info.luggage_id', 'left');
        $this->db->join('order_incurance', 'order_luggages.id = order_incurance.order_luggage_id', 'left');
        $this->db->join('luggage_product', 'order_luggages.luggage_id = luggage_product.product_id', 'left');
        $this->db->order_by('order_luggages.id', 'ASC');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_pick_up_fee($country_id){

        $this->db->select('*');
        $this->db->where('country_id', $country_id);
        $result = $this->db->get('extra_pickup_fee')->row_array();

        return $result;
    }

    public function get_data_by_zip_code($table_name, $zipcode){

        if(empty($this->table_exists($table_name))){
            return false;
        }

        $this->db->where('zip', $zipcode);

        $result = $this->db->get($table_name)->row_array();

        return $result;

    }

    public function get_credit_card_count_by_id($user_id){

        if(empty($user_id)){

            return false;
        }

        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('users_credit_cards');
    }

    public function get_all_luggages_insurance($order_id)
    {

        if (empty($order_id)) {

            return false;
        }

        $this->db->select('order_luggages.*, order_incurance.insurance, order_incurance.incurance_fee');
        $this->db->from('order_luggages');
        $this->db->join('order_incurance', 'order_luggages.id = order_incurance.order_luggage_id', 'left');
        $this->db->where('order_luggages.order_id',$order_id);


        $result = $this->db->get()->result_array();
        return $result;
    }


    public function get_credit_card_by_id($user_id,$card_num = NULL,$card_id = NULL){

        if(empty($user_id)){

            return false;
        }

        if(!empty($card_num)){

            $this->db->where('card_num', $card_num);
        }

        if(!empty($card_id)){

            $this->db->where('id', $card_id);
            $row = true;
        }

        $where = "user_id = $user_id AND (ver_status='3' OR ver_status='1')";
        $this->db->where($where);

        $credit_cards =  $this->db->get('users_credit_cards');

        if(!empty($row)){

            $credit_cards = $credit_cards->row_array();
        }else{
            $credit_cards = $credit_cards->result_array();
        }

        if(empty($credit_cards)){

            return false;
        }

        return $credit_cards;
    }

    public function get_states_by_id($id){

        if(empty($id)){

            return false;
        }

        $this->db->where('Stateid',$id);

        return $this->db->get('lts_state')->row_array();

    }

    public function get_incurance($order_id,$id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($id)){

            $this->db->where('id',$id);
        }

        $this->db->where('order_id',$order_id);

        $result = $this->db->get('order_incurance')->result_array();

        return $result;
    }

    public function get_delivery_label($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where('order_id',$order_id);

        $result = $this->db->get('delivery_label')->row_array();

        return $result;
    }


    public function get_insurance_fee($order_id){

        if(!$this->valid->is_id($order_id)){
            return false;
        }

        $this->db->select('SUM(incurance_fee) as fee');
        $this->db->where('order_id', $order_id);
        $result =  $this->db->get('order_incurance')->row_array();

        if(empty($result)){
            return NULL;
        }

        return $result['fee'];

    }

    public function get_states_by_name($name, $country_id = NULL){

        if(empty($name)){

            return false;
        }

        $this->db->like('State',$name);

        if(!empty($country_id)){
            $this->db->where('CountryID', $country_id);
        }

        $result = $this->db->get('lts_state')->row_array();

        if(empty($result)){
            return NULL;
        }

        return $result;

    }

    public function get_states_by_short_name($name, $country_id = NULL){

        if(empty($name)){

            return false;
        }

        $this->db->like('s_code',$name);

        if(!empty($country_id)){
            $this->db->where('CountryID', $country_id);
        }

        $result = $this->db->get('lts_state')->row_array();

        if(empty($result)){
            return NULL;
        }

        return $result;

    }

    public function get_submitted_order($user_id, $order_id = NULL){

        if(!$this->valid->is_id($user_id)){
            return false;
        }

        $this->db->select('*');

        $where = [
            'user_id' => $user_id,
            'shipping_status' => SUBMITTED_STATUS[0]
        ];

        $row = false;

        if(!empty($order_id) && $this->valid->is_id($order_id)){
            $where['id'] = $order_id;
            $row = true;
        }

        $this->db->where($where);

        $result = $this->db->get('order_shipping');

        if($row){
            return $result->row_array();
        }

        return $result->result_array();

    }

    public function get_discount_code_info($code){

        if(empty($code)){
            return false;
        }

        $this->db->where(['code' => $code, 'status' => 1]);

        $result = $this->db->get('discount_codes')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_order_form_document($order_id, $file_id = NULL){

        if(empty($order_id)){
            return false;
        }

        $this->db->where(['order_id' => $order_id]);

        if(!empty($file_id) && $this->valid->is_id($file_id)){
            $this->db->where(['id' => $file_id]);
        }

        $result = $this->db->get('order_form_files')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_item_list($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where(['order_id' => $order_id]);

        $result = $this->db->get('order_item_list')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_order_passport_info($order_id){

        if(empty($order_id)){

            return false;
        }

        $this->db->where(['order_id' => $order_id]);

        $result = $this->db->get('order_passport_visa')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_travel($order_id,$user_id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($user_id)){

            $this->db->where(['user_id' => $user_id]);
        }

        $this->db->where(['order_id' => $order_id]);

        $result = $this->db->get('travel_itinerary')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_travel_files($order_id, $user_id = NULL, $file_id = NULL){

        if(empty($order_id)){

            return false;
        }

        if(!empty($user_id)){

            $this->db->where(['user_id' => $user_id]);
        }

        if(!empty($file_id)){

            $this->db->where(['id' => $file_id]);
        }

        $this->db->where(['order_id' => $order_id]);

        $result = $this->db->get('travel_itinerary_files')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function get_carrier_by_name($name){

        if(empty($name)){
            return false;
        }

        $this->db->where(['currier_name' => $name]);

        $result = $this->db->get('lts_currier')->row_array();

        return $result;

    }

    public function get_luggage_insurance($luggage_id){

        if(!$this->valid->is_id($luggage_id)){
            return false;
        }

        $this->db->select('insurance');
        $this->db->where('order_luggage_id', $luggage_id);

        $result = $this->db->get('order_incurance')->row_array();

        if(empty($result)){
            return false;
        }

        return $result['insurance'];

    }

    public function get_order_errors($order_id){

        if(!$this->valid->is_id($order_id)){
            return false;
        }

        $this->db->select('*');
        $this->db->where('order_id', $order_id);

        $result = $this->db->get('order_label_create_errors')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_shedule_pick_up($order_id){

        if(!$this->valid->is_id($order_id)){
            return false;
        }

        $this->db->select('*');
        $this->db->where('order_id', $order_id);

        $result = $this->db->get('order_shedule_pick_up')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_label_shipment($order_id, $label = true){

        if(!$this->valid->is_id($order_id)) {
            return false;
        }

        if($label){
            $label_isset = $this->get_delivery_label_file($order_id);
        }else{
            $label_isset = false;
        }


        if(empty($label_isset)){

            $this->db->select('order_label_shipment_summary.*, order_label_shipment_summary.id AS label_shipping_id');
            $this->db->from('order_label_shipment_summary');
            $this->db->where(array('order_id' => $order_id));

        }
        else {

            $where = [
                'order_label_shipment_summary.order_id' => $order_id,
                'order_files.file_type'  => 'label_shipping',
                'order_files.luggage_id' => '0'
            ];

            $this->db->select('order_label_shipment_summary.*, order_files.*, order_files.id AS file_id, order_label_shipment_summary.id AS label_shipping_id');
            $this->db->from('order_label_shipment_summary');
            $this->db->join('order_files', 'order_label_shipment_summary.order_id = order_files.order_id', 'left');
            $this->db->where($where);

        }

        $result = $this->db->get()->row_array();

        if(empty($result)){
            if(!empty($label_isset)){
                return $label_isset;
            }
            return false;
        }

        return $result;

    }

    public function get_trucking_history($trucking_number, $luggage_id = NULL){

        if(empty($trucking_number)){
            return false;
        }

        $this->db->select('*');

        $this->db->where('truck_num', $trucking_number);

        if($this->valid->is_id($luggage_id)){

            $this->db->where('luggage_id', $luggage_id);
        }

        $result = $this->db->get('trucking_history')->result_array();

        return $result;

    }

    public function get_luggage_info_by_number($trucking_number){

        if(empty($trucking_number)){
            return false;
        }

        $this->db->select('*');

        $this->db->where('tracking_number', $trucking_number);

        $this->db->order_by('id', 'DESC');

        $result = $this->db->get('order_luggages')->result_array();

        if(empty($result)){
            return false;
        }

        return $result[0];

    }

    public function get_trucking_temp_info($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('*');

        $this->db->where('order_id', $order_id);

        $result = $this->db->get('trucking_temp_info')->result_array();

        if(empty($result)){
            return false;
        }

        $return_array = [];

        foreach($result as $single){
            $return_array[$single['luggage_id']] = [
                'id'              => $single['id'],
                'order_id'        => $single['order_id'],
                'trucking_number' => $single['trucking_number'],
                'file_name'       => $single['file_name']
            ];
        }

        return $return_array;

    }

    public function get_single_trucking_temp_info($id, $order_id){

        $this->db->select('*');

        $where = [];
        $return = 0;

        if(!empty($id)){
            $return = 1;
            $where['id'] = $id;
        }

        if(!empty($order_id)){
            $return += 2;
            $where['order_id'] = $order_id;
        }

        if(!empty($where)){
            $this->db->where($where);
        }

        $result = $this->db->get('trucking_temp_info');

        if($return == 1 || $return > 2){

            $result = $result->row_array();

        }else{

            $result = $result->result_array();
        }

        if(empty($result)){
            return NULL;
        }

        return $result;

    }

    public function get_luggage_temp_info($order_id, $luggage_id){

        $this->db->select('*');

        $where = [
            'order_id'   => $order_id,
            'luggage_id' => $luggage_id
        ];

        $this->db->where($where);

        $result = $this->db->get('trucking_temp_info')->row_array();

        if(empty($result)){
            return NULL;
        }

        return $result;

    }

    public function get_delivery_label_file($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('*');

        $where = [
            'order_id'   => $order_id,
            'luggage_id' => '0',
            'file_type'  => 'label_shipping',
        ];

        $this->db->select('order_files.*, order_files.id AS file_id');
        $this->db->where($where);

        $result = $this->db->get('order_files')->row_array();

        return $result;

    }

    public function get_order_final_billing_info($order_id, $luggage_id = NULL){

            if(empty($order_id)){
                return false;
            }

            $this->db->where('order_luggages.order_id', $order_id);

            $row = false;

            if(!empty($luggage_id)){
                $this->db->where('order_luggages.id', $luggage_id);
                $row = true;
            }

            $this->db->select('order_luggages.*, order_luggages.charge_weight AS lug_charge_weight, order_luggages.id AS lug_id, order_luggages.luggage_name AS lug_name, order_luggages.type_name AS lug_type, order_luggages.weight AS lug_weight, order_luggages.order_id AS real_id, order_incurance.*, final_billing_info.*');
            $this->db->from('order_luggages');
            $this->db->join('order_incurance', 'order_luggages.id = order_incurance.order_luggage_id', 'left');
            $this->db->join('final_billing_info', 'order_luggages.id = final_billing_info.order_lug_id', 'left');
            $this->db->order_by('order_luggages.id', 'DESC');

            if($row){
                $result = $this->db->get()->row_array();
            }else{
                $result = $this->db->get()->result_array();
            }

            return $result;

    }

    public function get_insurance_sum($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('SUM(incurance_fee) AS total_fee, SUM(insurance) AS total_insurance');
        $this->db->where('order_id', $order_id);

        $result = $this->db->get('order_incurance')->row_array();

        return $result;

    }

    public function get_single_credit($credit_id){

        if(empty($credit_id)){
            return false;
        }

        $this->db->where('id', $credit_id);

        $result = $this->db->get('admin_credit_history')->row_array();

        return $result;

    }

    public function get_all_order_credits($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->where('order_id', $order_id);

        $result = $this->db->get('admin_credit_history')->result_array();

        return $result;

    }

    public function check_single_final_billing_info($order_id, $luggage_id){

        if(empty($order_id) || empty($luggage_id)){
            return false;
        }

        $this->db->select('id');

        $this->db->where(['order_lug_id'=> $luggage_id, 'order_id' => $order_id]);

        $result = $this->db->get('final_billing_info');

        $result = $result->row_array();

        if(empty($result)){

            return false;
        }else{

            return true;
        }

    }

    public function check_isset_trucking_temp_info($crt){

        if(empty($crt)){
            return false;
        }

        $this->db->select('*');

        $this->db->where($crt);

        $result = $this->db->get('trucking_temp_info');

        $result = $result->row_array();

        if(empty($result)){

            return false;
        }else{

            return true;
        }

    }


    public function search_zip_by($column, $search){

        $this->db->like($column, $search);
        $result = $this->db->get('lts_state')->row_array();
        return $result;

    }

    public function get_order_temp_info($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->select('*');

        $this->db->where('order_id', $order_id);

        $result = $this->db->get('order_temp_info')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    /////// OTHER
    public function check_order_by_id($user_id, $order_id, $additional_status = NULL){

        if(empty($user_id) || empty($order_id)){

            return false;
        }

        $this->db->where(['user_id' => $user_id, 'id'=>$order_id]);
        $statuses = array(INCOMPLETE_STATUS[0],SUBMITTED_STATUS[0]);

        if(!empty($additional_status)){

            $statuses[] = $additional_status;
        }

        $this->db->where_in('shipping_status', $statuses);

        $result = $this->db->get('order_shipping')->num_rows();

        if($result == 1){
            return true;
        }

        return false;

    }

    public function check_label_creating($order_id){

        if(empty($order_id)){

            return false;
        }

        $where = [
            'order_id' => $order_id,
            'file_type' => 'label'
        ];

        $this->db->where($where);

        $result = $this->db->get('order_files')->num_rows();

        if(empty($result)){
            return false;
        }

        return true;

    }

    public function table_exists($table_name){

        if(empty($table_name)){
            return false;
        }

        $sql = "SHOW TABLES LIKE '".strtolower($table_name)."'";

        $data = $this->db->query($sql)->result_array();

        if (empty($data)){
            return 0;
        }

        return 1;
    }

    public function check_user_card($user_id, $card_id){

        if(!$this->valid->is_id($user_id) || !$this->valid->is_id($card_id)){
            return false;
        }

        $where = [
            'user_id'  => $user_id,
            'id'       => $card_id
        ];

        $this->db->where($where);

        $result = $this->db->get('users_credit_cards')->row_array();

        if(empty($result)){
            return false;
        }

        return true;

    }

    public function check_carrier_service_isset($table_name, $carrier_id, $service = NULL){

        if(empty($table_name) ||  empty($carrier_id)){
            return false;
        }

        if(!$this->table_exists($table_name)){
            return false;
        }

        $this->db->select('COUNT(*) as count');
        $this->db->where('currier_id',$carrier_id);

        if(!empty($service)){
            $this->db->like('type', $service, 'both');
        }

        $result = $this->db->get($table_name)->row_array();

        if(empty($result['count'])){
            return false;
        }

        return true;

    }

    public function check_trucking_number_isset_for_order($order_id){

        if(empty($order_id)){
            return false;
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('`tracking_number` IS NOT NULL', null, false);

        $result = $this->db->get('order_luggages')->num_rows();

        if(empty($result)){
            return false;
        }

        return true;

    }

    public function trucking_number_in_use($trucking_number, $order_id){

        if(empty($trucking_number)){
            return false;
        }

        $this->db->where('tracking_number', $trucking_number);

        if(!empty($order_id) && $this->valid->is_id($order_id)){
            $this->db->where('order_id !=', $order_id);
        }

        $result = $this->db->get('order_luggages')->num_rows();

        if(empty($result)){
            return false;
        }

        return true;

    }

    public function update_or_insert_order_temp($data){

        if(empty($data['order_id'])){
            return false;
        }

        $isset = $this->get_order_temp_info($data['order_id']);

        if(!empty($isset)){

            return $this->update_order_temp_info($data['order_id'], $data);
        }

        return $this->insert_order_temp_info($data);

    }

    public function update_or_insert_trucking_temp($batch_array, $order_id){

        if(empty($batch_array) || !is_array($batch_array)){
            return false;
        }

        foreach($batch_array as $single){

            $crt = ['luggage_id' => $single['id'], 'order_id' => $order_id];

            $data_update = ['trucking_number' => $single['tracking_number']];

            $data_insert = [
                'order_id'        => $order_id,
                'luggage_id'      => $single['id'],
                'trucking_number' => $single['tracking_number'],
                'file_name'       => NULL
            ];

            if(!empty($single['file_name'])){
                $data_insert['file_name'] = $single['file_name'];
                $data_update['file_name'] = $single['file_name'];
            }

            $isset = $this->check_isset_trucking_temp_info($crt);

            if($isset){

                $this->update_trucking_temp_info($crt, $data_update);
            }
            else{

                $this->insert_trucking_temp_info($data_insert);
            }

        }

        return true;

    }

    public function remove_user_modify($user_id){

        if(empty($user_id)){
            return false;
        }

        $where = [
            'user_id' => $user_id,
            'user_modify !=' => '0'
        ];

        $this->db->set('user_modify', '0', FALSE);
        $this->db->where($where);

        return $this->db->update('order_shipping');

    }


}

