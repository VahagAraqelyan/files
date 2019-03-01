@extends('admin/layouts.adminDashboard');

@section('content')
    <div class="admin_main_content">
        <form method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="formGroupExampleInput">Name</label>
                <input type="text" class="form-control" id="nameInp" placeholder="" name="nameInp">
            </div>
            <button type="button" class="btn btn-primary save_subject">Save</button>
        </form>
    </div>
@endsection
