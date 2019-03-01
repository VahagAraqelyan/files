<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class admin extends CI_Controller{

    private $customer_list_row_count = 3;
    private $admin_dir;
    private $admin_alias = ADMIN_PANEL_URL.'/';

    public function __construct(){

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
        $this->config->load('order');
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index() {

        $this->check_admin_login();
        redirect('admin/dashboard/dashboard', 'refresh');

    }

    public function user_file($id, $file_name = NULL){

        $this->check_admin_login();

        if(!$this->valid->is_id($id) || empty(trim($file_name))){

            show_404();
            return false;
        }

        $file_path = FCPATH.'uploaded_documents/'.$id.'/'.$file_name;

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

    public function login(){

        //validate form input
        $this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('code', 'Security Code', 'required|xss_clean');

        $captcha_word = $this->input->post('code');
        $ip=$this->input->ip_address();


        $this->data["username"]   = trim($this->input->post('username'));
        $this->data['message']    = "";

        if ($this->form_validation->run() == true) {

            if(!$this->captcha_lib->is_captcha($captcha_word, $ip)){

                //if captcha is not the same
                $this->data['captcha'] = $this->captcha_lib->get_captcha();
                $this->data["username"] = trim($this->input->post('username'));
                $this->data['message']  = 'Invalid security code.';
                $this->load->view('backend/admin/login', $this->data);
                return false;
            }

            $username = trim($this->input->post('username'));
            $password = trim($this->input->post('password'));

            // check to see if the Admin is logging in
            if ($this->_login($username, $password)) {
                redirect('admin/dashboard/dashboard', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->data['captcha']    = $this->captcha_lib->get_captcha();
                $this->data["username"]    = trim($this->input->post('username'));
                $this->data['message']  = 'Invalid Username and/or Password.';
                $this->load->view('backend/admin/login', $this->data);
                return false;
            }

        } else {
            // the Admin is not logging in so display the login page
           $this->data['captcha']    = $this->captcha_lib->get_captcha();
           $this->load->view('backend/admin/login', $this->data);
        }
    }


    public function profile(){

        $this->check_admin_login();

        if($this->input->method() != 'post') {

            $data = [
                'admin_alias' => $this->admin_alias,
                'content' => 'backend/admin/profile',
                'admin_name' => $this->session->userdata('admin_full_name'),
                'email_id' => $this->session->userdata('admin_email'),
                'login_id' => $this->session->userdata('admin_name'),
                'error' => [],
                'success' => []
            ];

            $this->load->view('backend/back_template', $data);
            return false;
        }

        $error = [];
        $success = [];

        $name = trim($this->input->post('admin_name'));
        $email = trim($this->input->post('email_id'));
        $password = trim($this->input->post('password'));
        $conf_password = trim($this->input->post('confirm_password'));

        if(empty($name) || empty($email)){
            $error[] = 'Sorry, Please fill all the required fields!!!';
        }

        if(empty($error) && !$this->valid->is_email($email)){
            $error[] = 'Sorry, Invalid email address!!!';
        }

        if(empty($error) && $password != $conf_password){
            $error[] = 'Sorry, Password and confirm password does not match!!!';
        }

        if(empty($error)){

            $update_data['email']      = $email;
            $update_data['admin_name'] = $name;

            if(!empty($password)){
                $update_data['password'] = $this->encrypt_admin_pass($password);
            }

            $admin_id = $this->session->userdata('admin_id');

            if($this->Admin_model->update_profile_info($admin_id, $update_data)) {

                $data=[
                    'admin_email'  => $email,
                    'admin_full_name'   => $name
                ];

                $this->session->set_userdata($data);
                $this->Admin_model->last_update($admin_id);
                $success[] = 'Admin profile has been updated successfully!!!';

            } else {

                $error[] = 'Error changeing information!!!';
            }

        }

        $data = [
            'admin_alias' => $this->admin_alias,
            'content' => 'backend/admin/profile',
            'admin_name' => $this->session->userdata('admin_full_name'),
            'email_id' => $this->session->userdata('admin_email'),
            'login_id' => $this->session->userdata('admin_name'),
            'error' => $error,
            'success' => $success
        ];

        $this->load->view('backend/back_template', $data);

    }

    public function _login($username, $password) {

        if(empty($username) || empty($password)){
            return false;
        }

        $password=$this->encrypt_admin_pass($password);

        if(empty($admin_info=$this->Admin_model->get_login_info($username, $password))){

            return false;

        }

        $mixinf = $admin_info->admin_id.$admin_info->user_id.$this->input->ip_address();
        $mixinf = $this->encrypt_admin_pass($mixinf);

        $data=[
                'admin_id'     => $admin_info->admin_id,
                'admin_email'  => $admin_info->email,
                'admin_name'   => $admin_info->user_id,
                'admin_full_name'   => $admin_info->admin_name,
                'admin_session_inf' => $mixinf,
              ];

        $this->session->set_userdata($data);
        $this->Admin_model->last_login($data["admin_id"]);

        return true;
    }

    /*
 * Take captcha image (for ajax post request)
 * @access public
 * @return void
 */
    public function get_new_captcha(){

        if($this->input->method()!='post' || !$this->input->is_ajax_request()){
            return false;
        }

        $captcha = $this->captcha_lib->get_captcha();

        echo $captcha['image'];

    }


    public function logout(){

        $this->session->sess_destroy();
        redirect($this->admin_alias.'login/', 'refresh');

    }


    // Do admin password encrition
    private function encrypt_admin_pass($pass) {

        $salt = $this->config->item('salt');
        $pass = sha1($pass.$salt);

        return $pass;
    } // End of function encrypt_admin_pass

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            redirect($this->admin_alias.'login/', 'refresh');
            exit;
        }

    }

}

?>