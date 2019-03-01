function get_new_order(page,data) {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'dashboard';
    if($.inArray(method,link_arr) == -1){

        return false;
    }

    if(data != ""){

        data.push({name:'page', value:page});

    }else{

        data = $('#new_order_form').serializeArray();
        data.push({name:'page', value:page});
    }

    var url = base_url + 'dashboard/ax_new_order/'+ (page - 1) * new_order_count;
    send_ajax(url, 'post', data, {answer:'#admin_new_order'});

}

get_new_order(1,"");

$(document).on('click','.new_order_pagination',function () {

    var page = $(this).attr('data-ci-pagination-page');
    get_new_order(page,"");

});

$(document).on('click', '.search_new_order', function () {

    var data = $(this.form).serializeArray();
    get_new_order(1,data);
});

function get_processid_order(page,data) {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'dashboard';
    if($.inArray(method,link_arr) == -1){

        return false;
    }

    if(data != ""){

        data.push({name:'page', value:page});

    }else{

        data = $('#processid_order_form').serializeArray();
        data.push({name:'page', value:page});
    }

    var url = base_url + 'dashboard/ax_processing_order/'+ (page - 1) * processing_order;;
    send_ajax(url, 'post', data, {answer:'#admin_processing_order'});

}

get_processid_order(1,"");

$(document).on('click','.processid_order_pagination',function () {

    var page = $(this).attr('data-ci-pagination-page');

    get_processid_order(page,"");

});

$(document).on('click', '.processid_order_search', function () {

    var data = $(this.form).serializeArray();
    get_processid_order(1,data);
});

function get_ready_order(page,data) {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'dashboard';
    if($.inArray(method,link_arr) == -1){

        return false;
    }

    if(data != ""){

        data.push({name:'page', value:page});

    }else{

        data = $('#processid_order_form').serializeArray();
        data.push({name:'page', value:page});
    }
    var url = base_url + 'dashboard/ax_ready_order/'+ (page - 1) * ready_order;
    send_ajax(url, 'post', data, {answer:'#admin_ready_order'});

}

get_ready_order(1,"");

$(document).on('click','.ready_order_pagination',function () {

    var page = $(this).attr('data-ci-pagination-page');

    get_ready_order(page,"");

});

$(document).on('click', '.ready_order_search', function () {

    var data = $(this.form).serializeArray();
    get_ready_order(1,data);
});

$(document).on('click','.sender_label',function () {

    var url = base_url + 'order/ax_delete_label_file';
    var order_id = $('#order_id').val();
    var luggage_id = $(this).attr('data_id');

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

                send_ajax(url, 'post', {order_id:order_id,luggage_id:luggage_id}, {handler:'delete_file_handler_truck'});

            }
        }
    });


});

function delete_file_handler_truck(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(obj['error']);
    }
    else {

        location.reload();

    }
}

$('.edit_delivery_butt').click(function () {

    var url = base_url + 'order/ax_edit_delivery_info';
    var order_id = $('#order_id').val();
    send_ajax(url, 'post', {order_id:order_id}, {answer:'.delivery_info'});

});

$(document).on('click','.admin_save_delivery_info', function () {

    var url = base_url + 'order/ax_update_receiver_info';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data = $('#delivery_form').serializeArray();
    data.push({name:'order_id',value:order_id});
    data.push({name:'user_id',value:user_id});
    send_ajax(url, 'post', data, {handler:'edit_delivery_handler'});
});


function edit_delivery_handler(data) {

    $("#show_error_my_profile").html('');
    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');

    var obj = $.parseJSON(data);

    if (obj["errors"].length > 0) {

        $('#show_upload_error_img').addClass('error_img');
        $("#show_error_my_profile").html(obj['error']);
    }
    else {

        location.reload();

    }
}

$('.edit_sender_pickup_info').click(function () {

    var url = base_url + 'order/ax_edit_sender_info';
    var order_id = $('#order_id').val();
    send_ajax(url, 'post', {order_id:order_id}, {answer:'.admin_sender_info_answer'});

});

$(document).on('click','.sender_pickup_edit', function () {

    var url = base_url + 'order/ax_update_sender_info';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data = $('#admin_sender_info_form').serializeArray();
    data.push({name:'order_id',value:order_id});
    data.push({name:'user_id',value:user_id});
    var sucFunc="$('.select-country').selectpicker('refresh')";
    send_ajax(url, 'post', data, {handler:'edit_delivery_handler',success: sucFunc});
});

function get_custom_document(editable) {

    var url = base_url + 'order/ax_custom_document';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var sucScript  = '$(".select-country").selectpicker("refresh");$("#arrival_date").datepicker({startDate: "dateToday",format:"yyyy-mm-dd"});$("#departure_date").datepicker({startDate: "dateToday",format:"yyyy-mm-dd"}),get_custom_icon()';
    send_ajax(url, 'post', {order_id:order_id,user_id:user_id,editable:editable}, {answer:'.admin_custom_document',abort:true,success:sucScript});

}

function get_billing_payment(before_send) {

    var url = base_url + 'order/ax_billing_payment';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var sucScript  = '$(".select-country").selectpicker("refresh");';
    var beforeScript = '';
    if(typeof before_send !== 'undefined'){
        beforeScript = before_send;
    }
    send_ajax(url, 'post', {order_id:order_id,user_id:user_id}, {answer:'.admin_billing_payment',abort:true, success:sucScript, beforsend:beforeScript});
}

$(document).on('click','.billing_payment_info', function () {

    get_billing_payment();
});

$(document).on('click','.clear_signature_db',function () {

    get_custom_document(true);

});


$(document).on('click', '.clear-signature', function() {
    $("#signature").jSignature("reset");
});


