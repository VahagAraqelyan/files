<div class="modal-header">
    <h2 class="register-title text-center">Traveler  Information</h2>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="register-block no-hide">
<div id="" class="form-horizontal text-left">
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">First Name<span class="important error_class">*</span> <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['first_name']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Last Name<span class="important error_class">*</span> <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['last_name']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Phone Number<span class="important error_class">*</span> <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['phone']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Email <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['email']; ?></div>
    </div>

    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Country<span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['country']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Organization <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['organization']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Address 1<span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['address1']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Address 2</div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['address2']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">City<span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['city']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">State / Region <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['State']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-4 control-label value-index">Zip code <span class="last-dots">:</span></div>
        <div class="col-xs-8 value-info static-place"><?php echo $traveler['zip_code']; ?></div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 additional-comments word-break">
            <span class="bold"><b>Additional Comments:</b></span>
            <?php echo $traveler['comment']; ?>
        </div>
    </div>
</div>
</div>

