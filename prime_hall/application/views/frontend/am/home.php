<section class="filter">
<div class="menu">
    <ul>
        <li><a data-id="home" href="<?php echo base_url()?>">ԳԼԽԱՎՈՐ</a></li>
        <li><a data-id="gallery" href="<?php echo base_url('gallery')?>">ԼՈՒՍԱՆԿԱՐՆԵՐ</a></li>
        <li><a data-id="book_now" class="book_now" href="#">ԱՄՐԱԳՐԵԼ</a></li>
        <!--<li class="menu_logo"><a data-id="" href="<?php /*echo base_url();*/?>">
                <img src="<?php /*echo base_url('assets/images/logo_prime_hall.jpg')*/?>" alt="">
            </a></li>-->
        <li><a data-id="our_us" href="<?php echo base_url('about_us')?>">ՄԵՐ ՄԱՍԻՆ</a></li>
        <li><a data-id="contact_us" href="<?php echo base_url('contact_us')?>">ՀԵՏԱԴԱՐԶ ԿԱՊ</a></li>
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
            <li><a data-id="home" href="<?php echo base_url()?>">ԳԼԽԱՎՈՐ</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('gallery')?>">ԼՈՒՍԱՆԿԱՐՆԵՐ</a></li>
            <li><a data-id="book_now" href="#">ԱՄՐԱԳՐԵԼ</a></li>
            <li><a data-id="our_us" href="<?php echo base_url('about_us')?>">ՄԵՐ ՄԱՍԻՆ</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('contact_us')?>">ՀԵՏԱԴԱՐԶ ԿԱՊ</a></li>
        </ul>
    </div>
    <div class="">
        <div class="filter-block">
            <section class="promo">
                <div id="video_main" class="bg-video bg-video_visible">
                    <video poster="" autoplay="" muted="" loop="" class="bg-video__media">
                        <source src="<?php echo base_url()?>assets/videos/10000000_494258114333856_500771067632025600_n.mp4" type="video/mp4">
                        <source src="<?php echo base_url()?>assets/videos/10000000_1853417888299014_8535253984670121984_n.mp4" type="video/ogg; codecs='theora, vorbis'">
                        <source src="<?php echo base_url()?>assets/videos/41649711_595583907504991_4427609462389558355_n.mp4" type="video/webm">
                    </video>

                    <br class="clear">
                </div>
                <div class="slider_content">
                    <div class="slider_content_pos">
                        <div class="promo__logo-wrapper prime_logo">
                            <img src="<?php echo base_url('assets/images/logo.png')?>" alt="">
                        </div>
                        <h2 class="promo__title">Ժամանակակից հյուրընկալության փիլիսոփայությունը</h2>

                        <div class="calendar_main">
                            <div class="language col-4">
                                <a href="<?php echo base_url('am/home')?>">AM</a>
                                <a href="<?php echo base_url('ru/home')?>">RU</a>
                                <a href="<?php echo base_url('en/home')?>">EN</a>
                            </div>
                            <div class="calendar col-6">
                                <h5>ԱՄՐԱԳՐԵԼ ԻՐԱԴԱՐՁՈՒԹՅՈՒՆ</h5>
                                <input class="form-control reservetion_date_calendar" autocomplete="off" type="text" id="reservetion_calendar">
                               <!-- <i class="fa fa-calendar click_calendar" aria-hidden="true"></i>-->
                            </div>
                            <div class="language pan_main col-2">
                               <a href="#"><svg id="icon-virt-tour" viewBox="0 0 679.417 323.78" width="100%" height="100%"><path fill-rule="evenodd" clip-rule="evenodd" d="M585.443 94.92c12.34 3.81 24.469 8.341 36.146 13.872 20.283 9.604 44.02 22.727 54.158 43.872 8.561 17.86 1.183 35.902-12.245 48.963-4.948 4.817-10.488 9.005-16.281 12.746-38.173 24.658 43.191-27.916 0 0-44.035 28.445-97.462 40.339-148.55 48.712-11.889 1.949-24.125 4.305-36.817 5.96-5.496.719-16.085 2.609-19.648-3.412-1.979-3.348-1.439-7.629-1.489-11.344-.048-3.768-.214-7.619.555-11.328 1.984-9.583 10.939-11.012 19.354-11.728 51.03-4.359 101.162-15.751 147.69-37.544 16.74-7.841 30.792-21.403 26.397-41.569-3.909-17.938-23.244-25.039-37.831-32.391-11.233-5.658-22.67-9.464-34.366-13.95-3.535-1.354-7.248-3.481-8.025-7.515-.67-3.458.467-11.405 4.791-11.162 6.814.385 26.161 7.818 26.161 7.818z"></path><path d="M180.357 118.955c5.706 2.958 18.811 8.452 31.914 8.452 16.695 0 25.151-8.032 25.151-18.387 0-13.526-13.526-19.655-27.688-19.655h-13.102V66.329H209.1c10.78-.211 24.518-4.229 24.518-15.853 0-8.244-6.763-14.375-20.29-14.375-11.2 0-23.039 4.863-28.744 8.247l-6.553-23.25c8.244-5.287 24.73-10.354 42.483-10.354 29.376 0 45.651 15.426 45.651 34.236 0 14.587-8.243 25.996-25.15 31.917v.423c16.487 2.957 29.799 15.426 29.799 33.394 0 24.308-21.344 42.06-56.218 42.06-17.754 0-32.759-4.652-40.791-9.721l6.552-24.098zM379.652 35.889c-3.592-.208-7.397 0-12.471.426-28.532 2.323-41.215 16.907-44.808 32.971h.635c6.763-6.975 16.275-10.989 29.167-10.989 23.036 0 42.481 16.272 42.481 44.805 0 27.265-20.923 49.669-50.725 49.669-36.563 0-54.529-27.265-54.529-60.027 0-25.785 9.511-47.343 24.304-61.082 13.742-12.469 31.494-19.232 53.053-20.29 5.916-.42 9.721-.42 12.893-.211v24.728zm-17.543 68.902c0-12.678-6.763-23.667-20.5-23.667-8.666 0-15.852 5.283-19.023 12.258-.846 1.688-1.266 4.226-1.266 8.032.635 14.584 7.607 27.685 22.189 27.685 11.412-.001 18.6-10.355 18.6-24.308zM510.679 81.124c0 42.479-17.12 71.647-52.205 71.647-35.508 0-51.147-31.917-51.359-70.805 0-39.734 16.91-71.224 52.419-71.224 36.772 0 51.145 32.759 51.145 70.382zm-71.226.842c-.21 31.494 7.398 46.501 19.865 46.501 12.474 0 19.236-15.645 19.236-46.923 0-30.434-6.554-46.498-19.445-46.498-11.837 0-19.866 15.007-19.656 46.92z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M538.912 0c-11.755 0-21.266 9.554-21.266 21.312 0 11.753 9.511 21.266 21.266 21.266 11.756 0 21.31-9.512 21.31-21.266C560.221 9.554 550.667 0 538.912 0zm0 33.989c-6.999 0-12.68-5.68-12.68-12.677 0-7.043 5.681-12.723 12.68-12.723 7.045 0 12.725 5.68 12.725 12.723-.001 6.997-5.68 12.677-12.725 12.677z"></path><path d="M402.791 255.896l-74.668-67.906v51.801c0-.004-2.232-.023-3.338-.068-13.871-.534-27.706-1.676-41.558-2.587-55.998-3.698-111.864-9.463-165.941-25.179-12.192-3.543-24.224-7.739-35.652-13.309-11.12-5.42-22.976-12.099-31.106-21.614-6.365-7.45-9.292-16.991-5.35-26.322 4.63-10.963 15.49-18.549 25.283-24.561 11.422-7.007 24.031-11.887 36.556-16.523a533.415 533.415 0 0 1 20.455-7.082c3.979-1.288 9.31-2.45 11.249-6.679 1.542-3.364.914-11.279-3.422-11.279-12.467-.006-48.264 12.525-48.264 12.525-23.238 7.716-45.756 18.152-64.801 33.754-16.914 13.862-29.135 34.11-17.885 55.558 11.276 21.497 36.613 34.938 58.02 44.191 24.899 10.758 51.233 18.522 77.623 24.636 53.844 12.473 109.004 17.079 164.08 19.909 8.02.406 17.051.53 24.051 1.383v47.235l74.668-67.883z"></path></svg></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                <!--Complex Part-->
                <div class="section_slider">
                   <!-- <div class="section_titles">
                        <ul>
                            <li><a class="button secondary url" href="#wedding_salon_slider">ՀԱՐՍԱՆՅԱՑ ՍՐԱՀ</a></li>
                            <li><a class="button secondary url" href="#shooting_ranges_slider">ՀՐԱԶԳԱՐԱՆ</a></li>
                            <li><a class="button secondary url" href="#explanation_slider">ԲԱՑՈԹՅԱ</a></li>
                        </ul>
                    </div>-->
                    <div class="previews_list owl-carousel">
                        <?php
                        if(!empty($gallery)){
                            foreach ($gallery as $single){ ?>
                                <div class="item" data-src="<?php echo base_url('tmp/').$single['name'] ?>" ><img src="<?php echo base_url('tmp/').$single['name'] ?>"  class="img-responsive" alt=""></div>
                        <?php  } } ?>
                    </div>
                </div>
                <!--End Complex part-->
                <!--Our Menu part-->
             <div class="our_menu_main">
                 <div id="our_menu">
                    <div>
                       <div>
                           <h4>Մեր Ճաշացանկը</h4>
                           <button type="button" class="btn btn-primary show_menu">Ճաշացանկ</button>
                       </div>
                    </div>
                     <div class="img_div">
                         <img src="<?php echo base_url('assets/images/menu.jpg')?>" alt="">
                     </div>
                     </div>
                 </div>
             </div>
            </div>
        </div>

    <?php
    if(!empty($offer)){ ?>
        <div class="special_offer special_offer_hidden">
            <div class="title title_theme_sand">ՀԱՏՈՒԿ ԱՌԱՋԱՐԿՆԵՐ</div>
            <div class="specs">
                <div class="specs__row columns columns_center columns_grid">
                    <?php
                    foreach ($offer as $index => $val){ ?>
                    <div class="columns__col columns__col_3">
                        <div class="specs__item">
                            <a href="<?php echo base_url('home/single_offer/').$val['id']?>" class="preview preview_specs">
                                <span class="preview__img-wrapper">
                                    <img class="preview__img" src="<?php echo base_url('image_upload/offers/').$val['image'];?>" alt="">
                                </span>
                                <span class="preview__name lazyimgs"><?php echo $val['title_am']?></span>
                            </a>
                        </div>
                    </div>
                   <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
 <div class="address address_hidden">
     <a target="_blank" href="https://wego.here.com/directions/mix//Prime-Hall,-Yeghvard-Highway,-dzor-3,-No-1,-0054-Yerevan,-Armenia:e-eyJuYW1lIjoiUHJpbWUgSGFsbCIsImFkZHJlc3MiOiJZZWdodmFyZCBIaWdod2F5LCBkem9yIDMsIE5vIDEsIFx1MDQxNVx1MDQ0MFx1MDQzNVx1MDQzMlx1MDQzMFx1MDQzZCIsImxhdGl0dWRlIjo0MC4yMTk0MDQ1MjgyMjEsImxvbmdpdHVkZSI6NDQuNTAzMjk3ODA1Nzg2LCJwcm92aWRlck5hbWUiOiJmYWNlYm9vayIsInByb3ZpZGVySWQiOjE3Nzc4MjQ5NjM5MzYyOH0=?map=40.2194,44.5033,15,normal&fb_locale=ru_RU">
         Ինչպես հասնել
     </a>
 </div>
<div id="map" class="map_hidden" style="height:400px;"></div>
</section>
<!--Modals-->
<div class="modal" id="menu_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="menu_book show_menu_answer" id="menu_book">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal login-fast inform-fast" id="reservetion_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">լրացրեք տվյալները</h2>
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
                            <div class="col-4 control-label value-index">Օր<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control res_date reservetion_date_calendar"  name="date" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Անուն<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control"  name="first_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Ազգանուն<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control" maxlength="20" name="last_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Հեռ․<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="tel" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Մասնակիցների քանակը․<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="number_part" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Էլ․ հասցե:
                            </div>
                            <div class="col-8  value-info">
                                <input type="email" class="form-control"  name="email" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-8 control-label value-index">
                            </div>
                            <div class="col-4  value-info">
                                <button type="button" id="save_reservetion" class="btn btn-primary">Հաստատել</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"
        async defer></script>
