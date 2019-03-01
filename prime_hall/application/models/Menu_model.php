<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public function __construct(){

        parent::__construct();

    }

    public function get_menu_type(){

        $result = $this->db->get('menu_type')->result_array();

        return $result;
    }

    public function get_menu_by_type_id($type_id,$return = NULL){

        if(empty($type_id)){

            return false;
        }

        $this->db->where('type_id', $type_id);

        if(!empty($return)){

            $result = $this->db->get('menus')->result_object();
            return $result;
        }

        $result = $this->db->get('menus')->result_array();

        return $result;
    }

    public function add_menu($data){

        if(empty($data)){

            return false;
        }

        $result =  $this->db->insert('menus', $data);

        return $result;
    }

    public function update_menu($data,$menu_id){

        if(empty($data) || empty($menu_id)){

            return false;
        }

        $this->db->where('id', $menu_id);
        $result =  $this->db->update('menus', $data);

        return $result;
    }

    public function delete_menu($crt){

        if(sizeof($crt) == 0){

            return false;
        }

        $this->db->where($crt);

        $result = $this->db->delete('menus');

        return  $result;
    }

    public function delete_food_type($crt){

        if(sizeof($crt) == 0){

            return false;
        }

        $this->db->where($crt);

        $result =  $this->db->delete('food_type');

        return $result;
    }

    public function batch_insert_menu($data){

        if(sizeof($data) == 0){

            return false;
        }

       $result =  $this->db->insert_batch('menus', $data);
        echo $this->db->last_query();
        return $result;
    }

    public function insert_food_type($data){

        if(sizeof($data) == 0){

            return false;
        }

        $result =  $this->db->insert('food_type', $data);

        return $this->db->insert_id();
    }

    public function update_menu_type($data,$menu_id){

        if(empty($data) || empty($menu_id)){

            return false;
        }

        $this->db->where('id', $menu_id);
        $result =  $this->db->update('food_type', $data);

        return $result;
    }

    public function get_menu_by_food_id($food_id,$type_id, $return = NULL,$crt = NULL){

        if(empty($food_id) || empty($type_id)){

            return false;
        }


        if(!empty($crt)){
            $this->db->where($crt);
        }

        $this->db->where('food_type_id', $food_id);
        $this->db->where('type_id', $type_id);
        $this->db->order_by("id", "asc");

        if(!empty($return)){

            $result = $this->db->get('menus')->result_object();
            return $result;
        }

        $result = $this->db->get('menus')->result_array();

        return $result;
    }

    public function get_food_type($id,$crt = NULL){

        if(empty($id)){
            return false;
        }

        $this->db->where('menu_type_id', $id);
        $this->db->order_by("id", "asc");
        $result = $this->db->get('food_type')->result_array();

        return $result;
    }
}