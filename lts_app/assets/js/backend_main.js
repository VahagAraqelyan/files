
$('#change-captcha').click(function(){

    var ajax_url=base_url+"admin/get_new_captcha";
    send_ajax(ajax_url, 'post', {}, {answer:'#captcha-div'});

});
$(function() {

    $('.extra-date').datepicker({
        multidate: true,
        format:'yyyy-mm-dd'
    });

});

$(function() {

    $('#dinamic_date').datepicker({
        multidate: true,
        format:'mm-dd'
    });

});

$('.extra-date').on('changeDate', function(ev){

    var dateval =  $('.hidden_date').val();
    $('.extra_calendar').html('');
    if(dateval == ''){

        $('.extra_calendar').first().append('<div></div>');

    }else{

        dateval = dateval.split(',');

        for(var i = 0; i<dateval.length; i++){


            $('.extra_calendar').append('<div class="extra_calendar_child"><span>'+dateval[i]+'</span></div>');
            $('#date_table thead th:nth-of-type(1)').attr('colspan', i+1);

        }

        $('.extra_calendar').append('<br class="clear">')
    }

});

$('#dinamic_date').on('changeDate', function(ev){

    var date =  $('.hidden_dinamic_date').val();
    $('.dinamic_calendar').html('');
    if(date == ''){

        $('.dinamic_calendar').first().append('<div></div>');

    }else{

        date = date.split(',');

        for(var i = 0; i<date.length; i++){


            $('.dinamic_calendar').append('<div class="dinamic_calendar_child"><span>'+date[i]+'</span></div>');
            $('#dinamic_table thead th:nth-of-type(1)').attr('colspan', i+1);

        }

        $('.dinamic_calendar').append('<br class="clear">')
    }

});


$('.click_calendar').click(function () {

    $(".extra-date").focus();


});

$('.click_dinamic_calendar').click(function () {

    $("#dinamic_date").focus();


});
$('.admin_menu').click(function () {
    $('.admin_menu').removeClass('active');
});

$(function() {
    var menu_arr = ['profile','manage_price','customer_list','manage_admin','promotion','report','finsih_order','order_history'];
    var link = $(location).attr('href');
    var link_arr = link.split('/');
    link = $(link_arr).last();
    if($.inArray(link[0],menu_arr) == -1 ||
        !$.isNumeric(link[0])){

        return false;
    }
    if(link[0] == '' || $.isNumeric(link[0])){
        var a = link_arr.pop();
        link = $(link_arr).last();
    }

    $('[data-block = '+link[0]+']').addClass('active');

});




$('.admin_menu').click(function () {

    $(this).addClass('active');


});

$('#edit_profile').click(function () {

    $('#edit_profile_form > *').find('input').removeClass('error_red_class');

    var log = true;

    var login_fields  = {

        admin_name:{errorname:'Admin name', required: true,minlength:2 },
        email_id:{errorname:'Email', required: true, emailvalid:true },
        password:{errorname:'Password', minlength:8},
        confirm_password:{errorname:'Confirm password', equal:'password'}
    };



    $.each(login_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;
            return false
        }

    });

    $('#show_error_img').removeClass('error_img');
    $(".show_login_error").html('');

    if (!log){
        $('.show_login_error').removeClass('success_class');
        $(".show_login_error").html(error);
        $('#show_error_img').addClass('error_img');
    }
    else {

        $('#edit_profile_form').submit();
    }

});


$(document).on('keypress', '#update_user_address #zip_code', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});

$(document).on('keypress', '#add_new_addr_form #zip_code', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});
$(document).on('keypress', '#traveler_add_update #zip_code', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});


$(document).on('keypress', '#update_info_form_1 #zip_code_1', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});
$(document).on('keypress', '#update_info_form_2 #zip_code_2', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});
$(document).on('keypress', '#update_info_form_3 #zip_code_3', function (key){
    if(key.charCode < 48 || key.charCode > 57){

        return false;
    }

});

$(document).ajaxComplete(function() {
    $('[data-toggle="popover"]').popover();
});

$('#admin_login').click(function () {


    $('#admin_log_form > *').find('input').removeClass('error_red_class');

    var log = true;

    var login_fields  = {

        username:{errorname:'User name', required: true },
        password:{errorname:'Password', required: true, minlength:8},
        code:{errorname:'Security code', required: true, length:4}
    };



    $.each(login_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;
            return false
        }

    });

    $('#show_error_img').removeClass('error_img');
    $(".show_login_error").html('');

    if (!log){

        $(".show_login_error").html(error);
        $('#show_error_img').addClass('error_img');
    }
    else {

        $('#admin_log_form').submit();
    }
});



$('#costumer_list').click(function () {

    // get_customer_list(1);

});


$(document).on('click','#search_butt',function () {

    var page = $(this).attr('data-ci-pagination-page');
    var search_arr = {
        'account_name': $('#account_name').val(),
        'first_name':   $('#username').val(),
        'email':        $('#email').val()

    };
    var send_data = {page: page, search:search_arr};
    var url = base_url + "user_manage/ax_customer_list/";
    send_ajax(url, 'post', send_data, {answer: '#main_content'});

});

$(document).on('click','#viewall',function () {

    var send_data = {all:true};
    var url = base_url + "user_manage/ax_customer_list/";
    send_ajax(url, 'post', send_data, {answer: '#main_content'});

});


$(document).on('click','#update_status',function () {

    var send_data = $('#update_status_form').serializeArray();
    var url = base_url + "user_manage/ax_update_status/";
    send_ajax(url, 'post', send_data, {handler:'update_user_status',beforsend:'$("#show_error_my_profile").html("")'});

});



function update_user_status(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        var user_id = $('#user_id').val();
        $('#show_error_my_profile').addClass('success_class');
        $("#show_error_my_profile").html(obj['success']);
        location.reload();
        edit_user_profile(user_id);

    }
}

function get_traveler_list(page,suc_func) {
    var send_data = {page: page, user_id:$('#user_id').val()};
    var url = base_url + "user_manage/ax_traveler_list/" + (page - 1) * traveler_list_row_count;
    send_ajax(url, 'post', send_data, {answer: '#traveller_list_content', success:suc_func, abort:true});
}


$(document).on('click', '#traveler_list_link', function () {
    get_traveler_list(1);
});

$(document).on('click', '.travel_pagination', function () {

    var page = $(this).attr('data-ci-pagination-page');
    get_traveler_list(page);

});

$(document).on('click', '#add_new_traveller', function (){

    var url = base_url + 'user_manage/ax_add_new_traveler';
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh')";
    var send_data = $('#user_id').val();
    send_ajax(url, 'post', {user_id:send_data}, {answer: '#my_profile_modal_content', success: sucFunc,beforsend:'$("#my_profile_modal_content").html("")'});

});

$(document).on('change', '#country-select', function () {

    var url = base_url + "user_manage/get_states/get_traveller_state_select";
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh')";
    send_ajax(url, 'post', {country: $(this).val()}, {
        answer: ' #state-select',
        success: sucFunc
    });

});

$(document).on('change', '#country_select', function () {

    var url = base_url + "user_manage/get_states/get_traveller_state_select";
    var sucFunc = "$('#update_user_address').find('*').selectpicker('refresh')";
    send_ajax(url, 'post', {country: $(this).val()}, {
        answer: ' #state-select',
        success: sucFunc
    });

});

