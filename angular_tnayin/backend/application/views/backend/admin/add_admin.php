<?php
$disabled = '';
if(!empty($admin['admin_id'])){
    $disabled = 'disabled';
}
?>
<div class="register-block no-hide delivery_mobile_adding">
        <h2 class="register-title text-center lovercase"><?php echo (!empty($admin['admin_id']))?'Edit Admin Profile':'Add New Admin'; ?></h2>
        <div class="panel-body">
            <div class="registration-error">
                <span id="add_error_img"></span>
                <span id="register_error"></span>
            </div>
            <form method="post" id = "add_admin_form">
                <input type="hidden" name="admin_id" value="<?php echo (!empty($admin['admin_id']))?$admin['admin_id']:''; ?>">
                <div class="form-horizontal text-left my_profile_content add_admin_form_div">
                    <div class="form-group">
                        <div class="col-xs-5 control-label value-index">Admin Name:<span class="important">*</span>
                        </div>
                        <div class="col-xs-6 value-info">
                            <input name="admin_name" maxlength="50" type="text" value="<?php echo (!empty($admin['admin_name']))?$admin['admin_name']:''; ?>" placeholder="Admin name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-5 control-label value-index">Email ID:<span class="important">*</span>
                        </div>
                        <div class="col-xs-6  value-info">
                            <input  type="text" name="email"  maxlength="30" value="<?php echo (!empty($admin['email']))?$admin['email']:''; ?>"  placeholder="Email ID" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-5 control-label value-index">Login ID:<span class="important">*</span>
                        </div>
                        <div class="col-xs-6 value-info">
                            <input class="promotion" type="text" placeholder="Login ID" name="login_id" autocomplete="off" value="<?php echo (!empty($admin['user_id']))?$admin['user_id']:''; ?>" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-5 control-label value-index">Password:<span class="important">*</span>
                        </div>
                        <div class="col-xs-7 value-info">
                            <input class="promotion" type="password"  name="pass" autocomplete="false" value="" placeholder="Password" id="inputPassword"><span class="header-btns btn btnpos" id="generate_password">Generate</span>
                            <div id="complexity" class="default">Enter password</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-5 control-label value-index">Confirm Password:<span class="important">*</span>
                        </div>
                        <div class="col-xs-6 value-info">
                            <input class="promotion" type="password"  name="conf_pass" autocomplete="off" value="" placeholder="Confirm Password" id="conf_password">
                        </div>
                    </div>
                    <div id="perm_table_div">
                        <h5>Permissions:</h5>
                        <ul>
                            <?php
                            foreach($all_perm as $single_perm){
                                $k = '';
                                if(!empty($admin_perm) && in_array($single_perm[0], $admin_perm)){
                                    $k = 'checked="checked"';
                                }
                                ?>
                                <li>
                                    <input type="checkbox" value="<?php echo $single_perm[0]; ?>" <?php echo $k; ?> name="admin_perm[]">
                                    <span class="perm_span"><?php echo $single_perm[1]; ?></span>
                                </li>
                                <?php
                            }
                            ?>
                            <br class="clear">
                        </ul>
                    </div>
                    <div class="form-group">
                            <div class="col-xs-11">
                                <?php if(!empty($admin)){
                                    ?>
                                    <button type="button" class="add-new-but btn btn-default btn-login-orange" id="add_admin_butt">Edit</button>
                                    <?php
                                }else{
                                    ?>
                                        <button type="button" class="add-new-but btn btn-default btn-login-orange" id="add_admin_butt">Add</button>
                                    <?php
                                }?>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>