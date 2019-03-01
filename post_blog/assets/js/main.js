
$('#signup').click(function () {

    var registration_fields  = {
        options:{selector:'.registration_error', single:false, form_id:'#registration_form'},
        first_name:{errorname:'First name', required: true, minlength:2},
        last_name:{errorname:'Last name', required: true, minlength:2},
        email:{errorname:'Email', required: true, emailvalid:true },
        password:{errorname:'Password', required: true, minlength:8},
        retype_password:{errorname:'Retype password', required: true, equalTo:'password'}
    };

    var validation = new validation_lib(registration_fields);

    if(!validation.validate_field()){

        return false;
    }

    var send_data=$("#registration_form").serializeArray();
    var url = base_url+'home/ax_check_registration';
    send_ajax(url, 'post', send_data, {handler:'reg_handler'});
});

function reg_handler(data) {

    var bool = JSON.parse(data);

    if(!bool){

        bootbox.alert({
            message:'<span class="error_class">error</span>',
            backdrop: true

        });

    }else{

        location.replace(base_url+'home/login');
    }
}

$('#login').click(function () {

    var login_fields  = {
        options:{selector:'.registration_error', single:false, form_id:'#login_form'},
        email:{errorname:'Email', required: true, emailvalid:true },
        password:{errorname:'Password', required: true, minlength:8}
    };

    var validation = new validation_lib(login_fields);

    if(!validation.validate_field()){

        return false;
    }

    var send_data=$("#login_form").serializeArray();
    var url = base_url+'home/ax_check_login';
    send_ajax(url, 'post', send_data, {handler:'login_handler'});
});

function login_handler(data) {

    var bool = JSON.parse(data);

    if(!bool){

        bootbox.alert({
            message:'<span class="error_class">error</span>',
            backdrop: true

        });

    }else{

        location.replace(base_url+'home');
    }
}

$('#add_post').click(function () {

    var add_post_fields  = {
        options:{selector:'.post_error', single:false, form_id:'#add_post_form'},
        post_name:{errorname:'Post Name', required: true},
        desc:{errorname:'Description', required: true}
    };

    var validation = new validation_lib(add_post_fields);

    if(!validation.validate_field()){

        return false;
    }

    var send_data=$("#add_post_form").serializeArray();
    var url = base_url+'post/ax_add_post';
    send_ajax(url, 'post', send_data, {handler:'login_handler'});
});

$('.add_comment').click(function () {


    if($(this).closest("form").find('textarea').val() == ''){

        bootbox.alert({
            message:'<span class="error_class">Comment field required</span>',
            backdrop: true

        });

        return false;
    }

    var send_data=$(this).closest("form").serializeArray();

    var url = base_url+'post/ax_add_comment';
    send_ajax(url, 'post', send_data, {handler:'add_comment_handler'});
});

function add_comment_handler(data) {

    var bool = JSON.parse(data);

    if(!bool){

        bootbox.alert({
            message:'<span class="error_class">error</span>',
            backdrop: true

        });

    }else{

        location.reload();
    }
}