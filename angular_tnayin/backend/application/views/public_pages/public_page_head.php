<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="en">
    <meta name="description" content="<?php echo $inf['meta_desc']; ?>">
    <meta name="keywords" content="<?php echo $inf['meta_keywords']; ?>">
    <title><?php echo $inf['title']; ?></title>
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico')?>" type="images/x-icon">
    <!--  <link rel="shortcut icon" href="<?php /*echo base_url('assets/images/favicon.png');*/?>">-->
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/frontend/main_1.2.css');?>">

    <style>
        html, body {
            height:100%;
        }
    </style>

    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/js/frontend/if.ie.top.js'); ?>"></script>

    <![endif]-->
    <script type="text/javascript">
        base_url = '<?php echo base_url(); ?>';
        action = '<?php echo $this->router->fetch_method(); ?>';
        us_id = <?php echo (!empty($us_id))?$us_id:0; ?>
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC36B3BK5OaEmBOADTokWJlAfgpNnC6JmU"></script>
</head>