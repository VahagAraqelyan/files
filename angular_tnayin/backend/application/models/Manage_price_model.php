<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_price_model extends CI_Model {

    public function insert_inter_document($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert('form_doc_files', $data);
    }

    public function insert_currier_comment($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert('currier_comment', $data);
    }

    public function insert_pickup_fee($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert('extra_pickup_fee', $data);

    }

    public function insert_processing_fee($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert('extra_processing_fee', $data);

    }

    public function insert_domestic_insurance($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert_batch('extra_domestic_insurance', $data);
    }

    public function insert_international_insurance($data){

        if(empty($data)){

            return false;
        }

        return $this->db->insert_batch('extra_international_insurance', $data);
    }

    public function insert_over_size($data){

        if(empty($data['country_id']) || empty($data['currier_id'])){
            return false;
        }

        return $this->db->insert('over_size_surcharge', $data);

    }

    public function insert_currier_file($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert('curriers_files', $data);

        if(!empty($result)){
            return $this->db->insert_id();
        }

        return false;
    }

    public function insert_country_profile($data){

        if(empty($data)){
            return false;
        }

        return $this->db->insert('country_profile', $data);

    }

    public function insert_country_profile_batch($data){

        if(empty($data)){
            return false;
        }

        $result = $this->db->insert_batch('country_profile', $data);
        return $result;

    }

    public function insert_domestic($data,$country_id = NULL){

        if(empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->insert_batch('prod_domestic_fee', $data);

    }

    public function insert_international($data,$country_id = NULL){

        if(empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->insert_batch('prod_international_fee', $data);

    }

    public function insert_one_international($data){

        if(empty($data)){

            return false;
        }


        return $this->db->insert('prod_international_fee', $data);

    }

    public function insert_one_domestic($data){

        if(empty($data)){

            return false;
        }


        return $this->db->insert('prod_domestic_fee', $data);

    }

    public function delete_batch_data($table_name, $crt = NULL){

        if(empty($table_name)){
            return false;
        }

        if(!empty($crt)) {
            $this->db->where($crt);
        }else{
            return $this->db->empty_table($table_name);
        }

        return $this->db->delete($table_name);

    }

    public function data_batch_insert($table_name, $data){

        if(empty($data) || empty($table_name)){
            return false;
        }

        $result = $this->db->insert_batch($table_name, $data);
        return $result;

    }

    public function create_international_price_table($table_name, $colums){

        if(empty($colums) || empty($table_name)){
            return false;
        }

        $this->load->dbforge();

        $fields = [];

        foreach($colums as $colum_name){

            $fields[$colum_name]['unsigned'] = TRUE;
            $fields[$colum_name]['null'] = TRUE;

            if( $colum_name == 'currier_id'){

                $fields[$colum_name]['type'] = 'INT';
                $fields[$colum_name]['constraint'] = 4;

            }elseif($colum_name == 'weight_lb' || $colum_name == 'type'){

                $fields[$colum_name]['type'] = 'VARCHAR';
                $fields[$colum_name]['constraint'] = '255';

            }else{
                $fields[$colum_name]['type'] = 'FLOAT';
            }

        }

        $this->dbforge->add_field($fields);

        return $this->dbforge->create_table($table_name);


    }

    public function create_international_delivery_time_table($table_name, $colums){

        if(empty($colums) || empty($table_name)){
            return false;
        }

        $this->load->dbforge();

        $fields = [];

        foreach($colums as $colum_name){

            $fields[$colum_name]['unsigned'] = TRUE;
            $fields[$colum_name]['null'] = TRUE;

            if($colum_name == 'sending_type'){

                $fields[$colum_name]['type'] = 'VARCHAR';
                $fields[$colum_name]['constraint'] = '255';

            }else{
                $fields[$colum_name]['type'] = 'INT';
                $fields[$colum_name]['constraint'] = 3;
            }

        }

        $this->dbforge->add_field($fields);

        return $this->dbforge->create_table($table_name);


    }

    public function create_domestic_price($table_name, $colums){

        if(empty($colums) || empty($table_name)){
            return false;
        }

        $this->load->dbforge();

        $fields = [];

        foreach($colums as $colum_name){

            $fields[$colum_name]['unsigned'] = TRUE;
            $fields[$colum_name]['null'] = TRUE;

            if( $colum_name == 'currier_id' || $colum_name == 'zone'){

                $fields[$colum_name]['type'] = 'INT';
                $fields[$colum_name]['constraint'] = 4;

            }elseif($colum_name == 'weight'){

                $fields[$colum_name]['type'] = 'VARCHAR';
                $fields[$colum_name]['constraint'] = '255';

            }else{
                $fields[$colum_name]['type'] = 'FLOAT';
            }


        }

        $this->dbforge->add_field($fields);

        return $this->dbforge->create_table($table_name);

    }





    public function get_currier_comment($type = NULL,$country_id = NULL, $id = NULL,$row = NULL){

        if(empty($country_id) && empty($id)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        if(!empty($id)){

            $this->db->where('id', $id);
        }
        $this->db->where('type', $type);

        if(!empty($row)){
            $result = $this->db->get('currier_comment')->row_array();

        }else{

            $result = $this->db->get('currier_comment')->result_array();
        }


        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_pickup_fee($country_id = NULL, $id = NULL){

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        if(!empty($country_id) || $country_id == '0'){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->get('extra_pickup_fee')->result_array();
    }


    public function get_processing_fee($country_id = NULL, $id = NULL){

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        if(!empty($country_id) || $country_id == '0'){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->get('extra_processing_fee')->result_array();
    }



    public function update_processing_fee($data, $country_id = NULL){

        if(empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->update('extra_processing_fee', $data);
    }


    public function get_domestic_insurance($country_id = NULL, $id = NULL,$order_by = NULL){

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        if(!empty($country_id)|| $country_id == '0'){

            $this->db->where('country_id', $country_id);
        }




        if(!empty($order_by)){

            $this->db->order_by("insurance_fee", "ASC");
        }else{

            $this->db->order_by("location", "ASC");
        }

        $result =  $this->db->get('extra_domestic_insurance')->result_array();

        return $result;
    }

    public function update_domestic_insurance($data, $country_id = NULL){

        if(empty($data)){

            return false;
        }

        foreach ($data as  $update_data){

            if(!empty($country_id)){

                $this->db->where('country_id', $country_id);
            }

            $this->db->where('location', $update_data['location']);
            $result = $this->db->update('extra_domestic_insurance', $update_data);

            if(empty($result)){

                $result = false;
            }
        }

        return $result;
}

    public function get_international_insurance($country_id = NULL, $id = NULL){

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        if(!empty($country_id)|| $country_id == '0'){

            $this->db->where('country_id', $country_id);
        }
        $this->db->order_by("location", "ASC");
        return $this->db->get('extra_international_insurance')->result_array();
    }



    public function update_international_insurance($data, $country_id = NULL){

        if(empty($data)){

            return false;
        }

        foreach ($data as  $update_data){

            if(!empty($country_id)){

                $this->db->where('country_id', $country_id);
            }

            $this->db->where('location', $update_data['location']);
            $result = $this->db->update('extra_international_insurance', $update_data);

            if(empty($result)){

                $result = false;
            }
        }

        return $result;
    }
    public function update_currier_comment($update_data, $country_id = NULL, $id = NULL){

        if(empty($update_data)){

            return false;
        }

        if(empty($country_id) && empty($id)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        return $this->db->update('currier_comment', $update_data);
    }


    public function get_currier_document($country_id, $type = NULL, $id = NULL){

        if(empty($country_id)){

            return false;
        }

        if(!empty($id)){

            $this->db->where('id', $id);
        }

        if(!empty($type)){

            $this->db->where('type', $type);
        }

        $this->db->where('country_id', $country_id);
        $query =   $this->db->get('form_doc_files')->result_array();
        return $query;
    }

    public function delete_inter_document($id){

        if(empty($id)){
           return false;
        }

        $this->db->delete('form_doc_files', array('id' => $id));

    }

    public function get_curriers($id = NULL, $country_iso = NULL){

        if(!empty($id)){
            $this->db->where('lts_currier.id', $id);
        }

        if(!empty($country_iso)){
            $this->db->select('*');
            $this->db->from('lts_currier');
            $this->db->join('country_profile', 'lts_currier.id = country_profile.currier_id', 'left');
            $this->db->where('country_profile.country_iso', $country_iso);
            $result = $this->db->get()->result_array();
            return (empty($result))?false:$result;
        }

        $result = $this->db->get('lts_currier')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_currier_files($country_id, $currier_id = NULL, $type = 1, $type_name = NULL){

        if(empty($country_id)){
            return false;
        }

        $where['country_id'] = $country_id;
        $where['type'] = $type;

        if(!empty($currier_id)){
            $where['currier_id'] = $currier_id;
        }

        if(!empty($type_name)){
            $where['name'] = $type_name;
        }

        $result = $this->db->get_where('curriers_files', $where)->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function search_currier_files($crt){

        if(empty($crt)){
            return false;
        }

        $result = $this->db->get_where('curriers_files', $crt)->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }



    public function update_over_size($oversize_id, $insert_data){

        if(empty($oversize_id) || empty($insert_data)){
            return false;
        }

        $this->db->where('id', $oversize_id);
        return $this->db->update('over_size_surcharge', $insert_data);

    }

    public function get_over_size($crt){

        if(empty($crt)){
            return false;
        }

        $result = $this->db->get_where('over_size_surcharge', $crt)->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function delete_currier_file($id){

        if(empty($id)){
            return false;
        }

        $result = $this->db->delete('curriers_files', array('id' => $id));

        return $result;

    }

    public function update_file_status($id){

        if(empty($id)){
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update('curriers_files', ['status'=>1]);
    }

    public function update_country_profile($update_data, $where){

        if(empty($update_data)){
            return false;
        }

        $this->db->where($where);
        return $this->db->update('country_profile', $update_data);

    }

    public function get_country_profile($country_iso){

        if(!isset($country_iso)){
            return false;
        }

        $this->db->select('*');
        $this->db->from('lts_currier');
        $this->db->join('country_profile', 'lts_currier.id = country_profile.currier_id', 'left');
        $this->db->where('country_profile.country_iso', $country_iso);
        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function delete_country_profile($crt = NULL){

        if(empty($crt)){
            return $this->db->empty_table('country_profile');
        }

        return $this->db->delete('country_profile', $crt);
    }

    public function get_prod_international($country_id,$luggage_id = NULL){

        if(!isset($country_id)){
            return false;
        }

        $this->db->select('*');
        $this->db->from('prod_international_fee');
        $this->db->join('lts_currier', 'lts_currier.id = prod_international_fee.currier_id', 'left');
        $this->db->join('luggage_product', 'luggage_product.product_id = prod_international_fee.luggage_id', 'left');
        $this->db->join('luggage_type', 'luggage_product.type_id = luggage_type.id', 'left');
        $this->db->where('prod_international_fee.country_id', $country_id);

        if(!empty($luggage_id)){

            $this->db->where('prod_international_fee.luggage_id', $luggage_id);
        }

        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function delete_prod_international($country_id){

        if(empty($country_id)){

            return false;
        }

        $this->db->where('country_id', $country_id);
        $result = $this->db->delete('prod_international_fee');

        return $result;
    }

    public function get_prod_domestic($country_id,$luggage_id = NULL){

        if(!isset($country_id)){
            return false;
        }

        $this->db->select('*');
        $this->db->from('prod_domestic_fee');
        $this->db->join('luggage_product', 'luggage_product.product_id = prod_domestic_fee.luggage_id', 'left');
        $this->db->join('luggage_type', 'luggage_product.type_id = luggage_type.id', 'left');
        $this->db->where('prod_domestic_fee.country_id', $country_id);

        if(!empty($luggage_id)){

            $this->db->where('prod_domestic_fee.luggage_id', $luggage_id);
        }

        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function get_product($where = NULL){

        $this->db->select('*');
        $this->db->from('luggage_product');
        $this->db->join('luggage_type', 'luggage_product.type_id = luggage_type.id', 'left');
        $this->db->order_by('ordering', 'ASC');
        if(!empty($where)){
            $this->db->where($where);
        }
        $result = $this->db->get()->result_array();

        if(empty($result)){
            return false;
        }

        return $result;
    }

    public function get_prod_type($id = NULL){

        if(!empty($id)){
            $this->db->where('id', $id);
        }

        $result = $this->db->get('luggage_type')->result_array();

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_domestic($country_id = NULL, $luggage_id = NULL){

        if(isset($country_id)){

            $this->db->where('country_id', $country_id);
        }

        if(!empty($luggage_id)){

            $this->db->where('luggage_id', $luggage_id);
        }

        return $this->db->get('prod_domestic_fee')->result_array();
    }

    public function get_international($country_id = NULL, $luggage_id = NULL, $carrier_id = NULL){

        if(isset($country_id)){

            $this->db->where('country_id', $country_id);
        }

        if(!empty($luggage_id)){

            $this->db->where('luggage_id', $luggage_id);
        }

        if(!empty($carrier_id)){

            $this->db->where('currier_id', $carrier_id);
        }

        return $this->db->get('prod_international_fee')->result_array();
    }

    public function get_only_prod($id = NULL){

        if(!empty($id)){

            $this->db->where('product_id', $id);
        }

        return $this->db->get('luggage_product')->result_array();
    }

    public function update_prod($where,$data){

        if(empty($where) || empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        $this->db->where($where);

        return $this->db->update('luggage_product', $data);

    }

    public function update_domestic($luggage_id,$data,$country_id = NULL){

        if(empty($luggage_id) || empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        $this->db->where('luggage_id', $luggage_id);

        $result =  $this->db->update('prod_domestic_fee', $data);

        return $result;
    }

    public function update_international($where,$data,$country_id = NULL){

        if(empty($where) || empty($data)){

            return false;
        }

        if (!empty($country_id)) {

            $this->db->where('country_id', $country_id);
        }

        $this->db->where($where);
        $result = $this->db->update('prod_international_fee', $data);

        if (empty($result)) {

            $result = false;
        }

        return $result;
    }

    public function drop_table($table_name){

        if(empty($table_name)){

            return false;
        }

        $this->load->dbforge();

        return $this->dbforge->drop_table($table_name);
    }

    public function delete_currier_file_criteria($criteria){

        if(empty($criteria)){
            return false;
        }

         $result = $this->db->delete('curriers_files',$criteria);

        return $result;

    }

    public function get_holidays($country_id){

        if(empty($country_id)){

            return false;
        }

        $this->db->where('country_id', $country_id);
        $this->db->select('day');
        return  $this->db->get('holidays_calendar')->result_array();

    }

    public function get_dinamic_holidays($country_id){

        if(empty($country_id)){

            return false;
        }

        $this->db->where('country_id', $country_id);
        $this->db->select('day');
        return  $this->db->get('dinamic_calendar')->result_array();

    }

    public function get_weekend($country_id){

        if(empty($country_id)){

            return false;
        }

        $this->db->where('country_id', $country_id);

        return $this->db->get('weekends_calendar')->result_array();
    }

    public function insert_weekend($data){

        if(empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->insert('weekends_calendar', $data);

    }

    public function update_weekend($data,$country_id){

        if(empty($country_id) || empty($data)){

            return false;
        }

        $this->db->where('country_id', $country_id);
        $result = $this->db->update('weekends_calendar', $data);

        if (empty($result)) {

            $result = false;
        }

        return $result;
    }

    public function update_pickup_fee($data, $country_id = NULL){

        if(empty($data)){

            return false;
        }

        if(!empty($country_id)){

            $this->db->where('country_id', $country_id);
        }

        return $this->db->update('extra_pickup_fee', $data);
    }



}
?>