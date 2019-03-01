<div class="register-block no-hide delivery_mobile_adding">

    <h2 class="register-title text-center lovercase">Label Delivery</h2>

    <div class="panel-body">

        <form method="post" action="" id="delivery_label_form">
            <div class="form-horizontal text-left my_profile_content">
             <div class="form-group">
                 <p class="jusify_class text_padding">
                     We will try to mail you the shipping labels and pouches for free.
                     The envelope will be delivered to "From“ address or below address if you specified. Please reach out us at 18006786167 if you have any question. Thanks.
                 </p>
             </div>
                <div class="registration-error">
                    <span id="add_error_img"></span>
                    <span id="register_error"></span>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index strong_text">
                        Receiver
                    </div>
                    <div class="col-xs-7 value-info">
                        <?php if(!empty($traveller)){?>
                        <select class="form-control selectpicker select-country my_profile"   name="" id="delivery_label_list">
                            <option value="">Select from name list</option>
                            <?php foreach ($traveller as $index => $value){
                                $k=($trav_id==$value['id'])?'selected="selected"':'';
                                ?>
                                <option value="<?php echo $value['id']; ?>" <?php echo $k; ?>><?php echo $value['first_name']." ".$value['last_name']; ?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div><div class="form-group">
                    <div class="col-xs-4 control-label value-index">First Name:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" maxlength="40" name="first_name" placeholder="" value="<?php echo (!empty($traveller_info['first_name']))?$traveller_info['first_name']:$delivery_info['first_name']; ?>">
                    </div>
                </div><div class="form-group">
                    <div class="col-xs-4 control-label value-index">Last Name:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" maxlength="40" name="last_name" placeholder="" value="<?php echo (!empty($traveller_info['last_name']))?$traveller_info['last_name']:$delivery_info['last_name']; ?>">
                    </div>
                </div><div class="form-group">
                    <div class="col-xs-4 control-label value-index">Phone Number:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" maxlength="22" name="phone" placeholder="" value="<?php echo (!empty($traveller_info['phone']))?$traveller_info['phone']:$delivery_info['phone']; ?>">
                    </div>
                    <div class="col-sm-1 col-xs-1 no-padding">
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please include the country code for the phone number. For example, put +44 if the phone number is a UK number." data-original-title="" title=""></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Email:

                    </div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" maxlength="40" name="email" placeholder=""  value="<?php echo (!empty($traveller_info['email']))?$traveller_info['email']:$delivery_info['email']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index strong_text">
                        To
                    </div>
                    <div class="col-xs-7 value-info">
                        <?php if(!empty($address_book)){ ?>
                        <select class="form-control selectpicker select-country my_profile" name="" id="delivery_label_address">
                            <option value=" ">Select from address book</option>
                            <?php
                            foreach ($address_book as $index => $value){
                                $k=($add_id==$value['id'])?'selected="selected"':' ';
                                ?>
                                <option <?php echo $k; ?> value="<?php echo $value['id']; ?>"><?php echo $value['contact_id']." ". $value['address1']." ".$value['city']; ?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Organization:
                    </div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control placeholder_class" maxlength="40" name="company" placeholder="Please enter name here" value="<?php echo (!empty($address_info['organization']))?$address_info['organization']:$delivery_info['company']; ?>">
                    </div>
                    <div class="col-sm-1 col-xs-1 no-padding">
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If your label will be delivered to a hotel, or company, please input the organization’s name here. So the courier can find it and pick up your shipment without any delay." data-original-title="" title=""></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address 1:<span class="important">*</span></div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" maxlength="50" name="address1" placeholder="" value="<?php echo (!empty($address_info['address1']))?$address_info['address1']:$delivery_info['address1']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address 2:</div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control placeholder_class" maxlength="50" name="address2" placeholder="Apartment or suite number etc." value="<?php echo (!empty($address_info['address2']))?$address_info['address2']:$delivery_info['address2']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Postal Code:<span class="important">*</span></div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control not_string" maxlength="25" name="postal_code" placeholder="Postal Code" value="<?php echo (!empty($address_info['postal_code']))?$address_info['postal_code']:$delivery_info['postal_code']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">City:<span class="important">*</span></div>
                    <div class="col-xs-7 value-info">
                        <input type="text" class="form-control" name="city" maxlength="30" placeholder="City" value="<?php echo (!empty($address_info['city']))?$address_info['city']:$delivery_info['city']; ?>">
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">State/Region:</div>
                    <div class="col-xs-7 value-info">
                        <select class="form-control selectpicker select-country my_profile" name="state_region">
                            <option value="">Select State</option>
                            <?php foreach ($states as $state){

                                $k = ((!empty($state['Stateid']) && $state['Stateid'] == $delivery_info['state_id']) || (!empty($address_info['state']['Stateid']) && $state['Stateid'] == $address_info['state']['Stateid']))?'selected = selected':'';
                                ?>
                                <option value="<?php echo $state['Stateid']; ?>" <?php echo  $k; ?> ><?php echo $state['State']; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Country:</div>
                    <div class="col-xs-7 value-info">
                        <p class="static-value orange-color"><?php echo $country[0]['country']; ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Remark:</div>
                    <div class="col-sm-7 col-xs-7 mob-input delivery_remark">
                        <textarea class="delivery_textarea" maxlength="200" placeholder="Please put any special notes related to the label shipment. For example, C/O, building security code etc." name="remark"><?php echo  (!empty($address_info['remark']))?$address_info['remark']:$delivery_info['remark']; ?></textarea>
                    </div>
                    <div class="col-sm-1 col-xs-1 no-padding">
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please assign instructions that will be forwarded to the carrier to better assist the delivery process.  For example, building security code, hotel concierge/reception desk, college mail room etc.  The maximum length of the delivery instructions should not exceed 25 characters." data-original-title="" title=""></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                    <div class="col-xs-11">
                    <button type="button" class="btn btn-default btn-login-orange save-info-btn delivery_label_save delivery_label_edit">Save</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
</div>
</div>

