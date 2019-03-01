<?php
//if errors exists
    if(!empty($errors)){
        ?>
        <div id="answer_upload">
        <?php
        foreach($errors as $single){
            ?>
                <div><span class="error_img"></span> <span class="error_class"><?php echo $single; ?></span></div>
            <?php
        }
        ?>
        </div>
        <?php
        exit();
    }
    if(empty($result['sender']['validation_results']) && empty($result['receiver']['validation_results'])){
        ?>
        <div id="answer_upload">
            <div><span class="error_img"></span> <span class="error_class">Can not connect to server.</span></div>
        </div>
        <?php
        exit();
    }

    $sender_address_type = 'Undefined';
    $receiver_address_type = 'Undefined';

    if(isset($result['sender']['is_residential']) && $result['sender']['is_residential'] === true){
        $sender_address_type = 'Home';
    }elseif(isset($result['sender']['is_residential']) && $result['sender']['is_residential'] === false){
        $sender_address_type = 'Ground';
    }

    if(isset($result['receiver']['is_residential']) && $result['receiver']['is_residential'] === true){
        $receiver_address_type = 'Home';
    }elseif(isset($result['receiver']['is_residential']) && $result['receiver']['is_residential'] === false){
        $receiver_address_type = 'Ground';
    }

?>
<div id="address_validation_result">
<table>
    <tr>
        <td>
            <table class="origin_address">
                <tr>
                    <th>
                        <span class="addr_title">Pickup Address</span>
                        <?php
                        if(!empty($result['sender']['validation_results']['is_valid'])){
                            ?>
                            <i class="fa fa-check delivered-icon"></i>
                            <?php
                        }else{
                            ?>
                            <i class="fa fa-times delay-icon"></i>
                            <?php
                        }
                        ?>
                    </th>
                </tr>
                <tr>
                    <td><?php echo $result['sender']['origin']['name']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $result['sender']['origin']['street1'].' '.$result['sender']['origin']['street2']; ?></td>
                </tr>
                <tr>
                    <td>
                        <?php
                            echo $result['sender']['origin']['zip'].' '.$result['sender']['origin']['city'].' '.$result['sender']['origin']['state'].' '.$result['sender']['origin']['country'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Address type - <?php echo $sender_address_type; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table class="origin_address">
                <tr>
                    <th>
                        <span class="addr_title">Delivery Address</span>
                        <?php
                        if(!empty($result['receiver']['validation_results']['is_valid'])){
                            ?>
                            <i class="fa fa-check delivered-icon"></i>
                            <?php
                        }else{
                            ?>
                            <i class="fa fa-times delay-icon"></i>
                            <?php
                        }
                        ?>
                    </th>
                </tr>
                <tr>
                    <td><?php echo $result['receiver']['origin']['name']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $result['receiver']['origin']['street1'].' '.$result['receiver']['origin']['street2']; ?></td>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo $result['receiver']['origin']['zip'].' '.$result['receiver']['origin']['city'].' '.$result['receiver']['origin']['state'].' '.$result['receiver']['origin']['country'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Address type - <?php echo $receiver_address_type; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
    $m_s = !empty($result['sender']['validation_results']['messages']);
    $m_r = !empty($result['receiver']['validation_results']['messages']);
    if($m_s || $m_r){?>
    <tr>
        <td>
            <?php
            if($m_s){
                foreach($result['sender']['validation_results']['messages'] as $single){
                    ?>
                    <table class="addr_validate_error">
                        <tr>
                            <th>Message - <?php echo $single->code;?></th>
                        </tr>
                        <tr>
                            <td><?php echo $single->text;?></td>
                        </tr>
                    </table>
                    <?php
                }
            }
            ?>
        </td>
        <td>
            <?php
            if($m_r){
                foreach($result['receiver']['validation_results']['messages'] as $single){
                    ?>
                    <table class="addr_validate_error">
                        <tr>
                            <th>Message - <?php echo $single->code;?></th>
                        </tr>
                        <tr>
                            <td><?php echo $single->text;?></td>
                        </tr>
                    </table>
                    <?php
                }
            }
            ?>
        </td>
    </tr>
    <?php } ?>
</table>
    <div class="address-validation-button-div">
        <button type="button" class="btn btn-default btn-login-blue adm-btn hide_address_validation_modal">Cancel</button>
        <button type="button" class="btn btn-default btn-login-orange adm-btn create-label" id="create_label" title="Create Label">Create</button>
    </div>
</div>