<div class="admin_reservetion_main">

<div id="search_div">
    <div class="form-group my-form-group">
        <div class="col-3 control-label value-index">
            <select class="form-control" name="status" id="search_crt">
                <option value="">Ըստ Ինչի</option>
                <option value="first_name">Անուն Ազգանուն</option>
                <option value="email">Էլ․ Հասցե</option>
                <option value="date">Ամսաթիվ</option>
                <option value="number_part">Մասնակիցների քանակը</option>
                <option value="status">Կարգավիճակ</option>
                <option value="tel">Հեռ․</option>
            </select>
        </div>
        <div class="col-3 value-info">
            <input type="text" name="search_val" class="form-control" autocomplete="off" id="search_val">
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary search_reservetion_butt">Փնտրել</button>
        </div>
        <div class="col-3 value-info">
            <a href="" class="btn btn-default view-all-btn btn-login-blue" id="reset_butt">Չեղարկել արդյունքները</a>
        </div>
    </div>
</div>

    <table id="admin_reservetion" class=" table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Անուն</small></th>
            <th class="order-number"><small>Ազգանուն</small></th>
            <th class="order-number"><small>Հեռ․</small></th>
            <th class="order-number"><small>Էլ․ հասցե․</small></th>
            <th class="order-number"><small>Ամսաթիվ․</small></th>
            <th class="order-number"><small>Մասնակիցների քանակը</small></th>
            <th class="order-number"><small>Կարգավիճակ․</small>
                <span class="popover-style" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="
                    Կարգավիճակ սյունը ցույց է տալիս արդյոք կան այդ օրը այլ  ամրագրումներ։" data-original-title="" title=""></span>
            </th>
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