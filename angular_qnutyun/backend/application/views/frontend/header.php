<header class="">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo-place">
                        <a href="#" class="logo">
                            <img src="<?php echo base_url();?>assets/images/logo.png" id="logo_img" alt="Worldwide Luggage Shipping">
                        </a>
                </div>
            </div>
            <?php if(!$this->ion_auth->logged_in()) {?>
                <div class="col-md-6 col-xs-12 price_page_hide">
                    <h1><span class="header-main text-center">Worldwide Luggage Shipping</span>
                        <span class="header-second text-center">Luggage,  Boxes, Golf Clubs, Skis, Bikes &amp; More</span>
                    </h1>
                </div>
            <?php }else{ ?>
                <div class="col-md-6 col-xs-12 wo-loged-in price_page_hide">
                    <h1><span class="header-main text-center">Worldwide Luggage Shipping</span>
                        <span class="header-second text-center">Luggage,  Boxes, Golf Clubs, Skis, Bikes &amp; More</span>
                    </h1>
                </div>
            <?php } ?>
            <div class="col-md-3">
                <ul class="header-address">
                    <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                    <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                </ul>
            </div>
            <?php if($this->ion_auth->logged_in()) { ?>
            <div class="acc-mo-logged-in col-sm-12">
                <ul class="mob-account-info">
                    <li class="account-no text-left">Acount #: <span><?php echo $info['account_num']; ?></span></li>
                    <li class="account-na text-right">Name: <span><?php echo $info['user_name']; ?></span></li>
                </ul>
            </div>
            <?php } ?>
            <div class="button-phone-place">
                <p class="phone"><i class="head-phone"></i><a href="tel:18006786167" class="phone_color">1800 678 6167</a></p>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

        </div>
</header>