<?php  if($action == 'get_reg_state_select') {?>
<label for="country" class="col-sm-3 control-label text-right">State</label>
<div class="col-sm-9">
    <select class="form-control selectpicker" name="state">
        <option value="" selected="selected">Select State</option>
        <?php
            foreach($states as $single_state){
                ?>
                <option value="<?php echo $single_state["Stateid"]."_".$single_state["s_code"]; ?>"><?php echo $single_state["State"] ?></option>
                <?php
            }
        ?>
    </select>
</div>
<?php }
  if($action == 'get_traveller_state_select') {
?>
            <option value="" selected="selected">Select State</option>
            <?php
            foreach($states as $single_state){
                ?>
                <option value="<?php echo $single_state["Stateid"]; ?>"><?php echo $single_state["State"] ?></option>
                <?php
            }
            ?>
<?php } ?>
