<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <title>Luggage to Ship</title>
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico')?>" type="images/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/backend/main.css');?>">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/js/backend/if.ie.top.js'); ?>"></script>
    <![endif]-->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">

        <?php
        $this->load->library('Admin_security');
        $admin_dir = $this->admin_security->admin_dir();
        ?>
        base_url='<?php echo base_url($admin_dir); ?>';
        front_base_url='<?php echo base_url(); ?>';
        customer_list_row_count = 3;
        us_id = <?php echo (!empty($us_id))?$us_id:0; ?>
    </script>
<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>-->
</head>
