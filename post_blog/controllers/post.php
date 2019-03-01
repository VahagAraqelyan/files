<?php

class Post extends Controller
{

    public function __construct()
    {

        parent:: __construct();

    }

    public function index(){

        $this->add_post();
    }

    public function add_post(){

        $data['content'] = 'post/add_post';

        $this->view->render_view('site_main_template',$data);
    }

    public function ax_add_post(){

        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            echo json_encode(false);
            return false;
        }

        if(empty($_POST['post_name']) || empty($_POST['desc'])){

            echo json_encode(false);
            return false;
        }

        $insert_data = [
            'name'        => $_POST['post_name'],
            'description' => $_POST['desc'],
        ];

        $home_model = $this->model->render_model('home_model');
        $result = $home_model->insert_data('posts', $insert_data);

        if(!$result){

            echo json_encode(false);
            return false;
        }

        echo json_encode(true);
    }

    public function ax_add_comment(){

        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            echo json_encode(false);
            return false;
        }

        if(empty($_POST['comment']) || empty($_POST['post_id'])){
            echo json_encode(false);
            return false;
        }

      $insert_data = [
          'comment' => $_POST['comment'],
          'post_id' => $_POST['post_id'],
      ];

        $home_model = $this->model->render_model('home_model');
        $result = $home_model->insert_data('comment', $insert_data);

        if(!$result){

            echo json_encode(false);
            return false;
        }

        echo json_encode(true);
    }
}