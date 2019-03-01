$('#update_item').click(function(){
    $('#update_item_modal').modal('show');
});

$('.yes_update').click(function () {
    var order_id = $('#order_id').val();
    var url = base_url + '/order/ax_update_item_or_service';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'update_item_or_service_handler'});
});



$('.no_update').click(function () {
    $('#update_item_modal').modal('hide');
});

function update_item_or_service_handler(data){

    var obj = $.parseJSON(data);

    if(obj['errors'].length>0){

        return false;

    }else{

        location.replace(base_url);
    }

}

$('.dashboard_view_edit_sender').click(function () {
    bootbox.alert("You can not change sender information");
});

$('.dashboard_view_edit_delivery').click(function () {

    bootbox.alert("You can not change delivery information");

});

$('#order_submit').click(function () {
    var sender_class = $('#sender_pickup').attr('class');
    var delivery_class = $('#receiver_delivery_icon').attr('class');
    var payment_class = $('#payment_info_icon').attr('class');

    if (sender_class != 'fa verified-icon' || delivery_class !=  'fa verified-icon' || payment_class != 'fa verified-icon') {
        $('#order_submit_error_modal').modal('show');
        return false;
    }


    $("input[name='accept']" ).removeClass('error_red_class');
    var log = true;
    var order_processing  = {

        accept:{errorname:'The Terms & Conditions',checked:true,error_text:'Please read and accept terms and conditions.'}

    };

    $.each(order_processing, function( index, value ) {

        error = valid_fields(index,value);

        if(error != ''){

            log = false;

            return false;
        }

    });



    $("#show_upload_error_img").html('');
    $('#show_error_my_profile').removeClass('error_img');

    if (!log ){
        $('.order_complete_error').addClass('display_none');
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(error);
    }
    else{

        $('#ajax_modal').modal({

            backdrop: 'static',
            keyboard: false
        });
        var send_data={order_id:$('#order_id').val()};
        var url = base_url+'order/ax_check_order';
        var load_script = '$("#ajax_modal").modal("show"); $("#process_word").html("CHECKING...");';

        send_ajax(url, 'post', send_data, {handler:'order_submit_handler',beforsend:load_script});

    }

});


$("#upload_modal").on("hidden.bs.modal", function () {
    $('.order_complete_error').addClass('display_none');
});

function order_submit_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {

        var error_text = '';
        $("#ajax_modal").modal("hide");
        $("#show_error_my_profile").html('');
        $('#show_upload_error_img').removeClass('error_img');

        for(var i = 0; i < obj['errors'].length; i++){

            $("#show_error_my_profile").append('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][i] + '</span></div>');
        }

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');


    }
    else {

        if(obj['type'] == '2'){
            $('#checking_span').attr('class', 'fa fa-check verified-icon');
            var send_data={order_id:obj['order_id']};
            var url = base_url+'order/ax_charge_order_pay';
            var load_script = '$("#process_word").html("CHARGING...");';
            send_ajax(url, 'post', send_data, {handler:'order_charging_handler', beforsend:load_script});

        }else{

            location.replace(base_url+ 'order/custom_documents/' + obj['order_id']);
        }


    }
}

function order_charging_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {

        $("#ajax_modal").modal("hide");
        $('#shippo_error_modal').modal('show');

    }
    else {
            $('#charging_span').attr('class', 'fa fa-check verified-icon');
            var send_data={order_id:obj['order_id']};
            var url = base_url+'order/ax_create_shipment';
            var load_script = '$("#process_word").html("PROCESSING...");';
            var compecte = '$("#ajax_modal").modal("hide")';
            send_ajax(url, 'post', send_data, {handler:'creting_labbel_handler', beforsend:load_script,complete:compecte});

    }

}

function creting_labbel_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $("#ajax_modal").modal("hide");
        $('#shippo_label_error_modal').modal('show');
    }
    else {
        $('#shippo_success_modal').modal('show');
    }


}

$('#shippo_error_modal').on('hidden.bs.modal', function (){

    var order_id = parseInt($('#order_id').val());
    location.replace(base_url+ 'order/order_processing/'+order_id);
});

$('#shippo_label_error_modal').on('hidden.bs.modal', function (){

    var order_id = parseInt($('#order_id').val());

    location.replace(base_url+ 'dashboard/view_order/'+order_id);
});


