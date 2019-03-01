<section class="content-header">
    <h1>
        Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Menu</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12" id="menu_titles">
            <div class="box">
                <div class="box-header with-border box box-info" style="border-top-color: #82c2e6;!important;">
                    <h3 class="all_tags col-md-4">All Tags</h3>
                    <!--<button type="button" style="background-color: #61add8!important;float: right" class="btn bg-olive margin add_new_menu_btn" data-toggle="modal" data-target="#modal-default" id="add_new_menu_btn">Add New</button>-->
                    <div class="box-tools">
                    </div>

                </div>
                <?php
                if(!empty($menu)){
                    foreach ($menu as $val){ ?>
                        <div class="box-body">
                            <ul class="todo-list menu_group_item">
                                <li>
                                    <a href="<?php echo base_url("menu/create_menu/{$val['id']}"); ?>"><i class="fa fa-align-left btn btn-info btn-flat"></i></a>
                                    <div class="box-body">
                                        <span class="text col-md-6"><?php echo $val['type_name'];?></span>
                                        <span class="text col-md-4">Group items count - <?php echo $val['item_count'];?></span>
                                        <div class="tools">
                                            <i data-id="<?PHP echo $val['id']?>" class="fa fa-edit edit_menu_group_name"></i>
                                            <i data-id="<?PHP echo $val['id']?>" class="fa fa-trash-o delete_menu_group_name"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php } } ?>
            </div>
        </div>
        <!--modal-->
        <div class="modal fade" id="menu_group_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <div class="modal-content" id="add_edit_menu_modal">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</section>