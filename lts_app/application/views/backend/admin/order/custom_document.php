
<div class="row">
    <div class="col-md-7">
        <?php

        $class1 = (!empty($item_list))?'fa fa-check delivered-icon':'fa fa-exclamation created-icon';
        $class2 = (!empty($passport))?'fa fa-check delivered-icon':'fa fa-exclamation created-icon';
        $class3 = (!empty($travel))?'fa fa-check delivered-icon':'fa fa-exclamation created-icon';
        $dis_class = ($order_info['order_type'] == 2)?'dis_none':'';
        ?>
        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title"> </span> <i class="<?php echo $class1; ?>" id="icon_h3"></i></h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal">
                    <div class="col-md-12">
                        <p>Personal Luggage Customs Value Limit <strong><?php echo $custom_value; ?></strong> When You Ship To <strong><?php echo $country_info['country']; ?></strong></p>

                        <form method="post" class="form-horizontal" action="">

                            <div class="order_type">
                                <span>
                                     <input <?php echo ($order_info['order_type'] == 1)?'checked = "checked"':""; ?> <?php echo ($action == 'view')?'disabled':''; ?> type="radio" class="order_type individual" name="order_type" value="1"><span class="order_type_name">Personal Effects</span>
                                     <span class="order_type_popover popover-style secure-code hidden-sm hidden-xs"data-container="body" data-toggle="popover"
                                          data-trigger="hover"data-placement="top"data-content="Those used personal articles such as unaccompanied baggage and household goods being shipped for relocation."data-original-title="" title=""></span>
                                </span>
                                <span>
                                    <input <?php echo ($order_info['order_type'] == 2)?'checked = "checked"':""; ?> <?php echo ($action == 'view')?'disabled':''; ?> type="radio" class="order_type comertial" name="order_type" value="2"><span class="order_type_name">Commercial Use</span>
                                     <span class="order_type_popover popover-style secure-code hidden-sm hidden-xs" data-container="body" data-toggle="popover"
                              data-trigger="hover" data-placement="top" data-content="Any shipment being sold or sent free of charge, for the purpose of being re-sold or otherwise consumed." data-original-title="" title=""></span>
                                </span>

                            </div>

                            <?php if($action == 'add') {
                                if(!empty($order_item_list)){
                                ?>
                            <div class="lists-block">
                                <?php
                                    $sum = 0;
                                    $all_sum = 0;
                                    $quanity_sum = 0;
                                    foreach ($order_item_list as $index => $item_list) {
                                        $sum = floatval($item_list['item_count']) * floatval($item_list['item_price']);
                                        $all_sum += $sum;
                                        $quanity_sum+= floatval($item_list['item_count']);
                                        $class = ($index > 0) ? 'new-adding-place' : '';
                                        ?>
                                        <div class="<?php echo $class; ?>">
                                            <div class="list-item-area new-adding-place my_list_class">
                                                <div class="col-sm-5 col-xs-11 list-input">
                                                    <?php
                                                    $isset_item = false;
                                                    $options = "";
                                                    foreach ($item_name as $object) {

                                                        $k = "";

                                                        if($item_list['item_name'] == $object->title){
                                                            $isset_item = true;
                                                            $k = "selected = 'selected'";
                                                        }

                                                        $options .= "<option value='$object->title' $k>$object->title</option>";

                                                    }
                                                    if($isset_item){
                                                        ?>
                                                        <select class="form-control selectpicker select-country item_list_select" name="names[]">
                                                            <option value="">Please select tems name</option>
                                                            <option value="new">Add New Item</option>
                                                            <?php echo $options; ?>
                                                        </select>
                                                        <?php

                                                    }else{
                                                        ?>
                                                        <input type="text" name="names[]" value="<?php echo $item_list['item_name']; ?>" class="form-control placeholder_class item_input_class" placeholder="Inser Item Name">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-2 col-xs-4 list-input">
                                                    <input type="text"
                                                           class="form-control quantity_value_<?php echo $index + 1; ?> count_item unit_val"
                                                           data_count="<?php echo $index + 1; ?>" name="counts[]"
                                                           value="<?php echo $item_list['item_count']; ?>" placeholder="Quantity">
                                                </div>
                                                <div class="col-sm-2 col-xs-4 list-input">
                                                    <input type="text"
                                                           class="form-control unit_value_<?php echo $index + 1; ?> unit_value unit_val"
                                                           data_count="<?php echo $index + 1; ?>" name="prices[]"
                                                           value="<?php echo $item_list['item_price']; ?>" placeholder="Unit Value">
                                                </div>
                                                <div class="col-sm-2 col-xs-4 list-input">
                                                    <span class="col-padding sum_row_<?php echo $index + 1; ?> sum_all_row orange-color">$ <?php echo $sum; ?></span>
                                                </div>

                                                <div class="item-delete"><a href="" class="remove-more-item red-color"><i
                                                                class="fa fa-times"></i></a></div>

                                            </div>
                                        </div>
                             <?php }  ?>
                                <div class="add_more_fields">

                                </div>
                            </div>
                                    <div class="lists-block-add-item">
                                        <div class="col-sm-5 col-xs-12">
                                            <a href="#" class="add-more-item">Add More Item</a>
                                        </div>
                                        <div class="col-sm-3 col-xs-6 text-center">
                                            Total <span class="total-quantity"><?php echo $quanity_sum; ?></span>
                                        </div>
                                        <div class="col-sm-4 col-xs-6 text-center">
                                            <span class="total-price">$ <?php echo (!empty($all_sum)) ? $all_sum : 0; ?></span>
                                        </div>
                                    </div>
                            <?php }else{ ?>
                                    <div class="add_more_fields">

                                    </div>
                                    <div class="lists-block-add-item">
                                        <div class="col-sm-5 col-xs-12">
                                            <a href="#" class="add-more-item">Add More Item</a>
                                        </div>
                                        <div class="col-sm-3 col-xs-6 text-center">
                                            Total <span class="total-quantity">0</span>
                                        </div>
                                        <div class="col-sm-4 col-xs-6 text-center">
                                            <span class="total-price">0</span>
                                        </div>
                                    </div>
                                <?php } } ?>
                            <?php if($action == 'view') { ?>
                                <table class="table designed-table table-bordered t-payment item-list-filled-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Value</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sum = 0;
                                    $all_sum = 0;
                                    $total_count = 0;
                                    foreach ($order_item_list as $index => $item_list) {
                                        $sum = floatval($item_list['item_count']) * floatval($item_list['item_price']);
                                        $all_sum += $sum;
                                        $total_count  +=$item_list['item_count'];
                                        $name = '';
                                        foreach ($item_name as $object) {


                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $index+1; ?></td>
                                            <td><span class="orange-color"><?php echo $item_list['item_name'];?></span></td>
                                            <td><span class="orange-color"><?php echo $item_list['item_count'];?></span></td>
                                            <td><span class="orange-color">$ <?php echo $item_list['item_price'];?></span></td>
                                            <td><span class="orange-color">$ <?php echo $sum;?></span></td>
                                        </tr>

                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <div class="col-sm-5 col-xs-7">

                                            </div>
                                            <div class="col-sm-3 col-xs-5 text-center">
                                                Total: <span class="total-quantity"><?php echo $total_count; ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center">$ <?php echo $all_sum; ?></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="doc-file-place">
                                        <ul class="">
                                            <?php if (!empty($uploaded_document)) {

                                                foreach ($uploaded_document as $document) { ?>

                                                    <li>
                                                        <div class="image_div">
                                                            <img class='admin_order_delete_img' data_id='<?php echo $document['id']; ?>'
                                                                 src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                            <a href="<?php echo base_url('admin/order/user_file/' . $document['file_name'] . '/' . $order_info['id']. '/' . $order_info['user_id']); ?> "
                                                               target="_blank"> <img class="main_img"
                                                                                     src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                                        </div>
                                                    </li>
                                                <?php }

                                            } ?>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="info-for-inline">
                                <?php if($action == 'add') { ?>
                                <div class="col-md-5 text-right">
                                    <label class="btn btn-default btn-file select-doc-file">
                                        Upload own item list <input type="file" id="upload_file_item_list" name="input_file" class="form-control" style="display: none;">
                                    </label>
                                </div>
                                <?php } ?>
                               <!-- <div class="col-md-7">
                                    <span class="">Input declared value: </span>
                                    <input type="text" name="" class="form-control small-input">
                                    <span> USD</span>
                                </div>-->
                            </div>
                            <?php if($action == 'add') { ?>
                            <div class="row signature-block">
                                <div class="col-md-9">
                                    <div id="signature_img"><img src="data:<?php echo $order_info['signature']; ?>" alt=""></div>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-default btn-login-orange adm-btn pull-right edit_all_item_list">Save</button>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($action == 'view') { ?>
                                <div class="row signature-block">
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <?php if (!empty($order_info['signature'])) { ?>
                                            <div id="signature_img"><img src="data:<?php echo $order_info['signature']; ?>" alt=""></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                        <button type="button" class="btn btn-default btn-login-orange clear_signature_db">Edit</button><br>
                                        <a href="<?php echo base_url('admin/order/get_signature_file/'.$order_info['id']); ?>">Download Signature Image</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                        <p class="clearfix"></p>
                    </div>

                </form>
            </div>
        </div>

        <div class="panel panel-default designed-panel panel-bordered light no-margin custom_dis_none <?php echo $dis_class; ?>">
            <div class="panel-table-title">
                <h3 class="panel-title"><i class="fa fa-address-book-o"></i> Passport Information <i class="<?php echo $class2; ?>" id="paspport_h3"></i></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-5">
                    <div class="text-center">
                        <ul class="doc pass">
                            <?php if(!empty($passport_info['passport_file'])){ ?>
                                <li>
                                    <div class="image_div">
                                        <img class='admin_delete_passport_img admin_delete_passport' data_name = 'passport_file' data-blok='<?php echo $passport_info['passport_file']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                        <a href="<?php echo base_url('admin/order/user_file/'.$passport_info['passport_file'].'/'.$order_info['id'].'/'.$order_info['user_id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                        <span>Passport Copy</span>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if(!empty($passport_info['visa_file'])){ ?>
                                <li>
                                    <div class="image_div">
                                        <img class='admin_delete_passport_img admin_delete_visa_copy' data_name = 'visa_file' data-blok='<?php echo $passport_info['visa_file']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                        <a href="<?php echo base_url('admin/order/user_file/'.$passport_info['visa_file'].'/'.$order_info['id'].'/'.$order_info['user_id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                        <span>Visa Copy</span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center form-small-font">Passport number:</p>
                            <input type="text" name="" class="form-control passport_copy" value="<?php echo $passport_info['passport_number']?>">
                        </div>
                        <div class="col-md-6">
                            <p class="text-center form-small-font">Issue Country:</p>
                            <select class="form-control selectpicker select-country" name="" id="passport_issue_country">
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
                </div>
                <p class="clearfix"></p>
                <div class="col-md-5">
                    <div class="text-left form-small-font">Passport</div>
                    <label class="btn btn-default btn-file select-doc-file">
                        Choose File <input type="file" id="passport_copy" name="passport_file" class="form-control" style="display: none;">
                    </label>
                    <div class="text-left form-small-font margin-top-12">Visa & Order</div>
                    <label class="btn btn-default btn-file select-doc-file">
                        Choose File <input type="file" id="visa_copy" name="visa_file" class="form-control" style="display: none;">
                    </label>
                </div>
                <div class="col-md-7 passport-select">
                    <button type="button" class="btn btn-default btn-login-orange adm-btn pull-right admin_save_passport">Save</button>
                </div>
                <p class="clearfix"></p>
            </div>
        </div>
    </div>
    <div class="col-md-5">

        <div class="panel panel-default designed-panel panel-bordered light">
            <div class="panel-table-title">
                <h3 class="panel-title">Country Profile <span class="orange-color pull-right"><?php echo $country_info['country']; ?></span> </h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <ul class="styled-ul">
                        <li>
                            <div class="row">
                                <div class="col-md-3 padding-right-0">Custom Limit :</div>
                                <div class="col-md-3 orange-color padding-left-0"><?php echo ($custom_value == '-1')?'n/a':'$ '.$custom_value; ?></div>
                            </div>
                        </li>
                       <!-- <li>
                            <div class="row">
                                <div class="col-md-3 padding-right-0">Forms :</div>
                                <div class="col-md-3 orange-color padding-left-0">CN-123</div>
                            </div>
                        </li>-->
                    </ul>
                </div>
                <div class="col-md-8 col-md-push-4 text-right">
                   <!-- <ul class="inline-document-files">
                        <li>
                            <img class="" data-blok="8" src="<?php /*echo base_url(); */?>assets/images/download-note.svg">
                            <span>Blank Form</span>
                        </li>
                        <li>
                            <img class="" data-blok="8" src="<?php /*echo base_url(); */?>assets/images/download-note.svg">
                            <span>Sample Form</span>
                        </li>
                    </ul>-->

                    <ul class="inline-document-files">
                        <?php
                        if (!empty($form_files)) {

                            foreach ($form_files as $files) { ?>

                                <li>
                                    <a href="<?php echo base_url('admin/price_page/currier_file/' . $country_info['iso2'] . '/' . $files['doc_file_name']); ?>">
                                        <img class="" data-blok="8" src="<?php echo base_url(); ?>assets/images/download-note.svg">
                                        <span><?php echo $files['show_doc_name']; ?></span>
                                    </a>
                                </li>

                            <?php }
                        } ?>
                    </ul>
                </div>
                <div class="col-md-12">
                    <p>Note :</p>
                    <div class="note"><?php echo $note['comment']; ?></div>
                </div>
            </div>
        </div>

        <div class="panel panel-default designed-panel panel-bordered light no-margin custom_dis_none <?php echo $dis_class; ?>">
            <div class="panel-table-title">
                <h3 class="panel-title "><i class="fa fa-plane"></i> Travel Itinerary Information <i class= "<?php echo $class3; ?>" id="travel_h3"></i> </h3>
            </div>
            <form action="" method="post">
            <div class="panel-body flight-form">
                <div class="col-md-6 arriving-line">
                    <p class="form-small-font">Arriving By:</p>
                    <ul>
                         <li><input type="radio" value="0" name="arriving_by" <?php echo ($travel_info['arriving_by'] == '0')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/plane.png"> </li>
                         <li><input type="radio" value="1" name="arriving_by" <?php echo ($travel_info['arriving_by'] == '1')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/ship.png">  </li>
                         <li><input type="radio" value="2" name="arriving_by" <?php echo ($travel_info['arriving_by'] == '2')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/car.png">  </li>
                         <li><input type="radio" value="3" name="arriving_by" <?php echo ($travel_info['arriving_by'] == '3')? "checked = 'checked'":""; ?>><img src="<?php echo base_url(); ?>assets/images/train.png">  </li>
                    </ul>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="arrival_city" value="<?php echo $travel_info['arrival_city']; ?>" placeholder="Arrival City">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control shipping_date " value="<?php echo ($travel_info['arrival_date'] != '0000-00-00')?$travel_info['arrival_date']:''; ?>"  name="arrival_date" id="arrival_date" placeholder="Arrival Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="arrival_ticked_number" value="<?php echo $travel_info['arrival_ticked_number']; ?>" placeholder="Flight / Ticket Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="arrival_cruise_name" value="<?php echo $travel_info['arrival_cruise_name']; ?>" placeholder="Airline / Cruise Name">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="form-small-font">Leaving By:</p>
                    <ul>
                       <li><input type="radio" value="0" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '0')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/plane.png"></li>
                       <li><input type="radio" value="1" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '1')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/ship.png"></li>
                       <li><input type="radio" value="2" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '2')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/car.png"></li>
                       <li><input type="radio" value="3" name="leaving_by" <?php echo ($travel_info['leaving_by'] == '3')? "checked = 'checked'":""; ?> ><img src="<?php echo base_url(); ?>assets/images/train.png"></li>
                    </ul>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="departure_city" value="<?php echo $travel_info['departure_city']; ?>" placeholder="Departure City">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control shipping_date " value="<?php echo ($travel_info['departure_date'] != '0000-00-00')?$travel_info['departure_date']:''; ?>" name="departure_date" id="departure_date" placeholder="Departure Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="ticked_number" value="<?php echo $travel_info['ticked_number']; ?>" placeholder="Flight / Ticket Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mob-input form-small-font">
                            <input type="text" class="form-control" name="departure_cruise_name" value="<?php echo $travel_info['departure_cruise_name']; ?>" placeholder="Airline / Cruise Name">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <ul class="doc">
                            <?php foreach ($travel_info_file as $trav_info){ ?>
                                <li>
                                    <div class="image_div ">
                                        <span>
                                             <img class='admin_itinary_travel_img_delete_img ' data_id='<?php echo $trav_info['id']; ?>' src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                        <a href="<?php echo base_url('admin/order/user_file/'.$trav_info['file_name'].'/'.$travel_info['order_id'].'/'.$order_info['user_id']); ?> " target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                                        </span>
                                    </div>

                                </li>
                                <!--<span class="blue-color"><?php /*echo $trav_info['client_name'];*/?></span>-->
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="inline-document-files text-center">
                        <!--<li>
                            <img class=" medium-img" data-blok="8" src="<?php /*echo base_url(); */?>assets/images/download-note.svg">
                            <span>Itinerary PDF</span>
                        </li>-->
                    </ul>
                </div>
                <div class="info-for-inline">
                    <div class="col-md-4 text-right">
                        <span class="form-small-font">Upload Itinerary: </span>
                    </div>
                    <div class="col-md-4">
                        <label class="btn btn-default btn-file select-doc-file">
                            Choose File <input type="file" id="travel_file" name="input_file" class="form-control" style="display: none;">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-default btn-login-orange adm-btn pull-right admin_save_travel">Save</button>
                    </div>
                </div>

                <p class="clearfix"></p>
            </form>
            </div>
        </div>

    </div>
</div>