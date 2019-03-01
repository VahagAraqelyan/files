<?php
if(!empty($admin['id'])){
    $class = 'edit_admin_form';
}else{
    $class = 'add_edit_admin_form';
}
?>

<form method="post" id="<?php echo $class; ?>" autocomplete="off">
    <div class="reservetion-error">

    </div>
    <input type="hidden" name="id" value="<?php echo $admin['id'];?>">
    <div class="form-group">
        <label>Անուն</label>
        <input type="text" class="form-control" name="name" value="<?php echo $admin['name'];?>">
    </div>
    <div class="form-group">
        <label>Էլ․ Հասցե</label>
        <input type="email" class="form-control" name="email" value="<?php echo $admin['email'];?>">
    </div>
    <div class="form-group">
        <label>Գաղտնաբառ</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label>Կրկնել Գաղտնաբառը</label>
        <input type="password" class="form-control" name="confirm_password">
    </div>

    <?php
    if(empty($admin['id'])){ ?>
        <div class="form-group">
            <label>Գլխավոր Ադմին</label>
            <input type="checkbox" value="1" name="root_admin">
        </div>
    <?php }
    ?>
</form>