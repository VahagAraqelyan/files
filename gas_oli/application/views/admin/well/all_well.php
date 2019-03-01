<div class="content well_content">

    <div id="search_div">
        <div class="form-group my-form-group">
            <div class="col-3 control-label value-index">
                <select class="form-control" name="status" id="search_crt">
                    <option value="">Search Criteria</option>
                    <option value="well.well_id">Well ID</option>
                    <option value="well.name">Well Name</option>
                    <option value="well.location">Surface Location</option>
                    <option value="well.status">Well Status</option>
                    <option value="well.lat">Surface Latitude</option>
                    <option value="well.lng">Surface Longitude</option>
                    <option value="company.name">Company</option>
                    <option value="well.company_field">Company Field</option>
                    <option value="well.comment">Comment</option>
                </select>
            </div>
            <div class="col-3 value-info">
                <input type="text" name="search_val" class="form-control" autocomplete="off" id="search_val">
            </div>
            <div class="col-2 value-info">
                <button type="button" class="btn btn-primary search_reservetion_butt">Search</button>
            </div>
            <div class="col-3 value-info">
                <a href="" class="btn btn-default view-all-btn btn-login-blue" id="reset_butt">Reset</a>
            </div>
        </div>
    </div>
    <div class="form-group my-form-group">
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary upload_csv">Upload via CSV</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary update_well">Manual Update</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary delete_well"> Delete Well</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary mark_list">Mark List</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary unmark_list">Unmark List</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary see_map">See on map</button>
        </div>
    </div>
<!--    <div class="form-group my-form-group">
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary mark_list">Mark List</button>
        </div>
        <div class="col-2 value-info">
            <button type="button" class="btn btn-primary unmark_list">Unmark List</button>
        </div>
    </div>-->
    <table id="well_list" class=" table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small>#</small></th>
            <th class="order-number"><small>Well ID</small></th>
            <th class="order-number"><small>Well Name</small></th>
            <th class="order-number"><small>Surface Location</small></th>
            <th class="order-number"><small>Well Status․</small></th>
            <th class="order-number"><small>Surface Latitude</small></th>
            <th class="order-number"><small>Surface Longitude</small></th>
            <th class="order-number"><small>Company</small>
            <th class="order-number"><small>Company Field</small>
            <th class="order-number"><small>Comment</small>
            <th class="order-number"><small>State</small>
            <th class="order-number"><small>Edit/Delete</small>
            </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

<div class="modal " id="manual_update" role="dialog">
    <div class="modal-dialog modal-dialog-well">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="manual_update_answer">
            </div>

        </div>

    </div>
</div>

<div class="modal" id="view_more" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body view_well_answer">

            </div>
        </div>

    </div>
</div>

<div class="modal" id="map_modal" role="dialog">
    <div class="modal-dialog modal-dialog-well">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body map_answer">

            </div>
        </div>

    </div>
</div>
