xhr = '';

function valid_fields(field_name, valid_obj) {

    var error_messages = [];

    if(valid_obj.hasOwnProperty('formid')){

        var formid = valid_obj['formid'];

        var field_val =  $( valid_obj['formid'] + ' ' + '[name = '+field_name+']').val();

    }else{

        var field_val =  $('[name = '+field_name+']').val();
    }

    if(valid_obj.hasOwnProperty('errorname')){

        valid_obj['errorname'];

    }else {

        valid_obj['errorname'] =  field_name;
    }

    if(!field_val || field_val == '' ){

        field_val = false;

    }else{

        field_val = field_val.trim();

    }// end  valid  required


    if(valid_obj.hasOwnProperty('required') && !field_val){

        if(lang == 'ru'){
            error_messages.push(  valid_obj['errorname'] + ' Поле обязательное') ;
        }else if(lang == 'en'){
            error_messages.push(  valid_obj['errorname'] + ' Field Required') ;
        }else{

            error_messages.push(  valid_obj['errorname'] + ' Դաշտը Պարտադիր  է։') ;
        }
    }

    if(valid_obj.hasOwnProperty('minlength') && field_val.length < valid_obj['minlength'] && field_val){

        if(lang == 'ru'){
            error_messages.push( valid_obj['errorname'] + ' поле должно быть не меньше ' + valid_obj['minlength']+' символы.');
        }else if(lang == 'en'){
            error_messages.push( valid_obj['errorname'] + ' the field must be no less than ' + valid_obj['minlength']+' characters.');
        }else{
            error_messages.push( valid_obj['errorname'] + ' դաշտը պետք է լինի ոչ պակաս քան ' + valid_obj['minlength']+' նիշ.');
        }

    }// end valid minlength

    if(valid_obj.hasOwnProperty('maxlength') && field_val.length > valid_obj['maxlength'] && field_val){

        error_messages.push( valid_obj['errorname'] +  ' field must be at least ' + valid_obj['maxlength']+ ' characters in length.');

    }// end valid maxlength

    if(valid_obj.hasOwnProperty('length') && field_val.length != valid_obj['length'] && field_val){

        error_messages.push(valid_obj['errorname'] +  ' field must be equal ' + valid_obj['length'] + ' characters in length.');

    }// end valid length


    if(valid_obj.hasOwnProperty('equalTo')){

        var equalTo_val =  $('[name = '+valid_obj['equalTo']+']').val();


        if(equalTo_val != field_val  && field_val){


            if(lang == 'ru'){
                error_messages.push( valid_obj['errorname'] +  'не совпадает с полем Пароль');
            }else if(lang == 'en'){
                error_messages.push( valid_obj['errorname'] + ' does not match the Password field ' + valid_obj['minlength']+' characters.');
            }else{
                error_messages.push( valid_obj['errorname'] + ' դաշտը պետք է լինի ոչ պակաս քան ' + valid_obj['minlength']+' նիշ.');
            }



        }
    }// end  valid  equalTo

    if(valid_obj.hasOwnProperty('equal')){

        var equal_val =  $('[name = '+valid_obj['equal']+']').val();


        if(equal_val != field_val){

            error_messages.push( valid_obj['errorname'] +  ' field does not match the ' + valid_obj['equal'] + ' field.');

        }
    }// end  valid  equalTo


    if(valid_obj.hasOwnProperty('emailvalid') && field_val){

        var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if(!filter.test(field_val)){


            if(lang == 'ru'){
                error_messages.push( valid_obj['errorname'] +' поле должно быть эл. адрес формате.');
            }else if(lang == 'en'){
                error_messages.push( valid_obj['errorname'] +' field must be email.');
            }else{
                error_messages.push( valid_obj['errorname'] +' դաշտը պետք է լինի էլ․ հասցե ձևաչափով։');
            }

        }

    }// end  valid  emailvalid

    if(valid_obj.hasOwnProperty('datevalid') && field_val){

        if(new Date(field_val) == 'Invalid Date'){

            error_messages.push( valid_obj['errorname'] + ' field must be correct date.');

        }

    }

    if(valid_obj.hasOwnProperty('checked')){

        var check = false;

        if($('[name = '+field_name+']').length<2){

            if(!$('[name = '+field_name+']').prop('checked')){

                if(valid_obj.hasOwnProperty('error_text')){

                    error_messages.push(valid_obj['error_text']);

                }else{

                    error_messages.push(' Please Read and Agree to.'+ valid_obj['errorname']);
                }


            }
        }else{
            $.each($('[name = '+field_name+']'), function( index, value ) {



                if($(value).prop('checked')){

                    check = true;
                    return false;
                }

            });

            if(!check){

                if(valid_obj.hasOwnProperty('error_text')){

                    error_messages.push(valid_obj['error_text']);

                }else{

                    error_messages.push(' Please Read and Agree to.'+ valid_obj['errorname']);
                }
            }

        }

    }

    if(valid_obj.hasOwnProperty('required_state')){

        var state = $( "#select-state" ).find('select[name = "state"]');
        $(state).parent().find('button').removeClass('error_red_class');
        if(state.length > 0){

            if(state.val()== 0){

                $(state).parent().find('button').addClass('error_red_class');

                error_messages.push( valid_obj['errorname'] + ' field is required');
            }
        }

    }

    if(valid_obj.hasOwnProperty('phone_number')){

        if (field_val[0] != '+' && field_val){

            error_messages.push( valid_obj['errorname'] + ' invalid');
        }
    }

    if(valid_obj.hasOwnProperty('numeric')){

        if (field_val && !$.isNumeric(field_val)){

            error_messages.push( valid_obj['errorname'] + ' does not number');
        }
    }

    if(valid_obj.hasOwnProperty('phone_number_length') &&  error_messages == ''){

        var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{5})$/;
        if (!field_val.match(phoneno) && field_val){

            error_messages.push( valid_obj['errorname'] + ' field must be equal 11 characters in length.');

        }
    }

    if(valid_obj.hasOwnProperty('card_number') && error_messages == ''){

        if(valid_obj.hasOwnProperty('formid')){

            var attr = $( valid_obj['formid'] + ' ' + '[name = '+field_name+']');

        }else{

            var attr = $('[name = '+field_name+']');
        }

        var result = attr.validateCreditCard();

        if(!result.valid){

            error_messages.push( valid_obj['errorname'] + ' field invalid.');
        }

    }// end valid card number

    if(valid_obj.hasOwnProperty('select_valid') && field_val){

       if(field_val != "US_226"){

           return false;
       }

        $.each(valid_obj['select_valid'], function( index, value ) {


            if($(value).val() == '' || $(value).val() == 0){

                error_messages.push( index + ' field required.');


                if(error_messages.length != 0  &&  $(value).prop('tagName') == 'SELECT'){

                    $(value).parent().find('button').addClass('error_red_class');
                        return false;
                }else if(error_messages.length != 0){

                    $(value).addClass('error_red_class');
                    return false;
                }

            }
        });
            return error_messages;
    }

    if(error_messages.length != 0  && $('[name = '+field_name+']').prop('tagName') == 'SELECT'){

        if(valid_obj.hasOwnProperty('formid')){

            $(valid_obj['formid'] + ' ' + '[name = '+field_name+']').parent().find('button').addClass('error_red_class');

        }else{

            $('[name = '+field_name+']').parent().find('button').addClass('error_red_class');

        }

    }else if(error_messages.length != 0 ){

        if(valid_obj.hasOwnProperty('formid')){

            $(valid_obj['formid'] + ' ' + '[name = '+field_name+']').addClass('error_red_class');

        }else{

            $('[name = '+field_name+']').addClass('error_red_class');
        }



    }

    return error_messages;

} //end function


