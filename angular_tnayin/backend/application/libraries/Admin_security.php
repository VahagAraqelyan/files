<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by GEVOR.
 * Date: 31.01.2017
 * Time: 3:14
 */

class admin_security{

    private $CI;
    private $fields = ['admin_id','admin_email','admin_name','admin_session_inf'];

    private $is_admin = false;
    private $admin_info = NULL;
    private $admin_permissions = [];

    public function __construct()
    {

        $this->CI = get_instance();

        $this->CI->load->model("Admin_model");

        $this->is_admin = $this->init();

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

        $inf_string = $admin_info->admin_id.$admin_info->user_id.$this->CI->input->ip_address();
        $inf_string = $this->encrypt_inf($inf_string);

        if($inf_string !== $session_inf){

            return false;

        }

        $this->admin_info = $admin_info;

        $this->admin_permissions = $this->CI->Admin_model->get_admin_perm($admin_id);

        return true;

    }
    /*
    * @access public
    * @param  no
    * @return bool
    */
    public function is_admin(){

        return $this->is_admin;

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