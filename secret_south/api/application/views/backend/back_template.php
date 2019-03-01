<!doctype html>
<html lang="en">
<?php

$us_id = $this->Users_model->get_us_country();

$data = array();

$perm = $this->admin_security->admin_perm();
$all_url = $this->config->item('section_url');
$data['all_perm'] = $this->config->item('all_permissions');
$data['all_url'] = $all_url;
$data['permissions'] = $perm;

if(!empty($us_id[0])) {

    $data['us_id'] = $us_id[0]['id'];
}

$new_status = [SUBMITTED_STATUS[0],SUBMITTED_CANCEL_STATUS[0]];
$processed_status = [PROCESSED_STATUS[0]];
$ready_status = [READY_STATUS[0]];
$intranzit_status = [TRANSIT_STATUS[0]];
$delivery_canseled_status = [DELIVERY_STATUS[0]];
$incomplete_statuses = [INCOMPLETE_STATUS[0]];

$new_or_where = '`status_change_by` = 0 AND `shipping_status` = "'.SUBMITTED_CANCEL_STATUS[0].'"';
$proc_or_where = '`status_change_by` = 0 AND `shipping_status` = "'.PROCESSED_CANCEL_STATUS[0].'"';
$cancle_or_where = '`status_change_by` = 1 AND (`shipping_status` = "'.PROCESSED_CANCEL_STATUS[0].'" OR `shipping_status` = "'.SUBMITTED_CANCEL_STATUS[0].'")';

$data['new_order']                = $this->Users_model->get_count_order($new_status, $new_or_where);
$data['processed_status']         = $this->Users_model->get_count_order($processed_status, $proc_or_where);
$data['ready_status']             = $this->Users_model->get_count_order($ready_status);
$data['intranzit_status']         = $this->Users_model->get_count_order($intranzit_status);
$data['delivery_canseled_status'] = $this->Users_model->get_count_order($delivery_canseled_status, $cancle_or_where);
$data['incomplete_order_count']   = $this->Users_model->get_count_order($incomplete_statuses);

$this->load->view('backend/head', $data);
?>
<body>
<?php

$this->load->view('backend/header',$data);
?>
<?php
//$this->load->view('backend/navigation');
?>
<div id="main_content">
<?php

$this->load->view($content);
?>
</div>
<?php
$this->load->view('backend/footer');
?>

</html>
