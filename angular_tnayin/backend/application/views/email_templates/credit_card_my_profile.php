<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
    <tr>
        <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Please complete the credit card verification processing</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Thank you for choosing our services. For security reason, our accounting department would like to verify your credit card ending with <?php echo "********".substr($card_number,0,4); ?>. We have charged an amount from your card.</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">Charge Time: <?php echo $charge_date; ?> EST</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Company Name: Luggagetoship.com</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;Margin-bottom:15px;">Please check with your bank for the verification amount we charged. Please submit the amount in  <a href="<?php echo base_url('user/my_profile'); ?>">My Profile</a> credit card part. We will refund the amount to your credit card within 48 hours.</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions on credit card verification, please chat with us online or send email to  <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com</a>.</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">Sincerely,</p>
            <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">Customer Service Team</p>
        </td>
    </tr>
</table>
