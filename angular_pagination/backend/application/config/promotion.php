<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['promotion_types'] = [

    'All_shipment'          => [],

    'All_International'     => [
        'shipping_type' => '1',
    ],

    'International_Express' => [
        'shipping_type' => '1',
        'service_type'  => 'express',
    ],

    'International_Economy' => [
        'shipping_type' => '1',
        'service_type'  => 'economy',
    ],
    'All_Domestic'          => [
        'shipping_type' => '2',
    ],

    'Domestic_Express'      => [
        'shipping_type' => '2',
        'service_type'  => 'express',
    ],

    'Domestic_Priority'     => [
        'shipping_type' => '2',
        'service_type'  => 'priority',
    ],

    'Domestic_Standard'     => [
        'shipping_type' => '2',
        'service_type'  => 'standard',
    ],

    'Domestic_Basic'        => [
        'shipping_type' => '2',
        'service_type'  => 'basic',
    ]

];

?>
