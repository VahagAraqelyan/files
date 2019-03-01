<?php
$url = $app->make('url')->to('/');
$url = str_replace('public','',$url);
?>
<div style="float: none;clear: both" id="search_answer">
    @foreach($prod as $single)
        <div class="card" style="width:30%;float: left;margin-right: 13px;">
            <img class="card-img-top" src="{{$url.'/storage/app/'.$single['image']}}" alt="Card image" style="width:100%">
            <div class="card-body">
                <h4 class="card-title">{{$single['name']}}</h4>
            </div>
        </div>
    @endforeach
</div>