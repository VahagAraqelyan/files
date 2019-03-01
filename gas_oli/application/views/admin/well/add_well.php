

<div class="steersman_content admin_content">
    <div class="show_error">

    </div>

    <div class="form-group">
        <label class="btn btn-default btn-file select-doc-file my_profile_document">
            Upload CSV <input type="file" id="upload_csv" name="upload_csv" class="form-control" style="display: none;">
        </label>
    </div>
  <div class="form-group upload_progressbar" id="upload_progressbar">
        <div class="progressbar">
            <div class="procent">
                <span class="proc_span"></span>
            </div>
        </div>
    </div>
    <form autocomplete="off" method="post" id="add_well_form">
        <div class="form-group">
            <label for="exampleInputEmail1">Well ID</label>
            <input type="text" class="form-control" name="well_id" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Well Name</label>
            <input type="text" class="form-control" name="name" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Surface Location</label>
            <input type="text" class="form-control" name="location" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Well Status</label>
            <input type="text" class="form-control" name="status" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Surface Latitude</label>
            <input type="text" class="form-control" name="lat" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Surface Longitude</label>
            <input type="text" class="form-control" name="lng" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Company</label>
            <select name="company" class="form-control">
                <option value=" "> Select company name</option>
                <?php
                if(!empty($company)){
                    foreach ($company as $single){ ?>
                        <option value="<?php echo $single['id']?>"><?php echo $single['name']?></option>
                   <?php } } ?>
            </select>
        </div>
        <div class="form-group">

            <label for="exampleInputPassword1">State</label>
            <select name="state_id" class="form-control">
                <option value=" "> Select state</option>
                <?php
                if(!empty($states)){
                    foreach ($states as $single){ ?>
                        <option value="<?php echo $single['id']?>"><?php echo $single['state']?></option>
                    <?php } } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Company Field</label>
            <input type="text" class="form-control" name="company_field" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Comment</label>
            <textarea name="comment" id="well_textarea" class="form-control"></textarea>
        </div>
        <button type="button" class="btn btn-primary" id="add_well_butt">Save</button>
    </form>
</div>
