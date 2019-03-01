<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class home extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model("Home_model");

    }

    public function index(){

        $this->home_page();
    }

    public function insert_data(){

        $data['error'] = '';
        $data['success'] = '';

         if ($this->input->method() != 'post') {

            $data['error'] = 'error!';
            return false;
        }


         $name  = trim($this->security->xss_clean($this->input->post('name')));
         $price = trim($this->security->xss_clean($this->input->post('price')));
         $desc  = trim($this->security->xss_clean($this->input->post('desc')));


          $url = '../front/src/assets/images';

        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        $config['upload_path'] = $url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
        $config['max_size'] = 4096;
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('upload_image') == false) {

            $data['errors'] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

         $insert_data = [
            'name'    => $name,
            'price'   => $price,
            'desc'    => $desc,
            'image'   => $file_info['file_name'],
            'like'    => 0,
            'dislike' => 0

         ];

        $this->Home_model->insert_product($insert_data);

          $data['success'] = 'inserted';

        echo json_encode($data);

    }

    public function get_all_data(){

        $data = $this->Home_model->get_product();

        echo json_encode($data);
    }

    public function get_data(){

         $post_data  = json_decode(file_get_contents('php://input'), true);

         if(empty($post_data['id'])){

            return false;
         }

         $data = $this->Home_model->get_product($post_data['id']);

        echo json_encode($data);
    }

    public function update_like_dislike(){

        $id      = trim($this->security->xss_clean($this->input->post('id')));
        $action  = trim($this->security->xss_clean($this->input->post('action')));

        if(empty($id) || empty($action)){

            return false;
        }

        $prod = $this->Home_model->get_product($id);

        if($action == 'like'){

             $update_data = ['like' =>$prod['like'] +1];
        
        }else{

            $update_data = ['dislike' =>$prod['dislike'] +1];
        }

       

        $this->Home_model->update_likes($id,$update_data);

        $prod = $this->Home_model->get_product($id);
        
        $data['like'] =$prod['like'];
        $data['dislike'] =$prod['dislike'];

        echo json_encode($data);
    }

}

?>