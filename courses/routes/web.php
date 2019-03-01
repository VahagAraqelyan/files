<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'HomeController@main');

Route::get('/pricing_plan', 'PricingController@pricing_plan')->name('pricing_plan');
Route::get('/training_room', 'TrainingController@index');
Route::get('/profile', 'ProfileController@index');
Route::get('/reset_password', 'HomeController@reset_password');
Route::get('/change_plan', 'PricingController@change_plan');
Route::get('/get_plan/{id}/{action}', 'PricingController@get_plan')->where('id', '[0-9]+');
Route::get('/example/{id}', 'TrainingController@example')->where('id', '[0-9]+');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact', 'HomeController@contact');
Route::get('/about_us', 'HomeController@about_us');
Route::get('/faq', 'HomeController@faq');


Route::post('/ax_ordering_subject', 'HomeController@ax_ordering_subject');

Route::get('admin-dashboard', 'Admin\AdminController@dashboard');

Route::get('/admin/dashboard', 'Admin\AdminController@dashboard');
Route::get('/admin/enable_work', 'Admin\AdminController@enable_work');
Route::get('/admin/all_subject', 'Admin\SubjectController@all_subject');
Route::get('/admin/all_subject_type', 'Admin\SubjectController@all_subject_type');
Route::get('/admin/add_lesson', 'Admin\LessonController@add_lesson');
Route::get('/admin/all_lesson', 'Admin\LessonController@all_lesson');
Route::get('/admin/add_quiz', 'Admin\QuizController@add_quiz');
Route::get('/admin/all_quiz', 'Admin\QuizController@all_quiz');
Route::get('/admin/add_example', 'Admin\QuizController@add_example');
Route::get('/admin/all_user_check', 'Admin\CheckController@get_all_user_check');
Route::get('/admin/add_user', 'Admin\CheckController@add_user');

Route::get('/admin/update_template', 'Admin\PageTemplateController@update_template');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/admin-panel', 'Auth\LoginController@showAdminLoginForm');
Route::get('/add_subject', 'Admin\SubjectController@add_subject');
Route::get('/add_subject_type', 'Admin\SubjectController@subject_type');

Route::post('/ax_save_exam_answer', 'TrainingController@ax_save_exam_answer');
Route::post('/ax_save_user_info',   'ProfileController@ax_save_user_info');
Route::post('/ax_delete_avatar',   'ProfileController@ax_delete_avatar');
Route::post('/ax_check_password',   'ProfileController@ax_check_password');
Route::post('/ax_change_email',   'ProfileController@ax_change_email');
Route::post('/ax_save_check',   'PricingController@ax_save_check');
Route::post('/ax_change_premium',   'PricingController@ax_change_premium');

Route::post('/ax_save_subject_type', 'Admin\SubjectController@ax_save_subject_type');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/add_records/ax_save_records', 'RecordsController@ax_save_records');
Route::post('/ax_save_subject', 'Admin\SubjectController@ax_save_subject');
Route::post('/upload_file', 'Admin\LessonController@upload_file');
Route::post('/ax_save_lesson', 'Admin\LessonController@ax_save_lesson');
Route::post('/ax_update_lesson', 'Admin\LessonController@ax_update_lesson');
Route::post('/ax_save_update_lesson', 'Admin\LessonController@ax_save_update_lesson');
Route::post('/ax_delete_lesson', 'Admin\LessonController@ax_delete_lesson');
Route::post('/ax_upload_video', 'Admin\LessonController@ax_upload_video');
Route::post('/ax_save_quiz', 'Admin\QuizController@ax_save_quiz');
Route::post('/ax_save_exam', 'Admin\QuizController@ax_save_exam');
Route::post('/ax_upload_quiz_file', 'Admin\QuizController@ax_upload_quiz_file');
Route::post('/ax_save_quiz_answer', 'Admin\QuizController@ax_save_quiz_answer');
Route::post('/ax_update_quiz', 'Admin\QuizController@ax_update_quiz');
Route::post('/ax_save_update_quiz', 'Admin\QuizController@ax_save_update_quiz');
Route::post('/ax_upload_updatet_quiz_file', 'Admin\QuizController@ax_upload_updatet_quiz_file');
Route::post('/ax_check_coupon', 'Admin\CheckController@ax_check_coupon');
Route::post('/ax_save_check_coupon', 'Admin\CheckController@ax_save_check_coupon');
Route::post('/ax_update_subject', 'Admin\SubjectController@ax_update_subject');
Route::post('/ax_save_edit_subject', 'Admin\SubjectController@ax_save_edit_subject');
Route::post('/ax_delete_subject', 'Admin\SubjectController@ax_delete_subject');
Route::post('/ax_update_subject_type', 'Admin\SubjectController@ax_update_subject_type');
Route::post('/ax_save_edit_subject_type', 'Admin\SubjectController@ax_save_edit_subject_type');
Route::post('/ax_delete_subject_type', 'Admin\SubjectController@ax_delete_subject_type');
Route::post('/ax_get_statistic', 'Admin\AdminController@ax_get_statistic');
/*Route::post('/ax_remove_image', 'Admin\LessonController@ax_remove_image');*/
Route::post('/ax_open_course', 'HomeController@ax_open_course');
Route::post('/ax_update_enable', 'Admin\AdminController@ax_update_enable');
Route::post('/ax_save_user', 'Admin\CheckController@ax_save_user');
Route::post('/ax_delete_user', 'Admin\CheckController@ax_delete_user');
Route::post('/ax_parse_html', 'Admin\PageTemplateController@ax_parse_html');
Route::post('/ax_save_page', 'Admin\PageTemplateController@ax_save_page');
Route::post('/ax_revert_page', 'Admin\PageTemplateController@ax_revert_page');


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/artisan_command', function() {
    $exitCode = Artisan::call('php artisan clear-compiled');
   // $exitCode2 = Artisan::call('php artisan dump-autoload');
// return what you want
});
