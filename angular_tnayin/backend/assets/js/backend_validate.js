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
})