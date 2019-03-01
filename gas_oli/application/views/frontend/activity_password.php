<div class="activity_password_content">
    <div class="show_error">

    </div>
    <form autocomplete="off" method="post" id="activity_password_form">
        <input type="hidden" name="dripver_id" value="<?php echo $driver_id;?>">
        <div class="form-group">
            <label for="exampleInputPassword1">password</label>
            <input type="password" class="form-control activity_pass" name="password" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Retype password</label>
            <input type="password" class="form-control activity_pass" name="rectype_password" autocomplete="off">
        </div>
        <button type="button" class="btn btn-primary" id="update_password">Save</button>
    </form>
</div>
