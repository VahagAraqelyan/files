<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User_manage extends CI_Controller{

    private $customer_list_row_count = 12;
    private $admin_dir;
    private $traveler_list_row_count = 12;
    private $addres_book_list_row_count = 12;
    private $users_credit_cards_count = 3;
    private $pay_currency = 'usd';
    private $admin_alias = ADMIN_PANEL_URL.'/';
    private $order_count = 12;

    public function __construct(){

        parent::__construct();

        $this->load->library('payment_lib');
        $this->load->model("Ion_auth_model");
        $this->load->model("Users_model");
        $this->load->model('Lists_model');
        $this->lang->load('auth');
        $this->load->library('captcha_lib');
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->load->model("Order_model");
        $this->load->library('Price_lib');
        $this->load->model("Dashboard_model");
        $this->load->library('General_email');
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index(){

        $this->check_admin_login();

        redirect($this->admin_dir.'user_manage/customer_list', 'refresh');

    }

    public function customer_list($page = NULL){

        $this->check_admin_login();

        $search_data = [
            'account_name'  => '',
            'first_name'    => '',
            'email'         => '',
            'user_status'   => ''
        ];

        $search_fields = [
            'account_name',
            'first_name',
            'email',
            'user_status'
        ];

        $table_head_config = [
            '#'                => ['title' => '#'],
            'user_status'      => ['title' => 'Status'],
            'account_name'     => ['title' => 'Account Number'],
            'first_name'       => ['title' => 'Account Name'],
            'company'          => ['title' => 'Company Name'],
            'created_on'       => ['title' => 'Register date', 'order_type' => 'DESC'],
            'email'            => ['title' => 'Email'],
            'last_update_bool' => ['title' => 'Profile Update', 'order_type' => 'DESC'],
            'total_orders'     => ['title' => 'Total Orders', 'order_type' => 'DESC'],
            'total_paid'       => ['title' => 'Total Paid'],
            'account_balance'  => ['title' => 'Balance', 'order_type' => 'DESC'],
            'login'            => ['title' => 'Login by user']
        ];

        if(!empty($this->input->get())){

            foreach ($this->input->get() as $item => $value){

                if(in_array($item,$search_fields)){
                    $search_data[$item] = $value;
                }
            }
        }

        $orders = [
            'created_on',
            'user_status',
            'account_name',
            'first_name',
            'company',
            'created_on',
            'email',
            'total_orders',
            'account_balance',
            'last_update_bool',
        ];

        if(in_array($this->input->get('order'),$orders)){
            $order = $this->input->get('order');
        }

        if(!is_numeric($page) || $page<= 0){

            $page = 1;

        }

        $order_by_arr = [
            'ASC',
            'DESC'
        ];

        $order_by = 'id';
        $ordering_type = 'DESC';

        if(in_array(strtoupper($this->input->get('order_type')),$order_by_arr)){
            $ordering_type = strtoupper($this->input->get('order_type'));
        }

        if(in_array(strtolower($this->input->get('order_by')),$orders)){

            $order_by = strtolower($this->input->get('order_by'));

            if(!empty($table_head_config[$order_by])){

                $table_head_config[$order_by]['active'] = true;

                if($ordering_type == 'DESC'){

                    $table_head_config[$order_by]['order_type'] = 'ASC';
                }else{

                    $table_head_config[$order_by]['order_type'] = 'DESC';
                }
            }
        }

        $row_count = &$this->customer_list_row_count;

        $limit=[$row_count, ($page - 1)*$row_count];
        $costumer_data = $this->Users_model->get_users_info($limit,$search_data,$order_by,$ordering_type);

        /*if($this->input->post('all')){

            $costumer_data = $this->Users_model->get_users_info('',$search_data);
            $row_count = 0;
        }*/



        // Initialize pagination config
        $config['base_url'] = base_url('admin/user_manage/customer_list/');
        $config['suffix'] = '/?'.$this->input->server('QUERY_STRING');
        $config['total_rows'] = $costumer_data['count_costumers_list'];
        $config['per_page'] =  $row_count;
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
        $config['first_url'] = base_url('admin/user_manage/customer_list/').'/?'.$this->input->server('QUERY_STRING');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'costumer_list');
        $config['use_page_numbers'] = TRUE;


        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data['row_count'] = $row_count;
        $data['count'] =  $costumer_data['count_costumers_list'];
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;
        $data['search'] = $search_data;
        $data['table_head'] = $table_head_config;

        $data['filter'] = [
            'status'   => $search_data['user_status'],
            'order'    => $order_by,
            'order_by' => $ordering_type
        ];

       if(!empty($costumer_data['result'])){
            foreach ($costumer_data['result']  as $index => $customer){
                $costumer_data['result'][$index]['paid'] = 0;
                $pay_crt = [
                    'user_id' =>  $customer['id']
                ];

                $all_charges = $this->Order_model->get_pay_history(NULL,$pay_crt);

                $costumer_data[$index]['paid'] = '';
                if(!empty($all_charges)){

                    foreach ($all_charges as $single){

                        $costumer_data['result'][$index]['paid'] += $single['amount'];
                    }
                }
            }
        }

        $data['info'] = $costumer_data['result'];

        $data['content'] ='backend/admin/custumer_list';
        $this->load->view('backend/back_template',$data);

    }

    public function user_account($id = NULL,$page = NULL){

        $this->check_admin_login();

        if(!$this->valid->is_id($id)){

            show_404('Invalid id');
            return false;
        }

        $this->load->config('payment_config');

        $crt = ['id' => $id];
        $data['id'] = $id;

        $data['info'] = $this->Users_model->search_users($crt);

        if(empty($data['info'])){

            show_404('User not found');
            return false;

        }

        $ip_info = $this->Users_model->get_user_ip_info($crt['id']);

        $data['document_select'] = $this->Lists_model->get_data_by_list_key('profile_user_documents');

        $data['cards'] = [];

        $data['traveler_list_row_count'] = $this->traveler_list_row_count;
        $data['addres_book_list_row_count'] = $this->addres_book_list_row_count;

        if(empty($data['info']['files'])){

            $data['info']['files']=[];

        }

        $get_data = $this->input->get();

        $user_order = $this->_get_user_order($id, $page,$get_data);

        $data['states'] = [];
        if(!empty($data['info'][0]['address_country_id'])){
            $data['states'] = $this->Users_model->get_states($data['info'][0]['address_country_id']);
        }
        $data['country'] = $data['info'][0]['address_country_id'];
        $data['all_countries'] = $this->Users_model->get_countries();
        $data['messages'] = $this->Users_model->get_user_message_board($data['id']);
        $cards = $this->Users_model->get_credit_cards(['user_id' => $data['id']]);
        $data['user_ip_info'] = $ip_info;
        $data['cards_count'] = $this->users_credit_cards_count;
        $data['admin_alias'] = $this->admin_alias;
        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['public_key'] = $this->config->item('stripe_public_key');
        $files =  $this->Users_model->get_doc_info($data['id']);
        $data['documents_block'] = $this->load->view('backend/user_profile/uploaded_docs',['files' => $files],true);
        if(!empty($cards)){
            foreach($cards as $single){
                $data['cards'][$single['card_num']] = $single['ver_status'];
            }
        }
        $pay_crt['user_id'] = $id;
        $all_charges = $this->Order_model->get_pay_history(NULL,$pay_crt);

        $data['total_paid'] = 0;
        if(!empty($all_charges)){

            foreach ($all_charges as $single){

                $data['total_paid'] += $single['amount'];
            }
        }

        $data['content'] ='backend/user_profile/main';

        $data = array_merge($data,$user_order);
        $this->load->view('backend/back_template',$data);

    }


    public function _get_user_order($user_id, $page,$get_data)
    {
        $this->check_admin_login();

        if(!is_numeric($page) || $page<= 0){

            $page = 1;

        }

        $search_data_in_view = [
            'order_id'   => '',
            'first_name' => '',
            'email'      => ''
        ];

        $search_data = [
            'order_shipping.order_id'   => '',
            'users.first_name'          => '',
            'users.email'               => ''
        ];

        $search_fields = [
            'order_id',
            'status'
        ];


        if(!empty($get_data)){

            foreach ($get_data as $item => $value){

                if(in_array($item,$search_fields)){

                    $search_data_in_view[$item] = $value;
                }

            }

            foreach ($search_data as $index => $value){

                $exp_index = explode('.',$index);

                if(array_intersect($search_data,$search_data_in_view)){

                    $search_data[$index] = $search_data_in_view[$exp_index[1]];
                }
            }
        }

        $row_count = $this->order_count;
        $count_crt = ['user_id'=>$user_id];
        $limit=[$row_count, ($page - 1)*$row_count];
        $all_count = $this->Dashboard_model->all_get_count_order(NULL,$search_data,NULL,$count_crt,true);
        $all_orders = $this->Dashboard_model->get_all_order($user_id,$limit,'',$search_data, '','', true);
        foreach ($all_orders as $index => $orders){

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);
            $all_orders[$index]['user_info'] = $this->return_user_info($orders['user_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if(!empty($order_luggage['tracking'])){

                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $type_files = $this->Order_model->get_order_files($orders['real_id'],'label');

            if(!empty($type_files)){

                $data['type_files'][$orders['real_id']][] = $type_files;
            }

            if(!empty($order_luggage['count'])){

                $all_orders[$index]['luggage_count'] = $order_luggage['count'];
            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);

            $label_check = $this->label_address_dif_check($orders['real_id']);
            $all_orders[$index]['label_check'] = $label_check;

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if(!empty($pickup_state['State'])){
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if(!empty($delivery_state['State'])){
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $all_orders[$index]['order_price'] = $this->price_lib->get_order_fee($orders['real_id'], $orders['user_id']);

        }
        // Initialize pagination config
        $config['base_url'] = base_url('admin/user_manage/user_account/').$user_id;
        $config['suffix'] = '/?'.$this->input->server('QUERY_STRING');
        $config['total_rows'] = $all_count;
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 5;
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
        $config['first_url'] = base_url('admin/user_manage/user_account').'/'.$user_id.'/?'.$this->input->server('QUERY_STRING');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'order_list');
        $config['use_page_numbers'] = TRUE;


        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data["link"] = $this->pagination->create_links();
        $data['all_orders'] = $all_orders;
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['order_count'] = $this->order_count;
        $data['all_count'] = $all_count;
        $data['cr'] = $search_data_in_view;
        return $data;

    }

    public function _return_luggage_order($order_id){

        $this->check_admin_login();

        if(empty($order_id)){

            return false;
        }

        $return_data = [];

        $order_luggages = $this->Order_model->get_luggage_order($order_id);

        if(empty($order_luggages)){

            return false;
        }

        $total_weight = 0;

        foreach ($order_luggages as $index => $luggage){

            $total_weight += floatval($luggage['weight']);
        }

        $return_data['count'] = count($order_luggages);
        $return_data['total_weight'] = $total_weight;
        return $return_data;

    }


    public function return_user_info($user_id){

        $this->check_admin_login();

        if(empty($user_id)){

            return false;
        }

        $search_data = ['id' => $user_id];

        $user_info = $this->Users_model->search_users($search_data);

        if(empty($user_info)){

            return false;
        }

        return $user_info;
    }

    public function return_luggage_count($order_id){

        $this->check_admin_login();

        if(empty($order_id)){

            return false;
        }

        $return_data = [];
        $data = [];

        $order_luggage = $this->Order_model->get_luggage_order($order_id);

        if(empty($order_luggage)){

            return false;

        }

        foreach ($order_luggage as $luggage){

            if(!empty($return_data[$luggage['type_name']][$luggage['luggage_name']])){

                $return_data[$luggage['type_name']][$luggage['luggage_name']] += 1;

            }else{

                $return_data[$luggage['type_name']][$luggage['luggage_name']] = 1;
            }

            if(!empty($luggage['tracking_number'])){

                $data[] = [
                    'tracking_number' => $luggage['tracking_number'],
                    'luggage_id'      => $luggage['id']
                ];

            }
        }


        return ['count' => $return_data,'tracking' => $data];
    }

    private function label_address_dif_check($order_id){

        $label = $this->Order_model->get_delivery_label($order_id);
        $address = $this->Order_model->get_pickup_info($order_id);

        if(empty($address)){
            return true;
        }

        if(empty($label['address1']) && empty($label['phone']) && empty($label['postal_code']) && empty($label['city'])){
            return true;
        }

        $checking_array = [
            'sender_phone'       => 'phone',
            'pickup_address1'    => 'address1',
            'pickup_address2'    => 'address2',
            'pickup_postal_code' => 'postal_code',
            'pickup_city'        => 'city',
            'pickup_country_id'  => 'country_id',
            'sender_email'       => 'email',
            'sender_first_name'  => 'last_name',
            'sender_last_name'   => 'first_name',
        ];

        foreach ($checking_array as $address_key => $label_key){

            if($address[$address_key] != $label[$label_key]){
                return false;
            }
        }

        return true;

    }

    public function ax_update_status(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $data_update['user_status'] = trim($this->security->xss_clean($this->input->post('status')));
        $user_id                    = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($data_update['user_status']) &&  $data_update['user_status'] == ''){

            $data['errors'][] = 'User account status not checked';

        }

        if($data_update['user_status']>3){

            $data['errors'][] = 'Account Status false';
        }

        if(empty($data['errors']) && empty($user_id)){

            $data['errors'][] = 'User information';
        }

        if(!empty( $data['errors'])){

            echo json_encode($data);
            return false;

        }

        if(!$this->Users_model->update_user($data_update,$user_id)){

            $data['errors'][] = 'Update not success';
            echo json_encode($data);
            return false;

        }

        $data['success'][] = 'Update has been successfully';

        echo json_encode($data);

    }

    /*
 * take states list (for ajax post request)
 * @access public
 * @return void
 */
    public function get_states($action=NULL){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data = trim($this->input->post("country"));
        $data = explode("_", $data);

        $country_id=(!empty($data[1]))?$data[1]:0;

        $states=$this->Users_model->get_states($country_id);

        if(empty($states)){
            echo "nodata";
            return false;
        }

        $this->load->view("frontend/user/small_ajax_templates", ['states'=>$states, 'action' => $action]);

    }


    public function ax_traveler_list(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $page = $this->input->post('page');

        if(empty($page)){

            $page = 1;

        }
        $user_id['id'] = $this->security->xss_clean($this->input->post('user_id'));

        if(empty( $user_id['id'])){

            return false;
        }

        $row_count = &$this->traveler_list_row_count;

        $limit=[$row_count, ($page - 1)*$row_count];

        $list_data = $this->Users_model->get_traveler_list($user_id['id'], NULL, $limit);

        if(empty($list_data)){

            return false;

        }


        // Initialize pagination config
        $config['base_url'] = '#';
        $config['total_rows'] = $list_data['count_all'];
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="#" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li><a href="#" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'travel_pagination');


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $list_data["links"] = $this->pagination->create_links();

        $this->load->view('backend/user_profile/traveler/traveler_list', $list_data);

    }

    public function ax_add_new_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $data=[
            'trav_id'      => '',
            'title'        => 'Add New Traveler',
            'fname'        => '',
            'lname'        => '',
            'phone'        => '',
            'email'        => '',
            'country'      => '0',
            'organization' => '',
            'address1'     => '',
            'address2'     => '',
            'city'         => '',
            'state_reg'    => '',
            'zip_code'     => '',
            'comment'      => '',
            'user_id'      => $user_id,
            'button_id'    => 'add_traveler_but',
            'button_value' => 'ADD'
        ];

        $data['countries'] = $this->Users_model->get_countries();

        $this->load->view('backend/user_profile/traveler/add_new_traveler_modal', $data);

    }

    public function ax_check_add_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $first_name =  trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name  =  trim($this->security->xss_clean($this->input->post('last_name')));
        $phone      =  trim($this->security->xss_clean($this->input->post('phone_number')));
        $email      =  trim($this->security->xss_clean($this->input->post('email')));
        $country    =  trim($this->security->xss_clean($this->input->post('add_trav_country')));
        $organiz    =  trim($this->security->xss_clean($this->input->post('organization')));
        $addres1    =  trim($this->security->xss_clean($this->input->post('address_1')));
        $addres2    =  trim($this->security->xss_clean($this->input->post('address_2')));
        $city       =  trim($this->security->xss_clean($this->input->post('city')));
        $state      =  trim($this->security->xss_clean($this->input->post('state_region')));
        $zipcode    =  trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment    =  trim($this->security->xss_clean($this->input->post('comment')));

        $data['error'] = [];
        $data['success'] = [];

        if(empty($first_name)){

            $data['error'][]='Please enter first name.';

        }

        if(empty($data['error']) && empty($last_name)){

            $data['error'][]='Please enter last name.';

        }

        if(empty($data['error']) && empty($phone)){

            $data['error'][]='Please enter phone number.';

        }

        if(empty($data['error']) && !empty($country) &&  count(explode('_', $country)) != 2){

            $data['error'][]='Invalid country.';

        }elseif(!empty($country)){

            $country = explode("_", $country)[1];
        }


        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }


        $insert_data = [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'phone'        => $phone,
            'email'        => $email,
            'country_id'   => $country,
            'organization' => $organiz,
            'address1'     => $addres1,
            'address2'     => $addres2,
            'city'         => $city,
            'state_id'     => $state,
            'zip_code'     => $zipcode,
            'comment'      => $comment,
            'user_id'      => $this->input->post('user_id')
        ];

        if($this->Users_model->insert_traveler($insert_data)){

            $data['success'][] = 'New traveler '.$first_name.' '.$last_name.' has been added successfully.';

        }else{

            $data['error'][]='Error adding traveler';

        }

        echo json_encode($data);


    }

    public function ax_edit_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $trav_id = trim($this->input->post('traveler_id'));
        $data['error'] = [];
        $data['success'] = [];

        if(empty($trav_id)){

            $data['error'][]='Please select a record to edit.';

        }

        if(empty($data['error']) && count($trav_id) > 1){

            $data['error'][]='Please select only one record to edit.';

        }

        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $traveler_data = $this->Users_model->get_traveler_list($user_id, $trav_id);

        if(empty($traveler_data)){

            $data['error'][]='Undefined traveler';
            echo json_encode($data);
            return false;

        }

        $traveler_data = $traveler_data['travel_list'];


        $data=[
            'trav_id'      => $traveler_data[0]['id'],
            'title'        => 'Edit Traveler',
            'fname'        => $traveler_data[0]['first_name'],
            'lname'        => $traveler_data[0]['last_name'],
            'phone'        => $traveler_data[0]['phone'],
            'email'        => $traveler_data[0]['email'],
            'country'      => $traveler_data[0]['country_id'],
            'organization' => $traveler_data[0]['organization'],
            'address1'     => $traveler_data[0]['address1'],
            'address2'     => $traveler_data[0]['address2'],
            'city'         => $traveler_data[0]['city'],
            'state_reg'    => $traveler_data[0]['state_id'],
            'zip_code'     => $traveler_data[0]['zip_code'],
            'comment'      => $traveler_data[0]['comment'],
            'button_id'    => 'edit_traveler_but',
            'button_value' => 'EDIT',
            'user_id'      => $this->input->post('user_id')
        ];
        $data['countries'] = $this->Users_model->get_countries();
        $data['states'] = $this->Users_model->get_states($traveler_data[0]['country_id']);

        $this->load->view('backend/user_profile/traveler/add_new_traveler_modal', $data);

    }

    public function ax_check_edit_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $traveler_id = trim($this->security->xss_clean($this->input->post('trav_id')));
        $first_name  = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name   = trim($this->security->xss_clean($this->input->post('last_name')));
        $phone       = trim($this->security->xss_clean($this->input->post('phone_number')));
        $email       = trim($this->security->xss_clean($this->input->post('email')));
        $country     = trim($this->security->xss_clean($this->input->post('add_trav_country')));
        $organiz     = trim($this->security->xss_clean($this->input->post('organization')));
        $addres1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $addres2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city        = trim($this->security->xss_clean($this->input->post('city')));
        $state       = trim($this->security->xss_clean($this->input->post('state_region')));
        $zipcode     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment     = trim($this->security->xss_clean($this->input->post('comment')));
        $user_id     = $this->security->xss_clean($this->input->post('user_id'));

        $data['errors'] = [];
        $data['success'] = [];

        if(empty($this->Users_model->get_traveler_list($user_id, $traveler_id))){

            $data['error'][]='Undefined traveler';
            echo json_encode($data);
            return false;

        }

        if(empty($first_name)){

            $data['error'][]='Please enter first name.';

        }

        if(empty($data['error']) && empty($last_name)){

            $data['error'][]='Please enter last name.';

        }

        if(empty($data['error']) && empty($phone)){

            $data['error'][]='Please enter phone number.';

        }

        if(empty($data['error']) && !empty($country) &&  count(explode('_', $country)) != 2){

            $data['error'][]='Invalid country.';

        }elseif(!empty($country)){

            $country = explode("_", $country)[1];
        }


        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }


        $update_data = [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'phone'        => $phone,
            'email'        => $email,
            'country_id'   => $country,
            'organization' => $organiz,
            'address1'     => $addres1,
            'address2'     => $addres2,
            'city'         => $city,
            'state_id'     => $state,
            'zip_code'     => $zipcode,
            'comment'      => $comment,
            'user_id'      => $user_id
        ];

        if($this->Users_model->update_traveler($update_data, $traveler_id)){

            $data['success'][] = 'Traveler information updated successfully.';

        }else{

            $data['error'][]='Error adding traveler';

        }

        echo json_encode($data);

    }

    public function ax_delete_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $traveler_id = trim($this->security->xss_clean($this->input->post('check')[0]['value']));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($traveler_id)){

            $data['errors'][] = 'Sorry! Please select at least one record to delete.';
            echo json_encode($data);
            return false;

        }

        if(empty($this->Users_model->get_traveler_list($user_id, $traveler_id))){

                return false;

        }

        if(!$this->Users_model->delete_treveler($traveler_id)){

            $data['errors'][] = 'Error deleting travelers.';

        }else{

            $data['success'][] = 'Selected travelers has been deleted successfully.';

        }

        echo json_encode($data);

    }

    public function ax_view_traveler_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $traveler_id = trim($this->security->xss_clean($this->input->post('trav_id')));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $data['traveler'] = $this->Users_model->get_traveler_list($user_id, $traveler_id);

        if(empty($data['traveler'])){
            return false;
        }

        $data['traveler'] = $data['traveler']['travel_list'][0];

        $this->load->view('backend/user_profile/traveler/view_traveler_info', $data);

    }

    public function ax_address_book_list(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $page = $this->input->post('page');

        if(empty($page)){

            $page = 1;

        }

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $row_count = &$this->addres_book_list_row_count;

        $limit=[$row_count, ($page - 1)*$row_count];

        $where_data['user_id'] = $user_id;
        $or_where_data['user_id'] = '0';

        $address_array = $this->Users_model->get_address_book_list($where_data, $limit,$or_where_data);

        if(empty($address_array)){



            return false;

        }

        $config['base_url'] = '#';
        $config['total_rows'] = $address_array['count_all'];
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="#" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li><a href="#" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'addrbook_pagination');


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $address_array["links"] = $this->pagination->create_links();

        $this->load->view('backend/user_profile/address/address_book',$address_array);

    }

    public function ax_add_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data = [
            'id'           => '',
            'addr_id'      => '',
            'organiz'      => '',
            'country'      => '',
            'address1'     => '',
            'address2'     => '',
            'city'         => '',
            'state'        => '',
            'zip_code'     => '',
            'comment'      => '',
            'title'        => 'ADD NEW ADDRESS',
            'button_id'    => 'add_new_addr_book',
            'button_value' => 'ADD',
            'user_id'      => $this->input->post('user_id')
        ];

        $data['countries'] = $this->Users_model->get_countries();

        $this->load->view('backend/user_profile/address/add_new_address_modal', $data);


    }

    public function ax_check_add_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $address_id   = trim($this->security->xss_clean($this->input->post('address_id')));
        $organization = trim($this->security->xss_clean($this->input->post('organization')));
        $country      = trim($this->security->xss_clean($this->input->post('add_addr_country')));
        $address1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment      = trim($this->security->xss_clean($this->input->post('comment')));
        $user_id      = $this->security->xss_clean($this->input->post('user_id'));


        $data['errors'] = [];
        $data['success'] = [];


        if(empty($data['errors']) && empty($country)){

            $data['errors'][] = 'Country is required.';

        }

        if(empty($data['errors']) && count(explode('_', $country)) != 2){

            $data['errors'][]='Invalid country.';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Address 1 is required.';

        }


        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $search['contact_id'] = $address_id;
        $search['user_id'] = $user_id;
        $country = explode('_', $country);

        if(!empty($address_id) && !empty($this->Users_model->get_address_book_list($search))){

            $data['errors'][] = 'Sorry! The address id '.$address_id.' is already exist, please try another.';
            echo json_encode($data);
            return false;

        }


        $insert_data=[
            'user_id'    => $user_id,
            'contact_id' => $address_id,
            'country_id' => $country[1],
            'company'    => $organization,
            'address1'   => $address1,
            'address2'   => $address2,
            'city'       => $city,
            'state_id'   => $state,
            'zip_code'   => $zip_code,
            'comment'    => $comment,
            'add_date'   => date('Y-m-d H:i:s')
        ];

        if($this->Users_model->insert_address_book($insert_data)){

            $data['success'][] = 'New address has been added successfully in the address book.';

        }else{

            $data['errors'][] = 'Data inserting error.';

        }

        echo json_encode($data);


    }

    public function ax_edit_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $id = trim($this->security->xss_clean($this->input->post('addr_book')));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($id)){

            return false;

        }

        $data['errors'] = [];

        $base_data = $this->Users_model->get_address_book_list(['user_id' => $user_id, 'address_book.id' => $id]);

        if(empty($base_data)){
            $base_data = $this->Users_model->get_address_book_list(['user_id' => '0', 'address_book.id' => $id]);
            if(empty($base_data)) {
                $data['errors'][] = 'Address not found.';
                echo json_encode($data);
                return false;
            }

        }

        $base_data = $base_data['address_book'][0];

        $data = [
            'id'           => $base_data['id'],
            'addr_id'      => $base_data['contact_id'],
            'organiz'      => $base_data['company'],
            'country'      => $base_data['country_id'],
            'address1'     => $base_data['address1'],
            'address2'     => $base_data['address2'],
            'city'         => $base_data['city'],
            'state'        => $base_data['state_id'],
            'zip_code'     => $base_data['zip_code'],
            'comment'      => $base_data['comment'],
            'button_id'    => 'edit_addr_book',
            'title'        => 'EDIT ADDRESS',
            'button_value' => 'EDIT',
            'user_id'      => $this->input->post('user_id')
        ];

        $data['countries'] = $this->Users_model->get_countries();
        $data['states'] = $this->Users_model->get_states($base_data['country_id']);

        $this->load->view('backend/user_profile/address/add_new_address_modal', $data);

    }

    public function ax_check_edit_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $id           = trim($this->security->xss_clean($this->input->post('addr_id')));
        $address_id   = trim($this->security->xss_clean($this->input->post('address_id')));
        $organization = trim($this->security->xss_clean($this->input->post('organization')));
        $country      = trim($this->security->xss_clean($this->input->post('add_addr_country')));
        $address1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment      = trim($this->security->xss_clean($this->input->post('comment')));
        $user_id      = $this->security->xss_clean($this->input->post('user_id'));


        $data['errors'] = [];
        $data['success'] = [];

        $base_data = $this->Users_model->get_address_book_list(['user_id' => $user_id, 'address_book.id' => $id]);

        if(empty($base_data)){

            $data['errors'][] = 'Address not found.';
            echo json_encode($data);
            return false;

        }

        $base_data = $base_data['address_book'][0];

        if(empty($data['errors']) && empty($country)){

            $data['errors'][] = 'Country is required.';

        }

        if(empty($data['errors']) && count(explode('_', $country)) != 2){

            $data['errors'][]='Invalid country.';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Address 1 is required.';

        }


        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $search['contact_id'] = $address_id;
        $search['user_id'] = $user_id;
        $country = explode('_', $country);

        if(!empty($address_id) && $address_id != $base_data['contact_id'] && !empty($this->Users_model->get_address_book_list($search))){

            $data['errors'][] = 'Sorry! The address id '.$address_id.' is already exist, please try another.';
            echo json_encode($data);
            return false;

        }

        $update_data=[
            'user_id'    => $user_id,
            'contact_id' => $address_id,
            'country_id' => $country[1],
            'company'    => $organization,
            'address1'   => $address1,
            'address2'   => $address2,
            'city'       => $city,
            'state_id'   => $state,
            'zip_code'   => $zip_code,
            'comment'    => $comment,
            'add_date'   => date('Y-m-d H:i:s')
        ];

        if($this->Users_model->update_address_book($update_data, $id)){

            $data['success'][] = 'Address book information updated successfully.';

        }else{

            $data['errors'][] = 'Data updating error.';

        }

        echo json_encode($data);

    }

    public function ax_view_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();


        $id = $this->security->xss_clean($this->input->post('addr_id'));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $base_data = $this ->Users_model->get_address_book_list(['user_id' => $user_id, 'address_book.id' => $id]);

        if(empty($base_data)){

            $base_data = $this->Users_model->get_address_book_list(['user_id' => '0', 'address_book.id' => $id]);

            if(empty($base_data)) {
                $data['errors'][] = 'Address not found.';
                echo json_encode($data);
                return false;
            }

        }

        $base_data = $base_data['address_book'][0];

        $data = [
            'addr_id'      => $base_data['contact_id'],
            'organiz'      => $base_data['company'],
            'country'      => $base_data['country'],
            'address1'     => $base_data['address1'],
            'address2'     => $base_data['address2'],
            'city'         => $base_data['city'],
            'state'        => $base_data['State'],
            'zip_code'     => $base_data['zip_code'],
            'comment'      => $base_data['comment'],
        ];

        $this->load->view('backend/user_profile/address/address_details_modal', $data);

    }

    public function ax_delete_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $id_array = $this->security->xss_clean($this->input->post('check')[0]['value']);
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($id_array)){

            $data['errors'][] = 'Sorry! Please select at least one record to delete.';
            echo json_encode($data);
            return false;

        }
        

            if(empty($this->Users_model->get_address_book_list(['user_id' => $user_id, 'address_book.id' => $id_array]))){
                return false;
            }

        if($this->Users_model->delete_address_book($id_array)){

            $data['success'][] = 'Selected address has been deleted successfully.';

        }else{

            $data['errors'][] = 'Data deleting error';

        }

        echo json_encode($data);

    }


    public function ax_update_user_numbers()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $cell_phone    = trim($this->security->xss_clean($this->input->post('user_number')[0]['value']));
        $fax_number    = trim($this->security->xss_clean($this->input->post('user_number')[1]['value']));
        $hom_off_phone = trim($this->security->xss_clean($this->input->post('user_number')[2]['value']));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $update_data = [];
        $message_data['errors'] = [];
        $message_data['success'] = [];

        $update_data['phone'] = $cell_phone;
        $update_data['fax_number'] = $fax_number;
        $update_data['home_office_phone'] = $hom_off_phone;

        if ($this->ion_auth_model->update($user_id, $update_data)) {

            $message_data['success'][] = 'Your information updated successfully.';

        } else {

            $message_data['errors'][] = 'information update error.';

        }

        echo json_encode($message_data);

    }

    public function ax_update_password()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $new_pass  = trim($this->security->xss_clean($this->input->post('user_number')[0]['value']));
        $conf_pass = trim($this->security->xss_clean($this->input->post('user_number')[1]['value']));
        $id        = $this->security->xss_clean($this->input->post('user_id'));

        $message_data['errors'] = [];
        $message_data['success'] = [];

        if (empty($new_pass)) {

            $message_data['errors'][] = 'Please enter new password.';

        }

        if (empty($message_data['errors']) && strlen($new_pass) < 8) {

            $message_data['errors'][] = 'Required 8-16 digits in new password.';

        }

        if (empty($message_data['errors']) && empty($conf_pass)) {

            $message_data['errors'][] = 'Please enter confirm password.';

        }

        if (empty($message_data['errors']) && ($conf_pass != $new_pass)) {

            $message_data['errors'][] = 'Confirm password does not match.';

        }

        if (!empty($message_data['errors'])) {

            echo json_encode($message_data);
            return false;

        }

        $search_arr = ['id' => $id];
        $data = $this->Users_model->search_users($search_arr)[0];
        $data_pass['password'] = $new_pass;

        $data_inf['username'] = $data['first_name'];
        $header_content = $this->get_email_header();
        $main_coontent = $this->load->view('email_templates/change_password', $data_inf, true);
        $footer_content = $this->get_email_footer();

        $body = $this->load->view(
            'email_templates/main_template',
            [
                'header_content' => $header_content,
                'main_content'   => $main_coontent,
                'footer_content' => $footer_content
            ], true);



        if ($this->ion_auth_model->update($id, $data_pass)) {

            $email_data = array(
                'email'   => $data['email'],
                'to_name' => $data_inf['username'],
                'subject' => 'Your password has been successfully updated  – ' . $data['account_name'],
                'message' => $body
            );


            $send = $this->_send_email($email_data);

            $message_data['success'][] = 'Your password successfully change.';

        } else {

            $message_data['errors'][] = 'Invalid new password.';

        }

        echo json_encode($message_data);


    }

    public function ax_update_user_address()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $company_name = trim($this->security->xss_clean($this->input->post('country_name')));
        $address1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $country      = trim($this->security->xss_clean($this->input->post('country')));
        $user_id      = $this->security->xss_clean($this->input->post('user_id'));

        $update_data = [];
        $message_data['errors'] = [];
        $message_data['success'] = [];

        if(empty($country)){

            $message_data['errors'][] = 'Please select country.';

        }

        if (empty($message_data['errors']) &&  count(explode('_', $country)) != 2) {

            $message_data['errors'][] = 'Invalid country information';

        }

        if(empty($message_data['errors']) && empty($address1)){

            $message_data['errors'][] = 'Please enter address1.';

        }


        if(empty($message_data['errors']) && empty($city)){

            $message_data['errors'][] = 'Please enter city.';

        }



        if(!empty($message_data['errors'])){

            echo json_encode($message_data);
            return false;

        }

        $update_data['company']  = $company_name;
        $update_data['address2'] = $address2;
        $update_data['address_state_id'] = $state;
        $update_data['zipcode']  = $zip_code;
        $country = explode('_',$country);
        $update_data['address1'] = $address1;
        $update_data['city'] = $city;
        $update_data['address_country_id'] = $country[1];

        if($this->ion_auth_model->update($user_id, $update_data)){

            $message_data['success'][] = 'Your information updated successfully.';

        }else{

            $message_data['errors'][] = 'information update error.';

        }

        echo json_encode($message_data);

    }

    public function ax_upload_document(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['success'] = [];
        $data['error'] = [];

        if(empty($this->input->post('user_id'))){

            $data['error'][] = 'Invalid user';
            return false;

        }

        $doc_type_id = $this->security->xss_clean($this->input->post('doc_type_id'));;


        if(empty($doc_type_id)){

            $data['error'][] = 'Please select document name.';
            echo json_encode($data);
            return false;

        }

        $id = $this->security->xss_clean($this->input->post('user_id'));

        $count_document = $this->Users_model->get_count_document($id);

        if($count_document >= 10){

            $data['error'][] = 'Max count of documents  10';
            echo json_encode($data);
            return false;
        }

        $config['upload_path'] = FCPATH.'uploaded_documents/'.$id;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
        $config['max_size']	= 4096;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['error'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $insert_data=[
            'user_id'         => $id,
            'doc_type_id'     => $doc_type_id,
            'doc_type_name'   => $this->Lists_model->get_title_by_id($doc_type_id),
            'show_doc_name'   => $file_info['client_name'],
            'doc_file'        => $file_info['file_name'],
            'reviewed_status' => '0',
            'status'          => '1',
            'add_date'        => date('Y-m-d H:i:s')
        ];

        if(!$this->Users_model->insert_doc_info($insert_data)){

            $data['error'][] = 'Can\'t insert file info';

        }else{

            $data['success'][] = 'Document uploaded successfully.';
            $this->Users_model->last_update($id);

        }


        echo json_encode($data);


    }


    public function ax_remove_document(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['error'] = [];
        $data['success'] = [];

        $file_id = $this->security->xss_clean($this->input->post('doc_id'));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $file_inf = $this->Users_model->remove_user_doc($user_id, $file_id);

        if(empty($file_inf)){

            $data['error'][] = 'Can\'t find document information.';
            echo json_encode($data);
            return false;

        }


        $url = 'uploaded_documents/'.$user_id.'/'.$file_inf[0]['doc_file'];

        if(!file_exists($url)){

            $data['error'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url)){

            $data['error'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $data['success'][] = 'File removed successfully.';
        echo json_encode($data);

    }

    public function ax_get_documents(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

       if(empty($user_id)){

           return false;
       }

        $search_arr = ['id' => $user_id];
        $result = $this->Users_model->search_users($search_arr);

        if(empty($result)){

            return false;
        }

        $data['files'] = $this->Users_model->get_doc_info($user_id);

        if(empty($data['files'])){

            return false;

        }

        $this->load->view('backend/user_profile/uploaded_docs', $data);

    }


    public function _send_email($email_data){

        $this->check_admin_login();

        $this->load->library('email_lib');

        return $res = $this->email_lib->sendgrid_email($email_data);

    }

    private function get_email_header(){

        $header_data=[
            'logo_image'  => 'https://www.luggagetoship.com/assets/email-resources/logo.png',
            'phone_image' => 'https://www.luggagetoship.com/assets/email-resources/phone.png',
            'mail_image'  => 'https://www.luggagetoship.com/assets/email-resources/mail.png',
        ];

        return $this->load->view('email_templates/header',$header_data, true);

    }

    private function get_email_footer(){

        $footer_data=[
            'twitter_image'   => 'https://www.luggagetoship.com/assets/email-resources/twitter.png',
            'fb_image'        => 'https://www.luggagetoship.com/assets/email-resources/facebook.png',
            'google_image'    => 'https://www.luggagetoship.com/assets/email-resources/googleplus.png',
            'pinterest_image' => 'https://www.luggagetoship.com/assets/email-resources/pinterest.png'
        ];

        return $this->load->view('email_templates/footer',$footer_data, true);

    }

    public function ax_add_message_to_board(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $admin_id = $this->session->userdata('admin_id');
        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $meggage = trim($this->security->xss_clean($this->input->post('message')));


        if(empty($meggage) || empty($user_id)){

            return false;
        }

        if($this->Users_model->add_message_to_board($user_id, $admin_id, $meggage)){

            echo true;
        }

        echo false;

    }

    public function ax_get_message_board(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($user_id)){

            echo 'User id is required';
            return false;

        }

        $data['messages'] = $this->Users_model->get_user_message_board($user_id);

        $this->load->view('backend/user_profile/message_board', $data);


    }

    public function ax_reset_user_update(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        if(empty($user_id)){

            return false;

        }

        $data_update['last_update'] = NULL;

        if($this->ion_auth_model->update($user_id, $data_update)){

            echo 'true';

        }else{

            echo 'false';

        }

    }

    public function ax_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $user_id = $this->security->xss_clean($this->input->post('user_id'));
        $card_num = $this->security->xss_clean($this->input->post('card_num'));

        if(empty($user_id) || empty($card_num)){

            return false;

        }


        $data['verify_att'] = [];
        $data['ver_pay'] = '';
        $data['ver_date'] = '';
        $data['verify_att'] = '';


        $card_info = ['user_id' => $user_id, 'card_num' => $card_num];

        $info = $this->Users_model->get_credit_card_info($card_info);

        if(empty($info)){

            $data = [
                'id'                => '',
                'card_id'           => '',
                'holder_first_name' => '',
                'holder_last_name'  => '',
                'company_name'      => '',
                'card_number'       => '',
                'exp_mounth'        => '',
                'exp_year'          => '',
                'security_code'     => '',
                'address1'          => '',
                'address2'          => '',
                'city'              => '',
                'zip_code'          => '',
                'phone'             => '',
                'card_num'          => '',
                'customer_id'       => '',
                'country'           => '',
                'type'              => '',
                'origin'            => '',
                'cvc_check'         => '0',
                'street_check'      => '0',
                'zip_check'         => '0',
                'cc_copy'           => '',
                'cc_bin'            => '',
                'id_copy'           => '',
                'risk_check'        => '0',
                'bank_v'            => '',
                'ver_status'        => '',
                'ver_pay'           => '',
                'ver_date'          => '',
                'button_name'       => 'ADD CC',
                'button_class'      => 'add_credit_card',
                'disable'           => '',
                'sec_val'           => '',
                'card_val'          => '',
                'country_id'        => '',
                'states'            => ''
            ];

        }else{

          $data = $info;
          $ver_pay = $this->Users_model->get_verification_payments([
              'user_id' => $user_id,
              'card_id' => $info['id']

          ]);

          $data['ver_pay'] = $ver_pay[0]['amount'];
          $data['ver_date'] = $ver_pay[0]['date'];
          $data['verify_att'] = $this->Users_model-> get_verify_history($info['id']);
          $data['button_name'] = 'Update CC';
          $data['button_class'] = 'update_cc';
          $data['disable'] = 'disabled';
          $data['sec_val'] = '***';
          $data['card_val'] = '****************';

        }


        $data['countries']   = $this->Users_model->get_countries();
        $data['country']     = $this->Users_model->get_countries($info['country_id']);
        $data['states']      = $this->Users_model->get_states($info['country_id']);
        $data['user_id']     = $user_id;
        $data['card_num']    = trim($this->input->post('card_num'));
        $data['card_number'] = substr($data['card_number'], -4, 4);

        $this->load->view('backend/user_profile/credit_card/credit_card_template',$data);

    }

    public function ax_pay_from_admin(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data['errors']  = [];
        $data['success'] = [];

        $pay = $this->security->xss_clean($this->input->post('int_part')).'.'.$this->security->xss_clean($this->input->post('float_part'));
        $data_id['id'] = $this->security->xss_clean($this->input->post('user_id'));
        $card_inc_id = $this->security->xss_clean($this->input->post('card_id'));

        $result_card = $this->Users_model->get_credit_card_info(['users_credit_cards.id' => $card_inc_id, 'user_id' =>   $data_id['id']]);

        if(empty($result_card)){

            $data['errors'][] = 'Undefined card.';
            echo json_encode($data);
            return false;

        }

        $criteria =[
            'user_id' => $data_id['id'],
            'card_id' => $result_card['id'],
            'card'    => $result_card['card_id']
        ];

        $is_pay = $this->Users_model->get_verification_payments($criteria);

        if(!empty($is_pay)){

            $data['errors'][] = 'The payment for verification has already been made.';
            echo json_encode($data);
            return false;

        }

        $customer_id = $result_card['customer_id'];
        $card_id = $result_card['card_id'];

        $user_inf = $this->Users_model->search_users($data_id);

        if(empty($user_inf)){

            $data['errors'][] = 'Undefined user.';
            echo json_encode($data);
            return false;

        }

        $user_inf = $user_inf[0];

        $user_inf['desc']  = $user_inf['account_name'];

        $payment_array   = [
            'currency' => $this->pay_currency,
            'description' => 'Verification Pay '.$user_inf['desc']
        ];

        $payment_array['customer_id'] = $customer_id;
        $payment_array['card'] = $card_id;
        $payment_array['amount'] = $pay * 100;
        $result = $this->_do_payment_from_customer($payment_array);

        if(!empty($result['errors'])){

            $data['errors'] = $result['errors'];
            echo json_encode($data);
            return false;

        }

        $pay_data = [
            'user_id' =>  $data_id['id'],
            'customer_id' => $customer_id,
            'charge_id' => $result['response']['id'],
            'amount' => $result['response']['amount'],
            'card_id' => $card_inc_id,
            'card' => $card_id,
            'status' => '0',
            'date'  =>  date('Y-m-d H:i:s')

        ];


        $insert_pay = $this->Users_model->insert_verification_payment($pay_data);


        if($insert_pay){

            $this->Users_model->edit_credit_card($card_inc_id, ['ver_status'=>'2', 'ver_attempt'=>'0']);
            $this->Users_model->clear_ver_attempt_his($card_inc_id);

            $data_inf = [
                'first_name' =>$user_inf['first_name'],
                'last_name' =>$user_inf['last_name'],
                'card_number' =>$result_card['card_number'],
                'exp_date' => $result_card['exp_mounth'].'/'.$result_card['exp_year'],
                'charge_date' => date('Y-m-d H:i:s'),
                'username'     => $user_inf['first_name']." ".$user_inf['last_name'],
                'subject_description'     => 'Hi '.$user_inf['first_name']." ".$user_inf['last_name'].', for security reason, our accounting department would like to verify your credit card ending',


            ];

            $email_data = array(
                'email'     => $user_inf['email'],
                'to_name'   => $user_inf['username'],
                'subject'   => 'Please complete the credit card verification process  – ' . $user_inf['account_name'],
                'variables' => $data_inf
            );

            $this->general_email->send_email('credit_card',$email_data);

            $data['success'][] = 'Credit card successfully pay.';

        }else{

            $data['errors'][] = 'Error pay Credit card';
        }

        echo json_encode($data);

    }

    public function ax_update_card_status(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $id = $this->input->post('card_id');

        if(empty($id)){

            return false;
        }

        if(!empty($this->input->post('cc_copy'))){

            $data['cc_copy'] = $this->input->post('cc_copy');

        }else{

            $data['cc_copy'] = '0';
        }

        if(!empty($this->input->post('cc_bin'))){

            $data['cc_bin'] = $this->input->post('cc_bin');

        }else{

            $data['cc_bin'] = '0';
        }

        if(!empty($this->input->post('id_copy'))){

            $data['id_copy'] = $this->input->post('id_copy');

        }else{

            $data['id_copy'] = '0';
        }

        if(!empty($this->input->post('bank_v'))){

            $data['bank_v'] = $this->input->post('bank_v');

        }else{

            $data['bank_v'] = '0';
        }

        $data['ver_status'] = $this->input->post('card_status');

        $result = $this->Users_model->edit_credit_card($id,$data);


    }

    public function ax_update_card_ver_status(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        if(empty($this->input->post('card_id'))){

            return false;
        }


        $data['ver_status'] = $this->input->post('status');
        $id = $this->input->post('card_id');

        $this->Users_model->edit_credit_card($id,$data);

    }

    public function ax_update_cc(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()){

            show_404();
            return false;

        }

        $this->check_admin_login();

        $user_id      = $this->security->xss_clean($this->input->post('user_id'));
        $id           = $this->security->xss_clean($this->input->post('card_id'));
        $fname        = trim($this->security->xss_clean($this->input->post('holder_first_name')));
        $lname        = trim($this->security->xss_clean($this->input->post('holder_last_name')));
        $company_name = trim($this->security->xss_clean($this->input->post('company_name')));
        $exp_mount    = trim($this->security->xss_clean($this->input->post('exp_mounth')));
        $exp_year     = trim($this->security->xss_clean($this->input->post('exp_year')));
        $address1     = trim($this->security->xss_clean($this->input->post('address1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $country      = trim($this->security->xss_clean($this->input->post('credit_card_country')));
        $phone        = trim($this->security->xss_clean($this->input->post('phone')));
        $sec_cod      = trim($this->security->xss_clean($this->input->post('security_code')));


        $update_data = [];
        $data['errors'] = [];
        $data['success'] = [];

        if(empty($id)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;

        }

        $cc_old_info = $this->Users_model->get_credit_card_info(['users_credit_cards.id' => $id, 'user_id'=>$user_id]);

        if(empty($cc_old_info)){

            $data['errors'][] = 'Undefined credit card';
            echo json_encode($data);
            return false;

        }


        if(empty($country)){

            $data['errors'][] = 'Please select country.';

        }

        if (empty($data['errors']) &&  count(explode('_', $country)) != 2) {

            $data['errors'][] = 'Invalid country information';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Please enter address1.';

        }


        if(empty($data['errors']) && empty($city)){

            $data['errors'][] = 'Please enter city.';

        }

        if(empty($data['errors']) && empty($fname)){

            $data['errors'][] = 'Please enter Firsname.';

        }

        if(empty($data['errors']) && empty($lname)){

            $data['errors'][] = 'Please enter Lastname.';

        }

        if(empty($data['errors']) && empty($sec_cod)){

            $data['errors'][] = 'Please enter Security cod.';

        }

        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $card_id = $cc_old_info['card_id'];
        $customer_id = $cc_old_info['customer_id'];


        $update_data['address2'] = $address2;
        $update_data['state_id'] = $state;
        $update_data['zip_code']  = $zip_code;
        $update_data['phone']  = $phone;
        $update_data['address1'] = $address1;
        $update_data['city'] = $city;
        $country = explode('_',$country);
        $update_data['country_id'] = $country[1];

        $update = true;
        if($sec_cod!=='***'){
            $update = false;
        }

        if($update){

            if(empty($address2)){
                $address2 = NULL;
            }
            if(empty($zip_code)){
                $zip_code = NULL;
            }

            $updating_fields_stripe= [
                'address_city'    => $city,
                'address_country' => $country[1],
                'address_line1'   => $address1,
                'address_line2'   => $address2,
                'address_zip'     => $zip_code,
                'exp_month'       => $exp_mount,
                'exp_year'        => $exp_year,
                'name'            => $fname.' '.$lname
            ];

            $result = $this->payment_lib->update_credit_card($customer_id, $card_id,$updating_fields_stripe);

            if(empty($result->id)){

                $data['errors'][] = $result;
                echo json_encode($data);
                return false;

            }

            $update_data['card_id'] = $result->id;


        }else{

            $card_token_info = [
                'number'          => $cc_old_info['card_number'],
                'exp_month'       => $exp_mount,
                'exp_year'        => $exp_year,
                'cvc'             => $sec_cod,
                'address_city'    => $city,
                'address_country' => $country[0],
                'address_line1'   => $address1,
                'address_line2'   => $address2,
                'address_state'   => $state,
                'address_zip'     => $zip_code,
                'name'            => $fname.' '.$lname
            ];

            $create_tok = $this->payment_lib->create_card_token($card_token_info);

            if(empty($create_tok->id)){

                $data['errors'][] = $create_tok;
                echo json_encode($data);
                return false;

            }

            $new_token = $create_tok->id;

            $result = $this->payment_lib->add_credit_card($customer_id, $new_token);

            if(empty($result->id)){
                $data['errors'][] = $result;
                echo json_encode($data);
                return false;
            }

            $this->payment_lib->delete_credit_card($customer_id, $cc_old_info['card_id']);

            $update_data['card_id'] = $result->id;

        }

        $update_data['cvc_check'] = false;
        $update_data['street_check'] = false;
        $update_data['zip_check'] = false;

        if(!empty($result['cvc_check']) && $result['cvc_check'] == 'pass'){
            $update_data['cvc_check'] = true;
        }

        if(!empty($result['address_line1_check']) && $result['address_line1_check'] == 'pass'){
            $update_data['street_check'] = true;
        }

        if(!empty($result['address_zip_check']) && $result['address_zip_check'] == 'pass'){
            $update_data['zip_check'] = true;
        }

        $update_data['holder_first_name'] = $fname;
        $update_data['holder_last_name'] = $lname;
        $update_data['exp_mounth'] = $exp_mount;
        $update_data['exp_year'] = $exp_year;
        $update_data['company_name'] = $company_name;

        if(!$this->Users_model->edit_credit_card($id,$update_data)){

            $data['errors'][] = 'Update not success';

        }else{

            $data['success'][] = 'Update  Successfully';
        }


        echo json_encode($data);

    }

    public function ax_add_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $card_num = $this->security->xss_clean($this->input->post('card_num'));
        $user_id = $this->security->xss_clean($this->input->post('user_id'));


        $data['errors']  = [];
        $data['success'] = [];

        if(empty($card_num) || !$this->valid->is_id($card_num) || empty($user_id)){

            return false;

        }

        if($card_num > 3){

            $data['errors'][] = 'Invalid amounts of credit cards';
            echo json_encode($data);
            return false;

        }

        if($this->Users_model->card_isset($user_id, $card_num)){

            $data['errors'][] = 'Credit card already exists';
            echo json_encode($data);
            return false;

        }

        $country = $this->security->xss_clean($this->input->post('credit_card_country'));
        $country = explode('_',$country);
        if(empty($country[1])){

            $data['errors'][] = 'Invalid country';
            echo json_encode($data);
            return false;

        }

        $data_id['id'] = $user_id;
        $user_info = $this->Users_model->search_users($data_id);

        if(empty($user_info)){

            $data['errors'][] = 'Undefined user.';
            echo json_encode($data);
            return false;

        }

        $user_info = $user_info[0];

        $user_inf['desc']  = $user_info['account_name'];
        $user_inf['email'] = $user_info['email'];

        $payment_array   = [
            'currency' => $this->pay_currency,
            'description' => 'Verification Pay '.$user_inf['desc']
        ];

        $stripeToken = $this->input->post('stripeToken');

        $customer = $this->Users_model->search_customer($user_id);

        if(!$customer){

            $customer = $this->payment_lib->create_customer($stripeToken, $user_inf);


            if(empty($customer->id)){

                $data['errors'][] = $customer;
                echo json_encode($data);
                return false;

            }

            if(!$this->Users_model->insert_customer($user_id, $customer->id)){

                $data['errors'][] = 'Unable to insert customer data.';
                echo json_encode($data);
                return false;

            }

            $payment_array['customer_id'] = $customer->id;
            $payment_array['card'] = $customer->default_source;

        }else{

            $add_card = $this->payment_lib->add_credit_card($customer, $stripeToken);

            if(empty($add_card->id)){
                $data['errors'][] = $add_card;
                echo json_encode($data);
                return false;
            }

            $payment_array['customer_id'] = $customer;
            $payment_array['card'] = $add_card->id;

        }


        $payment_array['amount'] = 50;
        $result = $this->_do_payment_from_customer($payment_array);

        if(!empty($result['errors'])){

            $this->payment_lib->delete_credit_card($payment_array['customer_id'], $payment_array['card']);
            $data['errors'] = $result['errors'];
            echo json_encode($data);
            return false;

        }

        $info      = $this->payment_lib->get_charge_info($result['response']['id']);
        $card_info = $this->payment_lib->get_card_info($payment_array['customer_id'], $payment_array['card']);

        $cvc_check = false;
        $street_check = false;
        $address_zip_check = false;
        $risk_check = false;
        $card_type = NULL;
        $card_country = NULL;

        if(!empty($card_info['cvc_check']) && $card_info['cvc_check'] == 'pass'){
            $cvc_check = true;
        }

        if(!empty($card_info['address_line1_check']) && $card_info['address_line1_check'] == 'pass'){
            $street_check = true;
        }

        if(!empty($card_info['address_zip_check']) && $card_info['address_zip_check'] == 'pass'){
            $address_zip_check = true;
        }

        if(!empty($info['outcome']['risk_level']) && $info['outcome']['risk_level'] != 'elevated'){
            $risk_check = true;
        }

        if(!empty($card_info['brand'])){
            $card_type = $card_info['brand'];
        }

        if(!empty($card_info['country'])){
            $card_country = $card_info['country'];
        }


        $refound = $this->_refund($result['response']['id']);
        if($refound !== true){
            $data['errors'] = $refound;
        }

        $insert_credit_card_info = [
            'holder_first_name' => trim($this->security->xss_clean($this->input->post('holder_first_name'))),
            'holder_last_name'  => trim($this->security->xss_clean($this->input->post('holder_last_name'))),
            'company_name'      => trim($this->security->xss_clean($this->input->post('company_name'))),
            'card_number'       => trim($this->security->xss_clean($this->input->post('card_number'))),
            'exp_mounth'        => trim($this->security->xss_clean($this->input->post('exp_mounth'))),
            'exp_year'          => trim($this->security->xss_clean($this->input->post('exp_year'))),
            'security_code'     => '***',
            'country_id'        => $country[1],
            'address1'          => trim($this->security->xss_clean($this->input->post('address1'))),
            'address2'          => trim($this->security->xss_clean($this->input->post('address2'))),
            'city'              => trim($this->security->xss_clean($this->input->post('city'))),
            'state_id'          => trim($this->security->xss_clean($this->input->post('state_region'))),
            'zip_code'          => trim($this->security->xss_clean($this->input->post('zip_code'))),
            'phone'             => trim($this->security->xss_clean($this->input->post('phone'))),
            'card_num'          => $card_num,
            'user_id'           => $user_id,
            'ver_status'        => '1',
            'card_id'           => $payment_array['card'],
            'customer_id'       => $payment_array['customer_id'],
            'type'              => $card_type,
            'origin'            => $card_country,
            'cvc_check'         => $cvc_check,
            'street_check'      => $street_check,
            'zip_check'         => $address_zip_check,
            'cc_copy'           => false,
            'cc_bin'            => false,
            'id_copy'           => false,
            'bank_v'            => false,
            'risk_check'        => $risk_check,
            'ver_attempt'       => 0
        ];

        $ins_result = $this->Users_model->insert_credit_card($insert_credit_card_info);

        if(!$ins_result['insert']){

            $data['errors'][] = 'Error insert credit card data';

        }

        if(empty($data['errors'])){

            $data['success'][] = 'Credit card successfully registered.';

        }

        echo json_encode($data);

    }

    public function login_by_user(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $data = [
            'errors' => [],
            'success' => ''
        ];

        $user_id = $this->security->xss_clean($this->input->post('user_id'));

        $result = $this->admin_security->login_by_user($user_id);

        if ($result['status'] != 'OK') {

            $data['errors'] = $result['errors'];

        }else{

            $data['success'] = 'login';
        }

        echo json_encode($data);

    }

    public function _do_payment_from_customer($data){

        if(empty($data['amount']) || empty($data['customer_id'])){

            return false;

        }

        $this->check_admin_login();

        $data_res['errors'] = [];
        $data_res['response'] = [];

        $result = $this->payment_lib->do_paymant_from_customer($data);

        if(!empty($result->status) && $result->status == 'succeeded'){

            $data_res['response']['id'] = $result->id;
            $data_res['response']['amount'] = $result->amount;

        }else{

            $data_res['errors'] = $result;

        }

        return $data_res;

    }

    public function _refund($charge, $data = NULL){

        $this->check_admin_login();

        if(empty($charge)){

            return false;

        }

        $data['charge'] = $charge;

        $result = $this->payment_lib->refund($data);

        if($result->status === 'succeeded'){

            return true;

        }

        return $result;

    }

    public function price_check_reports(){

        $this->check_admin_login(CHECK_PRICE_REPORTS);

        $data['admin_alias'] = $this->admin_alias;
        $data['admin_name']  = $this->session->userdata('admin_full_name');
        $data['content']     = 'backend/price_check_reports';
        $data['files'] = [];

        $url = FCPATH.'reports';

        if(is_dir($url)){

            $scan_dir = scandir ($url);

            if(!empty($scan_dir)){

                foreach($scan_dir as $single_file){

                    if($single_file == '.' || $single_file == '..'){
                        continue;
                    }

                    $file_info = pathinfo($url.'/'.$single_file);

                    if(empty($file_info['extension']) || $file_info['extension'] != 'csv'){
                        continue;
                    }

                    $creation_date = date('M-d-y', filemtime($url.'/'.$single_file));

                    $data['files'][] = [
                        'name' => $single_file,
                        'date' => $creation_date
                    ];

                }

            }

        }

        if(!empty($data['files'])){
            $data['files'] = array_reverse($data['files']);
        }

        $this->load->view('backend/back_template', $data);

    }

    public function load_report_pile($file_name)
    {

        $this->check_admin_login(CHECK_PRICE_REPORTS);

        if (empty(trim($file_name))) {

            show_404();
            return false;
        }

        $file_path = FCPATH . 'reports/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        exit;

    }

    public function ax_delete_price_check_report(){

        $this->check_admin_login(CHECK_PRICE_REPORTS);

        $file_name = trim($this->input->post('file_name'));

        $data = [
            'errors' => [],
            'success' => ''
        ];

        if (empty(trim($file_name))) {

            $data['errors'][] = 'Undefined file name.';
            echo json_encode($data);
            return false;
        }

        $file_path = FCPATH . 'reports/'.$file_name;

        if (!file_exists($file_path)) {

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        if(!unlink($file_path)){
            $data['errors'][] = 'Can not delete file.';
        }else{
            $data['success'] = 'File deleted.';
        }

        echo json_encode($data);

    }

    private function check_admin_login($check_perm = NULL) {

        if(!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }

        if(empty($check_perm)){
            return true;
        }

        if(!is_array($check_perm)){
            show_404();
            exit;
        }

        $admin_perm = $this->admin_security->admin_perm();

        if(is_array($check_perm[0])){

            foreach($check_perm as $single_check){
                if(!in_array($single_check[0], $admin_perm)){
                    show_404();
                    exit;
                }
            }

        }else{

            if(!in_array($check_perm[0], $admin_perm)){
                show_404();
                exit;
            }

        }

    }

}

?>