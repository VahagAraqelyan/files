<html lang="en">
<?php
$this->load->view('frontend/head');
$cancel = false;
if($order_info['shipping_status'] == PROCESSED_CANCEL_STATUS[0] || $order_info['shipping_status'] == SUBMITTED_CANCEL_STATUS[0]){
    $cancel = true;
}
?>
<body>
<div class="invoice_div">
    <div id="invoice_header">
        <div class="logo">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAL8AAABeCAYAAABy8sUhAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mzk2NUJFMEU0RjUzMTFFN0EwNjRDMDEzODdENEYxMDgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mzk2NUJFMEQ0RjUzMTFFN0EwNjRDMDEzODdENEYxMDgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MjUxMTQ3NDdFMUFFMTFFNkI3ODI4QTE5MjE2MENFNzMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MjUxMTQ3NDhFMUFFMTFFNkI3ODI4QTE5MjE2MENFNzMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5T2/rfAAAcWElEQVR42uxd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">
        </div>
        <div class="address">
            <ul>
                <li>228 E. 45 th Street, Ground Floor</li>
                <li>New York, NY 10017, USA</li>
                <li>1-800- 678-6167</li>
                <li><a href="<?php echo base_url(); ?>"><?php echo base_url(); ?></a></li>
            </ul>
        </div>
        <div class="title">
            <h3><?php echo $title; ?></h3>
        </div>
    </div>
    <?php if(strtolower($type) == 'initial'){ ?>

        <div class="remark">
            <p>
                *Please be advised the invoice amount is based on the service you requested. If additional service is added or certain service is cancelled during the
                shipment, we will adjust the total amount correspondingly, and provide the finial invoice after the carrier provides us the shipment details.
            </p>
        </div>

    <?php } ?>
    <div class="title_div">
        <h4 class="invoice_blue_title">Order Summary</h4>
        <ul class="my-float-right">
            <li>From: <?php echo $sender_info['pickup_city'].' '.$from_country['country']?></li>
            <li>To: <?php echo $receiver_info['delivery_city'].' '.$to_country['country']?></li>
            <li>Service: <?php echo $order_info['currier_name'].' '.change_order_type($order_info['send_type'],$order_info['currier_name'],$order_info['shipping_type']); ?></li>
        </ul>
        <ul class="my-float-left">
            <li><b>Order Number: <?php echo $order_info['order_id']; ?></b></li>
            <li>Order Date: <?php echo date('M-d-Y', strtotime($order_info['created_date'])); ?></li>
            <li>Customer: <?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></li>
        </ul>
        <br class="clear-both">
    </div>
    <?php if($cancel){
        ?>
        <div class="invoice_table">
            <table>
                <tr>
                    <th>#</th>
                    <th>Package Type</th>
                    <th>Max. Weight <br> (lb.)</th>
                    <th>Max. Size <br> (inch)</th>
                    <th>Remark</th>
                </tr>
                <?php
                $first = true;

                foreach($luggage_billing_info['luggage'] as $index => $single_luggage){
                    $rowspan = '';
                    if($first){
                        $rowspan = 'rowspan="'.count($luggage_billing_info['luggage']).'"';
                    }
                    ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td><?php echo $single_luggage['luggage_name']; ?></td>
                        <td><?php echo modify_number($single_luggage['lug_weight']); ?></td>
                        <td><?php echo modify_number($single_luggage['width']).'-'.modify_number($single_luggage['length']).'-'.modify_number($single_luggage['height']); ?></td>
                        <?php if($first) { ?>
                            <td <?php echo $rowspan; ?>>
                                <p class="remark">
                                    Your order has been <br> cancelled successfully.
                                </p>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $first = false;
                }
                ?>
            </table>
        </div>
        <?php
        foreach($billing_history as $index => $single) {

            if ($single['type'] == 'adjust_1' || $single['type'] == 'adjust_2' || $single['type'] == 'estimate') {
                continue;
            }

            if($single['type'] == 'initial'){
                continue;
            }

            if($single['type'] == 'initial'){
                $title_text = 'Initial Breakdown';
            }else{
                $title_text = 'Final Adjustment';
            }

            $promo_text = [
                'size' => '0%',
                'amount' => '$ 0.00'
            ];

            $sum = floatval($single['shipping_fee'])
                + floatval($single['pickup_fee'])
                + floatval($single['process_fee'])
                + floatval($single['insurance_fee'])
                + floatval($single['special_handling'])
                + floatval($single['oversize_fee'])
                + floatval($single['remote_area_fee'])
                - floatval($single['admin_discount'])
                - floatval($single['account_credit'])
                + floatval($single['cancel_fee'])
                + floatval($single['address_change_fee'])
                + floatval($single['shipment_holding'])
                + floatval($single['label_delivery_fee'])
                + floatval($single['tax_fee'])
                + floatval($single['other_fee']);

            if (!empty($single['promotion_type']) && $single['promotion_type'] == '1') {

                $promo = $sum * floatval($single['promotion_code']) / 100;
                $sum = $sum - $promo;
                $promo_text['size'] = $single['promotion_code'] . ' %';
                $promo_text['amount'] = '$ ' . number_format($promo, '2');
                $single['promotion_code'] = $promo;

            } else {

                $sum = $sum - $single['promotion_code'];
                $promo_text['size'] = '$ ' . $single['promotion_code'];
                $promo_text['amount'] = '$ ' . $single['promotion_code'];
            }

            $sum = number_format($sum, '2');

            ?>
            <div class="title_div">
                <h4 class="invoice_blue_title"><?php echo $title_text; ?></h4>
            </div>
            <div class="invoice_table no_padding">
                <table>
                    <?php
                    $billing_array_temp = $billing_info;
                    unset($billing_array_temp['id']);
                    unset($billing_array_temp['order_id']);
                    unset($billing_array_temp['user_id']);
                    unset($billing_array_temp['type']);
                    unset($billing_array_temp['update_date']);
                    unset($billing_array_temp['status']);
                    unset($billing_array_temp['promotion_type']);

                    foreach($billing_array_temp as $title => $value){

                        if($value <= 0){
                            continue;
                        }

                        $title = str_replace('_', ' ', $title);
                        $title = ucwords($title);
                        ?>
                        <tr>
                            <td style="text-align:left;"><?php echo $title; ?></td>
                            <td><?php echo '$ '.modify_number($value); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align:right; border:0;"><b>Final Total:</b></td>
                        <td style="border:0;"><b>$ <?php echo modify_number($sum); ?></b></td>
                    </tr>
                </table>
            </div>
            <?php
        }
        ?>
        <div class="title_div">
            <h4 class="invoice_blue_title" >Payment/Refund Records</h4>
        </div>
        <div class="invoice_table no_padding">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Card #</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $total_refaund = 0;
                $total_charge  = 0;
                if(!empty($payment_history)){

                    foreach ($payment_history as $index => $pay_info){

                        if($pay_info['amount'] <= 0){
                            continue;
                        }

                        if($pay_info['type'] == '1'){

                            $total_charge += $pay_info['amount'];
                            $charge = true;

                        }else{

                            $total_refaund += $pay_info['amount'];
                            $charge = false;
                        }

                        if(preg_match('/^[0-9]*$/', $pay_info['card_number'])){

                            $card_num = '********'.substr($pay_info['card_number'],-4,4);
                        }else{

                            $card_num = $pay_info['card_number'];
                        }

                        $type_text = (empty($pay_info['type_name']))?'Initial':ucwords(str_ireplace('_',' ', $pay_info['type_name']));

                        if($pay_info['type'] == '1'){
                            $type_text.=' Charge';
                        }else{
                            $type_text.=' Refound';
                        }

                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $pay_info['date']; ?></td>
                            <td><?php echo $card_num; ?></td>
                            <td><?php echo $type_text; ?></td>
                            <td><?php echo ($charge)?'$'.modify_number($pay_info['amount']):'<span class="orange-color">($'.modify_number($pay_info['amount']).')</span>'; ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Charge :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_charge); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Refund :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_refaund); ?></b></td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    if(strtolower($type) == 'initial' && $cancel == false){  // INITIAL ?>
        <div class="invoice_table">
            <table>
                <tr>
                    <th>#</th>
                    <th>Package Type</th>
                    <th>Max. Weight <br> (lb.)</th>
                    <th>Max. Size <br> (inch)</th>
                    <th>Remark</th>
                </tr>
                <?php

                $first = true;

                foreach($luggage_billing_info['luggage'] as $index => $single_luggage){
                    $rowspan = '';
                    if($first){
                        $rowspan = 'rowspan="'.count($luggage_billing_info['luggage']).'"';
                    }
                    ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td><?php echo $single_luggage['luggage_name']; ?></td>
                        <td><?php echo modify_number($single_luggage['lug_weight']); ?></td>
                        <td><?php echo modify_number($single_luggage['width']).'-'.modify_number($single_luggage['length']).'-'.modify_number($single_luggage['height']); ?></td>
                        <?php if($first) { ?>
                            <td <?php echo $rowspan; ?>>
                                <p class="remark">
                                    Please do not over pack your package and exceed the<br>
                                    max. weight and max. size of each item. We will<br>
                                    charge additional shipping fee if your package is<br>
                                    oversize or overweight.
                                </p>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $first = false;
                }
                ?>
            </table>
        </div>
        <div class="title_div">
            <h4 class="invoice_blue_title" >Order Breakdown</h4>
        </div>
        <div class="invoice_table no_padding">
            <table>
                <?php

                $billing_array_temp = $billing_info;

                $billing_array_temp['shipping_fee'] += $billing_array_temp['process_fee'] + $billing_array_temp['special_handling'];

                unset($billing_array_temp['id']);
                unset($billing_array_temp['order_id']);
                unset($billing_array_temp['user_id']);
                unset($billing_array_temp['type']);
                unset($billing_array_temp['update_date']);
                unset($billing_array_temp['status']);
                unset($billing_array_temp['promotion_code']);
                unset($billing_array_temp['insurance_fee']);
                unset($billing_array_temp['account_credit']);
                unset($billing_array_temp['promotion_type']);
                unset($billing_array_temp['process_fee']);
                unset($billing_array_temp['special_handling']);
                unset($billing_array_temp['admin_discount']);

                foreach($billing_array_temp as $title => $value){

                    if($value <= 0){
                        continue;
                    }

                    $title = str_replace('_', ' ', $title);
                    $title = ucwords($title);
                    ?>
                    <tr>
                        <td style="text-align:left;"><?php echo $title; ?></td>
                        <td><?php echo '$ '.modify_number($value); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td style="text-align:left;">Insurance Fee (up to $ <?php echo modify_number($insurance['total_insurance']); ?> coverage for the shipment)</td>
                    <td>$ <?php echo modify_number($billing_info['insurance_fee']); ?></td>
                </tr>
                <?php if($billing_info['promotion_code'] > 0) {?>
                    <tr>
                        <td style="text-align:right;">Promotion Code (<?php echo $promo_text_billing['size']; ?> off)</td>
                        <td>- <?php echo $promo_text_billing['amount']; ?></td>
                    </tr>
                <?php }
                if($billing_info['admin_discount'] > 0) {?>
                    <tr>
                        <td style="text-align:right;">Admin discount</td>
                        <td><?php echo '- $ '.modify_number($billing_info['admin_discount']); ?></td>
                    </tr>
                <?php }
                if($billing_info['account_credit'] > 0) {?>
                    <tr>
                        <td style="text-align:right;">Account Credits </td>
                        <td>- <?php echo '$ '.modify_number($billing_info['account_credit']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align:right; border:0;"><b>Initial:</b></td><td style="border:0;"><b>$ <?php echo modify_number($shipping_fee); ?></b></td>
                </tr>
            </table>
        </div>
        <div class="title_div">
            <h4 class="invoice_blue_title" >Payment/Refund Records</h4>
        </div>
        <div class="invoice_table no_padding">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Card #</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $total_refaund = 0;
                $total_charge  = 0;
                if(!empty($payment_history)){

                    foreach ($payment_history as $index => $pay_info){

                        if(empty($pay_info['type_name'])){
                            $pay_info['type_name'] = 'initial';
                        }

                        if($pay_info['type_name'] != 'initial'){
                            continue;
                        }

                        if($pay_info['type'] == '1'){

                            $total_charge += $pay_info['amount'];
                            $charge = true;

                        }else{

                            $total_refaund += $pay_info['amount'];
                            $charge = false;
                        }

                        if(preg_match('/^[0-9]*$/', $pay_info['card_number'])){

                            $card_num = '********'.substr($pay_info['card_number'],-4,4);
                        }else{

                            $card_num = $pay_info['card_number'];
                        }

                        $type_text = ucwords(str_ireplace('_',' ', $pay_info['type_name']));

                        if($pay_info['type'] == '1'){
                            $type_text.=' Charge';
                        }else{
                            $type_text.=' Refound';
                        }

                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $pay_info['date']; ?></td>
                            <td><?php echo $card_num; ?></td>
                            <td><?php echo $type_text; ?></td>
                            <td><?php echo ($charge)?'$'.modify_number($pay_info['amount']):'<span class="orange-color">($'.modify_number($pay_info['amount']).')</span>'; ?></td>
                        </tr>

                    <?php }

                    ?>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Charge :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_charge); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Refund :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_refaund); ?></b></td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
        </div>
        <div class="invoice_table orange-color text-center">
            <p>
                Thank you very much for your business! If you have any question, please call us at 1-800- 678-6167.<br>
                By submitting order, you accepted Luggage To Ship services terms and conditions.
            </p>
        </div>
    <?php } // END OF INITIAL

    if(strtolower($type) == 'final' && $cancel == false){

        if($weight_difference){ ?>
            <div class="invoice_table">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Package Type<br>Tracking Number</th>
                        <th>Max. Weight (lb.) <br> Max. Size (inch)</th>
                        <th>Final Actual Weight (lb.) <br> Finial Size (inch)</th>
                        <th>Weight Difference <br> (lbs.) </th>
                    </tr>
                    <?php
                    $sum_weight_difference = 0;
                    foreach($luggage_billing_info['luggage'] as $index => $single_luggage){

                        $weight_difference = $single_luggage['charge_weight'] - $single_luggage['lug_weight'];

                        if($weight_difference < 0){
                            $weight_difference = 0;
                        }

                        $sum_weight_difference += $weight_difference;

                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $single_luggage['luggage_name'].'<br>'.$single_luggage['tracking_number']; ?></td>
                            <td><?php echo modify_number($single_luggage['lug_weight']).'<br>'.modify_number($single_luggage['width']).'-'.modify_number($single_luggage['length']).'-'.modify_number($single_luggage['height']); ?></td>
                            <td><?php echo modify_number($single_luggage['actual_weight']).'<br>'.modify_number($single_luggage['actual_width']).'-'.modify_number($single_luggage['actual_length']).'-'.modify_number($single_luggage['actual_height']); ?></td>
                            <td><?php echo modify_number($weight_difference); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <span class="my-float-right"><b>Weight Difference: <?php echo $sum_weight_difference; ?> lbs</b></span>
                <div class="invoice_italic_text">
                    <p>*The weight we used to calculate the shipping fee will be the bigger one of the actual weight and dimensional weight of your package. The dimensional weight (lb.) formula is Length * Width * Height (inch) / 139.</p>
                </div>
            </div>
            <?php

            foreach($billing_history as $index => $single){
                if($single['type'] != 'initial'){
                    continue;
                }

                $promo_text = [
                    'size' => '0%',
                    'amount' => '$ 0.00'
                ];

                $sum = floatval($single['shipping_fee'])
                    + floatval($single['pickup_fee'])
                    + floatval($single['process_fee'])
                    + floatval($single['insurance_fee'])
                    + floatval($single['special_handling'])
                    + floatval($single['oversize_fee'])
                    + floatval($single['remote_area_fee'])
                    - floatval($single['admin_discount'])
                    - floatval($single['account_credit'])
                    + floatval($single['cancel_fee'])
                    + floatval($single['address_change_fee'])
                    + floatval($single['shipment_holding'])
                    + floatval($single['label_delivery_fee'])
                    + floatval($single['tax_fee'])
                    + floatval($single['other_fee']);

                if(!empty($single['promotion_type']) && $single['promotion_type'] == '1'){

                    $promo = $sum*floatval($single['promotion_code'])/100;
                    $sum = $sum - $promo;
                    $promo_text['size']   = $single['promotion_code'].' %';
                    $promo_text['amount'] = '$ '.number_format($promo, '2');
                    $single['promotion_code'] = $promo;

                }else{

                    $sum = $sum - $single['promotion_code'];
                    $promo_text['size']   = '$ '.$single['promotion_code'];
                    $promo_text['amount'] = '$ '.$single['promotion_code'];
                }

                $sum = number_format($sum, '2');

                ?>
                <!-- <div class="title_div">
                        <h4 class="invoice_blue_title" >Initial Breakdown</h4>
                    </div>
                    <div class="invoice_table no_padding">
                        <table>
                            <tr>
                                <td style="text-align:left;">Shipping Fee</td>
                                <td>$ <?php echo modify_number(floatval($sum) - floatval($single['insurance_fee']) - floatval($single['pickup_fee']) + floatval($single['promotion_code']) + floatval($single['account_credit'])); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Pickup Fee</td>
                                <td>$ <?php echo modify_number($single['pickup_fee']); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Insurance Fee (up to $ <?php echo modify_number($insurance['total_insurance']); ?> coverage for the shipment)</td>
                                <td>$ <?php echo modify_number($single['insurance_fee']); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;">Promotion Code (<?php echo $promo_text['size']; ?> off)</td>
                                <td>- <?php echo $promo_text['amount']; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;">Account Credits </td>
                                <td>- <?php echo '$ '.modify_number($single['account_credit']); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right; border:0;"><b>Initial:</b></td><td style="border:0;"><b>$ <?php echo modify_number($sum); ?></b></td>
                            </tr>
                        </table>
                    </div>
                    <?php
            }
            ?>
                -->
            <div class="title_div">
                <h4 class="invoice_blue_title" >Final Breakdown</h4>
            </div>
            <div class="invoice_table no_padding">
                <table>
                    <?php

                    $billing_array_temp = $billing_info;

                    $billing_array_temp['shipping_fee'] += $billing_array_temp['process_fee'] + $billing_array_temp['special_handling'];

                    unset($billing_array_temp['id']);
                    unset($billing_array_temp['order_id']);
                    unset($billing_array_temp['user_id']);
                    unset($billing_array_temp['type']);
                    unset($billing_array_temp['update_date']);
                    unset($billing_array_temp['status']);
                    unset($billing_array_temp['promotion_code']);
                    unset($billing_array_temp['insurance_fee']);
                    unset($billing_array_temp['account_credit']);
                    unset($billing_array_temp['promotion_type']);
                    unset($billing_array_temp['process_fee']);
                    unset($billing_array_temp['special_handling']);
                    unset($billing_array_temp['admin_discount']);

                    foreach($billing_array_temp as $title => $value){

                        if($value <= 0){
                            continue;
                        }

                        $title = str_replace('_', ' ', $title);
                        $title = ucwords($title);
                        ?>
                        <tr>
                            <td style="text-align:left;"><?php echo $title; ?></td>
                            <td><?php echo '$ '.modify_number($value); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align:left;">Insurance Fee (up to $ <?php echo modify_number($insurance['total_insurance']); ?> coverage for the shipment)</td>
                        <td>$ <?php echo modify_number($billing_info['insurance_fee']); ?></td>
                    </tr>
                    <?php if($billing_info['promotion_code'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Promotion Code (<?php echo $promo_text_billing['size']; ?> off)</td>
                            <td>- <?php echo $promo_text_billing['amount']; ?></td>
                        </tr>
                    <?php }
                    if($billing_info['admin_discount'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Admin discount</td>
                            <td><?php echo '- $ '.modify_number($billing_info['admin_discount']); ?></td>
                        </tr>
                    <?php }
                    if($billing_info['account_credit'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Account Credits </td>
                            <td>- <?php echo '$ '.modify_number($billing_info['account_credit']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="text-align:right; border:0;"><b>Final Total:</b></td><td style="border:0;"><b>$ <?php echo modify_number($shipping_fee); ?></b></td>
                    </tr>
                </table>
            </div>
            <?php
        }else{
            ?>
            <div id="final_invoice" class="my-clear-both">
            <div class="invoice_table">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Package Type</th>
                        <th>Max. Weight <br> (lb.)</th>
                        <th>Max. Size <br> (inch)</th>
                        <th>Tracking number</th>
                    </tr>
                    <?php
                    foreach($luggage_billing_info['luggage'] as $index => $single_luggage){
                        ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo $single_luggage['luggage_name']; ?></td>
                            <td><?php echo modify_number($single_luggage['lug_weight']); ?></td>
                            <td><?php echo modify_number($single_luggage['width']).'-'.modify_number($single_luggage['length']).'-'.modify_number($single_luggage['height']); ?></td>
                            <td><?php echo $single_luggage['tracking_number']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <div class="title_div">
                <h4 class="invoice_blue_title" >Order Breakdown</h4>
            </div>
            <div class="invoice_table no_padding">
                <table>
                    <?php

                    $billing_array_temp = $billing_info;

                    $billing_array_temp['shipping_fee'] += $billing_array_temp['process_fee'] + $billing_array_temp['special_handling'];

                    unset($billing_array_temp['id']);
                    unset($billing_array_temp['order_id']);
                    unset($billing_array_temp['user_id']);
                    unset($billing_array_temp['type']);
                    unset($billing_array_temp['update_date']);
                    unset($billing_array_temp['status']);
                    unset($billing_array_temp['promotion_code']);
                    unset($billing_array_temp['insurance_fee']);
                    unset($billing_array_temp['account_credit']);
                    unset($billing_array_temp['promotion_type']);
                    unset($billing_array_temp['process_fee']);
                    unset($billing_array_temp['special_handling']);
                    unset($billing_array_temp['admin_discount']);

                    foreach($billing_array_temp as $title => $value){

                        if($value <= 0){
                            continue;
                        }

                        $title = str_replace('_', ' ', $title);
                        $title = ucwords($title);
                        ?>
                        <tr>
                            <td style="text-align:left;"><?php echo $title; ?></td>
                            <td><?php echo '$ '.modify_number($value); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align:left;">Insurance Fee (up to $ <?php echo modify_number($insurance['total_insurance']); ?> coverage for the shipment)</td>
                        <td>$ <?php echo modify_number($billing_info['insurance_fee']); ?></td>
                    </tr>
                    <?php if($billing_info['promotion_code'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Promotion Code (<?php echo $promo_text_billing['size']; ?> off)</td>
                            <td>- <?php echo $promo_text_billing['amount']; ?></td>
                        </tr>
                    <?php }
                    if($billing_info['admin_discount'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Admin discount</td>
                            <td><?php echo '- $ '.modify_number($billing_info['admin_discount']); ?></td>
                        </tr>
                    <?php }
                    if($billing_info['account_credit'] > 0) {?>
                        <tr>
                            <td style="text-align:right;">Account Credits </td>
                            <td>- <?php echo '$ '.modify_number($billing_info['account_credit']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="text-align:right; border:0;"><b>Final :</b></td><td style="border:0;"><b>$ <?php echo modify_number($shipping_fee); ?></b></td>
                    </tr>
                </table>
            </div>

        <?php } ?>
        <div class="title_div finl_">
            <h4 class="invoice_blue_title " >Payment/Refund Records</h4>
        </div>
        <div class="invoice_table no_padding">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Card #</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $total_refaund = 0;
                $total_charge  = 0;
                if(!empty($payment_history)){

                    foreach ($payment_history as $index => $pay_info){

                        if($pay_info['amount'] <= 0){
                            continue;
                        }

                        if($pay_info['type'] == '1'){

                            $total_charge += $pay_info['amount'];
                            $charge = true;

                        }else{

                            $total_refaund += $pay_info['amount'];
                            $charge = false;
                        }

                        if(preg_match('/^[0-9]*$/', $pay_info['card_number'])){

                            $card_num = '********'.substr($pay_info['card_number'],-4,4);
                        }else{

                            $card_num = $pay_info['card_number'];
                        }

                        $type_text = (empty($pay_info['type_name']))?'Initial':ucwords(str_ireplace('_',' ', $pay_info['type_name']));

                        if($pay_info['type'] == '1'){
                            $type_text.=' Charge';
                        }else{
                            $type_text.=' Refound';
                        }

                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $pay_info['date']; ?></td>
                            <td><?php echo $card_num; ?></td>
                            <td><?php echo $type_text; ?></td>
                            <td><?php echo ($charge)?'$'.modify_number($pay_info['amount']):'<span class="orange-color">($'.modify_number($pay_info['amount']).')</span>'; ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Charge :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_charge); ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right; border:0;"><b>Total Refund :</b></td><td style="border:0;"><b>$ <?php echo modify_number($total_refaund); ?></b></td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
        </div>
        <div class="invoice_table orange-color text-center">
            <p>
                Thank you very much for your business! If you have any question, please call us at 1-800- 678-6167.<br>
                By submitting order, you accepted Luggage To Ship services terms and conditions.
            </p>
        </div>
        </div>

    <?php } ?>
</div>
</body>

</html>