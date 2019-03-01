<form id="single_final_billing_form">
    <input type="hidden" name="order_id" value="<?php echo $luggages['real_id']; ?>">
    <input type="hidden" name="luggage_id" value="<?php echo $luggages['lug_id']; ?>">
<div class="modal-header">
    <button type="button" id="final_biling_close" class="close" data-dismiss="modal">&times;</button>
    <div class="final_billing_header">
        <div>
            <span>#<?php echo $data_number; ?></span>
            <span><?php echo $luggages['tracking_number']; ?></span>
        </div>
    </div>
</div>
<div class="modal-body">
<div id="billing_info">

    <div id="single_billing_error_main">
        <span id="single_billing_error_img"></span>
        <span id="single_billing_profile"></span>
    </div>
<ul class="">
    <li></li>
    <li>Special Handling</li>
    <li>Oversize Fee</li>
    <li>Remote Area</li>
    <li>Address Change</li>
    <li>Shipment Holding</li>
    <li>Tax and Duty</li>
    <li>Other Fee</li>
    <li><button type="button" class="btn btn-default btn-login-blue small-button single_billing_info_save" id="">Save</button></li>
    <li></li>

</ul>
<ul>
    <li>Billing</li>
    <li>$ <?php echo $luggages['special_handling']; ?></li>
    <li>-</li>
    <li>-</li>
    <li>-</li>
    <li></li>
    <li></li>
    <li></li>
    <li><hr class="biling_hr biling_final_hr"></li>
    <li>Total:$ <?php echo $luggages['special_handling']; ?></li>
</ul>
<ul class="last_billing_ul">
    <li>Initial</li>
    <?php
        $total = $luggages['special_handling_editable'] +
                 $luggages['oversize_fee'] +
                 $luggages['remote_area_fee'] +
                 $luggages['address_change_fee'] +
                 $luggages['shipment_holding_fee'] +
                 $luggages['tax_duty_fee'] +
                 $luggages['other_fee'];
    ?>
    <li><input type="text" value="<?php echo $luggages['special_handling_editable']; ?>" name="special_handling" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['oversize_fee']; ?>" name="oversize_fee" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['remote_area_fee']; ?>" name="remote_area" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['address_change_fee']; ?>" name="address_change" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['shipment_holding_fee']; ?>" name="shipment_holding" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['tax_duty_fee']; ?>" name="tax_duty" class="form-control small-input final_billing_inp"></li>
    <li><input type="text" value="<?php echo $luggages['other_fee']; ?>" name="other_fee" class="form-control small-input final_billing_inp"></li>
    <li><hr class="biling_final_hr"></li>
    <li id="total_biiling_answer">$ <?php echo $total; ?></li>
</ul>
    <br class="clear">
</div>
</div>
</form>