$(document).on('click', '#add_traveler_but', function () {

    $('#traveler_add_update > *').find('*').removeClass('error_red_class');
    var log = true;

    var traveler_fields = {
        first_name: {errorname: 'First name', required: true, minlength: 2},
        last_name: {errorname: 'Last name', required: true, minlength: 2},
        phone_number: {errorname: 'Phone Number', required: true,minlength:5,maxlength:22}
    };

    $.each(traveler_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {

        $("#traveler_add_update #traveler_error").addClass('error_class');
        $('#traveler_add_update #add_error_img').addClass('error_img');
        $("#traveler_add_update #traveler_error").html(error);

    } else {

        var ser = $('#traveler_add_update').serializeArray();
        var send_data = ser;
        var url = base_url + "user_manage/ax_check_add_traveler";
        send_ajax(url, 'post', send_data, {handler: 'show_message'});

    }

});
function show_message(data) {

    $("#traveler_add_update #traveler_error").html('');
    $('#traveler_add_update #add_error_img').removeClass('error_img');
    $('#traveler_add_update #traveler_error').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#my_profile_modal').modal('show');
    if (obj["error"].length > 0) {

        $('#traveler_add_update #add_error_img').addClass('error_img');
        $("#traveler_add_update #traveler_error").html(obj['error']);
    }
    else {
        $('#traveler_add_update #traveler_error').addClass('success_class');
        $("#traveler_add_update #traveler_error").html(obj['success']);

        $('#my_profile_modal').modal('hide');
        var script = "$('.panel-body>div').first().addClass('table-row-success')";
        get_traveler_list(1, script);

    }

}


$(document).on('click', '#edit_traveller', function () {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class ');
    var result = [];
    var error_text = '';
    var checkarray = $('.traveler_list_checkbox');

    for (var i = 0; i < checkarray.length; i++) {
        if (checkarray[i].checked) {
            result.push(checkarray[i]);

        }
    }
    if (result.length < 1) {

        error_text = 'Please select a record to edit.'

    } else if (result.length > 1) {

        error_text = 'Please select only one record to edit.';

    }

    if (error_text != '') {
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error_text);

        return false;
    }
    $('#my_profile_modal').modal('show');
    var send_data = {traveler_id:$('.traveler_list_checkbox:checked').val(),user_id:$('#user_id').val()};
    traveler_row_id = send_data['traveler_id'];
    var url = base_url + "user_manage/ax_edit_traveler";
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
    send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content', success: sucFunc,beforsend:'$("#show_error_my_profile").html("")'});


});

$(document).on('click', '#edit_traveler_but', function () {

    $('#traveler_add_update > *').find('*').removeClass('error_red_class');
    var log = true;

    var traveler_fields = {
        first_name: {errorname: 'First name', required: true, minlength: 2},
        last_name: {errorname: 'Last name', required: true, minlength: 2},
        phone_number: {errorname: 'Phone Number', required: true, minlength:5,maxlength:22},
    };

    $.each(traveler_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {
        $("#traveler_add_update #traveler_error").addClass('error_class');
        $('#traveler_add_update #add_error_img').addClass('error_img');
        $("#traveler_add_update #traveler_error").html(error);

    } else {

        var send_data = $('#traveler_add_update').serializeArray();
        var url = base_url + "user_manage/ax_check_edit_traveler";
        send_ajax(url, 'post', send_data, {handler: 'show_edit_traveler_message'});
    }
});

function show_edit_traveler_message(data) {

    $("#traveler_add_update #traveler_error").html('');
    $('#traveler_add_update #add_error_img').removeClass('error_img');
    $('#traveler_add_update #traveler_error').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#my_profile_modal').modal('show');

    if (obj["errors"].length > 0) {
        $('#traveler_add_update #add_error_img').addClass('error_img');
        $("#traveler_add_update #traveler_error").html(obj['error']);
    }
    else {
        $('#traveler_add_update #traveler_error').addClass('success_class');
        $("#traveler_add_update #traveler_error").html(obj['success']);
        $('#my_profile_modal').modal('hide');
        var sucFunctpart='$("[data-id=\''+traveler_row_id+'\']").addClass("table-row-success");';
        get_traveler_list(1, sucFunctpart);

    }

}

$(document).on('click', '#delete_traveler', function () {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var result = [];
    var error_text = '';
    var checkarray = $('.traveler_list_checkbox:checked');

    if (checkarray.length < 1) {

        error_text = 'Please select a record to delete.'

    }

    if (error_text != '') {

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error_text);

        return false;
    }

    bootbox.confirm({
        message: "Are you sure, you want to delete record?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var user_id = $('#user_id').val();
                var send_data = {check:checkarray.serializeArray(),user_id:user_id};
                var url = base_url + "user_manage/ax_delete_traveler";
                send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content',handler:'show_del_messages',beforsend:'$("#show_error_my_profile").html("")'});
            }
        }
    });
});

function show_del_messages(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#upload_modal').modal('show');
    if (obj["errors"].length > 0) {

        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(obj['error']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $("#show_error_my_profile").html(obj['success']);
        get_traveler_list(1,'' );

    }
}

$(document).on('click', '.trav_inf', function () {

    var user_id = $('#user_id').val();
    var trav_id = $(this).attr('data-blok');
    var url = base_url+'user_manage/ax_view_traveler_info';
    var send_data={trav_id:trav_id,user_id:user_id};
    send_ajax(url, 'post', send_data, {answer:'#my_profile_modal_content',beforsend:'$("#my_profile_modal_content").html("")'});

});

/*Address book*/

$(document).on('click', '.addrbook_pagination', function () {

    var page = $(this).attr('data-ci-pagination-page');
    get_address_book(page, '');

});

function get_address_book(page,suc_func) {

    var user_id = $('#user_id').val();
    var send_data = {page: page,user_id:user_id};
    var url = base_url + "user_manage/ax_address_book_list/" + (page - 1) * addres_book_list_row_count;
    send_ajax(url, 'post', send_data, {answer: '#address_book_content', success:suc_func, abort:true});
}

$(document).on('click', '#address_book_link', function(){

    get_address_book(1,'');

});

$(document).on('click', '#add_new_addr', function(){

    var url = base_url+'user_manage/ax_add_address_book';
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
    var send_data = $('#user_id').val();
    send_ajax(url,'post',{user_id:send_data},{answer:'#my_profile_modal_content', success:sucFunc,beforsend:'$("#show_error_my_profile").html("")'});

});

$(document).on('click', '#add_new_addr_book', function(){

    $('#add_new_addr_form > *').find('*').removeClass('error_red_class');
    var log = true;

    var address_book_fields = {
        add_addr_country: {errorname: 'Country', required: true, select_valid:{State:'#state-select',Zip:'#zip_code'}},
        address_1: {errorname: 'Address 1', required: true}
    };

    $.each(address_book_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {

        $("#add_error_img").addClass('error_img');
        $('#traveler_error').addClass('error_class');
        $("#traveler_error").html(error);

    }
    else{

        var url = base_url+'user_manage/ax_check_add_address_book';
        var send_data=$('#add_new_addr_form').serializeArray();
        send_ajax(url,'post', send_data, {handler:'show_add_book_message'});

    }
});

function show_add_book_message(data) {

    $("#traveler_error").html('');
    $('#add_error_img').removeClass('error_img');
    $('#traveler_error').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#my_profile_modal').modal('show');
    if (obj["errors"].length > 0) {

        $('#add_error_img').addClass('error_img');
        $('#traveler_error').html(obj['errors']);
    }
    else {
        $('#traveler_error').addClass('success_class');
        $("#traveler_error").html(obj['success']);

        $('#my_profile_modal').modal('hide');
        var script = "$('.panel-body>div').first().addClass('table-row-success')";
        get_address_book(1,script);

    }

}

$(document).on('click', '#edit_address_book', function () {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class ');
    var result = [];
    var error_text = '';
    var checkarray = $('.address_book_list_checkbox');

    for (var i = 0; i < checkarray.length; i++) {
        if (checkarray[i].checked) {
            result.push(checkarray[i]);

        }
    }
    if (result.length < 1) {

        error_text = 'Please select a record to edit.'

    } else if (result.length > 1) {

        error_text = 'Please select only one record to edit.';

    }

    if (error_text != '') {

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error_text);

        return false;
    }

    $('#my_profile_modal').modal('show');
    var send_data = {addr_book:$('.address_book_list_checkbox:checked').val(),user_id:$('#user_id').val()};
    address_book_row_id = send_data['addr_book'];
    var url = base_url + "user_manage/ax_edit_address_book";
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
    send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content', success: sucFunc,beforsend:'$("#show_error_my_profile").html("")'});


});

$(document).on('click', '#edit_addr_book', function () {

    $('#add_new_addr_form > *').find('*').removeClass('error_red_class');
    var log = true;

    var address_book_fields = {
        add_addr_country: {errorname: 'Country', required: true},
        address_1: {errorname: 'Address 1', required: true}
    };

    $.each(address_book_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {
        $("#traveler_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#traveler_error").html(error);

    } else {

        var send_data = $('#add_new_addr_form').serializeArray();
        var url = base_url + "user_manage/ax_check_edit_address_book";
        send_ajax(url, 'post', send_data, {handler: 'show_edit_address_book_message'});
    }
});

function show_edit_address_book_message(data) {

    $('#traveler_error').html('');
    $('#add_error_img').removeClass('error_img');
    $('#traveler_error').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#my_profile_modal').modal('show');

    if (obj["errors"].length > 0) {
        $(' #add_error_img').addClass('error_img');
        $(" #traveler_error").html(obj['errors']);
    }
    else {

        $('#traveler_error').addClass('success_class');
        $('#traveler_error').html(obj['success']);
        $('#my_profile_modal').modal('hide');
        var sucFuncpart='$("[addres-book-data = \''+address_book_row_id+'\']").addClass("table-row-success");';
        get_address_book(1, sucFuncpart);

    }

}

$(document).on('click', '.view_address_book', function () {

    var addr_book_id = $(this).attr('data-blok');
    var url = base_url+'user_manage/ax_view_address_book';
    var send_data={addr_id:addr_book_id,user_id:$('#user_id').val()};
    send_ajax(url, 'post', send_data, {answer:'#my_profile_modal_content',beforsend:'$("#my_profile_modal_content").html("")'});

});

$(document).on('click', '#delete_address_book', function () {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var result = [];
    var error_text = '';
    var checkarray = $('.address_book_list_checkbox:checked');

    if (checkarray.length < 1) {

        error_text = 'Please select a record to delete.'

    }

    if (error_text != '') {

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error_text);

        return false;
    }

    bootbox.confirm({
        message: "Are you sure, you want to delete record?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var user_id = $('#user_id').val();
                var send_data = {check:checkarray.serializeArray(),user_id:user_id};
                var url = base_url + "user_manage/ax_delete_address_book";
                send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content',handler:'show_del_addr_book_messages',beforsend:'$("#show_error_my_profile").html("")'});
            }
        }
    });
});

