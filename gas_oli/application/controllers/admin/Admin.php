<?php
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('captcha_lib');
        $this->load->model("Admin_model");
    }

    public function index(){

      show_404();
    }

    public function login(){

        //validate form input
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('code', 'Security Code', 'required|xss_clean');

        $data["username"] = trim($this->input->post('email'));
        $captcha_word = $this->input->post('code');

        $ip = $this->input->ip_address();

        $data['message'] = "";

        if ($this->form_validation->run() == true) {

            if (!$this->captcha_lib->is_captcha($captcha_word, $ip)) {

                //if captcha is not the same
                $data['captcha'] = $this->captcha_lib->get_captcha();
                $data["username"] = trim($this->input->post('email'));
                $data['message'] = 'Invalid security code.';

                $this->load->view('admin/login',$data);
                return false;
            }

            $username = trim($this->input->post('email'));
            $password = trim($this->input->post('password'));

            // check to see if the Admin is logging in
            $login = $this->_login($username, $password);

            if ($login) {

                redirect('admin/dashboard', 'refresh');

            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $data['captcha'] = $this->captcha_lib->get_captcha();
                $data["username"] = trim($this->input->post('email'));
                $data['message'] = 'Invalid Username and/or Password.';

                $this->load->view('admin/login',$data);
                return false;
            }

        } else {
            // the Admin is not logging in so display the login page
            $data['captcha'] = $this->captcha_lib->get_captcha();
            $this->load->view('admin/login',$data);
        }
    }

    public function _login($username, $password) {

        if(empty($username) || empty($password)){
            return false;
        }

        $password=$this->encrypt_admin_pass($password);
        $admin_info=$this->Admin_model->get_login_info($username, $password);

        if(empty($admin_info)){
            return false;
        }

        $mixinf = $admin_info->id.$admin_info->name.$this->input->ip_address();

        $mixinf = $this->encrypt_admin_pass($mixinf);
        $data=[
            'admin_id'     => $admin_info->id,
            'admin_email'  => $admin_info->email,
            'admin_name'   => $admin_info->name,
            'admin_session_inf' => $mixinf,
        ];


        $this->session->set_userdata($data);

        $this->Admin_model->last_login($data["admin_id"]);

        return ['status' => 'OK', 'is_root' => $admin_info->root_admin];
    }

    private function encrypt_admin_pass($pass) {

        $salt = $this->config->item('salt');
        $pass = sha1($pass.$salt);

        return $pass;
    } // End of function encrypt_admin_pass

    public function get_new_captcha(){

        if($this->input->method()!='post' || !$this->input->is_ajax_request()){
            return false;
        }

        $captcha = $this->captcha_lib->get_captcha();

        echo $captcha['image'];

    }

    private function check_admin_login($root) {

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }

        $crt = ['id'=>$this->session->admin_id];
        $admin = $this->Admin_model->get_all_admins(true,$crt);

        if(empty($admin)){
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }

        if($root && $admin[0]['root_admin'] == 0){

            show_404();
        }

    }

}
?>