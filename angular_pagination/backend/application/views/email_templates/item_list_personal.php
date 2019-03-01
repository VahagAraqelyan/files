<div style="width: 650px;background: white;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px 0;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;margin-bottom:30px;font-weight:600;color:#ff9107">Thank you for submitting the item list for custom clearance</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Dear <?php echo $username; ?>:</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Thank you for submitting the item list for order : <a href="<?php echo base_url('order/check_order_status/').$order_id;?>"><?php echo $order_number; ?></a></p>
                <br>
                <span style="display: block; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;"><span style="color:darkgray; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;">Destination country :</span ><span> <?php echo $country_to; ?></span></span>
                <span style="display: block; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;"><span style="color:darkgray;font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;">Shipping purpose: </span><span>Personal Effects </span></span>
                <span style="display: block; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;"><span style="color:darkgray;font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;">Total item quantity: </span><span><?php echo intval($quantity); ?></span></span>
                <span style="display: inline; font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;"><span style="color:darkgray;font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:7px;">Total declared value: </span><span>$<?php echo floatval($declared_value); ?></span></span>
                <span style="display: inline; margin-left: 30px;"><a href="<?php echo base_url('order/custom_documents/').$order_id; ?>" style="color: black; border: 1px solid gray; background: whitesmoke;border-radius: 6px;padding: 9px;text-decoration: none;font-size: 9px; max-width: 100px;">View or edit item list</a></span>
            </td>

        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;padding:20px 0;background:#fff;">
        <tr>
            <td style="font-family:sans-serif;font-size:13px;vertical-align:top;">
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">We recommend our customers to provide the passport, visa and travel itinerary copies to <?php echo $country_to; ?> customs
                to confirm that all items are temporary importing for personal use. You may upload copies in <a style="color: #00aced;" href="<?php echo base_url('order/custom_documents/').$order_id; ?>">custom document page</a>
                or attach them to your package together with shipping labels later.</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:30px;color:#3e3e3e;">Please be advised any international shipment is
                    subject to customs clearance and may be charged possible tax and duty.
                    LuggageToShip is not responsible for any customs delays and tax & duty fees.
                    The customs of the destination country have the right to check, re-value your item(s) and charge applied tax and duty correspondingly.
                    To avoid customs delay, we strongly suggest our customers to provide a completed and accurate item list.
                    Please check <a href="<?php echo base_url('luggagetoship-terms-of-use'); ?>">Terms and Conditions</a> for details.</p>

                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Shall you have further questions, please chat with us online or send email to  <a href="#">cs@luggagetoship.com</a>.</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;color:#3e3e3e;">Best Regards,</p>
                <p style="font-family:sans-serif;font-size:13px;font-weight:normal;margin:0;Margin-bottom:15px;color:#3e3e3e;">Customer Service Team</p>
            </td>
        </tr>
    </table>
</div>