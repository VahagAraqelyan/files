
<main class="map">
        <div class="content">
            <div class="flex_container">
                <div class="flex_item left_side">
                   <!-- <h2>Accel / Carson Creek</h2>-->
                    <div>
                        <ul class="nav">
                            <?php
                                if(!empty($filter_well)){
                                    foreach ($filter_well as $index => $value){ ?>
                                        <li class="well_inf" data-index="<?php echo $index;?>">
                                            <div>
                                                <p><?php echo $value['name']?></p>
                                                <a class="locate">
                                                    <p><span>Surface location:</span> <?php echo $value['location']?></p>
                                                    <p><span>Well ID: </span><?php echo $value['well_id']?></p>
                                                </a>
                                                <!--<p class="show_road" data-lat="<?php /*echo str_replace(',','.',$value['lat']);*/?>" data-lng="<?php /*echo str_replace(',','.',$value['lng']);*/?>">Show the road</p>-->
                                                <p class="designatet_place" data-id="<?php echo $value['id']; ?>" data-lat="<?php echo str_replace(',','.',$value['lat']);?>" data-lng="<?php echo str_replace(',','.',$value['lng']);?>">go to the designated place</p>
                                            </div>

                                            <p><i class="fas fa-chevron-right"></i></p>
                                        </li>
                                    <?php } }else{
                                    echo 'Data is missing.';
                                } ?>
                        </ul>
                    </div>
                </div>
                <div class="flex_item right_side">
                    <p class="road_distance"></p>
                    <div id="map">
                    </div>
                </div>
            </div>
        </div>
    </main>

<div class="modal " id="change_status_modal" role="dialog">
    <div class="modal-dialog modal-dialog-well">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="manual_update_answer">
              <div class="col-12">
                  <span>Change marker in yellow</span>
                  <input type="radio" name="chage_well_status" class="chage_well_status" value="4">
              </div>
               <div class="col-12">
                   <span>Change marker in green</span>
                   <input type="radio" name="chage_well_status" class="chage_well_status" value="3">
               </div>
            </div>

        </div>

    </div>
</div>

    <script>
        main_search_arr = '<?php echo  json_encode($filter_well,JSON_HEX_APOS|JSON_HEX_QUOT); ?>';
        short_well = '<?php echo  json_encode([0 => $go_arr],JSON_HEX_APOS|JSON_HEX_QUOT); ?>';
        user_id = '<?php echo $this->ion_auth->user()->row()->id; ?>'
    </script>

<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCzvjTnQCk5oShj_tTQcotEoaly3I3wWiw&sensor=FALSE'></script>


<!--AIzaSyAT_4SjgkacPQd0Iuj3TGv5br7UdMHprzc-->