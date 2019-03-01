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
                <h3>CONTACTS</h3>
                <div class="about_us_content">
                    <form action="" method="post" autocomplete="off" id="about_us_form">
                        <div class="about-us-error">

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
                            <div class="col-4 control-label value-index">Email:
                            </div>
                            <div class="col-8  value-info">
                                <input type="email" class="form-control" name="email" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Sentence:
                            </div>
                            <div class="col-8  value-info">
                                <textarea name="our_text" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-8 control-label value-index">
                            </div>
                            <div class="col-4  value-info">
                                <button type="button" id="save_about_us" class="btn btn-primary">Confirm</button>
                            </div>
                        </div>
                    </form>

                </div>
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

<div class="modal login-fast inform-fast" id="succ_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Your suggestion was successfully sent. Thank you․</p>
            </div>
        </div>
    </div>
</div>
