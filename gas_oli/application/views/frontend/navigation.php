

<?php

if($this->ion_auth->logged_in()){ ?>
    <aside>
        <div class="rad-sidebar rad-nav-min">
            <ul>
                <li>
                    <a href="<?php echo base_url('crew/filter')?>" class="inbox">
                        <!--<i class="fa fa-dashboard"><span class="icon-bg rad-bg-success"></span></i>-->
                        <span class="rad-sidebar-item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <!--<i class="fa fa-bar-chart-o">-->
                        <!--<span class="icon-bg rad-bg-danger"></span>-->
                        <!--</i>-->
                        <span class="rad-sidebar-item">Ticket status</span>
                    </a>
                </li>
                <li><a href="#" class="snooz"><i class="fa fa-line-chart"><span class="icon-bg rad-bg-primary"></span></i><span class="rad-sidebar-item">Call trends</span></a></li>
                <li><a href="#" class="done"><i class="fa fa-area-chart"><span class="icon-bg rad-bg-warning"></span></i><span class="rad-sidebar-item">Heat maps</span></a></li>
                <li>
                    <a href="#">
                        <!--<i class="fa fa-wrench"><span class="icon-bg rad-bg-violet"></span></i>-->
                        <span class="rad-sidebar-item">Settings</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>
<?php }else{ ?>
    <aside>
        <div class="rad-sidebar rad-nav-min">

        </div>
    </aside>
<?php }  ?>