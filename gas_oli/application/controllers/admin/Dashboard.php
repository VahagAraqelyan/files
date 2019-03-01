<?php
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('captcha_lib');
        $this->load->model("Admin_model");
    }

    public function index()
    {

    $this->dashboard();
    }

    public function dashboard(){

        $this->check_admin_login();
        $data['content'] = 'admin/dashboard/dashboard';

        $this->load->view('admin/back_template',$data);
    }

    public function logout(){

        $this->check_admin_login();
        $this->session->sess_destroy();
        redirect('admin-panel', 'refresh');
    }

    public  function ax_get_socket_id(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['socket_id'] = $this->input->cookie('io');

        echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);


    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }
    }
}