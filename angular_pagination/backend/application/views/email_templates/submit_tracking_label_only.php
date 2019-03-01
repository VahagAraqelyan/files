<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Your Shipping label is Ready</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"> Your shipping label for order is ready. Please find a link to print out shipping instruction and labels. If you requested a
                pick-up, a confirmation email will be sent to you separately once scheduled  </p>
            </td>
        </tr>
    </table>
    <?php
    $code = ($shipping_type == 1)?$country_from:$pickup_postal_code;
    $code2 = ($shipping_type == 1)?$country_to:$delivery_postal_code;
    ?>
    <p style="color: darkgrey; text-align: center; margin-bottom: 25px;">Order #   <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>
    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:50%;padding:0px; float: left;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/from_icon.jpg" alt=""></span><span style="color: darkgray;margin-left: 7px; vertical-align: top;"> From: </span>
                <span style="margin: 3px; margin-left: 10px; vertical-align: top;font-weight: 600;font-size: 12px;"><?php echo $pickup_city.', '.$code; ?></span>
                <span style="margin-top: -8px;margin-bottom: 17px; display: block; margin-left: 80px;"><?php echo date('m/d/Y', strtotime($shipping_date)); ?></span>
            </td>
        </tr>
        <tr style="padding-bottom: 15px;">
            <td>
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/<?php echo strtolower($currier_name); ?>.png" alt="" style="width: 40px;"></span>
                <span style="margin-left: 38px; font-size: 12px;font-family:sans-serif;vertical-align:top; width: 25%;"><?php echo change_order_type($origin_send_type,$currier_name,$shipping_type); ?> </span>
                <p style="margin: 5px; font-size: 13px; margin-left: 80px"> <?php echo (!empty($luggage_info[0]['tracking_number']))?'<span style="color:darkgray;">Tracking #: <a href= '.base_url('luggage-tracking/').$currier_name.'/'.$luggage_info[0]['tracking_number'].'>'.$luggage_info[0]['tracking_number'].'</a></span>':''; ?></p>
            </td>
            <td>


            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:40%;padding:0px; float: left;">
        <tr style="display: block;margin-bottom: 13px;">
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 20%;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/email_flag.jpg" alt=""></span><span style="margin-bottom: -14px; color: darkgray;margin-left: 7px; vertical-align: top;">To:</span>
            </td>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 62%;">
                <span style="margin: 3px;font-weight: 600;font-size: 12px;color: #000;margin-left: 20px;"><?php echo $delivery_city.', '.$code2; ?> </span>
            </td>

        </tr>


        <tr >
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 50%;">
                    <p style="margin-left: 75px"><a href="<?php echo base_url('stream/labels/'.$labels_pdf.'/'.sample_hash($user_id)); ?>" style="color: white; background:#F6BE98;border-radius: 8px;padding: 9px;text-decoration: none;font-size: 11px; margin: 0px -12px;">Print shipping labels</a></p>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:5px;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>