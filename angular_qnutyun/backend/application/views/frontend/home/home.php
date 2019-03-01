<?php
if(!empty($this->input->cookie('order'))){

    $selected_order = $this->input->cookie('order');
    $selected_order = json_decode($selected_order);

    if(!empty($selected_order->country_from)){
        $country_from = $selected_order->country_from;
    }

    if(!empty($selected_order->country_to)){
        $country_to   = $selected_order->country_to;
    }

    if(!empty($selected_order->luggage)){
        $temp_luggage = (array)$selected_order->luggage;
    }

}
?>
<div class="modal fade error-modal" id="error" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header home_modal_header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Missing Information</h4>
            </div>
            <div class="modal-body">
               <div class="from_date">

               </div>
                <div class="shiping_date">

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
                        <li>
                            <span>Currently we are not able to ship to / from Alaska and Hawaii remote areas.</span>
                        </li>
                    </ul>
                    <p>
                        Please call us at <span class="blue-color">1800 678 6167</span> if you have any question on quotation. Thanks.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<section class="filter">
    <div class="container">
        <div class="filter-block">
            <form class="filter-form" method="post" action="" id="home_filter_form">
                <div class="country-part col-md-3">
                    <div class="form-group from-block">
                        <label for="country_from">From:
                            <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="click" data-placement="top"
                                  data-content="
                                  Please put and select the country and zip code (or city) you are shipping from. Zip code (or city) is not required for international shipment quotation.
                            "></span>
                        </label>
                        <select class="home_select_country select-country" name="country_from" id="country_from" data-input="city_from" >
                            <?php
                            foreach ($countries as $index => $country){

                                if(!empty($country_from)){
                                    $k = ($country["id"] == $country_from)?"selected = 'selected'":"";
                                }else{
                                    $k = ($country["country"] == 'United States (USA)')?"selected = 'selected'":"";
                                }

                                ?>
                                <option value="<?php echo $country["id"] ?>" <?php echo $k; ?> ><?php echo $country["country"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input aria-autocomplete="none" autocoplete="sasas" onautocomplete="false" type="text" class="form-control filter_control search_zip_code last_zip" data_name = "City From" autocomplete="off" name="city_from" id="city_from" data-country="country_from" placeholder="Zip Code or City" data_targets = 'From zipcode'>
                        <img src="<?php echo base_url(); ?>assets/images/load.gif" id="load1" alt="From Loader">
                        <div id="city_from_div"></div>
                    </div>
                    <div class="form-group to-block">
                        <label for="country_to">To:
                            <span class="popover-style home-separate-pop home_popover_top" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="click" data-placement="top"
                                  data-content="
                                  Please put and select the country and zip code (or city) you are shipping to . <span class=''>Zip code (or city) is not required for international shipment quotation.</span>
                            "></span>
                        </label>
                        <select class="home_select_country " name="country_to" id="country_to" data-input="city_to">
                            <?php
                            foreach ($countries as $index => $country){

                                if(!empty($country_from)){
                                    $k = ($country["id"] == $country_to)?"selected = 'selected'":"";
                                }else{
                                    $k = ($country["country"] == 'United States (USA)')?"selected = 'selected'":"";
                                }

                                ?>
                                <option value="<?php echo $country["id"] ?>"  <?php echo $k; ?> ><?php echo $country["country"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input aria-autocomplete="none" autocoplete="sasasas" onautocomplete="false" type="text" class="form-control filter_control search_zip_code last_zip" data_name = "City To" autocomplete="off" name="city_to" id="city_to" data-country="country_to" placeholder="Zip Code or City" data_targets = 'To zipcode'>
                        <img src="<?php echo base_url(); ?>assets/images/load.gif" id="load2" alt="To Loader">
                        <div id="city_to_div"></div>
                    </div>
                    <div class="form-group date-block">
                        <label for="">Shipping Date: <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="click" data-placement="top"
                        data-content="<div class = 'date_popover_content'><span >Your luggage can be picked up by our carrier or dropped off at a carriers location. Pick up services are not available Sundays and holidays. FedEx Saturday pick-up services are available for express shipments within the United States. If your shipment Is dropped off after the cut-off time of the courier business hours. your package will be shipped out the next business day.</span></div
                "></span></label>
                        <input type="text" class="form-control shipping-date filter_control" onfocus="blur();" name="shipping_date" id="shipping_date" placeholder="Select date" data_targets = 'Shipping date'>
                    </div>

                </div>

                <div class="items-part col-md-9">
                    <span class="select-item-title">Select item(s):
                    <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="click" data-placement="top"
                          data-content="
                          1) Please click the blue icons below to see different types of items.
                          2) Please select the item quantity from the drop down list under various sizes of each item.
                "></span>
                    </span>
                    <ul class="nav nav-tabs select-items box_list" role="tablist">
                        <?php
                        foreach($luggages_array as $type_id=>$label){
                            $i_class = ($type_id == 7)?'bike_class':'';
                            $active=($label['type_name'] == 'Luggage')?"class='active'":"";
                            ?>
                            <li role="presentation" <?php echo $active; ?>>
                                <a href="#blok<?php echo $type_id; ?>" class="text-center" aria-controls="<?php echo $label["type_name"]; ?>" role="tab" data-toggle="tab"><i class="<?php echo $label["type_icon_class"]; ?>" id="<?php echo $i_class;?>"></i><?php echo $label["type_name"]; ?></a>
                                <span class="#blok<?php echo $type_id; ?>-count home_page_blocks">-0-</span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
                        foreach($luggages_array as $type_id=>$label){

                            $active=($label['type_name'] == 'Luggage')?" active":"";

                            ?>
                            <div role="tabpanel" class="tab-pane sizes<?php echo $active; ?>" id="blok<?php echo $type_id; ?>">

                                <?php if($label['type_name'] == 'Boxes'){ ?>
                                <div class="boxes-blocks">
                                    <div class="col-md-6 col-xs-12 no_padding_mobile">
                                        <?php } ?>

                                        <ul class="<?php echo $label["ul_class"]; ?>">
                                            <?php
                                            foreach($label["luggages"] as $luggage_id => $luggage_info){

                                                ?>
                                                <li class="<?php echo $luggage_info["li_class"]; ?>">
                                                    <div class="<?php echo $label["img_box_class"]; ?> home_img_box_class">
                                                        <img alt="<?php echo $luggage_info['luggage_name'];?>" id="<?php echo 'img_'.$luggage_id; ?>" src="<?php echo  base_url();?>assets/images/<?php echo $luggage_info["image_class"];?>" data-html="true" class="popover-style luggage_info_popover_img luggage_img"  data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-selector = "true" data-content="
                                                            <div class = 'luggage_info_popover'>
                                                            <span class = 'close_popover'>x</span>
                                                                <h5><?php echo $luggage_info["luggage_name"]; ?></h5>
                                                                <hr />
                                                                 <img alt='<?php echo $luggage_info['luggage_name'];?> Sizes' src='<?php echo  base_url();?>assets/images/<?php echo $luggage_info["sizes_image"];?>'>
                                                                 <p>Check the size and weight of each piece, if the weight and size exceed the max, amount, additional charges may incur.</p>
                                                            </div>">
                                                        <span >
                                                        </span>
                                                    </div>
                                                    <span class="luggage_name_mobile pc_version_mobile"><?php echo $luggage_info["luggage_name"].' '; ?></span>
                                                    <span class="luggage_name_mobile mobile_version_min home_short_name"><?php echo $luggage_info["short_name"].' '; ?></span>

                                                    <span class="luggage_info_span luggage_info_popover_img" data-toggle="popover" data-container="body"  data-html="true" data-placement="bottom"  data-trigger = 'hover' data_id = "<?php echo 'img_'.$luggage_id; ?> "
                                                          data-content="<div class = 'luggage_info_popover'>
                                                            <span class = 'close_popover'>x</span>
                                                                <h5><?php echo $luggage_info["luggage_name"]; ?></h5>
                                                                <hr />
                                                                 <img alt='<?php echo $luggage_info['luggage_name'];?> Sizes' src='<?php echo  base_url();?>assets/images/<?php echo $luggage_info["sizes_image"];?>'>
                                                                 <p>Check the size and weight of each piece, if the weight and size exceed the max, amount,  additional charges may incur.</p>
                                                            </div>">
                                                        <span class="pc_version size_details">Weight and  size detail</span>
                                                        <span class="mobile_version size_details">Size details</span>
                                                    </span>
                                                    <p><span class="pc_version">Max </span><?php echo $luggage_info["luggage_max_weight_lbs"]; ?> lbs / <?php echo $luggage_info["luggage_max_weight_kg"]; ?> kg</p>
                                                    <?php
                                                    $select_class = '';

                                                    if(!empty($temp_luggage[$type_id."_".$luggage_id]) && $temp_luggage[$type_id."_".$luggage_id]){

                                                        $select_class = 'asad3';
                                                    }

                                                    ?>
                                                    <select class="form-control selectpicker select-luggage-size count-select <?php echo $select_class;?>" data-block="#blok<?php echo $type_id; ?>-count" name="<?php echo $type_id."_".$luggage_id; ?>" id="small_size">
                                                        <?php
                                                        for($i=0; $i<=intval($luggage_info["luggage_max_count"]); $i++){
                                                            $name_val = $type_id."_".$luggage_id;
                                                            $k = '';
                                                            if(!empty($temp_luggage[$name_val]) && $i == $temp_luggage[$name_val]){
                                                                $k = 'selected="selected"';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $i; ?>" <?php echo $k; ?>><?php echo $i; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>


                                        <?php if($label['type_name'] == 'Boxes'){  ?>
                                    </div>
                                    <div class="col-md-6 col-xs-12 box_block_size_mobile_device">
                                        <div class="panel panel-default box-special-sizes">
                                            <div class="panel-heading text-center">
                                                Special Size Box & Bag <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If your are not able to find the item to match your box or bag’s size and/or weight, please put the weight, width, height, length and quantity of your box or bag here, so we can quote the shipping fee." data-original-title="" title=""></span>
                                            </div>
                                            <div class="panel-body text-center">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Weight (lbs)</th>
                                                        <th>Size (inch)</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control not_string" name="1_weight" placeholder="0"  valid_group = 'special_size1'></td>
                                                        <td>
                                                            <input type="text" class="form-control not_string" name="1_width"  valid_group = 'special_size1' placeholder="W">
                                                            <input type="text" class="form-control not_string" name="1_height"  valid_group = 'special_size1' placeholder="H">
                                                            <input type="text" class="form-control not_string" name="1_length"  valid_group = 'special_size1' placeholder="L">
                                                        </td>
                                                        <td>
                                                            <select class="form-control selectpicker count-select select-luggage-size" name="1_count" valid_group = 'special_size1'  data-block="#blok<?php echo $type_id; ?>-count">
                                                                <?php
                                                                //*
                                                                for($i=0; $i<=10; $i++){
                                                                    ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control not_string"  name="2_weight" valid_group = 'special_size2' placeholder="0"></td>
                                                        <td>
                                                            <input type="text" class="form-control not_string" name="2_width"  valid_group = 'special_size2' placeholder="W">
                                                            <input type="text" class="form-control not_string" name="2_height"  valid_group = 'special_size2' placeholder="H">
                                                            <input type="text" class="form-control not_string" name="2_length" valid_group = 'special_size2' placeholder="L">
                                                        </td>
                                                        <td>
                                                            <select class="form-control selectpicker count-select select-luggage-size" name="2_count" valid_group = 'special_size2' data-block="#blok<?php echo $type_id; ?>-count">
                                                                <?php
                                                                for($i=0; $i<=10; $i++){
                                                                    ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control not_string" name="3_weight" valid_group = 'special_size3' placeholder="0"></td>
                                                        <td>
                                                            <input type="text" class="form-control not_string" name="3_width"  valid_group = 'special_size3' placeholder="W">
                                                            <input type="text" class="form-control not_string" name="3_height" valid_group = 'special_size3' placeholder="H">
                                                            <input type="text" class="form-control not_string" name="3_length" valid_group = 'special_size3' placeholder="L">
                                                        </td>
                                                        <td>
                                                            <select class="form-control selectpicker count-select select-luggage-size" name="3_count" valid_group = 'special_size3' data-block="#blok<?php echo $type_id; ?>-count">
                                                                <?php
                                                                for($i=0; $i<=10; $i++){
                                                                    ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>

                            </div>
                            <?php

                        }
                        ?>
                    </div>
                    <div class="row form-footer">
                        <div class="col-md-8 filter-last-text text-left col-xs-12">
                            Select the item size and quantity. You can add different pieces by clicking the icon(s) above.
                        </div>

                        <div class="col-md-4 text-right col-xs-12 filter-buttons">
                            <a href="" id="reset" class="reset">Reset</a>
                            <a href="#" id="check_price" class="check btn btn-info btn-lg">Check Price</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>
<section class="working-process">
    <div class="container">
        <div class="row">
            <h2 class="text-center">How Luggage To Ship Works?</h2>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center ">
                <div class="single-choose">
                    <a  href="<?php echo  base_url('how-luggage-shipping-works');?>">
                        <div class="icon">
                            <span><i class="icon-book-online"></i></span>
                        </div>
                        <h3>Book Online or Call Us</h3>
                        <p>Simply Select Your Destination Shipping Date. Type of Luggage and Service Type.</p>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center ">
                <div class="single-choose">
                    <a  href="<?php echo  base_url('how-luggage-shipping-works');?>">
                        <div class="icon">
                            <span><i class="icon-receive-shipping"></i></span>
                        </div>
                        <h3>Receive Shipping Labels</h3>
                        <p>Shipping Labels and Documents are Delivery by Express Mail and Email.</p>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center ">
                <div class="single-choose">
                    <a  href="<?php echo  base_url('how-luggage-shipping-works');?>">
                        <div class="icon">
                            <span><i class="icon-pickup-drop"></i></span>
                        </div>
                        <h3>We Pickup or You Drop Off</h3>
                        <p>We Pickup at the Time of Your Request or You Drop-off at any Location Worldwide.</p>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center ">
                <div class="single-choose">
                    <a  href="<?php echo  base_url('how-luggage-shipping-works');?>">
                        <div class="icon">
                            <span><i class="icon-delivery-time"></i></span>
                        </div>
                        <h3>Delivery at Scheduled Time</h3>
                        <p>We Deliver to any Place in the USA and 220 Countries Around the World.</p>
                    </a>
                </div>
            </div>


        </div>
    </div>
</section>

<!--<section class="intro-video">
    <div class="container">
        <div class="row">
            <h2 class="text-center">Watch the Video to Learn More</h2>

            <div class="video-block">
                <video poster="assets/images/video.jpg" controls>
                    <source src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.mp4" type="video/mp4">
                    <source src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.webm" type="video/webm">

                    <a href="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.mp4" download>Download</a>
                </video>
            </div>

        </div>
    </div>
</section>-->

<section class="ship-your-luggage">
    <div class="container">
        <div class="row">
            <h2 class="text-center">Luggage To Ship <br /> Service Features</h2>

            <div class="col-md-3 col-sm-3 text-center">
                <div class="single-choose">
                    <a href="<?php echo base_url('shipping-rates');?>">
                        <div class="icon">
                            <span><i class="icon-icon-cost-effective"></i></span>
                        </div>
                        <h3>Cost-effective Shipping Services</h3>
                        <p class="italic">Save up-to 70% in Shipping Fees</p>
                    </a>
                </div>
                <!--
                <div class="single-choose">
                    <a href="">
                        <div class="icon">
                            <span><i class="icon-icon-same-day-new"></i></span>
                        </div>
                        <h3>Same-day Pickup Available</h3>
                        <p class="italic">or Choose to Drop-off</p>
                    </a>
                </div>
                --->
                <div class="single-choose">
                    <a href="<?php echo base_url('luggage-shipping-partners');?>">
                        <div class="fedex_dhl_icon"></div>
                        <h3>World Class Logistics Partners</h3>
                        <p class="italic">Felxible shipping optons</p>
                    </a>
                </div>
                <div class="single-choose">
                    <a href="<?php echo base_url('luggage-drop-of-location');?>">
                        <div class="icon">
                            <span><i class="icon-icon-worldwide-new"></i></span>
                        </div>
                        <h3>Worldwide Drop-off Locations</h3>
                        <p class="italic">Over 25,000 Carrier Locations</p>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 text-center">
                <div class="free-storage">
                    <img src="assets/images/free-storage-home.svg" alt="Free Storage Home">
                </div>
                <div class="free-storage-text">
                    <p>Why keep your own luggage, bike, ski, golf clubs, or moving boxes  at home? We can keep it for you and ship  it to your destination whenever you want.</p>
                    <p>We offer 6 months of free storage for your items. Extended time storage is available at $10 per month for each piece of luggage, bag or box.</p>
                    <a target="_blank" href="<?php echo base_url('luggage-storage-services')?>" class="storage-servce-button">Learn More about Storage Services</a>
                </div>
            </div>

            <div class="col-md-3 col-sm-3 text-center">
                <!--
                <div class="single-choose">
                    <a href="">
                        <div class="icon">
                            <span><i class="icon-icon-free-label"></i></span>
                        </div>
                        <h3>Free Label Delivery</h3>
                        <p class="italic">Via 2 Days Express Mail Services</p>
                    </a>
                </div>
                -->
                <div class="single-choose">
                    <a href="<?php echo base_url('domestic-luggage-shipping')?>">
                        <div class="map_icon"></div>
                        <h3>Convenient Domestic Shipping</h3>
                        <p class="italic">Door-to-door, sameday pick up availabe</p>
                    </a>
                </div>
                <!--
                <div class="single-choose">
                    <a href="">
                        <div class="icon">
                            <span><i class="icon-icon-inshurance-new"></i></span>
                        </div>
                        <h3>$100 Per Piece Free Insurance</h3>
                        <p class="italic">Up to $20.000 Coverage</p>
                    </a>
                </div>
                -->
                <div class="single-choose">
                    <a href="<?php echo base_url('international-luggage-delivery');?>">
                        <div class="map_air_icon"></div>
                        <h3>Hassle-free International Shipping</h3>
                        <p class="italic">to over 220 countries and temitories</p>
                    </a>
                </div>
                <div class="single-choose">
                    <a href="<?php echo base_url('ship-to-school');?>">
                        <div class="icon">
                            <span><i class="icon-icon-free-luggage-new"></i></span>
                        </div>
                        <h3>Student Shipping and Storages </h3>
                        <p class="italic">Affordable, easy and relax</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="partners">
    <div class="container">
        <div class="">
            <h2 class="text-center">Media & Trusted Partners</h2>

            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-center travel_show partner_logo_class">
                <div class="single-choose">
                   <img src="<?php echo base_url();?>assets/images/partners/travel_show.jpg" alt="Travel Show">
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-center rezident_magazine partner_logo_class">
                <div class="single-choose">
            <img src="<?php echo base_url();?>assets/images/partners/ResidentMagazine_colored.png" alt="Resident Magazine Community">
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-center dhl_home_logo partner_logo_class">
                <div class="single-choose">
                  <img src="<?php echo base_url();?>assets/images/partners/dhl_colored.png" alt="Dhl">
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-center fedex_home_logo partner_logo_class">
                <div class="single-choose">
                    <img src="<?php echo base_url();?>assets/images/partners/fedex_colored.png" alt="Fedex">
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-center fedex_home_logo vertoe_logo partner_logo_class" >
                <div class="single-choose">
                    <a href="https://vertoe.com"> <img src="<?php echo base_url();?>assets/images/Vertoe_logo_Blue.png" alt="Fedex"></a>
                    <p>Get 5% off!</p>
                    <p>code LTSVertoe</p>
                </div>
            </div>

        </div>
    </div>
</section>