$(function() {

    var link = $(location).attr('href');
    var link_arr = link.split('/');
    var method = 'order_detail';

    if($.inArray(method,link_arr) == -1){

        return false;
    }

    $(document).on('click', '.clear-signature', function() {
        $("#signature").jSignature("reset");
    });

    var fieldHTML = '';
    var x =parseInt(item_count);
    var options = '';

   $.each(item_name, function (index, value) {

        options = options +  '<option value="'+value['title']+'">'+value['title']+'</option>';

    });

    $(document).on('click', '.add-more-item', function(e) {

        x =parseInt($('.lists-block-add-item .total-quantity').html());
        e.preventDefault();

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
        $('.lists-block-add-item .total-quantity').html(x);
        $('.selectpicker').selectpicker();
    });

});

$(document).on('keyup','.count_item',function () {

    var count = $(this).attr('data_count');
    count_up(count);
});

$(document).on('keyup','.unit_value',function () {

    var count = $(this).attr('data_count');
    count_up(count);
});

function total_price() {

    var all_sum = $('.sum_all_row');

    var total_price = 0;
    for(var i=0; i<all_sum.length; i++)
    {
        var all_val = $(all_sum[i]).html();

        var all_val =parseFloat(all_val.substr(1, all_val.length));

        total_price += all_val;
    }

    $('.total-price').html('$ ' + total_price.toFixed(2));
    $('.custom_doc_price').html(total_price.toFixed(2));

}

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



$(document).on('click', '.remove-more-item', function(e){

    var count_item = parseInt($('.lists-block-add-item .total-quantity').html());
    e.preventDefault();
    $(this).parents('div.new-adding-place').remove();
    count_item--;

    $('.lists-block-add-item .total-quantity').html(count_item);
    total_price();
});

$('.custom_documents').click(function () {

    get_custom_document('');
});

$(document).on('click', '.edit_all_item_list', function () {

    var data  = $(this.form).serializeArray();
    save_item_list(data,true);

});

function save_item_list(data,edit) {

    $('#show_upload_error_img').removeClass('error_img');
    $('#show_error_my_profile').removeClass('success_class');
    var error = '';
    data.push({name: 'order_id', value: $('#order_id').val()});
    var datapair = $("#signature").jSignature("getData", "svgbase64");

    if (error != '') {

        $('#upload_modal').modal('show');
        $("#show_error_my_profile").addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(error);
        return false;
    }

    if (edit) {

        data.push({name: 'editable', value: true});
    }

    var user_id = $('#user_id').val();
    data.push({name: 'user_id', value:user_id});
    var url = base_url + 'order/ax_save_order_item_list';
    send_ajax(url, 'post', data, {handler: 'save_item_list_handler'});
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

        get_custom_document('');

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

$(document).on('click','.order_type',function () {

    if($(this).val() == '2'){

        $('.custom_dis_none').addClass('dis_none');

    }

    if($(this).val() == '1'){

        $('.custom_dis_none').removeClass('dis_none');
    }

    $(this).prop('checked',true);

});

$(document).on('click','.admin_order_delete_img',function () {

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

                var user_id = $('#user_id').val();
                var url = base_url+'order/ax_delete_order_form_file';
                var order_id = $('#order_id').val();
                send_ajax(url, 'post', {file_id:file_id,order_id:order_id,user_id:user_id}, {handler:'delete_file_handler'});
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

        get_custom_document('');
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

                if(handler == 'passport'){

                    $('#upload_modal').modal('show');
                    $('#show_error_my_profile').addClass('success_class');
                    $('#show_error_my_profile').html(obj_upload['success']);
                    $('.pasport_copy > span> i').attr('class','fa fa-check verified-icon');
                    get_custom_document('');

                }else if(handler == 'travel'){

                    $('.travel_itinary > span> i').attr('class','fa fa-check verified-icon');
                    $('#upload_modal').modal('show');
                    $('#show_error_my_profile').addClass('success_class');
                    $('#show_error_my_profile').html(obj_upload['success']);
                    get_custom_document('');

                }else if(handler == 'location'){

                    location.reload();
                }

            }
        }
    });
}

$(document).on('change','#upload_file_item_list',function () {

    var input = $('#upload_file_item_list');
    var url = base_url + 'order/ax_upload_order_form_file';
    var user_id = $('#user_id').val();
    var file_data = new FormData;

    if(!$.isArray(input)){

        file_data.append('doc', input.prop('files')[0]);

    }else{

        for(var i = 0; i<input.length;i++){

            file_data.append(input[i][0]['name'], input[i].prop('files')[0]);
        }
    }

    file_data.append('order_id',   $('#order_id').val());
    file_data.append('country_id', $('#passport_issue_country').val());
    file_data.append('pas_number', $('.passport_copy').val());
    file_data.append('user_id', user_id);
    ax_upload_file_ajax_for_passport(file_data,url,'admin_save_passport');
});

$(document).on('click','.admin_save_passport',function () {


    var input = [$('#passport_copy'),$('#visa_copy')];
    var url = base_url + 'order/ax_save_order_passport_info';
    var user_id = $('#user_id').val();
    var file_data = new FormData;

    if(!$.isArray(input)){

        file_data.append('doc', input.prop('files')[0]);

    }else{

        for(var i = 0; i<input.length;i++){

            file_data.append(input[i][0]['name'], input[i].prop('files')[0]);
        }
    }

    file_data.append('order_id',   $('#order_id').val());
    file_data.append('country_id', $('#passport_issue_country').val());
    file_data.append('pas_number', $('.passport_copy').val());
    file_data.append('user_id', user_id);
    ax_upload_file_ajax_for_passport(file_data,url,'passport');
});

