<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_order($user_id = NULL, $limit, $status = NULL,$cr = NULL, $where = NULL, $crt = NULL, $where_crt = NULL, $order_by = NULL)
    {

        if (empty($limit)) {

            return false;
        }

        $this->db->select('order_shipping.*, order_shipping.order_id AS order_number, order_shipping.id AS real_id, pick_up_info.*, delivery_info.*,users.first_name,users.last_name,users.account_name,users.id,users.email,order_shedule_pick_up.id AS shedule_id, order_label_shipment_summary.delivery_date AS label_date , order_label_shipment_summary.tracking_number AS label_trucking');
        $this->db->from('order_shipping');
        $this->db->join('pick_up_info', 'order_shipping.id = pick_up_info.order_id', 'left');
        $this->db->join('delivery_info', 'order_shipping.id = delivery_info.order_id', 'left');
        $this->db->join('users', 'order_shipping.user_id = users.id', 'left');
        $this->db->join('order_shedule_pick_up', 'order_shipping.id = order_shedule_pick_up.order_id', 'left');
        $this->db->join('order_label_shipment_summary', 'order_shipping.id = order_label_shipment_summary.order_id', 'left');

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        if(empty($order_by)){

            $this->db->order_by('order_shipping.id', 'DESC');

        }else{

            $this->db->order_by($order_by[0], $order_by[1]);
        }

        if(!empty($crt)){
            $this->db->where($crt);
        }

        if(!empty($user_id)){

            $this->db->where('order_shipping.user_id', $user_id);

            if(!empty($where_crt)){

                $this->db->limit($limit[0], $limit[1]);
                $result = $this->db->get()->result_array();

                return $result;
            }
        }

        $this->db->group_start();

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status', $status);
            }else{

                $this->db->where('shipping_status', $status);
            }

        }

        if(!empty($where)){
            $this->db->or_group_start();
            $this->db->where($where);
            $this->db->group_end();
        }

        $this->db->group_end();

        $this->db->limit($limit[0], $limit[1]);
        $result = $this->db->get()->result_array();
        return $result;

    }

    public function get_count_order($user_id, $status = NULL){

        if(empty($user_id)){

            return false;
        }

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status', $status);
            }else{

                $this->db->where('shipping_status', $status);
            }

        }

        $this->db->where('order_shipping.user_id', $user_id);

        $count_all = $this->db->count_all_results('order_shipping');
        return $count_all;

    }

    public  function get_countries_assoc(){

        $sql = "SELECT id, country, iso2 FROM lts_country WHERE status = 1 ORDER BY country ASC ";

        $result = $this->db->query($sql)->result_array();

        if(empty($result)){
            return false;
        }

        foreach ($result as $item){

            $return_data[$item['id']] = [

                'country' => $item['country'],
                'iso' => $item['iso2']
            ];
        }

        return $return_data;

    }

    public function all_get_count_order($status = NULL,$cr = NULL, $where = NULL, $crt = NULL,$all = NULL){

        if(!empty($user_id)){

            $this->db->where('order_shipping.user_id', $user_id);
        }

        if(!empty($cr)){

            foreach ($cr as $key => $value){

                if(empty($value)){

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);
        }

        if(!empty($crt)){
            $this->db->where($crt);
        }

        if(!empty($all)){

            $this->db->select('order_shipping.*, order_shipping.order_id AS order_number, order_shipping.id AS real_id, pick_up_info.*, delivery_info.*');
            $this->db->from('order_shipping');
            $this->db->join('pick_up_info', 'order_shipping.id = pick_up_info.order_id', 'left');
            $this->db->join('delivery_info', 'order_shipping.id = delivery_info.order_id', 'left');
            $this->db->join('users', 'order_shipping.user_id = users.id', 'left');
            $count_all = $this->db->count_all_results();
            return $count_all;
        }

        $this->db->group_start();

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status', $status);
            }else{

                $this->db->where('shipping_status', $status);
            }

        }


        if(!empty($where)){

            $this->db->or_group_start();
            $this->db->where($where);
            $this->db->group_end();

        }

        $this->db->group_end();

        $this->db->select('order_shipping.*, order_shipping.order_id AS order_number, order_shipping.id AS real_id, pick_up_info.*, delivery_info.*');
        $this->db->from('order_shipping');
        $this->db->join('pick_up_info', 'order_shipping.id = pick_up_info.order_id', 'left');
        $this->db->join('delivery_info', 'order_shipping.id = delivery_info.order_id', 'left');
        $this->db->join('users', 'order_shipping.user_id = users.id', 'left');
        $count_all = $this->db->count_all_results();
        return $count_all;

    }

    public function get_orders_for_cron($limit = NULL, $status = NULL)
    {

        $this->db->select('*');
        $this->db->from('order_shipping');

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status', $status);
            }else{

                $this->db->where('shipping_status', $status);
            }

        }

        if(!empty($limit)){
            $this->db->limit($limit);
        }

        $result = $this->db->get()->result_array();

        return $result;

    }

    public function get_orders_for_email_cron($status = NULL, $interval = '40')
    {

        $this->db->select('*');
        $this->db->from('order_shipping');

        if(!empty($status)){

            if(is_array($status)){

                $this->db->where_in('shipping_status', $status);
            }else{

                $this->db->where('shipping_status', $status);
            }

        }

        //$date_interval = date('Y-m-d H:i:s', strtotime("-".$interval." minutes"));

        //$this->db->where('created_date <', $date_interval);

        $this->db->where('create_email_send IS NULL', null, false);

        $result = $this->db->get()->result_array();

        return $result;

    }

}
?>