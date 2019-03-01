<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Google_api
{
    public function __construct(){

        $this->CI = get_instance();

    }

    //private $key      = 'AIzaSyAkN75HQ0wpAJEQ73M3hlsh2KEZkS2AnOo';
    private $key      = 'AIzaSyAWtXklsLFYNVaShBJSeJeFFYO0ygCq4_Y';
    private $request_limit = '2';

    public function get_staate_by_latlng($lat,$lng){

        if(empty($lat) || empty($lng)){
            return false;
        }

        $lat =  str_replace(',','.',$lat);
        $lng =  str_replace(',','.',$lng);

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false&key='.$this->key;

        $result = $this->get_web_page($url);
        $result = json_decode($result['content'], true);

        $return_arr = [];

        if(empty($result)){

            return false;
        }

        foreach ($result['results'] as $single){

            $return_arr[] = $single['address_components'][0];
        }

        if($result['status'] !== 'OK'){
         return false;
        }


        return $return_arr;
    }

    public function calculate_distance($lat1, $lon1, $lat2, $lon2){

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) *sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515 * 1.2073;

        return number_format($miles, 2, '.', '');

    }

    public function get_distance($lat1, $lon1,$destinations) {

        $limit = $this->request_limit;

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$lat1.','.$lon1.'&destinations='.$destinations.'&key='.$this->key;


        $result = $this->get_web_page($url);
        $result = json_decode($result['content'], true);

       /* var_dump($result['rows'][0]['elements']);*/

        if($result['status'] !== 'OK'){

            $debugging['error'] = $result;
            $this->log_error($debugging);
            return false;
        }

        $new_well = [];
        $min_well = [];

        foreach ($result['rows'][0]['elements'] as $index => $val){

            if(empty($val['distance']) || empty($val['distance']['value'])){
                continue;
            }

            $new_well[] = $val['distance']['value'];
        }

        $min = min($new_well);

        $key = array_keys($new_well,$min);

        $min_well[$key[0]] = $min;

        return $min_well;

    }

    public function log_error($data){

        $url = FCPATH.'google_log.html';
        $caller = 'Error';
        $data = '<pre>'.var_export($data, true).'</pre>';

    }

    public function google_map_search($search){

        $src = 'https://www.google.com/maps/embed/v1/search?q='.$search.'&key='.$this->key;
        return $src;

    }

    public function get_web_page( $url )
    {
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
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
}