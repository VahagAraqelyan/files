<section class="content add_new_menu">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border box box-info" style="border-top-color: #82c2e6;!important;">
                        <h3 class="box-title col-md-6" style="margin: 17px 0 0 0px;">Մենյու</h3>

                        <button type="button" class="btn bg-olive margin add_menu_type">Ավելացնել Տեսակ</button>

                        <div class="box-tools">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="droc_opshon">
                            <div class="box-header drag_drop">

                                <div class="dd" id="nestable-json"></div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 add_or_edit_main dis_none">
                <div class="box">
                    <div class="box-header with-border box box-info" style="border-top-color: #82c2e6;!important;">
                        <h3 class="box-title col-md-12" style="margin: 7px 0 0 0;">Ավելացնել (Փոփոխել) Մենյուն</h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <div class="box-body input_btn_droc">
                        <div class="row">
                            <form action="" id="add_edit_menu" method="post" autocomplete="off">
                                <input type="hidden" name="menu_id"  id="menu_id" value="">
                                <input type="hidden" name="child_id" id="child_id"  value="">
                                <input type="hidden" id="type_id" name="type_id" value="<?php echo $type_id; ?>">
                                <div class="col-md-12" id="link_block">
                                    <label>Անուն (Հայերեն)</label>
                                    <input type="text" class="form-control" id="name_am" placeholder="" name="name_am" value="">
                                </div>
                                <div class="col-md-12" id="link_block">
                                    <label>Անուն (Ռուսերեն)</label>
                                    <input type="text" class="form-control" id="name_ru" placeholder="" name="name_ru" value="">
                                </div>
                                <div class="col-md-12" id="link_block">
                                    <label>Անուն (Անգլերեն)</label>
                                    <input type="text" class="form-control" id="name_en" placeholder="" name="name_en" value="">
                                </div>
                                <div class="col-md-12" id="price_div">
                                    <label>Գին</label>
                                    <input type="text" class="form-control" name="price" id="price" placeholder="">
                                </div>
                                <div class="box-body btn_drop_add_sub_onoff">
                                    <div class="box-body">
                                        <button type="button" id="add_or_edit" class="btn btn-primary">Ավելացնել</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    json_data = '<?php echo $menus; ?>';
</script>