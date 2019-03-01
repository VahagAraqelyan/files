<?php

class Controller {

    public $view;
    public $model;

    public function __construct(){

        $this->view  = new View();
        $this->model = new Model(DB_INFO[0],DB_INFO[1],DB_INFO[2],DB_INFO[3]);
    }

    public function index(){

        $filename = 'home';

        if(!empty($_GET['url'])){

            $filename = $_GET['url'];
        }

        $filename = explode('/',rtrim($filename,'/'));

        if(!file_exists('controllers/'. strtolower($filename[0]).'.php')){
            $this->view->render_view('not_found');
            return false;
        }

        $class = new $filename[0]();

        if(count($filename)== 1){

            $boll = $this->check_method($class,'index');

            if(!$boll){
                return false;
            }

            $class->index();

        }else if(count($filename)>1){

            $method = $filename[1];

            unset($filename[0]);
            unset($filename[1]);

            $boll = $this->check_method($class, $method);

            if(!$boll){
                return false;
            }

            $function = new ReflectionMethod($class, $method);

            $function->invokeArgs(new $class, $filename);
        }
    }

    private function check_method($class=Null,$method=Null){

        if(empty($class) || empty($method)){

            $this->view->render_view('not_found');
            return false;
        }

        if(!method_exists($class, $method)){

            $this->view->render_view('not_found');
            return false;
        }

        return true;
    }
}