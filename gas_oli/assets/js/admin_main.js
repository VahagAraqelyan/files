socket = io.connect("https://oil.myworks.site:3000", {secure: true});
/*socket = io.connect("http://192.168.1.124:3000");*/

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


console.log(action);

checked_arr = [];
crew_info = [];

var crew_action = action.split('->');


if(action == 'dashboard->dashboard'){

    admin_crew_map = new google.maps.Map(document.getElementById("map"), {
        zoom: 6,
        center: new google.maps.LatLng(parseFloat(54.5215038), parseFloat(-107.3458742)),
        mapTypeId: 'satellite',
    });
}

socket.on('removeUser',function (data) {

        if(typeof data['userId'] == 'undefined' || data['userId'] == ''){

            return false;
        }

    if( typeof crew_info != 'undefined' || crew_info.length != 0){

        return false;
    }

        crew_info = crew_info.filter(function(number) {

            return number.crew_id == data.crew_id;
        });

    socket.emit('delete', req.body);
});

socket.on('getData',function (data) {

   if( typeof crew_info != 'undefined' || crew_info.length != 0){

        crew_info = crew_info.filter(function(number) {

           return number.crew_id == data.crew_id;
       });
   }

    crew_info.push(data);

    var i, x;

    if(crew_info.length == 0){
        return false;
    }

    var infowindow = new google.maps.InfoWindow();

    var marker, i, id;

    var color = '';

    for(var j = 0; j<4;j++){

        var rand_str = Math.floor(Math.random() * 100);

        if(j == 0 && rand_str == 155){

            rand_str =  Math.floor(Math.random() * 100);
        }

        color+= rand_str + ', '
    }

     color = color.slice(1, -2);

    var directionsDisplay = new google.maps.DirectionsRenderer(
        {
            suppressMarkers: true,
                polylineOptions: {
                    strokeColor: "rgb("+color+")"
                }
            }
        );
    var directionsService = new google.maps.DirectionsService;

    for (i = 0; i < crew_info.length; i++) {

        calculateAndDisplayRoute(directionsService, directionsDisplay, crew_info[i]['crew_lat'],crew_info[i]['crew_lng'], crew_info[i]['well_lat'], crew_info[i]['well_lng'],'maps-and-flags-black.png');
    }

    directionsDisplay.setMap(admin_crew_map);
});


socket.on('getData',function (data) {


    var i, x;

    if(crew_info.length == 0){


    }

    var infowindow = new google.maps.InfoWindow();

    var marker, i, id;

    var color = '';

    for(var j = 0; j<4;j++){

        var rand_str = Math.floor(Math.random() * 100);

        if(j == 0 && rand_str == 155){

            rand_str =  Math.floor(Math.random() * 100);
        }

        color+= rand_str + ', '
    }

    color = color.slice(1, -2);

    var directionsDisplay = new google.maps.DirectionsRenderer(
        {
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: "rgb("+color+")"
            }
        }
    );
    var directionsService = new google.maps.DirectionsService;

    for (i = 0; i < crew_info.length; i++) {

        calculateAndDisplayRoute(directionsService, directionsDisplay, crew_info[i]['crew_lat'],crew_info[i]['crew_lng'], crew_info[i]['well_lat'], crew_info[i]['well_lng'],'maps-and-flags-black.png');
    }

    directionsDisplay.setMap(admin_crew_map);
});


function calculateAndDisplayRoute(directionsService, directionsDisplay,crew_lat,crew_lng,well_lat,well_lng,icon_name) {


    var new_url = base_url.replace('admin/','');

    var icons = {
        start: new google.maps.MarkerImage(
            // URL
            new_url+'assets/images/crew_icon.png'

        ),
        end: new google.maps.MarkerImage(
            // URL
            new_url+'assets/images/'+icon_name

        )
    };

    directionsService.route({
        origin: new google.maps.LatLng(parseFloat(crew_lat),parseFloat(crew_lng)),
        destination: new google.maps.LatLng(parseFloat(well_lat),parseFloat(well_lng)),
        travelMode: google.maps.TravelMode['DRIVING'],
    }, function(response, status) {

        if (status === 'OK') {
            var leg = response.routes[0].legs[ 0 ];
            makeMarker(leg.start_location, icons.start, "title" );
            makeMarker(leg.end_location, icons.end, 'title' );
            directionsDisplay.setDirections(response);

        } else {
            window.alert('Directions request failed due to ' + status);
            clearInterval(designated_setinterval);
        }
    });
}

function makeMarker(position, icon, title ) {
    new google.maps.Marker({
        position: position,
        map: admin_crew_map,
        icon: icon,
        title: title,
    });
}

