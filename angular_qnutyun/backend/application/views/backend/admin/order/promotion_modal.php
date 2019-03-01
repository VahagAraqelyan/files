<?php
$disabled = '';
if(!empty($isset_promotion)){
    $disabled = 'disabled="disabled"';
}
?>

<div class="register-block no-hide delivery_mobile_adding">

    <h2 class="register-title text-center lovercase"><?php echo (!empty($isset_promotion))?'Edit Promotion':'Add New Promotion'; ?></h2>

    <div class="panel-body">
        <div class="registration-error">
            <span id="add_error_img"></span>
            <span id="register_error"></span>
        </div>
        <form method="post" id = "add_promotion_form" action="<?php echo base_url('/admin/promotion/add_promotion_code')?>">
            <input type="hidden" name="prom_id" value="<?php echo (!empty($isset_promotion['id']))?$isset_promotion['id']:''; ?>">
            <div class="form-horizontal text-left my_profile_content">
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Promotion status:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <select class="form-control selectpicker select-country my_profile" name="status" id="">
                            <option value=" ">Select promotion status</option>
                            <?php
                            foreach($promotion_statuses as $value => $name){
                                $k = '';
                                if(!empty($isset_promotion) && $isset_promotion['status'] == $value){
                                    $k = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $value; ?>" <?php echo $k; ?>><?php echo $name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Promotion type:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <select class="form-control selectpicker select-country my_profile" name="promotion_type" id="" <?php echo $disabled; ?>>
                            <option value=" ">Select promotion type</option>
                            <?php
                            foreach($promotion_types as $value => $info){
                                $k = '';
                                if(!empty($isset_promotion) && $isset_promotion['promotion_type'] == $value){
                                    $k = 'selected="selected"';
                                }
                                $name = str_replace('_', ' ', $value);
                                ?>
                                <option value="<?php echo $value; ?>" <?php echo $k; ?>><?php echo $name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Promotion Code:<span class="important">*</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <input class="" id="promo_code" name="promo_code" maxlength="50" type="text" value="<?php echo (!empty($isset_promotion['code']))?$isset_promotion['code']:''; ?>" placeholder="Promotion Code" autocomplete="off" <?php echo $disabled; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index no_padding">Promotion Amount:<span class="important">*</span>
                    </div>
                    <div class="col-xs-4  value-info no_padding">
                        <input class="col-sm-12" type="text" name="amount_p"  maxlength="30" value="<?php echo (!empty($isset_promotion['amount_p']))?$isset_promotion['amount_p']:''; ?>"  placeholder="Amount in %" autocomplete="off" style="padding-left:5px; " <?php echo $disabled; ?>>
                    </div>
                    <div class="col-xs-4  value-info no_padding">
                        <input class="col-sm-12" type="text" name="amount_d"  maxlength="30" value="<?php echo (!empty($isset_promotion['amount_d']))?$isset_promotion['amount_d']:''; ?>"  placeholder="Amount in $" autocomplete="off" <?php echo $disabled; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">From Date :</span>
                    </div>
                    <div class="col-xs-7 value-info">
                        <input class="promotion" type="text"  name="date_from" autocomplete="off" value="<?php echo (!empty($isset_promotion['date_from']))?$isset_promotion['date_from']:''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">To Date:

                    </div>
                    <div class="col-xs-7 value-info">
                        <input class="promotion" type="text" name="date_to" autocomplete="off" value="<?php echo (!empty($isset_promotion['date_to']))?$isset_promotion['date_to']:''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Amount of uses:
                    </div>
                    <div class="col-xs-7 value-info">
                        <select class="form-control selectpicker select-country my_profile" name="amount_of_use" id="promo_code">
                            <option value="-10">Unlimited</option>
                            <?php
                            for($i = 1; $i < 31; $i++){
                                $k = '';
                                if(!empty($isset_promotion) && $isset_promotion['count_of_use'] == $i){
                                    $k = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $i; ?>" <?php echo $k; ?>><?php echo $i; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Description:</div>
                    <div class="col-sm-7 col-xs-8 mob-input delivery_remark">
                        <textarea name="promo_desc" id="" cols="30" rows="10" <?php echo $disabled; ?>><?php echo (!empty($isset_promotion['desc']))?$isset_promotion['desc']:''; ?></textarea>
                    </div>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-11">
                            <?php if(!empty($isset_promotion)){
                                ?>
                                <button type="button" class="header-btns btn btnpos" id="add_promotion_butt">Edit</button>
                                <?php
                            }else{
                                ?>
                                <button type="button" class="header-btns btn btnpos" id="add_promotion_butt">Save</button>
                                <?php
                            }?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
