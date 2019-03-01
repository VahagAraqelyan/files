<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Your Order is Ready</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px">We have your order ready! Please follow the shipping instruction to pack and label your package(s) and have everything ready before the pick-up.</p>
            </td>
        </tr>
    </table>
    <p style="color:darkgrey; text-align: center; margin-bottom: 25px;">Order #   <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>

    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:47%;padding:20px; float: left;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 50%;">
                <span style="vertical-align: top; margin-top: -5px;"><img src="<?php echo base_url(); ?>assets/images/calendar_for_email2.jpg" alt="" style="margin-top: -5px;"></span>
                <span style="color: darkgrey;margin-left: 7px; vertical-align: top;display: inline-block;margin-top: 7px;margin-left: 30px;"> Pickup address :</span>
                <p style="color: #000; font-weight:600;font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px; margin-left: 60px;"><?php echo $pickup_address1; ?> </p>
                <p style="color: #000; font-weight:600;font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px; margin-left: 60px;"><?php echo (!empty($pickup_postal_code))?$pickup_city.', '.$pickup_postal_code:$pickup_city; ?> </p>
                <p style="color: #000; font-weight:600;font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px; padding-bottom: 10px;margin-left: 60px;"><?php echo $country_from; ?> </p>
            </td>
        </tr>
        <tr>
            <td>
                <span style="margin-right: 7px; vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/<?php echo strtolower($currier_name); ?>.png" alt=""></span> <span style="font-size: 12px;font-family:sans-serif;vertical-align:top; width: 50%; padding-bottom: 10px;"><?php echo change_order_type($origin_send_type,$currier_name,$shipping_type);?></span>
                <p style="margin: 5px; font-size: 13px;margin-left: 60px;"> <?php echo (!empty($luggage_info[0]['tracking_number']))?'<span style="color:darkgray;">Tracking #: <a href= '.base_url('luggage-tracking/').$currier_name.'/'.$luggage_info[0]['tracking_number'].'>'.$luggage_info[0]['tracking_number'].'</a></span>':''; ?></p>

            </td>
        </tr>
    </table>


    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:47%;padding:20px; float: left;">
        <tr style="display: block;margin-bottom: 5px;">
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 100%;">
             <span style="color: darkgrey;margin-left: 7px; vertical-align: bottom;display: inline-block;margin-top: 7px;">Pickup time and confirmation #</span>
                <p style="margin: 5px; color: orange; "> <?php echo date('m/d/Y', strtotime($shipping_date)); ?></p>
                <p style="margin: 5px; color: orange; "> <?php echo $pickup_time; ?></p>
                <p style="margin: 5px; color: #000; margin-bottom: 16px; "> #<?php echo $shedule['con']; ?></p>

                <?php
                if(!empty($labels_pdf)){ ?>
                     <p><a href="<?php echo base_url('stream/labels/'.$labels_pdf.'/'.sample_hash($user_id)); ?>" style="color: white; background: #F6BE98;border-radius: 7px;padding: 9px;text-decoration: none;font-size: 11px; margin: 0px -12px;">Print shipping labels</a></p>
                 <?php } ?>
            </td>
        </tr>
    </table>
<?php
if(!$subject_description){ ?>


    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;">We are sending you an envelope which includes: Shipping labels, instructions, label pouch, luggage tag and cable ties (if applied).</p>
            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" padding: 20px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top; margin-top: -5px;margin-left: 6px"><img src="<?php echo base_url(); ?>assets/images/email_pismo.jpg" alt="" style="margin-top: -5px;"></span>
                <span style="color: darkgrey; vertical-align: top;margin-left: 35px;"> Will arrive:</span>
                <p style="font-weight:600; margin: 0; margin-left: 75px;"><?php echo date('m/d/Y', strtotime($shipping_date)); ?></p>
            </td>
            <td style="vertical-align: text-bottom">
                <?php
                if(!empty($label_shipment['tracking'])){ ?>
                    <p style="margin-top: 0"><a href="<?php echo base_url('luggage-tracking/').$currier_name.'/'.$label_shipment['tracking']; ?>" style="color: black; border: 1px solid gray; background: whitesmoke;border-radius: 8px;padding: 6px;text-decoration: none;font-size: 10px;">Track the tag envelope </a></p>
                <?php } ?>
            </td>
        </tr>
    </table>
   <?php }
    ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;Margin-bottom:15px;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
    </div>