$('#shippo_success_modal').on('hidden.bs.modal', function (){

    var order_id = parseInt($('#order_id').val());

    location.replace(base_url+ 'dashboard/view_order/'+order_id);
});


$('.close_error_modal').click(function () {

    $('#shippo_error_modal').modal('hide');
});

$('.close_update_modal').click(function () {

    $('#updaeding_order_modal').modal('hide');
});

$('.close_label_error_modal').click(function () {

    $('#shippo_label_error_modal').modal('hide');
});


$('.cansel_order').click(function () {

    $("#cancel_modal").modal("show");

});

$('#no_cancel').click(function(){

    $("#cancel_modal").modal("hide");

});

$('#yes_cancel').click(function(){
    var send_data = {order_id: $('#order_id').val()};
    var url = base_url + 'order/ax_cancel_order';
    send_ajax(url, 'post', send_data, {handler: 'order_cancel_handler'});
});


function order_cancel_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);
    }
    else {

        location.replace(base_url+ 'order_history/history');
    }
}

$('.label_delivery').click(function () {

    $('#label_delivery_view').modal('show');
    get_delivery_label_view();
});

$(document).on('click', '.deliver_label_edit', function () {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val()};
    var url = base_url+'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    send_ajax(url,'post',send_data,{answer:'#edit_delivery_label_answer',success: sucFunc});
});


$('.luggage_incurance').click(function () {

    $('#insurance_modal').modal('show');
    get_incurance_view();
});

$(document).on('click', '.insurance_edit_button', function () {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val()};
    var url = base_url+'order/ax_insurance';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    send_ajax(url,'post',send_data,{answer:'#answer_incuranc',success:sucFunc,show_loader:true});
});

$(document).on('click','.close_modal',function () {

    close_modal('#insurance_modal');
});

$(document).on('click','.delivery_label_edit',function () {

    $('#label_delivery_view').modal('hide');
});



function close_modal(modal_id) {

    $(modal_id).modal('hide')
}

function get_incurance_view() {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val()};
    var url = base_url+'order/ax_incurance_view';
    send_ajax(url,'post',send_data,{answer:'#answer_incuranc',show_loader:true});
}

function get_delivery_label_view() {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val()};
    var url = base_url+'order/ax_delivery_label_view';
    send_ajax(url,'post',send_data,{answer:'#edit_delivery_label_answer',show_loader:true});
}

function get_item_list() {

    var send_data={order_id:$('#order_id').val()};
    var url = base_url+'order/ax_cancel_order';
    send_ajax(url, 'post', send_data, {});
}

$(document).on('click','.change_discount_code',function () {

    bootbox.confirm({
        message: "Please be advised only one promotion code can be applied to your order. <br><br> Are you sure you would like to change the code?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                $('.discount_code_block').html(

                    '<form method="post" action="" class="pay_select"><div class="form-group"> <input type="text" class="form-control show-placeholder placeholder_class" name="" placeholder="Enter promotion code" id="promotion_code"> </div> <div class="form-group"> <button type="button" class="btn apply_discount_code btn-default select-doc-file apply-promotion" id="apply_discount_code">Apply The Code</button> </div></form>'

                );

                $('.change_discount_code').addClass('dis_none');

            }
        }
    });

});

function get_item_list() {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'custom_documents';

    if($.inArray(method,link_arr) == -1){

        return false;
    }

    var send_data={order_id:$('#order_id').val()};
    var url = base_url+'order/ax_item_list';
    var sucScript  = '$(".select-country").selectpicker("refresh");$("#signature").jSignature();';
    send_ajax(url, 'post', send_data, {answer:'#account_information', complete:sucScript,abort:true});
 }


 function get_passport_copy() {

     var link = $(location).attr('href');
     var link_arr = link.split('/');
     var method = 'custom_documents';
     var method2 = 'custom_documents_view';

     if($.inArray(method,link_arr) == -1 && $.inArray(method2,link_arr) == -1){

         return false;
     }

     var send_data = {order_id:$('#order_id').val()};
     var url = base_url+'order/ax_order_passport_info';
     var sucScript  = '$(".select-country").selectpicker("refresh")';
     send_ajax(url, 'post', send_data, {answer:'#traveler_list',success:sucScript,abort:true});
 }
 
 function get_travel() {

     var link = $(location).attr('href');
     var link_arr = link.split('/');
     var method = 'custom_documents';
     var method2 = 'custom_documents_view';

     if($.inArray(method,link_arr) == -1 && $.inArray(method2,link_arr) == -1){

         return false;
     }



     var send_data = {order_id:$('#order_id').val()};
     var success = '$("#arrival_date").datepicker({startDate: "dateToday",format:"yyyy-mm-dd"});$("#departure_date").datepicker({startDate: "dateToday",format:"yyyy-mm-dd"})';
     var url = base_url+'order/travel_itinerary_info';
     send_ajax(url, 'post', send_data, {answer:'#address_book',abort:true,success:success});
 }

