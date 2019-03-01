<?php
class Gallery extends CI_Controller
{
    private $language = false;

    public function __construct()
    {
        parent::__construct();
        $this->language = $this->language_lib->switch_language();
        $this->load->model('Menu_model');
        $this->load->model('Offer_model');
        $this->load->model('Gallery_model');
    }

    public function index(){

        $this->gallery();
    }

    public function gallery(){

        $data['content'] = 'frontend/'.$this->language.'/gallery';

        $data['gallery'] = $this->Gallery_model->get_gallery_image(NULL,['image_type'=>2]);

        $this->load->view('frontend/site_main_template',$data);
    }
}