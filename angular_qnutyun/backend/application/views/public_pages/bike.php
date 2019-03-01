
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
<section class="filter ship-bike-bg">
    <div class="container">
        <div class="filter-block">
            <form class="filter-form" method="post" action="" id="home_filter_form">
                <div class="country-part col-md-3">
                    <div class="form-group from-block">
                        <label for="country_from">From:
                            <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="hover" data-placement="top"
                                  data-content="
                                  Please put and select the country and zip code (or city) you are shipping from. Zip code (or city) is not required for international shipment quotation.
                            "></span>
                        </label>
                        <select class="home_select_country " name="country_from" id="country_from" data-input="city_from" >
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
                            <span class="popover-style home-separate-pop home_popover_top" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="hover" data-placement="top"
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
                        <label for="">Shipping Date: <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="hover" data-placement="top"
                                                           data-content="<div class = 'date_popover_content'><span >Your luggage can be picked up by our carrier or dropped off at a carriers location. Pick up services are not available Sundays and holidays. FedEx Saturday pick-up services are available for express shipments within the United States. If your shipment Is dropped off after the cut-off time of the courier business hours. your package will be shipped out the next business day.</span></div
                "></span></label>
                        <input type="text" class="form-control shipping-date filter_control" onfocus="blur();" name="shipping_date" id="shipping_date" placeholder="Select date" data_targets = 'Shipping date'>
                    </div>

                </div>

                <div class="items-part col-md-9">
                    <span class="select-item-title">Select item(s):
                    <span class="popover-style home-separate-pop" data-container="body" data-html = "true"  data-toggle="popover" data-trigger="hover" data-placement="top"
                          data-content="
                          1) Please click the blue icons below to see different types of items.
                          2) Please select the item quantity from the drop down list under various sizes of each item.
                "></span>
                    </span>
                    <ul class="nav nav-tabs select-items box_list" role="tablist">
                        <?php
                        foreach($luggages_array as $type_id=>$label){
                            $i_class = ($type_id == 7)?'bike_class':'';
                            $active=($label['type_name'] == 'Bike & SKI')?"class='active'":"";
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

                            $active=($label['type_name'] == 'Bike & SKI')?" active":"";

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

<div class="content">
    <div class="container">
        <div class="block-section">
            <h1 class="cont-title">Ship Bike</h1>
            <h6 class="cont-description">Enjoy a lighter trip, and have your bike wait for you at destination</h6>

            <h3>Why Ship Your Bike</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="sl-info sl-long">
                        <span><i class="icon-alarm-second"></i></span>
                        <div class="sl-content">
                            <h6>Save time</h6>
                            <p>Skip check-in line </p>
                            <p>Skip baggage claim line</p>
                            <p>Avoid the hassles of carrying heavy bike all the trip</p>
                        </div>
                    </div>
                    <div class="sl-info sl-long">
                        <span><i class="icon-save-money"></i></span>
                        <div class="sl-content">
                            <h6>Save money</h6>
                            <p>Avoid excess baggage fees</p>
                            <p>No additional cost to move your bike between airport, resort and home.</p>
                        </div>
                    </div>
                    <div class="sl-info sl-long">
                        <span><i class="icon-relax-trip-second"></i></span>
                        <div class="sl-content">
                            <h6>Bask in the joys of a relaxing trip</h6>
                            <p>Enjoy a lighter trip without heavy bike.</p>
                            <p>Your bike and luggage are waiting for you at resort or your home in advance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-section">
            <div class="row">
                <div class="col-md-12">
                    <h3>Our Bike Shipping Services</h3>
                    <div class="sl-info">
                        <ul class="short-line-height">
                            <li>We ship to every US address, and over 220 countries and territories worldwide</li>
                            <li>We offer various shipping services at competitive rates. </li>
                            <li>We arrange pick-ups at scheduled time frames from your door, and deliver your bike to your resort, hotel or home at destination. </li>
                            <li>You may drop off your bike at over 250,000 locations worldwide. </li>
                            <li>We assist  you in preparing the customs documentation for international shipment. </li>
                            <li>We monitor every shipment and work with both you and the carrier  for any assistance that is needed.</li>
                            <li>We provide up-to 6 months of free storage services for your bike or sport equipment.</li>
                        </ul>
                    </div>
                    <p class="tag-info">Lean more about our <a href="<?php echo base_url('domestic-luggage-shipping')?>" class="blue-color">Domestic Shipping Services, </a> <a href="<?php echo base_url('international-luggage-delivery')?>" class="blue-color">International shipping services</a></p>
                </div>
            </div>
        </div>

        <div class="block-section">
            <h3>How to Pack and Label Your Bike</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="sl-info sl-short sl-small">
                        <span><i class="icon-bike-box-second"></i></span>
                        <div class="sl-content">
                            <h6>Packing</h6>
                        </div>
                    </div>
                    <div class="sl-info">
                        <ul class="short-line-height">
                            <li>Use a bicycle travel case or sturdy bicycle corrugated box </li>
                            <li>Disassemble the bike and secure each parts in the bike case or box</li>
                            <li>Fill the empty space of the bike box with packing bubble or peanuts fillings</li>
                            <li><span class="semibold-style">US Domestic shipment:</span> please lock your bike case by <f class="error_class">TSA approved locks </f> or <f  class="error_class">cable ties</f>.</li>
                            <li><span class="semibold-style">International shipment:</span> please <span class="red-color">ONLY</span> use <span class="red-color">Cable Ties</span> to lock your bike case.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sl-info sl-short sl-small">
                        <span><i class="icon-label-te-second"></i></span>
                        <div class="sl-content">
                            <h6>Labelling</h6>
                        </div>
                    </div>
                    <div class="sl-info">
                        <ul class="short-line-height">
                            <li>Put shipping labels and document inside the label pouch, tracking barcode facing outside.</li>
                            <li>Stick the pouch tightly to a luggage tag, and secure the tag to the top handle of your bike case. Or stick the pouch tightly to the bike box.</li>
                            <li>Put an additional copy of label and document inside bike case. Or tape an additional label on the bike box with clear tape.</li>
                            <li>Take a full picture of the labelled bike case/box, with the tracking barcode.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="tag-info">Check detailed <a href="<?php echo base_url('how-to-pack-luggage')?>" class="blue-color">Packing and Labelling instructions</a></p>
                </div>
            </div>
        </div>

        <div class="block-section items-block-part ski-inter bike">
            <div class="row">
                <!--      <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="luggage-img">
                        <img src="<?php /*echo base_url();*/?>assets/images/first-bike.jpg">
                    </div>
                    <div class="luggage-content">
                        <p class="blue-color item-title">LIght Bicycle in a box</p>
                        <p>Average Weight: <span class="orange-color">30lbs / 14kg</span></p>
                        <p>Average Dimension: <span class="orange-color">46*30*12inch <br>116*76*31cm</span></p>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="luggage-img">
                        <img src="<?php /*echo base_url();*/?>assets/images/second-bike.jpg">
                    </div>
                    <div class="luggage-content">
                        <p class="blue-color item-title">Heavy Bicycle in a box</p>
                        <p>Average Weight: <span class="orange-color">65lbs / 29kg</span></p>
                        <p>Average Dimension: <span class="orange-color">47*31*16inch <br>119*78*40cm</span></p>
                    </div>
                </div>-->

                <div class="col-md-9 col-sm-12 col-xs-12 bike_own">
                    <div class="luggage-img">
                        <img src="<?php echo base_url();?>assets/images/ski_bag.png">
                    </div>
                    <div class="luggage-content">
                        <p class="blue-color item-title">Bike Box</p>
                        <p>Max Weight: <span class="orange-color">55lbs/25kg</span></p>
                        <p>Max Lenght: <span class="orange-color">55inch/140cm</span></p>
                        <p>Max Girth: <span class="orange-color">72inch/183cm</span></p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>