get_item_list();

$(document).on('click','.item_list',function () {

    get_item_list();
});

$(document).on('click','.pasport_copy',function () {

    get_passport_copy();
});


$(document).on('click','.travel_itinary',function () {
    get_travel();


});

 $('.dahboard_item_list').click(function () {

     get_item_list();
 });

/*
$('.dashboard_pasport').click(function () {

    var order_id = $(this).attr('data_id');
    var url  = base_url+'order/custom_documents/'+order_id;
    location.replace(url);
})
$(document).ready(function () {

    $('.dashboard_pasport_copy').click(function () {


        //$('#pasport_copy').trigger('click');


        console.log('aa');
    });
});
*/

$(function() {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'custom_documents';

    if($.inArray(method,link_arr) == -1){

        return false;
    }

    if($(window).width()< 767){

        $('.button_width').parent().css('text-align', 'center');
    }

    if($(window).width()< 992){
        $('.item_list').trigger('click');
    }

    $(document).on('click', '.clear-signature', function() {
        $("#signature").jSignature("reset");
    });

    var fieldHTML = '';
    var x = parseInt(item_count);
    var options = '';
    $.each(item_name, function (index, value) {

            options = options +  '<option value="'+value['title']+'">'+value['title']+'</option>';

        });

    $(document).on('click', '.add-more-item', function(e) {
        e.preventDefault();
      /*  x =parseInt($('.lists-block-add-item .total-quantity').html());*/
        fieldHTML = '<div class="lists-block new-adding-place">' +
            '<div class="list-item-area">' +
            '<div class="col-sm-5 col-xs-11 list-input">' +
            '<select class="form-control selectpicker select-country item_list_select" name="names[]">' +
            '<option value="">Please select tems name</option>' +
            '<option value="new">Add new item</option>'+
            options +
            '</select>' +
            '</div>' +
            '<div class="col-sm-2 col-xs-4 list-input">' +
            '<input type="text" class="form-control quantity_value_'+(x+1)+' count_item unit_val" data_count = "'+(x+1)+'" name="counts[]" placeholder="Quantity">' +
            '</div>' +
            '<div class="col-sm-2 col-xs-4 list-input">' +
            '<input type="text" class="form-control unit_value_'+(x+1)+' unit_value unit_val" data_count = "'+(x+1)+'" name="prices[]" placeholder="Unit Value">' +
            '</div>' +
            '<div class="col-sm-2 col-xs-4 list-input">' +
            '<span class="col-padding orange-color sum_row_'+(x+1)+' sum_all_row">$0</span>' +
            '</div>' +
            '<div class="item-delete"><a href="" class="remove-more-item red-color"><i class="fa fa-times"></i></a></div>' +
            '</div>' +
            '</div>';

        x++;

        $('.add_more_fields').append(fieldHTML);
   /*     $('.lists-block-add-item .total-quantity').html(x);*/
        $('.selectpicker').selectpicker();
    });

});

$(document).on('click', '.remove-more-item', function(e){

    var count_item = parseInt($('.lists-block-add-item .total-quantity').html());
    e.preventDefault();
    $(this).parents('div.new-adding-place').remove();
    count_item--;
    total_price();
});


function count_up(count) {

    var quantity_value = parseFloat($('.quantity_value_' + count).val());
    var unit_value = parseFloat($('.unit_value_' + count).val());

    if(!$.isNumeric(quantity_value)){

        quantity_value = 0;
    }

    if(!$.isNumeric(unit_value)){

        unit_value = 0;
    }

    var sum = quantity_value * unit_value;
    $('.sum_row_' + count).html('$' + sum.toFixed(2));

    total_price();
}
popap_open = true;

