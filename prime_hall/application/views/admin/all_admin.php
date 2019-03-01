<div class="form-group my-form-group">
    <div class="col-2 value-info">
        <button type="button" class="btn  add_admin_btn butt_w">Ավելացնել</button>
    </div>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Անուն</th>
        <th>Էլ․ Հասցե</th>
        <th>վերջին Մուտք</th>
        <th>#</th>
    </tr>
    </thead>
<?php
foreach ($admins as $val){ ?>
    <tbody>
    <tr>
        <td><?php echo $val['name']; ?></td>
        <td><?php echo $val['email']; ?></td>
        <td><?php echo $val['last_login_date']; ?></td>
        <td>
            <span class="edit_admin pointer_class" data_id="<?php echo $val['id']; ?>"><i class="fa fa-pencil"></i></span>
            <span class="delete_admin pointer_class" data_id="<?php echo $val['id']; ?>"><i class="fa fa-trash-o"></i></span>
        </td>
    </tr>
    </tbody>

<?php } ?>
</table>

<div class="modal fade" id="add_admin_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="msg_error"></div>
            <div class="modal-body view_admin_answer">

            </div>
            <div class="modal-footer offer_butt_div">
                <button type="button" class="btn butt_w " id="add_new_admin">Պահպանել</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit_admin_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="msg_error"></div>
            <div class="modal-body edit_admin_answer">

            </div>
            <div class="modal-footer offer_butt_div">
                <button type="button" class="btn butt_w " id="save_edit_admin">Պահպանել</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>