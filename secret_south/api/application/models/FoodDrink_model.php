<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FoodDrink_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_food_drink($data){

        if(empty($data)){
            return false;
        }

        return $this ->db->insert('food_drink',$data);
    }


    public function get_food_drink($cr = NULL){

        if(!empty($cr)){

            $this->db->where($cr);
        }

        return $this->db->get('food_drink')->result_array();
    }
}