<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reservetion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_reservetion($data){

        if(empty($data)){

            return false;
        }

        $result =  $this->db->insert('reservetion', $data);

        return $result;
    }

    public function get_reservetion($crt, $row = false){

        if(!empty($crt)){

            $this->db->where($crt);
        }

        if(!$row){
            $result = $this->db->get('reservetion')->result_array();
        }else{
            $result = $this->db->get('reservetion')->row_array();
        }

        return $result;
    }

    public function get_all_reservetion_count($cr = NULL,$name_cr =NULL){

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        if(!empty($name_cr)){

            if($name_cr[0] != ''){

                $this->db->like('first_name',$name_cr[0]);
                $this->db->or_like('last_name',$name_cr[0]);

            }elseif ($name_cr[1] != ''){

                $this->db->like('last_name',$name_cr[1]);
                $this->db->or_like('first_name',$name_cr[1]);
            }
        }


        $count = $this->db->count_all_results('reservetion');

        return $count;

    }

    public function get_all_reservetion($limit = NULL,$cr = NULL,$ordering,$name_cr){

        if(empty($ordering) || empty($limit)){

            return false;
        }

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);
        }

        if(!empty($name_cr)){

            if($name_cr[0] != ''){

                $this->db->like('first_name',$name_cr[0]);
                $this->db->or_like('last_name',$name_cr[0]);

            }elseif ($name_cr[1] != ''){

                $this->db->like('last_name',$name_cr[1]);
                $this->db->or_like('first_name',$name_cr[1]);
            }
        }

        $this->db->order_by($ordering[0], $ordering[1]);

        $this->db->limit($limit[0], $limit[1]);

        $result = $this->db->get('reservetion')->result_array();

        return $result;

    }
}