<!doctype html>
<html lang="en">
<?php
    $this->load->view('frontend/head');
?>
<body>

<?php
if(empty($head_buffer)) {
    $this->load->view('frontend/header');
}else{
    $this->load->view($head_buffer);
}
?>

<section class="map_page">
    <?php

        if(empty($navigation_buffer)) {
            $this->load->view('frontend/navigation');
        }else{
            $this->load->view($navigation_buffer);
        }
        ?>

        <?php
        $this->load->view($content);

    ?>

</section>
<?php
if(empty($foot_buffer)) {
    $this->load->view('frontend/footer');
}else{
    $this->load->view($foot_buffer);
}
?>
</body>

</html>
