<?php if($action == 'view') { ?>
    <form method="post" action="">
        <div class="display-table">
            <div class="half-block">
                <div class="min-block order-shipping-date">
                    <h2>Delivery Date and Time</h2>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 receiver_shipping_date">
                                <p><span class="delivery_date_time">Delivery Date:</span> <span class="orange-color receiver_delivery_date"><?php echo date("M-d-Y", strtotime($receiver_info['delivery_date'])); ?></span></p>
                                <?php
                                if(!empty($receiver_info['delivery_time'])){
                                ?>
                                    <p><span class="delivery_date_time"> Delivery Time:</span> <span class="orange-color"><?php echo $receiver_info['delivery_time']; ?></span></p>
                                <?php
                                }
                                if(!empty($receiver_info['without_signature'])){ ?>
                                    <p>Signature: <span class="orange-color">Delivery Signature Not Require</span> <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" Delivery time and   Without Signature  " data-original-title="" title="" aria-describedby="popover942646"></span></p>
                                <?php } ?>
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
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">First Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_first_name']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $receiver_info['receiver_last_name']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone #:<span class="important">*</span></label>
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
                        Destination Address (To)
                    </h2>
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Organization:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_company']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address:<span class="important">*</span></label>
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
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<?php if($country == 'United States (USA)') {?><span class="important">*</span><?php }?>:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_postal_code']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $receiver_info['delivery_city']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<?php if($country == 'United States (USA)') {?><span class="important">*</span><?php }?>:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $delivery_state; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $country; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <span class="orange-color"><?php echo $receiver_info['delivery_remark']; ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">

            <?php
            $class = 'edit_delivery_info';

            if($order_info['shipping_status'] > SUBMITTED_STATUS[0] && $order_info['shipping_status'] <= READY_STATUS[0]){

                $class = 'dashboard_view_edit_sender';
            }

            ?>

            <button type="button" class="btn btn-default btn-login-orange save-action <?php echo $class; ?>" data_id = '<?php echo $receiver_info['id']; ?>'>Edit</button>
        </div>
    </form>

<?php } ?>

