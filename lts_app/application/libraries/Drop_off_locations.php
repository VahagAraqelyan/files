<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Drop_off_locations {

    private $CI;

    public function __construct()
    {

        $this->CI = get_instance();

    }

    public function get_fedex_locations($radius, $zipcode){

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <markers>';

        $url = "https://www.shipsticks.com/api/beta/store_locator/search?zip_code=$zipcode&radius=$radius&carrier=fedex";

        $response = $this->get_web_page($url);

        if(empty($response['content'])){
            return false;
        }

        if(!$data_points_object = json_decode($response['content'])){
            return false;
        }

        $data_points_object = $data_points_object->data;

        if(empty($data_points_object)){
            return false;
        }

        $info = [];

        foreach($data_points_object as $single){

            if(empty($single->latitude) || empty($single->longitude)){
                continue;
            }

            $single_marker = '<marker 
            name="'.$single->name.'" 
            address="'.$single->address_line.' '.$single->city.' '.$single->state.' '.$single->zip_code.'" 
            type="fedex" 
            lat="'.$single->latitude.'" 
            lng="'.$single->longitude.'" 
            phone="'.$single->phone_number.'" 
            distance="'.$single->distance.'" 
            last_pickup_orange="'.$single->pickup_time.'" 
            last_pickup_green="'.$single->ground_pickup_time.'" 
            />';

            $xml.= $single_marker;

            $info[] = [
                'name'     => $single->name,
                'phone'    => $single->phone_number,
                'street'   => $single->address_line,
                'city'     => $single->city,
                'state'    => $single->state,
                'dist'     => $single->distance,
                'zip_code' => $single->zip_code,
                'time_gr'  => 'Last Pickup ' . $single->pickup_time,
                'time_ai'  => 'Last Pickup ' . $single->ground_pickup_time
            ];

        }

        $xml.="</markers>";

        return array( 'xml' => $xml, 'info' => $info );

    }



    private function get_web_page($url, $method = "get"){

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

        if(strtolower($method) == 'post'){
            $options[CURLOPT_POST] = 1;
        }

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