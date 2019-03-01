
<div class="content">
    <div class="container">

        <div class="block-section">
            <h1 class="cont-title another">Track your shipment anywhere and anytime</h1>

            <div class="row margin-top-30">
                <div class="col-sm-8 col-xs-12 col-sm-push-2">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <img src="<?php echo  base_url();?>assets/images/fedex.jpg" class="img-responsive pull-right">
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <img src="<?php echo  base_url();?>assets/images/dhl.jpg" class="img-responsive pull-left">
                        </div>
                        <p class="clearfix"></p>
                        <form class="form-horizontal" method="get">
                            <div class="form-sl shipment-tracking-info no-border">
                                <div class="form-group">
                                    <div class="col-sm-4 col-xs-12 padding-right-0 padding-right-0 padding-for-mobile">
                                        <select id="trucking_carrier" class="form-control selectpicker select-country" name="carrier">
                                            <?php
                                            if(!empty($all_carriers)){
                                                foreach($all_carriers as $single_carrier){
                                                    $k = '';
                                                    if(strtolower($single_carrier['currier_name']) == strtolower($carrier)){
                                                        $k = 'selected="selected"';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $single_carrier['currier_name']; ?>" <?php echo $k; ?>><?php echo $single_carrier['currier_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-5 col-xs-12 padding-right-0 padding-for-mobile">
                                        <input type="text" id="truck_number" class="form-control" placeholder="Tracking Number" value="<?php echo $trucking_number; ?>">
                                    </div>
                                    <div class="col-sm-3 col-xs-12 padding-for-mobile">
                                        <button type="button" id="truck_button" class="orange-button-style-second">Track</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if(!empty($trucking_history['data']) && $trucking_history['status'] == 'OK'){
                            ?>
                            <div class="form-sl shipment-tracking-info no-border table-responsive">
                                <table class="table table-condensed designed-table shipment-tracking-table">
                                    <thead>
                                    <tr>
                                        <th><strong>Location</strong></th>
                                        <th><strong>Date/Time</strong></th>
                                        <th><strong>Activity</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($trucking_history['data']['trucking_history'] as $single_row){ ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if(!empty($single_row->location)) {
                                                    echo $single_row->location->city . ' ' . $single_row->location->state . ' ' . $single_row->location->zip . ' ' . $single_row->location->country;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $single_row->status_date; ?></td>
                                            <td><?php echo $single_row->status_details; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php }
                            elseif(empty($trucking_history['data']) && !empty($carrier) && !empty($trucking_number)){
                                ?>
                            <div class="form-sl shipment-tracking-info no-border table-responsive">
                                <h4 class="text-center">There are no information</h4>
                            </div>
                                <?php
                            }
                            ?>
                        </form>

                    </div>
                </div>
            </div>

            <div class="row margin-top-30"></div>
            <div class="row margin-top-30">
                <div class="col-md-6">
                    <h3>Tips</h3>
                    <div class="sl-info">
                        <ul class="short-line-height">
                            <li>Where can I find the tracking number of my shipment?</li>
                            <li>What can I do if I’m not able to track the shipment or the tracking stopped?</li>
                            <li>Will Luggage To Ship monitor my shipment?</li>
                            <li>Can I track my shipment in carrier’s website? </li>
                            <li>What can I do if my package is delayed in custom?</li>
                            <li>What can I do if my package is on hold by the carrier?</li>
                            <li>What can I do if my shipment experiences a “delivery exception”?</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3><span class="black-color">Tracking Keywords,</span> <i>Explanation</i>, <span class="orange-color">Action</span></h3>
                    <div class="sl-info">
                        <div class="short-line-height-tracking-row">
                            <div class="row">
                                <div class="col-md-6 text-left"><p class="main-text">Shipping Information Sent</p></div>
                                <div class="col-md-6 text-right italic-text"><p class="italic-text blue-color">Label is created, package is not picked up</p></div>
                                <div class="col-md-12">
                                    <p class="orange-color sub-mian-text">Call us or carrier if your package has been picked up</p>
                                </div>
                            </div>
                        </div>
                        <div class="short-line-height-tracking-row">
                            <div class="row">
                                <div class="col-md-6 text-left"><p class="main-text">Picked up</p></div>
                                <div class="col-md-6 text-right italic-text"><p class="italic-text blue-color">Your package has been picked up</p></div>
                                <div class="col-md-12">
                                    <p class="orange-color sub-mian-text">No action is needed</p>
                                </div>
                            </div>
                        </div>
                        <div class="short-line-height-tracking-row">
                            <div class="row">
                                <div class="col-md-6 text-left"><p class="main-text">In Transit</p></div>
                                <div class="col-md-6 text-right italic-text"><p class="italic-text blue-color">Your package is in transit to the destination</p></div>
                                <div class="col-md-12">
                                    <p class="orange-color sub-mian-text">No action is needed</p>
                                </div>
                            </div>
                        </div>
                        <div class="short-line-height-tracking-row">
                            <div class="row">
                                <div class="col-md-6 text-left"><p class="main-text">With Courier</p></div>
                                <div class="col-md-6 text-right italic-text"><p class="italic-text blue-color">Your package will be delivered today</p></div>
                                <div class="col-md-12">
                                    <p class="orange-color sub-mian-text">Be ready to accept the package</p>
                                </div>
                            </div>
                        </div>
                        <div class="short-line-height-tracking-row">
                            <div class="row">
                                <div class="col-md-6 text-left"><p class="main-text">Custom Delay</p></div>
                                <div class="col-md-6 text-right italic-text"><p class="italic-text blue-color">Your package is delayed in custom</p></div>
                                <div class="col-md-12">
                                    <p class="orange-color sub-mian-text">Call us or carrier if the delay is more than 2 day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
