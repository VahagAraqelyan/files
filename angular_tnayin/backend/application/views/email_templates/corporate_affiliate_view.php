<?php
if($type == 'corporate_type'){
    $text = 'Thank you for submitting following form and applying for a corporate account. One of our sales managers will contact you shortly within 48 hours, and discuss the account details with you.';
}else{
    $text = 'Thank you for submitting following form and applying for an affiliate account. One of our sales managers will contact you shortly within 48 hours, and discuss the account details with you.';
}
?>
<div style="width: 600px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107"><?php echo $title_view; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><?php echo $text;?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">First Name:</span> <?php echo $first_name; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Last Name:</span> <?php echo $last_name; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Title:</span><?php echo $title_inp; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Organization:</span><?php echo $organization; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Email:</span> <?php echo $email; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Phone:</span> <?php echo $phone; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;"><span style="font-weight: 700">Company Information:</span><?php echo $company_info; ?></p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Kind Regards,<br> Luggage To Ship Sales Team</p>

            </td>
        </tr>
    </table>
</div>