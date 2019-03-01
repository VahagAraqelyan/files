<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('change_order_type')){

    function change_order_type($type,$currier_name,$shipping_type,$action = NULL){

        if(empty($type) || empty($currier_name) || empty($shipping_type)){

            return '';
        }

        if($currier_name == 'FedEx' && $action == 'order'){
            if($shipping_type == 2){
                if(stripos($type, 'Basic') !== false){
                    $type = 'Basic Service';
                }else{
                    $type = str_ireplace(array('Express','Priority','Standard'),'',$type);

                    if(stripos($type, 'afternoon') !== false){
                        $type = str_ireplace('afternoon','PM',$type);
                    }elseif (stripos($type, 'morning') !== false){
                        $type = str_ireplace('morning','AM',$type);
                    }
                }
            }else{
                if(stripos($type, 'Express') !== false){
                    $type = 'Express';
                    $type = str_ireplace('days','',$type);

                }elseif (stripos($type, 'Economy') !== false){
                    $type = 'Economy';
                    $type = str_ireplace('days','',$type);

                }
            }

        }elseif($shipping_type == 1){
            if(stripos($type, 'Express') !== false){
                $type = 'Express';
                $type = str_ireplace('days','',$type);

            }elseif (stripos($type, 'Economy') !== false){
                $type = 'Economy';
                $type = str_ireplace('days','',$type);

            }


        }elseif ($shipping_type == 2){
            if($currier_name == 'DHL' && $shipping_type == 1){
                if(stripos($type, 'Express') !== false){
                    $type = 'Express';

                }
            }elseif(stripos($type, 'Basic') !== false){
                $type = 'Basic Service';
            }else{
                $type = str_ireplace(array('Express','Priority','Standard'),'',$type);

                if(stripos($type, 'afternoon') !== false){
                    $type = str_ireplace('afternoon','PM',$type);
                }elseif (stripos($type, 'morning') !== false){
                    $type = str_ireplace('morning','AM',$type);
                }
            }

        }elseif($currier_name == 'DHL' && $shipping_type == 1){
            if(stripos($type, 'Express') !== false){
                $type = 'Express';

            }
        }

        return $type;
    }

}