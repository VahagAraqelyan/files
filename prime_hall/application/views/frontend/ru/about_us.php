<section class="filter filter_offer">
    <div class="menu">
        <ul>
            <li><a data-id="home" href="<?php echo base_url('ru/home')?>">ГЛАВНЫЙ</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('ru/gallery')?>">ФОТОГРАФИИ</a></li>
            <li><a data-id="book_now" class="book_now" href="#">Забронировать мероприятие</a></li>
            <!--<li class="menu_logo"><a data-id="" href="<?php /*echo base_url();*/?>">
                <img src="<?php /*echo base_url('assets/images/logo_prime_hall.jpg')*/?>" alt="">
            </a></li>-->
            <li><a data-id="our_us" href="<?php echo base_url('ru/about_us')?>">О НАС</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('ru/contact_us')?>">КОНТАКТЫ</a></li>
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
            <li><a data-id="home" href="<?php echo base_url('ru/home')?>">ГЛАВНЫЙ</a></li>
            <li><a data-id="gallery" href="<?php echo base_url('ru/gallery')?>">ФОТОГРАФИИ</a></li>
            <li><a data-id="book_now" href="#">Забронировать мероприятие</a></li>
            <li><a data-id="our_us" href="<?php echo base_url('ru/about_us')?>">О НАС</a></li>
            <li><a data-id="contact_us" href="<?php echo base_url('ru/contact_us')?>">КОНТАКТЫ</a></li>
        </ul>
    </div>
    <div class="about_us image_main">
        <img src="<?php echo base_url('assets/images/banner.jpg');?>">
    </div>
    <div class="container">
        <div class="offer_main">

            <div class="content offer_main">
                <h3>О НАС</h3>
                <div class="about_us_content">
                    <h4>
                        <b>
                            ПРАЗДНИК ДОЛЖЕН БЫТЬ КРАСИВЫМ.
                        </b>
                    </h4>

                    <p>
                        <b>
                            НОВЫЙ РОСКОШНЫЙ ЗАЛ В ЕРЕВАНЕ НА 600 ЧЕЛОВЕК
                        </b>
                    </p>

                    <p>
                        <b>
                            ДЛЯ ТОРЖЕСТВ, МЕРОПРИЯТИЙ, КОНЦЕРТОВ И ПРЕЗЕНТАЦИЙ
                        </b>
                    </p>
                    <p><b>Преимущества</b></p>

                    <ul>
                        <li>
                            *ЗАЛ РАСПОЛОЖЕН ПО АДРЕСУ: Г.ЕРЕВАН, ДАВИТАШЕН, 3-Е УЩЕЛЬЕ,
                            ИДЕАЛЬНОЕ МЕСТО ДЛЯ НАСЛАЖДЕНИЯ ВЕЛИКОЛЕПНОЙ ПРИРОДОЙ
                            РАЗДАНСКОГО УЩЕЛЬЯ
                        </li>
                        <li>
                            *В ПРОСТОРНОМ ЗАЛЕ ОТСУТСТВУЮТ КОЛОННЫ</li>
                        <li>
                            *ИСКЛЮЧИТЕЛЬНО БОЛЬШАЯ И ПРОФЕССИОНАЛЬНАЯ СЦЕНА И ЗАКУЛИСЬЕ
                        </li>
                        <li>
                            *ЗАЛ ОСНАЩЕН СУПЕРСОВРЕМЕННОЙ СВЕТОВОЙ И ЗВУКОВОЙ ТЕХНИКОЙ
                        </li>
                        <li>
                            *ДАНЫ БЕСПРЕЦЕДЕНТНЫЕ ДИЗАЙНЕРСКИЕ РЕШЕНИЯ
                        </li>
                        <li>
                            * ВСЕ БЛЮДА ГОТОВЯТСЯ ПОД НАБЛЮДЕНИЕМ
                            ВЫСОКОКВАЛИФИЦИРОВАННОГО ШЕФ-ПОВАРА
                        </li>
                        <li>
                            * НАПРОТИВ ЗАЛА РАСПОЛАГАЕТСЯ ПРОСТОРНАЯ АВТОСТОЯНКА
                        </li>
                        <li>
                            * БЛЮДА ПОДАЮТСЯ ЗАРУБЕЖНЫМ СТОЛОВЫМ СЕРВИЗОМ ВЫСОКОГО
                            КАЧЕСТВА
                        </li>
                        <li>
                            У НАС ОПЫТНЫЙ И ПРОФЕССИОНАЛЬНЫЙ ОБСЛУЖИВАЮЩИЙ СОСТАВ
                        </li>
                    </ul>

                    <p>
                      <b>
                          МЫ ОБЕСПЕЧИМ ОТЛИЧНОЕ НАСТРОЕНИЕ И ПРИЯТНОЕ
                          ВРЕМЯПРЕПРОВОЖДЕНИЕ!
                      </b>
                    </p>
                    <p>
                        <b>
                            С УВАЖЕНИЕМ «Prime Hall»
                        </b>
                    </p>
                    <p>
                       <b>
                           ИЗ ЖЕЛАНИЯ В ДЕЙСТВИТЕЛЬНОСТЬ
                       </b>
                    </p>

                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal login-fast inform-fast" id="reservetion_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="register-title text-center">заполнить данные</h2>
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
                            <div class="col-4 control-label value-index">День<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control res_date reservetion_date_calendar"  name="date" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Имя<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control"  name="first_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Фамилия<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control" maxlength="20" name="last_name" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Тел.<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="tel" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Количество участников<span class="important">*</span>:
                            </div>
                            <div class="col-8 value-info">
                                <input type="text" class="form-control not_number" maxlength="20" name="number_part" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-4 control-label value-index">Эл. адрес:
                            </div>
                            <div class="col-8  value-info">
                                <input type="email" class="form-control"  name="email" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group my-form-group">
                            <div class="col-8 control-label value-index">
                            </div>
                            <div class="col-4  value-info">
                                <button type="button" id="save_reservetion" class="btn btn-primary">Подтвердить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


