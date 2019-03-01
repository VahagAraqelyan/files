plyr.setup();

sender_address_validation = 0;
reciver_address_validation = 0;

$(window).on('load', function(){
    $('#full_page_loader').hide();
    //$('#content_main_container').show();
    $('#content_main_container').css('visibility', 'visible');
    $('#content_main_container').css('height', 'auto');
    $('#content_main_container').css('overflow', 'auto');
});

/*
$('input, select, textarea').on('focus blur', function(event) {
    $('meta[name=viewport]').attr('content', 'width=device-width,initial-scale=1,maximum-scale=0');
});
*/

$(function () {

  $(document).bind( "touchstart", function(e){

        $('[data-toggle="popover"]').each(function () {

        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {

            $(this).popover('hide');
            }
        });

    } );

    $('.popover-style').bind( "touchstart", function(e){
        $(this).popover('show');
    } );

    var link = $(location).attr('href');

    if(link != base_url && link != base_url + 'home' && link != base_url + 'home/' && link != base_url + 'check_price' && link != base_url+'get_prod_by_type'){

        return false;
    }

/*
    if($('#blok5').hasClass('active')){

        $('#blok5').addClass('home_page_tab_pane');
    }
*/

    $('.home-separate-pop').each(function(i, obj) {

        $(this).popover({ placement: 'bottom', trigger: 'hover' })
            .data('bs.popover')
            .tip()
            .addClass('my-own-popover');
    });

    $('.luggage_info_popover').parent().parent().addClass('luggage_info_popover_main');

    $('.luggage_info_popover_img').each(function(i, obj) {

        $(this).popover({ placement: 'bottom', trigger: 'hover' })
            .data('bs.popover')
            .tip()
            .addClass('luggage_info_popover_main');
    });

   /* $('.luggage_info_popover_main').on('show.bs.popover', function () {

        $('.luggage_info_popover_main').popover('hide')
    })
*/
/*    $(document).on('click', '.luggage_info_popover_main', function () {

        $(this).parent().parent().popover('hide');
    });
   */
});
/*
$('.luggage_info_span').click(function () {

    var data_id = $(this).attr('data_id');
  $('#' + data_id).trigger('mouseenter');

});*/

$(document).on('click touchstart', '.close_popover', function () {

    $(this).parent().parent().parent().popover('hide');
});

$(function () {

    var link = $(location).attr('href');

    if(link != base_url+'check_price'){

        return false;
    }

    if($(window).width()> 510){

        return false;
    }

    $('.price_page_hide').addClass('dis_none');

});

$(function() {

    $('.responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm'] // xs, sm, md, lg
    });


    $('.order-responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm', 'md', 'lg'] // xs, sm, md, lg
    });

    $('[data-toggle="popover"]').popover();

    $('.shipping-date').datepicker({

    });
/*
    $('.box_list li a').mouseover(function () {

        $(this).trigger( "click" );

        if($('#blok5').hasClass('active')){

            $('#blok5').addClass('home_page_tab_pane');


        }

    });*/



    // User login
    $(document).on('click', '#register_modal_btn', function() {
        $('#login_modal').modal('hide');
        $('#register_modal').modal('show');
        $(document.body).addClass('modal-open');
    });

    $(document).on('click', '#login_modal_btn', function() {
        $('#register_modal').modal('hide');
        $('#login_modal').modal('show');
        $(document.body).addClass('modal-open');

    });

    // Optimalisation: Store the references outside the event handler:
    var $window = $(window);
    var $pab_pane, windowsize;

    function checkWidth() {
        var $li_group = $('.responsive-tabs-container').children('.nav-tabs'); //.children('li:first-child')
        var $a_accordion_first = $('.responsive-tabs-container').children('.tab-content').children('a.accordion-link').first();
        windowsize = $window.width();
        $pab_pane = $('.responsive-tabs-container').children('.tab-content').children('.tab-pane');

        if (windowsize < 992) {
            if ($pab_pane.first().hasClass('active')) {
                $pab_pane.first().removeClass('active');
            }

            if ($a_accordion_first.hasClass('active')) {
                $a_accordion_first.removeClass('active');
            }

        } else {

            $li_group.children('li').each(function( index ) {

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });

            $pab_pane.each(function( index ) {

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');

                } else {
                    $pab_pane.first().addClass('active');

                    if (!$li_group.children('li:first-child').hasClass('active')) {
                        $li_group.children('li:first-child').addClass('active');
                    }

                }
            });


        }
    }

    checkWidth();
    $(window).resize(checkWidth);

    if (windowsize < 992) {

        $('.accordion-link').on('click', function () {
            var attr_href = $(this).attr('href').replace('#', '');

            $pab_pane.each(function(index) {

                if ($(this).attr('id') == attr_href) {
                    if ($(this).hasClass('active')) {
                        /*$(this).addClass(' activemjk');*/

                    }
                }
            });

        });
    }

   /* if($(window).width()< 767){

        $('.order-details-content').find('a').click(function () {

            $('.order-details-content').find('.tab-pane').each(function(index) {

                if($(this).hasClass('active')){

                    $(this).removeClass('active');
                }

              /!*  if ( $(this).css('display') == 'block' ){

                    $(this).css('display','none')
                }*!/
            });

        });
    }*/

});

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

$(document).on('keypress', '.unit_val', function (key){

    if( key.charCode > 65 || key.charCode > 90){

        return false;
    }

});

$('#shipping_date').on('changeDate', function(ev){
    $(this).datepicker('hide');
});

// set datepicker min date
$("#shipping_date").datepicker({
    startDate: "dateToday",
    format:'yyyy-mm-dd'
});

$(document).ready(function(){

    $('.filter-block .home_select_country').select2({
        placeholder: 'Select an option'
    });

   $(function() {

       if($.cookie('order') == 'null' || $.cookie('order') === undefined){

           return false;
       }

       var count = {};
       var cookie_array = $.parseJSON($.cookie('order'));

       $.each(cookie_array['luggage'], function(index, value) {

           if(value == '' || value == undefined){

               return;
           }

           var type = index.split('_')[0];
           type = '#blok'+type + '-count';

           if(count[type] !== undefined){
               count[type]=parseInt(count[type]) + parseInt(value);
           }else{
               count[type]=parseInt(value);
           }

       });

       $.each(cookie_array['special'], function(index, value) {

           if(value['count'] == '' || value['count'] == undefined){

               return;
           }
           var type_id = $("[name = '1_count' ]").attr('data-block');

           if(count[type_id] !== undefined){
               count[type_id]=parseInt(count[type_id]) + parseInt(value['count']);
           }else{
               count[type_id]=parseInt(value['count']);
           }
       });

       $.each(count, function(index, value) {

           if(count.length == 0){

               return;
           }

           $("span[class='"+index+"']").css("visibility","visible");

           $("span[class='"+index+"']").html('-'+value+'-');

       });


    });

    $(".count-select").change(function () {
        var obj = $(this);
        show_count(obj);
    });

    function show_count(obj){

        $(obj).parent().find('button').removeClass('homeback_change');
        $(obj).parent().find('button').removeClass('asad');
        $(obj).parent().find('button').removeClass('asad2');

        var type=$(obj).attr("data-block");
        var arr=$("select[data-block='"+type+"']");
        var sum=0;

        for(var i=0; i<arr.length; i++)
        {
            var val=parseInt(arr[i].value);
            sum+=(val)?val:0;
        }

        if(sum>0){

            if ($(obj)[0].selectedIndex !== 0) {
                $(obj).parent().find('button').addClass('homeback_change');
                (obj).parent('div').find('button').addClass('asad');
                $('.select-country').selectpicker('refresh');

            }else{


            }

            $("span[class^='"+type+"']").css("visibility","visible");

            $("span[class^='"+type+"']").html('-'+sum+'-');

        }else {

            $("span[class^='"+type+"']").css("visibility","hidden");


        }

        if($(obj).val() <= 0){
            $(obj).parent('div').removeClass('asad3');
            $(obj).removeClass('asad3');

            $(obj).parent().find('button').removeClass('homeback_change');
            $(obj).parent().find('button').removeClass('asad');
            $(obj).parent().find('button').removeClass('asad2');
            $(obj).parent('div').removeClass('asad2');
            $(obj).parent('div').removeClass('asad');

        }else{
            $(obj).parent().find('button').addClass('homeback_change');
            (obj).parent('div').find('button').addClass('asad');
            (obj).parent('div').find('button').addClass('asad2');
        }

        if($(obj).val()>0){

            $(obj).parent().find('button').addClass('homeback_change');
            (obj).parent('div').find('button').addClass('asad');
            (obj).parent('div').find('button').addClass('asad2');

        }else{
            $(obj).parent('div').find('button').removeClass('asad');
            $(obj).parent('div').find('button').removeClass('asad2');
            $(obj).parent('div').find('button').removeClass('asad3');
            $(obj).parent('div').removeClass('asad');
            $(obj).parent('div').removeClass('asad2');

        }
    }

    /*$('.count-select').on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {

        var selected = $(e.currentTarget).val();
        if(selected>0){

            $(e.currentTarget).addClass('asad');
            $(e.currentTarget).addClass('asad2');
            $(e.currentTarget).parent().find('button').addClass('homeback_change');
            $(e.currentTarget).parent('div').find('button').addClass('asad');
            $(e.currentTarget).parent('div').find('button').addClass('asad2');
            $('.count-select').selectpicker('refresh');
            return false;
        }else{
            $(e.currentTarget).parent('div').find('button').removeClass('homeback_change');
            $(e.currentTarget).parent('div').find('button').removeClass('asad');
            $(e.currentTarget).parent('div').find('button').removeClass('asad2');
            $(e.currentTarget).parent('div').removeClass('asad');
            $(e.currentTarget).parent('div').removeClass('asad2');
            $(e.currentTarget).removeClass('asad2');
            $(e.currentTarget).removeClass('asad');
            $('.count-select').selectpicker('refresh');
            return false;
        }

    });
*/
    $(document).ready(function () {

        $(function () {

            var link = $(location).attr('href');

            if(link != base_url && link != base_url + 'home' && link != base_url + 'home/home_page' && link != base_url + 'shipping-rates' && link != base_url + 'home/' && link != base_url +'shipping-golf-club' && link != base_url +'shipping-luggage' && link != base_url +'shipping-boxes' && link != base_url +'shipping-ski-snowboard' && link != base_url + 'bike'){
                return false;
            }

            var select_arr = $('.select-luggage-size');

            $(select_arr).each(function(i, obj) {

                if($(obj).val() == 0){

                    return;
                }

                show_count_2(obj);
            });

        });

    });

    function show_count_2(obj) {

        $('.select-luggage-size').selectpicker('refresh');
        $(obj).parent('div').find('button').removeClass('homeback_change');
        $(obj).parent().find('button').removeClass('asad');
        $(obj).parent().find('button').removeClass('asad2');
        var type=$(obj).attr("data-block");
        var arr=$("select[data-block='"+type+"']");
        var sum=0;
        for(var i=0; i<arr.length; i++)
        {
            var val=parseInt(arr[i].value);
            sum+=(val)?val:0;
        }
        if(sum>0){

            if ($(obj)[0].selectedIndex !== 0) {
                $(obj).parent().find('button').addClass('homeback_change');
                $(obj).parent().find('button').addClass('asad');
            }
            $("span[class^='"+type+"']").css("visibility","visible");

            $("span[class^='"+type+"']").html('-'+sum+'-');
        }else {

            $("span[class^='"+type+"']").css("visibility","hidden");
        }
    }


    $(document).on('click','#change-captcha',function (){
        var ajax_url=base_url+"user/get_new_captcha";
        send_ajax(ajax_url, 'post', {}, {answer:'#captcha-div'});

    });

    $('#registration_form #email').change(function(){

        var email=$(this).val();
        $('#email_val').html('<img src="'+base_url+'assets/images/load.gif" id="email_loader" style="display:none;" >');
        var url=base_url+"user/email_inuse";
        var method="post";
        var send_data={email:email, return:'bool'};
        var ans="#email_val";
        var load="#email_loader";

        send_ajax(url, method, send_data, {handler:'validate_email_handler', loader:load});

    });


    $("#country").change(function(){

        if($(this).val()!="US_226"){
            $("#select-state").html("");
            return false;
        }

        var url = base_url+"user/get_states/get_reg_state_select";
        var send_data ={country:$(this).val()};
        var method="post";
        var ans="#select-state";
        var load=undefined;
        var sucFunc="$('#select-state').find('*').selectpicker('refresh')";
        send_ajax(url, method, send_data, {answer:ans, loader:load, success:sucFunc});

    });

    $(document).on("click","#forgot-link",function() {
        var url = base_url+"user/forgot_password";
        var send_data ="";
        var method="post";
        var ans="#forgot-modal-content";
        var load='#forgot_loader_1';
        send_ajax(url, method, send_data, {answer:ans, loader:load});

    });

    $(function () {

        var link = $(location).attr('href');
        var link_arr = link.split('/');
        var method1 = 'luggage-and-question';

        if($.inArray(method1,link_arr) == -1){

            return false;
        }


        if(for_questions == 'How_to_stick_label_on_my_luggage-bag-case' || for_questions == 'How_to_do_if_my_luggage_was_delivered_damaged-broken'){

            for_questions = for_questions.replace(/-/gi,'/');
        }

        $('#questions_main .accordion-toggle').each(function () {

            var title = $(this).text().replace('’','');
            var $this = $(this).parents('.panel-group');

            if($.trim(title).replace('?','') == for_questions.replace(/_/gi,' ')){
                $(this).trigger('click');

                if($this.hasClass('accordion-styled-inner')){
                    $(this).parent().parent().parent().parent().parent().parent().parent().children().children('h4').children('a').trigger('click');

                    var div = $(this).parent().parent().parent();

                    $('html,body').animate({
                            scrollTop: $(div).offset().top - 200},
                        'slow');
                }
            }
        });

    });

});

