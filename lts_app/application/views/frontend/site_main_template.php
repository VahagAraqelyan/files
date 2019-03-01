<!doctype html>
<html lang="en">
<?php

   $us_id = $this->Users_model->get_us_country();
   $data = array();

   if(!empty($us_id[0])) {

        $data['us_id'] = $us_id[0]['id'];
    }

    $this->load->view('frontend/head',$data);
?>
<body>
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
    <div id="full_page_loader">
        <div id="loader_container">
            <div class="cssload-thecube">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
        </div>
    </div>
    <div id="content_main_container" style="display:none;">
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