<?php if($action == 'add') { ?>
    <form method="post" action="" id="receiver_delivery_form">
        <div class="display-table">
            <div class="half-block">
                <div class="min-block order-shipping-date">
                    <h2>Delivery Date and Time</h2>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <?php $check = (!empty($receiver_info['without_signature']) || $signature == 'true')?'checked = checked':''; ?>
                            <div class="col-sm-12 col-xs-12">
                                <p><span class="delivery_date_time">Delivery Date: </span><span class="orange-color receiver_delivery_date"><?php echo date("M-d-Y", strtotime($receiver_info['delivery_date'])); ?></span></p>
                                <?php
                                if(!empty($receiver_info['delivery_time'])){
                                    ?>
                                    <p><span class="delivery_date_time">Delivery Time:</span> <span class="orange-color"><?php echo $receiver_info['delivery_time']; ?></span></p>
                                <?php
                                    }
                                if($order['shipping_type'] == '2'){ ?>

                                    <div class="delivery-with-out">
                                        <input type="checkbox" name="signature" class="signature" <?php echo $check; ?> value="1"><span>Delivery Without Signature</span>
                                        <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="In selecting this option, you authorized the carrier to leave the package at the delivery address without signature required.  Once delivered, Luggage To Ship is not responsible for any  item delivered without signature" data-original-title="" title="" aria-describedby="popover942646"></span>
                                    </div>
                                <?php } ?>
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
                            <div class="col-sm-4 col-xs-6 padding-right-0"></div>
                            <div class="col-sm-7 col-xs-12 value-info select_trav_list_mob">
                                <?php if(!empty($traveller)){?>
                                    <select class="form-control selectpicker select-country"   name="" id="traveller_list_receiver">
                                    <option value="">Select from name list</option>
                                    <?php foreach ($traveller as $index => $value){
                                        $k=($trav_id==$value['id'])?'selected="selected"':'';
                                        ?>
                                        <option value="<?php echo $value['id']; ?>" <?php echo $k; ?>><?php echo $value['first_name']." ".$value['last_name']; ?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">First Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control" maxlength="40" name="first_name" id="last_name" placeholder=""  value="<?php echo (!empty($traveller_info['first_name']))?$traveller_info['first_name']: $receiver_info['receiver_first_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control" maxlength="40" name="last_name" id="last_name" placeholder="" value="<?php echo (!empty($traveller_info['last_name']))?$traveller_info['last_name']: $receiver_info['receiver_last_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone #:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <input type="text" class="form-control" name="phone" placeholder="" value="<?php echo (!empty($traveller_info['phone']))?$traveller_info['phone']: $receiver_info['receiver_phone']; ?>">
                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <span class="popover-style secure-code"  data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please include the country code for the phone number. For example, put +44 if the phone number is a UK number." data-original-title="" title="" aria-describedby="popover942646"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Email:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control" maxlength="40" name="email" placeholder="" value="<?php echo (!empty($traveller_info['email']))?$traveller_info['email']: $receiver_info['receiver_email']; ?>">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="half-block">
                <div class="min-block">
                    <h2>
                        Destination Address (To)
                    </h2>
                    <div class="form-horizontal">

                        <div class="form-group">
                            <div class="col-sm-4 col-xs-6 padding-right-0"></div>
                            <div class="col-sm-7 col-xs-12 value-info select_trav_list_mob">
                                <?php if(!empty($address_book)){ ?>
                                <select class="form-control selectpicker select-country " name="" id="addres_book_receiver">
                                    <option value="">Select from address book</option>
                                    <?php
                                    foreach ($address_book as $index => $value){
                                        $k=($add_id==$value['id'])?'selected="selected"':'';
                                        ?>
                                        <option <?php echo $k; ?> value="<?php echo $value['id']; ?>"><?php echo $value['contact_id']." ". $value['address1']." ".$value['city']; ?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Organization:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <input type="text" class="form-control" maxlength="40" name="organization" placeholder="Name of Hotel, Company etc." value="<?php echo (!empty($address_info['organization']))?$address_info['organization']:$receiver_info['delivery_company']; ?>">
                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If your shipment will be delivered to a hotel, or company, please put the organization’s name here. So the courier can find it and deliver your shipment on time." data-original-title="" title="" aria-describedby="popover942646"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control orange-color order_font_size" maxlength="50" name="address1" placeholder="" value="<?php echo (!empty($address_info['address1']))?$address_info['address1']:$receiver_info['delivery_address1']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control placeholder_class" maxlength="50" name="address2" placeholder="Apt/floor, suite number"  value="<?php echo (!empty($address_info['address2']))?$address_info['address2']:$receiver_info['delivery_address2'];; ?>">
                            </div>
                        </div>
                      <!--  <?php /*if($order['shipping_type'] == '2'){ */?>
                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<?php /*if($country == 'United States (USA)') {*/?><span class="important">*</span><?php /*}*/?>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <p class="static-value orange-color"><?php /*echo $receiver_info['delivery_postal_code'];*/?></p>
                                </div>
                                <div class="col-sm-1 col-xs-1 no-padding">
                                    <span class="popover-style secure-code edit_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If you would like to change the postal code, city or country, please click bellow <button type='button' id='update_item_pop' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                                <div class="col-sm-7 col-xs-7 mob-input">
                                    <p class="static-value orange-color"><?php /*echo $receiver_info['delivery_city'];*/?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                                <div class="col-sm-7 col-xs-7 mob-input">
                                    <p class="static-value orange-color"><?php /*echo $receiver_info['delivery_state_name'];*/?></p>
                                </div>
                            </div>
                        --><?php /*}elseif($order['shipping_type'] == '1'){ */?>

                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<?php if($country == 'United States (USA)') {?><span class="important">*</span><?php }?>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" class="form-control orange-color order_font_size" maxlength="25" name="postal_code" placeholder="Postal Code" value="<?php echo (!empty($address_info['postal_code']))?$address_info['postal_code']: $receiver_info['delivery_postal_code']; ?>">
                                </div>
                                <div class="col-sm-1 col-xs-1 no-padding">
                                    <span class="popover-style secure-code edit_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If you would like to change the postal code, city or country, please click bellow <button type='button' id='update_item_pop' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City:<span class="important">*</span></label>
                                <div class="col-sm-7 col-xs-7 mob-input">
                                    <input type="text" class="form-control orange-color order_font_size" maxlength="30" name="city" placeholder="City" value="<?php echo (!empty( $address_info['city']))? $address_info['city']:$receiver_info['delivery_city']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<?php if($country == 'United States (USA)') {?>:<span class="important">*</span><?php }?></label>
                                <div class="col-sm-7 col-xs-7 mob-input">

                                    <select class="form-control selectpicker select-country orange_text" name="state">
                                        <option value="">Select State</option>
                                        <?php

                                        if(!empty($state)){
                                            foreach($state as $single){

                                                $k = '';

                                                if(!empty($address_info['state']) && $single['Stateid'] == $address_info['state']['Stateid']){

                                                    $k = 'selected="selected"';

                                                }elseif(!empty($receiver_info['delivery_state']) && $receiver_info['delivery_state'] == $single['Stateid']){

                                                    $k = 'selected="selected"';
                                                }

                                                ?>
                                                <option value="<?php echo $single['Stateid']; ?>" <?php echo $k; ?>><?php echo $single['State']; ?></option>
                                                <?php
                                            }
                                        }?>
                                    </select>
                                </div>
                            </div>
                      <!--  --><?php /*} */?>

                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $country; ?></p>
                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <?php
                                if($order['shipping_type'] == '1'){
                                ?>
                                <span class="popover-style secure-code  edit_popover_country" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="International order, Question mark contents:” If you would like to change country, please click bellow <button type='button' id='update_item_pop_country' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <textarea class="form-control small_textarea" maxlength="50" placeholder="" name="remark"><?php echo (!empty($address_info['remark']))?$address_info['remark']:$receiver_info['delivery_remark']; ?></textarea>
                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the delivery process.  For example, building security code, hotel concierge/reception desk, college mail room etc.  Please be advised carrier will not call or text you before the delivery. The maximum length of the delivery instructions should not exceed 25 characters." data-original-title="" title="" aria-describedby="popover942646"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default btn-login-orange save-action receiver_delivery_save"><?php echo ($order['shipping_status'] == SUBMITTED_STATUS[0])?'Save & Continue':'Save & Continue';?></button>
        </div>
    </form>
<?php } ?>
