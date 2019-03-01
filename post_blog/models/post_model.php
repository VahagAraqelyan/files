<?php

class post_model
{

    private $con;

    public function __construct($con)
    {

        $this->con = $con;
    }

    public function get_posts(){

        $sql="SELECT * FROM posts";

        return $this->SetQuery($sql);
    }

    public function get_comment($where){

        $sql="SELECT * FROM comment ".$where;

        return $this->SetQuery($sql);
    }

    public function SetQuery($query){

        $result = mysqli_query($this->con, $query);

        $return_data = [];

        if(empty($result)){

            return false;
        }

        while($row = mysqli_fetch_assoc($result)) {

            $return_data[] = $row;
        }

        return $return_data;

    }
}