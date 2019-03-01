<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class admin_security{

    private $CI;
    private $fields = ['admin_id','admin_email','admin_name','admin_session_inf'];

    private $is_admin = false;
    private $is_admin_key = false;
    private $admin_info = NULL;
    private $admin_permissions = [];
    private $root_admin = false;

    public function __construct()
    {

        $this->CI = get_instance();

        $this->CI->load->model("Admin_model");
        $this->CI->load->model("Admin_keys_model");

        $this->is_admin  = $this->init();

    }

    protected function init(){

        foreach($this->fields as $field){

            if(empty($this->CI->session->userdata($field))){

                return false;

            }

        }

        $admin_id    = $this->CI->session->userdata('admin_id');
        $session_inf = $this->CI->session->userdata('admin_session_inf');

        $admin_info = $this->CI->Admin_model->get_account_info($admin_id);

        if(empty($admin_info)){
            return false;
        }

        $this->admin_info = $admin_info;

        $inf_string = $admin_info->id.$admin_info->name.$this->CI->input->ip_address();
        $inf_string = $this->encrypt_inf($inf_string);

        if($inf_string !== $session_inf){

            return false;

        }

      //  $this->admin_permissions = $this->CI->Admin_model->get_admin_perm($admin_id);

        return true;

    }

    protected function init_key(){

        if(empty($this->admin_info)){
            return false;
        }

        if($this->admin_info->root_admin == 1){
            $this->root_admin = true;
            return true;
        }

        if($this->admin_info->login_with_key == 0){
            return true;
        }

        if(empty($this->CI->input->cookie('session_key', TRUE))){
            return false;
        }

        $key_info = $this->CI->Admin_keys_model->get_key_by_admin_id($this->admin_info->admin_id);

        if(empty($key_info)){
            delete_cookie('session_key');
            return false;
        }

        if(empty($key_info['status'])){
            delete_cookie('session_key');
            return false;
        }

        $key_hash    = $this->encrypt_inf($this->admin_info->admin_id.$key_info['key']);
        $session_key = $this->CI->input->cookie('session_key', TRUE);

        if($key_hash != $session_key){
            delete_cookie('session_key');
            return false;
        }

        $date = date('Y-m-d');

        if($date < $key_info['start_date'] || $date > $key_info['end_date']){
            delete_cookie('session_key');
            return false;
        }

        return true;

    }


    /*
    * @access public
    * @param  no
    * @return bool
    */
    public function is_admin($key = true){

        if (!$this->is_admin) {
            return false;
        }

        return $this->is_admin;

    }

    public function is_root_admin(){

        return $this->root_admin;

    }

    public function admin_row(){

        return $this->admin_info;

    }

    public function admin_dir(){

        return 'admin/';

    }

    public function admin_perm(){

        return $this->admin_permissions;
    }

    public function login_by_user($user_id){

        $response = [
            'status' => 'OK',
            'errors' => [],
            'data'   => []
        ];

        $this->CI->load->model("Users_model");
        $this->CI->load->model("Ion_auth_model");
        $this->CI->load->library('session');

        $user_info = $this->CI->Users_model->get_user_info($user_id);

        if(empty($user_info)){

            $response['status'] = false;
            $response['errors'][] = 'Undefined user.';
            return $response;
        }

        $login_data = new stdClass();
        $login_data->email       = $user_info['email'];
        $login_data->id          = $user_info['id'];
        $login_data->password    = $user_info['password'];
        $login_data->user_status = $user_info['user_status'];
        $login_data->last_login  = $user_info['last_login'];

        if(!$this->CI->ion_auth_model->set_session($login_data)){

            $response['status'] = false;
            $response['errors'][] = 'Can not set session.';

        }else{

            $response['data'] = $user_info;
        }

        return $response;

    }

    private function encrypt_inf($inf){

        $salt = $this->CI->config->item('salt');

        $inf = sha1($inf.$salt);

        return $inf;

    }

}

?>