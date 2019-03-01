
<div class="col-md-12 ">
    <div class="box">
        <div class="box-header with-border box box-info" style="border-top-color: #82c2e6;!important;">
            <h3 class="box-title origin_title col-md-8" style="margin: 7px 0px 0px 0px;">Լուսանկարներ </h3>
           <!-- <button type="button" style="background-color: #61add8!important;float: right;width: 100px;margin: 0px 11px 0px 0px;" class="btn bg-olive margin save_upload_files">Save</button>-->
            <div class="box-tools">
            </div>
        </div>
        <form action="" id="upload_image_form">
            <input type="hidden" name="db_id" id="db_id">
            <input type="hidden" name="slider_removed_images" id="slider_removed_images">
            <input type="hidden" name="main_removed_images" id="main_removed_images">
           <!-- <div class="box-body">
                <div class="col-md-12">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                    <input type="hidden" id="edit_item_id">
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="desc" id="page_desc" rows="3" placeholder="Description" style="resize: none; height: 100px"></textarea>
                    </div>
                </div>
            </div>-->
            <input type="hidden" id="image_type_id" value="<?php echo $id; ?>">
            <div class="container">
                <div class="">
                    <label>Ավելացնել Լուսանկարներ</label>
                    <div class="drop_upload" id="drop">
                        <div class="dz-message needsclick">
                            <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    gallery_images = '<?php echo json_encode($images); ?>';

</script>