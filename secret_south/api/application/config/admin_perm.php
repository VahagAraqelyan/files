<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['all_permissions'] = [
    PROFILE_PERM,
    SUPER_ADMIN_PERM,
    MANAGE_PRICE_PERM,
    PROMOTION_PERM,
    REPORT_PERM,
    INCOMPLETE_ORDER_PERM,
    ORDER_HISTORY_PERM,
    CUSTOMER_LIST_PERM,
    CHECK_PRICE_REPORTS,
    STATISTIC
];

$config['section_url'] = [
    PROFILE_PERM[0]          => ['url' => 'admin/admin/profile','data_block' => 'profile'],
    SUPER_ADMIN_PERM[0]      => ['url' => 'admin/manage_admin','data_block' => 'manage_admin'],
    MANAGE_PRICE_PERM[0]     => ['url' => 'admin/price_page/manage_price/226','data_block' => 'manage_price'],
    PROMOTION_PERM[0]        => ['url' => 'admin/promotion/promotion','data_block' => 'promotion'],
    REPORT_PERM[0]           => ['url' => 'admin/order/report','data_block' => 'report'],
    INCOMPLETE_ORDER_PERM[0] => ['url' => 'admin/order/uncompeted_order','data_block' => 'finsih_order'],
    ORDER_HISTORY_PERM[0]    => ['url' => 'admin/order/order_history','data_block' => 'order_history'],
    CUSTOMER_LIST_PERM[0]    => ['url' => 'admin/user_manage/customer_list','data_block' => 'customer_list'],
    CHECK_PRICE_REPORTS[0]   => ['url' => 'admin/user_manage/price_check_reports','data_block' => 'price_check_reports'],
    STATISTIC[0]             => ['url' => 'admin/statistic','data_block' => 'statistic']
];

?>

