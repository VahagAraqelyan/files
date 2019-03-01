

<?php if($action == 'full_cards') {  ?>
    <form method="post" class="form-horizontal" action="" class="pay_select">
        <div class="payment-information">
            <div class="block-1">

                <h2>Credit Card Information: </h2>
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12 mob-input">
                            <select class="form-control selectpicker select-country"  name="credit_cards" id="credit_cards">
                                <option value="new">Add New Card or Select From List</option>
                                <?php foreach ($cards_info as $index => $card){

                                    $k=(!empty($card_num) && $card_num == $card['card_num'])?'selected="selected"':'';

                                    ?>
                                    <option <?php echo $k; ?> value="<?php echo $card['id'] ?>"><?php echo $card['holder_first_name']. " ".$card['holder_last_name']," "."********".substr($card_data['card_number'],-4,4);  ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12 mob-input">
                            As you used all your possible credit cards you can't add a new one.
                        </div>
                    </div>
                </div>

                <div class="border-right"></div>
            </div>

            <p class="clearfix"></p>
            <div class="col-md-12 text-right">

            </div>
        </div>

    </form>
<?php } ?>
<?php if($action == 'view') { ?>
    <form method="post" class="form-horizontal" action="" class="pay_select">
        <div class="payment-information">
            <div class="block-1">

                <h2>Credit Card Information: </h2>
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12 mob-input">
                            <select class="form-control selectpicker select-country"  name="credit_cards" id="credit_cards">
                                <?php if($cards_count < 3){ ?>
                                <option value="new">Add New Card or Select From List</option>
                                    <?php } foreach ($cards_info as $index => $card){
                                        if(!empty($card_data)){
                                            $k=($card_data['card_num']==$card['card_num'])?'selected="selected"':'';

                                        }else{
                                            $k = '';
                                        } ?>
                                        <option <?php echo $k; ?> value="<?php echo $card['id'] ?>"><?php echo $card['holder_first_name']. " ".$card['holder_last_name']," "."********".substr($card_data['card_number'],-4,4);  ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">First Name:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['holder_first_name']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Last Name:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['holder_last_name']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Company:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['company_name']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Card Number:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color">********<?php echo substr($card_data['card_number'],-4,4); ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Card Code:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color">****</p>
                        </div>
                    </div>
                    <div class="form-group expiration_date">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Exp. Date:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['exp_mounth']; ?>-<?php echo $card_data['exp_year']; ?></p>
                        </div>
                    </div>

                </div>

                <div class="border-right"></div>
            </div>
            <div class="block-1 margin-right-0">
                <h2>Billing Information:</h2>

                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Country:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $country; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Address 1:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['address1']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['address2']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">City:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['city']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">State/Region:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $state ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Zip code:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['zip_code']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Phone #:</label>
                        <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                            <p class="static-value orange-color"><?php echo $card_data['phone']; ?></p>
                        </div>
                    </div>
                </div>

            </div>
            <p class="clearfix"></p>
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-default btn-login-orange save-action" id="edit_payment_info">Edit</button>
            </div>
        </div>

    </form>

<?php } ?>

<?php if($action == 'add') { ?>
        <form method="post" class="form-horizontal" action="" id="pay_select">
            <div class="payment-information answer_div payment_info_answer_div">
                <div class="block-1">

                    <h2>Credit Card Information: </h2>

                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 mob-input">
                                <select class="form-control selectpicker select-country"  name="credit_cards" id="credit_cards">
                                    <option value="new">Add New Card or Select From List</option>
                                    <?php
                                    if(!empty($cards_info)){


                                    foreach ($cards_info as $index => $card){

                                        $k=($card_data['card_num']==$card['card_num'])?'selected="selected"':'';
                                        ?>
                                        <option <?php echo $k;?> value="<?php echo $card['id'] ?>"><?php echo $card['holder_first_name']. " ".$card['holder_last_name']," "."********".substr($card_data['card_number'],-4,4);  ?></option>
                                    <?php }  } ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">First Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" maxlength="25" class="form-control" name="holder_first_name" placeholder="Holder First Name" value="<?php echo $card_data['holder_first_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Last Name:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" maxlength="25" class="form-control" name="holder_last_name" placeholder="Holder Last Name" value="<?php echo $card_data['holder_last_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Company:</label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" maxlength="40" class="form-control" name="company_name" placeholder="Company Name" value="<?php echo $card_data['company_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Card Number:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <?php if(!empty($edit)){
                                    ?>
                                    <input type="text" class="form-control" name="card_number" disabled placeholder="Card Number" value="************<?php echo substr($card_data['card_number'],-4,4);?>">
                                    <?php
                                }else{
                                    ?>
                                    <input type="text" class="form-control" name="card_number" placeholder="Card Number">
                                <?php
                                }?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Card Code:<span class="important">*</span>
                            <!--
                                <span class="popover-style secure-code credit_card_popover payment_popover_class" data-html = "true" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="
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
                            " data-original-title="" title="" aria-describedby="popover942646"></span>
                            --->
                            </label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <div class="inp-credit-card">
                                    <input type="text" maxlength="4" class="form-control sec-code-inp" name="security_code" placeholder="Card Number" value="<?php echo $credit_card_number; ?>">
                                </div>

                                <div class="span-credit-card">
                                    <span class="popover-style secure-code credit_card_popover payment_popover_class" data-html = "true" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="
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

                                    </span>


                                </div>

                            </div>
                        </div>
                        <div class="form-group expiration_date">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Exp. Date:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <select class="form-control selectpicker select-date select-country" name="exp_mounth">
                                    <option value="">Month</option>
                                    <?php
                                    for($i=1; $i<=12; $i++){
                                        $k = ($card_data['exp_mounth'] == $i)?'selected="selected"':'';
                                        ?>
                                        <option value="<?php echo $i; ?>" <?php echo $k; ?>><?php echo ($i < 10)?'0'.$i:$i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <select class="form-control selectpicker select-date select-country" name="exp_year">
                                    <option value="">Year</option>
                                    <?php
                                    for($i=intval(date('Y')); $i<=intval(date('Y'))+29; $i++){
                                        $k = ($card_data['exp_year'] == $i)?'selected="selected"':'';
                                        ?>
                                        <option value="<?php echo $i; ?>" <?php echo $k; ?>><?php echo $i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="border-right"></div>
                </div>
                <div class="block-1 margin-right-0">
                    <h2>Billing Information:</h2>

                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Country:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <select class="form-control selectpicker select-country" name="credit_card_country" id="my_profile_country">
                                    <option value="">Select Country</option>
                                    <?php
                                    foreach($countries as $value){
                                        $k = ($card_data['country_id'] == $value['id'])?'selected="selected"':'';
                                        ?>
                                        <option value="<?php echo $value["iso2"].'_'.$value["id"]; ?>" <?php echo $k; ?>><?php echo $value['country']?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Address 1:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" class="form-control" maxlength="40" name="address1" placeholder="Address 1:" value="<?php echo $card_data['address1'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Address 2:</label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" class="form-control placeholder_class"maxlength="40" name="address2" placeholder="Apt/floor, suite number" value="<?php echo $card_data['address2'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">City:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" class="form-control" maxlength="25" name="city" placeholder="City:" value="<?php echo $card_data['city'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">State/Region:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <select class="form-control selectpicker select-country" name="state_region" id="region_account_info" >
                                    <option value="">Select State</option>
                                    <?php if(!empty($edit) && !empty($all_states)){
                                        foreach($all_states as $single){
                                            $k = ($single['Stateid'] == $card_data['state_id'])?'selected="selected"':'';
                                            ?>
                                            <option value="<?php echo $single['Stateid']; ?>" <?php echo $k; ?>><?php echo $single['State']; ?></option>
                                            <?php
                                        }
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0 zip_code_text">Zip code:</label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" maxlength="25" class="form-control" name="zip_code" id="zip_code" placeholder="Zip code:" value="<?php echo $card_data['zip_code'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 col-xs-5 control-label text-left padding-right-0">Phone #:<span class="important">*</span></label>
                            <div class="col-sm-7 col-xs-7 mob-input padding-left-0">
                                <input type="text" class="form-control" maxlength="22" name="phone" placeholder="Phone:" value="<?php echo $card_data['phone'];?>">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="clearfix"></p>
                <div class="col-md-12 text-right">
                <?php if(!empty($edit)){ ?>
                    <button type="button" class="btn btn-default btn-login-orange save-action" id="edit_order_card" data_id="<?php echo $card_data['id'];?>" data_num="<?php echo $card_data['card_num'];?>"><?php echo ($order['shipping_status'] == SUBMITTED_STATUS[0])?'Save & Continue':'Save & Continue';?></button>
                <?php }
                else{ ?>
                    <button type="button" class="btn btn-default btn-login-orange save-action save_payment_card"><?php echo ($order['shipping_status'] == SUBMITTED_STATUS[0])?'Save & Continue':'Save & Continue';?></button>
               <?php }?>

                </div>
            </div>
        <div class="payment_loader display_none">
            <div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>
        </div>
        </form>
<?php } ?>