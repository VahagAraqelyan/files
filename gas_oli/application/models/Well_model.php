<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Well_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    public function insert_well($data)
    {

        if (empty($data)) {
            return false;
        }

        $result = $this->db->insert('well', $data);

        return $result;
    }

    public function well_insert_batch($data)
    {

        if (empty($data)) {
            return false;
        }

        $result = $this->db->insert_batch('well', $data);

        return $result;
    }

    public function get_well($crt = null, $row_array = false)
    {

        if (!empty($crt)) {
            $this->db->where($crt);
        }

        if (!$row_array) {
            $result = $this->db->get('well')->result_array();
        } else {
            $result = $this->db->get('well')->row_array();
        }

        return $result;
    }

    public function get_all_wells($limit = NULL, $cr = NULL, $ordering)
    {

        if (empty($ordering) || empty($limit)) {

            return false;
        }

        $this->db->select('well.id,well.well_id,well.name, well.location, well.status, well.lat, well.lng, well.company_field, well.comment,company.name AS company_name,state.state AS state_name');
        $this->db->from('well');
        $this->db->join('company', 'well.company_id = company.id', 'left');
        $this->db->join('state', 'well.state_id = state.id', 'left');

        if (!empty($cr)) {

            foreach ($cr as $key => $value) {

                if (empty($value)) {

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);
        }

        $this->db->order_by($ordering[0], $ordering[1]);

        $this->db->limit($limit[0], $limit[1]);

        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_all_well_count($cr = NULL)
    {

        if (!empty($cr)) {

            foreach ($cr as $key => $value) {

                if (empty($value)) {

                    unset($cr[$key]);
                }
            }

            $this->db->like($cr);

        }

        $this->db->select('well.id,well.well_id,well.name, well.location, well.status, well.lat, well.lng, well.company_field, well.comment,company.name AS company_name,state.state AS state_name');
        $this->db->from('well');
        $this->db->join('company', 'well.company_id = company.id', 'left');
        $this->db->join('state', 'well.state_id = state.id', 'left');

        $count = $this->db->count_all_results();

        return $count;
    }

    public function delete_well($id)
    {

        if (empty($id)) {
            return false;
        }

        return $this->db->delete('well', array('id' => $id));
    }

    public function get_wells_by_ids($id_array)
    {

        if (empty($id_array)) {
            return false;
        }
        $this->db->where_in('id', $id_array);

        $result = $this->db->get('well')->result_array();

        return $result;
    }

    public function get_wells_by_company($id_array,$crt = NULL,$state_ids = NULL)
    {

        if (!empty($id_array)) {
            $this->db->where_in('company_id', $id_array);
        }

        if (!empty($state_id)) {
            $this->db->where_in('state_id', $state_ids);
        }

        if (!empty($crt)) {
            $this->db->where($crt);
        }

        $this->db->select('well.*,company.name AS company_name');
        $this->db->from('well');
        $this->db->join('company', 'well.company_id = company.id', 'left');

        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_wells_by_not_ids($id_array)
    {

        if (empty($id_array)) {
            return false;
        }

        $this->db->where_not_in('id', $id_array);

        $result = $this->db->get('well')->result_array();
        return $result;
    }

    public function update_well($id, $update_data)
    {

        if (empty($id) || empty($update_data)) {
            return false;
        }

        $this->db->where('id', $id);

        $result = $this->db->update('well', $update_data);

        return $result;
    }

    public function get_states()
    {

        $result = $this->db->get('state')->result_array();

        return $result;
    }

    public function get_states_by_name()
    {

        $result = $this->db->get('state')->result_array();

        return $result;
    }

    public function get_states_by_ids($id_array)
    {

        if (empty($id_array)) {
            return false;
        }

        $this->db->where_in('id', $id_array);

        $result = $this->db->get('state')->result_array();

        return $result;
    }

    public function get_states_by_id($id)
    {

        if (empty($id)) {
            return false;
        }

        $this->db->where_in('id', $id);

        $result = $this->db->get('state')->row_array();

        return $result;
    }
}