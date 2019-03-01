<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promotion_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_promotion_code($data)
    {

        return $this->db->insert('discount_codes', $data);
    }

    public function get_all_promo_codes_count($where){

        $where = array_filter($where);

        $this->db->where($where);

        $this->db->select('COUNT(*) as total_count');
        $this->db->order_by('id', 'DESC');

        $result = $this->db->get('discount_codes')->row_array();

        return $result['total_count'];

    }

    public function get_all_promo_codes($limit, $where, $order_by, $ordering_type = 'DESC'){

        $where = array_filter($where);

        if(isset($where['date_from']) && isset($where['date_to'])){

            $this->db->group_start();

                $this->db->where(
                    array(
                        'date_from >=' => $where['date_from'],
                        'date_from <=' => $where['date_to']
                    )
                );

                $this->db->or_where(
                    array(
                        'date_from' => '0000-00-00',
                    )
                );

            $this->db->group_end();

            $this->db->or_group_start();
                $this->db->where(
                    array(
                        'date_to >=' => $where['date_from'],
                        'date_to <=' => $where['date_to']
                    )
                );

                $this->db->or_where(
                    array(
                        'date_to' => '0000-00-00',
                    )
                );
            $this->db->group_end();

            unset($where['date_from']);
            unset($where['date_to']);

        }elseif(isset($where['date_from'])){

            $this->db->group_start();
                $this->db->where(
                    array(
                        'date_from >=' => $where['date_from']
                    )
                );
                $this->db->or_where(
                    array(
                        'date_from' => '0000-00-00',
                    )
                );
            $this->db->group_end();

            $this->db->or_group_start();
                $this->db->where(
                    array(
                        'date_to >=' => $where['date_from']
                    )
                );
                $this->db->or_where(
                    array(
                        'date_to' => '0000-00-00',
                    )
                );
            $this->db->group_end();

            unset($where['date_from']);

        }elseif(isset($where['date_to'])){

            $this->db->group_start();
                $this->db->where(
                    array(
                        'date_from <=' => $where['date_to']
                    )
                );
                $this->db->or_where(
                    array(
                        'date_from' => '0000-00-00',
                    )
                );
            $this->db->group_end();

            $this->db->or_group_start();
                $this->db->where(
                    array(
                        'date_to <=' => $where['date_to']
                    )
                );
                $this->db->or_where(
                    array(
                        'date_to' => '0000-00-00',
                    )
                );
            $this->db->group_end();

            unset($where['date_to']);

        }

        $this->db->where($where);

        $this->db->limit($limit[0], $limit[1]);

        if(!empty($order_by)){

            $this->db->order_by($order_by, $ordering_type);
        }else{

            $this->db->order_by('id', 'DESC');
        }

        $result = $this->db->get('discount_codes')->result_array();

        return $result;

    }

    public function get_code_info($code){

        if(empty($code)){
            return false;
        }

        $this->db->where(['code' => $code]);

        $result = $this->db->get('discount_codes')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_code_info_by_id($id){

        if(empty($id)){
            return false;
        }

        $this->db->where(['id' => $id]);

        $result = $this->db->get('discount_codes')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function delete_promotion_code($promo_id){

        if(empty($promo_id)){
            return false;
        }

        $result = $this->db->delete('discount_codes', array('id' => $promo_id));

        return $result;

    }

    public function update_promotion_code($promo_id,$update_data){

        if(empty($update_data) || empty($promo_id)){

            return false;
        }

        $this->db->where('id',$promo_id);

        $result = $this->db->update('discount_codes', $update_data);

        return $result;

    }

    public function use_promotion($id){

        $this->db->set('count_of_use', 'count_of_use-1', FALSE);

        $this->db->where('id', $id);
        $this->db->where('original_count!=', '-10');

        return $this->db->update('discount_codes');

    }

    public function add_promotion($id){

        $this->db->set('count_of_use', 'count_of_use+1', FALSE);

        $this->db->where('id', $id);
        $this->db->where('original_count!=', '-10');

        return $this->db->update('discount_codes');

    }

    public function check_statuses(){

        $where = [
            'date_to <' => date('Y-m-d'),
            'date_to !=' => '0000-00-00'
        ];

        return $this->db->update('discount_codes', ['status' => '2'], $where);

    }


}
?>