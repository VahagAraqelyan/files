@extends('layouts.app')

@section('content')
    <div class="glob_body">
        <main>
            <section class="pricing_plan plan_single_page">
                <div class="top_image">
                    @if(Auth::user()->plan_id != 2 && Auth::user()->payment_charge == 2)
                        <img src="{{ asset('img/pricing_plan.png') }}" alt="">
                    @endif
                </div>
                <div class="content">
                    <div class="row">
                        <?php
                        if(Auth::user()->plan_id == 2 && Auth::user()->payment_charge == 2){ ?>
                        <div class="col-md-12">
                            <p>Your payment is successfully done.</p>
                            <p>  You can continue with the full version.</p>
                        </div>

                        <?php }elseif (Auth::user()->plan_id == 2 && Auth::user()->payment_charge == 1){ ?>

                            <?php
                            if(!empty($plans)){
                            $class = '';
                            foreach ($plans as $index => $val){

                            if($val->id == 2){
                            continue;
                            }

                            $class = ($index%2 == 0)?'gradient_bg':'';

                            ?>
                            <div class="col-md-12">
                                <div class="plan <?php echo $class;?> premium_plan">
                                    <div class="plan_header">
                                        <h6><?php echo $val->name; ?></h6>
                                        <h4 class="price"><?php echo empty($val->price)?'Free':'$'.$val->price; ?></h4>
                                        <p><?php echo (!empty($val->limit_count))?$val->limit_count.' time':$val->mounth_count.' month' ?></p>
                                    </div>
                                    <div class="plan_body">
                                        <ul>
                                            <li class="active"><p><i class="fas fa-check-circle"></i> <?php echo $val->lesson_count;?> lessons</p></li>
                                            <li><p><i class="fas fa-check-circle"></i> <?php echo $val->typical_task;?> typical tasks</p></li>
                                            <li><p><i class="fas fa-check-circle"></i> <?php echo $val->video_hours; ?> hours video course</p></li>
                                            <li><p><i class="fas fa-check-circle"></i> <?php echo $val->individual_lesson; ?> individual lessons</p></li>
                                        </ul>
                                    </div>
                                    <div class="plan_footer">

                                        <div class="plan_footer">
                                            <a href="#" class="no_href charge_modal_show_btn">Make a payment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } } }

                        else{ ?>
                        <div class="col-md-12">
                            <div class="section_title">
                                <h2>Choose plan</h2>
                            </div>
                        </div>

                        <?php
                        if(!empty($plans)){
                        $class = '';
                        foreach ($plans as $index => $val){

                        if($val->id == 2){
                            continue;
                        }

                        $class = ($index%2 == 0)?'gradient_bg':'';
                        ?>
                        <div class="col-md-12">
                            <div class="plan <?php echo $class;?> premium_plan">
                                <div class="plan_header">
                                    <h6><?php echo $val->name; ?></h6>
                                    <h4 class="price"><?php echo empty($val->price)?'Free':'$'.$val->price; ?></h4>
                                    <p><?php echo (!empty($val->limit_count))?$val->limit_count.' time':$val->mounth_count.' month' ?></p>
                                </div>
                                <div class="plan_body">
                                    <ul>
                                        <li class="active"><p><i class="fas fa-check-circle"></i> <?php echo $val->lesson_count;?> lessons</p></li>
                                        <li><p><i class="fas fa-check-circle"></i> <?php echo $val->typical_task;?> typical tasks</p></li>
                                        <li><p><i class="fas fa-check-circle"></i> <?php echo $val->video_hours; ?> hours video course</p></li>
                                        <li><p><i class="fas fa-check-circle"></i> <?php echo $val->individual_lesson; ?> individual lessons</p></li>
                                    </ul>
                                </div>
                                <div class="plan_footer">

                                    <div class="plan_footer">
                                        <a href="#" class="no_href change_premium_butt">Go Premium</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } } ?>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="charge_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="message"></div>
                <div class="modal-body change_email">
                  <div class="inf menu_success_color">
                      <p>Your payment number is 16552</p>
                      <p>Please, upload the check once done.</p>
                  </div>
                    <label for="upload" class="label">Upload New</label>
                    <input type="file" class="upload" id="upload_check">
                    <button type="button" class="btn btn-primary save_charge_check">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection