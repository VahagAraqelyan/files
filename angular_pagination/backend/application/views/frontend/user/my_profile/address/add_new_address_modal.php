<div class="modal-header">
    <h2 class="register-title text-center"><?php echo $title; ?></h2>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="popup-wrong-message"></div>
    <div class="register-block no-hide">
        <form id="add_new_addr_form">
            <div class="registration-error">
                <span id="add_error_img"></span>
                <span id="traveler_error"></span>
            </div>
            <input type="hidden" value="<?php echo $id; ?>" name="addr_id">
            <div id="" class="form-horizontal text-left">
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address ID:
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" Unique address ID." data-original-title="" title=""></span>
                    </div>
                    <div class="col-xs-8 value-info">
                        <input type="text" maxlength="25" class="form-control placeholder_class_mobile" name="address_id" placeholder="Exp: My Home / My office " value="<?php echo $addr_id; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Organization:
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Please put Business/Hotel/Golf Course/School Name." data-original-title="" title=""></span>
                    </div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control placeholder_class_mobile" maxlength="25" name="organization" placeholder="Company / Hotel Name " value="<?php echo $organiz; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Country<span class="important">*</span>:</div>
                    <div class="col-xs-8 value-info">
                        <select class="form-control selectpicker select-country"  name="add_addr_country" id="country-select">
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
                    <div class="col-xs-4 control-label value-index">Address 1<span class="important">*</span>:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control placeholder_class_mobile" maxlength="40" name="address_1" placeholder="Building Number & Street name " value="<?php echo $address1; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">Address 2:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" class="form-control placeholder_class_mobile" maxlength="40" name="address_2" placeholder="Unit / Suite Number " value="<?php echo $address2; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-4 control-label value-index">City<span class="important error_class">*</span>:</div>
                    <div class="col-xs-8 value-info">
                        <input type="text" maxlength="25" class="form-control placeholder_class_mobile" name="city" placeholder="Enter City Name " value="<?php echo $city; ?>">
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
                                    $k=($value['Stateid']==$state)?'selected=\'selected\'':'';
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
                        <input type="text" maxlength="25" class="form-control placeholder_class_mobile" name="zip_code" id="zip_code" placeholder="Enter Zip Code" value="<?php echo $zip_code; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 additional-comments">
                        Additional Comments:
                        <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="For example, building security code; C/O, etc." data-original-title="" title=""></span>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="comment" maxlength="200" class="mod-add-info coment_area" id="coment_area" cols="30" rows="10" placeholder="e.g. Building security access code. Luggage pick-up location ( mail room ) etc."><?php echo $comment; ?></textarea>
                    <button type="button" class="btn btn-default btn-login-orange save-info-btn" id="<?php echo $button_id ?>"><?php echo $button_value; ?></button>
                </div>
            </div>
        </form>

    </div>
</div>