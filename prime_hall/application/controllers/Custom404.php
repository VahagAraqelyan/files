<?php
class Custom404 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function index()
    {

        $this->output->set_status_header('404');
        $data['content'] = '404';
        $data['info'] = [
            'account_num' => '',
            'user_name'   => ''
        ];
        $this->load->view("frontend/site_main_template",$data);

    }
}
?>