$('#calc_luggage').change(function () {

    var luggage_id = $('#calc_luggage').val();
    var url = base_url + 'public_pages/ax_calc_weight_size';
    send_ajax(url, 'post', {luggage_id:luggage_id}, {answer:'.calc_weight_size_answer'});
});

/*$(document).on("mouseover",".single_zip_div",function() {
    var inputid = "#"+$(this).attr("data-input");
    var zip = $(this).attr("data-zip");
    $(inputid).val(zip);
});*/

$(window).on('click', function() {

    $('#city_from_div').css("display", "none");
    $('#city_from_div').removeClass("show_single");
    $('#city_to_div').css("display", "none");
    $('#city_to_div').removeClass("show_single");

});

$(document).on('click', '#change-captcha-2', function() {
    var ajax_url=base_url+"user/get_new_captcha";
    send_ajax(ajax_url, 'post', {}, {answer:'#captcha-div-2'});
});


$(document).on('click', '#forgot-send', function() {

    $('#forgot_form > *').find('input').removeClass('error_red_class');

    var log = true;

    var login_fields  = {

        email_forgot:{errorname:'Email', required: true, emailvalid:true },
        code_forgot:{errorname:'Security code', required: true, length:4}
    };



    $.each(login_fields, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;
            return false
        }

    });

    if (!log){

        $("#error_message>p>span:nth-of-type(2)").addClass('error_class');
        $('#error_message').show();
        $('#error_message>p>span:nth-of-type(2)').html(error);
    }
    else {

        var validate_ajax_url=base_url+"user/ax_check_forgot_password";
        var send_data={email:$('#email_forgot').val(), code:$('#code_forgot').val()};
        send_ajax(validate_ajax_url, 'post', send_data, {loader:'#forgot_loader', handler:'forgot_data_handler'});

    }

});

function forgot_data_handler(data){

    var obj = $.parseJSON(data);

    $('.form-horizontal > *').find('input').removeClass('error_red_class');

    if(obj['err_message'].length>0){
        if(obj['tag']!=undefined){
            $(obj['tag']).addClass('error_red_class');
        }
        send_ajax(base_url+"user/get_new_captcha", 'post', {}, {answer:'#captcha-div-2'});
        $('#success_message').hide();
        $('#error_message').show();
        $('#error_message>p>span:nth-of-type(2)').html(obj['err_message']);
        return false;
    }

    $('#forgot-modal-content #forgot_form').hide();
    $('#forgot-modal-content .footer-part').hide();
    $('#error_message').hide();
    $('#success_message').show();
    $('#success_message>p>span').html(obj['suc_message']);
    $('#code_forgot').val("");

}




