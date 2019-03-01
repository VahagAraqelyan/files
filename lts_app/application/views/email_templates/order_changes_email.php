<h1 style = "padding:20px 0; text-align:center;">
    <?php
    if(!empty($title)) {
        echo $title;
    }
    ?>
</h1>
<?php
    if(!empty($content)) {

        foreach($content as $single){
            if(!is_numeric(intval($single['title']))){
                echo $single['title'];
            }
            echo $single['body'];
        }

    }
?>
