$(document).on('keypress', '.number_class', function (key){
    if( key.charCode > 65 || key.charCode > 90){

        return false;
    }

});

$(document).on('change', '.number_class', function (key){

    if(!$.isNumeric($(this).val())){

        $(this).val('');
    }

});

$(document).ready(function () {

    if(action == 'AppHttpControllersHomeController@index'){

        var url =  base_url + "/home/ax_check_wallet";
        send_ajax(url, 'post', {'_token':$('#token').val()},{handler:'check_wallet_handler'});
    }

    if(action == 'AppHttpControllersWallet@addWallet'){

         var fieldHTML = '';

      $('.add_new').click(function () {

          fieldHTML = '<div class="col-md-12 wallet_block">' +
              '                <div class="list-item-area new-adding-place my_list_class">' +
              '                    <div class="col-md-3 list-input">' +
              '                        <input type="text" name="names[]" value="" class="form-control wallet_name " placeholder="">' +
              '                    </div>\n' +
              '                    <div class="col-md-3 list-input">' +
              '                        <select class="form-control selectpicker select-country wallet_type" name="types[]" tabindex="-98">' +
              '                            <option value="1">Credit Card</option>' +
              '                            <option value="2">Cash</option>' +
              '                        </select>' +
              '                    </div>' +
              '                    <div class="item-delete col-md-2"><a href="#" class="remove_wallet red-color">X</a></div>' +
              '                </div>' +
              '            </div>' +
              '        </div>';

          $('.add_more_fields').append(fieldHTML);
      });


        $(document).on('click', '.remove_wallet', function(e){
            $(this).parents('.wallet_block').remove();
        });


        $('.save_wallet').click(function () {

            if($('.wallet_name').val() == ''){

                alert('Incorrect information. Please add wallet name');
                return false;
            }

            if($('.wallet_type').val()>2 || $('.wallet_type').val()<1 || $('.wallet_type').val() == ''){

                alert('Incorrect information.');
                return false;
            }

            var url =  base_url + "/wallet/ax_save_wallet";
            var data = $('#add_wallet_form').serializeArray();
            data.push({'name':'_token','value':$('#token').val()});
            send_ajax(url, 'post', data,{handler:'save_wallet_handler'});
        });
    }

    if(action == 'AppHttpControllersRecordsController@add_records'){

        $('.save_records').click(function () {

            var url =  base_url + "/add_records/ax_save_records";
            var data = $('#add_records_form').serializeArray();
            data.push({'name':'_token','value':$('#token').val()});
            send_ajax(url, 'post', data,{handler:'save_wallet_handler'});
        });
    }
});

/*Handler functions*/

function check_wallet_handler(data) {

    var obj = $.parseJSON(data);

    if(!obj['errors'].length>0){
       agoolert(obj['errors']);
    }else{
        location.replace(base_url+'/add_Wallet');
    }
}

function save_wallet_handler(data) {

    var obj = $.parseJSON(data);

    if(!obj['bool']){
        location.replace(base_url+'/home');
    }
}
