<div class="content">
    <div class="container">
        <div class="register register-content row">
            <div class="col-md-8 col-md-offset-3">
                <div class="register-block">
                    <h2 class="register-title text-center">Add Post</h2>
                    <div class="post_error">
                    </div>
                    <form method="post" class="form-horizontal" id="add_post_form" autocomplete="off">

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label ">Post Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="post_name"  placeholder=""  value=""><span id='email_val'></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label ">Description</label>
                            <div class="col-sm-9">
                                <textarea name="desc" id="" cols="43" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group button-form-place">
                            <div class="col-sm-offset-3 col-sm-9 ">
                                <button type="button" class="btn btn-default btn-login-blue"  id="add_post">Add Post</button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

</div>