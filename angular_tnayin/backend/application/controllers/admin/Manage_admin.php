<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Manage_admin extends CI_Controller
{

    private $admin_alias = ADMIN_PANEL_URL . '/';
    private $admin_dir;

    public function __construct()
    {

        parent::__construct();

        $this->load->model("Users_model");
        $this->load->model("Order_model");
        $this->load->model("Lists_model");
        $this->load->model("Admin_model");
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index(){

        $this->view();
    }

    public function view(){

        $this->check_admin_login(SUPER_ADMIN_PERM);

        $data['content']      ='backend/admin/manage_admin';

        $data['admins'] = $this->Admin_model->get_all_admins();

        $data['admin_name']   = $this->session->userdata('admin_full_name');
        $data['admin_alias']  = $this->admin_alias;


        $this->load->view('backend/back_template',$data);

    }

    public function add_or_edit_admin_view(){

        $this->check_admin_login(SUPER_ADMIN_PERM);

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $admin_id  = trim($this->security->xss_clean($this->input->post('admin_id')));

        $data['admin']      = NULL;
        $data['admin_perm'] = NULL;
        $data['all_perm']   = $this->config->item('all_permissions');

        if(!empty($admin_id)){
            $data['admin']      = $this->Admin_model->get_admin_info($admin_id);
            $data['admin_perm'] = $this->Admin_model->get_admin_perm($admin_id);
        }

        $this->load->view('backend/admin/add_admin',$data);

    }

    public function ax_check_add_or_edit_admin(){

        $this->check_admin_login(SUPER_ADMIN_PERM);

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $name          = trim($this->input->post('admin_name'));
        $email         = trim($this->input->post('email'));
        $password      = trim($this->input->post('pass'));
        $conf_password = trim($this->input->post('conf_pass'));
        $admin_id      = trim($this->input->post('admin_id'));
        $login_id      = trim($this->input->post('login_id'));
        $admin_perm    = $this->input->post('admin_perm');

        if(empty($name) || empty($email)){
            $data['errors'][] = 'Sorry, Please fill all the required fields!!!';
        }

        if(empty($error) && !$this->valid->is_email($email)){
            $data['errors'][] = 'Sorry, Invalid email address.';
        }

        if(empty($admin_perm)){
            $data['errors'][] = 'Please set permissions.';
        }

        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;
        }

        if(!empty($admin_id)){

            $batch_insert_perm = [];

            foreach($admin_perm as $single){

                $batch_insert_perm[] = [
                    'admin_id' => $admin_id,
                    'permission' => $single,
                ];

            }

            $update_data['email']      = $email;
            $update_data['admin_name'] = $name;

            if(!empty($password)){

                if(strlen($password) < 8){
                    $data['errors'][] = 'Password must have at least 8 characters.';
                }

                if (!preg_match("#[0-9]+#", $password)) {
                    $data['errors'] = "Password must include at least one number.";
                }

                if (!preg_match("#[a-zA-Z]+#", $password)) {
                    $data['errors'] = "Password must include at least one letter.";
                }

                if(empty($error) && $password != $conf_password){
                    $data['errors'][] = 'Sorry, Password and confirm password does not match.';
                }

                if(!empty($data['errors'])){

                    echo json_encode($data);
                    return false;
                }

                $update_data['password'] = $this->encrypt_admin_pass($password);

            }

            if($this->Admin_model->update_profile_info($admin_id, $update_data)) {

                $this->Admin_model->last_update($admin_id);
                $success[] = 'Admin profile has been updated successfully!!!';

                $this->Admin_model->delete_admin_perm($admin_id);

                $this->Admin_model->insert_batch_admin_perm($batch_insert_perm);

            } else {

                $error[] = 'Error changeing information!!!';
            }

        }else{

            if(strlen($password) < 8){
                $data['errors'][] = 'Password must have at least 8 characters.';
            }

            if (!preg_match("#[0-9]+#", $password)) {
                $data['errors'][] = "Password must include at least one number.";
            }

            if (!preg_match("#[a-zA-Z]+#", $password)) {
                $data['errors'][] = "Password must include at least one letter.";
            }

            if(empty($error) && $password != $conf_password){
                $data['errors'][] = 'Sorry, Password and confirm password does not match.';
            }

            if(empty($login_id)){
                $data['errors'][] = 'Please enter login id';
            }

            if(!$this->Admin_model->check_admin_login_id($login_id)){
                $data['errors'][] = 'This login id already exists.';
            }

            if(!$this->Admin_model->check_admin_email_id($email)){
                $data['errors'][] = 'This Email id already exists.';
            }

            if(!empty($data['errors'])){

                echo json_encode($data);
                return false;
            }

            $insert_data = [
                'admin_name' => $name,
                'email'      => $email,
                'user_id'    => $login_id,
                'password'   => $this->encrypt_admin_pass($password),
                'add_date'   => date('Y-m-d H:i:s'),
                'status'     => '1'
            ];

            $admin_id = $this->Admin_model->add_admin($insert_data);

            if(empty($admin_id)){

                $data['errors'][] = 'Can not fill data to db';

            }else{

                $batch_insert_perm = [];

                foreach($admin_perm as $single){

                    $batch_insert_perm[] = [
                        'admin_id' => $admin_id,
                        'permission' => $single,
                    ];

                }

                $this->Admin_model->delete_admin_perm($admin_id);

                $this->Admin_model->insert_batch_admin_perm($batch_insert_perm);
            }

        }

        echo json_encode($data);

    }

    public function ax_delete_admin(){

        $this->check_admin_login(SUPER_ADMIN_PERM);

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = '';

        $admin_id      = trim($this->input->post('admin_id'));

        if(empty($admin_id)){

            $data['errors'][] = 'Undefined admin id.';
            echo json_encode($data);
            return false;
        }


        if(!$this->Admin_model->delete_admin($admin_id)){

            $data['errors'][] = 'Can not remove data from db.';

        }else{

            $this->Admin_model->delete_admin_perm($admin_id);
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

    private function encrypt_admin_pass($pass) {

        $salt = $this->config->item('salt');
        $pass = sha1($pass.$salt);

        return $pass;
    }
}