<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Faq extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->lang->load('auth');
        $this->load->model("Users_model");
        $this->load->model("Ion_auth_model");
    }


    function index(){


        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $data['content'] = 'frontend/faq';

        $this->load->view('frontend/site_main_template', $data);
    }


}