$('#change-captcha').click(function () {

    var ajax_url = base_url + "admin/get_new_captcha";
    send_ajax(ajax_url, 'post', {}, {answer: '#captcha-div'});
});

if(action == 'admin->index'){

    if($('#exampleInputEmail1').val() !=''){

        $('#exampleInputEmail1').trigger('focus');
    }

}

if(action == 'steersman->index'){
    $(document).ready(function () {

        driverDataTable = $('#driver_list').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax": {
                url: base_url+ "steersman/ax_get_all_steersman",
                data:{'type':$('#search_crt').val(),'searching_type':$('#search_val').val()},
                type:"POST",
                complete: function (data) {
                }
            },
            searching: false,
            "order": [[ 1, "ASC" ]],
            "columnDefs":[
                {
                    "target":[1]
                },
                { "orderable": false, "targets": 0 }
            ]
        });

        $('.search_driver_butt').click(function () {

            if($('#search_crt').val() == '' || $('#search_val').val() == ''){

                alert('Please set all data');
                return false;
            }

            driver_data_table();
        });


        function driver_data_table() {

            var settings = $("#driver_list").dataTable().fnSettings();

            settings.ajax.data = {'type':$('#search_crt').val(),'searching_type':$('#search_val').val()};

            driverDataTable.api().ajax.url(base_url+ "steersman/ax_get_all_steersman").load();
        }
    })

    $(document).on('click','.update_company',function () {

        var el = $('.edit_delete_cew');

        var checked_arr = [];

        $.each(el,function (index,val) {

            if($(val).prop('checked') == true){
                checked_arr.push($(val).val());
            }
        })

        if(checked_arr.length == 0){

            alert('Please set  Crew(s');
            return false;
        }

        $('#update_crew_modal').modal('show');

        var ajax_url = base_url + "Steersman/ax_update_crew";
        send_ajax(ajax_url, 'post', {'company':checked_arr}, {answer: '.update_crew_answer'});
    });


    $(document).on('click','.save_edit_crew',function () {

        var data = $('#save_edit_crew_form').serializeArray();
        var ajax_url = base_url + "Steersman/ax_save_update_crew";
        send_ajax(ajax_url, 'post', data, {handler:'save_edit_company_handler'});
    });


    $(document).on('click','.delete_company',function () {

        var el = $('.edit_delete_cew');

        var checked_arr = [];

        $.each(el,function (index,val) {

            if($(val).prop('checked') == true){
                checked_arr.push($(val).val());
            }
        })

        if(checked_arr.length == 0){

            alert('Please set Crew(s)');
            return false;
        }

        var ajax_url = base_url + "Steersman/ax_delete_crew";
        send_ajax(ajax_url, 'post', {'company':checked_arr}, {handler:'save_edit_company_handler'});
    });

    function save_edit_company_handler() {

        $('#update_crew_modal').modal('hide');
      location.reload();
    }
}

if(action == 'steersman->add_steersman'){

    $('#add_steersman_butt').click(function () {

        var add_steersman_fields  = {
            options:{selector:'.show_error', form_id:'#add_steersman_form'},
            name:{errorname:'Name',  required: true },
            surname:{errorname:'Surname', required: true},
            email:{errorname:'Email', required: true, emailvalid:true},
            tel:{errorname:'Tel.', required: true}
        };

        var validation = new validation_lib(add_steersman_fields);

        if(!validation.validate_field()){

            return false;
        }

        var data = $('#add_steersman_form').serializeArray();

        var url = base_url + "steersman/save_steersmans";
        send_ajax(url, 'post', data, {handler:'save_steersmans_handler'});

    });

    function save_steersmans_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length != 0){
            alert(obj['errors']);

        }else{
            location.replace(base_url+'steersman');
        }
    }
}

