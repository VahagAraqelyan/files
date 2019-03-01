<!doctype html>
<html lang="en">
<?php
$this->load->view('frontend/head');
$hide_class = '';
$box_class = '';
$hide_text_class = '';
?>
<body>
<div id="int_label_main_div">
    <div class="div_page">
        <div class="div_header padding_for_a4">
            <div class="header_info">
                <table>
                    <tr>
                        <td rowspan="2"><!--<span class="circle_index">1</span>--></td>
                        <td><h4 class="info_order"><?php echo $order_info['order_id'];?></h4></td>
                    </tr>
                    <tr>
                        <td><h4 class="info_luggage">International Shipping instruction</h4></td>
                    </tr>
                </table>
            </div>
            <div class="int_logo_address">
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
            <br class="clear">
        </div>
        <div class="page_body padding_for_a4">
            <div class="blue_title">
                <h4>How to Pack</h4>
            </div>
            <table class="first_table">
                <tr>
                    <th></th>
                    <th><p class="text-bold">Luggage</p></th>
                    <th></th>
                    <th><p class="text-bold">Boxes</p></th>
                </tr>
                <tr>
                    <td>
                        <img class="circle_img" src="<?php echo base_url('assets/images/labeling/luggage_logo.jpg')?>" alt="">
                    </td>
                    <td>
                        <ul>
                            <li>Use a sturdy suitcase.</li>
                            <li>DO NOT put luggage Inside a box</li>
                            <li>Secure the pull handle with tape</li>
                            <li>Protect and securely pack all fragile Items</li>
                        </ul>
                    </td>
                    <td>
                        <img class="circle_img" src="<?php echo base_url('assets/images/labeling/boxes_logo.jpg')?>" alt="">
                    </td>
                    <td>
                        <ul>
                            <li>Use a sturdy double walled cardboard box or plastic shipping box.</li>
                            <li>"H" tape the top and bottom of the box.</li>
                            <li>Protect and secure all fragile items.</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <th><p class="text-bold">Golf Clubs</p></th>
                    <th></th>
                    <th><p class="text-bold">Skis or Snowboard</p></th>
                </tr>
                <tr>
                    <td><img class="circle_img" src="<?php echo base_url('assets/images/labeling/golf_club.jpg')?>" alt=""></td>
                    <td>
                        <ul>
                            <li>Use a golf travel bag, hard case or golf box</li>
                            <li>Secure and wrap all fragile parts of golf clubs</li>
                            <li>Fill the empty space of golf box with packing fillings</li>
                        </ul>
                    </td>
                    <td><img class="circle_img" src="<?php echo base_url('assets/images/labeling/skis_snowboard.jpg')?>" alt=""></td>
                    <td>
                        <ul>
                            <li>Use a soft or hard ski/snowboard travel case/bag</li>
                            <li>Wrap ski/snowboard with bubble packaging to avoid scratching</li>
                            <li>Secure the bag with buckles and straps</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <th><p class="text-bold">Bike</p></th>
                    <th></th>
                    <th><p class="text-bold">Packing Tips for all Items</p></th>
                </tr>
                <tr>
                    <td>
                        <img class="circle_img" src="<?php echo base_url('assets/images/labeling/bike.jpg')?>" alt="">
                    </td>
                    <td>
                        <ul>
                            <li>Use a bicycle travel case or sturdy corrugated bicycle box</li>
                            <li>Disassemble the bike and secure each parts in the bike case or box.</li>
                            <li>Fill the empty space of bike box with packing fillings. </li>
                        </ul>
                    </td>
                    <td>
                        <img class="circle_img" src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt="">
                    </td>
                    <td>
                        <ul>
                            <li>Always secure and wrap fragile items, parts.</li>
                            <li>Do not overload and exceed weight limitation of your case, bag or box.</li>
                            <li><span class="error_class lock_p text_underline">DO NOT LOCK</span> your luggage, case or bag, use cable tie instead</li>
                            <li>Do not put <a href="<?php echo base_url('what-cant-ship');?>" class="blue-color">prohibited items.</a>  </li>
                            <li>Do not put <a href="<?php echo base_url('luggagetoship-terms-of-use');?>" class="blue-color"> items not covered by insurance.</a></li>
                        </ul>
                    </td>
                </tr>
            </table>
            <hr/>
            <div class="blue_title">
                <h4>How to Label</h4>
            </div>
            <div>
                <img class="large_img" src="<?php echo base_url('assets/images/labeling/luggages_print_international.jpg')?>" alt="">
            </div>
            <div class="first_tick_part">
                <table>
                    <tr>
                        <td style="position: relative">
                            <img class="circle_img"  style="width:2.2cm;height:2.2cm; position: absolute; right: 50%; top: -12px;  bottom: 0;" src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt="" class="last_tips_image">
                        </td>
                        <td>
                            <span>
                               Label pouch, luggage tag, cable tie, clear packing tape can be acquired  at <br> local carrier store.
                                Please show the following prepaid labels to get free <br> packing materials.
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <hr/>
            <div class="blue_title">
                <h4>Do not ship</h4>
            </div>
            <div class="first-do-not">
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
    <div class="div_page">
        <div class="div_header padding_for_a4">
            <div class="header_info">
                <table>
                    <tr>
                        <td rowspan="2"><!--<span class="circle_index">1</span>--></td>
                        <td><h4 class="info_order"><?php echo $order_info['order_id'];?></h4></td>
                    </tr>
                    <tr>
                        <td><h4 class="info_luggage">International Shipping instruction</h4></td>
                    </tr>
                </table>
            </div>
            <div class="int_logo_address">
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
            <br class="clear">
        </div>
        <div class="page_body padding_for_a4">
            <div class="blue_title">
                <h4>Pick up Instruction</h4>
            </div>
            <div class="page_2_table_div">
                <table>
                    <tr>
                        <td>
                            <img class="circle_img" src="<?php echo base_url('assets/images/labeling/label_book.jpg')?>" alt="">
                        </td>
                        <td>
                            <ul class="true_class">
                                <p class="text-bold">Pick up Check List </p>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img">Double check the pick-up address, date, time frame and notes in the pick up confirmation email. If anything is wrong, please reach out us right away at 1-800-678- 6167</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Correctly pack and label your luggage/case/bag/box, and have everything ready before the pick-up time.</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Please make sure the courier has easy access to your shipment, and you or someone can hand over to courier at the pickup location. The courier will not call or email you on the pick-up date.</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> If your shipment cannot be ready before the pickup time, or you missed pick up, please call us at 1-800-678- 6167.</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Your package can be tracked in couple of minutes after the carrier pick up it.</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <img class="circle_img" src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt="">
                        </td>
                        <td>
                            <ul>
                                <p class="text-bold">Pick up Tips</p>
                                <li>Please be advised the pick up timeframe is not guaranteed. Carrier may delay the pick up for any unexpected reason.</li>
                                <li><f class="text-bold">Hotel Pick Up</f>: always check with hotel if they can hand over package to courier on behalf of you,
                                    as well as their available pick up time and location. Please timely inform hotel the pick up information we confirmed with you.</li>
                                <li> <f class="text-bold">School Pick up</f>:
                                    Always check the package pickup regulation with your school first.
                                    If your school does not allow campus pickup, please confirm the address and open time of your school mail room or school lobby.

                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="blue_title">
                    <h4 class="inline_display">Drop off Instruction </h4><span class="blue-color small_font_size">  ( <a target="_blank" href="<?php echo base_url('luggage-drop-of-location'); ?>"><?php echo base_url('luggage-drop-of-location'); ?></a>)</span>
                </div>
                <table>
                    <tr>
                        <td>
                            <img class="circle_img" src="<?php echo base_url('assets/images/labeling/label_book.jpg')?>" alt="">
                        </td>
                        <td>
                            <ul class="true_class">
                                <p class="text-bold">Drop off Check List </p>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Confirm the latest pick up time of the service with the drop off location</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img">Ask for free label pouches, luggage tags and cable ties from the location (you many show the prepaid label we sent you to get these materials)</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Correctly pack and label your luggage/case/bag/box per our international shipping instruction</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img">Take a picture of your ready luggage/case/bag/box with shipping labels</li>
                                <li><img src="<?php echo base_url('assets/images/labeling/ok_img'); ?>" alt="" class="ok_img"> Ask for a drop-off receipt and telephone number of the location</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <img class="circle_img" src="<?php echo base_url('assets/images/labeling/tips.jpg')?>" alt="">
                        </td>
                        <td>
                            <ul>
                                <p class="text-bold">Drop off Tips</p>
                                <li>Please do not leave your luggage/case/bag/box at a carrier’s drop box in the street. Please find a staffed shipping center.</li>
                                <li>The actual shipping date will be the date carrier ships out your package from
                                    the drop-off shipping center. The estimated delivery date will be calculated on the actual shipping date.
                                </li>
                                <li> The drop off location should not charge you any shipping fee as the shipping label we sent you is pre-paid label.
                                    <i> Please be advised the carrier shipping center will not offer you the same shipping price we offered you.</i>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="blue_title">
                    <h4 class="inline_display">Tracking Instruction</h4><span class="blue-color small_font_size"> ( <a href="<?php echo base_url('luggage-trucking'); ?>"><?php echo base_url('luggage-trucking');?></a>)</span>
                </div>
                <table class="p2_last_table">
                    <tr>
                        <th>Tracking Keywords</th>
                        <th>Explanation</th>
                        <th>Suggested Actions</th>
                    </tr>
                    <tr>
                        <td>Shipping Information Sent</td>
                        <td>Label is created, package is not picked up</td>
                        <td>Call us or carrier if your package has been </td>
                    </tr>
                    <tr>
                        <td>Picked up</td>
                        <td>Your package has been picked up</td>
                        <td>Picked up</td>
                    </tr>
                    <tr>
                        <td>In Transit</td>
                        <td>Your package is in transit to the destination</td>
                        <td>No action is needed</td>
                    </tr>
                    <tr>
                        <td>With Courier</td>
                        <td>Your package will be delivered today</td>
                        <td>No action is needed</td>
                    </tr>
                    <tr>
                        <td>Custom Delay</td>
                        <td>Your package is delayed in custom</td>
                        <td>Call us or carrier if shipment delayed more than 2 days.</td>
                    </tr>
                    <tr>
                        <td>Shipment on Hold</td>
                        <td>Your package is on hold by carrier for some reason</td>
                        <td>
                            Be ready to accept the package<br>
                            Call us or carrier right away.
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="div_page">
        <div class="div_header padding_for_a4">
            <div class="header_info">
                <table>
                    <tr>
                        <td rowspan="2"><span class="circle_index_title">#1</span></td>
                        <?php

                        if($first_label['luggage_name'] == 'Special Boxes'){

                            $label_weight = $first_label['label_weight'];

                        }else{
                            $label_weight = $first_label['weight'];
                        }
                        ?>
                        <td><h4 class="info_order"><?php echo modify_number($label_weight).'lbs '.$first_label['luggage_name'].' - Label';?></h4></td>
                    </tr>
                    <tr>
                        <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                    </tr>
                </table>
            </div>
            <div class="int_logo_address">
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
            <br class="clear">
        </div>
        <div class="page_body padding_for_a4">
            <div class="first_label_div">

                <div class="label_first_part">
                    <div class="instructors ">
                        <?php
                        if(stripos($order_info['currier_name'], 'FedEx') !== FALSE){

                        if($first_label['types'] == 'Boxes' || ($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] == 'Bike Box')){
                            $box_class= 'fold_here_box';
                            ?>
                            <img class="large_img" src="<?php echo base_url('assets/images/labeling/box_label_instruction_first.jpg')?>" >
                        <?php }else if($first_label['types'] == 'Luggage'){ ?>
                            <img class="large_img" src="<?php echo base_url('assets/images/labeling/inter_label_first.png')?>" >
                        <?php } else if($first_label['types'] == 'Golf Bag'){ ?>
                            <img class="large_img" src="<?php echo base_url('assets/images/labeling/bag_full_image_first.jpg')?>" >
                        <?php } else if($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] != 'Bike Box'){ ?>
                            <img class="large_img" src="<?php echo base_url('assets/images/labeling/bike_full_image_first.jpg')?>" >
                            <?php } ?>
                        <?php  }else{
                            if($first_label['types'] == 'Boxes' || ($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] == 'Bike Box')){ ?>
                                <span class="circle_index_number">#1</span>
                                <img class="large_img" src="<?php echo base_url('assets/images/labeling/box_international_dhl.png')?>" >
                            <?php }else if($first_label['types'] == 'Luggage'){ ?>
                                <td rowspan="2"><span class="circle_index_number">#1</span></td>
                                <img class="large_img" src="<?php echo base_url('assets/images/labeling/international_label.jpg');?>" >
                            <?php } else if($first_label['types'] == 'Golf Bag'){ ?>
                                <span class="circle_index_number">#1</span>
                                <img class="large_img" src="<?php echo base_url('assets/images/labeling/bag_full_image_dhl.png')?>" >
                            <?php } else if($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] != 'Bike Box'){ ?>
                                <span class="circle_index_number">#1</span>
                                <img style="max-width: 100%;" src="<?php echo base_url('assets/images/labeling/bike_full_image_dhl.png')?>" >
                            <?php } ?>


                        <?php   } ?>

                    </div>
                    <div class="do_not">
                        <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                        <?php
                        if($first_label['types'] == 'Boxes' || ($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] == 'Bike Box')){

                            if($first_label['luggage_name'] == 'Special Boxes'){
                                $sizes_image = '';
                                $hide_class = 'dis_none';
                                $hide_text_class = '';
                            }else{
                                $sizes_image = $first_label['sizes_image'];
                                $hide_class = '';
                                $hide_text_class = 'dis_none';
                            }

                            $box_class= 'fold_here_box';
                            ?>
                            <table class="label_table">
                                <tr>
                                    <td> <p class="<?php echo $hide_text_class; ?>" style="float: left">Max. Weight: <span class="error_class"> <?php echo $first_label['label_weight'];?>(lbs)</span></p> </td>
                                    <td><img src="<?php echo base_url('assets/images/').$first_label['sizes_image'];?>" alt="" class="<?php echo $hide_class; ?>"></td>
                                    <td><img src="<?php echo base_url('assets/images/labeling/box_instruction.jpg');?>" alt=""></td>
                                </tr>
                                <tr>
                                    <td> <p class="<?php echo $hide_text_class; ?>" style="margin-top: -80px;float: left;"> Max. Size: <span class="error_class"> <?php echo floor(floatval(modify_number($first_label['label_width']))).' * '.floor(floatval(modify_number($first_label['label_length']))).' * '.floor(floatval(modify_number($first_label['label_height'])));?>(inch)</span></p> </td>
                                    <td ><p class="<?php echo $hide_class;?>"><span class="error_class ">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                    <td><p>Do not put your luggage in a box.<br>  Additional shipping fee may apply. </p></td>
                                </tr>
                            </table>
                            <!--Version 2-->
                        <?php }else if($first_label['types'] == 'Luggage'){ ?>
                        <table class="label_table">
                            <tr>
                                <td><img src="<?php echo base_url('assets/images/').$first_label['sizes_image'];?>" alt=""></td>
                                <td><img src="<?php echo base_url('assets/images/labeling/inter_label_luggage.jpg');?>" alt=""></td>
                                <td><img src="<?php echo base_url('assets/images/labeling/product_instruction1.jpg');?>" alt=""></td>
                                <td><img src="<?php echo base_url('assets/images/labeling/product_instruction2.jpg');?>" alt=""></td>
                            </tr>
                            <tr>
                                <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                <td><p><span class="error_class">Do not lock</span> your luggage</p></td>
                                <td><p>Do not put your luggage in a box.  Additional shipping fee may apply. </p></td>
                                <td><p class="instructors_p_3">Do not stick label on the surface of your luggage directly. It will drop and
                                        your luggage may be lost. </p></td>

                            </tr>
                        </table>
                        <?php } else if($first_label['types'] == 'Golf Bag'){ ?>
                        <table class="label_table">
                            <tr>
                                <td><img src="<?php echo base_url('assets/images/').$first_label['sizes_image'];?>" alt=""></td>
                                <td> <img src="<?php echo base_url('assets/images/labeling/bag_label2.jpg');?>" alt=""></td>
                                <td> <img src="<?php echo base_url('assets/images/labeling/bag_label.png');?>" alt=""></td>
                            </tr>
                            <tr>
                                <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                <td><p>Please <span class="error_class">Do not lock</span> your bag</p></td>
                                <td><p class="instructors_p_3">Do not stick label on the bag of <br>your luggage directly. It will drop and
                                        <br>
                                        your luggage may be lost. </p></td>
                            </tr>
                        </table>
                        <?php } else if($first_label['types'] == 'Bike & SKI' && $first_label['luggage_name'] != 'Bike Box'){ ?>
                        <table class="label_table">
                            <tr>
                                <td><img src="<?php echo base_url('assets/images/').$first_label['sizes_image'];?>" alt=""></td>
                                <td><img src="<?php echo base_url('assets/images/labeling/bike_label2.jpg');?>" alt=""></td>
                                <td><img src="<?php echo base_url('assets/images/labeling/bike_label.png');?>" alt=""></td>
                            </tr>
                            <tr>
                                <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                <td><p>Please <span class="error_class">Do not lock</span> your bag</p></td>
                                <td><p class="instructors_p_3">Do not stick label on the bike of <br>your luggage directly. It will drop and
                                        <br>
                                        your luggage may be lost. </p></td>
                            </tr>
                        </table>
                      <?php  }?>
                    </div>
                </div>
                <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                <div class="label img_div img_div_box">
                    <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$first_label['file_name'];?>" alt="">
                </div>
            </div>
        </div>
    </div>
    <?php

    // LABEL COPY
    if(!empty($first_label_count)){
        for($i = 1; $i<=$first_label_count; $i++){ ?>
            <?php
            if($first_label['luggage_name'] == 'Special Boxes'){
                $weight = $first_label['label_weight'];

            }else{
                $weight = $first_label['weight'];
            }
            ?>
            <div class="div_page">
                <div class="div_header padding_for_a4">
                    <div class="header_info">
                        <table>
                            <tr>
                                <td rowspan="2"><span class="circle_index_title">#1</span></td>
                                <td><h4 class="info_order"><?php echo modify_number($weight).'lbs '.$first_label['luggage_name'].' - Label Copy '.$i;?></h4></td>
                            </tr>
                            <tr>
                                <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="int_logo_address">
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
                    <br class="clear">
                </div>
                <div class="page_body padding_for_a4">
                    <div class="first_label_div">
                        <div class="label_first_part">
                            <div class="please_put_page">
                                    <span>
                                        Please put this page with &nbsp
                                    </span>
                                <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#1</span>
                                <span class="red-color">
                                        <?php echo modify_number($weight).'lbs '.$first_label['luggage_name'];?> - Label
                                    </span>
                                <span>
                                        page, and follow the page instruction
                                    </span>
                            </div>
                        </div>
                        <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                       <?php
                       if(stripos($order_info['currier_name'],'fedex')  !== FALSE && !empty($type_files[0]['file_name'])){ ?>
                           <div class="label img_div img_div_box">
                               <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$type_files[0]['file_name'];?>" alt="">
                           </div>
                       <?php }else { ?>
                           <div class="label img_div img_div_box">
                               <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$first_label['file_name'];?>" alt="">
                           </div>
                       <?php } ?>

                    </div>
                </div>
            </div>
            <?php
        }
    }

    //INVOICE PAGES
    if(!empty($invoice_files)){
        if(!empty($first_invoice_count)){
            for($i = 1; $i<=$first_invoice_count; $i++){
                $copy = '';
                if($i != 1){
                    $copy = ' Copy '.($i-1);
                }
                foreach($invoice_files as $single_page){
                    if($first_label['luggage_name'] == 'Special Boxes'){

                        $weight = $first_label['label_weight'];

                    }else{
                        $weight = $first_label['weight'];
                    }
                    ?>
                    <div class="div_page">
                        <div class="div_header padding_for_a4">
                            <div class="header_info">
                                <table>
                                    <tr>
                                        <td rowspan="2"><span class="circle_index_title">#1</span></td>
                                        <td><h4 class="info_order"><?php echo modify_number($weight).'lbs '.$first_label['luggage_name'].' - Custom Invoice'.$copy;?></h4></td>
                                    </tr>
                                    <tr>
                                        <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="int_logo_address">
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
                            <br class="clear">
                        </div>
                        <div class="page_body padding_for_a4">
                            <div class="please_put_page">
                                    <span>
                                        Please put this page with &nbsp
                                    </span>
                                <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#1</span>
                                <span class="red-color">
                                        <?php echo modify_number($weight).'lbs '.$first_label['luggage_name'];?> - Label
                                    </span>
                                <span>
                                        page, and follow the page instruction
                                    </span>
                            </div>
                            <img class="invoice_img_inter" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single_page['file_name'];?>" alt="" />
                        </div>
                    </div>
                    <?php
                }

            }

        }
    }

    $custom_document_number = 1;

    //PASSPORT && VISA
    if(!empty($pasport_file) || !empty($visa_file)){
        ?>
        <div class="div_page">
            <div class="div_header padding_for_a4">
                <div class="header_info">
                    <table>
                        <tr>
                            <td rowspan="2"><span class="circle_index_title">#1</span></td>
                            <td><h4 class="info_order"><?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'].' - <br>Additional Custom Document '.$custom_document_number;?></h4></td>
                        </tr>
                        <tr>
                            <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="int_logo_address">
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
                <br class="clear">
            </div>
            <div class="page_body padding_for_a4">
                <div class="please_put_page">
                        <span>
                            Please put this page with &nbsp
                        </span>
                    <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#1</span>
                    <span class="red-color">
                            <?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'];?> - Label
                        </span>
                    <span>
                            page, and follow the page instruction
                        </span>
                </div>
                <div class="passport_div">
                    <h4>Passport Copy</h4>
                    <?php if(!empty($pasport_file[0]['file_name'])){
                        ?>
                        <img src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$pasport_file[0]['file_name'];?>">
                    <?php }?>
                </div>
                <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                <div class="visa_div">
                    <h4>Visa Copy</h4>
                    <?php if(!empty($visa_file[0]['file_name'])){
                        ?>
                        <img src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$visa_file[0]['file_name'];?>">
                    <?php }?>
                </div>
            </div>
        </div>
        <?php
        $custom_document_number++;
    }

    //Itinerary
    if(!empty($itinerary_info) || !empty($itinerary_file)){
        ?>
        <div class="div_page">
            <div class="div_header padding_for_a4">
                <div class="header_info">
                    <table>
                        <tr>
                            <td rowspan="2"><span class="circle_index_title">#1</span></td>
                            <td><h4 class="info_order"><?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'].' - <br>Additional Custom Document '.$custom_document_number;?></h4></td>
                        </tr>
                        <tr>
                            <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="int_logo_address">
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
                <br class="clear">
            </div>
            <div class="page_body padding_for_a4">
                <div class="please_put_page">
                        <span>
                            Please put this page with &nbsp
                        </span>
                    <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#1</span>
                    <span class="red-color">
                            <?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'];?> - Label
                        </span>
                    <span>
                            page, and follow the page instruction
                        </span>
                </div>
                <div class="itinerary_info_div">
                    <h4>Travel Itinerary</h4>
                    <?php
                    if(!empty($itinerary_info)){

                        $type_array = [
                            '0' => 'Airplane',
                            '1' => 'Cruise',
                            '2' => 'Car / Bus',
                            '3' => 'Train'
                        ];
                        ?>
                        <table>
                            <tr>
                                <td>Arriving <?php echo $to_country['country']; ?> by <span class="verj_clas">:</span></td>
                                <td><?php echo $type_array[$itinerary_info['arriving_by']];?></td>
                                <td>Leaving <?php echo $from_country['country']; ?> by <span class="verj_clas">:</span></td>
                                <td><?php echo $type_array[$itinerary_info['leaving_by']];?></td>
                            </tr>
                            <tr>
                                <td>Arrival City <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['arrival_city'];?></td>
                                <td>Departure City <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['departure_city'];?></td>
                            </tr>
                            <tr>
                                <td>Arrival Date <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['arrival_date'];?></td>
                                <td>Arrival Date <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['departure_date'];?></td>
                            </tr>
                            <tr>
                                <td>Flight / Ticket Number <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['arrival_ticked_number'];?></td>
                                <td>Flight / Ticket Number <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['ticked_number'];?></td>
                            </tr>
                            <tr>
                                <td>Airline / Cruise Number <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['arrival_cruise_name'];?></td>
                                <td>Airline / Cruise Number <span class="verj_clas">:</span></td>
                                <td><?php echo $itinerary_info['departure_cruise_name'];?></td>
                            </tr>
                        </table>
                    <?php }?>
                </div>
                <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                <div class="itinerary_img_div">
                    <h4>Itinerary Document</h4>
                    <?php if(!empty($itinerary_file[0]['file_name'])){
                        ?>
                        <img src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$itinerary_file[0]['file_name'];?>">
                    <?php }?>
                </div>
            </div>
        </div>
        <?php
        $custom_document_number++;
    }

    if(!empty($personal_effect[0]['file_name'])){
        ?>
        <div class="div_page">
            <div class="div_header padding_for_a4">
                <div class="header_info">
                    <table>
                        <tr>
                            <td rowspan="2"><span class="circle_index_title">#1</span></td>
                            <td><h4 class="info_order"><?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'].' - <br>Additional Custom Document '.$custom_document_number;?></h4></td>
                        </tr>
                        <tr>
                            <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="int_logo_address">
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
                <br class="clear">
            </div>
            <div class="page_body padding_for_a4">
                <div class="please_put_page">
                                    <span>
                                        Please put this page with &nbsp
                                    </span>
                    <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#1</span>
                    <span class="red-color">
                                        <?php echo modify_number($first_label['weight']).'lbs '.$first_label['luggage_name'];?> - Label
                                    </span>
                    <span>
                                        page, and follow the page instruction
                                    </span>
                </div>
                <img class="invoice_img_inter" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$personal_effect[0]['file_name'];?>" alt="" />
            </div>
        </div>
        <?php
    }

    // LUGGAGE
    if(!empty($label_info)){
        foreach($label_info as $key=>$single){
            $index = $key+1;
            ?>
            <div class="div_page">
                <div class="div_header padding_for_a4">
                    <div class="header_info">
                        <?php

                        if($single['luggage_name'] == 'Special Boxes'){

                            $label_weight = $single['label_weight'];

                        }else{
                            $label_weight = $single['weight'];
                        }
                        ?>
                        <table>
                            <tr>
                                <td rowspan="2"><span class="circle_index_title">#<?php echo $index; ?></span></td>
                                <td><h4 class="info_order"><?php echo modify_number($label_weight).'lbs '.$single['luggage_name'].' - Label';?></h4></td>
                            </tr>
                            <tr>
                                <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="int_logo_address">
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
                    <br class="clear">
                </div>
                <div class="page_body padding_for_a4">
                    <div class="first_label_div">
                        <?php
                        if($single['types'] == 'Boxes' || ($single['types'] == 'Bike & SKI' && $single['luggage_name'] == 'Bike Box')){

                            if($single['luggage_name'] == 'Special Boxes'){
                                $sizes_image = '';
                                $hide_class = 'dis_none';
                                $hide_text_class = '';

                            }else{
                                $sizes_image = $single['sizes_image'];
                                $hide_class = '';
                                $hide_text_class = 'dis_none';
                            }

                            $box_class= 'fold_here_box';
                            ?>
                            <!--Version 2-->
                            <div class="label_first_part">
                                <div class="instructors ">
                                    <?php
                                     if(stripos($order_info['currier_name'], 'FedEx') === FALSE){ ?>
                                         <span class="circle_index_number">#<?php echo $index; ?></span>
                                   <?php } ?>

                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') !== FALSE){ ?>

                                        <img class="large_img" src="<?php echo base_url('assets/images/labeling/box_label_instruction.jpg')?>" >
                                    <?php  }else{ ?>
                                        <img class="large_img" src="<?php echo base_url('assets/images/labeling/box_international_dhl.png')?>" >
                                    <?php   } ?>
                                </div>
                                <div class="do_not">
                                    <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                                    <table class="label_table">
                                        <tr>
                                            <td> <p class="<?php echo $hide_text_class; ?>" style="float: left">Max. Weight: <span class="error_class"> <?php echo $single['label_weight'];?>(lbs)</span></p> </td>
                                            <td><img src="<?php echo base_url('assets/images/').$sizes_image;?>" alt="" class="<?php echo $hide_class; ?>"></td>
                                            <td><img src="<?php echo base_url('assets/images/labeling/box_instruction.jpg');?>" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td> <p class="<?php echo $hide_text_class; ?>" style="margin-top: -80px;float: left;"> Max. Size: <span class="error_class"> <?php echo floor(floatval(modify_number($single['label_width']))).' * '.floor(floatval(modify_number($single['label_length']))).' * '.floor(floatval(modify_number($single['label_height'])));?>(inch)</span></p> </td>
                                            <td ><p class="<?php echo $hide_class; ?>"><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                            <td><p>Do not put your luggage in a box.<br>  Additional shipping fee may apply. </p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <p class="fold_here <?php echo $box_class; ?>"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                            <div class="label img_div img_div_box">
                                <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single['file_name'];?>" alt="">
                            </div>
                        <?php }else if($single['types'] == 'Luggage'){ ?>
                            <!--Version 1-->
                            <div class="label_first_part">
                                <div class="instructors">
                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') === FALSE){ ?>
                                        <span class="circle_index_number">#<?php echo $index; ?></span>
                                    <?php } ?>
                                    <img class="large_img" src="<?php echo base_url('assets/images/labeling/international_label.jpg');?>" >
                                </div>
                                <hr>
                                <div class="do_not">
                                    <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                                        <table class="label_table">
                                            <tr>
                                                <td><img src="<?php echo base_url('assets/images/').$single['sizes_image'];?>" alt=""></td>
                                                <td><img src="<?php echo base_url('assets/images/labeling/inter_label_luggage.jpg');?>" alt=""></td>
                                                <td><img src="<?php echo base_url('assets/images/labeling/product_instruction1.jpg');?>" alt=""></td>
                                                <td><img src="<?php echo base_url('assets/images/labeling/product_instruction2.jpg');?>" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                                <td><p><span class="error_class">Do not lock</span> your luggage</p></td>
                                                <td><p>Do not put your luggage in a box.  Additional shipping fee may apply. </p></td>
                                                <td><p class="instructors_p_3">Do not stick label on the surface of your luggage directly. It will drop and
                                                        your luggage may be lost. </p></td>

                                            </tr>
                                        </table>
                                </div>
                            </div>
                            <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                            <div class="label img_div">
                                <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single['file_name'];?>" alt="">
                            </div>
                        <?php } else if($single['types'] == 'Golf Bag'){
                            ?>
                            <div class="label_first_part">
                                <div class="instructors">
                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') === FALSE){ ?>
                                        <span class="circle_index_number">#<?php echo $index; ?></span>
                                    <?php } ?>
                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') !== FALSE){ ?>

                                        <img class="large_img" src="<?php echo base_url('assets/images/labeling/bag_full_image.png')?>" >
                                    <?php  }else{ ?>
                                        <img class="large_img" src="<?php echo base_url('assets/images/labeling/bag_full_image_dhl.png')?>" >
                                    <?php   } ?>

                                </div>
                                <hr>
                                <div class="do_not">
                                    <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                                        <table class="label_table">
                                            <tr>
                                                <td><img src="<?php echo base_url('assets/images/').$single['sizes_image'];?>" alt=""></td>
                                                <td> <img src="<?php echo base_url('assets/images/labeling/bag_label2.jpg');?>" alt=""></td>
                                                <td> <img src="<?php echo base_url('assets/images/labeling/bag_label.png');?>" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                                <td><p>Please <span class="error_class">Do not lock</span> your bag</p></td>
                                                <td><p class="instructors_p_3">Do not stick label on the bag of <br>your luggage directly. It will drop and
                                                        <br>
                                                        your luggage may be lost. </p></td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                            <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                            <div class="label img_div">
                                <img src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single['file_name'];?>" alt="">
                            </div>
                        <?php } else if($single['types'] == 'Bike & SKI' && $single['luggage_name'] != 'Bike Box'){
                            ?>
                            <div class="label_first_part">
                                <div class="instructors">
                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') === FALSE){ ?>
                                        <span class="circle_index_number">#<?php echo $index; ?></span>
                                    <?php } ?>

                                    <?php
                                    if(stripos($order_info['currier_name'], 'FedEx') !== FALSE){ ?>

                                        <img style="max-width: 100%;" src="<?php echo base_url('assets/images/labeling/bike_full_image.png')?>" >
                                    <?php  }else{ ?>
                                        <img style="max-width: 100%;" src="<?php echo base_url('assets/images/labeling/bike_full_image_dhl.png')?>" >
                                    <?php   } ?>
                                </div>
                                <hr>
                                <div class="do_not">
                                    <h3><span class="blue-color">Please</span> <span class="error_class">DO NOT</span></h3>
                                    <table class="label_table">
                                        <tr>
                                            <td><img src="<?php echo base_url('assets/images/').$single['sizes_image'];?>" alt=""></td>
                                            <td><img src="<?php echo base_url('assets/images/labeling/bike_label2.jpg');?>" alt=""></td>
                                            <td><img src="<?php echo base_url('assets/images/labeling/bike_label.png');?>" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td><p><span class="error_class">Do not exceed</span> max. size & weight. <br> Additional fee will apply.</p></td>
                                            <td><p>Please <span class="error_class">Do not lock</span> your bag</p></td>
                                            <td><p class="instructors_p_3">Do not stick label on the bike of <br>your luggage directly. It will drop and
                                                    <br>
                                                    your luggage may be lost. </p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                            <div class="label img_div">
                                <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single['file_name'];?>" alt="">
                            </div>
                            <?php
                        }?>
                    </div>
                </div>
            </div>
            <?php

            // LABEL COPY
            if(!empty($label_count)){
                for($i = 1; $i<=$label_count; $i++){
                    ?>
                    <?php
                    if($single['luggage_name'] == 'Special Boxes'){
                        $weight = $single['label_weight'];

                    }else{
                        $weight = $single['weight'];
                    }
                    ?>
                    <div class="div_page">
                        <div class="div_header padding_for_a4">
                            <div class="header_info">
                                <table>
                                    <tr>
                                        <td rowspan="2"><span class="circle_index_title">#<?php echo $index; ?></span></td>
                                        <td><h4 class="info_order"><?php echo modify_number($weight).'lbs '.$single['luggage_name'].' - Label Copy '.$i;?></h4></td>
                                    </tr>
                                    <tr>
                                        <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="int_logo_address">
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
                            <br class="clear">
                        </div>
                        <div class="page_body padding_for_a4">
                            <div class="first_label_div">
                                <div class="label_first_part">
                                    <div class="please_put_page">
                                    <span>
                                        Please put this page with &nbsp
                                    </span>
                                        <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#<?php echo $index; ?></span>
                                        <span class="red-color">

                                        <?php echo modify_number($weight).'lbs '.$single['luggage_name'];?> - Label
                                    </span>
                                        <span>
                                        page, and follow the page instruction
                                    </span>
                                    </div>
                                </div>
                                <p class="fold_here"><span>Please Fold Here</span><span>Use of this label is subject to Luggage To Ship and <?php echo $order_info['currier_name'];?> Terms and Conditions </span></p>
                                <div class="label img_div img_div_box">
                                    <img class="inter_label_img" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single['file_name'];?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

            //INVOICE PAGES
            if(!empty($invoice_files)){
                if(!empty($invoice_count)){
                    for($i = 1; $i<=$invoice_count; $i++){
                        $copy = '';
                        if($i != 1){
                            $copy = ' Copy '.($i-1);
                        }
                        foreach($invoice_files as $single_page){

                            if($single['luggage_name'] == 'Special Boxes'){

                                $weight = $single['label_weight'];

                            }else{
                                $weight = $single['weight'];
                            }

                            ?>
                            <div class="div_page">
                                <div class="div_header padding_for_a4">
                                    <div class="header_info">
                                        <table>
                                            <tr>
                                                <td rowspan="2"><span class="circle_index_title">#<?php echo $index; ?></span></td>

                                                <td><h4 class="info_order"><?php echo modify_number($weight).'lbs '.$single['luggage_name'].' - Custom Invoice'.$copy;?></h4></td>
                                            </tr>
                                            <tr>
                                                <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="int_logo_address">
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
                                    <br class="clear">
                                </div>
                                <div class="page_body padding_for_a4">
                                    <div class="please_put_page">
                                    <span>
                                        Please put this page with &nbsp
                                    </span>
                                        <span class="circle_index_title" style="width:0.8cm;height:0.8cm;padding-top:0.05cm;">#<?php echo $index; ?></span>
                                        <span class="red-color">
                                        <?php echo modify_number($weight).'lbs '.$single['luggage_name'];?> - Label
                                    </span>
                                        <span>
                                        page, and follow the page instruction
                                    </span>
                                    </div>
                                    <img class="invoice_img_inter" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$single_page['file_name'];?>" alt="" />
                                </div>
                            </div>
                            <?php
                        }

                    }

                }
            }

        }
    }

    $type_arr = [
        'Luggage'    => 'luggage_img.jpg',
        'Boxes'      => 'box_img.jpg',
        'Golf Bag'   => 'golf_bag.jpg',
        'Bike & SKI' => 'sky_snowboard.jpg',
    ];


    $all_luggages = [
        "0" => $first_label
    ];

    if(!empty($label_info)){
        $all_luggages = array_merge($all_luggages, $label_info);
    }

    ?>

    <?php
    $all_luggages = array_values($all_luggages);

    $page = 1;

    $index = 1;

    while(!empty($all_luggages)){

        $first = NULL;
        $second = NULL;

        $first = $all_luggages[0];

        if(!empty($all_luggages[1])){
            $second = $all_luggages[1];
            unset($all_luggages[1]);
        }

        unset($all_luggages[0]);

        $all_luggages = array_values($all_luggages);

        ?>

        <div class="div_page">
            <div class="div_header padding_for_a4">
                <div class="header_info">
                    <table>
                        <tr>
                            <td rowspan="2"></td>
                            <td><h4 class="info_order red-text">Shipping Summary Paper <?php echo $page; ?></h4></td>
                        </tr>
                        <tr>
                            <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="int_logo_address">
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
                <br class="clear">
            </div>
            <div class="page_body padding_for_a4">
                <div class="first_label_div">
                    <div class="truck_info">
                        <p>
                            Please follow the dot line and cut the summary paper.
                            Please following below instruction put <br> paper inside related luggage/bag/case or tape paper on related box.
                            Please <span class="error_class">DO NOT LOCK</span> your  luggage/bag/case, use cable ties instead.
                        </p>
                    </div>
                    <?php
                    $img_name = ($first['luggage_name'] == 'Bike Box')?$type_arr['Boxes']:$type_arr[$first['types']];
                    ?>
                    <div class="sender_receiver_info sender_receiver_info_international">
                        <div class="<?php echo ($first['types'] == 'Boxes' || ($first['types'] == 'Bike & SKI' && $first['luggage_name'] == 'Bike Box'))?'instructors2':'instructors1'; ?>">
                            <p><?php echo $first['luggage_name']; ?></p>
                            <img src="<?php echo base_url('assets/images/labeling/').$img_name;?>" alt="">
                        </div>
                        <div class="sender_receiver_info2">
                            <div class="labels_navigation">
                                <span class="number"><?php echo $index; ?></span>
                                <?php

                                if($first['luggage_name'] == 'Special Boxes'){
                                    $label_weight = $first['label_weight'];

                                }else{
                                    $label_weight = $first['weight'];
                                }
                                ?>
                                <h4 class="info_luggage number"><?php echo modify_number($label_weight).'lbs '.$first['luggage_name']; ?></h4>
                                <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                            </div>
                            <div class="tracking_inf">
                                <p><?php echo $order_info['currier_name'].' Tracking '.$first['tracking_number']; ?></p>
                            </div>
                            <div>
                                <ul>
                                    <li><p class="text-bold">From:</p></li>
                                    <li><p><?php echo $sender_info['sender_first_name'].' '. $sender_info['sender_last_name'];?></p></li>
                                    <li><p><?php echo $sender_info['pickup_address1'];?></p></li>
                                    <li><p><?php echo $sender_info['pickup_address2'];?></p></li>
                                    <li><p><?php echo $sender_info['pickup_city'].$sender_state;?></p></li>
                                    <li><p><?php echo $sender_info['sender_phone'];?></p></li>
                                </ul>
                                <ul>
                                    <li><p class="text-bold">To:</p></li>
                                    <li><p><?php echo $delivery_info['receiver_first_name'].' '. $delivery_info['receiver_last_name'];?></p></li>
                                    <li><p><?php echo $delivery_info['delivery_address1'];?></p></li>
                                    <li><p><?php echo $delivery_info['delivery_address2'];?></p></li>
                                    <li><p><?php echo $delivery_info['delivery_city'].$delivery_state;?></p></li>
                                    <li><p><?php echo $delivery_info['receiver_phone'];?></p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($second)) { ?>
                        <div class="sender_receiver_info sender_receiver_info_international">
                            <div class="<?php echo ($second['types'] == 'Boxes' || ($second['types'] == 'Bike & SKI' && $second['luggage_name'] == 'Bike Box'))?'instructors2':'instructors1'; ?>">
                                <p><?php echo $second['luggage_name']; ?></p>
                                <?php
                                $img_name = ($second['luggage_name'] == 'Bike Box')?$type_arr['Boxes']:$type_arr[$second['types']];
                                ?>
                                <img src="<?php echo base_url('assets/images/labeling/').$img_name;?>" alt="">
                            </div>
                            <div class="sender_receiver_info2">
                                <div class="labels_navigation">
                                    <?php

                                    if($second['luggage_name'] == 'Special Boxes'){
                                        $label_weight = $second['label_weight'];

                                    }else{
                                        $label_weight = $second['weight'];
                                    }
                                    ?>
                                    <span class="number"><?php echo $index+1; ?></span>
                                    <h4 class="info_luggage number"><?php echo modify_number($label_weight).'lbs '.$second['luggage_name']; ?></h4>
                                    <h4 class="info_order">Order #:<?php echo $order_info['order_id'];?></h4>
                                </div>
                                <div class="tracking_inf">
                                    <p><?php echo $order_info['currier_name'].' Tracking '.$second['tracking_number']; ?></p>
                                </div>
                                <div>
                                    <ul>
                                        <li><p class="text-bold">From:</p></li>
                                        <li><p><?php echo $sender_info['sender_first_name'].' '. $sender_info['sender_last_name'];?></p></li>
                                        <li><p><?php echo $sender_info['pickup_address1'];?></p></li>
                                        <li><p><?php echo $sender_info['pickup_address2'];?></p></li>
                                        <li><p><?php echo $sender_info['pickup_city'].$sender_state;?></p></li>
                                        <li><p><?php echo $sender_info['sender_phone'];?></p></li>
                                    </ul>
                                    <ul>
                                        <li><p class="text-bold">To:</p></li>
                                        <li><p><?php echo $delivery_info['receiver_first_name'].' '. $delivery_info['receiver_last_name'];?></p></li>
                                        <li><p><?php echo $delivery_info['delivery_address1'];?></p></li>
                                        <li><p><?php echo $delivery_info['delivery_address2'];?></p></li>
                                        <li><p><?php echo $delivery_info['delivery_city'].$delivery_state;?></p></li>
                                        <li><p><?php echo $delivery_info['receiver_phone'];?></p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php
        $page ++;
        $index += 2;
    }


    if(!empty($dhl_last_page) && !empty($dhl_last_page_img[0]['file_name'])){
        ?>
        <div class="div_page">
            <div class="div_header padding_for_a4">
                <div class="header_info">
                    <table>
                        <tr>
                            <td rowspan="2"></td>
                            <td><h4 class="info_order error_class">Archive Page for Carrier</h4></td>
                        </tr>
                        <tr>
                            <td><span class="info_luggage">Order #:<?php echo $order_info['order_id'];?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="int_logo_address">
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
                <br class="clear">
            </div>
            <div class="page_body padding_for_a4">
                <div class="dhl_page">
                    <div class="dhl_page_text">
                     <span>
                         Please hand over this page to DHL pick up person or staff at DHL drop off locations.
                     </span>
                    </div>
                    <img class="invoice_img_inter" src="<?php echo base_url().'uploaded_documents/orders_files/'.$order_info['id'].'/'.$dhl_last_page_img[0]['file_name'];?>" alt="" />
                </div>
            </div>
        </div>
        <?php
    }

    ?>
</div>
</body>
</html>

