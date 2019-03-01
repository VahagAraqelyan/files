

                <div class="register-block forgot_pass">

                    <h2 class="register-title text-center">Forgot Password</h2>
                    <div id="forgot_loader_div"><img src="<?php echo base_url('assets/images/load.gif')?>" id="forgot_loader"></div>
                    <?php
                    $this->load->view('frontend/messages', ['action'=>'error_message_forgot']);
                    $this->load->view('frontend/messages', ['action'=>'success_message_forgot']);
                    ?>
                    <form method="post" class="form-horizontal" id="forgot_form">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label text-right">Email Address</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email_forgot" id="email_forgot" placeholder="Email Address" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-3 col-xs-12 control-label text-right">Enter Code</label>
                            <div class="col-sm-5 col-xs-8 cpatcha-code-place">
                                <input type="text" class="form-control" name="code_forgot" id="code_forgot" placeholder="Enter Code">
                            </div>
                            <div class="col-sm-4 col-xs-4 cpatcha-code-info">
                                <div class="captcha text-right" id="captcha-div-2">
                                    <?php echo $captcha['image']; ?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <p class="change-captcha-picture text-right"><a  id="change-captcha-2" style="cursor: pointer;">Change Code</a></p>
                            </div>
                        </div>
                    </form>
                    <div class="footer-part">
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                               <button type="submit" class="btn btn-default btn-login-orange" data-toggle="modal" data-target="#forgot-modal-message" id="forgot-send">Send</button>
                            </div>
                        </div>
                    </div>

                </div>







