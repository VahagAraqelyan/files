<!doctype html>
<html lang="en">
<?php
    $this->load->view('frontend/head');
?>
<body>

<div class="loader" id="full_page_loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>

<div class="site_main_div" style="visibility: hidden; height:0; overflow:hidden;">
    <?php
        if(empty($head_buffer)) {
            $this->load->view('frontend/header');
        }else{
            $this->load->view($head_buffer);
        }

        if(empty($navigation_buffer)) {
            $this->load->view('frontend/navigation');
        }else{
            $this->load->view($navigation_buffer);
        }
        ?>

    <?php
        $this->load->view($content);

        if(empty($foot_buffer)) {
            $this->load->view('frontend/footer');
        }else{
            $this->load->view($foot_buffer);
        }
    ?>
    </div>
</body>

</html>