$(document).on('click','.admin_delete_visa_copy',function () {


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

$(document).on('click','.admin_delete_passport',function () {


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

function delete_passport_img(file_name,type_name) {

    var url = base_url + 'order/ax_delete_passport_file';
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    send_ajax(url, 'post', {file_name:file_name,order_id:order_id,type_name:type_name,user_id:user_id}, {handler:'pasport_file_delete_handler'});
}

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
        get_custom_document('');
    }
}

$(document).on('click','.admin_save_travel',function () {

    var url = base_url + 'order/ax_save_travel_itinerary';
    var input = $('#travel_file');
    var file_data = new FormData;
    var user_id = $('#user_id').val();
    var ser_arr = $(this.form).serializeArray();
    $.each(ser_arr, function(index, value) {

        file_data.append(value['name'],value['value']);
    });

    file_data.append('doc', input.prop('files')[0]);
    file_data.append('order_id',$('#order_id').val());
    file_data.append('user_id',user_id);
    ax_upload_file_ajax_for_passport(file_data,url,'travel');

});

$(document).on('click','.admin_itinary_travel_img_delete_img',function () {

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
                var user_id = $('#user_id').val();
                var order_id = $('#order_id').val();
                var url = base_url + 'order/ax_delete_itineary_files';
                send_ajax(url, 'post', {file_id:id,order_id:order_id,user_id:user_id}, {handler:'delete_itineary_files'});

            }
        }
    });
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
        get_custom_document('');
    }
}

function get_custom_icon() {

    var item_class = $('#icon_h3').attr('class');
    var passport_class = $('#paspport_h3').attr('class');
    var travel_class = $('#travel_h3').attr('class');
    if(item_class == 'fa fa-check delivered-icon' && item_class == passport_class && item_class == travel_class){

        $('#custom_document').attr('class','fa fa-check delivered-icon');

    }else{

        $('#custom_document').attr('class','fa fa-exclamation created-icon');
    }
}

function account_order_message(message) {

    var order_id = $('#order_id').val();
    var url = base_url + 'order/ax_account_order_message';
    send_ajax(url, 'post', {order_id:order_id,message:message}, {handler:'account_order_message_handler'});
}

function account_order_message_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {

    }
    else {

        $('#account_message').val('');
        $('#order_message_val').val('');
        if(obj['type'] == 1){

            get_account_order_message('#account_answer',obj['type'][0]);

        }else{

            get_account_order_message('#order_answer',obj['type'][0]);
        }
    }
}

function get_account_order_message(answer) {

    var order_id = $('#order_id').val();
    var url = base_url + 'order/ax_get_account_order_message';
    send_ajax(url, 'post', {order_id:order_id}, {answer:answer});
}


$('.save_order_message').click(function () {

    var message = $('#order_message_val').val();
    account_order_message(message);
});

$(document).on('change','#admin_card_name_select', function () {

    var order_id = $('#order_id').val();
    var card_id = $('#admin_card_name_select').val();
    var user_id = $('#user_id').val();
    if(card_id == ''){

        return false;
    }
    var url = base_url + 'order/set_credit_card';
    send_ajax(url, 'post', {order_id:order_id,user_id:user_id,card_id:card_id}, {/*answer:'#credit_card_info'*/ handler:'set_credit_card_handler'});
});


function set_credit_card_handler(data) {

    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj['errors']);
    }
    else {
        var order_id = $('#order_id').val();
        var card_id = $('#admin_card_name_select').val();
        var user_id = $('#user_id').val();
        var url = base_url + 'order/ax_get_credit_card';
        send_ajax(url, 'post', {order_id:order_id,user_id:user_id,card_id:card_id}, {answer:'#credit_card_info'});
        $('#billing_icon').attr('class','fa fa-check delivered-icon');
        $('#biling_card_icon').attr('class','fa fa-check delivered-icon');
    }
}

$( document ).ready(function() {

    $('.update_order_status').click(function () {

        var order_id = $('#order_id').val();
        var user_id = $('#user_id').val();
        var data = $(this.form).serializeArray();
        data.push({name: 'order_id', value: order_id});
        data.push({name: 'user_id', value: user_id});
        var order_status = 0;

        $.each(data, function (index, value) {
            if (value["name"] == 'order_status') {
                order_status = value["value"]
            }
        });

        if (order_status == submited_status) {
            bootbox.confirm({
                message: "<p> Are you sure to change the order status to submitted? </p>" + "<br>" + "<span class='error_class'> Please only change when customer would like to update service and order total need to be updated</span>",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn btn-default btn-login-orange'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn btn-default  btn-login-blue'
                    }
                },
                callback: function (result) {

                    if (result == true) {

                        var url = base_url + 'order/ax_update_order_status';
                        send_ajax(url, 'post', data, {handler: 'update_status_handler'});

                    }
                }
            });

        } else {
            var url = base_url + 'order/ax_update_order_status';
            send_ajax(url, 'post', data, {handler: 'update_status_handler'});
        }


    });

});

$('.update_claim').click(function () {

    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data = $(this.form).serializeArray();
    data.push({name:'order_id',value:order_id});
    data.push({name:'user_id',value:user_id});
    var url = base_url + 'order/ax_update_claim';
    send_ajax(url, 'post', data, {handler:'update_claim_handler'});
});

function update_status_handler(data) {

    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);

    }else{
        location.reload();
    }
}

function update_claim_handler(data) {

    var obj = $.parseJSON(data);
    if (obj['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').html(obj['errors']);

    }else{
        location.reload();
    }


}

$('#change_currier').change(function () {

    var currier_id = $('#change_currier').val();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var url = base_url + 'order/ax_change_carrier';
    var sucFunc="$('.document_type').find('*').selectpicker('refresh')";
    if(currier_id == ''){

      return false;
    }

    send_ajax(url, 'post', {carrier_id:currier_id,order_id:order_id,user_id:user_id}, {answer:'.document_type',success:sucFunc});
});

