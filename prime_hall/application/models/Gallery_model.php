<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_gallery_image($data){

        if(empty($data)){

            return false;
        }

        $result =  $this->db->insert('gallery', $data);

        return $this->db->insert_id();
    }

    public function get_gallery_image($id=NULL,$crt = null){

        if(!empty($id)){

            $this->db->where('id',$id);
        }

        if(!empty($crt)){

            $this->db->where($crt);
        }

        $result = $this->db->get('gallery')->result_array();

        return $result;
    }

    public function get_gallery_type($crt = null){

        if(!empty($crt)){

            $this->db->where($crt);
        }

        $result = $this->db->get('image_type')->result_array();

        return $result;

    }

    public function delete_gallery_image($id){

        if(empty($id)){

            return false;
        }

        $this->db->where('id',$id);

        $this->db->delete('gallery')->result_array();

    }
}