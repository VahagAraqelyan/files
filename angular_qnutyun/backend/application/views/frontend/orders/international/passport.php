<?php
if($order_info['shipping_status'] > SUBMITTED_STATUS[0]){

    $disable = 'disabled';

}else{
    $disable = '';
}
?>
<div class="col-md-8 col-sm-12 mobile-full">
    <div class="list-colored-block">
        <h2>Please upload passport & visa copy</h2>
        <p class="lights">Please scan or take a picture of the passport photo page & visa information page, and upload below. If you do not travel, it is not necessary to upload these files. </p>

        <form method="post">
            <div class="col-md-12 text-center ">
                <ul class="document-files full ">
                    <?php if(!empty($passport_info['passport_file'])){ ?>

                        <li>
                            <div class="image_div">
                                <img class='delete_img delete_passport_img delete_passport_copy' data_name = 'passport_file' data-blok='<?php echo $passport_info['passport_file']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                <a href="<?php echo base_url('order/user_file/'.$passport_info['passport_file'].'/'.$order_info['id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                <span>Passport Copy</span>
                            </div>
                        </li>

                   <?php } ?>
                    <?php if(!empty($passport_info['visa_file'])){ ?>

                        <li>
                            <div class="image_div">
                                <img class='delete_img delete_passport_img delete_visa_copy' data_name = 'visa_file' data-blok='<?php echo $passport_info['visa_file']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                <a href="<?php echo base_url('order/user_file/'.$passport_info['visa_file'].'/'.$order_info['id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                <span>Visa Copy</span>
                            </div>
                        </li>

                    <?php } ?>
                </ul>
            </div>
            <div class="form-horizontal id-cards">
                <div class="form-group">
                    <label for="" class="col-sm-push-1 col-sm-3 col-xs-6 hidden-xs control-label text-left padding-right-0">Passport Number:</label>
                    <div class="col-sm-push-1 col-sm-3 col-xs-6 mob-input padding-left-0 pass-number">
                        <input type="text" <?php echo $disable; ?> class="form-control passport_copy" name="passport_number" placeholder="Passport Number" value="<?php echo $passport_info['passport_number']?>">
                    </div>
                    <div class="col-sm-push-1 col-sm-3 col-xs-6 mob-input padding-left-0">
                        <select class="form-control selectpicker select-country" id="passport_issue_country" <?php echo $disable; ?> name="passport_issue_country">
                            <option value="">Issue Country</option>
                            <?php
                            foreach($all_countries as $value){
                                $k = (!empty($passport_info['passport_country_id'])&& $passport_info['passport_country_id'] ==  $value["id"])?"selected = 'selected'":'';

                                ?>
                                <option <?php echo $k; ?> value="<?php echo $value["id"]; ?>" ><?php echo $value['country']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-push-1 col-sm-6 col-xs-8 control-label acceptable-format text-right padding-right-0">
                        File format: JPEG, PDF; Size up to 10M.
                    </label>
                    <?php

                    if($order_info['shipping_status']<=SUBMITTED_STATUS[0]){ ?>

                        <div class="col-sm-push-1 col-sm-3 col-xs-4 mob-input text-right padding-left-0">
                            <button type="button" class="btn btn-default btn-login-orange save-action save_passport">Save</button>
                        </div>
                    <?php } ?>

                </div>
                <div class="form-group">
                    <label for="" class="col-sm-push-1 col-sm-3 col-xs-6 control-label text-left padding-right-0">Passport Copy:</label>
                    <div class="col-sm-push-1 col-sm-6 col-xs-6 mob-input padding-left-0">
                        <label class="btn btn-default btn-file select-doc-file">
                            Choose File <input type="file"  name="passport_file" class="form-control" id="passport_copy" style="display: none;">
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-push-1 col-sm-3 col-xs-6 control-label text-left padding-right-0">Visa Copy:</label>
                    <div class="col-sm-push-1 col-sm-6 col-xs-6 mob-input padding-left-0">
                        <label class="btn btn-default btn-file select-doc-file">
                            Choose File <input type="file"  name="visa_file" class="form-control" id="visa_copy" style="display: none;">
                        </label>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-sm-12 mobile-top-margin mobile_version">
                <div class="">
                    <div class=" text-left item_info_mobile" data-toggle="collapse" data-target="#passport_info_mobile">
                        <img src="<?php echo base_url();?>assets/images/officer.svg">
                        <span>Passport & Custom Clearance</span>
                    </div>
                    <div class="collapse"  id="passport_info_mobile">
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
                                    <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Why_do_you_ask_for_my_passport_copy');?>">Why do you ask for my passport copy?</a></li>
                                    <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Top_Tips_for_uploading_your_Passport');?>">Top Tips for uploading your Passport</a></li>
                                    <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_happens_to_my_Passport_after');?>"> What happens to my Passport after?</a></li>
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
<div class="col-md-4 col-sm-12 mobile-top-margin pc_version">
    <div class="progress-small-block">
        <div class="bl-header text-left">
            <img src="<?php echo base_url();?>assets/images/officer.svg"> Passport & Custom Clearance
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
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Why_do_you_ask_for_my_passport_copy');?>">Why do you ask for my passport copy?</a></li>
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/Top_Tips_for_uploading_your_Passport');?>">Top Tips for uploading your Passport</a></li>
                <li><a target="_blank" href="<?php echo base_url('luggage-and-question/What_happens_to_my_Passport_after');?>"> What happens to my Passport after?</a></li>
            </ul>
        </div>
    </div>

</div>
