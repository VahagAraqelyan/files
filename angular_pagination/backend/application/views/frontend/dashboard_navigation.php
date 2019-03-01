<?php
$cur_url = current_url();
$page = explode('/', $cur_url);
$page = $page[count($page) - 1];
?>
<nav class="navbar navbar-default navbar-static-top">
    <div class="navbar-style">
        <div class="navbar-some-border">
            <div class="container">
                <div class="navbar-header">

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="<?php echo ($page == 'dashboard')?'active':'';?>"><a href="<?php echo base_url(); ?>dashboard/dashboard/">Dashboard</a></li>
                        <li class="<?php echo ($page == 'order_history')?'active':'';?>"><a href="<?php echo base_url(); ?>order_history">Order History</a></li>
                        <li class="<?php echo ($page == 'my_profile')?'active':'';?>"><a href="<?php echo base_url(); ?>user/my_profile/">My Profile</a></li>
                        <li class="reset_cookie <?php echo ($page == 'home')?'active':'';?>"><a href="<?php echo base_url(); ?>home">Check Price</a></li>
                        <li class="<?php echo ($page == 'luggage-and-question')?'active':'';?>"><a href="<?php echo base_url('luggage-and-question')?>">FAQ</a></li>
                        <li><a href="<?php echo base_url(); ?>user/logout/">Logout</a></li>
                    </ul>
                    <!-- ul class="nav navbar-nav navbar-right signin-signup">
                      <li><a href="#" data-toggle="modal" data-target="#login_modal">Login</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#register_modal">Signup</a></li>
                    </ul> -->
                    <div class="nav-account">
                        <img src="<?php echo base_url();?>assets/images/nav-user.png">
                        <ul class="nav-account-info">
                            <li>Hello <?php echo $info['user_name']; ?></li>
                            <li class="account-no">Acount No: <?php echo $info['account_num']; ?></li>
                        </ul>
                    </div>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
</nav>
