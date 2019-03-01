<?php

if(!empty($messages)){

    foreach ($messages as $index => $value){ ?>
        <ul>
            <li class="left clearfix">
                <span class="pull-left"></span>
                <div class="chat-body clearfix">
                    <div class="chat-title">
                        <strong class="primary-font"><?php echo date('M-d-Y', strtotime($value['add_date'])); ?> pm  By : <?php echo $value['admin_name'];?></strong>
                    </div>
                    <p>
                        <?php echo $value['message'];?>
                    </p>
                </div>
            </li>
        </ul>

    <?php  }
}
?>