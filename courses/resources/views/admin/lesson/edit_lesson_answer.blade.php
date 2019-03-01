<div class="admin_main_content">
    <form method="POST" id="edit_lesson_form">

        @if(!empty($all_lesson))
        @foreach($all_lesson as  $index => $single)

        {{ csrf_field() }}
        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" class="form-control" id="" placeholder="" name="name[{{$single['id']}}]" value="{{$single['name']}}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">title</label>
            <input type="text" class="form-control" id="" placeholder="" name="title[{{$single['id']}}]" value="{{$single['title']}}">
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Lesson Type</label>
            <select name="lesson_type[{{$single['id']}}]" id="" class="form-control">
                {{$k = ($single['type'] == 1)?'selected':''}}
                {{$m = ($single['type'] == 2)?'selected':''}}
                <option value="">Select lesson type</option>
                <option {{$k}} value="1">Text</option>
                <option {{$m}} value="2">video</option>
            </select>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Subject branch</label>
            <select name="subject_type_id[{{$single['id']}}]" id="" class="my_select_class">
                <?php
                if(!empty($subject_type)){
                foreach ($subject_type as $index => $val){ ?>
                <option value="<?php echo $val->id;?>"><?php echo $val->name; ?></option>
                <?php } } ?>

            </select>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Lesson Time</label>
            <input type="text" name="lesson_time[{{$single['id']}}]" class="form-control not_string" value="{{$single['lesson_time']}}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Lesson Status</label>
            {{$a = ($single['status'] == 1)?'selected':''}}
            {{$b = ($single['status'] == 2)?'selected':''}}
            <select name="status[{{$single['id']}}]" id="" class="form-control">
                <option {{$a}} value="1">For Free</option>
                <option {{$b}} value="2">For Premium</option>
            </select>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Lesson Text</label>
            <textarea class="form-control" name="lesson_text[{{$single['id']}}]">{{$single['lesson_text']}}</textarea>
        </div>
       {{-- <div class="form-group" id="lesson_video_upload">
            <label for="lesson_video">lesson Video

                <p class="lesson_video">UPLOAD</p>
            </label>
            <input type="file" class="form-control" id="lesson_video" name="lesson_video">
        </div>--}}
        {{--      <div class="form-group" id="lesson_image">
                  <label for="formGroupExampleInput">Lesson Image</label>
                  <div class="dz-message needsclick">
                      <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                  </div>
              </div>--}}
{{--        <div class="form-group">
            <div class="container">
                <div class="">
                    <label>Lesson Image</label>
                    <div class="drop_upload dz-clickable" id="drop">
                        <div class="dz-message needsclick">
                            <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>--}}
        @endforeach
            <button type="button" class="btn btn-primary save_updated_lesson">Save</button>
        @endif
    </form>
</div>