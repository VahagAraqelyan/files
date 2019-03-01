<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'Custom404';
$route['translate_uri_dashes'] = FALSE;
$route['login']='user/login';
$route['check_price']='price_page/price_page';
$route['registration']='user/registration';
$route['forgot_password']='user/forgot_password';
$route['dashboard']='dashboard/dashboard/';

$route[ADMIN_PANEL_URL] = 'admin/admin/index';
$route[ADMIN_PANEL_URL.'/user_manage'] = 'admin/user_manage';
$route[ADMIN_PANEL_URL.'/user_manage/(:any)'] = 'admin/user_manage/$1';
$route[ADMIN_PANEL_URL.'/(:any)'] = 'admin/admin/$1';

//Public Pages
$route['luggage-storage-services']        = 'Public_pages/get_public_pages/storage_services';
$route['how-luggage-shipping-works']      = 'Public_pages/get_public_pages/shipping_works';
$route['domestic-luggage-shipping']       = 'Public_pages/get_public_pages/domestic_luggage_shipping';
$route['international-luggage-delivery']  = 'Public_pages/get_public_pages/international_luggage_shipping';
$route['luggage-shipping-partners']       = 'Public_pages/get_public_pages/partners';
$route['site-map']                        = 'Public_pages/get_public_pages/site_map';
$route['ship-to-school']                  = 'Public_pages/get_public_pages/student';
$route['how-to-pack-luggage']             = 'Public_pages/get_public_pages/packing_labels';
$route['what-cant-ship']                  = 'Public_pages/get_public_pages/prohibited_items';
$route['luggage-weight']                  = 'Public_pages/get_public_pages/calc_weight_size';
$route['luggage-drop-of-location/(.+)']   = 'Public_pages/drop_of_locations/$1';
$route['luggage-drop-of-location']        = 'Public_pages/drop_of_locations';
$route['luggage-and-question']            = 'Public_pages/get_questions';
$route['luggage-and-question/(.+)']       = 'Public_pages/get_questions/$1';
$route['contact-luggage-to-ship']         = 'Public_pages/get_public_pages/contact_us';
$route['luggage-tracking/(.+)']           = 'Public_pages/luggage_trucking/$1';
$route['luggage-tracking']                = 'Public_pages/luggage_trucking';
$route['about-luggagetoship']             = 'Public_pages/get_public_pages/about_us';
$route['luggagetoship-business-programs'] = 'Public_pages/get_public_pages/business';
$route['luggagetoship-terms-of-use']      = 'Public_pages/get_public_pages/terms_of_use';
$route['luggagetoship-privacy-policy']    = 'Public_pages/get_public_pages/privacy_policy';
$route['luggage-weight']                  = 'Public_pages/get_public_pages/calc_weight_size';

//Public Pages Luggage
$route['shipping-luggage']          = 'Public_pages/get_prod_by_type/4';
$route['shipping-boxes']            = 'Public_pages/get_prod_by_type/5';
$route['shipping-golf-club']        = 'Public_pages/get_prod_by_type/6';
$route['shipping-ski-snowboard']    = 'Public_pages/get_prod_by_type/7';
$route['bike']                      = 'Public_pages/get_bike/7';
$route['shipping-rates']            = 'Public_pages/get_bike/4';
