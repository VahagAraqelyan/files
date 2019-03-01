<div class="content dashboard">
    <div class="container">
        <div class="panel panel-default designed-panel admin_new_order">
<div class="panel-heading">
    <?php
        if(!empty($dashboard_search_cr)){ ?>

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
                        <button type="button" class="btn btn-default btn-login-orange search_new_order">Search</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <a href="" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
                    <ul class="pagination designed-pagination">
                        <?php echo $link; ?>
                    </ul>
                </div>
            </div>
        <?php }elseif(!empty($dashboard_search_ready_cr)){ ?>
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
                        <button type="button" class="btn btn-default btn-login-orange search_new_order">Search</button>
                    </form>
                    <select class="form-control selectpicker select-carrier" name="" id="">
                        <option value="">All Carrier</option>
                        <option value="">United Kingdom</option>
                        <option value="">France</option>
                    </select>
                </div>
                <div class="col-md-6 text-right">
                    <a href="" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
                    <ul class="pagination designed-pagination">
                        <?php echo  $link; ?>
                    </ul>
                </div>
            </div>
        <?php } else{ ?>
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
                        <?php
                        if($action == 'processed_order'){
                            ?>
                            <select name="order_type">
                                <option value="">Select type</option>
                                <option value="1" <?php echo ($this->input->get('order_type') == 1)?'selected="selected"':''; ?>>International</option>
                                <option value="2" <?php echo ($this->input->get('order_type') == 2)?'selected="selected"':''; ?>>Domestic</option>
                            </select>
                            <?php
                        }
                        ?>
                        <button type="submit" class="btn btn-default btn-login-orange search_new_order">Search</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?php echo base_url('admin/order/').$action; ?>" class="btn btn-default view-all-btn btn-login-blue reset_all">Reset All</a>
                    <ul class="pagination designed-pagination">
                        <?php echo $link; ?>
                    </ul>
                </div>
            </div>

        <?php } ?>

</div>
<div class="panel-table-title">
    <?php
    if($action=='order_history'){ ?>
        <h3 class="panel-title"><?php echo $order_name; ?>: <span><?php echo $all_count; ?></span></h3>
   <?php }else{ ?>
        <h3 class="panel-title"><?php echo $order_name.' '.'Order'?>: <span><?php echo $all_count; ?></span></h3>
    <?php } ?>

</div>

            <?php if($action == 'order_history'){
                ?>
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
                                    <span><?php show_date($order['created_date']); ?></span>
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
                                    <span><?php  show_date($order['shipping_date']); ?></span>
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
                                    <span>$<?php echo (!empty($order['order_price']['original_price']))?$order['order_price']['original_price']:'0'; ?></span>
                                </td>
                            </tr>

                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            <?php } ?>


 <?php if($action == 'uncompeted_order'){
     ?>
<table class="table table-bordered table-hover designed-table">
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
        <th class=""><small>Total<br /> Luggage</small></th>
        <th class=""><small>Total Weight<br /> Cost</small></th>
    </tr>
    </thead>
    <tbody>
    <?php

    if(!empty($all_orders)){

        foreach ($all_orders as $index => $order){

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
                    <span><?php show_date($order['created_date']); ?></span>
                    <span class="<?php echo $cancel_class; ?>"><?php echo $order['title']; ?></span>
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

                    }elseif($order['pick_up'] == '2'){
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
                    <span>$<?php echo (!empty($order['order_price']['original_price']))?$order['order_price']['original_price']:'NaN'; ?></span>
                </td>
            </tr>

        <?php }
        }
    ?>
    </tbody>
</table>
<?php } ?>

<?php if($action == 'processed_order'){ ?>

    <table class="table table-bordered table-hover designed-table">
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
            <th class="tracking-number"><small>Tracking<br /> Number</small></th>
        </tr>
        </thead>
        <tbody>
        <?php

        if(!empty($all_orders)){

            foreach ($all_orders as $index => $order){

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
                        <span><?php echo $order['currier_name']."<br>".$type;; ?></span>
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
                            foreach ($order['tracking'] as $tracking){
                                ?>
                                <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?></span>
                            <?php   }
                        }
                        ?>
                    </td>
                </tr>
                <?php
            } }
        ?>
        </tbody>
    </table>

<?php } ?>

