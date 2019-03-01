<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['special_box_sizes_ranges'] = [
     [
         'from' => 5,
         'to'   => 41,
         'size' => 'small box'
     ],
     [
         'from' => 42,
         'to'   => 59,
         'size' => 'standard box'
     ],
     [
         'from' => 60,
         'to'   => INF,
         'size' => 'large box'
     ],
];

$config['international_fee_limit'] = [
    [
        'from' => 1,
        'to'   => 1,
        'column' => 'international_fee'
    ],
    [
        'from' => 2,
        'to'   => 2,
        'column' => 'international_fee_1'
    ],
    [
        'from' => 3,
        'to'   => INF,
        'column' => 'international_fee_2'
    ],
];

$config['special_box_add_data'] = [
    'weight' => 5,
    'width'  => 1,
    'height' => 1,
    'length' => 1
];

$config['times'] = [
    'default'        => '09:00am to 06:00pm',
    'morning'        => '08:30am to 11:00am',
    'afternoon'      => '11:00am to 03:30pm',
    'sat'            => '09:00am to 01:00pm',
    'international'  => '09:00am to 06:00pm'
];

?>