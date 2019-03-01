$(document).ready(function () {
    $('.card-body').each(function () {

        if ($(this).is(':visible')) {

            $(this).parent().siblings().find('i').css({"color": "#7f9093", "transform": "rotate(90deg)"})
        } else {
            $(this).parent().siblings().find('i').css({"color": "#48d19f", "transform": "rotate(0deg)"})
        }
    });
    $('.card-header button').click(function () {

        if ($(this).closest('.card-header').siblings().find('.card-body').is(':visible')) {

            $(this).find('i').css({"color": "#48d19f", "transform": "rotate(0deg)", "transition": "300ms"})
        } else {
            $(this).find('i').css({"color": "#7f9093", "transform": "rotate(90deg)", "transition": "300ms"})
        }
    })
});
console.log(action);

if(action == 'AppHttpControllersHomeController@main'){

    $(document).ready(function () {

        AOS.init();

        var clAOS = function() {

            AOS.init( {
                offset: 200,
                duration: 600,
                easing: 'ease-in-sine',
                delay: 300,
                once: true,
                disable: 'mobile'
            });
        };
    });

}

if (action == 'AppHttpControllersHomeController@index') {

    $(document).ready(function () {

        $('.admin__nav .menu__item').click(function (event) {
            event.stopPropagation();
            $(this).find('ul.dropdown_menu').toggle(200)
        });

        $('.dropdown_link').click(function () {
            $('div.dropdown_menu').toggle(200)
        });

        $('#class_or_training').modal('show');

        var url =  base_url + "/ax_open_course";
        send_ajax(url, 'post', {},{});
    });


    function opencourse(evt, courseName, lessonName, tab_lesson) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");

        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");

        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        if (lessonName) {
            document.getElementById("less_"+lessonName).style.display = "block";
        }
        if (lessonName && !tab_lesson) {

            $('#less_' +lessonName+ ' .video_overview .tablinks').eq(2).addClass('active');
        }

        if (tab_lesson) {
            $('#less_'+lessonName).find('.tabcontent').removeClass('dis_block');
            $('#less_'+lessonName).find('#'+tab_lesson).addClass("dis_block");
        }

       if(typeof courseName != 'undefined' ||  courseName != null){
           document.getElementById(courseName).style.display = "block";
       }
        evt.currentTarget.className += " active";
    }

/*
    //    chart js
    var canvas = document.getElementById('myChart');
    var data = {
        labels: ["JAN 10", "JAN 17", "FEV 3", "FEV 27", "MAR 6", "MAR 16", "MAR 27"],
        datasets: [
            {
                /!* label: "My First dataset", *!/
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "#48d19f",
                pointHoverBorderWidth: 3,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [1, 10, 30, 35, 50, 55, 65],
            },
            {
                /!* label: "My First dataset", *!/
                fill: false,
                lineTension: 0.1,
                backgroundColor: "#219dd0",
                borderColor: "#219dd0",
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "#219dd0",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#219dd0",
                pointHoverBorderColor: "#219dd0",
                pointHoverBorderWidth: 3,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [1, 5, 20, 25, 35, 45, 50],
            }
        ]
    };
*/

/*    function adddata() {
        myLineChart.data.datasets[0].data[7] = 60;
        myLineChart.data.labels[7] = "Newly Added";
        myLineChart.update();
    }

    var option = {
        showLines: true
    };
    var myLineChart = Chart.Line(canvas, {
        data: data,
        options: option
    });*/

    $('.navbra_toggle').click(function () {
        $('aside').toggle(200);
    });

    var x = window.matchMedia("(max-width: 992px)");

    if (x.matches) {
        $('.admin__nav > .menu  .dropdown_menu .menu__item').click(function () {
            $('aside').hide(200);
        })
    }

    $(".menu__item.open_drop").click(function(){
        $(this).find('i').toggleClass("iClass");
    });

    $(document).on('click','.sort_less',function () {

        var asc_desc = $(this).attr('data-asc');

        if(asc_desc == 'ASC'){

            $(this).attr('data-asc','DESC');
        }else{
            $(this).attr('data-asc','ASC');
        }

        var url =  base_url + "/ax_ordering_subject";
        send_ajax(url, 'post', {sub_id:$(this).attr('data-id'),asc_desc:asc_desc},{answer:'.lessons_sequence_answer'});
    });


}

