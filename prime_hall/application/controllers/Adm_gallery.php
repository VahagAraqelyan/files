<?php
class Adm_gallery extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gallery_model');
    }


    public function index(){
        $this->check_admin_login();
        $this->gallery_type();
    }

    public function gallery_type(){

        $this->check_admin_login();

        $data['image_types'] =  $this->Gallery_model->get_gallery_type();

        $data['content'] = 'admin/gallery/main_gallery_type';

        $this->load->view('admin/back_template',$data);
    }

    public function add_gallery($id = null){

        $this->check_admin_login();

        if(empty($id)){
            show_404();
            return false;
        }

        $image_types =  $this->Gallery_model->get_gallery_type(['id' => $id]);

        if(empty($image_types)){
            show_404();
            return false;
        }

        $data['images'] = $this->Gallery_model->get_gallery_image(null,['image_type'=>$id]);
        $data['id']     = $id;

        $data['content'] = 'admin/gallery/main';

        $this->load->view('admin/back_template',$data);

    }

    public function upload_file(){

        $this->check_admin_login(true);

        $type_id  = $this->security->xss_clean($this->input->post('type_id'));

        $this->load->helper('string');

        $data = [
            'errors'  => [],
            'success' => '',
            'info'    => []
        ];

        $file_name = time().random_string('alnum', 4);


        $config['upload_path']          = 'tmp';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = $file_name;
        $config['max_size']             = 13000;
        $config['max_width']            = 8000;
        $config['max_height']           = 8000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
        {
            $data['errors'][] = $this->upload->display_errors();
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $file_info = $this->upload->data();

        $insert_data = [
            'name'       => $file_info['orig_name'],
            'image_type' => $type_id
        ];

        if(!$id = $this->Gallery_model->add_gallery_image($insert_data)){

            $data['errors'][] = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $data['info']['id'] = $id;

        echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);

    }

    public function ax_remove_image(){

        $this->check_admin_login(true);

        $id  = $this->security->xss_clean($this->input->post('id'));

        if(empty($id)){

            $data['errors'][] = 'Undefined item.';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $images = $this->Gallery_model->get_gallery_image($id);

        if(empty($images)){
            $data['errors'][] = 'Undefined item.';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $file_url = FCPATH."tmp/".$images[0]['name'];
      
        if(file_exists($file_url) && !is_dir($file_url)){

            unlink($file_url);
        }

        $this->Gallery_model->delete_gallery_image($id);
    }

    private function check_admin_login($ajax = false) {

        if($ajax){

            if(!$this->input->is_ajax_request()){
                show_404();
                return false;
            }
        }

        if(!$this->admin_security->is_admin()) {
            redirect(base_url('admin-panel'), 'refresh');
            exit;
        }

    }


}