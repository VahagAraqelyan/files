<!-- traveler list  -->

<div class="panel-heading">
    <div class="row">
        <div class="col-md-6 mobile-hidden"><strong>Traveler List:</strong>  This list will be show up when place the order.</div>
        <div class="col-md-6 text-right">
            <ul class="pagination designed-pagination">
                <?php echo $links; ?>
            </ul>
        </div>
    </div>

</div>
<div class="panel-body no-padding">

    <table class="table table-bordered table-hover designed-table">
        <thead>
        <tr>
            <th class=""><small></small></th>
            <th class=""><small>First Name</small></th>
            <th class=""><small>Last Name</small></th>
            <th class=""><small>Phone Number</small></th>
            <th class=""><small>Email</small></th>
            <th class=""><small>City</small></th>
            <th class=""><small>State / Region</small></th>
            <th class=""><small>Country</small></th>
            <th class=""><small>Detail</small></th>
        </tr>
        </thead>
        <tbody>

            <?php foreach($travel_list as $trav) { ?>
            <tr data-id="<?php echo $trav['id']; ?>">
            <td><label> <input type="checkbox" name="traveler_id[]" class="traveler_list_checkbox" value="<?php echo $trav['id']; ?>"></label></td>
            <td><?php echo $trav['first_name']; ?></td>
            <td><?php echo $trav['last_name']; ?></td>
            <td><?php echo $trav['phone']; ?></td>
            <td><?php echo $trav['email']; ?></td>
            <td><?php echo $trav['city']; ?></td>
            <td><?php echo $trav['State']; ?></td>
            <td><?php echo $trav['country']; ?></td>
            <td><a href="" class="list-details details_modal trav_inf view_traveler_info" id="view_traveler_info" data-name="traveller_details_modal" data-toggle="modal" data-target="#my_profile_modal" data-blok="<?php echo $trav['id']; ?>"><i class="fa fa-list-ul"></i></a></td>
        </tr>
            <?php } ?>
        </tbody>
    </table>

</div>