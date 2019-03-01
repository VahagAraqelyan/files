
<?php
if(!empty($international)){ ?>
<!--    <div class="pc_version_mobile">
        <div id="inter_drop_off" >
            <table>
                <tr>
                    <td>
                        <span>Location</span>
                    </td>
                    <td>
                        <span><?php /*echo $country_info['country']; */?></span>
                        <input type="hidden" class="form-control selectpicker select-country" id="country_from" name="country_id" value="<?php /*echo $country_id; */?>">
                    </td>
                    <td>
                        <input type="text" class="form-control filter_control search_zip_code last_zip new_zip_input" data_name = "City From" autocomplete="off" name="zip_code" id="city_from" data-country="country_from" placeholder="Zip Code or City" data_targets = 'From zipcode' value="<?php /*echo (!empty($zip_code))?$zip_code:''; */?>">
                        <img src="<?php /*echo base_url(); */?>assets/images/load.gif" id="load1">
                        <div id="city_from_div"></div>
                    </td>
                    <td>
                        <?php /*if(!empty($carrier_info)){ */?>
                            <img src="<?php /*echo base_url('assets/images/'.strtolower($carrier_info['currier_name']).'.png'); */?>">
                        <?php /*} */?>
                    </td>
                    <td>
                        <button type="button" id="find_drop_off_inter" class="btn btn-default btn-login-orange">Find Drop off Location</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>-->

    <div class="col-md-12">
        <div id="inter_drop_off" class="col-md-12 ">
            <div  class="col-md-1"> <span>Location</span></div>
            <div  class="col-md-2">
                <span><?php echo $country_info['country']; ?></span>
                <input type="hidden" class="form-control selectpicker select-country" id="country_from" name="country_id" value="<?php echo $country_id; ?>"></div>
            <div  class="col-md-3">
                <input type="text" class="form-control filter_control search_zip_code last_zip new_zip_input" data_name = "City From" autocomplete="off" name="zip_code" id="city_from" data-country="country_from" placeholder="Zip Code or City" data_targets = 'From zipcode' value="<?php echo (!empty($zip_code))?$zip_code:$postal_code; ?>">
                <img src="<?php echo base_url(); ?>assets/images/load.gif" id="load1">
                <div id="city_from_div"></div>
            </div>
            <div  class="col-md-1">
                <?php if(!empty($carrier_info)){ ?>
                    <img src="<?php echo base_url('assets/images/'.strtolower($carrier_info['currier_name']).'.png'); ?>">
                <?php } ?>
            </div>
            <div  class="col-md-3">
                <button type="button" id="find_drop_off_inter" class="btn btn-default btn-login-orange">Find Drop off Location</button>
            </div>
        </div>
    </div>

<?php
}else{
    ?>
        <h5 id="drop_off_header"><?php echo (!empty($carrier_info['currier_name']))?$carrier_info['currier_name'].' ':''; ?>Drop off Location <?php echo $country_info['country']; ?></h5>
    <?php
}

if(empty($info) && $action !== 'google' && !empty($international)){
    ?>
    <span class = 'error_span error_drop_off_span'>
                Unable to find a nearby drop off location,<br>
                please check and put the correct city<br>
                name or postal code.<br>
                Please reach out us at 1-800-678-6167 for<br>
                your drop off requirements
            </span>
    <?php
    exit();
}

if($action === 'google'){
    $style = '';

}else{
    $style = 'display: inherit';
}

