<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{asset('css')}}/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css')}}/main.css">
</head>
<script>
    base_url = "<?php echo $app->make('url')->to('/');?>";
</script>
<body>
<ul class="navigation">
    <li><a href="<?php echo $app->make('url')->to('/');?>">Home</a></li>
    <li><a href="<?php echo $app->make('url')->to('/');?>/add_file">Upload File</a></li>
</ul>
<div>
    <input type="text" placeholder="Search" id="search">
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
</div>
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

<footer>
    <script src="{{asset('js')}}/jquery-3.1.0.min.js"></script>
    <script src="{{asset('js')}}/bootstrap.min.js"></script>
    <script src="{{asset('js')}}/bootbox.min.js"></script>
    <script src="{{asset('js')}}/ajax_lib.js"></script>
    <script src="{{asset('js')}}/main.js"></script>
</footer>
</body>
</html>