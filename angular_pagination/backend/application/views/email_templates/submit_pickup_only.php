<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Your Pick-up is Scheduled</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Your pick up has been scheduled! Please below pick-up information. Please have everything ready before the pickup time frame starts. </p>
            </td>
        </tr>
    </table>
    <p style="color: darkgrey; text-align: center; margin-bottom: 25px;">Order #   <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>
   <!-- --><?php
/*    $code = ($shipping_type == 1)?$country_from:$pickup_postal_code;
    $code2 = ($shipping_type == 1)?$country_to:$delivery_postal_code;
    */
                $zip_code = (!empty($pickup_postal_code))?', '.$pickup_postal_code:'';
            ?>
    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:47%;padding:20px; float: left;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 50%;">
                <span style="vertical-align: top; margin-top: -5px;"><img src="<?php echo base_url(); ?>assets/images/calendar_for_email2.jpg" alt="" style="margin-top: -5px;"></span>
                <span style="color: darkgrey;margin-left: 7px; vertical-align: top;display: inline-block;margin-top: 7px;"> Pickup address: </span>
                <p style="font-weight: 600; font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px;margin-left: 37px;"><?php echo $pickup_address1; ?> </p>
                <p style="font-weight: 600;font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px;margin-left: 37px;"><?php echo $pickup_city.' '.$zip_code; ?> </p>
                <p style="font-weight: 600;font-size: 11px;font-family:sans-serif;vertical-align:top; margin: 5px;padding-bottom: 10px;margin-left: 37px;"><?php echo $country_from; ?> </p>
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
            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>