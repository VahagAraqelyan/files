<?php
$max_incurance = 0;
$extra_fee = 0;
$total_count = 0;
foreach ($incurance as $index => $insurance){

    $max_incurance += $insurance['incurance_fee'];
    $extra_fee += $insurance['insurance'];
    $total_count ++;
}

?>
        <div class="register-block no-hide" id="main_incurance_div">
            <h2 class="register-title text-center lovercase for_mobile_margin">Item(s) and Insurance</h2>

            <div class="form-horizontal text-left">
                <div class="panel-body mobile_padding_in_popap" >

                    <div class="col-md-12 div_incurance_info">

                        <p class="incurance_info">Total Item: <span class="orange-color"><?php echo $total_count; ?></span></p>
                        <p class="incurance_info " >Total Extra Fee: <span class="orange-color" id="incurance_fee">$<?php echo (!empty($max_incurance))?$max_incurance:0; ?></span></p>
                        <p class="incurance_info">Max Insurance: <span class="orange-color" id="incurance_amount">$<?php echo (!empty($extra_fee))?$extra_fee:0; ?></span></p>
                    </div>

                    <form method="post" action="" class="incurance_form">
                        <table class="table table-bordered  designed-table incurance_table incurance_table_small">
                            <thead>
                            <tr>
                                <th class=""><b><small>#</small></b></th>
                                <th class=""><b><small>Item Type</small></b></th>
                                <th class=""><b><small>Insurance Coverage</small></b></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $min_insurance = '';

                            if(!empty($incurance_info['insurance_price'])){

                                foreach ($incurance_info['insurance_price'] as $single){
                                    if(empty($single['insurance_fee'])){
                                        $min_insurance = $single['insurance_amount'];
                                    }

                                }
                            }

                            if(!empty($incurance)){

                                foreach ($incurance as $index => $value){

                                    $amount = ($value['incurance_fee'] == 0)?'Free':"$".$value['incurance_fee'];
                                    ?>
                                    <tr>
                                        <td><?php echo $index +1; ?></td>
                                        <td><?php echo $value['luggage_name'];?></td>
                                        <td><?php echo $amount." For "."$".$value['insurance'] ?> <b>insurance</b></td>
                                    </tr>
                                <?php } }else if(!empty($prod)){
                                $index = 1;
                                $order_insurance = (empty($order_info['free_insurance']))?0:$order_info['free_insurance'];
                                $count = count($prod);
                                foreach ($prod as $luggage){

                                    while ($count >0){ ?>
                                        <tr>
                                            <td><?php echo $index; ?></td>
                                            <td><?php echo $luggage['luggage_name'];?></td>
                                            <td><?php echo "Free For "."$".$order_insurance; ?> insurance</td>
                                        </tr>
                                        <?php
                                        $index++;
                                        $count--;
                                    }
                                }
                            } ?>

                            </tbody>
                        </table>
                        <div class="small_font_text small_font_size">
                            <p class="jusify_class">Up to <?php echo $min_insurance; ?> free insurance coverage is provided for each luggage. You may purchase additional insurance coverage for your shipment.</p>
                            <p class="jusify_class">The insurance will ONLY Cover lost or extremely damaged luggage/parcel.
                                The insurance does NOT cover fragile items, electronics, cosmetic damages of your luggage, prohibited items, or any other items specified in our
                                <a target="_blank" href="<?php echo base_url('luggagetoship-terms-of-use')?>">Terms and Conditons.</a></p>


                        </div>
                    </form>
                    <?php if($order_info['shipping_status'] == SUBMITTED_STATUS[0]){ ?>
                      <!--  <div class="form-group">
                            <button type="button" class="btn btn-default btn-login-orange save-info-btn insurance_edit_button">Edit</button>
                        </div>-->
                    <?php }?>
                </div>
            </div>
        </div>