function show_del_addr_book_messages(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    $('#upload_modal').modal('show');
    if (obj["errors"].length > 0) {

        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $("#show_error_my_profile").html(obj['success']);
        get_address_book(1,'' );

    }
}

$(document).on('click', '#user_numbers_butt', function (){

    $('#user_numbers > *').find('input').removeClass('error_red_class');
    $('#show_error_my_profile').removeClass('success_class');
    var log = true;

    if($('#cell_phone').val() == '' && $('#fax_number').val() == '' && $('#home_phone').val() == ''){

        log = false;
    }

    if(!log){
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html('Fill in related information for save');

        return false
    }

    var user_numbers = {
        cell_phone:{errorname:'Cell phone', minlength:5,maxlength:22},
        fax_number:{errorname:'Fax number',minlength:5,maxlength:22},
        home_phone:{errorname:'Home/Office phone',minlength:5,maxlength:22}

    };

    $.each(user_numbers, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;

            return false;
        }

    });

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');

    $('#upload_modal').modal('show');
    if (!log ){
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);
    }
    else{

        var send_data = {user_number:$("#user_numbers").serializeArray(),user_id:$('#user_id').val()};
        var url = base_url + 'user_manage/ax_update_user_numbers';
        send_ajax(url, 'post', send_data, {handler: 'update_user_numbers',beforsend:'$("#show_error_my_profile").html("")'});

    }
});

function update_user_numbers(data) {
    $('#show_error_my_profile').html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
        return false;
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }
}

$(document).on('click', '#update_password_butt', function (){

    $('#update_password > *').find('input').removeClass('error_red_class');
    $('#show_error_my_profile').removeClass('success_class');
    var log = true;

    var update_password = {
        new_password:{errorname:'New password', required:true,minlength:8},
        confirm_password:{errorname:'Confirm password',required: true,minlength:8}

    };

    $.each(update_password, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;

            return false;
        }

    });



    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');


    if (!log ){
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);
    }
    else{
        var send_data = {user_number:$("#update_password").serializeArray(),user_id:$('#user_id').val()};

        var url = base_url + 'user_manage/ax_update_password';
        send_ajax(url, 'post', send_data, {handler: 'update_password',beforsend:'$("#show_error_my_profile").html("")'});
        $('#update_password input[type = "password"]').val('');
    }
});

function update_password(data) {
    $('#show_error_my_profile').html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    $('#upload_modal').modal('show');
    if (obj['errors'].length > 0) {
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
        return false;
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }
}

$('.traveler_country').change(function () {

    $('#update_user_address input[type = "text"]').val('');

});

$(document).on('click', '#update_address_butt', function (){

    $('#update_user_address > *').find('*').removeClass('error_red_class');
    $('#show_error_my_profile').removeClass('success_class');
    var log = true;

    var update_address = {
        country:{errorname:'Country', required: true,select_valid:{State:'#state-select',Zip:'#zip_code'}},
        address_1:{errorname:'Address 1', required: true},
        city:{errorname:'City', required: true}

    };

    $.each(update_address, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;

            return false;
        }

    });

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');


    if (!log ){
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);

    }else{

        var send_data = $("#update_user_address").serializeArray();
        var url = base_url + 'user_manage/ax_update_user_address';
        send_ajax(url, 'post', send_data, {handler: 'update_user_address',beforsend:'$("#show_error_my_profile").html("")'});

    }
});

function update_user_address(data) {

    $('#show_error_my_profile').html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    $('#upload_modal').modal('show');
    if (obj['errors'].length > 0) {
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }
}

$(document).on('change', '#upload_file', function (){

    $('#doc_file_type').parent().find('button').removeClass('error_red_class');
    $("#show_error_my_profile").removeClass('success_class ');
    var upload = true;
    var error_message = [];
    var doc_arr = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'xls', 'xlsx', 'png'];
    $('#show_error_my_profile').html('');
    var parts = $('#upload_file').val().split('.');

    if (doc_arr.join().search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only doc, docx, pdf, jpg, jpeg, xls, xlsx file.');
        upload = false;
    }

    if ($('#doc_file_type').val() == '') {

        error_message.push('Please select document name.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        return false;

    }

    ax_upload_file_ajax();
    $('#upload_file').val('');
    $('#doc_file_type option[value = ""]').attr('selected','selected');
    $('.selectpicker').selectpicker('val', '');
});

function ax_upload_file_ajax() {

    var widget = this;
    widget.queuePos++;
    var doc_type = $('#doc_file_type').val();
    var user_id = $('#user_id').val();
    $('#error_mess_div>span').html('');
    var input = $("#upload_file");
    var file_data = new FormData;
    file_data.append('doc', input.prop('files')[0]);
    file_data.append('doc_type_id', doc_type);
    file_data.append('user_id', user_id);

    url = base_url + 'user_manage/ax_upload_document';

    $.ajax({
        url: url,
        type: 'post',
        data: file_data,
        cache: false,
        contentType: false,
        processData: false,
        forceSync: false,
        dataType: 'json',
        xhr: function () {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;

                    var total = event.total || e.totalSize;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }

                    processing(percent);
                }, false);
            }

            return xhrobj;
        },
        success: function (data) {
            $('#upload_modal').modal();
            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').removeClass('error_img');
            $('#show_error_my_profile').removeClass('success_class');
            var obj_upload = data;
            if (obj_upload['error'].length > 0) {
                $('#upload_modal').modal('show');
                $('#show_upload_error_img').addClass('error_img');
                $('#show_error_my_profile').html(obj_upload['error'][0]);

            }
            else {
                $('#upload_modal').modal('show');
                $('#show_error_my_profile').addClass('success_class');
                $('#show_error_my_profile').html(obj_upload['success'][0]);
            }
            $('#upload_progressbar .proc_span').html('');
            $('#upload_progressbar .procent').css('width', '0');
            get_files();

        }
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}

function get_files() {

    var send_data = {user_id:$('#user_id').val()};
    var url = base_url + 'user_manage/ax_get_documents';
    send_ajax(url, 'post', send_data, {answer: '.doc-file-place'});
}

$(document).on('click', '.delete_img', function () {

    var data = $(this).attr('data-blok');

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var doc_id = data;
                var url = base_url + 'user_manage/ax_remove_document';
                send_ajax(url, 'post', {doc_id: doc_id, user_id:$('#user_id').val()}, {success: 'get_files()'});

            }
        }
    });

});
$(document).on('click','#add_message_to_board',function () {

    var send_data = {user_id:$('#user_id').val(),message:$('#btn-input').val()};
    var url = base_url + 'user_manage/ax_add_message_to_board';
    send_ajax(url, 'post', send_data, {handler:'message_to_board'});

});

function message_to_board(data) {

    if(data === 'false'){

        return false;
    }

    var send_data = {user_id:$('#user_id').val()};
    var url = base_url + 'user_manage/ax_get_message_board';
    send_ajax(url, 'post', send_data, {answer:'#admin-chat-body',});
    $('#btn-input').val('');
}

