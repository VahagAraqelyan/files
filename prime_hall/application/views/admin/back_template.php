<!doctype html>
<html lang="en">
<?php
$this->load->view('admin/head');
?>
<body>
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('admin/dashboard')?>"><img src="<?php echo  base_url('assets/images/logo.png')?>" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="<?php echo  base_url('admin/dashboard')?>"> <i class="menu-icon fa fa-dashboard"></i>Գլխավոր </a>
                </li>

                <li>
                    <a href="<?php echo  base_url('menu/menu')?>"><i class="menu-icon fa fa-th"></i>Խմբագրել Մենյուն </a>
                </li>
                <li class="">

                    <a href="<?php echo base_url('adm_gallery')?>"><i class="menu-icon fa fa-th"></i>Լուսանկարներ </a>
                </li>
                <li>
                    <a href="<?php echo  base_url('reservetion')?>"><i class="menu-icon fa fa-tasks"></i>Ամրագրում</a>
                </li>

                <li>
                    <a href="<?php echo  base_url('special_offer')?>"><i class="menu-icon fa fa-tasks"></i>Հատուկ առաջարկներ</a>
                </li>
                <?php
                $this->load->model("Admin_model");
                $crt = ['id'=>$this->session->admin_id];
                $admin = $this->Admin_model->get_all_admins(true,$crt);
                if($admin[0]['root_admin'] == 1){ ?>
                    <li>
                        <a href="<?php echo  base_url('admin/get_admin')?>"><i class="menu-icon fa fa-tasks"></i>Ադմիններ</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo  base_url('admin/edit_profile')?>"><i class="menu-icon fa fa-tasks"></i>Փոփոխել տվյալները</a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header">

        <div class="header-menu">

            <div class="col-sm-7">
                <a id="menuToggle" class="menutoggle pull-left"><i  style="line-height: 43px" class="fa fa fa-tasks"></i></a>
            </div>
        </div>

    </header><!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Գլխավոր</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Գլխավոր</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <?php
            $this->load->view($content);
        ?>
    </div>
</div><!-- /#right-panel -->

<!-- Right Panel -->




<?php
if(empty($foot_buffer)) {
    $this->load->view('admin/footer');
}else{
    $this->load->view($foot_buffer);
}
?>

</body>

</html>
