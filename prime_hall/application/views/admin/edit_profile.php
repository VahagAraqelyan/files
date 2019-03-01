<div class="col-md-6">

    <form method="post" id="edit_info_form" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $admin['id'];?>">
        <div class="form-group">
            <label>Անուն</label>
            <input type="text" class="form-control" name="name" value="<?php echo $admin['name'];?>">
        </div>
        <div class="form-group">
            <label>Էլ․ Հասցե</label>
            <input type="email" class="form-control" name="email" value="<?php echo $admin['email'];?>">
        </div>
        <div class="form-group">
            <label>Գաղտնաբառ</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label>Կրկնել Գաղտնաբառը</label>
            <input type="password" class="form-control" name="confirm_password">
        </div>
        <div class="modal-footer offer_butt_div">
            <button type="button" class="btn butt_w " id="save_edit_profile">Պահպանել</button>
        </div>
    </form>
</div>

<div class="modal fade" id="upload_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="register-block no-hide up_modal">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body " id="upload_modal_div">

                <div id="answer_upload">
                    <span id="show_upload_error_img"></span>
                    <span id="show_error_my_profile"></span>
                </div>
            </div>

        </div>

    </div>
</div>