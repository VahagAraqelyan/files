<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model{

    public function get_created_invoice($order_id,$type = NULL){

        if(empty($order_id) || !$this->valid->is_id($order_id)){
           return false;
        }

        $where = [
            'order_id' => $order_id,
        ];

        if(!empty($type)){

            $where['type'] = $type;
        }

        $this->db->where($where);

        $result = $this->db->get('invoice_created')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_single_invoice($id){

        if(empty($id)){
            return false;
        }

        $where = [
            'id' => $id,
        ];

        $this->db->where($where);

        $result = $this->db->get('invoice_created')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function create_invoice($data){

        if(empty($data)){

            return false;
        }

        $result = $this->db->insert('invoice_created',$data);

        return $result;

    }

    public function delete_invoice($crt){

        if(empty($crt['id']) || empty($crt['order_id'])){
            return false;
        }

        $result = $this->db->delete('invoice_created', $crt);
        return $result;

    }

    public function update_invoice($update_data, $crt){

        if(empty($crt)){
            return false;
        }

        $this->db->where($crt);

        return $this->db->update('invoice_created', $update_data);

    }

}
?>