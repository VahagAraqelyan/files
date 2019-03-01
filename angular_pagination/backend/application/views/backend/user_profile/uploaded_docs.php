<?php
if(!empty($files)){
?>
<ul>
    <?php
    foreach($files as $file){
        ?>
        <li>
           <div class="image_div">
                 <img class='delete_img admin_delete_img' data-blok='<?php echo $file['id']; ?>'src='<?php echo base_url(); ?>assets/images/x_document.png'>
                 <a href="<?php echo base_url('admin/admin/user_file/'.$file['user_id'].'/'.$file['doc_file']); ?>" target="_blank"> <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'></a>
                 <p><?php echo $file['doc_type_name']; ?></p>
           </div>
        </li>
        <?php
    }
    ?>
</ul>
<?php
}
?>