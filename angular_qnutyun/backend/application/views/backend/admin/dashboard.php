<div class="content dashboard">
    <div class="container">

        <div class="panel panel-default designed-panel" id="admin_new_order">

        </div>

        <div class="panel panel-default designed-panel">
            <div class="container" id="admin_processing_order">
            </div>
        </div>


        <div class="panel panel-default designed-panel" id="admin_ready_order">

        </div>

    </div>
</div>

<div class="modal fade" id="trucking_modal" role="dialog">
    <div class="modal-dialog drop_off_locator">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="trucking_modal_content">

            </div>
        </div>

    </div>
</div>

<script>
    new_order_count = '<?php echo $new_order_count; ?>';
    processing_order = '<?php echo $processing_order; ?>';
    ready_order = '<?php echo $ready_order; ?>';
</script>