if (action == 'my_profile') {

    $('#user_numbers_butt').click(function () {

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
                       cell_phone:{errorname:'Cell phone', minlength:5, maxlength:22},
                       fax_number:{errorname:'Fax number',minlength:5, maxlength:22},
                       home_phone:{errorname:'Home/Office phone',minlength:5, maxlength:22}

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


        if (!log ){
            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').addClass('error_img');
            $("#show_error_my_profile").html(error);
        }
        else{

        var send_data = $("#user_numbers").serializeArray();
        var url = base_url + 'user/ax_update_user_numbers';
        send_ajax(url, 'post', send_data, {handler: 'update_user_numbers'});

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

    $('#update_password_butt').click(function () {

            $('#update_password > *').find('input').removeClass('error_red_class');
            $('#show_error_my_profile').removeClass('success_class');
            var log = true;

            var update_password = {
                current_password:{errorname:'Current password', required: true,minlength:8},
                new_password:{errorname:'New password', required: true,minlength:8},
                confirm_password:{errorname:'Confirm password', required: true,minlength:8}

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
                $("#show_error_my_profile").addClass('error_class');
                $('#show_upload_error_img').addClass('error_img');
                $("#show_error_my_profile").html(error);
            }
            else{
                var send_data = $("#update_password").serializeArray();
                var url = base_url + 'user/ax_update_password';
                send_ajax(url, 'post', send_data, {handler: 'update_password'});
                $('#update_password input[type = "password"]').val('');
            }
    });

    function update_password(data) {
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

    $(document).on('keypress', '#update_user_address #zip', function (key){
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


    $(document).on('keypress', '#credit_card_form_1 #zip_code_1', function (key){
        if(key.charCode < 48 || key.charCode > 57){

            return false;
        }

    });
    $(document).on('keypress', '#credit_card_form_2 #zip_code_2', function (key){
        if(key.charCode < 48 || key.charCode > 57){

            return false;
        }

    });
    $(document).on('keypress', '#credit_card_form_3 #zip_code_3', function (key){
        if(key.charCode < 48 || key.charCode > 57){

            return false;
        }

    });


    $('#update_address_butt').click(function () {

        $('#update_user_address > *').find('*').removeClass('error_red_class');
        $('#show_error_my_profile').removeClass('success_class');
        var log = true;

        var update_address = {
            country:{errorname:'Country', required: true,select_valid:{State:'#region_account_info',Zip:'#zip'}},
            address1:{errorname:'Address 1', required: true},
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
            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').addClass('error_img');
            $("#show_error_my_profile").html(error);

        }else{

        var send_data = $("#update_user_address").serializeArray();
        var url = base_url + 'user/ax_update_user_address';
        send_ajax(url, 'post', send_data, {handler: 'update_user_address'});

        }
    });

    function update_user_address(data) {
        $('#show_error_my_profile').html('');
        $('#show_upload_error_img').removeClass('error_img');
        $('#show_error_my_profile').removeClass('success_class');
        var obj = $.parseJSON(data);
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


    $('#upload_file').change(function () {

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

        upload_file_ajax();
        $('#upload_file').val('');
        $('#doc_file_type option[value = ""]').attr('selected','selected');
        $('.selectpicker').selectpicker('val', '');

    });

    function upload_file_ajax() {

        var widget = this;
        widget.queuePos++;
        var doc_type = $('#doc_file_type').val();
        $('#error_mess_div>span').html('');
        var input = $("#upload_file");
        var file_data = new FormData;
        file_data.append('doc', input.prop('files')[0]);
        file_data.append('doc_type_id', doc_type);

        url = base_url + 'user/ax_upload_document';

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

        var url = base_url + 'user/ax_get_documents';
        send_ajax(url, 'post', {}, {answer: '.doc-file-place'});
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
                    var url = base_url + 'user/ax_remove_document';
                    send_ajax(url, 'post', {doc_id: doc_id}, {success: 'get_files()'});

                }
            }
        });

    });

    $(document).on('change', '#my_profile_country', function () {

        var url = base_url + "user/get_states/get_traveller_state_select";
        var sucFunc = "$('#update_user_address').find('*').selectpicker('refresh')";
        var ans = "#region_account_info";
        send_ajax(url, 'post', {country: $(this).val()}, {answer: ans, success: sucFunc});

    });


// traveller functions
    $(document).ajaxComplete(function() {
        $('[data-toggle="popover"]').popover();
    });



    $('.traveler_country').change(function () {

        $('#update_user_address input[type = "text"]').val('');
        $('.acount_info_add1').val('');

    });

    $('#add_new_traveller').click(function () {


        var url = base_url + 'user/ax_add_new_traveler';
        var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh')";
        send_ajax(url, 'post', {}, {answer: '#my_profile_modal_content', success: sucFunc, beforsend:'$("#my_profile_modal_content").html("")'});

    });


    $(document).on('change', '#country-select', function () {

        var url = base_url + "user/get_states/get_traveller_state_select";
        var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh')";
        send_ajax(url, 'post', {country: $(this).val()}, {
            answer: '#my_profile_modal_content #state-select',
            success: sucFunc
        });

    });

    $(document).on('click', '#add_traveler_but', function () {

        $('#traveler_add_update > *').find('*').removeClass('error_red_class');
        var log = true;

        var traveler_fields = {
            first_name: {errorname: 'First name', required: true, minlength: 2},
            last_name: {errorname: 'Last name', required: true, minlength: 2},
            phone_number: {errorname: 'Phone Number', required: true,minlength:5,maxlength:22},
            comment:{errorname: 'Additional Comments',maxlength:200}
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
            var url = base_url + "user/ax_check_add_traveler";
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

    $(document).on('click', '#traveler_list_link', function () {
        get_traveler_list(1);
    });


    $(document).on('click', '.travel_pagination', function () {

        var page = $(this).attr('data-ci-pagination-page');
        get_traveler_list(page);

    });

    function get_traveler_list(page,suc_func) {
        var send_data = {page: page};
        var url = base_url + "user/ax_traveler_list/" + (page - 1) * traveler_list_row_count;
        send_ajax(url, 'post', send_data, {answer: '#traveller_list_content', success:suc_func, abort:true});
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
        var send_data = {traveler_id:$('.traveler_list_checkbox:checked').val()};
        traveler_row_id = send_data['traveler_id'];
        var url = base_url + "user/ax_edit_traveler";
        var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
        send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content', success: sucFunc, beforsend:'$("#my_profile_modal_content").html("")'});


    });

    $(document).on('click', '#edit_traveler_but', function () {

        $('#traveler_add_update > *').find('*').removeClass('error_red_class');
        var log = true;

        var traveler_fields = {
            first_name: {errorname: 'First name', required: true, minlength: 2},
            last_name: {errorname: 'Last name', required: true, minlength: 2},
            phone_number: {errorname: 'Phone Number', required: true, minlength:5,maxlength:22},
            comment:{errorname: 'Additional Comments',maxlength:200}
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
            var url = base_url + "user/ax_check_edit_traveler";
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


    $(document).on('click', '.view_traveler_info', function () {

        var trav_id = $(this).attr('data-blok');
        var url = base_url + 'user/ax_view_traveler_info';
        var send_data = {trav_id: trav_id};
        var succesFunc = $('#my_profile_modal').modal('show');
        send_ajax(url, 'post', send_data, {answer:'#my_profile_modal_content',succes:succesFunc, beforsend:'$("#my_profile_modal_content").html("")'});
    });

function show_travel_list() {

$('#my_profile_modal').modal('show');
}

    $('#edit_login').click(function () {
        $('#my_profile_modal').modal('show');
        var url = base_url+'user/ax_update_email';
        var sucFunc="$('#my_profile_modal_content').find('*').selectpicker('refresh')";
        send_ajax(url, 'post', {}, {answer:'#my_profile_modal_content', success:sucFunc, beforsend:'$("#my_profile_modal_content").html("")'});

    });

    $(document).on('click', '#change_email', function () {
        var send_data = $('#traveler_add_update').serializeArray();
        var url = base_url + "user/ax_check_update_email";
        send_ajax(url, 'post', send_data, {handler: 'show_message_check_email'});


});
function show_message_check_email(data) {

    $("#traveler_error").html('');
    $('#add_error_img').removeClass('error_img');
    $('#traveler_error').removeClass('success_class');

    var obj = $.parseJSON(data);
    if (obj["errors"].length > 0) {

        $('#add_error_img').addClass('error_img');
        $("#traveler_error").html(obj['errors']);
    }
    else {
        $('#add_error_img').addClass('success_class');
        $("#traveler_error").html(obj['success']);

        $('#my_profile_modal').modal('hide');
        location.reload(base_url + 'user/my_profile/');

    }
 }
    $(document).on('click', '#delete_traveler', function () {

        $('#show_upload_error_img').removeClass('error_img');
        $("#show_error_my_profile").removeClass('success_class');
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

                    var send_data = checkarray.serializeArray();
                    var url = base_url + "user/ax_delete_traveler";
                    send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content',handler:'show_del_messages'});
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

//address book functions

$(document).on('click', '#address_book_link', function(){

    get_address_book(1,'');

});

$(document).on('click', '.addrbook_pagination', function () {

    var page = $(this).attr('data-ci-pagination-page');
    get_address_book(page, '');

});

function get_address_book(page,suc_func) {
    var send_data = {page: page};
    var url = base_url + "user/ax_address_book_list/" + (page - 1) * addres_book_list_row_count;
    send_ajax(url, 'post', send_data, {answer: '#address_book_content', success:suc_func, abort:true});
}


$('#add_new_addr').click(function(){

    var url = base_url+'user/ax_add_address_book';
    var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
    send_ajax(url,'post',{},{answer:'#my_profile_modal_content', success:sucFunc, beforsend:'$("#my_profile_modal_content").html("")'});

});

$(document).on('click', '#add_new_addr_book', function(){

    $('#add_new_addr_form > *').find('*').removeClass('error_red_class');
    var log = true;

    var address_book_fields = {
        add_addr_country: {errorname: 'Country', required: true, select_valid:{State:'#state-select',Zip:'#zip_code'}},
        address_1: {errorname: 'Address 1', required: true},
        city: {errorname: 'City', required: true},
        comment:{errorname: 'Additional Comments',maxlength:200}
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

    var url = base_url+'user/ax_check_add_address_book';
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
        var send_data = {addr_book:$('.address_book_list_checkbox:checked').val()};
        address_book_row_id = send_data['addr_book'];
        var url = base_url + "user/ax_edit_address_book";
        var sucFunc = "$('#my_profile_modal_content').find('*').selectpicker('refresh');";
        send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content', success: sucFunc, beforsend:'$("#my_profile_modal_content").html("")'});


    });

    $(document).on('click', '#edit_addr_book', function () {

        $('#add_new_addr_form > *').find('*').removeClass('error_red_class');
        var log = true;

        var address_book_fields = {
            add_addr_country: {errorname: 'Country', required: true, select_valid:{State:'#state-select',Zip:'#zip_code'}},
            address_1: {errorname: 'Address 1', required: true},
            city: {errorname: 'City', required: true},
            comment:{errorname: 'Additional Comments',maxlength:200}
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
            var url = base_url + "user/ax_check_edit_address_book";
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
        var url = base_url+'user/ax_view_address_book';
        var send_data={addr_id:addr_book_id};
        send_ajax(url, 'post', send_data, {answer:'#my_profile_modal_content',  beforsend:'$("#my_profile_modal_content").html("")'});

    });

    $(document).on('click', '#delete_address_book', function () {

        $('#show_upload_error_img').removeClass('error_img');
        $("#show_error_my_profile").removeClass('success_class');

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

                    var send_data = checkarray.serializeArray();
                    var url = base_url + "user/ax_delete_address_book";
                    send_ajax(url, 'post', send_data, {answer: '#my_profile_modal_content',handler:'show_del_addr_book_messages'});
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

    // credit card

    $(document).on('click', '.credit_card_link', function (){

        var card_num = $(this).attr('data-block');
        load_card_info(card_num);

    });

    function load_card_info(card_num){

        var url = base_url+'user/ax_credit_card';
        var send_data = {card_num:card_num};
        var answer ='#credit_card_'+card_num;
        var sucScript = "$('"+answer+"').find('*').selectpicker('refresh');$('.tab-pane').removeClass('active');$('#credit_card_"+card_num+"').addClass('active');";
        send_ajax(url,'post',send_data,{answer:answer, success:sucScript, abort:true,});

    }



    $(document).on('change', '#country-select-card', function (){
        var url = base_url + "user/get_states/get_traveller_state_select";
        var card_num = $(this).attr('data-block');
        var answer ='#state_select_card_'+card_num;
        var sucScript = "$('#credit_card_"+card_num+"').find('*').selectpicker('refresh')";
        send_ajax(url, 'post', {country: $(this).val()}, {
            answer: answer,
            success: sucScript
        });
    });

    $(document).on('click','.verif-card',function () {
        $(this).prop('disabled', true);
        card_num = $(this).attr('data-block');
        var formid = ('#credit_card_form_'+card_num);
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
            credit_card_country:{errorname: 'Country', required:true, formid:formid},
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

        if (!log) {

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

            $('.verif-card').prop('disabled', false);
            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').addClass('error_img');
            $('#upload_modal').modal('show');
            $('#show_upload_error_img').addClass('error_img');
            $("#show_error_my_profile").html(response.error['message']);


        } else {

            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $('#credit_card_form_'+card_num).append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            // and submit
            var url = base_url+'user/ax_add_credit_card';
            var send_data = $('#credit_card_form_'+card_num).serializeArray();
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
            $('.verif-card').prop('disabled', false);
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

    $(document).on('click', '.edit-credit-card', function(){
        var card_num = $(this).attr('data-card');
        var card_id = $('#credit_card_form_'+card_num+' > input[name="card_id"]').val();
        var url = base_url+'user/ax_edit_credit_card';
        var send_data = {card_num:card_num, card_id:card_id};
        var answer ='#credit_card_'+card_num;
        var sucScript = "$('#credit_card_"+card_num+"').find('*').selectpicker('refresh')";
        send_ajax(url,'post',send_data,{answer:answer, success:sucScript});
    });

    $(document).on('click', '.save-credit-card-change', function(){
        var card_number = $(this).attr('data-block');
        var formid = ('#credit_card_form_'+card_number);
        var state = ('#state_select_card_'+card_number);
        var zip = ('#zip_code_'+card_number);
        $(this.form).find('*').removeClass('error_red_class');
        $('#show_upload_error_img').removeClass('error_img');
        var log = true;
        var error = [];
        $("#answer_card_error").html('');

        var edit_card_info = {
                    holder_first_name: {errorname: 'Name ', required: true,formid:formid},
                    holder_last_name: {errorname: 'Last name', required: true,formid:formid},
                    exp_mounth: {errorname: 'Expiration mounth', required: true,formid:formid},
                    exp_year: {errorname: 'Expiration year', required: true,formid:formid},
                    security_code: {errorname: 'Security code', required: true,minlength:3,maxlength:4,formid:formid},
                    credit_card_country: {errorname: 'Country', required: true, formid:formid},
                    address1: {errorname: 'Address 1', required: true,formid:formid},
                    city: {errorname: 'City', required: true,formid:formid},
                    phone: {errorname: 'Phone', required: true,numeric:true, minlength:5, maxlength:22, formid:formid},
                        };

        if($(formid + ' #country-select-card').val() == 'US_226'){

            edit_card_info['zip_code'] = {errorname: 'Zip Code', required: true,formid:formid};
            edit_card_info['state_region'] = {errorname: 'State', required: true,formid:formid};
        }

        $.each(edit_card_info, function (index, value) {

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
        else{

             card_num = $(this).attr('data-block');
            var send_data = $('#credit_card_form_'+card_num).serializeArray();
            var num_obj = {name:'card_num', value:card_num};
            send_data.push( num_obj );
            var url = base_url+'user/ax_check_edit_credit_card';
            var sucScript = "";
            send_ajax(url,'post',send_data,{handler:'edit_credit_card'});

        }

    });

    function edit_credit_card(data) {

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
            load_card_info(card_num);
            delete card_num;
        }

    }

    $(document).on('click','.verify-credit-card', function(){

        var card_num = $(this).attr('data-card');
        var send_data = $('#credit_card_form_'+card_num).serializeArray();
        var num_obj = {name:'card_num', value:card_num};
        send_data.push( num_obj );
        var url = base_url+'user/ax_credit_card_verification';
        send_ajax(url,'post',send_data,{handler:'verify_credit_card'});

    });

    function verify_credit_card(data) {

        $("#show_error_my_profile").html('');
        $('#show_upload_error_img').removeClass('error_img');
        $('#show_error_my_profile').removeClass('success_class');

        var obj = $.parseJSON(data);

        $('#upload_modal').modal('show');
        if (obj["errors"].length > 0) {

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

    $(document).on('click','.delete-credit-card', function(){
        card_id = $(this).attr('data-card');

        bootbox.confirm({
            message: "Are you sure, you want to delete this credit card?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn btn-default btn-login-orange'
                }
            },
            callback: function (result) {

                if (result == true) {


                    var send_data = {card_id:card_id};
                    var url = base_url+'user/ax_delete_credit_card';
                    send_ajax(url,'post',send_data,{handler:'delete_credit_card'});
                    delete card_id;

                }
            }
        });



    });

    function delete_credit_card(data) {

        $("#show_error_my_profile").html('');
        $('#show_upload_error_img').removeClass('error_img');
        $('#show_error_my_profile').removeClass('success_class');

        var obj = $.parseJSON(data);

        $('#upload_modal').modal('show');
        if (obj["errors"].length > 0) {

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



}/*end action*/


if(action == 'index' || action == 'home_page' || action == 'get_bike' || action == 'get_prod_by_type' || action == 'get_public_pages' || action == 'drop_of_locations' || action == 'order_processing'){

    $(document).on('change', 'select.country-inf-select', function () {

        var country_id = $(this).val();
        input_id = $(this).attr('data-input');
        var send_url = base_url+'home/zip_code_isset';
        var send_data = {country:country_id};
        send_ajax(send_url,'post',send_data,{});
    });

    $(document).on('change', '#country_from', function () {

        if($('#country_from').val() != us_id){

            $('#city_from').val('');
            $('.fedex_pub_page').addClass('dis_none');
            $('.dhl_pub_page').find('input').prop('checked',true);

        }else{
            $('.fedex_pub_page').removeClass('dis_none');
            $('.dhl_pub_page').find('input').prop('checked',false);
        }
    });

    $(document).on('change', '#country_to', function () {

        if($('#country_to').val() != us_id){

            $('#city_to').val('');
        }

    });


    $('#public_find_drop_off').click(function () {

        $('#public_find_dropp_off_form > *').find('*').removeClass('error_red_class');
        var log = true;
        var registration_fields  = {
            country_id:{errorname:'Country', required: true},
            currier:{errorname:'Carrier',checked:true,error_text:'Please choose carrier'}

        };

        if($('#country_from').val() == '226'){

            registration_fields['zip_code'] = {errorname: 'Zip code or Country', required: true};
        }

        $.each(registration_fields, function( index, value ) {

            error = valid_fields(index,value);

            if(error != ''){

                log = false;

                return false;
            }

        });

        $("#show_upload_error_img").html('');
        $('#show_error_my_profile').removeClass('error_img');


        if (!log ){

            $('#upload_modal').modal('show');
            $("#show_error_my_profile").addClass('error_class');
            $('#show_upload_error_img').addClass('error_img');
            $("#show_error_my_profile").html(error);

            return false;
        }

        var country  = $('#country_from').val();
        var zip_code = $('#city_from').val();
        var radius = $('#radius').val();
        var carrier = false;
        var carriers = $('.currier');

        $.each(carriers, function (index, value) {

            if($(value).prop('checked')){
                carrier = $(value).val();
                return;
            }

        });

       if(zip_code == ''){
           zip_code = 'false';
       }


        if(country == us_id && carrier == 'DHL'){

          var zip_code_arr = zip_code.split(' ');

           zip_code = zip_code_arr.join('_');


        }else if(carrier == 'FedEx' && country == us_id){

            zip_code = zip_code.match(/\d/g);
            zip_code = zip_code.join("");
        }

        var url = base_url + 'public_pages/drop_of_locations/' + country + '/' + zip_code + '/' + carrier;


        location.replace(url);

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
        var search_zip_url = base_url+"home/search_zip_code";

        if(this.value.length<3){

            $(ans).css('display', 'none');

            return false;
        }

        var sucfunc = '$("'+ans+'").addClass("show_single")';


        send_ajax(search_zip_url, 'post', search, {answer:ans, loader:loader ,success:sucfunc});
    });



    pop = '';

    $(document).on("change",".search_zip_code",function(){

        pop = $(this).attr('name');
    });

    $(document).on("click",".single_zip_div",function() {
        var inputid = "#"+$(this).attr("data-input");
        var zip = $(this).attr("data-zip");
        $(inputid).val(zip);
        $(inputid+"div").css("display", "none");
        $(this).parent().removeClass('show_single');

        var name = $(this).parent().attr('id').replace('_div','');

        check_zip(name);
    });


    function check_zip(name) {

      /*  var id = '#'+$(zip).attr('name')+'_div';

        if($(id).hasClass('show_single') && $(id).children().hasClass('single_zip_div')){

            return false;
        }*/

        if(pop == ''){

            return false;
        }


        var select_id = $('[name = '+name+']').attr('data-country');
        var inpid  = $('[name = '+name+']').attr("id");
        var data_name  = $('[name = '+name+']').attr("data_name");
        var ans    = "#"+inpid+"_div";
        var country_id = $('#'+select_id).val();
        var val = $('[name = '+name+']').val();

        if(typeof(val) != 'undefined'){

            val = Number(val.match(/\d+/));
        }

        if(country_id != us_id){

            return false;
        }

        var check = {search:val, inputid:inpid, country_id:country_id,data_name:data_name};
        var check_zip_code = base_url+"home/check_zip_code";

        if(val.length<3){

            $(ans).css('display', 'none');

            return false;
        }

        send_ajax(check_zip_code, 'post', check, {handler:'check_zip_code_handler'});

        pop = '';
    }

    $(window).on('click', function() {

        check_zip(pop);
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

}/*end action*/

function validate_email_handler(data){

    $('#registration_form  *').removeClass('error_red_class');
    $('#register_error').html('');
    $('#add_error_img').removeClass('error_img');

    if(data=='false'){

        $('#email_val').html('<img src="'+base_url+'assets/images/ok.ico" data-block="ok">');


    }
    else if(data=='true'){

        $('#email_val').html('<img src="'+base_url+'assets/images/cancel.ico" data-block="ok">');
        $('#register_error').html('This email is already exist');
        $('#registration_form input[name="email"]').addClass('error_red_class');
        $('#add_error_img').addClass('error_img');

    }else if(data=='error'){

        $('#email_val').html('<img src="'+base_url+'assets/images/cancel.ico" data-block="ok">');
        $('#register_error').html('Invalid email address');
        $('#registration_form input[name="email"]').addClass('error_red_class');
        $('#add_error_img').addClass('error_img');

    }

}

$('.ship-met').click(function () {

    $(this).next().trigger('click');
});

$('.ship-met>div').click(function () {

    $(this).next().trigger('click');
});

$('.check_book').click(function () {

    $('.ship-met').find('div').removeClass('error_red_class');

        $(this).parents('.ship-met').find('input').attr('checked', 'checked');
        $(this).prev().find('input').attr('checked', 'checked');

    if($("input:radio:checked").length == 0){

         var button_class = $(this).attr('data-number');
         $('.'+button_class).parent().parent().find('.ship-met').find('div').addClass('error_red_class');
        $('#login_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html('Please select services');

        return false;

    }

    var url =  base_url+'price_page/ax_checkup_login';

    send_ajax(url, 'post', {}, {handler:'check_book_handler'});
});

function check_book_handler(data) {

    var obj = $.parseJSON(data);

    if(obj == false){

        var data = $('.order_proc_form').serializeArray();
        $.cookie('ship_met',data[0]['value'],{ path: '/' });

        $('#login_modal').modal('show');

      /*  document.body.style.overflow = 'hidden';
        document.body.style.height = '100%';
        document.body.style.width = '100%';*/
        modal_position_ios();
        var url =  base_url+'price_page/ax_login';
        send_ajax(url, 'post', {}, {answer:'.login_modal'});

    }else{

        var data = $('.order_proc_form').serializeArray();
        $.cookie('ship_met',data[0]['value'],{ path: '/' });
        location.replace(base_url+'user/index');
    }
}

$('.modal').on('hidden.bs.modal', function () {

    var ua = navigator.userAgent,
        iOS = /iPad|iPhone|iPod/.test(ua),
        iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3/.test(ua);

    if ( iOS ) {

        $('body').css('position','inherit');
    }

});

function modal_position_ios() {

    var ua = navigator.userAgent,
     iOS = /iPad|iPhone|iPod/.test(ua),
     iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3/.test(ua);

     if ( iOS ) {

         $('.modal-open').css('position','fixed');
     }

}

function set_icon_handler(data) {

    var obj = $.parseJSON(data);
    $("#sender_pickup").attr('class',obj['icon_sender']);
    $("#receiver_delivery_icon").attr('class',obj['icon_receiver']);
    $("#payment_info_icon").attr('class',obj['icon_payment']);
}

function set_icon_js() {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method1 = 'view_order';
    var method2 = 'order_processing';

    if ($.inArray(method1, link_arr) == -1 && $.inArray(method2, link_arr) == -1) {

        return false;
    }


    var sender_class = $('#sender_pickup').attr('class');
    var delivery_class = $('#receiver_delivery_icon').attr('class');
    var payment_class = $('#payment_info_icon').attr('class');
    var disable = false;
    if (sender_class == 'fa verified-icon' && sender_class == delivery_class && sender_class == payment_class) {

        disable = true;

    }

    if(disable){

        $('.adjust-function').attr('disabled', false);
        $('.submitted_info').html('View / Edit Order');

    }else{
        $('.adjust-function').attr('disabled', 'disabled');
        $('.submitted_info').html('Edit Item(s) or Services');
    }



}



function get_sender_info(sender_id,arg) {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'order_processing';

    if($.inArray(method,link_arr) == -1){

        return false;
    }

    var sender_arr = $('#sender_pickup_form').serializeArray();
    var tem_arr = [];
    $.each(sender_arr, function (index, obj) {

        if(obj['value'] == '') {

            return;
        }

        tem_arr.push(obj);

    });

    set_icon_js();

    if(tem_arr.length > 0 && !arg){

        return false;
    }

    var url =  base_url+'order/ax_sender_pickup_info';
    var data = $('#order_id').val();
    var id = $('#sender_pickup_main').parent('div').attr('id');
    var sucFunc="$('.select-country').selectpicker('refresh');scroll_to_id('"+id+"');";
    send_ajax(url, 'post', {order_id:data,sender_id:sender_id}, {answer:'.sender_pickup_body',success: sucFunc,show_loader:true});


}

$('.sender_butt').click(function () {

    get_sender_info('',false);
    change_price();

});

function get_delivery_info(delivery_id,arg) {

    var sender_arr = $('#receiver_delivery_form').serializeArray();
    var tem_arr = [];
    $.each(sender_arr, function (index, obj) {

        if(obj['value'] == '') {

            return;
        }

        tem_arr.push(obj);

    });

    if(tem_arr.length > 0 && !arg){

        return false;
    }
    set_icon_js();
    var url =  base_url+'order/ax_receiver_info';
    var data = $('#order_id').val();
    var id = $('#receiver_delivery_main').attr('id');
    var sucFunc="$('.select-country').selectpicker('refresh');scroll_to_id('"+id+"');";
    send_ajax(url, 'post', {order_id:data,delivery_id:delivery_id}, {answer:'.receiver_delivery_body',success: sucFunc,show_loader:true});
}

$('.receiver_butt').click(function () {

    get_delivery_info('',false);
    change_price();

});

function get_payment_info(changed,arg) {

    var sender_arr = $('#pay_select').serializeArray();
    var tem_arr = [];
    $.each(sender_arr, function (index, obj) {

        if(obj['value'] == '') {

            return;
        }

        tem_arr.push(obj);

    });

    if(tem_arr.length > 0 && !arg){

        return false;

    }

    sender_arr.push({name:'order_id', value: $('#order_id').val()});
    sender_arr.push({name:'cards_num',  value: $('#credit_cards').val()});
    sender_arr.push({name:'changed',  value:  changed});

    var url =  base_url+'order/ax_payment_info';
    var data = sender_arr;
    var id = $('#payment_main').parent('div').attr('id');
    var sucFunc="$('.select-country').selectpicker('refresh');scroll_to_id('"+id+"');";
    send_ajax(url, 'post', data, {answer:'.payment_info_body_answer', success: sucFunc,show_loader:true});
}


$('.payment_information').click(function () {

    get_payment_info(false,false);
    get_discount();
    change_price();

});

function get_discount() {

    var url =  base_url+'order/ax_discount';
    send_ajax(url, 'post', {order_id:$('#order_id').val()}, {answer:'#discount_answer'});
}


$(document).on('change','#credit_cards', function () {

    if($(this).val() != 'new'){

        $("#payment_info_icon").attr('class','fa verified-icon');

    }else{

        $("#payment_info_icon").attr('class','fa information-icon');
    }

    var url =  base_url+'order/ax_update_card';
    var data = {order_id: $('#order_id').val(),card_id:$('#credit_cards').val()};
    var sucFunc="$('.select-country').selectpicker('refresh')";
    send_ajax(url, 'post', data, {success: sucFunc,show_loader:true,handler:'update_card'});

    set_icon_js();
});

function update_card() {

    var add_card = true;

    if($('#credit_cards').val() == 'new'){

        add_card = false;
    }

    get_payment_info(true,true);

    if(add_card != false){


        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');

        if (sender_class == 'fa information-icon') {

            $('.sender_butt').trigger('click');

        }else if (delivery_class == 'fa information-icon') {

            $('.receiver_delivery_butt').trigger('click');

        }else{

            $('.payment_information').trigger('click');
        }
    }


}

$(function() {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method1 = 'view_order';
    var method2 = 'order_processing';

    if($.inArray(method1,link_arr) == -1 && $.inArray(method2,link_arr) == -1 ){

        return false;
    }

    if(checkdate == 1 && order_status < 2){

        $('#date_modal').modal('show');
    }

    if(order_status == 2){

        $('.sender_butt').trigger('click');
    }

});

$(document).ready(function () {

    $(function() {

        var link = $(location).attr('href');
        var link_arr = link.split('/');
        var method1 = 'view_order';
        var method2 = 'order_processing';

        if($.inArray(method1,link_arr) == -1 && $.inArray(method2,link_arr) == -1 ){

            return false;
        }



        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');
        var payment_class = $('#payment_info_icon').attr('class');
        $('.adjust-function').attr('disabled', 'disabled');
        if (sender_class == 'fa  verified-icon' && delivery_class ==  'fa  verified-icon' && payment_class == 'fa  verified-icon') {

            /*$('#order_submit').attr('disabled', false);*/
            $('.adjust-function').attr('disabled', false);

        }

        if (sender_class == 'fa information-icon') {

            $('.sender_butt').trigger('click');

        }

        if (delivery_class == 'fa information-icon' && sender_class == 'fa verified-icon') {

            $('.receiver_delivery_butt').trigger('click');

        }

        if (payment_class == 'fa information-icon' && sender_class == 'fa verified-icon' && delivery_class == 'fa verified-icon') {

            $('.payment_information').trigger('click');

        }

    });


});

$(document).on('click','.sender_pickup_save', function () {

    $('#sender_pickup_form > *').find('*').removeClass('error_red_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class ');
    var log = true;
    var formid = '#sender_pickup_form';
    var traveler_fields = {};

    if($('.pick_up').prop('checked')){

        traveler_fields['pickup_time'] = {errorname: 'Pick Up Time', required: true, minlength: 4,formid:formid};
    }


        traveler_fields['first_name'] = {errorname: 'First name', required: true, minlength: 2,formid:formid};
        traveler_fields['last_name']  =  {errorname: 'Last name', required: true, minlength: 2,formid:formid};
         traveler_fields['phone']     =  {errorname: 'Phone Number', required: true,minlength:5,maxlength:22,formid:formid};
         traveler_fields['address1'] = {errorname: 'Address', required: true,formid:formid};
         traveler_fields['remark']   ={errorname: 'Remark',maxlength:200,formid:formid};

    if($(formid + " input[name = 'city']").length != 0){

        traveler_fields['city'] = {errorname: 'City', required: true, minlength: 3,formid:formid};
        if(pick_up_country == us_id) {
            traveler_fields['postal_code'] = {errorname: 'Postal Code', required: true,formid:formid};
            traveler_fields['state'] = {errorname: 'State/Region', required: true,formid:formid};
        }
    }

    if($(formid + " input[name = 'email']").length != 0){

        traveler_fields['email'] = { emailvalid:true, formid:formid};
    }


    $.each(traveler_fields, function (index, value) {

          error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {

        $('#answer_upload > div').remove();
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);

    } else {

        var country_id = $('#country_id').val();
        var data = {};
        var arr = $(this.form).serializeArray();
        data['country_id'] = country_id;
        data['order_id'] = $('#order_id').val();
        data['traveler_list_select'] =$('#traveller_list_select').val();
        data['address_select'] =$('#addres_book_list').val();
        data['sender_address_validation'] = sender_address_validation;
        $.each(arr, function (index, value) {
            data[value['name']] = value['value'];

        });

        var url = base_url + 'order/ax_update_sender_info';
        send_ajax(url, 'post', data, {handler:'sender_pickup_handler'});
    }
});


function sender_pickup_handler(data) {


    $('#show_error_my_profile').html('');
    $('#answer_upload').html('<span id="show_upload_error_img"></span> <span id="show_error_my_profile"></span>');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        sender_address_validation++;

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');

        $("#answer_upload").append('<table><tr><td><span class="error_img"></span></td> <td><span class="error_class">' + obj['errors'][0] + '</span></td></tr></table>');

    }
    else {
        set_icon_js();

        $("#sender_pickup").attr('class','fa verified-icon');
        get_sender_info('',true);
        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');
        var payment_class = $('#payment_info_icon').attr('class');
        var body = $("html, body");
        var sender_height = parseInt($('#sender_and_pick_up').offset().top);

        if (delivery_class == 'fa information-icon') {

            $('.receiver_delivery_butt').trigger('click');
            if($(window).width()< 767) {
                var height = sender_height - parseInt($('#receiver_delivery').offset().top);
                if (height < 0) {

                    height = height * -1;
                }
                body.stop().animate({scrollTop: height}, 500, 'swing', function () {
                });
            }
        }else if (payment_class == 'fa information-icon') {

            $('.payment_information').trigger('click');
            if($(window).width()< 767) {
                var height = sender_height - parseInt($('#payment_information').offset().top);
                if (height < 0) {

                    height = height * -1;
                }
                body.stop().animate({scrollTop: height}, 500, 'swing', function () {
                });
            }
        }else{

            $('.sender_butt ').trigger('click');
            if($(window).width()< 767) {
                body.stop().animate({scrollTop: sender_height - 100}, 500, 'swing', function () {
                });
            }
        }

    }
}



$(document).on('click','.receiver_delivery_save', function () {

    $('#receiver_delivery_form > *').find('*').removeClass('error_red_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class ');
    var log = true;
    var formid = '#receiver_delivery_form';

    var traveler_fields = {
        first_name: {errorname: 'First name', required: true, minlength: 2,formid:formid},
        last_name: {errorname: 'Last name', required: true, minlength: 2,formid:formid},
        phone: {errorname: 'Phone Number', required: true,minlength:5,maxlength:22,formid:formid},
        address1: {errorname: 'Address', required: true,formid:formid},
        remark:{errorname: 'Remark',maxlength:200,formid:formid}
    };

    if($(formid + " input[name = 'city']").length != 0){

        traveler_fields['city'] = {errorname: 'City', required: true, minlength: 3,formid:formid};
        if(delivery_country == us_id) {
            traveler_fields['postal_code'] = {errorname: 'Postal Code', required: true,formid:formid};
            traveler_fields['state'] = {errorname: 'State/Region', required: true,formid:formid};
        }
    }

    if($(formid + " input[name = 'email']").length != 0){

        traveler_fields['email'] = { emailvalid:true, formid:formid};
    }


    $.each(traveler_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {

        $('#answer_upload > div').remove();
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);

    } else {

        var country_id = $('#country_id').val();
        var data = {};
        var arr = $(this.form).serializeArray();
        data['country_id'] = country_id;
        data['order_id'] = $('#order_id').val();
        data['traveler_list_select'] =$('#traveller_list_select').val();
        data['address_select'] =$('#addres_book_list').val();
        data['reciver_address_validation'] = reciver_address_validation;

        $.each(arr, function (index, value) {
            data[value['name']] = value['value'];

        });

        var url = base_url + 'order/ax_update_receiver_info';
        send_ajax(url, 'post', data, {handler:'receiver_info_handler'});
    }
});


function receiver_info_handler(data) {


    $('#show_error_my_profile').html('');
    $('#answer_upload').html('<span id="show_upload_error_img"></span> <span id="show_error_my_profile"></span>');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');

        reciver_address_validation++;

        $("#answer_upload").append('<table><tr><td><span class="error_img"></span></td> <td><span class="error_class">' + obj['errors'][0] + '</span></td></tr></table>');

    } else {

        set_icon_js();
        $('#receiver_delivery_icon').attr('class', 'fa verified-icon');

        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');
        var payment_class = $('#payment_info_icon').attr('class');
        var body = $("html, body");
        var sender_height = parseInt($('#receiver_delivery').offset().top);

        if (sender_class == 'fa information-icon') {
            get_delivery_info('', true);
            $('.sender_butt').trigger('click');

            if($(window).width()< 767) {
                var height = sender_height - parseInt($('#sender_and_pick_up').offset().top);

                body.stop().animate({scrollTop: height}, 500, 'swing', function () {
                });
            }
        } else if (payment_class == 'fa information-icon') {
            get_delivery_info('', true);
            $('.payment_information').trigger('click');
            if($(window).width()< 767) {
                var height = sender_height - parseInt($('#payment_information').offset().top);
                if (height < 0) {

                    height = height * -1;
                }
                if($(window).width()< 767) {
                    body.stop().animate({scrollTop: sender_height}, 500, 'swing', function () {
                    });
                }
            }
        } else {
            get_delivery_info('', true);
            $('.receiver_delivery_butt').trigger('click');
            body.stop().animate({scrollTop: sender_height-100}, 500, 'swing', function () {
            });
        }

    }
}

$(document).on('change','#traveller_list_select', function () {

    var drop = false;
    var pickup = false;
    var pickup_val = '';
    if($('.drop_off').prop('checked')){

        drop = true;

    }

    if ($('.pick_up').prop('checked')){

        pickup = true;
    }

    if($('#pickup_time').val() != ''){

       pickup_val = $('#pickup_time').val();
    }

    var info = $(this.form).serializeArray();
   info.push({name:'trav_id',value:$('#traveller_list_select').val()});
   info.push({name:'order_id',value:$('#order_id').val()});
   info.push({name:'sender_id',value:$('#data_id').val()});
   info.push({name:'pickup',value:pickup});
   info.push({name:'drop',value:drop});
   info.push({name:'pickup_val',value:pickup_val});
   info.push({name:'chenged',value:true});
    info.push({name:'add_id',value:$('#addres_book_list').val()});
    var url = base_url + 'order/ax_sender_pickup_info';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var data = info;

    send_ajax(url, 'post', data, {answer:'.sender_pickup_body',success:sucFunc});

});

$(document).on('change','#addres_book_list', function () {

    var drop = false;
    var pickup = false;
    var pickup_val = '';

    if($('.drop_off').prop('checked')){

        drop = true;

    }

    if ($('.pick_up').prop('checked')){

        pickup = true;
    }

    if($('#pickup_time').val() != ''){

        pickup_val = $('#pickup_time').val();
    }

    var info = $(this.form).serializeArray();
    info.push({name:'add_id',value:$('#addres_book_list').val()});
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'sender_id',value:$('#data_id').val()});
    info.push({name:'pickup',value:pickup});
    info.push({name:'drop',value:drop});
    info.push({name:'pickup_val',value:pickup_val});
    info.push({name:'chenged_address',value:true});
    info.push({name:'trav_id',value:$('#traveller_list_select').val()});

    var url = base_url + 'order/ax_sender_pickup_info';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var data = info;
    send_ajax(url, 'post', data, {answer:'.sender_pickup_body',success:sucFunc});

});

$(document).on('change','.signature',function () {

    if($('.signature').prop('checked')){

        $('#signature_check_modal').modal('show');

    }


});

$(document).on('change','#traveller_list_receiver', function () {

    var signature = false;

    if($('.signature').prop('checked')){

        signature = true;

    }

    var info = $(this.form).serializeArray();
    info.push({name:'trav_id',value:$('#traveller_list_receiver').val()});
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'delivery_id',value:$('#delivery_info').val()});
    info.push({name:'signature',value:signature});
    info.push({name:'chenged_trav',value:true});
    info.push({name:'add_id',value:$('#addres_book_receiver').val()});

    var url = base_url + 'order/ax_receiver_info';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var data = info;
    send_ajax(url, 'post', data, {answer:'.receiver_delivery_body',success:sucFunc});

});

$(document).on('change','#addres_book_receiver', function () {

    var signature = false;

    if($('.signature').prop('checked')){

        signature = true;

    }

    var info = $(this.form).serializeArray();
    info.push({name:'add_id',value:$('#addres_book_receiver').val()});
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'delivery_id',value:$('#delivery_info').val()});
    info.push({name:'signature',value:signature});
    info.push({name:'chenged_address',value:true});
    info.push({name:'trav_id',value:$('#traveller_list_receiver').val()});

    var url = base_url + 'order/ax_receiver_info';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var data = info;
    send_ajax(url, 'post', data, {answer:'.receiver_delivery_body',success:sucFunc});

});


$(document).on('change', '#pickup_time', function () {

    if($('#pickup_time').val() != ''){

        $('.pick_up').trigger('click');

    }else{

        $('.drop_off').trigger('click');
    }

});

$(document).ajaxComplete(function() {
    $('[data-toggle="popover"]').popover();
});

$(document).on('change', '#my_profile_country', function () {

    var url = base_url + "user/get_states/get_traveller_state_select";
    var sucFunc = "$('#region_account_info').selectpicker('refresh')";
    var ans = "#region_account_info";
    send_ajax(url, 'post', {country: $(this).val()}, {answer: ans, success: sucFunc});

});

$(document).on('change','#my_profile_country',function () {

    if($('#my_profile_country').val() != 'US_226'){

        $('.zip_code_text .important').remove();

        return false;
    }

    $('.zip_code_text').append('<span class="important">*</span>');

});

$(document).on('click','.save_payment_card',function () {

    $(this).prop('disabled', true);
    var formid = ('#pay_select');
    var state = ('#region_account_info');
    var zip = ('#zip_code');
    $(this.form).find('*').removeClass('error_red_class');
    $('#show_upload_error_img').removeClass('error_img');
    var log = true;
    var error = [];
    $("#show_error_my_profile").html('');

    var credit_card = {
        holder_first_name: {errorname: 'Name ', required: true, minlength:2, formid:formid},
        holder_last_name: {errorname: 'Last name', required: true,  minlength:2, formid:formid},
        card_number: {errorname: 'Card number', required: true, numeric:true,card_number:true,formid:formid},
        exp_mounth:{errorname: 'Expiration mounth', required: true,formid:formid},
        exp_year: {errorname: 'Expiration year', required: true,formid:formid},
        security_code: {errorname: 'Security code', required: true, numeric:true,minlength:3,maxlength:4,formid:formid},
        credit_card_country:{errorname: 'Country', required:true, formid:formid},
        address1: {errorname: 'Address 1', required: true,formid:formid},
        city: {errorname: 'City', required: true,formid:formid},
        phone: {errorname: 'Phone', required: true, minlength:5, maxlength:22, formid:formid}
    };

    if($(formid + ' #my_profile_country').val() == 'US_226'){

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

        $("#show_error_my_profile").removeClass('error_img');
        if (!log) {

            $('#upload_modal').modal('show');
            $(this).prop('disabled', false);

            for (var i = 0;i<error.length; i++) {

                $("#show_error_my_profile").addClass('error_class');

                $("#show_error_my_profile").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
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
    }, stripeResponseHandler1);
    return false; // submit from callback

});

function stripeResponseHandler1(status, response) {

    if (response.error) {

        $('.save_payment_card').prop('disabled', false);
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(response.error['message']);


    } else {

        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        $('#pay_select').append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // and submit
        var url = base_url+'user/ax_add_credit_card';
        var send_data = $('#pay_select').serializeArray();
        send_data.push({name:'order_processing',value:'1'});
        send_data.push({name:'order_id',value:$('#order_id').val()});
        var beforsend = '$(".payment_loader").removeClass("display_none"); $(".payment_info_answer_div").addClass("display_none");';
        var comlete = '$(".payment_loader").addClass("display_none");$(".payment_info_answer_div").removeClass("display_none");';
        send_ajax(url,'post',send_data,{handler:'add_credit_card_handler', answer:'.answer_div',beforsend:beforsend,complete:comlete});
    }
}

function add_credit_card_handler(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);
    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('.save_payment_card').prop('disabled', false);
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        $('#show_error_my_profile').addClass('success_class');
        $("#show_error_my_profile").html(obj['success']);
        var url = base_url+'order/set_credit_card';
        var send_data = {card_id:obj['card_id'],order_id:$('#order_id').val()};

        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');

        if (sender_class == 'fa information-icon') {

            $('.sender_butt').trigger('click');

        }else if (delivery_class == 'fa information-icon') {

            $('.receiver_delivery_butt').trigger('click');

        }else{

            $('.payment_information').trigger('click');
        }




        send_ajax(url,'post',send_data,{handler:'set_credit_card_hemdler'});

    }

}


function set_credit_card_hemdler(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('.save_payment_card').prop('disabled', false);
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {
        $("#payment_info_icon").attr('class','fa verified-icon');
        get_payment_info(false,true);
        set_icon_js();
    }

}

$(document).on('click', '.insurance_button', function () {


    var url = base_url+'order/ax_insurance';
    $('#insurance_modal_add').modal('show');

    var sucFunc="$('.select-country').selectpicker('refresh')";
    var data = {};
    var ser_arr = $('.incurance_form').serializeArray();
    $.each(ser_arr, function(index, value) {

        data[index] = value['value'];

    });

    var send_data = {order_id:$('#order_id').val(), incurance_id:data};

    send_ajax(url,'post',send_data,{answer:'#order_incurance',success:sucFunc,show_loader:true});
});

$(document).on('change', 'select.incurance_select', function () {

    var ser_arr = $(this.form).serializeArray();
    var data = {};

    $.each(ser_arr, function(index, value) {

        data[index] = value['value'];

    });

    var send_data = {order_id:$('#order_id').val(),country_id:pick_up_country, incurance_id:data,type:$('#type_id').val()};
    var url = base_url+'order/get_price_incurance';
    send_ajax(url,'post',send_data,{handler:'price_handler'});

});

function price_handler(data) {

    var obj =  $.parseJSON(data);

    if(obj['max_incurance'] == '0'){

        $('#incurance_fee').html('$' + obj['max_incurance']);
        $('#incurance_amount').html('$'+ obj['extra_fee']);
    }else {

        $('#incurance_fee').html('$' + obj['max_incurance']);
        $('#incurance_amount').html('$'+ obj['extra_fee']);
    }
}

$(document).on('click','.save_incurance', function () {

    var ser_arr = $(this.form).serializeArray();
    var data = {};

    $.each(ser_arr, function(index, value) {

        var luggage = value['value'].split('_');
        if(luggage.length != 2){

            return;
        }
        data[luggage[1]] = luggage[0];

    });


    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val(),return_view:true, incurance_id:data};
    var url = base_url+'order/ax_update_insurance';
    send_ajax(url,'post',send_data,{handler:'update_incurance_handler'});

});

function update_incurance_handler(data) {

    var obj = $.parseJSON(data);
    if (obj["errors"].length > 0) {

        $('#answer_upload>#show_upload_error_img').addClass('error_img');
        $('#answer_upload>#show_error_my_profile').addClass('error_class');
        $("#answer_upload>#show_error_my_profile").html(obj['errors']);
    }
    else {

        $('.incurance_class').html('UP to $' + obj['insurance'] +' '+'Insurance');
        $('.free_insurance').html('(+' + '$'+ obj['max_incurance'] + ')');
        $('#insurance_modal_add').modal('hide');
        change_price();
    }
}

$(document).on('click', '.edit_sender_info', function () {

    var id = $(this).attr('data_id');
    $('#data_id').val(id);
    $("#sender_pickup").attr('class','fa information-icon');
    get_sender_info($('#data_id').val(),true);
});

$(document).on('click', '.edit_delivery_info', function () {

    var id = $(this).attr('data_id');
    $('#delivery_info').val(id);
    $("#receiver_delivery_icon").attr('class','fa information-icon');
    get_delivery_info($('#delivery_info').val(),true);
});

$(document).on('click', '.delivery_label', function () {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val()};
    var url = base_url+'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    $('#delivery_label_modal').modal('show');
    send_ajax(url,'post',send_data,{answer:'#delivery_label',success: sucFunc});
});

$(document).on('change','#delivery_label_list', function () {

    if($('#delivery_label_list').val() == ' '){

        return false;
    }

    var url = base_url + 'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var info = $(this.form).serializeArray();
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'trav_id',value:$('#delivery_label_list').val()});
    info.push({name:'country_id',value:$('#country_id').val()});
    info.push({name:'trav_changed',value:true});
    info.push({name:'add_id',value:$('#delivery_label_address').val()});
    send_ajax(url, 'post', info, {answer:'#delivery_label',success:sucFunc});

});

$(document).on('change','#delivery_label_address', function () {

    if($('#delivery_label_address').val() == ' '){

        return false;
    }


    var url = base_url + 'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var info = $(this.form).serializeArray();
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'add_id',value:$('#delivery_label_address').val()});
    info.push({name:'country_id',value:$('#country_id').val()});
    info.push({name:'adress_changed',value:true});
    info.push({name:'trav_id',value:$('#delivery_label_list').val()});
    send_ajax(url, 'post', info, {answer:'#delivery_label',success:sucFunc});

});

$(document).on('click','.delivery_label_save', function () {

    $('#delivery_label_form > *').find('*').removeClass('error_red_class');
    var log = true;
    var formid = '#delivery_label_form';

    var traveler_fields = {
        first_name: {errorname: 'First name', required: true, minlength: 2,formid:formid},
        last_name: {errorname: 'Last name', required: true, minlength: 2,formid:formid},
        phone: {errorname: 'Phone Number', required: true,minlength:5,maxlength:22,formid:formid},
        address1: {errorname: 'Address', required: true,formid:formid},
        remark:{errorname: 'Remark',maxlength:200,formid:formid},
        postal_code:{errorname: 'Postal Code', required: true, minlength: 4,formid:formid},
        city:{errorname: 'City', required: true, minlength: 4,formid:formid}
    };

    if($('#country_id').val() == us_id){

        traveler_fields['state_region'] = {errorname: 'State / Region', required: true,formid:formid};
    }

    $.each(traveler_fields, function (index, value) {

        error = valid_fields(index, value);

        if (error != '') {

            log = false;

            return false;
        }

    });

    if (!log) {

        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(error);

    } else {

        var send_data = $(this.form).serializeArray();
        send_data.push({name:'order_id', value:$('#order_id').val()});
        send_data.push({name:'country_id', value:$('#country_id').val()});
        var url = base_url + 'order/ax_save_delivery_label';
        send_ajax(url, 'post', send_data, {handler:'delivery_label_handler'});
    }
});

function delivery_label_handler(data) {

    $("#register_error").html('');
    $('#add_error_img').removeClass('error_img');
    $('#register_error').removeClass('success_class');

    var obj = $.parseJSON(data);


    if (obj["errors"].length > 0) {

        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(obj['errors']);
    }
    else {
        $('#delivery_label_modal').modal('hide');
    }
}

$(document).on('click', '.drop_off_location', function () {

    $('#drop_off_map').modal('show');
    var send_data = {'order_id':$('#order_id').val()};
    var url = base_url + 'order/ax_drop_off_map';

    $.ajax({
        url: url,
        type: 'post',
        data:  send_data,
        beforeSend: function() {
            $('#drop_off_content').html(
                "<div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>");
        },
        success: function(data){
            $('#drop_off_content').html(data);
            /*$('#find_drop_off_inter').trigger('click');*/
        }
    });

});


var customLabel = {

    ups: {
        label: '',
        icon: 'https://www.luggagetoship.com/assets/images/ups-pin.png'
    },

    fedex: {
        label: '',
        icon: 'https://www.luggagetoship.com/assets/images/fedex-pin.png'
    }

};


function initMap(xml, lat, lng) {

    google_markers = [];

    var map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(lat, lng),
        zoom: 10
    });

    var infoWindow = new google.maps.InfoWindow;

    // Change this depending on the name of your PHP or XML file
    $('#xml').html(xml);

    markers = document.getElementsByTagName('marker');
    var i = 0;

    Array.prototype.forEach.call(markers, function(markerElem) {
        var name = markerElem.getAttribute('name');
        var address = markerElem.getAttribute('address');
        var type = markerElem.getAttribute('type');
        var point = new google.maps.LatLng(
            parseFloat(markerElem.getAttribute('lat')),
            parseFloat(markerElem.getAttribute('lng')));

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        var l_pickup_green = markerElem.getAttribute('last_pickup_green');
        var l_pickup_orange = markerElem.getAttribute('store_closes');
        var phone = markerElem.getAttribute('phone');
        var distance = markerElem.getAttribute('dist');
        strong.textContent = name;
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));

        var text = document.createElement('text');
        text.textContent = address;
        infowincontent.appendChild(text);
        var icon = customLabel[type] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            label: icon.label,
            icon: icon.icon,
            index:i
        });

        google.maps.event.addListener(marker, 'click', function() {

            marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function(){ marker.setAnimation(null); }, 5000);

             index_fedex = marker.index;

            $('#info').animate({scrollTop: $('#location-'+index_fedex).offset().top - ($('#info').offset().top - $('#info').scrollTop())}, 'slow');

            $('#location-'+index_fedex).siblings().removeClass('listItemSelect');

            $('#location-'+index_fedex).addClass('listItemSelect');

        });


        marker.addListener('click', function() {

            if(order_shipping_fedex_use_address){
                infoWindow.setContent('<div><strong>' + name + '</strong><br>' +
                    address + '</div>'+'' +
                    '<div>phone: '+phone+'</div>' +
                    '<ul class="last-pickup-indicator last_pickup_dropoff">' +
                    '<li><span></span>Last Pickup '+l_pickup_green+'</li>' +
                    '<li><span></span>Last Pickup '+l_pickup_orange+'</li>' +
                    '</ul>'+
                    '<div class=""><span class="distance"> mi '+distance+'<img class="location-icon" src=" '+base_url+'assets/images/location-icon.png"></span></div>'+
                    '<div><a href="#" class="btn btn-default btn-file select-doc-file fill_butt fill_butt_fedex" data-index='+index_fedex+'>Use this address as origin address</a></div>'
                );
                infoWindow.open(map, marker);

            }else{
                infoWindow.setContent('<div><strong>' + name + '</strong><br>' +
                    address + '</div>'+'' +
                    '<div>phone: '+phone+'</div>' +
                    '<ul class="last-pickup-indicator last_pickup_dropoff">' +
                    '<li><span></span>Last Pickup '+l_pickup_green+'</li>' +
                    '<li><span></span>Last Pickup '+l_pickup_orange+'</li>' +
                    '</ul>'+
                    '<div class="drop_off_mile"><span class="distance"> mi '+distance+'<img class="location-icon" src=" '+base_url+'assets/images/location-icon.png"></span></div>'
                );
                infoWindow.open(map, marker);
            }



        });


        google_markers.push(marker);
        i++;

    });

    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < google_markers.length; i++) {
        bounds.extend(google_markers[i].getPosition());
    }
    map.fitBounds(bounds);

}