$(document).on('click', '#reset_customer_update', function () {

    var send_data = {user_id:$('#user_id').val()};
    var url = base_url + 'user_manage/ax_reset_user_update';
    send_ajax(url, 'post', send_data, {handler:'reset_hundler'});
});

function reset_hundler(data){
    if(data == 'true'){
        ($('#user_id').val());
        location.reload();
    }
}

function load_card_info(card_num){

    var url = base_url+'user_manage/ax_credit_card';
    var send_data = {card_num:card_num,user_id:$('#user_id').val()};
    var answer ='#credit_card_'+card_num;
    var sucScript = "$('"+answer+"').find('*').selectpicker('refresh')";

    send_ajax(url,'post',send_data,{answer:answer, success:sucScript, abort:true});

}

$(document).on('click', '.credit_card', function (){

    var card_num = $(this).attr('data-block');
    load_card_info(card_num);

});

$(document).on('click', '.charge_verif', function () {
    card_num = $(this).attr('data-block');
    var send_data = $('#update_info_form_'+card_num+'').serializeArray();
    var url = base_url + 'user_manage/ax_pay_from_admin';
    send_ajax(url, 'post', send_data, {handler:'show_data_message'});

});

function show_data_message(data) {

    $('#show_error_my_profile').html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    $('#upload_modal').modal('show');
    if (obj['errors'].length > 0) {
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        load_card_info(card_num);
        delete card_num;
    }

}

$(document).on('click', '.update_status', function () {

    var data_block = $(this).attr('data-block');

    if($('#status_form_'+data_block + '> #card_id') == ''){

        return false;
    }

    var card_num = $(this).attr('data-block');
    var send_data = $('#status_form_'+card_num+'').serializeArray();
    var url = base_url + 'user_manage/ax_update_card_status';
    send_ajax(url, 'post', send_data, {success:'location.reload()'});



});

$(document).on('change', '#country-select-card', function () {


    var card_num = $(this).attr('data-block');
    var answer ='#state_select_'+card_num;
    var sucScript = "$('#update_info_form_"+card_num+"').find('*').selectpicker('refresh')";
    var url = base_url + "user_manage/get_states/get_traveller_state_select";
    send_ajax(url, 'post', {country: $(this).val()}, {
        answer: answer,
        success: sucScript
    });

});

$(document).on('click', '.update_ver_status', function () {

    var card_num = $(this).attr('data-block');
    var status = $(this).attr('data-attr');
    var id = $(this).attr('card-id');
    var send_data = {card_id:id,status:status};
    var url = base_url + 'user_manage/ax_update_card_ver_status';
    send_ajax(url, 'post', send_data, {success:'location.reload()'});

});

$(document).on('click', '.update_cc', function () {

    card_num = $(this).attr('data-block');
    $('#update_info_form_' + card_num +' > *').find('*').removeClass('error_red_class');
    $('#show_error_my_profile').removeClass('success_class');
    formid = '#update_info_form_'+card_num+'';
    var log = true;
    var error = [];
    $("#answer_card_error").html('');

    var update_address = {
        holder_first_name: {errorname: 'Name ', required: true,formid:formid},
        holder_last_name: {errorname: 'Last name', required: true,formid:formid},
        exp_mounth:{errorname: 'Expiration mounth', required: true,formid:formid},
        exp_year: {errorname: 'Expiration year', required: true,formid:formid},
        security_code: {errorname: 'Security code', required: true,minlength:3,maxlength:4,formid:formid},
        credit_card_country: {errorname: 'Country', required: true, formid:formid},
        address1: {errorname: 'Address 1', required: true,formid:formid},
        city: {errorname: 'City', required: true,formid:formid},
        phone: {errorname: 'Phone', required: true,numeric:true, minlength:5, maxlength:22, formid:formid}
    };

    if($(formid + ' #country-select-card').val() == 'US_226'){

        update_address['zip_code'] = {errorname: 'Zip Code', required: true,formid:formid};
        update_address['state_region'] = {errorname: 'State', required: true,formid:formid};
    }

    $.each(update_address, function( index, value ) {

        if(valid_fields(index, value)[0] != undefined){

            error .push(valid_fields(index, value)[0]);
        }


        if (error != '') {

            log = false;

        }

    });

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');


    $("#answer_upload span").removeClass('error_img');
    if (!log) {
        $('#add_card_modal').modal('show');
        $(this).prop('disabled', false);

        for (var i = 0;i<error.length; i++) {

            $("#answer_card_error").addClass('error_class');

            $("#answer_card_error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
        }

        return false;

    }else{

        var send_data = $(formid).serializeArray();
        var url = base_url + 'user_manage/ax_update_cc';
        send_ajax(url, 'post', send_data, {handler:'show_update_data_message'});
        delete formid;


    }

});

function show_update_data_message(data) {

    $('#show_error_my_profile').html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);

    $('#upload_modal').modal('show');
    if (obj['errors'].length > 0) {
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        load_card_info(card_num);
        delete card_num;
    }
}

$(document).on('click', '.add_credit_card', function (){

    card_num = $(this).attr('data-block');
    $('#update_info_form_' + card_num +' > *').find('*').removeClass('error_red_class');
    $(this).prop('disabled', true);
    var formid = ('#update_info_form_'+card_num);
    $(this.form).find('*').removeClass('error_red_class');
    $('#show_upload_error_img').removeClass('error_img');
    var log = true;
    var error = [];
    $("#answer_card_error").html('');
    var credit_card = {
        holder_first_name: {errorname: 'Name ', required: true,formid:formid},
        holder_last_name: {errorname: 'Last name', required: true,formid:formid},
        card_number: {errorname: 'Card number', required: true, numeric:true,card_number:true,formid:formid},
        exp_mounth:{errorname: 'Expiration mounth', required: true,formid:formid},
        exp_year: {errorname: 'Expiration year', required: true,formid:formid},
        security_code: {errorname: 'Security code', required: true, numeric:true,minlength:3,maxlength:4,formid:formid},
        credit_card_country: {errorname: 'Country', required: true, formid:formid},
        address1: {errorname: 'Address 1', required: true,formid:formid},
        city: {errorname: 'City', required: true,formid:formid},
        phone: {errorname: 'Phone', required: true,numeric:true, minlength:5, maxlength:22, formid:formid}
    };

    if($(formid + ' #country-select-card').val() == 'US_226'){

        credit_card['zip_code'] = {errorname: 'Zip Code', required: true,formid:formid};
        credit_card['state_region'] = {errorname: 'State', required: true,formid:formid};
    }

    $.each(credit_card, function (index, value) {

        if(valid_fields(index, value)[0] != undefined){

            error .push(valid_fields(index, value)[0]);
        }


        if (error != '') {

            log = false;

        }

    });

    $("#answer_upload span").removeClass('error_img');
    if (!log) {
        $('#add_card_modal').modal('show');
        $(this).prop('disabled', false);

        for (var i = 0;i<error.length; i++) {

            $("#answer_card_error").addClass('error_class');

            $("#answer_card_error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
        }

        return false;
    }


    form = $(this.form).serializeArray();
    var card_data = {};
    $.each(form, function(index, value) {
        card_data[value['name']] = value['value'];
    });

    card_data['credit_card_country'] = card_data['credit_card_country'].split('_');


    Stripe.card.createToken({
        number: card_data['card_number'],
        cvc: card_data['security_code'],
        exp_month: card_data['exp_mounth'],
        exp_year: card_data['exp_year'],
        name: card_data['holder_first_name']+' '+card_data['holder_last_name'],
        address_line1: card_data['address1'],
        address_city: card_data['city'],
        address_zip: card_data['zip_code'],
        address_state: card_data['state_region'],
        address_country: card_data['credit_card_country'][0]
    }, stripeResponseHandler);
    return false; // submit from callback
});

function stripeResponseHandler(status, response) {

    if (response.error) {

        $('.add_credit_card').prop('disabled', false);
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(response.error['message']);


    } else {

        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        $('#update_info_form_'+card_num).append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // and submit
        var url = base_url+'user_manage/ax_add_credit_card';
        var send_data = $('#update_info_form_'+card_num).serializeArray();
        send_ajax(url,'post',send_data,{handler:'add_credit_card_hemdler'});

    }
}

function add_credit_card_hemdler(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);
    $('#upload_modal').modal('show');

    if (obj["errors"].length > 0) {
        $('.add_credit_card').prop('disabled', false);
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $("#show_error_my_profile").html(obj['success']);
        setTimeout(function(){
            location.reload(base_url + 'user/my_profile/');
        }, 1500);

    }

}
/*Manage price*/

