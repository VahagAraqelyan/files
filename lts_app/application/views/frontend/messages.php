<?php
//email is equal check template

if($action=='email_ajax_success_check'){
    ?>
    <img src="<?php echo base_url('assets/images/ok.ico'); ?>" data-block="ok"/>
    <?php
}
if($action=='email_ajax_fail_check'){
    ?>
    <img src="<?php echo base_url('assets/images/cancel.ico'); ?>" data-block="cancel"/>
    <?php
}


//errors messages template

if($action=='error_message_forgot'){
    ?>
    <div id="error_message">
         <p><span class="error_img"></span><span></span></p>
    </div>
    <?php
}

//success messages template

if($action=='success_message_forgot'){
    ?>
    <div id="success_message">
        <p><span></span></p>
    </div>
    <?php
}