if(action == 'well->add_wells'){

    $('#add_well_butt').click(function () {

        var add_steersman_fields  = {
            options:{selector:'.show_error', single:false, form_id:'#add_well_form'},
            well_id:{errorname:'Well ID', required: true },
            name:{errorname:'Well Name', required: true },
            location:{errorname:'Surface Location', required: true},
            status:{errorname:'Well Status', required: true},
            lat:{errorname:'Surface Latitude', required: true},
            lng:{errorname:'Surface Longitude', required: true},
            company:{errorname:'Company', required: true},
            state_id:{errorname:'State', required: true},
            company_field:{errorname:'Company Field', required: true},
            comment:{errorname:'Comment', required: true},
        };

        var validation = new validation_lib(add_steersman_fields);

        if(!validation.validate_field()){

            return false;
        }

        var data = $('#add_well_form').serializeArray();

        var url = base_url + "well/ax_save_wells";
        send_ajax(url, 'post', data, {handler:'ax_save_wells_handler'});

    });

    function ax_save_wells_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length != 0){
            alert(obj['errors']);

        }else{
            location.replace(base_url+'get_all_wells');
        }
    }

    $('#upload_csv').change(function () {

        var file_data = new FormData;

        var input = $('#upload_csv');

        var file = input[0].files[0];

        var file_type = file['name'].split('.');

        if(file_type.length != 2){
            $('.show_error').html('Invalid file type');
            return false;
        }

        if(file_type['1'] != 'xls' && file_type['1'] != 'xlsx'){
            $('.show_error').html('the file must be in xls or xlsx type');
            return false;
        }

        file_data.append('well_csv', input[0].files[0]);

        var url =  base_url+'well/ax_upload_csv';
        ax_upload_file_ajax(file_data,url,upload_csv_handler);

    });

    function upload_csv_handler(data) {

        var obj = data;

        if (obj['errors'].length > 0) {

            $('.show_error').html(obj['errors']);
        } else {

            location.replace(base_url+'get_all_wells');
        }
    }
}

if(action == 'well->get_all_wells'){

    $(document).ready(function () {

        wellDataTable = $('#well_list').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax": {
                url: base_url+ "well/ax_get_all_wells",
                data:{'type':$('#search_crt').val(),'searching_type':$('#search_val').val()},
                type:"POST",
                complete: function (data) {

                    var page_checkbox = $('.product_check');
                    var page_arr = [];
                    var val1 = '';

                    $.each(page_checkbox, function( index, value ) {
                        page_arr.push($(value).val());
                    });

                    for (var i = 0; i < checked_arr.length; ++i) {
                        val1 = checked_arr[i];
                        for (var j = 0; j < page_arr.length; ++j)
                        {
                            if (val1 == page_arr[j]) {
                                $('.product_check[value="'+val1+'"]').prop('checked',true);
                                $('.product_check[value="'+val1+'"]').parents('tr').addClass('product_active');
                                continue;
                            }
                        }
                    }
                }
            },
            searching: false,
            "order": [[ 1, "ASC" ]],
            "columnDefs":[
                {
                    "target":[1]
                },
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 11}
            ]
        });

        $('.search_reservetion_butt').click(function () {

                if($('#search_crt').val() == '' || $('#search_val').val() == ''){

                    alert('Please set all data');
                    return false;
                }

                well_data_table();
        });


    })

    function well_data_table() {

        var settings = $("#well_list").dataTable().fnSettings();

        settings.ajax.data = {'type':$('#search_crt').val(),'searching_type':$('#search_val').val()};

        wellDataTable.api().ajax.url(base_url+ "well/ax_get_all_wells").load();
    }

    $(document).on('click','.mark_list',function () {

        var page_checkbox = $('.product_check');

        $.each(page_checkbox, function( index, value ) {

            $(value).prop('checked',true);
            $(value).parents('tr').addClass('product_active');
            checked_arr.push($(value).val());
        });

    });

    $(document).on('click','.unmark_list',function () {

        var page_checkbox = $('.product_check');


        $.each(page_checkbox, function( index, value ) {

            $(value).prop('checked',false);
            $(value).parents('tr').removeClass('product_active');

            for(var i = checked_arr.length; i--;){

                if (checked_arr[i] === $(value).val()){
                    checked_arr.splice(i, 1);
                }
            }
        });
    });

    $(document).on('change','.product_check',function () {


        if($(this).prop('checked') == false){

            $(this).parents('tr').removeClass('product_active');

            for(var i = checked_arr.length; i--;){

                if (checked_arr[i] === $(this).val()){
                    checked_arr.splice(i, 1);
                }
            }

        }else{

            $(this).parents('tr').addClass('product_active');
            checked_arr.push($(this).val());
        }
    });

    $(document).on('click','.upload_csv',function () {

        var url = base_url + "well/ax_download_csv";
        send_ajax(url, 'post', {ids:checked_arr}, {handler:'download_csv_handler'});
    });

    function download_csv_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {

          alert(obj['errors']);
        } else {

            location.replace(base_url+'well/download_file');
        }
    }

    $(document).on('click','.update_well',function () {

        if(checked_arr.length == 0){

            alert('Please set well(s)');
            return false;
        }

        $('#manual_update').modal('show');
        var url = base_url + "well/ax_manual_update";
        send_ajax(url, 'post', {ids:checked_arr}, {answer:'#manual_update_answer'});
    });

    $(document).on('click','.update_comment',function () {

        var id = $(this).attr('data-id');

        var comment = $("input[data-id='"+id+"']").val();

        $('#view_comment').modal('show');
        $('#upd_well_textarea').val(comment);
        $('#upd_well_textarea').attr('data-id',''+id+'');
    });

    $(document).on('click','#change_comment',function () {

        var comm =   $('#upd_well_textarea').val();

        var id = $('#upd_well_textarea').attr('data-id');

        $('#view_comment').modal('hide');
        $("input[data-id='"+id+"']").val(comm);
    });


    $(document).on('hidden.bs.modal','#view_comment', function () {
       $('body').addClass('modal-open');
    });

    $(document).on('click','.save_manual_update',function () {

        var data = $('#manual_update_form').serializeArray();
        var ajax_url = base_url + "well/manual_update_well";
        send_ajax(ajax_url, 'post', data, {handler:'manual_update_well_handler'});
    });

    function manual_update_well_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {

            alert(obj['errors']);
        } else {

            $('#manual_update').modal('hide');
            well_data_table()

        }
    }

    $(document).on('click','.see_map',function () {

        $('#map_modal').modal('show');
        var url = base_url + "well/ax_see_map";
        send_ajax(url, 'post', {}, {answer:'.map_answer'});
    });

    $(document).on('click','.delete_well',function () {

        if(checked_arr.length == 0){

            alert('Please set well(s)');
            return false;
        }

        var url = base_url + "well/ax_delete_well";

        send_ajax(url, 'post', {ids:checked_arr}, {handler:'delete_well_handler'});
    });

    function delete_well_handler(data) {

        well_data_table();
    }
}