function total_price() {

    var all_sum = $('.sum_all_row');
    var sum_quantity = $('.count_item');
    var total_price = 0;

    for(var i=0; i<all_sum.length; i++)
    {
        var all_val = $(all_sum[i]).html();

        var all_val =parseFloat(all_val.substr(1, all_val.length));

        total_price += all_val;
    }
    var totial_price2 = 0;
    for(var i=0; i<sum_quantity.length; i++)
    {
        var all_value = parseInt($(sum_quantity[i]).val());

       /* var all_value =parseFloat(all_value.substr(1, all_value.length));*/

        totial_price2 += all_value;
    }

    $('.lists-block-add-item .total-quantity').html(totial_price2);

    $('.total-price').html('$ ' + total_price.toFixed(2));


    if(custom_value > 0 && $('.individual').prop('checked') && popap_open){

        $('#custom_value_modal').modal('show');
         popap_open = false;

    }else if(custom_value == 0 && $('.individual').prop('checked') && popap_open){

        $('#custom_value_null_modal').modal('show');
        popap_open = false;
    }
}

$(document).on('keyup','.count_item',function () {

    var count = $(this).attr('data_count');
    count_up(count);
});

$(document).on('keyup','.unit_value',function () {

    var count = $(this).attr('data_count');
    count_up(count);
});
$(document).on('click', '.submit_all', function () {

    var data  = $(this.form).serializeArray();
    save_item_list(data,false);

});

$(document).on('click', '.edit_all_item_list', function () {

    var data  = $(this.form).serializeArray();
    save_item_list(data,true);

});

$(document).on('click','.clear_signature_db',function () {

    if($('.individual').prop('checked')){

        $('.comertial').attr('disabled', 'disabled');
    }
    if($('.comertial').prop('checked')){

        $('.individual').attr('disabled', 'disabled');
    }

    var order_id = $('#order_id').val();
    var url = base_url+'order/ax_delete_signature';
    var success = 'set_icon(false,"item_list");';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'clear_signature_handler', success:success});

});
$(document).ready(function () {

    $(function () {

        var link = $(location).attr('href');
        var link_arr = link.split('/');
        var method = 'custom_documents';

        if($.inArray(method,link_arr) == -1){

            return false;
        }

        if(order_type == 2 || order_type == 1){

            return false;
        }


        $('#pasport_travel_hide').modal('show');
    })

});



function clear_signature_handler(data) {

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
        get_item_list();
        $('.item_list a> span> i').attr('class','fa fa-exclamation information-icon');

    }
}

function save_item_list(data,edit) {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var error = '';
    var defaultText = "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMCIgaGVpZ2h0PSIwIj48L3N2Zz4=";
    data.push({name:'order_id', value:$('#order_id').val()});
    var datapair = $("#signature").jSignature("getData", "image");

    if(datapair[1] == defaultText){

        error = "Please Insert  signature";
    }

    var radio_arr = $('.order_type:radio:checked');
    if(radio_arr.length == 0 && error == ""){

        error = "Please select Personal Effects or Commercial Use.";
    }

    if(error != ''){

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error);
        return false;
    }

    if(edit){

        data.push({name:'editable', value:true});
    }

    data.push({name:'signature', value:datapair[0] + "," + datapair[1]});
    var url = base_url+'order/ax_save_order_item_list';
    send_ajax(url, 'post', data, {handler:'save_item_list_handler'});

}

function save_item_list_handler(data) {
    $('#item_list_form *').removeClass('error_red_class');
    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors'][0]);

        if(obj['error_boolean'] === true){
            error_list();
        }


    }
    else {
        if($('.comertial').prop('checked')){

            $('#comertial_use_modal').modal('show');
        }

        if($('.individual').prop('checked')){

            $('#personal_effect_modal').modal('show');
        }


        get_item_list();
        set_icon(true,"item_list");
        $('.item_list a> span> i').attr('class','fa fa-check verified-icon');

    }
}

