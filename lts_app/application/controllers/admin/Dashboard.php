<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard extends CI_Controller
{

    private $admin_dir;
    private $admin_alias = ADMIN_PANEL_URL.'/';
    private $user_id = '';
    private $new_order_count = 12;
    private $processid_order_count = 12;
    private $ready_order_count = 12;
    public function __construct()
    {

        parent::__construct();

        $this->load->model("Admin_model");
        $this->load->model("Users_model");
        $this->lang->load('auth');
        $this->load->library('captcha_lib');
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->load->model("Manage_price_model");
        $this->load->model("Order_model");
        $this->load->model("Lists_model");
        $this->load->model("Dashboard_model");
        $this->config->load('order');
        $this->admin_dir = $this->admin_security->admin_dir();
        $this->user_id = $this->session->userdata('user_id');
        $this->load->library('Price_lib');

    }

    public function index() {

        $this->check_admin_login();
        redirect($this->admin_alias.'dashboard/', 'refresh');
    }

    public function dashboard(){

        $this->check_admin_login();

        $data = [
            'content' => 'backend/admin/dashboard',
            'admin_alias' => $this->admin_alias,
            'admin_name' => $this->session->userdata('admin_full_name')
        ];

        $data['new_order_count']  = $this->new_order_count;
        $data['processing_order'] = $this->processid_order_count;
        $data['ready_order']      = $this->ready_order_count;

        $this->load->view('backend/back_template', $data);
    }

    public function ax_new_order(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $status_arr = [
            SUBMITTED_STATUS[0],
            SUBMITTED_CANCEL_STATUS[0]
        ];

        $page = trim($this->security->xss_clean($this->input->post('page')));
        $acount_number = trim($this->security->xss_clean($this->input->post('order_number')));
        $name = trim($this->security->xss_clean($this->input->post('first_name')));
        $email = trim($this->security->xss_clean($this->input->post('email')));

        if(empty($page)){

            $page = 1;

        }

        $cr = [
            'order_shipping.order_id'    => '',
            'users.first_name'           => '',
            'users.email'                => ''
        ];

        $or_where = [
            'order_shipping.status_change_by' => '0',
            'shipping_status' => SUBMITTED_CANCEL_STATUS[0]
        ];

        if(!empty($acount_number)){

            $cr['order_shipping.order_id'] = $acount_number;
        }

        if(!empty($name)){

            $cr['users.first_name'] = $name;
        }

        if(!empty($email)){

            $cr['users.email'] = $email;
        }

        $row_count = $this->new_order_count;
        $all_count = $this->Dashboard_model->all_get_count_order($status_arr,$cr, $or_where);

        $limit=[$row_count, ($page - 1)*$row_count];

        $all_orders = $this->Dashboard_model->get_all_order("",$limit,$status_arr,$cr, $or_where, NULL, NULL, ['pick_up_info.shipping_date', 'DESC'] );

        foreach ($all_orders as $index => $orders){

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);
            $all_orders[$index]['order_price'] = $this->price_lib->get_order_fee($orders['real_id'], $orders['user_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if(!empty($order_luggage['tracking'])){

                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if(!empty($pickup_state['State'])){
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if(!empty($delivery_state['State'])){
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $type_files = $this->Order_model->get_order_files($orders['real_id'],'label');

            if(!empty($type_files)){

                $data['type_files'][$orders['real_id']] = $type_files;

            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);

            $label_check = $this->label_address_dif_check($orders['real_id']);
            $all_orders[$index]['label_check'] = $label_check;

        }

        $class = 'new_order_pagination';
        $new_order_link = $this->get_link($all_count,$row_count,$class);
        $data['link'] = $new_order_link;
        $data['all_orders'] = $all_orders;
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['cr'] = $cr;
        $data['new_order_count'] = $this->new_order_count;
        $data['all_count'] = $all_count;
        $data['action'] = 'new_order';
        $data['order_name'] = 'New';
        $data['dashboard_search_cr'] = true;
        $this->load->view('backend/admin/order/status_order',$data);

    }


    public function ax_processing_order(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $status_arr = [
            PROCESSED_STATUS[0],
        ];

        $page = trim($this->security->xss_clean($this->input->post('page')));
        $acount_number = trim($this->security->xss_clean($this->input->post('order_number')));
        $name = trim($this->security->xss_clean($this->input->post('first_name')));
        $email = trim($this->security->xss_clean($this->input->post('email')));

        if(empty($page)){

            $page = 1;

        }

        $cr = [
            'order_shipping.order_id'    => '',
            'users.first_name'           => '',
            'users.email'                => ''
        ];

        $or_where = [
            'order_shipping.status_change_by' => '0',
            'shipping_status' => PROCESSED_CANCEL_STATUS[0]
        ];

        if(!empty($acount_number)){

            $cr['order_shipping.order_id'] = $acount_number;
        }

        if(!empty($name)){

            $cr['users.first_name'] = $name;
        }

        if(!empty($email)){

            $cr['users.email'] = $email;
        }

        $row_count = $this->processid_order_count;
        $all_count = $this->Dashboard_model->all_get_count_order($status_arr,$cr,$or_where);
        $limit=[$row_count, ($page - 1)*$row_count];
        $all_orders = $this->Dashboard_model->get_all_order("",$limit,$status_arr,$cr,$or_where, NULL, NULL, ['pick_up_info.shipping_date', 'DESC']);
        foreach ($all_orders as $index => $orders){

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if(!empty($order_luggage['count'])){

                $all_orders[$index]['luggage_count'] = $order_luggage['count'];

            }else{

                $all_orders[$index]['luggage_count'] = [];
            }

            if(!empty($order_luggage['tracking'])){
                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if(!empty($pickup_state['State'])){
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if(!empty($delivery_state['State'])){
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $type_files = $this->Order_model->get_order_files($orders['real_id'],'label');

            if(!empty($type_files)){

                $data['type_files'][$orders['real_id']] = $type_files;
            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);

            $label_check = $this->label_address_dif_check($orders['real_id']);
            $all_orders[$index]['label_check'] = $label_check;

        }

        $class = 'processid_order_pagination';
        $new_order_link = $this->get_link($all_count,$row_count,$class);
        $data['link'] = $new_order_link;
        $data['all_orders'] = $all_orders;
        /*$data['status_array'] = $this->config->item('status_array');*/
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['cr'] = $cr;
        $data['all_count'] = $all_count;
        $this->load->view('backend/admin/dashboard/processing_order',$data);
    }

    public function ax_ready_order(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $this->check_admin_login();

        $status_arr = [
            READY_STATUS[0]
        ];

        $page = trim($this->security->xss_clean($this->input->post('page')));
        $acount_number = trim($this->security->xss_clean($this->input->post('order_number')));
        $name = trim($this->security->xss_clean($this->input->post('first_name')));
        $email = trim($this->security->xss_clean($this->input->post('email')));

        if(empty($page)){

            $page = 1;

        }

        $cr = [
            'order_shipping.order_id'    => '',
            'users.first_name'           => '',
            'users.email'                => ''
        ];

        if(!empty($acount_number)){

            $cr['order_shipping.order_id'] = $acount_number;
        }

        if(!empty($name)){

            $cr['users.first_name'] = $name;
        }

        if(!empty($email)){

            $cr['users.email'] = $email;
        }

        $row_count = $this->processid_order_count;
        $all_count = $this->Dashboard_model->all_get_count_order($status_arr,$cr);
        $limit=[$row_count, ($page - 1)*$row_count];
        $all_orders = $this->Dashboard_model->get_all_order("",$limit,$status_arr,$cr, NULL, NULL, NULL, ['pick_up_info.shipping_date', 'DESC']);
        foreach ($all_orders as $index => $orders){

            $all_orders[$index]['luggage_info'] = $this->_return_luggage_order($orders['real_id']);

            $order_luggage = $this->return_luggage_count($orders['real_id']);

            if(!empty($order_luggage['count'])){

                $all_orders[$index]['luggage_count'] = $order_luggage['count'];
            }

            if(!empty($order_luggage['tracking'])){

                $all_orders[$index]['tracking'] = $order_luggage['tracking'];
            }

            $pickup_state = $this->Order_model->get_states_by_id($orders['pickup_state']);
            $delivery_state = $this->Order_model->get_states_by_id($orders['delivery_state']);

            if(!empty($pickup_state['State'])){
                $all_orders[$index]['pickup_state'] = $pickup_state['State'];
            }

            if(!empty($delivery_state['State'])){
                $all_orders[$index]['delivery_state'] = $delivery_state['State'];
            }

            $all_orders[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);
        }

        $class = 'ready_order_pagination';
        $new_order_link = $this->get_link($all_count,$row_count,$class);
        $data['link'] = $new_order_link;
        $data['all_orders'] = $all_orders;
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['cr'] = $cr;
        $data['all_count'] = $all_count;
        $data['action'] = 'ready_order';
        $data['order_name'] = 'Ready';
        $data['dashboard_search_ready_cr'] = true;
        $this->load->view('backend/admin/order/status_order',$data);
    }

    private function get_link($count,$row_count,$class){

        // Initialize pagination config
        $config['base_url'] = '#';
        $config['total_rows'] = $count;
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
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
        $config['attributes'] = array('class' => $class);
        $config['last_link'] = false;
        $config['first_link'] = false;
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $links = $this->pagination->create_links();

        return $links;
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

            $total_weight += floatval($luggage['charge_weight']);
        }

        $return_data['count'] = count($order_luggages);
        $return_data['total_weight'] = $total_weight;
        return $return_data;

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
                    'luggage_id'      => $luggage['id'],
                    'status_detail'   => $luggage['status_detail'],
                    'shipping_status' => $luggage['shipping_status']
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


    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }
    }

}
?>