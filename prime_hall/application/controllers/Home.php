<?php
class Home extends CI_Controller
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

        $this->home();
    }

    public function home(){

        $data['content'] = 'frontend/'.$this->language.'/home';

        $offer_cr = ['status' =>1,'offer_'.$this->language.'<>'=>' ','title_'.$this->language.'<>'=>' '];
        $ordering = ['id','ASC'];

        $data['offer'] = $this->Offer_model->get_offer($offer_cr,$ordering);
        $data['gallery'] = $this->Gallery_model->get_gallery_image(null,['image_type'=>1]);

        $this->load->view('frontend/site_main_template',$data);
    }

    public function single_offer($id=NULL){

        if(empty($id)){

            show_404();
        }

        $offer_cr = ['id'=>$id,'status' =>1,'offer_'.$this->language.'<>'=>' ','title_'.$this->language.'<>'=>' '];
        $ordering = ['id','ASC'];
        $offer = $this->Offer_model->get_offer($offer_cr,$ordering);

        if(empty($offer)){
            show_404();
        }

        $data['offer'] = $this->Offer_model->get_single_offer($id);
        $data['text']  = 'offer_'.$this->language.'';

        $data['content'] = 'frontend/'.$this->language.'/single_offer';

        $this->load->view('frontend/site_main_template',$data);
    }

    public function ax_show_menu(){

        if(!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $data['height'] = $this->security->xss_clean($this->input->post('height'));
        $crt = ['name_'.$this->language.'<>'=>' '];
        $data['food_type'] = $this->Menu_model->get_food_type(1,$crt);

        foreach ($data['food_type'] as $index => $single){

            $data['food_type'][$index]['children'] = $this->Menu_model->get_menu_by_food_id($single['id'],1,$crt);
        }

        $this->load->view('frontend/am/show_menu',$data);
    }

    public function about_us(){

        $data['content'] = 'frontend/'.$this->language.'/about_us';

        $this->load->view('frontend/site_main_template',$data);
    }

    public function contact_us(){

        $data['content'] = 'frontend/'.$this->language.'/contact_us';

        $this->load->view('frontend/site_main_template',$data);
    }


    public function ax_send_message(){

        if(!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $this->load->library('email_lib');
        $body = '';

        $name      = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name = trim($this->security->xss_clean($this->input->post('last_name')));
        $email     = trim($this->security->xss_clean($this->input->post('email')));
        $our_text  = trim($this->security->xss_clean($this->input->post('our_text')));

        $data['subject'] = 'Նոր Առաջարկ '.$name.' '.$last_name.' կողմից';
        $data['subject_description'] = 'Նոր Առաջարկ '.$name.' '.$last_name.' կողմից';
        $data['email'] = $email;
        $data['to_name'] = 'User';
        $data['variables'] = [
            'first_name' => $name,
            'last_name'  => $last_name,
            'email'      => $email,
            'our_text'   => $our_text,
            'title'   => 'Նոր Առաջարկ '.$name.' '.$last_name.' կողմից',
        ];

        $body = 'aaa';

        $data['message'] = $body;

        $send = $this->email_lib->sendgrid_email($data);

        echo json_encode(true);
    }
}
?>