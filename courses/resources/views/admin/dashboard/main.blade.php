@extends('admin/layouts.adminDashboard');
@section('content')

    <div class="search">

        <div class="form-group col-md-3">
            <input type="month" class="chart_date form-control" min="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="form-group col-md-3">

            <button class="search_statistic btn-default ">Search</button>
        </div>
    </div>
    <div class="statistic_answer">
    </div>
@endsection

