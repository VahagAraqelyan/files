<ul>
    <?php
    foreach($files as $file){
        ?>
        <li>
            <div class="image_div">
                <img class='delete_img upload_img' data-blok='<?php echo $file['id']; ?>'src='<?php echo base_url(); ?>assets/images/x_document.png'>
                <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'>
            </div>
            <p><?php echo $file['doc_type_name']; ?></p>
        </li>
        <?php
    }
    ?>
</ul>