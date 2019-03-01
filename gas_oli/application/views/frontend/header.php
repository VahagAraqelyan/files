<header>

    <?php

    if($this->ion_auth->logged_in()){ ?>
    <nav class="rad-navigation">
        <div class="content">
            <div class="flex_item_1">
                <a href="#" class="rad-toggle-btn pull-right">
                    <i class="material-icons dp48 left">menu</i>
                </a>

                <div class="search_wrapper">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." aria-label="Username"
                               aria-describedby="basic-addon1">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex_item_2">
                <div class="notification-icon right">
                    <i class="material-icons dp48">email</i>
                    <span class="num-count">2</span>
                </div>

                <div class="notification-icon right">
                    <i class="material-icons dp48">notifications</i>
                    <span class="num-count">13</span>
                </div>
                <div class="notification-icon right">
                    <a href="<?php echo base_url('crew/logout')?>">Logout</a>
                </div>
                <?php
                $user = $this->ion_auth->user()->row();
                ?>
                <div class="profile">
                    <span class="first-name right"><?php echo $user->first_name.' '.$user->last_name;?> <i class="fas fa-chevron-down"></i></span>
                </div>
            </div>
        </div>
    </nav>
    <?php }else{ ?>
        <aside>
            <div class="rad-sidebar rad-nav-min">
                <div class="content">
                </div>
            </div>
        </aside>
    <?php }  ?>
</header>