$('#price_manage_country').change(function () {

    var country_val = $('#price_manage_country').val();

    var country_id = country_val.split('_')[1];

    if(country_id == undefined){

        country_id = '';

    }

    location.replace(base_url+'price_page/manage_price/' + country_id);

});


$('.tabs_pane').click(function () {

    $('#select_file').removeClass('dis_block');

});

$('.country_profile').click(function () {

    if($('#price_manage_country').val() == 'all_0'){

        $('#select_file').addClass('dis_block');
    }



});

function get_country_profile(country_id) {

    var url = base_url+'price_page/ax_country_profile';
    var send_data = {country_id:country_id};
    send_ajax(url,'post',send_data,{answer:'#country_profile',abort:true});
}

$('.country_profile').click(function () {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];

    get_country_profile(country_id);

});

$(function() {

    var link = $(location).attr('href');
    var url1 = base_url+'price_page/manage_price/0';
    var url2 = base_url+'price_page/manage_price';
    var url3 = base_url+'price_page/manage_price/';
    if(link == url1){

        var country_val = $('#price_manage_country').val();
        var country_id = country_val.split('_')[1];

        get_country_profile(country_id);

    }else if(link == url2 || link == url3){

        get_country_profile(0);
    }
});


function get_extra_charge(country_id) {

    var url = base_url+'price_page/ax_extra_charge';
    var send_data = {country_id:country_id};
    send_ajax(url,'post',send_data,{answer:'#extra_charges',abort:true});
}

$('.extra_charges').click(function () {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    get_extra_charge(country_id);

});

function get_products(country_id) {

    var url = base_url+'price_page/ax_products';
    var send_data = {country_id:country_id};
    send_ajax(url,'post',send_data,{answer:'#product',abort:true});
}

$('.product').click(function () {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];

    get_products(country_id);

});

function ax_get_upload(currier_id,tname, file,url) {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var iso = country_val.split('_')[0];
    $('.outband_exp').val('');
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    file_data.append('doc', file);
    file_data.append('iso', iso);
    file_data.append('tname', tname);
    file_data.append('country_id', country_id);
    file_data.append('currier_id', currier_id);

    upload_file_ajax(url,file_data,'yes');


}

function upload_file_ajax(url,file_data,logic) {

    var url = base_url + url;

    $.ajax({
        url: url,
        type: 'post',
        data: file_data,
        cache: false,
        contentType: false,
        processData: false,
        forceSync: false,
        dataType: 'json',
        xhr: function () {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;

                    var total = event.total || e.totalSize;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }

                    processing(percent);
                }, false);
            }

            return xhrobj;
        },
        success: function (data) {

            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').removeClass('error_img');
            $('#show_error_my_profile').removeClass('success_class');
            var obj_upload = data;
            if (obj_upload['errors'].length > 0) {
                $('#upload_modal').modal('show');
                $('#show_upload_error_img').addClass('error_img');
                $('#show_error_my_profile').html(obj_upload['errors'][0]);

            }
            else {
                if(logic == 'yes'){

                    $('#upload_modal').modal('show');
                    $('#show_error_my_profile').addClass('success_class');
                    $('#show_error_my_profile').html(obj_upload['success']);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
                if(logic == 'no'){

                    location.reload();
                }
            }

        }
    });
}

$('.outband_exp').change(function () {

    $("#show_error_my_profile").removeClass('success_class');
    var upload = true;
    var error_message = [];
    var doc_type = 'csv';
    var parts = $(this).val().split('.');
    if (doc_type.search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only csv file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        $('.outband_exp').val('');
        return false;

    }

    var currier_id  = $(this.form).find('.currier_id').val();
    var tname = $(this).attr('name');
    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_upload_price_file';
    ax_get_upload(currier_id,tname, file,url);

});



function delete_currier_file(url,currier_id,type_name) {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var iso = country_val.split('_')[0];
    var data = {type_name:type_name,currier_id:currier_id,country_id:country_id,iso:iso};
    send_ajax(url, 'post', data, {handler:'delete_currier_file_handler'});
}

$('.admin_delete_process').click(function () {

    var currier_id  = $(this).closest( 'form' ).find('.currier_id').val();
    var type_name   =   $(this).attr('data-name');
    var url = base_url+'price_page/ax_delete_currier_file';

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                delete_currier_file(url,currier_id,type_name)
            }
        }
    });
});

function delete_currier_file_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }
}

$(document).on('keypress', '.not_string', function (key){
    if( key.charCode > 65 || key.charCode > 90){

        return false;
    }

});

$(document).on('change', '.not_string', function (key){

    if(!$.isNumeric($(this).val())){

        $(this).val('');
    }

});

$('.save_curriers').click(function () {

    $(this.form).find('input').removeClass('error_red_class');
    var log = true;
    var currier_id  = $(this.form).find('.currier_id').val();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var url = base_url+'price_page/ax_save_international_price';
    var formid = ('#inter_currier_form_'+ currier_id);

    var currier_fields  = {

        per_lbs:{errorname:'Per LBS', required: true,numeric:true,formid:formid},
        min:{errorname:'Min', required: true,numeric:true,formid:formid},
        max_length:{errorname:'Max Length', required: true,numeric:true,formid:formid},
        max_weight:{errorname:'Max Weight', required: true,numeric:true,formid:formid},
        sur_charge:{errorname:'Sur Charge', required: true,numeric:true,formid:formid}

    };

    $.each(currier_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;
            return false
        }

    });

    if (!log){
        $('#show_error_my_profile').removeClass('success_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(error);
    }
    else {
        var data = {};
        var arr = $(this.form).serializeArray();
        data['country_id'] = country_id;
        data['currier_id'] = currier_id;

        $.each(arr, function(index, value) {
            data[value['name']] =  value['value'];

        });

        send_ajax(url, 'post', data, {handler:'save_curriers_handler'});

    }

});

function save_curriers_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    $("#show_error_my_profile").html('');
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        for (var i = 0;i<obj['errors'].length; i++) {

            $("#show_error_my_profile").addClass('error_class');

            $("#show_error_my_profile").append('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][i] + '</span></div>');
        }
        $("#show_error_my_profile").addClass('error_class');

        $("#show_error_my_profile").append('<div><span  class="success_class marg_class">' + obj['success'] + '</div>');

    }
    else {
        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }

}

$('.save_curriers_dom').click(function () {

    $(this.form).find('input').removeClass('error_red_class');
    var log = true;
    var currier_id  = $(this.form).find('.currier_id').val();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var url = base_url+'price_page/ax_save_domestic_price';
    var formid = ('#dom_currier_'+ currier_id);

    var currier_fields  = {

        per_lbs:{errorname:'Per LBS', required: true,numeric:true,formid:formid},
        min:{errorname:'Min', required: true,numeric:true,formid:formid},
        max_length:{errorname:'Max Length', required: true,numeric:true,formid:formid},
        max_weight:{errorname:'Max Weight', required: true,numeric:true,formid:formid},
        sur_charge:{errorname:'Sur Charge', required: true,numeric:true,formid:formid}

    };

    $.each(currier_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;
            return false
        }

    });

    if (!log){
        $('#show_error_my_profile').removeClass('success_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(error);
    }
    else {
        var data = {};
        var arr = $(this.form).serializeArray();
        data['country_id'] = country_id;
        data['currier_id'] = currier_id;

        $.each(arr, function(index, value) {
            data[value['name']] =  value['value'];

        });

        send_ajax(url, 'post', data, {handler:'save_curriers_handler'});

    }

});

function save_curriers_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    $("#show_error_my_profile").html('');
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        for (var i = 0;i<obj['errors'].length; i++) {

            $("#show_error_my_profile").addClass('error_class');

            $("#show_error_my_profile").append('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][i] + '</span></div>');
        }
        $("#show_error_my_profile").addClass('error_class');

        $("#show_error_my_profile").append('<div><span  class="success_class marg_class">' + obj['success'] + '</div>');

    }
    else {
        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }

}

