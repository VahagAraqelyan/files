<div class="register-block no-hide" id="main_incurance_div">
    <h2 class="register-title text-center">Tracking</h2>

    <div class="form-horizontal text-left">
        <div class="panel-body">
            <?php

            if(!empty($errors)){
                ?>
                <h3><?php echo $errors[0]; ?></h3>
                <?php

            }else{
                $data = $info['data'];
                ?>
                <table class="table table-bordered table-hover designed-table tracking_number_table">
                    <thead>
                    <tr>
                        <td colspan = '4'><h4 class='text-center'>Current</h4></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo (!empty($data['current_status']->status))?$data['current_status']->status:''; ?></td>
                        <td><?php echo (!empty($data['current_status']->status_details))?$data['current_status']->status_details:''; ?></td>
                        <td><?php echo (!empty($data['current_status']->status_date))?$data['current_status']->status_date:''; ?></td>
                        <td><?php
                            if(!empty($data['current_status']->location)) {
                                echo $data['current_status']->location->city . ' ' . $data['current_status']->location->state . ' ' . $data['current_status']->location->zip . ' ' . $data['current_status']->location->country;
                            }?></td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-hover designed-table tracking_number_table">
                    <thead>
                    <tr>
                        <td colspan = '4'><h4 class='text-center'>History</h4></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $history = array_reverse($data['trucking_history']);
                    foreach($history as $single_row){ ?>
                        <tr>
                            <td><?php echo $single_row->status; ?></td>
                            <td><?php echo $single_row->status_details; ?></td>
                            <td><?php echo $single_row->status_date; ?></td>
                            <td><?php
                                if(!empty($single_row->location)) {
                                    echo $single_row->location->city . ' ' . $single_row->location->state . ' ' . $single_row->location->zip . ' ' . $single_row->location->country;
                                }
                                ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>


        </div>
    </div>
</div>



