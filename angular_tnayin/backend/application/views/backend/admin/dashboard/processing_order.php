<!--class="orange-box"-->
<div class="panel-heading">
    <div class="row">
        <div class="col-md-6">
            <form class="form-inline search-data-form" method="post" action="" id="new_order_form">
                <div class="form-group">
                    <label class="sr-only" for="">Account #</label>
                    <input type="text" name="order_number" class="form-control" placeholder="Account #" value="<?php echo $cr['order_shipping.order_id']; ?>">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="">Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="Name" value="<?php echo $cr['users.first_name']; ?>">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $cr['users.email']; ?>">
                </div>
                <button type="button" class="btn btn-default btn-login-orange processid_order_search">Search</button>
            </form>
        </div>
        <div class="col-md-6 text-right">
            <a href="" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
            <ul class="pagination designed-pagination">
               <?php echo $link; ?>
            </ul>
        </div>
    </div>
</div>

<div class="panel-table-title">
    <h3 class="panel-title">Processing Order: <span><?php echo $all_count; ?></span></h3>
</div>

<h4>International</h4>

<table class="table table-bordered table-hover designed-table some-width">
    <thead>
    <tr>
        <th class=""><small>#</small></th>
        <th class="order-number"><small>Order<br /> Number & Name</small></th>
        <th class="order-date"><small>Order<br /> Date & status</small></th>
        <th class="style-service"><small>Service<br /> Type</small></th>
        <th class=""><small>Label<br /> Delivery</small></th>
        <th class="pickup-date"><small>Pickup<br /> Date & Time</small></th>
        <th class=""><small>Delivery<br /> Date & Time</small></th>
        <th class="from"><small>From</small></th>
        <th class=""><small>To</small></th>
        <th class=""><small>Luggage</small></th>
        <th class=""><small>Tracking<br /> Number</small></th>
    </tr>
    </thead>
    <tbody>
    <?php

    if(!empty($all_orders)){

        foreach ($all_orders as $index => $order){

            if($order['shipping_type'] != '1'){
                continue;
            }

                $cancel_class = ($order['shipping_status'] == SUBMITTED_CANCEL_STATUS[0] || $order['shipping_status'] == PROCESSED_CANCEL_STATUS[0])?'red-text':"";
            $track_class = (empty($order['tracking']['tracking_number']))?'orange-label':'green-label';
            $label_class = (empty($type_files[$order['real_id']]))?'orange-label':'green-label';
            $label_text = (empty($order['sys_label']))?'Label':'SYS-Label';
            $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
            $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
            $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
            $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";
            $type = $order['send_type'];
            if($order['shipping_type'] == 2){

                if(stripos($type, 'Basic') !== false){
                    $type = 'Basic Service';
                }else{

                    if(stripos($type, 'Express') !== false){
                        $type = str_ireplace('Express','',$type);
                    }elseif (stripos($type, 'Priority') !== false){
                        $type = str_ireplace('Priority','',$type);
                    }elseif (stripos($type, 'Standard') !== false){
                        $type = str_ireplace('Standard','',$type);
                    }

                    if(stripos($type, 'afternoon') !== false){
                        $type = str_ireplace('afternoon','PM',$type);
                    }elseif (stripos($type, 'morning') !== false){
                        $type = str_ireplace('morning','AM',$type);
                    }
                }
            }elseif($order['shipping_type'] == 1){

                if(stripos($type, 'Express') !== false){
                    $type = 'Express';
                    $type = str_ireplace('days','',$type);

                }elseif (stripos($type, 'Economy') !== false){
                    $type = 'Economy';
                    $type = str_ireplace('days','',$type);

                }

            }  ?>

            <tr>
                <td><?php echo $index+1; ?></td>
                <td>
                    <div>
                        <a href="<?php echo base_url('admin/order/order_detail/').$order['real_id']; ?>">
                            <span><?php echo $order['order_number']; ?></span>
                        </a>
                        <a href="<?php echo base_url('admin/user_manage/user_account/').$order['user_id']?>">
                            <span><?php echo $order['first_name']." ".$order['last_name']; ?></span>
                        </a>
                        <?php
                        echo $lost_claim ;
                        echo $damage_claim ;
                        echo $payment_dispute ;
                        echo $billing_claim;
                        ?>
                    </div>
                </td>
                <td>
                    <span><?php show_date($order['created_date']); ?></span>
                    <span class="<?php echo $cancel_class; ?>"><?php echo $order['title'];?></span>
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
                        <span><?php show_date($order['label_date']); ?></span>
                        <span class="label_trucking" data_order ="<?php echo $order['real_id']; ?>"><?php echo $order['label_trucking']; ?></span>
                        <!--<span class="green-label">Tag</span>-->
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <span><?php show_date($order['shipping_date']); ?></span>
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

                    }else{
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
                <td>
                    <?php
                    for($i = 1; $i <= $order['luggage_info']['count']; $i++){
                        ?>
                        <span><?php echo $i; ?></span>
                        <?php
                    }
                    ?>

                </td>
                <td>
                    <?php
                    if(!empty($order['tracking'])){
                        foreach ($order['tracking'] as  $tracking){ ?>
                            <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?></span>
                        <?php   } }  ?>
                </td>
            </tr>
            <?php
        } }
    ?>
    </tbody>
