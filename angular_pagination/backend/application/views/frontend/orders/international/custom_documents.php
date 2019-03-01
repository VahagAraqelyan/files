<!-- Modal upload-->
<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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

<div class="content">
    <div class="container inter_cust_document">
        <div class="profile">
            <div class="place-order">
                <span class="orange-color">Custom Documents</span>
                <div class="button-place go-to-details order_detalis_mobile ">
                    <a href="<?php echo base_url('order/order_processing/'.$order_info['id']); ?>" class="btn btn-default no_transform btn-login-orange apply-promotion">Go Order Details</a>
                </div>
                <div class="place-order-content more">
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center"><span class="orange-color"><?php echo $title; ?></span></div>
                    <div class="col-md-3 col-sm-4 col-xs-6 first">
                        <p class="pc_version"><?php echo $order_info['currier_name']." ".$order_info['send_type']; ?></p>
                        <?php
                        $type = $order_info['send_type'];
                      if($order_info['currier_name'] == 'FedEx' && $order_info['shipping_type'] == 1){

                            if(stripos($type, 'Express') !== false){
                                $type = 'Express';
                                $type = str_ireplace('days','',$type);

                            }elseif (stripos($type, 'Economy') !== false){
                                $type = 'Economy';
                                $type = str_ireplace('days','',$type);
                            }

                        }elseif($order_info['currier_name'] == 'DHL' && $order_info['shipping_type'] == 1){
                            if(stripos($type, 'Express') !== false){
                                $type = 'Express';

                            }
                        }  ?>
                        <p class="mobile_version"><?php echo $order_info['currier_name']." ".$type; ?></p>
                        <p>Shipping fee: <span class="orange-color pay_amount">$<?php echo (!empty($order_info['price']))?$order_info['price']:0; ?></span></p>
                        <p class="blue-color"><a href="#" class="luggage_incurance">Item & Insurance</a></p>
                    </div>
                    <div class="col-md-6 col-sm-4 hidden-xs text-center"><br /><span class="orange-color"><?php echo $title; ?></span></div>
                    <div class="col-md-3 col-sm-4 col-xs-6 text-right last">
                        <p>Order #: <span class="orange-color"><?php echo $order_info['order_id']; ?></span></p>
                        <p class="light-gray">Order Date: <?php echo date("M-d-Y", strtotime($order_info['created_date'])); ?></p>
                        <p class="blue-color"><a href="#" class="label_delivery">Label Delivery</p></a>
                    </div>
                    <p class="clearfix"></p>
                </div>
            </div>

            <input type="hidden" name="country_id" value="<?php echo $sender_info['pickup_country_id']; ?>" id="country_id">
            <input type="hidden" name="order_id" value="<?php echo $order_info['id']; ?>" id="order_id">
            <div class="order-process-block">
                <?php

                $class1 = 'fa fa-exclamation information-icon';
                if(!empty($order_item_list) && !empty($order_info['signature'])){
                    $class1 = 'fa fa-check verified-icon';
                }
                $class2 = 'fa fa-exclamation information-icon';
                if(!empty($passport_info)){

                    $class2 = 'fa fa-check verified-icon';
                }

                $class3 = 'fa fa-exclamation information-icon';
                if(!empty($travel)){

                    $class3 = 'fa fa-check verified-icon';
                }
                $item_class = '';
                if($order_info['order_type'] == 2){

                    $item_class = 'dis_none_item_list';
                }

                ?>

                <div class="row order_detalis order_detalis_full">
                    <div class="col-md-12 accept-group text-right">
                        <div class="button-place go-to-details">
                            <a href="<?php echo base_url('order/order_processing/'.$order_info['id']); ?>" class="btn btn-default btn-login-orange apply-promotion">Go Order Details</a>
                        </div>
                    </div>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs responsive-tabs" role="tablist" id="my_accoutn_tabs">
                    <li class="active ">
                        <a href="#account_information" data-toggle="tab" class="item_list">
                                <span class="tab-image">
                                    <img class="" src="<?php echo  base_url();?>assets/images/fill-list.svg">
                                    <i class="<?php echo $class1; ?>" id="item_list"></i>
                                </span> Item List <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="for_custum_documents <?php echo $item_class; ?>">
                        <a href="#traveler_list" data-toggle="tab" class="pasport_copy <?php echo $item_class; ?>">
                            <span class="tab-image">
                                    <img class="" src="<?php echo  base_url();?>assets/images/passport.svg">
                                    <i class="<?php echo $class2; ?>" id="passport_icon"></i>
                                </span> Passport Copy <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="for_custum_documents <?php echo $item_class; ?>">
                        <a href="#address_book" data-toggle="tab" class="travel_itinary <?php echo $item_class; ?>">
                                <span class="tab-image">
                                    <img class="" src="<?php echo  base_url();?>assets/images/airplane.svg">
                                    <i class="<?php echo $class3;?>" id="travel_icon"></i>
                                </span> Travel Itinerary <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                        </a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content tab-profile order-details-content">
                    <div class="tab-pane account-info active" id="account_information">

                    </div>
                    <div class="tab-pane" id="traveler_list">

                    </div>
                    <div class="tab-pane" id="address_book">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="insurance_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade ">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body insurance_mobile_padding" id="answer_incuranc">
            </div>
        </div>
    </div>
</div>

<div id="label_delivery_view" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_delivery_label_answer">
            </div>
        </div>
    </div>