?>
<div id="map_div" style="<?php echo $style; ?>;">
<?php
if($action === 'google'){

    if(empty($lat) || empty($lng)){

        $zoom = 6;

    }else{
        $zoom = 12;
    }

    if($order_info['shipping_status'] < PROCESSED_STATUS[0]){ ?>

        <script>
            var use_address = '<div><a href="#" class="btn btn-default btn-file select-doc-file fill_butt fill_butt_dhl">Use this address as origin address</a></div>';
        </script>

   <?php }else{ ?>
        <script>
            var use_address = '';
        </script>
   <?php }

    ?>
    <div id="dhl_map">

    <script>
        var map;
        var infowindow;

        function initMap() {
            var pyrmont = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>);

            map = new google.maps.Map(document.getElementById('map'), {
                center: pyrmont,
                zoom: <?php echo $zoom;?>
            });

            var request = {
                location: pyrmont,
                radius: '150',
                query: '<?php echo $search;?>'
            };

            service = new google.maps.places.PlacesService(map);
            service.textSearch(request, callback);
           infowindow = new google.maps.InfoWindow();
        }

        function callback(results, status) {

            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location

            });

             address     = '';
             city        = '';
             state       = '';
             zip         = '';
            temp_address = '';


            map.setCenter(place.geometry.location);

            google.maps.event.addListener(marker, 'click', function() {
                service.getDetails(place, function(result1, status) {
                    if (status !== google.maps.places.PlacesServiceStatus.OK) {
                        console.log(status);
                        return;
                    }

                    var components = result1.address_components;

                    for (var i = 0, component; component = components[i]; i++) {

                        if (component.types[0] == 'route') {

                            address = component['long_name'];

                        }else if( component.types[0] == 'neighborhood'){
                            ddress = component['long_name'];
                        }

                        if (component.types[0] == 'postal_code') {

                            zip = component['long_name'];
                        }

                        if (component.types[0] == 'locality' || component.types[0] == 'administrative_area_level_3') {

                            city = component['long_name'];
                        }

                        if (component.types[0] == 'street_number') {

                            temp_address = component['long_name'];
                        }

                        if (component.types[0] == 'administrative_area_level_1') {

                            state = component['long_name'];
                        }
                    }

                    if(typeof(result1['formatted_phone_number']) == 'undefined'){

                        var phone_number = '';

                    }else{
                        var phone_number = 'Phone number:' + result1['formatted_phone_number'];
                    }

                    infowindow.setContent('<div><strong>' + place.name +'</strong><br>'
                        + temp_address + ' ' + address + ' ' + city +  ' ' + ' ' + state +  ' ' + zip + '</div>'+''
                        + '<div> ' +phone_number+'</div>'
                        + use_address
                    );
                });


                infowindow.open(map, this);
            });
        }
    </script>

    <div id="map"></div>
    </div>
</div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU&libraries=places&callback=initMap" async defer></script>

<?php

} else{ ?>

    <div id="map"></div>
    <div id = "info" style="display: list-item" >

        <?php

        if(!$action){ ?>
            <span class = 'error_span'>
                Unable to find a nearby drop off location,<br>
                please check and put the correct city<br>
                name or postal code.<br>
                Please reach out us at 1-800-678-6167 for<br>
                your drop off requirements
            </span>
            <?php
        }else{

            foreach($info as $index => $single){
                ?>
                <div id="<?php echo 'location-'.$index; ?>" class="col-md-12 col-sm-12 col-xs-12 location-box mobile_version_dropoff" data-id="<?php echo $index; ?>">
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <img src="<?php echo base_url('assets/images/'.$store_type.'.png'); ?>">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-left">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <span class="title"><?php echo $single['name']; ?></span>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 address dropp_off_address" data-class="sender_pickup_address"><?php echo $single['street'].' '.$single['city'].' '.$single['state']; ?></div>
                            <div class="col-md-12 col-sm-12 col-xs-12 phone_number">Phone: <?php echo $single['phone']; ?></div>
                            <div class="col-md-12 col-sm-12 col-xs-12 last_pickup">
                                <ul class="last-pickup-indicator">
                                    <li><span></span><?php echo $single['time_gr']?></li>
                                    <li><span></span><?php echo $single['time_ai']?></li>
                                </ul>
                                <?php
                                if($order_info['shipping_status'] < PROCESSED_STATUS[0]){
                                ?>
                                <button type="button" id="use_address" data-address="<?php echo $single['street'].'_|'.$single['city'].'_|'.$single['state'].'_|'.$single['zip_code']; ?>" class="btn btn-default btn-login-blue apply-promotion">Use this address as origin address</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <br><span class="distance"><?php echo $single['dist']; ?> mi <img class="location-icon" src="<?php echo base_url('assets/images/location-icon.png'); ?>"></span>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div id="xml" style = 'display:none;'></div>
    <script>
        var xml = '<?php echo str_ireplace("'","\'",json_encode($xml)); ?>';
        var lat = <?php echo $lat; ?>;
        var lng = <?php echo $lng; ?>;
        initMap(xml, lat, lng);


    </script>
<?php } ?>
</div>
<!--  var lat_dhl = <?php /*echo $lat;*/?>;
var lng_dhl = <?php /*echo $lng;*/?>;
var search = '<?php /*echo $search */?>';
var zoom = <?php /*echo $zoom */?>;
init_map_dhl(lat_dhl,lng_dhl,search,zoom);-->