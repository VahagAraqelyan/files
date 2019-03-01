<!doctype html>
<html lang="en">
<?php
$this->load->view('admin/head');
?>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- preloader area start -->
<div id="preloader">
    <div class="loader"></div>
</div>
<!-- preloader area end -->
<!-- page container area start -->
<div class="page-container">
    <!-- sidebar menu area start -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="<?php echo base_url('admin/dashboard')?>">Logo</a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu" id="menu">
                        <li class="active">
                            <a href="<?php echo base_url('admin/dashboard/logout')?>" aria-expanded="true"><span>Logout</span></a>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Crew</span></a>
                            <ul class="collapse">
                                <li class=""><a href="<?php echo base_url('admin/steersman')?>">All Crew</a></li>
                                <li class=""><a href="<?php echo base_url('steersman/add_steersman')?>">Add Crew</a></li>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Well</span></a>
                            <ul class="collapse">
                                <li class=""><a href="<?php echo base_url('admin/get_all_wells')?>">All Well</a></li>
                                <li class=""><a href="<?php echo base_url('well/add_wells')?>">Add Well</a></li>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Company</span></a>
                            <ul class="collapse">
                                <li class=""><a href="<?php echo base_url('admin/company/all_company')?>">All Company</a></li>
                                <li class=""><a href="<?php echo base_url('admin/company/add_company')?>">Add Company</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- sidebar menu area end -->
    <!-- main content area start -->
    <div class="main-content">
        <?php
        $this->load->view($content);
        ?>
    </div>

    <?php
    if(empty($foot_buffer)) {
        $this->load->view('admin/footer');
    }else{
        $this->load->view($foot_buffer);
    }
    ?>
</body>

</html>