if(action == 'company->add_company'){

    $('#add_company_butt').click(function () {

        var company_name = $('.company_name').val();

        if(company_name == ''){

            alert('Company name field required')
        }

        var url = base_url + "company/ax_save_company";
        send_ajax(url, 'post', {name:company_name}, {handler:'add_company_handler'});

    });

    function add_company_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {

            alert(obj['errors']);
        } else {

            alert('Data saved.');
            $('.company_name').val('');
        }
    }
}

if(action == 'company->all_company'){

    $(document).ready(function () {

        companyDataTable = $('#company_list').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax": {
                url: base_url+ "company/ax_get_all_company",
                data:{'searching_type':$('#search_val').val()},
                type:"POST",
                complete: function (data) {
                }
            },
            searching: false,
            "order": [[1, "ASC" ]],
            "columnDefs":[
                {
                    "target":[1]
                },

                { "orderable": false, "targets": 0 }
            ]
        });
    });

    $(document).on('click','.search_company_butt', function () {

        company_data_table();
    });

    function company_data_table() {

        var settings = $("#company_list").dataTable().fnSettings();

        settings.ajax.data = {'searching_type':$('#search_val').val()};

        companyDataTable.api().ajax.url(base_url+ "company/ax_get_all_company").load();
    }

    $(document).on('click','.update_company',function () {

        var el = $('.edit_delete_company');

        var checked_arr = [];

        $.each(el,function (index,val) {

            if($(val).prop('checked') == true){
                checked_arr.push($(val).val());
            }
        })

        if(checked_arr.length == 0){

            alert('Please set company');
            return false;
        }

        $('#update_company_modal').modal('show');

        var ajax_url = base_url + "Company/ax_update_company";
        send_ajax(ajax_url, 'post', {'company':checked_arr}, {answer: '.update_company_answer'});
    });


    $(document).on('click','.save_edit_company',function () {
        var data = $('#save_edit_company_form').serializeArray();
        var ajax_url = base_url + "Company/ax_save_update_company";
        send_ajax(ajax_url, 'post', data, {handler:'save_edit_company_handler'});
    });


    $(document).on('click','.delete_company',function () {

        var el = $('.edit_delete_company');

        var checked_arr = [];

        $.each(el,function (index,val) {

            if($(val).prop('checked') == true){
                checked_arr.push($(val).val());
            }
        })

        if(checked_arr.length == 0){

            alert('Please set company');
            return false;
        }

        var ajax_url = base_url + "Company/ax_delete_company";
        send_ajax(ajax_url, 'post', {'company':checked_arr}, {handler:'save_edit_company_handler'});
    });

    function save_edit_company_handler() {

        $('#update_company_modal').modal('hide');
       location.reload();
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

$(document).on('click','.paragraph_desc_view',function () {

    var lang = $(this).attr('data-lang');
    var id   = $(this).attr('data-id');
    $('#view_more').modal('show');

    var ajax_url = base_url + "well/view_well";
    send_ajax(ajax_url, 'post', {'id':id}, {answer: '.view_well_answer'});
});