<?php

$update_arr_status = ['0','1','2'];

?>

<div class="content">
    <div class="container">
        <div class="profile">
            <div class="mob-profile text-right">
                <span class="my-prof">Dashboard</span>
                <a href="<?php echo base_url();?>" class="btn btn-default btn-login-orange">Check Price & Book Order</a>
            </div>

            <div class="content">

                <div class="dashboard-info">
                    <?php if(!empty($order_data)){

                        foreach ($order_data as $index => $data){
                            if(in_array($data['shipping_status'],$update_arr_status)){

                                $order_name = '<a href="'.base_url('order/order_processing/'.$data['real_id']).'">'.$data['order_number'].'</a>';

                            }else{
                                $order_name =  '<a href="'.base_url('dashboard/view_order/'.$data['real_id']).'">'.$data['order_number'].'</a>';

                            }  ?>
                            <div class="large-designed-info-row">
                                <div class="tr-order">
                                    <span class="hidden-sm hidden-xs"><?php echo date("Y-m-d", strtotime($data['created_date']))?></span>
                                    <span class="blue-color"><?php echo $order_name; ?></span>
                                    <span class="orange-color"><?php echo $data['title']; ?></span>
                                </div>
                                <div class="tr-mobile-currier-name mobile_version">
                                    <?php
                                    if(stripos($data['send_type'], 'outbound') !== false){

                                        $type = trim(str_replace('outbound', '', $data['send_type']));
                                        $type = ucfirst($type)." ".$data['delivery_day_count']." days";

                                    }else if(stripos($data['send_type'], 'inbound') !== false){

                                        $type = trim(str_replace('inbound', '', $data['send_type']));
                                        $type = ucfirst($type)." ".$data['delivery_day_count']." days";

                                    }else{

                                        $type = $data['send_type'];
                                    }
                                    if($data['currier_name'] == 'FedEx' && $data['shipping_type'] == 2 ){

                                        if(stripos($type, 'Basic') !== false){
                                            $type = 'Basic Service';
                                        }else{


                                            if(stripos($type, 'Express') !== false){
                                                $type = str_ireplace('Express','',$data['send_type']);

                                            }elseif (stripos($type, 'Priority') !== false){
                                                $type = str_ireplace('Priority','',$data['send_type']);
                                            }elseif (stripos($type, 'Standard') !== false){
                                                $type = str_ireplace('Standard','',$data['send_type']);
                                            }

                                            if(stripos($type, 'afternoon') !== false){
                                                $type = str_ireplace('afternoon','PM',$type);
                                            }elseif (stripos($type, 'morning') !== false){
                                                $type = str_ireplace('morning','AM',$type);
                                            }


                                        }
                                    }
                                    ?>
                                    <span class=""><img src="<?php echo base_url()?>assets/images/<?php echo strtolower($data['currier_name']).".png"; ?>"> <?php echo $type; ?></span>
                                </div>
                                <div class="tr-order-edit mobile-hidden">
                                    <?php
                                    if(in_array($data['shipping_status'],$update_arr_status)){ ?>

                                        <span><a href="<?php echo base_url('order/order_processing/'.$data['real_id']); ?>"><img src="<?php echo base_url()?>assets/images/edit-note.svg"></a></span>
                                        <?php if($data['shipping_status'] == SUBMITTED_STATUS[0]){ ?>

                                            <span class="orange-color">View/Edit</span>
                                      <?php  }else{ ?>

                                            <span class="orange-color">Continue Order</span>
                                      <?php  } ?>


                                  <?php  }else{ ?>

                                        <span><a href="<?php echo base_url('dashboard/view_order/'.$data['real_id']); ?>"><img src="<?php echo base_url()?>assets/images/list-note.svg"></a></span>

                                        <?php } ?>
                                </div>
                                <div class="tr-pickup mobile-hidden">
                                    <span class="small-text">Pickup / Drop Off</span>
                                    <span><?php echo date('M-d-Y', strtotime($data['shipping_date'])); ?></span>
                                    <span><?php echo ($data['pickup_time'] == 'no_data')?'I will confirm pick up time later':str_ireplace('–','to',$data['pickup_time']);?></span>
                                </div>
                                <div class="tr-delivery mobile-hidden">
                                    <span class="small-text">Delivery</span>
                                    <span><?php echo date('M-d-Y', strtotime($data['delivery_date']));?></span>
                                    <span><?php echo $data['delivery_time'];?></span>
                                </div>
                                <div class="tr-country mobile-hidden">
                                    <p>
                                        <span><?php echo $countries[$data['pickup_country_id']]['country']; ?></span>
                                        <span><?php echo $data['pickup_city']; ?></span>
                                    </p>
                                    <p>
                                        <span><?php echo  $countries[$data['delivery_country_id']]['country']; ?></span>
                                        <span><?php echo $data['delivery_city']; ?></span>
                                    </p>
                                </div>
                                <div class="tr-shipping">
                                    <?php

                                    if(stripos($data['send_type'], 'outbound') !== false){

                                        $type = trim(str_replace('outbound', '', $data['send_type']));
                                        $type = ucfirst($type)." ".$data['delivery_day_count']." days";

                                    }else if(stripos($data['send_type'], 'inbound') !== false){

                                        $type = trim(str_replace('inbound', '', $data['send_type']));
                                        $type = ucfirst($type)." ".$data['delivery_day_count']." days";

                                    }else{

                                        $type = $data['send_type'];
                                    }

                                    ?>
                                    <span class="pc_version"><img src="<?php echo base_url()?>assets/images/<?php echo strtolower($data['currier_name']).".png"; ?>"> <?php echo $type; ?></span>
                                    <span class="no-tracking-number">
                                            <?php

                                            if(!empty($data['tracking_number'])){

                                            foreach ($data['tracking_number']['tracking_number'] as $value){

                                                if(empty($value['tracking_number'])){

                                                    $order_data[$index]['track_empty'] = true;

                                                }else{

                                                    $order_data[$index]['track_empty'] = false;
                                                }

                                                ?>

                                                <span class="link_tracking" data_number = "<?php echo $data['real_id'].'_'.$value['luggage_id'].'_'.$value['tracking_number']; ?>"><?php echo $value['tracking_number']; ?></span>

                                              <?php } } ?>
                                         </span>
                                            <?php

                                     if(($data['shipping_status'] == INCOMPLETE_STATUS[0]) &&  $order_data[$index]['track_empty'] == true){ ?>
                                         <div class="tr-complete-info add-padding incomlete_mobile_info">
                                             <div class="orange-box pull-right"> Incomplete order will  be auto cancelled after pickup date.
                                             </div>
                                         </div>
                                        <?php }elseif($data['shipping_status'] == SUBMITTED_STATUS[0] &&  $order_data[$index]['track_empty'] == true){  ?>

                                         <div class="tr-complete-info add-padding incomlete_mobile_info">
                                             <div class="orange-box pull-right"> We will process your order and update tracking number soon.
                                             </div>
                                         </div>
                                     <?php }elseif($data['shipping_status'] == PROCESSED_STATUS[0] &&  $order_data[$index]['track_empty'] == true){  ?>

                                         <div class="tr-complete-info add-padding incomlete_mobile_info">
                                             <div class="orange-box pull-right"> We will send shipping labels and update tracking number soon</div>
                                         </div>
                                     <?php }elseif($data['shipping_status'] == PROCESSED_STATUS[0] && empty($data['status_change_by']) && $order_data[$index]['track_empty'] == true){ ?>

                                         <div class="orange-box pull-right"> We will send shipping labels and update tracking number soon</div>
                                    <?php }elseif($data['shipping_status'] == PROCESSED_STATUS[0] && $data['status_change_by'] == '1' && $order_data[$index]['track_empty'] == true){ ?>

                                         <div class="orange-box pull-right"> We will send shipping labels and update tracking number soon</div>
                                     <?php } ?>
                                </div>
                                <div class="my_div tr-country-box-content">
                                    <div class="tr-country-mobile">
                                        <span><?php echo $countries[$data['pickup_country_id']]['iso']."-".$data['pickup_city'] ?></span>
                                        <span><?php echo $countries[$data['delivery_country_id']]['iso']."-".$data['delivery_city'] ?></span>
                                    </div>
                                    <?php
                                    if($data['shipping_status'] == INCOMPLETE_STATUS[0]){ ?>
                                        <div class="tr-complete-info add-padding">
                                          <!--  <div class="orange-box pull-right"> Saved / Uncompleted  order will be automatically cancelled after pickup date</div>-->
                                            <a href="<?php echo base_url('order/order_processing/'.$data['real_id']); ?>" class="btn btn-default btn-login-orange small-button pull-right">Please Complete</a>
                                        </div>

                                    <?php  }elseif(($data['shipping_status'] ==SUBMITTED_STATUS[0] || $data['shipping_status'] == PROCESSED_STATUS[0]) && $data['shipping_type'] == '1'){

                                        $true = false;
                                        $icon_class1 = (!empty($order_item_list[$data['order_id']]) && !empty($data['signature']))?"fa fa-check verified-icon":"fa fa-exclamation information-icon";
                                        $icon_class2 = (!empty($passport_info[$data['order_id']]))?"fa fa-check verified-icon":"fa fa-exclamation information-icon";
                                        $icon_class3 = (!empty($travel[$data['order_id']]))?"fa fa-check verified-icon":"fa fa-exclamation information-icon";
                                        $link = ($data['shipping_status'] == '3')?base_url('order/custom_documents_view/'.$data['real_id']):base_url('order/custom_documents/'.$data['real_id']);
                                        if($icon_class1 == 'fa fa-check verified-icon' && $icon_class1 == $icon_class2 && $icon_class1 == $icon_class3){

                                            $true = true;
                                        }
                                        $but_text = 'Please Complete';
                                        if($icon_class1 == 'fa fa-check verified-icon'){
                                            $but_text = 'View and edit';
                                        }

                                        ?>
                                    <div class="tr-complete-info add-padding">
                                        <ul class="document-label item-list">
                                            <li>
                                                <a href="<?php echo $link; ?>" class="dahboard_item_list">
                                                    <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                                    <i class="<?php echo $icon_class1; ?>"></i>
                                                </a>
                                            </li>
                                        <?php

                                        if(empty($data['order_type']) || $data['order_type'] == 1){ ?>
                                            <li>
                                                <a href="<?php echo $link; ?>" class="dashboard_pasport_copy">
                                                    <img class="" src="<?php echo base_url()?>assets/images/passport.svg">
                                                    <i class="<?php echo $icon_class2; ?>"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $link; ?>">
                                                    <img class="" src="<?php echo base_url()?>assets/images/airplane.svg">
                                                    <i class="<?php echo $icon_class3; ?>"></i>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        </ul>

                                        <?php if(!$true){ ?>
                                            <a href="<?php echo $link; ?>" class="btn btn-default btn-login-orange small-button pull-right"><?php echo $but_text; ?></a>

                                       <?php } ?>
                                     </div>
                                    <?php }else{ ?>

                                        <div class="tr-complete-info add-padding">

                                            <ul class="document-label item-list">
                                                <?php
                                               if(!empty($data['labels_pdf']) && $data['shipping_status'] != DELIVERY_STATUS[0]){
                                                    ?>

                                                   <li>
                                                      <p>
                                                          <i class="fa fa-print orange-color"></i>
                                                      </p>
                                                    </li>


                                               <?php }
                                                ?>

                                                <?php

                                                if (!empty($data['uploaded_document'])) {

                                                    foreach ($data['uploaded_document'] as $document) { ?>
                                                        <li>
                                                            <a href="<?php echo base_url('order/user_file/' . $document['file_name'] . '/' . $data['real_id']); ?> ">
                                                                <img class="download-img" src="<?php echo base_url();?>assets/images/download-note.svg">
                                                                <span>Item List</span>
                                                            </a>
                                                        </li>
                                                    <?php } } ?>

                                                <?php
                                                if(!empty($data['travel_info_file'])){

                                                    foreach ($data['travel_info_file'] as $trav_info){ ?>

                                                        <li>
                                                            <a href="<?php echo base_url('order/user_file/'.$trav_info['file_name'].'/'.$data['real_id']); ?> ">
                                                                <img class="download-img" src="<?php echo base_url();?>assets/images/download-note.svg">
                                                                <span>Itinerary</span>
                                                            </a>
                                                        </li>
                                                    <?php } } ?>

                                            </ul>
                                            <?php
                                            if(!empty($data['labels_pdf']) && $data['shipping_status'] != DELIVERY_STATUS[0]){
                                            ?>
                                            <a target="_blank" href="<?php echo base_url('stream/labels/'.$data['labels_pdf'].'/'.sample_hash($data['user_id'])); ?>" class="btn btn-default btn-login-orange small-button pull-right label_link_a"> Print Labels and Instructions</a>
                                            <!-- <a href="" class="btn btn-default btn-login-orange small-button pull-right">Please Print And Attach to  Luggage</a>-->
                                        <?php } ?>
                                        </div>


                                            <?php   } ?>

                                </div>
                            </div>
                        <?php } } ?>
                    <div class="row">
                        <div class="col-md-12 text-right navigation-panel">
                            <?php echo $links; ?>
                        </div>
                    </div>

                    <div class="tips-tools">
                        <h2 class="text-center">Tips and Tools</h2>
                        <div class="tips-blocks">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="tips-block">
                                        <div class="block-header">Order Process</div>
                                        <div class="block-content">
                                            <ul>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Order_status_instruction');?>"> Order status instruction</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_you_process_my_order');?>">How you process my order?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_to_edit_my_order');?>">How to edit my order?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_to_cancel_my_order');?>">How to cancel my order?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_can_I_see_the_order_details');?>">How can I see the order details?</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="tips-block">
                                        <div class="block-header">Packing and Labelling</div>
                                        <div class="block-content">
                                            <ul>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/How_to_stick_label_on_my_luggage-bag-case');?>">How to select case/ box?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Packing_and_Labeling');?>">How to pack my items?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Items_cannot_be_covered_by_insurance');?>">Items not covered by insurance</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Do_I_need_to_lock_my_luggage_for_international_shipment');?>">Do I need lock my luggage?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Will_you_send_shipping_labels_for_my_order');?>">Will you mail me the label?</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="tips-block">
                                        <div class="block-header">Pick up / Drop off / Delivery</div>
                                        <div class="block-content">
                                            <ul>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Pick-up_check_list');?>">Pick up check list</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Drop-off_check_list');?>">Drop off check list</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_if_I_missed_a_pick_up');?>">How to do if missed pick up</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Where_can_I_drop-off_my_luggage');?>">Find a drop off location</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Do_I_need_to_stay_at_the_delivery_location_to_accept_package');?>">Do i need to stay at the delivery location to accept package?</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="tips-block">
                                        <div class="block-header">International Shipment</div>
                                        <div class="block-content">
                                            <ul>
                                                <li><a target="_blank" href="<?php echo base_url('what-cant-ship');?>">Restricted item list</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_kind_of_document_is_needed_for_the_custom_clearance');?>">Document for custom clearance?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Is_it_safe_to_upload_my_travelling_document');?>">Is it safe to upload my document?</a></li>
                                                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_to_do_if_my_package_is_delayed_in_custom');?>">What to do if my package is delayed incustom?</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

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

<script>

    order_list_row_count = '<?php echo $order_list_row_count; ?>';
</script>