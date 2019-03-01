<?php  if($action == 'service_type') {?>
        <select class="form-control document_name document_type " name="service_type" id="document_type">
            <option value="" selected="selected">Select Type</option>
            <?php
            foreach($types as $name => $single_type){
                ?>
                <option value="<?php echo $single_type; ?>"><?php echo $name; ?></option>
                <?php
            }
            ?>
        </select>
<?php }
?>