$(document).on('click', '.location-box', function() {

    var markerNum = $(this).data('id');
    //$('#location-'+markerNum).toggleClass('listItemSelect');
    //$('#location-'+markerNum).siblings().removeClass('listItemSelect');

    google.maps.event.trigger(google_markers[markerNum], 'click');

    google_markers[markerNum].setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(function(){ google_markers[markerNum].setAnimation(null); }, 5000);

});



$(document).on('change', '.pickup_price', function(){

    var bool = $(this).val();

    if(bool == 1){

        $('#pickup_time').val('');
        $('#pickup_time').selectpicker('refresh')
    }

    calculate_pick_up_fee(bool,order_pickup);
    order_pickup = bool;

});

function change_price(){

    var url = base_url+'order/ax_get_order_fee';
    var send_data={order_id:$('#order_id').val()};
    send_ajax(url, 'post', send_data, {answer:'.pay_amount'});
    get_payment_info(false,false);
}

function calculate_pick_up_fee(bool,order_pickup){

    var fee = $('#pickup_price').val();
    var value = $('.pay_amount').html();
    value = parseFloat(value.substr(1, value.length));

    if(bool == '2'){
        $('.pay_amount').html('$' + (parseFloat(value) + parseFloat(fee)).toFixed(2));
    }else if(order_pickup != '' && bool == '1'){

        $('.pay_amount').html('$' + (parseFloat(value) - parseFloat(fee)).toFixed(2));
    }
}

