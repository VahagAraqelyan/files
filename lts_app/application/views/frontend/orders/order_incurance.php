<?php

$max_incurance = 0;
$extra_fee = 0;
foreach ($incurance['incurance_info'] as $insurance){

$max_incurance += $insurance['incurance_fee'];
$extra_fee += $insurance['insurance'];

}

if(!empty($order['free_insurance'])){

    $option = '';

}else{

    $option = '<option value="">Select insurance</option>';
}



?>

<div class="register-block no-hide my_profile_content" id="main_incurance_div">
     <input type="hidden" id="type_id" value="<?php echo $type; ?>">
                <h2 class="register-title text-center no_transform for_mobile_margin">Item(s) and Insurance</h2>

                <div class="form-horizontal text-left">
                    <div class="panel-body mobile_padding_in_popap">
                        <div id="answer_upload">
                            <span id="show_upload_error_img"></span>
                            <span id="show_error_my_profile"></span>
                        </div>
                        <div class="col-md-12 div_incurance_info">

                            <p class="incurance_info">Total Item: <span class="orange-color"><?php echo (!empty($incurance['total_count']))?$incurance['total_count']:''; ?></span></p>
                            <p class="incurance_info " >Total Extra Fee: <span class="orange-color" id="incurance_fee">$<?php echo (!empty($max_incurance))?$max_incurance:0; ?></span></p>
                            <p class="incurance_info">Max Insurance: <span class="orange-color" id="incurance_amount">$<?php echo (!empty($extra_fee))?$extra_fee:0; ?></span></p>
                        </div>
                        <form method="post" action="" class="incurance_form">
                    <table class="table table-bordered table-hover designed-table incurance_table incurance_table_small">
                        <thead>
                        <tr>
                            <th class=""><small><b>#</b></small></th>
                            <th class=""><small><b>Item Type</b></small></th>
                            <th class=""><small><b>Insurance Coverage</b></small></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            $count = 0;
                            ?>
                            <?php if(!empty($incurance)){


                                foreach ($incurance['incurance_info'] as $index => $value){
                                    $min_insurance = '';
                                    $insurance_id = (!empty($value['order_luggage_id']))?$value['order_luggage_id']:0;
                                    $count++;
                                    ?>
                            <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $value['luggage_name'];?></td>
                                    <td><select  name = "insurance_price_<?php echo $index+1; ?>" class="my_profile incurance_select selectpicker col-sm-3  col-md-12 select-country">
                                            <?php echo (!empty($option))?$option:''; ?>
                                        <?php foreach ($incurance['insurance_price'] as $incurance_fee){

                                            if(empty($incurance_fee['insurance_fee'])){
                                                $min_insurance = $incurance_fee['insurance_amount'];
                                            }

                                            $k = (!empty($value['incurance_id']) && $value['incurance_id'] == $incurance_fee['insurance_id'])?'selected="selected"':'';
                                            $amount = ($incurance_fee['insurance_fee'] ==0)?'Free':"$".$incurance_fee['insurance_fee'];
                                            ?>
                                            <option value="<?php echo $incurance_fee['insurance_id']."_".$insurance_id; ?>" <?php echo  $k; ?>><?php echo $amount." for "."$".$incurance_fee['insurance_amount']; ?> </option>
                                        <?php  } ?>
                                        </select></td>


                            </tr>
                                <?php } }

                                ?>

                        </tbody>
                    </table>
                            <div class="small_font_text small_font_size">
                                <p class="jusify_class">Up to <?php echo $min_insurance; ?> free insurance coverage is provided for each luggage. You may purchase additional insurance coverage for your shipment.</p>
                                <p class="jusify_class">The insurance will ONLY Cover lost or extemely damaged luggage/parcel.
                                    The insurance does NOT cover fragile items, electronics, cosmetic damages of your luggage, prohibited items, or any other items specified in our
                                    <a target="_blank" href="<?php echo base_url('luggagetoship-terms-of-use')?>">Terms and Conditons.</a></p>


                            </div>
                        <div class="col-md-12 text-right button_incurance">
                            <button type="button" class="btn btn-default btn-login-orange save-info-btn save_incurance close_modal no_transform">Update Insurance</button>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
