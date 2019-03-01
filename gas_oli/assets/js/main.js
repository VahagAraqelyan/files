console.log(action);
socket = io.connect("https://oil.myworks.site:3000", {secure: true});

var crew_action = action.split('->');

if(crew_action[0] == 'crew' && (crew_action[1] != 'crew_login' || crew_action[1] != 'activity_password') ){

    var url = base_url + "crew/ax_get_socket_id";
    send_ajax(url, 'post', {}, {handler:'socket_id_handler'});

    function socket_id_handler(data) {

        var obj = $.parseJSON(data);

        socket.emit('new_key',{'crew_id':obj['crew_id'], 'socket_id':socket.id})
    }

}

socket.on('admin_map',function (data) {

    navigator.geolocation.getCurrentPosition(function(position){

        socket.emit('latlng',{'lat': position.coords.latitude, 'lng' : position.coords.longitude,'key':socket.id});
    });

});

if(action == 'crew->activity_password'){

    $('#update_password').click(function () {
        var add_steersman_fields  = {
            options:{selector:'.show_error', single:false, form_id:'#activity_password_form'},
            password:{errorname:'Password', single:false, minlength:8, required: true },
            rectype_password:{errorname:'Retype Password', required: true, equalTo:'password'}
        };

        var validation = new validation_lib(add_steersman_fields);

        if(!validation.validate_field()){

            return false;
        }

        var data = $('#activity_password_form').serializeArray();

        var url = base_url + "crew/save_activity_password";
        send_ajax(url, 'post', data, {handler:'save_activity_password_handler'});
    });

    function save_activity_password_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length != 0){
            alert(obj['errors']);

        }else{
            location.replace(base_url+'crew/');
        }

        $('.activity_pass').val('');
    }
}

if(action == 'crew->filter' || action == 'crew->index'){

    $.cookie("filter", null, { path: '/' });


    $('.company_filter').click(function () {

        if( $(this).next().prop('checked') == false){
            $(this).next().prop('checked',true);
            $(this).addClass('active');
        }else{

            $(this).next().prop('checked',false);
            $(this).removeClass('active');
        }

    });

    $(document).on('click','.filter_state',function () {

        if( $(this).next().prop('checked') == false){

            $(this).next().prop('checked',true);
            console.log( $(this));
            $(this).addClass('state_active');

        }else{

            $(this).next().prop('checked',false);
            $(this).removeClass('state_active');
        }
    });

    $('#next_filter').click(function () {

        var company_checkboxes = $('.company_checkbox');
        var filter_checkboxes = $('.filter_state_checkbox');

        var company_filter_arr = [];
        var filter_checkboxes_arr = [];

        $.cookie("filter", null, { path: '/' });

        $.each(company_checkboxes, function( index, value ) {

            if($(value).prop('checked') != true){
                return;
            }

            company_filter_arr.push($(value).val());

        });


        $.each(filter_checkboxes, function( index, value ) {
            if($(value).prop('checked') != true){
                return;
            }
            filter_checkboxes_arr.push($(value).val());
        });

        if(filter_checkboxes_arr.length == 0 || company_filter_arr.length == 0){

            alert('Please set company and state');
            return false;
        }

        var lat = 0;
        var lng = 0;

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position){

                lat = position.coords.latitude;
                lng = position.coords.longitude;

                var data = {company_filter:company_filter_arr,state_filter:filter_checkboxes_arr,locat:{'lat':lat,'lng':lng}};

                $.cookie('filter',JSON.stringify(data),{ path: '/' });
                location.replace(base_url + "crew/main_search");
            });

        }else{
            var data = {company_filter:company_filter_arr,state_filter:filter_checkboxes_arr,locat:{'lat':lat,'lng':lng}};
            console.log(data);
            $.cookie('filter',JSON.stringify(data),{ path: '/' });
            location.replace(base_url + "crew/main_search");
        }


    });

    function ax_next_filter_handler() {

        location.replace(base_url+'crew/main_search');
    }

}

$('ul.nav li').click(function () {
    $( this ).parent().find( 'li.active' ).removeClass( 'active' );
    $( this ).addClass( 'active' );
});

$('.rad-toggle-btn').click(function () {
    $('aside').toggle(300);
    $('.content').toggleClass('content_width');
});


