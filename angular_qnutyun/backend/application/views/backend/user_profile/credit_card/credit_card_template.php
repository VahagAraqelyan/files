<div class="card_info">
    <form method="post" id="update_info_form_<?php echo $card_num; ?>">
<div class="block-1  block_1">
    <div class="card_information">
    <input type="hidden" name="card_num" value="<?php echo $card_num; ?>">
    <h2>My Credit Card #<?php echo $card_num; ?></h2>

    <div class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder First Name<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" maxlength="25" class="form-control" name="holder_first_name" placeholder="Holder First Name" value="<?php echo $holder_first_name;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Holder Last Name<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text"  maxlength="25" class="form-control" name="holder_last_name" placeholder="Holder Last Name" value="<?php echo $holder_last_name;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" maxlength="40" class="form-control" name="company_name" placeholder="Company Name" value="<?php echo $company_name;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Card Number<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" class="form-control" name="card_number" <?php echo $disable; ?> placeholder="Card Number" value="<?php echo $card_val.$card_number;?>">
            </div>
        </div>
        <div class="form-group expiration_date">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Expiration Date<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <select class="form-control selectpicker select-date exp" name="exp_mounth">
                    <option value="">Month</option>
                    <?php
                    for($i=1; $i<=12; $i++){
                        $k = ($i == $exp_mounth)?'selected = "selected"':'';
                        ?>
                        <option <?php echo $k; ?> value="<?php echo $i; ?>"><?php echo ($i < 10)?'0'.$i:$i; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select class="form-control selectpicker select-date exp" name="exp_year">
                    <option value="">Year</option>
                    <?php
                    for($i=intval(date('Y')); $i<=intval(date('Y'))+29; $i++){
                        $k = ($i == $exp_year)?'selected = "selected"':'';
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
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="password" class="form-control secure-code-place" maxlength="4" name="security_code" placeholder="Security Code" value="<?php echo  $sec_val; ?>">

            </div>
        </div>

    </div>
    </div>
    <div class="col-xs-12 text-right button-place" id="cvc_div">
        <?php
        $status_arr = [
            '0' => 'fa fa-times delay-icon',
            '1' => 'fa fa-check delivered-icon',
        ];
        $status_risk = [
                '1' => '<span class="success_class"> No risk</span>',
                '0' => '<span class="error_class"> Risk</span>',
        ]
        ?>
    <table>
        <tr>
            <td>  Type: </td>
            <td> <?php echo $type;?></td>

        </tr>
        <tr>
            <td> Origin:</td>
            <td><?php echo $origin;?></td>
        </tr>
        <tr>
            <td> Risk lavel:</td>
            <td>  <?php echo $status_risk[$risk_check]; ?></td>

        </tr>
    </table>

    <table>
        <tr>
            <td> CVC check:</td>
            <td><i class="<?php echo $status_arr[$cvc_check]; ?>"></i></td>
        </tr>
        <tr>
            <td>Street check:</td>
            <td><i class="<?php echo $status_arr[$street_check]; ?>"></i></td>

        </tr>
        <tr>
            <td>Zip check:</td>
            <td> <i class="<?php echo $status_arr[$zip_check]; ?>"></i></td>

        </tr>
    </table>
    </div>
</div>
<div class="block-1 margin-right-0  block_2">

    <div class="billing_info">
    <h2>Billing Information</h2>

    <div class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Country<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <select class="form-control selectpicker country-select_aj" name="credit_card_country" id="country-select-card"  data-block="<?php echo $card_num; ?>">
                    <option value="">Select Country</option>
                    <?php

                    foreach($countries as $value){
                        $k=($value['id'] == $country_id)?'selected=\'selected\'':'';
                        ?>
                        <option value="<?php echo $value["iso2"].'_'.$value["id"]; ?>"  <?php echo $k; ?> ><?php echo $value['country'];  ?></option>
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
                <input type="text" maxlength="40" class="form-control" name="address1" placeholder="Address 1:" value="<?php echo $address1;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" class="form-control" maxlength="40" name="address2" placeholder="Address 2:" value="<?php echo $address2;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">City<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" class="form-control" maxlength="25" name="city" placeholder="City:" value="<?php echo $city;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <select class="form-control selectpicker" name="state_region" id="state_select_<?php echo  $card_num; ?>">
                    <option value="">Select State</option>
                    <?php
                    if(!empty($states)){
                        foreach($states as $value){
                            $k=($value['Stateid']== $state_id)?'selected=\'selected\'':'';
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
                <input type="text" class="form-control" maxlength="25" name="zip_code" id="zip_code_<?php echo $card_num; ?>" placeholder="Zip code:" value="<?php echo $zip_code;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-5 col-xs-6 control-label text-left">Phone<span
                    class="important">*</span>:</label>
            <div class="col-sm-7 col-xs-6 mob-input">
                <input type="text" class="form-control" maxlength="22" name="phone" placeholder="Phone:" value="<?php echo $phone;?>">
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" name="card_id" value="<?php echo $id; ?>" id="card_id">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <?php if($ver_status == '2' && empty($ver_pay)) { ?>
    <div class="verif">
            <input type="hidden" name="card_id" value="<?php echo $id; ?>" id="card_id">
        <div class="form-group">
            <div class="col-xs-12 text-right button-place">
                <button type="button" class="btn btn-default btn-login-orange charge_verif"  data-block="<?php echo $card_num; ?>" >Charge Verification</button>
                <button type="button" class="btn btn-default btn-login-orange <?php echo $button_class; ?>"  data-block="<?php echo $card_num; ?>"><?php echo $button_name; ?></button>
            </div>
        </div>
        <div class="form-group">
           <div class="col-xs-6 ">
                <table class="col-xs-12">
                    <tr>
                        <td>
                            <select class="form-control selectpicker select-price" name="int_part" id="int_part">
                                <?php
                                for($i=0; $i<=10; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control selectpicker select-price" name="float_part" id>
                                <?php
                                for($i=0; $i<9; $i=$i+2){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i.'0'; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>


            </div>
        </div>

    <div >
    </div>
        <br class="clear">
    </div>
    <?php } else {
        ?>
        <div class="verif">
            <div class="form-group">
                <div class="col-xs-12 text-right button-place">
                     <button type="button" class="btn btn-default btn-login-orange <?php echo $button_class; ?>"  data-block="<?php echo $card_num; ?>"><?php echo $button_name; ?></button>
                </div>
            </div>
            <br class="clear">
        </div>
        <?php
    }?>
</div>
    </form>
    <div class="block-1 margin-right-0 block_3">
        <div class="status_div">
            <form action="" method="post" id="status_form_<?php echo $card_num; ?>">
                <input type="hidden" name="card_id" value="<?php echo $id; ?>">
        <table class="cc_table">

            <tr>
                <td>CC Copy: </td><td><input type="checkbox" name="cc_copy" value="1" <?php echo ($cc_copy == '1')?'checked = checked':""; ?> ></td>
            </tr>
            <tr>
                <td>CC Bin:</td><td> <input type="checkbox" name="cc_bin" value="1" <?php echo ($cc_bin == '1')?'checked = checked':""; ?>></td>
            </tr>
            <tr>
                <td>ID Copy:</td><td><input type="checkbox" name="id_copy" value="1" <?php echo ($id_copy == '1')?'checked = checked':""; ?> > </td>
            </tr>
            <tr>
                <td>Bank V. :</td><td><input type="checkbox" name="bank_v" value="1"  <?php echo ($bank_v == '1')?'checked = checked':""; ?>> </td>
            </tr>
        </table>
            <table class="cc_table">

                <tr>
                    <td><span class="fa fa-check picked-up-icon"></span> Regular:</td><td><input type="radio" name="card_status" value="1" <?php echo ($ver_status == '1')?'checked = checked':""; ?>></td>
                </tr>
                <tr>
                    <td><span class="fa fa-exclamation created-icon fa_under_review"></span> Under Review:</td><td><input type="radio" name="card_status"  value="2" <?php echo ($ver_status == '2')?'checked = checked':""; ?>></td>
                </tr>
                <tr>
                    <td><span class="fa fa-check delivered-icon"></span> Verified:</td><td><input type="radio" name="card_status"  value="3" <?php echo ($ver_status == '3')?'checked = checked':""; ?>></td>
                </tr>
                <tr>
                    <td><span class="fa fa-times delay-icon"></span> Cancel:</td><td><input type="radio" name="card_status" value="0" <?php echo ($ver_status == '0')?'checked = checked':""; ?>></td>
                </tr>
            </table>
            <button type="button" class="btn btn-default btn-login-orange update_status"  data-block="<?php echo $card_num; ?>" >Update</button>
            </form>

            <table class="verif_table verif_pay_table">
                <tr>
                    <th colspan="3">Verification</th>
                </tr>
                <tr>
                    <td rowspan="4"><p><?php echo $ver_date;?></p></td>
                    <td rowspan="4"><p><?php echo '$ '.floatval($ver_pay)/100; ?></p></td>
                        <?php
                        if(!empty($verify_att)){
                            if($ver_status == '2'){ ?>
                            <td > <button type="button" class="btn btn-default btn-login-orange update_ver_status" data-attr = '0' data-block = '<?php echo $card_num; ?>' card-id = '<?php echo $id; ?>'>Reject</button>
                                <button type="button" class="btn btn-default btn-login-orange update_ver_status" data-attr = '3' data-block = '<?php echo $card_num; ?>' card-id = '<?php echo $id; ?>'>Accept</button>
                            </td>

                          <?php }
                        }
                        ?>
                </tr>
            </table>
            <table data-filter="#filter" class="verif_table verif_pay_table user_charge" id="verif_pay_table">
                <thead>
                <tr>
                    <th >Date / Time</th>
                    <th >Reply</th>
                    <th>Status</th>
                </tr>

                <?php
                if(!empty($verify_att)){
                    $accepted = [1 => 'Accepted',2=>'Rejected'];
                    foreach ($verify_att as $key => $verif){

                        if($ver_pay == $verif['amount']){

                            $k = 1;

                        }else{

                            $k = 2;
                        }
                    ?>
                    <tr>
                        <td><?php echo $verif['date']; ?></td>
                        <td><?php echo '$ '.floatval($verif['amount']/100); ?></td>

                        <?php if($k != '') { ?>
                            <td ><?php echo $accepted[$k];?></td>
                        <?php }else{?>
                            <td></td>
                            <?php } ?>
                        <?php } ?>

                    </tr>

                    <?php
                }
                ?>

            </table>
        </div>
    </div>
    <br class="clear">
</div>
     