if(action == 'AppHttpControllersHomeController@index'){

    $(document).on('click','.check_result',function () {

        var arr_count = $(this).parents('.accordion').find('.card').length;

        var radio_val = [];

        var el = $(this).parents('.accordion').find('.check_result_radio');


        $.each(el, function( index, value ) {

            if($(value).prop('checked') == true){

                radio_val.push($(value).val());
            }
        });

        var url =  base_url + "/ax_save_quiz_answer";
        send_ajax(url, 'post', {answers:radio_val,less_id:$('#less_id').val()},{handler:'save_quiz_answer_handler'});
    });

    function save_quiz_answer_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length>0){
            alert(obj['errors'])
        }else{

            if(obj['right_answer'].length == 0){

                $('.answer_info').html('<p>'+obj['right_answer_count'] + ' - ' + $('.exam_main').find('.col-md-6').length+'</p>');

                $('html,body').animate({
                        scrollTop: $("#answer_info").offset().top},
                    'slow');

                return false;
            }

            var val = '';

            $('.answer_info').html('<p>'+obj['right_answer_count'] + ' - ' + obj['all_count']+'</p>');

            $('html,body').animate({
                    scrollTop: $("#answer_info").offset().top},
                'slow');

            var el = $('#' + obj['lesson_title']).find('.card');

            $.each(el, function( index, value ) {

                $(value).addClass('red_border');

            });

            $.each(obj['right_answer'], function( index, value ) {

                val = value['quiz_id']+ '->' + value['answer_id'];

                $('input[value="' + val + '"]').parents('.card').removeClass('red_border');
                $('input[value="' + val + '"]').parents('.card').addClass('green_border');
            });

            $.each(obj['wrong_answer'], function( index, value ) {

                val = obj['wrong_answer'][index]['quiz_id']+ '->' + obj['wrong_answer'][index]['answer_id'];

                $('input[value="' + val + '"]').parent('.container_radio').find('.checkmark').addClass('red_class');
                $('input[value="' + value['right_answer_id'] + '"]').parent('.container_radio').find('.checkmark').addClass('green_class');
            });

            $('.check_result').remove();
        }

        setTimeout(function () {
            $('.answer_info').html('');
        },3000)
    }
}

if(action == 'AppHttpControllersTrainingController@example'){

    $('.start_quiz').click(function () {

        $('#example_form').html(examInfo);
        $('.exam_main').removeClass('dis_none');

        $('.finish').prop('disabled',false);

        var minutes = 24;
        var seconds = 60;

        setTimeout(function () {
            $('.minutes').html(minutes);
        },1000);

        intervalMinutes = setInterval(function () {

            minutes--;
            console.log(minutes);
            $('.minutes').html(minutes);

        },60000);

        intervalSeconds = setInterval(function () {

            seconds--;

           if(seconds>0 && seconds<10){

                seconds = '0'+seconds;
            }

            $('.second').html(seconds);


            if(minutes == 0 && seconds == 0){

                $('.finish').trigger('click');

                clearInterval(intervalMinutes);
                clearInterval(intervalSeconds);
            }

            if(seconds == 0){
                seconds = 60;
            }

            if(minutes == 1 && seconds == 0){
                bootbox.alert('1 minute left');

            }

        },1000);



        $(this).remove();
    });

    $(document).on('click','.example_li',function () {

        var el = $(this).parents('ul').find('input');

        $.each(el, function( index, value ) {

            $(value).prop('checked',false);
        });

        $(this).find('input').prop('checked',true);
        $(this).find('input').trigger('change');
    });

    $(document).on('change','.check_result_radio',function (){

        var el = $(this).parents('ul').find('input');

        $.each(el, function( index, value ) {

            $(value).parent('li').removeClass('blue_color_class');

            if($(value).prop('checked') == true){

                $(value).parent('li').addClass('blue_color_class');
            }
        });
    });


    $(document).on('click','.finish',function (){

        var arr_count =  $('.exam_main').find('.col-md-6').length;

        var radio_val = [];

        var el = $('.exam_main').find('.check_result_radio');


        $.each(el, function( index, value ) {

            if($(value).prop('checked') == true){

                radio_val.push($(value).val());
            }
        });

        var url =  base_url + "/ax_save_exam_answer";
        send_ajax(url, 'post', {answers:radio_val,exam_id:$('#exam_id').val()},{handler:'save_quiz_exam_handler'});
    });

    function save_quiz_exam_handler(data) {

      var obj = $.parseJSON(data);

        clearInterval(intervalMinutes);
        clearInterval(intervalSeconds);

        if(obj['errors'].length>0){
            alert(obj['errors'])
        }else{

            if(obj['right_answer'].length == 0){

                $('.answer_info').html('<p>'+obj['right_answer_count'] + ' - ' + $('.exam_main').find('.col-md-6').length+'</p>');

                $('html,body').animate({
                        scrollTop: $("#answer_info").offset().top},
                    'slow');

                $.each(obj['wrong_answer'], function( index, value ) {

                    val = obj['wrong_answer'][index]['quiz_id']+ '->' + obj['wrong_answer'][index]['answer_id'];

                    $('input[value="' + val + '"]').parent('li').addClass('red_color_class');
                    $('input[value="' + value['right_answer_id'] + '"]').parent('li').addClass('green_color_class');
                });

                return false;
            }

            var val = '';

            $('.answer_info').html('<p>'+obj['right_answer_count'] + ' - ' + obj['all_count']+'</p>');

            $('html,body').animate({
                    scrollTop: $("#answer_info").offset().top},
                'slow');

            $.each(obj['right_answer'], function( index, value ) {

                val = value['quiz_id']+ '->' + value['answer_id'];

                $('input[value="' + val + '"]').parent('li').removeClass('red_color_class');
                $('input[value="' + val + '"]').parent('li').addClass('green_color_class');
            });

            $.each(obj['wrong_answer'], function( index, value ) {

                val = obj['wrong_answer'][index]['quiz_id']+ '->' + obj['wrong_answer'][index]['answer_id'];

                $('input[value="' + val + '"]').parent('li').addClass('red_color_class');
                $('input[value="' + value['right_answer_id'] + '"]').parent('li').addClass('green_color_class');
            });

            $('.finish').remove();
            $('.finish').prop('disabled',true);
        }
    }

    $(document).ready(function () {

        examInfo = $('.exam_main').clone();
        $('.exam_main').remove();

    });
}

