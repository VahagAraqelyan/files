<?php
if($order_info['shipping_status'] > SUBMITTED_STATUS[0]){

    $disable = 'disabled';

}else{
    $disable = '';
}
?>
   <div class="col-md-8 col-sm-12 mobile-full">
    <div class="list-colored-block">
        <h2>Please provide travel itinerary information </h2>
        <p class="lights">If you do not travel, it is not necessary to fill in and upload your itinerary information.</p>
        <div class="flight-form">
            <form method="post" id="travel_form">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                    <h5>How are you arriving in to <?php echo $country_to; ?></h5>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 hidden-xs text-right">
                            Arriving By:
                        </div>
                        <div class="col-md-6 col-sm-6 text-left">
                            <ul>
                                <li><input type="radio" value="0" <?php echo $disable; ?> name="arriving_by" <?php echo ($travel_info['arriving_by'] == '0')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/plane.png"> Airplane </li>
                                <li><input type="radio" value="1" <?php echo $disable; ?> name="arriving_by" <?php echo ($travel_info['arriving_by'] == '1')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/ship.png"> Cruise </li>
                                <li><input type="radio" value="2" <?php echo $disable; ?> name="arriving_by" <?php echo ($travel_info['arriving_by'] == '2')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/car.png"> Car / Bus </li>
                                <li><input type="radio" value="3" <?php echo $disable; ?> name="arriving_by" <?php echo ($travel_info['arriving_by'] == '3')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/train.png"> Train </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" <?php echo $disable; ?> name="arrival_city" value="<?php echo $travel_info['arrival_city']; ?>" placeholder="Arrival City">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control shipping_date " <?php echo $disable; ?>  value="<?php echo ($travel_info['arrival_date'] != '0000-00-00')?$travel_info['arrival_date']:''; ?>"  name="arrival_date" id="arrival_date" placeholder="Arrival Date">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="arrival_ticked_number" <?php echo $disable; ?> value="<?php echo $travel_info['arrival_ticked_number']; ?>" placeholder="Flight / Ticket Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="arrival_cruise_name" <?php echo $disable; ?> value="<?php echo $travel_info['arrival_cruise_name']; ?>" placeholder="Airline / Cruise Name">
                    </div>

                    <div class="border-right"></div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                    <h5>How are you leaving from <?php echo $country_from; ?></h5>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 hidden-xs text-right">
                            Leaving By:
                        </div>
                        <div class="col-md-6 col-sm-6 text-left">
                            <ul>
                                <li><input type="radio" <?php echo $disable; ?> value="0" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '0')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/plane.png"> Airplane </li>
                                <li><input type="radio" <?php echo $disable; ?> value="1" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '1')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/ship.png"> Cruise </li>
                                <li><input type="radio" <?php echo $disable; ?> value="2" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '2')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/car.png"> Car / Bus </li>
                                <li><input type="radio" <?php echo $disable; ?> value="3" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '3')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/train.png"> Train </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" <?php echo $disable; ?> name="departure_city" value="<?php echo $travel_info['departure_city']; ?>" placeholder="Departure City">
                    </div>
                    <div class="form-group">
                        <input type="text" <?php echo $disable; ?> class="form-control shipping_date " value="<?php echo ($travel_info['departure_date'] != '0000-00-00')?$travel_info['departure_date']:''; ?>" name="departure_date" id="departure_date" placeholder="Departure Date">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" <?php echo $disable; ?> name="ticked_number" value="<?php echo $travel_info['ticked_number']; ?>" placeholder="Flight / Ticket Number">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" <?php echo $disable; ?> name="departure_cruise_name" value="<?php echo $travel_info['departure_cruise_name']; ?>" placeholder="Airline / Cruise Name">
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="doc-file-place">
                    <ul class="document-files full">
                        <?php foreach ($travel_info_file as $index => $trav_info){ ?>
                            <li>
                                <div class="image_div ">
                                    <img class='itinary_travel_img_delete_img delete_img ' data_id='<?php echo $trav_info['id']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                    <a href="<?php echo base_url('order/user_file/'.$trav_info['file_name'].'/'.$travel_info['order_id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                    <span class="blue-color">Ticket <?php echo $index+1;?></span>

                                </div>
                            </li>
                       <?php } ?>
                    </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-push-1 col-sm-6 col-xs-8 control-label acceptable-format text-right">
                        File format: JPEG, PDF; Size up to 10M.
                    </label>
                    <?php

                    if($order_info['shipping_status']<=SUBMITTED_STATUS[0]){ ?>

                        <div class="col-sm-push-1 col-sm-3 col-xs-4 mob-input text-right padding-left-0">
                            <button type="button" class="btn btn-default btn-login-orange save-action save_travel">Save</button>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-horizontal id-cards">
                    <div class="form-group">
                        <label for="" class="col-sm-push-1 col-sm-3 col-xs-6 control-label text-left padding-right-0">Upload Itinerary:</label>
                        <div class="col-sm-push-1 col-sm-6 col-xs-6 mob-input padding-left-0 file-col">
                            <label class="btn btn-default btn-file select-doc-file">
                                Upload File <input type="file" <?php echo $disable; ?> id="travel_file" name="input_file" class="form-control" style="display: none;">
                            </label>
                        </div>
                    </div>

                </div>


                <div class="col-md-4 col-sm-12 mobile-top-margin mobile_version">

                    <div class="">
                        <div class="mobile_version col-xs-12 item_info_mobile">
                            <div class="item_info_mobile text-left" data-toggle="collapse" data-target="#travel_info_mobile">
                                <img src="<?php echo base_url(); ?>assets/images/officer.svg">
                                <span>International Travel</span>
                            </div>
                        </div>
                        <div  class="collapse"  id="travel_info_mobile">
                            <div class="bl-content small_font_size">
                                <p>
                                    If you travel and ship your used personal effects or sport equipment, we recommend our customers to provide the travel itinerary to the customs authority of the destination country to confirm the items are temporary importing for personal use.
                                </p>
                                <p>We use SSL with 256 bit encryption security system. Your travel itinerary information will be securely saved in our system, and will be deleted once the order is closed. You are able to delete the itinerary information anytime in our system.</p>
                            </div>


                            <div class="progress-small-block">
                                <div class="bl-header text-center">FAQ</div>
                                <div class="bl-content faq_links">
                                    <ul>
                                      <!--  <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#passport_id">Why do we need a Passport or ID ?</a></li>
                                        <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#passport">What do we do with your Passport?</a></li>
                                        <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#after_passport">What happens to my Passport after?</a></li>
                                        <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#your_passport">Top Tips for uploading your Passport</a></li>-->


                                       <!-- <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#passport_id">Why do we need a copy of a flight ticket?</a></li>
                                        <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#passport">What does my ticket need to show?</a></li>
                                        <li><a target="_blank" href="<?php /*echo base_url()*/?>faq#after_passport">What happens to my ticket after?</a></li>-->
                                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Why_do_you_ask_for_my_travel_itinerary');?>">Why do you ask for my travel itinerary?</a></li>
                                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_does_my_ticket_need_to_show');?>">What does my ticket need to show?</a></li>
                                        <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_happens_to_my_ticket_after');?>"> What happens to my ticket after?</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="clearfix"></p>
            </form>

        </div>

    </div>
</div>
<div class="col-md-4 col-sm-12 mobile-top-margin pc_version">
    <div class="progress-small-block">
        <div class="bl-header text-left">
            <img src="<?php echo base_url(); ?>assets/images/officer.svg"> International Travel
        </div>
        <div class="bl-content">
            <p>
                If you travel and ship your used personal effects or sport equipment, we recommend our customers to provide the travel itinerary to the customs authority of the destination country to confirm the items are temporary importing for personal use.
            </p>
            <p>We use SSL with 256 bit encryption security system. Your travel itinerary information will be securely saved in our system, and will be deleted once the order is closed. You are able to delete the itinerary information anytime in our system.</p>
        </div>
    </div>

    <div class="progress-small-block">
        <div class="bl-header text-center">FAQ</div>
        <div class="bl-content faq_links">
            <ul>
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Why_do_you_ask_for_my_travel_itinerary');?>">Why do you ask for my travel itinerary?</a></li>
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_does_my_ticket_need_to_show');?>">What does my ticket need to show?</a></li>
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_happens_to_my_ticket_after');?>"> What happens to my ticket after?</a></li>
            </ul>
        </div>
    </div>

</div>


