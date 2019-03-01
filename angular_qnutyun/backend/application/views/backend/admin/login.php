<?php
$this->load->view('backend/head');
?>

<body>
<div id="admin_login_log">
    <img src="<?php echo base_url(); ?>/assets/images/logo.png">
</div>
<div class="content">
    <div class="container">
        <div class="register register-content row">
            <div class="col-md-6 col-md-offset-3">

                <div class="register-block">
                    <h2 class="register-title text-center">Login</h2>
                    <div class="login-error">
                        <span id="show_error_img"></span>
                        <span class="show_login_error">
                             <?php echo (!empty($message))?"<span class='error_img'></span>$message":""; ?>
                             <?php echo validation_errors("<span class='error_img'></span>","");?>
                        </span>
                    </div>
                    <form method="post" class="form-horizontal" id="admin_log_form">
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label text-right">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" id="username" placeholder="" value="<?php echo $username; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label text-right">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-3 control-label text-right">Enter Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="code" id="code" placeholder="">
                            </div>

                            <div class="col-sm-3">
                                <div id="captcha-div" style="width:100px; height:40px;">
                                    <?php echo $captcha['image']; ?>
                                </div>
                                <a style="cursor:pointer;" id="change-captcha" >Change Code</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9 text-right">
                                <button type="button" class="btn btn-default btn-login-blue" id="admin_login">Login</button>
                            </div>
                        </div>

                    </form>



                </div>

            </div>
        </div>
    </div>

</div>


</body>
<?php
$this->load->view('backend/footer');
?>
