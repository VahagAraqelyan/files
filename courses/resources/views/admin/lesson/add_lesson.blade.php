@extends('admin/layouts.adminDashboard');

@section('content')
    <div class="admin_main_content">
        <form method="POST" id="add_lesson_form">
            <div class="show_error">

            </div>
            <input type="hidden" id="image_name" name="image_name" value="" >
            <input type="hidden" id="video_name" name="video_name" value="" >
            {{ csrf_field() }}
            <div class="form-group">
                <label for="formGroupExampleInput">Name</label>
                <input type="text" class="form-control" id="" placeholder="" name="name">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">title</label>
                <input type="text" class="form-control" id="" placeholder="" name="title">
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput">Lesson Type</label>
                <select name="lesson_type" id="lesson_type" class="form-control">
                    <option value="1">Text</option>
                    <option value="2">video</option>
                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Subject branch</label>
                <select name="subject_type_id" id="" class="form-control">
                    <?php
                    if(!empty($subject_type)){

                    foreach ($subject_type as $index => $val){ ?>
                    <option value="<?php echo $val->id;?>"><?php echo $val->name; ?></option>
                    <?php } } ?>

                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Lesson Status</label>
                <select name="status" id="" class="form-control">
                    <option value="1">For Free</option>
                    <option value="2">For Premium</option>
                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Lesson Text</label>
                <textarea name="" id="lesson_text"></textarea>
            </div>
            <div class="form-group" id="lesson_video_upload">
                <input type="file" class="form-control" id="lesson_video" name="lesson_video">
                <label for="lesson_video">lesson Video

                <p class="lesson_video">UPLOAD</p></label>
                <div class="lds-dual-ring dis_none"></div>
            </div>
            <div class="form-group upload_progressbar" id="upload_progressbar">
                <div class="progressbar">
                    <div class="procent">
                        <span class="proc_span"></span>
                    </div>
                </div>
            </div>
            <div class="container drop_upload_pic">
                <div>
                    <label>Lesson Image</label>
                    <div class="drop_upload dz-clickable" id="drop">
                        <div class="plus_jpg">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>

                        <div class="dz-message needsclick">
                            <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

            </div>
            <button type="button" class="btn btn-primary save_lesson">Save</button>
        </form>
    </div>
@endsection
