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


         $name      = trim($this->security->xss_clean($this->input->post('name')));
         $email     = trim($this->security->xss_clean($this->input->post('email')));
         $question  = trim($this->security->xss_clean($this->input->post('question')));
         $type      = trim($this->security->xss_clean($this->input->post('type')));
    
         $insert_data = [
            'name'     => $name,
            'email'    => $email,
            'question' => $question,
            'like'     => 0,
            'dislike'  => 0

         ];

        $this->Home_model->insert_question($insert_data);

          $data['success'] = 'inserted';

        echo json_encode($data);

    }

    public function insert_comment(){

         $id      = trim($this->security->xss_clean($this->input->post('id')));
         $comment = trim($this->security->xss_clean($this->input->post('comment')));

         $data['error'] = '';
         $data['success'] = '';

         $data = $this->Home_model->get_questions($id);

         if(empty($id)){

            $data['error'] = 'error';
         }

         $insert_data = [
            'quest_id' => $id,
            'comment'  => $comment
         ];

        $this->Home_model->insert_comment($insert_data);

          $data['success'] = 'inserted';

        echo json_encode($data);
    }

    public function get_comment($id = NULL){

        if(empty($id)){

           return false;
        }

        $data = $this->Home_model->get_comment($id);
    
        echo json_encode($data);
    }

    public function get_all_data(){

        $data = $this->Home_model->get_questions();
    
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
            $data = '';
            return false;
        }

        $prod = $this->Home_model->get_questions($id);
        
        if(empty($prod)){
              $data = '';
              return false;
        }

        if($action == 'like'){

             $update_data = ['like' =>$prod[0]['like'] +1];
        
        }else{

            $update_data = ['dislike' =>$prod[0]['dislike'] +1];
        }

       

        $this->Home_model->update_likes($id,$update_data);

        $prod = $this->Home_model->get_questions($id);
        
        $data['like']    = $prod[0]['like'];
        $data['dislike'] = $prod[0]['dislike'];

        echo json_encode($data);
    }

        public function update_comment_like_dislike(){

        $id              = trim($this->security->xss_clean($this->input->post('id')));
        $comment_id      = trim($this->security->xss_clean($this->input->post('comment_id')));
        $action          = trim($this->security->xss_clean($this->input->post('action')));

        if(empty($id) || empty($action)){
            $data = '';
            return false;
        }

        $comment = $this->Home_model->get_comment($id,$comment_id);
     
        
        if(empty($comment)){
              $data = '';
              return false;
        }

        if($action == 'like'){

             $update_data = ['like' =>$comment[0]['like'] +1];
        
        }else{

            $update_data = ['dislike' =>$comment[0]['dislike'] +1];
        }

       

        $this->Home_model->update_comment_likes($comment_id,$update_data);

        $comment = $this->Home_model->get_comment($id,$comment_id);
        
        $data['like']    = $comment[0]['like'];
        $data['dislike'] = $comment[0]['dislike'];

        echo json_encode($data);
    }

}

?>