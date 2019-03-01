
<?php
$language = $this->language_lib->switch_language();
if($language == 'en'){

    $address = 'Yeghvard Highway, dzor 3, № 1 Ереван';
    $tel     = 'Tel';

}elseif ($language == 'ru'){
    $address = 'Егвардское шоссе, Дзор 3, № 1 Ереван';
    $tel     = 'Тел';

}else{
    $address = 'Եղվարդի խճուղի, Ձոր 3, թիվ 1 Երևան';
    $tel     = 'Հեռ';
}
?>
<footer class="footer footer_hidden">
<div class="footer_conteiner">
    <div class="social-header-wrap">
        <ul>
            <li class="social-icon">
                <a class="ntips" title="Facebook" href="https://www.facebook.com/Prime.Hall.Restaurant/" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
           <!-- <li class="social-icon">
                <a class="ntips" title="Twitter" href="#" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li class="social-icon">
                <a class="ntips" title="Google+" href="#" target="_blank">
                    <i class="fa fa-google-plus"></i>
                </a>
            </li>-->
            <li class="social-icon">
                <a class="ntips" title="Youtube" href="https://www.youtube.com/watch?v=I4ENlJi0Z6Q " target="_blank">
                    <i class="fa fa-youtube"></i>
                </a>
            </li>
            <li class="social-icon">
                <a class="ntips"  title="Instagram" href="https://www.instagram.com/primehall_restaurant" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            </li>
            <li class="address-text">
                <i class="fa fa-map"></i><?php echo $address; ?>
            </li>
            <li class="contact-text">
                <a href="tel:+37444361010"><i class="fa fa-phone-square"></i><?php echo  $tel; ?>: +374 44 36 10 10</a>
            </li>
        </ul>
    </div>
</div>
</footer>
<script src="<?php echo base_url();?>assets/js/frontend/bottom.main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-48473629-3"></script>
-->