$('#change_label_currier').change(function () {

    var currier_id = $('#change_label_currier').val();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var url = base_url + 'order/ax_change_carrier';
    var sucFunc="$('#label_document_type').find('*').selectpicker('refresh')";
    if(currier_id == ''){

        return false;
    }

    send_ajax(url, 'post', {carrier_id:currier_id,order_id:order_id,user_id:user_id,label:true}, {answer:'#label_document_type',success:sucFunc});
});

$('#save_track_label').click(function () {

    var error = '';

    var currier_id = $('#change_currier').val();
    var order_id = $('#order_id').val();
    var document_type = $('#document_type').val();
    var user_id = $('#user_id').val();
    var sat_delivery = '';
    if($('#sat_delivery').is(":checked")){
        sat_delivery = true;
    }
    var data = $('#tracking_label_form').serializeArray();

    var send_data = {};
    var inf = [];

    $.each(data, function(index, value) {
        inf = value['name'].split('_');
        send_data[inf[1]] = value['value'];
    });

    if(document_type == ''){

        error = 'Please select document type';
    }

    if(currier_id == '' && error == ''){

        error = 'Please select Carrier';
    }

   if(error != ''){

       $('#upload_modal').modal('show');
       $('#show_upload_error_img').addClass('error_img');
       $('#show_error_my_profile').addClass('error_class');
       $('#show_error_my_profile').html(error);
       return false;

   }

    var url = base_url + 'order/ax_save_tracking_info';
    var file_data = {
        'carrier_id': currier_id,
        'order_id': order_id,
        'sending_type': document_type,
        'numbers': JSON.stringify(send_data),
        'user_id': user_id,
        'sat_delivery': sat_delivery
    };


    send_ajax(url, 'post', file_data, {handler:'create_shipment_handler'});
});

$('#save_track_temp').click(function () {

    var error = '';

    var currier_id = $('#change_currier').val();
    var order_id = $('#order_id').val();
    var document_type = $('#document_type').val();
    var user_id = $('#user_id').val();
    var sat_delivery = '';
    if($('#sat_delivery').is(":checked")){
        sat_delivery = true;
    }
    var data = $('#tracking_label_form').serializeArray();

    var send_data = {};
    var inf = [];

    $.each(data, function(index, value) {
        inf = value['name'].split('_');
        send_data[inf[1]] = value['value'];
    });

    if(document_type == ''){

        error = 'Please select document type';
    }

    if(currier_id == '' && error == ''){

        error = 'Please select Carrier';
    }

    if(error != ''){

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(error);
        return false;

    }

    var url = base_url + 'order/ax_save_temp_tracking_info';
    var file_data = {
        'carrier_id': currier_id,
        'order_id': order_id,
        'sending_type': document_type,
        'numbers': JSON.stringify(send_data),
        'user_id': user_id,
        'sat_delivery': sat_delivery
    };


    send_ajax(url, 'post', file_data, {handler:'create_shipment_handler'});
});

$(document).on('click','#create_label',function () {

    $('#address_validation_modal').modal('hide');

    bootbox.confirm({
        message: "<p> Are you sure to create new label(s)? </p>" + "<br>" + "<span class='error_class'> After the transaction, the former labels will be deleted</span>",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            },
            cancel: {
                label: 'No',
                className: 'btn btn-default  btn-login-blue'
            }

        },
        className: "create_label_bootbox",
        callback: function (result) {

            if (result == true) {

                var order_id = $('#order_id').val();
                var user_id = $('#user_id').val();
                var beforsend = '$("#create_shipment_div").removeClass("dis_none")';
                var comlete = '$("#create_shipment_div").addClass("dis_none")';
                var url = base_url + 'order/ax_admin_create_shipment';
                send_ajax(url, 'post', {order_id:order_id,user_id:user_id}, {handler:'create_shipment_handler', beforsend:beforsend,complete:comlete});

            }
        }
    });
});

function create_shipment_handler(data) {

    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {

       location.reload();
    }
}

$('#upload_label').change(function () {

    var input = $('#upload_label');
    var document_type = $('#type_id').val();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var luggage_id = $('#luggages').val();
    var file_data = new FormData;
    file_data.append('doc', input.prop('files')[0]);
    file_data.append('order_id', order_id);
    file_data.append('doc_type', document_type);
    file_data.append('user_id', user_id);
    file_data.append('luggage_id', luggage_id);
    var url = base_url + 'order/ax_upload_order_files';
   ax_upload_file_ajax_for_passport(file_data,url,'location');
});


function get_delivery_label_view() {

    var user_id = $('#user_id').val();
    var send_data = {order_id:$('#order_id').val(),user_id:user_id};
    var url = base_url+'order/ax_delivery_label_view';
    send_ajax(url,'post',send_data,{answer:'#edit_delivery_label_answer',show_loader:true});
}

$(document).on('click', '.label_delivery', function () {

    var send_data = {order_id:$('#order_id').val(),country_id:$('#country_id').val(),user_id:$('#user_id').val()};
    var url = base_url+'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";

    $.ajax({
        url: url,
        type: 'post',
        data: send_data,
        success: function (data) {

            obj_upload = {errors:[]}

            if(data.indexOf('{"errors"') >= 0) {

                var obj_upload = $.parseJSON(data);
            }

            if (obj_upload['errors'].length > 0) {

                $('#upload_modal').modal('show');
                $('#show_upload_error_img').addClass('error_img');
                $('#show_error_my_profile').addClass('error_class');
                $('#show_error_my_profile').html(obj_upload['errors']);

            }
            else {

                $('#delivery_label').html(data);
                $('#delivery_label_modal').modal('show');

                $('.select-country').selectpicker('refresh');
            }

        }
    });

    //send_ajax(url,'post',send_data,{answer:'#delivery_label',success:sucFunc, handler:'new_address_handler'});
});

