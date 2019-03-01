<?php

class home_model {

    private $con;

    public function __construct($con){

        $this->con = $con;
    }

    public function check_email($email= Null){

        if(empty($email)){

            return false;
        }

        $sql = "SELECT * FROM users WHERE email = {$email}";

        $result = $this->SetQuery($sql);

        if(!empty($result)){

            return false;
        }

        return true;
    }

    public function insert_data($table=Null,$data=Null){

        if(empty($table) || empty($data)){

            return false;
        }

        $val = '';
        $key  = '';

        foreach ($data as $index => $single){

            $key .= $index.',';
            $val .= '"'.$single.'"'.',';
        }

        $val = rtrim($val, ',');
        $key = rtrim($key, ',');

        $query = "INSERT INTO {$table} ($key) VALUES ({$val})";

        if(!mysqli_query($this->con, $query)){

            return false;
        }

        return true;
    }

    public function get_login_info($email, $password=Null, $bool=false){

        if(empty($email)){
            echo 'a';
            return false;
        }

        if($bool){

            $sql1="SELECT COUNT(*) as count FROM users 
              WHERE 
              email='".$email."'
              AND pass='".$password."'
              ";

            $result = $this->SetQuery($sql1);

            if(empty($result[0]['count'])){

                return false;

            }
        }

        $where = " WHERE email='".$email."' ";

        if(!empty($password)){

            $where.= "AND pass='".$password."'";
        }

        $sql2="SELECT * FROM users".$where;

        return $this->SetQuery($sql2);
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