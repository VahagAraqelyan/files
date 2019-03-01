<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * LTS Configuration constants
 */
// Pages content caching
define('ENABLE_PAGES_CACHING', false);

// Allowed cache types file, memcached
define('ASSETS_CACHING_TYPE', 'memcached');

// Assets (CSS/JS) Caching
define('ENABLE_ASSETS_CACHING', false);


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| User, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and User
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid User input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('ADMIN_PANEL_URL', 'lts-panel');

//Shippo constants
define('SHIPPO_API_KEY', 'shippo_live_797a40d9cb75855556328167acb29921c0b9be44');
//define('SHIPPO_API_KEY', 'shippo_test_0a36838d1c726b81695dfecbbee0af901c056840');

define('REGISTER_WEB_HOOK_URL', 'https://api.goshippo.com/tracks/');

//Order status constants
defined('INCOMPLETE_STATUS')       OR define('INCOMPLETE_STATUS',       array('1','Incomplete'));
defined('SUBMITTED_STATUS')        OR define('SUBMITTED_STATUS',        array('2','Submitted'));
defined('PROCESSED_STATUS')        OR define('PROCESSED_STATUS',        array('3','Processed'));
defined('CLOSED_STATUS')           OR define('CLOSED_STATUS',           array('5','Closed'));
defined('READY_STATUS')            OR define('READY_STATUS',            array('6','Ready Order'));
defined('TRANSIT_STATUS')          OR define('TRANSIT_STATUS',          array('7','In Transit'));
defined('DELIVERY_STATUS')         OR define('DELIVERY_STATUS',         array('8','Delivered'));
defined('SUBMITTED_CANCEL_STATUS') OR define('SUBMITTED_CANCEL_STATUS', array('9','Cancelled'));
defined('PROCESSED_CANCEL_STATUS') OR define('PROCESSED_CANCEL_STATUS', array('10','Cancelled'));

// INVOICE VIEW VERIFICATION CODE
defined('VIEW_INVOICE_CODE') OR define('VIEW_INVOICE_CODE', 'GVVIEINVOICEVERNUMSA564SAD654ASD464SA3D26');

// MODIFY ORDER FREEZE INTERVAL (minutes)
defined('FREEZE_INTERVAL') OR define('FREEZE_INTERVAL', 15);

// DEVELOPERS EMAIL
defined('DEVELOPERS_EMAIL') OR define('DEVELOPERS_EMAIL', array('gevorg.dev@gmail.com', 'khazaryan@gmail.com', 'vahagn.dev@gmail.com', 'mku.aie@gmail.com', 'may@aieexpress.com'));


//Admin permissions
defined('SUPER_ADMIN_PERM')       OR define('SUPER_ADMIN_PERM',      array('1','Manage admin'));
defined('PROFILE_PERM')           OR define('PROFILE_PERM',          array('2','Profile'));
defined('MANAGE_PRICE_PERM')      OR define('MANAGE_PRICE_PERM',     array('3','Manage Price'));
defined('PROMOTION_PERM')         OR define('PROMOTION_PERM',        array('5','Promotion'));
defined('REPORT_PERM')            OR define('REPORT_PERM',           array('6','Report'));
defined('INCOMPLETE_ORDER_PERM')  OR define('INCOMPLETE_ORDER_PERM', array('7','Incomplete Order'));
defined('ORDER_HISTORY_PERM')     OR define('ORDER_HISTORY_PERM',    array('8','Order History'));
defined('CUSTOMER_LIST_PERM')     OR define('CUSTOMER_LIST_PERM',    array('9','Customer List'));
defined('CHECK_PRICE_REPORTS')    OR define('CHECK_PRICE_REPORTS',   array('10','Price Check Reports'));
defined('STATISTIC')              OR define('STATISTIC',             array('11','Order Statistic'));