/*function new_address_handler(data) {

    var obj_upload = $.parseJSON(data);

    if (obj_upload['errors'].length > 0) {

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj_upload['errors']);

    }
    else {

        $('#delivery_label_modal').modal('show');
    }

}*/

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
        send_data.push({name:'user_id', value:$('#user_id').val()});
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


$('.pick_up_date').on('changeDate', function(ev){
    $(this).datepicker('hide');
});
$('.pick_up_date').datepicker({
    startDate: "dateToday",
    format:'yyyy-mm-dd'
});

$('.save_shedule').click(function () {

    var data = $('#shedule_form').serializeArray();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();

    data.push({name:'order_id', value:order_id});
    data.push({name:'user_id', value:user_id});
    var url = base_url+'order/ax_save_shedule_pick_up';
    send_ajax(url,'post',data,{handler:'shedule_shipment_handler'});
});

$('.shipment_summary_save').click(function () {

    var data = $('#delivery_address_form').serializeArray();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();

    data.push({name:'order_id', value:order_id});
    data.push({name:'user_id', value:user_id});
    var url = base_url+'order/ax_save_label_shipment';
    send_ajax(url,'post',data,{handler:'shedule_shipment_handler'});

});

$('.shipment_summary_temp').click(function () {

    var data = $('#delivery_address_form').serializeArray();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();

    data.push({name:'order_id', value:order_id});
    data.push({name:'user_id', value:user_id});
    var url = base_url+'order/ax_save_label_shipment_temp';
    send_ajax(url,'post',data,{handler:'shedule_shipment_handler'});

});

$('.shedule_temp').click(function () {

    var data = $('#shedule_form').serializeArray();
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();

    data.push({name:'order_id', value:order_id});
    data.push({name:'user_id', value:user_id});
    var url = base_url+'order/ax_save_pick_up_temp';
    send_ajax(url,'post',data,{handler:'shedule_shipment_handler'});

});


function shedule_shipment_handler(data) {

    var obj_upload = $.parseJSON(data);
    $('#show_error_my_profile').removeClass('success_class');
    $('#show_upload_error_img').removeClass('error_img');
    if (obj_upload['errors'].length > 0) {
        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(obj_upload['errors'][0]);

    }
    else {

        $('#upload_modal').modal('show');
        $('#show_error_my_profile').addClass('success_class');
        $('#show_error_my_profile').html(obj_upload['success']);
        location.reload();
    }
}

$(document).on('click','.link_tracking', function () {

    var url = base_url+'order/ax_get_trucking_history';
    link_tracking(url,true,'',$(this))
});

$(document).on('click','.label_trucking', function () {

    var url = base_url+'order/ax_get_label_trucking';
    var order_id = $(this).attr('data_order');
    link_tracking(url,false,order_id,$(this));
});

function link_tracking(url,trucking,order_id,inp) {


    if(trucking){

        var data = inp.attr('data_number');
        var user_id = inp.attr('user_id');
        var send_data={truck_inf:data,user_id:user_id};

    }else{

        var send_data={order_id:order_id};
    }

    var load_script = '$("#trucking_modal").modal("show");';
    send_ajax(url, 'post', send_data, {answer:'#trucking_modal_content', beforsend:load_script, show_loader:true});

}


$(".promotion").datepicker({format:"yyyy-mm-dd"});

$(document).on('changeDate', '.promotion', function (ev) {
    $(this).datepicker('hide');
});


$('.prom_order_span').click(function(){

    var order_by = $(this).attr('data-order-by');
    var order_type = $(this).attr('data-order-type');
    $('#order_by_input').val(order_by);
    $('#order_type_input').val(order_type);
    $('#search_promotion_form').submit();

});

$('.status_filter').click(function(){

    var status = $(this).attr('data-status');
    $('#user_status').val(status);
    $('#costumer_list_form').submit();

});

$('.customer_order_span').click(function(){

    var order_by = $(this).attr('data-order-by');
    var order_type = $(this).attr('data-order-type');
    $('#user_list_order_by').val(order_by);
    $('#user_list_order_type').val(order_type);
    $('#costumer_list_form').submit();

});

$(document).on('click', '#add_promotion_butt', function () {
    var ser_arr = $('#add_promotion_form').serializeArray();
    var url = base_url+'promotion/ax_add_edit_promotion_code';
    send_ajax(url, 'post', ser_arr, {handler:'add_promotion_handler'});
});

function add_promotion_handler(data) {
    var obj = $.parseJSON(data);
    $("#register_error").html('');
    $('#add_error_img').removeClass('error_img');
    if(obj['errors'].length>0){
        $("#register_error").addClass('error_class');
        $('#add_error_img').addClass('error_img');
        $("#register_error").html(obj['errors'][0]);
    }else{

        location.replace(base_url + 'promotion/promotion');
    }
}

$('.add_promotion_butt').click(function () {
    $('#add_promotion').modal('show');
    var url = base_url + 'promotion/ax_promotion_modal';
    var id = $(this).attr('data_id');
    var sucFunc = '$(".select-country").selectpicker("refresh"); $(".promotion").datepicker({format:"yyyy-mm-dd"}); $(".promotion").datepicker("refresh");';
    send_ajax(url, 'post', {id:id}, {answer:'.promotion_answer', success:sucFunc});
});

$('.creat-summery-label').click(function () {

    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var url = base_url + 'order/create_label_shipment';
    send_ajax(url, 'post', {order_id:order_id, user_id:user_id}, {handler:'create_shipment_handler', answer:'#label_shipment_but_cont', loader:'.mini-loader'});

});


