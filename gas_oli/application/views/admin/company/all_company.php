<div class="content well_content">

    <div id="search_div">
        <div class="form-group my-form-group">
            <div class="col-3 value-info">
                <input type="text" name="search_val" class="form-control" autocomplete="off" id="search_val">
            </div>
            <div class="col-2 value-info">
                <button type="button" class="btn btn-primary search_company_butt">Search</button>
            </div>
            <div class="col-3 value-info">
                <a href="" class="btn btn-default view-all-btn btn-login-blue" id="reset_butt">Reset</a>
            </div>
        </div>
    </div>
    <div class="form-group my-form-group">

        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary update_company">Update</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary delete_company">Delete</button>
        </div>
    </div>
    <table id="company_list" class=" table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class="">
                <small>#</small>
            </th>
            <th class="order-number">
                <small>Company Name</small>
            </th>
            <th class="order-number">
                <small>Edit/Delete</small>
            </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

<div class="modal" id="update_company_modal" role="dialog">
    <div class="modal-dialog modal-dialog-well">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body update_company_answer">

            </div>
        </div>

    </div>
</div>