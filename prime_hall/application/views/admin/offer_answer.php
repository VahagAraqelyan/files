<div class="reservetion-error">
<?php

$switch_text = ($info['status'] == 1)?'Active':'In Active';
$checked     = ($info['status'] == 1)?'checked':'';

?>
</div>
<form id="edit_add_offer_form">
    <input type="hidden" name="id" id="offer_id" value="<?php echo $info['id'];?>">
    <div class="form-group">
        <label>Վերնագիր (Հայերեն)</label>
        <input type="text" class="form-control" name="title_am" id="edit_title_am" value="<?php echo $info['title_am']?>">
    </div>
    <div class="form-group">
        <label>Վերնագիր (Ռուսերեն)</label>
        <input type="text" class="form-control" name="title_ru" id="edit_title_ru" value="<?php echo $info['title_ru']?>">
    </div>
    <div class="form-group">
        <label>Վերնագիր (Անգլերեն)</label>
        <input type="text" class="form-control" name="title_en" id="edit_title_en" value="<?php echo $info['title_en']?>">
    </div>
    <div class="form-group">
        <label>Նկար</label>
        <label class="btn btn-default btn-file select-doc-file">
            Ընտրել նկար
            <input type="file" name="image" id="edit_offer_image" style="display: none;">
        </label>
    </div>

    <div class="form-group">
        <label>Առաջարկ (Հայերեն)</label>
        <textarea class="textarea" name="" id="edit_paragraph_desc_am_<?php echo $info['id']; ?>"><?php echo $info['offer_am'];?></textarea>
    </div>
    <div class="form-group">
        <label>Առաջարկ  (Ռուսերեն)</label>
        <textarea class="textarea" name="" id="edit_paragraph_desc_ru_<?php echo $info['id']; ?>"><?php echo $info['offer_ru'];?></textarea>
    </div>
    <div class="form-group">
        <label>Առաջարկ (Անգլերեն)</label>
        <textarea class="textarea" name="" id="edit_paragraph_desc_en_<?php echo $info['id']; ?>"><?php echo $info['offer_en'];?></textarea>
    </div>
    <div class="form-group status_main">
        <div class="box-body on_off_drop">
            <label class="status_checkbox grey"><?php echo $switch_text; ?></label>
            <label class="switch">
                <input type="checkbox" name="status_check" <?php echo $checked; ?> id="status_check">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

</form>