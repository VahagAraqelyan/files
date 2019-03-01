<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Controller
{

    private $traveler_list_row_count = 12;
    private $addres_book_list_row_count = 12;
    private $users_credit_cards_count = 3;
    private $pay_currency = 'usd';

    public function __construct()
    {

        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'),
            $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->library('captcha_lib');
        $this->load->library('payment_lib');
        $this->load->library('General_email');
        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
        $this->load->model('Lists_model');

    }


    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('user/login', 'refresh');
        }

        if(!empty($this->input->cookie('order')) && $this->input->cookie('order') != 'null'){

            redirect('order/new_order', 'refresh');

        }else{

            redirect('dashboard/dashboard', 'refresh');

        }

    }

    /*
     * User login functionality and validation
     * @access public
     * @return void
     */
    public function login()
    {

        $this->data['content'] = 'frontend/user/login';
        $this->data['captcha'] = $this->captcha_lib->get_captcha();
        $this->data['info']['account_num'] = '';
        $this->data['info']['user_name'] = '';
        $this->_render_page('frontend/site_main_template', $this->data);

    }

    public function ax_check_login()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $email = trim($this->security->xss_clean($this->input->post('email')));
        $password = trim($this->security->xss_clean($this->input->post('password')));
        $code = trim($this->security->xss_clean($this->input->post('code')));

        $data['errors'] = [];

        if (empty($email) || !$this->valid->is_email($email)) {

            $data['errors'][] = 'Invalid email address';
            $data['error_tag'] = '#email';

        }

        if (empty($data['errors']) && empty($password)) {

            $data['errors'][] = 'Password field is required';
            $data['error_tag'] = '#password';

        }

        if (empty($data['errors']) && empty($code)) {

            $data['errors'][] = 'Security code field is required';
            $data['error_tag'] = '#code';

        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        if (!$this->captcha_lib->is_captcha($code, $this->input->ip_address())) {

            $data['errors'][] = 'Invalid security code';
            $data['error_tag'] = '#code';

        }

        if (empty($data['errors']) && !$this->ion_auth_model->login($email, $password)) {

            $data['errors'][] = 'Invalid email and/or password.';

        }

        echo json_encode($data);

    }


    /*
     * User logout functionality
     * @access public
     * @return void
     */
    public function logout()
    {
        $this->data['title'] = 'Logout';

        $this->load->model('Order_model');

        $user = $this->ion_auth->user()->row();

        $this->Order_model->remove_user_modify($user->id);

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());

        delete_cookie('changed_order');
        delete_cookie('order');
        delete_cookie('ship_met');

        redirect('user/login', 'refresh');

    }

    /*
     * User registration functionality and validation
     * @access public
     * @return void
     */
    public function registration()
    {

        $data['content'] = 'frontend/user/registration';
        $data['cap'] = $this->captcha_lib->get_captcha();
        $data['country'] = $this->Users_model->get_countries();
        $data['info']['account_num'] = '';
        $data['info']['user_name'] = '';

        $this->_render_page('frontend/site_main_template', $data);

    }

    public function ax_check_registration()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $first_name      = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name       = trim($this->security->xss_clean($this->input->post('last_name')));
        $email           = trim($this->security->xss_clean($this->input->post('email')));
        $password        = trim($this->security->xss_clean($this->input->post('password')));
        $retype_password = trim($this->security->xss_clean($this->input->post('retype_password')));
        $country         = trim($this->security->xss_clean($this->input->post('country')));
        $state           = trim($this->security->xss_clean($this->input->post('state')));
        $code            = trim($this->security->xss_clean($this->input->post('code')));
        $accept          = trim($this->security->xss_clean($this->input->post('accept')));


        $data['errors'] = [];

        if (empty($first_name) || strlen($first_name) < 2) {

            $data['tag'] = '#first_name';
            $data['errors'][] = 'Invalid first name';

        }

        if (empty($data['errors']) && (empty($last_name) || strlen($last_name) < 2)) {

            $data['tag'] = '#last_name';
            $data['errors'][] = 'Invalid last name';

        }

        if (empty($data['errors']) && !$this->valid->is_email($email)) {

            $data['tag'] = '#email';
            $data['errors'][] = 'Invalid email address';

        }

        if (empty($data['errors']) && (empty($password) || strlen($password) < 8)) {

            $data['tag'] = '#password';
            $data['errors'][] = 'Invalid password';

        }

        if (empty($data['errors']) && $retype_password != $password) {

            $data['tag'] = '#retype_password';
            $data['errors'][] = 'Passwords do not match';

        }

        if (empty($data['errors']) && (empty($country) || count(explode('_', $country)) != 2)) {

            $data['errors'][] = 'Invalid country information';

        }

        if (!empty($country) && $country == 'US_226') {
            if (empty($data['errors']) && (empty($state) || count(explode('_', $state)) != 2)) {

                $data['errors'][] = 'Invalid state information';

            }
        }

        if (empty($data['errors']) && empty($code)) {

            $data['tag'] = '#code';
            $data['errors'][] = 'Security code field is required';

        }

        if (empty($data['errors']) && empty($accept)) {

            $data['errors'][] = 'Please Read and Agree to.The Terms & Conditions';

        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        if (!$this->captcha_lib->is_captcha($code, $this->input->ip_address())) {

            $data['tag'] = '#code';
            $data['errors'][] = 'Invalid security code.';

        }

        if (empty($data['errors']) && $this->ion_auth->email_check($email)) {

            $data['tag'] = '#email';
            $data['errors'][] = 'This email is already registered';

        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }


        $country = explode('_', $country);
        $country_id = $country[1];
        $search_data['country_id'] = $country_id;
        $iso2 = $country[0];
        $state_shname = "00";
        $state_id = NULL;

        if ($country_id == '226') {

            $state = explode('_', $state);
            $search_data['state_id'] = $state[0];
            $state_shname = $state[1];
            $state_id = $state[0];

        }


        $user_count = $this->Users_model->search_users($search_data);

        if (!empty($user_count)) {

            $user_count = preg_replace("/[^0-9]/", "",$user_count[0]['account_name']);

            $user_count = intval($user_count) + 1;

        } else {

            $user_count = 1;

        }

        $account_name = $iso2 . $state_shname . str_pad($user_count, 5, '0', STR_PAD_LEFT);

        $user_isset = $this->Users_model->search_users(['account_name' => $account_name]);

        while(!empty($user_isset)){

            $user_count++;

            $account_name = $iso2 . $state_shname . str_pad($user_count, 5, '0', STR_PAD_LEFT);

            $user_isset = $this->Users_model->search_users(['account_name' => $account_name]);

        }

        $user_reg = array(
            "first_name"   => $first_name,
            "last_name"    => $last_name,
            'country_id'   => $country_id,
            'state_id'     => $state_id,
            'account_name' => $account_name
        );

        if ($this->ion_auth->register($email, $password, $email, $user_reg)) {

            $info = [
                'first_name'          => $user_reg['first_name'],
                'last_name'           => $user_reg['last_name'],
                'email'               => $email,
                'account_number'      => $user_reg['account_name'],
                'luggage_image'       => base_url('assets/email-resources/luggage-shipping.png'),
                'username'            => $user_reg['first_name']." ".$user_reg['last_name'],
                'subject_description' => 'Hi '. $user_reg['first_name']." ".$user_reg['last_name'].' thanks for registering with LuggageToShip.com. Your account number is'.$iso2 . $state_shname . str_pad($user_count, 5, '0', STR_PAD_LEFT).'. We are excited to provide you with professional luggage shipping services. '
            ];


            $email_data = array(
                'email'     => $email,
                'to_name'   => $email,
                'subject'   => 'Welcome to Luggage To Ship – ' . $user_reg['account_name'],
                'variables' => $info
            );


            $this->general_email->send_email('registration',$email_data);

            $this->ion_auth->login($email, $password, false);

            $id = $this->ion_auth->user()->row()->id;

            if (!is_dir(FCPATH.'uploaded_documents')) {
                mkdir(FCPATH.'uploaded_documents', 0775, TRUE);
            }

            if (!is_dir(FCPATH.'uploaded_documents/'.$id)) {
                mkdir(FCPATH.'uploaded_documents/'.$id, 0775, TRUE);
            }


        } else {

            $data["error"] = "Registration not success";
        }

        echo json_encode($data);

    }

    /*
     * Take User Forgot password page template
     * @access public
     * @return void
     */
    public function forgot_password()
    {

        $data['captcha'] = $this->captcha_lib->get_captcha();

        $this->load->view('frontend/user/forgot_password', $data);

    }

    /*
     * User Forgot password functionality and validation (ajax)
     * @access public
     * @return void
     */
    public function ax_check_forgot_password()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $email = trim($this->security->xss_clean($this->input->post('email')));
        $code = trim($this->security->xss_clean($this->input->post('code')));

        $data['err_message'] = [];
        $data['suc_message'] = [];
        $ip_address = $this->input->ip_address();

        if (empty($email)) {

            $data['tag'] = '#email_forgot';
            $data['err_message'][] = "Email field must be filled.";

        }

        if (empty($data['err_message']) && !$this->valid->is_email($email)) {

            $data['tag'] = '#email_forgot';
            $data['err_message'][] = "Invalid Email address.";

        }

        if (empty($data['err_message']) && empty($code)) {

            $data['tag'] = '#code_forgot';
            $data['err_message'][] = "Security code field must be filled.";

        }

        if (empty($data['err_message']) && !$this->captcha_lib->is_captcha($code, $ip_address)) {

            $data['tag'] = '#code_forgot';
            $data['err_message'][] = 'Invalid security code.';

        }

        if (!empty($data['err_message'])) {

            echo json_encode($data);
            return false;

        }

        if (!$this->ion_auth->email_check($email)) {

            $data['tag'] = '#email_forgot';
            $data['err_message'][] = 'This email is not registered with us yet.';

            echo json_encode($data);

            return false;

        }

        $user_info = $this->Users_model->search_users(['email' => $email]);

        $data_inf['new_password']          = random_string('alnum', 8);
        $data_inf['email']                 = $email;
        $data_inf['first_name']            = $user_info[0]['first_name'];
        $data_inf['last_name']             = $user_info[0]['last_name'];
        $data_inf['username']              = $user_info[0]['first_name']." ".$user_info[0]['last_name'];
        $data_inf['subject_description']   = 'Hi '.$user_info[0]['first_name']." ".$user_info[0]['last_name'].', we received a password reset request for your account. The temporary password is'. $data_inf['new_password'].'. Please login your account and reset your password in My Profile.';

        $change = $this->ion_auth->reset_password($data_inf['email'], $data_inf['new_password']);

        if ($change) {
            // if the password was successfully changed

            $email_data = array(
                'email'     => $data_inf['email'],
                'to_name'   =>  $data_inf['first_name'].' '.$data_inf['last_name'],
                'subject'   => 'Reset Password – ' . $user_info[0]['account_name'],
                'variables' => $data_inf
            );


            $send = $this->general_email->send_email('forgot_password',$email_data);

            if ($send->_status_code == 202) {

                $data['suc_message'][] = 'Recovery password has been sent successfully on your email. Please check your email.';

            } else {

                $data['err_message'][] = 'Email send error';

            }

        } else {

            $data['err_message'][] = 'Password recovery error.';

        }
        echo json_encode($data);

    }

    public function my_profile()
    {
        if (!$this->ion_auth->logged_in() ) {

            redirect('user/login', 'refresh');
            return false;

        }

        $this->load->config('payment_config');

        $user   = $this->ion_auth->user()->row();

        $cards = $this->Users_model->get_credit_cards(['user_id' => $user->id]);

        $data['document_select'] = $this->Lists_model->get_data_by_list_key('profile_user_documents');
        $data['cards'] = [];
        $data['cards_count'] = $this->users_credit_cards_count;

        $data['info'] = [
            'email'          => $user->email,
            'country'        => $user->address_country_id,
            'phone'          => $user->phone,
            'fax'            => $user->fax_number,
            'home_phone'     => $user->home_office_phone,
            'company_name'   => $user->company,
            'add1'           => $user->address1,
            'add2'           => $user->address2,
            'city'           => $user->city,
            'state'          => $user->address_state_id,
            'zip_code'       => $user->zipcode,
            'user_name'      => $user->first_name,
            'account_num'    => $user->account_name,
            'all_countries'  => $this->Users_model->get_countries(),
            'files'          => $this->Users_model->get_doc_info($user->id),
            'account_credit' => $user->account_credit,
        ];

        $data['traveler_list_row_count'] = $this->traveler_list_row_count;
        $data['addres_book_list_row_count'] = $this->addres_book_list_row_count;

        if(empty($data['info']['files'])){

            $data['info']['files']=[];

        }

        if(!empty($cards)){
            foreach($cards as $single){
                $data['cards'][$single['card_num']] = $single['ver_status'];
            }
        }

        $data['states'] = [];
        if(!empty($user->address_country_id)){
            $data['states'] = $this->Users_model->get_states($user->address_country_id);
        }

        $data['content'] = 'frontend/user/my_profile/main';
        $data['navigation_buffer'] = 'frontend/dashboard_navigation';
        $data['public_key'] = $this->config->item('stripe_public_key');

        $this->_render_page('frontend/site_main_template',  $data);

    }


    public function ax_update_user_numbers()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $cell_phone    = trim($this->security->xss_clean($this->input->post('cell_phone')));
        $fax_number    = trim($this->security->xss_clean($this->input->post('fax_number')));
        $hom_off_phone = trim($this->security->xss_clean($this->input->post('home_phone')));

        $update_data = [];
        $message_data['errors'] = [];
        $message_data['success'] = [];

        $update_data['phone'] = $cell_phone;
        $update_data['fax_number'] = $fax_number;
        $update_data['home_office_phone'] = $hom_off_phone;

        if (empty($update_data)) {

            return false;

        }


        if(!empty($message_data['errors'])){

            echo json_encode($message_data);
            return false;

        }


        $user = $this->ion_auth->user()->row();

        if ($this->ion_auth_model->update($user->id, $update_data)) {

            $message_data['success'][] = 'Your information updated successfully.';

        } else {

            $message_data['errors'][] = 'information update error.';

        }

        echo json_encode($message_data);

    }

    public function ax_update_password()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $cur_pass  = trim($this->security->xss_clean($this->input->post('current_password')));
        $new_pass  = trim($this->security->xss_clean($this->input->post('new_password')));
        $conf_pass = trim($this->security->xss_clean($this->input->post('confirm_password')));

        $message_data['errors'] = [];
        $message_data['success'] = [];

        if (empty($cur_pass)) {

            $message_data['errors'][] = 'Please enter current password.';

        }

        if (empty($message_data['errors']) && empty($new_pass)) {

            $message_data['errors'][] = 'Please enter new password.';

        }

        if (empty($message_data['errors']) && strlen($new_pass) < 8) {

            $message_data['errors'][] = 'Required 8-16 digits in new password.';

        }

        if (empty($message_data['errors']) && empty($conf_pass)) {

            $message_data['errors'][] = 'Please enter confirm password.';

        }

        if (empty($message_data['errors']) && ($conf_pass != $new_pass)) {

            $message_data['errors'][] = 'Confirm password does not match.';

        }

        if (!empty($message_data['errors'])) {

            echo json_encode($message_data);
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $data_inf['first_name']          = $user->first_name;
        $data_inf['last_name']           = $user->last_name;
        $data_inf['username']            =  $user->first_name." ".$user->last_name;
        $data_inf['subject_description'] =  'Hi '.$user->first_name." ".$user->last_name.', you have successfully changed password of your Luggage To Ship account. Please always keeps your login information secure and confidential.';

        $header_content = $this->get_email_header();
        $main_coontent = $this->load->view('email_templates/change_password', $data_inf, true);
        $footer_content = $this->get_email_footer();

        $body = $this->load->view(
            'email_templates/main_template',
            [
                'header_content' => $header_content,
                'main_content'   => $main_coontent,
                'footer_content' => $footer_content
            ], true);

        if ($this->ion_auth_model->change_password($user->email, $cur_pass, $new_pass)) {

            $email_data = array(
                'email'     => $user->email,
                'to_name'   => $user->username,
                'subject'   => 'Your password has been successfully updated  – ' . $user->account_name,
                'variables' => $data_inf
            );


            $send = $this->general_email->send_email('update_password',$email_data);

            $message_data['success'][] = 'Your password successfully change.';

        } else {

            $message_data['errors'][] = 'Invalid current password.';

        }

        echo json_encode($message_data);


    }


    public function ax_update_user_address()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $company_name = trim($this->security->xss_clean($this->input->post('company_name')));
        $address1     = trim($this->security->xss_clean($this->input->post('address1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip')));
        $country      = trim($this->security->xss_clean($this->input->post('country')));

        $update_data = [];
        $message_data['errors'] = [];
        $message_data['success'] = [];

        if(empty($country)){

            $message_data['errors'][] = 'Please select country.';

        }

        if (empty($message_data['errors']) &&  count(explode('_', $country)) != 2) {

            $message_data['errors'][] = 'Invalid country information';

        }

        if(empty($message_data['errors']) && empty($address1)){

            $message_data['errors'][] = 'Please enter address1.';

        }


        if(empty($message_data['errors']) && empty($city)){

            $message_data['errors'][] = 'Please enter city.';

        }

        $update_data['company']  = $company_name;
        $update_data['address2'] = $address2;
        $update_data['address_state_id'] = $state;
        $update_data['zipcode']  = $zip_code;

        if(!empty($message_data['errors'])){

            echo json_encode($message_data);
            return false;

        }

        $country = explode('_',$country);
        $update_data['address1'] = $address1;
        $update_data['city'] = $city;
        $update_data['address_country_id'] = $country[1];

        $user = $this->ion_auth->user()->row();

        if($this->ion_auth_model->update($user->id, $update_data)){

            $message_data['success'][] = 'Your information updated successfully.';

        }else{

            $message_data['errors'][] = 'information update error.';

        }

        echo json_encode($message_data);

    }

    public  function ax_update_email(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $data['email'] =  $this->ion_auth->user()->row()->email;
        $this->load->view('frontend/user/my_profile/change_email',$data);

    }

    public  function ax_check_update_email(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $cur_pass  = trim($this->security->xss_clean($this->input->post('password')));
        $email     = trim($this->security->xss_clean($this->input->post('new_email')));


        $message_data['errors'] = [];
        $message_data['success'] = [];

        if (empty($cur_pass)) {

            $message_data['errors'][] = 'Please enter  password.';

        }

        if (empty($message_data['errors']) && empty($email)) {

            $message_data['errors'][] = 'Please enter email.';

        }

        $user=$this->ion_auth->user()->row();
        $old_email = $user->email;

        if($email==$user->email){
            $message_data['success'][] = '';
            echo json_encode($message_data);
            return false;
        }

        if(!empty($message_data['errors'])){

            echo json_encode($message_data);
            return false;

        }

        if(empty($data['errors']) && $this->ion_auth->email_check($email) ){

            $message_data['errors'][] = 'This email is already registered.';

        }

        if (!empty($message_data['errors'])) {

            echo json_encode($message_data);
            return false;

        }


        if(!$this->ion_auth_model->hash_password_db($user->id, $cur_pass)){

            $message_data['errors'][] = 'Invalid password';

        }

        if (!empty($message_data['errors'])) {

            echo json_encode($message_data);
            return false;

        }

        $update_data = [
            'username' => $email,
            'email'    => $email
        ];

        $data_inf['first_name'] = $user->first_name;
        $data_inf['last_name'] = $user->last_name;
        $data_inf['email'] = $email;
        $data_inf['username'] =  $data_inf['first_name']." ". $data_inf['last_name'];
        $data_inf['subject_description'] =  'Hi '.$data_inf['first_name']." ". $data_inf['last_name'].', you have successfully updated the login email of your Luggage To Ship account. We will send all future emails to '.$email.' Thanks';

        if($this->ion_auth_model->update($user->id, $update_data)){

            $email_data = array(
                'email'     => $user->email,
                'to_name'   => $data_inf['email'],
                'subject'   => 'Your login email has been successfully updated   – ' . $user->account_name,
                'variables' => $data_inf
            );

            $email_data2 = array(
                'email'     => $user->email,
                'to_name'   => $old_email,
                'subject'   => 'Your login email has been successfully updated   – ' . $user->account_name,
                'variables' => $data_inf
            );

            $email_data['email'] = $email;

            $this->general_email->send_email('change_email',$email_data);
            $this->general_email->send_email('change_email',$email_data2);

            $message_data['success'][] = 'Email change successfully';

        }else{

            $message_data['errors'][] = 'Email changing error';

        }

        echo json_encode($message_data);

    }

    public function ax_upload_document(){

        if($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $doc_type_id = $this->input->post('doc_type_id');

        if(empty($doc_type_id)){

            $data['error'][] = 'Please select document name.';
            echo json_encode($data);
            return false;

        }

        $id = $this->ion_auth->user()->row()->id;

        $data['success'] = [];
        $data['error'] = [];

        $count_document = $this->Users_model->get_count_document($id);

        if($count_document >= 10){

            $data['error'][] = 'Max count of documents  10';
            echo json_encode($data);
            return false;
        }

        $config['upload_path'] = 'uploaded_documents/'.$id;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
        $config['max_size']	= 4096;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['error'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $insert_data=[
            'user_id'         => $id,
            'doc_type_id'     => $doc_type_id,
            'doc_type_name'   => $this->Lists_model->get_title_by_id($doc_type_id),
            'show_doc_name'   => $file_info['client_name'],
            'doc_file'        => $file_info['file_name'],
            'reviewed_status' => '0',
            'status'          => '1',
            'add_date'        => date('Y-m-d H:i:s')
        ];

        if(!$this->Users_model->insert_doc_info($insert_data)){

            $data['error'][] = 'Can\'t insert file info';

        }else{

            $data['success'][] = 'Document uploaded successfully.';
            $this->Users_model->last_update($id);

        }


        echo json_encode($data);


    }


    public function ax_remove_document(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $data['error'] = [];
        $data['success'] = [];

        $file_id = $this->security->xss_clean($this->input->post('doc_id'));
        $user_id = $this->ion_auth->user()->row()->id;
        $file_inf = $this->Users_model->remove_user_doc($user_id, $file_id);

        if(empty($file_inf)){

            $data['error'][] = 'Can\'t find document information.';
            echo json_encode($data);
            return false;

        }


        $url = 'uploaded_documents/'.$user_id.'/'.$file_inf[0]['doc_file'];

        if(!file_exists($url)){

            $data['error'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url)){

            $data['error'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $data['success'][] = 'File removed successfully.';
        echo json_encode($data);

    }

    public function ax_get_documents(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $data['files'] = $this->Users_model->get_doc_info($user->id);

        if(empty($data['files'])){

            return false;

        }

        $this->load->view('frontend/user/my_profile/uploaded_docs', $data);

    }

    public function ax_traveler_list(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $page = $this->input->post('page');

        if(empty($page)){

            $page = 1;

        }

        $user = $this->ion_auth->user()->row();

        $row_count = &$this->traveler_list_row_count;

        $limit=[$row_count, ($page - 1)*$row_count];

        $list_data = $this->Users_model->get_traveler_list($user->id, NULL, $limit);

        if(empty($list_data)){

            return false;

        }




        // Initialize pagination config
        $config['base_url'] = '#';
        $config['total_rows'] = $list_data['count_all'];
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="#" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li><a href="#" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['last_link']  = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'travel_pagination');


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $list_data["links"] = $this->pagination->create_links();

        $this->load->view('frontend/user/my_profile/traveler/traveler_list', $list_data);

    }


    public function ax_add_new_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $data=[
            'trav_id'      => '',
            'title'        => 'Add New Traveler',
            'fname'        => '',
            'lname'        => '',
            'phone'        => '',
            'email'        => '',
            'country'      => '0',
            'organization' => '',
            'address1'     => '',
            'address2'     => '',
            'city'         => '',
            'state_reg'    => '',
            'zip_code'     => '',
            'comment'      => '',
            'button_id'    => 'add_traveler_but',
            'button_value' => 'Save'
        ];

        $data['countries'] = $this->Users_model->get_countries();

        $this->load->view('frontend/user/my_profile/traveler/add_new_traveler_modal', $data);

    }

    public function ax_check_add_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $first_name =  trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name  =  trim($this->security->xss_clean($this->input->post('last_name')));
        $phone      =  trim($this->security->xss_clean($this->input->post('phone_number')));
        $email      =  trim($this->security->xss_clean($this->input->post('email')));
        $country    =  trim($this->security->xss_clean($this->input->post('add_trav_country')));
        $organiz    =  trim($this->security->xss_clean($this->input->post('organization')));
        $addres1    =  trim($this->security->xss_clean($this->input->post('address_1')));
        $addres2    =  trim($this->security->xss_clean($this->input->post('address_2')));
        $city       =  trim($this->security->xss_clean($this->input->post('city')));
        $state      =  trim($this->security->xss_clean($this->input->post('state_region')));
        $zipcode    =  trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment    =  trim($this->security->xss_clean($this->input->post('comment')));

        $data['error'] = [];
        $data['success'] = [];

        if(empty($first_name)){

            $data['error'][]='Please enter first name.';

        }

        if(empty($data['error']) && empty($last_name)){

            $data['error'][]='Please enter last name.';

        }

        if(empty($data['error']) && empty($phone)){

            $data['error'][]='Please enter phone number.';

        }

        if(empty($data['error']) && !empty($country) &&  count(explode('_', $country)) != 2){

            $data['error'][]='Invalid country.';

        }elseif(!empty($country)){

            $country = explode("_", $country)[1];
        }



        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }


        $insert_data = [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'phone'        => $phone,
            'email'        => $email,
            'country_id'   => $country,
            'organization' => $organiz,
            'address1'     => $addres1,
            'address2'     => $addres2,
            'city'         => $city,
            'state_id'     => $state,
            'zip_code'     => $zipcode,
            'comment'      => $comment,
            'user_id'      => $this->ion_auth->user()->row()->id
        ];

        if($this->Users_model->insert_traveler($insert_data)){

            $data['success'][] = 'New traveler '.$first_name.' '.$last_name.' has been added successfully.';

        }else{

            $data['error'][]='Error adding traveler';

        }

        echo json_encode($data);


    }

    public function ax_edit_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }


        $trav_id = $this->input->post('traveler_id');
        $data['error'] = [];
        $data['success'] = [];

        if(empty($trav_id)){

            $data['error'][]='Please select a record to edit.';

        }

        if(empty($data['error']) && count($trav_id) > 1){

            $data['error'][]='Please select only one record to edit.';

        }

        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $traveler_data = $this->Users_model->get_traveler_list($user->id, $trav_id);

        if(empty($traveler_data)){

            $data['error'][]='Undefined traveler';
            echo json_encode($data);
            return false;

        }

        $traveler_data = $traveler_data['travel_list'];


        $data=[
            'trav_id'      => $traveler_data[0]['id'],
            'title'        => 'Edit Traveler',
            'fname'        => $traveler_data[0]['first_name'],
            'lname'        => $traveler_data[0]['last_name'],
            'phone'        => $traveler_data[0]['phone'],
            'email'        => $traveler_data[0]['email'],
            'country'      => $traveler_data[0]['country_id'],
            'organization' => $traveler_data[0]['organization'],
            'address1'     => $traveler_data[0]['address1'],
            'address2'     => $traveler_data[0]['address2'],
            'city'         => $traveler_data[0]['city'],
            'state_reg'    => $traveler_data[0]['state_id'],
            'zip_code'     => $traveler_data[0]['zip_code'],
            'comment'      => $traveler_data[0]['comment'],
            'button_id'    => 'edit_traveler_but',
            'button_value' => 'Update'
        ];
        $data['countries'] = $this->Users_model->get_countries();
        $data['states'] = $this->Users_model->get_states($traveler_data[0]['country_id']);

        $this->load->view('frontend/user/my_profile/traveler/add_new_traveler_modal', $data);

    }

    public function ax_check_edit_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $traveler_id = trim($this->security->xss_clean($this->input->post('trav_id')));
        $first_name =  trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name  =  trim($this->security->xss_clean($this->input->post('last_name')));
        $phone      =  trim($this->security->xss_clean($this->input->post('phone_number')));
        $email      =  trim($this->security->xss_clean($this->input->post('email')));
        $country    =  trim($this->security->xss_clean($this->input->post('add_trav_country')));
        $organiz    =  trim($this->security->xss_clean($this->input->post('organization')));
        $addres1    =  trim($this->security->xss_clean($this->input->post('address_1')));
        $addres2    =  trim($this->security->xss_clean($this->input->post('address_2')));
        $city       =  trim($this->security->xss_clean($this->input->post('city')));
        $state      =  trim($this->security->xss_clean($this->input->post('state_region')));
        $zipcode    =  trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment    =  trim($this->security->xss_clean($this->input->post('comment')));

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        if(empty($this->Users_model->get_traveler_list($user->id, $traveler_id))){

            $data['error'][]='Undefined traveler';
            echo json_encode($data);
            return false;

        }

        if(empty($first_name)){

            $data['error'][]='Please enter first name.';

        }

        if(empty($data['error']) && empty($last_name)){

            $data['error'][]='Please enter last name.';

        }

        if(empty($data['error']) && empty($phone)){

            $data['error'][]='Please enter phone number.';

        }

        if(empty($data['error']) &&  !empty($country) && count(explode('_', $country)) != 2){

            $data['error'][]='Invalid country.';

        }elseif(!empty($country)){

            $country = explode("_", $country)[1];
        }

        if(!empty($data['error'])){

            echo json_encode($data);
            return false;

        }


        $update_data = [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'phone'        => $phone,
            'email'        => $email,
            'country_id'   => $country,
            'organization' => $organiz,
            'address1'     => $addres1,
            'address2'     => $addres2,
            'city'         => $city,
            'state_id'     => $state,
            'zip_code'     => $zipcode,
            'comment'      => $comment,
            'user_id'      => $this->ion_auth->user()->row()->id
        ];

        if($this->Users_model->update_traveler($update_data, $traveler_id)){

            $data['success'][] = 'Traveler information updated successfully.';

        }else{

            $data['error'][]='Error adding traveler';

        }

        echo json_encode($data);

    }

    public function ax_delete_traveler(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $data['errors'] = [];
        $data['success'] = [];

        $traveler_id_array = $this->security->xss_clean($this->input->post('traveler_id'));
        $user_id = $this->ion_auth->user()->row()->id;

        if(empty($traveler_id_array)){

            $data['errors'][] = 'Sorry! Please select at least one record to delete.';
            echo json_encode($data);
            return false;

        }

        foreach($traveler_id_array as $trav_id){

            if(empty($this->Users_model->get_traveler_list($user_id, $trav_id))){
                return false;
            }

        }

        if(!$this->Users_model->delete_treveler($traveler_id_array)){

            $data['errors'][] = 'Error deleting travelers.';

        }else{

            $data['success'][] = 'Selected travelers has been deleted successfully.';

        }

        echo json_encode($data);

    }



    public function ax_view_traveler_info(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $traveler_id = $this->security->xss_clean($this->input->post('trav_id'));
        $user_id = $this->ion_auth->user()->row()->id;

        $data['traveler'] = $this->Users_model->get_traveler_list($user_id, $traveler_id);

        if(empty($data['traveler'])){
            return false;
        }

        $data['traveler'] = $data['traveler']['travel_list'][0];

        $this->load->view('frontend/user/my_profile/traveler/view_traveler_info', $data);

    }


    public function ax_address_book_list(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $page = $this->input->post('page');

        if(empty($page)){

            $page = 1;

        }

        $user = $this->ion_auth->user()->row();

        $row_count = &$this->addres_book_list_row_count;

        $limit=[$row_count, ($page - 1)*$row_count];

        $where_data['user_id'] = $user->id;
        $or_where_data['user_id'] = '0';

        $address_array = $this->Users_model->get_address_book_list($where_data, $limit, $or_where_data);

        if(empty($address_array)){

            return false;

        }

        $config['base_url'] = '#';
        $config['total_rows'] = $address_array['count_all'];
        $config['per_page'] =  $row_count;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['full_tag_open'] = '<ul class="pagination designed-pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev_page"><a href="#" aria-label="Previous"><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></a></li>';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li><a href="#" aria-label="Next"><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['last_link'] = false;
        $config['first_link'] = false;
        $config['attributes'] = array('class' => 'addrbook_pagination');


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $address_array["links"] = $this->pagination->create_links();

        $this->load->view('frontend/user/my_profile/address/address_book',$address_array);

    }


    public function ax_add_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $data = [
            'id'           => '',
            'addr_id'      => '',
            'organiz'      => '',
            'country'      => '',
            'address1'     => '',
            'address2'     => '',
            'city'         => '',
            'state'        => '',
            'zip_code'     => '',
            'comment'      => '',
            'title'        => 'ADD NEW ADDRESS',
            'button_id'    => 'add_new_addr_book',
            'button_value' => 'Save'
        ];

        $data['countries'] = $this->Users_model->get_countries();

        $this->load->view('frontend/user/my_profile/address/add_new_address_modal', $data);


    }

    public function ax_check_add_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $address_id   = trim($this->security->xss_clean($this->input->post('address_id')));
        $organization = trim($this->security->xss_clean($this->input->post('organization')));
        $country      = trim($this->security->xss_clean($this->input->post('add_addr_country')));
        $address1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment      = trim($this->security->xss_clean($this->input->post('comment')));


        $data['errors'] = [];
        $data['success'] = [];

        if(empty($data['errors']) && empty($country)){

            $data['errors'][] = 'Country is required.';

        }

        if(empty($data['errors']) && count(explode('_', $country)) != 2){

            $data['errors'][]='Invalid country.';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Address 1 is required.';

        }


        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $search['contact_id'] = $address_id;
        $search['user_id'] = $user->id;
        $country = explode('_', $country);

        if(!empty($address_id) && !empty($this->Users_model->get_address_book_list($search))){

            $data['errors'][] = 'Sorry! The address id '.$address_id.' is already exist, please try another.';
            echo json_encode($data);
            return false;

        }

        $insert_data=[
            'user_id'    => $user->id,
            'contact_id' => $address_id,
            'country_id' => $country[1],
            'company'    => $organization,
            'address1'   => $address1,
            'address2'   => $address2,
            'city'       => $city,
            'state_id'   => $state,
            'zip_code'   => $zip_code,
            'comment'    => $comment,
            'add_date'   => date('Y-m-d H:i:s')
        ];

        if($this->Users_model->insert_address_book($insert_data)){

            $data['success'][] = 'New address has been added successfully in the address book.';

        }else{

            $data['errors'][] = 'Data inserting error.';

        }

        echo json_encode($data);


    }


    public function ax_edit_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $id = $this->security->xss_clean($this->input->post('addr_book'));

        if(empty($id)){

            return false;

        }

        $data['errors'] = [];

        $user = $this->ion_auth->user()->row();

        $base_data = $this->Users_model->get_address_book_list(['user_id' => $user->id, 'address_book.id' => $id]);

        if(empty($base_data)){

            $data['errors'][] = 'Address not found.';
            echo json_encode($data);
            return false;

        }

        $base_data = $base_data['address_book'][0];

        $data = [
            'id'           => $base_data['id'],
            'addr_id'      => $base_data['contact_id'],
            'organiz'      => $base_data['company'],
            'country'      => $base_data['country_id'],
            'address1'     => $base_data['address1'],
            'address2'     => $base_data['address2'],
            'city'         => $base_data['city'],
            'state'        => $base_data['state_id'],
            'zip_code'     => $base_data['zip_code'],
            'comment'      => $base_data['comment'],
            'button_id'    => 'edit_addr_book',
            'title'        => 'EDIT ADDRESS',
            'button_value' => 'Update'
        ];

        $data['countries'] = $this->Users_model->get_countries();
        $data['states'] = $this->Users_model->get_states($base_data['country_id']);

        $this->load->view('frontend/user/my_profile/address/add_new_address_modal', $data);

    }

    public function ax_check_edit_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $id           = trim($this->security->xss_clean($this->input->post('addr_id')));
        $address_id   = trim($this->security->xss_clean($this->input->post('address_id')));
        $organization = trim($this->security->xss_clean($this->input->post('organization')));
        $country      = trim($this->security->xss_clean($this->input->post('add_addr_country')));
        $address1     = trim($this->security->xss_clean($this->input->post('address_1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address_2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $comment      = trim($this->security->xss_clean($this->input->post('comment')));

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $base_data = $this->Users_model->get_address_book_list(['user_id' => $user->id, 'address_book.id' => $id]);

        if(empty($base_data)){

            $data['errors'][] = 'Address not found.';
            echo json_encode($data);
            return false;

        }

        $base_data = $base_data['address_book'][0];

        if(empty($data['errors']) && empty($country)){

            $data['errors'][] = 'Country is required.';

        }

        if(empty($data['errors']) && count(explode('_', $country)) != 2){

            $data['errors'][]='Invalid country.';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Address 1 is required.';

        }

        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $user = $this->ion_auth->user()->row();

        $search['contact_id'] = $address_id;
        $search['user_id'] = $user->id;
        $country = explode('_', $country);

        if(!empty($address_id) && $address_id != $base_data['contact_id'] && !empty($this->Users_model->get_address_book_list($search))){

            $data['errors'][] = 'Sorry! The address id '.$address_id.' is already exist, please try another.';
            echo json_encode($data);
            return false;

        }

        $update_data=[
            'user_id'    => $user->id,
            'contact_id' => $address_id,
            'country_id' => $country[1],
            'company'    => $organization,
            'address1'   => $address1,
            'address2'   => $address2,
            'city'       => $city,
            'state_id'   => $state,
            'zip_code'   => $zip_code,
            'comment'    => $comment,
            'add_date'   => date('Y-m-d H:i:s')
        ];

        if($this->Users_model->update_address_book($update_data, $id)){

            $data['success'][] = 'Address book information updated successfully.';

        }else{

            $data['errors'][] = 'Data updating error.';

        }

        echo json_encode($data);

    }

    public function ax_view_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $id = $this->security->xss_clean($this->input->post('addr_id'));
        $user = $this->ion_auth->user()->row();

        $base_data = $this->Users_model->get_address_book_list(['user_id' => $user->id, 'address_book.id' => $id]);

        if(empty($base_data)){

            $base_data = $this->Users_model->get_address_book_list(['user_id' => '0', 'address_book.id' => $id]);

            if(empty($base_data)) {
                $data['errors'][] = 'Address not found.';
                echo json_encode($data);
                return false;
            }

        }

        $base_data = $base_data['address_book'][0];

        $data = [
            'addr_id'      => $base_data['contact_id'],
            'organiz'      => $base_data['company'],
            'country'      => $base_data['country'],
            'address1'     => $base_data['address1'],
            'address2'     => $base_data['address2'],
            'city'         => $base_data['city'],
            'state'        => $base_data['State'],
            'zip_code'     => $base_data['zip_code'],
            'comment'      => $base_data['comment'],
        ];

        $this->load->view('frontend/user/my_profile/address/address_details_modal', $data);

    }

    public function ax_delete_address_book(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            return false;

        }

        $data['errors'] = [];
        $data['success'] = [];

        $id_array = $this->security->xss_clean($this->input->post('addr_book'));
        $user_id = $this->ion_auth->user()->row()->id;

        if(empty($id_array)){

            $data['errors'][] = 'Sorry! Please select at least one record to delete.';
            echo json_encode($data);
            return false;

        }

        foreach($id_array as $addr_id){

            if(empty($this->Users_model->get_address_book_list(['user_id' => $user_id, 'address_book.id' => $addr_id]))){
                return false;
            }

        }

        if($this->Users_model->delete_address_book($id_array)){

            $data['success'][] = 'Selected address has been deleted successfully.';

        }else{

            $data['errors'][] = 'Data deleting error';

        }

        echo json_encode($data);

    }

    public function ax_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $card_num = $this->security->xss_clean($this->input->post('card_num'));

        if(empty($card_num)){

            return false;

        }

        $user = $this->ion_auth->user()->row();

        $card_info = ['user_id' => $user->id, 'card_num' => $card_num];

        $card_info = $this->Users_model->get_credit_card_info($card_info);

        if(empty($card_info)){

            $view_data=[
                'action'            => 'add',
                'card_num'          => $card_num
            ];

            $view_data['countries'] = $this->Users_model->get_countries();


        }else{

            $view_data = $card_info;

            $view_data['action']='view';
            $view_data['card_number'] = substr($view_data['card_number'], -4, 4);

            $view_data['countries'] = $this->Users_model->get_countries();
            $view_data['states'] = $this->Users_model->get_states($view_data['country_id']);

        }

        $this->load->view('frontend/user/my_profile/credit_card/template_credit_card', $view_data);

    }

    public function ax_add_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $order_id = $this->security->xss_clean($this->input->post('order_id'));

        $user = $this->ion_auth->user()->row();

        if(!empty($this->input->post('order_processing'))){

            $card_num = $this->get_free_card_num($user->id);

        }else{

            $card_num = $this->security->xss_clean($this->input->post('card_num'));
        }

        $card_number = trim($this->security->xss_clean($this->input->post('card_number')));

        $data['errors']  = [];
        $data['success'] = [];

        if(empty($card_num) || !$this->valid->is_id($card_num)){

            return false;

        }

        if($card_num > $this->users_credit_cards_count){

            $data['errors'][] = 'Invalid amounts of credit cards';
            echo json_encode($data);
            return false;

        }

        if($this->Users_model->card_isset($user->id, $card_num)){

            $data['errors'][] = 'Credit card already exists';
            echo json_encode($data);
            return false;

        }

        $country = $this->security->xss_clean($this->input->post('credit_card_country'));
        $country = explode('_',$country);

        if(empty($country[1])){

            $data['errors'][] = 'Invalid country';
            echo json_encode($data);
            return false;

        }

        $user_inf['desc']  = $user->account_name;
        $user_inf['email'] = $user->email;

        $payment_array   = [
            'currency' => $this->pay_currency,
            'description' => 'Verification Pay '.$user_inf['desc']
        ];

        $stripeToken = $this->input->post('stripeToken');

        $customer = $this->Users_model->search_customer($user->id);

        if(!$customer){

            $customer = $this->payment_lib->create_customer($stripeToken, $user_inf);


            if(empty($customer->id)){

                $this->save_credit_card_error($order_id, $customer, $card_number);

                $data['errors'][] = $customer;
                echo json_encode($data);
                return false;

            }

            if(!$this->Users_model->insert_customer($user->id, $customer->id)){

                $data['errors'][] = 'Unable to insert customer data.';
                echo json_encode($data);
                return false;

            }

            $payment_array['customer_id'] = $customer->id;
            $payment_array['card'] = $customer->default_source;

        }else{

            $add_card = $this->payment_lib->add_credit_card($customer, $stripeToken);

            if(empty($add_card->id)){

                $this->save_credit_card_error($order_id, $add_card, $card_number);

                $data['errors'][] = $add_card;
                echo json_encode($data);
                return false;

            }

            $payment_array['customer_id'] = $customer;
            $payment_array['card'] = $add_card->id;

        }

        $payment_array['amount'] = 50;
        $result = $this->_do_payment_from_customer($payment_array);

        if(!empty($result['errors'])){

            $this->save_credit_card_error($order_id, $result['errors'], $card_number);

            $this->payment_lib->delete_credit_card($payment_array['customer_id'], $payment_array['card']);
            $data['errors'] = $result['errors'];
            echo json_encode($data);
            return false;

        }

        $info = $this->payment_lib->get_charge_info($result['response']['id']);
        $card_info = $this->payment_lib->get_card_info($payment_array['customer_id'], $payment_array['card']);

        $cvc_check = false;
        $street_check = false;
        $address_zip_check = false;
        $risk_check = true;
        $card_type = NULL;
        $card_country = NULL;

        if(!empty($card_info['cvc_check']) && $card_info['cvc_check'] == 'pass'){
            $cvc_check = true;
        }

        if(!empty($card_info['address_line1_check']) && $card_info['address_line1_check'] == 'pass'){
            $street_check = true;
        }

        if(!empty($card_info['address_zip_check']) && $card_info['address_zip_check'] == 'pass'){
            $address_zip_check = true;
        }

        if(!empty($info['outcome']['reason'])){
            $risk_check = false;
        }

        if(!empty($card_info['brand'])){
            $card_type = $card_info['brand'];
        }

        if(!empty($card_info['country'])){
            $card_country = $card_info['country'];
        }


        $refound = $this->_refund($result['response']['id']);
        if($refound !== true){
            $data['errors'] = $refound;
        }



        $insert_credit_card_info = [
            'holder_first_name' => trim($this->security->xss_clean($this->input->post('holder_first_name'))),
            'holder_last_name'  => trim($this->security->xss_clean($this->input->post('holder_last_name'))),
            'company_name'      => trim($this->security->xss_clean($this->input->post('company_name'))),
            'card_number'       => $card_number,
            'exp_mounth'        => trim($this->security->xss_clean($this->input->post('exp_mounth'))),
            'exp_year'          => trim($this->security->xss_clean($this->input->post('exp_year'))),
            'security_code'     => '***',
            'country_id'        => $country[1],
            'address1'          => trim($this->security->xss_clean($this->input->post('address1'))),
            'address2'          => trim($this->security->xss_clean($this->input->post('address2'))),
            'city'              => trim($this->security->xss_clean($this->input->post('city'))),
            'state_id'          => trim($this->security->xss_clean($this->input->post('state_region'))),
            'zip_code'          => trim($this->security->xss_clean($this->input->post('zip_code'))),
            'phone'             => trim($this->security->xss_clean($this->input->post('phone'))),
            'card_num'          => $card_num,
            'user_id'           => $user->id,
            'ver_status'        => '1',
            'card_id'           => $payment_array['card'],
            'customer_id'       => $payment_array['customer_id'],
            'type'              => $card_type,
            'origin'            => $card_country,
            'cvc_check'         => $cvc_check,
            'street_check'      => $street_check,
            'zip_check'         => $address_zip_check,
            'cc_copy'           => false,
            'cc_bin'            => false,
            'id_copy'           => false,
            'bank_v'            => false,
            'risk_check'        => $risk_check,
            'ver_attempt'       => 0
        ];

        $ins_result = $this->Users_model->insert_credit_card($insert_credit_card_info);

        if(!$ins_result['insert']){

            $data['errors'][] = 'Error insert credit card data';

        }

        if(empty($data['errors'])){

            $data['success'][] = 'Credit card successfully registered.';
            $data['card_id'] = $ins_result['insert_id'];
            $this->Users_model->last_update($user->id);

        }

        echo json_encode($data);

    }

    public function ax_edit_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $card_id = $this->security->xss_clean($this->input->post('card_id'));
        $card_num = $this->security->xss_clean($this->input->post('card_num'));


        if(empty($card_id)){

            show_404();
            return false;

        }

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $card_info = ['user_id' => $user->id, 'users_credit_cards.id' => $card_id, 'card_num' => $card_num];

        $card_info = $this->Users_model->get_credit_card_info($card_info);

        if(empty($card_info)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;

        }

        $card_info['action'] = 'edit';
        $card_info['card_num'] = $card_num;
        $card_info['card_number'] = substr($card_info['card_number'], -4, 4);
        $card_info['countries'] = $this->Users_model->get_countries();
        $card_info['states'] = $this->Users_model->get_states($card_info['country_id']);

        $this->load->view('frontend/user/my_profile/credit_card/template_credit_card', $card_info);

    }

    public function ax_check_edit_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }


        $id = $this->security->xss_clean($this->input->post('card_id'));
        $card_num = $this->security->xss_clean($this->input->post('card_num'));


        if(empty($id)){

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        if(!$this->Users_model->card_isset($user->id, $card_num, $id)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;

        }


        $fname        = trim($this->security->xss_clean($this->input->post('holder_first_name')));
        $lname        = trim($this->security->xss_clean($this->input->post('holder_last_name')));
        $company_name = trim($this->security->xss_clean($this->input->post('company_name')));
        $exp_mount    = trim($this->security->xss_clean($this->input->post('exp_mounth')));
        $exp_year     = trim($this->security->xss_clean($this->input->post('exp_year')));
        $address1     = trim($this->security->xss_clean($this->input->post('address1')));
        $address2     = trim($this->security->xss_clean($this->input->post('address2')));
        $city         = trim($this->security->xss_clean($this->input->post('city')));
        $state        = trim($this->security->xss_clean($this->input->post('state_region')));
        $zip_code     = trim($this->security->xss_clean($this->input->post('zip_code')));
        $country      = trim($this->security->xss_clean($this->input->post('credit_card_country')));
        $phone        = trim($this->security->xss_clean($this->input->post('phone')));
        $sec_cod      = trim($this->security->xss_clean($this->input->post('security_code')));


        $update_data = [];
        $data['errors'] = [];
        $data['success'] = [];


        if(empty($id)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;

        }

        $cc_old_info = $this->Users_model->get_credit_card_info(['users_credit_cards.id' => $id, 'user_id'=>$user->id]);

        if(empty($cc_old_info)){

            $data['errors'][] = 'Undefined credit card.';
            echo json_encode($data);
            return false;

        }


        if(empty($country)){

            $data['errors'][] = 'Please select country.';

        }

        if (empty($data['errors']) &&  count(explode('_', $country)) != 2) {

            $data['errors'][] = 'Invalid country information';

        }

        if(empty($data['errors']) && empty($address1)){

            $data['errors'][] = 'Please enter address1.';

        }


        if(empty($data['errors']) && empty($city)){

            $data['errors'][] = 'Please enter city.';

        }

        if(empty($data['errors']) && empty($fname)){

            $data['errors'][] = 'Please enter Firsname.';

        }

        if(empty($data['errors']) && empty($lname)){

            $data['errors'][] = 'Please enter Lastname.';

        }

        if(empty($data['errors']) && empty($sec_cod)){

            $data['errors'][] = 'Please enter Security cod.';

        }

        if(!empty($data['errors'])){

            echo json_encode($data);
            return false;

        }

        $card_id = $cc_old_info['card_id'];
        $customer_id = $cc_old_info['customer_id'];


        $update_data['address2'] = $address2;
        $update_data['state_id'] = $state;
        $update_data['zip_code']  = $zip_code;
        $update_data['phone']  = $phone;
        $update_data['address1'] = $address1;
        $update_data['city'] = $city;
        $country = explode('_',$country);
        $update_data['country_id'] = $country[1];

        $update = true;
        if($sec_cod!=='***'){
            $update = false;
        }

        if($update){

            if(empty($address2)){
                $address2 = NULL;
            }
            if(empty($zip_code)){
                $zip_code = NULL;
            }

            $updating_fields_stripe= [
                'address_city'    => $city,
                'address_country' => $country[1],
                'address_line1'   => $address1,
                'address_line2'   => $address2,
                'address_zip'     => $zip_code,
                'exp_month'       => $exp_mount,
                'exp_year'        => $exp_year,
                'name'            => $fname.' '.$lname
            ];

            $result = $this->payment_lib->update_credit_card($customer_id, $card_id,$updating_fields_stripe);

            if(empty($result->id)){

                $data['errors'][] = $result;
                echo json_encode($data);
                return false;

            }

            $update_data['card_id'] = $result->id;


        }else{

            $card_token_info = [
                'number'          => $cc_old_info['card_number'],
                'exp_month'       => $exp_mount,
                'exp_year'        => $exp_year,
                'cvc'             => $sec_cod,
                'address_city'    => $city,
                'address_country' => $country[0],
                'address_line1'   => $address1,
                'address_line2'   => $address2,
                'address_state'   => $state,
                'address_zip'     => $zip_code,
                'name'            => $fname.' '.$lname
            ];

            $create_tok = $this->payment_lib->create_card_token($card_token_info);

            if(empty($create_tok->id)){

                $data['errors'][] = $create_tok;
                echo json_encode($data);
                return false;

            }

            $new_token = $create_tok->id;

            $result = $this->payment_lib->add_credit_card($customer_id, $new_token);

            if(empty($result->id)){
                $data['errors'][] = $result;
                echo json_encode($data);
                return false;
            }

            $this->payment_lib->delete_credit_card($customer_id, $cc_old_info['card_id']);

            $update_data['card_id'] = $result->id;

        }

        $update_data['cvc_check'] = false;
        $update_data['street_check'] = false;
        $update_data['zip_check'] = false;

        if(!empty($result['cvc_check']) && $result['cvc_check'] == 'pass'){
            $update_data['cvc_check'] = true;
        }

        if(!empty($result['address_line1_check']) && $result['address_line1_check'] == 'pass'){
            $update_data['street_check'] = true;
        }

        if(!empty($result['address_zip_check']) && $result['address_zip_check'] == 'pass'){
            $update_data['zip_check'] = true;
        }

        $update_data['holder_first_name'] = $fname;
        $update_data['holder_last_name'] = $lname;
        $update_data['exp_mounth'] = $exp_mount;
        $update_data['exp_year'] = $exp_year;
        $update_data['company_name'] = $company_name;

        if(!$this->Users_model->edit_credit_card($id,$update_data)){

            $data['errors'][] = 'Update not success';

        }else{
            $this->Users_model->last_update($user->id);
            $data['success'][] = 'Update  Successfully';
        }


        echo json_encode($data);

    }

    public function ax_credit_card_verification(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $card_id    = $this->security->xss_clean($this->input->post('card_id'));
        $int_part   = $this->security->xss_clean($this->input->post('int_part'));
        $float_part = $this->security->xss_clean($this->input->post('float_part'));
        $card_num   = $this->security->xss_clean($this->input->post('card_num'));

        if(empty($card_id) || empty($card_num)){

            return false;

        }

        $user = $this->ion_auth->user()->row();

        $search_data = [
            'user_id'  => $user->id,
            'card_num' => $card_num,
            'users_credit_cards.id' => $card_id,
            'ver_status' => '2'
        ];

        $card_info = $this->Users_model->get_credit_card_info($search_data);

        $data['errors']  = [];
        $data['success'] = [];

        if(empty($card_info)){

            $data['errors'][] = 'Invalid credit card';
            echo json_encode($data);
            return false;

        }

        if($card_info['ver_attempt'] >= 2){
            $data['errors'][] = 'Аttempts limit exceeded';
            echo json_encode($data);
            return false;
        }


        $search_pay = [
            'user_id' => $user->id,
            'card_id' => $card_info['id']
        ];

        $pay = $this->Users_model->get_verification_payments($search_pay);

        if(empty($pay)){

            $data['errors'][] = 'No payment for this card';
            echo json_encode($data);
            return false;

        }

        $select_amount_payment = floatval($int_part.'.'.$float_part)*100;

        $ver_data = [
            'card_id' => $card_info['id'],
            'amount'  => $select_amount_payment
        ];

        if(!$this->Users_model->insert_ver_attempt($ver_data)){

            $data['errors'][] = 'Error insert verification pay to histry.';
            echo json_encode($data);
            return false;

        }

        if(intval($pay[0]['amount']) != intval($select_amount_payment)){


            //$this->Users_model->delete_credit_card($card_id);
            //$c_id = $card_info['card_id'];
            //$customer_id = $card_info['customer_id'];
            //$this->payment_lib->delete_credit_card($customer_id, $c_id);

            if(!empty($card_info['ver_attempt']) && $card_info['ver_attempt'] == 1){

                $data['success'][] = 'Your response has been sent to the administrator as soon as check';

            }else{

                $data['errors'][] = 'Invalid payment amount';

            }

            $this->Users_model->edit_credit_card($card_id,
                [
                    'ver_status' => '2',
                    'ver_attempt' => intval($card_info['ver_attempt'])+1,
                ]
            );

            echo json_encode($data);
            return false;

        }

        if($this->Users_model->edit_credit_card($card_id, ['ver_status'=>'3'])){

            $data['success'][] = 'Credit card successfully verified.';
            $this->_refund($pay[0]['charge_id']);

        }else{

            $data['errors'][] = 'Error updating data';

        }

        echo json_encode($data);

    }

    public function ax_delete_credit_card(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request() || !$this->ion_auth->logged_in()) {

            show_404();
            return false;

        }

        $card_id    = $this->security->xss_clean($this->input->post('card_id'));

        $data['errors'] = [];
        $data['success'] = [];

        $user = $this->ion_auth->user()->row();

        $search_data = [
            'user_id'  => $user->id,
            'users_credit_cards.id' => $card_id,
        ];

        $card_info = $this->Users_model->get_credit_card_info($search_data);

        if(empty($card_info)){

            $data['errors'][] = 'Invalid credit card';
            echo json_encode($data);
            return false;

        }

        $c_id = $card_info['card_id'];
        $customer_id = $card_info['customer_id'];

        if($this->Users_model->delete_credit_card($card_id) && $this->payment_lib->delete_credit_card($customer_id, $c_id)){

            $this->Users_model->last_update($user->id);
            $data['success'][] = 'credit card successfully deleted.';

        }else{

            $data['errors'][] = 'Error deleting data.';

        }

        echo json_encode($data);

    }

    public function _do_payment_from_customer($data){

        if(empty($data['amount']) || empty($data['customer_id'])){

            return false;

        }

        $data_res['errors'] = [];
        $data_res['response'] = [];

        $result = $this->payment_lib->do_paymant_from_customer($data);

        if(!empty($result->status) && $result->status == 'succeeded'){

            $data_res['response']['id'] = $result->id;
            $data_res['response']['amount'] = $result->amount;

        }else{

            $data_res['errors'] = $result;

        }

        return $data_res;

    }

    public function _refund($charge, $data = NULL){

        if(empty($charge)){

            return false;

        }

        $data['charge'] = $charge;

        $result = $this->payment_lib->refund($data);

        if($result->status === 'succeeded'){

            return true;

        }

        return $result;

    }



    /*
     * Load template
     * @access public
     * @param string $view, array $data, bool $returnhtml
     * @return void
     */
    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data: $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true

    }


    /*
     * Take captcha image (for ajax post request)
     * @access public
     * @return void
     */
    public function get_new_captcha(){

        if($this->input->method()!='post' || !$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $captcha = $this->captcha_lib->get_captcha();

        echo $captcha['image'];

    }

    /*
     * check busy email address (for ajax post request)
     * @access public
     * @return void
     */
    public function email_inuse(){

        if($this->input->method()!='post' || !$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $data['errors'] = '';

        $return = $this->input->post('return');

        $email = trim($this->input->post('email'));

        if(!$this->valid->is_email($email)){
            echo 'error';
            return false;
        }

        if($this->ion_auth->email_check($email)){
            $bool='true';
            $action = 'email_ajax_fail_check';
        }
        else{
            $bool='false';
            $action = 'email_ajax_success_check';
        }

        if($return == 'bool'){
            echo $bool;
            return false;
        }

        $this->load->view('frontend/messages',
            [
                'action'=>$action
            ]);

    }


    /*
     * take states list (for ajax post request)
     * @access public
     * @return void
     */
    public function get_states($action=NULL){

        if($this->input->method()!="post" || empty($this->input->post()) || !$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $data = $this->input->post("country");
        $data = explode("_", $data);

        $country_id=(!empty($data[1]))?$data[1]:0;

        $states=$this->Users_model->get_states($country_id);

        if(empty($states)){
            echo "nodata";
            return false;
        }

        $this->load->view("frontend/user/small_ajax_templates", ['states'=>$states, 'action' => $action]);

    }

    /*
     * Sending email
     * @access public
     * @param array $email_data
     * @return object
     */
    public function _send_email($email_data){

        $this->load->library('email_lib');

        return $res = $this->email_lib->sendgrid_email($email_data);

    }


    private function get_email_header(){

        $header_data=[
            'logo_image'  => 'https://www.luggagetoship.com/assets/email-resources/logo.png',
            'phone_image' => 'https://www.luggagetoship.com/assets/email-resources/phone.png',
            'mail_image'  => 'https://www.luggagetoship.com/assets/email-resources/mail.png',
        ];

        return $this->load->view('email_templates/header',$header_data, true);

    }

    private function get_email_footer(){

        $footer_data=[
            'twitter_image'   => 'https://www.luggagetoship.com/assets/email-resources/twitter.png',
            'fb_image'        => 'https://www.luggagetoship.com/assets/email-resources/facebook.png',
            'google_image'    => 'https://www.luggagetoship.com/assets/email-resources/googleplus.png',
            'pinterest_image' => 'https://www.luggagetoship.com/assets/email-resources/pinterest.png'
        ];

        return $this->load->view('email_templates/footer',$footer_data, true);

    }

    public function get_free_card_num($user_id){

        $array = ['1','2','3'];

        $card_nums = $this->Users_model->get_user_card_nums($user_id);

        if(empty($card_nums)){
            return $array[0];
        }

        foreach($array as $num){
            if(!in_array($num, $card_nums)){
                return $num;
            }
        }

        return false;

    }

    public function user_order_count_test($arg = NULL){

        if($arg != 'asdasdasd'){
            show_404();
        }

        $this->load->model('Order_model');

        $users = $this->Users_model->get_users_info();

        foreach($users['result'] as $single_user){

            $user_id = $single_user['id'];

            $count = $this->Order_model->get_orders_count(['user_id' => $user_id]);

            if(empty($count)){
                continue;
            }

            $this->Users_model->update_user(['total_orders' => $count], $user_id);

        }

    }

    private function save_credit_card_error($order_id, $message, $card_num = ''){

        $this->load->model('Order_model');

        if(empty($order_id)) {
            return false;
        }

        if(is_array($message)){
            $message = implode(",", $message);
        }

        $insert_data = [
            'order_id' => $order_id,
            'admin_name' => 'Stripe',
            'add_date' => date('Y-m-d H:i:s'),
            'message' => 'Card number:'.$card_num.' - '.$message
        ];

        if(!$this->Order_model->insert_finicial_notes($insert_data)){
            return false;
        }

        return true;

    }

/*    public function tests(){

        $country = $this->Users_model->get_countries();

        $this->load->model("Manage_price_model");

        $inter_us =  $this->Manage_price_model-> get_international('0');
        $dom_us =  $this->Manage_price_model-> get_domestic('0');
        $products = $this->Manage_price_model->get_product();


        $empty_array = [];
        foreach ($country as $single){

            foreach ($products as $prod){

                $inter =  $this->Manage_price_model->get_international($single['id'],$prod['product_id']);
                $dom =  $this->Manage_price_model-> get_domestic($single['id']);

                if(empty($inter)){

                    $empty_array[] = [
                        'product_id' => $prod['product_id'],
                        'country_id' => $single['id']
                    ];
                }


            }



        }

        foreach ($empty_array as $single){

            foreach ($inter_us as $index => $val){

                unset($inter_us[$index]['international_id']);
                unset($val['international_id']);
                if($single['product_id'] == $val['luggage_id']){

                    $val['country_id'] = $single['country_id'];

                    $result1 = $this->Manage_price_model->insert_one_international($val);
                    var_dump($result1);
                }
            }

            foreach ($dom_us as $index => $val){

                unset($dom_us[$index]['domestic_id']);
                unset($val['domestic_id']);

                if($single['product_id'] == $val['luggage_id']){
                    $val['country_id'] = $single['country_id'];
                    $result2 = $this->Manage_price_model->insert_one_domestic($val);
                    var_dump($result2);
                }
            }
        }



        exit();


    }*/


/*    public function sql_test(){


        $sql1 = ' DROP TABLE IF EXISTS `luggage_product`';
        $query1 = $this->db->query($sql1);
        $sql2 =  '
        CREATE TABLE `luggage_product` (
        `product_id` int(250) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(250) unsigned DEFAULT NULL,
  `luggage_name` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `max_count` int(10) DEFAULT NULL,
  `length` int(4) DEFAULT NULL,
  `width` int(4) DEFAULT NULL,
  `height` int(4) DEFAULT NULL,
  `weight` int(4) DEFAULT NULL,
  `girth` int(4) DEFAULT NULL,
  `li_class` varchar(255) DEFAULT NULL,
  `image_class` varchar(255) DEFAULT NULL,
  `calc_length` int(4) DEFAULT NULL,
  `calc_width` int(4) DEFAULT NULL,
  `calc_height` int(4) DEFAULT NULL,
  `sizes_image` varchar(255) DEFAULT NULL,
  `ordering` int(2) DEFAULT NULL,
  KEY `id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
        ';
        $query2 = $this->db->query($sql2);
       $sql3='insert  into `luggage_product`(`product_id`,`type_id`,`luggage_name`,`short_name`,`max_count`,`length`,`width`,`height`,`weight`,`girth`,`li_class`,`image_class`,`calc_length`,`calc_width`,`calc_height`,`sizes_image`,`ordering`) values (5,4,\'Small Luggage\',\'Small\',10,22,20,20,25,52,\'luggage-7\',\'small-luggage.png\',11,22,14,\'small_l.jpg\',1),(6,4,\'Medium Luggage\',\'Medium\',10,26,20,20,35,58,\'luggage-6\',\'medium-luggage.png\',12,26,17,\'medium_l.jpg\',2),(7,4,\'Standard Luggage\',\'Standard \',10,30,20,20,50,62,\'luggage-5\',\'standard-luggage.png\',11,30,20,\'standard_l.jpg\',3),(8,4,\'Large Luggage\',\'Large \',10,32,20,20,60,64,\'luggage-4\',\'oversize-luggage.png\',11,32,21,\'large_l.jpg\',4),(9,4,\'X Large Luggage\',\'X Large\',10,34,20,20,75,72,\'luggage-3\',\'x-large-luggage.png\',14,34,22,\'x_large.jpg\',5),(24,4,\'Oversize Luggage\',\'Oversize \',10,38,20,20,85,75,\'luggage-2\',\'large-luggage.png\',14,38,22,\'oversize_l.jpg\',6),(12,5,\'Small Box\',\'Small \',10,15,15,15,25,60,\'box-3\',\'box_small.png\',15,15,15,\'small_box.jpg\',7),(13,5,\'Standard Box\',\'Standard \',10,18,18,18,42,72,\'box-2\',\'box_standard.png\',18,18,18,\'standart_box.jpg\',8),(14,5,\'Large Box\',\'Large\',10,20,20,20,60,80,\'box-1\',\'box_large.png\',20,20,20,\'large_box.jpg\',9),(15,6,\'Small Travel Bag\',\'Small\',10,50,20,20,35,44,\'golf-5\',\'small-travel.png\',10,50,12,\'small_g.jpg\',10),(16,6,\'Standard Travel Bag\',\'Standard \',10,52,20,20,40,46,\'golf-4\',\'standard-travel.png\',11,52,12,\'standard_g.jpg\',11),(17,6,\'Large Travel Bag\',\'Large\',10,52,20,20,50,50,\'golf-3\',\'large-travel.png\',11,52,14,\'large_g.jpg\',12),(18,6,\'Delux Travel Bag\',\'Delux\',10,53,20,20,55,54,\'golf-2\',\'delluxe-travel.png\',12,53,15,\'delux_g.jpg\',13),(19,6,\'Large Pro Travel Bag\',\'Large Pro\',10,54,20,20,60,60,\'golf-1\',\'large-pro-travel.png\',15,54,15,\'large_pro_g.jpg\',14),(20,7,\'Bike Box\',\'Bike\',10,55,20,20,55,72,\'ski-2\',\'ski_bag.png\',8,55,28,\'heavy_byke.jpg\',15),(21,7,\'Ski Bag\',\'Ski\',10,72,20,20,22,25,\'ski-4\',\'small_snowboard.png\',7,72,7,\'1_ski_bike.jpg\',16),(22,7,\'Double Ski Bag\',\'Double Ski\',10,74,20,20,40,36,\'ski-3\',\'double_sky_bag.png\',7,74,11,\'2_ski_bike.jpg\',17),(23,7,\'Small Snowboard\',\'Small \',10,65,20,20,30,36,\'ski-5\',\'large_snowboard.png\',7,65,11,\'light_byke.jpg\',18),(25,7,\'Large Snowboard\',\'Large \',10,20,20,20,40,NULL,\'ski-1\',\'bike_box.png\',11,75,13,\'2_ski_bike.jpg\',19)';
     $query3 = $this->db->query($sql3);

     var_dump($query1);
     var_dump($query2);
     var_dump($query3);
    }*/

}

?>