<?php if($action == 'ready_order'){ ?>
    <table class="table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Order<br /> Number & Name</small></th>
            <th class="order-date"><small>Order<br /> Date & status</small></th>
            <th class="style-service"><small>Service<br /> Type</small></th>
            <th class=""><small>Label<br /> Tracking</small></th>
            <th class="pickup-date"><small>Pickup<br /> Date & Time</small></th>
            <th class=""><small>Delivery<br /> Date & Time</small></th>
            <th class="from"><small>From</small></th>
            <th class=""><small>To</small></th>
            <th class=""><small>Luggage</small></th>
            <th class="tracking-number"><small>Tracking<br /> Number</small></th>
        </tr>
        </thead>
        <tbody>
        <?php


        if(!empty($all_orders)){

            foreach ($all_orders as $index => $order){

                $cancel_class = ($order['shipping_status'] == SUBMITTED_CANCEL_STATUS[0] || $order['shipping_status'] == PROCESSED_CANCEL_STATUS[0])?'red-text':"";
                $track_class = (empty($order['tracking']['tracking_number']))?'orange-label':'green-label';
                $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
                $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
                $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
                $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";
                $type = change_order_type($order['send_type'],$order['currier_name'],$order['shipping_type']);
                $date_class = (strtotime(date('M-d-Y'))>strtotime($order['shipping_date']))?'error_class':'';
                ?>

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
                            <span class="label_trucking" data_order ="<?php echo $order['real_id']; ?>" > <?php echo $order['label_trucking']; ?></span>
                            <!--<span class="green-label">Tag</span>-->
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <span class="<?php echo $date_class; ?>"><?php show_date($order['shipping_date']); ?></span>
                        <?php
                        if($order['pick_up'] == '2'){

                            ?>
                            <span><?php echo  ($order['pickup_time'] == 'no_data')?'I will confirm pick up time later':$order['pickup_time']; ?></span>
                            <?php

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

                            if(empty($order['webhook_reg'])){ ?>
                                <a href="#" data_id="<?php echo $order['order_id']; ?>" class="btn btn-default view-all-btn btn-login-blue admin_web_hook no_href">Web hook</a>
                            <?php }

                            foreach ($order['tracking'] as $tracking){

                                $truck_class = 'fa fa-times delay-icon';

                                if($tracking['shipping_status'] == TRANSIT_STATUS[0]){

                                    $truck_class = 'fa fa-check picked-up-icon';

                                }elseif ($tracking['shipping_status'] == DELIVERY_STATUS[0]){

                                    $truck_class = 'fa fa-check delivered-icon';

                                } ?>
                                <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?><i class="<?php echo $truck_class; ?>"></i></span>
                            <?php   }
                        }
                        ?>
                    </td>
                </tr>
                <?php
            } }
        ?>
        </tbody>
    </table>
<?php } ?>

<?php if($action == 'in_transit_order'){ ?>

  <!--  Today is: --><?php /*echo strtotime(date('M-d-Y')); */?>
    <table class="table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Order<br /> Number & Name</small></th>
            <th class="style-service"><small>Service<br /> Type</small></th>
            <th class=""><small>Delivery<br /> Date & Time</small></th>
            <th class="from"><small>From</small></th>
            <th class=""><small>To</small></th>
            <th class=""><small>Luggage</small></th>
            <th class=""><small>Tracking<br /> Number</small> <!--<a href="" class="btn btn-default view-all-btn btn-login-blue">Track</a>--></th>
            <th class=""><small>Tracking<br /> Result</small></th>
            <th class=""><small>Admin Tracking<br /> Notes</small></th>
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
                $type = change_order_type($order['send_type'],$order['currier_name'],$order['shipping_type']);
                $date_class = (strtotime(date('M-d-Y'))>strtotime($order['delivery_date']))?'error_class':'';

                ?>

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
                        <span><?php echo $order['currier_name']."<br>".$type;; ?></span>
                    </td>
                    <td>
                        <span class="<?php echo $date_class; ?>"><?php show_date($order['delivery_date']); ?></span>
                        <span class="<?php echo $date_class; ?>"><?php echo $order['delivery_time']; ?></span>
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

                            if(empty($order['webhook_reg'])){ ?>
                                <a href="#" data_id="<?php echo $order['order_id']; ?>" class="btn btn-default view-all-btn btn-login-blue admin_web_hook no_href">Web hook</a>
                            <?php }

                            foreach ($order['tracking'] as $tracking){
                                $truck_class = 'fa fa-times delay-icon';

                                if($tracking['shipping_status'] == TRANSIT_STATUS[0]){

                                    $truck_class = 'fa fa-check picked-up-icon';

                                }elseif ($tracking['shipping_status'] == DELIVERY_STATUS[0]){

                                    $truck_class = 'fa fa-check delivered-icon';

                                }

                              ?>
                                <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?>  <i class="<?php echo $truck_class; ?>"></i></span>

                            <?php   } } ?>
                    </td>
                    <td>
                        <?php
                        if(!empty($order['tracking'])){
                        foreach ($order['tracking'] as $index => $tracking){ ?>
                            <span><?php echo (!empty($tracking['status_detail']))? $index+1 ." )".$tracking['status_detail']:'';?></span>
                        <?php   } }  ?>
                    </td>
                    <td>
                        <textarea cols="10" rows="3" class="transit_notes_<?php echo $order['real_id']; ?> save_transit_order_notes"  data_id="<?php echo $order['real_id']; ?>" ><?php echo (!empty($order['notes']))?$order['notes']:''; ?></textarea>

                    </td>
                </tr>
                <?php
            } }
        ?>
        </tbody>
    </table>
