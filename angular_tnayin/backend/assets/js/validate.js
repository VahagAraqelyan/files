plyr.setup();


$(document).on('keypress', '#registration_form #first_name', function (key){
    if((key.charCode < 97 || key.charCode > 122) && (key.charCode < 65 || key.charCode > 90) && (key.charCode != 32) && (key.charCode != 45) && (key.charCode != 46) && (key.charCode != 95)){

        return false;
    }
});

$(document).on('keypress', '#registration_form #last_name', function (key){

    if((key.charCode < 97 || key.charCode > 122) && (key.charCode < 65 || key.charCode > 90) && (key.charCode != 45) && (key.charCode != 32)&& (key.charCode != 46) && (key.charCode != 95)){

        return false;
    }
});

$('#signup').click(function () {

    $('#registration_form > *').find('*').removeClass('error_red_class');
    var log = true;
    var registration_fields  = {
        first_name:{errorname:'First name', required: true, minlength:2},
        last_name:{errorname:'Last name', required: true, minlength:2},
        email:{errorname:'Email', required: true, emailvalid:true },
        password:{errorname:'Password', required: true, minlength:8},
        retype_password:{errorname:'Retype password', required: true, equalTo:'password'},
        country:{errorname:'Country', required: true},
        state:{errorname:'State',required_state:true},
        code:{errorname:'Security code', required: true, length:4},
        accept:{errorname:'The Terms & Conditions',checked:true}

    };

    $.each(registration_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;

            return false;
        }

    });

    $("#register_error").html('');
    $('#add_error_img').removeClass('error_img');


    if (!log ){

        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(error);
        if($(window).scrollTop()>$(".registration-error").offset().top){
            $('html,body').animate({scrollTop: $(".registration-error").offset().top}, 'slow');
        }
    }
    else{

        var send_data=$("#registration_form").serializeArray();
        var url = base_url+'user/ax_check_registration';
        send_ajax(url, 'post', send_data, {handler:'reg_handler'});

    }

});

function reg_handler(data){
    var obj = $.parseJSON(data);

    $('.form-horizontal > *').find('input').removeClass('error_red_class');

    if(obj['errors'].length > 0){
        if(obj['tag']!=undefined){
            $(obj['tag']).addClass('error_red_class');
        }
        send_ajax(base_url+'user/get_new_captcha', 'post', {}, {answer:'#captcha-div'});
        $('#add_error_img').addClass('error_img');
        $('#register_error').html(obj['errors'][0]);
        if($(window).scrollTop()>$(".registration-error").offset().top){
            $('html,body').animate({scrollTop: $(".registration-error").offset().top}, 'slow');
        }
        return false;
    }
    $( location ).attr("href", base_url+'user/index');

}
$(document).on('click','.terms_conditions',function () {

    $('#term_modal').modal('show');
});

