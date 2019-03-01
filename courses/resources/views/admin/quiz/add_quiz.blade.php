@extends('admin/layouts.adminDashboard');
@section('content')
        <h3>Add Quiz</h3>
        <div class="show_error"></div>
        <input type="hidden" id="form_uniq" value="save_quiz_1">
        <div class="admin_main_content">
        <div class="question_main copy_div">
        <form method="POST" class="quiz_form_1">
            <input type="hidden" name="name" id="image_name" value="">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="formGroupExampleInput">Quiz Type</label>
                <select name="quiz_type" id="quiz_type" class="form-control">
                    <option value="">Select quiz type</option>
                    <option value="1">For lesson</option>
                    <option value="2">For training room</option>
                </select>
            </div>
            <div class="form-group dis_none subject_main">
                <label for="formGroupExampleInput">Exam</label>
                <select name="" id="quiz_type" class="form-control ">
                    <option value="">Select exam type</option>
                    <?php
                        if(!empty($example)){
                            foreach ($example as $val){ ?>
                            <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
                        <?php } } ?>

                </select>
            </div>

            <div class="form-group lesson_main">
                <label for="formGroupExampleInput">Lesson</label>
                <select name="lesson" id="" class="form-control">
                    <option value="">Select Lesson</option>
                    <?php
                    if(!empty($lesson)){

                    foreach ($lesson as $index => $val){ ?>
                    <option value="<?php echo $val->id;?>"><?php echo $val->name; ?></option>
                    <?php } } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Question</label>
                <input type="file" class="form-control" id="question_file" placeholder="">
            </div>
            <div class="form-group answer_multi">
                <label for="formGroupExampleInput">Answer</label>
                <input type="text" class="form-control"  placeholder="" name="answer[]">
                <input type="radio" name="right_answer" value="1">
            </div>
            <div class="form-group answer_multi">
                <label for="formGroupExampleInput">Answer</label>
                <input type="text" class="form-control"  placeholder="" name="answer[]">
                <input type="radio" name="right_answer" value="2">
            </div>
            <div class="form-group answer_multi">
                <label for="formGroupExampleInput">Answer</label>
                <input type="text" class="form-control"  placeholder="" name="answer[]">
                <input type="radio" name="right_answer" value="3">
            </div>
            <div class="form-group answer_multi">
                <label for="formGroupExampleInput">Answer</label>
                <input type="text" class="form-control" placeholder="" name="answer[]">
                <input type="radio" name="right_answer" value="4">
            </div>
            <div class="append_answer_main">
            <span class="plus">+</span>
            </div>
            <button type="button" class="btn btn-primary  save_quiz save_quiz_1">Save</button>
        </form>
        </div>
            <div class="new_question"></div>
        <button type="button" class="btn btn-primary add_new_question">Add a new question</button>
            <br>
            <br>
        <button type="button" class="btn btn-primary save_all">Save All</button>
    </div>
@endsection
