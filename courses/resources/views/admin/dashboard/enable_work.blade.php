@extends('admin/layouts.adminDashboard');
@section('content')

    <div class="form-group col-md-5">
        <select name="" class="form-control text-center" id="enable_disable_work">
            <?php
            $k = ($enable_disable['enabling'] == 1)?'selected':'';
            $m = ($enable_disable['enabling'] == 2)?'selected':'';

            ?>
            <option {{$k}} value="1">Disable</option>
            <option {{$m}} value="2">Enable</option>
        </select>
    </div>

@endsection