$(document).on('click','#apply_discount_code',function () {

    var url = base_url+'order/ax_set_discount';
    var promo_code = $('#promotion_code').val();
    var order_id = $('#order_id').val();

    var send_data={order_id:order_id, code:promo_code};

    send_ajax(url, 'post', send_data, {handler:'code_change_handler'});

});

function change_price_discount(){

    var url = base_url+'order/ax_get_order_fee';
    var send_data={order_id:$('#order_id').val()};
    send_ajax(url, 'post', send_data, {answer:'.pay_amount'});
}

function code_change_handler(data){

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    $('#show_error_my_profile').removeClass('error_class');

    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(obj['errors']);
    }
    else {

        get_discount();
        change_price_discount();
    }

}

function scroll_to_id(this_id) {
    id = this_id;

    if($(window).width()< 767){
        $('html,body').animate({
                scrollTop: $("#" + id).offset().top},
            'slow');
    }

}


$(document).on('mouseover', '.credit_card_popover', function () {
    $('.credit_main').parent().parent().addClass('my-own-popover');
    $('.credit_main').parent().parent().addClass('my_credit_popover');
});

$('#truck_button').click(function () {

    var carrier = $('#trucking_carrier').val();
    var trucking_number = $('#truck_number').val();
    var url = base_url+'luggage-tracking/'+carrier+'/'+trucking_number;
    location.replace(url);

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


$('.corporate_acount').click(function () {

    $('#corporate_acount').modal('show');
});

$(document).on('click', '.affiliate_link', function () {

    $('#corporate_acount').modal('show');
    $('#title_answer').html(' Affiliate Form');
    $('#save_corporate_button').attr('data_type','affiliate_type');
});

$('.save_corporate_form').click(function () {

    $('#corporate_form > *').find('*').removeClass('error_red_class');
    var log = true;
    var corporate_form  = {
        first_name:{errorname:'First name', required: true, minlength:2},
        last_name:{errorname:'Last name', required: true, minlength:2},
        title:{errorname:'Title', required: true},
        organization:{errorname:'Organization', required: true},
        email:{errorname:'Email', required: true, emailvalid:true },
        phone:{errorname:'Phone number', required: true}

    };

    $.each(corporate_form, function( index, value ) {

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
    }
    else{

        var send_data=$("#corporate_form").serializeArray();
        send_data.push({name:'type', value:$(this).attr('data_type')});
        var url = base_url+'public_pages/ax_send_public_email';
        send_ajax(url, 'post', send_data, {handler:'send_public_email_handler'});

    }
});



function send_public_email_handler(data) {
    $("#register_error").html('');
    $('#add_error_img').removeClass('error_img');
    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {
        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(error);
    }
    else {
        $('#corporate_acount').modal('hide');

    }
}

$('.size_details').click(function () {

    $('html,body').animate({
            scrollTop: $(this).parents('span').prev().prev().prev().offset().top},
        'slow');
});

$('.filter-block .home_img_box_class').click(function () {

    $('html,body').animate({
            scrollTop: $(this).offset().top},
        'slow');
});

$(document).on('click', '#update_item_pop', function () {

    $('#update_item').trigger('click');
    $('.edit_popover').trigger('click');
});

$(document).on('click', '#update_item_pop_country', function () {

    $('#update_item').trigger('click');
    $('.edit_popover_country').trigger('click');
});


/*
function init_map_dhl(lat,lng,zoom, search) {
    var map;
    var infowindow;

    function initMap() {
        var pyrmont = new google.maps.LatLng(lat,lng);

        map = new google.maps.Map(document.getElementById('map'), {
            center: pyrmont,
            zoom: zoom
    });

        var request = {
            location: pyrmont,
            radius: '500',
            query: search
        };

        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);
    }

    function callback(results, status) {

        if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                createMarker(results[i]);
            }
        }
    }

    function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
            console.log('aaa');
        });
    }


}*/

$("#drop_off_map").on("hidden.bs.modal", function () {

    exitFullscreen();
});


function exitFullscreen() {
    var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
        (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
        (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
        (document.msFullscreenElement && document.msFullscreenElement !== null);

    var docElm = document.documentElement;
    if (isInFullScreen) {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
        viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
        document.body.addEventListener('gesturestart', function () {
            viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
        }, false);
    }
}