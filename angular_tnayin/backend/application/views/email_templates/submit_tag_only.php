<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="color:orange; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px">We are sending you an envelope with shipping labels, pouches and tags</p>
                <p style="color:#000;font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:5px;">We are sending you an envelope which includes: Shipping labels, instructions, label pouch, luggage tag and cable ties (if applied).</p>
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

    <p style="color: darkgrey; text-align: center; margin-bottom: 25px;">Order # <a style="color: #3399FF;" href="<?php echo base_url('order/check_order_status/').$real_id;?>"><?php echo $order_number; ?> </a></p>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style=" padding: 20px; border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <span style="vertical-align: top; margin-top: -5px;"><img src="<?php echo base_url(); ?>assets/images/email_pismo.jpg" alt="" style="margin-top: -5px;"></span>
                <span style="color: darkgrey;margin-left: 7px; vertical-align: top;"> Will arrive:</span>
                <p style="margin: 0; margin-left: 41px;"><?php echo date('m/d/Y', strtotime($label_shipment['delivery_date'])); ?></p>
                <p style="margin-left:43px; vertical-align: top;font-weight: 600;font-size: 12px;margin-bottom: 5px; margin-top: 0;"><?php echo $address_arrive; ?></p>
            </td>
            <td style="vertical-align: text-bottom">
                <?php
                if(!empty($label_shipment['tracking'])){ ?>
                    <p style="margin-top: 0"><a href="<?php echo base_url('stream/labels/'.$labels_pdf.'/'.sample_hash($user_id)); ?>" style="color: black; border: 1px solid gray; background: whitesmoke;border-radius: 8px;padding: 6px;text-decoration: none;font-size: 10px;">Track the tag envelope </a></p>
                <?php } ?>
            </td>
        </tr>
    </table>

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