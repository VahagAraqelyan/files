

$(window).on('load', function(){
    $('.loader').hide();
    //$('#content_main_container').show();
    $('.site_main_div').css('visibility', 'visible');
    $('.site_main_div').css('height', 'auto');
    $('.site_main_div').css('overflow', 'auto');

    $('#map').removeClass('map_hidden');
    $('.special_offer').removeClass('special_offer_hidden');
    $('.address').removeClass('address_hidden');
    $('.footer').removeClass('footer_hidden');

});


$(document).on('keypress', '.not_number', function (key){
    if( key.charCode > 65 || key.charCode > 90){

        return false;
    }

});

$(document).on('change', '.not_number', function (key){

    if(!$.isNumeric($(this).val())){

        $(this).val('');
    }

});

if(action.toLowerCase() == 'home->index'){


    var customLabel = {
        ph: {
            label: '',
            icon: ''+base_url+'assets/images/if_location_925919.png'
        }

    };

    function initMap() {
        var pyrmont = new google.maps.LatLng();

        var myLatlng = new google.maps.LatLng(40.223265,44.509194);
        var myOptions = {
            zoom: 15,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map(document.getElementById("map"), myOptions);

        var icon = customLabel|| {};

        var marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
           /* icon: customLabel.ph.icon*/
        });

        $('#map').css('width',$(window).width()-80);
    }

    window.onload = function(){

        initMap();

        }

    $(document).ready(function ($) {

        var jssor_1_SlideshowTransitions = [
            {$Duration:500,$Delay:30,$Cols:8,$Rows:4,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:2049,$Easing:$Jease$.$OutQuad},
            {$Duration:500,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$SlideOut:true,$Easing:$Jease$.$OutQuad},
            {$Duration:1000,x:-0.2,$Delay:40,$Cols:12,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5}},
            {$Duration:2000,y:-1,$Delay:60,$Cols:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:$Jease$.$OutJump,$Round:{$Top:1.5}},
            {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$Jease$.$InWave,$Top:$Jease$.$InWave,$Clip:$Jease$.$OutQuad},$Round:{$Left:1.3,$Top:2.5}}
        ];

        var jssor_1_options = {
            $AutoPlay: 1,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
        };

        //var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
        /*#region responsive code begin*/

        var MAX_WIDTH = 10000;
        var MAX_HEIGHT = 10000;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                jssor_1_slider.$ScaleSize($(window).width(), $(window).height()+30);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        //ScaleSlider();

        //$(window).bind("load", ScaleSlider);
        //$(window).bind("resize", ScaleSlider);
        //$(window).bind("orientationchange", ScaleSlider);
        /*#endregion responsive code end*/

        $('.previews_list').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            },
            center: true,
            URLhashListener: true,
            autoplayHoverPause: true,
            smartSpeed: 1000
        });

    });

    $(".previews_list").lightGallery();

    $('.show_menu').click(function () {

        $('#menu_modal').show({
            backdrop: 'static'
        });
        var width = $(window).width()*75/100;var height = ($(window).width()*74/100)*0.6;

        if($(window).width()<600){
            width = $(window).width()*95/100;
            height = ($(window).width()*95/100)*0.6
        }

        var sucScript = "$('#menu_book').turn({width:'"+width+"',height:'"+height+"', autoCenter: '"+true+"'});";

        send_ajax(base_url + 'home/ax_show_menu', 'post', {'height':height}, {answer:'.show_menu_answer',complete:sucScript});
    });

    $(document).on('click','.odd',function () {

        $("#menu_book").turn("next");
    });

    $(document).on('click','.even',function () {
        $("#menu_book").turn("previous");
    });

    $('.close').click(function () {

        $("#menu_book").turn("destroy");

        $('#menu_modal').hide({
            backdrop: 'static'
        });

        $('.show_menu_answer').html('');

    });

    

    (function($){
        $.fn.datepicker.dates['hy'] = {
            days: ["Կիրակի", "Երկուշաբթի", "Երեքշաբթի", "Չորեքշաբթի", "Հինգշաբթի", "Ուրբաթ", "Շաբաթ"],
            daysShort: ["Կիր", "Երկ", "Երե", "Չոր", "Հին", "Ուրբ", "Շաբ"],
            daysMin: ["Կի", "Եկ", "Եք", "Չո", "Հի", "Ու", "Շա"],
            months: ["Հունվար", "Փետրվար", "Մարտ", "Ապրիլ", "Մայիս", "Հունիս", "Հուլիս", "Օգոստոս", "Սեպտեմբեր", "Հոկտեմբեր", "Նոյեմբեր", "Դեկտեմբեր"],
            monthsShort: ["Հնվ", "Փետ", "Մար", "Ապր", "Մայ", "Հուն", "Հուլ", "Օգս", "Սեպ", "Հոկ", "Նոյ", "Դեկ"],
            today: "Այսօր",
            clear: "Ջնջել",
            format: "dd.mm.yyyy",
            weekStart: 1,
            monthsTitle: 'Ամիսներ'
        };
    }(jQuery));


    $('.reservetion_date_calendar').datepicker({
        autoclose:true,
        language: 'hy',
        startDate: "dateToday",
        format:'yyyy-mm-dd'
    });

    $('#reservetion_calendar').change(function () {

        $('#reservetion_modal').modal('show');

        $('.res_date').val($(this).val());
    });


}

