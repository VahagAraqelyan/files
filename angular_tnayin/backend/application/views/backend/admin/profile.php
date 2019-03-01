<div class="container">
    <div class="customer-list-hole-part">
        <h3>My Profile</h3>
        <div class="login-error" id="edit_profile_error">
            <?php
            $message = '';
            $class = 'show_login_error';
            $img_class = '';
            if(!empty($success)) {
                $message = $success[0];
                $class = 'show_login_error success_class';
            }
            if(!empty($error)) {
                $message = $error[0];
                $class = 'show_login_error';
                $img_class = ' error_img';
            }
            ?>
            <span id="show_error_img<?php echo $img_class; ?>"></span>
            <span class="<?php echo $class; ?>"><?php echo $message; ?></span>
        </div>
        <div class="due-main main-mt">

            <form method="post" action="" id="edit_profile_form">

                <ul class="admin_profileform">
                    <li><div class="pt"><div class="pt1">Admin Name :<span class=" error_class">*</span></div></div>
                        <div class="pt2">
                            <input class="" id="admin_name" name="admin_name" type="text" maxlength="25" value="<?php echo $admin_name; ?>" placeholder="Admin Name" autocomplete="off"></div>
                        <div class="clear"></div>
                    </li>

                    <li> <div class="pt"><div class="pt1">Email ID :<span class=" error_class">*</span></div></div>
                        <div class="pt2"><input class="" id="email_id" name="email_id" maxlength="50" type="text" value="<?php echo $email_id; ?>" placeholder="Email ID" autocomplete="off"></div>
                        <div class="clear"></div>

                    </li>



                    <li><div class="pt"><div class="pt1">Login ID :<span class=" error_class">*</span></div></div>
                        <div class="pt2"> <input class="" type="text" id="login"  maxlength="30" readonly="" value="<?php echo $login_id; ?>" disabled placeholder="Login ID" autocomplete="off"></div>
                        <div class="clear"></div>

                    </li>
                    <li><div class="pt"><div class="pt1"> Password :</div></div>
                        <div class="pt2"><div class="yr">
                                <input class="" type="password" id="password" name="password" placeholder="Password" maxlength="16" autocomplete="off"></div></div>
                        <div class="clear"></div>

                    </li>
                    <li><div class="pt"><div class="pt1">  Confirm Password :</div></div>
                        <div class="pt2"><div class="yr">
                                <input class="" type="password" id="confirm_password" name="confirm_password" maxlength="16" placeholder="Confirm Password" autocomplete="off"></div></div>
                        <div class="clear"></div>
                    </li>                  <li> <span class="txt-style"><em>Please fill password and confirm password to change your old password.</em></span></li>

                    <div class="add_profilebtn"> <br><span><button type="button" class="header-btns btn btnpos" id="edit_profile">Edit</button></span></div>

                </ul>
            </form>
            <div class="clear"></div>
        </div>
    </div>
</div>