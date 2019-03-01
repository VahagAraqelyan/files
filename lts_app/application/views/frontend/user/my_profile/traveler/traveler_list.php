<div class="panel-heading">
    <div class="row">
        <div class="col-md-7 mobile-hidden"><strong>Traveler’s List:</strong><span class="small_font"> You can choose a traveler from your traveler list when you place an order.</span> </div>
        <div class="col-md-3 text-right">

            <?php echo $links; ?>

        </div>
    </div>

</div>
<form action="travel_list_form" id="travel_list_form">
<div class="panel-body">
    <?php foreach($travel_list as $trav) { ?>

        <div class="designed-info-row" data-id="<?php echo $trav['id']; ?>">
            <div class="tr-checkbox"><label><?php if($trav['user_id'] != 0) {?><input type="checkbox" name="traveler_id[]" class="traveler_list_checkbox" value="<?php echo $trav['id']; ?>"><?php } ?></label></div>
            <div class="tr-name"><?php echo $trav['first_name'].' '.$trav['last_name']; ?></div>
            <div class="tr-phone"><?php echo $trav['phone']; ?></div>
            <div class="tr-mail"><?php echo $trav['email']; ?></div>
            <div class="tr-city"><?php echo $trav['city']; ?></div>
            <div class="tr-region-short"><?php echo $trav['s_code']; ?></div>
            <div class="tr-region"><?php echo $trav['State']; ?></div>
            <div class="tr-country-short"><?php echo $trav['iso2']; ?></div>
            <div class="tr-country"><?php echo $trav['country']; ?></div>
            <div class="tr-detail"><a href="" class="list-details details_modal trav_inf view_traveler_info" id="view_traveler_info" data-name="traveller_details_modal" data-toggle="modal" data-target="#my_profile_modal" data-blok="<?php echo $trav['id']; ?>"><i class="fa fa-list-ul"></i></a></div>
        </div>

    <?php } ?>
</div>
</form>