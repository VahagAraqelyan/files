<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: GEVOR
 * Date: 19/03/2017
 * Time: 3:18 PM
 */

class Price_lib
{

    private $CI;

    public function __construct()
    {

        $this->CI = get_instance();
        $this->CI->load->model("Users_model");
        $this->CI->load->model("Home_model");
        $this->CI->load->model("Luggage_model");
        $this->CI->load->model("Check_price_model");
        $this->CI->load->model("Manage_price_model");
        $this->CI->load->model("Order_model");
        $this->CI->load->model("Billing_model");
        $this->CI->config->load('check_price');

    }

    public function shipping_data_from_cookie(){

        if(empty($this->CI->input->cookie('order'))){
            return false;
        }

        $product_arr = json_decode($this->CI->input->cookie('order'),true);

        if(empty($product_arr['shipping_date']) || empty($product_arr['country_from']) || empty($product_arr['country_to'])){
            return false;
        }

        $return_data['country_from'] = $product_arr['country_from'];
        $return_data['country_to']   = $product_arr['country_to'];
        $return_data['city_from']    = '';
        $return_data['city_to']      = '';

        if(!empty($product_arr['city_from'])){
            $return_data['city_from'] = $product_arr['city_from'];
        }

        if(!empty($product_arr['city_to'])){
            $return_data['city_to'] = $product_arr['city_to'];
        }

        $return_data['date'] = $product_arr['shipping_date'];
        $return_data['special'] = $product_arr['special'];
        $return_data['luggages'] = [];

        if(!empty($product_arr['luggage'])){

            foreach ($product_arr['luggage'] as $kay => $prod_count){

                $prod = explode('_',$kay);

                if(count($prod) != 2){
                    return false;
                }

                $prod_id =$prod[1];

                $product = $this->CI->Luggage_model->get_luggage_by_id($prod_id);

                if(empty($product)){
                    continue;
                }

                $return_data['luggages'][$prod_id] = $prod_count;

            }
        }


        return $return_data;
    }

    public function price_types_data(){

        if(empty($this->CI->input->cookie('order'))){
            return false;
        }

        $product_arr = json_decode($this->CI->input->cookie('order'),true);

        $data_prod = [];

        if(!empty($product_arr['luggage'])){

            foreach ($product_arr['luggage'] as $kay => $products){

                $prod_name = explode('_',$kay);
                if(count($prod_name) != 2){

                    return false;
                }

                $type = $this->CI->Luggage_model->get_luggage_types($prod_name[0]);
                $prod = $this->CI->Luggage_model->get_luggage_by_id($prod_name[1]);

                if(empty($data_prod[$type[0]['type_name']]['image'])){
                    $data_prod[$type[0]['type_name']]['image'] = $type[0]['image_class'];
                }

                $data_prod[$type[0]['type_name']][$prod['luggage_name']] = $products;

            }
        }

        $count = 0;
        foreach ($product_arr['special'] as $special_size){

            if(!empty($special_size)){

                $count += $special_size['count'];
                $data_prod['Boxes']['image'] = 'icon-box';
                $data_prod['Boxes']['Special Boxes'] = $count;

            }
        }

       return $data_prod;
    }


