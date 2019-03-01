<div class="content well_content">

    <div id="search_div">
        <div class="form-group my-form-group">
            <div class="col-3 control-label value-index">
                <select class="form-control" name="status" id="search_crt">
                    <option value="">Search Criteria</option>
                    <option value="first_name">Name</option>
                    <option value="last_name">Surname</option>
                    <option value="email">Email address</option>
                    <option value="tel">Tel.</option>
                </select>
            </div>
            <div class="col-3 value-info">
                <input type="text" name="search_val" class="form-control" autocomplete="off" id="search_val">
            </div>
            <div class="col-2 value-info">
                <button type="button" class="btn btn-primary search_driver_butt">Search</button>
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

    <table id="driver_list" class=" table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Name</small></th>
            <th class="order-number"><small>Surname</small></th>
            <th class="order-number"><small>Email address</small></th>
            <th class="order-number"><small>Tel.</small></th>
            <th class="order-number"><small>Active/Inactive</small></th>
            <th class="order-number">
                <small>Edit/Delete</small>
            </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal" id="update_crew_modal" role="dialog">
    <div class="modal-dialog modal-dialog-well">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body update_crew_answer">

            </div>
        </div>

    </div>
</div>