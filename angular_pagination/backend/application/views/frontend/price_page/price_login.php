
<div class="register-block">
    <h2 class="register-title text-center">Login</h2>
    <div class="login-error">
        <span id="show_error_img"></span>
        <span id="show_login_error">

                        </span>
    </div>
    <form method="post" class="form-horizontal" id="login_form">
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label text-right">Email Address</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label text-right">Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="code" class="col-sm-3 col-xs-12 control-label text-right">Enter Code</label>
            <div class="col-sm-5 col-xs-8 cpatcha-code-place">
                <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
            </div>
            <div class="col-sm-4 col-xs-4 cpatcha-code-info">
                <div class="captcha text-right" id="captcha-div">
                    <?php echo $captcha['image']; ?>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <p class="change-captcha-picture text-right"><a  id="change-captcha" style="cursor: pointer;">Change Code</a></p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 text-right">
                <a href="" class="forgot-password" data-toggle="modal" data-target="#forgot-modal" id="forgot-link">Forgot Password?</a> <button type="button" class="btn btn-default btn-login-blue" id="login" >Login</button>
            </div>
        </div>

    </form>

    <div class="footer-part">
        <div class="form-group">
            <div class="col-sm-12 text-right">
                New User <a href="<?php echo base_url();?>registration"><button type="submit" class="btn btn-default btn-login-orange">Sign Up</button></a>
            </div>
        </div>
    </div>

</div>
