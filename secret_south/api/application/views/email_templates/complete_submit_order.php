<?php
if($shipping_type == '1'){

    $city_or_country = $country_to;
}else{
    $city_or_country = $city_to.','.$postal_code;
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px;background:#fff;">
    <tr>
        <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Please complete and submit your order</p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $first_name. ' '. $last_name; ?>:</p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;;Margin-bottom:15px;color:#3e3e3e;">Thank you for visiting Luggage To Ship. You recently created a new shipping order to <?php echo $city_or_country; ?>. If you have not submitted the order, simply visit <a href="<?php echo base_url('dashboard/dashboard')?>">your dashboard</a> to complete the order.
           Please be advised the incomplete order will be automatically cancelled after <?php echo $shipping_date; ?></p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions on placing an order, please reach out us at : <a href="tel:18006786167" class="phone_color">1800 678 6167</a>  or <a href="<?php echo  base_url(); ?>">cs@luggagetoship.com.</a></p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;color:#3e3e3e;">LuggageToShip is here with you for every trip!</p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;color:#3e3e3e;">Sincerely,</p>
            <p style="font-family:sans-serif;font-size:12px;font-weight:normal;margin:0;color:#3e3e3e;">Customer Service Team</p>
        </td>
    </tr>
</table>

<!--<ul style="background: white;margin: 0">
    <li style="list-style: none;">Tips:</li>
    <li style="list-style: none;">
        <ul>
            <li style="list-style: disc;">How to place an order?</li>
            <li style="list-style: disc;">How you process my order?</li>
            <li style="list-style: disc;">How to edit my order?</li>
        </ul>
    </li>
    <li style="list-style: none;">Tools:</li>
    <li style="list-style: none;">
        <ul>
            <li style="list-style: disc;">Prohibited Item List</li>
            <li style="list-style: disc;">Items not covered by insurance</li>
            <li style="list-style: disc;">Luggage size and weight calculator</li>
        </ul>
    </li>
</ul>-->