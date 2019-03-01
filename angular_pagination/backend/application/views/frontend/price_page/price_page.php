<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>

<div id="login_modal" tabindex="-1" role="dialog" class="login-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body login_modal" id="forgot-modal-content">
                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="filter sec-price">
    <div class="container price_page">
        <div class="filter-block price-filter-block">
            <form class="filter-form order_proc_form" method="post" action="">

                <div class="country-part col-md-3">
                    <div class="form-group from-block">
                        <label class="pric_shipment_label">Your Shipment:</label>
                        <div class="sel-place ipad_device">
                            <span class="mobile_from_to_date">From:</span>
                            <?php if(empty($international)){ ?>
                                <span><?php echo (!empty($city_from))?$city_from:$country_from; ?></span>
                            <?php }else{  ?>
                                <span><?php echo $country_from; ?></span>
                            <?php } ?>
                        </div>
                        <div class="from_place pc_version_mobile">
                            <span >From:</span>
                        </div>
                        <div class="sel-place pc_version_mobile">

                            <span><?php echo $country_from; ?></span>
                            <span><?php echo $city_from; ?></span>
                        </div>
                    </div>


                    <div class="form-group to-block">

                        <div class="sel-place ipad_device">
                            <span class="mobile_from_to_date">To:</span>
                            <?php if(empty($international)){ ?>
                                <span><?php echo (!empty($city_to))?$city_to:$country_to; ?></span>
                            <?php }else{ ?>
                                <span><?php echo $country_to; ?></span>
                            <?php } ?>
                        </div>

                        <div  class="from_place pc_version_mobile">
                            <span>To:</span>
                        </div>
                        <div class="sel-place pc_version_mobile">
                            <span><?php echo $country_to; ?></span>
                            <span><?php echo $city_to; ?></span>
                        </div>
                    </div>
                    <div class="form-group date-block">
                        <span class="price_date_block"><span class="mobile_from_to_date">Date:</span> <span class="popover-style hidden-sm hidden-xs home-separate-pop" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                Pickup is available through Monday to Saturday. Also you can drop off your luggage 7 days a week at any of our drop off locations all over the world.
                " style="margin-right: 6px;"></span></span>
                        <div class="sel-place date_place">
                            <span><?php echo show_date($date); ?></span>
                        </div>
                    </div>

                    <div class="reset-back-place reset_back_button_div ">
                        <button type="button" class="btn btn-default btn-login-blue go_back">Edit</button>
                    </div>

                </div>
                <div class="items-part col-md-9">
                    <div class="row">

                        <div class="you-select">
                            <span class="select-item-title dis_none_for_300">Your Items</span>

                            <ul class="selected-items">
                                <?php

                                if(!empty($product)){
                                    foreach ($product as $key => $prods){

                                        $img = $prods['image'];
                                        unset($prods['image']); ?>

                                        <li>
                                            <div class="image-part">
                                                <!--<p><?php /*echo $key; */?></p>-->
                                                <i class="<?php echo $img;?>"></i>
                                            </div>
                                            <div class="text-part">
                                                <?php
                                                $all_count = 0;
                                                foreach ($prods as $name => $prod){
                                                    $all_count+=$prod;
                                                    ?>

                                                    <span><?php echo $prod. '&nbsp &nbsp'.$name; ?></span>



                                                <?php } ?>
                                            </div>
                                            <span class="luggage-count hidden-lg hidden-md"><?php echo $all_count; ?></span>
                                        </li>

                                    <?php } }?>

                            </ul>
                            <div class="reset-back-place ">
                                <p class="dis_none_for_300">Flexible shipping and storage solutions available, please call us at  <span class="blue-color"> 1-800-678-6167</span>.</p>
                            </div>
                        </div>

                        <div class="list-block ">

                            <?php

                            if(empty($international) && !empty($domestic)){?>

                                <span class="select-item-title">Delivery Date - Time & Services: <span data-html="true" class="popover-style home-separate-pop" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="
                                    <div class = 'title_class price_mobile_popover'>
                                    <p> If your delivery address is designated by the carrier as a <span class = 'hotline_text'>residential address </span> or a <span class = 'hotline_text'>remote area address, </span> the delivery time-frame will be adjusted to:</p>
                                    <h6>Morning delivery</h6>
                                    <span class = 'hotline_text'>8:30am to 1:00pm</span>
                                    <h6>Afternoon delivery</h6>
                                    <span class = 'hotline_text'>11:00am to 8:00pm</span>
                                     <h6>Standart 3 days</h6>
                                    <span class = 'hotline_text'>10:00am to 8:00pm</span>
                                    <p>if you have any questions, contact us at </p>
                                    <span class = 'blue-color'>1-800-678-6167.</span>
                                    </div>">
                                </span></span>
                            <?php }else if(empty($domestic) && !empty($international)){ ?>

                                <span class="select-item-title">Delivery Date - Time & Services:
                                     <span class="popover-style basic_popover hidden-sm hidden-xs home-separate-pop" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Delivery date for international shipping services is not guaranteed. package(s) may arrive before or after the estimated delivery date."></span>
                                     </span>
                            <?php } ?>


                            <ul class="service-list">
                                <?php
                                $week_array = [
                                    'mon' => 'Monday',
                                    'tue' => 'Tuesday',
                                    'wed' => 'Wednesday',
                                    'thu' => 'Thursday',
                                    'fri' => 'Friday',
                                    'sat' => 'Saturday',
                                    'sun' => 'Sunday',
                                ];

                                if(!empty($international)){

                                    $list_count = false;
                                    $currier_name = '';
                                    $number = 0;
                                    $shipment_class  = '';
                                    $shipment_class2 = '';

                                    foreach ($international as $key => $price){

                                        $class_count = '';

                                        if(count($price) == 1){
                                            $class_count = 'service_list_item_one';

                                        }else{
                                            $class_count = 'service_list_item_two';
                                            $list_count = true;
                                            $shipment_class2 = 'two_shipment2';
                                        }

                                        if (count($price) == 3){
                                            $class_count = 'service_list_item_three';
                                        }
                                        $number ++;

                                        $time = $config_times['international'];
                                        if($list_count && $class_count == 'service_list_item_one'){

                                            $shipment_class  = 'two_shipment';
                                            $shipment_class2 = 'two_shipment2';

                                        }
                                        ?>
                                        <li class="<?php echo $class_count; ?> <?php echo $shipment_class; echo ' '. $shipment_class2; ?>">
                                            <section>
                                                <?php
                                                foreach ($price as $index => $currier){
                                                    $popover = (stripos(explode('_',$currier['send_type'])[1], 'basic') !== false)?'<span class="popover-style basic_popover hidden-sm hidden-xs home-separate-pop" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Delivery date for basic services is not guaranteed, package may arrive before or after the estimated delivery date"></span>':'';
                                                    $currier_name = ucfirst (explode('_',$currier['send_type'])[1])." ".$currier['count']." Days";
                                                    ?>

                                                    <div class="ship-met">
                                                        <div>
                                                        <span class="text-center ship-icon first"><img src="<?php echo base_url()?>assets/images/<?php echo $currier['logo'];?>">
                                                            <?php
                                                            if($class_count == 'service_list_item_one'){ ?>

                                                                <input type="radio" class="ship_met pc_version_mobile homespan_change_price_page" data_time = "<?php echo $time; ?>" value="<?php echo $currier['curier']."->".$currier['send_type']; ?>" name="ship_met">

                                                            <?php }else{ ?>
                                                                <input type="radio" class="ship_met homespan_change_price_page" value="<?php echo $currier['curier']."->".$currier['send_type']; ?>" name="ship_met">
                                                            <?php }  ?>

                                                        </span>
                                                            <span class="price">$<?php echo $currier['price']; echo $popover; ?> </span>
                                                        </div>
                                                        <?php
                                                        if($class_count != 'service_list_item_one'){ ?>
                                                            <button type="button" class="btn btn-default btn-login-orange check_book data_<?php echo $number;?>" data-number = "data_<?php echo $number;?>">Book</button>
                                                        <?php }else if($class_count == 'service_list_item_one' && $list_count){ ?>
                                                            <button type="button" class="btn btn-default btn-login-orange check_book data_<?php echo $number;?>" data-number = "data_<?php echo $number;?>">Book</button>
                                                        <?php } ?>

                                                    </div>

                                                    <?php
                                                    $int_class = '';

                                                    if(!$list_count && $class_count == 'service_list_item_one'){

                                                        ?>
                                                        <button type="button" class="btn btn-default btn-login-orange check_book data_<?php echo $number;?> check_book_one" data-number = "data_<?php echo $number;?>">Book</button>
                                                    <?php  } ?>

                                                <?php }  ?>

                                            </section>
                                            <section>
                                                <div class="week-day">
                                                    <span><?php echo $week_array[$currier['weekday']]; ?></span>
                                                    <span class="orange-color"><?php echo show_date($key); ?></span>
                                                    <span><?php echo $currier_name;?></span>
                                                </div>
                                                <div class="time">
                                                    <?php echo $time; ?>
                                                </div>
                                            </section>

                                        </li>

                                    <?php }?>

                                <?php } ?>

                                <?php
                                if(!empty($domestic)){

                                    $number = 0;
                                    foreach ($domestic as $index => $dom){

                                        $class_count = '';
                                        $shipment_class  = '';
                                        $shipment_class2 = '';
                                        $shipment_class3 = '';

                                        if(count($dom) == 1){
                                            $class_count = 'service_list_item_one';
                                            $shipment_class2 = 'two_shipment2';
                                            $shipment_class3 = 'dom_img_no';

                                        }else{
                                            $class_count = 'service_list_item_two';
                                            $shipment_class  = 'two_shipment';
                                            $shipment_class2 = 'two_shipment2';

                                        }

                                        if (count($dom) == 3){
                                            $class_count = 'service_list_item_three';
                                        }

                                        $number ++;
                                        $names =  explode("_",$index);

                                        $currier_name =  $names[0]." ".$names[1]." ".$names[2];

                                        $popover = (stripos($currier_name, 'basic') !== false)?'<span class="popover-style hidden-sm hidden-xs home-separate-pop basic_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Delivery date for basic services is not guaranteed, package may arrive before or after the estimated delivery date"></span>':'';
                                        $time = $config_times['default'];

                                        if(in_array('morning', $names)){
                                            $time = $config_times['morning'];
                                        }

                                        if(in_array('afternoon', $names)){
                                            $time = $config_times['afternoon'];
                                        }

                                        if(end($names) == '+Sat'){

                                            $currier_name.=' + Sat';
                                            $time = $config_times['sat'];

                                        }else{

                                            if(in_array('afternoon', $names)){
                                                $currier_name = $currier_name.' PM';
                                            }

                                            if(in_array('morning', $names)){
                                                $currier_name = $currier_name.' AM';
                                            }

                                        }

                                        ?>
                                        <li class="<?php echo $class_count; ?>">
                                            <section>
                                                <?php foreach ($dom as $key => $prod){ ?>

                                                    <div class="ship-met">
                                                        <div class="<?php echo $shipment_class3; ?>">
                                                <span class="text-center ship-icon first"><!--<img src="<?php /*echo base_url()*/?>assets/images/<?php /*echo$prod['logo'];*/?>">-->
                                                    <?php
                                                    if($class_count == 'service_list_item_one'){ ?>

                                                        <input class="pc_version_mobile homespan_change_price_page" type="radio" value="<?php echo $key."->".$index; ?>" name="ship_met">

                                                    <?php }else{ ?>
                                                        <input class="homespan_change_price_page"  type="radio" value="<?php echo $key."->".$index; ?>" name="ship_met">
                                                    <?php }  ?>

                                                </span>
                                                            <span class="price">$<?php echo $prod['price']; ?></span>
                                                        </div>
                                                    </div>
                                                <?php  } ?>
                                                <?php
                                                $class_butt = '';

                                                if(count($dom) == 1){

                                                    $class_butt = 'check_book_one';
                                                }

                                                if(count($dom) == 1){ ?>
                                                    <button type="button" class="btn btn-default btn-login-orange check_book data_<?php echo $number;?>  <?php echo $class_butt;?>" data-number = "data_<?php echo $number;?>">Book</button>
                                                <?php } ?>
                                            </section>
                                            <section>
                                                <div class="week-day">
                                                    <span><?php echo $week_array[$prod['weekday']]; ?></span>
                                                    <span class="orange-color"><?php echo show_date($prod['date']); ?></span>
                                                    <span><?php echo $currier_name; echo $popover; ?></span>
                                                </div>
                                                <div class="time">
                                                    <?php echo $time; ?>
                                                </div>
                                            </section>
                                        </li>
                                    <?php  }  } ?>

                                <?php
                                if(empty($international) && empty($domestic)){ ?>
                                    <p>
                                        Service is not available now. Please check back later or <br> call us at <span class="blue-color"> 1-800-6786167.</span>
                                    </p>
                                <?php } ?>
                            </ul>

                        </div>
                    </div>
                    <div class="reset-back-place dis_none_for">
                        <p>Flexible shipping and storage solutions available, please call us at  <span class="blue-color"> 1-800-678-6167</span>.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="luggage-processing">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="sl-info sl-short sl-small">
                    <div class="sl-content">
                        <h4 class="">Tips</h4>
                    </div>
                </div>
                <div class="sl-info shipping_rates_info">
                    <ul class="short-line-height">
                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_information_do_I_need_know_before_checking_the_price');?>">What information do I need to know before checking the price?</a></li>
                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_do_I_measure_my_bag');?>">How do I measure my bag</a></li>
                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_if_Im_not_sure_of_the_weight_and_dimensions_of_my_luggage');?>">What if I'm not sure of the weight and dimensions of my luggage?</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="sl-info sl-short sl-small">
                    <div class="sl-content ">
                        <h4 class="">Tools</h4>
                    </div>
                </div>
                <div class="sl-info shipping_rates_info">
                    <ul class="short-line-height">
                        <li><a target="_blank" href="<?php echo base_url('luggage-weight');?>">Luggage size and weight calculator.</a> </li>
                        <li><a target="_blank" href="<?php echo base_url('luggage-drop-of-location');?>">Drop-off locator </a></li>
                        <li><a target="_blank" href="<?php echo base_url('how-to-pack-luggage');?>">How to pack your items</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
