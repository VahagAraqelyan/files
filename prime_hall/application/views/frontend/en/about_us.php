<section class="filter filter_offer">
    <div class="menu">
        <ul>
            <li><a data-id="home" href="<?php echo base_url('en/home')?>">Home</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('en/gallery')?>">Gallery</a></li>
            <li><a data-id="book_now" class="book_now" href="#">Book an event</a></li>
            <!--<li class="menu_logo"><a data-id="" href="<?php /*echo base_url();*/?>">
                <img src="<?php /*echo base_url('assets/images/logo_prime_hall.jpg')*/?>" alt="">
            </a></li>-->
            <li><a data-id="our_us" href="<?php echo base_url('en/about_us')?>">ABOUT US</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('en/contact_us')?>">CONTACT</a></li>
        </ul>
    </div>
    <div class="resp_menu">

        <div class="menu-toggle">
            <button type="button" id="menu-btn">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
            <li><a data-id="home" href="<?php echo base_url('en/home')?>">Home</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('en/gallery')?>">Gallery</a></li>
            <li><a data-id="book_now" href="#">Book an event</a></li>
            <li><a data-id="our_us" href="<?php echo base_url('en/about_us')?>">ABOUT US</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('en/contact_us')?>">CONTACT</a></li>
        </ul>
    </div>
    <div class="about_us image_main">
        <img src="<?php echo base_url('assets/images/banner.jpg');?>">
    </div>
    <div class="container">
        <div class="offer_main">

            <div class="content offer_main">
                <h3>ABOUT US</h3>
                <div class="about_us_content">
                    <h4>
                        <b>
                            THE CELEBRATION SHOULD BE BEAUTEOUS
                        </b>
                    </h4>

                    <p>
                        <b>
                            NEW FABULOUS BANQUET, EVENTS, CONCERT
                        </b>
                    </p>

                    <p>
                        <b>
                            ДAND PRESENTATION HALL IN YEREVAN
                        </b>
                    </p>
                    <p><b>
                            HOSTING UP TO 600 PERSONS
                        </b></p>

                    <p><b>Advantages</b></p>

                    <ul>
                        <li>
                            * THE HALL IS LOCATED IN YEREVAN CITY,
                            DAVTASHEN, YEGHVARD HIGHWAY,
                            GORGE 3, FROM WHERE YOU WILL ENJOY
                            THE BEAUTIFUL NATURE OF HRAZDAN GORGE
                        </li>
                        <li>
                            * THERE ARE NO COLUMNS IN THE SPACIOUS HALL
                        <li>
                            * THERE IS AN EXCLUSIVE, LARGE AND PROFESSIONAL STAGE WITH A
                            BACKSTAGE
                        </li>
                        <li>
                            * THE HALL IS EQUIPPED WITH A MODERN LIGHTING AND SOUND TECHNICS
                        </li>
                        <li>
                            * THE HALL IS FEATURED WITH UNPRECEDENTED DESIGN SOLUTIONS
                        </li>
                        <li>
                            * THE DISHES ARE MADE UNDER SUPERVISION OF A HIGHLY QUALIFIED
                            CHEF
                        </li>
                        <li>
                            * A SPECIOUS PARKING LOT IS LOCATED IN FRONT OF THE HALL
                        </li>
                        <li>
                            * THE FOOD IS SERVED WITH HIGH-QUALITY FOREIGN DISHES
                        </li>
                        <li>
                            * WE HAVE AN EXPERIENCED AND PROFESSIONAL SERVICE PERSONNEL
                        </li>
                    </ul>

                    <p>
                        <b>
                            WE WILL ENSURE YOUR EVENT’S HIGH MOOD AND PLEASANT PASTIME.
                        </b>
                    </p>
                    <p>
                        <b>
                            BEST REGARDS, “PRIME HALL” FROM DREAMS TO REALITY
                        </b>
                    </p>
                </div>
            </div>
    </div>
</section>


<div class="modal login-fast inform-fast" id="reservetion_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">to fill in the data</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="reservetion-error">

            </div>
            <div class="modal-body">
                <div class="form-horizontal text-left" id="">
                    <form action="" method="post" autocomplete="off" id="reservetion_form">
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Day<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control res_date reservetion_date_calendar"  name="date" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">First Name<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control"  name="first_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Last Name<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control" maxlength="20" name="last_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Tel.<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="tel" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Number of participants․<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="number_part" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Email:
                            </div>
                            <div class="col-8  value-info">
                                <input type="email" class="form-control"  name="email" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-8 control-label value-index">
                            </div>
                            <div class="col-4  value-info">
                                <button type="button" id="save_reservetion" class="btn btn-primary">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>