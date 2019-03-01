@extends('layouts.app')

@section('content')

<main>
    <section class="exam_test_head">
        <div class="content">
            <div class="exam_and_part_number">
                <h4>{{$exam['name']}}</h4>
               {{-- <h5>PART 1</h5>--}}
                <div class="border"></div>
            </div>
            <div class="duration">
                <h3 id=time><span class="minutes">25</span>:<span class="second">00</span></h3>
                <div id="container">
                    <div id="inputArea"></div>
                </div>
                <button type="button" class="start_quiz"></button>
            </div>
        </div>
    </section>

    <section class="exam_test_choose">
        <div class="content">
            <form action="" id="example_form">
                <div class="row exam_main dis_none">
                    <div class="answer_info" id="answer_info"></div>
                    <input type="hidden" name="exam_id" id="exam_id" value="{{$exam['id']}}">
                    @foreach($quizes as $index => $value)
                            @if($index%2 == 0)
                                <div class="col-md-6">
                                    <div class="exam_test">
                                        <div class="number_of_exam"><span>1</span></div>
                                        <div class="question">
                                            <h3>
                                                <img src="{{ asset('quiz_images/'.$value->quiz_name)}}" alt="">
                                            </h3>
                                            <ul>
                                                @foreach($value->answer as $answer_index => $answer)
                                                    <li class="example_li">
                                                        <input type="radio" class="check_result_radio" name="result_{{$answer_index+1}}" value="{{$value->id.'->'.$answer->id}}">
                                                        {{$answer_index+1}}) {{$answer->answer}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        @else
                              <div class="col-md-6">
                                  <div class="exam_test">
                                      <div class="number_of_exam"><span>1</span></div>
                                      <div class="question">
                                          <h3>
                                              <img src="{{ asset('quiz_images/'.$value->quiz_name)}}" alt="">
                                          </h3>
                                          <ul>
                                              @foreach($value->answer as $answer_index => $answer)
                                                  <li class="example_li">
                                                      <input type="radio" class="check_result_radio" name="result_{{$value->id}}" value="{{$value->id.'->'.$answer->id}}">
                                                      {{$answer_index+1}}) {{$answer->answer}}
                                                  </li>
                                              @endforeach
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                            @endif
                    @endforeach
                    <div class="line"></div>
                    <div class="row">
                        <div class="col-md-12 load_and_finish">
                            <a href="#" id="loadMore"><i class="fas fa-chevron-down"></i></a>
                            <button type="button" class="finish" disabled="disabled">Finish</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

@endsection