</table>

<h4>Domestic</h4>

<table class="table table-bordered table-hover designed-table some-width">
    <thead>
    <tr>
        <th class=""><small>#</small></th>
        <th class="order-number"><small>Order<br /> Number & Name</small></th>
        <th class="order-date"><small>Order<br /> Date & status</small></th>
        <th class="style-service"><small>Service<br /> Type</small></th>
        <th class=""><small>Label<br /> Delivery</small></th>
        <th class="pickup-date"><small>Pickup<br /> Date & Time</small></th>
        <th class=""><small>Delivery<br /> Date & Time</small></th>
        <th class="from"><small>From</small></th>
        <th class=""><small>To</small></th>
        <th class=""><small>Luggage</small></th>
        <th class=""><small>Tracking<br /> Number</small></th>
    </tr>
    </thead>
    <tbody>
    <?php

    if(!empty($all_orders)){

        foreach ($all_orders as $index => $order){

            if($order['shipping_type'] != '2'){
                continue;
            }

            $cancel_class = ($order['shipping_status'] == SUBMITTED_CANCEL_STATUS[0] || $order['shipping_status'] == PROCESSED_CANCEL_STATUS[0])?'red-text':"";
            $track_class = (empty($order['tracking']['tracking_number']))?'orange-label':'green-label';
            $label_class = (empty($type_files[$order['real_id']]))?'orange-label':'green-label';
            $label_text = (empty($order['sys_label']))?'Label':'SYS-Label';
            $type = $order['send_type'];
            $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
            $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
            $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
            $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";


            if($order['shipping_type'] == 2){

                if(stripos($type, 'Basic') !== false){
                    $type = 'Basic Service';
                }else{

                    if(stripos($type, 'Express') !== false){
                        $type = str_ireplace('Express','',$type);
                    }elseif (stripos($type, 'Priority') !== false){
                        $type = str_ireplace('Priority','',$type);
                    }elseif (stripos($type, 'Standard') !== false){
                        $type = str_ireplace('Standard','',$type);
                    }

                    if(stripos($type, 'afternoon') !== false){
                        $type = str_ireplace('afternoon','PM',$type);
                    }elseif (stripos($type, 'morning') !== false){
                        $type = str_ireplace('morning','AM',$type);
                    }
                }
            }elseif($order['shipping_type'] == 1){

                if(stripos($type, 'Express') !== false){
                    $type = 'Express';
                    $type = str_ireplace('days','',$type);

                }elseif (stripos($type, 'Economy') !== false){
                    $type = 'Economy';
                    $type = str_ireplace('days','',$type);

                }

            }  ?>

            <tr>
                <td><?php echo $index+1; ?></td>
                <td>
                    <div>
                        <a href="<?php echo base_url('admin/order/order_detail/').$order['real_id']; ?>">
                            <span><?php echo $order['order_number']; ?></span>
                        </a>
                        <a href="<?php echo base_url('admin/user_manage/user_account/').$order['user_id']?>">
                            <span><?php echo $order['first_name']." ".$order['last_name']; ?></span>
                        </a>
                        <?php
                        echo $lost_claim ;
                        echo $damage_claim ;
                        echo $payment_dispute ;
                        echo $billing_claim;
                        ?>
                    </div>
                </td>
                <td>
                    <span><?php show_date($order['created_date']); ?></span>
                    <span class="<?php echo $cancel_class; ?>"><?php echo $order['title'];?></span>
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
                        <span><?php show_date($order['label_date']); ?></span>
                        <span class="label_trucking" data_order ="<?php echo $order['real_id']; ?>"><?php echo $order['label_trucking']; ?></span>
                       <!-- <span class="green-label">Tag</span>-->
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <span><?php show_date($order['shipping_date']); ?></span>
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

                    }else{
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
                <td>
                    <?php
                    for($i = 1; $i <= $order['luggage_info']['count']; $i++){
                        ?>
                        <span><?php echo $i; ?></span>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if(!empty($order['tracking'])){
                        foreach ($order['tracking'] as  $tracking){ ?>
                            <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?></span>
                        <?php   } }

                    ?>

                </td>
            </tr>
            <?php
        } }
    ?>
    </tbody>
</table>