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
                        <li class="reset_cookie <?php echo ($page == 'home')?'active':'';?> "><a href="<?php echo base_url(); ?>home">Home</a></li>
                        <li class="reset_cookie <?php echo ($page == 'shipping-rates')?'active':'';?>"><a href="<?php echo base_url('shipping-rates'); ?>">Shipping Rate</a></li>
                        <li class="<?php echo ($page == 'luggage-storage-services')?'active':'';?>"><a href="<?php echo base_url('luggage-storage-services')?>">Storage Services</a></li>
                        <li class="<?php echo ($page == 'luggage-and-question')?'active':'';?>"><a href="<?php echo base_url('luggage-and-question')?>">Faq</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right signin-signup">
                        <li><a href="<?php echo base_url(); ?>login">Login</a></li>
                        <li><a href="<?php echo base_url(); ?>registration">Signup</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
</nav>