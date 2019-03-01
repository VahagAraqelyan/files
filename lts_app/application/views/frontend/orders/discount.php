<div class="min-block ">

    <?php if($discount_action == 'add'){ ?>
        <form method="post" action="" class="pay_select">
            <div class="shipping-fee-part">
                <h2 class="text-center">Total Shipping Fee</h2>
                <p class="text-center big-price orange-color pay_amount">$<?php echo $all_price;?></p>
                <?php if(!empty($price_array['account_credit'])){
                    ?>
                    <div class="form-group ">
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">Original Fee : </label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo $all_price; ?></p>
                        </div>
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">Acc. Credit : </label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo $price_array['account_credit']; ?></p>
                        </div>
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">New Fee : </label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo (($min = $all_price - $price_array['account_credit']) < 0)?'0':$min; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="shipping-fee-val">
                <div class="discount_code_block">
                    <div class="form-group">
                        <input type="text" class="form-control show-placeholder placeholder_class" name="" placeholder="Enter promotion code" id="promotion_code">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-default select-doc-file apply-promotion apply_discount_code" id="apply_discount_code">Apply The Code</button>
                    </div>
                </div>
            </div>
            <div class="form-group">

            </div>
        </form>

    <?php }else{ ?>
        <form method="post" action="" class="pay_select">
            <div class="shipping-fee-part">
                <h2 class="text-center">Shipping Fee</h2>
                <p class="text-center big-price orange-color pay_amount">$<?php echo $all_price;?></p>
            </div>
            <div class="shipping-fee-val">


                <div class="discount_code_block">
                    <div class="form-group">
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">Original Fee:</label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo floatval($all_price + $price_array['discount']); ?></p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">Discount:</label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo $price_array['discount']; ?></p>
                        </div>
                    </div>
                    <?php if(!empty($price_array['account_credit'])){
                        $all_price = $all_price - $price_array['account_credit'];
                        if($all_price < 0){
                            $all_price = 0;
                        }
                        ?>
                        <div class="form-group ">
                            <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">Acc. Credit : </label>
                            <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                                <p class="static-value orange-color">$<?php echo $price_array['account_credit']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="" class="col-sm-7 col-xs-7 control-label text-left padding-right-0">New Fee:</label>
                        <div class="col-sm-5 col-xs-5 mob-input padding-left-0">
                            <p class="static-value orange-color">$<?php echo $all_price; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group change_code_parent">
                <p class="clearfix"></p>
                <div class="text-center mobile_change_code">
                    <a href="#" class="change_discount_code ">Change Code</a>
                </div>
            </div>
        </form>
    <?php } ?>
</div>