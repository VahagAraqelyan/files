<div class="panel panel-default designed-panel no-margin">
    <div class="panel-body no-padding">
        <div class="row">

            <div class="col-md-4">
                <form method="post" class="form-horizontal search-data-form max-width-block" action="">
                    <div class="rounded-border">
                        <div class="form-group">
                            <div class="col-md-8 text-left">
                                <h5 class="red-text bold">Pick up Fee</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Domestic Basic</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="domestic_bas" class="form-control not_string" value="<?php echo (!empty($pickup_fee[0]['domestic_basic'])?$pickup_fee[0]['domestic_basic']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Domestic Express</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="domestic_exp" class="form-control not_string" value="<?php echo (!empty($pickup_fee[0]['domestic_express'])?$pickup_fee[0]['domestic_express']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">International weekday pick up</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="international" class="form-control not_string" value="<?php echo (!empty($pickup_fee[0]['international'])?$pickup_fee[0]['international']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Saturday Pickup</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="sat_pickup" class="form-control not_string" value="<?php echo (!empty($pickup_fee[0]['saturday_pickup'])?$pickup_fee[0]['saturday_pickup']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Saturday  Delivery</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="sat_delivery" class="form-control not_string" value="<?php echo (!empty($pickup_fee[0]['saturday_pickup'])?$pickup_fee[0]['saturday_delivery']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 text-right">
                                <span class="form-small-font"><?php
                                    if(!empty($pickup_fee)){

                                        echo $pickup_fee[0]['date'];
                                    }
                                    ?></span>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="button" id="extra_pick_up_butt" class="btn btn-default btn-login-orange adm-btn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="post" class="form-horizontal search-data-form max-width-block" action="">

                    <div class="rounded-border">
                        <div class="form-group">
                            <div class="col-md-8 text-left">
                                <h5 class="red-text bold">Processing Fee</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Item Processing</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="item_processing" class="form-control not_string" value="<?php echo (!empty($processing_fee[0]['item_processing'])?$processing_fee[0]['item_processing']:'');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Cruise Processing</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="cruise_crocessing" class="form-control not_string" value="<?php echo (!empty($processing_fee[0]['cruise_processing'])?$processing_fee[0]['cruise_processing']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label class="form-small-font">Cancelation Fee</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="cancelation_fee" class="form-control not_string" value="<?php echo (!empty($processing_fee[0]['cancelation_fee'])?$processing_fee[0]['cancelation_fee']:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 text-right">
                                <span class="form-small-font">
                                    <?php
                                    if(!empty($processing_fee)){

                                        echo $processing_fee[0]['date'];
                                    }
                                    ?></span>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="button" class="btn btn-default btn-login-orange adm-btn" id="processing_fee_butt">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <form method="post" class="form-horizontal search-data-form max-width-block" action="">
                    <div class="rounded-border">
                        <div class="form-group">
                            <div class="col-md-8 text-left">
                                <h5 class="red-text bold">Domestic Insurance</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 text-center">
                                <span class="form-small-font">Insurance Amount</span>
                            </div>
                            <div class="col-md-6 text-center">
                                <span class="form-small-font">Insurance fee</span>
                            </div>
                        </div>
                        <?php
                        if(!empty($domestic_insurance)){
                        foreach ($domestic_insurance as $domestic){?>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" name="insurance_amount[]" class="form-control not_string" value="<?php echo (!empty($domestic['insurance_amount']))?$domestic['insurance_amount']:'';?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="insurance_fee[]" class="form-control not_string" value="<?php echo (!empty($domestic['insurance_fee']))?$domestic['insurance_fee']:'';?>">
                                </div>
                            </div>
                        <?php }}else{?>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-md-6 text-right">
                                <span class="form-small-font"><?php
                                    if(!empty($domestic_insurance)){

                                        echo $domestic_insurance[0]['date'];
                                    }
                                    ?></span>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="button" id="extra_domestic_butt" class="btn btn-default btn-login-orange adm-btn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <form method="post" class="form-horizontal search-data-form max-width-block" action="">

                    <div class="rounded-border">
                        <div class="form-group">
                            <div class="col-md-8 text-left">
                                <h5 class="red-text bold">International  Insurance</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 text-center">
                                <span class="form-small-font">Insurance Amount</span>
                            </div>
                            <div class="col-md-6 text-center">
                                <span class="form-small-font">Insurance fee</span>
                            </div>
                        </div>
                        <?php
                        if(!empty($international_insurance)){
                            foreach ($international_insurance as $domestic){?>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input type="text" name="insurance_amount[]" class="form-control not_string" value="<?php echo (!empty($domestic['insurance_amount']))?$domestic['insurance_amount']:''?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="insurance_fee[]" class="form-control not_string" value="<?php echo (!empty($domestic['insurance_fee']))?$domestic['insurance_fee']:'';?>">
                                    </div>
                                </div>
                            <?php }}else{?>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control  not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" name="insurance_amount[]" class="form-control not_string">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="insurance_fee[]" class="form-control not_string">
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-md-6 text-right">
                                <span class="form-small-font"><?php
                                    if(!empty($international_insurance)){

                                        echo $international_insurance[0]['date'];
                                    }
                                    ?></span>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="button" id="extra_international_butt" class="btn btn-default btn-login-orange adm-btn">Save</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>