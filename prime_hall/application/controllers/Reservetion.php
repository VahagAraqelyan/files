<?php
class Reservetion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservetion_model');

    }

    public function  ax_add_reservetion(){

        if(!$this->input->is_ajax_request()){
            show_404();
            return false;
        }

        $date        = $this->security->xss_clean($this->input->post('date'));
        $first_name  = $this->security->xss_clean($this->input->post('first_name'));
        $last_name   = $this->security->xss_clean($this->input->post('last_name'));
        $tel         = $this->security->xss_clean($this->input->post('tel'));
        $email       = $this->security->xss_clean($this->input->post('email'));
        $number_part = $this->security->xss_clean($this->input->post('number_part'));

        $data = [
            'success' => '',
            'errors' => []
        ];

        $status = 1;

        if(strtotime(date('M-d-Y'))>strtotime($date)){

            $data['errors'][] = 'Այդ Օրը անցել է։ Խնդրում ենք նշել գործող ժամանակ';
            echo json_encode($data);
            return false;
        }

        $reserve = $this->Reservetion_model->get_reservetion(['date'=>$date],true);

        if(empty($reserve)){

            $status = 2;
        }

        $insert_data = [
            'date'        =>   $date,
            'first_name'  =>   $first_name,
            'last_name'   =>   $last_name,
            'tel'         =>   $tel,
            'email'       =>   $email,
            'status'      =>   $status,
            'number_part' =>   $number_part,
        ];

        if(!$this->Reservetion_model->add_reservetion($insert_data)){
            $data['errors'][]  = 'Տվյալները չեն պահմանվել խնդրում ենք փորձել կրկին';

        }

        $data['success'][] = 'Շնորհակալություն ձեր Հայտը հաջողությամբ ուղարկվեց։ Մեր ադմինիստրատորները կկապնվեն ձեր հետ։';

        $this->load->library('email_lib');

        $email_data['subject'] = 'Նոր Ամրագրում '.$first_name.' '.$last_name.' կողմից';
        $email_data['subject_description'] = 'Նոր Ամրագրում '.$first_name.' '.$last_name.' կողմից';
        $email_data['email'] = $email;
        $email_data['to_name'] = 'User';
        $body = '
                    <p>'.$first_name.' '.$last_name.'</p>
                    <p>Հեռ․ '.$tel.'</p>
                    <p>Էլ Հասցե '.$email.'</p>
                    <p>Մասնակիցների քանակ '.$number_part.'</p>
                ';

        $email_data['message'] = $body;

        $send = $this->email_lib->sendgrid_email($email_data);

        echo json_encode($data);
    }

    public function get_reservetion(){

        $this->check_admin_login();

        $data['content'] = 'admin/reservetion/main';

        $this->load->view('admin/back_template',$data);
    }

    public function ax_get_all_reservetion(){

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
        $name_cr = [];
        $cr = [];

        if($type == 'first_name' && !empty($search_type)){

            $search_type = explode(" ",$search_type);

            if(count($search_type) == 1){

                $lastname = '';
            }else{

                $lastname = $search_type[1];
            }

            $name_cr = [
                0 => $search_type[0],
                1 => $lastname
            ];

        }else{

            $cr = [
                $type =>$search_type
            ];
        }
;
        $asc_desc = $this->input->post('order');

        $limit = [10,0];

        $start = $this->input->post('start');
        $length = $this->input->post('length');

        if(!empty($start) || !empty($length)){

            $limit = [$length,$start];
        }

        $colums = [

            1 => 'first_name',
            2 => 'last_name',
            4 => 'email',
            5 => 'date',
            6 => 'number_part',
            7 => 'status'
        ];

        if(!empty($ordering)){

            $ordering = [
                $colums[$asc_desc[0]['column']],
                $asc_desc[0]['dir']
            ];

        }else{
            $ordering = ['first_name', 'ASC'];
        }

        $all_count = $this->Reservetion_model->get_all_reservetion_count($cr,$name_cr);

        $all_reservetion = $this->Reservetion_model->get_all_reservetion($limit,$cr,$ordering,$name_cr);

        if(empty($all_reservetion)){

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

        foreach ($all_reservetion as $index => $single){

            $return_data['data'][] = [
                $index+1,
                $single['first_name'],
                $single['last_name'],
                $single['tel'],
                $single['email'],
                $single['date'],
                $single['number_part'],
                $status_arr[$single['status']],
            ];
        }

        $return_data['draw'] = $this->input->post('draw');
        $return_data['recordsTotal'] = $all_count;
        $return_data['recordsFiltered'] = $all_count;

        echo json_encode($return_data);
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