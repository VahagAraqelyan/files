<?php
require_once('ext/fedex/fedex-common.php5');

class Fedex_lib {

    private $CI;

    public function __construct(){

        $this->CI=get_instance();
    }

    public function address_validation($address){

        $response_glob = [
            'status' => 'OK',
            'errors' => []
        ];

        $path_to_wsdl = FCPATH."application/libraries/ext/fedex/AddressValidationService_v4.wsdl";

        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

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
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Address Validation Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'aval',
            'Major' => '4',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $request['InEffectAsOfTimestamp'] = date('c');

        $addresses_array[0]['ClientReferenceId'] = $address['ref_id'];

        if(!empty($address['address'])){

            $addresses_array[0]['Address'] =[
                'StreetLines'         => array($address['address']['address_1'], $address['address']['address_2']),
                'PostalCode'          => $address['address']['zip_code'],
                'City'                => $address['address']['city'],
                'StateOrProvinceCode' => $address['address']['state'],
                'CountryCode'         => $address['address']['country_iso2']
            ];
        }

        if(!empty($address['contact'])){

            $addresses_array[0]['Contact'] =[
                'PersonName'   => $address['contact']['fname'].' '.$address['contact']['lname'],
                'CompanyName'  => $address['contact']['company'],
                'PhoneNumber'  => $address['contact']['phone'],
                'EMailAddress' => $address['contact']['email']
            ];
        }

        $request['AddressesToValidate'] = $addresses_array;

        try {
            if(setEndpoint('changeEndpoint')){

                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client ->addressValidation($request);

            if(!is_object($response)){
                $response_glob['status'] = true;
                return $response_glob;
            }

            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){

                $checking = [
                    'CountrySupported'     => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.',
                    'MultipleMatches'      => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.',
                    'PostalValidated'      => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.',
                    'StreetRangeValidated' => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.',
                    'StreetValidated'      => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.',
                    'CityStateValidated'   => 'Address is NOT correct, please make sure that your full address is correct including suite/apt. number, city, state, and zip code.'
                ];

                $single_address = $response -> AddressResults;

                    if(!empty($single_address -> Attributes)){

                        foreach($single_address -> Attributes as $attribute){

                            if(!is_object($attribute)){
                                continue;
                            }

                            if(!array_key_exists($attribute->Name, $checking)){
                                continue;
                            }

                            if($attribute->Name == 'SuiteRequiredButMissing' && $attribute->Value == 'false'){

                                continue;

                            }elseif($attribute->Name == 'SuiteRequiredButMissing'){

                                $response_glob['status'] = false;
                                $response_glob['errors'][] = $single_address -> ClientReferenceId.' '.$checking[$attribute->Name];
                            }

                            if($attribute->Name == 'InvalidSuiteNumber' && $attribute->Value == 'false'){

                                continue;

                            }elseif($attribute->Name == 'InvalidSuiteNumber'){

                                $response_glob['status'] = false;
                                $response_glob['errors'][] = $single_address -> ClientReferenceId.' '.$checking[$attribute->Name];
                            }

                            if($attribute->Name == 'MultipleMatches' && $attribute->Value == 'false'){

                                continue;

                            }elseif($attribute->Name == 'MultipleMatches'){

                                $response_glob['status'] = false;
                                $response_glob['errors'][] = $single_address -> ClientReferenceId.' '.$checking[$attribute->Name];
                            }

                            if($attribute->Value != 'true'){

                                $response_glob['status'] = false;
                                $response_glob['errors'][] = $single_address -> ClientReferenceId.' '.$checking[$attribute->Name];
                            }

                        }
                    }



            }else{

                $response_glob['status'] = true;
                log_message('error', 'Can not send request to fedex address validator.');
            }

            //writeToLog($client);    // Write to log file
        } catch (SoapFault $exception) {

            $response_glob['status'] = true;
            log_message('error', 'SoapFault fedex address validator.');

        }

        return  $response_glob;

    }


}
?>