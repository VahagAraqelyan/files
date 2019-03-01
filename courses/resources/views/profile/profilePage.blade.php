@extends('layouts.app')

@section('content')

    <main class="wrapper-menu">
        <div class="content">
            <div class="row">
                <div class="col-md-7">
                    <form action="" id="userProfile_info_form">
                        <div class="form-group">
                            <label for="formGroupExampleInput"> Name</label>
                            <input type="text" class="form-control" placeholder="" id="first_name"
                                   value="{{Auth::user()->name}}">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">Email address</label>
                            <a href="#" class="change_email">Change email address</a>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary save_user_info">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <form action="" id="profile_info_form">
                        <fieldset>
                            <legend class="row-title">Profile photo</legend>
                            <div class="settings-item">
                                <div id="photo">
                                    <div class="ProfilePhoto">
                                        <div class="photo-selector two-column">
                                            <div class="photo-preview left">
                                                @if(empty(Auth::user()->user_avatar))
                                                    <img id="photo-upload-preview" src="{{'img/no-profile-pic.png'}}">
                                                @else
                                                    <img id="photo-upload-preview"
                                                         src="{{asset('user/'.Auth::user()->id.'/'.Auth::user()->user_avatar)}}">
                                                @endif
                                            </div>
                                            <div class="row">
                                                 <div class="form-group col-md-6">
                                                <div class="preview">
                                                    {{--<label for="upload" >Choose File</label>--}}
                                                    {{--<input type="file"  id="upload" class="upload" />--}}
                                                    {{----}}
                                                    <label for="upload" class="label">Upload New</label>
                                                    <input type="file" class="form-control-file upload" id="upload_profile_photo" name="upload">
                                                </div>
                                            </div>
                                                 <div class="form-group col-md-6">
                                                <label for="formGroupExampleInput"></label>
                                                <button type="button" class="btn btn-secondary remove_img">Remove</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>
        </div>
        {{--<div class="panel">--}}
        {{--<div class="page-header">--}}
        {{--<h1>Profile</h1>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
        {{--<form action="" id="profile_info_form">--}}
        {{--<fieldset>--}}
        {{--<legend class="row-title">Profile photo</legend>--}}
        {{--<div class="settings-item">--}}
        {{--<div id="photo">--}}
        {{--<div class="ProfilePhoto">--}}
        {{--<div class="photo-selector two-column">--}}
        {{--<div class="photo-preview left">--}}
        {{--@if(empty(Auth::user()->user_avatar))--}}
        {{--<img id="photo-upload-preview" src="{{'img/no-profile-pic.png'}}">--}}
        {{--@else--}}
        {{--<img id="photo-upload-preview"--}}
        {{--src="{{asset('user/'.Auth::user()->user_avatar)}}">--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--<div class="form-group col-md-6">--}}
        {{--<label for="formGroupExampleInput">Upload New</label>--}}
        {{--<input type="file" class="form-control-file" id="upload_profile_photo">--}}
        {{--</div>--}}
        {{--<div class="form-group col-md-6">--}}
        {{--<label for="formGroupExampleInput"></label>--}}
        {{--<button type="button" class="btn btn-secondary remove_img">Remove</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</fieldset>--}}
        {{--<div class="form-group col-md-4">--}}
        {{--<label for="formGroupExampleInput"> Name</label>--}}
        {{--<input type="text" class="form-control" placeholder="" id="first_name"--}}
        {{--value="{{Auth::user()->name}}">--}}
        {{--</div>--}}
        {{--<div class="form-group col-md-9">--}}
        {{--<label for="formGroupExampleInput">Email address</label>--}}
        {{--<a href="#" class="change_email">Change email address</a>--}}
        {{--</div>--}}
        {{--<div class="form-group col-md-9">--}}
        {{--<button type="button" class="btn btn-secondary save_user_info">Save</button>--}}
        {{--</div>--}}
        {{--</form>--}}

        {{--</div>--}}
        {{--<div class="clear"></div>--}}
        {{--</div>--}}
        {{--<div class="clear"></div>--}}
    </main>

    <div class="modal fade" id="change_email_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Check Password</h4>
                </div>
                <div class="message"></div>
                <div class="modal-body change_email">
                    <input type="password" name="password" id="password">
                    <button type="button" class="btn btn-default check_password">Check</button>
                </div>
            </div>
        </div>
    </div>
@endsection