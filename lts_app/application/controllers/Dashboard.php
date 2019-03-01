<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard extends CI_Controller
{

    private $order_list_row_count = 6;

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
        $this->load->model("Order_model");
        $this->load->model("Lists_model");
        $this->load->model("Dashboard_model");
        $this->config->load('order');
        $this->load->library('Price_lib');
        $this->load->model("Invoice_model");
    }

    public function index(){

        $this->dashboard();
    }

    public function dashboard($page = NULL)
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

        $dashboard_status = array(
            INCOMPLETE_STATUS[0],
            SUBMITTED_STATUS[0],
            PROCESSED_STATUS[0],
            READY_STATUS[0],
            TRANSIT_STATUS[0],
            DELIVERY_STATUS[0],
        );

        $count = $this->Dashboard_model->get_count_order($user->id,$dashboard_status);

        if($page > ceil($count/$row_count) && $count != 0){

            $page = ceil($count/$row_count);
        }

        $limit=[$row_count, ($page - 1)*$row_count];

        $dashboard_status = array(
            INCOMPLETE_STATUS[0],
            SUBMITTED_STATUS[0],
            PROCESSED_STATUS[0],
            READY_STATUS[0],
            TRANSIT_STATUS[0],
            DELIVERY_STATUS[0],
        );

        $order_data =  $this->Dashboard_model->get_all_order($user->id,$limit,$dashboard_status);

        if(empty($order_data)){

            $data['order_data'] = '';

        }

        $config['base_url'] = base_url('dashboard/dashboard/');
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
        $config['first_url'] =  base_url('dashboard/dashboard/');
        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'order_pagination');
        $config['use_page_numbers'] = TRUE;

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['content'] = 'frontend/user/dashboard/main';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';
        $data['order_list_row_count'] = $row_count;
       /* $data['status_array'] = $this->config->item('status_array');*/
        $data['countries'] = $this->Dashboard_model->get_countries_assoc();
        $data['order_item_list'] = [];
        $data['passport_info'] = [];
        $data['travel'] = [];

        if(!empty($order_data)){

            foreach ($order_data as $index => $orders){
                $item_list = $this->Order_model->get_item_list($orders['real_id']);

                if(!empty($item_list)){

                    $data['order_item_list'][$orders['order_id']] = $item_list;
                }
                $passport_info  = $this->Order_model->get_order_passport_info($orders['real_id']);

                if(!empty($passport_info)){

                    $data['passport_info'][$orders['real_id']] = $passport_info;
                }


                $travel = $this->Order_model->get_travel($orders['real_id']);

                if(!empty($travel)){

                    $data['travel'][$orders['real_id']] = $travel;
                }

                $tracking_number = $this->_return_track_number($orders['real_id']);
                $order_data[$index]['tracking_number'] = $tracking_number;
                $order_data[$index]['uploaded_document'] = $this->Order_model->get_order_form_document($orders['real_id']);
                $order_data[$index]['travel_info_file'] = $this->Order_model->get_travel_files($orders['real_id'],$user->id);
                $type_files = $this->Order_model->get_order_files($orders['real_id'],'label');
                $order_data[$index]['type_files'] = $type_files;
                $order_data[$index]['title'] = $this->price_lib->get_status_title($orders['shipping_status']);
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

            $return_data['tracking_number'][] = [
                'luggage_id'      => $luggages['id'],
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

    public function _return_track_number_luggage_info($order_id){

        if(empty($order_id)){

            return false;
        }


        $luggage_info = $this->Order_model->get_luggage_order($order_id);
        $return_data = [];

        foreach ($luggage_info as $luggages){

            if(empty($luggages['tracking_number'])){

                $return_data[] = [
                    'luggage_id'      => $luggages['id'],
                    'type_name' => $luggages['type_name'],
                    'weight' => $luggages['weight'],

                ];

                continue;
            }

            $return_data['tracking_number'][] = [
                'luggage_id'      => $luggages['id'],
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

    public function view_order($order_id = NULL){

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page

            show_404();
            return false;
        }

        if(empty($order_id)){

            show_404();
            return false;
        }

        $view_status = array(
            PROCESSED_STATUS[0],
            CLOSED_STATUS[0],
            READY_STATUS[0],
            TRANSIT_STATUS[0],
            DELIVERY_STATUS[0],
            PROCESSED_CANCEL_STATUS[0],
            SUBMITTED_CANCEL_STATUS[0]
        );

        $user = $this->ion_auth->user()->row();
        $order_info = $this->Order_model->get_order_info($order_id,$user->id,$view_status);

        if(empty($order_info)){

            show_404();
            return false;
        }

        $data['item_name'] = $order_info['signature'];
        $data['passport_info'] = [];
        $data['travel'] = [];

        $passport_info  = $this->Order_model->get_order_passport_info($order_id);
        $travel = $this->Order_model->get_travel($order_id);
        $data['my_carrier'] = $this->Order_model->get_carrier_by_name($order_info['currier_name']);
        $data['uploaded_document'] = $this->Order_model->get_order_form_document($order_id);
        $data['invoice'] = $this->Invoice_model->get_created_invoice($order_id);
        $data['shedule_pickup'] = [];

        $data['passport_info'] = $passport_info;

        if(!empty($travel)){

            $data['travel'] = $travel;
        }

        $data['price_origin'] = $this->price_lib->get_order_fee($order_id,$user->id);

        $incurance_data  = $this->Order_model->get_incurance($order_id);

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
        $data['delivery_info'] = [];
        $data['country'] = [];
        $delivery_label = $this->Order_model->get_delivery_label($order_id);

        if(!empty($delivery_label)){

            $data['delivery_info'] = $delivery_label;
        }

       $receiver_info =  $this->Order_model->get_delivery_info($order_id);

        $country = $this->Users_model->get_countries($delivery_label['country_id']);
        $country_to = $this->Users_model->get_countries($receiver_info['delivery_country_id'],true);

        if(!empty($country[0]['country'])){

            $data['country'] = $country[0]['country'];
            $data['country_sender_info'] = $country[0];
        }

        if(!empty($country_to['country'])){

            $data['country_receiver_info'] = $country_to;
        }


        $data['country_prof_info_sender'] = [
            'hotline' => ''
        ];
        $data['country_prof_info_receiver'] = [
            'hotline' => ''
        ];

        $my_carrier = $this->Order_model->get_carrier_by_name($order_info['currier_name']);
        $country_prof_info_sender = $this->Order_model->get_country_profile($country[0]['iso2'],$my_carrier['id']);
        $country_prof_info_receiver = $this->Order_model->get_country_profile($country_to['iso2'],$my_carrier['id']);

        if(!empty($country_prof_info_sender)){

            $data['country_prof_info_sender'] = $country_prof_info_sender;
        }

        if(!empty($country_prof_info_receiver)){

            $data['country_prof_info_receiver'] = $country_prof_info_receiver;
        }


        $data['info']=[
            'user_name'          => $user->first_name,
            'account_num'        => $user->account_name
        ];

        $data['travel_info_file'] = $this->Order_model->get_travel_files($order_id,$user->id);
        $data['sender_info'] = $this->Order_model->get_pickup_info($order_id);
        $data['receiver_info'] = $this->Order_model->get_delivery_info($order_id);
        $data['pay_history'] = $this->Order_model->get_pay_history($order_id, ['status' => 1]);
        $data['title'] = $this->price_lib->get_status_title($order_info['shipping_status']);
        $data['country_from'] = '';
        $data['country_to'] = '';
        $country_from = $this->Users_model->get_countries($data['sender_info']['pickup_country_id']);
        $country_to = $this->Users_model->get_countries($data['receiver_info']['delivery_country_id']);

        $data['delivery_state'] = '';
        $data['pickup_state']   =  '';

        $delivery_state = $this->Order_model->get_states_by_id($data['receiver_info']['delivery_state']);

        if(!empty($delivery_state)){

            $data['delivery_state'] = $delivery_state['State'];
        }

        $pickup_state = $this->Order_model->get_states_by_id($data['sender_info']['pickup_state']);

        if(!empty($pickup_state)){

            $data['pickup_state'] = $pickup_state['State'];
        }

        if($data['sender_info']['pick_up'] == 2){

            $data['shedule_pickup']    = $this->Order_model->get_shedule_pick_up($order_id);
        }

        $data['label_check'] = $this->Order_model->check_label_creating($order_id);

        if(!empty($country_from[0]['country'])){

            $data['country_from'] = $country_from[0]['country'];
        }

        if(!empty($country_to[0]['country'])){

            $data['country_to'] = $country_to[0]['country'];
        }

        $procesing_fee =$this->Manage_price_model->get_processing_fee($data['sender_info']['pickup_country_id']);

        if(!empty($procesing_fee[0])){

            $data['procesing_fee'] = $procesing_fee[0];
        }

        $data['sender_class']   = $this->_check_info_isset($order_id, 'pick_up');
        $data['delivery_class'] = $this->_check_info_isset($order_id, 'delivery');
        $data['payment_class']  = $this->_check_info_isset($order_id, 'credit_card');

        $tracking_number = $this->_return_track_number_luggage_info($order_info['id']);
        $order_info['tracking_number'] = $tracking_number;

        $data['order_info'] = $order_info;
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';
        $data['content'] = 'frontend/price_page/order_processing';
        $this->load->view('frontend/site_main_template',$data);

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

    public function invoice_file($order_id,$name){

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page

            show_404();
            return false;
        }

        if(empty(trim($order_id)) || empty(trim($name))){

            show_404();
            return false;
        }

        $file_path = FCPATH.'invoices/'.$order_id.'/'.$name;

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
}
?>