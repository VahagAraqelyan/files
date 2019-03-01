<?php
class Offer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Offer_model');
    }

    public function get_all_offer(){

        $this->check_admin_login();

        $data['content'] = 'admin/offer';

        $this->load->view('admin/back_template',$data);
    }

    public function ax_get_all_offer(){

        $this->check_admin_login(true);

        $page = trim($this->security->xss_clean($this->input->post('page')));
        $type = trim($this->security->xss_clean($this->input->post('type')));
        $search_type = trim($this->security->xss_clean($this->input->post('searching_type')));
        $ordering = $this->security->xss_clean($this->input->post('order'));
        $limit = $this->security->xss_clean($this->input->post('length'));

        if(empty($page)){

            $page = 1;
        }

        $return_data = [];
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
            3 => 'status',
        ];

        if(!empty($ordering)){

            $ordering = [
                $colums[$asc_desc[0]['column']],
                $asc_desc[0]['dir']
            ];

        }else{
            $ordering = ['first_name', 'ASC'];
        }

        $all_count = $this->Offer_model->get_all_offer_count($cr);

        $all_offers = $this->Offer_model->get_all_offer($limit,$cr,$ordering);

        if(empty($all_offers)){

            $all_count = 0;
            $return_data['recordsTotal'] = 0;
            $return_data['recordsFiltered'] = 0;

            $return_data['data'] = [];
            echo json_encode($return_data);
            return false;
        }

        $status_arr = [
            '1' => 'Այո',
            '2' => 'Ոչ',
        ];


        foreach ($all_offers as $index => $single){

            if(!empty($single['offer_am']) && strlen($single['offer_am']) > 100){
                $sing_offer_am =  substr($single['offer_am'],0,100).' '.'<a href="#" class="paragraph_desc_view" data-lang="am" data-id="'.$single['id'].'">... View more</a>';
            }else{
                $sing_offer_am = $single['offer_am'];
            }

            if(!empty($single['offer_ru']) && strlen($single['offer_ru']) > 100){
                $sing_offer_ru =  substr($single['offer_ru'],0,100).' '.'<a href="#" class="paragraph_desc_view" data-lang="ru" data-id="'.$single['id'].'">... View more</a>';
            }else{
                $sing_offer_ru = $single['offer_ru'];
            }

            if(!empty($single['offer_en']) && strlen($single['offer_en']) > 100){
                $sing_offer_en =  substr($single['offer_en'],0,100).' '.'<a href="#" class="paragraph_desc_view" data-lang="en" data-id="'.$single['id'].'">... View more</a>';
            }else{
                $sing_offer_en = $single['offer_en'];
            }

            $return_data['data'][] = [
                $index+1,
                $sing_offer_am,
                $sing_offer_ru,
                $sing_offer_en,
                $single['title_am'],
                $single['title_ru'],
                $single['title_en'],
                $status_arr[$single['status']],
                '<img src="'.base_url('image_upload/offers/').$single['image'].'" alt="" class="min_image">',
                '<div class="tools">
                   <i data-id="'.$single['id'].'" class="fa fa-edit edit_delete_icon edit_offer"></i>
                   <i data-id="'.$single['id'].'" class="fa fa-trash-o edit_delete_icon delete_offer"></i>
                 </div>',
            ];
        }

        $return_data['draw'] = $this->input->post('draw');
        $return_data['recordsTotal'] = $all_count;
        $return_data['recordsFiltered'] = $all_count;

        echo json_encode($return_data);
    }

    public function ax_get_single_offer(){

        $this->check_admin_login(true);

        $id = trim($this->security->xss_clean($this->input->post('id')));

        $data = [
            'errors'  => [],
            'info'    => []
        ];

        $offer_data = $this->Offer_model->get_single_offer($id);

        if(empty($offer_data)){

            $data['errors'][] = 'sxal';
            echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
            return false;
        }

        $data['info'] = $offer_data;

        $this->load->view( 'admin/offer_answer',$data);
    }

    public function ax_add_offer(){

        $this->check_admin_login(true);

        $title_am      = trim($this->security->xss_clean($this->input->post('title_am')));
        $title_ru      = trim($this->security->xss_clean($this->input->post('title_ru')));
        $title_en      = trim($this->security->xss_clean($this->input->post('title_en')));
        $offer_am      = trim($this->security->xss_clean($this->input->post('offer_am')));
        $offer_ru      = trim($this->security->xss_clean($this->input->post('offer_ru')));
        $offer_en      = trim($this->security->xss_clean($this->input->post('offer_en')));
        $editable      = trim($this->security->xss_clean($this->input->post('editable')));
        $up_file       = trim($this->security->xss_clean($this->input->post('up_file')));
        $status_check  = trim($this->security->xss_clean($this->input->post('status_check')));
        $offer_id      = trim($this->security->xss_clean($this->input->post('offer_id')));

        $data = [
            'errors'  => [],
            'success' => '',
            'info'    => []
        ];

        if($editable && empty($offer_id)){
            $data['errors'][] = 'Տվյալները չեն պահպանվել';
            echo json_encode($data);
            return false;
        }

        $file_info = [];

        $this->load->helper('string');

        $file_name = time().random_string('alnum', 4);

        $config['upload_path']          = 'image_upload/offers';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = $file_name;
        $config['max_size']             = 13000;
        $config['max_width']            = 8000;
        $config['max_height']           = 8000;

        if(($editable == 'true' && $up_file == 'true') || !$editable){

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('upload_file'))
            {
                $data['errors'][] = $this->upload->display_errors();
                echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
                return false;
            }

            $file_info = $this->upload->data();

            if(!$editable){

                $insert_data = [
                    'title_am'   =>  $title_am,
                    'title_ru'   =>  $title_ru,
                    'title_en'   =>  $title_en,
                    'offer_am'   =>  $offer_am,
                    'offer_ru'   =>  $offer_ru,
                    'offer_en'   =>  $offer_en,
                    'image'      => $file_info['orig_name'],
                    'status'     => 1,
                ];

                if(!$this->Offer_model->add_new_offer($insert_data)){

                    $data['errors'][] = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';
                    echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
                    return false;
                }

            }
        }

        $update_data = [
            'title_am'   =>  $title_am,
            'title_ru'   =>  $title_ru,
            'title_en'   =>  $title_en,
            'offer_am'   =>  $offer_am,
            'offer_ru'   =>  $offer_ru,
            'offer_en'   =>  $offer_en,
            'status'     => $status_check,
        ];

        if(!empty($file_info)){

            $offer_data = $this->Offer_model->get_single_offer($offer_id);

            $file_url = FCPATH."image_upload/offers/".$offer_data['image'];

            if(file_exists($file_url) && !is_dir($file_url)){

                unlink($file_url);
            }


            $update_data['image'] = $file_info['orig_name'];
        }

        if($editable){

            $this->Offer_model->update_data($update_data,['id'=>$offer_id]);
        }

        echo json_encode($data, JSON_HEX_APOS|JSON_HEX_QUOT);
    }

    public function ax_delete_offer(){

        $this->check_admin_login(true);

        $offer_id      = trim($this->security->xss_clean($this->input->post('id')));

        if(empty($offer_id)){
            $data['errors'][] = 'Տվյալները չեն պահպանվել';
            echo json_encode($data);
            return false;
        }

        $offer_data = $this->Offer_model->get_single_offer($offer_id);

        $file_url = FCPATH."image_upload/offers/".$offer_data['image'];

        if(file_exists($file_url) && !is_dir($file_url)){

            unlink($file_url);
        }

        $this->Offer_model->delete_offer($offer_id);

        echo json_encode(true);

    }

    public function view_offer(){

        $this->check_admin_login(true);

        $offer_id     = trim($this->security->xss_clean($this->input->post('id')));
        $data['lang'] = trim($this->security->xss_clean($this->input->post('lang')));


        $data['offer_data'] = $this->Offer_model->get_single_offer($offer_id);

        $this->load->view( 'admin/view_offer_answer',$data);
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