function error_list() {

    var divs = $('#item_list_form .lists-block');

    $.each(divs, function(index, value) {

        var inputs = $(value).find('input');
        var select = $(value).find('select');

        $.each(inputs, function(input_index, input_value) {

            if($(input_value).attr('name') != 'names[]'){

                if($(input_value).val() < 0 || $(input_value).val() == ''){

                    $(input_value).addClass('error_red_class');
                }

            }else{

                if($(input_value).val() == ''){

                    $(input_value).addClass('error_red_class');
                }

            }


        });

        $.each(select, function(select_index, select_value) {

            if($(select_value).val() == ''){

                $(select_value).parent().find('button').addClass('error_red_class');;
            }
        });

    });
}

$(document).on('click', '.personal_effect_modal_close', function () {

    $('#personal_effect_modal').modal('hide');
});


$(document).on('click', '.comertial_use_modal_close', function () {

    $('#comertial_use_modal').modal('hide');
});

$(document).on('click', '.close_custom_value_modal', function () {

    $('#custom_value_modal').modal('hide');
});

$(document).on('click', '.close_custom_value_null_modal', function () {

    $('#custom_value_null_modal').modal('hide');
});



$(document).on('click','.item_list_popap', function () {

    if($('.individual_popap').prop('checked')){

        $('.individual').prop('checked',true);
    }

    if($('.comertial_popap').prop('checked')){

        $('.comertial').prop('checked',true);
    }

    $('#pasport_travel_hide').modal('hide');

});

$(document).on('change','.order_type',function () {

    if(!$(this).prop('checked')){

        return false;
    }

    if($(this).val() == 1){

        $('.for_custum_documents').removeClass('dis_none_item_list');
        $('#traveler_list').removeClass('dis_none_item_list');
        $('.pasport_copy ').removeClass('dis_none_item_list');
        $('.travel_itinary  ').removeClass('dis_none_item_list');
        $('#address_book').removeClass('dis_none_item_list');
        return false;
    }

    $('.for_custum_documents').addClass('dis_none_item_list');
    $('#traveler_list').addClass('dis_none_item_list');
    $('.pasport_copy ').addClass('dis_none_item_list');
    $('.travel_itinary  ').addClass('dis_none_item_list');
    $('#address_book').addClass('dis_none_item_list');

});

function ax_upload_file_ajax(input,url) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var widget = this;
    widget.queuePos++;
    $('#error_mess_div>span').html('');
    var input = input;
    var file_data = new FormData;

    if(!$.isArray(input)){

        file_data.append('doc', input.prop('files')[0]);

    }else{

        for(var i = 0; i<input.length;i++){

            file_data.append(input['name'], input[i].prop('files')[0]);
        }
    }

    if(parseInt(input.prop('files')[0]['size'])/1000>5){

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html('The uploaded file exceeds the maximum allowed size in your PHP configuration file.');
    }

    file_data.append('order_id', $('#order_id').val());


    var url = url;

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
                $('#show_error_my_profile').html(obj_upload['errors']);

            }
            else {
                $('#upload_modal').modal('show');
                $('#show_error_my_profile').addClass('success_class');
                $('#show_error_my_profile').html(obj_upload['success']);

                $('.doc-file-place ul').append(
                    '<li>' +
                    '<div class="image_div">' +
                    '<img class="order_delete_img" data_id="'+obj_upload['file_id']+'" src="'+base_url+'assets/images/x_document.png">'+
                    '<a href="'+base_url+'order/user_file/'+obj_upload['file_name']+'/'+obj_upload['order_id']+'">' +
                    '<img class="main_img" src="'+base_url+'assets/images/file_uploaded.png">'+
                    '</a>'+
                    '<span>'+obj_upload['show_file_name']+'</span>'+
                    '</div>'+
                    '</li>'
                );
            }
            $('#upload_progressbar .proc_span').html('');
            $('#upload_progressbar .procent').css('width', '0');

        }
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}

$(document).on('change','#upload_file',function () {

    var input = $("#upload_file");
    var url = base_url + 'order/ax_upload_order_form_file';
    ax_upload_file_ajax(input,url);
    $(this).val('');
});

$(document).on('click','.order_delete_img',function () {

    var file_id = $(this).attr('data_id');

    bootbox.confirm({
        message: "Are you sure, you want to delete this file?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {


                var url = base_url+'order/ax_delete_order_form_file';
                var order_id = $('#order_id').val();
                send_ajax(url, 'post', {file_id:file_id,order_id:order_id}, {handler:'delete_file_handler'});
            }
        }
    });




});

