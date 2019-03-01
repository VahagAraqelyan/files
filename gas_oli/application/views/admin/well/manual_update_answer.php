<form method="post" autocomplete="off" id="manual_update_form">
    <div class="main_well_upd">
<?php

$road_status_arr = [
        1  => 'incomplete',
        2  => 'In progress',
        3  => 'Weed spray',
        4  => 'complete',
        5  => 'Remote',
];

if(!empty($download_wells)){
    foreach ($download_wells as $index => $single){ ?>
        <input type="hidden" name="ids[]" value="<?php echo $single['id']?>">
            <div class="my-form-group">
                <div class="col-1 value-info">
                    <input type="text" name="well_id[]" class="form-control" autocomplete="off" placeholder="Well Id" value="<?php echo $single['well_id'];?>">
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="name[]" class="form-control" autocomplete="off" placeholder="Well Name" value="<?php echo $single['name'];?>">
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="location[]" class="form-control" autocomplete="off" placeholder="Surface Location" value="<?php echo $single['location'];?>">
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="status[]" class="form-control" autocomplete="off" placeholder="Well Status" value="<?php echo $single['status'];?>">
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="lat[]" class="form-control" autocomplete="off" placeholder="Surface Latitude" value="<?php echo $single['lat'];?>">
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="lng[]" class="form-control" autocomplete="off" placeholder="Surface Longitude" value="<?php echo $single['lng'];?>">
                </div>
                <div class="col-1 value-info">
                    <select name="company[]" class="form-control">
                        <option value=" "> Select company name</option>
                        <?php
                        if(!empty($company)){
                            foreach ($company as $item){
                                $k = ($single['company_id'] == $item['id'])?'selected="selected"':'';
                                ?>
                                <option <?php echo $k; ?> value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                            <?php } } ?>
                    </select>
                </div>

                <div class="col-1 value-info">
                    <select name="road_status[]" class="form-control">
                        <option value=" "> Select company name</option>
                        <?php
                        if(!empty($road_status_arr)){
                            foreach ($road_status_arr as $index => $road_single){
                                $k = ($index == $single['road_status'])?'selected="selected"':'';
                                ?>
                                <option <?php echo $k; ?> value="<?php echo $index; ?>"><?php echo $road_single?></option>
                            <?php } } ?>
                    </select>
                </div>
                <div class="col-1 value-info">
                    <input type="text" name="company_field[]" class="form-control" autocomplete="off" placeholder="Company Field" value="<?php echo $single['company_field'];?>">
                </div>
                <div class="col-1 value-info">
                    <span  class="update_comment" data-id="<?php echo $single['id']?>">Update comment</span>
                    <input type="text" name="comment[]" data-id="<?php echo $single['id']?>" class="form-control" value="<?php echo $single['comment'];?>" style="visibility: hidden">
                </div>
            </div>

    <?php } } ?>
    <div class="col-12 value-info">
        <button type="button" class="btn btn-primary save_manual_update">Save</button>
    </div>
    </div>
</form>


<div class="modal" id="view_comment" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body view_well_answer">
                <div class="form-group">
                    <label for="exampleInputPassword1">Comment</label>
                    <textarea name="comment" id="upd_well_textarea" class="form-control"></textarea>
                </div>
                <button type="button" class="btn btn-primary" id="change_comment">Save</button>
            </div>
        </div>

    </div>
</div>