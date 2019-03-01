<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_offer_count($cr = NULL){

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        $count = $this->db->count_all_results('special_offer');

        return $count;

    }

    public function get_all_offer($limit = NULL,$cr = NULL,$ordering){

        if(empty($ordering)){

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

        $this->db->order_by($ordering[0], $ordering[1]);

        if(!empty($limit)){
            $this->db->limit($limit[0], $limit[1]);
        }

        $result = $this->db->get('special_offer')->result_array();

        return $result;
    }



    public function get_offer($cr = NULL,$ordering){

        if(empty($ordering)){

            return false;
        }

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->where($cr);
        }

        $this->db->order_by($ordering[0], $ordering[1]);

        if(!empty($limit)){
            $this->db->limit($limit[0], $limit[1]);
        }

        $result = $this->db->get('special_offer')->result_array();

        return $result;
    }

    public function get_single_offer($id){

        if(empty($id)){
            return false;
        }

        $this->db->where('id',$id);

        $result = $this->db->get('special_offer')->row_array();

        return $result;
    }

    public function update_data($data,$where){

        if(empty($data) || empty($where)){

            return false;
        }

        $this->db->where($where);

        $result = $this->db->update('special_offer',$data);

        return $result;
    }

    public function add_new_offer($data){

        if(empty($data)){
            return false;
        }

        $result =  $this->db->insert('special_offer', $data);

        return $result;
    }

    public function delete_offer($id){

        if(empty($id)){
            return false;
        }

        $this->db->where('id',$id);
        $this->db->delete('special_offer');
    }
}