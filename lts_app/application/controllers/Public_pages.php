<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/// @todo

class Public_pages extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->lang->load('auth');
        $this->load->model("Users_model");
        $this->load->model("Luggage_model");
        $this->load->model("Ion_auth_model");
        $this->load->model("Order_model");
        $this->config->load('order');
        $this->load->config('public_page');
    }

    public function get_public_pages($view){

        if(empty($view)){
            return false;
        }

        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        if($view == 'calc_weight_size'){

            $all_luggage = $this->Luggage_model->get_all_luggage();

            $data['luggage'] = $all_luggage;
        }

        $data['content']             = 'public_pages/'.$view;

        $data['inf'] = $this->config->item($view);
        $this->load->view('public_pages/public_page_template',$data);
    }


    public function ax_calc_weight_size(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $luggage_id = trim($this->security->xss_clean($this->input->post('luggage_id')));

        $single_luggage = $this->Luggage_model->get_luggage_by_id($luggage_id);

        if(empty($single_luggage)){
            show_404();
            return false;
        }

        $data['single_luggage'] = $single_luggage;

        $this->load->view('public_pages/calc_weight_size_answer',$data);
    }


    public function get_questions($for = NULL){

        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $data['content'] = 'public_pages/questions';
        $data['inf']     = $this->config->item('questions');

        $logged_in = true;

        if(!$this->ion_auth->logged_in()){

            $logged_in = false;

        }

        $data['logged_in'] = $logged_in;

        if(empty($for)){

            $for = '';
        }

        $data['for'] = $for;

        $this->load->view('public_pages/public_page_template',$data);

    }


    function get_prod_by_type($type_id){

        if(empty($type_id)){
            show_404();
        }

        $luggages = $this->Luggage_model->get_luggages_by_type($type_id);

        if(empty($luggages)){
            show_404();
        }

        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $data=[
            "countries"      => $this->Users_model->get_countries(),
            "luggages_array" => $this->luggage_ref->get_ref_data()
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $view_arr         = $this->config->item('luggage_view_by_type');
        $data['content']  = 'public_pages/'.$view_arr[$type_id];
        $data['inf']      = $this->config->item($view_arr[$type_id]);
        $data['luggages'] = $luggages;

        $this->load->view('public_pages/public_page_template',$data);
    }

    function get_bike($type_id){

        if(empty($type_id)){
            show_404();
        }

        $luggages = $this->Luggage_model->get_luggages_by_type($type_id);

        if(empty($luggages)){
            show_404();
        }

        $data['info']=[
            'user_name'   => '',
            'account_num' => '',
        ];

        $data=[
            "countries"      => $this->Users_model->get_countries(),
            "luggages_array" => $this->luggage_ref->get_ref_data()
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        if($type_id == 4){

            $data['content']  = 'public_pages/shipping_rates';
            $data['inf']      = $this->config->item('shipping_rates');

        }else{
            $data['content']  = 'public_pages/bike';
            $data['inf']      = $this->config->item('bike');
        }


        $data['luggages'] = $luggages;

        $this->load->view('public_pages/public_page_template',$data);
    }

    public function drop_of_locations($country_id = '', $zip_code = '', $carrier = '', $radius = '10'){

        $zip_code = urldecode($zip_code);

        $state_place = '';
        if($zip_code == 'false'){
            $zip_code = '';
        }

        if(!empty($zip_code)){

            if($carrier != 'DHL'){

                $zip_code = preg_replace('/[^0-9]+/', '', $zip_code);

            }else{

                $zip_code = str_replace('_',' ',$zip_code);
                $state_explode = explode('-',trim($zip_code));

            }

            if(!empty($state_explode[1])){

                $state_place = trim($state_explode[1]);
            }

        }

        $data['selected'] = [
            'zip_code' => trim($zip_code),
            'carrier'  => $carrier,
            'country'  => $country_id,
            'radius'   => $radius
        ];

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $this->load->model("Manage_price_model");

        $data['content'] = 'public_pages/drop_off_location';

        $data['all_country'] = $this->Users_model->get_countries();

        $data['all_carriers'] = $this->Manage_price_model->get_curriers();

        $data['inf'] = $this->config->item('drop_off_location');

        $data['action'] = true;

        $data['message'] = '';

        if(empty($carrier) || empty($country_id)){

            $this->load->view('public_pages/public_page_template',$data);
            return false;

        }

        $this->load->library('Google_api');

        if(strtolower($carrier) == 'dhl'){

            $county = $this->Users_model->get_countries($country_id);

            if(!empty($county[0]['country'])){

                $country = $county[0]['country'];
                $search = $country.' '.$zip_code.' '.$state_place.'dhl location';
                $url = $this->google_api->google_map_multi_search($search);

            }else{

                $search = $zip_code.' '.$state_place.'dhl location';
                $url = $this->google_api->google_map_multi_search($search);
            }

            $data['action'] = 'google';
            $data['url'] = $url;

        }else {

            if(empty($zip_code)){

                $this->load->view('public_pages/public_page_template',$data);
                return false;
            }

            $location = [
                'lat' => 0,
                'lng' => 0
            ];

            $info = $this->google_api->get_place_id($zip_code, true);

            if (empty($info)) {

                $data['action'] = false;
                $data['message'] = '(Place id) Unable to find a nearby drop off location,<br>
                please check and put the correct city<br>
                name or postal code.<br>
                Please reach out us at 1-800-678-6167 for<br>
                your drop off requirements<br>';

            } else {

                $location = $info['results'][0]['geometry']['location'];
            }

            $data['lat'] = $location['lat'];
            $data['lng'] = $location['lng'];

            $data['store_type'] = strtolower($carrier);

            $radius_array = [5, 10, 15, 50];

            foreach ($radius_array as $radius){

                $loc_info = $this->_genxml($zip_code, $data['lat'], $data['lng'], $radius, $data['store_type']);

                if(!empty($loc_info['info'])){
                    break;
                }

            }

            if(empty($loc_info['info'])){
                $loc_info = $this->_genxml($zip_code, $data['lat'], $data['lng'], $radius, $data['store_type'], true);
            }

            if (empty($loc_info['info'])) {

                $data['action'] = false;
                $data['message'] = 'Unable to find a nearby drop off location,<br>
                please check and put the correct city<br>
                name or postal code.<br>
                Please reach out us at 1-800-678-6167 for<br>
                your drop off requirements<br>';

            }

            $data['xml'] = $loc_info['xml'];
            $data['loc_info'] = $loc_info['info'];

        }

        $this->load->view('public_pages/public_page_template',$data);

    }

    public function luggage_trucking($carrier = NULL, $trucking_number = NULL){

        $trucking_history = NULL;

        $this->load->library('Shippo_lib');

        if(!empty($carrier) && !empty($trucking_number)){

            $shippo_carrier = $this->shippo_lib->get_carrier_name_for_shipo($carrier);

            if(!empty($carrier)){
                $trucking_history = $this->shippo_lib->get_trucking_status($trucking_number, $shippo_carrier);
            }

        }

        $user = $this->ion_auth->user()->row();

        if(!empty($user)){

            $data['info']=[
                'user_name'          => $user->first_name,
                'account_num'        => $user->account_name
            ];

            $data['navigation_buffer'] = 'frontend/dashboard_navigation';

        }else{

            $data['navigation_buffer'] = 'frontend/navigation';
        }

        $data['content'] = 'public_pages/tracking';

        $data['carrier']          = $carrier;
        $data['trucking_number']  = $trucking_number;
        $data['trucking_history'] = $trucking_history;

        $this->load->model("Manage_price_model");

        $data['all_carriers'] = $this->Manage_price_model->get_curriers();

        $data['inf'] = $this->config->item('tracking');

        $this->load->view('public_pages/public_page_template',$data);

    }

    public function _genxml($zip_code, $center_lat, $center_lng, $radius, $store_type, $all_types = NULL) {

        switch ($store_type) {
            case 'ups':

                $end_point = "https://onlinetools.ups.com/ups.app/xml/Locator";
                $accessKey = '2D1BCDF403AC62EE';
                $userId = 'mikeulker';
                $password = 'Aie 10017';

                $xml_ups = '<?xml version="1.0"?>
						<AccessRequest xml:lang="en-US">
							<AccessLicenseNumber>'.$accessKey.'</AccessLicenseNumber>
							<UserId>'.$userId.'</UserId>
							<Password>'.$password.'</Password>
						</AccessRequest>
						<?xml version="1.0"?>
						<LocatorRequest xml:lang="en-US">
							<Request>
								<TransactionReference/>
								<RequestAction>Locator</RequestAction>
								<RequestOption>1</RequestOption>
							</Request>
							<OriginAddress>
								<Geocode>
									<Latitude>'.$center_lat.'</Latitude>
									<Longitude>'.$center_lng.'</Longitude>
								</Geocode>
								<AddressKeyFormat>
									<CountryCode>US</CountryCode>
								</AddressKeyFormat>
							</OriginAddress>
							<Translate>
								<LanguageCode>ENG</LanguageCode>
						</Translate>
						<UnitOfMeasurement>
							<Code>MI</Code>
							<Description>Miles</Description>
						</UnitOfMeasurement>
						<LocationSearchCriteria>
							<AccessPointSearch>
								<AccessPointStatus>01</AccessPointStatus>
							</AccessPointSearch>
							<MaximumListSize>50</MaximumListSize>
							<SearchRadius>'.$radius.'</SearchRadius>
							<SearchOption>
								<OptionType>
									<Code>01</Code>
								</OptionType>
								<OptionCode>
									<Code>002</Code>
								</OptionCode>
							</SearchOption>
						</LocationSearchCriteria>
					</LocatorRequest>';

                $response = $this->_send_postdata($end_point, $xml_ups);

                if(empty($response->SearchResults->DropLocation)){
                    return false;
                }

                $xml_doc = new DOMDocument("1.0");
                $markers = $xml_doc->createElement("markers");
                $child   = $xml_doc->appendChild($markers);
                $info = [];
                foreach($response->SearchResults->DropLocation as $single){

                    $distance     = $single->Distance->Value;
                    $units        = strtolower($single->Distance->UnitOfMeasurement->Code);
                    $company_name = $single->AddressKeyFormat->ConsigneeName;
                    $phone_number = $single->PhoneNumber;
                    $street       = $single->AddressKeyFormat->AddressLine;
                    $city         = $single->AddressKeyFormat->PoliticalDivision2;
                    $state        = $single->AddressKeyFormat->PoliticalDivision1;
                    $postal_code  = $single->AddressKeyFormat->PostcodePrimaryLow;
                    $latitude     = $single->Geocode->Latitude;
                    $longitude    = $single->Geocode->Longitude;
                    $store_closes = $single->OperatingHours->StandardHours->DayOfWeek[1]->CloseHours;
                    $store_closes = date("g:i a", strtotime($store_closes));

                    $last_drop_off_time_ground = $single->LatestGroundDropOffTime;
                    $last_drop_off_time_air = $single->LatestAirDropOffTime;

                    if(!empty($company_name)){

                        $info[] = [
                            'name'    => $company_name,
                            'phone'   => $phone_number,
                            'street'  => $street,
                            'city'    => $city,
                            'state'   => $state,
                            'dist'    => $distance,
                            'time_gr' => $last_drop_off_time_ground,
                            'time_ai' => $last_drop_off_time_air
                        ];
                    }
                    $markers = $xml_doc->createElement("marker");
                    $newchild = $child->appendChild($markers);
                    $newchild->setAttribute("name", $company_name);
                    $newchild->setAttribute("address", $street . ', ' .$city . ', ' . $state . ' ' . $postal_code);
                    $newchild->setAttribute("phone", $phone_number);
                    $newchild->setAttribute("lat", $latitude);
                    $newchild->setAttribute("lng", $longitude);
                    $newchild->setAttribute("type", 'ups');
                    $newchild->setAttribute("distance", $distance . ' ' . $units);
                    $newchild->setAttribute("store_closes", $store_closes);

                }

                return array( 'xml' => $xml_doc->saveXML(), 'info' => $info );

                break;

            case 'fedex':

                //$this->load->library('drop_off_locations');
                //$result = $this->drop_off_locations->get_fedex_locations($radius, $zip_code);
//
                //if(empty($result)){
                //    return array( 'xml' => '', 'info' => [] );
                //}
//
                //return $result;

                $url = "https://www.shipsticks.com/api/beta/store_locator/search?zip_code=93722&radius=10&carrier=fedex";

                require_once( APPPATH . 'libraries/ext/fedex/fedex-common.php5');
                $path_to_wsdl = APPPATH . 'libraries/ext/fedex/LocationsService_v7.wsdl';

                ini_set("soap.wsdl_cache_enabled", "0");
                // disable notice, warnings, error
                ini_set("error_reporting", "0");

                $dom = new DOMDocument("1.0");
                $node = $dom->createElement("markers");
                $parnode = $dom->appendChild($node);

                $client = new SoapClient($path_to_wsdl, array('trace' => 1));

                $request['WebAuthenticationDetail'] = array(
                    'ParentCredential' => array(
                        'Key' => getProperty('parentkey'),
                        'Password' => getProperty('parentpassword')
                    ),
                    'UserCredential' => array(
                        'Key' => getProperty('key'),
                        'Password' => getProperty('password')
                    )
                );

                $request['ClientDetail'] = array(
                    'AccountNumber' => getProperty('shipaccount'),
                    'MeterNumber' => getProperty('meter')
                );

                $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Search Locations Request using PHP ***');
                $request['Version'] = array(
                    'ServiceId' => 'locs',
                    'Major' => '7',
                    'Intermediate' => '0',
                    'Minor' => '0'
                );

                $request['EffectiveDate'] = date('Y-m-d');

                $bNearToPhoneNumber = false;

                if($bNearToPhoneNumber) {
                    $request['LocationsSearchCriterion'] = 'PHONE_NUMBER';
                    $request['PhoneNumber'] = getProperty('searchlocationphonenumber');
                }
                else {
                    $request['LocationsSearchCriterion'] = 'ADDRESS';
                    $request['Address'] =  array(
                        'PostalCode' => $zip_code,
                        'CountryCode' => 'US'
                    );
                }

                $request['MultipleMatchesAction'] = 'RETURN_ALL';
                $request['SortDetail'] = array(
                    'Criterion' => 'DISTANCE',
                    'Order' => 'LOWEST_TO_HIGHEST'
                );
                $request['Constraints'] = array(

                    'RadiusDistance' => array(
                        'Value' => $radius,
                        'Units' => 'MI'
                    ),
                    'ExpressDropOfTimeNeeded' => '15:00:00.00',
                    'ResultFilters' => 'EXCLUDE_LOCATIONS_OUTSIDE_STATE_OR_PROVINCE',
                    //	'SupportedRedirectToHoldServices' => array('FEDEX_EXPRESS', 'FEDEX_GROUND', 'FEDEX_GROUND_HOME_DELIVERY'),
                    'RequiredLocationAttributes' => array(
                        //'ACCEPTS_CASH','ALREADY_OPEN'
                    ),
                    'ResultsRequested' => 100,
                    //	'LocationContentOptions' => array('HOLIDAYS'),

                );

                if(!$all_types){
                    $request['Constraints']['LocationTypesToInclude'] = array('FEDEX_OFFICE');
                } else {
                    $request['Constraints']['LocationTypesToInclude'] = array('FEDEX_OFFICE', 'FEDEX_AUTHORIZED_SHIP_CENTER');
                }

                $request['DropoffServicesDesired'] = array(
                    'Express' => 1,
                    'FedExStaffed' => 1,
                    'FedExSelfService' => 1,
                    'FedExAuthorizedShippingCenter' => 1,
                    'HoldAtLocation' => 1
                );

                try{
                    if(setEndpoint('changeEndpoint')){
                        $newLocation = $client->__setLocation(setEndpoint('endpoint'));
                    }

                    $response = $client ->searchLocations($request);

                    $info = [];

                    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){

                        foreach($response->AddressToLocationRelationships->DistanceAndLocationDetails as $key => $value) {

                            if(is_array($value) || is_object($value)) {

                                $hours = $value->LocationDetail->NormalHours;

                                $distance = round($value->Distance->Value, 1);
                                $units = strtolower($value->Distance->Units);

                                $company_name = $value->LocationDetail->LocationContactAndAddress->Contact->CompanyName;
                                $phone_number = $value->LocationDetail->LocationContactAndAddress->Contact->PhoneNumber;

                                $street = $value->LocationDetail->LocationContactAndAddress->Address->StreetLines;
                                $city = $value->LocationDetail->LocationContactAndAddress->Address->City;
                                $state = $value->LocationDetail->LocationContactAndAddress->Address->StateOrProvinceCode;
                                $postal_code = $value->LocationDetail->LocationContactAndAddress->Address->PostalCode;

                                //$geo_codes = $value->LocationDetail->GeographicCoordinates;
                                $map_url = $value->LocationDetail->MapUrl;

                                $coords = get_coordinates($map_url);

                                $store_closes = $value->LocationDetail->NormalHours[0]->OperationalHours; //OPEN_ALL_DAY

                                if($store_closes == 'OPEN_ALL_DAY') {
                                    $store_closes = 'Closed';
                                }
                                else {
                                    $store_closes = $value->LocationDetail->NormalHours[0]->Hours->Ends;
                                }

                                if(is_array($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails[0]->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $value->LocationDetail->CarrierDetails[2]->EffectiveLatestDropOffDetails->Time;

                                }elseif(is_object($value->LocationDetail->CarrierDetails)){

                                    $last_pickup_orange = $value->LocationDetail->CarrierDetails->EffectiveLatestDropOffDetails->Time;
                                    $last_pickup_green = $last_pickup_orange;


                                }

                                if(!empty($street)) {
                                    $info[] = [
                                        'name' => $company_name,
                                        'phone' => $phone_number,
                                        'street' => $street,
                                        'city' => $city,
                                        'state' => $state,
                                        'dist' => $distance,
                                        'time_gr' => 'Last Pickup ' . get12hoursTime($last_pickup_green),
                                        'time_ai' => 'Last Pickup ' .  get12hoursTime($last_pickup_orange)
                                    ];
                                }
                                $node = $dom->createElement("marker");
                                $newnode = $parnode->appendChild($node);
                                $newnode->setAttribute("name", $company_name);
                                $newnode->setAttribute("type", "fedex");
                                $newnode->setAttribute("address", $street . ', ' .$city . ', ' . $state . ' ' . $postal_code);
                                $newnode->setAttribute("phone", $phone_number);
                                $newnode->setAttribute("lat", $coords[0]);
                                $newnode->setAttribute("lng", $coords[1]);
                                $newnode->setAttribute("distance", $distance . ' ' . $units);
                                $newnode->setAttribute("last_pickup_orange", get12hoursTime($last_pickup_orange));
                                $newnode->setAttribute("last_pickup_green", get12hoursTime($last_pickup_green));
                                $newnode->setAttribute("store_closes", get12hoursTime($store_closes));
                            }
                        }

                        return array( 'xml' => $dom->saveXML(), 'info' => $info );

                    }
                    else{
                        // printError($client, $response);
                    }
                }
                catch (SoapFault $exception) {

                    printFault($exception, $client);
                }

                break;
            case 'dhl':

                break;
        }
    }

    public function ax_send_public_email(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {

            show_404();
            return false;

        }

        $data["errors"] = [];

        $first_name   = trim($this->security->xss_clean($this->input->post('first_name')));
        $last_name    = trim($this->security->xss_clean($this->input->post('last_name')));
        $title        = trim($this->security->xss_clean($this->input->post('title')));
        $organization = trim($this->security->xss_clean($this->input->post('organization')));
        $email        = trim($this->security->xss_clean($this->input->post('email')));
        $phone        = trim($this->security->xss_clean($this->input->post('phone')));
        $company_info = trim($this->security->xss_clean($this->input->post('company_info')));
        $type         = trim($this->security->xss_clean($this->input->post('type')));

        $this->load->library('General_email');

        if($type == 'corporate_type'){
            $subject_description = 'Corporate Account Form';
            $email_subject = 'Thank you for submitting corporate account form';
        }else{
            $subject_description = 'Affiliate Form';
            $email_subject = 'Thank you for submitting affiliate form';
        }


        $email_info = [
            'first_name'          => $first_name,
            'last_name'           => $last_name,
            'title_inp'           => $title,
            'organization'        => $organization,
            'email'               => $email,
            'phone'               => $phone,
            'company_info'        => $company_info,
            'type'                => $type,
            'title_view'          => $subject_description,
            'subject_description' => $subject_description
        ];

        $email_data = [
            'email'     => $email,
            'to_name'   => $email,
            'subject'   => $email_subject,
            'variables' => $email_info
        ];

        $this->config->load('general_email');

        $email_data2 = [
            'email'     => $this->config->item('server_email'),
            'to_name'   => $this->config->item('server_email'),
            'subject'   => 'Welcome to Luggage To Ship – ' . $first_name.' '.$last_name,
            'variables' => $email_info
        ];

        $this->general_email->send_email('corporate_affiliate',$email_data);
        $this->general_email->send_email('corporate_affiliate',$email_data2);

        echo json_encode($data);
    }

    private function _send_postdata($end_point, $xml_ups) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_ups);

        if (curl_errno($ch)) {
            echo curl_errno($ch) ;
            echo curl_error($ch);
        }
        else {
            $response = curl_exec($ch);
            $xml_to_array_resp = new SimpleXMLElement($response);
            curl_close($ch);
            return $xml_to_array_resp;
        }

    }


}
?>