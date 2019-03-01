<?php if($action == 'view') { ?>
    <form method="post" action="">
        <div class="display-table">
            <div class="half-block">
                <div class="min-block order-shipping-date">
                    <h2>Shipping Date and Time</h2>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12">
                                <p><span class="shiping_date">Shipping Date:</span> <span class="orange-color"><?php echo date("M-d-Y", strtotime($sender_info['shipping_date'])); ?></span></p>
                            </div>
                        </div>
                        <div class="form-group">
                        <?php
                        if($order_info['pick_up_check'] == '1'){

                            $size = ($sender_info['pick_up'] == 1)?'5':'12';
                            ?>


                                <?php if($sender_info['pick_up'] == 1){ ?>
                                <div class="margin_left_15 col-sm-<?php echo $size; ?>  col-xs-<?php echo $size; ?> drop-off small_font_size no_padding">
                                    <span class="droppoff">Drop Off Luggage:</span>
                                </div>
                                <?php  }else{
                                    $pikup = ($sender_info['pickup_time'] == 'no_data')?'I will confirm pick up time later':str_ireplace('–','to',$sender_info['pickup_time']);
                                    ?>
                            <div class="margin_left_15 col-sm-<?php echo $size; ?>  col-xs-<?php echo $size; ?> small_font_size no_padding">
                                    <span class="shiping_time ">Pick Up Time :</span><span class="orange-color view_pickup_time"> <?php echo $pikup ?></span>
                            </div>
                                <?php } ?>

                        <?php }else{ ?>

                                <?php if($sender_info['pick_up'] == 1){ ?>
                                <div class="col-sm-6 col-xs-6 drop-off small_font_size no_padding">
                                    <span class=" droppoff"> Drop Off:</span>
                                </div>
                                <?php  }else{ ?>
                                <div class="col-sm-6 col-xs-6  small_font_size no_padding">
                                    <div class="col-sm-7 col-xs-7 mob-text">
                                        Pick up not available  <span class="popover-style secure-code home-separate-pop" data-container="body" data-toggle="popover"
                                                                     data-trigger="hover" data-placement="Due to carrier business hours, pick up services are not available on the shipping date you selected (Saturday, Sunday, and holidays).
                                                                     If you need to schedule a pick-up, please click the “Go Back” button and change the shipping date. You may also drop off the package at a nearby carrier location. Please check the location by clicking the “find a drop off location” button." data-original-title="" title="" aria-describedby="popover942646"></span>
                                    </div>
                                </div>
                                <?php } ?>

                         <?php  } ?>

                            <?php

                            if($sender_info['pick_up'] != 2){ ?>
                                <div class="col-sm-6 col-xs-6 value-info btn_find">
                                    <a href="#" class="btn btn-default btn-file select-doc-file drop_off_location">Find a drop off location</a>
                                </div>
                            <?php  } ?>

                        </div>

                    </div>
                </div>
                <div class="min-block">
                    <h2>
                        Sender Information (Shipper) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="The “shipper” is the person who is sending the shipment." data-original-title="" title="" aria-describedby="popover942646"></span>
                    </h2>
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">First Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $sender_info['sender_first_name'];?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $sender_info['sender_last_name'];?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone #:<span class="important">*</span></label>
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
                        Origin Address (From) <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                     If you are dropping off,  you may put your current  address, such as a hotel, business or residence. Pick-up (from) address.
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
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address:<span class="important">*</span></label>
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
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $sender_info['pickup_postal_code'];?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $sender_info['pickup_city'];?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<?php if($country == 'United States (USA)') {?>:<span class="important">*</span><?php }?></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $pickup_state; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <p class="static-value orange-color"><?php echo $country;?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark: </label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <span class="orange-color"><?php echo $sender_info['pickup_remark'];?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <?php
            $class = 'edit_sender_info';

            if($order_info['shipping_status'] > SUBMITTED_STATUS[0] && $order_info['shipping_status'] <= READY_STATUS[0]){

                $class = 'dashboard_view_edit_sender';
            }

            ?>
            <button type="button" class="btn btn-default btn-login-orange save-action <?php echo $class; ?>" data_id = '<?php echo $sender_info['id'];?>'>Edit </button>
        </div>
    </form>

<?php } ?>

    <input type="hidden" name="country_id" value="<?php echo $sender_info['pickup_country_id']; ?>" id="country_id">
