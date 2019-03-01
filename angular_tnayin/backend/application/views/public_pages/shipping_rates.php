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
<!doctype html>
<html lang="en">

<body>

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
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
if($this->input->cookie('order')){

    $selected_order = $this->input->cookie('order');
    $selected_order = json_decode($selected_order);

    if(!empty($selected_order->luggage)){
        $temp_luggage = (array)$selected_order->luggage;
    }

}
?>

<section class="filter shipping_rates_bg">
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
                        <select class="home_select_country" name="country_to" id="country_to" data-input="city_to">
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
<div class="content shipping_rates">
    <div class="container">
    <div class="block-section ">
        <div class="row">
            <div class="col-md-6">
                <div class="sl-info sl-short sl-small">
                    <div class="sl-content">
                        <h6 class="blue-color">Tips</h6>
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
                        <h6 class="blue-color">Tools</h6>
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
</div>
</div>
</body>
</html>