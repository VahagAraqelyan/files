<?php

class Crew extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Steersman_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Well_model");
        $this->load->model("Company_model");

        $this->load->library('google_api');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {

            redirect('crew/crew_login', 'refresh');

        } else {

            redirect('crew/filter', 'refresh');
        }

    }

    public function filter()
    {

        if (!$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }


        $data['all_wels'] = $this->Well_model->get_well();
        $data['company'] = $this->Company_model->get_all_company();
        $data['get_states'] = $this->Well_model->get_states();

        /* $state_src = [];
         foreach ($data['get_states'] as $single){

             $state_src[$single['id']]=$this->google_api->get_staate_by_latlng('54,321336','-115,785508');

         }*/

        $data['content'] = 'frontend/crew/main';

        $this->load->view('frontend/site_main_template', $data);
    }


    public function check_login()
    {

        if ($this->input->method() != 'post') {

            echo '404 Not Found';
            return false;
        }


        $data['errors'] = [];
        $data['success'] = [];
        $data['user_inf'] = [];
        $data['company'] = [];
        $data['get_states'] = [];

        $post_data = file_get_contents("php://input");

        if (empty($post_data)) {
            $data['errors'][] = 'Field is required';
            echo json_encode($data);
            return false;
        }

        $post_data = json_decode($post_data);

        $password = $post_data->password;
        $email = $post_data->email;

        if (empty($password)) {
            $data['errors'][] = 'Password field is required.';
            echo json_encode($data);
            return false;
        }


        if (empty($email)) {
            $data['errors'][] = 'Email field is required.';
            echo json_encode($data);
            return false;
        }

        if (!$this->ion_auth_model->login($email, $password)) {

            $data['errors'][] = 'Invalid email and/or password.';
            echo json_encode($data);
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $data['user_inf'] = $user;
        $data['company'] = $this->Company_model->get_all_company();
        $data['get_states'] = $this->Well_model->get_states();

        echo json_encode($data);

    }

    public function ax_get_socket_id()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        if (!$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $data['crew_id'] = $user->id;

        $data['socket_id'] = $this->input->cookie('io');

        echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    public function activity_password($driver_id = Null)
    {

        if (empty($driver_id)) {
            return false;
        }

        $data['content'] = 'frontend/activity_password';

        $data['driver_id'] = $driver_id;

        $this->load->view('frontend/site_main_template', $data);
    }

    public function save_activity_password()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $password = trim($this->input->post('password'));
        $rect_password = trim($this->input->post('rectype_password'));
        $id = trim($this->input->post('dripver_id'));

        $data['errors'] = [];
        $data['success'] = [];

        if (empty($password)) {
            $data['errors'][] = 'Password field is required.';
            echo json_encode($data);
            return false;
        }

        if (strlen($password) < 8) {
            $data['errors'][] = 'Password field must be at least 8 characters in length';
            echo json_encode($data);
            return false;
        }

        if ($password != $rect_password) {
            $data['errors'][] = 'Retype Password field does not match the password field.';
            echo json_encode($data);
            return false;
        }

        $driver = $this->Steersman_model->get_steersman($id);

        if (!empty($driver['password'])) {
            $data['errors'][] = 'Data not saved!';
            echo json_encode($data);
            return false;

        }

        $salt = $this->ion_auth_model->salt();

        $hash_password = $this->ion_auth_model->hash_password($password, $salt);

        $update_data = [
            'password' => $hash_password
        ];

        if (!$this->Steersman_model->update_steersman($id, $update_data)) {

            $data['errors'][] = 'Data not saved!';

        } else {

            if (!$this->ion_auth_model->login($driver['email'], $password)) {

                $data['errors'][] = 'All data Saved, but not loggined. Please try again';
                echo json_encode($data);
                return false;

            }

            $data['success'] = 'All data Saved!';
        }

        echo json_encode($data);
    }

    public function ax_next_filter()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $company_filter = $this->input->post('company_filter');
        $state_filter = $this->input->post('state_filter');

        $data['errors'] = [];
        $data['success'] = [];

        echo json_encode($data);
    }

    /*    public function test_redis()
        {

            $this->load->library('redis');
            $redis = $this->redis->conf();

            $set = $redis->set('data10', 'sdddgthtjuujht');
            $get = $redis->get('data10');
            $redis->publish('transaction_completed', $get);
            echo $get;

        }*/

    public function main_search()
    {

        $filter = file_get_contents("php://input");

        $filter = json_decode($filter);

        if (empty($filter)) {
            show_404();
            return false;
        }

        /*        if ($this->input->method() != 'post') {

                    show_404();
                    return false;
                }*/


        $data['filter_well'] = [];
        $new_well = [];
        $data['errors'] = [];

        if (empty($filter->company_filter)) {
            $data['errors'][] = 'Please set company';
            echo json_encode($data);
            return false;
        }

        if (empty($filter->state_filter)) {
            $data['errors'][] = 'Please set state';
            echo json_encode($data);
            return false;
        }

        if (empty($filter->locat)) {
            $data['errors'][] = 'crew GPS info required';
            echo json_encode($data);
            return false;
        }

        $well = $this->Well_model->get_wells_by_company($filter->company_filter, NULL, $filter->state_filter);

        if (empty($well)) {
            $data['errors'][] = 'Empty result';
            echo json_encode($data);
            return false;
        }

        $destination = '';
        $destination_arr = [];
        $count = 0;
        $keys = [];
        $min_index = 0;

        foreach ($well as $index => $single) {


            if ($single['road_status'] > 1) {
                continue;
            }

            $single['lat'] = str_replace(',', '.', $single['lat']);
            $single['lng'] = str_replace(',', '.', $single['lng']);

            $destination .= '' . $single['lat'] . ',' . $single['lng'] . '|';
            $count++;

            if ($count == 98) {
                $destination = substr($destination, 0, -1);
                $destination_arr[] = $destination;
                $destination = '';
                $count = 0;
            }

        }

        foreach ($destination_arr as $index => $value) {

            $key = $this->google_api->get_distance($filter->locat->lat, $filter->locat->lng, $value);

            if(empty($key)){
                continue;
            }

            foreach ($key as $key_index => $key_val) {
                $keys[$key_index] = $key_val;
            }
        }

        if(!empty($keys)){

            $min = min($keys);
            $min_key = array_keys($keys, $min);
            $min_index = (array_search($min_key[0], array_keys($keys)) + 1) * 100 + $min_key[0];
        }

        if(empty($min_index)){
            $data['go_arr'] = [];
            $data['filter_well'] = $well;
            echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
            return false;
        }


        $data['go_arr'] = $well[$min_index];

        $data['filter_well'] = $well;
        /* $this->load->library('redis');
         $redis = $this->redis->conf();

         $set = $redis->set('filter', json_encode($go_arr, JSON_HEX_APOS | JSON_HEX_QUOT));
         $get = $redis->get('filter');
         $redis->publish('filtered', $get);*/

        echo json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    public function ax_get_new_well()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        if (!$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $filter = json_decode($this->input->cookie('filter'));

        if (empty($filter)) {
            show_404();
            return false;
        }

        $data['filter_well'] = [];
        $new_well = [];
        $go_arr = [];
        $distance_arr = [];
        $data['errors'] = [];

        $crt = ['well.road_status' => 1];

        $well = $this->Well_model->get_wells_by_company($filter->company_filter, $crt);
        $state = $this->Well_model->get_states_by_ids($filter->state_filter);

        if (empty($well)) {

            $data['errors'][] = 'No freely well';
            echo json_encode($data);
            return false;
        }

        foreach ($well as $index => $single) {

            $well[$index]['state'] = '';

            $filtered_arr = $this->google_api->get_staate_by_latlng($single['lat'], $single['lng']);

            if (empty($filtered_arr)) {
                continue;
            }

            foreach ($filtered_arr as $item) {

                if (empty($item['types']) || $item['types'][0] != 'administrative_area_level_1') {
                    continue;
                }

                $well[$index]['state'] = $item['long_name'];
            }
        }

        foreach ($state as $item) {

            foreach ($well as $index => $single) {

                if ($item['state'] == $single['state']) {

                    $new_well[] = $single;

                    $single['lat'] = str_replace(',', '.', $single['lat']);
                    $single['lng'] = str_replace(',', '.', $single['lng']);

                    $distance = $this->google_api->calculate_distance($single['lat'], $single['lng'], $filter->locat->lat, $filter->locat->lng);


                    $distance_arr[$single['id']] = $distance;
                }
            }
        }

        foreach ($new_well as $item) {

            $min_id = array_keys($distance_arr, min($distance_arr));

            if ($item['id'] == $min_id[0]) {

                $go_arr = $item;
            }
        }


        echo json_encode($go_arr);
    }

    public function change_well_status()
    {

        $well_data = file_get_contents("php://input");

        $well_data = json_decode($well_data);

        if (empty($well_data)) {
            show_404();
            return false;
        }


        $well_status = $well_data->status;
        $well_id = $well_data->well_id;

        $data['errors'] = [];
        $data['success'] = [];

        $well = $this->Well_model->get_well(['id' => $well_id], true);

        if (empty($well)) {
            $data['errors'][] = 'error';
            echo json_encode($data);
            return false;
        }

        $user = $this->ion_auth->user()->row();

        $this->Well_model->update_well($well_id, ['road_status' => $well_status]);

        $data['success'][] = 'Well has been succesfully changed';

        echo json_encode($data);
    }

    public function logout()
    {

        if (!$this->ion_auth->logged_in()) {

            show_404();
            return false;
        }

        $user = $this->ion_auth->user()->row();

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());

        redirect('crew/crew_login', 'refresh');

    }
}