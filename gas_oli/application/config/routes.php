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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin-panel']              = 'admin/admin/login';
$route['admin/dashboard']          = 'admin/dashboard/index';
$route['admin/dashboard']          = 'admin/dashboard/dashboard';
$route['admin/steersman']          = 'admin/steersman/index';
$route['admin/get_all_wells']      = 'admin/well/index';
$route['admin/get_all_wells']      = 'admin/well/get_all_wells';
$route['steersman/add_steersman']  = 'admin/steersman/add_steersman';
$route['well/add_wells']           = 'admin/well/add_wells';

/*well_id =>100 / 10-02-061-12 W5 / 2
Well Name => ACCEL HOLDINGS CARSON 10-31-61-12
Surface Location => 10-31-061-12W5M1
Well Status => GAS SUSP
Surface Latitude => 54.277546
Surface Longitude => -115.685753
company => company1
company_field => company_field10
comment => comment
state => state*/

