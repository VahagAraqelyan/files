<div class="admin_main_content">
    <form action="" id="save_edit_company_form" method="post">
     <?php
        if(!empty($company)){

            foreach ($company as $index => $single){ ?>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for=""><?php echo $single['name']?></label>
                        <input type="text" name="company_name[<?php echo $single['id']; ?>]" value="<?php echo $single['name']; ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="my-form-group">
                <div class="col-md-12 value-info">
                    <button type="button" class="save_edit_company btn btn-primary ">Edit Company</button>
                </div>
            </div>
        <?php } ?>
    </form>

</div>