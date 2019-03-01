<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct(){

		parent::__construct();
	}

    public function get_user_info($user_id){

        if(empty($user_id)) {
           return false;
        }

        $result = $this->db->get_where('users', ['id' => $user_id])->row_array();

        return $result;

    }

	public function get_captcha_count($word, $ip){

        $expiration = time() - 1800;
        $this->db->where('captcha_time < ', $expiration)->delete('captcha');


        $sql = "SELECT COUNT(*) AS count FROM captcha 
                WHERE word = '".$this->db->escape_str($word)."' AND 
                      ip_address = '".$ip."' AND 
                      captcha_time > '".$expiration."'";

	    return $this->db->query($sql)->row();

    }


    public function get_countries($county_id = null, $row = false){

	    $sql = "SELECT * FROM lts_country WHERE status = 1 ";

        if(isset($county_id)){

            $sql .= " AND id = '".$county_id."'";

        }

        $sql.='ORDER BY id = "226" DESC, country ASC';

        if($row){

            $result = $this->db->query($sql)->row_array();
        }else{

            $result = $this->db->query($sql)->result_array();
        }

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_states($country_id, $state_id = NULL){

        if(empty($country_id)){
            return false;
        }

        $where = [
            'CountryID' => $country_id
        ];

        if($state_id !== NULL){
            $where['Stateid'] = $state_id;
        }

        $query = $this->db->get_where('lts_state', $where)->result_array();

        return($query);

    }

    public function get_count_order($status, $where = NULL){

        if(empty($status)){

            return false;
        }

        if(is_array($status)){

            $this->db->where_in('shipping_status', $status);
        }else{

            $this->db->where('shipping_status', $status);
        }

        if(!empty($where)){
            $this->db->or_group_start();
            $this->db->where($where);
            $this->db->group_end();
        }

        $this->db->from('order_shipping');
        $count_all = $this->db->count_all_results();

        if(empty($count_all)){

            $count_all = 0;
        }

        return $count_all;
    }

    public function search_users($data){

        if(empty($data)){
            return false;
        }

        $this->db->order_by('account_name', 'DESC');

        $query = $this->db->get_where('users', $data)->result_array();

        if(empty($query)){
            return false;
        }

        return $query;

    }

    public function last_update($user_id){

        if(empty($user_id)){

            return false;

        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', ['last_update' =>  date('Y-m-d H:i:s'), 'last_update_bool'=>'1']);

    }

    public function insert_doc_info($insert_data){

        if(empty($insert_data)){

            return false;

        }

        return $this->db->insert('user_doc_files', $insert_data);

    }


    public function get_doc_info($user_id, $file_id = NULL){

        if(empty($user_id)){

            return false;

        }

        if(!empty($file_id)){

            $data['id'] = $file_id;

        }

        $data['user_id'] = $user_id;

        $result = $this->db->get_where('user_doc_files', $data)->result_array();

        if(empty($result)){

            return false;

        }

        return $result;

    }

    public function remove_user_doc($user_id,$file_id){

        if(empty($file_id) || empty($user_id)){

            return false;

        }

        $user_doc = $this->get_doc_info($user_id, $file_id);

        if(empty($user_doc)){

            return false;

        }

        $data=[
            'id' => $file_id,
            'user_id' => $user_id
        ];

        $this->db->where($data)->delete('user_doc_files');

        return $user_doc;

    }

    public function insert_traveler($data){

        if(empty($data)){

            return false;

        }

        return $this->db->insert('travelers_list', $data);

    }

    public function update_traveler($update_data, $id){

        $this->db->where('id', $id);
        return $this->db->update('travelers_list', $update_data);

    }

    public function get_traveler_list($user_id = NULL, $travel_id = NULL, $limit = NULL){

        $data = [];

        if(!empty($user_id)){

            $data['travelers_list.user_id'] = $user_id;

        }

        if(!empty($travel_id)){

            $data['travelers_list.id'] = $travel_id;

        }

        $this->db->select('travelers_list.*, lts_country.country, lts_country.iso2, lts_state.s_code, lts_state.State');
        $this->db->from('travelers_list');
        $this->db->join('lts_country', 'lts_country.id = travelers_list.country_id', 'left');
        $this->db->join('lts_state', 'lts_state.Stateid = travelers_list.state_id', 'left');

        $this->db->where($data);

        $temp_data = $data;

       /* $data['travelers_list.user_id'] = '0';*/

        $this->db->or_group_start();
        $this->db->where($data);
        $this->db->group_end();

        if(!empty($limit)) {
            $this->db->limit($limit[0], $limit[1]);
        }

        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();

        $this->db->where($temp_data);
        $this->db->or_group_start();
        $this->db->where($data);
        $this->db->group_end();

        $count_all = $this->db->count_all_results('travelers_list');

        if(empty($query)){

            return false;

        }

        return [
            'travel_list' => $query,
            'count_all'   => $count_all
        ];

    }

    public function check_traveller($crt, $or_crt = NULL){

        if(empty($crt)){
            return false;
        }

        $this->db->where($crt);


        if(!empty($or_crt)){
            $this->db->or_group_start();
            $this->db->where($or_crt);
            $this->db->group_end();
        }

        $this->db->from('travelers_list');

        $result = $this->db->count_all_results();

        return $result;

    }

    public function delete_treveler($id){

        if(empty($id)){
            return false;
        }

        $this->db->where_in('id', $id);

        return $this->db->delete('travelers_list');
    }

    public function get_address_book_list($where, $limit = NULL, $or_where = NULL){

        if(empty($where)){
            return false;
        }

        $this->db->select('address_book.*, lts_country.country, lts_country.iso2, lts_state.s_code, lts_state.State');
        $this->db->from('address_book');
        $this->db->join('lts_country', 'lts_country.id = address_book.country_id', 'left');
        $this->db->join('lts_state', 'lts_state.Stateid = address_book.state_id', 'left');
        $this->db->where($where);

        if(!empty($or_where)){
            $this->db->or_group_start();
            $this->db->where($or_where);
            $this->db->group_end();
        }

        if(!empty($limit)) {
            $this->db->limit($limit[0], $limit[1]);
        }

        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();

        $this->db->where($where);

        if(!empty($or_where)){
            $this->db->or_group_start();
            $this->db->where($or_where);
            $this->db->group_end();
        }

        $count_all = $this->db->count_all_results('address_book');

        if(empty($query)){
            return false;
        }

        return  [
            'address_book' => $query,
            'count_all'    => $count_all
        ];

    }

    public function insert_address_book($data){

        if(empty($data)){

            return false;

        }

        return $this->db->insert('address_book', $data);

    }

    public function update_address_book($update_data, $id){

        $this->db->where('id', $id);
        return $this->db->update('address_book', $update_data);

    }

    public function delete_address_book($id){

        if(empty($id)){
            return false;
        }

        $this->db->where_in('id', $id);

        return $this->db->delete('address_book');
    }

    public function check_address($crt, $or_crt = NULL){

        if(empty($crt)){
            return false;
        }

        $this->db->where($crt);

        if(!empty($or_crt)){
            $this->db->or_group_start();
            $this->db->where($or_crt);
            $this->db->group_end();
        }

        $this->db->from('address_book');

        return $this->db->count_all_results();

    }

    public function get_credit_card_info($data){

        if(empty($data)){
            return false;
        }

        $this->db->select('users_credit_cards.*, lts_country.country, lts_country.iso2, lts_state.s_code, lts_state.State');
        $this->db->from('users_credit_cards');
        $this->db->join('lts_country', 'lts_country.id = users_credit_cards.country_id', 'left');
        $this->db->join('lts_state', 'lts_state.Stateid = users_credit_cards.state_id', 'left');
        $this->db->where($data);
        $query = $this->db->get()->row_array();

        if(empty($query)){
            return false;
        }

        return $query;

    }

    public function search_customer($user_id){

        if(empty($user_id)){

            return false;

        }

        $data = $this->db->get_where('users', array('id' => $user_id))->row();

        if(empty($data->customer_id)){

            return false;

        }

        return $data->customer_id;

    }

    public function insert_customer($user_id, $customer_id){

        if(empty($user_id) || empty($customer_id)){

            return false;

        }

        $this->db->where('id', $user_id);

        return $this->db->update('users', ['customer_id' => $customer_id]);

    }

    public function insert_verification_payment($data){

        if(empty($data['user_id']) || empty($data['customer_id']) || empty($data['charge_id'])){

            return false;

        }

        return $this->db->insert('verification_payments', $data);

    }

    public function get_verification_payments($data = NULL){

        $this->db->order_by("id", "desc");
        $result = $this->db->get_where('verification_payments', $data)->result_array();

        if(empty($result)){

            return false;

        }

        return $result;

    }

    public function change_verification_payment_status($id, $status){

        if(empty($id)){

            return false;

        }

        $this->db->where('id', $id);
        return $this->db->update('verification_payments', ['status' => $status]);

    }

    public function insert_credit_card($data){

        if(empty($data['user_id']) || empty($data['customer_id'])){

            $response = [
                'insert'    => false,
                'insert_id' => NULL
            ];

            return $response;

        }


        $response = [
            'insert'    => $this->db->insert('users_credit_cards', $data),
            'insert_id' => $this->db->insert_id()
        ];

        return $response;

    }

    public function card_isset($user_id, $card_num, $card_id = NULL){

        if(empty($user_id) || empty($card_num)){

            return false;

        }

        $data = [
            'user_id'  => $user_id,
            'card_num' => $card_num
        ];

        if(!empty($card_id)){

            $data['id'] = $card_id;

        }

        $query = $this->db->get_where('users_credit_cards', $data)->result_array();

        if(empty($query)){

            return false;

        }

        return true;

    }

    public function edit_credit_card($card_id, $update_data){

        if(empty($card_id)){

            return false;

        }

        $this->db->where('id', $card_id);
        return $this->db->update('users_credit_cards', $update_data);

    }


    public function get_users_info($limit = NULL,$search_data = NULL,$order = 'id',$order_by = 'DESC'){

        if(!is_numeric($limit)) {

            $this->db->limit($limit[0], $limit[1]);

        }

        if(!empty($search_data)){

            $this->db->like($search_data);
        }

        $this->db->order_by($order,$order_by);
        $result = $this->db->get('users')->result_array();

        $this->db->from('users');

        if(!empty($search_data)){

            $this->db->like($search_data);
        }

        $count_costumers_list =  $this->db->count_all_results();

        return  [
            'result'                  => $result,
            'count_costumers_list'    => $count_costumers_list
        ];
    }


    public function update_user($data,$user_id){

        if(empty($data) || $data == '' || empty($user_id)){

            return false;
        }

        $this->db->where('id', $user_id);
        $result = $this->db->update('users', $data);

        return $result;
    }

    public function delete_credit_card($id){

        if(empty($id)){
            return false;
        }

        return $this->db->delete('users_credit_cards', array('id' => $id));

    }

    public function get_credit_cards($data = NULL){

        $query = $this->db->get_where('users_credit_cards', $data)->result_array();

        if(empty($query)){
            return false;
        }

        return $query;

    }

    public function get_user_message_board($user_id){

        if(empty($user_id)){
            return false;
        }

        $this->db->select('message_board.*, admins.admin_name');
        $this->db->from('message_board');
        $this->db->join('admins', 'message_board.admin_id = admins.admin_id', 'left');
        $this->db->where(['message_board.user_id' => $user_id]);
        $this->db->order_by('id','DESC');
        $query = $this->db->get()->result_array();

        if(empty($query)){

            return false;

        }

        return $query;
    }

    public function add_message_to_board($user_id, $admin_id, $message){

        if(empty($user_id) || empty($admin_id)){
            return false;
        }

        $data = [
            'admin_id'    => $admin_id,
            'user_id'     => $user_id,
            'message_txt' => $message,
            'add_date'    => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('message_board', $data);

    }

    public function get_user_ip_info($user_id){

        if(empty($user_id)){

            return false;
        }

        $sql = 'SELECT * FROM lts_login_history WHERE user_id = '.$this->db->escape($user_id).' ORDER BY id ASC LIMIT 1';
        $data1 = $this->db->query($sql)->result_array();
        $sql = 'SELECT * FROM lts_login_history WHERE user_id = '.$this->db->escape($user_id).' ORDER BY id DESC LIMIT 3 ';
        $data2 = $this->db->query($sql)->result_array();
        $data = array_merge($data1, $data2);

        if(empty($data)){
            return false;
        }

        return $data;

    }

    public function get_count_document($user_id){

        if (empty($user_id)){

            return false;

        }

        $this->db->where('user_id', $user_id);
        $count_documents =  $this->db->count_all_results('user_doc_files');

        return $count_documents;

    }

    public function insert_ver_attempt($data){

        if(empty($data['card_id'])){
            return false;
        }

        $data['date'] = date('Y-m-d H:i:s');

        return $this->db->insert('verify_attempt_history', $data);

    }

    public function get_verify_history($card_id){

        if(empty($card_id)){

            return false;
        }

        $this->db->order_by('date', 'DESC');
        $query = $this->db->get_where('verify_attempt_history', ['card_id' => $card_id])->result_array();

        return $query;
    }

    public function clear_ver_attempt_his($card_id){

        if(empty($card_id)){
            return false;
        }

        $this->db->where('card_id', $card_id);
        $this->db->delete('verify_attempt_history');

    }

    public function get_us_country($row = NULL){

        $this->db->where('iso2','us');

        if(empty($row)){

            $data = $this->db->get('lts_country')->result_array();

        }else{
            $data = $this->db->get('lts_country')->row_array();
        }

        return $data;
    }

    public function get_user_card_nums($user_id){

        if(!$this->valid->is_id($user_id)){
            return false;
        }

        $this->db->select('card_num');
        $this->db->where('user_id', $user_id);

        $result = $this->db->get('users_credit_cards')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_array[] = $single['card_num'];
        }

        return $return_array;

    }

    public function change_total_paid($user_id, $amount){

        if(empty($user_id) || empty($amount)){
            return false;
        }

        $this->db->set('total_paid', 'total_paid+'.$amount, FALSE);
        $this->db->where('id', $user_id);

        return $this->db->update('users');

    }

    public function change_user_credit($user_id, $amount, $do){

        if(empty($user_id) || empty($amount)){
            return false;
        }

        $this->db->set('account_credit', 'account_credit'.$do.$amount, FALSE);
        $this->db->where('id', $user_id);

        $result = $this->db->update('users');

        return $result;

    }

    public function get_old_users(){

        $this->db->select('*');

        $result = $this->db->get('lts_user_info')->result_array();

        return $result;

    }

    public function update_old_user($id){

        $this->db->where('id', $id);

        $update_data['change_date'] = 1;

        return $this->db->update('lts_user_info', $update_data);

    }

    public function update_user_crt($data,$crt){

        if(empty($data)  || empty($crt)){

            return false;
        }

        $this->db->where($crt);
        $result = $this->db->update('users', $data);

        return $result;
    }



}

/* End of file Users_model.php */
/* Location: ./application/models/Users_model.php */
 ?>