$(document).on('click','#login',function (){

    $('#login_form > *').find('input').removeClass('error_red_class');

    var log = true;

    var login_fields  = {

        email:{errorname:'Email', required: true, emailvalid:true },
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

    $("#show_login_error").html('');
    $('#show_error_img').removeClass('error_img');

    if (!log){
        $("#show_login_error").addClass('error_class');
        $("#show_login_error").html(error);
        $('#show_error_img').addClass('error_img');
    }
    else {

        var send_data=$("#login_form").serializeArray();
        var url = base_url+'user/ax_check_login';
        send_ajax(url, 'post', send_data, {handler:'login_handler'});

    }
});


function valid_boxes() {
    var boxes_error = [];
    var arr = $(".items-part select");
    var sum = 0;
    for(var i = 0; i<arr.length; i++)
    {
        var val = parseInt(arr[i].value);
        sum += (val)?val:0;
    }

    if(sum <= 0){

        boxes_error.push('Item(s).');

    }

    return boxes_error;
}

function valid_specialbox(special_size,error_message) {

    var arr = $('*[valid_group = '+special_size+' ]');
    var special_box_err = [];
    var arr2 = [];
    for(var i = 0; i<arr.length; i++)
    {
        var val = (parseInt(arr[i].value))?parseInt(arr[i].value):0;
        $(arr[i]).removeClass('home_error');
        $(arr[i]).parent().find('button').removeClass('home_error');

        if(!val){

            arr2.push(arr[i]);
        }
    }

    if(arr2.length != arr.length && arr2.length != 0 ){

        for(var i = 0; i<arr2.length; i++)
        {
            $(arr2[i]).addClass('home_error');
            $(arr2[i]).parent().find('button').addClass('home_error');
        }

        special_box_err.push(' Special Box '+error_message+ ' values can not be empty');


    }

    return special_box_err;

}

function login_handler(data){

    var obj = $.parseJSON(data);

    $('.form-horizontal > *').find('input').removeClass('error_red_class');

    if(obj['errors'].length > 0){
        if(obj['error_tag']!=undefined){
            $(obj['error_tag']).addClass('error_red_class');
            $(obj['error_tag']).val('');
        }
        send_ajax(base_url+'user/get_new_captcha', 'post', {}, {answer:'#captcha-div'});
        $('#show_error_img').addClass('error_img');
        $('#show_login_error').html(obj['errors'][0]);
        return false;
    }
    $( location ).attr("href", base_url+'user/index');

}

function valid_date(inp_id) {

    var err_message = [];
    var val = $(inp_id).val();
    $(inp_id).removeClass('error_red_class');
    if(!val || val == ''){

        err_message.push('Shiping date');
    }

    if(new Date(val) == 'Invalid Date'){

        $(inp_id).addClass('error_red_class');
        err_message.push('Shiping date field must be correct date.');

    }

    return err_message;
}

$(document).ready(function(){

    function check_option(name_arr) {

        if($.cookie('order') == 'null' || $.cookie('order') === undefined){

            return false;
        }

        var cookie_arr = {};
        var cookie_array = $.parseJSON($.cookie('order'));

        if($.isEmptyObject(cookie_array['luggage'])){

            return false;
        }

        for(var i = 0; i<name_arr.length; i++){

            $.each(cookie_array['luggage'], function(index, value) {

                if(value == '' || value == undefined){

                    return;
                }

                cookie_arr[index] =value;

            });

            $.each(cookie_array, function(index, value) {

                if(value == '' || value == undefined){

                    return;
                }

                if(index == 'luggage' || index == 'special'){

                    return;
                }

                if($('[name = '+index+']').prop('tagName') != 'SELECT'){

                    return;

                }

                cookie_arr[index] =value;

            });

        }

        $.each(cookie_arr, function(index, value) {

            if($.cookie(index) == "null"|| $.cookie('order') === undefined){

                return false;
            }

            $('[name = '+index+'] option').attr("selected", false);
            $('[name = '+index+'] [value = '+value+']').attr("selected", "selected");
            $('.select-luggage-size').selectpicker('refresh');
        });
    }

    function input_val(name_arr) {

        if($.cookie('order') == "null" || $.cookie('order') === undefined){

            return false;
        }

        var cookie_array = $.parseJSON($.cookie('order'));

        var cookie_arr = {};

        for(var i = 1; i<name_arr.length; i++){

            if(cookie_array[name_arr[i]] == '0'){

                continue;
            }

            $.each(cookie_array['special'], function(index, value) {

                if($.isEmptyObject(value)){

                    return;
                }

                if(name_arr[i] == 'city_to' || name_arr[i] == 'city_from' || name_arr[i] == 'shipping_date'){

                    return;
                }


                cookie_arr[index+'_'+name_arr[i]] = cookie_array['special'][index][name_arr[i]];

            });

            if(name_arr[i] == 'height' || name_arr[i] == 'length' || name_arr[i] == 'weight' || name_arr[i] == 'width'){

                continue;
            }

            cookie_arr[name_arr[i]] = cookie_array[name_arr[i]];

        }



        $.each(cookie_arr, function(index, value) {

            if($.cookie(index) == ''){

                return false;
            }

            $('[name = '+index+'] ').val(value);

            /*if($('[name = '+index+']').prop('tagName') == 'SELECT'){

                $('[name = '+index+'] option').attr("selected", false);
                $('[name = '+index+'] [value = '+value+']').attr("selected", "selected");
                $('.select-luggage-size').selectpicker('refresh');
            }*/


            for(i = 1; i < 4; i++){

                if(index == i+'_count'){

                    $('[name = '+index+'] option').attr("selected", false);
                    $('[name = '+index+'] [value = '+value+']').attr("selected", "selected");
                    $('.select-luggage-size').selectpicker('refresh');
                }

            }
        });
    }

    get_check_option();
    get_input_val();

    function get_input_val() {

        var arr = ['',"weight","width","height","length","city_from","city_to","shipping_date","count","country_from","country_to"];
        input_val(arr);
    }

    function get_check_option() {

        var arr = ["1_1","1_2","1_3","1_4","1_5","1_6","1_7","2_1","2_2","2_3","3_1","3_2","3_3","3_4","3_5","4_1","4_2","4_3","4_4","country_from","country_to"];
        check_option(arr);
    }

    $("#check_price").click(function () {


        $('#home_filter_form > *').find('button').removeClass('error_red_class');
        $('#home_filter_form > *').find('input').removeClass('error_red_class');

        //zip code check
        var check_zip_code = base_url+"home/check_zip_code";
        var select_id1 = $('#city_from').attr('data-country');
        var inpid1  = $('#city_from').attr("id");
        var data_name1  = $('#city_from').attr("data_name");
        var country_id1 = $('#'+select_id1).val();
        var search1 = $('#city_from').val();
        check_handler_2 = false;
        check_handler_1 = false;

        var check1 = {search:search1, inputid:inpid1, country_id:country_id1,data_name:data_name1};
        send_ajax(check_zip_code, 'post', check1, {handler:'check_zip_code_1'});

    });


    $('#reset').click(function () {

        $.cookie("order", null, { path: '/' });

    });

    $('.reset_cookie').click(function () {

        $.cookie("order", null, { path: '/' });
    });

    $('#logo_img').click(function () {

        $.cookie("order", null, { path: '/' });
        location.replace(base_url + 'home');

    });

    $('.go_back').click(function () {


        location.replace(base_url + 'home');

    });
});

function check_price() {

    $('#home_filter_form > *').find('input').removeClass('error_red_class');
    var inspection_arr = [];
    var inspection_arr2 = [];
    var special_box_class1 = "special_size1";
    var special_box_class2 = "special_size2";
    var special_box_class3 = "special_size3";
    var logic = true;
    var error_arr = [];

    if($('#country_from').val() == us_id && $('#country_to').val() == us_id){

        error_arr.push([city_to    = valid_fields('city_to',{errorname:'City to', required: true, minlength:3})]);
        error_arr.push([city_from  = valid_fields('city_from',{errorname:'City from', required: true, minlength:3})]);

    }else{

        error_arr['city_from'] = '';
    }

    var error_arr2 = [
        shipping_date      =  valid_date('#shipping_date'),
        boxes              = valid_boxes(),
        sp_box1            = valid_specialbox(special_box_class1,'1'),
        sp_box2            = valid_specialbox(special_box_class2,'2'),
        sp_box3            = valid_specialbox(special_box_class3,'3')

    ];


    if(error_arr.length != 0){
        for(var i = 0; i<error_arr.length; i++){

            if (error_arr[i] != ''){

                inspection_arr.push(error_arr[i][0]);
            }
        }
    }

    for(var i = 0; i<error_arr2.length; i++){

        if (error_arr2[i] != ''){

            inspection_arr2.push(error_arr2[i][0]);
        }
    }

    $("#check_price").removeAttr('data-toggle','modal');
    $("#check_price").removeAttr('data-target','#error');
    if(inspection_arr.length != 0 || inspection_arr2.length != 0 ){

        $('#error').modal('show');
        $(".shiping_date").html('');
        $(".from_date").html('');

        if(inspection_arr.length != 0){

            $(".from_date").append('<p>Please enter:</p>');
            for (var i = 0;i<inspection_arr.length; i++){

                $(".from_date").append('<div>' + inspection_arr[i] + '</div>');

            }
        }

        if(inspection_arr2.length != 0) {


            $(".shiping_date").append('<p>Please select:</p>');
            for (var i = 0; i < inspection_arr2.length; i++) {

                $(".shiping_date").append('<div>' + inspection_arr2[i] + '</div>');
            }
        }

        logic = false;
    }

    if(!logic){

        return false;
    }



    var arr =  $('#home_filter_form').serializeArray();
    var data = {
        'luggage':{},
        'special':{1:{},2:{},3:{}}
    };

    $.each(arr, function(index, value) {

        if(value['value'] == '0' || value['value']== ''){
            delete arr[index];
            return;
        }

        if($('[name = '+value['name']+']').prop('tagName') == 'SELECT' && value['name'] != 'country_from' && value['name'] != 'country_to' && value['name'] != '1_count' && value['name'] != '2_count' && value['name'] != '3_count' ){

            data['luggage'][value['name']] = value['value'];
            delete arr[index];

        }

        if(value['name'] == 'city_from' && value['value'] != ''){

            data[value['name']] =  value['value'];
            delete arr[index];
        }
        if(value['name'] == 'city_to' && value['value'] != ''){

            data[value['name']] =  value['value'];
            delete arr[index];
        }
        if(value['name'] == 'country_from' && value['value'] != ''){

            data[value['name']] =  value['value'];
            delete arr[index];
        }
        if(value['name'] == 'country_to' && value['value'] != ''){

            data[value['name']] =  value['value'];
            delete arr[index];
        }
        if(value['name'] == 'shipping_date' && value['value'] != ''){

            data[value['name']] =  value['value'];
            delete arr[index];
        }

    });

    $.each(arr, function(index, value) {



        if(value === undefined){

            return;
        }
        for(i = 1; i < 4; i++){

            if(value['name'] == i+'_weight'){
                data['special'][i]['weight'] =  value['value'];
            }
            if(value['name'] == i+'_width'){
                data['special'][i]['width'] =  value['value'];
            }
            if(value['name'] == i+'_height'){
                data['special'][i]['height'] =  value['value'];
            }
            if(value['name'] == i+'_length'){
                data['special'][i]['length'] =  value['value'];
            }
            if(value['name'] == i+'_count'){
                data['special'][i]['count'] =  value['value'];
            }

        }

    });

    $.cookie('order',JSON.stringify(data),{ path: '/' });
    location.replace(base_url+'check_price');

}

function check_zip_code_1(data) {

    $('#city_from').removeClass('error_red_class');
    $('#country_from').parent().find('button').removeClass('error_red_class');

    var select_id2 = $('#city_to').attr('data-country');
    var country_id2 = $('#'+select_id2).val();
    var search2 = $('#city_to').val();
    var check_zip_code = base_url+"home/check_zip_code";
    var inpid2  = $('#city_to').attr("id");
    var data_name2  = $('#city_to').attr("data_name");
    var check2 = {search:search2, inputid:inpid2, country_id:country_id2,data_name:data_name2};
    setTimeout(function () {
        send_ajax(check_zip_code, 'post', check2, {handler:'check_zip_code_2'});
    },300);

    var obj = $.parseJSON(data);
    if(obj['check_zip'] == false){

        $('#zip_code_error').modal('show');
        $('#' + obj['input_id']).addClass('error_red_class');
        var shipment = obj['input_id'].split('_')[1];
        $('#country_' + shipment).parent().find('button').addClass('error_red_class');
        check_handler_1 = false

    }else{
        check_handler_1 = true;


        if(check_handler_2 && check_handler_1){

            check_price();
        }
    }
}

function check_zip_code_2(data) {

    var obj = $.parseJSON(data);

    if(obj['check_zip'] == false){
        $('#' + obj['input_id']).addClass('error_red_class');
        $('#zip_code_error').modal('show');
        var shipment = obj['input_id'].split('_')[1];
        $('#country_' + shipment).parent().find('button').addClass('error_red_class');
        check_handler_2 = false;

    }else{

        $('#city_to').removeClass('error_red_class');
        $('#country_to').parent().find('button').removeClass('error_red_class');

        check_handler_2 = true;

        if(check_handler_1 && check_handler_2){
            check_price();
        }

    }
}

$('#check_price').click(function($e) {
    $e.preventDefault();
});