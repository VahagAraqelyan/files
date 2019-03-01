<?php
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('captcha_lib');
        $this->load->model("Admin_model");
        $this->load->model("Statistic_model");
    }

    public function index(){

        $this->login();
    }

    public function dashboard(){

        $this->check_admin_login();

        $data['content'] = 'admin/dashboard';

        $this->load->view('admin/back_template',$data);
    }

    public function get_admin(){

        $this->check_admin_login(true);

        $crt = ['id <>'=>$this->session->admin_id];
        $data['admins'] = $this->Admin_model->get_all_admins(true,$crt);

        $data['content'] = 'admin/all_admin';

        $this->load->view('admin/back_template',$data);
    }

    public function add_admin(){

        $this->check_admin_login(true);

        $this->load->view('admin/add_edit_admin_answer');
    }

    public function ax_save_admin(){

        $this->check_admin_login(true);

        $name        = $this->security->xss_clean($this->input->post('name'));
        $email       = $this->security->xss_clean($this->input->post('email'));
        $pass        = $this->security->xss_clean($this->input->post('password'));
        $root_admin  = $this->security->xss_clean($this->input->post('root_admin'));

        $pass = $this->encrypt_admin_pass($pass);
        $data['errors'] = [];
        $crt = ['email'=>$email];
        $admin = $this->Admin_model->get_all_admins(true,$crt);

        if(!empty($admin)){
             $data['errors'][] = 'Նշված էլ․ հասցեն արդեն օգտագործվում է։';
            echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $insert_data = [
            'name'            => $name,
            'email'           => $email,
            'password'        => $pass,
            'last_login_date' => '',
            'root_admin'      => $root_admin,
        ];

        $this->Admin_model->add_admin($insert_data);
        echo json_encode($data);
    }

    public function ax_edit_admin(){

        $this->check_admin_login(true);

        $id  = $this->security->xss_clean($this->input->post('id'));

        $data['errors'] = [];

        $crt = ['id' => $id];

        $admin = $this->Admin_model->get_all_admins(true,$crt);

        if(empty($admin)){
            $data['errors'][] = 'Գործողության ընթացքում տեղի ունեցավ սխալ։ Խնդրում ենք փորձել կրկին';
            echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $data['admin'] = $admin[0];


        $this->load->view('admin/add_edit_admin_answer',$data);
    }

    public function ax_save_edit_admin(){

        $this->check_admin_login(true);

        $name  = $this->security->xss_clean($this->input->post('name'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $pass  = $this->security->xss_clean($this->input->post('password'));
        $id    = $this->security->xss_clean($this->input->post('id'));

        $data['errors'] = [];
        $crt = ['email'=>$email];
        $crt2 = ['id'=>$id];
        $admin = $this->Admin_model->get_all_admins(true,$crt);
        $admin2 = $this->Admin_model->get_all_admins(true,$crt2);

        if(!empty($admin) ){

            if($admin[0]['email'] != $admin2[0]['email']){
                $data['errors'][] = 'Նշված էլ․ հասցեն արդեն օգտագործվում է։';
                echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
                return false;
            }

        }

        $insert_data = [
            'name'            => $name,
            'email'           => $email
        ];

        if(!empty($pass)){

            $pass = $this->encrypt_admin_pass($pass);
            $insert_data['password'] = $pass;
        }

        $this->Admin_model->update_admin($insert_data,$id);
        echo json_encode($data);
    }

    public function ax_delete_admin(){

        $this->check_admin_login(true);

        $id    = $this->security->xss_clean($this->input->post('id'));

        $crt = ['id'=>$id];
        $admin = $this->Admin_model->get_all_admins(true,$crt);

        $data['errors'] = [];

        if(empty($admin)){
            $data['errors'][] = 'Գործողության ընթացքում տեղի ունեցավ սխալ։ Խնդրում ենք փորձել կրկին';
            echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $this->Admin_model->delete_admin($id);

        echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
    }

    public function search_statistic(){

        $this->check_admin_login();

        if(!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $statistic_data = trim($this->security->xss_clean($this->input->post('mounth')));

        if(empty($statistic_data)){

            $statistic_data = date('Y-m');
        }

        $date_arr = [];
        $int_arr  = [];

        $date_day_month = explode('-',$statistic_data);

        $inf = $this->Statistic_model->get_statistic($date_day_month);

        foreach ($inf as $item =>$value){

            $date = explode('-',$value['date']);
            $date_arr[] = $date[2];
            $int_arr[]  = $value['cnt'];
        }

        $data['date_arr'] = $date_arr;
        $data['int_arr']  = $int_arr;

        $this->load->view('admin/statistic_answer', $data);
    }

    public function edit_profile(){

        $this->check_admin_login();

        $data['content'] = 'admin/edit_profile';


        $crt = ['id'=>$this->session->admin_id];

        $data['admin'] = $this->Admin_model->get_all_admins(true,$crt)[0];

        $this->load->view('admin/back_template',$data);
    }

    public function save_edit_profile(){

        $this->check_admin_login();

        $name  = $this->security->xss_clean($this->input->post('name'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $pass  = $this->security->xss_clean($this->input->post('password'));
        $id    = $this->session->admin_id;

        $data['errors'] = [];

        $crt = ['email'=>$email];

        $crt2 = ['id'=>$id];

        $admin = $this->Admin_model->get_all_admins(true,$crt);

        $admin2 = $this->Admin_model->get_all_admins(true,$crt2);

        if(!empty($admin) ){

            if($admin[0]['email'] != $admin2[0]['email']){
                $data['errors'][] = 'Նշված էլ․ հասցեն արդեն օգտագործվում է։';
                echo json_encode($data,JSON_HEX_APOS|JSON_HEX_QUOT);
                return false;
            }

        }

        $insert_data = [
            'name'            => $name,
            'email'           => $email
        ];

        if(!empty($pass)){

            $pass = $this->encrypt_admin_pass($pass);
            $insert_data['password'] = $pass;
        }

        $this->Admin_model->update_admin($insert_data,$id);

        $admin_info = $this->Admin_model->get_all_admins(true,$crt2)[0];

        $mixinf = $admin_info['id'].$admin_info['name'].$this->input->ip_address();

        $mixinf = $this->encrypt_admin_pass($mixinf);
        $this->session->set_userdata('admin_session_inf', $mixinf);
        echo json_encode($data);
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

        return ['status' => 'OK', 'is_root' => $admin_info->root_admin, 'login_with_key' => $admin_info->login_with_key];
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