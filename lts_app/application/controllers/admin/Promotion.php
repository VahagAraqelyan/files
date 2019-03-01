<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Promotion extends CI_Controller
{

    private $admin_alias = ADMIN_PANEL_URL . '/';
    private $admin_dir;
    private $promotion_statuses = [
          '1' => 'Active',
          '2' => 'Expired',
          '3' => 'Suspended'
        ];

    public function __construct()
    {

        parent::__construct();
        $this->load->model("Users_model");
        $this->load->model("Manage_price_model");
        $this->load->model('Lists_model');
        $this->load->model("Promotion_model");
        $this->load->library('captcha_lib');
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index(){

        $this->promotion();

    }

    public function promotion($page = 1){

        $this->check_admin_login();

        $this->Promotion_model->check_statuses();

        if(!is_numeric($page) || $page<= 0){
            $page = 1;
        }

        $table_head_array = [
            'status'            => ['title'=>'Promotions Status'],
            'promotion_type'    => ['title'=>'Promotions type', 'order_type'=>'DESC'],
            'code'              => ['title'=>'Promotion Code', 'order_type'=>'DESC'],
            'create'            => ['title'=>'Created By'],
            'amount_p'          => ['title'=>'Amount', 'order_type'=>'DESC'],
            'date_from'         => ['title'=>'From', 'order_type'=>'DESC'],
            'date_to'           => ['title'=>'To', 'order_type'=>'DESC'],
            'desc'              => ['title'=>'Comments', 'order_type'=>'DESC'],
            'count'             => ['title'=>'Count of use Be/Left'],
            'edit'              => ['title'=>'Edit']
        ];

        $search_data = [
            'date_from'      => '',
            'date_to'        => '',
            'promotion_type' => '',
            'status'         => ''
        ];

        $search_fields = [
            'date_from',
            'date_to',
            'promotion_type',
            'status'
        ];

        if(!empty($this->input->get())){

            foreach ($this->input->get() as $item => $value){

                if(in_array($item,$search_fields)){
                    $search_data[$item] = $value;
                }
            }
        }

        $ordering = [
            'promotion_type',
            'code',
            'created_by',
            'amount_p',
            'date_from',
            'date_to',
            'desc',
        ];

        $order_by_arr = [
            'ASC',
            'DESC'
        ];

        $order_by = NULL;
        $ordering_type = NULL;

        if(in_array(strtoupper($this->input->get('order_type')),$order_by_arr)){
            $ordering_type = strtoupper($this->input->get('order_type'));
        }

        if(in_array(strtolower($this->input->get('order_by')),$ordering)){

            $order_by = strtolower($this->input->get('order_by'));

            if(!empty($table_head_array[$order_by])){

                $table_head_array[$order_by]['active'] = true;

                if($ordering_type == 'DESC'){

                    $table_head_array[$order_by]['order_type'] = 'ASC';
                }else{

                    $table_head_array[$order_by]['order_type'] = 'DESC';
                }
            }
        }

        $this->config->load('promotion');

        $data['content']         = 'backend/admin/promotion_code';
        $data['promotion_types'] = $this->config->item('promotion_types');
        $data['admin_name']      = $this->session->userdata('admin_full_name');
        $data['admin_alias']     = $this->admin_alias;
        $data['table_head']      = $table_head_array;
        $data['statuses']        = $this->promotion_statuses;

        $all_count = $this->Promotion_model->get_all_promo_codes_count($search_data);

        $limit=[10, ($page - 1)*10];

        $config['base_url']       = base_url('admin/promotion/promotion/');
        $config['suffix']         = '/?'.$this->input->server('QUERY_STRING');
        $config['total_rows']     = $all_count;
        $config['per_page']       = 10;
        $config['uri_segment']    = 4;
        $config['num_links']      = 7;
        $config['full_tag_open']  = '<ul class="pagination promotion_pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link']      = '&larr; Previous';
        $config['prev_tag_open']  = '<li class="prev_page"><a href="" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link']      = 'Next &rarr;';
        $config['next_tag_open']  = '<li><a href="" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open']     = '<li class="active"><a href="">';
        $config['cur_tag_close']    = '</a></li>';
        $config['first_url']        = base_url('admin/promotion/promotion/').'/?'.$this->input->server('QUERY_STRING');
        $config['last_link']        = false;
        $config['first_link']       = false;
        $config['attributes']       = array('class' => 'order_pagination');
        $config['use_page_numbers'] = TRUE;

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();

        $data['all_codes'] = $this->Promotion_model->get_all_promo_codes($limit, $search_data, $order_by, $ordering_type);

        if(!empty($data_isset)){
            $data['isset_promotion'] = $data_isset;
        }

        $this->load->view('backend/back_template',$data);

    }

    public function ax_promotion_modal(){

        $this->check_admin_login();

        $this->load->config('promotion');

        $data = [
            'promotion_types' => $this->config->item('promotion_types')
        ];

        $data['promotion_statuses'] = $this->promotion_statuses;

        $id = trim($this->security->xss_clean($this->input->post('id')));

        if($this->valid->is_id($id)){
            $data['isset_promotion'] = $this->Promotion_model->get_code_info_by_id($id);
        }

        $this->load->view('backend/admin/order/promotion_modal', $data);

    }

    public function ax_add_edit_promotion_code(){

        $this->check_admin_login();

        $admin = $this->admin_security->admin_row();

        $this->load->model("Order_model");

        $data['errors']  = [];
        $data['success'] = '';

        $insert_data['code']           = trim($this->security->xss_clean($this->input->post('promo_code')));
        $insert_data['date_from']      = trim($this->security->xss_clean($this->input->post('date_from')));
        $insert_data['date_to']        = trim($this->security->xss_clean($this->input->post('date_to')));
        $insert_data['amount_d']       = trim($this->security->xss_clean($this->input->post('amount_d')));
        $insert_data['amount_p']       = trim($this->security->xss_clean($this->input->post('amount_p')));
        $insert_data['count_of_use']   = intval($this->security->xss_clean($this->input->post('amount_of_use')));
        $insert_data['original_count'] = intval($this->security->xss_clean($this->input->post('amount_of_use')));
        $insert_data['promotion_type'] = trim($this->security->xss_clean($this->input->post('promotion_type')));
        $insert_data['desc']           = trim($this->security->xss_clean($this->input->post('promo_desc')));
        $insert_data['status']         = trim($this->security->xss_clean($this->input->post('status')));
        $edit_id                       = trim($this->security->xss_clean($this->input->post('prom_id')));

        if(empty($insert_data['promotion_type']) && empty($edit_id)){
            $data['errors'][] = 'Please set amount.';
        }

        if(empty($insert_data['code']) && empty($edit_id)){
            $data['errors'][] = 'Promotion Code is required.';
        }

        if(!empty($insert_data['amount_p']) && !empty($insert_data['amount_d']) && empty($edit_id)){
            $data['errors'][] = 'Please set only one type of amount.';
        }

        if(empty($insert_data['amount_p']) && empty($insert_data['amount_d']) && empty($edit_id)){
            $data['errors'][] = 'Please set amount.';
        }

        if(!is_int($insert_data['count_of_use']) && $insert_data['count_of_use'] != '-10'){
            $data['errors'][] = 'Invalid Amount of uses.';
        }

        if($insert_data['date_from'] > $insert_data['date_to'] && $insert_data['date_from'] != '' && $insert_data['date_to'] != ''){
            $data['errors'][] = 'Invalid Date From or Date To.';
        }

        if(empty($insert_data['status'])){
            $data['errors'][] = 'Please select promotion status.';
        }

        $code_info = $this->Promotion_model->get_code_info($insert_data['code']);

        if(!empty($code_info) && empty($edit_id)){
            $data['errors'][] = 'This promotion code already exists.';
        }

        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;
        }

        $insert_data['created_by'] = $admin->admin_name;

        if(empty($edit_id)){

            if(!$this->Promotion_model->insert_promotion_code($insert_data)){

                $dtat['errors'][] = 'Error filling data to database.';
                echo json_encode($data);
                return false;

            }

        }else{

            $code_info = $this->Promotion_model->get_code_info_by_id($edit_id);

            if(empty($code_info)){

                $dtat['errors'][] = 'Undefined id.';
                echo json_encode($data);
                return false;
            }

            $updating_data = [
                'date_from'      => $insert_data['date_from'],
                'date_to'        => $insert_data['date_to'],
                'count_of_use'   => $insert_data['count_of_use'],
                'original_count' => $insert_data['count_of_use'],
                'status'         => $insert_data['status']
            ];

            if(!$this->Promotion_model->update_promotion_code($edit_id, $updating_data)){

                $dtat['errors'][] = 'Error updating data.';
                echo json_encode($data);
                return false;

            }

        }

        echo json_encode($data);
        return false;

    }

    public function remove_promotion_code($promotion_id){

        $this->check_admin_login();

        $this->Promotion_model->delete_promotion_code($promotion_id);

        redirect('admin/promotion', 'refresh');
        return false;

    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }

    }

}


