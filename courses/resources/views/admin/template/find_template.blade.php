@extends('admin/layouts.adminDashboard');

@section('content')
    <form method="POST" id="find_template">
        {{ csrf_field() }}
        <div class="form-group col-md-7">
            <label for="formGroupExampleInput">Choose page</label>
            <select name="" class="form-control text-center" id="find_url_select">
                @foreach($templates as $index => $value)
                    <option value="{{$value['id']}}">{{$value['title']}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
         <button type="button" class="btn btn-primary find_url">Find</button>
        </div>
    </form>

    <div class="html_builder_main_answer">

    </div>
@endsection