function delete_file_handler(data) {

    $("#show_error_my_profile").addClass('error_class');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj_upload['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj_upload['success']);
        setTimeout(function(){
            location.reload();
        }, 1500);
    }

}

function ax_upload_file_ajax_for_passport(file_data,url,handler) {

    var widget = this;
    widget.queuePos++;

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
                $('#show_error_my_profile').html(obj_upload['errors']);

            }
            else {

                $('#upload_modal').modal('show');
                $('#show_error_my_profile').addClass('success_class');
                $('#show_error_my_profile').html(obj_upload['success']);
               if(handler == 'passport'){
                   get_passport_copy();
                   $('.pasport_copy > span> i').attr('class','fa fa-check verified-icon');

               }else if(handler == 'travel'){

                   $('.travel_itinary > span> i').attr('class','fa fa-check verified-icon');
                   get_travel();
               }
            }
        }
    });
}

$(document).on('change', '#passport_copy', function () {
    var input =$('#passport_copy');
    var url = base_url + 'order/ax_save_order_passport_info';
    var file_data = new FormData;
    if(!$.isArray(input)){

        file_data.append(input[0]['name'], input.prop('files')[0]);

    }else{

        for(var i = 0; i<input.length;i++){

            file_data.append(input[i][0]['name'], input[i].prop('files')[0]);
        }
    }

    file_data.append('order_id',   $('#order_id').val());
    file_data.append('country_id', $('#passport_issue_country').val());
    file_data.append('pas_number', $('.passport_copy').val());

    if(parseInt(input.prop('files')[0]['size'])/1000>5){

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html('The uploaded file exceeds the maximum allowed size in your PHP configuration file.');
    }


    ax_upload_file_ajax_for_passport(file_data,url,'passport');

});


$(document).on('change', '#visa_copy', function () {
    var input =$('#visa_copy');
    var url = base_url + 'order/ax_save_order_passport_info';
    var file_data = new FormData;
    if(!$.isArray(input)){

        file_data.append(input[0]['name'], input.prop('files')[0]);

    }else{

        for(var i = 0; i<input.length;i++){

            file_data.append(input[i][0]['name'], input[i].prop('files')[0]);
        }
    }

    file_data.append('order_id',   $('#order_id').val());
    file_data.append('country_id', $('#passport_issue_country').val());
    file_data.append('pas_number', $('.passport_copy').val());

    if(parseInt(input.prop('files')[0]['size'])/1000>5){

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html('The uploaded file exceeds the maximum allowed size in your PHP configuration file.');
    }

    ax_upload_file_ajax_for_passport(file_data,url,'passport');

});

$(document).on('click','.save_passport',function () {

    var url = base_url + 'order/ax_save_order_passport_info';

    var data = {'order_id': $('#order_id').val(),'country_id':$('#passport_issue_country').val(),'pas_number':$('.passport_copy').val()};
    send_ajax(url, 'post', data, {handler:'save_passport_handler'});

});

function save_passport_handler(data) {
    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);


    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        $('#passport_icon').attr('class','fa fa-check verified-icon');
        get_passport_copy();
    }

}

$(document).on('click','.save_travel',function () {

    var url = base_url + 'order/ax_save_travel_itinerary';
    var ser_arr = $(this.form).serializeArray();
    ser_arr.push({name:'order_id', value:$('#order_id').val()});
    send_ajax(url, 'post', ser_arr, {handler:'save_travel_handler'});
    
});

function save_travel_handler(data) {
    var obj = $.parseJSON(data);
    $('#show_upload_error_img').removeClass('error_img');
    if (obj['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj['success']);
        $('#travel_icon').attr('class','fa fa-check verified-icon');
        get_travel();
    }

}

$(document).on('change','#travel_file',function () {

    var url = base_url + 'order/ax_save_travel_itinerary';
    var input = $('#travel_file');
    var file_data = new FormData;
    var ser_arr = $('#travel_form').serializeArray();
    $.each(ser_arr, function(index, value) {

        file_data.append(value['name'],value['value']);
    });

    file_data.append('doc', input.prop('files')[0]);
    file_data.append('order_id',$('#order_id').val());

    if(parseInt(input.prop('files')[0]['size'])/1000>5){

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html('The uploaded file exceeds the maximum allowed size in your PHP configuration file.');
    }

    ax_upload_file_ajax_for_passport(file_data,url,'travel');
});

function delete_passport_img(file_name,type_name) {

    var url = base_url + 'order/ax_delete_passport_file';
    var order_id = $('#order_id').val();
    send_ajax(url, 'post', {file_name:file_name,order_id:order_id,type_name:type_name}, {handler:'pasport_file_delete_handler'});
}

$(document).on('click','.delete_passport_copy',function () {


    var file_name = $(this).attr('data-blok');
    var type_name = $(this).attr('data_name');

    bootbox.confirm({
        message: "Are you sure, you want to delete this file?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                delete_passport_img(file_name,type_name);

            }
        }
    });

});