</div>


<div class="modal fade login-fast inform-fast modal fade in" id="pasport_travel_hide" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center text_transform_none ">Thank you for  submitting order</h2>

                <div class="first_text">
                    <h4 class="title">Order Number <?php echo $order_info['order_id']; ?></h4>
                    <p>
                        Because the detailed item list is necessary custom document for international shipment, please select the purpose of your shipment and provide the detailed item list
                    </p>
                    <p>
                        <input type="radio" class="order_type individual individual_popap item_list_popap" name="order_type" value="1">
                       <span class="text-bold"> Personal Effects.</span>  I’m sending used personal effects which are for my sole use and have been owned by me for a minimum  of 6 months.
                    </p>
                    <p>
                        <input type="radio" class="order_type comertial comertial_popap item_list_popap" name="order_type" value="2">
                        <span class="text-bold">Commercial Use. </span> I’m sending items for commercial purposes.
                    </p>
                    <p>
                        ShaI you have any questions on this order, please contact us at <br><span class="blue-color">cs@luggagetoship.com </span>  or <span class="blue-color">1800 678 6167 </span><br>
                        Our office hours are Monday- Friday 9:00am to 6 00om EST
                    </p>
                </div>


            </div>

        </div>

    </div>
</div>

    <div class="modal fade login-fast inform-fast modal fade in" id="custom_value_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center lovercase small_text_mobile">Declared Value for Personal Effects </h2>

                <div class="first_text text-center">
                    <p class="pc_version custom_document_p">
                        The declared value is for customs purposes only.<br>
                        Because you are sending used personal effects, the declared value  <br>
                        should reflect the depreciation price (not the replacement value).<br>
                        Please be advised the declare value for free  <br>
                        duty in <?php echo $country; ?> is less than  <?php echo $custom_value; ?>USD <br>
                        Custom may charge tax for this shipment if applied.

                    </p>
                    <p class="mobile_version custom_document_p">
                        The declared value is for customs purposes only.
                        Because you are sending used personal effects, the declared value should
                        reflect the depreciation price (not the replacement value).
                        Please be advised the declare value for free
                        duty in <?php echo $country; ?> is less than  <?php echo $custom_value; ?>USD
                        Custom may charge tax for this shipment if applied.

                    </p>
                </div>

                <div class="button-place text-right">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_error_modal close_custom_value_modal no_transform button_width">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade login-fast inform-fast modal fade in" id="custom_value_null_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center lovercase small_text_mobile">Declared Value for Personal Effects </h2>

                <div class="first_text text-center">
                    <p class="pc_version custom_document_p">
                        The declared value is for customs purposes only. Because you are <br>
                        sending used personal effects, the declared value should reflect <br>
                        the depreciation price (not the replacement value).<br>
                        Please be advised <?php echo $country; ?> custom may charge tax and duty <br>
                        on this shipment. The receiver will be responsible for the tax and duty.<br>

                    </p>
                    <p class="mobile_version custom_document_p">
                        The declared value is for customs purposes only. Because you are sending used personal effects,
                        the declared value should reflect the depreciation price (not the replacement value).  Please be advised
                        <?php echo $country; ?> custom may charge tax and duty on this shipment.
                        The receiver will be responsible for the tax and duty.
                    </p>
                </div>

                <div class="button-place text-right">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_error_modal close_custom_value_modal close_custom_value_null_modal no_transform button_width">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade login-fast inform-fast modal fade in" id="personal_effect_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center text_transform_none small_text_mobile">Thank you for submitting item list </h2>

                <div class="first_text text-center">
                    <p class="mobile_version">
                        If you are sending personal effects for your trip,
                        you may continue to complete passport copy and travel itinerary tab  for a smooth custom clearance.
                        Alternatively, you may attach your passport copy and travel itinerary to your shipping  document later
                        when your shipment is picked up or  dropped off. <br> <br>  We will process your order and email you shipping labels soon.
                    </p>
                    <p class="pc_version">
                        If you are sending personal effects for your trip,
                        you may <br> continue to complete passport copy and travel itinerary tab <br> for a smooth custom clearance.
                        Alternatively, you may attach <br> your passport copy and travel itinerary to your shipping <br> document later
                        when your shipment is picked up or <br> dropped off. <br> <br> We will process your order and email you shipping labels  <br> soon.
                    </p>
                </div>

                <div class="button-place text-right">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_error_modal personal_effect_modal_close no_transform button_width">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade login-fast inform-fast modal fade in" id="comertial_use_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center text_transform_none small_text_mobile">Thank you for submitting item list </h2>

                <div class="first_text text-center">
                    <p class="pc_version">
                        Thank you for submitting the item list. We will process your <br> order and email your shipping labels soon.
                    </p>
                    <p class="mobile_version">
                        Thank you for submitting the item list. We will process your order and email your shipping labels soon.
                    </p>
                </div>

                <div class="button-place text-right">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_error_modal comertial_use_modal_close no_transform button_width">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>


<?php
$item_count = 1;

if(!empty($order_item_list)){

$item_count = count($order_item_list);
}

?>

<script>
    item_count = '<?php echo $item_count; ?>';
    item_name  = <?php echo json_encode($item_name); ?>;
    custom_value  = <?php echo json_encode($custom_value); ?>;
    order_type  = <?php echo json_encode($order_info['order_type']); ?>;
</script>