/*socket.on('initMap',function (data) {



});*/

if(action == 'crew->main_search'){

    (function(){

        var customLabel = {
            ph: {
                label: '',
                icon: ''+base_url+'assets/images/maps-and-flags-black.png'
            }
        };

        initMap();

        function initMap() {

            var locations = $.parseJSON(main_search_arr);

            if(locations.length == 0){
                return false;
            }

            locations[0]['lat'] =  locations[0]['lat'].replace(/,/gi, ".");
            locations[0]['lng'] =  locations[0]['lng'].replace(/,/gi, ".");

             crew_map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: new google.maps.LatLng(parseFloat(locations[0]['lat']), parseFloat(locations[0]['lng'])),
                mapTypeId: 'satellite'
            });

            var infowindow = new google.maps.InfoWindow();

            var icon = customLabel || {};

            var  marker, i, id;
            crew_map_marker = {};

            for (i = 0; i < locations.length; i++) {

                locations[i]['lat'] =  parseFloat(locations[i]['lat'].replace(/,/gi, "."));
                locations[i]['lng'] =  parseFloat(locations[i]['lng'].replace(/,/gi, "."));

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
                    map: crew_map,
                    icon: customLabel.ph.icon
                });

                google.maps.event.addListener(marker, "click", (function (marker, i) {
                    return function () {
                        infowindow.setContent('' +
                            '<h2>'+locations[i]['name']+'</h2>' +
                            '<p>'+locations[i]['location']+'</p>' +
                            '<p>'+locations[i]['well_id']+'</p>' +
                            '');
                        infowindow.open(crew_map, marker);
                    }
                })(marker, i));

                crew_map_marker[locations[i]['lat']+'|'+locations[i]['lng']] = marker;
            }

            $(document).on('click','.well_inf',function () {
                var number = $(this).attr("data-index");

                crew_map.setCenter({
                    lat: parseFloat(locations[number]['lat']),
                    lng: parseFloat(locations[number]['lng'])
                });
            });
        }
    })();

    $(document).ready(function () {

        var short = $.parseJSON(short_well);
        short = short[0];

        $('[data-id = '+short['id']+']').trigger('click');
    });

    $(document).on('click','.designatet_place',function () {

        well_lat = $(this).attr('data-lat');
        well_lng = $(this).attr('data-lng');

        if (navigator.geolocation) {

            designated_setinterval =  setInterval(function () {

                navigator.geolocation.getCurrentPosition(function(position){
                    socket.emit('crew_latlng',{'lat': position.coords.latitude, 'lng' : position.coords.longitude,'well_lat':well_lat,'well_lng':well_lng,'key':user_id});
                });

            },800);

        }

        $(this).attr('class','end_road');
        $('.end_road').html('End');
    });


    $(document).on('click','.end_road',function () {

        well_lat = $(this).attr('data-lat');
        well_lng = $(this).attr('data-lng');


        // in Server Code
       if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(position){

                if(well_lat != position.coords.latitude && well_lng !=   position.coords.longitude){

                    //alert("You haven't reached to the mentioned point yet");
                }else{
                    $('#change_status_modal').modal('show');
                }
            });
        
        }else{
            $('#change_status_modal').modal('show');
        }

        $('#change_status_modal').modal('show');
    });

    $(document).on('change','.chage_well_status',function () {

        var status  = $(this).val();

        if(status > 4){
            alert('No status available');
            return false;
        }

        var short = $.parseJSON(short_well);
        short = short[0];

        var url = base_url + "crew/ax_change_well_status";
        //send_ajax(url, 'post', {'well_id':short['id'],'status':status}, {});

        navigator.geolocation.getCurrentPosition(function(position){

            var ajax_data = {'lat': position.coords.latitude,'lng' : position.coords.longitude};

            var url = base_url + "crew/ax_get_new_well";
            send_ajax(url, 'post', ajax_data, {handler:'get_new_well_handler'});
        });
    });

    function get_new_well_handler(data){

        var obj = $.parseJSON(data);

        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        var directionsService = new google.maps.DirectionsService;

        var short = $.parseJSON(short_well);
        short = short[0];

        short['lat'] =  parseFloat(short['lat'].replace(/,/gi, "."));
        short['lng'] =  parseFloat(short['lng'].replace(/,/gi, "."));


        var color = {'4':'yellow','3':'blue'};

        var stat =  $('.chage_well_status');
         var status = 0;

        $.each(stat, function( index, value ) {

            if($(value).prop('checked') != true){
                return;
            }

            status = $(value).val();
        });

        crew_map_marker[short['lat']+'|'+short['lng']].setMap(null);

        var old_marker = new google.maps.Marker({
            position: new google.maps.LatLng(short['lat'], short['lng']),
            map: crew_map,
            icon: base_url+'assets/images/maps-and-flags-'+color[status]+'.png'
        });

        directionsDisplay.setMap(crew_map);
        old_marker.setMap(crew_map);



        var url = base_url + "crew/ax_change_well_status";
        //send_ajax(url, 'post', {'well_id':obj['id'],'status':2}, {});

        $('[data-id = '+obj['id']+']').attr('class','end_road');
        $('.end_road').html('End');

        short_well = short;
        $('#change_status_modal').modal('hide');

        navigator.geolocation.getCurrentPosition(function(position){
            console.log(position.coords);
            calculateAndDisplayRoute(directionsService, directionsDisplay, position.coords.latitude,position.coords.longitude, obj['lat'], obj['lng'],'maps-and-flags-black.png');
        });
    }

    socket.on('crew_road',function (data) {

        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
        var directionsService = new google.maps.DirectionsService;

        directionsDisplay.setMap(crew_map);

        var short = $.parseJSON(short_well);
        short = short[0];

        var url = base_url + "crew/ax_change_well_status";
        //send_ajax(url, 'post', {'well_id':short['id'],'status':2}, {handler:'change_status_handler'});

        $('[data-id = '+short_well['id']+']').attr('class','end_road');
        $('.end_road').html('End');

        calculateAndDisplayRoute(directionsService, directionsDisplay,data['latlngs']['lat'],data['latlngs']['lng'],data['latlngs']['well_lat'],data['latlngs']['well_lng'],'maps-and-flags-black.png');
    });

    function change_status_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length >0){
            return false;
        }

        $.cookie('short_well',JSON.stringify(obj['well']));
    }

    function calculate_distance(lat1, lon1, lat2, lon2){
        return false;
        var R, a, c, d, dLat, dLon;
        R = 6371;
        dLat = (lat2 - lat1).toRad();
        dLon = (lon2 - lon1).toRad();
        a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        d = R * c;
        return d;
    }

    Number.prototype.toRad = function() {
        return this * Math.PI / 180;
    };

    function calculateAndDisplayRoute(directionsService, directionsDisplay,crew_lat,crew_lng,well_lat,well_lng,icon_name) {


        var icons = {
            start: new google.maps.MarkerImage(
                // URL
                base_url+'assets/images/crew_icon.png'

            ),
            end: new google.maps.MarkerImage(
                // URL
               base_url+'assets/images/'+icon_name

            )
        };

        directionsService.route({
            origin: new google.maps.LatLng(parseFloat(crew_lat),parseFloat(crew_lng)),
            destination: new google.maps.LatLng(parseFloat(well_lat),parseFloat(well_lng)),
            travelMode: google.maps.TravelMode['DRIVING','TRANSIT','WALKING']
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
            map: crew_map,
            icon: icon,
            title: title
        });
    }
}

if(action == 'crew->crew_login'){

    $('#crew_login_butt').click(function () {

        var add_steersman_fields  = {
            options:{selector:'.show_error', form_id:'#crew_login_form'},
            email:{errorname:'Username', required: true, emailvalid:true},
            password:{errorname:'Password', required: true}
        };

        var validation = new validation_lib(add_steersman_fields);

        if(!validation.validate_field()){

            return false;
        }

        var data = $('#crew_login_form').serializeArray();

        var url = base_url + "crew/ax_check_login";
        send_ajax(url, 'post', data, {handler:'ax_check_login_handler'});

    });

    function ax_check_login_handler(data) {

        var obj = $.parseJSON(data);

        if(obj['errors'].length != 0){

            alert(obj['errors'][0]);

        }else{

         /*   socket.emit('crew_login',{'crew_id':obj['crew_id'], 'socket_id':socket.id});*/
            location.replace(base_url+'crew/');
        }
    }
}