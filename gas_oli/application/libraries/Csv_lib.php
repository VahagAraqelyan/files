<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csv_lib {

    private $CI;
    private $config;

    public function __construct()
    {

        $this->CI=get_instance();
        $this->init_config();

        $this->CI->load->model("Company_model");
        $this->CI->load->model("Well_model");

    }

    public function init_config() {

    }

    public function read_file($file_url,$delimiter = ',',$key_count = 6){

        if (($handle = fopen($file_url, "r")) === FALSE) {
            return false;
        }

        $full_arr = [];

        while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {

            if(count($data) == 1){
                $data = explode("|",$data[0]);
            }

            if(count($data) != $key_count){

                return false;
            }

          $full_arr[] = [
              'well_id'       =>  ltrim($data[0],','),
              'name'          =>  ltrim($data[1],','),
              'location'      =>  ltrim($data[2],','),
              'status'        =>  ltrim($data[3],','),
              'lat'           =>  ltrim($data[4],','),
              'lng'           =>  ltrim($data[5],','),
              'company_id'    =>  ltrim($data[6],','),
              'company_field' =>  ltrim($data[7],','),
              'comment'       =>  ltrim($data[8],','),
              'road_status'   =>  ltrim($data[9],','),
              'state_id'      =>  ltrim($data[10],',')
          ];
        }

        return $full_arr;
    }

    public function download_csv($download_arr,$delimiter = ','){

        if(empty($download_arr)){
            return false;
        }

        $url = FCPATH.'upload_image/download_csv';

        if (!file_exists($url)) {

            mkdir($url,0776, TRUE);
        }

        $fp = fopen($url.'/down_csv.csv', 'w');

        foreach ($download_arr as $index => $single){

            $company = $this->CI->Company_model->get_company_name_by_id($single['company_id']);
            $state   = $this->CI->Well_model->get_states_by_id($single['state_id']);

            if(!empty($company)){
                $single['company_id'] = $company;
            }

            if(!empty($state)){
                $single['state_id'] = $state['state'];
            }


            fputcsv($fp, $single,$delimiter);
        }

        fclose($fp);

        return $url.'/down_csv.csv';
    }
}
?>