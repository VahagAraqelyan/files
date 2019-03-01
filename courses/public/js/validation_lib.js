class validation_lib {

    constructor(valid_field){

        this.valid_field = valid_field;
    }

    validate_field(){

        var error = [];
        var log = true;
        var selector = '';
        var bool_break = true;
        var modal_show = '';
        var answer = '';

        for (var key in this.valid_field) {

            if(!this.valid_field.hasOwnProperty('options')){

                alert('Please Attach Options');

                break;
            }

            if(this.valid_field[key].hasOwnProperty('modal_show')){
                modal_show = this.valid_field[key]['modal_show'];
            }

            if(key == 'options'){

                selector = this.valid_field[key]['selector'];
                $(''+selector+'').html('');

                if(!this.valid_field[key]['single']){
                    bool_break = false;
                }
                continue;
            }

            if(bool_break) {
                error = this.check_field(key, this.valid_field[key]);

                if (error != '') {

                    log = false;
                    break;
                }
            }else{

                if(typeof this.check_field(key, this.valid_field[key])[0] != 'undefined'){
                    error .push(this.check_field(key, this.valid_field[key])[0]);
                }

                if(error.length >0){
                    log = false;
                }
            }
        }

        if (!log) {

            if(modal_show !=''){

                $(modal_show).modal('show');
            }

            for (var i = 0;i<error.length; i++) {

                $(selector).append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
            }

            return false;
        }

        return true;
    }

    check_field(field_name,valid_obj){

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

            error_messages.push(  valid_obj['errorname'] + ' field is required.') ;


        }

        if(valid_obj.hasOwnProperty('minlength') && field_val.length < valid_obj['minlength'] && field_val){

            error_messages.push( valid_obj['errorname'] + ' field must be at least ' + valid_obj['minlength']+' characters in length.');

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

                error_messages.push( valid_obj['errorname'] +  ' field does not match the ' + valid_obj['equalTo'] + ' field.');

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

                error_messages.push( valid_obj['errorname'] +' field must contain a valid email address.');

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

    }


}