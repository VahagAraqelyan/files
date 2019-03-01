<?php
if(!empty($files)){
    ?>
    <ul>
        <?php
        foreach($files as $file){
            ?>
            <li>
                <div class="image_div">
                    <img class='admin_delete_img currier_file_rem' data-blok='<?php echo $file['id']; ?>'src='<?php echo base_url(); ?>assets/images/x_document.png'>
                    <a href="<?php echo base_url('admin/price_page/currier_file/'.$iso.'/'.$file['doc_file_name']); ?>" target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                    <p><?php echo $file['doc_file_name']; ?></p>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>