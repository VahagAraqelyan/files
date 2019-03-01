<!-- addres book -->
<div class="panel-heading">
    <div class="row">
        <div class="col-md-9 mobile-hidden"><strong>Address Book:</strong> Address list will show if zip code/city match with the shipping/delivery addresses of your order</div>
        <div class="col-md-3 text-right">
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
            <th class=""><small>Address ID</small></th>
            <th class=""><small>Address 1</small></th>
            <th class=""><small>City</small></th>
            <th class=""><small>State / Region</small></th>
            <th class=""><small>Country</small></th>
            <th class=""><small>Detail</small></th>
        </tr>
        </thead>
        <tbody>

            <?php

            foreach($address_book as $single){
            ?>
                <tr data-block = '<?php echo $single['id']; ?>' >
            <td><label> <input type="checkbox" name="addr_book[]" class="address_book_list_checkbox" value="<?php echo $single['id']; ?>"> </label></td>
            <td><?php echo (empty($single['contact_id']))?'<div class="tr-empty"></div>':$single['contact_id']; ?></td>
            <td><?php echo $single['address1']; ?></td>
            <td><?php echo $single['city']; ?></td>
            <td><?php echo $single['State']; ?></td>
            <td><?php echo $single['country']; ?></td>
            <td><a href="" class="list-details view_address_book" data-toggle="modal" data-target="#my_profile_modal" data-blok="<?php echo $single['id']; ?>"><i class="fa fa-list-ul"></i></a></td>

        </tr>
        <?php
            }

            ?>


        </tbody>
    </table>

</div>