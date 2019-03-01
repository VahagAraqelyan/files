<section class="login">

    <div class="row full-login no-gutters">

        <div class="col-md-7 login-part">

            <div class="logo-brand">
                <!--<img src="img/logo.png" alt="">-->
            </div>

            <div class="main-login-content text-center">
                <h3>Log In</h3>

                <p> Enter username and password to log in: </p>
                
                <div class="show_error"></div>

                <form method="post" id="crew_login_form" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Username" aria-label="username"
                               aria-describedby="basic-addon2" name="email">
                        <div class="input-group-append uppend-icon">
                            <span class="input-group-text" id="basic-addon3">
                                <img src="<?php echo base_url()?>assets/images/login/user-1.png" alt=""></span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password"
                               aria-describedby="basic-addon2" name="password">
                        <div class="input-group-append uppend-icon">
                            <span class="input-group-text" id="basic-addon2"><img src="<?php echo base_url()?>assets/images/login/key.png" alt=""></span>
                        </div>
                    </div>

                    <label class="container text-left"> Remember me<input type="checkbox" name="remember" value="1"><span
                            class="checkmark"></span></label>
                    <button class="btn btn-primary d-block btn-login" id="crew_login_butt" type="button">Login</button>

                    <a href="#" class="float-right forgot">Forgot your password?</a>
                    <p class="clearfix"></p>
                </form>
            </div>
        </div>

        <div class="col-md-5 login-second-part">
            <img src="<?php echo base_url()?>assets/images/crew_login.jpg" alt="">
        </div>

    </div>

</section>
