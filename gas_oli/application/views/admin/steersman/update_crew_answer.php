<div class="admin_main_content">
    <form action="" id="save_edit_crew_form" method="post">
        <?php
        if(!empty($crew)){

               foreach ($crew as $index => $single){ ?>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for=""><?php echo $single['first_name']?></label>
                        <input type="text" name="crew_name[<?php echo $single['id']; ?>]" value="<?php echo $single['first_name']; ?>">
                    </div>
                </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for=""><?php echo $single['last_name']?></label>
                        <input type="text" name="crew_lname[<?php echo $single['id']; ?>]" value="<?php echo $single['last_name']; ?>">
                    </div>
                </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for=""><?php echo $single['tel']?></label>
                        <input type="text" name="crew_tel[<?php echo $single['id']; ?>]" value="<?php echo $single['tel']; ?>">
                    </div>
                </div>
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for=""><?php echo $single['email']?></label>
                        <input type="text" name="crew_email[<?php echo $single['id']; ?>]" value="<?php echo $single['email']; ?>">
                    </div>
                </div>

            <?php } ?>
            <div class="my-form-group">
                <div class="col-md-12 value-info">
                    <button type="button" class="save_edit_crew btn btn-primary ">Edit Crew</button>
                </div>
            </div>
        <?php } ?>
    </form>

</div>