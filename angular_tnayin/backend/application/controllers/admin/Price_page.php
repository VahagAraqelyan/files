<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Price_page extends CI_Controller{

    private $admin_alias = ADMIN_PANEL_URL.'/';
    private $admin_dir;
    private $international_types = ['outbound_express', 'outbound_economy', 'inbound_express', 'inbound_economy'];

    public function __construct(){

        parent::__construct();
        $this->load->model("Ion_auth_model");
        $this->load->model("Users_model");
        $this->load->model("Manage_price_model");
        $this->load->model('Lists_model');
        $this->lang->load('auth');
        $this->load->library('captcha_lib');
        $this->load->library('Admin_security');
        $this->load->library('valid');
        $this->admin_dir = $this->admin_security->admin_dir();

    }

    public function index(){

        $this->check_admin_login();

        redirect($this->admin_dir.'price_page/manage_price', 'refresh');

    }

    public function manage_price($country_id = NULL){

        $this->check_admin_login();

        if(isset($country_id) && (!is_numeric($country_id)  || intval($country_id)<0)){
                show_404();
                return false;
        }

        $data['selected_country'] = false;
        $data['documents_block'] = '';
        $data['dom_documents_block'] = '';
        $iso = $this->Users_model->get_countries($country_id)[0]['iso2'];

        if(isset($country_id)){
            $data['selected_country'] = $country_id;
            $files = $this->Manage_price_model->get_currier_document($country_id,'1');
            $dom_files = $this->Manage_price_model->get_currier_document($country_id,'2');
            $data['documents_block'] = $this->load->view('backend/price_page/currier_doc_files',['files' => $files,'iso' => $iso],true);
            $data['dom_documents_block'] = $this->load->view('backend/price_page/currier_dom_files',['dom_files' => $dom_files,'iso' => $iso],true);
        }

        $holiday_day = $this->Manage_price_model->get_holidays($country_id);
        $dinamic_day = $this->Manage_price_model->get_dinamic_holidays($country_id);

        $data['delivery_time'] = [
            'inter' => $this->Manage_price_model->get_currier_files($country_id, NULL, 1, 'Delivery Time'),
            'domes' => $this->Manage_price_model->get_currier_files($country_id, NULL, 2, 'Delivery Time')
        ];

        $data['content']      ='backend/admin/manage_price';
        $data['admin_name']   = $this->session->userdata('admin_full_name');
        $data['admin_alias']  = $this->admin_alias;
        $data['countries']    = $this->Users_model->get_countries();
        $data['iso']          = $iso;
        $data['document_select'] = $this->Lists_model->get_data_by_list_key('currier_document');
        $data['comment']      = '';
        $data['comment_date'] = '';
        $data['curriers']     = [];
        $data['dom_curriers']     = [];
        $data['comment']      = $this->Manage_price_model->get_currier_comment('1',$country_id);
        $data['dom_comment']  = $this->Manage_price_model->get_currier_comment('2',$country_id);
        $data['holidays']     = $holiday_day;
        $data['dinamic_day']  = $dinamic_day;
        $data['weekend']      = $this->Manage_price_model->get_weekend($country_id);


        if($data['selected_country']===false){
            $this->load->view('backend/back_template',$data);
            return false;
        }


        $data['curriers'] = $this->get_curriers_array($data['selected_country']);

        $data['dom_curriers'] = $this->get_curriers_array($data['selected_country'], '2');
        $this->load->view('backend/back_template',$data);

    }

    public function ax_upload_price_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_iso = $this->security->xss_clean($this->input->post('iso'));
        $type_name   = $this->security->xss_clean($this->input->post('tname'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $currier_id  = $this->security->xss_clean($this->input->post('currier_id'));

        if(empty($this->Manage_price_model->get_curriers($currier_id))){
            $data['errors'][] = 'Undefined currier.';
            echo json_encode($data);
            return false;
        }

        if(!in_array($type_name, $this->international_types)){
            $data['errors'][] = 'Incorrect type name';
            echo json_encode($data);
            return false;
        }

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso;
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }

        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'csv';
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $date_val = date('Y-m-d H:i:s');

        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type'       => 1,
            'name'       => $type_name,
            'file_name'  => $file_info['file_name'],
            'date'       => $date_val,
            'status'     => 0
        ];


        $file = $this->Manage_price_model->get_currier_files($country_id, $currier_id, '1', $type_name);
        $new_url = $dir_url.'/'.$file_info['file_name'];

        if(!$file_id = $this->Manage_price_model->insert_currier_file($insert_data)){

            $data['errors'][] = 'Error insert data to database.';
            unlink($new_url);

        }

        $this->load->library('Csv_lib');

        $result = $this->csv_lib->insert_international_price($country_iso, $currier_id, $type_name, $new_url);

        if(!empty($result['error'])){

            $data['errors'][] = $result['error'];
            $this->_delete_currier_file($file_id, $new_url);

        }else{

            if(!empty($file) && $file[0]['date'] != $date_val){
                $url = $dir_url.'/'.$file[0]['file_name'];
                $this->_delete_currier_file($file[0]['id'], $url);
            }

            $data['success'][] = 'File uploaded successfully.';
            $this->Manage_price_model->update_file_status($file_id);

        }

        if(empty($data['errors'])){
            $data['success'] = 'Data successfully imported to databse.';
        }

        echo json_encode($data);

    }

    public function ax_delete_currier_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $currier_id = $this->security->xss_clean($this->input->post('currier_id'));
        $type_name  = $this->security->xss_clean($this->input->post('type_name'));
        $country_iso = $this->security->xss_clean($this->input->post('iso'));

        if(empty($country_id) || empty($type_name) || empty($country_iso) || empty($currier_id)){
            $data['errors'][] = 'Incorect data.';
            echo json_encode($data);
            return false;
        }

        if(!in_array($type_name, $this->international_types)){
            $data['errors'][] = 'Incorrect type name';
            echo json_encode($data);
            return false;
        }

        $table_name = strtolower($country_iso.'_international_price');

        $file = $this->Manage_price_model->get_currier_files($country_id, $currier_id, '1', $type_name);

        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso;

        if(empty($file)){
            $data['errors'][] = 'Undefined file.';
            echo json_encode($data);
            return false;
        }

        $url = $dir_url.'/'.$file[0]['file_name'];
        $this->_delete_currier_file($file[0]['id'], $url);

        $crt = [
            'currier_id' => $currier_id,
            'type'       => $type_name
        ];

        if($file[0]['status'] == 1) {
            $this->Manage_price_model->delete_batch_data($table_name, $crt);
        }

        $data['success'] = 'File successfully deleted.';
        echo json_encode($data);

    }

    public function _delete_currier_file($id, $url){

        $this->check_admin_login();

        if(empty($id) || empty($url) || !file_exists($url)){
            return false;
        }

        if(!empty($id)){
            $this->Manage_price_model->delete_currier_file($id);
        }

        unlink($url);

    }

    public function ax_save_international_price(){

        if (!$this->input->is_ajax_request()){
            return false;
        }

        $this->check_admin_login();

        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $currier_id = $this->security->xss_clean($this->input->post('currier_id'));
        $per_lbs    = $this->security->xss_clean($this->input->post('per_lbs'));
        $min        = $this->security->xss_clean($this->input->post('min'));
        $max_length = $this->security->xss_clean($this->input->post('max_length'));
        $max_weight = $this->security->xss_clean($this->input->post('max_weight'));
        $sur_charge = $this->security->xss_clean($this->input->post('sur_charge'));

        $data['errors'] = [];
        $data['success'] = [];

        if(empty($country_id) || empty($currier_id)){
            $data['errors'][] = 'Incorrect data.';
            echo json_encode($data);
            return false;
        }

        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info)){
            $data['errors'][] = 'Undefined country.';
            echo json_encode($data);
            return false;
        }


        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'per_lbs'    => $per_lbs,
            'min'        => $min,
            'max_length' => $max_length,
            'max_weight' => $max_weight,
            'sur_charge' => $sur_charge,
            'type'       => 1
        ];

        $oversize_crt = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type'       => 1
        ];

        $oversize_data = $this->Manage_price_model->get_over_size($oversize_crt);

        if(empty($oversize_data)){

            if(!$this->Manage_price_model->insert_over_size($insert_data)){
                $data['errors'][] = 'Error insert data to db.';
                echo json_encode($data);
                return false;
            }

        }else{

            if(!$this->Manage_price_model->update_over_size($oversize_data[0]['id'],$insert_data)){
                $data['errors'][] = 'Error update oversize data.';
                echo json_encode($data);
                return false;
            }

        }



        $data['success'] = 'Data successfully saved.';
        echo json_encode($data);

    }

    public function currier_file($iso, $file_name = NULL){

        $this->check_admin_login();

        if(empty(trim($file_name)) || empty(trim($file_name))){

            show_404();
            return false;
        }

        $file_path = FCPATH.'uploaded_documents/manage_price/'.$iso.'/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /*header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);*/
        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);
        exit;

    }

    public function country_profile_file($file_name = NULL){

        $this->check_admin_login();

        if(empty(trim($file_name))){

            show_404();
            return false;
        }

        $file_path = FCPATH.'uploaded_documents/countries_profiles/'.$file_name;

        if (!file_exists($file_path)) {

            show_404();
            return false;
        }

        /*header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);*/

        @apache_setenv('no-gzip', 1);
        $this->load->helper('download');
        force_download($file_path, NULL);

        exit;

    }

    public function get_curriers_array($country_id, $type = 1){

        $this->check_admin_login();

        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info)){
            return false;
        }

        $curriers = $this->Manage_price_model->get_curriers(NULL, $country_info[0]['iso2']);
        $return_data = [];

        if(!empty($curriers)){
            foreach($curriers as $single){

                $cur_info = [
                    'id'         => $single['id'],
                    'name'       => $single['currier_name'],
                    'domestic'   => $single['domestic'],
                    'intern_out' => $single['intern_out'],
                    'intern_in'  => $single['intern_in']
                ];

                $files = $this->Manage_price_model->get_currier_files($country_id, $single['id'], $type);

                $oversize_crt = [
                    'country_id' => $country_id,
                    'currier_id' => $single['id'],
                    'type'       => $type
                ];

                $oversize_data = $this->Manage_price_model->get_over_size($oversize_crt);

                if(!empty($oversize_data)) {
                    unset($oversize_data[0]['id']);
                    $cur_info = array_merge($cur_info, $oversize_data[0]);
                }

                if(!empty($files)){
                    foreach($files as $single_file){
                        if($single_file['name'] == 'Delivery Time') {continue;}
                        $cur_info[$single_file['name']] = $single_file['file_name'];
                        $cur_info[$single_file['name'].'_date'] = $single_file['date'];
                        $cur_info[$single_file['name'].'_id'] = $single_file['id'];
                    }
                }

                $return_data[] = $cur_info;
            }
        }

        return $return_data;

    }

    public function ax_international_doc_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_iso = $this->security->xss_clean($this->input->post('iso'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_id)){

            $data['errors'][] = 'Please select country.';
            echo json_encode($data);
            return false;

        }

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso;
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }


        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
      /*  $config['file_name'] = random_string('numeric', 10);*/
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }


        $file_info = $this->upload->data();

        $insert_data = [
            'country_id'    => $country_id,
            'doc_file_name' => $file_info['file_name'],
            'add_date'      => date('Y-m-d H:i:s'),
            'type'          => '1',
            'show_doc_name' => $file_info['client_name']
        ];

        if(!$this->Manage_price_model->insert_inter_document($insert_data)){

            $data['errors'][] = 'Error insert data to database.';

        }else{

            $data['success'][] = 'File uploaded successfully.';
        }

        echo json_encode($data);


    }

    public function ax_delete_inter_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $file_id    = $this->security->xss_clean($this->input->post('file_id'));
        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $iso        = $this->security->xss_clean($this->input->post('iso'));

        $file = $this->Manage_price_model->get_currier_document($country_id,'1',$file_id);

        if(empty($file)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        $this->Manage_price_model->delete_inter_document($file_id);

        $url = 'uploaded_documents/manage_price/'.$iso.'/'.$file[0]['doc_file_name'];

        if(!file_exists($url)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url)){

            $data['errors'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $data['success'][] = 'File removed successfully.';
        echo json_encode($data);

    }

    public function ax_country_profile_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $name    = $this->security->xss_clean($this->input->post('name'));

        if(empty($name)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        $url_path = 'uploaded_documents/countries_profiles/'.$name.'';

        if(!file_exists($url_path)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url_path)){

            $data['errors'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }/*else{

            if(!$this->Manage_price_model->delete_country_profile()){

                $data['errors'][] = 'Error insert data to database.';

            }
        }*/

        if(empty($data['errors'])){

            $data['success'][] = 'File removed successfully.';
        }

        echo json_encode($data);

    }

    public function ax_inter_comment(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $comment =     $this->security->xss_clean($this->input->post('comment'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_id)){

            $data['errors'][] = 'Undefined country .';
            echo json_encode($data);
            return false;

        }

        if(empty($comment)){

            $data['errors'][] = 'Please select comment .';
            echo json_encode($data);
            return false;

        }

        $insert_data = [

            'country_id' => $country_id,
            'type'       => '1',
            'comment'    => $comment
        ];

       $result = $this->Manage_price_model->get_currier_comment('0',$country_id);

       if(!empty($result)){

           if(!$this->Manage_price_model->update_currier_comment($insert_data,$country_id)){

               $data['errors'][] = 'Error insert data to database.';

           }else{

               $data['success'][] = 'Update has ben successfully.';
           }

           echo json_encode($data);

       } else{

           if(!$this->Manage_price_model->insert_currier_comment($insert_data)){

               $data['errors'][] = 'Error insert data to database.';

           }else{

               $data['success'][] = 'Insert has ben successfully.';
           }

           echo json_encode($data);
       }
    }

    public function ax_upload_inter_del_time(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_iso = $this->security->xss_clean($this->input->post('country_iso'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso.'/';
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }

        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'csv';
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $date_val = date('Y-m-d H:i:s');

        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => NULL,
            'type'       => 1,
            'name'       => 'Delivery Time',
            'file_name'  => $file_info['file_name'],
            'date'       => $date_val,
            'status'     => 0
        ];


        $file = $this->Manage_price_model->get_currier_files($country_id, 0, '1', 'Delivery Time');

        if(!$file_id = $this->Manage_price_model->insert_currier_file($insert_data)){

            $data['errors'][] = 'Error insert data to database.';
            unlink($dir_url.'/'.$file_info['file_name']);

        }

        $this->load->library('Csv_lib');
        $url = $dir_url.'/'.$file_info['file_name'];
        $result = $this->csv_lib->insert_international_delivery_time($url,$country_iso);

        if(!empty($result['error'])){

            $data['errors'][] = $result['error'];
            $this->_delete_currier_file($file_id, $url);

        }else{

            if(!empty($file) && $file[0]['date'] != $date_val){
                $url = $dir_url.'/'.$file[0]['file_name'];
                $this->_delete_currier_file($file[0]['id'], $url);
            }

            $data['success'][] = 'Data successfully inserted to database.';
        }

        echo json_encode($data);

    }

    public function ax_domestic_doc_file(){

        if (!$this->admin_security->is_admin() || !$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $data['errors'] = [];
        $data['success'] = [];


        $country_iso = $this->security->xss_clean($this->input->post('iso'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_id)){

            $data['errors'][] = 'Please select country.';
            echo json_encode($data);
            return false;

        }

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso;
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }

        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png|xls|xlsx|png';
        $config['file_name'] = random_string('numeric', 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();


        $insert_data = [
            'country_id'    => $country_id,
            'doc_file_name' => $file_info['file_name'],
            'add_date'      => date('Y-m-d H:i:s'),
            'type'          => '2'
        ];

        if(!$this->Manage_price_model->insert_inter_document($insert_data)){

            $data['errors'][] = 'Error insert data to database.';

        }else{

            $data['success'][] = 'File uploaded successfully.';
        }

        echo json_encode($data);


    }

    public function ax_delete_dom_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $file_id    = $this->security->xss_clean($this->input->post('file_id'));
        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $iso        = $this->security->xss_clean($this->input->post('iso'));

        $file = $this->Manage_price_model->get_currier_document($country_id,'2',$file_id);

        if(empty($file)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        $this->Manage_price_model->delete_inter_document($file_id);

        $url = 'uploaded_documents/manage_price/'.$iso.'/'.$file[0]['doc_file_name'];

        if(!file_exists($url)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url)){

            $data['errors'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $data['success'][] = 'File removed successfully.';
        echo json_encode($data);

    }

    public function ax_dom_comment(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $comment     = $this->security->xss_clean($this->input->post('comment'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_id)){

            $data['errors'][] = 'Undefined country .';
            echo json_encode($data);
            return false;

        }

        if(empty($comment)){

            $data['errors'][] = 'Please select comment .';
            echo json_encode($data);
            return false;

        }

        $insert_data = [

            'country_id' => $country_id,
            'type'       => '2',
            'comment'    => $comment
        ];

        $result = $this->Manage_price_model->get_currier_comment('1',$country_id);

        if(!empty($result)){

            if(!$this->Manage_price_model->update_currier_comment($insert_data,$country_id)){

                $data['errors'][] = 'Error insert data to database.';

            }else{

                $data['success'][] = 'Update has ben successfully.';
            }

            echo json_encode($data);

        } else{

            if(!$this->Manage_price_model->insert_currier_comment($insert_data)){

                $data['errors'][] = 'Error insert data to database.';

            }else{

                $data['success'][] = 'Insert has ben successfully.';
            }

            echo json_encode($data);
        }
    }

    public function ax_save_pick_up_fee(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id    = $this->security->xss_clean($this->input->post('country_id'));
        $domestic_bas  = floatval($this->security->xss_clean($this->input->post('domestic_bas')));
        $domestic_exp  = floatval($this->security->xss_clean($this->input->post('domestic_exp')));
        $international = floatval($this->security->xss_clean($this->input->post('international')));
        $sat_pickup    = floatval($this->security->xss_clean($this->input->post('sat_pickup')));
        $sat_delivery  = floatval($this->security->xss_clean($this->input->post('sat_delivery')));

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country .';
            echo json_encode($data);
            return false;

        }


        $insert_data = [
            'domestic_basic'    => $domestic_bas,
            'domestic_express'  => $domestic_exp,
            'international'     => $international,
            'saturday_pickup'   => $sat_pickup,
            'saturday_delivery' => $sat_delivery,
            'date'              => date('Y-m-d H:i:s')
        ];

        if($country_id == '0'){

            $all = $this->Manage_price_model->get_pickup_fee($country_id);
           if(!$this->Manage_price_model->update_pickup_fee($insert_data)){

               $data['errors'][] = 'Error update data to database.';
         }

            if(empty($all)){

                if(!$this->Manage_price_model->insert_pickup_fee($insert_data)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            if(empty($data['errors'])){

                $data['success'][] = 'Update has ben successfully.';
            }

        }else{

            $pick_up = $this->Manage_price_model->get_pickup_fee($country_id);

            if(empty($pick_up)){

                $insert_data[ 'country_id'  ] = $country_id;
                $result = $this->Manage_price_model->insert_pickup_fee($insert_data);

            }else{

                $result  = $this->Manage_price_model->update_pickup_fee($insert_data,$country_id);
            }

            if(!$result){

                $data['errors'][] = 'Error update data to database.';

            }else{

                $data['success'][] = 'Update has ben successfully.';
            }
        }

        echo json_encode($data);

    }

    public function ax_save_domestic_insurance(){

        if (!$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id          = $this->security->xss_clean($this->input->post('country_id'));
        $insurance_amount    = $this->security->xss_clean($this->input->post('insurance_amount'));
        $insurance_fee       = $this->security->xss_clean($this->input->post('insurance_fee'));

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country .';
            echo json_encode($data);
            return false;

        }

        if(empty($insurance_fee) && empty($insurance_amount)){

            $data['errors'][] = 'Invalid domestic insurance';
        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        foreach ($insurance_amount as $key => $insurance){


            if(empty($insurance_amount[$key])){

                $insurance_amount[$key] = '0';
            }

            if(empty($insurance_fee[$key])){

                $insurance_fee[$key] = '0';
            }

            $insert_data[] = array('insurance_amount' => floatval($insurance_amount[$key]),'insurance_fee' => floatval($insurance_fee[$key]),'location' => $key+1,'date' => date('Y-m-d H:i:s'));

        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        if($country_id == '0'){

            $all = $this->Manage_price_model->get_domestic_insurance($country_id);

            if(!$this->Manage_price_model->update_domestic_insurance($insert_data)){

                $data['errors'][] = 'Error update data to database.';
            }

            if(empty($all)){

                if(!$this->Manage_price_model->insert_domestic_insurance($insert_data)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            if(empty($data['errors'])){

                $data['success'][] = 'Update has ben successfully.';
            }



        }else{

            $dom_ins = $this->Manage_price_model->get_domestic_insurance($country_id);

            if(empty($dom_ins)){

                foreach ($insurance_amount as $key => $insurance){

                    $batch_data[] = array('insurance_amount' => floatval($insurance_amount[$key]),'insurance_fee' => floatval($insurance_fee[$key]),'location' => $key+1,'country_id' =>$country_id,'date'=> date('Y-m-d H:i:s'));

                }

                $res = $this->Manage_price_model->insert_domestic_insurance($batch_data);

            }else{

                $res  = $this->Manage_price_model->update_domestic_insurance($insert_data,$country_id);
            }

            if(!$res){

                $data['errors'][] = 'Error update data to database.';

            }else{

                $data['success'][] = 'Update has ben successfully.';
            }
        }

        echo json_encode($data);
    }

    public function ax_save_international_insurance(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id          = $this->security->xss_clean($this->input->post('country_id'));
        $insurance_amount    = $this->security->xss_clean($this->input->post('insurance_amount'));
        $insurance_fee       = $this->security->xss_clean($this->input->post('insurance_fee'));

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country .';
            echo json_encode($data);
            return false;

        }

        if(empty($insurance_fee) && empty($insurance_amount)){

            $data['errors'][] = 'Invalid domestic insurance';
        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        foreach ($insurance_amount as $key => $insurance){


            if(empty($insurance_fee[$key])){

                $insurance_fee[$key] = '0';
            }

            if(empty($insurance_amount[$key])){

                $insurance_amount[$key] = '0';
            }

            $insert_data[] = array('insurance_amount' => floatval($insurance_amount[$key]),'insurance_fee' => floatval($insurance_fee[$key]),'location' => $key+1,'date' => date('Y-m-d H:i:s'));

        }

        if (!empty($data['errors'])) {

            echo json_encode($data);
            return false;

        }

        if($country_id == '0'){

            $all = $this->Manage_price_model->get_international_insurance($country_id);

            if(!$this->Manage_price_model->update_international_insurance($insert_data)){

                $data['errors'][] = 'Error update data to database.';
            }

            if(empty($all)){

                if(!$this->Manage_price_model->insert_international_insurance($insert_data)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            if(empty($data['errors'])){

                $data['success'][] = 'Update has ben successfully.';
            }



        }else{

            $dom_ins = $this->Manage_price_model->get_international_insurance($country_id);

            if(empty($dom_ins)){

                foreach ($insurance_amount as $key => $insurance){

                    $batch_data[] = array('insurance_amount' => floatval($insurance_amount[$key]),'insurance_fee' => floatval($insurance_fee[$key]),'location' => $key+1,'country_id' =>$country_id,'date' => date('Y-m-d H:i:s'));

                }

                $res = $this->Manage_price_model->insert_international_insurance($batch_data);

            }else{

                $res  = $this->Manage_price_model->update_international_insurance($insert_data,$country_id);
            }

            if(!$res){

                $data['errors'][] = 'Error update data to database.';

            }else{

                $data['success'][] = 'Update has ben successfully.';
            }
        }

        echo json_encode($data);
    }

    public function ax_processing_fee(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id        = $this->security->xss_clean($this->input->post('country_id'));
        $item_processing   = floatval($this->security->xss_clean($this->input->post('item_processing')));
        $cruise_crocessing = floatval($this->security->xss_clean($this->input->post('cruise_crocessing')));
        $cancelation_fee   = floatval($this->security->xss_clean($this->input->post('cancelation_fee')));

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country .';
            echo json_encode($data);
            return false;

        }

        $insert_data = [
            'item_processing'    => $item_processing,
            'cruise_processing'  => $cruise_crocessing,
            'cancelation_fee'    => $cancelation_fee,
            'date'               => date('Y-m-d H:i:s')
        ];

        if($country_id == '0'){

            $all = $this->Manage_price_model->get_processing_fee($country_id);
            if(!$this->Manage_price_model->update_processing_fee($insert_data)){

                $data['errors'][] = 'Error update data to database.';
            }

            if(empty($all)){

                if(!$this->Manage_price_model->insert_processing_fee($insert_data)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            if(empty($data['errors'])){

                $data['success'][] = 'Update has ben successfully.';
            }

        }else{

            $pick_up = $this->Manage_price_model->get_processing_fee($country_id);

            if(empty($pick_up)){

                $insert_data[ 'country_id'  ] = $country_id;
                $result = $this->Manage_price_model->insert_processing_fee($insert_data);

            }else{

                $result  = $this->Manage_price_model->update_processing_fee($insert_data,$country_id);
            }

            if(!$result){

                $data['errors'][] = 'Error update data to database.';

            }else{

                $data['success'][] = 'Update has ben successfully.';
            }
        }

        echo json_encode($data);

    }

    public function ax_country_profile(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $country_id = $this->security->xss_clean($this->input->post('country_id'));

        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_id) && $country_id != '0'){
            return false;
        }

        $data['country'] = 'ALL';
        $country_iso = 'all';
        $data['custom_value'] = NULL;

        if(!empty($country_info)){
            $data['country'] = $country_info[0]['country'];
            $country_iso = $country_info[0]['iso2'];
        }

        $result = $this->Manage_price_model->get_country_profile($country_iso);

        $curriers = $this->Manage_price_model->get_curriers();
        $data['curriers'] = [];
        if(!empty($curriers)){
            foreach($curriers as $single){
                $data['curriers'][$single['id']]=[
                    'id' => $single['id'],
                    'currier_name' =>  $single['currier_name'],
                    'profile_id'   =>  NULL,
                    'currier_id'   =>  NULL,
                    'country_id'   =>  NULL,
                    'domestic'     =>  NULL,
                    'intern_out'   =>  NULL,
                    'intern_in'    =>  NULL,
                    'hotline'      =>  NULL,
                    'website'      =>  NULL,
                    'user_name'    =>  NULL,
                    'password'     =>  NULL,
                    'partner_web'  =>  NULL,
                    'user_name_p'  =>  NULL,
                    'password_p'   =>  NULL,
                    'custom_value' =>  NULL,
                ];
            }
        }



        if(!empty($result)) {

            $data['custom_value'] = $result[0]['custom_value'];

            if($data['custom_value'] < 0){
                $data['custom_value'] = 'n/a';
            }

            foreach ($result as $prof) {
                $data['curriers'][$prof['id']] = $prof;
            }
        }

        $this->load->view('backend/price_page/country_profile', $data);

    }

    public function ax_save_country_profile(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $ids = $this->security->xss_clean($this->input->post('ids'));
        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $custom_value = $this->security->xss_clean($this->input->post('custom_value'));
        $country_info = $this->Users_model->get_countries($country_id);

        if(stripos($custom_value, 'n/a') !== false){
            $custom_value = -1;
        }

        if(empty($country_info) && $country_id != 0){
            $data['errors'][] = 'Invalid country.';
            echo json_encode($data);
            return false;
        }

        if($country_id == 0){
            $country_info[0] = ['iso2' => 'all'];
        }

        if(empty($ids)){
            $data['errors'][] = 'No curriers.';
            echo json_encode($data);
            return false;
        }

        $isset_profile = true;
        if(empty($this->Manage_price_model->get_country_profile( $country_info[0]['iso2']))){
            $isset_profile = false;
        }

        foreach ($ids as $id) {

            $update_data = [
                'domestic' => $this->security->xss_clean($this->input->post($id . '_domestic')),
                'intern_out' => $this->security->xss_clean($this->input->post($id . '_int_out')),
                'intern_in' => $this->security->xss_clean($this->input->post($id . '_int_in')),
                'hotline' => $this->security->xss_clean($this->input->post($id . '_hotline')),
                'website' => $this->security->xss_clean($this->input->post($id . '_website')),
                'user_name' => $this->security->xss_clean($this->input->post($id . '_user_name')),
                'password' => $this->security->xss_clean($this->input->post($id . '_password')),
                'partner_web' => $this->security->xss_clean($this->input->post($id . '_partn_web')),
                'user_name_p' => $this->security->xss_clean($this->input->post($id . '_user_name_p')),
                'password_p' => $this->security->xss_clean($this->input->post($id . '_password_p')),
                'custom_value' => $custom_value,
                'country_iso' => $country_info[0]['iso2']
            ];

            $crt = [
                'currier_id' => $id,
                'country_iso' => $country_info[0]['iso2']
            ];

            if($isset_profile){

                if($country_id == 0){
                   unset($crt['country_iso']);
                   unset($update_data['country_iso']);
                }

                if (!$this->Manage_price_model->update_country_profile($update_data, $crt)) {
                    $data['errors'][] = 'Error fill data do database.';
                }

            }else{

                $insert_array = array_merge($update_data, $crt);

                if (!$this->Manage_price_model->insert_country_profile($insert_array)){
                    $data['errors'][] = 'Error fill data do database.';
                }

                if($country_id == 0){
                    unset($crt['country_iso']);
                    unset($update_data['country_iso']);
                    $this->Manage_price_model->update_country_profile($update_data, $crt);
                }

            }

        }



        if(empty($data['errors'])){
            $data['success'] = 'All data successfully seved.';
         }

        echo json_encode($data);

    }

    public function ax_upload_country_profile_csv(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $dir_url=FCPATH.'uploaded_documents/countries_profiles';
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775);
        }

        $config['upload_path'] = $dir_url;
        $config['file_name'] = 'Country-Profile';
        $config['allowed_types'] = 'csv';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $url = $file_info['full_path'];
        $this->load->library('Csv_lib');
        $result = $this->csv_lib->insert_country_profile_csv($url);

        if(!empty($result['error'])){
            unlink($url);
            $data['errors'][] = $result['error'];
        }else{
            $data['success'] = 'Data successfully inserted to database.';
        }

        echo json_encode($data);

    }

    public function ax_extra_charge(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['pickup_fee'] = '';
        $data['processing_fee'] = '';
        $data['domestic_insurance'] = '';
        $data['international_insurance'] = '';

        $country_id = $this->security->xss_clean($this->input->post('country_id'));


        $data['pickup_fee'] = $this->Manage_price_model->get_pickup_fee($country_id);
        $data['processing_fee'] = $this->Manage_price_model->get_processing_fee($country_id);
        $data['domestic_insurance'] = $this->Manage_price_model->get_domestic_insurance($country_id);
        $data['international_insurance'] = $this->Manage_price_model->get_international_insurance($country_id);

        if(empty($country_id) && $country_id != '0'){

            $data['pickup_fee'] = '';
            $data['processing_fee'] = '';
            $data['domestic_insurance'] = '';
            $data['international_insurance'] = '';
        }

        $this->load->view('backend/price_page/extra_charges',$data);

    }

    public function ax_products(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $country_id = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_id) && $country_id != '0'){
            return false;
        }

        $result = $this->Manage_price_model->get_prod_international($country_id);
        $domestic = $this->Manage_price_model->get_prod_domestic($country_id);
        $products = $this->Manage_price_model->get_product();
        $types = $this->Manage_price_model->get_prod_type();
        $curriers = $this->Manage_price_model->get_curriers();

        $data['country'] = NULL;

        if(!empty($data['country'] = $this->Users_model->get_countries($country_id))){
            $data['country'] = $data['country'][0]['country'];
        }

        foreach ($types as $type){

            $data['types'][$type['id']]=[
                'name' => $type['type_name'],
                'date' => NULL,
                'prod' => []
            ];

            }
        $data['currier_name'] = [];

        if(!empty($products)) {

            foreach ($products as $prod) {

                $data['types'][$prod['type_id']]['prod'][$prod['product_id']] = [

                    'weight'            =>  $prod['weight'],
                    'charge_weight'     =>  NULL,
                    'size'              => NULL,
                    'prod_name'         =>  $prod['luggage_name'],
                    'domestic_express'  =>  NULL,
                    'domestic_basic'    =>  NULL,
                    'api_weight'        =>  NULL,
                    'api_size'          =>  0,


                ];

                if(!empty($prod['calc_length']) && !empty($prod['calc_width']) && !empty($prod['calc_height'])){

                    $data['types'][$prod['type_id']]['prod'][$prod['product_id']]['size'] = $prod['calc_width'].'-'.$prod['calc_height'].'-'.$prod['calc_length'];
                }
            }
        }


                foreach($curriers as $single){

                    $data['curriers'][$single['id']] =[
                    'currier_name'  =>  $single['currier_name'],
                     'value'        =>  []

            ];
        }

        if(!empty($domestic)){

            foreach ($domestic as $value){

            $data['types'][$value['type_id']]['prod'][$value['luggage_id']]['charge_weight'] = $value['charge_weight'];
            $data['types'][$value['type_id']]['prod'][$value['luggage_id']]['domestic_express'] = $value['domestic_express'];
            $data['types'][$value['type_id']]['prod'][$value['luggage_id']]['domestic_basic'] = $value['domestic_basic'];
            $data['types'][$value['type_id']]['prod'][$value['luggage_id']]['api_weight'] = $value['api_weight'];
            $data['types'][$value['type_id']]['date'] = $value['date'];

                if(!empty($value['api_width']) && !empty($value['api_height']) && !empty($value['api_length'])){

                    $data['types'][$value['type_id']]['prod'][$value['luggage_id']]['api_size'] = $value['api_width'].'-'.$value['api_height'].'-'.$value['api_length'];
                }
            }
        }

       if(!empty($result)){
            foreach($result as $international) {
                $data['curriers'][$international['currier_id']]['value'][$international['luggage_id']]['international_fee'] = $international['international_fee'];
                $data['curriers'][$international['currier_id']]['value'][$international['luggage_id']]['international_fee_1'] = $international['international_fee_1'];
                $data['curriers'][$international['currier_id']]['value'][$international['luggage_id']]['international_fee_2'] = $international['international_fee_2'];

            }
        }

        $this->load->config('check_price');
        $data['international_fee_limit'] = $this->config->item('international_fee_limit');

        $this->load->view('backend/price_page/products',$data);

    }

    public function ax_save_product(){

        if (!$this->input->is_ajax_request()) {

            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $ids = $this->security->xss_clean($this->input->post('ids'));
        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info) && $country_id != 0){
            $data['errors'][] = 'Invalid country.';
            echo json_encode($data);
            return false;
        }

        if(empty($ids)){
            $data['errors'][] = 'No luggages.';
            echo json_encode($data);
            return false;
        }

        $luggage_update_array = [];
        $domestic_array = [];
        $international_array = [];

        foreach($ids as $id){

            // luggage update_array
            $weight = $this->security->xss_clean($this->input->post('weight_'.$id));
            $sizes  = $this->security->xss_clean($this->input->post('size_'.$id));
            $max_weight = $this->security->xss_clean($this->input->post('max_weight_'.$id));
            $max_sizes  = $this->security->xss_clean($this->input->post('max_size_'.$id));

            $sizes     = explode('-',$sizes);
            $max_sizes = explode('-',$max_sizes);

            if(count($sizes) < 3){
                for($i=0; $i<3; $i++){
                    if(empty($sizes[$i])){
                        $sizes[$i] = NULL;
                    }
                }
            }

            if(count($max_sizes) < 3){
                for($i=0; $i<3; $i++){
                    if(empty($max_sizes[$i])){
                        $max_sizes[$i] = NULL;
                    }
                }
            }

            $luggage_update_array[] = [
                'where' => ['product_id' => $id],
                'update_array' => [
                    'weight' => $weight,
                    'calc_width'  => $sizes[0],
                    'calc_height' => $sizes[1],
                    'calc_length' => $sizes[2],
                ]
            ];

            //Domestic array
            $charge_weight = $this->security->xss_clean($this->input->post('charge_weight_'.$id));
            $dom_express   = $this->security->xss_clean($this->input->post('express_'.$id));
            $dom_basic     = $this->security->xss_clean($this->input->post('basic_'.$id));

            $domestic_array[] = [
                'luggage_id' => $id,
                'country_id' => $country_id,
                'charge_weight'    => $charge_weight,
                'domestic_express' => $dom_express,
                'domestic_basic'   => $dom_basic,
                'api_weight'       => $max_weight,
                'api_width'        => $max_sizes[0],
                'api_height'       => $max_sizes[1],
                'api_length'       => $max_sizes[2],
                'date'             =>  date('Y-m-d H:i:s')
            ];

            $data_update = [
                        'date'  =>  date('Y-m-d H:i:s')
                     ];

            // International array
            $currier = $this->security->xss_clean($this->input->post('currier_'.$id));

            foreach($currier as $currier_id => $international_fee) {
                $international_array[] = [
                    'where' => [
                        'currier_id' => $currier_id,
                        'luggage_id' => $id,
                        'country_id' => $country_id
                    ],
                    'update_array' => $international_fee
                ];
            }

        }

        foreach ($luggage_update_array as $prod_update_data){

            if(!$this->Manage_price_model->update_prod($prod_update_data['where'],$prod_update_data['update_array'])){

                $data['errors'][] = 'Error update data to database.';
            }
        }

        if($country_id == '0'){

            $all_domestic =      $this->Manage_price_model->get_domestic($country_id,$id);
            $all_international = $this->Manage_price_model->get_international($country_id,$id);
            foreach ($domestic_array as $prod_domestic){

                $luggage_id = $prod_domestic['luggage_id'];
                unset($prod_domestic['luggage_id']);
                unset($prod_domestic['country_id']);

                if(!$this->Manage_price_model->update_domestic($luggage_id,$prod_domestic)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }


            if(empty($all_domestic)){

                if(!$this->Manage_price_model->insert_domestic($domestic_array)){

                    $data['errors'][] = 'Error update data to database.';
                }

            }

            foreach ($international_array as $international){

                unset($international['where']['country_id']);

                if(!$this->Manage_price_model->update_international($international['where'],$international['update_array'])){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            if(empty($all_international)){

                foreach ($international_array as $international){

                    $insert_international_array[] = array_merge($international['where'],$international['update_array']);
                }

                if(!$this->Manage_price_model->insert_international($insert_international_array)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }

            $this->Manage_price_model->update_domestic($luggage_id,$data_update);

        }// End if all count

        else{

            $all_domestic =      $this->Manage_price_model->get_domestic($country_id,$id);
            $all_international = $this->Manage_price_model->get_international($country_id,$id);

            if(empty($all_domestic)){

                if(!$this->Manage_price_model->insert_domestic($domestic_array)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }
            else{

                foreach ($domestic_array as $prod_domestic){

                    $luggage_id = $prod_domestic['luggage_id'];
                    unset($prod_domestic['luggage_id']);
                    unset($prod_domestic['country_id']);

                    if(!$this->Manage_price_model->update_domestic($luggage_id,$prod_domestic,$country_id)){

                        $data['errors'][] = 'Error update data to database.';
                    }
                }
            }

            if(empty($all_international)){

                foreach ($international_array as $international){

                    $insert_international_array[] = array_merge($international['where'],$international['update_array']);
                }

                if(!$this->Manage_price_model->insert_international($insert_international_array)){

                    $data['errors'][] = 'Error update data to database.';
                }
            }
            else{

                foreach ($international_array as $international){

                    if(!$this->Manage_price_model->update_international($international['where'],$international['update_array'])){

                        $data['errors'][] = 'Error update data to database.';
                    }
                }
            }

            $this->Manage_price_model->update_domestic($luggage_id,$data_update,$country_id);
        }

        if(empty($data['errors'])){
            $data['success'] = 'Saved';
        }

        echo json_encode($data);
    }

    public function ax_product_pattern(){

        if (!$this->input->is_ajax_request()){

            show_404();
            return false;
        }

        $this->check_admin_login();

        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $domestic_pattern = $this->security->xss_clean($this->input->post('domestic_pattern'));
        $international_pattern = $this->security->xss_clean($this->input->post('international_pattern'));

        $data['errors'] = [];
        $data['success'] = [];

        if(empty($country_id) && $country_id != 0){
            $data['errors'][] = 'Invalid country.';
            echo json_encode($data);
            return false;
        }

        if(empty($international_pattern)){
            $data['errors'][] = 'Please select international pattern.';
            echo json_encode($data);
            return false;
        }

        if(empty($domestic_pattern)){
            $data['errors'][] = 'Please select domestic pattern.';
            echo json_encode($data);
            return false;
        }

    }

    public function ax_delete_delivery_time(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $name    = $this->security->xss_clean($this->input->post('name'));
        $data_block    = $this->security->xss_clean($this->input->post('data_block'));
        $country_id    = $this->security->xss_clean($this->input->post('country_id'));
        $country_iso    = $this->security->xss_clean($this->input->post('country_iso'));

        if(empty($name)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        $url_path = 'uploaded_documents/manage_price/'.$country_iso.'/'.$name.'';

        if(!file_exists($url_path)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;

        }

        if(!unlink($url_path)){

            $data['errors'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $country_iso = strtolower($country_iso);
        $tablename = $country_iso.'_international_delivery_time';

        if(!$this->Manage_price_model->drop_table($tablename)){
            $data['errors'][]  = 'Error deleting table '.$tablename;
        }

        $cr = [
            'name'       => $data_block,
            'country_id' => $country_id
        ];

        if(!$this->Manage_price_model->delete_currier_file_criteria($cr)){

            $data['errors'][]  = 'Error delete file for db';

        }

        if(empty($data['errors'])){

            $data['success'][] = 'File removed successfully.';
        }

        echo json_encode($data);

    }

    public function ax_delete_domestic_currier_file(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $name        = $this->security->xss_clean($this->input->post('name'));
        $type_name   = $this->security->xss_clean($this->input->post('data_name'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $country_iso = $this->security->xss_clean($this->input->post('country_iso'));
        $currier_id  = $this->security->xss_clean($this->input->post('currier_id'));

        if(empty($name)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        if(empty($country_id) && $country_id != '0'){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        $url_path = 'uploaded_documents/manage_price/'.$country_iso.'/'.$name.'';

        if(!file_exists($url_path)){
            $data['errors'][] = 'File not found.';
        }

        if(!unlink($url_path)){

            $data['errors'][] = 'Can\'t remove file.';
            echo json_encode($data);
            return false;

        }

        $table_name = strtolower($country_iso.'_domestic');
        $this->load->model("Home_model");

        if($this->Home_model->table_exists($table_name)){
            $this->Manage_price_model->delete_batch_data($table_name, ['currier_id' => $currier_id]);
        }


        $cr = [
            'file_name'  => $name,
            'country_id' => $country_id,
            'name' => $type_name

        ];

        if(!$this->Manage_price_model->delete_currier_file_criteria($cr)){

            $data['errors'][]  = 'Error delete file for db';

        }


        if(empty($data['errors'])){

            $data['success'][] = 'File removed successfully.';
        }

        echo json_encode($data);

    }

    public function ax_save_domestic_price(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $country_id = $this->security->xss_clean($this->input->post('country_id'));
        $currier_id = $this->security->xss_clean($this->input->post('currier_id'));
        $per_lbs    = $this->security->xss_clean($this->input->post('per_lbs'));
        $min        = $this->security->xss_clean($this->input->post('min'));
        $max_length = $this->security->xss_clean($this->input->post('max_length'));
        $max_weight = $this->security->xss_clean($this->input->post('max_weight'));
        $sur_charge = $this->security->xss_clean($this->input->post('sur_charge'));

        $data['errors'] = [];
        $data['success'] = [];

        if(empty($country_id) || empty($currier_id)){
            $data['errors'][] = 'Incorect data.';
            echo json_encode($data);
            return false;
        }

        $country_info = $this->Users_model->get_countries($country_id);

        if(empty($country_info)){
            $data['errors'][] = 'Undefined country.';
            echo json_encode($data);
            return false;
        }

        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'per_lbs'    => $per_lbs,
            'min'        => $min,
            'max_length' => $max_length,
            'max_weight' => $max_weight,
            'sur_charge' => $sur_charge,
            'type'       => 2
        ];

        $oversize_crt = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type'       => 2
        ];

        $oversize_data = $this->Manage_price_model->get_over_size($oversize_crt);

        if(empty($oversize_data)){

            if(!$this->Manage_price_model->insert_over_size($insert_data)){
                $data['errors'][] = 'Error insert data to db.';
                echo json_encode($data);
                return false;
            }

        }else{

            if(!$this->Manage_price_model->update_over_size($oversize_data[0]['id'],$insert_data)){
                $data['errors'][] = 'Error update oversize data.';
                echo json_encode($data);
                return false;
            }

        }

            $data['success'] = 'Data successfully saved.';
            echo json_encode($data);

    }

    public function ax_upload_domestic_price(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_iso = $this->security->xss_clean($this->input->post('country_iso'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $currier_id  = $this->security->xss_clean($this->input->post('currier_id'));

        if(empty($this->Manage_price_model->get_curriers($currier_id))){
            $data['errors'][] = 'Undefined currier.';
            echo json_encode($data);
            return false;
        }

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso;
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }

        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'csv';
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $date_val = date('Y-m-d H:i:s');

        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => $currier_id,
            'type'       => 2,
            'name'       => 'Domestic',
            'file_name'  => $file_info['file_name'],
            'date'       => $date_val,
            'status'     => 1
        ];


        $file = $this->Manage_price_model->get_currier_files($country_id, $currier_id, '2', 'Domestic');

        if(!$file_id = $this->Manage_price_model->insert_currier_file($insert_data)){

            $data['errors'][] = 'Error insert data to database.';
            unlink($dir_url.'/'.$file_info['file_name']);

        }

        if(!empty($data['errors'])){
            echo json_encode($data);
        }

        $this->load->library('Csv_lib');
        $url = $dir_url.'/'.$file_info['file_name'];

        $result = $this->csv_lib->upload_domestic($country_iso, $currier_id, $url);

        if(!empty($result['error'])){
            $this->_delete_currier_file($file_id, $url);
            $data['errors'][] = $result['error'];
        }else{

            if(!empty($file)){
                $url = $dir_url.'/'.$file[0]['file_name'];
                $this->_delete_currier_file($file[0]['id'], $url);
            }

            $data['success'] = 'Data successfully inserted to database.';
        }

        echo json_encode($data);

    }

    public function ax_domestic_delivery_time(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];



        $country_iso = $this->security->xss_clean($this->input->post('country_iso'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));

        if(empty($country_iso) || empty($country_id)){
            return false;
        }

        if(!is_dir(FCPATH.'uploaded_documents/manage_price')){
            mkdir(FCPATH.'uploaded_documents/manage_price',0775, TRUE);
        }
        $dir_url=FCPATH.'uploaded_documents/manage_price/'.$country_iso.'/';
        if(!is_dir($dir_url)){
            mkdir($dir_url,0775, TRUE);
        }

        $config['upload_path'] = $dir_url;
        $config['allowed_types'] = 'csv';
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('doc') == false) {

            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data);
            return false;

        }

        $file_info = $this->upload->data();

        $date_val = date('Y-m-d H:i:s');

        $insert_data = [
            'country_id' => $country_id,
            'currier_id' => NULL,
            'type'       => 2,
            'name'       => 'Delivery Time',
            'file_name'  => $file_info['file_name'],
            'date'       => $date_val,
            'status'     => 0
        ];


        $file = $this->Manage_price_model->get_currier_files($country_id, 0, '2', 'Delivery Time');

        if(!$file_id = $this->Manage_price_model->insert_currier_file($insert_data)){

            $data['errors'][] = 'Error insert data to database.';
            unlink($dir_url.'/'.$file_info['file_name']);

        }

        $this->load->library('Csv_lib');
        $url = $dir_url.'/'.$file_info['file_name'];
        $result = $this->csv_lib->insert_domestic_delivery_time($url,$country_id);

        if(!empty($result['error'])){

            $data['errors'][] = $result['error'];
            $this->_delete_currier_file($file_id, $url);

        }else{

            if(!empty($file) && $file[0]['date'] != $date_val){
                $url = $dir_url.'/'.$file[0]['file_name'];
                $this->_delete_currier_file($file[0]['id'], $url);
            }

            $data['success'][] = 'Data successfully inserted to database.';
        }

        echo json_encode($data);

    }

    public function ax_delete_domestic_delivery_time(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['success'] = [];
        $data['errors'] = [];

        $name        = $this->security->xss_clean($this->input->post('name'));
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $country_iso = $this->security->xss_clean($this->input->post('country_iso'));

        if(empty($name)){

            $data['errors'][] = 'File not found.';
            echo json_encode($data);
            return false;
        }

        if(empty($country_id)){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        $url_path = 'uploaded_documents/manage_price/'.$country_iso.'/'.$name.'';

        $file = $this->Manage_price_model->get_currier_files($country_id, 0, '2', 'Delivery Time');

        $file_id = $file[0]['id'];
        $this->_delete_currier_file($file_id, $url_path);

        if(empty($data['errors'])){

            $data['success'][] = 'File removed successfully.';
        }

        echo json_encode($data);

    }

    public function ax_holidays_calendar(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $holidays        = $this->security->xss_clean($this->input->post('days'));

        if(empty($country_id)){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        if(empty($holidays)){

            $data['errors'][] = 'Please select days';
            echo json_encode($data);
            return false;
        }

        $holidays = explode(',', $holidays);

        foreach ($holidays as $days){

            if(!$this->valid->is_date($days)){

                $data['errors'][] = 'Incorrect  days';
                continue;
            }

            $batch_insert[] = [
                'country_id' => $country_id,
                'day' => $days

            ];
        }

        $crt = [

            'country_id' => $country_id
        ];

        $tablename = 'holidays_calendar';

        if(!$this->Manage_price_model->delete_batch_data($tablename,$crt)){

            $data['errors'][] = 'Error insert data to database.';
            echo json_encode($data);
        }

        if(!$this->Manage_price_model->data_batch_insert($tablename,$batch_insert)){

            $data['errors'][] = 'Error insert data to database.';
            echo json_encode($data);
        }

        if(empty($data['errors'])){

            $data['success'][] = 'Data successfully inserted to database.';
            echo json_encode($data);
        }


    }

    public function ax_dinamic_holidays_calendar(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];

        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $holidays        = $this->security->xss_clean($this->input->post('days'));

        if(empty($country_id)){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        if(empty($holidays)){

            $data['errors'][] = 'Please select days';
            echo json_encode($data);
            return false;
        }

        $holidays = explode(',', $holidays);

        foreach ($holidays as $days){

            if(!$this->valid->is_date($days,'m-d')){

                $data['errors'][] = 'Incorect  days';
                continue;
            }

            $batch_insert[] = [
                'country_id' => $country_id,
                'day' => $days

            ];
        }

        $crt = [

            'country_id' => $country_id
        ];

        $tablename = 'dinamic_calendar';

        if(!$this->Manage_price_model->delete_batch_data($tablename,$crt)){

            $data['errors'][] = 'Error insert data to database.';
            echo json_encode($data);
        }

        if(!$this->Manage_price_model->data_batch_insert($tablename,$batch_insert)){

            $data['errors'][] = 'Error insert data to database.';
            echo json_encode($data);
        }

        if(empty($data['errors'])){

            $data['success'][] = 'Data successfully inserted to database.';
            echo json_encode($data);
        }


    }

    public function ax_weekend_calendar(){

        if (!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->check_admin_login();

        $data['errors'] = [];
        $data['success'] = [];
        $country_id  = $this->security->xss_clean($this->input->post('country_id'));
        $mon  = $this->security->xss_clean($this->input->post('mon'));
        $tue  = $this->security->xss_clean($this->input->post('tue'));
        $wed  = $this->security->xss_clean($this->input->post('wed'));
        $thu  = $this->security->xss_clean($this->input->post('thu'));
        $fri  = $this->security->xss_clean($this->input->post('fri'));
        $sat  = $this->security->xss_clean($this->input->post('sat'));
        $sun  = $this->security->xss_clean($this->input->post('sun'));

        if(empty($country_id)){

            $data['errors'][] = 'Please select country';
            echo json_encode($data);
            return false;

        }

        $weekend_arr = [
            'mon'        => $mon,
            'tue'        => $tue,
            'thu'        => $thu,
            'fri'        => $fri,
            'sat'        => $sat,
            'sun'        => $sun,
            'wed'        => $wed,
            'country_id' => $country_id
        ];

        $result = $this->Manage_price_model->get_weekend($country_id);

        if(empty($result)){

            if(!$this->Manage_price_model->insert_weekend($weekend_arr)){

                $data['errors'][] = 'Error insert data to database.';
                echo json_encode($data);

            }

        }else{

            unset($weekend_arr['country_id']);

            if(!$this->Manage_price_model->update_weekend($weekend_arr,$country_id)){

                $data['errors'][] = 'Error insert data to database.';
                echo json_encode($data);

            }

        }

        if(empty($data['errors'])){

            $data['success'][] = 'All data succesfully saved.';
            echo json_encode($data);
        }
    }

    private function check_admin_login() {

        if(!$this->admin_security->is_admin()) {
            show_404();
            exit;
        }
    }

}
?>