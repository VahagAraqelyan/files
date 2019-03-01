<!doctype html>
<html lang="en">

<body>

<div class="content">
    <div class="container">

        <div class="block-section">
            <h1 class="cont-title another">Shipping Weight and Size</h1>
            <p class="main-title-desc">To ensure we can quote the correct shipping fee and issue the proper shipping label, it is important to select correct size of your items. Both weight and dimensions (Length, Girth) are key factors for carrier to arrange and charge the shipment.</p>
            <h3>Check Size and Weight Limits</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="shadow-box shipping-info-box">

                        <div class="col-md-12">
                            <div class="col-md-6">
                            <select class="col-md-6 form-control selectpicker select-country small-dropdown" name="" id="calc_luggage">
                                <option value="">Please Select Item</option>
                                <?php
                                if(!empty($luggage)){

                                    foreach ($luggage as $single){ ?>
                                        <option value="<?php echo $single['product_id'];?>"><?php echo $single['luggage_name'];?></option>
                                    <?php } } ?>
                            </select>
                            </div>
                        </div>
                        <div class="calc_weight_size_answer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <p class="col-md-12 inline-text orange-color margin-top-30">* If there is weight difference between the item size you selected and the chargeable weight carrier billed us, we will refund/recharge the difference.</p>
            </div>
        </div>
        <div class="block-section">
            <h3>How to measure the Length and Girth?</h3>

            <p class="block-sum-desc">Carriers calculate dimensions from the widest point of each side of your luggage or box. Please check following instructions on how to get an accurate number of the length and girth of your Item.</p>
            <div class="shadow-box shipping-info-box large">
                <div class="row">
                    <div class="col-md-4">
                        <img id="" src="<?php echo  base_url();?>assets/images/weight_size/shipping_weight_size1.jpg">
                    </div>
                    <div class="col-md-4">
                        <img id="" src="<?php echo  base_url();?>assets/images/weight_size/shipping_weight_size.png">
                    </div>
                    <div class="col-md-4">
                        <img id="" src="<?php echo  base_url();?>assets/images/weight_size/shipping_weight_size3.png">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img id="" src="<?php echo  base_url();?>assets/images/weight_size/shipping_weight_size4.png">
                    </div>
                   <!-- <div class="col-md-4">
                        <img id="" src="<?php /*echo  base_url();*/?>assets/images/weight_size/shipping_weight_size5.png">
                    </div>-->
                    <div class="col-md-4 weight_size_last_img">
                        <img id="" src="<?php echo  base_url();?>assets/images/weight_size/shipping_weight_size5.png">
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
</body>
</html>