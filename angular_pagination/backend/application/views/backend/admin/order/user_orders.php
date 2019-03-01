<div class="content dashboard">
    <div class="container">
        <div class="panel panel-default designed-panel admin_new_order">
        <div class="panel-heading">
<div class="row">
    <div class="col-md-6">
        <form class="form-inline search-data-form" id="search_promotion_form">
            <input type="hidden" name="order_by" id="order_by_input">
            <input type="hidden" name="order_type" id="order_type_input">
            <select name="shipping_type">
                <option value="all">Select type</option>
                <option value="1" <?php if(!empty($crt['order_shipping.shipping_type']) && $crt['order_shipping.shipping_type'] == 1) { echo 'selected="selected"'; } ?>>International</option>
                <option value="2" <?php if(!empty($crt['order_shipping.shipping_type']) && $crt['order_shipping.shipping_type'] == 2) { echo 'selected="selected"'; } ?>>Domestic</option>
            </select>
            <select name="shipping_status">
                <option value="all">Select status</option>
                <?php
                foreach($status_array as $single){
                    $k = '';
                    if(!empty($crt['order_shipping.shipping_status']) && $crt['order_shipping.shipping_status'] == $single[0]){
                        $k = 'selected="selectid"';
                    }
                    ?>
                    <option value="<?php echo $single[0]; ?>" <?php echo $k; ?>><?php echo $single[1] ?></option>
                    <?php
                }
                ?>
            </select>
            <button type="submit" class="btn btn-default btn-login-orange search_new_order">Search</button>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?php echo base_url('admin/order/user_orders/'.$user['id']); ?>" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
        <ul class="pagination designed-pagination">
            <?php echo  $links; ?>
        </ul>
    </div>
</div>
        </div>
            <div class="panel-table-title">
                <h3 class="panel-title"><?php echo $user['account_name']; ?>: <span><?php echo $all_count; ?></span></h3>

            </div>
<table class="table table-bordered table-hover designed-table">
    <thead>
    <tr>
        <?php
        foreach($table_head as $value => $info){

            if(empty($info['order_type'])){
                ?>
                <th><?php echo $info['title']; ?></th>
                <?php
                continue;
            }

            if(empty($info['active'])){
                ?>
                <th><?php echo $info['title'];?><span class = 'prom_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $info['order_type']; ?>">&#9650;&#9660;</span></th>
                <?php
                continue;
            }

            if($info['order_type'] == 'ASC'){
                $symbol = '&#9660;';
            }else{
                $symbol = '&#9650;';
            }

            ?>
            <th><?php echo $info['title'];?><span class = 'prom_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $info['order_type']; ?>"><?php echo $symbol; ?></span></th>
            <?php
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php

    if(!empty($orders)){

        foreach ($orders as $index => $order){

            $cancel_class = ($order['shipping_status'] == SUBMITTED_CANCEL_STATUS[0] || $order['shipping_status'] == PROCESSED_CANCEL_STATUS[0])?'red-text':"";
            $track_class = (empty($order['tracking']['tracking_number']))?'orange-label':'green-label';
            $label_class = (empty($type_files[$order['real_id']]))?'orange-label':'green-label';
            $label_text = (empty($order['sys_label']))?'Label':'SYS-Label';
            $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
            $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
            $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
            $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";
            $type = change_order_type($order['send_type'],$order['currier_name'],$order['shipping_type']);

            ?>
            <tr>
                <td><?php echo $index+1; ?></td>
                <td>
                    <a href="<?php echo base_url('admin/order/order_detail/').$order['real_id']; ?>">
                        <span><?php echo $order['order_number']; ?></span>
                    </a>
                    <a href="<?php echo base_url('admin/user_manage/user_account/').$order['user_info'][0]['id']?>">
                        <span><?php echo $order['user_info'][0]['first_name']." ".$order['user_info'][0]['last_name']; ?></span>
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
                    <span class="<?php echo $cancel_class; ?> error_class"><?php echo $order['title']; ?></span>
                </td>
                <td>
                    <span><?php echo $order['currier_name']."<br>".$type; ?></span>
                    <span class="<?php echo $label_class; ?>"><?php echo $label_text; ?></span>
                </td>
                <td>
                    <?php
                    if(empty($order['label_trucking']) && empty($order['label_check'])){
                        ?>
                        <span class="orange-label">Tag</span>
                        <?php
                    }elseif(!empty($order['label_trucking'])){
                        ?>
                        <span><?php echo date('M-d-Y', strtotime($order['label_date'])); ?></span>
                        <span><?php echo $order['label_trucking']; ?></span>
                        <span class="green-label">Tag</span>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <span><?php echo date('M-d-Y', strtotime($order['shipping_date'])); ?></span>
                    <?php
                    if($order['pick_up'] == '2'){

                        ?>
                        <span><?php echo  ($order['pickup_time'] == 'no_data')?'I will confirm pick up time later':$order['pickup_time']; ?></span>
                        <?php

                        if(!empty($order['shedule_id'])){
                            ?>
                            <span class="green-label">Pickup</span>
                            <?php
                        }else{
                            ?>
                            <span class="orange-label">Pickup</span>
                            <?php
                        }

                    }elseif($order['pick_up'] == '2'){
                        ?>
                        <span>Drop Off</span>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <span><?php echo date('M-d-Y', strtotime($order['delivery_date'])); ?></span>
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
                    <span>$<?php echo (!empty($order['order_price']['original_price']))?$order['order_price']['original_price']:'NaN'; ?></span>
                </td>
            </tr>

        <?php }
    }
    ?>
</tbody>
</table>
        </div>
    </div>
</div>
