<div class="admin_reservetion_main">

    <div id="search_div">
        <div class="form-group my-form-group">
            <div class="col-2 value-info">
                <button type="button" class="btn  add_offer_btn butt_w">Ավելացնել</button>
            </div>
        </div>
        <div class="form-group my-form-group">
            <div class="col-3 control-label value-index">
                <select class="form-control" name="status" id="offer_search_crt">
                    <option value="start_date">Փնտրել ըստ </option>
                    <option value="offer">Առաջարկ</option>
                    <option value="title">Վերնագիր</option>
                </select>
            </div>
            <div class="col-3 value-info">
                <input type="text" name="search_val" class="form-control" autocomplete="off" id="offer_search_val">
            </div>
            <div class="col-2 value-info">
                <button type="button" class="btn btn-primary search_offer_butt">Փնտրել</button>
            </div>
            <div class="col-3 value-info">
                <a href="" class="btn btn-default view-all-btn btn-login-blue" id="reset_butt">Չեղարկել արդյունքները</a>
            </div>
        </div>
    </div>

    <table id="admin_offer_table" class=" table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Առաջարկ (Հայերեն)</small></th>
            <th class="order-number"><small>Առաջարկ (Ռուսերեն)</small></th>
            <th class="order-number"><small>Առաջարկ (Անգլերեն)</small></th>
            <th class="order-number"><small>Վերնագիր(Հայերեն)</small></th>
            <th class="order-number"><small>Վերնագիր(Ռուսերեն)</small></th>
            <th class="order-number"><small>Վերնագիր(Անգլերեն)</small></th>
            <th class="order-number"><small>Կարգավիճակ</small></th>
            <th class="order-number"><small>Նկար</small></th>
            <th class="order-number"><small>հղում</small></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
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

<div class="modal fade" id="add_offer_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="msg_error"></div>
            <div class="modal-body">
                <div class="reservetion-error">

                </div>

                <form id="add_offer_form">
                    <div class="form-group">
                        <label>Վերնագիր (Հայերեն)</label>
                        <input type="text" class="form-control" name="title_am" id="title_am">
                    </div>
                    <div class="form-group">
                        <label>Վերնագիր (Ռուսերեն)</label>
                        <input type="text" class="form-control" name="title_ru" id="title_ru">
                    </div>
                    <div class="form-group">
                        <label>Վերնագիր (Անգլերեն)</label>
                        <input type="text" class="form-control" name="title_en" id="title_en">
                    </div>

                    <div class="form-group">
                        <label>Նկար</label>
                        <label class="btn btn-default btn-file select-doc-file">
                            Ընտրել նկար
                             <input type="file" name="image" id="offer_image" style="display: none;">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Առաջարկ (Հայերեն)</label>
                        <textarea class="textarea" name="" id="add_paragraph_desc_am"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Առաջարկ (Ռուսերեն)</label>
                        <textarea class="textarea " name="" id="add_paragraph_desc_ru"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Առաջարկ (Անգլերեն)</label>
                        <textarea class="textarea" name="" id="add_paragraph_desc_en"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer offer_butt_div">
                <button type="button" class="btn butt_w add_new_offer" id="add_new_offer">Պահպանել</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit_offer_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="msg_error"></div>
            <div class="modal-body edit_offer_answer">

            </div>
            <div class="modal-footer offer_butt_div">
                <button type="button" class="btn butt_w " id="edit_new_offer">Պահպանել</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="view_offer_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="msg_error"></div>
            <div class="modal-body view_offer_answer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>