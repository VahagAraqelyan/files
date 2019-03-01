
<?php
if(!empty($card_info['cvc_check'])){
    $cvc_check = 'fa fa-check delivered-icon';
    $cvc_check_answer = 'Passed ';

}else{

    $cvc_check = 'fa fa-times delay-icon';
    $cvc_check_answer = 'Failed';
}

if(!empty($card_info['street_check'])){

    $stret_check = 'fa fa-check delivered-icon';
    $stret_check_answer = 'Passed ';

}else{
    $stret_check = 'fa fa-times delay-icon';
    $stret_check_answer = 'Failed';
}

if(!empty($card_info['zip_check'])){

    $zip_check = 'fa fa-check delivered-icon';
    $zip_check_answer = 'Passed ';
}else{

    $zip_check = 'fa fa-times delay-icon';
    $zip_check_answer = 'Failed';
}

?>
<div class="panel-body" id="credit_card_info">
    <div class="col-md-6 padding-right-0">
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">First Name:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['holder_first_name'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Last Name:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['holder_last_name'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Company:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['company_name'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Card Number:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0">********<?php echo substr($card_info['card_number'],-4,4); ?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Expiration:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['exp_year']."-".$card_info['exp_mounth'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Card Code:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0">***</div>
    </div>
</div>
<hr>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Country:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['country'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Address 1:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['address1'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Address 2:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['address2'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">City:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['city'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">State:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['state'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Zip Code:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['zip_code'];?></div>
    </div>
</div>
<div class="light-block">
    <div class="form-group">
        <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Phone:</label>
        <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['phone'];?></div>
    </div>
</div>
</div>
<div class="col-md-6">
    <div class="light-block">
        <div class="form-group">
            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Type: </label>
            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['type'];?></div>
        </div>
    </div>
    <div class="light-block">
        <div class="form-group">
            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Origin: </label>
            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $card_info['origin'];?></div>
        </div>
    </div>
    <div class="light-block">
        <div class="form-group">
            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">CVC Check: </label>
            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cvc_check_answer; ?> <i class="<?php echo $cvc_check;?>"></i></div>
        </div>
    </div>
    <div class="light-block">
        <div class="form-group">
            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Street Check: </label>
            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $stret_check_answer;?> <i class="<?php echo $stret_check;?>"></i></div>
        </div>
    </div>
    <div class="light-block">
        <div class="form-group">
            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Zip Check: </label>
            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $zip_check_answer;?> <i class="<?php echo $zip_check;?>"></i></div>
        </div>
    </div>
</div>