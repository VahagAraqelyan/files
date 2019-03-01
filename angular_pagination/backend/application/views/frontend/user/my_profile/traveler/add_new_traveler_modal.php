<div class="modal-header">
    <h2 class="register-title text-center"><?php echo $title; ?></h2>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="popup-wrong-message"></div>
    <div class="register-block no-hide">

        <form method="post" action="" id="traveler_add_update">
            <div class="registration-error">
                <span id="add_error_img"></span>
                <span id="traveler_error"></span>
            </div>
            <input type="hidden" value="<?php echo  $trav_id; ?>" name="trav_id">
            <div id="" class="form-horizontal text-left">
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">First Name<span class="important">*</span>:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control" maxlength="20" name="first_name" placeholder="" value="<?php echo $fname; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Last Name<span class="important">*</span>:
                    </div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control" maxlength="20" name="last_name" placeholder="" value="<?php echo $lname; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index phone_number_traveler">Phone Number<span class="important">*</span>:
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="If Phone not from US Please put country code For Ex. +19987654433." data-original-title="" title=""></span>
                    </div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control placeholder_class_mobile" maxlength="22" name="phone_number" placeholder="Country  code & Number" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Email:</div>
                    <div class="col-xs-8 value-info">
                        <input type="email" maxlength="25" class="form-control" name="email" placeholder="" value="<?php echo $email; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Country:</div>
                    <div class="col-xs-8 value-info">
                        <select class="form-control selectpicker select-country" name="add_trav_country" id="country-select">
                            <option value="">Select Country</option>
                            <?php
                                foreach($countries as $value){
                                    $k=($value['id']==$country)?'selected=\'selected\'':'';
                                    ?>
                                    <option value="<?php echo $value["iso2"].'_'.$value["id"]; ?>" <?php echo $k; ?> ><?php echo $value['country']?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Organization:
                        <span class="popover-style"  data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please put Business/Hotel/Golf Course/School Name" data-original-title="" title=""></span>
                    </div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control placeholder_class_mobile" maxlength="25" name="organization" placeholder="Enter Your Address Here" value="<?php echo $organization; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address 1:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control" maxlength="40" name="address_1" placeholder="" value="<?php echo $address1; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address 2:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control" maxlength="40" name="address_2" placeholder="" value="<?php echo $address2; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">City:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" maxlength="25" class="form-control" name="city" placeholder="" value="<?php echo $city; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">State / Region:</div>
                    <div class="col-xs-8 value-info">
                        <select class="form-control selectpicker select-country" name="state_region" id="state-select">
                            <option value="">Select State</option>
                            <?php
                                if(!empty($states)){
                                    foreach($states as $value){
                                        $k=($value['Stateid']==$state_reg)?'selected=\'selected\'':'';
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
                    <div class="col-xs-4 control-label value-index">Zip code:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control" maxlength="25" name="zip_code" id="zip_code" placeholder="" value="<?php echo $zip_code; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 additional-comments">
                        Additional Comments:
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please put any special comments related to this traveler here." data-original-title="" title=""></span>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="comment" class="mod-add-info coment_area" maxlength="200" id="coment_area" cols="30" rows="10" placeholder="e.g., building security code; C/O, etc."><?php echo $comment; ?></textarea>
                    <button type="button" id="<?php echo $button_id; ?>" class="btn btn-default btn-login-orange save-info-btn"><?php echo $button_value; ?></button>
                </div>
            </div>
        </form>

    </div>
</div>