<?php
$this->statistic->insert_statistic();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <title></title>
    <link rel="icon" href="">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/frontend/main.css');?>">

    <style>
        html, body,.content_main_container {
            height:100%;
        }
    </style>
    <?php
    $language = $this->language_lib->switch_language();

    ?>
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/js/frontend/if.ie.top.js'); ?>"></script>

    <![endif]-->
    <script type="text/javascript">
        lang = '<?php echo $language; ?>';
        base_url = '<?php echo base_url(); ?>';
        action = '<?php echo $this->router->class.'->'.$this->router->method; ?>';
    </script>

</head>
