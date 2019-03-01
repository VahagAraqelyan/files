<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:600px;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;color:#ff9107">Your Order is Ready!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">We have your order ready! Please follow the shipping instruction to pack and label your package(s) and have everything ready before the drop-off.</p>

            </td>
        </tr>
    </table>
    <p style="color:darkgrey; text-align: center; margin-bottom: 25px;">Order #   <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>

   <?php
   $code = ($shipping_type == 1)?$country_from:$pickup_postal_code;
   ?>

    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:50%;padding:0px; float: left;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/from_icon.jpg" alt="">
                </span><span style="color: darkgray;margin-left: 27px; vertical-align: top;"> Drop off: </span>
                <p style="margin-left:50px; vertical-align: top;font-weight: 600;font-size: 12px;margin-bottom: 12px; margin-top: 0;"><?php echo $pickup_city.', '.$code; ?></p>
            </td>
        </tr>
        <tr style="">
            <td>
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/<?php echo strtolower($currier_name); ?>.png" alt="" style="width: 40px;"></span>
                <span style="margin-left: 10px; font-size: 12px;font-family:sans-serif;vertical-align:top; width: 25%;"><?php echo change_order_type($origin_send_type,$currier_name,$shipping_type); ?> </span>
                <p style="margin: 5px; font-size: 13px; margin-left: 53px"> <?php echo (!empty($luggage_info[0]['tracking_number']))?'<span style="color:darkgray;">Tracking #: <a href= '.base_url('luggage-tracking/').$currier_name.'/'.$luggage_info[0]['tracking_number'].'>'.$luggage_info[0]['tracking_number'].'</a></span>':''; ?></p>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:40%;padding:0px; float: left;">
        <tr style=" margin-top: 4px; margin-bottom: 15px; display: block;">
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 50%;">
                <p style="margin:0"><a href="<?php echo base_url('public_pages/drop_of_locations/').$pickup_country_id.'/'.$pickup_postal_code.'/'.$currier_name;?>" style="color: white; background:#ADCDEA;border-radius: 7px;padding: 9px;text-decoration: none;font-size: 11px; margin: 0px -12px;">Find a drop off location</a></p>
            </td>
        </tr>
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 50%;">
                <?php
                if(!empty($labels_pdf)){ ?>
                    <p style="margin: 23px 0;"><a href="<?php echo base_url('stream/labels/'.$labels_pdf.'/'.sample_hash($user_id)); ?>" style="color: white; background: #F6BE98;border-radius: 7px;padding: 9px;text-decoration: none;font-size: 11px; margin: 0px -12px;">Print shipping labels</a></p>
                <?php } ?>
            </td>
        </tr>
    </table>

    <div style="width: 600px;float: none;clear: both;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:600px;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="color:#000; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;">We are sending you an envelope which includes: Shipping labels, instructions, label pouch, luggage tag and cable ties (if applied).</p>
            </td>
        </tr>
    </table>
    <?php

    if(!empty($new_address['city'])){

        $address_arrive = $new_address['city'].', '.$new_address['postal_code'];

    }else{

        $address_arrive =  $pickup_city.', '.$pickup_postal_code;
    }
    ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" padding: 20px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top; margin-top: -5px;"><img src="<?php echo base_url(); ?>assets/images/email_pismo.jpg" alt="" style="margin-top: -5px;"></span>
                <span style="color: darkgrey;margin-left: 7px; vertical-align: top;"> Will arrive:</span>
                <p style="margin: 0; margin-left: 41px;"><?php echo date('m/d/Y', strtotime($shipping_date)); ?></p>
                <p style="margin-left:43px; vertical-align: top;font-weight: 600;font-size: 12px;margin-bottom: 5px; margin-top: 0;"><?php echo $address_arrive; ?></p>
            </td>
            <td style="vertical-align: text-bottom">
                <?php
                if(!empty($label_shipment['tracking'])){ ?>
                    <p style="margin-top: 0"><a href="<?php echo base_url('luggage-tracking/').$currier_name.'/'.$label_shipment['tracking']; ?>" style="color: black; border: 1px solid gray; background: whitesmoke;border-radius: 8px;padding: 6px;text-decoration: none;font-size: 10px;">Track the tag envelope </a></p>
                <?php } ?>
            </td>
        </tr>
    </table>
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>