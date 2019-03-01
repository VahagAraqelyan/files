<div class="content dashboard">
    <div class="container">

        <div class="panel panel-default designed-panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-inline search-data-form" method="get" id="costumer_list_form" action="<?php echo base_url('admin/user_manage/customer_list/'); ?>">
                            <div class="form-group">
                                <label class="sr-only" for="">Account #</label>
                                <input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account #" value="<?php echo $search['account_name'];?>">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="">Name</label>
                                <input type="text" name="first_name" id="username" class="form-control" placeholder="Name" value="<?php echo $search['first_name'];?>">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $search['email'];?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default btn-login-orange" style="float: left;margin-left: 10px;margin-right: 10px">Search</button>
                                <a href="<?php echo base_url('admin/user_manage/customer_list'); ?>" class="btn btn-default view-all-btn btn-login-blue reset_all" id="viewall">Reset ALL</a>
                            </div>
                            <input type="hidden" name="user_status" id="user_status" value="<?php echo $filter['status']; ?>">
                            <input type="hidden" name="order_by" id="user_list_order_by" value="<?php echo $filter['order']; ?>">
                            <input type="hidden" name="order_type" id="user_list_order_type" value="<?php echo $filter['order_by']; ?>">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-exclamation created-icon fa_under_review status_filter" data-status="3"></i>
                        <i class="fa fa-check picked-up-icon status_filter" data-status="1"></i>
                        <i class="fa fa-check delivered-icon status_filter" data-status="2"></i>
                        <i class="fa fa-times delay-icon status_filter" data-status="0"></i>
                    </div>
                    <div class="col-md-4 text-right">
                        <ul class="pagination designed-pagination">
                            <?php echo $links; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-table-title">
                <h3 class="panel-title">Customer List: <span><?php echo $count; ?></span></h3>
            </div>
            <table class="table table-bordered table-hover designed-table">
                <thead>
                <tr>
                    <?php
                    foreach($table_head as $value => $settings){

                        if(empty($settings['order_type'])){
                            ?>
                            <th><?php echo $settings['title']; ?></th>
                            <?php
                            continue;
                        }

                        if(empty($settings['active'])){
                            ?>
                            <th><?php echo $settings['title'];?><span class = 'customer_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $settings['order_type']; ?>">&#9650;&#9660;</span></th>
                            <?php
                            continue;
                        }

                        if($settings['order_type'] == 'ASC'){
                            $symbol = '&#9660;';
                        }else{
                            $symbol = '&#9650;';
                        }

                        ?>
                        <th><?php echo $settings['title'];?><span class = 'customer_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $settings['order_type']; ?>"><?php echo $symbol; ?></span></th>
                        <?php
                    }
                    ?>
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
                    foreach ($info as $index => $info_user){

                            $active_class =  $status_arr[$info_user['user_status']];

                            if(empty($info_user['last_update'])){

                                $k = 'NO';
                                $class = 'red-text';

                            }else{

                                $k = 'YES';
                                $class = 'green-text';
                            }
                    ?>
                    <tr class="edit_user_account" data-id = '<?php echo $info_user['id']; ?>'>
                        <td><?php echo $index +1; ?></td>
                        <td><i class="<?php echo $active_class ?>"></i></td>
                        <td><a href="<?php echo  base_url()?>admin/user_manage/user_account/<?php echo $info_user['id'];?>"><?php echo $info_user['account_name']; ?></a></td>
                        <td><?php echo $info_user['first_name']." ".$info_user['last_name']; ?></td>
                        <td><?php echo $info_user['company']; ?></td>
                        <td><?php echo date("M-d-Y H:i:s", $info_user['created_on']); ?></td>
                        <td><?php echo $info_user['email']; ?></td>
                        <td>
                            <span class="<?php echo $class; ?> bold"><?php echo  $k;?></span>
                        </td>
                        <td>
                            <a href="<?php echo base_url('admin/order/user_orders/'.$info_user['id']); ?>"><span class="bold"><?php echo $info_user['total_orders']; ?></span></a></td>
                        <td>
                            <span class="bold"><?php echo (empty($info_user['paid']))?'$ 0.00':'$ '.$info_user['paid']; ?></span>
                        </td>
                        <td><?php echo '$ '.$info_user['account_balance']; ?></td>
                        <td><a href="#" class="btn btn-default view-all-btn btn-login-blue reset_all no_href" data_id="<?php echo $info_user['id']; ?>" id="login_us_admin">Login</a></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
