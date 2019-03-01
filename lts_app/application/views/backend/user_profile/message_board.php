<ul>
    <?php
    if(!empty($messages)) {
        foreach ($messages as $msg) {
            ?>
            <li class="left clearfix">
                <span class="pull-left"></span>
                <div class="chat-body clearfix">
                    <div class="chat-title">
                        <strong class="primary-font"><?php echo $msg['add_date']; ?> By
                            : <?php echo $msg['admin_name']; ?></strong>
                    </div>
                    <p>
                        <?php echo $msg['message_txt']; ?>
                    </p>
                </div>
            </li>
            <?php
        }
    }
    ?>
</ul>