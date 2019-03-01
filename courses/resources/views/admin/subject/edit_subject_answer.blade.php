<div class="admin_main_content">
    <form action="" id="save_edit_subj_form" method="post">
        @if(!empty($subject))
            @foreach($subject as  $index => $single)
                <div class="my-form-group">
                    <div class="col-md-12 value-info">
                        <label for="">{{$single['name']}}</label>
                        <input type="text" name="subj_name[{{$single['id']}}]" value="{{$single['name']}}">
                    </div>
                </div>
            @endforeach
            <div class="my-form-group">
                <div class="col-md-12 value-info">
                    <button type="button" class="save_edit_subject btn btn-primary ">Edit Subject</button>
                </div>
            </div>
    </form>
    @endif
</div>

