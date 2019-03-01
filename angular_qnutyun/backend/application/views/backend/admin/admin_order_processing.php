<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>
<?php
if($order['shipping_type'] == 2){

    $dis_class = 'dis_none';

}else{

    $dis_class = '';
}

?>
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
<input type="hidden" id="order_status" value="<?php echo $order['shipping_status']; ?>">
<div class="content dashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-body small-body">
                        <div class="display-inline">Currier : <?php echo $order['currier_name']; ?></div>
                        <div class="display-inline">Partner : <a href=""><?php echo $country_prof_info['partner_web']; ?></a></div>
                        <div class="display-inline">User Name : <?php echo $country_prof_info['website']; ?></div>
                        <div class="display-inline">Password : ***** <?php echo substr($country_prof_info['password'] ,-4,4); ?></div>
                        <div class="display-inline">
                            <span><?php echo $order['currier_name']." ".$country_from[0]['iso2']; ?> : <?php echo $country_prof_info['partner_web']; ?></span>
                            <?php
                            if($order['shipping_type'] == 1){?>
                                <span><?php echo $order['currier_name']." ".$country_to[0]['iso2']; ?> : <?php echo $country_prof_info['partner_web']; ?></span>
                           <?php }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Account Message</h3>
                    </div>
                    <input type="hidden" id="order_id" value="<?php echo $order['id']; ?>">
                    <input type="hidden" id="user_id" value="<?php echo $order['user_id']; ?>">
                    <div class="panel-body chat" id="admin-chat-body">
                        <?php

                        if(!empty($account_message)){

                            foreach ($account_message as $index => $value){ ?>
                                <ul>
                                    <li class="left clearfix">
                                        <span class="pull-left"></span>
                                        <div class="chat-body clearfix">
                                            <div class="chat-title">
                                                <strong class="primary-font"><?php echo ($value['add_date'] != '0000-00-00')?date('M-d-Y', strtotime($value['add_date'])):''; ?>pm  By : <?php echo $value['admin_name'];?></strong>
                                            </div>
                                            <p>
                                                <?php echo $value['message_txt'];?>
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                            <?php  }
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm chat-search-place" placeholder="">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-login-blue small-button" id="add_message_to_board">Submit</button>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Order Message</h3>
                    </div>

                    <div class="panel-body chat"  id="order_answer">
                        <?php

                        if(!empty($order_message)){

                            foreach ($order_message as $index => $value){ ?>
                                <ul>
                                    <li class="left clearfix">
                                        <span class="pull-left"></span>
                                        <div class="chat-body clearfix">
                                            <div class="chat-title">
                                                <strong class="primary-font"><?php echo date('M-d-Y', strtotime($value['add_date'])); ?>pm  By : <?php echo $value['admin_name'];?></strong>
                                            </div>
                                            <p>
                                                <?php echo $value['message'];?>
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                            <?php  }
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="order_message_val" type="text" i class="form-control input-sm chat-search-place" placeholder="">
                            <span class="input-group-btn">
                                    <button class="btn btn-default btn-login-blue small-button save_order_message" id="">Submit</button>
                                </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default designed-panel panel-bordered">
                    <div class="panel-table-title text-center">
                        <h3 class="panel-title">Account & Order Summary <i class="fa fa-check delivered-icon"></i></h3>
                    </div>
                    <div class="panel-body small-body">

                        <div class="row">
                            <div class="col-md-6 order_info_div">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-5 col-xs-6 control-label text-left padding-right-0">Order Number</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span>: <?php echo $order['order_id']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-5 col-xs-6 control-label text-left padding-right-0">Order Date</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span>: <?php echo date("M-d-Y", strtotime($order['created_date'])); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-5 col-xs-6 control-label text-left padding-right-0">Order Total</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span>: $<?php echo (!empty($order_price['original_price']))?$order_price['original_price']:'0'; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-5 col-xs-6 control-label text-left padding-right-0">Account Balance</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span>: <span class="red-text">$0</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-5 col-xs-6 control-label text-left padding-right-0">Order Status</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span class="orange-color">: <span ><?php echo $title;?></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 no-padding order_info_div">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-4 col-xs-6 control-label text-left">Name</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span class="admin_name_max">: <?php echo $user_info[0]['first_name']. ' '.$user_info[0]['last_name'];?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-4 col-xs-6 control-label text-left">Email</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span class="admin_name_max">: <?php echo $user_info[0]['email'];?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-4 col-xs-6 control-label text-left">Account #</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <a href="<?php echo base_url('admin/user_manage/user_account/').$user_info[0]['id']; ?>">
                                                <span>: <?php echo $user_info[0]['account_name']; ?></span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-4 col-xs-6 control-label text-left">Credits</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span>: <span class="red-text">$<?php echo $user_info[0]['account_credit']; ?></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-4 col-xs-6 control-label text-left padding-right-0">Customer Cancel</label>
                                        <div class="col-sm-7 col-xs-6 mob-input">
                                            <span> <?php echo  (($order['shipping_status'] == SUBMITTED_CANCEL_STATUS[0] || $order['shipping_status'] == PROCESSED_CANCEL_STATUS[0]) && $order['status_change_by'] == 0)?': <span class="rounded-x">X</span>':'';  echo (!empty($order['cancel_count']))?'&nbsp'.$order['cancel_count']:''; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="post">
                                <div class="col-md-7 no-padding">
                                    <ul class="label-ordering">
                                        <li>
                                            <?php

                                            $status = $order['shipping_status'];
                                            $original_status = $status;

                                            if($status == SUBMITTED_CANCEL_STATUS[0] && $order['status_change_by'] == 1){
                                                $status = PROCESSED_CANCEL_STATUS[0];
                                            }

                                            if($status == PROCESSED_CANCEL_STATUS[0] && $order['status_change_by'] == 1){
                                                $status = SUBMITTED_CANCEL_STATUS[0];
                                            }

                                            if($status == SUBMITTED_CANCEL_STATUS[0] && $order['status_change_by'] == 0){
                                                $status = SUBMITTED_STATUS[0];
                                            }

                                            if($status == PROCESSED_CANCEL_STATUS[0] && $order['status_change_by'] == 0){
                                                $status = PROCESSED_STATUS[0];
                                            }

                                            foreach($all_statuses[$original_status] as $single_status){
                                                
                                                $k = '';

                                                if($status == $single_status[0]){
                                                    $k = "checked = 'checked'";
                                                }

                                            ?>
                                                <div class="col-md-4 padding-right-0 admin_status_radio"> <input type="radio" name="order_status" value="<?php echo $single_status[0]; ?>" <?php echo $k; ?>><?php echo $single_status[1]; ?></div>
                                            <?php
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-5 no-padding">
                                    <div class="rounded-border ordering-block">
                                        <ul class="label-ordering">
                                            <li>
                                                <div class="col-md-6 padding-right-0 padding-left-0 form-small-font admin_checkbox"> <input value="1" name="lost_claim" <?php echo ($order['lost_claim'] == 1)?'checked = "checked"':'';?> class="order_checkbox" type="checkbox"> &nbsp  Lost Claim</div>
                                                <div class="col-md-6 padding-right-0 padding-left-0 form-small-font admin_checkbox"> <input value="1" name="damage_claim" <?php echo ($order['damage_claim'] == 1)?'checked = "checked"':'';?> class="order_checkbox" type="checkbox"> &nbsp  Damage Claim</div>
                                            </li>
                                            <li>
                                                <div class="col-md-6 padding-right-0 padding-left-0 form-small-font admin_checkbox"> <input value="1" name="payment_dispute" <?php echo ($order['payment_dispute'] == 1)?'checked = "checked"':'';?> class="order_checkbox" type="checkbox">&nbsp Payment Dispute</div>
                                                <div class="col-md-6 padding-right-0 padding-left-0 form-small-font admin_checkbox"> <input value="1" name="billing_claim" <?php echo ($order['billing_claim'] == 1)?'checked = "checked"':'';?> class="order_checkbox" type="checkbox"> &nbsp Billing Claim</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right padding-right-0">
                                    <button type="button" class="btn btn-default btn-login-blue small-button update_order_status">Update</button>
                                </div>
                                <div class="col-md-6 text-right padding-right-0">
                                    <button type="button" class="btn btn-default btn-login-blue small-button update_claim">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
$billing_class = (!empty($order['card_id']))?'fa fa-check delivered-icon':'fa fa-exclamation created-icon';

?>
        <div class="designed-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="my_accoutn_tabs">
                <li class="active"><a href="#account_information" data-toggle="tab"><?php echo $order['currier_name']." ".$order['original_send_type']; ?><i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li class="<?php echo $dis_class; ?>"><a href="#traveler_list" class="custom_documents" data-toggle="tab">Custom Documents @ <span class="orange-color custom_doc_price"><?php show_price($travel_price);?></span> <i class="<?php echo $custom_class; ?>" id="custom_document"></i> <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#address_book" class="billing_payment_info" data-toggle="tab">Billing and Payment <i class="<?php echo $billing_class; ?>" id="billing_icon"></i> <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#api_errors" data-toggle="tab">API Errors<i class="" id="billing_icon"></i> <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li class="float_right"><?php
                        if($freeze['freeze']){
                            echo '<p class="error_class no-margin">User modifying order now!</p>';
                        }
                        echo '<p class="no-margin">Last Modify : '.$freeze['last'].'</p>';
                    ?></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-profile">
                <div class="tab-pane account-info active" id="account_information">
                    <div class="col-md-12 order-detail-top-panel">
                        <?php if($order['shipping_status'] == SUBMITTED_STATUS[0]) {?>
                        <a href="<?php echo base_url('admin/order/manage_order/'.$order['id']); ?>" target="_blank"><button class="btn btn-default btn-login-orange">Modify Order</button></a>
                        <?php } ?>
                        <button class="btn btn-default  btn-login-blue submit-all-btn">Submit All</button>
                    </div>
                    <div class="row">
                        <div class="col-md-3 padding-right-0 admin_sender_info_answer">
                            <div class="panel panel-default designed-panel panel-bordered light">
                                <div class="panel-table-title">
                                    <h3 class="panel-title">Pickup Information <a href="#" class="pull-right light-edit edit_sender_pickup_info no_href"><i class="fa fa-pencil"></i> edit</a></h3>
                                </div>

                                <div class="panel-body">
                                    <div class="light-block">
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Pickup Date: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                               <?php echo ($sender_info['shipping_date'] != '0000-00-00')?date('M-d-Y', strtotime($sender_info['shipping_date'])):'';?>
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
                                                <?php echo $sender_info['sender_first_name'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Last Name: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['sender_last_name'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Phone: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['sender_phone'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Email: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['sender_email'];?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="light-block">
                                        <div class="light-title">From</div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Organization: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['pickup_company'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Address 1: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['pickup_address1'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Address 2: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['pickup_address2'];?>
                                            </div>
                                        </div>
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
                                                <?php echo $state_name_sender;?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Country: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $country_from[0]['country']; ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Remark: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $sender_info['pickup_remark'];?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 padding-right-0 delivery_info">
                            <div class="panel panel-default designed-panel panel-bordered light">
                                <div class="panel-table-title">
                                    <h3 class="panel-title">Delivery Information <a href="#" class="pull-right light-edit edit_delivery_butt no_href"><i class="fa fa-pencil"></i> edit</a></h3>
                                </div>

                                <div class="panel-body">
                                    <div class="light-block">
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Delivery Date: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                              <?php echo ($delivery_info['delivery_date'] != '0000-00-00')?date('M-d-Y', strtotime($delivery_info['delivery_date'])):'';?>
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
                                                <?php echo $delivery_info['receiver_first_name'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Last Name: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['receiver_last_name'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Phone: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['receiver_phone'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Email: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['receiver_email'];?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="light-block">
                                        <div class="light-title">To</div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Organization: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['delivery_company'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Address 1: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['delivery_address1'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Address 2: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['delivery_address2'];?>
                                            </div>
                                        </div>
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
                                                <?php echo $state_name_delivery;?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Country: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $country_to[0]['country']; ?>
                                                <input type="hidden" id="delivery_country_id" value="<?php echo $delivery_info['delivery_country_id']?>">
                                                <input type="hidden" id="order_id" value="<?php echo $delivery_info['order_id']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-5 control-label form-small-font">Remark: </label>
                                            <div class="col-sm-7 mob-input form-small-font">
                                                <?php echo $delivery_info['delivery_remark'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-4 control-label">Remote Area </label>
                                            <div class="col-sm-8 mob-input form-small-font remote_area_main">
                                                <span><input type="radio" name="remote_val" value="2" <?php echo ($delivery_info['remote_area_fee'] != 0)?'checked = "checked"':'';?> id="yes" class="remote_area_radio"> Yes</span>
                                                <span><input type="radio" <?php echo ($delivery_info['remote_area_fee'] == 0)?'checked = "checked"':'';?> name="remote_val" value="1" id="no" class="remote_area_radio"> No</span>
                                                <p class="error_class" id="remote_area_fee_answer"><?php echo ($delivery_info['remote_area_fee'] != 0)?'Remote area fee $'.$delivery_info['remote_area_fee']:'No remote area fee'; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php

                        if($delivery_info['without_signature'] == 1){

                            $signature = 'YES';

                        }else{

                            $signature = 'NO';
                        }

                        $trucking_class = 'fa fa-check delivered-icon';

                        if(!empty($order['temp']) ){

                            $trucking_class = 'fa fa-check verified-icon ';

                        }elseif(empty($insurance_info['label_check'])){

                            $trucking_class = 'fa fa-exclamation created-icon';

                        }

                        ?>
                        <div class="col-md-6">
                            <form method="post" id="tracking_label_form">

                            <div class="panel panel-default designed-panel panel-bordered light">
                                <div class="panel-table-title">
                                    <h3 class="panel-title">Tracking Numbers & Labels <i class="<?php echo $trucking_class; ?>"></i> </h3>
                                </div>
                                <?php
                                $real_service = $my_carrier['currier_name']." ".str_ireplace(['outbound ', 'inbound'], '', $order['original_send_type']);
                                $billing_service = $order['origin_carrier_name']." ".str_ireplace(['outbound ', 'inbound'], '', $order['origin_send_type']);
                                ?>
                                <div class="row tracking-number-info">
                                    <div class="col-md-5">Service : <span class="orange-color"><?php echo $real_service  ?></span></div>
                                    <div class="col-md-3">Without Sig : <span class="green-text"><?php echo $signature; ?></span></div>
                                    <div class="col-md-4 text-right">Total Ins : <span class="orange-color">$<?php echo $insurance_info['total']; ?></span></div>
                                    <div class="col-md-12">Billing Service : <span class="red-text"><?php

                                            if($real_service != $billing_service){
                                                echo $billing_service;
                                            }

                                            ?></span>
                                    </div>
                                </div>
                                    <div class="panel-body">
                                        <?php
                                        $c = '';
                                        if(stripos($order['original_send_type'], '+sat')!==FALSE){
                                            $c = 'checked="checked"';
                                        }
                                        ?>
                                    <div class="col-md-12 trucking-header">
                                        <div class="col-md-4">
                                            <input type="checkbox" value="true" id="sat_delivery" name="sat_delivery" <?php echo $c; ?>> Saturday delivery
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control selectpicker document_name mini-dropdown" name="" id="change_currier">
                                                <option value="">Select Currier</option>
                                                <?php
                                                if(!empty($all_currier)){

                                                    foreach ($all_currier as $currier){
                                                        $k = ($currier['id'] == $my_carrier['id'])?'selected = "selected"':'';
                                                        ?>

                                                        <option  <?php echo $k; ?> value="<?php echo $currier['id']; ?>"><?php echo $currier['currier_name']; ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control selectpicker document_name document_type mini-dropdown" name="" id="document_type">
                                                <?php
                                                if(!empty($carrier_info)){
                                                    foreach ($carrier_info as $index => $value){

                                                        $send_type = $order['send_type'];

                                                        if(stripos($send_type, 'basic') !== FALSE){
                                                            $send_type = str_ireplace($order['delivery_day_count'], '*', $send_type);
                                                        }

                                                        $k = ($value == $send_type)?'selected = "selected"':'';
                                                        ?>
                                                        <option <?php echo $k; ?> value="<?php echo $value; ?>"><?php echo $index; ?></option>
                                                    <?php } }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <table class="table table-bordered designed-table">
                                        <thead>
                                        <tr>
                                            <th class=""><small>#</small></th>
                                            <th class=""><small>Luggage Type</small></th>
                                            <th class=""><small>Weight & Size</small></th>
                                            <th class=""><small>Insurance</small></th>
                                            <th class=""><small>Tracking#</small></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!empty($insurance_info['info'])){

                                            foreach ($insurance_info['info'] as $index => $insurance){

                                                if($insurance['luggage_name'] == 'Special Boxes'){
;
                                                    $weight = $insurance['label_weight'];
                                                    $length = $insurance['label_length'];
                                                    $height = $insurance['label_height'];
                                                    $width  = $insurance['label_width'];

                                                }else{

                                                    $weight = $insurance['weight'];
                                                    $length = $insurance['length'];
                                                    $height = $insurance['height'];
                                                    $width  = $insurance['width'];
                                                }


                                                if($weight%1 == 0){

                                                    $weight = intval($weight);

                                                }else{

                                                    $weight = number_format($weight, 2);
                                                }

                                                if($length%1 == 0){

                                                    $length = intval($length);

                                                }else{

                                                    $length = number_format($length, 2);
                                                }

                                                if($height%1 == 0){

                                                    $height = intval($height);

                                                }else{

                                                    $height = number_format($height, 2);
                                                }

                                                if($width%1 == 0){

                                                    $width = intval($width);

                                                }else{

                                                    $width = number_format($width, 2);
                                                }
                                                ?>

                                                <tr>
                                                    <td><?php echo $index+1; ?></td>
                                                    <td>
                                                        <div class="name_div">
                                                            <input class="visible-hidden luggage_labele_upload" data_id="<?php echo $insurance['lug_id']; ?>" type="file" id="file_<?php echo $insurance['lug_id'];?>">
                                                            <span   class="upload_luggage_file">
                                                                <?php

                                                                if(!empty($insurance['lug_name'])){
                                                                    echo $insurance['lug_name'];
                                                                }else{
                                                                    echo $insurance['type_name'];
                                                                }

                                                                ?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                        if(!empty($insurance['temp_label_file'])){
                                                            ?>
                                                            <div class="image_div">
                                                                <a href="<?php echo base_url('admin/order/label_file/' . $order['id'] . '/' . $insurance['temp_label_file']); ?>"
                                                                   target="_blank"> <img class="main_img small_img"
                                                                                         src='<?php echo base_url(); ?>assets/images/doc_ico.ico'></a>
                                                                <img class='sender_label position-static' data_id='<?php echo 'temp_'.$insurance['file_id']; ?>'
                                                                     src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                                <span class="mega-small red-text">temp</span>
                                                            </div>
                                                            <?php
                                                        }
                                                        elseif(!empty($insurance['file_name'])){

                                                            ?>
                                                            <div class="image_div">
                                                                <a href="<?php echo base_url('admin/order/label_file/' . $order['id'] . '/' . $insurance['file_name']); ?>"
                                                                   target="_blank"> <img class="main_img small_img"
                                                                                         src='<?php echo base_url(); ?>assets/images/doc_ico.ico'></a>
                                                                <img class='sender_label position-static' data_id='<?php echo $insurance['file_id']; ?>'
                                                                     src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $weight; ?> lbs ( <?php echo intval($width)."-".$length."-".$height;?> )</td>
                                                    <td>$<?php echo $insurance['insurance']?></td>
                                                    <td><input type="text" name="tracking_<?php echo $insurance['lug_id'];?>" class="form-control" value="<?php echo $insurance['tracking_number']; ?>">
                                                        <?php if(!empty($insurance['temp_number'])) { ?>
                                                            <span class="mega-small red-text">temp</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                         <?php   } }?>

                                        </tbody>
                                    </table>
                                    <div>
                                    <?php if($order['shipping_type'] == '1') { ?>
                                        <div class="col-md-9">
                                            <div class="row form-horizontal ">
                                                <div class="form-group">
                                                    <div class="col-md-5 col-md-push-1">
                                                        <select class="form-control selectpicker document_name" name="" id="type_id">
                                                            <?php
                                                            if(!empty($order_file_types)){

                                                                $currier_name_for_type = $my_carrier['currier_name'];

                                                                foreach ($order_file_types as $index => $value){

                                                                    if(stripos($currier_name_for_type,'dhl')  === FALSE && $value['value'] == 'Archive_review'){

                                                                        continue;
                                                                    }

                                                                    if(stripos($currier_name_for_type,'fedex')  === FALSE && $value['value'] == 'fedex_second_label'){

                                                                        continue;
                                                                    }

                                                                    ?>
                                                                    <option value="<?php echo $value['value']; ?>"><?php echo $value['title']; ?></option>
                                                                <?php }
                                                            }  ?>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-4 col-md-push-1">
                                                        <label class="btn btn-default btn-file select-doc-file">
                                                            Upload<input type="file" id="upload_label" name="input_file" class="form-control" style="display: none;">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-horizontal">
                                                <div class="form-group">
                                                    <div class="col-md-12 col-md-push-1">
                                                        <div class="doc-file-place admin_custom_invoice">
                                                            <ul class="">
                                                                <?php if(!empty($type_files)){
                                                                foreach ($type_files as $index => $files){
                                                                    if($files['file_type'] == 'label' || $files['file_type'] == 'label_shipping'){
                                                                        continue;
                                                                    }
                                                                 ?>
                                                                <li>
                                                                    <div class="image_div">
                                                                        <img class='sender_label' data_id='<?php echo $files['id']; ?>'
                                                                        src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                                        <a href="<?php echo base_url('admin/order/label_file/' . $order['id'] . '/' . $files['file_name']); ?>"
                                                                           target="_blank"> <img class="main_img"
                                                                                                 src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                                    </div>

                                                                    <span class="limit_text"><?php echo str_replace('_',' ', $files['file_type']); ?></span>
                                                                </li>
                                                                <?php   } }?>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                        <div id="create_shipment_div" class="dis_none">
                                            <div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>
                                        </div>
                                        <div class="col-md-2 create-label-div">
                                            <button type="button" class="btn btn-default btn-login-orange adm-btn create-label fedex_validate_address" id="">Create Label</button>
                                        </div>
                                        <?php
                                        if(!empty($order['labels_pdf'])){ ?>
                                        <div class="col-md-2 create-label-div regeneracia_pdf <?php echo ($order['shipping_type'] == 2)?'dom_reg_diiv':'';?>">
                                            <button type="button" class="btn btn-default btn-login-orange adm-btn create-label" id="regeneracia_pdf">Regenerate pdf</button>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-12 trucking-footer">
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-default btn-login-blue adm-btn" id="save_track_label">Submit</button>
                                        </div>
                                        <div class="col-md-3">
                                            <?php
                                            if(empty($order['labels_pdf'])){ ?>

                                                <button type="button" class="btn btn-default adm-btn print_labels">Print Labels</button>
                                           <?php }else{ ?>
                                                <a href="<?php echo base_url('stream/labels/'.$order['labels_pdf'].'/'.sample_hash($order['user_id'])); ?>" target="_blank" class="btn btn-default adm-btn">Label Pdf</a>
                                          <?php  } ?>

                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-default btn-login-orange adm-btn" id="save_track_temp">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">

                            <div class="panel panel-default designed-panel panel-bordered light no-margin">
                                <div class="panel-table-title">
                                    <?php

                                    $shedule_class = (empty($shedule))?'fa fa-exclamation created-icon':'fa fa-check delivered-icon';

                                    if(!empty($shedule['temp'])){

                                        $shedule_class = 'fa fa-check verified-icon';

                                    }else if($sender_info['pick_up'] == '1'){

                                        $shedule_class = '';
                                    }

                                    ?>

                                    <h3 class="panel-title shedule_icon_class">Shedule Pick up <i class="<?php echo $shedule_class; ?> "></i></h3>
                                </div>

                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" id="shedule_form">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="col-sm-3 control-label text-left">Pick up Date : </label>
                                                <div class="col-sm-9 mob-input form-small-font">
                                                    <input type="text" name="pick_up_date" class="form-control main-date pick_up_date" value="<?php echo (!empty($shedule))?$shedule['date']:''; ?>"><span class="red-text"> Fee: <?php echo '$'.$fee['pick_up']; ?></span> <a href="#" class="btn btn-default small-button select-doc-file  white-space drop_off_location">Find a drop off location</a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-3 control-label text-left">Pick up Time : </label>
                                                <div class="col-sm-3 mob-input form-small-font padding-right-0">
                                                    <select class="form-control selectpicker document_name" name="time_from" >
                                                        <?php
                                                        $AM = '';
                                                        $PM = '';
                                                        for($i=1; $i<=12; $i++){
                                                            $time = $i.':00am';
                                                            $k = '';
                                                            if($shedule['time_from'] == $time){
                                                                $k = 'selected="selected"';
                                                            }
                                                            $AM = $AM."<option value='$time' $k>$time</option>";

                                                            $time = $i.':00pm';
                                                            $k = '';
                                                            if($shedule['time_from'] == $time){
                                                                $k = 'selected="selected"';
                                                            }
                                                            $PM = $PM."<option value='$time' $k>$time</option>";
                                                        }
                                                        echo $AM;
                                                        echo $PM;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 mob-input text-center">
                                                    <label class="control-label">To</label>
                                                </div>
                                                <div class="col-sm-3 mob-input form-small-font padding-left-0">
                                                    <select class="form-control selectpicker document_name" name="time_to" >
                                                        <?php
                                                        $AM = '';
                                                        $PM = '';
                                                        for($i=1; $i<=12; $i++){
                                                            $time = $i.':00am';
                                                            $k = '';
                                                            if($shedule['time_to'] == $time){
                                                                $k = 'selected="selected"';
                                                            }
                                                            $AM = $AM."<option value='$time' $k>$time</option>";

                                                            $time = $i.':00pm';
                                                            $k = '';
                                                            if($shedule['time_to'] == $time){
                                                                $k = 'selected="selected"';
                                                            }
                                                            $PM = $PM."<option value='$time' $k>$time</option>";
                                                        }
                                                        echo $AM;
                                                        echo $PM;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <label for="" class="col-sm-3 control-label text-left">Pick up Con# : </label>
                                                <div class="col-sm-8 mob-input form-small-font">
                                                    <input type="text" name="con" class="form-control" value="<?php echo (!empty($shedule))?$shedule['con']:'';?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                    <div class="col-sm-5 mob-input old-pick-up">
                                                        <span>Org. pick up:</span>
                                                        <?php
                                                        $sdate = '';
                                                        $stime = '';
                                                        if(!empty($shedule['old_pick_up'])){
                                                            $shedule['old_pick_up'] = explode('/', $shedule['old_pick_up']);
                                                            if(!empty($shedule['old_pick_up'][0])){
                                                                $sdate = $shedule['old_pick_up'][0];
                                                            }
                                                            if(!empty($shedule['old_pick_up'][1])){
                                                                $stime = $shedule['old_pick_up'][1];
                                                            }
                                                        }
                                                        ?>
                                                        <p class="form-small-font">
                                                            Date: <?php  if(!empty($sdate)) {echo date('M-d-Y', strtotime($sdate)); }?><br>
                                                            Time: <?php if(!empty($stime)) {echo  $stime; }?>
                                                        </p>
                                                    </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-right margin-top-12">
                                                        <button type="button" class="btn btn-default btn-login-orange adm-btn shedule_temp">Save</button>
                                                        <button type="button" class="btn btn-default btn-login-blue adm-btn save_shedule">Submit</button>
                                                        <!-- <button type="submit" class="btn btn-default btn-login-blue adm-btn">Submit</button>-->
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="clearfix"></p>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-default designed-panel panel-bordered light no-margin">
                                <div class="panel-table-title">
                                    <?php

                                    if(empty($label_dif)){

                                        $checked_delivery_label = true;
                                    }else{

                                        $checked_delivery_label = false;
                                    }

                                    if(empty($label_dif) && (empty($label_shipment['viewed']) || $label_shipment['viewed'] != 1)){

                                        $label_delivery_class = 'fa fa-exclamation created-icon';

                                    }elseif(empty($label_shipment)){

                                        $label_delivery_class = '';

                                    }else{

                                        $label_delivery_class = 'fa fa-check delivered-icon';
                                    }

                                    $address_class = 'btn btn-default grow-button adm-btn pull-right light-add label_delivery';

                                    if($checked_delivery_label){

                                        $address_class = 'btn btn-default btn-login-orange adm-btn pull-right light-add label_delivery';

                                    }

                                    if(!empty($label_shipment['temp'])){
                                        $label_delivery_class = 'fa fa-check verified-icon ';
                                    }

                                    ?>
                                    <h3 class="panel-title">Label Shipment & Summary <i class="<?php echo $label_delivery_class;?>"></i>
                                        <button type="button" class="<?php echo  $address_class; ?>">New Address</button>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" id="delivery_address_form">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label text-left">Shipping Date : </label>
                                                <div class="col-sm-8 mob-input form-small-font">
                                                    <input type="text" name="shipping_date" class="form-control main-date pick_up_date" value="<?php echo (!empty($label_shipment['shipping_date']))?$label_shipment['shipping_date']:'';?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label text-left">Delivery Date : </label>
                                                <div class="col-sm-8 mob-input form-small-font">
                                                    <input type="text" name="delivery_date" class="form-control main-date pick_up_date" value="<?php echo (!empty($label_shipment['delivery_date']))?$label_shipment['delivery_date']:'';?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label text-left">Tracking# : </label>
                                                <div class="col-sm-8 mob-input form-small-font">
                                                    <input type="text" name="trucking_num" class="form-control" value="<?php echo (!empty($label_shipment['tracking_number']))?$label_shipment['tracking_number']:'';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="courier form-small-font">Courier</label>
                                                    <select class="form-control selectpicker document_name pull-right" name="label_carrier" id="change_label_currier">
                                                        <option value="">Select Currier</option>
                                                        <?php
                                                        if(!empty($all_currier)){
                                                            foreach ($all_currier as $currier){
                                                                $k = ($currier['id'] == $label_shipment['carrier_id'])?'selected = "selected"':'';
                                                                ?>
                                                                <option  <?php echo $k; ?> value="<?php echo $currier['id']; ?>"><?php echo $currier['currier_name']; ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 mob-input form-small-font" id="label_document_type">
                                                    <select class="form-control selectpicker document_name" name="service_type">
                                                        <?php
                                                        if(!empty($label_carrier_info)){
                                                            foreach ($label_carrier_info as $index => $value){
                                                                $k = ($value == $label_shipment['shipping_type'])?'selected = "selected"':'';
                                                                ?>
                                                                <option <?php echo $k; ?> value="<?php echo $value; ?>"><?php echo $index; ?></option>
                                                            <?php } }  ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right margin-top-6" id="label_shipment_but_cont">
                                            <div class='cssload-square mini-loader'>
                                                <div class='cssload-square-part cssload-square-green'></div>
                                                <div class='cssload-square-part cssload-square-pink'></div>
                                                <div class='cssload-square-blend'></div>
                                            </div>
                                            <?php if(!empty($label_shipment['file_id'])) {?>
                                                <div class="image_div col-md-6">
                                                    <img class='sender_label label_shipment_x' data_id='<?php echo $label_shipment['file_id']; ?>'
                                                         src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                    <a href="<?php echo base_url('admin/order/label_file/' . $label_shipment['order_id'] . '/' . $label_shipment['file_name']); ?>"
                                                       target="_blank"> <img class="main_img"
                                                                             src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            if(!empty($label_shipment['shipping_date'])){?>
                                            <button class="creat-summery-label" type="button">Create Label</button>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6 text-right margin-top-6">
                                            <button type="button" class="btn btn-default btn-login-orange adm-btn shipment_summary_temp">Save</button>
                                            <button type="button" class="btn btn-default btn-login-blue adm-btn shipment_summary_save">Submit</button>
                                           <!-- <button type="submit" class="btn btn-default btn-login-blue adm-btn">Submit</button>-->
                                        </div>
                                        <p class="clearfix"></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-pane admin_custom_document" id="traveler_list">

                </div>
                <div class="tab-pane admin_billing_payment" id="address_book">

                </div>
                <div class="tab-pane" id="api_errors">
                    <table class="col-lg-12 table table-bordered designed-table">
                        <thead>
                            <tr>
                                <th class="col-lg-6">Error message</th>
                                <th class="col-lg-6">Date</th>
                            </tr>
                        </thead>
                    <?php if(!empty($errors)) {
                        foreach($errors as $single){
                            ?>
                            <tr>
                                <td class="col-lg-6"><?php echo $single['error_message']?></td>
                                <td class="col-lg-6"><?php echo date('M-d-Y H:i:s', strtotime($single['date'])); ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="label_delivery_view" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_delivery_label_answer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="drop_off_map" role="dialog">
    <div class="modal-dialog drop_off_locator">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="drop_off_content">

            </div>

        </div>

    </div>
</div>
<div id="delivery_label_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade ">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mobile_padding_in_popap" id="delivery_label">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="submit_all_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="text-center">Necessary Information</h3>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="answer_upload_all">
                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade" id="address_validation_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="text-center" style="margin: 0">Address Validation</h3>
            </div>
            <div class="modal-body" id="upload_modal_div">
                <div id="loader">
                    <div id="validate_loader_div" class="dis_none">
                        <div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>
                    </div>
                </div>
                <div id="answer_validate_error">

                </div>
            </div>

        </div>

    </div>
</div>
<?php
$item_count = 1;

if(!empty($order_item_list)){

    $item_count = count($order_item_list);
}

?>
<script>
    item_count = '<?php echo $item_count; ?>';
    item_name  = <?php echo json_encode($item_name); ?>;
    submited_status = <?php echo SUBMITTED_STATUS[0];?>
</script>