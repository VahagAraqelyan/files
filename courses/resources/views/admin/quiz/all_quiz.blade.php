@extends('admin/layouts.adminDashboard');
@section('content')
<?php
$type_arr = [
    0 => '',
    1 => 'For lesson',
    2 => 'For training room',
];
$right_answ = '';
?>
    <div class="content well_content">
        <table id="driver_list" class=" table table-bordered table-hover designed-table">
            <thead>
            <tr>
                <th class="order-number"><small>Edit/Delete</small></th>
                <th class="order-number"><small>Right Answer</small></th>
                <th class="order-number"><small>Name</small></th>
                <th class="order-number"><small>Quiz Type</small></th>
                <th class=""><small>#</small></th>
            </tr>
            </thead>
            <tbody>
            @foreach($quiz as $index => $val)
                @foreach($val['answer'] as $answer_val)
                   <?php
                   $right_answ = ($val['right_answer_id'] ==$answer_val['id'])?$answer_val['answer']:$right_answ;
                   ?>
                 @endforeach
            <tr>
                <td>  <div class="my-form-group">
                        <button type="button" class="edit_lesson btn btn-primary edit_quiz" style="margin-left: 5px" data-id="{{$val['id']}}">Edit</button>
                        <button type="button" class="delete_lesson btn btn-primary delete_quiz" {{$val['id']}}>Delete</button>
                    </div>
                </td>
                <td>@if($right_answ){{$right_answ}}@endif</td>
                <td><img src="{{ asset('quiz_images/'.$val['quiz_name'])}}" alt="" style="width: 50px;height: 50px"></td>
                <td>{{$type_arr[$val['status']]}}</td>
                <td>{{$index+1}}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<div class="modal fade" id="edit_quiz_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="message"></div>
            <div class="modal-body edit_quiz_answer">
            </div>
        </div>
    </div>
</div>
@endsection