$(document).on('change', '.item_list_select', function () {
    if($(this).prop('tagName') == 'SELECT'){
        if($(this).val() == 'new'){
            $(this).parent().html('<input type="text" name="names[]" class="form-control placeholder_class item_input_class" placeholder="Inser Item Name">');
        }
    }
});

$('.remote_area_radio').change(function () {

    var remote_val = 0;
    var country_id = $('#delivery_country_id').val();
    var order_id =   $('#order_id').val();

    if($('#yes').prop('checked')){
        remote_val = 2;

    }else if($('#no').prop('checked')){
        remote_val = 1;
    }

    if(remote_val != 1 && remote_val != 2){

        return false;
    }

    var url = base_url + 'order/ax_calc_remote_area_fee';
    send_ajax(url, 'post', {order_id:order_id, country_id:country_id, remote_val: remote_val}, {handler:'remote_area_handler'});

});

function remote_area_handler(data) {

    var data = $.parseJSON(data);
    if(data['errors'].length>0){

        $('#upload_modal').modal('show');
        $('#show_upload_error_img').addClass('error_img');
        $('#show_error_my_profile').addClass('error_class');
        $('#show_error_my_profile').html(data['errors']);

    }else{

        var remote_area_fee = 0;

        if(data['remote_area_fee'] == 'No remote area fee'){
            remote_area_fee = 'No remote area fee';

        }else{

            remote_area_fee = 'Remote area fee $'+data['remote_area_fee'];
        }

        $('#remote_area_fee_answer').html(remote_area_fee);
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
        marker.addListener('click', function() {
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'click', function() {

            marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function(){ marker.setAnimation(null); }, 5000);

            var index = marker.index;

            $('#info').animate({scrollTop: $('#location-'+index).offset().top - ($('#info').offset().top - $('#info').scrollTop())}, 'slow');

            $('#location-'+index).siblings().removeClass('listItemSelect');

            $('#location-'+index).addClass('listItemSelect');

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

$('.submit-all-btn').click(function(){

    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();

    var data1 = $('#shedule_form').serializeArray();

    data1.push({name:'order_id', value:order_id});
    data1.push({name:'user_id', value:user_id});

    var data2 = $('#delivery_address_form').serializeArray();

    var currier_id = $('#change_currier').val();
    var document_type = $('#document_type').val();
    var sat_delivery = '';

    if($('#sat_delivery').is(":checked")){
        sat_delivery = true;
    }

    var data = $('#tracking_label_form').serializeArray();

    var data3 = {};
    var inf = [];

    $.each(data, function(index, value) {
        inf = value['name'].split('_');
        data3[inf[1]] = value['value'];
    });

    var file_data = [
        {name: "carrier_id", value: currier_id},
        {name: "sending_type", value: document_type},
        {name: "numbers", value: JSON.stringify(data3)},
        {name: "sat_delivery", value: sat_delivery}
    ];

    var all_data = [];

    all_data = all_data.concat(data1, data2, file_data);

    var url = base_url + 'order/ax_submit_all';

    send_ajax(url, 'post', all_data, {async:'false',handler:'submit_all_handler'});

});

function submit_all_handler(data) {

    var obj = $.parseJSON(data);
    $('#answer_upload_all').html('');

    if (obj['errors'].hasOwnProperty('tracking_numbers_&_labels') || obj['errors'].hasOwnProperty('shedule_pick_up') || obj['errors'].hasOwnProperty('label_shipment_&_summary')) {

        $('#submit_all_modal').modal('show');

        $.each(obj['errors'], function(index_1, value_1) {


          var title = index_1.replace(/_/gi,' ');

            $('#answer_upload_all').append('<h4 class="lovercase">'+title+'</h4>');

            $.each(value_1, function(index_2, value_2) {

                $('#answer_upload_all').append('<div><span class="error_img"></span><span class="error_class">'+value_2+'</span></div>');
            });

        });

    }else {
        location.reload();
    }
}

$(document).on('change','#delivery_label_address', function () {

    if($('#delivery_label_address').val() == ' '){

        return false;
    }


    var url = base_url + 'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var info = $(this.form).serializeArray();
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'user_id',value:$('#user_id').val()});
    info.push({name:'add_id',value:$('#delivery_label_address').val()});
    info.push({name:'country_id',value:$('#country_id').val()});
    info.push({name:'adress_changed',value:true});
    info.push({name:'trav_id',value:$('#delivery_label_list').val()});
    send_ajax(url, 'post', info, {answer:'#delivery_label',success:sucFunc});

});

$(document).on('change','#delivery_label_list', function () {

    if($('#delivery_label_list').val() == ' '){

        return false;
    }

    var url = base_url + 'order/ax_delivery_label';
    var sucFunc="$('.select-country').selectpicker('refresh')";
    var info = $(this.form).serializeArray();
    info.push({name:'order_id',value:$('#order_id').val()});
    info.push({name:'user_id',value:$('#user_id').val()});
    info.push({name:'trav_id',value:$('#delivery_label_list').val()});
    info.push({name:'country_id',value:$('#country_id').val()});
    info.push({name:'trav_changed',value:true});
    info.push({name:'add_id',value:$('#delivery_label_address').val()});
    send_ajax(url, 'post', info, {answer:'#delivery_label',success:sucFunc});

});


$(document).on('click','.final_billing_info', function () {
    var order_id = $(this).attr('data_order');
    var luggage_id = $(this).attr('data_luggage');
    var data_number = $(this).attr('data_number');
    var url = base_url + 'order/ax_add_luggage_fee';
    var sucFunc="$('.final_billing_modal').modal('show')";
    send_ajax(url, 'post', {order_id:order_id,luggage_id:luggage_id,data_number:data_number}, {answer:'#final_billing_answer',success:sucFunc});
});



$(document).on('click', '#submit_billing_form', function () {

    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data = $('#billing_info_form').serializeArray();
    var type = $('#submit_billing_form').attr('data-type');

    data.push({name:'order_id', value:order_id});
    data.push({name:'type', value:type});
    data.push({name:'user_id', value:user_id});
    var url = base_url+'order/ax_submit_billing_info';
    send_ajax(url, 'post', data, {handler:'submit_billing_info_handler'});
});

function submit_billing_info_handler(data) {

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

$(document).on('click','#billing_info_form .form-control', function () {

    if($(this).parents('ul').hasClass('final_input')){

        return false;
    }

    var order_status = $('#order_status').val();

    billing_autocomplete($(this),order_status);
});


function billing_autocomplete(input,order_status) {

    if(order_status == 9 || order_status == 10){

        return false;
    }

    var billing_auto_complete_array = $.parseJSON($("#billing_auto_complete_array").val());

    var data_type = $(input).attr('data-type');

    if(billing_auto_complete_array == null || billing_auto_complete_array == undefined){
        return false;
    }

    if($('[name = "'+data_type+'_shipping_fee"]').val() != 0){
        return false;
    }

    $.each(billing_auto_complete_array, function( index, value ) {


        if(index == 'id' || index == 'order_id' || index == 'type' || index == 'update_date' || index == 'user_id'){
            return;
        }

       // $('[name = '+index+']').val(value);

        if(index == 'promotion_code'){
            var type = billing_auto_complete_array['promotion_type'];
            if(type == '2'){
                value = '$ '+value;
            }else{
                value = value+' %';
            }
        }

        $(input).parents('ul').find('[name = '+data_type+'_'+index+']').val(value);
    });

    billing_editable(input);
}

$(document).on('click','.final_input input', function () {

    $('#submit_billing_form').attr('data-type','final');
    $('#submit_billing_form').html('Submit Final C & R');
    var order_status = $('#order_status').val();

    billing_autocomplete($(this),order_status);
});

$(document).on('click','.adjust_remove_input input', function () {

    var data_type = $(this).attr('data-type');

    var title = data_type.replace('_', ' #');

    $('#submit_billing_form').attr('data-type',data_type);
    $('#submit_billing_form').html('Submit ' + title);

});


function billing_editable(input) {

    var arr = $(input).parents('ul').find('input');

    var sum = 0;
    var promo = false;
    var promo_input;

    $.each(arr, function( index, value ) {

        var inp_val = $(value).val();

        if(index == 9 || index == 7){
            return true;
        }

        inp_val = inp_val.replace('$', '');
        inp_val = inp_val.replace('%', '');

        if( inp_val == ''){

            inp_val = 0;
        }else{

            inp_val = parseFloat(inp_val);
        }

        if(index == 8){

            var promo_type = $(arr[9]).val();

            if(promo_type == '1'){


                promo = true;
                promo_input = $(arr[7]);

            }else{

                sum -= inp_val;
            }

            return true;
        }

        if(index == 10 || index == 11){

            sum -= inp_val

        }else{

            sum += inp_val;
        }

    });

    if(promo){

        var promo_amount = parseFloat(sum*parseFloat($(arr[8]).val())/100);
        sum = sum - promo_amount;
        promo_input.val(promo_amount);
    }

    sum = sum.toString();

    var explode_sum = sum.split('.');

    if(explode_sum[1] == '' || explode_sum[1] == undefined){

        sum = parseInt(sum);

    }else{

        sum = parseFloat(sum).toFixed(2);
    }

    $(input).parents('ul').find('li p').html('$' + sum)
}



$(document).on('change','#billing_info_form .form-control', function () {
    billing_editable($(this));
});

function get_billing_final_notes() {
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var data = {user_id:user_id,order_id:order_id};
    var url = base_url+'order/ax_get_finicial_notes';
    send_ajax(url, 'post', data, {answer:'#finicial_notes_answer'});

}

function account_finicial_message(message) {

    var order_id = $('#order_id').val();
    var url = base_url + 'order/ax_add_finicial_notes';
    send_ajax(url, 'post', {order_id:order_id,message:message}, {handler:'account_finicial_message_handler'});
}

function account_finicial_message_handler(data) {

    var obj = $.parseJSON(data);

    if (obj['errors'].length > 0) {

    }
    else {
        get_billing_final_notes();
        $('#billing_final_notes').val('');
    }
}

$(document).on('click', '#billing_finicial_button', function () {

   var message = $('#billing_final_notes').val();
    account_finicial_message(message);
});

function final_billing_val() {

    var arr = $('.final_billing_inp');
    var sum = 0;
    $.each(arr, function( index, value ) {

        var inp_val = $(value).val();

        if( inp_val == '' || !$.isNumeric(inp_val)){

            inp_val = 0;
        }

        inp_val = parseFloat(inp_val);
        sum += inp_val;

    });

    sum = sum.toString();

    var explode_sum = sum.split('.');

    if(explode_sum[1] == '' || explode_sum[1] == undefined){

        sum = parseInt(sum);

    }else{

        sum = parseFloat(sum).toFixed(2);
    }

    $('#total_biiling_answer').html('$' + sum);
}

$(document).on('change','.final_billing_inp', function () {
    final_billing_val();
});

$(document).on('click','.single_billing_info_save', function () {
    var url = base_url + 'order/ax_save_luggage_fee';
    var data = $('#single_final_billing_form').serializeArray();
    send_ajax(url, 'post', data, {handler:'single_billing_info_handler'});
});


function single_billing_info_handler(data) {

    var obj_upload = $.parseJSON(data);
    if (obj_upload['errors'].length > 0) {
        $('#single_billing_error_img').addClass('error_img');
        $('#single_billing_profile').addClass('error_class');
        $('#single_billing_profile').html(obj_upload['errors']);

    }else{

        $('.final_billing_modal').modal('hide');

        setTimeout(function () {
            get_billing_payment();
        },700);

    }
}

$(document).on('click','#final_billing_info_save', function () {
    var order_id = $('#order_id').val();
    var url = base_url + 'order/ax_save_final_billing';
    var data = $('#final_billing_table').serializeArray();
    data.push({name:'order_id',value:order_id});
    send_ajax(url, 'post', data, {handler:'final_biling_info_handler'});
});

function final_biling_info_handler(data) {

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

        get_billing_payment();

    }
}

$(document).on('click','.update_final_shiping_fee', function () {
    var order_id = $('#order_id').val();
    var user_id = $('#user_id').val();
    var url = base_url + 'order/ax_final_billing_update_shipping_fee';
    send_ajax(url, 'post', {order_id:order_id,user_id:user_id}, {handler:'update_final_shiping_fee_handler'});
});

function update_final_shiping_fee_handler(data) {

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
        get_billing_payment();
       setTimeout(function () {
           update_fina_shipping_sucess();
       },1000);

    }
}

function update_fina_shipping_sucess() {

    $('html,body').animate({
            scrollTop: $("#billing_info_form").offset().top},
        'slow');
    setTimeout(function () {
        $(".final_input").find('li').addClass("admin_table_row_success");
    },100)
}

$('.save_transit_order_notes').change(function () {

    var order_id = $(this).attr('data_id');
    var message = $('.transit_notes_'+order_id+'').val();

    var url = base_url + 'order/ax_save_transit_order_notes';
    send_ajax(url, 'post', {order_id:order_id,message:message}, {});
});

$(document).on('click','.create_inv', function () {
    var order_id = $('#order_id').val();
    var type = $(this).attr('data_type');
    var url = base_url + '../invoice/ax_create_invoice';
    var beforsend = '$("#create_invoice_div").removeClass("dis_none")';
    var comlete = '$("#create_invoice_div").addClass("dis_none")';
    send_ajax(url, 'post', {order_id:order_id,type:type}, {handler:'invoice_handler', beforsend:beforsend,complete:comlete});
});

$(document).on('click','.invoice_img', function () {

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

                var order_id = $('#order_id').val();

                var url = base_url + '../invoice/ax_delete_invoice';
                send_ajax(url, 'post', {order_id:order_id,id:id}, {handler:'invoice_handler'});
            }
        }
    });

});

