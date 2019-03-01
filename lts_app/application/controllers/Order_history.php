<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Order_history extends CI_Controller
{

    private $order_list_row_count = 6;

    private  $status_array = '';


    public function __construct()
    {

        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Order_model");
        $this->load->model("Dashboard_model");
        $this->config->load('order');
        $this->load->library('Price_lib');
        $this->load->model("Invoice_model");

    }

    public function index(){
        $this->history();
    }

    public function history($page = NULL)
    {

        if (!$this->ion_auth->logged_in()) {

            redirect('user/login', 'refresh');

        }

        $user = $this->ion_auth->user()->row();

        $data['info']=[
            'user_name'          => $user->first_name,
            'account_num'        => $user->account_name
        ];


        if(!is_numeric($page) || $page<= 0){

            $page = 1;

        }

        $row_count = &$this->order_list_row_count;

        $count = $this->Dashboard_model->get_count_order($user->id, [CLOSED_STATUS[0], SUBMITTED_CANCEL_STATUS[0], PROCESSED_CANCEL_STATUS[0]]);

        if($page > ceil($count/$row_count) && $count != 0){

            $page = ceil($count/$row_count);
        }

        $limit=[$row_count, ($page - 1)*$row_count];

        $order_data =  $this->Dashboard_model->get_all_order($user->id, $limit, [CLOSED_STATUS[0], SUBMITTED_CANCEL_STATUS[0], PROCESSED_CANCEL_STATUS[0]]);

        if(empty($order_data)){

            $data['order_data'] = '';

        }

        $config['base_url'] = base_url('order_history/history/');
        $config['total_rows'] = $count;
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 3;
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
        $config['first_url'] =  base_url('order_history/history/');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'order_pagination');
        $config['use_page_numbers'] = TRUE;

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['content'] = 'frontend/user/order_history/main';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';
        $data['order_list_row_count'] = $row_count;
        /*$data['status_array'] = $this->status_array;*/
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();

        if(!empty($order_data)){

            foreach ($order_data as $index => $orders){

                $tracking_number = $this->_return_track_number($orders['real_id']);
                $order_data[$index]['tracking_number'] = $tracking_number;
                $order_data[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);
                $charge_info = $this->price_lib->get_order_fee($orders['real_id'], $user->id);
                $order_data[$index]['original_price'] = $charge_info['original_price'];
                $order_data[$index]['invoice'] = $this->Invoice_model->get_created_invoice($orders['real_id']);
                $order_data[$index]['order_price'] = $this->price_lib->get_order_fee($orders['real_id'], $orders['user_id']);

            }
        }
        $data['order_data'] = $order_data;
        $this->load->view('frontend/site_main_template', $data);

    }

    public function _return_track_number($order_id){

        if(empty($order_id)){

            return false;
        }


        $luggage_info = $this->Order_model->get_luggage_order($order_id);

        $return_data = [];

        foreach ($luggage_info as $luggages){

            if(empty($luggages['tracking_number'])){

                continue;
            }

            $return_data['tracking_number'][] = [

                'tracking_number' => $luggages['tracking_number'],
                'type_name' => $luggages['type_name'],
                'weight' => $luggages['weight'],


            ];

        }

        foreach ($luggage_info as $luggages){

            if(empty($luggages['receiver_label'])){

                continue;
            }

            $return_data['receiver_label'][] = $luggages['receiver_label'];

        }

        return $return_data;
    }

}
?>