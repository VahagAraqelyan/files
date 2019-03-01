<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['default_subject']  = 'Luggage to Ship support';
$config['subject_description']  = '';
$config['server_email']  = 'info@luggagetoship.com';

$config['registration'] = [
    'title'                  => 'Welcome to Luggage to Ship',
    'view'                   => 'registration_email',
    'attachment'             => '',
    'subject_description'    => 'Hi user_name, thanks for registering with LuggageToShip.com. Your account number is account_number. We are excited to provide you with professional luggage shipping services. ',
];

$config['forgot_password'] = [
    'title'                  => 'Welcome to Luggage to Ship',
    'view'                   => 'forgot_password',
    'attachment'             => '',
    'subject_description'    => 'Hi user_name, we received a password reset request for your account. The temporary password is ********. Please login your account and reset your password in My Profile.  '

];

$config['update_password'] = [
    'title'                  => 'Welcome to Luggage to Ship',
    'view'                   => 'change_password',
    'attachment'             => '',
    'subject_description'    => 'Hi user_name, you have successfully changed password of your Luggage To Ship account. Please always keeps your login information secure and confidential.'
];

$config['change_email'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'change_login_email',
    'attachment' => '',
    'subject_description'    => 'Hi user_name, you have successfully updated the login email of your Luggage To Ship account. We will send all future emails to ..... Thanks'
];

$config['credit_card'] = [
    'title'                 => 'Welcome to Luggage to Ship',
    'view'                  => 'credit_card_my_profile',
    'attachment'            => '',
    'subject_description'   =>'Hi user_name, for security reason, our accounting department would like to verify your credit card ending'
];

$config['incomplete_order'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'complete_submit_order',
    'attachment' => '',
    'subject_description' => 'Hi user_name, you recently created a new shipping order to . If you have not submitted the order, simply login your account, complete and submit the order. Thanks.   '
];

$config['charge_and_label'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'charge_create_label',
    'attachment' => ''
];

$config['international_submited_order'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'inter_submited_order',
    'attachment' => ''
];


$config['dom_submited_no_charge'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'submited_no_charge',
    'attachment' => ''
];

$config['submited_no_label'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'submited_no_label',
    'attachment' => ''
];

$config['admin_edit_items_services'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'admin_edit_items',
    'attachment' => ''
];

$config['item_list_comertial_use'] = [
    'title'      => 'Welcome to Luggage to Shipord',
    'view'       => 'item_list_comertial',
    'attachment' => ''
];

$config['item_list_personal_effect'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'item_list_personal',
    'attachment' => ''
];

$config['admin_submit_all'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'admin_submit_all',
    'attachment' => ''
];

$config['ready_order'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'ready_order',
    'attachment' => ''
];

$config['submit_tracking_only'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'submit_tracking_label_only',
    'attachment' => ''
];

$config['submit_pickup_only'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'submit_pickup_only',
    'attachment' => ''
];

$config['submit_tag_only'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'submit_tag_only',
    'attachment' => ''
];

$config['cancel_before_processed'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'order_canceletion',
    'attachment' => ''
];

$config['cancel_after_processed'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'cancel_after_process',
    'attachment' => ''
];

$config['cancel_after_send_labels'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'cancel_after_send_label',
    'attachment' => ''
];

$config['change_delivery_status'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'change_delivery_status',
    'attachment' => ''
];

$config['corporate_affiliate'] = [
    'title'      => 'Welcome to Luggage to Ship',
    'view'       => 'corporate_affiliate_view',
    'attachment' => ''
];
?>