<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>
<div class="content">
    <div class="container">
        <div class="profile">
            <div class="mob-profile text-right">
                <span class="my-prof">Order History</span>
                <a href="<?php echo base_url(); ?>" class="btn btn-default btn-login-orange">Check Price & Book Order</a>
            </div>

            <div class="content">

                <div class="dashboard-info">
                    <?php if(!empty($order_data)){

                    foreach ($order_data as $index => $data){ ?>
                    <div class="large-designed-info-row">
                        <div class="tr-order">
                            <span class="hidden-sm hidden-xs"><?php echo date("Y-m-d", strtotime($data['created_date']))?></span>
                            <span class="blue-color"><?php echo '<a href="'.base_url('dashboard/view_order/'.$data['real_id']).'">'.$data['order_number'].'</a>'; ?></span>
                            <span class="orange-color"><?php echo $data['title']; ?></span>
                        </div>
                        <div class="tr-order-edit mobile-hidden">
                            <span><a href="<?php echo base_url('dashboard/view_order/'.$data['real_id']); ?>"><img src="<?php echo base_url()?>assets/images/list-note.svg"></a></span>
                        </div>
                        <div class="tr-pickup mobile-hidden">
                            <span class="small-text">Pickup / Drop Off</span>
                            <span><?php echo $data['shipping_date']; ?></span>
                            <span><?php echo $data['pickup_time'];?></span>
                        </div>
                        <div class="tr-delivery mobile-hidden">
                            <span class="small-text">Delivery</span>
                            <span><?php echo $data['delivery_date'];?></span>
                            <span><?php echo $data['delivery_time'];?></span>
                        </div>
                        <div class="tr-country mobile-hidden">
                            <p>
                                <span><?php echo $countries[$data['pickup_country_id']]['country']; ?></span>
                                <span><?php echo $data['pickup_city']; ?></span>
                            </p>
                            <p>
                                <span><?php echo  $countries[$data['delivery_country_id']]['country']; ?></span>
                                <span><?php echo $data['delivery_city']; ?></span>
                            </p>
                        </div>
                        <div class="tr-shipping">
                           <span><img src="<?php echo base_url()?>assets/images/<?php echo strtolower($data['currier_name']).".png"; ?>">
                            <span class="no-tracking-number">
                                <?php
                                if(!empty($data['tracking_number']['tracking_number'])){

                                    foreach ($data['tracking_number']['tracking_number'] as $item){ ?>

                                        <span><?php echo $item['tracking_number']; ?></span>
                                 <?php   } } ?>
                                </span>
                        </div>
                        <div class="tr-country-mobile">
                            <span><?php echo $countries[$data['pickup_country_id']]['iso']."-".$data['pickup_city'] ?></span>
                            <span><?php echo $countries[$data['delivery_country_id']]['iso']."-".$data['delivery_city'] ?></span>
                        </div>
                        <div class="tr-complete-info add-padding">
                            <div class="list-hist">
                                <ul class="document-label item-list list-hist">
                                    <?php

                                    if(!empty($data['invoice'])){

                                        foreach ($data['invoice'] as $single){ ?>
                                        <li>
                                            <a href="<?php echo base_url('dashboard/invoice_file/' . $data['real_id'] . '/' .$single['pdf_file'])?>" target="_blank">
                                                <img class="" src="<?php echo  base_url();?>assets/images/invoice.png">
                                                <span><?php echo $single['type'];?><br />Invoice</span>
                                            </a>
                                        </li>
                                        <?php  } } ?>
                                </ul>
                                <span><?php echo (!empty($data['order_price']['original_price']) && $data['shipping_status'] == CLOSED_STATUS[0])?$data['order_price']['original_price'].'USD':'' ?></span>
                            </div>
                        </div>
                    </div>
<?php }} ?>
                    <div class="row">
                        <div class="col-md-12 text-right navigation-panel">
                            <ul class="pagination designed-pagination">
                                <?php echo $links; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<script>

    order_list_row_count = '<?php echo $order_list_row_count; ?>';
</script>