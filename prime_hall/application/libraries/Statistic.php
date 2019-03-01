<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Statistic {

    private $CI;

    public function __construct(){

        $this->CI=get_instance();
        $this->CI->load->model('Statistic_model');
    }


    public function insert_statistic(){

       $server = $this->CI->input->server();

       if(empty($server)){

           return false;
       }

        $user_ip = $server['REMOTE_ADDR'];

        $date_now = date("Y-m-d");

        $user_check = $this->CI->Statistic_model->get_user_statistic(['date' =>$date_now,'ip'=>$user_ip]);

        if(!empty($user_check)){
            return false;
        }

        //$country = $this->get_country_by_ip($user_ip);


        $insert_data1 = [
            'date'     => $date_now,
            'ip'       => $user_ip
        ];

      $date_count = $this->CI->Statistic_model->get_user_statistic_count($date_now);

      if(!empty($date_count)){

          $result2 =  $this->CI->Statistic_model->update_user_statistic_count(['count' => $date_count['count']+1],$date_now);

      }else{
          $insert_data2 = [
              'count' => $date_count+1,
              'date'  => $date_now
          ];
          $result2 =  $this->CI->Statistic_model->insert_user_statistic_count($insert_data2);
      }



        $date1 =  date('Y-m-d H:i:s',strtotime("-1 month"));


        $result1 =  $this->CI->Statistic_model->insert_user_statistic($insert_data1);


        $this->delete_old_user_statistic($date1);
    }

    public function delete_old_user_statistic($date){

        if(empty($date)){

            return false;
        }

        $this->CI->Statistic_model->delete_old_user_statistic($date);
    }

    public function get_country_by_ip($ip){

        if(empty($ip)){

            return false;
        }

        $url = 'http://api.ipstack.com/'.$ip.'?access_key=40cdd0d4f21f3712207e10399e739e13';

        $respons = [];

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 5,        // timeout on connect
            CURLOPT_TIMEOUT        => 5,        // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );

        $content = json_decode($content);

        if(empty($content) || empty($content->country_name)){
            return false;
        }

        return $content->country_name;
    }
}