$('.inter_doc_file').change(function () {

    $("#show_error_my_profile").removeClass('success_class');
    var upload = true;
    var error_message = [];
    var doc_type = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'xls', 'xlsx', 'png'];
    var parts = $(this).val().split('.');
    var country_val = $('#price_manage_country').val();
    if(country_val == 'all_0' || country_val == ''){

        error_message.push('Please select country.');
        upload = false;
    }
    if (doc_type.join().search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only doc, docx, pdf, jpg, jpeg, xls, xlsx file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message[0]);
        $('#upload_file').val('');
        $('.inter_doc_file').val('');
        return false;

    }

    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_international_doc_file';
    var country_id = country_val.split('_')[1];
    var iso = country_val.split('_')[0];
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    file_data.append('doc', file);
    file_data.append('iso', iso);
    file_data.append('country_id', country_id);
    upload_file_ajax(url,file_data,'no');


});

$('.domestic_doc_file').change(function () {

    $("#show_error_my_profile").removeClass('success_class');
    var upload = true;
    var error_message = [];
    var doc_type = ['doc', 'docx', 'pdf', 'jpg', 'jpeg', 'xls', 'xlsx', 'png'];
    var parts = $(this).val().split('.');
    var country_val = $('#price_manage_country').val();
    if(country_val == 'all_0' || country_val == ''){

        error_message.push('Please select country.');
        upload = false;
    }
    if (doc_type.join().search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only doc, docx, pdf, jpg, jpeg, xls, xlsx file.');
        upload = false;
    }

    if($('#domestic_file_name').val() == ''){

        error_message.push('Undefined file name.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message[0]);
        $('#upload_file').val('');
        $('.inter_doc_file').val('');
        return false;

    }

    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_domestic_doc_file';
    var file_name = $('#domestic_file_name').val();
    var country_id = country_val.split('_')[1];
    var iso = country_val.split('_')[0];
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    file_data.append('doc', file);
    file_data.append('file_name', file_name);
    file_data.append('iso', iso);
    file_data.append('country_id', country_id);
    upload_file_ajax(url,file_data,'no');


});

$('#all_country_butt').click(function () {
    $("#show_error_my_profile").removeClass('success_class');


    var upload = true;
    var error_message = [];
    var doc_type = 'csv';
    var parts = $('#county_profile_file').val().split('.');
    if( $('#county_profile_file').val() == ''){

        error_message.push('Please select file.');
        upload = false;
    }

    if (doc_type.search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only csv file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        $('.outband_exp').val('');
        return false;

    }

    var file = $('#county_profile_file').prop('files')[0];
    var url = 'price_page/ax_upload_country_profile_csv';
    var file_name = $('#county_profile_file').val();
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    file_data.append('doc', file);
    file_data.append('file_name', file_name);

    bootbox.confirm({
        message: "This change has been changed in all countries, you are sure that the?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                upload_file_ajax(url,file_data,'yes');
            }
        }
    });





});


function save_comment(val,url) {

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var data = {comment:val,country_id:country_id};
    var url = base_url+url;
    send_ajax(url, 'post', data, {handler:'save_coment'});

}

$('#save_inter_comments').click(function () {

    var inter_comment = $('.inter_comment').val();
    var url = 'price_page/ax_inter_comment';
    save_comment(inter_comment,url)
});

$('#save_dom_comments').click(function () {

    var inter_comment = $('.dom_comment').val();
    var url = 'price_page/ax_dom_comment';
    save_comment(inter_comment,url)
});


function save_coment(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }

}

$('.currier_file_rem').click(function () {


    var doc_id = $(this).attr('data-blok');

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {
                var country_val = $('#price_manage_country').val();
                var country_id = country_val.split('_')[1];
                var iso = country_val.split('_')[0];
                var data = {file_id:doc_id,country_id:country_id,iso:iso};

                var url = base_url + 'price_page/ax_delete_inter_file';
                send_ajax(url, 'post',data, {handler:'remove_file_handler'});

            }
        }
    });

});

function remove_file_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }
}

$('.domestic_currier_file_rem').click(function () {


    var doc_id = $(this).attr('data-blok');

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {
                var country_val = $('#price_manage_country').val();
                var country_id = country_val.split('_')[1];
                var iso = country_val.split('_')[0];
                var data = {file_id:doc_id,country_id:country_id,iso:iso};

                var url = base_url + 'price_page/ax_delete_dom_file';
                send_ajax(url, 'post',data, {handler:"domestic_remove_file_handler"});

            }
        }
    });

});

$('.remove_country_profile').click(function () {


    var doc_id = $(this).attr('data-blok');

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var data = {name:doc_id};

                var url = base_url + 'price_page/ax_country_profile_file';
                send_ajax(url, 'post',data, {handler:'country_profile_handler',abort:true});

            }
        }
    });

});

function country_profile_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }
}


function domestic_remove_file_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }
}



$(document).on('click', '.save_country_profile', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    if(country_val == 'all_0'){
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {

                    var custom_value = $('#custom_value').val();
                    var data = {name:'country_id',value:country_id};
                    var data1 = {name:'custom_value',value:custom_value};
                    ser_arr.push(data);
                    ser_arr.push(data1);
                    var url = base_url + 'price_page/ax_save_country_profile';
                    send_ajax(url, 'post',ser_arr, {handler:'save_country_profile_handler'});
                }
            }
        });
    }else{

        var custom_value = $('#custom_value').val();
        var data = {name:'country_id',value:country_id};
        var data1 = {name:'custom_value',value:custom_value};
        ser_arr.push(data);
        ser_arr.push(data1);
        var url = base_url + 'price_page/ax_save_country_profile';
        send_ajax(url, 'post',ser_arr, {handler:'save_country_profile_handler'});
    }
});

function save_country_profile_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);

    }
}

$(document).on('click', '#extra_pick_up_butt', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    country_id = country_val.split('_')[1];
    var data = {name: 'country_id', value: country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_save_pick_up_fee';

    if(country_val == 'all_0') {
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {

                    send_ajax(url, 'post', ser_arr, {handler: 'extra_pickup_handler'});
                }
            }
        });

    }else{

        send_ajax(url, 'post', ser_arr, {handler: 'extra_pickup_handler'});
    }

});

function extra_pickup_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        get_extra_charge(country_id);
        delete country_id;
    }
}

$(document).on('click', '#extra_domestic_butt', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    country_id = country_val.split('_')[1];
    var data = {name: 'country_id', value: country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_save_domestic_insurance';
    if(country_val == 'all_0') {
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {


                    send_ajax(url, 'post', ser_arr, {handler: 'extra_domestic_handler'});
                }
            }
        });

    }else{

        send_ajax(url, 'post', ser_arr, {handler: 'extra_domestic_handler'});
    }

});

function extra_domestic_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        get_extra_charge(country_id);
        delete country_id;
    }
}

$(document).on('click', '#extra_international_butt', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    country_id = country_val.split('_')[1];
    var data = {name:'country_id',value:country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_save_international_insurance';
    if(country_val == 'all_0') {
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {


                    send_ajax(url, 'post', ser_arr, {handler: 'extra_international_handler'});
                }
            }
        });
    }else {
        send_ajax(url, 'post', ser_arr, {handler: 'extra_international_handler'});

    }


});

function extra_international_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        get_extra_charge(country_id);
        delete country_id;

    }
}

$(document).on('click', '#processing_fee_butt', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    country_id = country_val.split('_')[1];
    var data = {name:'country_id',value:country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_processing_fee';
    if(country_val == 'all_0') {
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {


                    send_ajax(url, 'post', ser_arr, {handler: 'extra_processing_handler'});
                }
            }
        });

    }else{

        send_ajax(url, 'post', ser_arr, {handler: 'extra_processing_handler'});
    }

});

function extra_processing_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        get_extra_charge(country_id);
        delete country_id;
    }
}


$(document).on('click', '.update_prod_butt', function (){

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var data = {name:'country_id',value:country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_save_product';

    if(country_val == 'all_0'){
        bootbox.confirm({
            message: "This change has been changed in all countries, you are sure that the?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {

                    send_ajax(url, 'post',ser_arr, {handler:'save_product_handler'});
                }
            }
        });

    }else{

        send_ajax(url, 'post',ser_arr, {handler:'save_product_handler'});
    }

});

function save_product_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        var country_val = $('#price_manage_country').val();
        var country_id = country_val.split('_')[1];
        get_products(country_id);
    }
}