if(action == 'AppHttpControllersProfileController@index'){

    $('.save_user_info').click(function () {

        var file_data = new FormData;

        var input = $('#upload_profile_photo');

        var file = input[0].files[0];

        file_data.append('user_photo', input[0].files[0]);
        file_data.append('name', $('#first_name').val());

        var url =  base_url+'/ax_save_user_info';
        ax_upload_file_ajax(file_data,url,save_user_info);
    });

    function save_user_info(data) {

        var obj = data;

        if(obj['inf'].length != 0){

            $('#photo-upload-preview').prop('src',obj['inf']);
        }

        $('#upload_profile_photo').val('');
        $('#upload_profile_photo').prop('value','');
    }

    $('.remove_img').click(function () {

        var url =  base_url + "/ax_delete_avatar";
        send_ajax(url, 'post', {},{handler:'delete_avatar_handler'});
    });

    function delete_avatar_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length>0){
            alert(obj['errors'])
        }else{

            $('#photo-upload-preview').prop('src',obj['path']+'/no-profile-pic.png');
        }
    }

    $('.change_email').click(function () {

        $('#change_email_modal').modal('show');
    });
    
    $('.check_password').click(function () {

        var url =  base_url + "/ax_check_password";
        send_ajax(url, 'post', {password:$('#password').val()},{handler:'check_password_handler'});
    });

    function check_password_handler(data) {

        var obj = $.parseJSON(data);

        if(!obj['check']){

            alert('Your password is invalid');
        }else{
            $('.change_email').find('input').prop('name','change_email');
            $('.change_email').find('input').prop('type','email');
            $('.change_email').find('input').prop('value','');
            $('.change_email').find('button').removeClass('check_password');
            $('.change_email').find('button').addClass('change_email_butt');
            $('.change_email').find('button').html('Change Email');
        }
    }

    $(document).on('click','.change_email_butt',function () {

        var url =  base_url + "/ax_change_email";
        send_ajax(url, 'post', {email:$('#password').val()},{handler:'change_email_handler'});
    });

    function change_email_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length >0){
            $('.message').html(obj['errors']);
            return false;
        }

        $('.message').html(obj['message']);

        setTimeout(function () {
            $('#change_email_modal').modal('hide');
        },2000);
    }

    $('#change_email_modal').on('hidden.bs.modal', function (e) {
        $('.message').html('');
    })
}

if(action == 'AppHttpControllersPricingController@change_plan'){

    $('.charge_modal_show_btn').click(function () {

        $('#charge_modal').modal('show');
    });

    $('.save_charge_check').click(function () {

        var file_data = new FormData;

        var input = $('#upload_check');

        var file = input[0].files[0];

        file_data.append('check_photo', input[0].files[0]);

        var url =  base_url+'/ax_save_check';
        ax_upload_file_ajax(file_data,url,save_check);
    });

    function save_check(data) {
        $('.inf').html('<p>Your check is Successfully uploaded. </p>' +
            '<p>Our admins will get back to you soon.</p>');

        setTimeout(function () {

          location.reload();
        },3000);
    }

    $('.change_premium_butt').click(function () {

        var url =  base_url + "/ax_change_premium";
        send_ajax(url, 'post', {plan_id:2},{handler:'change_premium_handler'});
    });

    function change_premium_handler(data) {

        var obj = $.parseJSON(data);

        $('#charge_modal').modal('show');
    }
}


function ax_upload_file_ajax(file_data,url,handler) {

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
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
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

            var obj_upload = data;

            if(handler != ''){
                eval(handler(data))
            }

            $('#mass_upload_file_name').val(obj_upload['file_name']);

            $('.progressbar .proc_span').html('');
            $('.progressbar .procent').css('width', '0');
            $('#mass_upload_inp').val('');
        }
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}

$('.no_href').click(function (e) {
    e.preventDefault();
});