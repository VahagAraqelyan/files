
<div class="panel panel-default designed-panel panel-bordered light">
    <div class="panel-table-title">
        <h3 class="panel-title">Pickup Information <span class="pull-right light-edit sender_pickup_edit save_sender_receiver"><b>Save</b></a></span></h3>
    </div>
    <form action="" method="post" id="admin_sender_info_form">
    <div class="panel-body">
        <div class="light-block">
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Pickup Date: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <?php echo $sender_info['shipping_date'];?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Pickup Time: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <?php
                    if(empty($sender_info['pickup_time']) && $sender_info['pick_up'] == 1){
                        $time = 'Drop off';

                    }else{

                        if(!empty($sender_info['pickup_time']) && $sender_info['pickup_time'] == 'no_data'){
                            $time = 'I will confirm pick up time later';

                        }else{
                            $time = $sender_info['pickup_time'];
                        }
                    }

                    echo $time;
                    ?>

                </div>
            </div>
        </div>
        <div class="light-block">
            <div class="light-title">Shipper</div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">First Name: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <input type="text" class="form-control" maxlength="40" name="first_name" id="first_name" placeholder="" value=" <?php echo $sender_info['sender_first_name'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Last Name: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <input type="text" class="form-control" maxlength="40" name="last_name" id="last_name" placeholder=""  value="<?php echo $sender_info['sender_last_name'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Phone: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <input type="text" class="form-control" name="phone" placeholder="" value="<?php echo $sender_info['sender_phone'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Email: </label>
                <div class="col-sm-7 mob-input form-small-font">

                    <input type="text" class="form-control" maxlength="40" name="email" placeholder="" value=" <?php echo $sender_info['sender_email'];?>">
                </div>
            </div>
        </div>
        <div class="light-block">
            <div class="light-title">From</div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Organization: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <input type="text" class="form-control" maxlength="40" name="organization" placeholder="Name of Hotel, Company etc." value="<?php echo $sender_info['pickup_company'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Address 1: </label>
                <div class="col-sm-7 mob-input form-small-font">

                    <input type="text" class="form-control" maxlength="50" name="address1" placeholder="" value="<?php echo $sender_info['pickup_address1'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">Address 2: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <input type="text" class="form-control" maxlength="50" name="address2" placeholder="" value="<?php echo $sender_info['pickup_address2'];?>">
                </div>
            </div>
            <?php
            if($order['shipping_type'] == 1 /*&& $sender_info['pickup_country_id'] != $us*/){ ?>

                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">Postal Code: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <input type="text" class="form-control" maxlength="25" name="pickup_postal_code" placeholder="" value="<?php echo $sender_info['pickup_postal_code'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">City: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <input type="text" class="form-control" maxlength="30" name="pickup_city" placeholder="" value="<?php echo $sender_info['pickup_city'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-5 control-label form-small-font">State/Region: </label>
                    <div class="col-sm-7 mob-input form-small-font">
                        <select class="form-control  select-country" name="state">
                            <option value="">Select State</option>
                            <?php
                            if(!empty($state)){
                                foreach($state as $single){

                                    $k = '';

                                   if(!empty($sender_info['pickup_state']) && $sender_info['pickup_state'] == $single['Stateid']){

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
                    <?php echo $sender_info['pickup_postal_code'];?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">City: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <?php echo $sender_info['pickup_city'];?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font">State/Region: </label>
                <div class="col-sm-7 mob-input form-small-font">
                    <?php echo $state_name; ?>
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
                    <textarea class="form-control" maxlength="200" placeholder="Please put any special notes related to the shipment pick up. For example: C/O, Road Number, etc" name="remark"><?php echo $sender_info['pickup_remark'];?></textarea>
                </div>
            </div>
           <!-- <div class="form-group">
                <label for="" class="col-sm-5 control-label form-small-font"></label>
                <div class="col-sm-7 mob-input form-small-font">
                    <button type="button" class="btn btn-default btn-login-orange save-action sender_pickup_edit">Edit</button>
                </div>
            </div>-->
        </div>

    </div>
    </form>
</div>