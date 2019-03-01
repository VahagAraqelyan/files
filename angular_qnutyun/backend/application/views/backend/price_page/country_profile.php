<div class="panel panel-default designed-panel no-margin">
    <div class="panel-heading">
        <div class="row">
            <h2 class="text-center min-title-height">Custom Value: <input type="text" name="custom_value" id="custom_value" value="<?php echo $custom_value; ?>" class="form-control small-input display-inline"></h2>
        </div>
    </div>
    <div class="panel-body no-padding">

        <form method="post" class="form-horizontal search-data-form" action="">
            <h4 class="panel-title">Country Profile - <?php echo $country; ?></h4>
            <table class="table table-bordered designed-table">
                <thead>
                <tr>
                    <th class=""><small>Carrier</small></th>
                    <th class=""><small>Domestic<br> Services</small></th>
                    <th class="" colspan="2"><small>International<br /> Out &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In</small></th>
                    <th class=""><small>Hotline</small></th>
                    <th class=""><small>Website</small></th>
                    <th class=""><small>User Name</small></th>
                    <th class=""><small>Password</small></th>
                    <th class=""><small>Partner web</small></th>
                    <th class=""><small>User Name</small></th>
                    <th class=""><small>Password</small></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($curriers as $single){
                    ?>
                    <tr>
                        <td><input type="hidden" name="ids[]" value="<?php echo $single['id']; ?>"><?php echo $single['currier_name']; ?></td>
                        <td><input type="checkbox" name="<?php echo $single['id'].'_domestic'; ?>" value="1" <?php echo ($single['domestic'])?'checked="checked"':''; ?>></td>
                        <td><input type="checkbox" name="<?php echo $single['id'].'_int_out'; ?>" value="1" <?php echo ($single['intern_out'])?'checked="checked"':''; ?>></td>
                        <td><input type="checkbox" name="<?php echo $single['id'].'_int_in'; ?>" value="1" <?php echo ($single['intern_in'])?'checked="checked"':''; ?>></td>
                        <td><input type="text" name="<?php echo $single['id'].'_hotline'; ?>" class="form-control" value="<?php echo $single['hotline']; ?>" ></td>
                        <td><input type="text" name="<?php echo $single['id'].'_website'; ?>" class="form-control big-input" value="<?php echo $single['website']; ?>"></td>
                        <td><input type="text" name="<?php echo $single['id'].'_user_name'; ?>" class="form-control" value="<?php echo $single['user_name']; ?>"></td>
                        <td><input type="password" name="<?php echo $single['id'].'_password'; ?>" class="form-control" value="<?php echo $single['password']; ?>"></td>
                        <td><input type="text" name="<?php echo $single['id'].'_partn_web'; ?>" class="form-control big-input" value="<?php echo $single['partner_web']; ?>"></td>
                        <td><input type="text" name="<?php echo $single['id'].'_user_name_p'; ?>" class="form-control" value="<?php echo $single['user_name_p']; ?>"></td>
                        <td><input type="password" name="<?php echo $single['id'].'_password_p'; ?>" class="form-control" value="<?php echo $single['password_p']; ?>"></td>
                    </tr>
                    <?php
                }?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-10 text-right">

                </div>
                <div class="col-md-2 text-right">
                    <button type="button" class="btn btn-default btn-login-orange adm-btn save_country_profile">Save</button>
                </div>
            </div>
        </form>
        <p class="border-bottom"></p>


    </div>
</div>