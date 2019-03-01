<?php
if(!empty($order_info['card_id'])){

    $class1 = 'fa fa-check delivered-icon';

}else{
    $class1 = 'fa fa-exclamation created-icon';
}
?>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title">Credit card <i class="<?php echo $class1; ?>" id="biling_card_icon"></i></h3>
                <select class="form-control selectpicker document_name pull-right mini-dropdown select-country" id="admin_card_name_select" name="card_name" >
                    <option value="">Select card</option>
                    <?php
                    if(!empty($cards_info['all_cards'])){

                        foreach ($cards_info['all_cards'] as $index => $value){
                            $k = ($order_info['card_id'] == $value['id'])?'selected = "selected"':'';
                            ?>

                            <option value="<?php echo $value['id']?>" <?php echo $k; ?>>Card ********<?php echo substr($value['card_number'],-4,4); ?></option>

                     <?php   } } ?>
                </select>
            </div>
            <?php

            if(!empty($cards_info['card_info']['cvc_check'])){
                $cvc_check = 'fa fa-check delivered-icon';
                $cvc_check_answer = 'Passed ';

            }else{

                $cvc_check = 'fa fa-times delay-icon';
                $cvc_check_answer = 'Failed';
            }

            if(!empty($cards_info['card_info']['street_check'])){

                $stret_check = 'fa fa-check delivered-icon';
                $stret_check_answer = 'Passed ';

            }else{
                $stret_check = 'fa fa-times delay-icon';
                $stret_check_answer = 'Failed';
            }

            if(!empty($cards_info['card_info']['zip_check'])){

                $zip_check = 'fa fa-check delivered-icon';
                $zip_check_answer = 'Passed ';
            }else{

                $zip_check = 'fa fa-times delay-icon';
                $zip_check_answer = 'Failed';
            }

            ?>
            <div class="panel-body" id="credit_card_info">
                <div class="col-md-6 padding-right-0">
                    <?php
                    if(!empty($cards_info['card_info'])){ ?>
                    <div class="form-group">
                    <div class="light-block">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">First Name:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['holder_first_name'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label style="position: absolute; left: 15px;top: 20px;" for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Last Name:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['holder_last_name'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Company:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['company_name'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Card Number:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0">********<?php echo substr($cards_info['card_info']['card_number'],-4,4); ?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Expiration:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['exp_year']."-".$cards_info['card_info']['exp_mounth'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Card Code:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0">***</div>
                        </div>
                    </div>
                    <hr>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Country:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['country'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Address 1:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['address1'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Address 2:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['address2'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">City:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['city'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">State:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['state'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Zip Code:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['zip_code'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Phone:</label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['phone'];?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Type: </label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['type'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Origin: </label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cards_info['card_info']['origin'];?></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">CVC Check: </label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $cvc_check_answer; ?> <i class="<?php echo $cvc_check;?>"></i></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Street Check: </label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $stret_check_answer;?> <i class="<?php echo $stret_check;?>"></i></div>
                        </div>
                    </div>
                    <div class="light-block">
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label form-small-font padding-right-0 padding-left-0">Zip Check: </label>
                            <div class="col-sm-7 mob-input form-small-font padding-left-0 padding-right-0"><?php echo $zip_check_answer;?> <i class="<?php echo $zip_check;?>"></i></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title">Credit - Charge - Refund</h3>
                <span class="red-text pull-right">Account Balance: $100</span>
            </div>

            <div class="panel-body">
                <form method="post" class="form-horizontal" id="admin_action">
                    <div class="col-md-10 padding-left-0">
                        <ul class="label-ordering form-small-font">
                            <li>
                                <div class="col-md-4 padding-right-0"><input type="radio" class="charge_refund_radio" name="admin_action" value="admin_credit"> Admin Credit</div>
                                <div class="col-md-4 padding-right-0"><input type="radio" class="charge_refund_radio" name="admin_action" value="admin_refund"> Admin Refund</div>
                                <div class="col-md-4 padding-right-0"><input type="radio" class="charge_refund_radio" name="admin_action" value="manual_refund"> Manual Refund</div>
                            </li>
                            <li>
                                <div class="col-md-4 padding-right-0 small text-center">This Credit will be use for Next Shipment</div>
                                <div class="col-md-4 padding-right-0"><input type="radio" class="charge_refund_radio" name="admin_action" value="canceled"> Canceled</div>
                                <div class="col-md-4 padding-right-0"><input type="radio" class="charge_refund_radio" name="admin_action" value="closet"> Closet</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="" placeholder="">
                    </div>
                    <p class="clearfix"></p>
                    <div class="charge-refund">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label text-left padding-right-0">Amount: </label>
                                <div class="col-sm-4 mob-input form-small-font padding-right-0">
                                    <input type="text" name="amount" class="form-control">
                                </div>
                                <div class="col-sm-5 mob-input form-small-font">
                                    <select class="form-control  document_name" name="reason" >
                                        <?php
                                        if(!empty($reasons)){
                                            foreach($reasons as $single){
                                                ?>
                                                <option value="<?php echo $single; ?>"><?php echo $single; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label text-left padding-right-0">Pay By: </label>
                                <div class="col-sm-4 mob-input form-small-font padding-right-0">
                                    <select class="form-control  document_name" name="" >
                                        <option value="">4594</option>
                                        <option value="">5757</option>
                                        <option value="">4755</option>
                                    </select>
                                </div>
                                <div class="col-sm-5 mob-input form-small-font">
                                    <input type="text" name="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button"  class="btn btn-default btn-login-orange adm-btn pull-right save_credit_charge" >Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default designed-panel panel-bordered">
                <div class="panel-table-title text-center">
                    <h3 class="panel-title">Finical Notes</h3>
                </div>
                <div class="panel-body chat billing_panel_body" id="admin-chat-body">
                    <ul id="finicial_notes_answer">
                        <?php
                        foreach ($order_message as $index => $value){ ?>
                        <li class="left clearfix">
                            <span class="pull-left"></span>
                            <div class="chat-body clearfix">
                                <div class="chat-title">
                                    <strong class="primary-font"><?php echo date('M-d-Y', strtotime($value['add_date'])); ?> pm  By : <?php echo $value['admin_name'];?></strong>
                                </div>
                                <p>
                                  <?php echo $value['message'];?>
                                </p>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <br>
                </div>
                <div class="panel-footer billing_footer">
                    <div class="form-group">
                        <div class="col-xs-8 value-info">
                            <textarea name="" id="billing_final_notes"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-8 value-info">
                            <button class="btn btn-default btn-login-blue small-button finicial_button" id="billing_finicial_button">Submit</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="col-md-7">

        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title">Charge & Payment History</h3>
                <span class="red-text pull-right">Account Balance: $100</span>
            </div>
            <div class="panel-body">
                <table class="table table-bordered designed-table">
                    <thead>
                    <tr>
                        <th><small>#</small></th>
                        <th><small>Date & Time</small></th>
                        <th><small>Pay By</small></th>
                        <th><small>Type</small></th>
                        <th><small>C. / R.</small></th>
                        <th><small>Cont. #</small></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $total_charge = 0;
                    $total_refund = 0;
                    $order_balance = [
                        'amount' => 0,
                        'type' => ''
                    ];

                    if(!empty($charge_payment)){

                        $initial_charge_arr = [
                           '1' => 'charge',
                           '2' => 'refund'
                        ];

                        foreach ($charge_payment as $index => $charge){

                            if($charge['status'] == '1'){

                                if($charge['type'] == '1'){

                                    $total_charge += $charge['amount'];

                                }else if($charge['type'] == '2'){

                                    $total_refund += $charge['amount'];
                                }

                            }else{

                                if($charge['button_isset'] == '1'){
                                    $order_balance['amount'] = $charge['amount'];
                                    $order_balance['type'] = $charge['type'];
                                }
                            }

                            if($initial_charge_arr[$charge['type']] != 'refund'){
                                $butt_class = 'btn-login-orange';

                            }else{
                                $butt_class = 'refound_butt_class';
                            }

                            $pay_history_class = ($charge['type'] == 2)?'error_class':'';
                            $fin_card_num = explode(',', $charge['card_number']);

                            if(count($fin_card_num) > 1){

                                foreach($fin_card_num as $index => $single){
                                    $fin_card_num[$index] = (is_numeric ($single))?'***'.substr($single,-4,4):$single;
                                }
                            }else{

                                $fin_card_num[0] = (is_numeric ($fin_card_num[0]))?'***'.substr($fin_card_num[0],-4,4):$fin_card_num[0];
                            }

                            $fin_card_num = implode('<br>', $fin_card_num);

                            $butt_name = ($charge['amount'] == 0)?'Close':ucfirst($initial_charge_arr[$charge['type']]);

                            ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td>
                                <span><?php echo $charge['date'];?></span>
                            </td>
                            <td><?php echo $fin_card_num; ?></td>
                            <td>
                                <span><?php echo $charge['type_name']?></span>
                                <span><?php echo ucfirst  ($initial_charge_arr[$charge['type']]); ?></span>
                            </td>
                            <td>
                                <span class="<?php echo $pay_history_class; ?>"><?php echo $charge['amount']?></span>
                            </td>
                            <td><?php echo (!empty($charge['button_isset']))?'<button type="button" class="btn btn-default  '.$butt_class.' adm-btn payment_history_butt"  data-id="'.$charge['id'].'">'.$butt_name.'</button>':str_replace(',','<br>',$charge['charge_id']); ?></td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>

                <div class="charge-payment-history">
                    <div id="create_invoice_div" class="dis_none">
                        <div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>
                    </div>
                    <div class="col-md-4 inv_link invoice_link">
                        <?php
                        if(!empty($invoices_link)){
                        ?>
                        <table>
                            <tr>
                                <th colspan="3">Invoices</th>
                            </tr>
                            <?php
                            foreach($invoices_link as $single){ ?>
                                <tr>
                                    <td><?php echo $single['name'];?></td>
                                    <td><a href="<?php echo $single['url']?> " target="_blank">View</a></td>
                                    <td><button type="button" data_type="<?php echo $single['name']; ?>" class="btn btn-default create_inv">Create</button></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <?php } ?>
                    </div>
                   <div class="col-md-3 cr_invoice padding-right-0">
                        <div class="">
                            <?php

                            if(!empty($invoices)){

                                foreach ($invoices as $single){ ?>
                                    <div class="image_div price_page_image invoice_pdf_div">
                                        <img class='delivery_time invoice_img'
                                             data_id='<?php echo $single['id'];?>'
                                             src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                       <a href="<?php echo base_url('admin/order/invoice_file/' . $order_info['id'] . '/' .$single['pdf_file']); ?>"
                                   target="_blank">
                                           <img class="main_img"
                                                            src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                    <span><?php echo $single['type'];?></span>
                                   <span><?php echo $single['creation_date'];?></span>
                                    </div>

                                <?php } } ?>
                        </div>
                    </div>

                    <div class="col-md-2 padding-left-0 text-center history-total">
                        <div class="order-balance">
                            <span class="form-small-font">Order Balance</span><br>
                            <span class="red-text large"><?php echo ($order_balance['type']==2)?'<span class="text-red">- $ '.$order_balance['amount'].'</span>':'<span>$ '.$order_balance['amount'].'</span>'; ?></span>
                        </div>
                    </div>
                    <div class="col-md-3 padding-left-0 history-total">
                        <div class="light-block">
                            <label for="" class="col-sm-7 control-label form-small-font padding-right-0 padding-left-0">Total Charge :</label>
                            <div class="col-sm-5 mob-input form-small-font padding-left-0 padding-right-0"><?php echo '<span>$ '.$total_charge.'</span>'?></div>
                        </div>
                        <div class="light-block">
                            <label for="" class="col-sm-7 control-label form-small-font padding-right-0 padding-left-0">Total Refund :</label>
                            <div class="col-sm-5 mob-input form-small-font padding-left-0 padding-right-0"><span class="red-text"><?php echo '<span class="text-red"> - $ '.$total_refund.'</span>'?></span></div>
                        </div>
                        <div class="light-block">
                            <label for="" class="col-sm-7 control-label form-small-font padding-right-0 padding-left-0">Actual Charged:</label>
                            <div class="col-sm-5 mob-input form-small-font padding-left-0 padding-right-0"><?php echo '<span>$ '.floatval($total_charge - $total_refund).'</span>'?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="small">Admin Credit :</p>
                    <?php
                    if(!empty($order_credits)){
                        foreach($order_credits as $single_credit){
                            ?>
                            <div class="admin_credit_div">
                                <table>
                                    <tr>
                                        <td><p class="small red-text">Date : <?php echo date('M-d-Y', strtotime($single_credit['date'])); ?></p></td>
                                        <td rowspan="2"><span class="red-text"><?php echo '$ '.$single_credit['amount']; ?>&nbsp&nbsp</span><span class="rounded-x delete_admin_credit" data-id="<?php echo $single_credit['id']; ?>">X</span></td>
                                    </tr>
                                    <tr>
                                        <td><p class="small">Reason : <?php echo '&nbsp&nbsp'.$single_credit['reason']; ?></p></td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title">Cost</h3>
            </div>
            <?php
                $titles = [
                    'estimate'   => 'Estimate',
                    'initial'    => 'Initial',
                    'adjust_1'   => 'adjust #1',
                    'adjust_2'   => 'adjust #2',
                    'final'      => 'Final C & R'
                ];
            ?>
            <div class="panel-body">
                <?php
                if(!empty($button_isset)){
                    ?>
                    <button type="button" class="btn btn-default btn-login-orange adm-btn" id="submit_billing_form" data-type="<?php echo $button_isset; ?>">Submit <?php echo $titles[$button_isset]; ?></button>
                    <?php
                }?>
                <form method="post" class="form-horizontal search-data-form estimate-table billing-form" id="billing_info_form">
                    <ul class="designed-ul-like-table">
                        <li><p>Total</p></li>
                        <li><span>Billing Item</span></li>
                        <li><span>Shipping Fee</span></li>
                        <li><span>Pickup Fee</span></li>
                        <li><span>Process Fee</span></li>
                        <li><span>Insurance Fee</span></li>
                        <li><span>Special Handling</span></li>
                        <li><span>Over size Fee</span></li>
                        <li><span>Remote Area fee</span></li>
                        <li><span class="error_class">Promotion Code</span></li>
                        <li><span class="error_class">Admin Discount (-$)</span></li>
                        <li><span class="error_class">Account Credit (-$)</span></li>
                        <li><span>Order Cancel Fee</span></li>
                        <li><span>Address Change</span></li>
                        <li><span>Shipment Holding</span></li>
                        <li><span>Label Delivery Fee</span></li>
                        <li><span>Tax and Duty</span></li>
                        <li><span>Other Fee</span></li>
                    </ul>
                        <?php

                            foreach($billing_table as $index => $single){

                                $promo = 0;

                                $sum = floatval($single['shipping_fee'])
                                    +floatval($single['pickup_fee'])
                                    +floatval($single['process_fee'])
                                    +floatval($single['special_handling'])
                                    +floatval($single['insurance_fee'])
                                    +floatval($single['oversize_fee'])
                                    +floatval($single['remote_area_fee'])
                                    -floatval($single['admin_discount'])
                                    -floatval($single['account_credit'])
                                    +floatval($single['cancel_fee'])
                                    +floatval($single['address_change_fee'])
                                    +floatval($single['shipment_holding'])
                                    +floatval($single['label_delivery_fee'])
                                    +floatval($single['tax_fee'])
                                    +floatval($single['other_fee']);

                                if(!empty($single['promotion_type']) && $single['promotion_type'] == '1'){

                                    $promo = $sum*floatval($single['promotion_code'])/100;
                                    $sum = $sum - $promo;

                                }else{
                                    $promo = $single['promotion_code'];
                                    $sum = $sum - $single['promotion_code'];
                                }

                                if(empty($single['status'])) {
                                    ?>
                                    <ul>
                                        <li><p><?php show_price($sum,'$'); ?></p></li>
                                        <li><span><?php echo $titles[$single['type']]; ?></span></li>
                                        <li><span><?php show_price($single['shipping_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['pickup_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['process_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['insurance_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['special_handling'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['oversize_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['remote_area_fee'], '$'); ?></span></li>
                                        <li><span class="error_class"><?php show_price($promo, '$'); ?></span></li>
                                        <li><span class="error_class"><?php show_price($single['admin_discount'], '$'); ?></span></li>
                                        <li><span class="error_class"><?php show_price($single['account_credit'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['cancel_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['address_change_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['shipment_holding'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['label_delivery_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['tax_fee'], '$'); ?></span></li>
                                        <li><span><?php show_price($single['other_fee'], '$'); ?></span></li>
                                    </ul>
                                    <?php
                                }elseif ($single['status'] == '1'){

                                    $class_array = [
                                        'final'    => 'final_input',
                                        'adjust_1' => 'adjust_remove_input',
                                        'adjust_2' => 'adjust_remove_input'
                                    ];

                                    $class = '';

                                    if(!empty($class_array[$single['type']])){
                                        $class = $class_array[$single['type']];
                                    }

                                    ?>
                                    <ul id="billing_editable_ul" class="<?php echo $class; ?>">
                                        <li><p><?php show_price($sum,'$'); ?></p></li>
                                        <li><span><?php echo $titles[$single['type']]; ?></span></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_shipping_fee" class="form-control display-inline" type="text" value="<?php show_price($single['shipping_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_pickup_fee" class="form-control display-inline" type="text" value="<?php show_price($single['pickup_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_process_fee" class="form-control display-inline" type="text" value="<?php show_price($single['process_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_insurance_fee" class="form-control display-inline" type="text" value="<?php show_price($single['insurance_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_special_handling" class="form-control display-inline" type="text" value="<?php show_price($single['special_handling']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_oversize_fee" class="form-control display-inline" type="text" value="<?php show_price($single['oversize_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_remote_area_fee" class="form-control display-inline" type="text" value="<?php show_price($single['remote_area_fee']); ?>"></li>
                                        <li>
                                            <input disabled name="<?php echo $single['type'];?>_promotion_code" class="form-control display-inline" type="text" value="<?php show_price($promo); ?>">
                                            <input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_promotion_code" class="form-control display-inline" type="hidden" value="<?php show_price($single['promotion_code']); ?>">
                                            <input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_promotion_type" class="form-control display-inline" type="hidden" value="<?php show_price($single['promotion_type']); ?>">
                                        </li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_admin_discount" class="form-control display-inline" type="text" value="<?php show_price($single['admin_discount']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_account_credit" class="form-control display-inline" type="text" value="<?php show_price($single['account_credit']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_cancel_fee" class="form-control display-inline" type="text" value="<?php show_price($single['cancel_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_address_change_fee" class="form-control display-inline" type="text" value="<?php show_price($single['address_change_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_shipment_holding" class="form-control display-inline" type="text" value="<?php show_price($single['shipment_holding']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_label_delivery_fee" class="form-control display-inline" type="text" value="<?php show_price($single['label_delivery_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_tax_fee" class="form-control display-inline" type="text" value="<?php show_price($single['tax_fee']); ?>"></li>
                                        <li><input data-type="<?php echo $single['type'];?>" name="<?php echo $single['type'];?>_other_fee" class="form-control display-inline" type="text" value="<?php show_price($single['other_fee']); ?>"></li>
                                    </ul>
                                    <?php
                                }
                            }
                        ?>
                </form>
            </div>
        </div>


    </div>
    <?php
    if(!empty($final_billing_info)){ ?>
    <div class="col-md-12">
        <div class="panel panel-default designed-panel panel-bordered light no-margin">
            <div class="panel-table-title">
                <h3 class="panel-title">Final Billing Information</h3>
                <div class="text-right pull-right final-billing-title">
                    <div class="display-inline">Service : <span class="orange-color"><?php echo $final_billing_info['order_info']['currier_name'].' '.change_order_type($final_billing_info['order_info']['send_type'], $final_billing_info['order_info']['currier_name'], $final_billing_info['order_info']['shipping_type']); ?></span></div>
                    <div class="display-inline">Without Sig : <?php echo (!empty($final_billing_info['delivery_info']['without_signature']))?'<span class="green-text">YES</span>':'<span class="red-text">NO</span>'; ?></div>
                    <div class="display-inline">Total Ins : <span class="orange-color"><?php echo '$ '.$final_billing_info['totals']['total_insurance']; ?></span></div>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal search-data-form estimate-table" id="final_billing_table">
                    <table class="table table-bordered designed-table">
                        <thead>
                        <tr>
                            <th><small>#</small></th>
                            <th><small>Luggage Type</small></th>
                            <th><small>Label</small></th>
                            <th><small>Insurance</small></th>
                            <th><small>Tracking #</small></th>
                            <th><small>Actual W.</small></th>
                            <th><small>Actual Size</small></th>
                            <th><small>Billing W.</small></th>
                            <th><small>Cost</small></th>
                          <!--  <th><small>Special Handing</small></th>-->
                            <th><small>Add L. Fee</small></th>
                            <th><small>Lost</small></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $total_add_fee = 0;
                        $total_luggage_weight = 0;
                        $origin_charge_weight = 0;

                        foreach ($final_billing_info['luggage'] as $index => $luggages){

                            if(fmod($luggages['lug_weight'],1) == 0){
                                $luggages['lug_weight'] = intval($luggages['lug_weight']);
                            }else{
                                $luggages['lug_weight'] = number_format($luggages['lug_weight'],2);
                            }

                            if(fmod($luggages['width'],1)== 0){
                                $luggages['width'] = intval($luggages['width']);
                            }else{
                                $luggages['width'] = number_format($luggages['width'],2);
                            }

                            if(fmod($luggages['length'],1)== 0){
                                $luggages['length'] = intval($luggages['length']);
                            }else{
                                $luggages['length'] = number_format($luggages['length'],2);
                            }

                            if(fmod($luggages['height'],1)== 0){
                                $luggages['height'] = intval($luggages['height']);
                            }else{
                                $luggages['height'] = number_format($luggages['height'],2);
                            }

                            $single_total_add_fee = $luggages['special_handling_editable'] + $luggages['oversize_fee'] + $luggages['remote_area_fee'] + $luggages['address_change_fee'] + $luggages['shipment_holding_fee'] + $luggages['tax_duty_fee'] + $luggages['other_fee'];
                            $total_add_fee += $single_total_add_fee;

                            $total_luggage_weight +=  $luggages['label_weight'];
                            $origin_charge_weight += $luggages['origin_charge_weight'];
                            $luggage_actual_size_weight = ceil($luggages['actual_width']* $luggages['actual_length']*$luggages['actual_height']/139);

                            ?>
                            <tr>
                                <td><?php echo $index +1; ?><input type="hidden" name="billing_luggage_id[]" value="<?php echo $luggages['lug_id']?>"></td>
                                <td>
                                    <?php echo $luggages['lug_name']; ?><br>
                                    <span class="small_font_size"><?php echo $luggages['lug_weight'].'lbs '.'('.$luggages['width'].'-'.$luggages['length'].'-'.$luggages['height'].')'; ?></span>
                                </td>
                                <td><span class="small_font_size"><?php echo $luggages['label_weight'].'lbs '.'('.$luggages['label_width'].'-'.$luggages['label_length'].'-'.$luggages['label_height'].')'; ?></td>
                                <td><?php show_price($luggages['insurance'],'$'); ?></td>
                                <td><?php echo $luggages['tracking_number']; ?></td>
                                <td>
                                    <input type="text" name="actual_weight[<?php echo $luggages['lug_id']; ?>]" class="form-control" value="<?php echo $luggages['actual_weight'];?>">
                                </td>
                                <td>
                                    <input type="text" name="actual_width[<?php echo $luggages['lug_id']; ?>]" class="form-control display-inline small-input" value="<?php echo $luggages['actual_width'];?>">
                                    <input type="text" name="actual_length[<?php echo $luggages['lug_id']; ?>]" class="form-control display-inline small-input" value="<?php echo $luggages['actual_length'];?>">
                                    <input type="text" name="actual_height[<?php echo $luggages['lug_id']; ?>]" class="form-control display-inline small-input" value="<?php echo $luggages['actual_height'];?>">
                                    <span class="display-inline"><?php echo $luggage_actual_size_weight; ?> lb</span>
                                </td>
                                <td><?php echo $luggages['charge_weight'];?> lb</td>
                                <td>
                                    <input type="text" name="costs[<?php echo $luggages['lug_id']; ?>]" class="form-control small-input" value="<?php echo $luggages['cost']; ?>">
                                </td>
                                <td class="last-element">
                                   <span class="final_billing_info" data_number="<?php echo $index+1;?>" data_order="<?php echo$luggages['real_id'];?>" data_luggage="<?php echo$luggages['lug_id'];?>"><?php echo '$ '.$single_total_add_fee;?></span>
                                </td>
                                <td>
                                    <input type="checkbox" name="lost[]" value="<?php echo $luggages['lug_id']?>">
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="5">Final Total: <span><?php echo $total_luggage_weight;?>lbs / <?php echo $origin_charge_weight;?> lbs</span></td>
                            <td colspan="2" ><span><?php echo $final_billing_info['totals']['total_actual_weight'];?>lbs</span></td>
                            <td colspan="1">
                                <span ><?php echo $final_billing_info['totals']['total_billing_weight'];?> lbs</span>
                            </td>
                            <td colspan="1">
                                <span><?php echo '$ '.$final_billing_info['totals']['total_cost'];?></span>
                            </td>
                            <td><?php echo '$ '.$total_add_fee; ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="info_final_billing">
                        <table class="info_final_billing_table">
                            <tr>
                                <td><span>Special Handing</span> <span><?php  echo '$ '.$final_billing_info['totals']['total_handling']; ?></span></td>
                                <td><span>Oversize Fee</span> <span><?php     echo '$ '.$final_billing_info['totals']['total_oversize']; ?></span></td>
                                <td><span>Remote Area Fee</span> <span><?php  echo '$ '.$final_billing_info['totals']['total_remote_area']; ?></span></td>
                                <td><span>Address Change</span> <span><?php   echo '$ '.$final_billing_info['totals']['total_address_change']; ?></span></td>
                                <td><span>Shipment Holding</span> <span><?php echo '$ '.$final_billing_info['totals']['total_shipment_holding']; ?></span></td>
                                <td><span>Tax and Duty</span> <span><?php     echo '$ '.$final_billing_info['totals']['total_tax_and_duty']; ?></span></td>
                                <td><span>Other Fee</span> <span><?php        echo '$ '.$final_billing_info['totals']['total_other']; ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-9 text-right margin-top-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="light-block">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label form-small-font no-padding"><strong>From : </strong></label>
                                        <div class="col-sm-9 form-small-font padding-right-0 text-left"><?php echo $final_billing_info['from']['State'].' ('.$final_billing_info['pickup_info']['pickup_postal_code'].')'?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="light-block">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label form-small-font no-padding"><strong>To : </strong></label>
                                        <div class="col-sm-9 form-small-font padding-right-0 text-left"><?php echo $final_billing_info['to']['State'].' ('.$final_billing_info['delivery_info']['delivery_postal_code'].')'?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="light-block">
                                    <div class="form-group">
                                        <label for="" class="col-sm-5 control-label form-small-font no-padding"><strong>Promotion : </strong></label>
                                        <div class="col-sm-7 form-small-font padding-right-0 text-left"><?php
                                            if(!empty($final_billing_info['promotion'])){

                                                if(!empty($final_billing_info['promotion']['amount_d'])){
                                                    $amount = '$ '.$final_billing_info['promotion']['amount_d'];
                                                }else{
                                                    $amount = $final_billing_info['promotion']['amount_p'].' %';
                                                }

                                                echo $final_billing_info['promotion']['desc'].' ('.$amount.')';
                                            }
                                            ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-right margin-top-12">
                        <button type="button" class="btn btn-default btn-login-orange adm-btn save-last-btn" id="final_billing_info_save">Save</button>
                        <button type="button" class="btn btn-default btn-login-blue adm-btn update_final_shiping_fee">Update Shipping Fee</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php } ?>
</div>

<div class="modal fade final_billing_modal" role="dialog">
    <div class="modal-dialog" >
        <!-- Modal content-->
        <div class="modal-content" id="final_billing_answer">
        </div>

    </div>
</div>
<input type="hidden" id="billing_auto_complete_array" value='<?php echo (!empty($auto_complete_array))?json_encode($auto_complete_array):'false';?>'>















