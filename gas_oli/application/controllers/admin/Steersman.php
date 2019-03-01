<?php
class Steersman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Steersman_model");
    }

    public function index()
    {

        $this->all_steersman();
    }

    public function all_steersman(){

        $this->check_admin_login();

        $data['content'] = 'admin/steersman/all_steersman';

        $this->load->view('admin/back_template',$data);
    }

    public function ax_get_all_steersman(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $page        = trim($this->input->post('page'));
        $type        = trim($this->input->post('type'));
        $search_type = trim($this->input->post('searching_type'));
        $ordering    = $this->input->post('order');
        $limit       = $this->input->post('length');

        if(empty($page)){

            $page = 1;
        }

        $return_data = [];
        $name_cr = [];
        $cr = [];

        $cr = [
            $type =>$search_type
        ];

        $asc_desc = $this->input->post('order');

        $limit = [10,0];

        $start = $this->input->post('start');
        $length = $this->input->post('length');

        if(!empty($start) || !empty($length)){

            $limit = [$length,$start];
        }

        $colums = [

            1 => 'first_name',
            2 => 'last_name',
            3 => 'email',
            4 => 'tel',
        ];

        if(!empty($ordering)){

            $ordering = [
                $colums[$asc_desc[0]['column']],
                $asc_desc[0]['dir']
            ];

        }else{
            $ordering = ['first_name', 'ASC'];
        }


        $all_count = $this->Steersman_model->get_all_driver_count($cr);

        $all_driver = $this->Steersman_model->get_all_driver($limit,$cr,$ordering);

        if(empty($all_driver)){

            $all_count = 0;
            $return_data['recordsTotal'] = 0;
            $return_data['recordsFiltered'] = 0;

            $return_data['data'] = [];
            echo json_encode($return_data);
            return false;
        }

        $status_arr = [
            0 => 'inActive',
            0 => 'Active',
        ];

        foreach ($all_driver as $index => $single){

            $return_data['data'][] = [
                $index+1,
                $single['first_name'],
                $single['last_name'],
                $single['email'],
                $single['tel'],
                $status_arr[$single['status']],
                "<input type='checkbox' name='check_well' class='edit_delete_cew' value='" . $single['id'] . "'>",
            ];
        }

        $return_data['draw'] = $this->input->post('draw');
        $return_data['recordsTotal'] = $all_count;
        $return_data['recordsFiltered'] = $all_count;

        echo json_encode($return_data);


    }

    public function add_steersman(){

        $this->check_admin_login();

        $data['content'] = 'admin/steersman/add_steersman';

        $this->load->view('admin/back_template',$data);
    }

    public function ax_update_crew(){
        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $crew = $this->input->post('company');

        $data['errors'] = [];

        if(empty($crew)){
            $data['errors'] = 'lease set company';
            echo json_encode($data);
            return false;
        }

        foreach ($crew as $index => $value) {

            $data['crew'][] = $this->Steersman_model->get_steersman($value);
        }

        $this->load->view('admin/steersman/update_crew_answer',$data);
    }

    public function ax_save_update_crew(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $crew_name  = $this->input->post('crew_name');
        $crew_lname = $this->input->post('crew_lname');
        $crew_tel   = $this->input->post('crew_tel');
        $crew_email = $this->input->post('crew_email');

        foreach ($crew_name as $index => $val){

            $update_data = [
                'first_name' => $val,
                'last_name'  => $crew_lname[$index],
                'email'      => $crew_email[$index],
                'tel'        => $crew_tel[$index]
            ];

            $this->Steersman_model->update_steersman($index,$update_data);
        }

        echo json_encode(true);
    }

    public function ax_delete_crew(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $crews = $this->input->post('company');

        $data['errors'] = [];

        if(empty($crews)){
            $data['errors'] = 'lease set company';
            echo json_encode($data);
            return false;
        }

        foreach ($crews as $index => $value) {

            $this->Steersman_model->delete_crew($value);

        }

        echo json_encode(true);

    }

    public function save_steersmans(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $name    = trim($this->input->post('name'));
        $surname = trim($this->input->post('surname'));
        $email   = trim($this->input->post('email'));
        $tel     = trim($this->input->post('tel'));

        $data['errors'] = [];
        $data['success'] = [];

        if (empty($name)) {
            $data['errors'][] = 'Name field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($surname)) {
            $data['errors'][] = 'Surname field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($email)) {
            $data['errors'][] = 'Email field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($tel)) {
            $data['errors'][] = 'Tel. field is required.';
            echo json_encode($data);
            return false;
        }

        $all_steersman = $this->Steersman_model->get_driver();

        $exist = false;

        foreach ($all_steersman as $single){

            $exist = in_array($email,$single);
        }

        if ($exist) {
            $data['errors'][] = 'This email is already exist.';
            echo json_encode($data);
            return false;
        }

        $insert_data = [
            'first_name' => $name,
            'last_name'  => $surname,
            'email'      => $email,
            'tel'        => $tel,
            'status'     => 0
        ];

        $driver_id = $this->Steersman_model->insert_steersman($insert_data);

        if(!$driver_id){

            $data['errors'][] = 'Data not saved!';

        }else{

            $email_data['subject'] = 'Activity password';
            $email_data['subject_description'] = 'Activity password';
            $email_data['email'] = $email;
            $email_data['to_name'] = 'Driver';

            $body = '
            <p>Please click the following link to set your password</p> 
            <a href="'.base_url('crew/activity_password/').$driver_id.'">Activity Password</a>';

            $email_data['message'] = $body;

            $this->load->library('email_lib');

            $send = $this->email_lib->sendgrid_email($email_data);

            $data['success'] = 'All data Saved!';
        }

        echo json_encode($data);

    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }
    }
}