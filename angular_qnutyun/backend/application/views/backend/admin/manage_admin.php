<div class="container">
    <div class="customer-list-hole-part">
        <div id="adtop_msg_pcdiv"></div>
        <h3>Manage Admins</h3>
        <div class="customer-list-body-part">
            <div class="inner_main">
                <div class="tblbox">
                    <div class="add_admin_block">
                        <button class="add-new-but btn btn-default btn-login-orange button-size-class add_admin_butt" type="button">Add New</button>
                    </div>
                    <table class="table table-bordered table-hover designed-table">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Admin Name</th>
                            <th>Admin ID</th>
                            <th>Status</th>
                            <th>Add date </th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($admins as $single_admin){ ?>
                            <tr>
                                <td><?php echo $single_admin['admin_id']; ?></td>
                                <td><?php echo $single_admin['admin_name']; ?></td>
                                <td><?php echo $single_admin['user_id']; ?></td>
                                <td><?php echo $single_admin['status']; ?></td>
                                <td><?php show_date($single_admin['add_date']); ?></td>
                                <td>
                                    <span class="admin_icon_span position">
                                        <?php
                                        $billing_class = (!empty($order))?'fa fa-check delivered-icon':'fa fa-exclamation created-icon';
                                        ?>
                                        <i class="<?php echo $billing_class; ?>"></i>
                                    </span>
                                    <span class="admin_img_span pointer_class delete_admin" data_id="<?php echo $single_admin['admin_id']; ?>"><img src="<?php echo base_url()?>assets/images/close.png" alt=""></span>
                                    <span class="edit_admin pointer_class" data_id="<?php echo $single_admin['admin_id']; ?>"><i class="fa fa-pencil"></i></span>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_edit_admin_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="add_edit_admin_answer">

            </div>
        </div>
    </div>
</div>

</div>