    public function _domestic_shipping($country_id, $zip_code_1, $zip_code_2, $date, $luggages, $special_boxes){

        if(!$this->CI->valid->is_id($country_id)){
            return false;
        }

        $zip_code_1 = preg_replace('/[^0-9]+/', '', $zip_code_1);
        $zip_code_2 = preg_replace('/[^0-9]+/', '', $zip_code_2);

        if(empty($zip_code_1) || empty($zip_code_2)){
            return false;
        }

        $country_info = $this->CI->Users_model->get_countries($country_id);

        if(empty($country_info)){
            return false;
        }

        $country_info = $country_info[0];

        $distance_info = $this->get_domestic_distance_and_zone($country_info, $zip_code_1, $zip_code_2);

        $zone = $distance_info['zone'];
        $days = $distance_info['days'];

        $luggages_id = array_keys($luggages);

        $weight_country = $this->CI->Check_price_model->get_charge_weight($country_info['id'], $luggages_id);

        $weight = [];
        $total_weight = 0;
        $total_count = 0;

        foreach($luggages as $id => $count){

            $total_count += $count;

            if(!empty($weight_country[$id])){

                if(isset($weight[$weight_country[$id]])){

                    $weight[$weight_country[$id]] += intval($count);
                }else{

                    $weight[$weight_country[$id]] = intval($count);
                }

            }

        }

        $special_boxes = $this->_get_special_box_fee($special_boxes, 'domestic', $country_id);

        if(!empty($special_boxes)){

            foreach($special_boxes['weight_array'] as $box_weight => $box_count){

                if(isset($weight[$box_weight])){

                    $weight[$box_weight] += $box_count;
                }else{

                    $weight[$box_weight] = $box_count;
                }

            }

            $total_count += $special_boxes['total_count'];
            $total_weight +=  $special_boxes['total_weight'];
            $additional_weight = $special_boxes['special_box_add_weight'];

        }else{
            $additional_weight = NULL;
        }

        $domestic_fee = $this->_get_domestic_fee($country_id, $luggages);
        $price_table_name = strtolower($country_info['iso2'].'_domestic');

        if(!$this->CI->Home_model->table_exists($price_table_name)){
            return false;
        }

        $business_days_ex = $this->_get_business_days($date, $country_id, $country_id, ['sat']);
        $business_days = $this->_get_business_days($date, $country_id, $country_id);

        $data = [
            'country_id'           => $country_id,
            'price_table_name'     => $price_table_name,
            'processing_fee'       => $this->_get_processing_fee($country_id, $total_count),
            'domestic_basic_fee'   => $domestic_fee['domestic_basic'],
            'domestic_express_fee' => $domestic_fee['domestic_express'],
            'weight'               => $weight,
            'additional_weight'    => $additional_weight,
            'zone'                 => $zone,
            'business_days_ex'     => $business_days_ex,
            'business_days'        => $business_days,
            'day_count'            => $days,
            'special_boxes'        => $special_boxes
        ];

        $result = $this->_get_domestic_prices($data);

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function get_domestic_distance_and_zone($country_info, $zip_code_1, $zip_code_2){

        if($this->_check_hawaii_or_alaska($zip_code_1, $zip_code_2)){

            $zone = $this->_check_hawaii_or_alaska($zip_code_1, $zip_code_2);

        }elseif($zip_code_1 == $zip_code_2) {

            $zone = 1;
            $days = 1;
        }

        if(empty($zone)){

            $this->CI->load->library('Google_api');
            $distance = $this->CI->google_api->get_distance_by_zip($zip_code_1, $zip_code_2);

            if (empty($distance)) {
                return false;
            }

            $zone_and_days = $this->CI->Check_price_model->get_days_and_zone($country_info['id'], $distance);

            if(empty($zone_and_days)){
                return false;
            }

            $zone = $zone_and_days['zone'];
            $days = $zone_and_days['basic_delivery_days'];

        }elseif(empty($days)){

            $zone_and_days = $this->CI->Check_price_model->get_days_and_zone($country_info['id'], NULL, $zone);

            if(empty($zone_and_days)){
                return false;
            }

            $days = $zone_and_days['basic_delivery_days'];

        }

        $result = [
            'zone' => $zone,
            'days' => $days
        ];

        return $result;

    }

    public function _get_domestic_prices($data){

        $curriers = $this->CI->Manage_price_model->get_curriers();

        $prices = [];

        foreach($curriers as $currier){

            $shipping_data = $this->CI->Check_price_model->get_domestic_data($data['price_table_name'], $data['weight'], $currier['id'], $data['zone']);

            if(empty($shipping_data)){
                continue;
            }

            if(!empty($data['additional_weight'])){
                $added_weight_data = $this->CI->Check_price_model->get_domestic_data($data['price_table_name'], 'PLUS', $currier['id'], $data['zone']);
            }

            foreach($shipping_data as $send_type => $price){

                if(empty($price)){
                    continue;
                }

                $price_details['shipping_fee'] = $price;
                $price_details['saturday_delivery_fee'] = NULL;
                $price_details['oversize_fee'] = NULL;

                if(!empty($added_weight_data[$send_type])){

                    $add_weight_price = floatval($added_weight_data[$send_type]) * $data['additional_weight'];
                    $price = $price + $add_weight_price;
                    $price_details['shipping_fee'] += $add_weight_price;

                }

                $price += floatval($data['processing_fee']);
                $price_details['processing_fee'] = floatval($data['processing_fee']);

                $day = preg_replace('/[^0-9]+/', '', $send_type);
                $sat_logic = false;

                if(stripos($send_type, 'Basic') !== false){

                    $price += floatval($data['domestic_basic_fee']);
                    $price_details['special_handling'] = floatval($data['domestic_basic_fee']);

                    if(!empty($data['special_boxes'])){

                        $price_details['shipping_fee'] += floatval($data['special_boxes'][$currier['currier_name']]['domestic_basic']) - $data['special_boxes'][$currier['currier_name']]['surcharge'] - $data['special_boxes'][$currier['currier_name']]['special_basic'];
                        $price_details['special_handling'] += $data['special_boxes'][$currier['currier_name']]['special_basic'];
                        $price = $price + floatval($data['special_boxes'][$currier['currier_name']]['domestic_basic']);

                    }

                    $day = $data['day_count'];

                    $send_type = str_replace('*', $day, $send_type);

                }else{

                    $price += floatval($data['domestic_express_fee']);
                    $price_details['special_handling'] = floatval($data['domestic_express_fee']);

                    if(!empty($data['special_boxes'])) {

                        $price_details['shipping_fee'] += floatval($data['special_boxes'][$currier['currier_name']]['domestic_express']) - $data['special_boxes'][$currier['currier_name']]['surcharge'] - $data['special_boxes'][$currier['currier_name']]['special_express'];
                        $price_details['special_handling'] += $data['special_boxes'][$currier['currier_name']]['special_express'];
                        $price = $price + floatval($data['special_boxes'][$currier['currier_name']]['domestic_express']);

                    }

                    if(date('D',strtotime($data['business_days_ex'][$day]['date'])) == 'Sat' && stripos($send_type, 'morning') !== false){

                        $sat_del = $this->CI->Check_price_model->get_sat_delivery($data['country_id']);
                        $sat_logic = true;
                    }

                }

                $prices[$currier['currier_name']][$send_type] = [
                    'price' => number_format($price, 2),
                    'logo'  => $currier['currier_logo'],
                    'zone'  => $data['zone']
                ];

                if(!empty($data['special_boxes'])) {
                    $price_details['oversize_fee'] = $data['special_boxes'][$currier['currier_name']]['surcharge'];
                }

                $prices[$currier['currier_name']][$send_type] = array_merge($prices[$currier['currier_name']][$send_type], $data['business_days'][$day]);

                $prices[$currier['currier_name']][$send_type]['price_details'] = $price_details;
                $prices[$currier['currier_name']][$send_type]['country'] = $data['country_id'];

                if($sat_logic){

                    $sat_tname = $send_type.'_+Sat';
                    $price += $sat_del;

                    $price_details['saturday_delivery_fee'] = $sat_del;

                    $prices[$currier['currier_name']][$sat_tname] = [
                        'price'         => number_format($price,2),
                        'logo'          => $currier['currier_logo'],
                        'price_details' => $price_details,
                        'country'       => $data['country_id'],
                        'zone'          => $data['zone']
                    ];

                    $prices[$currier['currier_name']][$sat_tname] = array_merge($prices[$currier['currier_name']][$sat_tname], $data['business_days_ex'][$day]);

                }

            }
        }

        if(empty($prices)){
            return false;
        }

        return $prices;
    }


    public function _international_shipping($country_from, $country_to, $date, $luggages, $special_boxes){

        $all_total_count = 0;

        if(!empty($special_boxes[1]['count'])){
            $all_total_count += $special_boxes[1]['count'];
        }

        if(!empty($special_boxes[2]['count'])){
            $all_total_count += $special_boxes[2]['count'];
        }

        if(!empty($special_boxes[3]['count'])){
            $all_total_count += $special_boxes[3]['count'];
        }

        if(!empty($luggages)){
            $all_total_count += array_sum($luggages);
        }

        if(!$this->CI->valid->is_id($country_from) || !$this->CI->valid->is_id($country_to)){
            return false;
        }

        $country1_info = $this->CI->Users_model->get_countries($country_from);
        $country2_info = $this->CI->Users_model->get_countries($country_to);

        if(empty($country1_info) || empty($country2_info)){
            return false;
        }

        $country1_info = $country1_info[0];
        $country2_info = $country2_info[0];

        $luggages_id = array_keys($luggages);

        $weight_country1 = $this->CI->Check_price_model->get_charge_weight($country1_info['id'], $luggages_id);
        $weight_country2 = $this->CI->Check_price_model->get_charge_weight($country2_info['id'], $luggages_id);

        $weight_from = 0;
        $weight_to = 0;
        $total_count = 0;

        foreach($luggages as $id => $count){
            $total_count += $count;

            if(!empty($weight_country1[$id])){
                $weight_from+=$weight_country1[$id]*$count;
            }
            if(!empty($weight_country2[$id])){
                $weight_to+=$weight_country2[$id]*$count;
            }

        }

        $box_info = $this->_special_box_changes($special_boxes);

        if(!empty($box_info)){
            $total_count += $box_info['total_count'];
            $weight_from += $box_info['total_weight'];
            $weight_to   += $box_info['total_weight'];
        }

        $check_result = $this->_check_international_data($country1_info, $country2_info, $weight_from, $weight_to);

        $special_boxes = $this->_get_special_box_fee($special_boxes, 'international', $check_result['main_country']['id'], $all_total_count);

        if(empty($check_result)){

            return false;
        }

        $processing_fee      = $this->_get_processing_fee($check_result['main_country']['id'], $total_count);
        $international_fee   = $this->_get_international_fee($check_result['main_country']['id'], $luggages, $all_total_count);
        $delivery_table_name = strtolower($check_result['main_country']['iso2']).'_international_delivery_time';
        $delivery_days       = $this->_get_delivery_days_inter($date, $check_result['main_country']['id'], $check_result['for_country']['id'], $delivery_table_name, $check_result['for_country']['iso2']);

        if(empty($delivery_days)){
            return false;
        }

        $data = [
            'for_country'       => $check_result['for_country'],
            'main_country'      => $check_result['main_country'],
            'type'              => $check_result['type'],
            'weight'            => $check_result['weight'],
            'additional_weight' => $check_result['additional_weight'],
            'delivery_days'     => $delivery_days,
            'processing_fee'    => $processing_fee,
            'international_fee' => $international_fee,
            'price_table'       => $check_result['table_name'],
            'special_boxes'     => $special_boxes
        ];

        $result = $this->_get_international_prices($data);

        if(empty($result)){
            return false;
        }

        return $result;

    }

    public function _get_international_prices($data){

        $for_country = $data['for_country'];

        $curriers = $this->CI->Manage_price_model->get_curriers();

        $prices = [];

        foreach($curriers as $currier){

            $shipping_data = $this->CI->Check_price_model->get_outbound_or_inbound_data($data['price_table'], $data['weight'], $data['type'], $currier['id'], $for_country['iso2']);

            if(empty($shipping_data)){
                continue;
            }

            if(!empty($data['additional_weight'])){
                $added_weight_data = $this->CI->Check_price_model->get_outbound_or_inbound_data($data['price_table'], 'PLUS', $data['type'], $currier['id'], $for_country['iso2']);
            }

            $special_fee = 0;
            $luggage_count = 0;
            $box_count = 0;

            if(!empty($data['international_fee'])){
                $special_fee   += $data['international_fee'][$currier['currier_name']];
                $luggage_count = $data['international_fee']['total_count'];
            }

            if(!empty($data['special_boxes'])){
                $special_fee   += $data['special_boxes'][$currier['currier_name'].'_special'];
                $box_count     = $data['special_boxes']['total_count'];
            }

            //$special_fee = max($special_fee);

            foreach($shipping_data as $send_type => $shipping_fee){

                if(empty($shipping_fee)){
                    unset($shipping_data[$send_type]);
                    continue;
                }

                $price = floatval($shipping_fee) + floatval($data['processing_fee']) + floatval($special_fee);

                $price_details['shipping_fee']          = floatval($shipping_fee);
                $price_details['processing_fee']        = floatval($data['processing_fee']);
                $price_details['special_handling']      = floatval($special_fee);
                $price_details['saturday_delivery_fee'] = NULL;
                $price_details['oversize_fee']          = NULL;

                if(!empty($added_weight_data[$send_type])){

                    $price = $price + floatval($added_weight_data[$send_type]) * $data['additional_weight'];
                    $price_details['shipping_fee'] += floatval($added_weight_data[$send_type]) * $data['additional_weight'];
                }

                if(!empty($data['special_boxes'])){

                    $price = $price + floatval($data['special_boxes'][$currier['currier_name']]);
                    $price_details['oversize_fee'] = $data['special_boxes'][$currier['currier_name'].'_surcharge'];

                }

                $shipping_data[$send_type] = [
                    'price'         => number_format($price, 2),
                    'logo'          => $currier['currier_logo'],
                    'price_details' => $price_details,
                    'country'       => $data['main_country']['id']
                ];

                if(!empty($data['delivery_days'][$send_type])){
                    $shipping_data[$send_type] = array_merge($shipping_data[$send_type], $data['delivery_days'][$send_type]);
                }


            }

            $prices[$currier['currier_name']] = $shipping_data;

        }

        return $prices;

    }


    public function _check_international_data($country1_info, $country2_info, $weight_from, $weight_to){

        if($weight_from > 150){
            $additional_weight = $weight_from - 150;
            $weight = 150;
        }else{
            $weight = $weight_from;
            $additional_weight = NULL;
        }

        $table_name = strtolower($country1_info['iso2']).'_international_price';

        if($this->CI->Home_model->table_exists($table_name) && $this->CI->Check_price_model->check_outbound_or_inbound_data($table_name, $weight, 'outbound', $country2_info['iso2'])){
            return [
                'table_name' => $table_name,
                'main_country' => $country1_info,
                'type' => 'outbound',
                'for_country' => $country2_info,
                'additional_weight' => $additional_weight,
                'weight' => $weight
            ];
        }


        if($weight_to > 150){
            $additional_weight = $weight_to - 150;
            $weight = 150;
        }else{
            $weight = $weight_to;
            $additional_weight = NULL;
        }


        $table_name = strtolower($country2_info['iso2']).'_international_price';

        if($this->CI->Home_model->table_exists($table_name) && $this->CI->Check_price_model->check_outbound_or_inbound_data($table_name, $weight, 'inbound', $country1_info['iso2'])){
            return [
                'table_name' => $table_name,
                'main_country' => $country2_info,
                'type' => 'inbound',
                'for_country' => $country1_info,
                'additional_weight' => $additional_weight,
                'weight' => $weight
            ];
        }


        return false;

    }

    public function _get_delivery_days_inter($date, $country_id1, $country_id2, $table_name, $column){

        if(!$this->CI->Home_model->table_exists($table_name)){
            return false;
        }

        $delivery_days = $this->CI->Check_price_model->get_delivery_day($table_name, $column);

        $business_days = $this->_get_business_days($date, $country_id1,$country_id2);

        foreach($delivery_days as $key=>$val){
            $delivery_days[$key] = $business_days[$val];
            $delivery_days[$key]['count'] = $val;
        }

        return $delivery_days;

    }

    public function _get_business_days($date, $country_id1,$country_id2, $exceptions = NULL){

        $holidays = $this->CI->Check_price_model->get_holidays([$country_id1,$country_id2]);

        $weekend = $this->_get_weekend_days($country_id1, $country_id2);

        if(!empty($exceptions)){
            foreach($weekend as $index => $value){
                if(in_array($value, $exceptions)){
                    unset($weekend[$index]);
                }
            }
        }

        $dinamic = $this->CI->Check_price_model->get_dinamic_holidays([$country_id1,$country_id2]);

        $all_days = $this->_get_dates_in_range($date, 100);

        $business_days = [];

        foreach($all_days as $day){

            if(!empty($holidays) && in_array($day['date'], $holidays)){
                continue;
            }
            if(!empty($dinamic) && in_array(substr($day['date'], 5, 5), $dinamic)){
                continue;
            }
            if(!empty($weekend) && in_array($day['weekday'], $weekend)){
                continue;
            }

            $business_days[] = $day;
        }

        return $business_days;
    }

    public function _get_weekend_days($country_id1, $country_id2){

        if(!empty($week_days1 = $this->CI->Manage_price_model->get_weekend($country_id1))){
            $week_days1 = array_filter($week_days1[0]);
        }else{
            $week_days1 = [];
        }

        if(!empty($week_days2 = $this->CI->Manage_price_model->get_weekend($country_id2))){
            $week_days2 = array_filter($week_days2[0]);
        }else{
            $week_days2 = [];
        }

        $week_days = array_merge($week_days1, $week_days2);

        if(!empty($week_days)){
            unset($week_days['id']);
            unset($week_days['country_id']);
        }

        return array_keys($week_days);

    }

    public function _get_dates_in_range($start, $range){

        $begin = new DateTime($start);
        $end = new DateTime($start);
        $end->modify( '+'.($range+1).' day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        $return_array = [];

        foreach($daterange as $date){
            $return_array[]=[
                'date' => $date->format('Y-m-d'),
                'weekday' => strtolower($date->format('D'))
            ];
        }

        return $return_array;

    }

    public function _get_processing_fee($country_id, $count){

        $processing_fee = $this->CI->Manage_price_model->get_processing_fee($country_id);

        if(empty($processing_fee[0]['item_processing'])){
            $processing_fee = 0;
        }else{
            $processing_fee = $processing_fee[0]['item_processing']*$count;
        }

        return $processing_fee;

    }

    public function _get_international_fee($country_id, $luggages, $all_total_count = 0){

        $curriers_array = $this->CI->Manage_price_model->get_curriers();

        if(empty($curriers_array)){
            return false;
        }

        $luggages_id = array_keys($luggages);

        $total_count = array_sum(array_values($luggages));

        $fee_limits = $this->CI->config->item('international_fee_limit');

        foreach($curriers_array as $single){

            $luggages_fee = $this->CI->Check_price_model->get_international_fee($country_id, $single['id'], $luggages_id);

            $fee = 0;

            foreach($luggages_id as $single_lug){

                foreach($fee_limits as $fee_limit){

                    if($all_total_count >=  $fee_limit['from'] && $all_total_count <=  $fee_limit['to']){

                        if(!empty($luggages_fee[$single_lug][$fee_limit['column']])){
                            $fee += $luggages[$single_lug]*$luggages_fee[$single_lug][$fee_limit['column']];
                        }

                        break;
                    }
                }

            }

            $return_array[$single['currier_name']] = $fee;

        }

        $return_array['total_count'] = $total_count;

        return $return_array;

    }


    public function _get_domestic_fee($country_id, $luggages){

        $luggages_id = array_keys($luggages);

        $luggages_fee = $this->CI->Check_price_model->get_domestic_fee($country_id, $luggages_id);

        $express_fee = 0;
        $basic_fee = 0;

        foreach($luggages as $lug_id => $count){

            if(!empty($luggages_fee[$lug_id]['domestic_express'])){
                $express_fee += $count * $luggages_fee[$lug_id]['domestic_express'];
            }

            if(!empty($luggages_fee[$lug_id]['domestic_basic'])){
                $basic_fee += $count * $luggages_fee[$lug_id]['domestic_basic'];
            }

        }

        $return_array = [
            'domestic_express' => $express_fee,
            'domestic_basic'   => $basic_fee
        ];

        return $return_array;

    }

    public function _check_hawaii_or_alaska($zip_code1, $zip_code2){

        if(empty($zip_code1) || empty($zip_code2) || strlen($zip_code1) < 3 || strlen($zip_code2) <3){
            return false;
        }

        $zip_code1 = substr($zip_code1, 0, 3);
        $zip_code2 = substr($zip_code2, 0, 3);

        $array = [
            '967' => 'HW',
            '968' => 'HW',
            '995' => 'ALS',
            '996' => 'ALS',
            '997' => 'ALS',
            '998' => 'ALS',
            '999' => 'ALS'
        ];

        if(empty($array[$zip_code1]) && empty($array[$zip_code2])){
            return false;
        }

        $zip_code1 = (!empty($array[$zip_code1]))?$array[$zip_code1]:'US';
        $zip_code2 = (!empty($array[$zip_code2]))?$array[$zip_code2]:'US';

        $return_array = [
            'US'  => [
                'HW'  => 8,
                'ALS' => 11
            ],
            'HW'  => [
                'US'  => 9,
                'HW'  => 10,
                'ALS' => 14
            ],
            'ALS' => [
                'US'  => 12,
                'ALS' => 13,
                'HW'  => 15
            ]
        ];

        return $return_array[$zip_code1][$zip_code2];

    }

    public function _get_special_box_fee($boxes, $type, $country_id, $all_total_count = 0){

        if(is_array($boxes)) {
            $boxes = array_filter($boxes);
        }

        if(empty($boxes)){
            return false;
        }

        $country_inf = $this->CI->Users_model->get_countries($country_id);

        if(empty($country_inf)){
            return false;
        }

        $curriers = $this->CI->Manage_price_model->get_curriers();

        if(empty($curriers)){
            return false;
        }

        $prices = NULL;

        if(strtolower($type) == 'domestic'){
            $prices = $this->_get_box_dom($curriers, $boxes, $country_id);
        }
        elseif(strtolower($type) == 'international'){
            $prices = $this->_get_box_inter($curriers, $boxes, $country_id, $all_total_count);
        }

        if(empty($prices)){
            return false;
        }

        return $prices;

    }


    public function _get_box_inter($curriers, $boxes, $country_id, $all_total_count = 0){

        $prices = [];

        $international_fee = $this->CI->Check_price_model->get_boxes_international($country_id);

        $boxes_info = $this->_special_box_changes($boxes);

        $fee_limits = $this->CI->config->item('international_fee_limit');

        foreach($curriers as $currier){

            $sur_charge_data = $this->CI->Check_price_model->get_sur_charges($country_id, $currier['id'], '1');

            $prices[$currier['currier_name']] = 0;
            $prices[$currier['currier_name'].'_surcharge'] = 0;
            $prices[$currier['currier_name'].'_special'] = 0;

            if(empty($sur_charge_data)) {continue;}

            $special_fee = [];

            foreach($boxes_info['boxes'] as $box){

                $price = 0;

                if($box['weight'] >= $sur_charge_data['max_weight'] || $box['width'] >= $sur_charge_data['max_length'] || $box['height'] >= $sur_charge_data['max_length'] || $box['length'] >= $sur_charge_data['max_length']){
                    $price += floatval($sur_charge_data['sur_charge']);
                    $prices[$currier['currier_name'].'_surcharge'] += floatval($sur_charge_data['sur_charge']) * $box['count'];
                }

                foreach($this->CI->config->item('special_box_sizes_ranges') as $range){

                    if($box['weight'] >= $range['from'] && $box['weight'] <= $range['to']){

                        foreach($fee_limits as $fee_limit){

                            if($all_total_count >=  $fee_limit['from'] && $all_total_count <=  $fee_limit['to']){

                                if(!empty($international_fee[strtolower($range['size'])][$currier['id']][$fee_limit['column']])){

                                    $prices[$currier['currier_name'].'_special'] += $international_fee[strtolower($range['size'])][$currier['id']][$fee_limit['column']]*$box['count'];
                                }

                                break;
                            }
                        }

                        break;
                    }

                }

                $prices[$currier['currier_name']] += $price * $box['count'];

            }

        }

        $prices['total_weight'] = $boxes_info['total_weight'];
        $prices['total_count']  = $boxes_info['total_count'];

        return $prices;

    }


    public function _get_box_dom($curriers, $boxes, $country_id){

        $prices = [];

        $domestic_fee = $this->CI->Check_price_model->get_boxes_domestic($country_id);

        $boxes_info = $this->_special_box_changes($boxes, true);

        foreach($curriers as $currier){

            $sur_charge_data = $this->CI->Check_price_model->get_sur_charges($country_id, $currier['id'], '2');

            $prices[$currier['currier_name']] = [
                'domestic_express' => 0,
                'domestic_basic'   => 0,
                'surcharge'        => 0,
                'special_express'  => 0,
                'special_basic'    => 0
            ];

            if(empty($sur_charge_data)) {continue;}

            foreach($boxes_info['boxes'] as $box){

                $price = 0;

                if($box['weight'] >= $sur_charge_data['max_weight'] || $box['width'] >= $sur_charge_data['max_length'] || $box['height'] >= $sur_charge_data['max_length'] || $box['length'] >= $sur_charge_data['max_length']){
                    $price += floatval($sur_charge_data['sur_charge']);
                    $prices[$currier['currier_name']]['surcharge'] += floatval($sur_charge_data['sur_charge']*$box['count']);
                }

                $price_express = $price;
                $price_basic = $price;

                foreach($this->CI->config->item('special_box_sizes_ranges') as $range){

                    if($box['weight'] >= $range['from'] && $box['weight'] <= $range['to']){

                        $price_express +=  $domestic_fee[strtolower($range['size'])]['domestic_express'];
                        $price_basic +=  $domestic_fee[strtolower($range['size'])]['domestic_basic'];
                        $prices[$currier['currier_name']]['special_express'] += $domestic_fee[strtolower($range['size'])]['domestic_express']*$box['count'];
                        $prices[$currier['currier_name']]['special_basic']   += $domestic_fee[strtolower($range['size'])]['domestic_basic']*$box['count'];
                        break;
                    }

                }

                $prices[$currier['currier_name']]['domestic_express'] += $price_express*$box['count'];
                $prices[$currier['currier_name']]['domestic_basic'] += $price_basic*$box['count'];

            }

        }

        $prices['total_weight'] = $boxes_info['total_weight'];
        $prices['total_count']  = $boxes_info['total_count'];
        $prices['weight_array'] = $boxes_info['weight_array'];
        $prices['special_box_add_weight'] = $boxes_info['additional_weight_for_domestic'];
        return $prices;

    }

    public function _special_box_changes($boxes, $single_weight = false){

        if(is_array($boxes)) {
            $boxes = array_filter($boxes);
        }

        if(empty($boxes)){
            return false;
        }

        $total_weight = 0;
        $total_count = 0;
        $weight_array = [];

        $additional_weight = 0;

        foreach($boxes as $index => $box) {

            $weight = floatval($box['weight']) + $this->CI->config->item('special_box_add_data')['weight'];
            $width  = floatval($box['width'])  + $this->CI->config->item('special_box_add_data')['width'];
            $height = floatval($box['height']) + $this->CI->config->item('special_box_add_data')['height'];
            $length = floatval($box['length']) + $this->CI->config->item('special_box_add_data')['length'];

            $weight = max(ceil($weight), ceil($width * $height * $length / 139));

            $boxes[$index]['weight'] = $weight;
            $boxes[$index]['width']  = $width;
            $boxes[$index]['height'] = $height;
            $boxes[$index]['length'] = $length;

            $total_weight += $weight * $box['count'];
            $total_count += $box['count'];

            if($single_weight){

                if($weight > 150){
                    $additional_weight += ($weight - 150)*intval($box['count']);
                    $weight = 150;
                }

                if(isset($weight_array[$weight])){
                    $weight_array[$weight] += intval($box['count']);
                }else{
                    $weight_array[$weight] = intval($box['count']);
                }

            }

        }

        $return_array = [
            'boxes'        => $boxes,
            'total_weight' => $total_weight,
            'total_count'  => $total_count,
            'weight_array' => $weight_array,
            'additional_weight_for_domestic' => $additional_weight
        ];

        return $return_array;

    }

    public function get_order_create_info($order_id, $date = NULL){

        $order_info    = $this->CI->Order_model->get_order_info($order_id);
        $pick_up_info  = $this->CI->Order_model->get_pickup_info($order_id);
        $delivery_info = $this->CI->Order_model->get_delivery_info($order_id);

        if(empty($date)){
            $date = $pick_up_info['shipping_date'];
        }

        if(empty($order_info)){
            return false;
        }

        if(empty($pick_up_info)){
            return false;
        }

        if(empty($delivery_info)){
            return false;
        }

        $additional_week_days = [];

        if($order_info['shipping_type'] == 2){

            $day_count = preg_replace('/[^0-9]+/', '', $order_info['send_type']);

            if(stripos($order_info['send_type'], '+sat') !== FALSE){
                $additional_week_days[] = 'sat';
            }

            $main_country_id = $pick_up_info['pickup_country_id'];
            $second_country_id = $pick_up_info['pickup_country_id'];

        }else{

            if(stripos($order_info['send_type'], 'outbound') !== FALSE){

                $main_country_id = $pick_up_info['pickup_country_id'];
                $second_country_id = $delivery_info['delivery_country_id'];
            }else{

                $second_country_id = $pick_up_info['pickup_country_id'];
                $main_country_id = $delivery_info['delivery_country_id'];
            }

            $main_country_info   = $this->CI->Users_model->get_countries($main_country_id, true);
            $second_country_info = $this->CI->Users_model->get_countries($second_country_id, true);

            $table_name          = strtolower($main_country_info['iso2']).'_international_delivery_time';
            $delivery_days_array = $this->CI->Check_price_model->get_delivery_day($table_name, $second_country_info['iso2']);

            $send_type = preg_replace('/\s+/', '_', $order_info['send_type']);

            if(!empty($delivery_days_array[$send_type])){
                $day_count = $delivery_days_array[$send_type];
            }

        }

        if(empty($day_count)){
            return false;
        }


        $days = $this->_get_business_days($date,$main_country_id,$second_country_id,$additional_week_days);

        if(empty($days)){
            return false;
        }

        $return_array = [
            'days'          => $days,
            'day_count'     => $day_count,
            'delivery_info' => $delivery_info,
            'pickup_info'   => $pick_up_info
        ];

        return $return_array;

    }

    public function get_status_title($status){

        if(INCOMPLETE_STATUS[0] == $status){
            return INCOMPLETE_STATUS[1];
        }

        if(SUBMITTED_STATUS[0] == $status){
            return SUBMITTED_STATUS[1];
        }

        if(PROCESSED_STATUS[0] == $status){
            return PROCESSED_STATUS[1];
        }

        if(CLOSED_STATUS[0] == $status){
            return CLOSED_STATUS[1];
        }

        if(READY_STATUS[0] == $status){
            return READY_STATUS[1];
        }

        if(TRANSIT_STATUS[0] == $status){
            return TRANSIT_STATUS[1];
        }

        if(DELIVERY_STATUS[0] == $status){
            return DELIVERY_STATUS[1];
        }

        if(SUBMITTED_CANCEL_STATUS[0] == $status){
            return SUBMITTED_CANCEL_STATUS[1];
        }

        if(PROCESSED_CANCEL_STATUS[0] == $status){
            return PROCESSED_CANCEL_STATUS[1];
        }

        return false;

    }

    public function get_order_fee($order_id, $user_id, $from = 'billing'){

        $order_info = $this->CI->Order_model->get_order_info($order_id, $user_id);
        $user_info = $this->CI->Users_model->get_user_info($user_id);

        if(empty($order_info)){
            return false;
        }

        if(empty($user_info)){
            return false;
        }

        $last = $this->CI->Billing_model->check_last_billing($order_id);

        $final_billing = $last['last_billing'];

        $credit = floatval($user_info['account_credit']);

        if($final_billing['account_credit'] > $credit){

            $crt = [
                'order_id' => $order_id,
                'status'   => '1',
                'type'     => $final_billing['type']
            ];

            $this->CI->Billing_model->global_update_billing_info(['account_credit' => $credit], $crt);

            $last = $this->CI->Billing_model->check_last_billing($order_id);

            $final_billing = $last['last_billing'];

        }

        if(empty($final_billing) || $from != 'billing'){

            $order_luggages = $this->CI->Order_model->get_luggage_order($order_id);
            $count = count($order_luggages);

            $pick_up_info = $this->CI->Order_model->get_pickup_info($order_id);

            $pick_up_fee = floatval($pick_up_info['pickup_price']*$count);

            $insurance_fee = floatval($this->CI->Order_model->get_insurance_fee($order_id));

            $price_amount = floatval($order_info['price']);

            $all_fee = $price_amount + $insurance_fee + $pick_up_fee;

            $discount_p = NULL;
            $discount_d = NULL;

            if($order_info['discount_type'] == '2'){

                $discount_amount = floatval($order_info['interest_discount']);
                $discount_d = floatval($order_info['interest_discount']);

            }else{

                $discount_amount = ($all_fee * floatval($order_info['interest_discount']) / 100);
                $discount_p = floatval($order_info['interest_discount']);
            }

            $sum = $price_amount + $insurance_fee + $pick_up_fee - $discount_amount;

            $new_credit = $credit - $sum;

            $pay_from_card = $sum - $credit;

            if($new_credit < 0){
                $new_credit = 0;
            }

            $pay_from_credit = $credit - $new_credit;

        }else{

            $sum = floatval($final_billing['shipping_fee'])
                + floatval($final_billing['pickup_fee'])
                + floatval($final_billing['process_fee'])
                + floatval($final_billing['insurance_fee'])
                + floatval($final_billing['special_handling'])
                + floatval($final_billing['oversize_fee'])
                + floatval($final_billing['remote_area_fee'])
                - floatval($final_billing['admin_discount'])
                + floatval($final_billing['cancel_fee'])
                + floatval($final_billing['address_change_fee'])
                + floatval($final_billing['shipment_holding'])
                + floatval($final_billing['label_delivery_fee'])
                + floatval($final_billing['tax_fee'])
                + floatval($final_billing['other_fee']);

            $discount_p = 0;

            if(!empty($final_billing['promotion_type']) && $final_billing['promotion_type'] == '1'){

                $promo = $sum*floatval($final_billing['promotion_code'])/100;
                $sum = $sum - $promo;
                $discount_p = $final_billing['promotion_code'];
                $final_billing['promotion_code'] = $promo;

            }else{

                $sum = $sum - $final_billing['promotion_code'];
            }

            $pay_from_credit = floatval($final_billing['account_credit']);

            if($final_billing['account_credit'] > $sum){
                $pay_from_credit = $sum;
            }

            $pay_from_card = $sum - $pay_from_credit;

            $discount_amount = floatval($final_billing['admin_discount']) + floatval($final_billing['promotion_code']);
            $insurance_fee = floatval($final_billing['insurance_fee']);
            $pick_up_fee = floatval($final_billing['pickup_fee']);
            $discount_d = floatval($final_billing['promotion_code']);


        }

        if($pay_from_card < 0){
            $pay_from_card = 0;
        }

        if($sum < 0){
            $sum = 0;
        }

        if($pay_from_credit < 0){
            $pay_from_credit = 0;
        }

        $return_array =  [
            'original_price'  => floatval(number_format($sum, 2, '.', false)),
            'account_credit'  => floatval(number_format($credit,2, ".", false)),
            'pay_from_card'   => floatval(number_format($pay_from_card,2, ".", false)),
            'pay_from_credit' => floatval(number_format($pay_from_credit,2, ".", false)),
            'discount'        => floatval(number_format($discount_amount, 2, '.', '')),
            'insurance'       => floatval(number_format($insurance_fee, 2, '.', '')),
            'pick_up'         => floatval(number_format($pick_up_fee, 2, '.', '')),
            'discount_d'      => floatval(number_format($discount_d,2, ".", false)),
            'discount_p'      => floatval(number_format($discount_p,2, ".", false))
        ];

        return $return_array;

    }

    public function recalculate_shipping_fee($order_id){

        $order_info         = $this->CI->Order_model->get_order_info($order_id);
        $pickup_info        = $this->CI->Order_model->get_pickup_info($order_id);
        $delivery_info      = $this->CI->Order_model->get_delivery_info($order_id);
        $final_billing_info = $this->CI->Order_model->get_order_final_billing_info($order_id);

        if(empty($order_info) || empty($pickup_info) || empty($delivery_info) || empty($final_billing_info)){
            return false;
        }

        $carrier = $order_info['currier_name'];
        $send_type = str_replace(' ','_', $order_info['send_type']);

        $luggage_total_count = count($final_billing_info);
        $luggage_count = 0;
        $box_count = 0;

        $day_count = $order_info['delivery_day_count'];

        $result = NULL;

        $total_weight        = 0;
        $weight_for_domestic = [];
        $special_handling    = [];
        $special_handling_domestic = 0;

        $special_boxes = [
            1 => [],
            2 => [],
            3 => []
        ];

        foreach ($final_billing_info as $index => $inf){

            if(!empty($inf['special_index'])){

                if(!empty($special_boxes[$inf['special_index']])){

                    $special_boxes[$inf['special_index']]['count'] += 1;

                }else{

                    $box_weight = (empty($inf['actual_weight']))?$inf['weight']:$inf['actual_weight'];
                    $box_width  = (empty($inf['actual_width']))?$inf['width']:$inf['actual_width'];
                    $box_height = (empty($inf['actual_height']))?$inf['height']:$inf['actual_height'];
                    $box_length = (empty($inf['actual_length']))?$inf['length']:$inf['actual_length'];

                    $special_boxes[$inf['special_index']] = [
                        'weight' => $box_weight,
                        'width'  => $box_width,
                        'height' => $box_height,
                        'length' => $box_length,
                        'count'  => 1
                    ];

                }

                $box_count++;

            }else{

                $special_handling_domestic += $inf['special_handling'];
                $luggage_count ++;

                if(isset($weight_for_domestic[$inf['lug_charge_weight']])){

                    $weight_for_domestic[$inf['lug_charge_weight']] += 1;
                }else{

                    $weight_for_domestic[$inf['lug_charge_weight']] = 1;
                }

            }

            $total_weight += $inf['lug_charge_weight'];
            $special_handling[] = $inf['special_handling'];

        }

        if($order_info['shipping_type'] == '1'){

            $country1_info = $this->CI->Users_model->get_countries($pickup_info['pickup_country_id'], true);
            $country2_info = $this->CI->Users_model->get_countries($delivery_info['delivery_country_id'], true);

            $check_result = $this->_check_international_data($country1_info, $country2_info, $total_weight, $total_weight);

            $delivery_table_name = strtolower($check_result['main_country']['iso2']).'_international_delivery_time';
            $delivery_days       = $this->_get_delivery_days_inter($pickup_info['shipping_date'], $check_result['main_country']['id'], $check_result['for_country']['id'], $delivery_table_name, $check_result['for_country']['iso2']);
            $processing_fee      = $this->_get_processing_fee($check_result['main_country']['id'], $luggage_total_count);

            $special_box_international = $this->_get_special_box_fee($special_boxes, 'international', $check_result['main_country']['id']);

            $curriers_array = $this->CI->Manage_price_model->get_curriers();

            $international_fee = [
                'total_count' => $luggage_count
            ];

            if(!empty($curriers_array)){
                foreach($curriers_array as $single){
                    $international_fee[$single['currier_name']] = max($special_handling);
                }
            }

            $data = [
                'for_country'       => $check_result['for_country'],
                'main_country'      => $check_result['main_country'],
                'type'              => $check_result['type'],
                'weight'            => $check_result['weight'],
                'additional_weight' => $check_result['additional_weight'],
                'delivery_days'     => $delivery_days,
                'processing_fee'    => $processing_fee,
                'international_fee' => $international_fee,
                'price_table'       => $check_result['table_name'],
                'special_boxes'     => $special_box_international
            ];


            $result = $this->_get_international_prices($data);

        }
        elseif($order_info['shipping_type'] == '2'){

            $country_info     = $this->CI->Users_model->get_countries($pickup_info['pickup_country_id'], true);
            $price_table_name = strtolower($country_info['iso2'].'_domestic');
            $business_days_ex = $this->_get_business_days($pickup_info['shipping_date'], $pickup_info['pickup_country_id'], $pickup_info['pickup_country_id'], ['sat']);
            $business_days    = $this->_get_business_days($pickup_info['shipping_date'], $pickup_info['pickup_country_id'], $pickup_info['pickup_country_id']);
            $zone             = $order_info['domestic_zone'];
            $special_box_domestic = $this->_get_special_box_fee($special_boxes, 'domestic', $pickup_info['pickup_country_id']);

            $add_weight_domestic = 0;

            if(!empty($special_box_domestic)){

                foreach($special_box_domestic['weight_array'] as $box_weight => $box_count){

                    if(isset($weight_for_domestic[$box_weight])){

                        $weight_for_domestic[$box_weight] += $box_count;
                    }else{

                        $weight_for_domestic[$box_weight] = $box_count;
                    }

                }

                $add_weight_domestic = $special_box_domestic['special_box_add_weight'];

            }

            $data = [
                'country_id'           => $pickup_info['pickup_country_id'],
                'price_table_name'     => $price_table_name,
                'processing_fee'       => $this->_get_processing_fee($pickup_info['pickup_country_id'], $luggage_total_count),
                'domestic_basic_fee'   => $special_handling_domestic,
                'domestic_express_fee' => $special_handling_domestic,
                'weight'               => $weight_for_domestic,
                'additional_weight'    => $add_weight_domestic,
                'zone'                 => $zone,
                'business_days_ex'     => $business_days_ex,
                'business_days'        => $business_days,
                'day_count'            => $day_count,
                'special_boxes'        => $special_box_domestic
            ];

            $result = $this->_get_domestic_prices($data);

        }

        $send_type = str_ireplace('*', $order_info['delivery_day_count'], $send_type);

        if(empty($result[$carrier][$send_type])){
            return false;
        }

        return $result[$carrier][$send_type];

    }

}