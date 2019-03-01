<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>
<!-- Modal upload-->
<?php
$check_date = 0;
$pickup_id =    (!empty($pickup_country_id))?$pickup_country_id:'';
$delivery_id = (!empty($delivery_country_id))?$delivery_country_id:'';
$public_key = (!empty($public_key))?$public_key:'';
$true = false;
$class1 = 'fa fa-exclamation information-icon';
if(!empty($item_name)){

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

if($class1 == 'fa fa-check verified-icon' && $class1 == $class2 && $class1 == $class3){

    $true = true;

    $info = 'View / Edit Order';

}else{

    $info = 'Edit Item(s) or Services';

}

if($class1 == 'fa fa-check verified-icon'){
    $confirm ='View and Edit';

}else{
    $confirm = 'Please Complete Item List';
}


if($sender_class){

    $sender_class = 'fa verified-icon';

}else{

    $sender_class = 'fa information-icon';
}

if($delivery_class){

    $delivery_class = 'fa verified-icon';

}else{

    $delivery_class = 'fa information-icon';
}

if($payment_class){

    $payment_class = 'fa verified-icon';

}else{

    $payment_class = 'fa information-icon';
}
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>


    <script>
    Stripe.setPublishableKey('<?php echo $public_key;?>');
    pick_up_country = '<?php echo $pickup_id; ?>';
    delivery_country = '<?php echo $delivery_id; ?>';
    </script>
<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="register-block no-hide up_modal">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="register-title text-center lovercase">Missing information</h2>
            </div>
            <div class="modal-body " id="upload_modal_div">

                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                    <p class="order_complete_error display_none error_class">Please complete and save ①②③ to submit the order.</p>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="order_submit_error_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="register-block no-hide up_modal">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="register-title text-center lovercase">Missing information</h2>
            </div>
            <div class="modal-body ">

                <div >
                    <p class=" error_class" style="text-align: center;">Please complete and save ①②③ to submit the order.</p>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="<?php echo ($order_info['shipping_type'] == 2)?'ajax_modal':'';?>" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" id="before_send">
            <div class="modal-body before_send">
                <div class='cssload-square process_load_div'>
                    <div class='cssload-square-part cssload-square-green'></div>
                    <div class='cssload-square-part cssload-square-pink'></div>
                    <div class='cssload-square-blend'></div>
                </div>
                <div id="process_div">
                    <span class="orange-color" id="process_word">CHARGING...</span>
                </div>
              <!--  <div id= 'status_div'>
                        <table>
                            <tr>
                                <td><span>Checking</span></td>
                                <td><i class="" id="checking_span"></i></td>
                            </tr>
                            <tr>
                                <td><span>Charging</span></td>
                                <td><i class="" id="charging_span"></i></td>
                            </tr>
                            <tr>
                                <td><span>Processing</span></td>
                                <td><i class="" id="label_span"></i></td>
                            </tr>
                        </table>
                </div>-->
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="drop_off_map" role="dialog">
    <div class="modal-dialog drop_off_locator">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="register-block no-hide up_modal">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="register-title text-center lovercase">Find A Drop off Location</h2>
            </div>

            <div class="modal-body" id="drop_off_content">

            </div>

        </div>

    </div>
</div>

<input type="hidden" name="order_id" value="<?php echo $order_info['id']; ?>" id="order_id">
<input type="hidden" name="country_id" value="" id="data_id">
<input type="hidden" name="country_id" value="" id="delivery_info">
<div class="content">
    <div class="container">
        <div class="profile order-process-content">
            <?php

            if(stripos($order_info['send_type'], 'outbound') !== false){

                $type = trim(str_replace('outbound', '', $order_info['send_type']));
                $type = ucfirst($type)." ".$order_info['delivery_day_count']." days";

            }else if(stripos($order_info['send_type'], 'inbound') !== false){

                $type = trim(str_replace('inbound', '', $order_info['send_type']));
                $type = ucfirst($type)." ".$order_info['delivery_day_count']." days";

            }else{

                $type = $order_info['send_type'];
            }

            ?>
            <?php if($order_info['shipping_status'] == INCOMPLETE_STATUS[0]){ ?>

                <div class="place-order">

                    <?php
                    if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){ ?>

                        <span class="orange-color submitted_info"><?php echo $info; ?></span>
                    <?php }else {  ?>
                        <span class="orange-color">Place Order</span>
                    <?php } ?>
                    <div class="place-order-content">
                        <div class="col-md-6 col-xs-6">
                            <p class="pc_version"><?php echo $order_info['currier_name']." ".$type; ?></p>
                            <?php
                            $type = change_order_type($type,$order_info['currier_name'],$order_info['shipping_type'],'order');

                            ?>
                            <p class="mobile_version"><?php echo $order_info['currier_name']." ".$type; ?></p>
                            <p>Shipping fee: <span class="orange-color pay_amount">$<?php echo $order_info['price']; ?></span></p>
                            <p class="blue-color mobile_version"><a href="#" class="insurance_button">Item & Insurance</a></p>
                        </div>

                        <div class="col-md-6 col-xs-6 text-right">
                            <p>Order #: <span class="orange-color"><?php echo $order_info['order_id']; ?></span></p>
                            <p class="light-gray">Order Date: <?php echo date("M-d-Y", strtotime($order_info['created_date'])); ?></p>
                            <p class="blue-color mobile_version"><a href="#" class="delivery_label">Label Delivery</a></p>
                        </div>
                        <p class="clearfix"></p>
                    </div>
                </div>

            <?php }else{ ?>

                <div class="place-order">
                    <span class="orange-color">Order Details</span>
                    <div class="place-order-content more">
                        <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center"><span class="orange-color"><?php echo $title; ?></span></div>
                        <div class="col-md-3 col-sm-4 col-xs-6 first">
                            <p class="pc_version"><?php echo $order_info['currier_name']." ".$type; ?></p>
                            <?php

                            $type = change_order_type($type,$order_info['currier_name'],$order_info['shipping_type']);
                            ?>
                            <p class="mobile_version"><?php echo $order_info['currier_name']." ".$type; ?></p>
                            <p>Shipping fee: <span class="orange-color pay_amount">$<?php echo (!empty($price_origin['original_price']))?$price_origin['original_price']:0; ?></span></p>
                            <?php
                            if($order_info['shipping_status'] != SUBMITTED_STATUS[0]){ ?>

                                <p class="blue-color"><a href="#" class="luggage_incurance">Item & Insurance</a></p>
                            <?php }else{ ?>
                                <p class="blue-color mobile_version"><a href="#" class="insurance_button">Item & Insurance</a></p>
                            <?php } ?>


                        </div>
                        <div class="col-md-6 col-sm-4 hidden-xs text-center"><br /><span class="orange-color"><?php echo $title; ?></span></div>
                        <div class="col-md-3 col-sm-4 col-xs-6 text-right last">
                            <p>Order #: <span class="orange-color"><?php echo $order_info['order_id']; ?></span></p>
                            <p class="light-gray">Order Date: <?php echo date("M-d-Y", strtotime($order_info['created_date'])); ?></p>
                            <?php
                            if($order_info['shipping_status'] != SUBMITTED_STATUS[0]){ ?>

                                <p class="blue-color"><a href="#" class="label_delivery">Label Delivery</a></p>
                            <?php }else{ ?>
                                <p class="blue-color mobile_version"><a href="#" class="delivery_label">Label Delivery</a></p>
                            <?php } ?>
                        </div>
                        <p class="clearfix"></p>
                    </div>
                </div>
            <?php } ?>

            <div class="order-process-block">

                <?php  if($order_info['shipping_status'] >= PROCESSED_STATUS[0] && $order_info['shipping_status'] <= PROCESSED_CANCEL_STATUS[0]){

                    if($order_info['shipping_status'] >= PROCESSED_STATUS[0] && $order_info['shipping_status'] <= PROCESSED_CANCEL_STATUS[0]){ ?>
                            <div class="right-part">
                                <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <?php
                                    if($order_info['shipping_status'] == TRANSIT_STATUS[0] || $order_info['shipping_status'] == DELIVERY_STATUS[0] || $order_info['shipping_status'] == CLOSED_STATUS[0]){ ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading light-color" role="tab" id="headingFourth">
                                                <h4 class="panel-title text-left">
                                                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#shipping_tracking" aria-expanded="false" aria-controls="headingFourth">
                                                        <img src="<?php echo  base_url('assets/images/').$my_carrier['currier_logo'];?>"> Tracking Numbers <i class="fa fa-angle-up tab-down" id="shipping_tracking_colapse" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="shipping_tracking" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFourth">
                                                <?php
                                                if(!empty($order_info['labels_pdf'])){ ?>
                                                    <div class="button-place col-xs-12">
                                                        <a href="<?php echo base_url('stream/labels/'.$order_info['labels_pdf'].'/'.sample_hash($order_info['user_id'])); ?>" target="_blank" class="no_white_space butt_small_padding btn btn-default btn-login-orange print_modal_butt apply-promotion col-xs-10 no_transform"><i class="fa fa-print "></i> Print shipping label(s)</a>
                                                    </div>
                                                <?php } ?>
                                                <div class="panel-body white panel-table-block">
                                                    <table class="table-default">
                                                        <thead>
                                                        <tr>
                                                            <th width="25">#</th>
                                                            <th class="text-center">Type</th>
                                                            <th class="text-center">Tracking #</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if(!empty($order_info['tracking_number']['tracking_number'])){

                                                            foreach ($order_info['tracking_number']['tracking_number'] as $index => $value){

                                                                if($value['weight']%1 != 0){

                                                                    $weight = explode('.',$value['weight']);
                                                                    $weight = intval($weight[0]).'.'.intval($weight[1]);

                                                                }else{

                                                                    $weight = intval($value['weight']);
                                                                }
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $index+1;?></td>
                                                                    <td class="text-center"><?php echo $weight;?> lbs <?php echo $value['type_name']?></td>
                                                                    <td class="text-center" ><span class="orange-color link_tracking" data_number = "<?php echo $order_info['id'].'_'.$value['luggage_id'].'_'.$value['tracking_number']; ?>"><?php echo $value['tracking_number']?></span></td>
                                                                </tr>
                                                            <?php   }  }else{
                                                            $colum_text = true;
                                                            foreach ($order_info['tracking_number'] as $index => $value){

                                                                if($value['weight']%1 != 0){

                                                                    $weight = explode('.',$value['weight']);
                                                                    $weight = intval($weight[0]).'.'.intval($weight[1]);

                                                                }else{

                                                                    $weight = intval($value['weight']);
                                                                }

                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $index+1;?></td>
                                                                    <td class="text-center"><?php echo $weight;?> lbs <?php echo $value['type_name']?></td>
                                                                    <?php if($colum_text) {
                                                                        ?>
                                                                        <td rowspan="<?php echo count($order_info['tracking_number']); ?>">
                                                                        <span class="orange-color tracking_info">
                                                                        We have Processed <br> your order and will <br> update your tracking number soon.
                                                                        </span>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    $colum_text = false;
                                                                    ?>
                                                                </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php

                                                    $country_iso3 = ($country_receiver_info['iso3'] == null)?'Not available':$country_receiver_info['iso3'];
                                                    ?>
                                                    <p class="text-center"><?php echo $order_info['currier_name']." ".$country_iso3. " Hotline: ". $country_prof_info_receiver['hotline']; ?></p>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading light-color" role="tab" id="headingFifth">
                                                <h4 class="panel-title text-left">
                                                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#pickup_confirmation" aria-expanded="false" aria-controls="headingFifth">
                                                        <img src="<?php echo base_url('assets/images/').$my_carrier['currier_logo']; ?>"> <?php echo ($sender_info['pick_up'] != 1)?'Pickup Confirmation':' Drop-off Confirmation'?>  <i class="fa tab-down fa-angle-down" id="pick_up_colapse" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="pickup_confirmation" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFifth">
                                                <div class="panel-body white panel-table-block">

                                                    <div class="panel-body white panel-table-block text-center">
                                                        <?php
                                                        if($sender_info['pick_up'] == 2){ ?>

                                                            <?php
                                                            if($sender_info['pick_up'] == 2){
                                                                if(empty($shedule_pickup['date'])){
                                                                ?>
                                                                <p>Pick up will be arranged within 2 business days from the shipping date.</p>
                                                            <?php } }else{ ?>

                                                                <p>You may drop-off your luggage any time after you receive your label. </p>

                                                            <?php } ?>

                                                            <?php if(!empty($shedule_pickup)){ ?>
                                                                <p><span class="pickup_inf1">Pick Up Date:</span>   <span class="pickup_inf2 orange-color"><?php echo date('M-d-Y', strtotime($shedule_pickup['date']));?></span></p>
                                                                <p><span class="pickup_inf1">Pick Up Time:</span>   <span class="pickup_inf2 orange-color"><?php echo $shedule_pickup['time_from'].'-'.$shedule_pickup['time_to'];?></span></p>
                                                                <p><span class="pickup_inf1">Confirmation #:</span> <span class="pickup_inf2 orange-color"><?php echo $shedule_pickup['con']; ?></span></p>

                                                            <?php } }else{ ?>

                                                            <p>You may drop-off your luggage any time after you receive your label. </p>
                                                            <p><a href="<?php echo base_url('luggage-and-question'); ?>" class="blue-color" target="_blank">View instructions</a></p><br />
                                                        <?php } ?>


                                                        <?php

                                                        $country_iso3_sender = ($country_sender_info['iso3'] == null)?'Not available':$country_sender_info['iso3'];
                                                        ?>
                                                        <p class="text-center hotline_text"><?php echo $order_info['currier_name']." ". $country_iso3_sender. " Hotline: ". $country_prof_info_sender['hotline']; ?></p>
                                                        <div class="text-center">
                                                            <?php
                                                            if($sender_info['pick_up'] == 2 && $order_info['shipping_type'] == 2){ ?>

                                                                <a href="#" class="btn btn-default small-button   white-space drop_off_location btn-login-orange">Find a drop off location if missed pickup</a>
                                                            <?php }else{ ?>

                                                                <a href="#" class="btn btn-default small-button select-doc-file  white-space drop_off_location">Find a drop off location</a>

                                                            <?php } ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                 <?php }else{ ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading light-color" role="tab" id="headingFifth">
                                                <h4 class="panel-title text-left">
                                                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#pickup_confirmation" aria-expanded="false" aria-controls="headingFifth">
                                                        <img src="<?php echo base_url('assets/images/').$my_carrier['currier_logo']; ?>"> <?php echo ($sender_info['pick_up'] != 1)?'Pickup Confirmation':' Drop-off Confirmation'?>  <i class="fa fa-angle-up tab-down" id="pick_up_colapse" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="pickup_confirmation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFifth">
                                                <div class="panel-body white panel-table-block">

                                                    <div class="panel-body white panel-table-block text-center">
                                                        <?php
                                                        if($sender_info['pick_up'] == 2){ ?>

                                                            <?php
                                                            if($sender_info['pick_up'] == 2){

                                                                if(empty($shedule_pickup['date'])){

                                                                ?>

                                                                <p  class="dropp_off_inf">Pick up will be arranged within 2 business days from the shipping date.</p>
                                                            <?php } }else{ ?>

                                                                <p  class="dropp_off_inf">You may drop-off your luggage any time after you receive your label. </p>

                                                            <?php } ?>

                                                            <?php if(!empty($shedule_pickup)){ ?>
                                                                <p><span class="pickup_inf1">Pick Up Date:</span>   <span class="pickup_inf2 orange-color"><?php echo date('M-d-Y', strtotime($shedule_pickup['date']));?></span></p>
                                                                <p><span class="pickup_inf1">Pick Up Time:</span>   <span class="pickup_inf2 orange-color"><?php echo $shedule_pickup['time_from'].'-'.$shedule_pickup['time_to'];?></span></p>
                                                                <p><span class="pickup_inf1">Confirmation #:</span> <span class="pickup_inf2 orange-color"><?php echo $shedule_pickup['con']; ?></span></p>
                                                            <?php } }else{ ?>

                                                            <p class="dropp_off_inf">You may drop-off your luggage any time after you receive your label. </p>
                                                            <p><a href="<?php echo base_url('luggage-and-question'); ?>" class="blue-color" target="_blank">View instructions</a></p><br />
                                                        <?php } ?>


                                                        <?php

                                                        $country_iso3_sender = ($country_sender_info['iso3'] == null)?'Not available':$country_sender_info['iso3'];
                                                        ?>
                                                        <p class="text-center hotline_text"><?php echo $order_info['currier_name']." ". $country_iso3_sender. " Hotline: ". $country_prof_info_sender['hotline']; ?></p>
                                                        <div class="text-center">
                                                            <?php
                                                            if($sender_info['pick_up'] == 2){ ?>

                                                                <a href="#" class="btn btn-default small-button   white-space drop_off_location btn-login-orange">Find a drop off location if missed pickup</a>
                                                            <?php }else{ ?>

                                                                <a href="#" class="btn btn-default small-button select-doc-file  white-space drop_off_location">Find a drop off location</a>

                                                            <?php } ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading light-color" role="tab" id="headingFourth">
                                                <h4 class="panel-title text-left">
                                                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#shipping_tracking" aria-expanded="false" aria-controls="headingFourth">
                                                        <img src="<?php echo  base_url('assets/images/').$my_carrier['currier_logo'];?>"> Tracking Numbers <i class="fa fa-angle-up tab-down" id="shipping_tracking_colapse" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="shipping_tracking" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFourth">
                                                <?php
                                                if(!empty($order_info['labels_pdf'])){ ?>
                                                    <div class="button-place col-xs-12">
                                                        <a href="<?php echo base_url('stream/labels/'.$order_info['labels_pdf'].'/'.sample_hash($order_info['user_id'])); ?>" target="_blank" class="no_white_space butt_small_padding btn btn-default btn-login-orange print_modal_butt apply-promotion col-xs-10 no_transform"><i class="fa fa-print "></i> Print shipping label(s)</a>
                                                    </div>
                                                <?php } ?>
                                                <div class="panel-body white panel-table-block">
                                                    <table class="table-default">
                                                        <thead>
                                                        <tr>
                                                            <th width="25">#</th>
                                                            <th class="text-center">Type</th>
                                                            <th class="text-center">Tracking #</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if(!empty($order_info['tracking_number']['tracking_number'])){

                                                            foreach ($order_info['tracking_number']['tracking_number'] as $index => $value){

                                                                if($value['weight']%1 != 0){

                                                                    $weight = explode('.',$value['weight']);
                                                                    $weight = intval($weight[0]).'.'.intval($weight[1]);

                                                                }else{

                                                                    $weight = intval($value['weight']);
                                                                }
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $index+1;?></td>
                                                                    <td class="text-center"><?php echo $weight;?> lbs <?php echo $value['type_name']?></td>
                                                                    <td class="text-center" ><span class="orange-color link_tracking" data_number = "<?php echo $order_info['id'].'_'.$value['luggage_id'].'_'.$value['tracking_number']; ?>"><?php echo $value['tracking_number']?></span></td>
                                                                </tr>
                                                            <?php   }  }else{
                                                            $colum_text = true;
                                                            foreach ($order_info['tracking_number'] as $index => $value){

                                                                if($value['weight']%1 != 0){

                                                                    $weight = explode('.',$value['weight']);
                                                                    $weight = intval($weight[0]).'.'.intval($weight[1]);

                                                                }else{

                                                                    $weight = intval($value['weight']);
                                                                }

                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $index+1;?></td>
                                                                    <td class="text-center"><?php echo $weight;?> lbs <?php echo $value['type_name']?></td>
                                                                    <?php if($colum_text) {
                                                                        ?>
                                                                        <td rowspan="<?php echo count($order_info['tracking_number']); ?>">
                                                                        <span class="orange-color tracking_info">
                                                                        We have Processed <br> your order and will <br> update your tracking number soon.
                                                                        </span>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    $colum_text = false;
                                                                    ?>
                                                                </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php

                                                    $country_iso3 = ($country_receiver_info['iso3'] == null)?'Not available':$country_receiver_info['iso3'];
                                                    ?>
                                                    <p class="text-center"> <?php echo $order_info['currier_name']." ".$country_iso3. " Hotline: ". $country_prof_info_receiver['hotline']; ?></p>

                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                        <?php
                                        if($order_info['shipping_type'] == 1){ ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading light-color" role="tab" id="headingSixth">
                                                    <h4 class="panel-title text-left small-text">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#item_list_passport" aria-expanded="false" aria-controls="headingSixth">
                                                            Item List/Passport/Travel Itinerary <i class="fa fa-angle-up tab-down" id="item_list_i" aria-hidden="true"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="item_list_passport" class="panel-collapse collapse in item_list_passport" role="tabpanel" aria-labelledby="headingSixth">
                                                    <div class="panel-body white panel-table-block">
                                                        <ul class="document-label item-list">
                                                            <li>
                                                                <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                    <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                                                    <i class="<?php echo $class1; ?>"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                    <img class="" src="<?php echo base_url(); ?>assets/images/passport.svg">
                                                                    <i class="<?php echo $class2; ?>"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                    <img class="" src="<?php echo base_url(); ?>assets/images/airplane.svg">
                                                                    <i class="<?php echo $class3; ?>"></i>
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <div class="text-center">
                                                            <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>" class="btn btn-default small-button btn-login-orange col-md-12">Please Complete Item List</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>
                        </div>
                            </div>
                        </div>
                            <?php } else{ ?>

                        <div class="right-part ">
                            <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">
                                <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading light-color" role="tab" id="headingFifth">
                                            <h4 class="panel-title text-left">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#pickup_confirmation" aria-expanded="false" aria-controls="headingFifth">
                                                    <img src="<?php echo base_url('assets/images/').$my_carrier['currier_logo']; ?> <?php echo ($sender_info['pick_up'] != 1)?'Pickup Confirmation':' Drop-off Confirmation'?>  <i class="fa fa-angle-up tab-down" id="pick_up_colapse" aria-hidden="true"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="pickup_confirmation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFifth">
                                            <div class="panel-body white panel-table-block">

                                                <div class="panel-body white panel-table-block text-center">
                                                    <?php
                                                    if($sender_info['pick_up'] == 2){
                                                        if(empty($shedule_pickup['date'])){
                                                        ?>

                                                        <p  class="dropp_off_inf">Pick up will be arranged within 2 business days from the shipping date.</p>
                                                    <?php } }else{ ?>

                                                        <p>You may drop-off your luggage any time after you receive your label. </p>

                                                    <?php } ?>

                                                    <p><a href="<?php echo base_url('faq'); ?>" class="blue-color" target="_blank">View instructions</a></p><br />
                                                    <?php

                                                    $country_iso3_sender = ($country_sender_info['iso3'] == null)?'Not available':$country_sender_info['iso3'];
                                                    ?>
                                                    <p class="text-center hotline_text"><?php echo $order_info['currier_name']." ". $country_iso3_sender. " Hotline: ". $country_prof_info_sender['hotline']; ?></p>
                                                    <div class="text-center">
                                                        <?php
                                                        if($sender_info['pick_up'] == 2){ ?>

                                                            <a href="#" class="btn btn-default small-button select-doc-file  white-space drop_off_location">Find a drop off location if can’t wait</a>
                                                        <?php }else{ ?>

                                                            <a href="#" class="btn btn-default small-button select-doc-file  white-space drop_off_location">Find a drop off location</a>

                                                        <?php } ?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading light-color" role="tab" id="headingFourth">
                                            <h4 class="panel-title text-left">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#shipping_tracking" aria-expanded="false" aria-controls="headingFourth">
                                                    <img src="<?php echo  base_url();?>assets/images/fedex.png"> Documents &Tracking # <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                                                </a>
                                            </h4>
                                        </div>

                                        <div id="shipping_tracking" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFourth">
                                            <div class="panel-body white panel-table-block">
                                                <?php if($order_info['shipping_type'] == '1'){ ?>
                                                <ul class="document-label">
                                                        <?php if (!empty($uploaded_document)) {

                                                                foreach ($uploaded_document as $document) { ?>
                                                                  <li>
                                                                    <a href="<?php echo base_url('order/user_file/' . $document['file_name'] . '/' . $order_info['id']); ?> ">
                                                                        <img class="" src="<?php echo base_url();?>assets/images/download-note.svg">
                                                                        <span>Item List</span>
                                                                    </a>
                                                                </li>
                                                                <?php } } ?>
                                                    <?php
                                                    if(!empty($travel_info_file)){

                                                        foreach ($travel_info_file as $trav_info){ ?>

                                                            <li>
                                                                <a href="<?php echo base_url('order/user_file/'.$trav_info['file_name'].'/'.$order_info['id']); ?> ">
                                                                    <img class="" src="<?php echo base_url();?>assets/images/download-note.svg">
                                                                    <span>Itinerary</span>
                                                                </a>
                                                            </li>
                                                   <?php } } ?>
                                                </ul>

                                                <p class="download-label">Please Download Label and  Shipping Instruction</p>
                                                <?php } ?>

                                                <table class="table-default">
                                                    <thead>
                                                    <tr>
                                                        <th width="25">#</th>
                                                        <th class="text-center">Type</th>
                                                        <th class="text-center">Tracking #</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                    if(!empty($order_info['tracking_number']['tracking_number'])){

                                                        foreach ($order_info['tracking_number']['tracking_number'] as $index => $value){ ?>

                                                            <tr>
                                                                <td><?php echo $index+1;?></td>
                                                                <td class="text-center"><?php echo $value['weight'];?> lbs <?php echo $value['type_name']?></td>
                                                                <td class="text-center"><span class="orange-color"><?php echo $value['tracking_number']?></span></td>
                                                            </tr>
                                                        <?php   }  }  ?>
                                                    </tbody>
                                                </table>
                                                <?php

                                                $country_iso3 = ($country_receiver_info['iso3'] == null)?'Not available':$country_receiver_info['iso3'];
                                                ?>
                                                <p class="text-center"> <?php echo $order_info['currier_name']." ".$country_iso3. " Hotline: ". $country_prof_info_receiver['hotline']; ?></p>

                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                    if($order_info['shipping_type'] == 1){ ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading light-color" role="tab" id="headingSixth">
                                                <h4 class="panel-title text-left small-text">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#item_list_passport" aria-expanded="false" aria-controls="headingSixth">
                                                        Item List/Passport/Travel Itinerary <i class="fa fa-angle-up tab-down" id="item_list_i" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                                </h4>
                                            </div>
                                            <div id="item_list_passport" class="panel-collapse collapse in item_list_passport" role="tabpanel" aria-labelledby="headingSixth">
                                                <div class="panel-body white panel-table-block">
                                                    <ul class="document-label item-list">
                                                        <li>
                                                            <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                                                <i class="<?php echo $class1; ?>"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                <img class="" src="<?php echo base_url(); ?>assets/images/passport.svg">
                                                                <i class="<?php echo $class2; ?>"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>">
                                                                <img class="" src="<?php echo base_url(); ?>assets/images/airplane.svg">
                                                                <i class="<?php echo $class3; ?>"></i>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="text-center">
                                                        <a href="<?php echo base_url('order/custom_documents_view/'.$order_info['id']); ?>" class="btn btn-default small-button btn-login-orange col-md-12">Please Complete Item List</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                  <?php  }  } ?>

                <div class="left-part">
                    <?php if($order_info['shipping_status'] >= PROCESSED_STATUS[0] && $order_info['shipping_status'] <= PROCESSED_CANCEL_STATUS[0]){ ?>
                        <div class="panel-group designed-tabs" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default " id="sender_pickup_main">
                                <div class="panel-heading order_process_accordion" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a  role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#sender_and_pick_up" aria-expanded="true" aria-controls="collapseOne">
                                            Sender & Origin Address <i class="fa fa-angle-down tab-down colapse_icon" id="colapse_icon_sender" aria-hidden="true"></i> <i class="fa verified-icon">1</i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="sender_and_pick_up" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <form method="post" action="">
                                            <div class="display-table">
                                                <div class="half-block">
                                                    <div class="min-block order-shipping-date">
                                                        <h2>Shipping Date and Time</h2>
                                                        <div class="form-horizontal">
                                                            <div class="form-group">
                                                                <div class="col-sm-12 col-xs-12">
                                                                    <p> <span class="shiping_time">Shipping Date: </span><span class="orange-color"><?php echo date("M-d-Y", strtotime($sender_info['shipping_date'])); ?></span></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">

                                                                    <?php if($sender_info['pick_up'] == 1){ ?>
                                                                <div class="col-sm-12 col-xs-12 drop-off">
                                                                        <span class="droppoff">Drop Off Luggage:</span>
                                                                </div>
                                                                    <?php  }else{
                                                                        $pikup = ($sender_info['pickup_time'] == 'no_data')?'I will confirm pick up time later':$sender_info['pickup_time'];
                                                                        ?>
                                                                <div class="col-sm-12 col-xs-12">
                                                                       Pick Up Time :<span class="orange-color"> <?php echo $pikup ?></span>
                                                                </div>
                                                                    <?php } ?>

                                                            </div>
                                                            <?php
                                                                    if($sender_info['shipping_date'] == date('Y-m-d')){

                                                            $check_date = 1;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="min-block">
                                                        <h2>
                                                            Sender Information (Shipper) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="The “shipper” is the person who is sending the shipment." data-original-title="" title="" aria-describedby="popover942646"></span>
                                                        </h2>
                                                        <div class="form-horizontal">

                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">First Name<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['sender_first_name'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['sender_last_name'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone Number<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['sender_phone'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Email:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['sender_email'];?></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="half-block">
                                                    <div class="min-block">
                                                        <h2>
                                                            Sender & Origin Address (From) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                       If you are dropping off, you may put your current address, such as a hotel, business or residence. You may also use the drop-off location as your pick-up (from) address.
                        " data-original-title="" title="" aria-describedby="popover942646"></span>
                                                        </h2>
                                                        <div class="form-horizontal">

                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Organization:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['pickup_company'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['pickup_address1'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['pickup_address2'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['pickup_postal_code'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $sender_info['pickup_city'];?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $pickup_state;?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $country_from;?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark: </label>
                                                                <div class="col-sm-7 col-xs-7 mob-input orange-color">
                                                                    <?php echo $sender_info['pickup_remark'];?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default " id="receiver_delivery_main">
                                <div class="panel-heading order_process_accordion" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#receiver_delivery" aria-expanded="false" aria-controls="collapseTwo">
                                            Receiver & Destination Address <i class="fa fa-angle-down tab-down colapse_icon" id="colapse_icon_receiver" aria-hidden="true"></i> <i class="fa verified-icon">2</i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="receiver_delivery" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <form method="post" action="">
                                            <div class="display-table">
                                                <div class="half-block">
                                                    <div class="min-block order-shipping-date">
                                                        <h2>Shipping Date and Time</h2>
                                                        <div class="form-horizontal">
                                                            <div class="form-group">
                                                                <div class="col-sm-12 col-xs-12 receiver_shipping_date">
                                                                    <p>Delivery Date: <span class="orange-color"><?php echo date("M-d-Y", strtotime($receiver_info['delivery_date'])); ?></span></p>
                                                                    <p>Delivery Time: <span class="orange-color"><?php echo $receiver_info['delivery_time']; ?></span></p>
                                                                    <p>Signature: <span class="orange-color"><?php echo (empty($receiver_info['without_signature']))? 'Delivery Signature Require':'No Delivery Signature Require '; ?> </span>  <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Delivery time and   Without Signature" data-original-title="" title="" aria-describedby="popover942646"></span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="min-block">
                                                        <h2>
                                                            Receiver Information (Receiver) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="The “receiver” is the person who will ACCEPT this shipment at the destination" data-original-title="" title="" aria-describedby="popover942646"></span>
                                                        </h2>
                                                        <div class="form-horizontal">

                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">First Name<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['receiver_first_name']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['receiver_last_name']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone Number<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['receiver_phone']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Email:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['receiver_email']; ?></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="half-block">
                                                    <div class="min-block">
                                                        <h2>
                                                            Destination Address (To) <!--<span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title="" aria-describedby="popover942646"></span>-->
                                                        </h2>
                                                        <div class="form-horizontal">

                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Organization:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['delivery_company']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['delivery_address1']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['delivery_address2']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['delivery_postal_code']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $receiver_info['delivery_city']; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $delivery_state; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country<span class="important">*</span>:</label>
                                                                <div class="col-sm-7 col-xs-7 mob-input">
                                                                    <p class="static-value orange-color"><?php echo $country_to; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark: </label>
                                                                <div class="col-sm-7 col-xs-7 mob-input orange-color">
                                                                 <?php echo $receiver_info['delivery_remark']; ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default " id="payment_main">
                                <div class="panel-heading order_process_accordion" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#payment_information" aria-expanded="false" aria-controls="collapseThree">
                                            Payment Information <i class="fa fa-angle-up tab-down colapse_icon" id="colapse_icon_payment" aria-hidden="true"></i> <i class="fa verified-icon">3</i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="payment_information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body panel-table-block">

                                        <div class="col-md-8 mobile-no-padding">
                                            <table class="table designed-table table-bordered t-payment">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Card #</th>
                                                    <th>Date</th>
                                                    <th>Charege / <span class="orange-color">Refund</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $total_refaund = 0;
                                                $total_charge  = 0;
                                                if(!empty($pay_history)){

                                                    foreach ($pay_history as $index => $pay_info){

                                                        if($pay_info['amount'] == 0){

                                                            continue;
                                                        }

                                                        if($pay_info['type'] == '1'){

                                                            $total_charge += $pay_info['amount'];
                                                            $charge = true;

                                                        }else{

                                                            $total_refaund += $pay_info['amount'];
                                                            $charge = false;
                                                        }

                                                        if(preg_match('/^[0-9]*$/', $pay_info['card_number'])){

                                                            $card_num = '********'.substr($pay_info['card_number'],-4,4);
                                                        }else{

                                                            $card_num = $pay_info['card_number'];
                                                        }

                                                        ?>

                                                        <tr>
                                                            <td><?php echo $index + 1; ?></td>
                                                            <td><?php echo $card_num; ?></td>
                                                            <td><?php echo $pay_info['date']; ?></td>
                                                            <td><?php echo ($charge)?'$'.$pay_info['amount']:'<span class="orange-color">($'.$pay_info['amount'].')</span>'; ?></td>
                                                        </tr>

                                                    <?php }

                                                } ?>

                                                </tbody>
                                            </table>
                                            <div class="total-payment text-right">
                                                <p>Total Charge : <strong>$<?php echo $total_charge; ?></strong></p>
                                                <p>Total Refund : <strong>$<?php echo $total_refaund ; ?></strong></p>
                                            </div>
                                        </div>

                                        <?php if(!empty($invoice)) { ?>

                                        <div class="col-md-4">
                                            <ul class="invoice">
                                                <?php
                                                foreach ($invoice as $single){ ?>
                                                    <li>
                                                        <a href="<?php echo base_url('dashboard/invoice_file/' . $order_info['id'] . '/' .$single['pdf_file'])?>" target="_blank">
                                                            <img class="" src="<?php echo  base_url();?>assets/images/invoice.png">
                                                            <span><?php echo $single['type'];?><br />Invoice</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <p class="download-invoice">Please download invoices for detail charges</p>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 accept-group text-right">
                                <?php if($order_info['shipping_status'] >= INCOMPLETE_STATUS[0] && $order_info['shipping_status'] <= PROCESSED_STATUS[0]){ ?>

                                    <div class="button-place">
                                        <button type="submit" class="btn btn-default select-doc-file save-action cansel_order">Cancel Order</button>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    <?php }else{
                        ?>

                        <?php
                        if($order_info['shipping_status'] == SUBMITTED_STATUS[0] && $order_info['shipping_type'] == 1){

                            $link = ($order_info['shipping_status'] == SUBMITTED_STATUS[0])?base_url('order/custom_documents/'.$order_info['id']):base_url('order/custom_documents_view/'.$order_info['id']);
                            ?>
                            <div class="panel-group designed-tabs mobile_version" id="accordion2" role="tablist" aria-multiselectable="true">
                                <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">

                                    <div class="panel panel-default">
                                        <div class="panel-heading light-color" role="tab" id="headingSixth">
                                            <h4 class="panel-title text-left small-text">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#item_list_passport" aria-expanded="false" aria-controls="headingSixth">
                                                    Item List/Passport/Travel Itinerary <i class="fa fa-angle-up tab-down" id="item_list_i" aria-hidden="true"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="item_list_passport" class="panel-collapse collapse in item_list_passport" role="tabpanel" aria-labelledby="headingSixth">
                                            <div class="panel-body white panel-table-block">
                                                <ul class="document-label item-list">
                                                    <li>
                                                        <a href="<?php echo $link; ?>">
                                                            <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                                            <i class="<?php echo $class1; ?>"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $link; ?>">
                                                            <img class="" src="<?php echo base_url(); ?>assets/images/passport.svg">
                                                            <i class="<?php echo $class2; ?>"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo $link; ?>">
                                                            <img class="" src="<?php echo base_url(); ?>assets/images/airplane.svg">
                                                            <i class="<?php echo $class3; ?>"></i>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="text-center">
                                                    <a href="<?php echo $link; ?>" class="btn btn-default small-button btn-login-orange col-md-12">Please Complete Item List</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <div class="panel-group designed-tabs" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default"  id="sender_pickup_main">
                            <div class="panel-heading order_process_accordion" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" class="sender_butt collapsed" data-toggle="collapse" data-parent="#accordion" href="#sender_and_pick_up" aria-expanded="true" aria-controls="collapseOne">
                                        Sender & Origin Address <i class="fa fa-angle-down tab-down colapse_icon" id="colapse_icon_sender" aria-hidden="true" ></i>
                                        <i class="<?php echo $sender_class; ?>" id="sender_pickup">1</i>
                                    </a>
                                </h4>
                            </div>
                            <div id="sender_and_pick_up" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body sender_pickup_body">

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default " id="receiver_delivery_main">
                            <div class="panel-heading order_process_accordion" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed receiver_butt receiver_delivery_butt"  role="button" data-toggle="collapse" data-parent="#accordion" href="#receiver_delivery" aria-expanded="false" aria-controls="collapseTwo">
                                        Receiver & Destination Address <i class="fa fa-angle-down tab-down colapse_icon" id="colapse_icon_receiver" aria-hidden="true" ></i>
                                        <i class="<?php echo $delivery_class; ?>" id="receiver_delivery_icon">2</i>
                                    </a>
                                </h4>
                            </div>
                            <div id="receiver_delivery" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body receiver_delivery_body">

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default " id="payment_main">
                            <div class="panel-heading order_process_accordion" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed payment_information" role="button" data-toggle="collapse" data-parent="#accordion" href="#payment_information" aria-expanded="false" aria-controls="collapseThree">
                                        Payment Information <i class="fa fa-angle-down tab-down colapse_icon" id="colapse_icon_payment" aria-hidden="true"></i>
                                        <i class="<?php echo $payment_class; ?>" id="payment_info_icon">3</i>
                                    </a>
                                </h4>
                            </div>
                            <div id="payment_information" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">

                                <div class="panel-body white payment_info_body">
                                    <div class="order-colored-block" id="discount_answer">

                                    </div>
                                    <div class="payment_info_body_answer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12 accept-group text-right">
                            <?php
                            if($order_info['shipping_status'] < SUBMITTED_STATUS[0]){ ?>

                               <p> <input type="checkbox" name="accept">
                                 <span class="pc_version">  <span class="hidden-xs pull-left">I Accept Luggage To Ship   </span> <a href="#" class="terms_conditions">&nbsp Terms & Conditions</a> and will not ship <a href="<?php echo base_url('what-cant-ship')?>">prohibited items</a></span>
                                 <span class="mobile_version acept_mobile_version">I Accept Luggage To Ship  <a href="#" class="terms_conditions">&nbsp Terms & Conditions</a> and will not ship <a href="<?php echo base_url('what-cant-ship')?>">prohibited items</a></span></p>
                           <?php } ?>
                                <div class="button-place " id="all_buttons_div">
                                    <?php if(!empty($admin_tool)) {?>
                                        <button type="button" id="update_item" class="btn btn-default btn-login-blue apply-promotion">Edit Item(s) or Service</button>
                                        <button type="button" class="btn btn-default btn-login-orange adjust-function">Save Changes</button>
                                    <?php }
                                    else if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){ ?>
                                        <button type="submit" class="btn btn-default select-doc-file save-action cansel_order">Cancel Order</button>
                                        <button type="button" id="update_item" class="btn btn-default btn-login-blue apply-promotion">Edit Item(s) or Service</button>
                                       <!-- <button type="button" id="update_modal_show" class="btn btn-default btn-login-orange apply-promotion">Update</button>-->
                                    <?php }
                                    else{ ?>
                                        <button type="button" id="update_item" class="btn btn-default btn-login-blue apply-promotion">Edit Item(s) or Service</button>
                                        <button type="button" id="order_submit" class="btn btn-default btn-login-orange apply-promotion">Submit</button>
                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            <?php if($order_info['shipping_status'] == INCOMPLETE_STATUS[0] || $order_info['shipping_status'] == SUBMITTED_STATUS[0]){ ?>
            <div class="right-part pc_version">
                <?php
                if($order_info['shipping_status'] == SUBMITTED_STATUS[0] && $order_info['shipping_type'] == 1){

                    $link = ($order_info['shipping_status'] == SUBMITTED_STATUS[0])?base_url('order/custom_documents/'.$order_info['id']):base_url('order/custom_documents_view/'.$order_info['id']);
                ?>
                    <div class="panel-group designed-tabs ps_version" id="accordion2" role="tablist" aria-multiselectable="true">
                    <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                    <div class="panel-heading light-color" role="tab" id="headingFifth">
                        <h4 class="panel-title text-left small-text">
                            <a class="" role="button" data-toggle="collapse" data-parent="#accordion2" href="#pickup_confirmation" aria-expanded="false" aria-controls="headingFifth">
                                Item List/Passport/Travel Itinerary <i class="fa fa-angle-up tab-down" id="pick_up_colapse" aria-hidden="true"></i>
                            </a>
                        </h4>
                    </div>
                    <div id="pickup_confirmation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFifth">
                    <div class="panel-body white panel-table-block">

                    <div class="panel-body white panel-table-block text-center">
                        <ul class="document-label item-list">
                            <li>
                                <a href="<?php echo $link; ?>">
                                    <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                    <i class="<?php echo $class1; ?>"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $link; ?>">
                                    <img class="" src="<?php echo base_url(); ?>assets/images/passport.svg">
                                    <i class="<?php echo $class2; ?>"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $link; ?>">
                                    <img class="" src="<?php echo base_url(); ?>assets/images/airplane.svg">
                                    <i class="<?php echo $class3; ?>"></i>
                                </a>
                            </li>
                        </ul>

                        <div class="text-center">
                            <a href="<?php echo $link; ?>" class="btn btn-default small-button btn-login-orange col-md-12">Please Complete Item List</a>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>

                        </div>
                    </div>
<?php } ?>
                <div class="progress-small-block">
                    <div class="bl-header text-center">
                        Item(s)&nbsp&  Insurance
                    </div>
                    <div class="bl-content">
                        <p class="selected-items-title orange-color"><?php echo $count; ?> Items Selected
                            <span class="popover-style secure-code edit_popover_country up_to_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Click the item name to see the weight and size details. Please do not exceed the max. weight and size. If you would like to add or remove items, please click  <button type='button' id='update_item_pop_country' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                        </p>

                        <ul class="selected-items">
                            <?php

                            if(!empty($data_prod)){
                                foreach ($data_prod as $key => $prods){

                                    $img = $prods['image'];
                                    unset($prods['image']);
                                    $img = ($img == 'icon-luggage')?'icon_luggage':$img;
                                    ?>

                                    <li>
                                        <div class="image-part">
                                            <i class="<?php echo $img;?>"></i>
                                        </div>
                                        <div class="text-part">
                                            <?php
                                            foreach ($prods as $name => $prod){

                                                $prod_class = ($name != 'Special Boxes')?'blue-color':'';
                                                if(!empty($prod['sizes_image'])){
                                                ?>
                                                <span class="<?php echo $prod_class; ?> order_prod_span" data-html="true" class="popover-style home-separate-pop luggage_info_popover_img" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-selector = "true" data-content="
                                                            <div class = 'luggage_info_popover_order'>
                                                                <h5><?php echo $name; ?></h5>
                                                                <hr />
                                                                 <img src='<?php echo  base_url();?>assets/images/<?php echo $prod['sizes_image'];?>'>
                                                                 <p>Check the size and weight of each piece,<br> if the weight and size exceed the max, amount, <br> additional charges may incur.</p>
                                                            </div>">
                                                    <?php echo $prod['count']. '&nbsp &nbsp'.$name; ?>
                                                </span>

                                            <?php } else {
                                                    ?>
                                                    <span class="<?php echo $prod_class; ?>">
                                                    <?php echo $prod. '&nbsp &nbsp'.$name; ?>
                                                </span>
                                            <?php
                                                }
                                            }?>
                                        </div>
                                     <!--   <span class="luggage-count hidden-lg hidden-md">-2-</span>-->
                                    </li>

                                <?php } }?>
                        </ul>
                        <?php
                        $insurance_true = true;
                        if(!empty($incurance_zero)){

                            $incurance_price = $incurance_zero;
                            $incurance_price1 =  "$".$incurance_zero." "."Insurance" ;
                            $incurance_price2 =  "(+ $".$incurance_fee.")" ;


                         }else{

                            if(!empty($order_info['free_insurance'])){
                                $incurance_price = $order_info['free_insurance'] * $count;
                                $free_incurance  = 'Free';
                                $incurance_price1 = "$".$order_info['free_insurance'] * $count ." "."Insurance" ;
                                $incurance_price2 =  "(+".$free_incurance.")" ;

                            }else{

                                $incurance_price1 = '';
                                $incurance_price2 = '';
                                $incurance_price = '';
                                $insurance_true = false;
                            }



                        } ?>
<!--
                        <p>
                            Click the item name to see the weight and size details. Please do not exceed the max. weight and size.
                        </p>-->
                        <p class="selected-items-title "> <span class="incurance_class orange-color"><?php
                                if(!empty($insurance_true)){ ?>
                                Up to <?php echo $incurance_price1; ?></span>&nbsp <span class="free_insurance"><?php echo $incurance_price2;?></span>

                                <?php } ?>
                            <span class="popover-style secure-code up_to_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Up to 100USD free insurance coverage is provided for each luggage. You may purchase additional insurance coverage for your shipment. The insurance will ONLY cover lost or extremely damaged luggage/parcel. The insurance does NOT cover fragile items, electronics, prohibited Items, cosmetic damage of luggage, or any other items specified in our Terms and Conditions."  data-original-title="" title="" aria-describedby="popover942646"></span>
                        </p>
                        <p>
                            <?php
                            $min_insurance = '';

                            if(!empty($incurance_info['insurance_price'])){

                                foreach ($incurance_info['insurance_price'] as $single){

                                    if(empty($single['insurance_fee'])){
                                        $min_insurance = $single['insurance_amount'];
                                    }
                                }
                            }
                            ?>
                            <span class="">You may purchase additional insurance coverage for this shipment.</span>
                        </p>

                        <div class="form-group">
                            <label class="btn btn-default btn-file select-doc-file select_doc_file_label">
                                <a href="#" class="default_button insurance_button"> Add More Insurance</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="progress-small-block">
                    <div class="bl-header text-center">
                        Label Delivery
                    </div>
                    <div class="bl-content">
                        <p>
                            We will try to mail you the shipping labels and pouches for free.
                            Please confirm the label delivery address if it is different from the pick up address.

                        </p>

                        <div class="form-group">
                            <label class="btn btn-default btn-file select-doc-file select_doc_file_label">
                                <a href="#" class="default_button delivery_label">Delivery Label to a  Different Address</a>
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>

            <?php } ?>

            <!-- modal forms -->
        </div>
    </div>
</div>

<div id="delivery_label_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade ">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mobile_padding_in_popap" id="delivery_label">

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

<div class="modal fade login-fast inform-fast modal fade in" id="date_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">Same Day Shipment</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div>
                    Due to the different time zone and carrier business hours, same day shipping services is not guaranteed.
                    If your shipment is urgent, please complete the order and call us at 1-800-678-6167. We will try our best to assist you.
                    If your shipment is not urgent, you may click  "Edit Item(s) or Service" button to change the shipping date. Thank you very much!
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade login-fast inform-fast modal fade in" id="update_item_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">Update  Item or Service Type</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body mobile_padding_in_popap">
                <div class="update_item_content">
                    Please be advised you will need to fill in necessary
                    information and promotion code again if you would like
                    to update item or services.
                </div>
                <div class="update_item_text">Are you sure to update the item or services of this order?</div>
                <div>
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-default btn-login-orange save-action yes_update">YES</button>
                        <button type="button" class="btn btn-default btn-login-orange save-action no_update">NO</button>
                    </div>
                    <br class="clear">
                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal fade login-fast inform-fast modal fade in" id="signature_check_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">Delivery With Out Signature</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body mobile_padding_in_popap">
                <div class="update_item_content">
                    In selecting this option, you authorized the carrier to leave the package at the delivery address without signature required.
                    Once delivered, Luggage To Ship is not responsible for any item delivered without the signature.
                </div>
            </div>

        </div>

    </div>
</div>

<div id="insurance_modal_add" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade ">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body insurance_mobile_padding" id="order_incurance">

            </div>
        </div>
    </div>
</div>



<div class="modal fade login-fast inform-fast modal fade in" id="disable_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">Please complete Order</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body mobile_padding_in_popap">
                <div class="update_item_content">
                    please complete and save ①②③ to submit the order.
                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade login-fast inform-fast modal fade in" id="shippo_error_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content mobile_padding_in_popap">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide delivery_mobile_adding ">
                <h2 class="register-title text-center lovercase small_text_mobile">Thank you for  submitting order</h2>

                <div class="first_text text-center">
                    <h4 class="title">The order confirmation email has been emailed to you <?php echo $order_info['order_id']; ?></h4>
                    <p>
                        We will process your order and email you the shipping label (s) as soon as possible.
                        You may edit order or change item(s)/ services anytime before the order is processed.
                    </p>
                    <p>
                        If you have any questions on this order, please contact us at <br><span class="blue-color">cs@luggagetoship.com </span>  or <span class="blue-color">1800 678 6167 </span><br>
                        Our office hours are Monday- Friday 9:00am to 6:00pm EST
                    </p>
                </div>

                <div class="button-place text-center">
                        <button type="button" class="btn btn-default btn-login-orange no_transform apply-promotion close_error_modal butt_small_padding">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade login-fast inform-fast modal fade in" id="shippo_label_error_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content mobile_padding_in_popap">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <input type="hidden" id="order_id" value="<?php echo $order_info['order_id']; ?>">
            <div class="modal-body  register-block no-hide delivery_mobile_adding ">
                <h2 class="register-title text-center lovercase small_text_mobile">Thank you for  submitting order</h2>

                <div class="first_text text-center ">
                    <h4 class="title ">The order confirmation email has been emailed to you. <br /> Order Number <?php echo $order_info['order_id']; ?></h4>
                    <p class="no_justify">
                        We will email  you the shipping label(s) as soon as possible
                    </p>
                    <p class="no_justify">
                        If you have any questions on this order, please contact us at <span class="blue-color">cs@luggagetoship.com </span>  or <span class="blue-color">1800 678 6167 </span>
                        Our office hours are Monday- Friday 9:00am to 6:00pm EST
                    </p>
                </div>

                <div class="button-place text-center">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_label_error_modal butt_small_padding no_transform">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade login-fast inform-fast modal fade in" id="shippo_success_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content mobile_padding_in_popap">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center lovercase small_text_mobile">Thank you for  submitting order</h2>

                <div class="first_text text-center">
                    <h4 class="title">Order Number # <?php echo $order_info['order_id']; ?></h4>
                    <p>
                        Your shipping label is ready Please click below button to print your shipping labels.
                    </p>

                    <p>
                        If you requested a pick up, the pick up confirmation will be emailed to you before the shipping date
                    </p>
                    <p>
                        If you have any questions, please contact us at, <span class="blue-color">cs@luggagetoship.com </span>  or <span class="blue-color">1800 678 6167 </span>
                        <br>
                        Our office hours are Monday- Friday 9:00am to 6:00pm EST
                    </p>
                </div>
                <div class="button-place col-xs-12">
                    <?php
                    if(!empty($order_info['labels_pdf'])){ ?>

                        <a href="<?php echo base_url('stream/labels/'.$order_info['labels_pdf'].'/'.sample_hash($order_info['user_id'])); ?>" target="_blank" class="no_white_space butt_small_padding btn btn-default btn-login-orange print_modal_butt apply-promotion col-xs-10 no_transform">Print shipping instructions and label(s)</a>
                   <?php }
                    ?>
                </div>

                <br class="clear">
            </div>

        </div>

    </div>
</div>

<?php if($order_info['shipping_status'] == SUBMITTED_STATUS[0]) { ?>

<div id="cancel_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mobile_padding_in_popap">
                <div class="register-block">

                    <h2 class="register-title lovercase text-center">Order Cancellation</h2>

                    <div class="form-horizontal text-left">
                        <p>Are you sure you want to cancel this order?</p>
                        <div id="buttons">
                            <button id='yes_cancel' class="btn btn-default btn-login-blue">Yes</button>
                            <button id='no_cancel' class="btn btn-default btn-login-orange"  >No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
else{
    ?>
<div id="cancel_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mobile_padding_in_popap">
                <div class="register-block">

                    <h2 class="register-title lovercase text-center">Order Cancellation</h2>

                    <div class="process_cancel_order text_center">
                        <p>
                            As the order has been processed, you will be charged:
                        </p>
                        <p>
                            - <?php echo (!empty($procesing_fee['cancelation_fee']))?$procesing_fee['cancelation_fee']:0; ?> USD cancellation fee.
                        </p>
                        <p>
                            - Other related fee may apply.
                        </p>
                        <p>
                            We will refund the difference within 15 days.
                        </p>
                        <div class="strong_text">
                            <p>
                            We strongly suggest you to reach out us at
                        </p>
                            <p>
                                <span class="orange-color">1800 678 6167 </span>  or
                                <span class="blue-color">cs@luggagetoship.com </span>
                            </p>
                            <p>
                                before you cancel the order.
                            </p>

                        </div>
                    </div>

                    <div class="form-horizontal text-left text_center">
                        <p>Are you sure you want to cancel this order?</p>
                        <div id="buttons">
                            <button id='yes_cancel'  class="btn btn-default btn-login-blue" >Yes</button>
                            <button id='no_cancel'   class="btn btn-default btn-login-orange">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="modal fade login-fast inform-fast modal fade in" id="updaeding_order_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content mobile_padding_in_popap">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-block no-hide">
                <h2 class="register-title text-center lovercase updeting_modal_font_size">Thank you for  updating your order</h2>

                <div class="first_text text-center">
                    <h5 class="title text-bold updeting_modal_font_size">Your order <?php echo $order_info['order_id']; ?> has been updated succesfully.</h5>
                    <p>
                        We will process the order and email you the shipping label before the shipping day.
                    </p>

                    <p>
                        Shall you have any question, please email us at
                    </p>

                    <p class="no_justify">
                        <span class="blue-color">cs@luggagetoship.com </span>  or <span class="text-bold">1800 678 6167   Monday </span>
                    </p>
                    <p> through Friday 9:00am to 6:00pm </p>
                </div>

                <div class="button-place text-center">
                    <button type="button" class="btn btn-default btn-login-orange apply-promotion close_error_modal close_update_modal no_transform">Close</button>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="trucking_modal" role="dialog">
    <div class="modal-dialog drop_off_locator">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="trucking_modal_content">

            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="term_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content terms_text_div">
            <div class="modal-header register-block no-hide">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="register-title"> Luggage To Ship Terms and Conditions</h2>
            </div>
            <div class="modal-body" >
                <div class="term_use_modal">
                    <p>
                        Welcome to the Luggage To Ship.com website (the "Website"). The website is owned and operated by Luggage To Ship Inc. (the “Luggage To Ship”) By using the                    website and any services of the website, you (refer to individuals or companies) agree to and acknowledge these teams and conditions (the “Terms”)
                    </p>

                    <h4 class="blue-color">Acceptance of Terms</h4>
                    <p>
                        Luggage To Ship will review the terms every quarter and may update or modify the terms by posting a revised terms on the website. No notification will be                     sent to you. You may check the revised terms at any time by visiting this page. By submitting an order through the website, you agree to and acknowledge                      the carrier’s (refer to the third-party shipping company Luggage To Ship used to provide the shipping services) terms and conditions as well.</p>
                    FedEx:  <a href="http://www.fedex.com/us/legal">http://www.fedex.com/us/legal</a><p>
                        DHL:    <a href="http://www.dhl-usa.com/en/express/shipping/shipping_advice/terms_conditions.html">http://www.dhl               .com/en/express/shipping/shipping_advice/terms_conditions.html</a>
                    <h4 class="blue-color">Use of the website</h4>
                    <p>As a condition of your use of the website, you warrant that:</p>
                    <ul>
                        <li>You are at least 18 years of age;</li>
                        <li>You possess the legal authority to create a binding legal obligation;</li>
                        <li>You will use the website in accordance with the terms;</li>
                        <li>You will only use the website to make legitimate reservations of services for you or the other person you are on behalf of</li>
                        <li>You will inform such other persons about the terms that apply to the services you have made on their behalf, including all rules and restrictions applicable thereto;</li>
                        <li>All information provided by you on website is true, accurate, current and complete;</li>
                        <li>If you opened an account with Luggage To Ship, you will safeguard your account information and will supervise and be completely responsible for any use of your account by you and anyone other than you.</li>
                        <li>You agree to comply with all applicable laws, statues, ordinances and regulations regarding use of Luggage To Ship services</li><br>
                    </ul>
                    <p>Luggage To Ship retain the right at our sole discretion to deny access to anyone to the website and the services at any time and for any reason, including, but not limited to, for violation of the terms. </p>

                    <h4 class="blue-color">Description of services</h4>
                    <p>Luggage To Ship provides a web platform to quote, arrange and facilitate the shipment and storage of luggage, boxes and sports equipment (the “Packages”). You select the carrier for your shipping order and acknowledge that Luggage To Ship will use the carrier to transport your packages. You acknowledge that the other third parties (refer to person or origination) at the pick up or delivery address of your order may be responsible for handing over or accepting your packages on behalf of you. Luggage To Ship or the carrier reserves the right to refuse, cancel, return or hold any shipment if the shipment does not comply with the terms, is undeliverable, may contain possible dangerous, illegal or prohibited items, or is not properly packed. You acknowledge that you ship your packages through the service at your own risk. If your packages are damaged or lost during the shipment, or are not delivered within a timely manner due to a failure of Luggage To Ship or the carrier, you may timely and properly request Luggage To Ship's assistance with submitting any claims to the carrier. Luggage To Ship and/or the carrier may conduct a reasonable investigation into your claim, but in no event is Luggage To Ship required or obligated to investigate any claims pertaining to lost, damaged or delayed shipment. You acknowledge and agree that your request for assistance from Luggage To Ship, and/or any reasonable investigation into your claim, does not entitle you to compensation or damages from Luggage To Ship, or any action or recourse by Luggage To Ship, and that a commercially reasonable investigation is your sole and exclusive remedy. You acknowledge that the Services are also subject to any terms imposed by subcontractors of Luggage To Ship and all currieries Luggage To Ship uses.
                    </p>

                    <h4 class="blue-color">Rates and rate adjustments</h4>
                    <p>Rates generated on the website, <a href="https://www.luggagetoship.com/">https://www.luggagetoship.com/</a> , or by a Luggage To Ship representative are based upon the information provided by you at the time of inquiry. Final rates will be based upon actual weights and dimensions verified by the carrier, and actual services provided by the carrier and Luggage To Ship.
                    </p>
                    <p>Dimensions are measured from the widest point of each side of the package. If the actual weight or dimensions of any shipped Item exceeds the maximum allowed for the quoted Item category, rates may adjust to reflect the billing weight. The billing weight is the greater one of the actual weight and dimensional weight of each package. The dimensional weight of an item can be calculated by multiplying length, width and height, in inches, and dividing by 139. </p>
                    <p>If additional service is provided to you include but not limited to address correction after pickup, package hold service, re-pick up service and so forth, related fee will be added to the finial rates as well.
                    </p>
                    <p>If the final rates differ from quoted rates, you acknowledge and agree Luggage To Ship to charge or refund the difference without notice. A final invoice with order breakdown will be provided to you after the finial charge or final refund is processed. </p>

                    <h4 class="blue-color">Delivery time and shipment delay</h4>
                    <p>The delivery time generated on the website,<a href="https://www.luggagetoship.com/">https://www.luggagetoship.com/</a>, or by a Luggage To Ship representative is based on the shipping date and services you selected. The actual delivery date will be based on the actual date the shipment is picked up by the carrier from the pickup address or the drop off location.</p>
                    <p>Luggage To Ship guarantees the delivery time for below express services:</p>
                    <ul>
                        <li>US domestic <b>Express</b>   1 day service</li>
                        <li>US domestic <b>Priority</b>  2 days service</li>
                        <li>US domestic <b>Standard</b>  3 days standard services </li>
                    </ul>
                    <p>Luggage To Ship will make every effort to communicate with the carrier and have them to deliver the package on time. In very few scenarios that a delay is occurred, Luggage To Ship accepts delay claim for above three shipping services (excluding delays caused by factors mentioned in following paragraph). You agree to send a claim request to Luggage To Ship by email within 7 business days from the delivery date. Luggage To Ship will file a claim with the carrier on behalf of you and provide related tracking evidence. Luggage To Ship will not be responsible for any direct or indirect loss caused by <b>shipment delay. You understand and agree that the compensation for shipment delay is up to the shipping fee for the delayed package(s). The carrier who provided shipping services has the right to review the claim and decide the finial</b> compensation amount for the delay.  Luggage To Ship will inform you the claim result after the carrier makes decision. If a compensation is issued by the carrier company, Luggage to ship will process the refund within 3 business days after receiving the claim decision.
                    </p>
                    <p>Luggage To Ship is not responsible for the shipment delay because of:</p>
                    <ul>

                        <li>dropping off package(s) after the service cut off time at the drop of location.</li>
                        <li>shipment on-hold requested by you</li>
                        <li>improperly packing or labelling of the package </li>
                        <li>wrong, inaccurate or incomplete delivery address or receiver information provided by you</li>
                        <li>business being closed or absence or refusal of a person to sign for the shipment at the delivery address</li>
                        <li>no response to custom’s requirements on additional documents in time. </li>
                        <li>custom delay, custom or carrier inspection</li>
                        <li>acts of the God (e.g. earthquake, storm, flood, fog etc.),</li>
                        <li>acts of public authorities acting with actual or apparent authority of law</li>
                        <li>strike, lock-out, stoppage or restraint of labor, the consequences of which we are unable to avoid by the exercise of reasonable diligence</li>
                        <li>any other uncontrollable delay reason listed on FedEx and DHL terms </li>
                    </ul>
                    <p>Luggage To Ship does not guarantee the delivery time for below services:</p>
                    <ul>
                        <li>US domestic Basic <strong>( 1 to 5 days )</strong> service</li>
                        <li>International Express services</li>
                        <li>International Economy service</li>
                    </ul>
                    <p>You acknowledge that there is no delivery time guarantee these services. Packages may be delivered before or after the estimated delivery date. </p>

                    <h4 class="blue-color">Order modification</h4>
                    <p>Luggage To Ship understands that travel schedules can change. You can modify the order online any time before the order is processed. No additional modification fee will be charged. You acknowledge and agree that Luggage To Ship will process the updated order and charge you at updated order total if the change is subject to a fee change.
                    </p>
                    <p>Luggage To Ship will assist you to modify the order after the order is processed. An order modification fee, no more than 25USD, may apply. You acknowledge and agree that Luggage To Ship will charge or refund the order difference if the modification results in a fee change.</p>
                    <p>Once the shipment is picked up by carrier, order cannot be modified anymore. In very few scenarios that a modification must be made to guarantee the delivery, such as correct the wrong delivery address, or request a shipment hold. Luggage To Ship will put all efforts to communicate with the carrier, but the result is not guaranteed. An extra processing fee will be charged by carrier and applied to you.</p>
                    <p>By modifying the order, you acknowledge and agree this terms and conditions as well.</p>


                    <h4 class="blue-color">Order cancellation</h4>
                    <p> If you cancel the order before Luggage To Ship processes the order, no cancellation fee will apply. If you cancel the order after the order is processed, a 25USD cancellation fee will apply. If a pick up is scheduled, the pickup fee is not refundable. If a label envelop has been sent to you before the cancellation, the label delivery fee will apply.  Luggage To Ship will complete the cancellation refund within 15 business days. You acknowledge that carrier has the right to cancel, reject or return any shipment because of prohibited, illegal, dangerous items. You are responsible for any additional fee occurred because of this kind of cancellation, rejection or return.
                    </p>

                    <h4 class="blue-color">Packing, Locking and Labelling</h4>
                    <p>It is your responsibility to select proper case or box, well pack and protect your items. You acknowledge that Luggage To Ship will not responsible for any damage, lost shipment because of improper packing.</p>
                    <p>You agree not to over pack, and exceed the package maximal size and maximal weight of the order. You agree to pay for the weight difference and related surcharges if the luggage exceeds the size and weight limitation of the item catalog when you place the order.</p>
                    <p>It is your responsibility to lock all packages for US domestic shipment. Luggage To Ship is not responsible for any lost item if the unlocked package is shipped domestically.</p>
                    <p>It is your responsibility not to lock all packages for international shipment. You understand that custom or carrier may return the locked package if they are not able to open it for a normal custom screen. Luggage To Ship is not responsible for any shipment delay because of the locked package.</p>
                    <p>It is your responsibility to follow the shipping instruction and correctly attach the shipping labels to the package. Luggage To Ship is not responsible for any lost, delay shipment because of the improper labelling</p>
                    <p>The shipping label Luggage To Ship created for one shipment can only be used for the package(s) you ordered. And the package(s) should be picked up or dropped off same time at the same location you requested in the order. Luggage To Ship is not responsible for any delay, return, loss, damage, custom or carrier abandon shipment if the label is used for more package(s), or package(s) shipped from different location or at different time. Luggage To Ship keeps the right to charge all additional cost billed from the carrier.</p>

                    <h4 class="blue-color">Prohibited items</h4>
                    <p>You agree that will not send anything which may be construed as illegal in any way such as stolen items. You acknowledge and agree that will not pack or ship prohibited items listed below:</p>
                    <ul>
                        <li>Animals, Animal products and human remains; </li>
                        <li>Aerosols or any other pressurized containers;</li>
                        <li>Alcohol, or any goods containing alcohol included perfume</li>
                        <li>Bullion, currency, or other forms of tradeable currency; Credit cards;</li>
                        <li>Batteries (included with personal device) (Only prohibited for international shipment)</li>
                        <li>drugs, including all illegal narcotics, all drugs prohibited by any jurisdiction through which your package will or may travel, as well as prescription drugs; medical samples.</li>
                        <li>Firearms and firearm parts, ammunition, explosives, weapons (including imitations of same);  </li>
                        <li>Flowers and plant products; (Only prohibited for international shipment)</li>
                        <li>Perishable food articles and beverages (Only prohibited for international shipment)</li>
                        <li>Hazardous materials, including, without limitation, hazardous or corrosive materials, explosives, flammable or combustible materials, infectious substances, poisons, dry ice, fireworks, or radioactive materials; and hazardous waste</li>
                        <li>Items that require a temperature controlled environment;</li>
                        <li>Pornography;</li>
                        <li>Tobacco</li>
                        <li>Valuables, high value or irreplaceable items including but not limited to antiques, paintings, jewelry, precious stones;</li>
                        <li>lottery tickets or gambling devices in violation of the laws of any jurisdiction through which your package will or may travel </li>
                        <li>Other Dangerous / hazardous goods, including, without limitation, hazardous or corrosive materials, explosives, flammable or combustible materials, infectious substances, poisons, dry ice, fireworks, or radioactive materials;</li>
                        <li>Other illegal or restricted goods defined by any shipping partner, or any local, state, federal, international law and regulation.</li><br>
                    </ul>
                    <p>You agree not to ship package(s) that are wet, leaking or emit an odor of any kind. Luggage To Ship retains the right to update the prohibited item list any time to comply with related law or regulation. Luggage To Ship and the carrier company reserve the right to open and inspect any item shipped by Luggage To Ship.
                    </p>
                    <p>For international shipment, there may be additional prohibited items specified by the country of origin and/or destination. The carrier may at its sole discretion refuse to carry other items not listed here. It is your responsibility to check the local custom law and regulation before the shipment.
                    </p>

                    <h4 class="blue-color">Pick up and drop off</h4>
                    <p>It is your responsibility to provide correct pick up address and instruction, and make sure all package(s) is correctly labelled and packaged before scheduled pickup time frame. You understand that carrier will not call before the pickup. It is your responsibility to hand over the shipment to carrier or to make sure the courier has easy access to the shipment. Luggage To Ship is not responsible for the missing pick up because of the wrong pick up address, package cannot be found or package is not ready. You understand that the pickup timeframe is not guaranteed. Carrier may go earlier or late on the pickup date due to the road condition and other reasons. Luggage To Ship is not responsible for any unsuccessful pick up caused by carrier’s faults.
                    </p>
                    <p>You understand that carrier may not confirm pick up due to weather, traffic or service area factors. Luggage To Ship will refund the pickup fee if the pickup cannot be confirmed by the carrier. Once the pickup is confirmed, the pickup fee is not refundable. If the pickup is failed because of your fault (such as package not ready, wrong pick up address etc.), Luggage To Ship reserve the right to charge the second pick up.
                    </p>
                    <p>Due to the time difference and office hours, the same day pick up services is not guaranteed. The same day pick up is not available for FedEx Basic service. The Saturday pick up is not available for DHL Express service and FedEx Basic Services. Luggage To Ship does not provide Sunday or holiday pick up for all services.
                    </p>
                    <p>It is your responsible to deliver the package before the service cut off time of carrier’s drop off location, and request a drop off receipt with drop off date, time and shipment tracking number. You acknowledge that will not drop off the shipment incorrectly to carrier’s street box or non-staffed shipping center. Luggage To Ship is not responsible for the shipment delay or lost because of the late drop off, incorrect drop off.
                    </p>

                    <h4 class="blue-color">Delivery and collection</h4>
                    <p>It is your responsibility to provide correct delivery address and delivery instruction. Luggage To Ship is not responsible for the delayed, lost, return shipment because of wrong, incomplete delivery address. You agree to have someone accepts package at the delivery address with a signature. Luggage To Ship is not responsible for any lost, missing package after delivery.
                    </p>
                    <p>If your package is damaged or broken on delivery, it is your responsibility to keep full evidence to assist Luggage To Ship to file a claim with the carrier. The evidences include but not limited to:
                    </p>
                    <ul>
                        <li>package picture with label</li>
                        <li>item pictures</li>
                        <li>putting “package damaged or broken” when sign for the package </li>
                    </ul>
                    <p>If you selected “delivery without signature” when placed the order, you understand that you are not able to file a claim once the shipment tracking shows delivered on carrier’s website.
                    </p>
                    <p>Carrier may try a second delivery if the first delivery attempt is failed. It is your responsibility to have someone to accept the shipment at the delivery address. Carrier may also hold the shipment at nearby station for your collection if the first delivery is failed. You agree to show your pictured ID to collect the shipment. Luggage To Ship will not cover the additional cost occurred for the luggage hold and collection.</p>
                    <p>If you do not collect shipment within the timeframe carrier is able to hold or the package is defined as an undeliverable package because of the wrong address, it will be returned by carrier. You are responsible for the return shipping fee and other additional cost for the return.</p>

                    <h4 class="blue-color">International Shipments</h4>
                    <p>Except the prohibited items listed above, it is your responsibility to check the destination countries custom regulation and make sure not to ship restricted or prohibited items. Luggage To Ship is not responsible for any shipment delay, hold and return because of the restricted or prohibited items</p>
                    <p>Every international shipment is subject to custom clearance, you are responsible for providing full and correct item list for Luggage To Ship to create custom invoice. It is also your responsibility to provide all other document the destination custom requests for clearance. You understand custom has the right to hold and open your package, check and re-value items inside the package, as well as charge the tax and duty based on the value they evaluated.
                    </p>
                    <p>If the sender or receiver is on the carrier, government, or united nations’ denied persons list, the carrier has the right to refuse, hold or return the shipment. You agree that Luggage To Ship is not responsible for the delay, return or refusal of the shipment. You acknowledge to cover all related fee, including but not limited to original shipping fee, return fee, investigation fee and so forth.
                    </p>
                    <p>You acknowledge and agree to be full responsible for the tax and duty, as well as the other custom charges, broker fees or custom warehouse fee if applied. If you refuse to pay for the tax and duty and the carrier charges the tax and duty to Luggage To Ship, Luggage To Ship has the right to charge your credit card at the billed amount.</p>
                    <p>Luggage To Ship is not responsible for the custom delay.  If you do not cooperate with the local custom department and provide necessary custom document or payment for the tax and duty, local custom has the right to hold, destroy packages according to the destination country's law and regulation. You agree to take the full responsibility for the loss and will not dispute the shipping services and shipping fee with Luggage To Ship.
                    </p>
                    <p>You understand that carrier has the right to deliver the package to a third-party broker for clearance per local custom’s regulation. You agree to cooperate with the carrier and the broker company for the clearance, and pay for broker fee and any related fee if applied. Luggage To Ship is not responsible for any custom delay, shipment return or destroy because you refuse to cooperate with the broker and the carrier.
                    </p>

                    <h4 class="blue-color">Missing shipment</h4>
                    <p>Luggage To Ship will keep monitoring shipment and will communicate with the carrier if the shipment tracking stop updating more than 3 business days. It is your responsibility to provide full and detailed package size, color and content information if the carrier is not able to locate the shipment. So, the carrier can search and try to find the missing package.
                    </p>
                    <p>If the carrier confirms unable to locate the package, Luggage To Ship will file a lost claim with the carrier once the other package(s) of the shipment is delivered. If the carrier finds and delivers the missing package, you may request a delay claim if apply to the “Shipment delay” part of this term.
                    </p>

                    <h4 class="blue-color">Insurance, liability and discretionary compensation</h4>
                    <p>Luggage To Ship provides free insurance coverage for each package is up to 100USD. Additional shipping insurance coverage from carrier or the third-party insurance company is available for purchase when you place the order. You are responsible for ensuring to put sufficient insurance coverage to protect the shipment. Luggage To Ship ‘s liability is not applicable to additional shipping insurance purchased by you. Luggage To Ship will file a claim on behalf of you. The carrier or third-party insurance company investigates and makes final decision. In no event shall Luggage To Ship be liable for the additional shipping insurance coverage and related claim result.
                    </p>
                    <p>You understand that insurance only covers:<p>
                    <ul>
                        <li><b><span class="light_grew_iten">Lost shipment</span></b></li>
                        <li><b><span class="light_grew_iten">Damaged luggage / parcels excluding cosmetics damage.</span></b></li>
                    </ul>
                    <p>You understand the insurance does not cover</p>
                    <ul>
                        <li>Cosmetics damage of the luggage, including but not limited to cosmetics wear or tears, scratches on your luggage, broken or missing wheels, straps, pockets, pull handles, hanger hooks or other items attached to baggage or boxes</li>
                        <li>Fragile items including any breakable or temperature sensitive items</li>
                        <li>Glassware including, but not limited to, signs, mirrors, ceramics, porcelains, china, crystal, glass, framed glass, and any other commodity with similarly fragile qualities</li>
                        <li>Electronics including, but not limited to, laptops, cameras, personal computers, stereo equipment, personal audio devices, cell phones, TV.</li>
                        <li>Antiques, collector’s items, precious metals and gems, works of art, precious jewelry</li>
                        <li>Any prohibited items listed in our terms and conditions, </li>
                        <li>Any prohibited items prohibited or restricted by local, country, international law or regulation,</li>
                        <li><span class="likea">Shipment delay including but not limited to custom delay</span></li>
                        <li><span class="likea">Tax, duty and related custom fee for your international shipment,</span></li>
                        <li><span class="likea">Storage Services.</span></li>
                    </ul>
                    <p>You also understand the shipping insurance does not cover the loss or damage arising from following circumstances:</p>
                    <ul>
                        <li>Strike, lock-out, stoppage or restraint of labor, Customs delay, the consequences of which we are unable to avoid by the exercise of reasonable diligence</li>
                        <li>Acts of God</li>
                        <li>Consequence of War or Terrorism</li>
                        <li>Any item or package damaged or lost because of your improper packing or / and labelling. You understand that your items must be thoroughly packaged and must be able to fall approximately 38 inches without breaking. Or any damage inside packages or luggage
                        </li>
                        <li>Any lost or damage after package has been signed for and accepted at the wrong or incomplete delivery address provided by you</li>
                        <li>Any lost or damage after package has been delivered without signature request</li>
                        <li>Any lost or damage before the carrier pick up the shipment, or before the carrier accepted the drop off package.</li>
                        <li>You failed to adhere to the terms and conditions set out in these conditions</li>
                    </ul>
                    <p>You agree to file a claim with Luggage To Ship for the lost or damaged shipment. Lost claim need to be submitted within 5 business days from the estimated delivery date. The claim should be sent by email with the lost item list, purchase invoice. Damage claim need to be submitted within 3 business days after the shipment is delivered. The claim should be sent by email with damaged package, damaged item pictures, damaged item value list and purchase invoice.
                    </p><br>
                    <p>Luggage To Ship assists to collect all claim document and submit the claim on behalf of you. In no event shall Luggage To Ship to be responsible for the claim result. The carrier or third-party insurance company will investigate and decide the claim result and compensation amount per their insurance policy and inspection. The claim investigation usually will last 30-60 business days. Once the decision is made, it will be the final decision and settlement for the claim.
                    </p><br>
                    <p>Luggage To Ship will process a refund within 5 business days after the claim is approved by the carrier or third-party insurance company. You agree to file a lost or damage claim through Luggage To Ship. You understand the lost or damage claim may be rejected if you file it directly with the carrier. You acknowledge that Luggage To Ship will not responsible for any rejection because you file the claim directly with the carrier.
                    </p>

                    <h4 class="blue-color">Storage Services</h4>
                    <p>Luggage To Ship cannot accept packages over 72 inches in length or 100lbs in weight. Luggage To Ship is not able to provide storage service for those prohibited items described in this term.<br>
                        Luggage To Ship provides up-to 6 months’ free storage services for each piece of package. After 6 months, the monthly warehouse fee for each piece is 10USD. If the storage fee is due over 3 months, you agree that Luggage To Ship has the right to destroy the package(s). Luggage To Ship is not responsible for any item damaged because of improper packaging.
                        Luggage To Ship’s liability coverage for the storage service is up to 100USD each package. You understand that the shipping insurance does not cover the storage services.
                        Luggage To Ship has the right to refuse or return those packages cannot be accepted or stored in our warehouse. You will be responsible for related return shipping and handling fee.
                    </p>

                    <h4 class="blue-color">Promotion Code</h4>
                    <p>Luggage To Ship may offer promotion code to members. All discounts are applied at the sole discretion of Luggage To Ship and may be withdrawn at any time. The discounted amount applied by a promotion code cannot be refunded if you cancel the order. If an expected discount fails to apply to your order, you need contact with Luggage To Ship right away instead of submitting the order. Luggage To Ship accepts one valid promotion code per order.
                    </p>

                    <h4 class="blue-color">Limitation of Liability</h4>
                    <p>Luggage To Ship’s liability is limited to the lower of actual damages/lost or free insurance amount. Our maximal liability coverage is up to 100USD each package shipped and stored via us. Luggage To Ship is not responsible for indirect or consequential loss such as (but not limited to) loss of profit, loss of market or the consequences of delay or deviation however caused. Luggage To Ship is not responsible for any carrier or carrier’s partner ‘s service fault (delay, lost, damage etc.) Luggage To Ship is not responsible for any loss, damage or delay caused by events beyond our control, including but not limited to acts of god, war, civil unrest, or acts of government. Luggage To Ship is not the shipper of your package, and has no liability for what you ship. Luggage To Ship ‘s liability is not applicable to additional insurance purchased by you. Luggage To Ship file a claim on behalf of you. The carrier or third-party insurance company investigates and makes final decision. In no event shall Luggage To Ship be liable for the additional insurance coverage.
                    </p>

                </div>
            </div>
        </div>

    </div>

</div>

<?php  if($sender_info['shipping_date'] == date('Y-m-d')){

    $check_date = 1;
}

if($order_info['shipping_status'] < PROCESSED_STATUS[0]){ ?>

<script>
     order_shipping_fedex_use_address = true;
</script>

<?php }else{ ?>
    <script>
        order_shipping_fedex_use_address = false
    </script>
<?php } ?>

<script>
    checkdate = '<?php echo $check_date; ?>';
    order_status = '<?php echo $order_info['shipping_status']; ?>';
    order_pickup = '<?php echo $sender_info['pick_up']; ?>';
    order_shipping_fedex_use_address;
</script>