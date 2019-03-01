<div class="modal-header">
    <h2 class="register-title text-center">Address  Information</h2>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="register-block no-hide">
        <div id="" class="form-horizontal text-left">
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Address ID <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $addr_id; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Organization <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $organiz; ?></div>
            </div>

            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Country<span class="important">*</span> <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $country; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Address 1<span class="important">*</span> <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $address1; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Address 2<span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $address2; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">City<span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $city; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">State / Region <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $state; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-4 control-label value-index">Zip code <span class="last-dots">:</span></div>
                <div class="col-xs-8 value-info static-place"><?php echo $zip_code; ?></div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 additional-comments word-break">
                    <span class="bold"><b>Additional Comments:</b></span>
                    <?php echo $comment; ?>
                </div>
            </div>
        </div>
    </div>
</div>