function send_ajax(url, method, send_data, settings_obj){

    if(settings_obj.hasOwnProperty('abort') && settings_obj['abort'] == true) {
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
    }

    var async;

    if(settings_obj.hasOwnProperty('async') && settings_obj['async'] == 'false') {
        async = false;
    }

    xhr = $.ajax({
        url: url,
        type: method,
        data:  send_data,
        async: async,
        beforeSend: function() {
            if(settings_obj.hasOwnProperty('loader')) {
                $(settings_obj['loader']).show();
            }
            if(settings_obj.hasOwnProperty('beforsend')) {
                eval(settings_obj['beforsend']);
            }

            if(settings_obj.hasOwnProperty('show_loader')){
                $(settings_obj['answer']).html("<div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>");
            }
        },
        complete: function() {
            if(settings_obj.hasOwnProperty('loader')) {
                $(settings_obj['loader']).hide();
            }
            if(settings_obj.hasOwnProperty('complete')) {
                eval(settings_obj['complete']);
            }
        },
        success: function(data){
            if(settings_obj.hasOwnProperty('handler')){

                data= data.replace(/'/gi, "`");
                data=eval(settings_obj['handler']+'(\''+data+'\')');
            }
            if(settings_obj.hasOwnProperty('answer')){
                $(settings_obj['answer']).html(data);
                $(settings_obj['answer']).show();
            }
            if(settings_obj.hasOwnProperty('success')) {
                eval(settings_obj['success']);
            }

        }
    });

}
