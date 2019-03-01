<?php

class Model {

    public $con;
    public $table;
    public  $class;

    function __construct($host="localhost", $username="root", $password="", $dbname=""){
        if($dbname!=""){
            $con=mysqli_connect($host, $username, $password);
            mysqli_query($con, "CREATE DATABASE IF NOT EXISTS ".$dbname);
            $this->con=mysqli_connect($host, $username, $password, $dbname);
        }

    }

    public function render_model($name=Null){

        if(empty($name)){
            include 'views/error.php';
            return false;
        }

        if(!file_exists('models/'.$name.'.php')){
            include 'views/not_found.php';
            return false;
        }

        include 'models/'.$name.'.php';

        return new $name($this->con);
    }
}