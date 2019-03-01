<?php

class Company extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Company_model");
        $this->load->model("Well_model");
    }

    public function index()
    {

        show_404();
    }

    public function add_company()
    {

        $this->check_admin_login();


        $data['content'] = 'admin/company/add_company';

        $this->load->view('admin/back_template', $data);

    }

    public function all_company()
    {

        $this->check_admin_login();

        $data['content'] = 'admin/company/all_company';

        $this->load->view('admin/back_template', $data);
    }

    public function ax_get_all_company()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $page = trim($this->input->post('page'));
        $ordering = $this->input->post('order');
        $limit = $this->input->post('length');
        $search_type = trim($this->input->post('searching_type'));

        if (empty($page)) {

            $page = 1;
        }

        $return_data = [];

        $cr = [];

        $cr = [
            'name' => $search_type
        ];

        $asc_desc = $this->input->post('order');

        $limit = [10, 0];

        $start = $this->input->post('start');
        $length = $this->input->post('length');

        if (!empty($start) || !empty($length)) {

            $limit = [$length, $start];
        }

        $colums = [
            1 => 'name'
        ];

        if (!empty($ordering)) {

            $ordering = [
                $colums[$asc_desc[0]['column']],
                $asc_desc[0]['dir']
            ];

        } else {
            $ordering = ['first_name', 'ASC'];
        }

        $all_count = $this->Company_model->get_company_count($cr);

        $all_company = $this->Company_model->get_company($limit, $cr, $ordering);

        if (empty($all_company)) {

            $all_count = 0;
            $return_data['recordsTotal'] = 0;
            $return_data['recordsFiltered'] = 0;

            $return_data['data'] = [];

            echo json_encode($return_data);
            return false;
        }
        foreach ($all_company as $index => $single) {

            $return_data['data'][] = [
                $index + 1,
                $single['name'],
                "<input type='checkbox' name='check_well' class='edit_delete_company' value='" . $single['id'] . "'>",
            ];
        }

        $return_data['draw'] = $this->input->post('draw');
        $return_data['recordsTotal'] = $all_count;
        $return_data['recordsFiltered'] = $all_count;

        echo json_encode($return_data);
    }

    public function ax_save_company()
    {

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $name = trim($this->input->post('name'));

        if (empty($name)) {
            $data['errors'][] = 'Well Name field is required.';
            echo json_encode($data);
            return false;
        }

        if (!$this->Company_model->insert_company(['name' => $name])) {

            $data['errors'][] = 'Data not saved!';
        }

        echo json_encode($data);
        return false;
    }

    public function ax_update_company()
    {

        $this->check_admin_login();

        $companies = $this->input->post('company');

        $data['errors'] = [];

        if(empty($companies)){
            $data['errors'] = 'lease set company';
            echo json_encode($data);
            return false;
        }

        foreach ($companies as $index => $value) {

            $data['company'][] = $this->Company_model->get_company_by_crt(['id' => $value],true);
        }

        $this->load->view('admin/company/update_company_answer',$data);
    }

    public function ax_save_update_company(){

        $this->check_admin_login();

        $check_arr = $this->input->post('company_name');

        foreach ($check_arr as $index => $val){

            $this->Company_model->update_company($index, ['name' => $val]);
        }

        echo json_encode(true);
    }

    public function ax_delete_company(){

        $companies = $this->input->post('company');

        $data['errors'] = [];

        if(empty($companies)){
            $data['errors'] = 'lease set company';
            echo json_encode($data);
            return false;
        }

        foreach ($companies as $index => $value) {

             $this->Company_model->delete_company($value);
             $well = $this->Well_model->get_well(['company_id' =>$value]);

             foreach ($well as $index => $single){

                 $this->Well_model->delete_well($single['id']);
             }
        }

        echo json_encode(true);
    }

    private function check_admin_login()
    {

        if (!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }
    }
}