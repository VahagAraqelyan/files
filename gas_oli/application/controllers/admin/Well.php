<?php

class Well extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Well_model");
        $this->load->model("Company_model");
        $this->load->model("Lists_model");
        $this->load->library('csv_lib');
        $this->load->library('Excel');
    }

    public function index(){

        $this->get_all_wells();
    }

    public function get_all_wells(){

        $this->check_admin_login();

        $data['content'] = 'admin/well/all_well';

        $data['all_wels'] = $this->Well_model->get_well();

        $this->load->view('admin/back_template',$data);

    }

    public function add_wells(){

        $this->check_admin_login();

        $data['content'] = 'admin/well/add_well';
        $data['company']  = $this->Company_model->get_all_company();
        $data['states']  = $this->Well_model->get_states();
        $this->load->view('admin/back_template',$data);
    }

    public function ax_save_wells(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $well_id       = trim($this->input->post('well_id'));
        $name          = trim($this->input->post('name'));
        $location      = trim($this->input->post('location'));
        $status        = trim($this->input->post('status'));
        $lat           = trim($this->input->post('lat'));
        $lng           = trim($this->input->post('lng'));
        $company       = trim($this->input->post('company'));
        $company_field = trim($this->input->post('company_field'));
        $comment       = trim($this->input->post('comment'));
        $state_id      = trim($this->input->post('state_id'));


        $data['errors'] = [];
        $data['success'] = [];

        if (empty($well_id)) {
            $data['errors'][] = 'Well ID field is required.';
            echo json_encode($data);
            return false;
        }


        if (empty($name)) {
            $data['errors'][] = 'Well Name field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($location)) {
            $data['errors'][] = 'Surface Location field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($status)) {
            $data['errors'][] = 'Well Status field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($lat)) {
            $data['errors'][] = 'Surface Latitude field is required.';
            echo json_encode($data);
            return false;
        }

        if (empty($lng)) {
            $data['errors'][] = 'Surface Longitude field is required.';
            echo json_encode($data);
            return false;
        }

        $insert_data = [
            'well_id'       => $well_id,
            'name'          => $name,
            'location'      => $location,
            'status'        => $status,
            'lat'           => $lat,
            'lng'           => $lng,
            'company_id'    => $company,
            'company_field' => $company_field,
            'comment'       => $comment,
            'state_id'      => $state_id
        ];

        $all_wels = $this->Well_model->get_well();

        foreach ($all_wels as $old_index => $old_wel){

            if($insert_data['well_id'] == $old_wel['well_id']){

                $data['errors'][] = 'There is such that!';
                echo json_encode($data);
                return false;
            }
        }

        if(!$this->Well_model->insert_well($insert_data)){

            $data['errors'][] = 'Data not saved!';
        }else{

            $data['success'] = 'All data Saved!';
        }

        echo json_encode($data);

    }

    public function ax_upload_csv(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->load->helper('string');

        $data = [
            'errors'  => [],
            'success' => '',
            'info'    => []
        ];

        $file_name = time().random_string('alnum', 4);

        $config['upload_path']          = 'upload_image/csv_well';
        $config['allowed_types']        = 'xls|xlsx';
        $config['file_name']            = $file_name;
        $config['max_size']             = 13000;
        $config['max_width']            = 8000;
        $config['max_height']           = 8000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('well_csv'))
        {
            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }


        $file_info = $this->upload->data();

        $dir_url=FCPATH.'upload_image/csv_well/'.$file_info['file_name'];

        if (!file_exists($dir_url)) {
            $data['errors'][] = 'Data not saved!';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $insert_data = $this->excel->import_excel($dir_url);


        if(empty($insert_data)){

            $data['errors'][] = 'Data not saved! please check csv file.';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $update_data = [];

        $all_wels = $this->Well_model->get_well();
        $company_id = 0;
        $state_id = 0;
        foreach ($insert_data as $index => $single){

            if(!empty($single['company_id'])){
                $company_id = $this->Company_model->get_company_id_by_name($single['company_id']);
            }

            if(!empty($single['state_id'])){
                $state_id   = $this->Well_model->get_states_by_name($single['state_id']);
            }

            if(!$company_id){
                $company_id = $this->Company_model->insert_company(['name'=>$single['company_id']],true);
            }else{
                $insert_data[$index]['company_id'] = intval($company_id);
            }

            if(!empty($state_id)){
                $insert_data[$index]['state_id']   = intval($state_id);
            }

           if(!empty($all_wels)){

               foreach ($all_wels as $old_index => $old_wel){

                    if($single['well_id'] == $old_wel['well_id']){

                        $update_data[$old_wel['id']] =
                            [
                                'well_id'       => str_replace('"',' ',$single['well_id']),
                                'name'          => str_replace('"',' ',$single['name']),
                                'location'      => str_replace('"',' ',$single['location']),
                                'status'        => str_replace('"',' ',$single['status']),
                                'lat'           => str_replace('"',' ',$single['lat']),
                                'lng'           => str_replace('"',' ',$single['lng']),
                                'company_id'    => str_replace('"',' ',$single['company_id']),
                                'company_field' => str_replace('"',' ',$single['company_field']),
                                'comment'       => str_replace('"',' ',$single['comment']),
                                'road_status'   => str_replace('"',' ',$single['road_status']),
                                'state_id'      => str_replace('"',' ',$single['state_id']),
                            ];

                       unset($insert_data[$index]);
                    }
               }
           }
        }

        if(!empty($update_data)){

            foreach ($update_data as $index => $value){

                $this->Well_model->update_well($index,$value);
            }
        }

        if(!empty($insert_data)){
            if(!$this->Well_model->well_insert_batch($insert_data)){

                $data['errors'][] = 'Data not saved!';
                echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
                return false;
            }else{
                unlink($dir_url);
                $data['success'][] = 'Data saved';
            }
        }

        echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
    }

    public function ax_get_all_wells(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $page        = trim($this->input->post('page'));
        $type        = trim($this->input->post('type'));
        $search_type = trim($this->input->post('searching_type'));
        $ordering    = $this->input->post('order');
        $limit       = $this->input->post('length');

        if(empty($page)){
            $page = 1;
        }

        $return_data = [];
        $name_cr = [];
        $cr = [];

        $cr = [
            $type =>$search_type
        ];

        $asc_desc = $this->input->post('order');

        $limit = [10,0];

        $start = $this->input->post('start');
        $length = $this->input->post('length');

        if(!empty($start) || !empty($length)){

            $limit = [$length,$start];
        }

        $colums = [
            1 => 'well_id',
            2 => 'name',
            3 => 'location',
            4 => 'status',
            5 => 'lat',
            6 => 'lng',
            7 => 'company',
            8 => 'company_field',
            9 => 'comment',
            10 => 'state',
        ];

        if(!empty($ordering)){

            $ordering = [
                $colums[$asc_desc[0]['column']],
                $asc_desc[0]['dir']
            ];

        }else{
            $ordering = ['first_name', 'ASC'];
        }


        $all_count = $this->Well_model->get_all_well_count($cr,$name_cr);

        $all_wells = $this->Well_model->get_all_wells($limit,$cr,$ordering,$name_cr);

        if(empty($all_wells)){

            $all_count = 0;
            $return_data['recordsTotal'] = 0;
            $return_data['recordsFiltered'] = 0;

            $return_data['data'] = [];
            echo json_encode($return_data);
            return false;
        }

        foreach ($all_wells as $index => $single){

            if(!empty($single['comment']) && strlen($single['comment']) > 50){
                $sing_comment =  substr($single['comment'],0,50).' '.'<a href="#" class="paragraph_desc_view" data-lang="am" data-id="'.$single['id'].'">... View more</a>';
            }else{
                $sing_comment = $single['comment'];
            }

            $return_data['data'][] = [
                $index+1,
                str_replace('"',' ',$single['well_id']),
                str_replace('"',' ',$single['name']),
                str_replace('"',' ',$single['location']),
                str_replace('"',' ',$single['status']),
                str_replace('"',' ',$single['lat']),
                str_replace('"',' ',$single['lng']),
                str_replace('"',' ',$single['company_name']),
                str_replace('"',' ',$single['company_field']),
                str_replace('"',' ',$sing_comment),
                str_replace('"',' ',$single['state_name']),
                "<input type='checkbox' name='check_well' class='product_check' value='".$single['id']."'>",
            ];
        }

        $return_data['draw'] = $this->input->post('draw');
        $return_data['recordsTotal'] = $all_count;
        $return_data['recordsFiltered'] = $all_count;

        echo json_encode($return_data);

    }

    public function view_well(){

        $this->check_admin_login(true);

        $id     = trim($this->input->post('id'));

        $data['well_data'] = $this->Well_model->get_well(['id'=>$id],true);
        $this->load->view( 'admin/well/view_well_answer',$data);
    }

    public function manual_update_well(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }


        $data['errors'] = [];
        $data['success'] = [];

        $well_ids       = $this->input->post('well_id');
        $names          = $this->input->post('name');
        $locations      = $this->input->post('location');
        $statuses       = $this->input->post('status');
        $lats           = $this->input->post('lat');
        $lngs           = $this->input->post('lng');
        $companys       = $this->input->post('company');
        $company_fields = $this->input->post('company_field');
        $comments       = $this->input->post('comment');
        $ids            = $this->input->post('ids');
        $road_status    = $this->input->post('road_status');

        if(count($well_ids) != count($names) || count($locations) != count($names) || count($locations) != count($statuses) || count($statuses) != count($lats) || count($lats) != count($lngs) ||  count($lngs) != count($companys) || count($companys) != count($company_fields) || count($company_fields) != count($comments) || count($ids) != count($comments)){

            $data['errors'][] = 'Please set valid columns';
            echo json_encode($data);
            return false;
        }

        $update_data = [];

        foreach ($ids as $index => $value){

            if(in_array($well_ids[$index],$well_ids) && array_search($well_ids[$index],$well_ids) != $index){
                $data['errors'][] = $well_ids[$index]['well_id'].' Well ID is already please change';
                continue;
            }

            $update_data[$value] = [
                'well_id'       => $well_ids[$index],
                'name'          => $names[$index],
                'location'      => $locations[$index],
                'status'        => $statuses[$index],
                'lat'           => $lats[$index],
                'lng'           => $lngs[$index],
                'company_id'    => $companys[$index],
                'company_field' => $company_fields[$index],
                'comment'       => $comments[$index],
                'road_status'   => $road_status[$index],
            ];
        }

        $all_wels = $this->Well_model->get_wells_by_not_ids($ids);

        foreach ($update_data as $index => $single){

            foreach ($all_wels as $old_index => $old_wel){

                if($single['well_id'] == $old_wel['well_id']){

                    $data['errors'][] = $single['well_id'].' Well ID is already please change';
                    continue;
                }
            }

            $this->Well_model->update_well($index,$single);
        }

        echo json_encode($data);
    }

    public function ax_delete_well(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }


        $data['errors'] = [];
        $data['success'] = [];


        $ids = $this->input->post('ids');

        if(empty($ids)){
            $data['errors'][] = 'please check field!';
            echo json_encode($data);
            return false;
        }

        foreach ($ids as $single){

            $this->Well_model->delete_well($single);
        }

        echo  json_encode(true);
    }

    public function ax_download_csv(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }


        $data['errors'] = [];
        $data['success'] = [];

        $ids = $this->input->post('ids');

        if(empty($ids)){
            $data['errors'][] = 'Download error, please check field!';
            echo json_encode($data);
            return false;
        }

        $download_wells = $this->Well_model->get_wells_by_ids($ids);

        foreach ($download_wells as $index => $single){

           $download_wells[$index]['lat'] = str_replace(',','.',$single['lat']);
           $download_wells[$index]['lng'] = str_replace(',','.',$single['lng']);
           $download_wells[$index]['company_id'] = $this->Company_model->get_company_name_by_id($single['company_id']);
            unset($download_wells[$index]['id']);
        }

        $file_url = $this->excel->create_excel($download_wells);

        if (!file_exists($file_url)) {

            $data['errors'][] = 'Download error, please check field!';
            echo json_encode($data);
            return false;
        }

        $data['success'] = true;

       echo json_encode($data);
    }

    public function download_file(){

        $file_url = FCPATH.'upload_image/download_excel/down_excel.xlsx';

        if (!file_exists($file_url)) {

           return false;
        }

        @apache_setenv('no-gzip', 1);

        $this->load->helper('download');

        force_download($file_url, NULL);

        unlink($file_url);
    }

    public function ax_manual_update(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $ids = $this->input->post('ids');

        if(empty($ids)){
            $data['errors'][] = 'Download error, please check field!';
            echo json_encode($data);
            return false;
        }

        $data['company']  = $this->Company_model->get_all_company();

        $data['download_wells'] = $this->Well_model->get_wells_by_ids($ids);

        $this->load->view('admin/well/manual_update_answer',$data);
    }

    public function ax_see_map(){

        $this->check_admin_login();

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];

        $all_wells = $this->Well_model->get_well();

        if(empty($all_wells)){

            $data['errors'][] = 'Wells not found. Please add well.';
            echo json_encode($data);
            return false;
        }

        $data['well_lat_lng'] = [];

        foreach ($all_wells as $single){

            $data['well_lat_lng'][] = [

                'lat' => $single['lat'],
                'lng' => $single['lng'],
            ];
        }

        $data['well_lat_lng'] = json_encode($data['well_lat_lng']);

        $this->load->view('admin/map/admin_map',$data);
    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }
    }
}

