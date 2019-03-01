
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
<input type="hidden" name="order_id" value="<?php echo $order_info['id']; ?>" id="order_id">
<div class="content">
    <div class="container">
        <div class="profile">
            <div class="place-order">
                <span class="orange-color">Order History</span>
                <div class="place-order-content more">
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center"><span class="orange-color"><?php echo $title; ?></span></div>
                    <div class="col-md-3 col-sm-4 col-xs-6 first">
                        <p><?php echo $order_info['currier_name']." ".$order_info['send_type']; ?></p>
                        <p>Shipping fee: <span class="orange-color">$<?php echo (!empty($order_info['аmount_paid']))?$order_info['аmount_paid']:0; ?></span></p>
                        <p class="blue-color"><a href="#" class="luggage_incurance">Item & Insurance</a></p>
                    </div>
                    <div class="col-md-6 col-sm-4 hidden-xs text-center"><br /><span class="orange-color"><?php echo $title; ?></span></div>
                    <div class="col-md-3 col-sm-4 col-xs-6 text-right last">
                        <p>Order #: <span class="orange-color"><?php echo $order_info['order_id']; ?></span></p>
                        <p class="light-gray">Order Date: <?php echo date("M-d-Y", strtotime($order_info['created_date'])); ?></p>
                        <p class="blue-color"><a href="#" class="label_delivery">Label Delivery</a></p>
                    </div>
                    <p class="clearfix"></p>
                </div>
            </div>

            <div class="order-process-block">
                <div class="right-part">
                    <div class="panel-group designed-tabs" id="accordion2" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading light-color" role="tab" id="headingFourth">
                                <h4 class="panel-title text-left">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#shipping_tracking" aria-expanded="false" aria-controls="headingFourth">
                                        <img src="<?php echo  base_url();?>assets/images/fedex.png"> Shipping Tracking # <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="shipping_tracking" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFourth">
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
                                        <tr>
                                            <td>1</td>
                                            <td class="text-center">35 lbs Luggage</td>
                                            <td class="text-center"><span class="orange-color">1234565455465</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="text-center">75 lbs Luggage</td>
                                            <td class="text-center"><span class="orange-color">5465465465465</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="text-center">50  lbs Golf Bag</td>
                                            <td class="text-center"><span class="orange-color">6546546546645</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p class="text-center"><strong>FedEx  USA Hotline:  1800 463 3339</strong></p>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading light-color" role="tab" id="headingFifth">
                                <h4 class="panel-title text-left">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#pickup_confirmation" aria-expanded="false" aria-controls="headingFifth">
                                        <img src="<?php echo base_url(); ?>assets/images/fedex.png"> Pickup Confirmation <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="pickup_confirmation" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFifth">
                                <div class="panel-body white panel-table-block">

                                    <table class="table-default">
                                        <tbody>
                                        <tr>
                                            <td>Pick Up Date:</td>
                                            <td>10-15-2016</td>
                                        </tr>
                                        <tr>
                                            <td>Pick Up Time:</td>
                                            <td>10:00am -04:00pm</td>
                                        </tr>
                                        <tr>
                                            <td>Confirmation #:</td>
                                            <td>ZN3457CD</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p class="text-center"><strong>FedEx  USA Hotline:  1800 463 3339</strong></p>
                                    <div class="text-center">
                                        <a href="" class="btn btn-default small-button btn-login-orange white-space">Find a drop off location if missed pickup</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading light-color" role="tab" id="headingSixth">
                                <h4 class="panel-title text-left small-text">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#item_list_passport" aria-expanded="false" aria-controls="headingSixth">
                                        Item List/Passport/Travel Itinerary <i class="fa fa-angle-down tab-down" aria-hidden="true"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="item_list_passport" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSixth">
                                <div class="panel-body white panel-table-block">
                                    <ul class="document-label item-list">
                                        <li>
                                            <a href="">
                                                <img class="" src="<?php echo base_url(); ?>assets/images/fill-list.svg">
                                                <i class="fa fa-exclamation information-icon"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <img class="" src="<?php echo base_url(); ?>assets/images/passport.svg">
                                                <i class="fa fa-exclamation information-icon"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <img class="" src="<?php echo base_url(); ?>assets/images/airplane.svg">
                                                <i class="fa fa-exclamation information-icon"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="text-center">
                                        <a href="" class="btn btn-default small-button btn-login-orange col-md-12">Please Complete Item List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-part">

                    <div class="panel-group designed-tabs" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#sender_and_pick_up" aria-expanded="true" aria-controls="collapseOne">
                                        Sender &  Origin Address <i class="fa fa-angle-down tab-down" aria-hidden="true"></i> <i class="fa verified-icon">1</i>
                                    </a>
                                </h4>
                            </div>
                            <div id="sender_and_pick_up" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <div class="display-table">
                                            <div class="half-block">
                                                <div class="min-block order-shipping-date">
                                                    <h2>Shipping Date and Time</h2>
                                                    <div class="form-horizontal">
                                                        <div class="form-group">
                                                            <div class="col-sm-12 col-xs-12">
                                                                <p><span class="shiping_time">Shipping Date: </span><span class="orange-color"><?php echo date("M-d-Y", strtotime($sender_info['shipping_date'])); ?></span></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">

                                                                <?php if($sender_info['pick_up'] == 1){ ?>
                                                            <div class="col-sm-12 col-xs-12 drop-off">
                                                                    <span class=" droppoff">Drop Off Luggage:</span>
                                                            </div>
                                                                <?php  }else{
                                                                        $pikup = ($sender_info['pickup_time'] == 'no_data')?'I will confirm pick up time later':$sender_info['pickup_time'];
                                                                    ?>
                                                            <div class="col-sm-12 col-xs-12">
                                                                     Pick Up Time :<span class="orange-color"> <?php echo $pikup ?></span>
                                                            </div>
                                                                <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="min-block">
                                                    <h2>
                                                        Sender Information (Shipper) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="The “shipper” is the person who is sending the shipment." data-original-title="" title="" aria-describedby="popover942646"></span>
                                                    </h2>
                                                    <div class="form-horizontal">

                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">First Name<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['sender_first_name'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Last Name<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['sender_last_name'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Phone Number<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['sender_phone'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Email:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['sender_email'];?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="half-block">
                                                <div class="min-block">
                                                    <h2>
                                                        Pick-up Address (From) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                        If you are dropping off, you may put your current address, such as a hotel, business or residence. You may also use the drop-off location as your pick-up (from) address.
                        " data-original-title="" title="" aria-describedby="popover942646"></span>
                                                    </h2>
                                                    <div class="form-horizontal">

                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Organization:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_company'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Address<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_address1'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Address 2:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_address2'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Postal Code<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_postal_code'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_city'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $sender_info['pickup_state'];?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Country<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $country_from;?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Remark: <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the pick up process.  For example, building security code, hotel concierge/reception desk, college mail room etc. Please be advised carrier will not call or text you before the pick up. The maximum length of the pick up instructions should not exceed 25 characters." data-original-title="" title="" aria-describedby="popover942646"></span></label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <?php echo $sender_info['pickup_remark'];?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-default btn-login-orange save-action dashboard_view_edit_sender">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#receiver_delivery" aria-expanded="false" aria-controls="collapseTwo">
                                        Receiver & Destination Address <i class="fa fa-angle-down tab-down" aria-hidden="true"></i> <i class="fa verified-icon">2</i>
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
                                                            <div class="col-sm-12 col-xs-12">
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
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">First Name<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_first_name']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Last Name<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_last_name']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Phone Number<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_phone']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Email:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_email']; ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="half-block">
                                                <div class="min-block">
                                                    <h2>
                                                        Delivery Address (To) <!--<span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title="" aria-describedby="popover942646"></span>-->
                                                    </h2>
                                                    <div class="form-horizontal">

                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Organization:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_company']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Address<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_address1']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Address 2:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_address2']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Postal Code<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_postal_code']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_city']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_state']; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Country<span class="important">*</span>:</label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <p class="static-value orange-color"><?php echo $country_to; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Remark: <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the delivery process.  For example, building security code, hotel concierge/reception desk, college mail room etc.  Please be advised carrier will not call or text you before the delivery. The maximum length of the delivery instructions should not exceed 25 characters." data-original-title="" title="" aria-describedby="popover942646"></span></label>
                                                            <div class="col-sm-7 col-xs-6 mob-input">
                                                                <?php echo $receiver_info['delivery_remark']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-right">
                                                            <button type="button" class="btn btn-default btn-login-orange save-action dashboard_view_edit_delivery" >Edit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#payment_information" aria-expanded="false" aria-controls="collapseThree">
                                        Payment Information <i class="fa fa-angle-down tab-down" aria-hidden="true"></i> <i class="fa  verified-icon">3</i>
                                    </a>
                                </h4>
                            </div>
                            <div id="payment_information" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
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
                                                        <td><?php echo $index; ?></td>
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

                                    <?php if(!empty($pay_history)) {?>

                                        <div class="col-md-4">
                                            <ul class="invoice">
                                                <li>
                                                    <a href="">
                                                        <img class="" src="<?php echo  base_url();?>assets/images/invoice.png">
                                                        <span>Estimate<br />Invoice</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <img class="" src="<?php echo  base_url();?>assets/images/invoice.png">
                                                        <span>Final<br />Invoice</span>
                                                      </a>
                                                </li>
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

                </div>
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
            <div class="modal-body">
                <div class="register-block no-hide">

                    <h2 class="register-title text-center">Label Delivery</h2>

                    <div class="form-horizontal text-left">
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">First Name<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['first_name']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Last Name<span class="important">*</span><span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['last_name']?></div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Phone Number<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['phone']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Email <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['email']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Organization <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['company']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Address 1<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['address1']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Address 2</div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['address2']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Postal Code<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['postal_code']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">City<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['city']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">State / Region<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['state_id']?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-4 control-label value-index">Country<span class="important">*</span> <span class="last-dots">:</span></div>
                            <div class="col-xs-8 value-info static-place"><?php echo $country; ?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 additional-comments">
                                Remark:
                                <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the delivery process.  For example, building security code, hotel concierge/reception desk, college mail room etc.  Please be advised carrier will not call or text you before the delivery. The maximum length of the delivery instructions should not exceed 25 characters." data-original-title="" title=""></span>
                            </div>
                        </div>
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
            <div class="modal-body insurance_mobile_padding" id="order_incurance">
                <div class="register-block no-hide" id="main_incurance_div">
                    <h2 class="register-title text-center">Luggage and Insurance</h2>

                    <div class="form-horizontal text-left">
                        <div class="panel-body">

                            <div class="col-md-12 div_incurance_info">

                                <p class="incurance_info">Total Luggage:  <span class="orange-color"><?php echo (!empty($incurance['total_count']))?$incurance['total_count']:''; ?></span></p>
                                <p class="incurance_info " >Total Extra Fee:<span class="orange-color" id="incurance_fee">$<?php echo (!empty($free_incurance))?$free_incurance:0; ?></span></p>
                                <p class="incurance_info">Max Insurance:  <span class="orange-color" id="incurance_amount">$<?php echo (!empty($max_incurance))?$max_incurance:0; ?></span></p>
                            </div>
                            <form method="post" action="" class="incurance_form">
                                <table class="table table-bordered  designed-table incurance_table">
                                    <thead>
                                    <tr>
                                        <th class=""><small>#</small></th>
                                        <th class=""><small>Luggage Type</small></th>
                                        <th class=""><small>Max Weight</small></th>
                                        <th class=""><small>Insurance</small></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if(!empty($incurance)){

                                        foreach ($incurance as $index => $value){ ?>
                                            <tr>
                                                <td><?php echo $index +1; ?></td>
                                                <td><?php echo $value['luggage_name'];?></td>
                                                <td><?php echo $value['weight']."lbs"."/".floor(floatval($luggage['weight']*0.453))."kg";?></td>
                                                <td><?php echo "$".$value['incurance_fee']." For "."$".$value['insurance'] ?></td>
                                            </tr>
                                        <?php } }else if(!empty($prod)){
                                        $index = 1;
                                        foreach ($prod as $luggage){
                                            $count = $luggage['count'];
                                            while ($count >0){ ?>
                                                <tr>
                                                    <td><?php echo $index; ?></td>
                                                    <td><?php echo $luggage['luggage_name'];?></td>
                                                    <td><?php echo $luggage['weight']."lbs"."/".floor(floatval($luggage['weight']*0.453))."kg";?></td>
                                                    <td><?php echo "$0 For "."$".$order_info['free_insurance'] ?></td>
                                                </tr>
                                           <?php
                                                $index++;
                                                $count--;
                                            }
                                        }

                                    } ?>

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
