<div class="page hard"></div>
<div class="page hard"></div>
<!--<div class="page">
    <div class="book_list">
        <ul>

            <?php
/*    if(!empty($food_type)){
        foreach ($food_type as $single){
        */?>

          <li>  <a href="<?php /*echo 'a';*/?>"><?php /*echo $single['name_am']*/?></a></li>

    <?php /*} } */?>
        </ul>
    </div>
</div>-->
<?php

if(!empty($food_type)){

   $el_height = 26;
   $count = floor($height/$el_height);
    $count = $count-2;
    $p_count = '';

foreach ($food_type as $single_type){
    $page_div = '';
    $n1 = '';
    $p_count = ceil(count($single_type['children'])/$count);

    if(count($single_type['children']) > $count && !empty($single_type['children'])){

        for ($i=1; $i<=$p_count;$i++){ ?>
            <div class="page">
            <h3 class="menu_title"><?php echo $single_type['name_am']; ?></h3>
            <?php
            foreach ($single_type['children'] as $index => $single_menu){
                if(($index+1>($i-1)*$count) && $index+1<=$i*$count){ ?>

                    <div class="show_menu_main">
                        <p><?php echo $single_menu['name_am']; ?></p>
                        <p><?php echo $single_menu['price'];?> </p>
                    </div>
                <?php }} ?></div><?php } ?>

    <?php
    }else{
        if(!empty($single_type['children'])){ ?>
        <div class="page">
            <h3 class="menu_title"><?php echo $single_type['name_am']; ?></h3>
            <?php
            foreach ($single_type['children'] as $index => $single_menu){ ?>
                    <div class="show_menu_main">
                        <p><?php echo $single_menu['name_am']; ?></p>
                        <p><?php echo $single_menu['price'];?> </p>
                    </div>
                <?php } ?>
        </div>
            <?php }  } } } ?>
<div class="hard"></div>
<div class="hard"></div>
