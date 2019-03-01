<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['all_statuses'] = [
    INCOMPLETE_STATUS,
    SUBMITTED_STATUS,
    PROCESSED_STATUS,
    CLOSED_STATUS,
    READY_STATUS,
    TRANSIT_STATUS,
    DELIVERY_STATUS,
    PROCESSED_CANCEL_STATUS,
    SUBMITTED_CANCEL_STATUS
];

$config['status_change_types'] = [
    INCOMPLETE_STATUS[0]       => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    SUBMITTED_STATUS[0]        => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    PROCESSED_STATUS[0]        => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    CLOSED_STATUS[0]           => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    READY_STATUS[0]            => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    TRANSIT_STATUS[0]          => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    DELIVERY_STATUS[0]         => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
    PROCESSED_CANCEL_STATUS[0] => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, SUBMITTED_CANCEL_STATUS, READY_STATUS],
    SUBMITTED_CANCEL_STATUS[0] => [SUBMITTED_STATUS, PROCESSED_STATUS, CLOSED_STATUS, TRANSIT_STATUS, DELIVERY_STATUS, PROCESSED_CANCEL_STATUS, READY_STATUS],
];

$config['pdf_false_statuses'] = [
    DELIVERY_STATUS[0],
    CLOSED_STATUS[0],
    PROCESSED_CANCEL_STATUS[0],
    SUBMITTED_CANCEL_STATUS[0]
];

$config['order_file_types'] = [
    'custom_invoice' => [
        'title'       => 'Commercial invoice',
        'value'       => 'custom_invoice',
        'multiselect' =>  true
    ],
    'Passport_copy' => [
        'title'       => 'Passport copy',
        'value'       => 'Passport_copy',
        'multiselect' =>  false
    ],
    'Visa_copy' => [
        'title'       => 'Visa copy',
        'value'       => 'Visa_copy',
        'multiselect' =>  false
    ],
    'Travel_itinry' => [
        'title'       => 'Travel itinry',
        'value'       => 'Travel_itinry',
        'multiselect' =>  false
    ],
    'Personal_effect_document' => [
        'title'       => 'Personal effect document',
        'value'       => 'Personal_effect_document',
        'multiselect' =>  false
    ],
    'Archive_review' => [
        'title'       => 'Archive review',
        'value'       => 'Archive_review',
        'multiselect' =>  true
    ],
    'fedex_second_label' => [
        'title'       => 'Fedex second label',
        'value'       => 'fedex_second_label',
        'multiselect' =>  false
    ],
];


$config['outband_service'] = [

    '0'  => '8:00am to 1:00pm',
    '1'  => '9:00am to 2:00pm',
    '2'  => '10:00am to 3:00pm',
    '3'  => '11:00am to 4:00pm',
    '4'  => '12:00pm to 5:00pm',
    '5'  => '1:00pm to 4:00pm',
    '6'  => '2:00pm to  5:00pm',
    '7'  => '3:00pm to 6:00pm',
    '8'  => '4:00pm to 7:00pm',
    '9'  => '5:00pm to 8:00pm',
    '10' => '6:00pm to 9:00pm'
];

$config['express'] = [

    '0'  => ' 8:00am to 12:00pm',
    '1'  => ' 9:00am to 1:00pm',
    '2'  => '10:00am to 2:00pm',
    '3'  => '11:00am to 3:00pm',
    '4'  => '12:00pm to 4:00pm',
    '5'  => '1:00pm to 4:00pm',
    '6'  => '2:00pm to 5:00pm',
    '7'  => '3:00pm to 6:00pm',
    '8'  => '4:00pm to 7:00pm',
    '9'  => '5:00pm to 8:00pm',
    '10' => '6:00pm to 9:00pm'
];


$config['inbound_service'] = [

    '0'  => '10:00am to 4:00pm',
    '1'  => '11:00am to 5:00pm',
    '2'  => '12:00am to 6:00pm'
];

$config['basic'] = [
    '0'  => '8:00am to 3:00pm',
    '1'  => '9:00am to 4:00pm',
    '2'  => '10:00am to 5:00pm',
    '3'  => '11:00am to 6:00pm',
    '4'  => '12:00pm to 7:00pm',
    '5'  => '1:00pm to 8:00pm',
    '6'  => '2:00pm to  9:00pm',
];

$config['admin_reason'] = [
    "Tax and duties",
    "Warehouse storage fee",
    "Damaged item",
    "Lost package",
    "Delayed services",
    "Other LST service fault",
    "Customer Promotion"
];

?>