/*$(document).on('click', '#save_pattern', function (){

    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var domestic_pattern = $('#domestic_pattern').val();
    var international_pattern = $('#international_pattern').val();
    var data = {country_id:country_id,domestic_pattern:domestic_pattern,international_pattern:international_pattern};
    var url = base_url + 'price_page/ax_product_pattern';
    send_ajax(url, 'post',data, {});
});*/

$('#int_del_time').change(function () {

    $("#show_error_my_profile").removeClass('success_class');


    var upload = true;
    var error_message = [];
    var doc_type = 'csv';
    var parts = $(this).val().split('.');

    if (doc_type.search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only csv file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        $(this).val('');
        return false;

    }

    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_upload_inter_del_time';
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var country_iso = country_val.split('_')[0];
    file_data.append('doc', file);
    file_data.append('country_iso', country_iso);
    file_data.append('country_id', country_id);
    upload_file_ajax(url,file_data,'yes');
    $(this).val('');

});


$('.domestic_upload_file').change(function () {

    $("#show_error_my_profile").removeClass('success_class');
    var upload = true;
    var error_message = [];
    var doc_type = 'csv';
    var parts = $(this).val().split('.');
    if (doc_type.search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only csv file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        $('.outband_exp').val('');
        return false;

    }

    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_upload_domestic_price';
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var country_iso = country_val.split('_')[0];
    var currier_id  = $(this.form).find('.currier_id').val();
    file_data.append('doc', file);
    file_data.append('country_iso', country_iso);
    file_data.append('country_id', country_id);
    file_data.append('currier_id', currier_id);
    upload_file_ajax(url,file_data,'yes');
    $(this).val('');
});

$('.delivery_time').click(function () {

    var name = $(this).attr('data-name');
    var data_block = $(this).attr('data-block');
    var country_val = $('#price_manage_country').val();
    var country_iso = country_val.split('_')[0];
    var country_id = country_val.split('_')[1];

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var data = {name:name,country_iso:country_iso,data_block:data_block,country_id:country_id};

                var url = base_url + 'price_page/ax_delete_delivery_time';
                send_ajax(url, 'post',data, {handler:'delete_delivery_time_handler'});

            }
        }
    });

});

function delete_delivery_time_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }

}

$('.delete_domestic_currier').click(function () {

    var name =  $(this).attr('data-name');
    var data_name   =   $(this).attr('data-block');
    var currier_id  =   $(this).attr('data_currier');
    var country_val = $('#price_manage_country').val();
    var country_id  = country_val.split('_')[1];
    var country_iso = country_val.split('_')[0];
    var url = base_url+'price_page/ax_delete_domestic_currier_file';

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var data = {currier_id:currier_id,name:name,country_id:country_id,country_iso:country_iso,data_name:data_name};
                send_ajax(url, 'post',data, {handler:'delete_domestic_currier_handler'});
            }
        }
    });
});

function delete_domestic_currier_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        location.reload();
    }

}

$('#domestic_delivery_time').change(function () {

    $("#show_error_my_profile").removeClass('success_class');
    var upload = true;
    var error_message = [];
    var doc_type = 'csv';
    var parts = $(this).val().split('.');
    if (doc_type.search(parts[parts.length - 1]) == -1) {

        error_message.push('Please select only csv file.');
        upload = false;
    }

    if (!upload) {

        $("#show_error_my_profile").addClass('error_class');
        $('#doc_file_type').parent().find('button').addClass('error_red_class');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error_message);
        $('#upload_file').val('');
        $(this).val('');
        return false;

    }

    var file = $(this).prop('files')[0];
    var url = 'price_page/ax_domestic_delivery_time';
    var widget = this;
    widget.queuePos++;
    var file_data = new FormData;
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var country_iso = country_val.split('_')[0];
    file_data.append('doc', file);
    file_data.append('country_iso', country_iso);
    file_data.append('country_id', country_id);
    upload_file_ajax(url,file_data,'yes');
    $(this).val('');

});

$('.save_dinamic_holidays_calendar').click(function () {

    var dateval =  $('.hidden_dinamic_date').val();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var data = {country_id:country_id,days:dateval};
    var url = base_url + 'price_page/ax_dinamic_holidays_calendar';
    send_ajax(url, 'post',data, {handler:'save_holidays'});
});

$('.save_holidays_calendar').click(function () {

    var dateval =  $('.hidden_date').val();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var data = {country_id:country_id,days:dateval};
    var url = base_url + 'price_page/ax_holidays_calendar';
    send_ajax(url, 'post',data, {handler:'save_holidays'});
});

function save_holidays(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }

}

$('.save_weekend_calendar').click(function () {

    var ser_arr = $(this.form).serializeArray();
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var data = {name:'country_id',value:country_id};
    ser_arr.push(data);
    var url = base_url + 'price_page/ax_weekend_calendar';
    send_ajax(url, 'post',ser_arr, {handler:'save_weekend'});
});

function save_weekend(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
    }

}

$('.delete_domestic_delivery_time').click(function () {

    var name =  $(this).attr('data-name');
    var country_val = $('#price_manage_country').val();
    var country_id = country_val.split('_')[1];
    var country_iso = country_val.split('_')[0];
    var url = base_url+'price_page/ax_delete_domestic_delivery_time';

    bootbox.confirm({
        message: "Are you sure, you want to delete this document?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var data = {name:name,country_id:country_id,country_iso:country_iso};
                send_ajax(url, 'post',data, {handler:'delete_domestic_delivery_time'});
            }
        }
    });
});

function delete_domestic_delivery_time(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {
        location.reload();
    }

}

$('.add-new-but').click(function () {
    $('#add_promotion').modal('show');
})

$('.no_href').click(function($e) {
    $e.preventDefault();
});

$('.upload_luggage_file').click(function () {
    var input = $(this).parent().find('.visible-hidden');
    input.trigger( "click" );
});

$('.luggage_labele_upload').change(function () {

    var input = $(this);
    var document_type = 'label';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var luggage_id = $(this).attr('data_id');
    var file_data = new FormData;
    file_data.append('doc', input.prop('files')[0]);
    file_data.append('order_id', order_id);
    file_data.append('doc_type', document_type);
    file_data.append('user_id', user_id);
    file_data.append('luggage_id', luggage_id);
    var url = base_url + 'order/ax_upload_order_files';
    ax_upload_file_ajax_for_passport(file_data, url, 'location');

});

$(document).on('click','.payment_history_butt', function () {

    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data_id = $(this).attr('data-id');
    var url = base_url+'order/ax_charge_or_refund';
    var data = {order_id:order_id,user_id:user_id,data_id:data_id};

    if($(this).html() == 'Refound'){
        bootbox.confirm({
            message: "Are you sure, to refund customer now?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {

                    send_ajax(url, 'post', data, {handler:'payment_history_handler'});
                }
            }
        });

    }else{
        send_ajax(url, 'post', data, {handler:'payment_history_handler'});
    }


});

function payment_history_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj['errors'][0]);

    }
    else {

        get_billing_payment();
    }

}

$('.edit_admin').click(function () {

    var url = base_url + 'manage_admin/add_or_edit_admin_view';
    var id = $(this).attr('data_id');
    send_ajax(url, 'post', {admin_id:id}, {success:"$('#add_edit_admin_modal').modal('show')",answer:'#add_edit_admin_answer'});
});

$('.delete_admin').click(function () {

    var id = $(this).attr('data_id');

    bootbox.confirm({
        message: "Are you sure, you want to delete admin?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var url = base_url + 'manage_admin/ax_delete_admin';
                send_ajax(url, 'post', {admin_id: id}, {success: 'location.reload()'});

            }
        }
    });
});

$(document).on("keyup", ".search_zip_code", function(){

    var select_id = $(this).attr('data-country');
    var inpid  = $(this).attr("id");
    var data_name  = $(this).attr("data_name");
    var ans    = "#"+inpid+"_div";
    var country_id = $('#'+select_id).val();

    if(country_id != us_id){

        return false;
    }

    var search = {search:this.value, inputid:inpid, country_id:country_id,data_name:data_name};
    var loader = (inpid == "city_from")?"#load1":"#load2";
    var search_zip_url = base_url+"order/search_zip_code";

    if(this.value.length<3){

        $(ans).css('display', 'none');

        return false;
    }

    send_ajax(search_zip_url, 'post', search, {answer:ans, loader:loader});
});



