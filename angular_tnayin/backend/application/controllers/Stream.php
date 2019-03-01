<?php
Class Stream extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model("Users_model");
        $this->load->model("Order_model");

    }

    public function labels($file_name, $hash){

        $crt = [
            'labels_pdf' => $file_name
        ];

        $order_info = $this->Order_model->get_order_crt($crt);

        if(empty($order_info)){
            show_404();
            exit;
        }

        $this->load->library('Admin_security');

        $this->load->config('order');

        $false_status_aray = $this->config->item('pdf_false_statuses');

        if(!empty($false_status_aray) && !$this->admin_security->is_admin()){

            foreach ($false_status_aray as $single){

                if(in_array($order_info[0]['shipping_status'],$false_status_aray)){

                    $data['content'] = 'label_error';
                    $data['info'] = [
                        'account_num' => '',
                        'user_name'   => ''
                    ];
                    $this->load->view("frontend/site_main_template",$data);
                   return false;
                }
            }
        }

        $original_hash = sample_hash($order_info[0]['user_id']);

        if($hash != $original_hash){
            show_404();
            exit;
        }

        $file_path = FCPATH.'/labels/'.$file_name;

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        exit;

    }

    
}
?>