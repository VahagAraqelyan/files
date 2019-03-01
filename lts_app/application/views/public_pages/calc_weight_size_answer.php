
<div class="col-sm-5 col-xs-12">
    <div class="luggage-img">
        <img id="" src="<?php echo  base_url();?>assets/images/<?php echo $single_luggage['sizes_image']; ?>">
    </div>
</div>
<div class="col-sm-7 col-xs-12">

    <div class="luggage-content">
        <p class="blue-color item-title"><?php echo $single_luggage['luggage_name']; ?></p>
        <p class="weght_size_p"><span class="size-info">Max Weight</span> <span class="orange-color"><?php echo $single_luggage['weight'];?> lbs / <?php echo  floor(floatval(modify_number($single_luggage['weight'] /2.2)));?> kg</span></p>
        <p class="weght_size_p"><span class="size-info">Max Length</span> <span class="orange-color"><?php echo $single_luggage['length'];?> inch / <?php echo floor(floatval(modify_number($single_luggage['length']* 2.54)));?> cm</span></p>
        <p class="weght_size_p"><span class="size-info">Max Girth</span> <span class="orange-color"><?php echo $single_luggage['girth'];?> inch /  <?php echo  floor(floatval(modify_number($single_luggage['girth']* 2.54)));?> cm</span></p>
    </div>
</div>