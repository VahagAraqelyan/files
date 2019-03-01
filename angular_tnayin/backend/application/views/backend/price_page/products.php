<div class="panel panel-default designed-panel no-margin">
    <div class="panel-body no-padding">

        <?php

        foreach ($types as $key => $type){
            if(!empty($type['prod'])){
            ?>
            <form method="post" class="form-horizontal search-data-form" action="">
                <table class="table table-bordered designed-table">
                    <thead>
                    <tr>
                        <th rowspan="2" width="18%"><small class="left-corner-big orange-color"><?php echo (!empty($type['name']))?$type['name']:''; ?></small></th>
                        <th colspan="2"><small>Label (API)</small></th>
                        <th colspan="2"><span class="error_class">MAX</span></th>
                        <th rowspan="2"></th>
                        <th colspan="2"><small class="display-table">Domestic  Fee ( $ )</small></th>
                        <th rowspan="2"></th>
                        <th colspan="5"><small>International  Fee ( $ )</small></th>
                    </tr>
                    <tr>
                        <th><small>Weight</small></th>
                        <th><small>Sizes</small></th>
                        <th><small>Weight</small></th>
                        <th><small>Sizes</small></th>
                        <th><small>Express</small></th>
                        <th><small>Basic</small></th>
                        <?php

                        foreach ($curriers as $currier){ ?>

                            <th>
                               <p> <small><?php echo  $currier['currier_name']; ?></small></p>
                            <?php
                            foreach ($international_fee_limit as $types_limit){

                                $string = $types_limit['from'];
                                if($types_limit['to'] != $types_limit['from']){

                                    if($types_limit['to'] == INF){

                                        $string .= '+';

                                    }else{

                                        $string .= ' - '.$types_limit['to'];
                                    }
                                }
                                ?>
                                <apan class="prod_currier_th"><?php echo $string; ?></apan>
                            <?php }
                            ?>
                            </th>


                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>

                 <?php
               if(!empty($type['prod'])){

                  foreach ($type['prod'] as  $key => $single ){  ?>
                    <tr>
                        <td class="text-left">
                            <input type="hidden" name="ids[]" value="<?php echo $key; ?>"> <span class="prod_name_span"><?php echo (!empty($single['prod_name']))?$single['prod_name']:'';?></span>
                            <input type="text" value="<?php echo (!empty($single['charge_weight']))?$single['charge_weight']:''; ?>" name="charge_weight_<?php echo $key; ?>" class="form-control not_string display-inline small-input prod_charge_weight">
                        </td>
                     <td><input type="text" value="<?php echo (!empty($single['api_weight']))?$single['api_weight']:''; ?>" name="max_weight_<?php echo $key; ?>" class="form-control not_string"></td>
                        <td><input type="text" value="<?php echo (!empty($single['api_size']))?$single['api_size']:''; ?>" name="max_size_<?php echo $key; ?>" class="form-control prod_size_input "></td>
                        <td><input type="text" value="<?php echo (!empty($single['weight']))?$single['weight']:''; ?>" name="weight_<?php echo $key; ?>" class="form-control not_string"></td>
                        <td><input type="text" value="<?php echo (!empty($single['size']))?$single['size']:''; ?>" name="size_<?php echo $key; ?>" class="form-control prod_size_input"></td>
                        <td ><span class="plus-sign orange-color"><i class="fa fa-plus"></i></span></td>
                        <td><input value="<?php echo (!empty($single['domestic_express']))?$single['domestic_express']:''; ?>" type="text"  name="express_<?php echo $key; ?>" class="form-control not_string"></td>
                        <td><input value="<?php echo (!empty($single['domestic_basic']))?$single['domestic_basic']:''; ?>" type="text"  name="basic_<?php echo $key; ?>" class="form-control not_string"></td>
                        <td ><span class="plus-sign orange-color"><i class="fa fa-plus"></i></span></td>
                          <?php

                          foreach ($curriers as $currier_id => $currier){
                              //$value = (!empty($currier['value'][$key]))?$currier['value'][$key]:'';
                              ?>
                                 <!-- -->
                              <td class="prod_main_td">
                                  <table>
                                      <thead>
                                      <tr>

                                      </tr>
                                      </thead>
                                      <tbody>
                                      <tr>
                                          <?php
                                          foreach ($currier['value'][$key] as $fee_type => $fee_value){ ?>
                                              <td class="prod_currier_td"><input type="text" value="<?php  show_price($fee_value); ?>" name="currier_<?php echo $key.'['.$currier_id.']['.$fee_type.']'; ?>" class="form-control not_string small_inp_prod"></td>
                                          <?php }
                                          ?>
                                      </tr>
                                      </tbody>
                                  </table>
                              </td>
                          <?php } ?>
                    </tr>
                    <?php  }   } ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <div class="col-md-10 text-right">
                        <span class="form-small-font display-inline"><?php echo $type['date']; ?></span>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-default btn-login-orange adm-btn update_prod_butt">Update</button>
                    </div>
                </div>

            </form>
            <p class="border-bottom some-margin-bottom"></p>
        <?php } } ?>


        <div class="row dimension-patten">
            <h5 class="col-md-12"><strong>Dimensional Weight Patten</strong></h5>
            <div class="col-md-1">
                <span class="form-small-font display-inline">Domestic</span>
            </div>
            <div class="col-md-1">
                <input type="text" name="" id="domestic_pattern" class="form-control not_string">
            </div>
            <div class="col-md-1">
                <span class="form-small-font display-inline">International</span>
            </div>
            <div class="col-md-1">
                <input type="text" name="" id="international_pattern" class="form-control not_string">
            </div>
            <div class="col-md-3 text-right">
                <span class="form-small-font display-inline">Update Time: 03-15-2017 13:45pm</span>
            </div>
            <div class="col-md-2 text-left">
                <button type="button" id="save_pattern" class="btn btn-default btn-login-orange adm-btn">Update</button>
            </div>
        </div>

    </div>
</div>