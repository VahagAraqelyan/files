<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:6px 20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Your order cancellation request has been submitted</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:10px;color:#3e3e3e;">We are sorry to know that you would like to cancel the order <a href="<?php echo  base_url('dashboard/view_order/').$order_id; ?>"><?php echo $order_number; ?></a> As this order has been processed, we will charge:</p>
            </td>
        </tr>
    </table>

    <ul style="padding: 0 20px;">
        <li style="list-style: disc;"> <?php echo (!empty($processing_fee[0]['cancelation_fee']))?$processing_fee[0]['cancelation_fee'].'USD':''; ?> order cancellation fee.</li>
        <li style="list-style: disc;"> Other related fees if applied</li>
    </ul>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">If you change minds or have any question on the cancellation, please reach out us at  <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="#">cs@luggagetoship.com</a> as soon as possible.</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">We will complete cancellation and process the refund within 15 days. Once the refund is processed, a notification email will be sent to you together with the finial invoice.</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">Best Regards,</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>