<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistic_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_statistic_count($date){

        if(empty($date)){
            return false;
        }


        $this->db->where('date',$date);
        $result = $this->db->get('user_statistic_count')->row_array();

        if(empty($result)){
            return 0;
        }

        return $result;
    }

    public function get_user_statistic($crt){

        if(empty($crt)){
            return false;
        }


        $this->db->where($crt);

        $result = $this->db->get('user_statistic')->row_array();

        return $result;
    }

    public function insert_user_statistic($data){

        if(empty($data)){
            return false;
        }

        $result =  $this->db->insert('user_statistic', $data);


        return $result;
    }

    public function insert_user_statistic_count($data){

        if(empty($data)){
            return false;
        }

        $result =  $this->db->insert('user_statistic_count', $data);

        return $result;
    }

    public function delete_old_user_statistic($old_data){

        if(empty($old_data)){

            return false;
        }

        $this->db->where('date <', $old_data);
        $this->db->delete('user_statistic');

    }

    public function update_user_statistic_count($data,$date){

        if(empty($data) || empty($date)){

            return false;
        }

        $this->db->where('date', $date);
        $result =  $this->db->update('user_statistic_count', $data);

        return $result;
    }

    public function get_statistic($date){

        if(empty($date)){

            return false;
        }

        $query = "
          SELECT 
          id,
          `count` AS cnt,
          `date` 
        FROM
          user_statistic_count 
        WHERE MONTH(`date`) = $date[1] 
          AND YEAR(`date`) = $date[0]
        ";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

}