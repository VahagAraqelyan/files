<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @package	   Payment
 * @category   library
 * @link	   https://stripe.com/
 *
 * @name       Strip_payment_lib
 * Short description:
 * extended library for making payments
 *
 **/

// Include stripe external lib
include(APPPATH.'libraries/ext/stripe/init.php');


class Payment_lib {
    /**
     * Constructor
     *
     *
     * @return none
     *
     * @access public
     *
     *
     */

    private $CI;
    private $private_key;

    public function __construct() {
        $this->CI =& get_instance();
        // Init models
        $this->CI->load->config('payment_config');
        $this->private_key = $this->CI->config->item('stripe_private_key');
    }

    /**
     * This function is designed to make a payment
     *
     * @access public
     * @param array $data
     * @param int $type
     * @return mixed boolean | string
     */

    public function do_payment($data) {

        $amount = $data['amount'];
        $currency = $data['currency'];
        $stripeToken = $data['stripeToken'];
        $description = $data['description'];

        $array = array(
                        "amount" => $amount,
                        "currency" => $currency,
                        "card" => $stripeToken,
                        "description" => $description
                    );

        \Stripe\Stripe::setApiKey($this->private_key);

        try {

            // Do payment
           $result = \Stripe\Charge::create($array);


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;

    }

    public function create_customer($token, $data) {

        $data =[
            'source'         => $token,
            'email'          => $data['email'],
            'description'    => $data['desc'],
        ];

        try {

            // Do payment
            $customer = \Stripe\Customer::create($data,  $this->private_key);


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $customer;

    }

    public function get_charge_info($charge_id){

        if(empty($charge_id)){

            return false;
        }

        \Stripe\Stripe::setApiKey($this->private_key);

        \Stripe\Charge::retrieve($charge_id);

        try {

            // Do payment
            $result =  \Stripe\Charge::retrieve($charge_id);


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;
    }

    public function do_paymant_from_customer($data){

        $amount = $data['amount'];
        $currency = $data['currency'];
        $customer_id = $data['customer_id'];
        $description = $data['description'];

        $array = array(
            "amount" => $amount,
            "currency" => $currency,
            "customer" => $customer_id,
            "description" => $description
        );

        if(!empty($data['card'])){

            $array['card'] = $data['card'];

        }

        \Stripe\Stripe::setApiKey($this->private_key);

        try {

            // Do payment
            $result = \Stripe\Charge::create($array);

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;

    }

    public function add_credit_card($customer_id, $token){

        \Stripe\Stripe::setApiKey($this->private_key);

        $customer = \Stripe\Customer::retrieve($customer_id);

        try {

            // Add credit card
            $result = $customer->sources->create(array("source" => $token));


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;

    }

    public function get_card_info($customer_id, $card_id){

        if(empty($customer_id) || empty($card_id)){

            return false;
        }

        \Stripe\Stripe::setApiKey($this->private_key);

        try {

            $customer = \Stripe\Customer::retrieve($customer_id);
            $card = $customer->sources->retrieve($card_id);


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $card;

    }

    public function delete_credit_card($customer_id, $card_id){

        if(empty($customer_id) || empty($card_id)){

            return false;

        }

        \Stripe\Stripe::setApiKey($this->private_key);

        $customer = \Stripe\Customer::retrieve($customer_id);

        try {

            // Delete credit card
            $customer->sources->retrieve($card_id)->delete();


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;

    }

    public function update_credit_card($customer_id, $card_id, $updateing_data){

        if(empty($customer_id) || empty($card_id)){

            return false;

        }

        \Stripe\Stripe::setApiKey($this->private_key);
        $customer = \Stripe\Customer::retrieve($customer_id);
        $card = $customer->sources->retrieve($card_id);
        $card->name = "Andrew Robinson";

        $updating_fiels= [
            'address_city',
            'address_country',
            'address_line1',
            'address_line2',
            'address_state',
            'address_zip',
            'exp_month',
            'exp_year',
            'metadata',
            'name'
        ];

        foreach($updateing_data as $field => $value){
            if(in_array($field, $updating_fiels)){
                $card->$field = $value;
            }
        }

        try {

            // Update credit card
            $result = $card->save();


        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;

    }

    public function refund($data) {

        if(empty($data['charge'])){

            return false;

        }

        \Stripe\Stripe::setApiKey($this->private_key);

        try {

            // Do Refound
            $result = \Stripe\Refund::create($data);

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $result;

    }

    public function create_card_token($card_info){

        \Stripe\Stripe::setApiKey($this->private_key);

        try {

            // create token
            $result = \Stripe\Token::create(array(
                "card" => $card_info
            ));

            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

} // end of lib

/* End of file payment_lib.php*/
