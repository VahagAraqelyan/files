<header class="">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="logo-place">
                    <a href="<?php echo base_url(); ?>home" class="logo">
                        <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <p class="welcome-text text-center">Welcome: <span><?php echo $admin_name; ?></span></p>
                <ul class="head-user">
                    <li><a href="<?php echo base_url('admin/dashboard/dashboard');?>" class="btn btn-default btn-login-orange">Dashboard </a></li>
                    <li><a href="<?php echo base_url($admin_alias);?>logout" class="btn btn-default btn-login-orange">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="head-user right-top-part select-doc-parent">

                    <?php

                    foreach ($all_perm as $perm){

                        if(empty($all_url[$perm[0]])){
                            continue;
                        }

                        if(!in_array($perm[0], $permissions)){
                           continue;
                        }
                        ?>
                        <li data-block = "<?php echo $all_url[$perm[0]]['data_block']?>" class="admin_menu"><a href="<?php echo base_url($all_url[$perm[0]]['url']);?>" class="btn btn-default select-doc-file admin_menu"><?php echo $perm[1]; ?></a></li>
                    <?php } ?>
                </ul>
                <ul class="head-user right-bottom-part">
                    <li><a href="<?php echo base_url('admin/order/new_order')?>" class="show-values ">New order <span class="count"><?php echo $new_order;?></span></a></li>
                    <li><a href="<?php echo base_url('admin/order/processed_order')?>" class="show-values ">Processing <span class="count"><?php echo $processed_status;?></span></a></li>
                    <li><a href="<?php echo base_url('admin/order/ready_order')?>" class="show-values ">Ready <span class="count"><?php echo $ready_status;?></span></a></li>
                    <li><a href="<?php echo base_url('admin/order/in_transit_order')?>" class="show-values ">In Transit <span class="count"><?php echo $intranzit_status;?></span></a></li>
                    <li><a href="<?php echo base_url('admin/order/delivered_canceled')?>" class="show-values ">Delivered & Canceled <span class="count"><?php echo $delivery_canseled_status;?></span></a></li>
                </ul>
            </div>
        </div>

        <div class="button-phone-place">
            <p class="phone"><i class="head-phone"></i><span>1800 678 6167</span></p>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

    </div>
</header>