$(document).on('click','.delete_visa_copy',function () {


    var file_name = $(this).attr('data-blok');
    var type_name = $(this).attr('data_name');

    bootbox.confirm({
        message: "Are you sure, you want to delete this file?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                delete_passport_img(file_name,type_name);

            }
        }
    });

});

function pasport_file_delete_handler(data) {

    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj_upload['success']);
        get_passport_copy();
    }
}

$(document).on('click','.itinary_travel_img_delete_img',function () {

    var id = $(this).attr('data_id');

    bootbox.confirm({
        message: "Are you sure, you want to delete this file?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var url = base_url + 'order/ax_delete_itineary_files';
                var order_id = $('#order_id').val();
                send_ajax(url, 'post', {file_id:id,order_id:order_id}, {handler:'delete_itineary_files'});

            }
        }
    });
});

$( window ).resize(function() {

    $(function () {

        var link = $(location).attr('href');
        var link_arr = link.split('/');
        var method1 = 'order_processing';
        var method2 = 'view_order';

        if($.inArray(method1,link_arr) == -1 && $.inArray(method2,link_arr) == -1){

            return false;
        }

        var margin_gorc = 45;

        if($.inArray(method2,link_arr) != -1){

            margin_gorc = 22;

        }

        screen('.order-process-content',margin_gorc);


    });
});


function screen(elem_id,margin_gorc) {

  if($(window).width()< 991){

        return false;
    }

    var height = $(window).height();
    if(height<932){

        $('header').addClass('dis_none');

    }else{
        $('header').removeClass('dis_none');
    }

    if(height < 848){

        var scale = (height/834);
        scale = parseFloat(scale).toFixed(2);
        var margin = (1 - parseFloat(scale).toFixed(2))/0.1*margin_gorc;
        $(elem_id).css( "transform", "scale("+scale+","+scale+")");
        $(elem_id).css( "margin-top", "-"+margin+"px");
        $(elem_id).css( "-moz-transform", "scale("+scale+","+scale+")");
    }


}
$(function () {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method1 = 'order_processing';
    var method2 = 'view_order';

    if($.inArray(method1,link_arr) == -1 && $.inArray(method2,link_arr) == -1){

        return false;
    }

    var margin_gorc = 45;

    if($.inArray(method2,link_arr) != -1){

       margin_gorc = 22;

    }

    screen('.order-process-content',margin_gorc);

});

/*$(function () {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method1 = 'order_processing';

    if($.inArray(method1,link_arr) == -1){

        return false;
    }

    if($.cookie("from_update") === undefined || $.cookie("from_update") == ''){

        return false

    }



    $.cookie("from_update", '', { path: '/' });
});*/

$('#update_modal_show').click(function () {

    $('#updaeding_order_modal').modal('show');

});

function delete_itineary_files(data) {

    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj_upload['success']);
        get_travel();
    }
}

function set_icon(bool, id){

    $('#'+id).removeClass('fa fa-exclamation information-icon');
    $('#'+id).removeClass('fa fa-check verified-icon');

    if(bool){
        $('#'+id).addClass('fa fa-check verified-icon');
    }else{
        $('#'+id).addClass('fa fa-exclamation information-icon');
    }

}

$(document).on('click','#edit_payment_info', function () {

    var url =  base_url+'order/ax_payment_info';
    var data = {order_id: $('#order_id').val(),cards_num:$('#credit_cards').val(),changed:false,edit:true};
    var sucFunc="$('.select-country').selectpicker('refresh'); $('#payment_info_icon').attr('class','fa information-icon');";

    send_ajax(url, 'post', data, {answer:'.payment_info_body_answer', success: sucFunc,show_loader:true});
});

