<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct(){

        parent::__construct();

    }

    public function insert_question($data){

        if(empty($data)){
            return false;
        }

         $this->db->insert('question', $data);

    }

    public function insert_comment($data){

        if(empty($data)){

            return false;
        }

         $this->db->insert('comment', $data);
    }

    public function get_questions($id = NULL){

        if(!empty($id)){

             $this->db->where('id',$id);
        }
 
        $this->db->order_by('like desc, dislike asc'); 
        $result =  $this->db->get('question')->result_array();

        return $result;
    }


        public function get_comment($id,$comm_id =NULL){

            if(empty($id)){

                return false;
            }

            if(!empty($comm_id)){
                $this->db->where('id',$comm_id);
            }

            $this->db->where('quest_id',$id);
            $this->db->order_by('like desc, dislike asc'); 
            $result =  $this->db->get('comment')->result_array();
           
            return $result;
    }

        public function update_likes($id,$data){

        if(empty($id) || empty($data)){

            return false;
        }

         $this->db->where('id', $id);
        
        $this->db->update('question', $data);
    }

    public function update_comment_likes($id,$data){

        if(empty($id) || empty($data)){

            return false;
        }

         $this->db->where('id', $id);
        
         $this->db->update('comment', $data);
       
    }

}
?>