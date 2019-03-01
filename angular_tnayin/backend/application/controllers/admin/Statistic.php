<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Statistic extends CI_Controller{

    private $admin_dir;
    private $admin_alias = ADMIN_PANEL_URL . '/';

    public function __construct(){

        parent::__construct();

       $this->load->model("Admin_model");
        $this->load->model("Users_model");
        $this->load->model("Statistic_model");
        $this->load->library('Admin_security');
        $this->load->model("Order_model");
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index() {

        $this->check_admin_login(STATISTIC);


        $data['admin_name'] = $this->session->userdata('admin_full_name');
        $data['admin_alias'] = $this->admin_alias;
         $data['content'] = 'backend/order_statistic';

        $this->load->view('backend/back_template', $data);
    }


    public function search_statistic(){

        $this->check_admin_login(STATISTIC);

        $statistic_data = trim($this->security->xss_clean($this->input->post('date')));

        if(empty($statistic_data)){

            echo 'Please add search';
            return false;
        }

        $date_day_month = explode('-',$statistic_data);
        $data_int = $this->Statistic_model->get_orders($date_day_month);

        if(empty($data_int)){
            echo 'No Result';
            return false;
        }

        $int_arr  = [];
        $dom_arr  = [];
        $date_arr = [];

        foreach ($data_int as $item =>$value){

            if(empty($value['cnt_iner'])){

                $value['cnt_iner'] = 0;
            }

            if(empty($value['cnt_dom'])){

                $value['cnt_dom'] = 0;
            }

            $int_arr[]  = $value['cnt_iner'];
            $dom_arr[]  = $value['cnt_dom'];
            $date = explode('-',$value['sdate']);
            $date_arr[] = $date[2];
        }

        $data['int_arr']  = $int_arr;
        $data['dom_arr']  = $dom_arr;
        $data['date_arr'] = $date_arr;

        $this->load->view('backend/order_statistic_ajax', $data);
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