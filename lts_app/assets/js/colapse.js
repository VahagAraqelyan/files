


function colapse_close(event_id, icon_id) {

    $(event_id).on('hidden.bs.collapse', function () {
        $(icon_id).addClass('fa-angle-down');
        $(icon_id).removeClass('fa-angle-up');

    });

    $(event_id).on('shown.bs.collapse', function () {
        $(icon_id).addClass('fa-angle-up');
        $(icon_id).removeClass('fa-angle-down');

    });
    
    
}

colapse_close('#sender_and_pick_up','#colapse_icon_sender');
colapse_close('#receiver_delivery','#colapse_icon_receiver');
colapse_close('#payment_information','#colapse_icon_payment');
colapse_close('.item_list_passport','#item_list_i');
colapse_close('#pickup_confirmation','#pick_up_colapse');
colapse_close('#shipping_tracking','#shipping_tracking_colapse');
