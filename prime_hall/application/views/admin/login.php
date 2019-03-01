<?php
$this->load->view('admin/head');
?>
<div class="sufee-login d-flex align-content-center flex-wrap bg-dark admin_login">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <img class="align-content" src="<?php echo  base_url()?>images/logo.png" alt="">
            </div>
            <div class="login-form">
                <form  method="post"class="form-horizontal" id="admin_log_form"  autocomplete="off" >
                    <div class="login-error">
                        <span id="show_error_img"></span>
                        <span class="show_login_error">

                             <?php echo (!empty($message))?"<span class='error_img'></span>$message":""; ?>
                             <?php echo validation_errors("<span class='error_img'></span>","");?>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $username; ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Enter Code</label>
                            <input type="text" class="form-control" placeholder="Code" name="code">
                        </div>
                        <div class="col-sm-6" style="padding: 5% 0 0;">
                            <div id="captcha-div" style="width:100px; height:40px;">
                                <?php echo $captcha['image']; ?>
                            </div>
                            <a style="cursor:pointer;" id="change-captcha" >Change Code</a>
                        </div>
                    </div>
                   <!-- <div class="form-group">
                        <label>Enter Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="code" id="code" placeholder="">
                        </div>

                        <div class="col-sm-6">
                            <div id="captcha-div" style="width:100px; height:40px;">
                                <?php /*echo $captcha['image']; */?>
                            </div>
                            <a style="cursor:pointer;" id="change-captcha" >Change Code</a>
                        </div>
                    </div>-->
                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('admin/footer');
?>