<form method="post" class="form-horizontal my_profile_content" id = 'credit_card_form_<?php echo $card_num; ?>'>
    <h2 class="mobile_version">My Credit Card #<?php echo $card_num; ?></h2>
<?php

if(empty($ver_status) || $ver_status == 1){
    ?>
    <div class="block-2 colored-block mobile_version">
        <div class="min-block">
            <h2 class="text-center">Credit Card Verification</h2>

            <p class="text-center info-text">We may charge your credit card an amount between $0.2 to $10 for verification. The amount will be refunded within 48 hours.</p>
            <p class="border-bottom"></p>
            <p class="text-center info-text">Currently, we do not ask for verification. However, you may request a refundable verification charge of your credit card for quick processing. </p>
        </div>

    </div>
    <?php
}elseif(empty($ver_status) || $ver_status == 2){
    ?>
    <div class="block-2 colored-block mobile_version">
        <div class="min-block">
            <h2 class="text-center">Credit Card Verification <i class="fa fa-exclamation information-icon"></i></h2>
            <?php if($ver_attempt < 2) {?>
                <p class="text-center info-text">Please select the amount we charged for verification</p>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <span class="price-sign">$</span>
                        <select class="form-control selectpicker select-price my_profile" name="int_part">
                            <?php
                            for($i=0; $i<=10; $i++){
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="price-sign"> . </span>
                        <select class="form-control selectpicker select-price my_profile" name="float_part">
                            <?php
                            for($i=0; $i<10; $i++){
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i.'0'; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <p class="text-center info-text">Amount between   $0.50  and  $10.00</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-default btn-login-orange verify-credit-card changed_button" data-card="<?php echo $card_num; ?>">Submit</button>
                    </div>
                </div>
                <p class="border-bottom"></p>
            <?php } ?>
            <p class="text-center info-text">We have changed an amount from your credit card for verification. Please check with your bank and enter the amount above.</p>
        </div>

    </div>
    <?php
}elseif(!empty($ver_status) && $ver_status == 3){
    ?>
    <div class="block-2 colored-block mobile_version">

        <div class="min-block">
            <h2 class="text-center">Credit Card Verification <i class="fa fa-check delivered-icon"></i></h2>

            <p class="text-center info-text orange-color verified-text">Your credit card has been verified. </p>
            <p class="text-center info-text">Please be advised that we may ask for credit card verification again if you update the credit card information. </p>
        </div>

    </div>
    <?php
}
    if($action == 'add') {
        ?>
            <input type="hidden" value="<?php echo $card_num; ?>" name="card_num" id="card_id_<?php echo $card_num; ?>">
            <div class="block-1">

                <h2 class="pc_version">My Credit Card #<?php echo $card_num; ?></h2>

                <div class="form-horizontal ">
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder First Name<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control" maxlength="25" name="holder_first_name" placeholder="Holder First Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder Last Name<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control" maxlength="25" name="holder_last_name" placeholder="Holder Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control" maxlength="40" name="company_name" placeholder="Company Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Number<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" class="form-control" name="card_number" placeholder="Card Number">
                        </div>
                    </div>
                    <div class="form-group expiration_date">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Expiration Date<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <select class="form-control selectpicker select-date my_profile" name="exp_mounth">
                                <option value="">Month</option>
                                <?php
                                for($i=1; $i<=12; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo ($i < 10)?'0'.$i:$i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select class="form-control selectpicker select-date my_profile" name="exp_year">
                                <option value="">Year</option>
                                <?php
                                for($i=intval(date('Y')); $i<=intval(date('Y'))+29; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                }
                              ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Code<span
                                class="important">*</span>:
                            <span class="popover-style mobile_version credit_card_popover" data-html="true" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="
                                      <div class = 'credit_main'>
                                  <div class = 'cards_content vis_content'>
                                    <div class = 'credit_img_div'>
                                        <img src = '<?php echo base_url('assets/images/visa_credit.png'); ?>'>
                                    </div>
                                    <div class = 'credit_text_div'>
                                        <p>
                                            Visa, MasterCard or Discover.
                                             This 3-digit number is on the back of the card next to the signature panel.
                                        </p>
                                    </div>
                                     <br class = 'clear'>
                                  </div>
                                    <div class = 'cards_content american_content'>
                                     <div class = 'credit_img_div'>
                                         <img src = '<?php echo base_url('assets/images/american_credit.png'); ?>'>
                                     </div>
                                      <div class = 'credit_text_div'>
                                      <p>
                                         American Express
                                         This 4-ditit number is on the front of
                                          the card above the credit card number.
                                      </p
                                    </div>
                                     <br class = 'clear'>
                                    </div>
                                  </div>
                                 "
                                  data-original-title="" title=""></span>
                        </label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="password" class="form-control secure-code-place" maxlength="4" name="security_code" placeholder="Security Code">
                            <span class="popover-style secure-code pc_version home-separate-pop credit_card_popover" data-container="body" data-toggle="popover" data-trigger="hover" data-html = true data-placement="top"
                                  data-content="
                                         <div class = 'credit_main'>
                                  <div class = 'cards_content vis_content'>
                                    <div class = 'credit_img_div'>
                                        <img src = '<?php echo base_url('assets/images/visa_credit.png'); ?>'>
                                    </div>
                                    <div class = 'credit_text_div'>
                                        <p>
                                            Visa, MasterCard or Discover.
                                             This 3-digit number is on the back of the card next to the signature panel.
                                        </p>
                                    </div>
                                     <br class = 'clear'>
                                  </div>
                                    <div class = 'cards_content american_content'>
                                     <div class = 'credit_img_div'>
                                         <img src = '<?php echo base_url('assets/images/american_credit.png'); ?>'>
                                     </div>
                                      <div class = 'credit_text_div'>
                                      <p>
                                         American Express
                                         This 4-ditit number is on the front of
                                          the card above the credit card number.
                                      </p
                                    </div>
                                     <br class = 'clear'>
                                    </div>
                                  </div>
                                 "
                                  data-original-title="" title="" aria-describedby="popover942646">
                        </div>
                    </div>

                </div>

                <div class="border-right"></div>
            </div>
            <div class="block-1 margin-right-0">
                <h2>Billing Information</h2>

                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Country<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <select class="form-control selectpicker my_profile" name="credit_card_country" id="country-select-card"  data-block="<?php echo $card_num; ?>">
                                <option value="">Select Country</option>
                                <?php
                                foreach($countries as $value){
                                    ?>
                                    <option value="<?php echo $value["iso2"].'_'.$value["id"]; ?>"><?php echo $value['country']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 1<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" maxlength="40" class="form-control" name="address1" placeholder="Address 1:">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" maxlength="40" class="form-control" name="address2" placeholder="Address 2:">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">City<span
                                class="important">*</span>:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" maxlength="25" class="form-control" name="city" placeholder="City:">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <select class="form-control selectpicker my_profile" name="state_region" id="state_select_card_<?php echo $card_num; ?>">
                                <option value="">Select State</option>
                                <?php
                                if(!empty($states)){
                                    foreach($states as $value){
                                        $k=($value['Stateid']==$state_reg)?'selected=\'selected\'':'';
                                        ?>
                                        <option value="<?php echo $value['Stateid']; ?>" <?php echo $k; ?> ><?php echo $value['State']?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="zip_code" class="col-sm-5 col-xs-6 control-label text-left">Zip code:</label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text"  maxlength="25" class="form-control" name="zip_code" id="zip_code_<?php echo $card_num; ?>" placeholder="Zip code:">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-6 control-label text-left">Phone<span
                                    class="important">*</span>:
                            <span class="popover-style mobile_version" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Phone Number" data-original-title="" title=""></span>
                        </label>
                        <div class="col-sm-7 col-xs-6 mob-input">
                            <input type="text" maxlength="22" class="form-control secure-code-place" name="phone" placeholder="Phone:">
                            <span class="popover-style secure-code pc_version" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Phone Number" data-original-title="" title="" aria-describedby="popover942646">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-right button-place">
                            <button type="button" class="btn btn-default btn-login-orange verif-card changed_button" data-block="<?php echo $card_num; ?>" >Submit</button>
                        </div>
                    </div>
                </div>

                <div class="border-right"></div>
            </div>
        <?php
    }

    if($action == 'edit') {
        ?>
        <input type="hidden" value="<?php echo $id; ?>" name="card_id" id="card_id_<?php echo $card_num; ?>">
        <div class="block-1">
            <h2>My Credit Card #<?php echo $card_num; ?></h2>

            <div class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder First Name<span class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="25" class="form-control" name="holder_first_name" placeholder="Holder First Name" value = '<?php echo $holder_first_name; ?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder Last Name<span class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="25"  class="form-control" name="holder_last_name" placeholder="Holder Last Name" value = '<?php echo $holder_last_name; ?>'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="40" class="form-control" name="company_name" placeholder="Company Name" value = '<?php echo $company_name; ?>'>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Number<span class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" class="form-control"  disabled value = '************<?php echo $card_number; ?>'>
                    </div>
                </div>
                <div class="form-group expiration_date">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Expiration Date<span class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <select class="form-control selectpicker select-date my_profile" name="exp_mounth">
                            <option value="">MM</option>
                            <?php
                            for($i=1; $i<=12; $i++){
                                $k = ($exp_mounth == $i)?'selected="selected"':'';
                                ?>
                                <option <?php echo $k; ?> value="<?php echo $i; ?>"><?php echo ($i < 10)?'0'.$i:$i; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <select class="form-control selectpicker select-date my_profile" name="exp_year">
                            <option value="">YY</option>
                            <?php
                            for($i=intval(date('Y')); $i<=intval(date('Y'))+29; $i++){
                                $k = ($exp_year == $i)?'selected="selected"':'';
                                ?>
                                <option <?php echo $k; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Code<span
                                class="important">*</span>:
                        <span class="popover-style mobile_version credit_card_popover" data-container="body" data-html = 'true' data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                            <div class = 'credit_main'>
                                  <div class = 'cards_content vis_content'>
                                    <div class = 'credit_img_div'>
                                        <img src = '<?php echo base_url('assets/images/visa_credit.png'); ?>'>
                                    </div>
                                    <div class = 'credit_text_div'>
                                        <p>
                                            Visa, MasterCard or Discover.
                                             This 3-digit number is on the back of the card next to the signature panel.
                                        </p>
                                    </div>
                                     <br class = 'clear'>
                                  </div>
                                    <div class = 'cards_content american_content'>
                                     <div class = 'credit_img_div'>
                                         <img src = '<?php echo base_url('assets/images/american_credit.png'); ?>'>
                                     </div>
                                      <div class = 'credit_text_div'>
                                      <p>
                                         American Express
                                         This 4-ditit number is on the front of
                                          the card above the credit card number.
                                      </p
                                    </div>
                                     <br class = 'clear'>
                                    </div>
                                  </div>
                         " data-original-title="" title=""></span>
                    </label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="password" class="form-control secure-code-place" maxlength="4" name="security_code" placeholder="Security Code">
                        <span class="popover-style secure-code pc_version credit_card_popover" data-html = 'true' data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="
                            <div class = 'credit_main'>
                                  <div class = 'cards_content vis_content'>
                                    <div class = 'credit_img_div'>
                                        <img src = '<?php echo base_url('assets/images/visa_credit.png'); ?>'>
                                    </div>
                                    <div class = 'credit_text_div'>
                                        <p>
                                            Visa, MasterCard or Discover.
                                             This 3-digit number is on the back of the card next to the signature panel.
                                        </p>
                                    </div>
                                     <br class = 'clear'>
                                  </div>
                                    <div class = 'cards_content american_content'>
                                     <div class = 'credit_img_div'>
                                         <img src = '<?php echo base_url('assets/images/american_credit.png'); ?>'>
                                     </div>
                                      <div class = 'credit_text_div'>
                                      <p>
                                         American Express
                                         This 4-ditit number is on the front of
                                          the card above the credit card number.
                                      </p
                                    </div>
                                     <br class = 'clear'>
                                    </div>
                                  </div>
                        " data-original-title="" title="" aria-describedby="popover942646">
                    </div>
                </div>

            </div>

            <div class="border-right"></div>
        </div>
        <div class="block-1 margin-right-0">
            <h2>Billing Information</h2>

            <div class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Country<span
                                class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <select class="form-control selectpicker my_profile" name="credit_card_country" id="country-select-card"  data-block="<?php echo $card_num; ?>">
                            <option value="">Select Country</option>
                            <?php
                            foreach($countries as $value){
                                $k=($value['id']==$country_id)?'selected=\'selected\'':'';
                                ?>
                                <option value="<?php echo $value["iso2"].'_'.$value["id"]; ?>" <?php echo $k; ?> ><?php echo $value['country']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 1<span
                                class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="40" class="form-control" name="address1" placeholder="Address 1:" value="<?php echo $address1; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="40" class="form-control" name="address2" placeholder="Address 2:" value="<?php echo $address2; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">City<span
                                class="important">*</span>:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" class="form-control" maxlength="25" name="city" placeholder="City:" value="<?php echo $city; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <select class="form-control selectpicker my_profile" name="state_region" id="state_select_card_<?php echo $card_num; ?>">
                            <option value="">Select State</option>
                            <?php
                            if(!empty($states)){
                                foreach($states as $value){
                                    $k=($value['Stateid']==$state_id)?'selected=\'selected\'':'';
                                    ?>
                                    <option value="<?php echo $value['Stateid']; ?>" <?php echo $k; ?> ><?php echo $value['State']?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="zip_code" class="col-sm-5 col-xs-6 control-label text-left">Zip code:</label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" maxlength="25" class="form-control" name="zip_code" id="zip_code_<?php echo $card_num; ?>" placeholder="Zip code:" value="<?php echo $zip_code; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 col-xs-6 control-label text-left">Phone<span
                                class="important">*</span>:
                        <span class="popover-style mobile_version" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Phone Number" data-original-title="" title=""></span>
                    </label>
                    <div class="col-sm-7 col-xs-6 mob-input">
                        <input type="text" class="form-control secure-code-place" maxlength="22" name="phone" placeholder="Phone:" value="<?php echo $phone; ?>">
                        <span class="popover-style secure-code pc_version" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Phone Number" data-original-title="" title="" aria-describedby="popover942646">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 text-right button-place">
                        <button type="button" class="btn btn-default btn-login-orange save-credit-card-change changed_button" data-block="<?php echo $card_num; ?>" >Submit</button>
                    </div>
                </div>
            </div>

            <div class="border-right"></div>
        </div>
        <?php
    }

    if($action == 'view'){
        ?>
                <input type="hidden" value="<?php echo $id; ?>" name="card_id" id="card_id_<?php echo $card_num; ?>">
                <div class="block-1">

                    <h2>My Credit Card #<?php echo $card_num; ?></h2>

                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder First Name<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color "><?php echo $holder_first_name; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder Last Name<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $holder_last_name; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $company_name; ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Number<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color">************<?php echo $card_number; ?></p>
                            </div>
                        </div>
                        <div class="form-group expiration_date">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Expiration Date<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <?php
                                $exp_mounth=($exp_mounth<10)?'0'.$exp_mounth:$exp_mounth;
                                ?>
                                <p class="static-value orange-color"><?php echo $exp_mounth.' - '.$exp_year; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Code<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color">***</p>
                            </div>
                        </div>

                    </div>

                    <div class="border-right"></div>
                </div>
                <div class="block-1 margin-right-0">
                    <h2>Billing Information</h2>

                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Country<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $country; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 1<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $address1; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $address2; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">City<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $city; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $State; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Zip code:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $zip_code; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Phone<span class="important">*</span>:</label>
                            <div class="col-sm-7 col-xs-6 mob-input">
                                <p class="static-value orange-color"><?php echo $phone; ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-right button-place">
                                <a class="btn btn-default select-doc-file ed-del-action-btn delete-credit-card bold_button" data-card="<?php echo $id; ?>"><i class="fa fa-trash bold_button"></i>DELETE</a>
                                <a class="btn btn-default select-doc-file ed-del-action-btn edit-credit-card bold_button" data-card="<?php echo $card_num; ?>"><i class="fa fa-pencil-square-o bold_button"></i>EDIT</a>
                            </div>
                        </div>
                    </div>

                    <div class="border-right"></div>
                </div>
                <?php
    }

    if(empty($ver_status) || $ver_status == 1){
        ?>
        <div class="block-2 colored-block pc_version">
            <div class="min-block">
                <h2 class="text-center">Credit Card Verification</h2>

                <p class="text-center info-text">We may charge your credit card an amount between $0.2 to $10 for verification. The amount will be refunded within 48 hours.</p>
                <p class="border-bottom"></p>
                <p class="text-center info-text">Currently, we do not ask for verification. However, you may request a refundable verification charge of your credit card for quick processing. </p>
            </div>

        </div>
        <?php
    }elseif(empty($ver_status) || $ver_status == 2){
        ?>
        <div class="block-2 colored-block pc_version">
            <div class="min-block">
                <h2 class="text-center">Credit Card Verification <i class="fa fa-exclamation information-icon"></i></h2>
                <?php if($ver_attempt < 2) {?>
                <p class="text-center info-text">Please select the amount we charged for verification</p>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <span class="price-sign">$</span>
                            <select class="form-control selectpicker select-price my_profile" name="int_part">
                                <?php
                                for($i=0; $i<=10; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="price-sign"> . </span>
                            <select class="form-control selectpicker select-price my_profile" name="float_part">
                                <?php
                                for($i=0; $i<10; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i.'0'; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <p class="text-center info-text">Amount between   $0.50  and  $10.00</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                          <button type="button" class="btn btn-default btn-login-orange verify-credit-card changed_button" data-card="<?php echo $card_num; ?>">Submit</button>
                        </div>
                    </div>
                <p class="border-bottom"></p>
                <?php } ?>
                <p class="text-center info-text">We have changed an amount from your credit card for verification. Please check with your bank and enter the amount above.</p>
            </div>

        </div>
        <?php
    }elseif(!empty($ver_status) && $ver_status == 3){
        ?>
        <div class="block-2 colored-block pc_version">

            <div class="min-block">
                <h2 class="text-center">Credit Card Verification <i class="fa fa-check delivered-icon"></i></h2>

                <p class="text-center info-text orange-color verified-text">Your credit card has been verified. </p>
                <p class="text-center info-text">Please be advised that we may ask for credit card verification again if you update the credit card information. </p>
            </div>

        </div>
        <?php
    }
?>
</form>
