@extends('admin/layouts.adminDashboard');

@section('content')
    <div class="admin_main_content">
        <div class="show_error">

        </div>
        <form method="POST" id="add_user_form">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="formGroupExampleInput">Name</label>
                <input type="text" class="form-control"  placeholder="" name="name">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Email</label>
                <input type="email" class="form-control"  placeholder="" name="email">
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput">Password</label>
                <input type="password" class="form-control"  placeholder="" name="password">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Shcool year</label>
                <input type="text" class="form-control" placeholder="" name="shcool_year">
            </div>

            <button type="button" class="btn btn-primary save_user">Save</button>
        </form>
    </div>
@endsection
