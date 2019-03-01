<div class="register-block no-hide">

    <h2 class="register-title text-center">Label Delivery</h2>
    <div class="form-horizontal text-left">
        <div class="form-group">
            <p class="jusify_class text_padding label_delivery_view_text">
                We will try to mail you the shipping labels and pouches for free.
                The envelope will be delivered to "From“ address or below address if you specified. Please reach out us at 18006786167 if you have any question. Thanks.
            </p>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">First Name:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['first_name']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Last Name:<span class="important">*</span><span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['last_name']?></div>
        </div>

        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Phone Number:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['phone']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Email <span class="last-dots">:</span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['email']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Organization <span class="last-dots">:</span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['company']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Address 1:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['address1']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Address 2</div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['address2']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Postal Code:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['postal_code']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">City:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $delivery_info['city']?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">State / Region:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $state; ?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-4 control-label value-index">Country:<span class="important">*</span> <span class="last-dots"></span></div>
            <div class="col-xs-8 value-info static-place"><?php echo $country; ?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 additional-comments">
                Remark:
                <?php echo $delivery_info['remark']?>
            </div>
            <?php if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){ ?>
              <!--  <div class="form-group">
                    <button type="button" class="btn btn-default btn-login-orange save-info-btn deliver_label_edit">Edit</button>
                </div>-->
            <?php }?>
        </div>
    </div>

</div>

