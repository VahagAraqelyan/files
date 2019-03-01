<div id="reports">
    <?php
    if(empty($files)){
        ?>
        <h1>No report files</h1>
        <?php
        exit();
    }

    foreach($files as $single){
        ?>
        <div class="single_reporte_file">
            <a href="<?php echo base_url('admin/user_manage/load_report_pile/'.$single['name']); ?>" title="Download <?php echo $single['name']; ?>">
                <img src="<?php echo base_url('assets/images/csv.png'); ?>"><br>
                <span><?php echo $single['date']; ?></span>
            </a>
            <br>
            <a class="error_class reporte_delete_url" data-file-name="<?php echo $single['name']; ?>">Delete file</a>
        </div>
        <?php
    }
    ?>
</div>

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