$(".search_zip_code").change(function(){

    var select_id = $(this).attr('data-country');
    var inpid  = $(this).attr("id");
    var data_name  = $(this).attr("data_name");
    var ans    = "#"+inpid+"_div";
    var country_id = $('#'+select_id).val();
    var val = $(this).val();

    if(country_id != us_id){

        return false;
    }

    var check = {search:val, inputid:inpid, country_id:country_id,data_name:data_name};
    var check_zip_code = base_url+"order/check_zip_code";

    if(this.value.length<3){

        $(ans).css('display', 'none');

        return false;
    }

    send_ajax(check_zip_code, 'post', check, {handler:'check_zip_code_handler'});
});

function check_zip_code_handler(data) {

    var obj = $.parseJSON(data);

    if(obj['check_zip'] == false){
        $('#' + obj['input_id']).addClass('error_red_class');
        var shipment = obj['input_id'].split('_')[1];
        $('#country_' + shipment).parent().find('button').addClass('error_red_class');
        $('#zip_code_error').modal('show');

    }else{
        $('#home_filter_form > *').find('button').removeClass('error_red_class');
        $('#home_filter_form > *').find('input').removeClass('error_red_class');
    }
}

$(document).on("click",".single_zip_div",function() {
    var inputid = "#"+$(this).attr("data-input");
    var zip = $(this).attr("data-zip");
    $(inputid).val(zip);
    $(this).parent().css("display", "none");
});

$(document).on("mouseover",".single_zip_div",function() {
    var inputid = "#"+$(this).attr("data-input");
    var zip = $(this).attr("data-zip");
    $(inputid).val(zip);
});

$(document).on('click','#find_drop_off_inter',function () {

    var order_id = $('#order_id').val();
    var zip_code = $('.new_zip_input').val();
    $('.new_zip_input').removeClass('error_red_class');

    if(zip_code.length == 0){

        $('.new_zip_input').addClass('error_red_class');
        return
    }

    var send_data = {order_id:order_id,zip_code:zip_code};
    var url = base_url+'order/ax_drop_off_map';

    send_ajax(url, 'post', send_data, {answer:'#drop_off_content',show_loader:true});
});


$(document).on('click','#add_admin_butt', function () {

    var ser_arr = $('#add_admin_form').serializeArray();
    var url = base_url + 'manage_admin/ax_check_add_or_edit_admin';

    send_ajax(url, 'post', ser_arr, { handler:'add_admin_handler'});

});

$('.add_admin_butt').click(function () {

    var url = base_url + 'manage_admin/add_or_edit_admin_view';

    send_ajax(url, 'post', {}, {success:"$('#add_edit_admin_modal').modal('show')",answer:'#add_edit_admin_answer'});
});

function add_admin_handler(data) {

    var obj = $.parseJSON(data);
    $("#register_error").html('');
    $('#add_error_img').removeClass('error_img');

    if (obj['errors'].length > 0) {

        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(obj['errors'][0]);
    }
    else {

        $('#add_edit_admin_modal').modal('hide');
        location.reload();
    }
}

$(document).ready(function()
    {
        var strPassword;
        var charPassword;
        var minPasswordLength = 8;
        var baseScore = 0, score = 0;

        var num = {};
        num.Excess = 0;
        num.Upper = 0;
        num.Numbers = 0;
        num.Symbols = 0;

        var bonus = {};
        bonus.Excess = 3;
        bonus.Upper = 4;
        bonus.Numbers = 5;
        bonus.Symbols = 5;
        bonus.Combo = 0;
        bonus.FlatLower = 0;
        bonus.FlatNumber = 0;

        $(document).on('keyup','#inputPassword',function () {
            checkVal();
            $("#inputPassword").attr('type', 'password');
            $("#conf_password").attr('type', 'password');
        });

        function checkVal()
        {
            init();

            if (charPassword.length >= minPasswordLength)
            {
                baseScore = 50;
                analyzeString();
                calcComplexity();
            }
            else
            {
                baseScore = 0;
            }

            outputResult();
        }

        function init()
        {
            strPassword= $("#inputPassword").val();
            charPassword = strPassword.split("");

            num.Excess = 0;
            num.Upper = 0;
            num.Numbers = 0;
            num.Symbols = 0;
            bonus.Combo = 0;
            bonus.FlatLower = 0;
            bonus.FlatNumber = 0;
            baseScore = 0;
            score =0;
        }

        function analyzeString ()
        {
            for (i=0; i<charPassword.length;i++)
            {
                if (charPassword[i].match(/[A-Z]/g)) {num.Upper++;}
                if (charPassword[i].match(/[0-9]/g)) {num.Numbers++;}
                if (charPassword[i].match(/(.*[!,@,#,$,%,^,&,*,?,_,~])/)) {num.Symbols++;}
            }

            num.Excess = charPassword.length - minPasswordLength;

            if (num.Upper && num.Numbers && num.Symbols)
            {
                bonus.Combo = 25;
            }

            else if ((num.Upper && num.Numbers) || (num.Upper && num.Symbols) || (num.Numbers && num.Symbols))
            {
                bonus.Combo = 15;
            }

            if (strPassword.match(/^[\sa-z]+$/))
            {
                bonus.FlatLower = -15;
            }

            if (strPassword.match(/^[\s0-9]+$/))
            {
                bonus.FlatNumber = -500;
            }
        }

        function calcComplexity()
        {
            score = baseScore + (num.Excess*bonus.Excess) + (num.Upper*bonus.Upper) + (num.Numbers*bonus.Numbers) + (num.Symbols*bonus.Symbols) + bonus.Combo + bonus.FlatLower + bonus.FlatNumber;

        }

        function outputResult()
        {

            if ($("#inputPassword").val()== "")
            {
                $("#complexity").html("Enter password").removeClass("weak strong stronger strongest").addClass("default");
            }
            else if (charPassword.length < minPasswordLength)
            {
                $("#complexity").html("At least " + minPasswordLength+ " characters please!").removeClass("strong stronger strongest").addClass("weak");
            }
            else if (score<50)
            {
                $("#complexity").html("Weak!").removeClass("strong stronger strongest").addClass("weak");
            }
            else if (score>=50 && score<75)
            {
                $("#complexity").html("Average!").removeClass("stronger strongest").addClass("strong");
            }
            else if (score>=75 && score<100)
            {
                $("#complexity").html("Strong!").removeClass("strongest").addClass("stronger");
            }
            else if (score>=100)
            {
                $("#complexity").html("Secure!").addClass("strongest");
            }

        }

        $(document).on('click','#generate_password',function () {

            var password = '';

            var chars = '$@%_&!';
            var latters1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var latters2 = "abcdefghijklmnopqrstuvwxyz";
            var numbers = "0123456789";

            for (var i = 0; i < 16; i++){

                if(i == 0){

                    password += latters1.charAt(Math.floor(Math.random() * latters1.length));
                    password += latters2.charAt(Math.floor(Math.random() * latters2.length));
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                    password += numbers.charAt(Math.floor(Math.random() * numbers.length));

                }else{

                    var subpass = '';
                    subpass += latters1.charAt(Math.floor(Math.random() * latters1.length));
                    subpass += latters2.charAt(Math.floor(Math.random() * latters2.length));
                    subpass += chars.charAt(Math.floor(Math.random() * chars.length));
                    subpass += numbers.charAt(Math.floor(Math.random() * numbers.length));
                    password += subpass.charAt(Math.floor(Math.random() * chars.length));

                }

            }

            $("#inputPassword").val(password);
            $("#conf_password").val(password);

            $("#inputPassword").attr('type', 'text');
            $("#conf_password").attr('type', 'text');

            checkVal();

        });


    }

);

$(document).on('click','#login_us_admin', function () {
    var user_id= $(this).attr('data_id');
    var send_data = {user_id:user_id};
    var url = base_url+'user_manage/login_by_user';

    send_ajax(url, 'post', send_data, {handler:'login_admin_handler'});
});


function login_admin_handler(data) {

    var obj = $.parseJSON(data);


    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        location.replace(front_base_url + 'dashboard');

    }
}



$('.reporte_delete_url').click(function () {

    var file_name = $(this).attr('data-file-name');

    bootbox.confirm({
        message: "Are you Sure delete this file?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var url = base_url+'user_manage/ax_delete_price_check_report';

                send_ajax(url, 'post', {file_name:file_name}, {handler:'ax_delete_price_check_report_handler'});
            }
        }
    });
});


function ax_delete_price_check_report_handler(data) {

    var obj = $.parseJSON(data);


    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        location.reload();

    }
}