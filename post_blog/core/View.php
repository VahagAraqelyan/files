<?php

class View {

    public function __construct(){
    }

    public function render_view($name=Null,$data=Null){

        if(empty($name)){
            include 'views/error.php';
            return false;
        }

        if(!file_exists('views/'.$name.'.php')){
            include 'views/not_found.php';
            return false;
        }

        include 'views/'.$name.'.php';
        if(!empty($data)){
            $data;
        }
    }
}