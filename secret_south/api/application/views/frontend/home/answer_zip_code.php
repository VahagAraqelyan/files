
<?php
foreach($zip_codes_array as $zip_code){
    ?>
    <div
        class="single_zip_div"
        data-zip="<?php echo $zip_code["zip"]." - ".$zip_code["primary_city"]; ?>"
        data-input="<?php echo $input_id; ?>"
        data-parent="">
        <?php echo $zip_code["zip"]." / ".$zip_code["primary_city"]." / ".$zip_code["full_state"]; ?>
    </div>
    <?php
}
?>