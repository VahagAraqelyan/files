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

<div class="container">
    <div class="content">
        <form method="post" id="upload_file_form">
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label ">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="post_name" id='file_name'><span id='email_val'></span>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-3 control-label ">File</label>
                <div class="col-sm-9">
                    <input type="file" name="pdf_file" id="pdf_file">
                </div>
            </div>
            <div class="form-group upload_progressbar" id="upload_progressbar">
                <div class='progressbar'>
                    <div class='procent'>
                        <span class='proc_span'></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <button type="button" class="btn btn-primary add_comment" id="upload_file_butt">Send</button>
                </div>
            </div>
        </form>
    </div>
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
