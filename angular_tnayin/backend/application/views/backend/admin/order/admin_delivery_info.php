
    <div class="panel panel-default designed-panel panel-bordered light">
        <div class="panel-body">
            <div class="panel-table-title">
                <h3 class="panel-title">Delivery Information <span class="pull-right light-edit admin_save_delivery_info save_sender_receiver"><b>Save</b></a></span></h3>
            </div>
            <form method="post" action="" id="delivery_form">
                <div class="light-block">
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Delivery Date: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                       <?php echo $delivery_info['delivery_date'];?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Delivery Time: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <?php echo $delivery_info['delivery_time'];?>
                    </div>
                </div>
            </div>
            <div class="light-block">
                <div class="light-title">Receiver</div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">First Name: </label>
                    <div class="col-sm-7 mob-input form-small-font">

                        <input type="text" class="form-control" maxlength="40" name="first_name" id="last_name" placeholder=""  value="<?php echo $delivery_info['receiver_first_name'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Last Name: </label>
                    <div class="col-sm-7 mob-input form-small-font">

                        <input type="text" class="form-control" maxlength="40" name="last_name" id="last_name" placeholder="" value="<?php echo $delivery_info['receiver_last_name'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Phone: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <input type="text" class="form-control" maxlength="22" name="phone" placeholder="" value="<?php echo $delivery_info['receiver_phone'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Email: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <input type="text" class="form-control" maxlength="40" name="email" placeholder="" value=" <?php echo $delivery_info['receiver_email'];?>">
                    </div>
                </div>
            </div>
            <div class="light-block">
                <div class="light-title">To</div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Organization: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <input type="text" class="form-control" maxlength="40" name="organization" placeholder="" value=" <?php echo $delivery_info['delivery_company'];?>">
                    </div>
                </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label form-small-font">Address 1: </label>
                        <div class="col-sm-7 mob-input form-small-font">

                            <input type="text" class="form-control" maxlength="50" name="address1" placeholder="" value="<?php echo $delivery_info['delivery_address1'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label form-small-font">Address 2: </label>
                        <div class="col-sm-7 mob-input form-small-font">

                            <input type="text" class="form-control" maxlength="50" name="address2" placeholder="" value="<?php echo $delivery_info['delivery_address2'];?>">
                        </div>
                    </div>
                    <?php
                    if($order_info['shipping_type'] == 1 /*&& $delivery_info['delivery_country_id'] != $us*/){ ?>

                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label form-small-font">Postal Code: </label>
                        <div class="col-sm-7 mob-input form-small-font">
                            <input type="text" class="form-control" maxlength="25" name="delivery_postal_code" placeholder="" value="<?php echo $delivery_info['delivery_postal_code'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label form-small-font">City: </label>
                        <div class="col-sm-7 mob-input form-small-font">
                            <input type="text" class="form-control" maxlength="30" name="delivery_city" placeholder="" value="<?php echo $delivery_info['delivery_city'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-5 control-label form-small-font">State/Region: </label>
                        <div class="col-sm-7 mob-input form-small-font">
                            <select class="form-control select-country" name="delivery_state">
                                <option value="">Select State</option>
                                <?php

                                if(!empty($state)){
                                    foreach($state as $single){

                                        $k = '';

                                       if(!empty($delivery_info['delivery_state']) && $delivery_info['delivery_state'] == $single['Stateid']){

                                            $k = 'selected="selected"';
                                        }

                                        ?>
                                        <option value="<?php echo $single['Stateid']; ?>" <?php echo $k; ?>><?php echo $single['State']; ?></option>
                                        <?php
                                    }
                                }?>
                            </select>
                        </div>
                    </div>


                    <?php } else{  ?>

                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font">Postal Code: </label>
                            <div class="col-sm-7 mob-input form-small-font">
                                <?php echo $delivery_info['delivery_postal_code'];?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font">City: </label>
                            <div class="col-sm-7 mob-input form-small-font">
                                <?php echo $delivery_info['delivery_city'];?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font">State/Region: </label>
                            <div class="col-sm-7 mob-input form-small-font">
                                <?php echo $state_name;?>
                            </div>
                        </div>
                <?php } ?>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Country: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <?php echo $country; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Remark: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <textarea class="form-control" maxlength="200" placeholder="Please put any special notes related to the shipment pick up. For example: C/O, Road Number, etc" name="remark">  <?php echo $delivery_info['delivery_remark'];?></textarea>
                    </div>
                </div>

              <!--  <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font"></label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <button type="button" class="btn btn-default btn-login-orange save-action admin_save_delivery_info" data_id="<?php /*echo $delivery_info['id']*/?>">Edit</button>
                    </div>
                </div>-->

            </div>
            </form>
        </div>
    </div>