<div class="container">
    <div>
    <form method="get" id="search_promotion_form">
        <input type="hidden" name="order_by" id="order_by_input">
        <input type="hidden" name="order_type" id="order_type_input">
    <div class="customer-list-hole-part">
        <div id="adtop_msg_pcdiv"></div>
        <h3>Manage Promotions</h3>
        <div>
            <div id="promo_search" class="">
                <div>
                <table>
                    <tr>
                        <td><span>From:</span></td>
                        <td><input class="promotion" type="text" name="date_from" autocomplete="off" value="<?php echo (!empty($_GET['date_from']))?$_GET['date_from']:''; ?>"></div></div></td>
                        <td><span>To:</span></td>
                        <td><input class="promotion" type="text" name="date_to" autocomplete="off" value="<?php echo (!empty($_GET['date_to']))?$_GET['date_to']:''; ?>"></div></div></td>
                        <td>
                            <select name="promotion_type" id="">
                                <option value="">Select Type</option>
                                <?php
                                foreach($promotion_types as $value=>$info){
                                    $k = '';
                                    if(!empty($_GET['promotion_type']) && $_GET['promotion_type'] == $value){
                                        $k = 'selected="selected"';
                                    }
                                    $name = str_replace('_', ' ', $value);
                                    ?>
                                    <option value="<?php echo $value; ?>" <?php echo $k; ?>><?php echo $name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="status" id="">
                                <option value="">Select Status</option>
                                <?php
                                foreach($statuses as $value => $name){
                                    $k = (isset($_GET['status']) && $_GET['status'] == $value)?'selected="selected"':'';
                                    ?>
                                    <option value="<?php echo $value; ?>" <?php echo $k; ?>><?php echo $name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td><button class="btn btn-default btn-login-orange button-size-class" type="submit">Search</button></td>
                        <td><a href="<?php echo base_url('admin/promotion/promotion')?>"><button class="btn btn-default btn-login-blue button-size-class reset_all" type="button">Reset All</button></a></td>
                    </tr>
                </table>
            </form>
    </div>
            <div>
                <button data_id = '' class="add-new-but btn btn-default btn-login-orange button-size-class add_promotion_butt" type="button">Add New</button>
            </div>
            </div>
            <div class='prom_pagination text-right'>
                <?php
                echo $pagination;
                ?>
            </div>
        </div>
        <div class="customer-list-body-part">
            <div class="inner_main">
                <div class="tblbox">
                    <table class="table table-bordered table-hover designed-table">
                        <thead>
                        <tr>
                            <?php
                            foreach($table_head as $value => $info){

                                if(empty($info['order_type'])){
                                    ?>
                                    <th><?php echo $info['title']; ?></th>
                                    <?php
                                    continue;
                                }

                                if(empty($info['active'])){
                                    ?>
                                    <th><?php echo $info['title'];?><span class = 'prom_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $info['order_type']; ?>">&#9650;&#9660;</span></th>
                                    <?php
                                    continue;
                                }

                                if($info['order_type'] == 'ASC'){
                                    $symbol = '&#9660;';
                                }else{
                                    $symbol = '&#9650;';
                                }

                                ?>
                                <th><?php echo $info['title'];?><span class = 'prom_order_span' data-order-by="<?php echo $value; ?>" data-order-type="<?php echo $info['order_type']; ?>"><?php echo $symbol; ?></span></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($all_codes)){
                            foreach($all_codes as $single){

                                if(!empty($single['amount_p']) && $single['amount_p'] > 0){
                                    $amount = $single['amount_p'].' %';
                                }else{
                                    $amount = '$ '.$single['amount_d'];
                                }


                                ?>
                                <tr>
                                    <td><?php echo (!empty($statuses[$single['status']]))?$statuses[$single['status']]:'Invalid status'; ?></td>
                                    <td><?php echo str_replace('_', ' ', $single['promotion_type']); ?></td>
                                    <td><?php echo $single['code']; ?></td>
                                    <td><?php echo $single['created_by']; ?></td>
                                    <td><?php echo $amount; ?></td>
                                    <td><?php echo $single['date_from']; ?></td>
                                    <td><?php echo $single['date_to']; ?></td>
                                    <td><?php echo $single['desc']; ?></td>
                                    <td><?php echo ($single['original_count'] != '-10' || $single['count_of_use'] != '-10')?$single['original_count'].' / '.$single['count_of_use']:'Unlimited/Unlimited'; ?></td>
                                    <td><a href="#" data_id = '<?php echo $single['id']; ?>' class="add_promotion_butt"><i class="fa fa-pencil promotion_edit"></i></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </form>


<div id="add_promotion" tabindex="-1" role="dialog" class="login-fast inform-fast modal fade ">
    <div class="modal-dialog" role="document">
        <div class="modal-content white-background">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mobile_padding_in_popap promotion_answer">


            </div>
        </div>
    </div>
</div>

</div>