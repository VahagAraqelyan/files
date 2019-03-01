<?php
$this->load->view('admin/head');
?>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post" autocomplete="off">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                    </div>
                    <span class="show_login_error">
                             <?php echo validation_errors("<span class='error_img'></span>","");?>
                        </span>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" id="exampleInputEmail1" value="<?php echo $username; ?>" autocomplete="off">
                            <i class="error_email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" id="exampleInputPassword1">
                            <i class="error_password"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Enter Code</label>
                            <input type="text" name="code" id="codeInput">
                            <i class="error_code"></i>
                        </div>
                        <div class="form-gp">
                            <div id="captcha-div" style="width:100px; height:40px;">
                                <?php echo $captcha['image']; ?>
                            </div>
                            <a id="change-captcha" >Change Code</a>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="#">Sign up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
$this->load->view('admin/footer');
?>