$('#save_reservetion').click(function () {

    $('#reservetion_form > *').find('input').removeClass('error_red_class');

    $('.reservetion-error').html('');

    var log = true;
    var error = [];

    var date_errorname = '';
    var first_name_errorname = '';
    var last_name_errorname = '';
    var tel_errorname = '';
    var email_errorname = '';
    var number_part = '';

    if(lang == 'ru'){

        date_errorname = 'Бронирования в день';
        first_name_errorname = 'Имя';
        last_name_errorname = 'Фамилия';
        tel_errorname = 'Номер тел.';
        email_errorname = 'Эл. Адрес';
        number_part = 'Количество участников';

    }else if(lang == 'en'){

        date_errorname = 'Reservation day:';
        first_name_errorname = 'First Name';
        last_name_errorname = 'Last Name';
        tel_errorname = 'Tel.';
        email_errorname = 'Email';
        number_part = 'Number of participants';
    }else{

        date_errorname = 'Ամրագրման օր';
        first_name_errorname = 'Անուն';
        last_name_errorname = 'Ազգանուն';
        tel_errorname = 'Հեռախոսահամար';
        email_errorname = 'Էլ․ Հասցե';
        number_part = 'Մասնակիցների քանակը․';
    }

    var fields  = {
        date:{errorname:date_errorname, required: true,formid:'#reservetion_form'},
        first_name:{errorname:first_name_errorname, required: true,formid:'#reservetion_form'},
        last_name:{errorname:last_name_errorname, required: true,formid:'#reservetion_form'},
        tel:{errorname:tel_errorname, required: true,formid:'#reservetion_form'},
        email:{errorname:email_errorname, emailvalid:true,formid:'#reservetion_form'},
        number_part:{errorname:number_part,required: true, formid:'#reservetion_form'}
    };

    $.each(fields, function (index, value) {

        if(valid_fields(index, value)[0] != undefined){

            error.push(valid_fields(index, value)[0]);
        }


        if (error != '') {

            log = false;
        }
    });

    if (!log) {

        for (var i = 0;i<error.length; i++) {

            $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
        }

        return false;
    }

    var data = $('#reservetion_form').serializeArray();

    send_ajax(base_url + 'reservetion/ax_add_reservetion', 'post', data, {handler:'add_reservetion_handler'});

});


$(document).ready(function () {

    if(action.toLowerCase() == 'gallery->index' || action.toLowerCase() == 'gallery->gallery'){

        $("#lightgallery").lightGallery();
    }
});

function add_reservetion_handler(data) {

    var obj = JSON.parse(data);

    $(".reservetion-error").html('');

    if (obj['errors'].length > 0) {

        $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][0] + '</span></div>');

    }else{

        $(".reservetion-error").append('<div><span class="success_class">' + obj['success'][0] + '</span></div>');
    }

    setTimeout(function () {

        $('#reservetion_modal').modal('hide');
        $(".reservetion-error").html('');
        $('#reservetion_form > *').find('input').val('');
        $('#reservetion_calendar').val('');
    },1500);
}


$("#respMenu").aceResponsiveMenu({
    resizeWidth: '768', // Set the same in Media query
    animationSpeed: 'fast', //slow, medium, fast
    accoridonExpAll: false //Expands all the accordion menu on click
});

$('.book_now').click(function () {

    $('#reservetion_modal').modal('show');
});

$("#reservetion_modal").on('show.bs.modal', function () {

    $('#reservetion_form > *').find('input').removeClass('error_red_class');
    $('#reservetion_form > *').find('input').val('');

    $('.res_date').val($('#reservetion_calendar').val());
    $('.reservetion-error').html('');
});

$('#save_about_us').click(function () {

    $('#about_us_form > *').find('input').removeClass('error_red_class');
    $('#about_us_form > *').find('textarea').removeClass('error_red_class');

    $('.about-us-error').html('');

    var log = true;
    var error = [];

    var first_name_errorname = '';
    var last_name_errorname = '';
    var ar_errorname = '';
    var email_errorname = '';

    if(lang == 'ru'){

        first_name_errorname = 'Имя';
        last_name_errorname = 'Фамилия';
        ar_errorname = 'Предложение';
        email_errorname = 'Эл. Адрес';

    }else if(lang == 'en'){

        first_name_errorname = 'First Name';
        last_name_errorname = 'Last Name';
        ar_errorname = 'Sentence.';
        email_errorname = 'Email';
    }else{

        first_name_errorname = 'Անուն';
        last_name_errorname = 'Ազգանուն';
        ar_errorname = 'Առաջարկ';
        email_errorname = 'Էլ․ Հասցե';
    }

    var fields  = {
        first_name:{errorname:first_name_errorname, required: true,formid:'#about_us_form'},
        last_name:{errorname:last_name_errorname, required: true,formid:'#about_us_form'},
        our_text:{errorname:ar_errorname, required: true,formid:'#about_us_form'},
        email:{errorname:email_errorname, required: true, emailvalid:true,formid:'#about_us_form'}
    };

    $.each(fields, function (index, value) {

        if(valid_fields(index, value)[0] != undefined){

            error.push(valid_fields(index, value)[0]);
        }


        if (error != '') {

            log = false;
        }
    });

    if (!log) {

        for (var i = 0;i<error.length; i++) {

            $(".about-us-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
        }

        return false;
    }

    var data = $('#about_us_form').serializeArray();
    var suc_script = '' +
        '$("#succ_modal").modal("show"); $("#about_us_form input").val("");  $("#about_us_form textarea").val("");';
    send_ajax(base_url + 'home/ax_send_message', 'post', data, {success:suc_script});
});
