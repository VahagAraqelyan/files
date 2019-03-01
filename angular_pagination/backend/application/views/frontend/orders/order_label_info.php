<?php
$this->load->view('frontend/head');
$hide_class = '';
$hide_text_class = '';
$first_class = '';
$second_class = '';
$three_class = '';
$style      = '';
$class_4    =  '';

/*if(!empty($label_info)) {

    foreach ($label_info as $index => $value) {
        if (empty($value['types'])) {
            continue;
        }

        if($value['types'] != 'Golf Bag'){
            $first_class = 'label_do_not_ship_2';
            $second_class = 'tracking_instruction_2';
            $three_class = 'sender_receiver_info_last';
            $class_4 = 'label_img_22';
            $style = 'width:900px';
        }
    }
}*/
?>

<div class="content ">
    <div class="container dom_pdf_conteiner">

        <div class="domestic_instructions">
            <div class="label_div">
                <div class="info_div col-md-12">
                    <div class="navigation">
                        <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                        <h4 class="info_luggage">US Domestic Shipping Instruction</h4>
                    </div>
                    <div class="logo_address ">
                        <div class="logo_info">
                            <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                        </div>
                        <div class="label_address">
                            <ul class=" ">
                                <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                                <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="block-section block_section_label">
                    <h3 class="how_pack">How to Pack</h3>
                    <div class="row label_print_prod_instructions">
                        <div class="">
                            <div class="sl-info label_luggage">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/luggage_logo.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Luggage </p>
                                    <li>Use a sturdy suitcase.</li>
                                    <li>DO NOT put luggage Inside a box</li>
                                    <li>Secure the pull handle with tape</li>
                                    <li>Protect and securely pack all fragile Items </li>
                                </ul>
                            </div>
                            <div class="sl-info label_golf_club">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/golf_club.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Golf Clubs</p>
                                    <li>Use a golf travel bag, hard case or golf box</li>
                                    <li>Secure and wrap all fragile parts of golf clubs</li>
                                    <li>Fill the empty space of golf box with packing fillings</li>
                                </ul>
                            </div>
                            <div class="sl-info label_bike">
                                <span><i><img src="<?php echo base_url('assets/images/labeling/bike.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Bike</p>
                                    <li>Use a bicycle travel case or sturdy corrugated bicycle box</li>
                                    <li>Disassemble the bike and secure each parts in the bike case or box.</li>
                                    <li>Fill the empty space of bike box with packing fill-ings. </li>
                                </ul>
                            </div>
                        </div>
                        <div class="">
                            <div class="sl-info label_box">
                                <span><i ><img src="<?php echo base_url('assets/images/labeling/boxes_logo.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Boxes</p>
                                    <li>Use a sturdy double walled cardboard box or plastic shipping box.</li>
                                    <li> "H" tape the top and bottom of the box.</li>
                                    <li>Protect and secure all fragile items.</li>
                                </ul>
                            </div>
                            <div class="sl-info label_sky_snowboard">
                                <span><i><img src="<?php echo base_url('assets/images/labeling/skis_snowboard.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Skis or Snowboard</p>
                                    <li>Use a soft or hard ski/snowboard travel case/bag </li>
                                    <li>Wrap ski/snowboard with bubble packaging to avoid scratching</li>
                                    <li> Secure the bag with buckles and straps</li>
                                </ul>
                            </div>
                            <div class="sl-info label_packing_tips">
                                <span><i><img src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Packing Tips for all Items</p>
                                    <li> Always secure and wrap fragile items, parts.</li>
                                    <li>Do not overload and exceed weight limitation of your case, bag or box.</li>
                                    <li>Always <p class="error_class lock_p">LOCK</p> your luggage, case or bag</li>
                                    <li>Do not put <a href="<?php echo base_url('what-cant-ship');?>" class="blue-color">prohibited items.</a>  </li>
                                    <li>Do not put <a href="#" class="blue-color"> items not covered by insurance.</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br class="clear">
                </div>
                <div>
                    <img src="<?php echo base_url('assets/images/labeling/luggages_print.jpg')?>" alt="" style="width: 100%;max-height: 230px;">

                    <br class="clear">
                </div>

                <div class="tips label_instruc_tips">
                    <span>
                        <i><img src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt="" class="last_tips_image"></i>
                    </span>
                    <span>Label pouch, luggage tag. clear packing tape can be acquired at local FedEx store. <br> Please show the FedEx label to get free packing materials. Click to
                        <a href="<?php echo base_url('luggage-drop-of-location');?>" class="blue-color">find a local FedEx store.</a>  FedEx hotline: <a href="" class="blue-color">1-800-463-3339</a> </span>
                </div>
                <hr>
                <div class="label_do_not_ship <?php echo $first_class; ?>">
                    <h4 class="blue-color">Do not ship</h4>
                    <table>
                        <tr>
                            <td>Prohibited Items</td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/aerosol_other.png')?>" alt=""></p>
                                <p>Aerosols or <br> other <br> pressurized <br> containers </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/alkohol.png')?>" alt=""></p>
                                <p>Alcohol <br>  (include <br> perfume)</p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/batteries.png')?>" alt=""></p>
                                <p>Batteries <br>  (include with  <br> personal <br>  device) </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/drugs_meditation.png')?>" alt=""></p>
                                <p>Drugs or <br>materials </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/fireams_ammutitation.png')?>" alt=""></p>
                                <p>Firearms and <br>ammunition</p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/animals_prod.png')?>" alt=""></p>
                                <p>animals or <br> animal <br> products </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/hazard_dangerous_mat.png')?>" alt=""></p>
                                <p>Hazardous or<br> dangerous<br> materials</p>
                            </td>
                            <td>
                                <p>View <a href="<?php echo base_url('luggagetoship-terms-of-use'); ?>" class="blue-color">Terms <br> and Conditions</a> <br> for full list</p>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>Items not covered <br> by insurance</td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/anticues_collectors.png')?>" alt=""></p>
                                <p>Antiques  or <br> collector's <br> items</p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/electronics.png')?>" alt=""></p>
                                <p>Electronics</p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/frogile_items.png')?>" alt=""></p>
                                <p>Fragile items<br>or  glassware </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/jeverly.png')?>" alt=""></p>
                                <p>Jewelry, gems<br>or valuables </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/musical_instrument.png')?>" alt=""></p>
                                <p>Musical<br>instruments </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/photpgraphy.png')?>" alt=""></p>
                                <p>Photographic<br>equipment </p>
                            </td>
                            <td>
                                <p><img src="<?php echo base_url('assets/images/labeling/icons/works_art.png')?>" alt=""></p>
                                <p>Works of art </p>
                            </td>
                            <td>
                                <p>View <a href="<?php echo base_url('luggagetoship-terms-of-use'); ?>" class="blue-color">Terms <br> and Conditions</a> <br> for full list</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="pickup_instruction">
            <div class="label_div">
                <div class="info_div col-md-12">
                    <div class="navigation">
                        <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                        <h4 class="info_luggage">US Domestic Shipping Instruction</h4>
                    </div>
                    <div class="logo_address ">
                        <div class="logo_info ">
                            <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                        </div>
                        <div class="label_address">
                            <ul class=" ">
                                <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                                <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="block-section pockup_info_bl_section block_section_label">
                    <h3 class="pickup_instruct">Pick up Instruction</h3>
                    <div class="row">
                        <div class="">
                            <div class="sl-info label_book label_label_book">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/label_book.jpg')?>" alt=""></i></span>
                                <ul class="true_class">
                                    <p class="text-bold">Pick up Check List </p>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Double check the pick-up address, date, time frame and notes in the pick up confirmation email. If anything is wrong, please reach out us right away at 1-800-678- 6167</li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Correctly pack, label and lock your luggage/case/bag/box, and have everything ready before the pick-up time.</li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Please make sure the courier has easy access to your shipment, and you or someone can hand over to courier at the pickup location. The courier will not call or email you on the pick-up date.</li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> If your shipment cannot be ready before the pickup time, or you missed pick up, please call us at 1-800-678- 6167. </li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Your package can be tracked in couple of minutes after the carrier pick up it. </li>
                                </ul>
                            </div>
                            <div class="sl-info label_tips">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Pick up Tips</p>
                                    <li>Please be advised the pick up timeframe is not guaranteed. FedEx may delay the pick up for any unexpected reason.</li>
                                    <li>Hotel Pick Up: always check with hotel if they can hand over package to courier on behalf of you,
                                        as well as their available pick up time and location.
                                        Please timely inform hotel the pick up information we confirmed with you.</li>
                                    <li> School Pick up: Always check the package pickup regulation with your school first.
                                        If your school does not allow campus pickup, please confirm the address and open time
                                        of your school mail room or school lobby. </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-section pockup_info_bl_section block_section_label">
                    <h3 class="inline_display">Drop off Instruction </h3><span class="blue-color small_font_size">  ( <a target="_blank" href="<?php echo base_url('luggage-drop-of-location'); ?>"><?php echo base_url('luggage-drop-of-location'); ?></a>  or
                        <a target="_blank" href="http://www.fedex.com/locate/index.html?cc=us#star"> http://www.fedex.com/locate/index.html?cc=us#star</a>)</span>
                    <div class="row">
                        <div class="">
                            <div class="sl-info label_book label_label_book">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/label_book.jpg')?>" alt=""></i></span>
                                <ul class="true_class">
                                    <p class="text-bold">Drop off Check List </p>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Drop off Check List Confirm the latest FedEx pick up time of the service (Ground or Express) with the location </li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Ask for free label pouches, luggage tags and cable ties from the location (you many show the prepaid FedEx label we sent you to get these materials) </li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Correctly pack, label and lock your luggage/case/bag/box per our domestic shipping instruction </li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Take a picture of your ready luggage/case/bag/box with shipping labels </li>
                                    <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Ask for a drop-off receipt and telephone number of the location</li>
                                </ul>
                            </div>
                            <div class="sl-info label_tips">
                                <span><i class=""><img src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt=""></i></span>
                                <ul>
                                    <p class="text-bold">Drop off Tips</p>
                                    <li>Please do not leave your luggage/case/bag/box at a FedEx drop box in the street. Please find a staffed shipping center. </li>
                                    <li>The actual shipping date will be the date FedEx ships out your package from the drop-off shipping center.
                                        The estimated delivery date will be calculated on the actual shipping date. </li>
                                    <li> The drop off location should not charge you any shipping fee as the shipping label we sent you is pre-paid label.
                                        Please be advised the FedEx shipping center will not offer you the same shipping price we offered you. </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tracking_instruction <?php echo $second_class; ?>">
                    <h3 class="blue-color">Tracking Instruction </h3>
                    <div>
                        <ul>
                            <li>Tracking Keywords </li>
                            <li> Shipping Information Sent </li>
                            <li>Picked up</li>
                            <li>In Transit</li>
                            <li>With Courier</li>
                            <li>Shipment on Hold</li>
                        </ul>
                        <ul>
                            <li>Explanation </li>
                            <li>Label is created, package is not picked up</li>
                            <li>Your package has been picked up</li>
                            <li> Your package is in transit to the destination</li>
                            <li>Your package will be delivered today</li>
                            <li>Your package is on hold by carrier for some reason</li>
                        </ul>
                        <ul>
                            <li>Suggested Actions</li>
                            <li>Call us or carrier if your package has been picked up</li>
                            <li>No action is needed</li>
                            <li>No action is needed</li>
                            <li>Be ready to accept the package</li>
                            <li>Call us or FedEx right away</li>
                        </ul>
                        <br class="clear">
                    </div>
                    <div class="truck_inf">
                        <span class="blue-color">
                          <span> FedEx US hotline: 1- 800-463-3339</span>  <span> LuggageToShip US hotline: 1-800-678-6167</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!empty($label_info)){

            foreach ($label_info as $index => $value){
                if(empty($value['types'])){
                    continue;
                } ?>
                <div class="labels">
                    <div class="label_div label_img_main_div">
                        <div class="info_div col-md-12">
                            <div class="labels_navigation">
                                <?php
                                if($value['luggage_name'] == 'Special Boxes'){
                                    $label_weight = $value['label_weight'];

                                }else{
                                    $label_weight = $value['weight'];
                                }
                                ?>
                                <span class="number"><?php echo $index+1; ?></span>
                                <h4 class="info_luggage number"><?php show_price($label_weight).' '; echo 'lbs '.$value['luggage_name'] .' - Label' ?></h4>
                                <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                            </div>
                            <div class="logo_address ">
                                <div class="logo_info ">
                                    <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                                </div>
                                <div class="label_address">
                                    <ul class=" ">
                                        <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                                        <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <?php
                        if($value['types'] == 'Boxes' || ($value['types'] == 'Bike & SKI' && $value['luggage_name'] == 'Bike Box') ){

                            if($value['luggage_name'] == 'Special Boxes'){
                                $sizes_image = '';
                                $hide_class = 'dis_none';
                                $hide_text_class = '';

                            }else{
                                $sizes_image = $value['sizes_image'];
                                $hide_class = '';
                                $hide_text_class = 'dis_none';
                            }
                            ?>
                            <!--Version 2-->
                            <div class="instructors ">
                                <img  src="<?php echo base_url('assets/images/labeling/box_label_instruction.jpg')?>" style="width: 100%;">
                            </div>
                            <hr>
                            <div class="do_not">
                                <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                                <div class="do_not_parent">
                                    <div style="margin-top: 45px; left:7px;" class="<?php echo $hide_text_class;?>" >
                                        <p>
                                            Max. Weight: <span class="error_class"> <?php echo $value['label_weight'];?>(lbs)</span> <br>
                                            Max. Size:   <span class="error_class"> <?php echo floor(floatval(modify_number($value['label_width'] ))).' * '.floor(floatval(modify_number($value['label_length']))).' * '.floor(floatval(modify_number($value['label_height'])));?>(inch)</span>
                                        </p>
                                        <p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p>
                                    </div>
                                    <div class="<?php echo $hide_class; ?>">
                                        <img src="<?php echo base_url('assets/images/').$sizes_image;?>" alt="">
                                        <p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p>
                                    </div>
                                    <div style="bottom: 30px;">
                                        <img style="" src="<?php echo base_url('assets/images/labeling/box_instruction.jpg');?>" alt="">
                                        <p>Do not stick label on the opening of the box. </p>
                                    </div>
                                    <br class="clear">
                                </div>
                                <p class="do_not_info2">Please fold here</p>
                                <p class="do_not_info">Use of this label is subject to Luggage To Ship and FedEx Terms and Conditions </p>
                            </div>
                            <hr class="label_hr">
                            <div class="label img_div   img_div_box">
                                <img class="<?php echo $class_4; ?>" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$value['file_name'];?>" alt="" style="<?php echo $style; ?>">
                                <!--<div class="labels_number">
                            <span class="number"><span><?php /*echo $index+1; */?></span></span>
                            <h4><?php /*echo $value['weight'].'lbs - Label' */?></h4>
                            <h4>Please securely attach the label tag to the top handle of your luggage</h4>
                        </div>-->
                                <br class="clear">
                            </div>
                        <?php }else if($value['types'] == 'Luggage'){ ?>
                        <!--Version 1-->
                        <div class="instructors">
                            <img  src="<?php echo base_url('assets/images/labeling/label_instruction.jpg');?>" style="width: 100%;">
                        </div>
                        <hr>
                        <div class="do_not">
                            <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                            <div class="instructors">
                                <div>
                                    <img src="<?php echo base_url('assets/images/').$value['sizes_image'];?>" alt="">
                                    <p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p>
                                </div>
                                <div>
                                    <img src="<?php echo base_url('assets/images/labeling/product_instruction1.jpg');?>" alt="">
                                    <p>Do not put your luggage in a box.<br>  Additional shipping fee may apply. </p>
                                </div>
                                <div>
                                    <img src="<?php echo base_url('assets/images/labeling/product_instruction2.jpg');?>" alt="">
                                    <p class="instructors_p_3">Do not stick label on the surface of <br>your luggage directly. It will drop and
                                        <br>
                                        your luggage may be lost. </p>
                                </div>
                                <br class="clear">
                            </div>
                            <p class="do_not_info2">Please fold here </p>
                            <p class="do_not_info">Use of this label is subject to Luggage To Ship and FedEx Terms and Conditions </p>
                        </div>
                        <hr class="label_hr">
                        <div class="label img_div ">
                            <img class="<?php echo $class_4; ?>" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$value['file_name'];?>" alt="" style="<?php echo $style; ?>">
                            <!--<div class="labels_number">
                    <span class="number"><span><?php /*echo $index+1; */?></span></span>
                    <h4><?php /*echo $value['weight'].'lbs - Label' */?></h4>
                    <h4>Please securely attach the label tag to the top handle of your luggage </h4>
                </div>-->
                            <br class="clear">
                        </div>
                    </div>
                    <?php }else if($value['types'] == 'Golf Bag'){
                        $sizes_image = $value['sizes_image'];
                        ?>
                        <!--Version 3-->
                        <div class="instructors ">
                            <img style="max-width: 1100px;" src="<?php echo base_url('assets/images/labeling/bag_full_image.png')?>" >
                        </div>
                        <hr>
                        <div class="do_not">
                            <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                            <div class="do_not_parent do_not_parent2">

                                <div class="">
                                    <img src="<?php echo base_url('assets/images/').$sizes_image;?>" alt="">
                                    <p><span class="error_class">  Do not exceed max.</span> size & weight. <br>Additional fee will apply.</p>

                                </div>
                                <div>
                                    <img src="<?php echo base_url('assets/images/labeling/bag_label');?>" alt="">
                                    <p>Do not stick label on the surface of your bag directly. <br> It will drop and your bag may be lost. </p>
                                </div>
                                <br class="clear">
                            </div>
                            <p class="do_not_info2">Please fold here</p>
                            <p class="do_not_info">Use of this label is subject to Luggage To Ship and FedEx Terms and Conditions </p>
                        </div>
                        <hr class="label_hr">
                        <div class="label img_div img_div_box ">
                            <img class="<?php echo $class_4; ?>" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$value['file_name'];?>" alt="" style="<?php echo $style; ?>">
                            <!--<div class="labels_number">
                            <span class="number"><span><?php /*echo $index+1; */?></span></span>
                            <h4><?php /*echo $value['weight'].'lbs - Label' */?></h4>
                            <h4>Please securely attach the label tag to the top handle of your luggage</h4>
                        </div>-->
                            <br class="clear">
                        </div>
                    <?php }else if($value['types'] == 'Bike & SKI' && $value['luggage_name'] != 'Bike Box'){
                        $sizes_image = $value['sizes_image'];
                        ?>

                        <!--Version 4-->
                        <div class="instructors ">
                            <img style="max-width: 1100px;" src="<?php echo base_url('assets/images/labeling/bike_full_image.png')?>" >
                        </div>
                        <hr>
                        <div class="do_not">
                            <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                            <div class="do_not_parent do_not_parent2">
                                <div class="">
                                    <img src="<?php echo base_url('assets/images/').$sizes_image;?>" alt="">
                                    <p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p>
                                </div>
                                <div>
                                    <img src="<?php echo base_url('assets/images/labeling/bike_label.png');?>" alt="">
                                    <p>Do not stick label on the surface of your bag directly. <br> It will drop and your bag may be lost. </p>
                                </div>

                                <br class="clear">
                            </div>
                            <p class="do_not_info2">Please fold here</p>
                            <p class="do_not_info">Do not stick label on the surface of your bag directly. It will drop and your bag may be lost.</p>
                        </div>
                        <hr class="label_hr">
                        <div class="label img_div img_div_box ">
                            <img class="<?php echo $class_4; ?>" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$value['file_name'];?>" alt="" style="<?php echo $style; ?>">
                            <!--<div class="labels_number">
                            <span class="number"><span><?php /*echo $index+1; */?></span></span>
                            <h4><?php /*echo $value['weight'].'lbs - Label' */?></h4>
                            <h4>Please securely attach the label tag to the top handle of your luggage</h4>
                        </div>-->
                            <br class="clear">
                        </div>
                    <?php } ?>

                </div>


            <?php } }  ?>
        <div class="truck_instructions">
            <div class="label_div">
                <div class="info_div col-md-12 prod_info_div">
                    <div class="navigation">
                        <h4 class="info_order">Order #: <?php echo $order_info['order_id'];?></h4>
                        <h4 class="info_luggage error_class">Shipping Summary Paper 1</h4>
                    </div>
                    <div class="logo_address ">
                        <div class="logo_info ">
                            <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                        </div>
                        <div class="label_address">
                            <ul class=" ">
                                <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                                <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="truck_info">
                    <p>
                        Please follow the dot line and cut the summary paper. Please put summary paper Inside related luggage/bag/case or tape paper on
                        <br> related box with clear type. Please <span class="error_class">Lock your luggage or bag(s)</span>.
                    </p>
                </div>

                <div class="sender_receiver_info_main">
                    <?php

                    $type_arr = [
                        'Luggage'    => 'luggage_img.jpg',
                        'Boxes'      => 'box_img.jpg',
                        'Golf Bag'   => 'golf_bag.jpg',
                        'Bike & SKI' => 'sky_snowboard.jpg',
                    ];

                    $paper = 1;

                    if(!empty($label_info)){

                        foreach ($label_info as $index => $value){

                            if(empty($value['types'])){
                                continue;
                            }

                            $img_name = ($value['luggage_name'] == 'Bike Box')?$type_arr['Boxes']:$type_arr[$value['types']];

                            if($index %2 == 0 && $index>1){

                                $paper ++;



                                ?>
                                <div class="info_div col-md-12 prod_info_div">
                                    <div class="navigation">
                                        <h4 class="info_order">Order #: <?php echo $order_info['order_id'];?></h4>
                                        <h4 class="info_luggage error_class">Shipping Summary Paper <?php echo $paper; ?> </h4>
                                    </div>
                                    <div class="logo_address ">
                                        <div class="logo_info ">
                                            <img src="<?php echo base_url(); ?>/assets/images/logo.png">
                                        </div>
                                        <div class="label_address">
                                            <ul class=" ">
                                                <li><i class="head-phone"></i><span>1800 678 6167</span></li>
                                                <li><i class="head-mail"></i><span>cs@luggagetoship.com</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="truck_info">
                                    <p>
                                        Please follow the dot line and cut the summary paper. Please put summary paper Inside related luggage/bag/case or tape paper on
                                        <br> related box with clear type. Please <span class="error_class">Lock your luggage or bag(s)</span>.
                                    </p>
                                </div>
                            <?php }
                            ?>

                            <div class="sender_receiver_info <?php echo $three_class; ?>">
                                <div class="<?php echo ($value['types'] == 'Boxes')?'instructors2':'instructors1'; ?>">
                                    <p><?php echo $value['luggage_name']; ?></p>
                                    <img src="<?php echo base_url('assets/images/labeling/').$img_name;?>" alt="">
                                </div>
                                <div class="sender_receiver_info2">
                                    <div class="labels_navigation">
                                        <span class="number"><?php echo $index+1; ?></span>
                                        <?php
                                        if($value['luggage_name'] == 'Special Boxes'){
                                            $label_weight = $value['label_weight'];

                                        }else{
                                            $label_weight = $value['weight'];
                                        }
                                        ?>
                                        <h4 class="info_luggage number"><?php show_price($label_weight).' '; echo 'lbs '.$value['luggage_name']; ?></h4>
                                        <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                                    </div>
                                    <div class="tracking_inf">
                                        <p><?php echo (!empty($value['tracking_number']))? $order_info['currier_name'].' Tracking '.$value['tracking_number']: $order_info['currier_name'].' Tracking '.$value['trucking_number']; ?></p>
                                    </div>
                                    <div>
                                        <ul>
                                            <li><p class="text-bold">From:</p></li>
                                            <li><p><?php echo $sender_info['sender_first_name'].' '. $sender_info['sender_last_name'];?></p></li>
                                            <li><p><?php echo $sender_info['pickup_company'];?></p></li>
                                            <li><p><?php echo $sender_info['pickup_address1'];?></p></li>
                                            <li><p><?php echo $sender_info['pickup_address2'];?></p></li>
                                            <li><p><?php echo $sender_info['pickup_city'].$sender_state;?></p></li>
                                            <li><p><?php echo $sender_info['sender_phone'];?></p></li>
                                        </ul>

                                        <ul>
                                            <li><p class="text-bold">To:</p></li>
                                            <li><p><?php echo $delivery_info['receiver_first_name'].' '. $delivery_info['receiver_last_name'];?></p></li>
                                            <li><p><?php echo $delivery_info['delivery_company'];?></p></li>
                                            <li><p><?php echo $delivery_info['delivery_address1'];?></p></li>
                                            <li><p><?php echo $delivery_info['delivery_address2'];?></p></li>
                                            <li><p><?php echo $delivery_info['delivery_city'].$delivery_state;?></p></li>
                                            <li><p><?php echo $delivery_info['receiver_phone'];?></p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } }  ?>
                    <br class="clear">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
