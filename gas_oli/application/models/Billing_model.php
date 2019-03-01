<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    // GET FUNCTIONS

    public function get_billing($crt){

        if(empty($crt)){
            return false;
        }

        $result = $this->db->select('*')
            ->from('order_billing_info')
            ->where($crt)
            ->get()
            ->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_billing_info($order_id, $order = 'DESC'){

        if(empty($order_id)){
            return false;
        }

        $result = $this->db->select('*')
            ->from('order_billing_info')
            ->where('order_id', $order_id)
            ->order_by('update_date', $order)
            ->get()
            ->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_all_billing($order_id){

        if(empty($order_id)){
            return false;
        }

        $result = $this->db->select('*')
            ->from('order_billing_info')
            ->where('order_id', $order_id)
            ->order_by('update_date', 'ASC')
            ->get()
            ->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    // INSERT FUNCTIONS

    public function insert_billing_info($data){

        if(empty($data['user_id']) || empty($data['order_id'])){
            return false;
        }

        $data['update_date'] = date('Y-m-d H:i:s');

        return $this->db->insert('order_billing_info', $data);

    }

    public function auto_fill_insert($data){

        if(empty($data) || empty($data['order_id'])){
            return false;
        }

        $old_info = $this->get_billing_info($data['order_id']);

        if(!empty($old_info)){

            unset($old_info['update_date']);
            unset($old_info['type']);
            unset($old_info['status']);
            unset($old_info['id']);

            foreach($old_info as $key => $value){

                if(!isset($data[$key])){
                    $data[$key] = $value;
                }

            }

        }

        $result = $this->insert_billing_info($data);
        return $result;

    }

    // DELETE FUNCTIONS

    public function delete_billing_info($crt = []){

        return $result = $this->db->delete('order_billing_info', $crt);

    }

    // UPDATE FUNCTIONS

    public function update_billing_info($update_data, $order_id, $type){

        if(empty($order_id) || empty($update_data) || empty($type)){
            return false;
        }

        return $this->db->update('order_billing_info', $update_data, array('order_id' => $order_id , 'type' => $type));

    }

    public function global_update_billing_info($update_data, $crt = []){

        if(empty($update_data)){
            return false;
        }

        $result = $this->db->update('order_billing_info', $update_data, $crt);

        return $result;

    }

    //OTHER

    public function check_last_billing($order_id){

        $billing_info = $this->get_billing_info($order_id);

        $return_array = [
            'now'          => NULL,
            'next'         => 'estimate',
            'last_billing' => NULL
            ];

        if(empty($billing_info)){
            return $return_array;
        }

        if($billing_info['status'] == '0'){

            $next_array = [
                'estimate' => 'initial',
                'initial'  => 'adjust_1',
                'adjust_1' => 'adjust_2',
                'adjust_2' => 'final',
                'final'    => 'final'
            ];

            $next = $next_array[$billing_info['type']];

        }else{

            $next = $billing_info['type'];
        }

        $return_array['now']          = $billing_info['type'];
        $return_array['next']         = $next;
        $return_array['last_billing'] = $billing_info;

        return $return_array;

    }

}