<?php if($action == 'add') { ?>
<form method="post" action="" id="sender_pickup_form">
    <input type="hidden" id="pickup_price" value="<?php echo $pickup_price*$count;?>">
    <div class="display-table">
        <div class="half-block">
            <div class="min-block order-shipping-date">
                <h2>Shipping Date and Time</h2>
                <div class="form-horizontal">
                    <div class="form-group">

                        <div class="col-sm-12 col-xs-12">
                            <p><span class="shiping_date">Shipping Date: </span><span class="orange-color"><?php echo date("M-d-Y", strtotime($sender_info['shipping_date'])); ?></span></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php $check = (!empty($sender_info['pick_up'])  && $sender_info['pick_up'] == 2 || $pickup == 'true')?'checked = checked':''; ?>
                         <?php $check2 = (empty($check) && !empty($sender_info['sender_first_name']) && $sender_info['pick_up'] == 1)?'checked = checked':''; ?>
                        <?php $check3 = ($drop == 'true')?'checked = checked':''; ?>

                            <div class="col-sm-6 col-xs-6 mob-text no_padding">
                                <input type="radio" class="drop_off pickup_price" <?php echo $check2; echo $check3 ?> value="1" name="pick_up"> Drop Off (+$0)
                            </div>

                            <div class="col-sm-6 col-xs-6 value-info">
                                <a href="#" class="btn btn-default btn-file select-doc-file drop_off_location">Find a drop off location</a>
                            </div>

                    </div>
                    <div class="form-group">
                        <?php

                        if($order_info['pick_up_check'] == '1'){ ?>
                            <div class="col-sm-6 col-xs-6 mob-text no_padding">
                                <input type="radio" class="pick_up pickup_price" value="2" <?php echo $check; ?> name="pick_up"> Pick Up (+$<?php echo $pickup_price*$count; ?>)
                            </div>

                            <div class="col-sm-6 col-xs-6 value-info ">
                                <select class="form-control selectpicker select-country small-dropdown" name="pickup_time" id="pickup_time">
                                    <option value="">Select Pick-Up Time</option>
                                    <option value="no_data" <?php echo  ($sender_info['pickup_time'] == 'no_data')?'selected = selected':'';?> >I will confirm pick up time later</option>
                                    <?php
                                    foreach($pickup_time as $object){
                                        $k = ($sender_info['pickup_time'] == $object )?'selected = selected':'';
                                        ?>
                                        <option value="<?php echo $object; ?>" <?php echo $k; ?>><?php echo $object; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>


                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please be advised that  the carrier may change the pick up time frame at some locations. We will confirm the pick up time with you after we process  your order."></span>
                            </div>
                        <?php }else{ ?>
                            <div class="col-sm-6 col-xs-6">
                                Pick up not available  <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
Due to carrier business hours, pick up services are not available on the shipping date you selected (Saturday, Sunday, and holidays). If you need to schedule a pick-up, please click the “Go Back” button and change the shipping date.

You may also drop off the package at a nearby carrier location. Please check the location by clicking the “find a drop off location” button." data-original-title="" title="" aria-describedby="popover942646"></span>
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
                        <div class="col-sm-4 col-xs-6 padding-right-0"></div>
                        <div class="col-sm-7 col-xs-12 value-info select_trav_list_mob">
                            <?php if(!empty($traveller)){?>
                            <select class="form-control selectpicker select-country"   name="" id="traveller_list_select">
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
                            <input type="text" class="form-control" maxlength="40" name="first_name" id="first_name" placeholder="" value="<?php echo (!empty($traveller_info['first_name']))?$traveller_info['first_name']:$sender_info['sender_first_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Last Name:<span class="important">*</span></label>
                        <div class="col-sm-7 col-xs-7 mob-input">
                            <input type="text" class="form-control" maxlength="40" name="last_name" id="last_name" placeholder=""  value="<?php echo (!empty($traveller_info['last_name']))?$traveller_info['last_name']:$sender_info['sender_last_name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Phone #:<span class="important">*</span></label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control" name="phone" placeholder="" value="<?php echo (!empty($traveller_info['phone']))?$traveller_info['phone']:$sender_info['sender_phone']; ?>">
                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">
                            <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please include the country code for the phone number. For example, put +44 if the phone number is a United Kingdom number." data-original-title="" title="" aria-describedby="popover942646"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Email:</label>
                        <div class="col-sm-7 col-xs-7 mob-input">
                            <input type="text" class="form-control" maxlength="40" name="email" placeholder="" value="<?php echo (!empty($traveller_info['email']))?$traveller_info['email']:$sender_info['sender_email']; ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="half-block">
            <div class="min-block">
                <h2>
                    Origin Address (From)
                    <span class="popover-style secure-code " data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                      If you are dropping off,  you may put your current  address, such as a hotel, business or residence. You may also use the drop-off location as your pick-up (from) address." data-original-title="" title="" aria-describedby="popover942646"></span>
                </h2>
                <div class="form-horizontal">

                    <div class="form-group">
                        <div class="col-sm-4 col-xs-6 padding-right-0"></div>
                        <div class="col-sm-7 col-xs-12 value-info select_trav_list_mob">
                        <?php if(!empty($address_book)){ ?>
                            <select class="form-control selectpicker select-country " name="" id="addres_book_list">
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
                            <input type="text" class="form-control" maxlength="40" name="organization" placeholder="Name of Hotel, Company etc." value="<?php echo (!empty($address_info['organization']))?$address_info['organization']:$sender_info['pickup_company']; ?>">
                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">

                            <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If your luggage or box  is to be picked up at a hotel, golf course,  or  business, include the organization’s name here, so the courier can find it and pick up your shipment without any delays." data-original-title="" title="" aria-describedby="popover942646"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address:<span class="important">*</span></label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control sender_pickup_address orange-color order_font_size" maxlength="50" name="address1" placeholder="" value="<?php echo (!empty($address_info['address1']))?$address_info['address1']:$sender_info['pickup_address1']; ?>">
                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">

                            <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If you are dropping, you may put your current address, such as a hotel, business or residence. You may also use the drop-off location as your pick-up (from) address." data-original-title="" title="" aria-describedby="popover942646"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                        <div class="col-sm-7 col-xs-7 mob-input">
                            <input type="text" class="form-control placeholder_class" maxlength="50" name="address2" placeholder="Apt/floor, suite number" value="<?php echo (!empty($address_info['address2']))?$address_info['address2']:$sender_info['pickup_address2']; ?>">
                        </div>
                    </div>
                   <!-- <?php /*if($order['shipping_type'] == '2'){ */?>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<?php /*if($country == 'United States (USA)') {*/?><span class="important">*</span><?php /*}*/?>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <p class="static-value orange-color"><?php /*echo $sender_info['pickup_postal_code'];*/?></p>
                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">
                            <span class="popover-style secure-code edit_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If you would like to change the postal code, city or country, please click bellow <button type='button' id='update_item_pop' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City<span class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-7 mob-input">
                            <p class="static-value orange-color"><?php /*echo $sender_info['pickup_city'];*/?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<span class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-7 mob-input">
                            <p class="static-value orange-color"><?php /*echo $sender_info['pickup_state_name']; */?></p>
                        </div>
                    </div>
                    --><?php /*}elseif($order['shipping_type'] == '1'){ */?>

                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Postal Code<?php if($country == 'United States (USA)') {?>:<span class="important">*</span><?php }?></label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <input type="text" class="form-control orange-color order_font_size" maxlength="25" name="postal_code" placeholder="Postal Code" value="<?php echo (!empty($address_info['postal_code']))?$address_info['postal_code']:$sender_info['pickup_postal_code']; ?>">
                            </div>
                            <div class="col-sm-1 col-xs-1 no-padding">
                                <span class="popover-style secure-code edit_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If you would like to change the postal code, city or country, please click bellow <button type='button' id='update_item_pop' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">City:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <input type="text" class="form-control sender_pickup_city orange-color order_font_size" maxlength="30" name="city" placeholder="City" value="<?php echo (!empty($address_info['city']))?$address_info['city']:$sender_info['pickup_city']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">State/Region<?php if($country == 'United States (USA)') {?>:<span class="important">*</span><?php }?></label>
                            <div class="col-sm-7 col-xs-7 mob-input">
                                <select class="form-control selectpicker select-country sender_pickup_state orange_text" name="state">
                                    <option value="">Select State</option>
                                    <?php
                                    if(!empty($state)){
                                        foreach($state as $single){

                                            $k = '';

                                            if(!empty($address_info['state']) && $single['Stateid'] == $address_info['state']['Stateid']){

                                                $k = 'selected="selected"';

                                            }elseif(!empty($sender_info['pickup_state']) && $sender_info['pickup_state'] == $single['Stateid']){

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
                <!--    --><?php /*} */?>

                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Country:<span class="important">*</span></label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <p class="static-value orange-color"><?php echo $country;?></p>
                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">
                            <?php
                            if($order['shipping_type'] == '1'){
                            ?>
                            <span class="popover-style secure-code edit_popover_country" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" If you would like to change country, please click bellow <button type='button' id='update_item_pop_country' class='btn btn-default btn-login-blue apply-promotion popover_edit_but'>Edit Item(s) or Service</button> bottom for an update." data-html = "true" data-original-title="" title="" aria-describedby="popover942646"></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 col-xs-5 control-label text-left padding-right-0">Remark:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <textarea class="form-control small_textarea" maxlength="50" placeholder="" name="remark"><?php echo  (!empty($address_info['remark']))?$address_info['remark']:$sender_info['pickup_remark']; ?></textarea>

                        </div>
                        <div class="col-sm-1 col-xs-1 no-padding">
                            <span class="popover-style secure-code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the pick up process.  For example, building security code, hotel concierge/reception desk, college mail room etc. Please be advised carrier will not call or text you before the pick up. The maximum length of the pick up instructions should not exceed 25 characters." data-original-title="" title="" aria-describedby="popover942646"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-default btn-login-orange  save-action sender_pickup_save"><?php echo ($order['shipping_status'] == SUBMITTED_STATUS[0])?'Save & Continue':'Save & Continue';?></button>
    </div>
</form>
<?php } ?>
