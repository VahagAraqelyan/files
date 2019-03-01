<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Thank you for your order .</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Your order has been confirmed. Please check the order summary below.  We are preparing shipping labels and will
                send it to you soon. If you requested a pick-up, a confirmation email will be sent to you separately once scheduled.</p>
            </td>
        </tr>
    </table>
    <?php
    $code = ($shipping_type == 1)?$country_from:$pickup_postal_code;
    $code2 = ($shipping_type == 1)?$country_to:$delivery_postal_code;
    ?>
    <p style="color: darkgrey; text-align: center; margin-bottom: 25px;">Order # <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>

    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:47%;padding:20px; float: left;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/from_icon.jpg" alt=""></span><span style="color: darkgray;margin-left: 7px; vertical-align: top;">From: </span>
                <span style="margin: 3px; margin-left: 3px;vertical-align: top;font-weight: 600;font-size: 10px;"><?php echo $pickup_city.', '.$code; ?> </span>
                <p style="margin-left: 69px;margin-top: 0;margin-bottom: 15px;"><?php echo  date('m/d/Y', strtotime($shipping_date)); ?> </p>
            </td>
        </tr>
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/email_flag.jpg" alt="" style="vertical-align: top; width: 25px;"></span>
                <span style="color: darkgray;margin-left: 7px; vertical-align: top">To:</span>
                <span style="margin: 3px; margin-left: 12px;vertical-align: top;font-weight: 600;font-size: 10px;"><?php echo $delivery_city.', '.$code2; ?> </span>
                <p style="margin-top: 0;margin-left: 69px;margin-bottom: 15px;"><?php echo date('m/d/Y', strtotime($delivery_date)); ?> </p>
            </td>
        </tr>
        <tr>
            <td>
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/<?php echo strtolower($currier_name); ?>.png" alt="" style="width: 57px;"></span>
                <span style="margin-left: 10px; font-size: 12px;font-family:sans-serif;vertical-align:top;"><?php echo change_order_type($origin_send_type,$currier_name,$shipping_type); ?> </span>
            </td>
        </tr>
    </table>


    <table border="0" cellpadding="0" cellspacing="0" width="40%" style="margin-left: 12px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:47%;padding:20px; float: left;">
        <tr style="display: block;margin-bottom: 5px;">
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 100%;">
                <span style="vertical-align: top;"><img src="<?php echo base_url(); ?>assets/images/to_email_img.jpg" alt=""></span><span style="color: darkgrey;margin-left: 7px; vertical-align:top;">Estimated Order Total: </span>
            </td>
        </tr>
        <tr style="display: block;margin-bottom: 15px; margin-left: 37px;">
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top; width: 100%;">
                <p style="margin: 0;margin-left: 3px;">$<?php echo $price['original_price']; ?> </p>
            </td>
        </tr>
        <tr style="display: block;margin-bottom: 15px; margin-left: 37px;">
            <td style="font-size: 13px;font-family:sans-serif;vertical-align:top; width: 100%; padding-bottom: 10px;">
                <p style="margin: 0;margin-left: 3px;"><a href="<?php echo base_url('order/check_order_status/').$real_id; ?>" style="color: black; border: 1px solid gray; background: whitesmoke;border-radius: 8px;padding: 6px;text-decoration: none;font-size: 10px;">View or edit order </a></p>
            </td>
        </tr>

    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;Margin-bottom:15px;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
                <br>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>