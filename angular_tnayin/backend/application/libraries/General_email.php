<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_email
{

    private $CI;
    private $email_lib;

    public function __construct()
    {
        $this->CI = get_instance();

        $this->CI->load->config('general_email');

        $this->CI->load->library('email_lib');

    }

    /**
     * return email data
     *
     * @param $increment key
     * @param $data
     * @return array
     */

    public function send_email($inc_key, $data){

        if(empty($inc_key) || empty($data['email'])){

            return false;
        }

        $send_data = [];
        $return_data['suc_message'] = [];
        $return_data['err_message'] = [];

        if(empty($data['subject'])){

            $data['subject'] = $this->CI->config->item('default_subject');
        }

        if(!empty($data['variables'])){

            $send_data = $data['variables'];
            unset($data['variables']);

        }

        $config_info = $this->CI->config->item($inc_key);
        $send_data['title'] = $config_info['title'];

        $subject_description = $send_data['subject_description'];

        if(!empty($config_info['subject_description']) && empty($subject_description)){

            $subject_description = $config_info['subject_description'];

        }

        $data['from_name'] = '';

        if(!empty($config_info['from_name'])){

            $data['from_name'] = $config_info['from_name'];

        }

        if(!empty($config_info['attachment'])){

            $data['attachment'] = $config_info['attachment'];
        }

        $header_content = $this->get_email_header($subject_description);
        $main_content   = $this->CI->load->view('email_templates/'.$config_info['view'], $send_data, true);
        $footer_content = $this->get_email_footer();

        $body = $this->CI->load->view(
            'email_templates/main_template',
            [
                'header_content' => $header_content,
                'main_content'   => $main_content,
                'footer_content' => $footer_content
            ], true);

        $data['message'] = $body;

        $send = $this->CI->email_lib->sendgrid_email($data);

        return $send;
    }


    private function get_email_header($subject_description){

        $header_data=[
            'logo_image'          => base_url('assets/email-resources/logo.png'),
            'phone_image'         => base_url('assets/email-resources/phone.png'),
            'mail_image'          => base_url('assets/email-resources/mail.png'),
            'subject_description' => $subject_description
        ];

        return $this->CI->load->view('email_templates/header',$header_data, true);

    }

    private function get_email_footer(){

        $footer_data=[
            'twitter_image'   => base_url('assets/email-resources/twitter.png'),
            'fb_image'        => base_url('assets/email-resources/facebook.png'),
            'google_image'    => base_url('assets/email-resources/googleplus.png'),
            'pinterest_image' => base_url('assets/email-resources/pinterest.png')
        ];

        return $this->CI->load->view('email_templates/footer',$footer_data, true);

    }
}