<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
    traveler_list_row_count = '<?php echo $traveler_list_row_count; ?>';
    addres_book_list_row_count = '<?php echo $addres_book_list_row_count; ?>';
    Stripe.setPublishableKey('<?php echo $public_key;?>');
</script>

<div class="content">
    <div class="container">
        <div class="profile">
            <div class="mob-profile text-right">
                <span class="my-prof">My Profile</span>
                <a href="<?php echo base_url(); ?>" class="btn btn-default btn-login-orange">Check Price & Book Now</a>
            </div>

            <!-- Modal upload-->
            <div class="modal fade" id="upload_modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" id="upload_modal_div">
                            <div id="answer_upload">
                                <span id="show_upload_error_img"></span>
                                <span id="show_error_my_profile"></span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="modal fade" id="add_card_modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" id="upload_modal_div">
                            <div id="answer_card_error">

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- modal -->
            <div id="my_profile_modal" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content white-background" id="my_profile_modal_content">

                    </div>
                </div>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs responsive-tabs" role="tablist" id="my_accoutn_tabs">
                <li class="active"><a href="#account_information" data-toggle="tab">Account Information <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#traveler_list" data-toggle="tab" id="traveler_list_link">Traveler List <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <li><a href="#address_book" data-toggle="tab" id="address_book_link">Address Book <i class="fa fa-angle-down tab-down" aria-hidden="true"></i></a></li>
                <?php
                $status_icon = [
                    '0' => 'fa fa-times reject-icon',
                    '1' => 'fa fa-check verified-icon',
                    '2' => 'fa fa-exclamation information-icon',
                    '3' => 'fa fa-check delivered-icon'
                ];
                for($i = 1; $i<=$cards_count; $i++){
                 if(isset($cards[$i])){

                     $complete = '<i class="'.$status_icon[$cards[$i]].' credit_card_icon"></i>';

                 }else{
                     $complete = '';
                 }
                   ?>
                        <li><a href="#credit_card_<?php echo $i; ?>" data-toggle="tab" class="credit_card_link" data-block="<?php echo $i; ?>">Credit Card #<?php echo $i; ?> <i class="fa fa-angle-down tab-down" aria-hidden="true"></i><?php echo $complete; ?></a></li>
                        <?php
                }
                ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-profile">
                <div class="tab-pane account-info active my_profile_content" id="account_information">
                    <div class="block-1">

                        <div class="min-block">
                            <h2>My Number</h2>

                            <form method="post" class="form-horizontal" action=""  id="user_numbers">
                                <div class="form-group">
                                    <label for="cell_phone" class="col-sm-5 col-xs-6 control-label text-left">Cell Phone:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="cell_phone" id="cell_phone" placeholder="Cell Phone" value="<?php echo $info['phone']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fax_number" class="col-sm-5 col-xs-6 control-label text-left">Fax Number:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="fax_number" id="fax_number" placeholder="Fax Number"  value="<?php echo $info['fax']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="home_phone" class="col-sm-5 col-xs-6 control-label text-left">Home / Office  Phone:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="text" maxlength="22" class="form-control" name="home_phone" id="home_phone" placeholder="Home / Office  Phone" value="<?php echo $info['home_phone']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right button-place my_profile_margin_but">
                                        <span class="code-example text-left">Please enter country code Example: ( 1 ) 212 999 9999 </span>
                                        <button type="button" class="btn btn-default btn-login-orange my_profile_butt" id="user_numbers_butt" data-toggle = 'modal' data-target = '#upload_modal'>Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="min-block">
                            <h2>Login Information</h2>

                            <form method="post" class="form-horizontal" action="" id="update_password">
                                <div class="form-group">
                                    <label for="login_email" class="col-sm-5 col-xs-6 control-label text-left">Login Email:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <span class="code-example text-left user_email_change"><?php echo $info['email']; ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="login_email" class="col-sm-5 col-xs-6 control-label text-left"></label>
                                    <div class="col-sm-7 col-xs-6 mob-input">

                                        <a href="#" id="edit_login" >Change Email</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="current_password" class="col-sm-5 col-xs-6 control-label text-left">Current Password:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="col-sm-5 col-xs-6 control-label text-left">New Password:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-sm-5 col-xs-6 control-label text-left">Confirm Password:</label>
                                    <div class="col-sm-7 col-xs-6 mob-input">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 text-right button-place my_profile_margin_but">
                                        <button type="button" class="btn btn-default btn-login-orange my_profile_butt" id="update_password_butt" data-toggle = 'modal' data-target = '#upload_modal'>Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="border-right"></div>
                    </div>
                    <div class="block-1">
                        <h2>My Address</h2>

                        <form method="post" class="form-horizontal" action="" id="update_user_address">
                            <div class="form-group">
                                <label for="country" class="col-sm-5 col-xs-6 control-label text-left">Country<span class="important">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <select class="form-control selectpicker select-country traveler_country my_profile" name="country" id="my_profile_country">
                                        <option value="" selected="selected">Select Country</option>
                                        <?php
                                        foreach ($info['all_countries'] as $countries){
                                            $k=($countries['id'] == $info['country'])?'selected=\'selected\'':'';
                                            ?>
                                            <option value="<?php echo $countries["iso2"].'_'.$countries['id'];?>" <?php echo $k; ?>><?php echo $countries['country']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_name" class="col-sm-5 col-xs-6 control-label text-left">Company Name:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="25" class="form-control" name="company_name" id="company_name" placeholder="Company Name:" value="<?php echo $info['company_name']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address1" class="col-sm-5 col-xs-6 control-label text-left">Address 1<span class="important">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <textarea name="address1"  maxlength="40" id="address1" class="form-control acount_info_add1"><?php echo $info['add1']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address2" class="col-sm-5 col-xs-6 control-label text-left">Address 2:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" class="form-control" maxlength="40" name="address2" id="address2" placeholder="Address 2:" value="<?php echo $info['add2']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-sm-5 col-xs-6 control-label text-left">City<span class="important">*</span>:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" class="form-control" maxlength="25" name="city" id="city" placeholder="City:" value="<?php echo $info['city']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="region" class="col-sm-5 col-xs-6 control-label text-left">State / Region:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <select class="form-control selectpicker select-country my_profile" name="state" id="region_account_info">
                                        <option value="">Select State</option>
                                        <?php
                                        if(!empty($states)){
                                            foreach($states as $value){
                                                $k=($value['Stateid']==$info['state'])?'selected=\'selected\'':'';
                                                ?>
                                                <option value="<?php echo $value['Stateid']; ?>" <?php echo $k; ?> ><?php echo $value['State']?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="zip" class="col-sm-5 col-xs-6 control-label text-left">Zip code:</label>
                                <div class="col-sm-7 col-xs-6 mob-input">
                                    <input type="text" maxlength="25" class="form-control" name="zip" id="zip" placeholder="Zip code:" value="<?php echo $info['zip_code']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 text-right button-place big_margin_butt">
                                    <button type="button" class="btn btn-default btn-login-orange my_profile_butt" id="update_address_butt" data-toggle = 'modal' data-target = '#upload_modal'>Save</button>
                                </div>
                            </div>
                        </form>

                        <div class="border-right"></div>
                    </div>
                    <div class="block-2">

                        <div class="min-block">
                            <h2>Account Balance & Credits:</h2>

                            <p class="balance">Balance: <span>$0</span></p>
                            <p class="balance">Credit: <span>$<?php echo floatval($info['account_credit']); ?></span></p>
                        </div>
                        <div class="min-block">
                            <h2>My Document:</h2>

                            <form method="post" class="form-horizontal" action="" id="upload_file_form" enctype="multipart/form-data">
                                <div id="error_mess_div"><span></span></div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <select class="form-control selectpicker document_name my_profile" name="doc_file" id="doc_file_type">
                                            <option value="">Select Document Name</option>
                                            <?php
                                                foreach($document_select as $object){
                                                    ?>
                                                    <option value="<?php echo $object->id; ?>"><?php echo $object->title; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <label class="btn btn-default btn-file select-doc-file my_profile_document">
                                            Select Document <input type="file" id="upload_file" name="upload_file" class="form-control" style="display: none;">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group upload_progressbar" id="upload_progressbar">
                                    <div class='progressbar'>
                                        <div class='procent'>
                                            <span class='proc_span'></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="doc-file-place">
                                        <ul>
                                            <?php
                                            foreach($info['files'] as $file){
                                                ?>
                                                <li>
                                                    <div class="image_div">
                                                        <img class='delete_img' data-blok='<?php echo $file['id']; ?>'src='<?php echo base_url(); ?>assets/images/x_document.png'>
                                                        <img class="main_img" src='<?php echo base_url(); ?>assets/images/file_uploaded.png'>
                                                        <span><?php echo $file['doc_type_name']; ?></span>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12 text-left">
                                        <p class="for-secure-reason">For security purposes, you won`t be able to view document(s) uploaded here</p>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>


                <div class="tab-pane" id="traveler_list">
                    <div class="panel panel-default designed-panel">
                        <!-- ajax div -->
                        <div id="traveller_list_content">

                        </div>
                        <div class="panel-footer">
                            <a href="#" id="add_new_traveller" class="btn btn-default btn-login-orange" data-name="add_new_traveller_modal" data-toggle="modal" data-target="#my_profile_modal">ADD NEW</a>
                            <a href="#" id="edit_traveller"  class="btn btn-default select-doc-file bold_button"><i class="fa fa-pencil-square-o bold_button"></i>EDIT</a>
                            <a href="#" class="btn btn-default select-doc-file bold_button" id="delete_traveler"><i class="fa fa-trash bold_button"></i>DELETE</a>
                        </div>
                    </div>
                </div>


                <div class="tab-pane" id="address_book">
                    <div class="panel panel-default designed-panel">
                        <!-- ajax div -->
                        <div id="address_book_content">

                        </div>
                        <div class="panel-footer">
                            <a href="#" class="btn btn-default btn-login-orange" data-name="add_new_address" data-toggle="modal" data-target="#my_profile_modal" id="add_new_addr">ADD NEW</a>
                            <a href="#" class="btn btn-default select-doc-file bold_button" id="edit_address_book"><i class="fa fa-pencil-square-o bold_button"></i>EDIT</a>
                            <a href="#" class="btn btn-default select-doc-file bold_button" id="delete_address_book"><i class="fa fa-trash bold_button"></i>DELETE</a>
                        </div>
                    </div>
                </div>
                <!-- START CREDIT CARD -->
                <div class="tab-pane credit_card" id="credit_card_1">

                </div>
                <div class="tab-pane credit_card" id="credit_card_2">

                </div>
                <div class="tab-pane credit_card" id="credit_card_3">

                </div>
            </div>
        </div>
    </div>
</div>