<?php } ?>
<?php if($action == 'delivered_canceled'){ ?>

    <table class="table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Order Number <br /> Account  Name</small></th>
            <th class="order-date"><small>Order Date <br /> Order status</small></th>
            <th class="style-service"><small>Service<br /> Type</small></th>
            <th class="from"><small>From</small></th>
            <th class=""><small>To</small></th>
            <th class=""><small>Luggage</small></th>
            <th class=""><small>Tracking<br /> Number</small></th>
            <th class=""><small>Estimated Weight<br /> Charged amount</small></th>
            <th class=""><small>Finial Cost</small></th>
            <th class=""><small>Order <br />Balance</small></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $est_weight = 0;
        if(!empty($all_orders)){

            foreach ($all_orders as $index => $order){

                $lost_claim = ($order['lost_claim'] == 1)?'<span class="error_class"> Lost</span>' :"";
                $damage_claim = ($order['damage_claim'] == 1)?'<span class="error_class">Damage</span>' :"";
                $payment_dispute = ($order['payment_dispute'] == 1)?'<span class="error_class">Dispute</span>' :"";
                $billing_claim = ($order['billing_claim'] == 1)?'<span class="error_class">Billing Claim</span>' :"";
                $type = change_order_type($order['send_type'],$order['currier_name'],$order['shipping_type']);
                ?>

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
                        <span class=""><?php echo $order['title'];?></span>
                    </td>
                    <td>
                        <span><?php echo $order['currier_name']."<br>".$type;; ?></span>
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
                        $total_charge = 0;
                        $total_refund = 0;
                        $order_balance = [
                            'amount' => 0,
                            'type' => ''
                        ];

                        if(!empty($order['charge_payment'])){
                        foreach ($order['charge_payment'] as $charge){

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
                            }
                        }

                        $est_weight = 0;
                        foreach ($order['luggages'] as $luggages){

                            $est_weight += $luggages['charge_weight'];
                        }
                        $total_cost = 0;
                        if(!empty($order['final_billing_info'])){
                            foreach ($order['final_billing_info']['luggage'] as $final_billing_info){

                               if(!empty($final_billing_info['cost'])){

                                   $total_cost +=$final_billing_info['cost'];
                               }

                            }

                        }

                        if(!empty($order['tracking'])){

                            foreach ($order['tracking'] as $tracking){
                                $truck_class = 'fa fa-times delay-icon';

                                if($tracking['shipping_status'] == TRANSIT_STATUS[0]){

                                    $truck_class = 'fa fa-check picked-up-icon';

                                }elseif ($tracking['shipping_status'] == DELIVERY_STATUS[0]){

                                    $truck_class = 'fa fa-check delivered-icon';

                                }
                                ?>
                                <span class="link_tracking" user_id = "<?php echo $order['user_id'];?>" data_number = "<?php echo $order['real_id'].'_'.$tracking['luggage_id'].'_'.$tracking['tracking_number']; ?>"><?php echo $tracking['tracking_number']; ?> <i class="<?php echo $truck_class; ?>"></i></span>
                            <?php   }
                        }
                        ?>
                    </td>
                    <td>
                         <?php echo $est_weight;?>lbs <br>
                        <?php
                        echo !empty(floatval($total_charge - $total_refund))?'$'.floatval($total_charge - $total_refund):'';
                        ?>
                    </td>
                    <td>
                            <?php echo (!empty($total_cost))?'$'.$total_cost:''; ?>
                    </td>
                    <td>
                        <span class="red-text large"><?php echo ($order_balance['type']==2)?'<span class="text-red">- $ '.$order_balance['amount'].'</span>':'<span>$ '.$order_balance['amount'].'</span>'; ?></span>
                    </td>
                </tr>
                <?php
            } }
        ?>
        </tbody>
    </table>
<?php } ?>

            <?php if($action == 'new_order'){
                ?>
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
                        <th class=""><small>Total Weight<br /> Cost</small></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(!empty($all_orders)){

                        foreach ($all_orders as $index => $order){

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
                                    <span><?php show_date($order['created_date']); ?></span>
                                    <span class="<?php echo $cancel_class; ?>"><?php echo $order['title']; ?></span>
                                </td>
                                <td>
                                    <span><?php echo $order['currier_name']."<br>".$type;; ?></span>
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
                                    <!--    <span class="green-label">Tag</span>-->
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
            <?php } ?>
        </div>

        <div class="modal fade" id="trucking_modal" role="dialog">
            <div class="modal-dialog drop_off_locator">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="trucking_modal_content">

                    </div>
                </div>

            </div>
        </div>


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

<script>
    <?php
    if(empty($dashboard_search_cr) && empty($dashboard_search_ready_cr)){ ?>
    order_count = <?php echo $order_count; ?>
   <?php } ?>

</script>

