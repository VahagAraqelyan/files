<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_price_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    public function check_outbound_or_inbound_data($table_name, $weight, $type = 'outbound', $iso_column = NULL){

        if(empty($table_name) || empty($weight)){
            return false;
        }

        if(!empty($iso_column)){
            $this->db->where($iso_column.'<>', 0);
        }

        $this->db->where('weight_lb', $weight);

        if($type == 'outbound') {

            $where ='(`type` = "outbound_express" OR `type` = "outbound_economy")';
            $this->db->where($where);

        }elseif($type == 'inbound'){

            $where ='(`type` = "inbound_express" OR `type` = "inbound_economy")';
            $this->db->where($where);

        }else{
            return false;
        }

        $this->db->from($table_name);
        $result = $this->db->count_all_results();

        return $result;

    }

    public function get_outbound_or_inbound_data($table_name, $weight, $type = 'outbound', $currier_id = NULL,  $column){

        if(empty($table_name) || empty($weight) || empty($column)){
            return false;
        }

        if(!empty($column)){
            $this->db->select($column.', type');
        }else{
            $this->db->select('*');
        }

        $this->db->where('weight_lb', $weight);

        if(!empty($currier_id) && $this->valid->is_id($currier_id)){
            $this->db->where('currier_id', $currier_id);
        }

        if($type == 'outbound') {

            $where ='(`type` = "outbound_express" OR `type` = "outbound_economy")';
            $this->db->where($where);

        }elseif($type == 'inbound'){

            $where ='(`type` = "inbound_express" OR `type` = "inbound_economy")';
            $this->db->where($where);

        }else{
            return false;
        }

        $this->db->from($table_name);
        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $type){
            $return_array[$type['type']] = $type[$column];
        }

        return $return_array;

    }

    public function get_delivery_day($table_name,  $column){

        if(empty($table_name) || empty($column)){
            return false;
        }

        $this->db->select($column.', sending_type');
        $result = $this->db->get($table_name)->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_array[strtolower($single['sending_type'])] = $single[$column];
        }

        return $return_array;

    }

    public function get_holidays($countries){

        if(empty($countries)){
            return false;
        }

        $this->db->select('day');

        if(is_array($countries)){

            foreach($countries as $id){
                if(!$this->valid->is_id($id)){
                    return false;
                }
            }
            $this->db->where_in('country_id', $countries);
        }else{

            if(!$this->valid->is_id($countries)){
                return false;
            }
            $this->db->where('country_id', $countries);
        }

        $this->db->order_by('day', 'ASC');

        $result = $this->db->get('holidays_calendar')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_array[] = $single['day'];
        }

        return $return_array;

    }

    public function get_dinamic_holidays($countries){

        if(empty($countries)){
            return false;
        }

        $this->db->select('day');

        if(is_array($countries)){

            foreach($countries as $id){
                if(!$this->valid->is_id($id)){
                    return false;
                }
            }
            $this->db->where_in('country_id', $countries);
        }else{

            if(!$this->valid->is_id($countries)){
                return false;
            }
            $this->db->where('country_id', $countries);
        }

        $this->db->order_by('day', 'ASC');

        $result = $this->db->get('dinamic_calendar')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_array[] = $single['day'];
        }

        return $return_array;

    }

    public function get_international_fee($country_id, $currier_id, $luggages){

        if(empty($country_id) || empty($currier_id) || empty($luggages)){
            return false;
        }

        $this->db->select('*');

        $this->db->where('country_id', $country_id);
        $this->db->where('currier_id', $currier_id);

        if(is_array($luggages)){
            $this->db->where_in('luggage_id', $luggages);
        }else{
            $this->db->where('luggage_id', $luggages);
        }

        $result = $this->db->get('prod_international_fee')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_data[$single['luggage_id']] = $single;
        }

        return $return_data;
    }

    public function get_domestic_fee($country_id, $luggages){

        if(empty($country_id) || empty($luggages)){
            return false;
        }

        $this->db->select('luggage_id, domestic_express, domestic_basic');
        $this->db->where('country_id', $country_id);

        if(is_array($luggages)){
            $this->db->where_in('luggage_id', $luggages);
        }else{
            $this->db->where('luggage_id', $luggages);
        }

        $result = $this->db->get('prod_domestic_fee')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_data[$single['luggage_id']] = [
                'domestic_express' => $single['domestic_express'],
                'domestic_basic' => $single['domestic_basic']
            ];
        }

        return $return_data;

    }

    public function get_sat_delivery($country_id){

        if(empty($country_id)){
            return 0;
        }

        $this->db->select('saturday_delivery');
        $result = $this->db->get_where('extra_pickup_fee', ['country_id' => $country_id])->row_array();

        if(empty($result)){
            return 0;
        }

        return $result['saturday_delivery'];

    }

    public function get_domestic_data($table_name, $weight, $currier, $zone){

        if(empty($table_name) || empty($weight) || empty($zone)){
            return false;
        }

        $this->load->library('Csv_lib');
        $colums_array = $this->csv_lib->get_config('Domestic')['checking_array'];
        $colums = implode(',', $colums_array);

        if(is_array($weight)){

            $colums = $colums.', weight';

            $weights = array_keys($weight);

            $weights = array_filter($weights);

            if(empty($weights)){
                return false;
            }

            $this->db->select($colums);
            $this->db->where('currier_id', $currier);
            $this->db->where('zone', $zone);
            $this->db->where_in('weight', $weights);
            $this->db->from($table_name);
            $data = $this->db->get()->result_array();

            if(count($data) != count($weights)){
                return false;
            }

            $result = [];

            foreach($colums_array as $single){

                $result[$single] = 0;

                foreach($data as $single_data){

                    if(empty($single_data[$single])){
                        unset($result[$single]);
                        break;
                    }

                    $result[$single] += $single_data[$single]*$weight[$single_data['weight']];
                }

            }

        }else{

            $this->db->select($colums);
            $this->db->where('currier_id', $currier);
            $this->db->where('zone', $zone);
            $this->db->where('weight', $weight);
            $this->db->from($table_name);
            $result = $this->db->get()->row_array();

        }

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_charge_weight($country_id, $luggages){

        if(empty($country_id) || empty($luggages)){
            return false;
        }

        $this->db->select('luggage_id, charge_weight');

        $this->db->where('country_id', $country_id);

        if(is_array($luggages)){
            $this->db->where_in('luggage_id', $luggages);
        }else{
            $this->db->where('luggage_id', $luggages);
        }

        $result = $this->db->get('prod_domestic_fee')->result_array();

        if(empty($result)){
            return false;
        }

        foreach($result as $single){
            $return_array[$single['luggage_id']] = $single['charge_weight'];
        }

        return $return_array;

    }

    public function get_days_and_zone($country_id, $distance, $zone = NULL){

        if(empty($country_id)){
            return false;
        }

        $this->db->select('*');

        if(!empty($distance)) {
            $where = [
                'country_id' => $country_id,
                'distance_from <=' => $distance,
                'distance_to >=' => $distance
            ];
        }elseif(!empty($zone)){
            $where = [
                'country_id' => $country_id,
                'zone' => $zone,
            ];
        }

        $this->db->where($where);
        $result = $this->db->get('domestic_distance_zone')->row_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function get_box_type_id(){

        $this->db->select('id');
        $this->db->like('type_name', 'box', 'after');
        $result = $this->db->get('luggage_type')->row_array();

        if(empty($result)){
            return false;
        }

        return $result['id'];

    }

    public function get_boxes_domestic($country_id){

        if(empty($country_id)){
            return false;
        }

        $boxes_id = $this->get_box_type_id();

        if(empty($boxes_id)){
            return false;
        }

        $where = [
            'prod_domestic_fee.country_id' => $country_id,
            'luggage_product.type_id' => $boxes_id
        ];

        $this->db->select('luggage_name, domestic_express, domestic_basic');
        $this->db->from('luggage_product');
        $this->db->join('prod_domestic_fee', 'luggage_product.product_id = prod_domestic_fee.luggage_id', 'left');
        $this->db->where($where);

        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        $return_array = [];

        foreach($result as $single){
            $return_array[strtolower($single['luggage_name'])] = [
                'domestic_express' => $single['domestic_express'],
                'domestic_basic'   => $single['domestic_basic']
            ];
        }

        return $return_array;

    }

    public function get_boxes_international($country_id){

        if(empty($country_id)){
            return false;
        }

        $boxes_id = $this->get_box_type_id();

        if(empty($boxes_id)){
            return false;
        }

        $where = [
            'prod_international_fee.country_id' => $country_id,
            'luggage_product.type_id' => $boxes_id
        ];

        $this->db->select('*');
        $this->db->from('luggage_product');
        $this->db->join('prod_international_fee', 'luggage_product.product_id = prod_international_fee.luggage_id', 'left');
        $this->db->where($where);

        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        $return_array = [];

        foreach($result as $single){

            if(empty($return_array[strtolower($single['luggage_name'])])){

                $return_array[strtolower($single['luggage_name'])] = [
                    $single['currier_id'] => $single
                ];

            }else {
                $return_array[strtolower($single['luggage_name'])][$single['currier_id']] = $single;
            }

        }

        return $return_array;

    }

    public function get_sur_charges($country_id, $currier_id, $type){

        if(empty($country_id) || empty($currier_id)){
            return false;
        }

        $where = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type'       => $type
        ];

        return $this->db->get_where('over_size_surcharge', $where)->row_array();

    }

}