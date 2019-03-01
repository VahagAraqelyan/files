@extends('admin/layouts.adminDashboard')

@section('content')

    <div class="content well_content">
        <div class="buttons">
            <div class="my-form-group">
                <button type="button" class="edit_subject btn btn-primary ">Edit</button>
                <button type="button" class="delete_subject btn btn-primary ">Delete</button>
            </div>
        </div>
        <table id="driver_list" class=" table table-bordered table-hover designed-table">
            <thead>
            <tr>
                <th class="order-number"><small>Edit/Delete</small></th>
                <th class="order-number"><small>Name</small></th>
                <th class=""><small>#</small></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!empty($subjects)){

                foreach ($subjects as $index => $single){ ?>
                    <tr>
                        <td><input type="checkbox" class="edit_delete_subject" value="<?php echo $single['id']; ?>"></td>
                        <td><?php echo $single['name']; ?></td>
                        <td><?php echo $index+1; ?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="edit_subjects_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="message"></div>
                <div class="modal-body edit_subjects_answer">
                </div>
            </div>
        </div>
    </div>
@endsection
