@extends('layouts.app')

@section('content')
    <main>
        <section class="pricing_plan plan_single_page">
            <div class="top_image">
                <img src="{{ asset('img/pricing_plan.png') }}" alt="">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section_title">
                            <h2>Choose plan</h2>
                        </div>
                    </div>
                    <?php
                        if(!empty($plans)){
                                $class = '';
                            foreach ($plans as $index => $val){
                                $class = ($index%2 == 0)?'gradient_bg':'';
                                ?>
                                <div class="col-md-6">
                                    <div class="plan <?php echo $class;?>">
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
                                            @guest
                                               <?php
                                                if(empty($val->price)){ ?>
                                                   <a href="{{ url('/get_plan/'.$val->id.'/register')}}">
                                                       Sign up for free
                                                   </a>
                                                <?php }else{ ?>
                                                   <a href="{{ url('/get_plan/'.$val->id.'/register')}}">
                                                       Sign Up and Get started
                                                   </a>
                                                <?php } ?>
                                            @else
                                                <?php
                                                if(empty($val->price)){ ?>
                                                <a href="{{ url('/get_plan/'.$val->id.'/aaa')}}">
                                                     for free
                                                </a>
                                                <?php }else{ ?>
                                                <a href="{{ url('/get_plan/'.$val->id.'/aaa')}}">
                                                   Get started
                                                </a>
                                                <?php } ?>
                                            @endguest

                                        </div>
                                    </div>
                                </div>
                            <?php } } ?>
                </div>
            </div>
        </section>
    </main>
@endsection
