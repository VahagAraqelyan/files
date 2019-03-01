<script>
    traveler_list_row_count = '<?php echo $traveler_list_row_count; ?>';
    addres_book_list_row_count = '<?php echo $addres_book_list_row_count; ?>';
    Stripe.setPublishableKey('<?php echo $public_key;?>');
</script>
<!-- Modal upload-->
<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="add_card_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="answer_card_error">

                </div>
            </div>

        </div>

    </div>
</div>
<!-- modal -->
<div id="my_profile_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background" id="my_profile_modal_content">

        </div>
    </div>
</div>
<div class="content dashboard">
    <div class="container">

        <div class="panel panel-default designed-panel">
            <div class="panel-table-title">
                <h3 class="panel-title">Customer Profile</h3>
            </div>
            <table class="table table-bordered table-hover designed-table">
                <thead>
                <tr>
                    <th class=""><small>#</small></th>
                    <th class=""><small>Status</small></th>
                    <th class=""><small>Account Number</small></th>
                    <th class=""><small>Account Name</small></th>
                    <th class=""><small>Company Name</small></th>
                    <th class=""><small>Register date</small></th>
                    <th class=""><small>Email</small></th>
                    <th class=""><small>Profile<br /> Update</small></th>
                    <th class=""><small>Total<br /> Orders</small></th>
                    <th class=""><small>Total<br /> Paid</small></th>
                    <th class=""><small>Balance</small></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $status_arr = [
                    '0' => 'fa fa-times delay-icon',
                    '1' => 'fa fa-check picked-up-icon',
                    '2' => 'fa fa-check delivered-icon',
                    '3' => 'fa fa-exclamation created-icon fa_under_review',
                ];
                        $active_class =  $status_arr[$info[0]['user_status']];

                        if(empty($info[0]['last_update'])){

                            $k = 'NO';

                        }else{

                            $k = 'YES';
                        }
                        ?>
                            <tr>
                                <td><?php echo $info[0]['id']; ?></td>
                                <td><i class="<?php echo $active_class ?>"></i></td>
                                <td><?php echo $info[0]['account_name']; ?></td>
                                <td><?php echo $info[0]['first_name']." ".$info[0]['last_name']; ?></td>
                                <td><?php echo $info[0]['company']; ?></td>
                                <td><?php echo date("M-d-Y H:i:s", $info[0]['created_on']); ?></td>
                                <td><?php echo $info[0]['email']; ?></td>
                                <td>
                                    <span class="red-text bold"><?php echo  $k; ?></span>
                                    <?php if($k === 'YES') {?>
                                    <span class="orange-label btn btn-warning" id="reset_customer_update" data-block="<?php echo $info[0]['id']; ?>">Reset</span>
                                    <?php } ?>
                                </td>
                                <td><span class="bold"><a href="<?php echo base_url('admin/order/user_orders/'.$info[0]['id']); ?>"><?php echo $all_count;?></a></span></td>
                                <td>
                                    <span class="bold"><?php echo (!empty($total_paid))?'$'.$total_paid:'';?></span>
                                </td>
                                <td>$0.00</td>
                            </tr>
                </tbody>
            </table>
        </div>

        <div class="panel panel-default designed-panel">
            <div class="row">
                <div class="col-md-6">
                    <form class="form-inline search-data-form" method="get" action="" id="new_order_form">
                        <div class="form-group">
                            <label class="sr-only" for="">Account #</label>
                            <input type="text" name="order_id" class="form-control" placeholder="Account #" value="<?php echo $cr['order_id']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="">Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Name" value="<?php echo $cr['first_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $cr['email']; ?>">
                        </div>
                        <button type="submit" class="btn btn-default btn-login-orange search_new_order">Search</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?php echo base_url('admin/user_manage/user_account/').$id; ?>" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
                    <ul class="pagination designed-pagination">
                        <?php echo $link; ?>
                    </ul>
                </div>
            </div>
            <div class="panel-table-title">
                <h3 class="panel-title">All Order:<?php echo $all_count; ?></h3>
            </div>
            <table class="table table-bordered table-hover designed-table">
                <thead>
                <tr>
                    <th class=""><small>#</small></th>
                    <th class="order-number"><small>Order<br /> Number & Name</small></th>
                    <th class="order-date"><small>Order<br /> Date & status</small></th>
                    <th class="style-service"><small>Service<br /> Type</small></th>
                    <th class=""><small>Label<br /> Delivery</small></th>
                    <th class="pickup-date"><small>Pickup<br /> Date & Time</small></th>
                    <th class=""><small>Delivery<br /> Date & time</small></th>
                    <th class="from"><small>From</small></th>
                    <th class=""><small>To</small></th>
                    <th class=""><small>Total<br /> Luggage</small></th>
                    <th class=""><small>Final Weight<br /> Cost</small></th>
                </tr>
                </thead>
                <tbody>
                <?php

                if(!empty($all_orders)){

                    foreach ($all_orders as $index => $order){
                        $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
                        $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
                        $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
                        $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";
                        /*      $cancel_class = ($order['title'] =='Canceled')?'error_class':'';*/
                        $type = change_order_type($order['send_type'],$order['currier_name'],$order['shipping_type']);
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/order/order_detail/').$order['real_id']; ?>">
                                    <span><?php echo $order['order_number']; ?></span>
                                </a>
                                <a href="<?php echo base_url('admin/user_manage/user_account/').$order['id']?>">
                                    <span><?php echo $order['first_name']." ".$order['last_name']; ?></span>
                                </a>
                                <?php
                                echo $lost_claim ;
                                echo $damage_claim ;
                                echo $payment_dispute ;
                                echo $billing_claim;
                                ?>
                            </td>
                            <td>
                                <span><?php echo date('M-d-Y', strtotime($order['created_date'])); ?></span>
                                <span class="error_class"><?php echo $order['title']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $order['currier_name']."<br>".$type;; ?></span>
                            </td>
                            <td>
                                <span><?php show_date($order['label_date']); ?></span>
                                <span><?php echo $order['label_trucking']; ?></span>
                            </td>
                            <td>
                                <span><?php echo date('M-d-Y', strtotime($order['shipping_date'])); ?></span>
                                <?php
                                if($order['pick_up'] == '2'){

                                    ?>
                                    <span><?php echo  ($order['pickup_time'] == 'no_data')?'I will confirm pick up time later':$order['pickup_time']; ?></span>
                                <?php }else{
                                    ?>
                                    <span>Drop Off</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <span><?php show_date($order['delivery_date']); ?></span>
                                <span><?php echo $order['delivery_time']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $countries[$order['pickup_country_id']]['country']; ?></span>
                                <span><?php echo $order['pickup_state']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $countries[$order['delivery_country_id']]['country']; ?></span>
                                <span><?php echo $order['delivery_state']; ?></span>
                            </td>
                            <td><?php echo $order['luggage_info']['count']; ?></td>
                            <td>
                                <span><?php echo $order['luggage_info']['total_weight']; ?>bs</span>
                                <span>$<?php echo (!empty($order['order_price']['original_price']))?$order['order_price']['original_price']:'NaN';?></span>
                            </td>
                        </tr>

                    <?php }
                }
                ?>
                </tbody>
            </table>
        </div>






        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Account Message</h3>
                    </div>

                    <div class="panel-body chat" id="admin-chat-body">
                        <ul>
                            <?php
                            if(!empty($messages)) {
                                foreach ($messages as $msg) {
                                    ?>
                                    <li class="left clearfix">
                                        <span class="pull-left"></span>
                                        <div class="chat-body clearfix">
                                            <div class="chat-title">
                                                <strong class="primary-font"><?php echo $msg['add_date']; ?> By
                                                    : <?php echo $msg['admin_name']; ?></strong>
                                            </div>
                                            <p>
                                                <?php echo $msg['message_txt']; ?>
                                            </p>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm chat-search-place" placeholder="">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-login-blue small-button" id="add_message_to_board">Save</button>
                                </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-2">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Account Status <i class="<?php echo $active_class; ?>"></i></h3>
                    </div>
                    <form method="post" class="form-horizontal" action="" id="update_status_form">
                        <input type="hidden" name="user_id" value="<?php echo $info[0]['id'];?>" id="user_id">
                        <div class="form-group">
                            <label for="" class="col-md-5 col-md-push-1 control-label text-left">Regular</label>
                            <label for="" class="col-md-4 control-label"><i class="fa fa-check picked-up-icon"></i> </label>
                            <label class="radio-inline col-md-2">
                                <input type="radio" name="status" value="1" <?php echo ($info[0]['user_status'] == '1')?'checked = "checked"':''; ?>>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-5 col-md-push-1 control-label text-left">Verified</label>
                            <label for="" class="col-md-4 control-label"><i class="fa fa-check delivered-icon"></i> </label>
                            <label class="radio-inline col-md-2">
                                <input type="radio" name="status" value="2" <?php echo ($info[0]['user_status'] == '2')?'checked = "checked"':''; ?>>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-5 col-md-push-1 control-label text-left">Hold</label>
                            <label for="" class="col-md-4 control-label"><i class="fa fa-exclamation created-icon fa_under_review"></i> </label>
                            <label class="radio-inline col-md-2">
                                <input type="radio" name="status" value="3" <?php echo ($info[0]['user_status'] == '3')?'checked = "checked"':''; ?>>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-5 col-md-push-1 control-label text-left">Cancel</label>
                            <label for="" class="col-md-4 control-label"><i class="fa fa-times delay-icon"></i> </label>
                            <label class="radio-inline col-md-2">
                                <input type="radio" name="status" value="0" <?php echo ($info[0]['user_status'] == '0')?'checked = "checked"':''; ?>>
                            </label>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12 text-center button-place">
                                <button type="button" class="btn btn-default btn-login-blue small-button" id="update_status">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Registration IP</h3>
                    </div>
                    <div class="panel-body">

                        <p class="table-text-for">Registration IP and last 3 Login IP</p>
                        <table class="table table-bordered table-hover designed-table">
                            <thead>
                            <tr>
                                <th class=""><small>IP Address</small></th>
                                <th class=""><small>Country/Location</small></th>
                                <th class=""><small>Date/Time</small></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="red-text"><?php echo $user_ip_info[0]['login_ip']; ?></td>
                                <td class="red-text">
                                    <?php
                                    if(empty($user_ip_info[0]['country']) && empty($user_ip_info[0]['city'])){
                                        echo 'NO DATA';
                                    }else {
                                        echo $user_ip_info[0]['country'] . '/' . $user_ip_info[0]['city'];
                                    }
                                    ?>
                                </td>
                                <td class="red-text"> <?php echo date("Y-m-d H:i:s", $info[0]['created_on']); ?></td>
                            </tr>
                            <?php
                            unset($user_ip_info[0]);
                            if(!empty($user_ip_info)){
                                foreach ($user_ip_info as $index => $user_ip) {
                                ?>
                                <tr>
                                    <td><?php echo $user_ip['login_ip']; ?></td>
                                    <td>
                                        <?php
                                        if(empty($user_ip['country']) && empty($user_ip['city'])){
                                            echo 'NO DATA';
                                        }else {
                                            echo $user_ip['country'] . '/' . $user_ip['city'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $user_ip['login_datetime']; ?></td>
                                </tr>
                                <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="designed-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="my_accoutn_tabs">
                <li class="active"><a href="#account_information" data-toggle="tab">Account Information <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#traveler_list" data-toggle="tab" id="traveler_list_link">Traveler List <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#address_book" data-toggle="tab" id="address_book_link">Address Book <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>

                <?php
                $status_icon = [
                    '0' => 'fa fa-times delay-icon',
                    '1' => 'fa fa-check verified-icon',
                    '2' => 'fa fa-exclamation created-icon',
                    '3' => 'fa fa-check delivered-icon'
                ];
                for($i = 1; $i<=$cards_count; $i++){
                    if(!isset($cards[$i])){
                        ?>
                        <li><a href="#credit_card_<?php echo $i; ?>" class="credit_card" data-block = '<?php echo $i; ?>' data-toggle="tab">Credit Card #<?php echo $i; ?> <i class="fa fa-angle-down tab-down" aria-hidden="true" id="icon_<?php echo $i; ?>"></i></a></li>
                        <?php
                    }else{
                        ?>
                        <li><a href="#credit_card_<?php echo $i; ?>" class="credit_card" data-block = '<?php echo $i; ?>' data-toggle="tab">Credit Card #<?php echo $i; ?> <i class="<?php echo $status_icon[$cards[$i]]; ?>" aria-hidden="true" id="icon_<?php echo $i; ?>"></i></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-profile">
                <div class="tab-pane account-info active" id="account_information">
                    <div class="block-1">
                        <div class="min-block">
                            <h2>My Numbers:</h2>

                            <form method="post" class="form-horizontal" action="" id="user_numbers">
                                <div class="form-group">
                                    <label for="cell_phone" class="col-sm-5 col-xs-6 control-label text-left">Cell Phone:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="cell_phone" id="cell_phone" placeholder="" value="<?php echo $info[0]['phone']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fax_number" class="col-sm-5 col-xs-6 control-label text-left">Fax Number:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="fax_number" id="fax_number" placeholder=""  value="<?php echo $info[0]['fax_number']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="home_phone" class="col-sm-5 col-xs-6 control-label text-left">Home / Office  Phone:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="home_phone" id="home_phone" placeholder=""  value="<?php echo $info[0]['home_office_phone']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right button-place">
                                        <span class="code-example text-left">Please enter country code Example: ( 1 ) 212 999 9999 </span>
                                        <button type="button" id = 'user_numbers_butt' class="btn btn-default btn-login-orange">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <p class="border-bottom"></p>
                        <div class="min-block">
                            <h2>Reset Password:</h2>

                            <form method="post" class="form-horizontal" action="" id="update_password" >
                                <div class="form-group">
                                    <label for="new_password" class="col-sm-5 col-xs-6 control-label text-left">New Password:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-sm-5 col-xs-6 control-label text-left">Confirm Password:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right button-place">
                                        <button type="button" id="update_password_butt" class="btn btn-default btn-login-orange">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="border-right"></div>
                    </div>
                    <div class="block-1">
                        <h2>My Address:</h2>
                        <form method="post" class="form-horizontal" action="" id="update_user_address">
                            <input type="hidden" name="user_id" value="<?php echo $info[0]['id'];?>" id="user_id">
                            <div class="form-group">
                                <label for="country" class="col-sm-5 col-xs-6 control-label text-left">Country<span class="important error_class">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">

                                    <select class="form-control selectpicker select-country traveler_country" name="country"  id="country_select">
                                        <option value="" selected="selected">Select Country</option>
                                        <?php
                                        foreach ($all_countries as $countries){
                                            $k=($countries['id'] == $country)?'selected=\'selected\'':'';
                                            ?>
                                            <option value="<?php echo $countries["iso2"].'_'.$countries['id'];?>" <?php echo $k; ?>><?php echo $countries['country']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country_name" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="25" class="form-control" name="country_name" id="country_name" placeholder="" value="<?php echo $info[0]['company']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address_1" class="col-sm-5 col-xs-6 control-label text-left">Address 1<span class="important error_class">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="40" class="form-control" name="address_1" id="address_1" placeholder="" value="<?php echo $info[0]['address1']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address_2" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="40" class="form-control" name="address_2" id="address_2" placeholder="" value="<?php echo $info[0]['address2']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-sm-5 col-xs-6 control-label text-left">City<span class="important error_class">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="25" class="form-control" name="city" id="city" placeholder="" value="<?php echo $info[0]['city']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="region" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <select class="form-control selectpicker select-country" name="region" id="state-select">
                                        <option value="">Select State</option>
                                        <?php
                                        if(!empty($states)){
                                            foreach($states as $value){
                                                $k=($value['Stateid']==$info[0]['address_state_id'])?'selected=\'selected\'':'';
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
                                <label for="zip_code" class="col-sm-5 col-xs-6 control-label text-left">Zip code:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="25" class="form-control" name="zip_code" id="zip_code" placeholder="" value="<?php echo $info[0]['zipcode']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 text-right button-place">
                                    <button type="button" id="update_address_butt" class="btn btn-default btn-login-orange">Save</button>
                                </div>
                            </div>
                        </form>

                        <div class="border-right"></div>
                    </div>
                    <div class="block-2">
                        <div class="min-block">
                            <h2>My Document:</h2>

                            <form method="post" class="form-horizontal" action="">
                                <div id="error_mess_div"><span></span></div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <select class="form-control  document_name" name="document_name" id="doc_file_type">
                                            <option value="">Select Document Name</option>
                                            <?php
                                            foreach($document_select as $object){
                                                ?>
                                                <option value="<?php echo $object->id; ?>"><?php echo $object->title; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <label class="btn btn-default btn-file select-doc-file">
                                            Select Document <input type="file" id="upload_file" name="input_file" class="form-control" style="display: none;">
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="doc-file-place">
                                            <?php
                                            echo $documents_block;
                                            ?>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <p class="border-bottom"></p>
                        <div class="min-block">
                            <h2>Account Credit: <span class="orange-color">$<?php echo floatval($info[0]['account_credit']); ?></span></h2>

                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="traveler_list">

                    <div class="panel panel-default designed-panel no-margin">
                        <!-- ajax div -->
                        <div id="traveller_list_content">

                        </div>
                        <div class="panel-footer no-padding footer-no-border">
                            <a href="#" id="add_new_traveller" class="btn btn-default btn-login-orange" data-name="add_new_traveller_modal" data-toggle="modal" data-target="#my_profile_modal">Add New</a>
                            <a href="#" id="edit_traveller"  class="btn btn-default select-doc-file"><i class="fa fa-pencil-square-o"></i>Edit</a>
                            <a href="#" class="btn btn-default select-doc-file" id="delete_traveler"><i class="fa fa-trash"></i>Delete</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="address_book">
                    <div class="panel panel-default designed-panel">
                        <!-- ajax div -->
                        <div id="address_book_content">

                        </div>
                        <div class="panel-footer no-padding footer-no-border">
                            <a href="#" class="btn btn-default btn-login-orange" data-name="add_new_address" data-toggle="modal" data-target="#my_profile_modal" id="add_new_addr">Add New</a>
                            <a href="#" class="btn btn-default select-doc-file" id="edit_address_book"><i class="fa fa-pencil-square-o"></i>Edit</a>
                            <a href="#" class="btn btn-default select-doc-file" id="delete_address_book"><i class="fa fa-trash"></i>Delete</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane teb_panel" id="credit_card_1">

                </div>
                <div class="tab-pane teb_panel" id="credit_card_2"></div>
                <div class="tab-pane teb_panel" id="credit_card_3"></div>
            </div>
        </div>

    </div>
</div>