function invoice_handler(data) {

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
        get_billing_payment();
    }
}

    $(document).on('click','#create_label_pdf',function () {
    var order_id = $('#order_id').val();

    var url = base_url + 'order/ax_create_label_pdf';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'create_label_handler'});
});

function create_label_handler(data) {

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
      location.reload();
    }
}

$(document).on('click','.delete_label_pdf',function () {

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

                var order_id = $('#order_id').val();
                var url = base_url + 'order/ax_delete_label_pdf';
                send_ajax(url, 'post', {order_id:order_id}, {handler:'create_label_handler'});

            }
        }
    });


});

$('.print_labels').click(function () {

    var order_id = $('#order_id').val();
    var url = base_url + 'order/ax_label_check';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'label_check_handler'});
});


function label_check_handler(data) {

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

     location.replace(base_url + 'order/label_print/'+obj['order_id']);

    }
}

$('#regeneracia_pdf').click(function () {
    var order_id = $('#order_id').val();
    var beforsend = '$("#create_shipment_div").removeClass("dis_none")';
    var comlete = '$("#create_shipment_div").addClass("dis_none")';
    var url = base_url + 'order/ax_create_label_pdf';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'regenerate_pdf_handler',beforsend:beforsend,complete:comlete});
});

function regenerate_pdf_handler(data) {

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
        location.reload();
    }
}


