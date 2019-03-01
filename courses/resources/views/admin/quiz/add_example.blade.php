@extends('admin/layouts.adminDashboard');
@section('content')

    <h3>Add Exam</h3>
    <div class="show_error"></div>
    <input type="hidden" id="form_uniq" value="save_quiz_1">
    <div class="admin_main_content">
        <div class="question_main copy_div">
            <form method="POST" class="" id="exam_form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="formGroupExampleInput">Subjects</label>
                    <select name="subject_id" id="subject_id" class="form-control ">
                        <option value="">Select subject type</option>
                        <?php
                        if(!empty($subjects)){
                        foreach ($subjects as $val){ ?>
                        <option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Name</label>
                    <input type="text" class="form-control" name="exam_name" placeholder="">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Description</label>
                    <textarea name="description" class="form-control" style="resize: none;height: 166px;width: 656px;"></textarea>
                </div>
                <button type="button" class="btn btn-primary  save_exam">Save</button>
            </form>
        </div>
    </div>
@endsection
