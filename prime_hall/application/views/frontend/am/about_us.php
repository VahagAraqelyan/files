<section class="filter filter_offer">
    <div class="menu">
        <ul>
            <li><a data-id="home" href="<?php echo base_url();?>">ԳԼԽԱՎՈՐ</a></li>
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
            <li><a data-id="home" href="<?php echo base_url();?>">ԳԼԽԱՎՈՐ</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('gallery')?>">ԼՈՒՍԱՆԿԱՐՆԵՐ</a></li>
            <li><a data-id="book_now" href="#">ԱՄՐԱԳՐԵԼ</a></li>
            <li><a data-id="our_us" href="<?php echo base_url('about_us')?>">ՄԵՐ ՄԱՍԻՆ</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('contact_us')?>">ՀԵՏԱԴԱՐԶ ԿԱՊ</a></li>
        </ul>
    </div>
    <div class="about_us image_main">
        <img src="<?php echo base_url('assets/images/banner.jpg');?>">
    </div>
    <div class="container">
        <div class="offer_main">

            <div class="content offer_main">
                <h3>ՄԵՐ ՄԱՍԻՆ</h3>
                <div class="about_us_content">
                    <p>Բարև Հարգելի գործընկեր.</p>

                    <p>  Սիրով Ձեր ուշադրությանն ենք ուզում ներկայացնել նոր շքեղ հանդիսությունների, միջոցառումների, համերգների և շնորհանդեսների սրահ մեր քաղաքում՝ նախատեսված մինչև 600 անձի համար։</p>

                    <p>Առավելություններ</p>

                    <ul>
                        <li>*Տեղակայված է քաղաքի ներսում (Դավթաշեն, Եղվարդի խճուղի, Ձոր 3), բայց շուրջն ունի հիանալի բնություն և հանգստություն</li>
                        <li> *Սրահում բացակայում են սյուները</li>
                        <li>*Ունի բացառիկ մեծ և պրոֆեսիոնալ բեմ՝ ետնաբեմով</li>
                        <li>*Հագեցած է վերջին հնարավորության ձայնային և լուսային տեխնիկայով</li>
                        <li>*Աշխատանքները վստահում է միայն իրենց գործի լավագույն մասնագետներին</li>
                        <li>*Ունի դիզայներական բացառիկ լուծում (ցանցային կամարներ սրահի ներսում)</li>
                        <li>*Մատուցում է հատուկ իր համար ստեղծված տարբերվող ճաշացանկ, ունենալով հայտնի և տաղանդավոր շեֆ խոհարար</li>
                        <li>*Ունի մեծ ավտոկայանատեղի, հարուստ բար, գիտակ բարմեն և գեղեցիկ սպասասրահ</li>
                        <li>*Ներկայանալի սպասք, գեղեցիկ մատուցում, բարեկիրթ մատուցողական կազմ և այլն....</li>
                    </ul>

                    <p>
                        Սիրով ձեզ առաջարկում ենք հյուրընկալվել մեզ մոտ և գնահատել այն ինչ ստեղծված է Ձեր վայելքի համար։ Մենք ընդունում ենք կորպորատիվ հայտեր ցանկացած ֆորմատի միջոցառման համար։ Ինչպես նաև առաջարկում ենք պիրատեխնիկա, հատուկ էֆֆեկտներ, յուրահատուկ շոու ծրագիր, ձևավորման մեծ տեսականի և ամեն ինչ Ձեր երեկոյի գեղեցիկ կազմակերպման համար։
                    </p>
                    <p>Հարգանքներով՝ «Prime Hall»</p>

                </div>
            </div>
        </div>
    </div>
</section>

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
