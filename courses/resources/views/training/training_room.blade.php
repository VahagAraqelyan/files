@extends('layouts.app')

@section('content')

    <div class="toolbar training_toolbar">
{{--        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                   aria-describedby="basic-addon1">
        </div>--}}

        <div class="flex_cont_1">
            <div class="go_to">
                <a href="#" class="training_room">Go to training room <i
                            class="fas fa-long-arrow-alt-right"></i></a>
            </div>
            <div class="logout">
                <ul>
                    <li>
                        @if(!empty(Auth::user()->user_avatar))
                        <div class="user_image">
                            <img src="{{asset('user/'.Auth::user()->id.'/'.Auth::user()->user_avatar)}}" class="img-circle" alt="Avatar">
                        </div>
                            @else
                            <div class="user_image">
                                <img id="photo-upload-preview" src="{{'img/no-profile-pic.png'}}">
                            </div>

                         @endif
                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="dropdown_link"> {{Auth::user()->name}}<i class="fas fa-sort-down"></i></button>
                            <div class="dropdown_menu">
                                <a class="dropdown_item" href="#">Profile</a>
                                <a class="dropdown_item" href="#">Personal Settings</a>
                                <a class="dropdown_item" href="#"> Go Premium</a>
                            </div>
                        </div>
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
<main>
    <section class="training_room_header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="room_section_title">
                        <h1>Training room</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="training_room_content">
        <div class="content">

            @foreach($subjects as $index => $value)

                @if($value->training_exam->count()<=0)
                    @continue;
                @endif
                <div class="exam">
                    <ul class="exams_number">
                        <li>
                            <h1>EXAM {{$index+1}}</h1>
                        </li>
                    </ul>

                    <div class="perspective-200">
                        <ul class="list_question">
                            @foreach($value->training_exam as $quiz_index => $quiz_val)
                                <li><h4><a href="{{url('example/'.$quiz_val->id)}}">PART {{$quiz_index+1}} <span>({{$quiz_val->count()}} questions with 25 min limit)</span></a></h4></li>
                            @endforeach
                        </ul>
                        <div class="number_of_questions">
                            <p><span>25/</span><span>25</span></p>
                        </div>
                    </div>

                </div>
            @endforeach
            <a href="#" id="loadMore"><i class="fas fa-chevron-down"></i></a>
        </div>
    </section>
</main>
@endsection