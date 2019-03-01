<div class="panel-heading">
    <div class="row">
        <div class="col-md-7 mobile-hidden"><strong>Address Book:</strong> <span class="small_font"> You can choose a traveler from your traveler list when you place an order.</span></div>
        <div class="col-md-3 text-right">
            <?php echo $links; ?>
        </div>
    </div>

</div>
<div class="panel-body">
    <?php

        foreach($address_book as $single){
            ?>
            <div class="designed-info-row" addres-book-data="<?php echo $single['id']; ?>">
                <div class="tr-checkbox"><label><?php if($single['user_id'] != 0){?><input type="checkbox" name="addr_book[]" class="address_book_list_checkbox" value="<?php echo $single['id']; ?>"><?php } ?></label></div>
                <div class="tr-name add-book"><?php echo (empty($single['contact_id']))?'<div class="tr-empty"></div>':$single['contact_id']; ?></div>
                <div class="tr-city add-book"><?php echo $single['city']; ?></div>
                <div class="tr-region-short"><?php echo $single['s_code']; ?></div>
                <div class="tr-region add-book"><?php echo $single['State']; ?></div>
                <div class="tr-country-short"><?php echo $single['iso2']; ?></div>
                <div class="tr-country add-book"><?php echo $single['country']; ?></div>
                <div class="tr-detail"><a href="" class="list-details view_address_book" data-toggle="modal" data-target="#my_profile_modal" data-blok="<?php echo $single['id']; ?>"><i class="fa fa-list-ul"></i></a></div>
            </div>
            <?php
        }

    ?>
</div>