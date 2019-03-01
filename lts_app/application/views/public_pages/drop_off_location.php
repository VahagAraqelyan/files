<div class="content drop_off_content">
    <div class="container ">
        <div class="block-section no-bg">
            <h1 class="cont-title upper-block">Find a Drop-off Location</h1>
            <div class="row">
                <div class="col-md-7">
                    <form class="form-horizontal" method="post" id="public_find_dropp_off_form">
                        <div class="form-sl">
                            <div class="form-group">
                                <label for="" class="col-sm-2 col-xs-12 control-label text-left">Location <span class="important">*</span> </label>
                                <div class="col-sm-4 col-xs-12 padding-right-0 padding-right-0 padding-for-mobile">
                                    <select class="form-control selectpicker select-country" id="country_from" name="country_id">
                                        <?php
                                        if(!empty($all_country)){

                                            foreach ($all_country as $index => $value){
                                                $k = ($value["id"] == $selected['country'])?"selected = 'selected'":"";
                                                ?>
                                                <option <?php echo $k; ?> value="<?php echo $value['id']; ?>"><?php echo $value['country']; ?></option>
                                            <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-12 padding-right-0 padding-for-mobile">
                                    <input type="text" class="form-control filter_control search_zip_code last_zip" data_name = "City From" autocomplete="off" name="zip_code" id="city_from" data-country="country_from" placeholder="Zip Code or City" data_targets = 'From zipcode' value="<?php echo $selected['zip_code']; ?>">
                                    <img src="<?php echo base_url(); ?>assets/images/load.gif" id="load1">
                                    <div id="city_from_div"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-sl">
                            <div class="form-group">
                                <label for="" class="col-sm-2 col-xs-12 control-label text-left">Carrier <span class="important">*</span></label>
                                <?php
                                foreach($all_carriers as $single){

                                    if($single['currier_name'] == 'UPS'){
                                        continue;
                                    }
                                    $k = '';
                                    if(strtolower($single['currier_name']) == strtolower($selected['carrier'])){
                                        $k = 'checked="checked"';
                                    }
                                    ?>
                                    <div class="col-sm-4 col-xs-12 padding-right-0 padding-for-mobile <?php echo strtolower($single['currier_name'])?>_pub_page">
                                        <div class="ship-met ">
                                         <!--
                                            <div>
                                                    <span class="text-center ship-icon first"><input  type="radio" id="fedex" value="<?php echo $single['currier_name']; ?>"  class="currier" name="currier" <?php echo $k; ?>> <img src="<?php echo base_url('assets/images/'.strtolower($single['currier_name']).'-mid.png'); ?>"></span>
                                                    <div class="control_indicator"></div>
                                            </div>
                                          -->
                                            <div class="options">
                                                <label class="item1">
                                                   <input  type="radio" id="fedex" value="<?php echo $single['currier_name']; ?>"  class="currier" name="currier" <?php echo $k; ?>>

                                                    <img class="radio-img" />
                                                </label>
                                                <div class="fedex_dhl_img">
                                                    <img src="<?php echo base_url('assets/images/'.strtolower($single['currier_name']).'-mid.png'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-sl">
                            <div class="form-group">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="button" class="orange-button-style-second" id="public_find_drop_off">Find a drop off location</button>
                                    <!--<p class="all-results"><a href="" class="blue-color">See All Results</a></p>-->
                                </div>
                            </div>
                        </div>
                        <div id="message_div">
                            <h4><?php echo $message; ?></h4>
                        </div>
                        <?php
                        if($action !== 'google' && !empty($selected['zip_code']) && !empty($selected['carrier']) && !empty($selected['country'])){

                            $new_xml = str_ireplace("'","\'",json_encode($xml));
                            ?>
                            <div id = "info" class="mobile_version_dropoff">
                                <?php
                                if($action){
                                    foreach($loc_info as $index => $single){
                                        ?>
                                        <div id="<?php echo 'location-'.$index; ?>" class="col-md-12 col-sm-12 col-xs-12 location-box" data-id="<?php echo $index; ?>">
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <img  src="<?php echo base_url('assets/images/'.$store_type.'.png'); ?>">
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 text-left">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <span class="title"><?php echo $single['name']; ?></span>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12 address" data-class="sender_pickup_address"><?php echo $single['street'].' '.$single['city'].' '.$single['state']; ?></div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12 phone_number">Phone: <?php echo $single['phone']; ?></div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12 last_pickup">
                                                        <ul class="last-pickup-indicator">
                                                            <li><span></span><?php echo $single['time_gr']?></li>
                                                            <li><span></span><?php echo $single['time_ai']?></li>
                                                        </ul>
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
                                var xml = '<?php echo $new_xml; ?>';
                                var lat = <?php echo $lat; ?>;
                                var lng = <?php echo $lng; ?>;
                                var loc_info = <?php echo $loc_info; ?>;
                            </script>
                        <?php } ?>
                    </form>
                </div>
                <div id="create_shipment_div" class="dis_none">
                    <div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>
                </div>
                <div class="col-md-5">
                    <div class="show-map shadow-box" id="public_page_find_dropp_off_answer" style="width:100%;">
                        <!-- Added code-->
                        <?php
                        if($action === 'google'){
                            ?>
                            <iframe  frameborder="0" style="border:0" width="100%" height="500px"
                                     src="<?php echo $url; ?>" allowfullscreen>
                            </iframe>
                        <?php } else{
                            ?>
                            <div id="map" style="width: 100%;"></div>
                            <?php
                        }?>
                        <!-- end code-->
                    </div>
                    <h4 class="min-title">Tips</h4>
                    <div class="sl-info small-sl-info">
                        <ul class="short-line-height">
                            <li>Make sure to match the carrier on your label with the drop-off location.</li>
                            <li>Check carrier’s daily cut off time of your service with the drop-off location.</li>
                            <li>Ask for free label pouches, luggage tags and cable ties at the drop off location. You need show the prepaid shipping labels we sent you to get free shipping materials.</li>
                            <li>Have all shipping document ready before drop-off. Correctly pack, label and lock your luggage/case/bag/box</li>
                            <li>Take a picture of your luggage with shipping label</li>
                            <li>Ask for a drop-off receipt before leaving the drop-off location</li>
                        </ul>
                        <p class="map-desc">Please be advised the drop-off location is not able to provide the shipping price we offered you.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade error-modal" id="zip_code_error" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header home_modal_header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Wrong Information</h4>
            </div>
            <div class="modal-body">
                <div class="wrong_zip">
                    <p>Please check and put the correct:</p>
                    <p class="red-color">Country, Zip code</p>
                    <ul class="wrong_zip_error">
                        <li>
                            <span>If you are shipping to / from Puerto Rico or US Virgin Islands, please select Puerto Rico or Virgin Islands US.</span>
                        </li>
                        <li>
                            <span>Currently we are not able to ship to / from military bases.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="drop_off_map" role="dialog">
    <div class="modal-dialog drop_off_locator">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="drop_off_content">

            </div>

        </div>

    </div>
</div>


<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="register-block no-hide up_modal">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="register-title text-center lovercase">Missing information</h2>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    var customLabel = {

        ups: {
            label: '',
            icon: 'https://www.luggage2ship.com/assets/images/ups-pin.png'
        },

        fedex: {
            label: '',
            icon: 'https://www.luggage2ship.com/assets/images/fedex-pin.png'
        }

    };

    function initMap1(xml, lat, lng) {

        google_markers = [];

        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(lat, lng),
            zoom: 1
        });

        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        $('#xml').html(xml);

        markers = document.getElementsByTagName('marker');
        var i = 0;

        Array.prototype.forEach.call(markers, function(markerElem) {

            var name = markerElem.getAttribute('name');
            var address = markerElem.getAttribute('address');
            var type = markerElem.getAttribute('type');
            var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng')));
            var phone = markerElem.getAttribute('phone');
            var l_pickup_green = markerElem.getAttribute('last_pickup_green');
            var l_pickup_orange = markerElem.getAttribute('store_closes');
            var infowincontent = document.createElement('div');
            var strong = document.createElement('strong');
            strong.textContent = name;
            infowincontent.appendChild(strong);
            infowincontent.appendChild(document.createElement('br'));

            var text = document.createElement('text');
            text.textContent = address;
            infowincontent.appendChild(text);
            var icon = customLabel[type] || {};
            var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label,
                icon: icon.icon,
                index:i
            });

            marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.setContent('<div><strong>' + name + '</strong><br>' +
                    address + '</div>'+'' +
                    'phone: '+phone+'' +
                    '<ul class="last-pickup-indicator">' +
                    '<li><span></span>Last Pickup '+l_pickup_green+'</li>' +
                    '<li><span></span>Last Pickup '+l_pickup_orange+'</li>' +
                    '</ul>');
                infoWindow.open(map, marker);
            });

            google.maps.event.addListener(marker, 'click', function() {

                marker.setAnimation(google.maps.Animation.BOUNCE);
                setTimeout(function(){ marker.setAnimation(null); }, 5000);

                var index = marker.index;

                $('#info').animate({scrollTop: $('#location-'+index).offset().top - ($('#info').offset().top - $('#info').scrollTop())}, 'slow');

                $('#location-'+index).siblings().removeClass('listItemSelect');

                $('#location-'+index).addClass('listItemSelect');

            });

            google_markers.push(marker);
            i++;

        });

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < google_markers.length; i++) {
            bounds.extend(google_markers[i].getPosition());
        }

        map.fitBounds(bounds);

        if(typeof(xml) == 'undefined' || typeof(lat) == 'undefined' || typeof(lng) == 'undefined'){

            map.panTo(new google.maps.LatLng(38.019469,-100.652838));

        }
        
    }

    window.onload = function(){

        if(typeof(xml) != 'undefined' || typeof(lat) != 'undefined' || typeof(lng) != 'undefined'){

            initMap1(xml, lat, lng);

        }else{

            initMap1(undefined, undefined, undefined);
        }

    }

</script>
