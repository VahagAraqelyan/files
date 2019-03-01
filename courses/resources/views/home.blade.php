@extends('layouts.dashboard')

@section('content')

    <main class="dashboard_main">
        <div class="toolbar">
            <div class="input-group mb-3">
               {{-- <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                       aria-describedby="basic-addon1">--}}
            </div>
            <div class="flex_cont_1">
                <div class="go_to">
                    <a href="{{url('training_room')}}" class="training_room">Go to training room <i
                                class="fas fa-long-arrow-alt-right"></i></a>
                </div>
                <div class="logout">
                    <ul>
                        <li>
                           <div class="user_image">
                               @if(!empty(Auth::user()->user_avatar))
                               <img src="{{asset('user/'.Auth::user()->id.'/'.Auth::user()->user_avatar)}}" class="img-circle" alt="Avatar">
                               @else
                                   <div class="user_image">
                                       <img id="photo-upload-preview" src="{{'img/no-profile-pic.png'}}">
                                   </div>
                               @endif
                            </div>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="dropdown_link"> {{ Auth::user()->name }}<i class="fas fa-sort-down"></i></button>
                                <div class="dropdown_menu">
                                    <a class="dropdown_item" href="{{url('profile')}}">Profile</a>
                                    <a class="dropdown_item" href="{{url('change_plan')}}"> Go Premium</a>
                                    <a class="dropdown_item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </div>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbra_toggle">
                <div>
                    <span>
                        <i class="fas fa-bars"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="admin__main">

           <h2 class="default_text text-center">Welcome!</h2>
            <?php

            if(!empty($subject_type)){
                foreach ($subject_type as $sub){ ?>

            <div id="{{$sub->name}}" class="tabcontent">
                <div class="row">
                    <div class="col-md-3">
                        <div class="lessons">
                            <h2 dir="rtl">{{$sub->name}}</h2>
                            <div class="number_of_lessons">
                                <p dir="rtl">{{--{{count($lesson)}} lessons--}}
                                    <span>
                                    <span data-id="{{$sub->id}}" data-asc="ASC" class="sort_less"><img src="{{'img/sorting.png'}}" alt=""></span>
                                   {{-- <span><img src="{{'img/tag.png'}}" alt=""></span>
                                    <span><img src="{{'img/more.png'}}" alt=""></span>--}}
                                </span>
                                </p>
                            </div>

                            <div class="lessons_sequence lessons_sequence_answer">
                                <?php

                                if(!empty($lesson)){
                                foreach ($lesson as $index => $value){
                                    if($value['subject_type_id'] != $sub->id){
                                        continue;
                                    }

                                    if($value['status'] == 1 && Auth::user()->payment_charge == 1){
                                        continue;
                                    }

                                    ?>

                                    <ul class="tablinks" onclick="opencourse(event, '{{$value['subject_type'][0]['name']}}', '{{$value['id']}}')">
                                        <li>
                                            {{--start lesson--}}
                                        </li>
                                              <li>
                                            <h3 dir="rtl">{{ $value['name']}}</h3>
                                            <p class="course_title">{{ $value['title']}}</p>
                                        </li>
                                       {{-- <li>
                                            <div class="duration">
                                                <p dir="rtl"><i class="far fa-clock"></i> {{ $value['lesson_time']}} m. </p>
                                            </div>
                                        </li>--}}
                                    </ul>

                                    <?php } } ?>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php
                        if(!empty($lesson)){

                        foreach ($lesson as $index => $value){
                        if($value['subject_type_id'] != $sub->id){
                            continue;
                        }
                        ?>
                            <input type="hidden" id="less_id" value="{{$value['id']}}">
                        <div id="less_{{$value['id']}}" class="tabcontent">
                            <div class="lesson_content audion_and_video_lessons">
                                <div class="lessons_header">
                                    <h2 dir="rtl">{{ $value['title']}}
                                      {{--  <button class="expand"><img src="{{'img/frame-icon.png'}}" alt=""></button>--}}
                                    </h2>
                                    <h1 dir="rtl">{{ $value['name']}}</h1>
                                </div>
                                    <div class="lessons_body">
                                        <div class="video_overview">

                                            <ul role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active tablinks"
                                                       onclick="opencourse(event, '{{$value['subject_type'][0]['name']}}', '{{$value['id']}}',  'quiz')">Quiz</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link active tablinks"
                                                       onclick="opencourse(event, '{{ $value['subject_type'][0]['name']}}', '{{$value['id']}}', 'video')">Video</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active tablinks"
                                                       onclick="opencourse(event, '{{ $value['subject_type'][0]['name']}}', '{{$value['id']}}', 'overview' )">Text</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tabcontent" id="overview">
                                            <div class="row">
                                               <div class="col-md-10">

                                                   @foreach($value['lesson_img'] as $img_val)

                                                    <img src="{{ asset('images/'.$img_val['image_name'])}}" alt="">
                                                   @endforeach
                                                    <?php
                                                    echo  $value['lesson_text'];
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tabcontent" id="video">
                                           <div class="video_curses">
                                                @if($value['type'] == 2)
                                                <video style="width: 560px; height:315px; margin: 0 auto; display: block;" controls  class="bg-video__media">
                                                    <source src="{{ asset('videos/'.$value['lesson_video'])}}" type="video/webm">
                                                </video>
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="tabcontent" id="quiz">
                                            <div class="accordion" id="accordionExample">
                                                <div class="answer_info" id="answer_info"></div>
                                                <?php
                                                if(!empty($quiz)){

                                                foreach ($quiz as $quiz_index => $quiz_val){

                                                if($quiz_val->lesson_id == $value['id']){ ?>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>
                                                            <button class="btn btn-link collapsed"><img src="{{ asset('quiz_images/'.$quiz_val->quiz_name)}}" alt=""></button>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                        if(!empty($answer)){

                                                        foreach ($answer as $answer_index => $answer_value){
                                                        if($answer_value->quiz_id == $quiz_val->id){ ?>
                                                        <div class="col-md-6">
                                                            <label class="container_radio">{{$answer_index+1 .' )'.' '.$answer_value->answer}}
                                                                <input style="display: inline;" class="check_result_radio" type="radio" name="result_{{$quiz_index+1}}" value="{{$quiz_val->id.'->'.$answer_value->id}}">
                                                                <span class="checkmark"></span>
                                                            </label>

                                                        </div>
                                                        <?php }  } }
                                                        ?>
                                                        <br class="clear">
                                                    </div>
                                                    <br class="clear">

                                                </div>
                                                <br class="clear">
                                                <?php } }
                                                $bool = true;
                                                foreach ($quiz as $quiz_index => $quiz_val){

                                                if($quiz_val->lesson_id == $value['id']){

                                                    ?>
                                                <button type="button" class="btn btn-success  check_result">See the results</button>
                                                   <?php break; } } ?>
                                                 <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                            <?php } } ?>
                    </div>
                </div>
            </div>
                <?php } } ?>
        </div>
    </main>
@endsection