$(document).on('click', '.admin_web_hook', function () {

    var order_id = $(this).attr('data_id');
    var url = base_url + 'order/ax_web_hook_reg';
    send_ajax(url, 'post', {order_id:order_id}, {handler:'ax_web_hook_handler'});
});

function ax_web_hook_handler(data) {

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
        location.reload();
    }
}

$(document).on('click', '.save_credit_charge',function () {

   var data = $('#admin_action').serializeArray();
    data.push({name:'order_id', value:$('#order_id').val()});

    var url = base_url + 'order/billing_payment_admin_action';
    send_ajax(url, 'post', data, {handler:'save_credit_charge_handler'});
});

$(document).on('click','.delete_admin_credit',function () {

    var order_id = $('#order_id').val();
    var credit_id = $(this).attr('data-id');

    bootbox.confirm({
        message: "Are you sure, you want to delete ?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn btn-default btn-login-orange'
            }
        },
        callback: function (result) {

            if (result == true) {

                var url = base_url + 'order/ax_delete_admin_credit';
                send_ajax(url, 'post', {order_id:order_id,credit_id:credit_id}, {handler:'save_credit_charge_handler'});

            }
        }
    });





});

function save_credit_charge_handler(data) {

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
        location.reload();
    }
}


$(document).on('click','.fedex_validate_address',function () {

    $('#answer_validate_error').html('');
    var url = base_url+'order/validate_order_address';
    var load_script = '$("#validate_loader_div").removeClass("dis_none");';
    var compecte = '$("#validate_loader_div").addClass("dis_none");';
    var order_id = $('#order_id').val();
    $('#address_validation_modal').modal('show');
    send_ajax(url, 'post', {order_id:order_id}, {answer:'#answer_validate_error', beforsend:load_script,complete:compecte});
});


$(document).on('click','.hide_address_validation_modal',function () {

    $('#address_validation_modal').modal('hide');
});

