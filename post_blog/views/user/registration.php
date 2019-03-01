<div class="content">
    <div class="container">
        <div class="register register-content row">
            <div class="col-md-8 col-md-offset-3">

                <div class="register-block">

                    <h2 class="register-title text-center">Registration</h2>
                    <div class="registration_error">

                        <span id="add_error_img"></span>
                        <span id="register_error"></span>

                    </div>
                    <form method="post" class="form-horizontal" id="registration_form" autocomplete="off">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label ">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" maxlength="25"  name="first_name" id="first_name" placeholder="First Name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" maxlength="25" name="last_name" pattern="\D [^0-9]" id="last_name" placeholder="Last Name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Email Address</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address"  value=""><span id='email_val'></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label ">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="retype_password" class="col-sm-3 control-label ">Retype Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Retype Password">
                            </div>
                        </div>
                        <div class="form-group button-form-place">
                            <div class="col-sm-offset-3 col-sm-9 ">
                                <button type="button" class="btn btn-default btn-login-blue"  id="signup">Sign Up</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

</div>