$(document).on('click', '#edit_order_card', function () {

    var data = $(this.form).serializeArray();
    data.push({name:'card_num', value: $(this).attr('data_num')});
    data.push({name:'card_id', value: $(this).attr('data_id')});
    var url =  base_url+'user/ax_check_edit_credit_card';
    send_ajax(url, 'post', data, {answer:'.answer_div', show_loader:true,handler:'edit_order_handler'});
});

function edit_order_handler(data) {

    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {

        get_payment_info(true,true);
        var sender_class = $('#sender_pickup').attr('class');
        var delivery_class = $('#receiver_delivery_icon').attr('class');
        $('#payment_info_icon').attr('class','fa verified-icon');
        if (sender_class == 'fa information-icon') {
            $('.sender_butt').trigger('click');

        }else if (delivery_class == 'fa information-icon') {

            $('.receiver_delivery_butt').trigger('click');

        }else{

            $('.payment_information').trigger('click');
        }

    }

}

$('.link_tracking').click(function () {

    var data = $(this).attr('data_number');

    var send_data={truck_inf:data};
    var url = base_url+'order/ax_get_trucking_history';
    var load_script = '$("#trucking_modal").modal("show");';
    send_ajax(url, 'post', send_data, {answer:'#trucking_modal_content', beforsend:load_script, show_loader:true});

});

$(document).on('change', '.item_list_select', function () {
    if($(this).prop('tagName') == 'SELECT'){
        if($(this).val() == 'new'){
            $(this).parent().html('<input type="text" name="names[]" class="form-control placeholder_class item_input_class" placeholder="Inser Item Name">');
        }
    }
});


$(document).on('click', '.adjust-function', function () {

    var order_id = $('#order_id').val();
    var url = base_url+'order/ax_admin_save_adjust';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'adjust_handler'});
});

function adjust_handler(data) {

    var obj_upload = $.parseJSON(data);
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    $('#show_error_my_profile').removeClass('show_error_my_profilex');
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {
        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj_upload['success']);
        var id = $('#order_id').val();
        setTimeout(function () {
            location.replace(base_url+'admin/order/order_detail/'+id);
        },1500);
    }

}


$(document).on('mousedown touchstart', '#signature', function () {

    $('.signature_info').addClass('dis_none');

});

$(document).on('mousedown touchstart', '.signature_info', function () {

    $('.signature_info').addClass('dis_none');
});

$(document).on('click','#use_address',function () {

    var string = $(this).attr('data-address');
    string = string.split('_|');
    city = string[1];
    if(string.length != 4){

        return false;
    }

    var url = base_url+'order/ax_fill_fields';
    var order_id = $('#order_id').val();
    send_ajax(url, 'post', {state:string[2],order_id:order_id,city:string[1],address:string[0],zip_code:string[3]}, {handler:'ax_fill_fields_handler'});
});


$(document).on('click','.fill_butt_fedex',function(){

    $('#location-'+index_fedex+' #use_address').trigger('click');
});

$(document).on('click','.fill_butt_dhl',function () {
    var url = base_url+'order/ax_fill_fields';
    var order_id = $('#order_id').val();
    send_ajax(url, 'post', {state:state,order_id:order_id,city:city,address:temp_address+' ' + address,zip_code:zip}, {handler:'ax_fill_fields_handler'});
});

function ax_fill_fields_handler(data) {

    var obj_upload = $.parseJSON(data);

    if (obj_upload['errors'].length > 0) {

        return false;
    }
    else {

        $('.drop_off').prop('checked',true);
        $('.sender_pickup_address').val(obj_upload['info']['pickup_address1']);
        $('.sender_postal_code').val(obj_upload['info']['pickup_postal_code']);
        $('.sender_pickup_city').val(obj_upload['info']['pickup_city']);
        $('.sender_pickup_state option').attr("selected", false);
        $('.sender_pickup_state option[value = "'+obj_upload['info']['pickup_state']+'"]').attr("selected", "selected");
        $('.sender_pickup_state').parent().find('button').find('.filter-option.pull-left').html($('.sender_pickup_state option[value = "'+obj_upload['info']['pickup_state']+'"]').html());
        $('.sender_pickup_state').selectpicker('refresh');
        $('#drop_off_map').modal('hide');

    }
}

