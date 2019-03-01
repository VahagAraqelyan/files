<?php
require_once('ext/Shippo.php');


Shippo::setApiVersion("2017-08-01");

Class Shippo_lib {

    private $CI;
    private $responce = [];
    private $address = [];
    private $percels = [];
    private $order_extra = [];
    private $custom_declaration = NULL;
    private $custom_items = [];

    public function __construct()
    {
        Shippo::setApiKey(SHIPPO_API_KEY);
    }

    public function create_shipment($carrier_account, $type, $date, $international = false)
    {

        $this->init_responce();

        if(empty($carrier_account)){
            $this->set_error('Undefined carrier id.');
            return $this->responce;
        }

        $data = array(
            'shipment_date'    => date(DATE_ISO8601,strtotime($date)),
            'address_from'     => $this->address['from'],
            'address_to'       => $this->address['to'],
            'parcels'          => $this->percels,
            'carrier_accounts' => array($carrier_account),
            'async'            => false,
            'extra'            => $this->order_extra,
        );

        if($international){

            if(empty($this->custom_declaration->object_id)){
                $this->set_error('Please create custom declaration.');
                return $this->responce;
            }

            $data['customs_declaration'] = $this->custom_declaration->object_id;

        }

        try {

            // Create shipment
            $shipment = Shippo_Shipment::create($data);

        } catch (Exception $e) {

            $creating_error = $e->getMessage();

            $vowels = array('"','{','}',']','[','__all__:','_','`');
            $creating_error = str_replace($vowels, "", $creating_error);

            $this->set_error($creating_error);
            return $this->responce;

        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        $parcels = [];

        foreach($shipment['parcels'] as $parcel){
            $parcels[$parcel['object_id']] = $parcel['metadata'];
        }

        if(!empty($shipment['messages'])){

            foreach($shipment['messages'] as $error){

                $vowels = array('"','{','}',']','[','__all__:','_','`');
                $error = str_replace($vowels, "", $error);
                $this->set_warning($error);
            }

        }

        $rates = $shipment['rates'];

        if(empty($rates)){

            $this->set_error('Empty rates for this shipment.');

            return $this->responce;

        }

        $rate = NULL;

        foreach($rates as $single){

            if($single['servicelevel']['token'] == $type){
                $rate = $single;
                break;
            }
        }

        if(empty($rate)){
            $this->set_error('Creating shipment error (undefined shipping type).');
            return $this->responce;
        }

        try {

            $transaction = Shippo_Transaction::create(
                array(
                    'rate' => $rate["object_id"],
                    'label_file_type' => "PNG",
                    'async' => false
                )
            );

        } catch (Exception $e) {

            $creating_error = $e->getMessage();

            $vowels = array('"','{','}',']','[','__all__:','_','`');
            $creating_error = str_replace($vowels, "", $creating_error);

            $this->set_error($creating_error);
            return $this->responce;

        }

        if ($transaction["status"] != "SUCCESS") {
            $this->set_error($transaction['messages'][0]['text']);
        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        $all_transaction = Shippo_Transaction::all(['results' => count($this->percels), 'rate' => $rate["object_id"]], SHIPPO_API_KEY);

        $this->responce['data']['transactions'] = [];

        foreach($all_transaction['results'] as $single){

            if(empty($parcels[$single['parcel']])){
                break;
            }

            $this->responce['data']['transactions'][] = [
                'tracking_number' => $single['tracking_number'],
                'tracking_url'    => $single['tracking_url_provider'],
                'label_url'       => $single['label_url'],
                'object_id'       => $single['object_id'],
                'id'              => $parcels[$single['parcel']]
            ];

        }

        return $this->responce;

    }

    public function set_address($from, $to){

        $this->init_responce();

        if(empty($from)){
            $this->set_error('Sender address is required');
        }

        if(empty($to)){
            $this->set_error('Receiver address is required');
        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        $this->address['from'] = array(

            'name'    => $from['name'],
            'street1' => $from['street1'],
            'street2' => $from['street2'],
            'city'    => $from['city'],
            'state'   => $from['state'],
            'zip'     => $from['zip'],
            'country' => $from['country'],
            'phone'   => $from['phone'],
            'email'   => $from['email'],
            'company' => $from['company']
        );

        $this->address['to'] = array(

            'name'    => $to['name'],
            'street1' => $to['street1'],
            'street2' => $to['street2'],
            'city'    => $to['city'],
            'state'   => $to['state'],
            'zip'     => $to['zip'],
            'country' => $to['country'],
            'phone'   => $to['phone'],
            'email'   => $to['email'],
            'company' => $to['company']
        );

        return $this->responce;

    }

    public function set_percels($array_data){

        //$parcel1 = array(
        //    'length' => '5',
        //    'width' => '5',
        //    'height' => '5',
        //    'distance_unit' => 'in',
        //    'weight' => '2',
        //    'mass_unit' => 'lb',
        //);

        $this->init_responce();

        if(empty($array_data)){
            $this->set_error('Percels can not be empty.');
        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        $this->percels = $array_data;

        return $this->responce;

    }

    public function set_custom_items($custom_items){

        // Demo
        // $custom_items = array(
        //    'description'=> 'T-Shirt',
        //    'quantity'=> '20',
        //    'net_weight'=> '1',
        //    'mass_unit'=> 'lb',
        //    'value_amount'=> '200',
        //    'value_currency'=> 'USD',
        //    'origin_country'=> 'US');

        $this->init_responce();

        if(empty($custom_items)){
            $this->set_error('Custom items can not be empty.');
        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        if(!empty($custom_items[0]) && is_array($custom_items[0])){

            foreach($custom_items as $single_item){

                if(empty($single_item['description'])){
                    $this->set_error('Please set description for all items.');
                }

                if(empty($single_item['quantity'])){
                    $this->set_error('Please set quantity for all items.');
                }

                if(empty($single_item['net_weight'])){
                    $this->set_error('Please set net weight for all items.');
                }

                if(empty($single_item['value_amount'])){
                    $this->set_error('Please set amount for all items.');
                }

                if(empty($this->responce['status'])){
                    return $this->responce;
                }
            }

            if(!empty($this->responce['status'])){

                $this->custom_items = $custom_items;

            }

        }else{

            if(empty($custom_items['description'])){
                $this->set_error('Please set description for all items.');
            }

            if(empty($custom_items['quantity'])){
                $this->set_error('Please set quantity for all items.');
            }

            if(empty($custom_items['net_weight'])){
                $this->set_error('Please set net weight for all items.');
            }

            if(empty($custom_items['value_amount'])){
                $this->set_error('Please set amount for all items.');
            }

            if(!empty($this->responce['status'])){

                $array_data = [$custom_items];

                $this->custom_items = $array_data;

            }

        }

        return $this->responce;

    }

    public function create_custom_declaration($options){

        //$opt_data = [
        //    'contents_type'=> 'MERCHANDISE',
        //    'contents_explanation'=> 'T-Shirt purchase',
        //    'non_delivery_option'=> 'RETURN',
        //    'certify'=> 'true',
        //    'certify_signer'=> 'Simon Kreuz',
        //    'items'=> $this->custom_items
        //];

        $this->init_responce();

        if(empty($options)){
            $this->set_error('Please set options.');
        }

        if(empty($this->custom_items)){
            $this->set_error('Please set custom items before create declaration.');
        }

        if(empty($this->responce['status'])){
            return $this->responce;
        }

        $opt_data = [
            'contents_type'=> 'MERCHANDISE',
            'contents_explanation'=> 'T-Shirt purchase',
            'non_delivery_option'=> 'RETURN',
            'certify'=> $options['certify'],
            'certify_signer'=> $options['certify_signer'],
            'items'=> $this->custom_items
        ];

        try {

            $customs_declaration = Shippo_CustomsDeclaration::create($opt_data);

        } catch (Exception $e) {

            $creating_error = $e->getMessage();

            $vowels = array('"','{','}',']','[','__all__:','_','`');
            $creating_error = str_replace($vowels, "", $creating_error);

            $this->set_error($creating_error);

        }

        if(!empty($this->responce['status'])){

            $this->custom_declaration = $customs_declaration;
        }

        return $this->responce;

    }

    public function set_order_extra($extra){
        $this->order_extra = $extra;
    }

    public function get_trucking_status($trucking_number, $carrier){

        $this->init_responce();

        //$carrier = 'shippo';                    // SHIPPO TESTING VALUES REMOVE BEFORE TESTING
        //$trucking_number = 'SHIPPO_DELIVERED';  // SHIPPO TESTING VALUES REMOVE BEFORE TESTING

        if(is_array($carrier)){

            foreach($carrier as $single){
                $url = REGISTER_WEB_HOOK_URL.$single.'/'.$trucking_number;
                $result = $this->php_curl($url, '','get');
                $result = json_decode($result);
                if(!empty($result)){
                    break;
                }
            }

        }else{

            $url = REGISTER_WEB_HOOK_URL.$carrier.'/'.$trucking_number;
            $result = $this->php_curl($url, '','get');
            $result = json_decode($result);
        }


        if(empty($result) || (empty($result->tracking_status) && empty($result->tracking_history))){

            $this->set_error('No data.');
            return $this->responce;
        }

        $this->responce['data'] = [
            'tracking_number'  => $result->tracking_number,
            'carrier'          => $result->carrier,
            'current_status'   => $result->tracking_status,
            'trucking_history' => $result->tracking_history
        ];

        return $this->responce;

    }

    public function validate_address($address){

        $this->init_responce();

        $result = $this->create_address($address);

        if(empty($result['status'])){
            return $result;
        }

        $obj_id = $result['data'];

        if(empty($obj_id)){

            $this->set_error('Can`t create address object');
            return $this->responce;
        }

        $result = Shippo_Address::validate($obj_id);

        if((empty($result['validation_results']['is_valid']) || $result['validation_results']['is_valid'] != true) && !empty($result['validation_results']['messages'][0]['text'])){

            $this->set_error($result['validation_results']['messages'][0]['text']);
        }

        return $this->responce;

    }

    public function register_webhook($carrier, $tracking_number){

        if(empty($carrier) || empty($tracking_number)){
            return false;
        }

        $carrier = $this->get_carrier_name_for_shipo($carrier);

        if(!is_array($carrier)){

            $data = "carrier=$carrier&tracking_number=$tracking_number";

            $response = $this->php_curl(REGISTER_WEB_HOOK_URL, $data);

            $response = json_decode($response);

            if(!empty($response->tracking_status)){
                return true;
            }

        }else{

            foreach($carrier as $name){

                $data = "carrier=$name&tracking_number=$tracking_number";

                $response = $this->php_curl(REGISTER_WEB_HOOK_URL, $data);

                $response = json_decode($response);

                if(!empty($response->tracking_status)){
                    return true;
                }

            }

        }

        log_message('debug', var_export($response, true));

        return false;

    }

    private function create_address($address){

        $this->init_responce();

        try {
            $Address_obj = Shippo_Address::create( array(
                "name"    => $address['name'],
                "street1" => $address['street1'],
                "street2" => $address['street2'],
                "city"    => $address['city'],
                "state"   => $address['state'],
                "zip"     => $address['zip'],
                "country" => $address['country'],
                "phone"   => $address['phone'],
                "email"   => $address['email']
            ));

        } catch (Exception $e) {

            $this->set_error( $e->getMessage());
            return $this->responce;

        }

        if(empty($Address_obj['object_id'])){

            $this->set_error('Cannot create address');

        }else{
            $this->responce['data'] = $Address_obj['object_id'];
        }

        return $this->responce;

    }

    private function init_responce(){

        $this->responce = [
            'status'   => 'OK',
            'errors'   => [],
            'warnings' => [],
            'data'     => []
        ];
    }

    private function set_error($error_msg){

        $this->responce['status']   = false;
        $this->responce['errors'][] = $error_msg;

    }

    private function set_warning($error_msg){

        $this->responce['warnings'][] = $error_msg;

    }

    public function get_carrier_name_for_shipo($name){

        if(empty($name)){
            return false;
        }

        if(stripos($name, 'fedex') !== FALSE){
            return 'fedex';
        }

        if(stripos($name, 'ups') !== FALSE){
            return 'ups';
        }

        if(stripos($name, 'dhl') !== FALSE){

            return [
                'dhl_express',
                'dhl_germany',
                'dhl_ecommerce',
            ];

        }

        return false;

    }

    public function php_curl($url, $data, $method = 'post') {

        if(empty($url) ){
            return false;
        }

        $curl = curl_init();

        $array = array(
            CURLOPT_HTTPHEADER     => ["Authorization: ShippoToken ".SHIPPO_API_KEY],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_URL            => $url
        );

        if(strtolower($method) == 'get'){

            unset($array[CURLOPT_POST]);
            unset($array[CURLOPT_POSTFIELDS]);

        }

        curl_setopt_array($curl, $array);

        $resp = curl_exec($curl);

        curl_close($curl);

        return $resp;

    }

    public function get_all_carriers_info(){

        $this->init_responce();

        $carriers = Shippo_CarrierAccount::all(['results' => '100']);

        if(empty($carriers->results)){
            $this->set_error('No Carriers');
        }else{
            $this->responce['data'] = $carriers->results;
        }

        return $this->responce;

    }

}
?>