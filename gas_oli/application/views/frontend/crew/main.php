<section class="main_dashboard">
<main>
    <div class="content">
        <div class="row">
            <?php
            if(!empty($company)){ ?>
                <div class="col-md-12 main_buttons">
                    <?php
                        foreach ($company as $single){ ?>
                            <button class="company_filter" data-id=""><?php echo $single['name']?></button>
                            <input type="checkbox" name="company" class="company_checkbox" value="<?php echo $single['id']?>" style="display: none">

                    <?php } ?>

                </div>
            <?php } ?>
            <?php
            if(!empty($get_states)){
                foreach ($get_states as $index => $single){ ?>
                    <div class="col-md-6">
                        <div class="map_info">
                            <h2 class="filter_state"><?php echo $single['state'];?></h2>
                            <input type="checkbox" name="filter_state_checkbox" class="filter_state_checkbox" value="<?php echo $single['id']?>" style="display:none;">
                            <div class="map">
                                <!--<iframe style="width: 100%;min-height: 250px;" src="<?php /*echo $single; */?>" frameborder="0"></iframe>-->
                                <img src="<?php echo base_url();?>assets/images/map.jpg" alt="">
                            </div>
                        </div>
                    </div>
                <?php }  } ?>
            <div class="col-md-6"></div>
            <div class="col-md-12">
                <div class="next_page">
                    <a href="#" id="next_filter">Next </a>
                </div>
            </div>
        </div>
    </div>
</main>
</section>