<div class="form-group col-md-6">
    <button type="button" class="btn btn-primary revert_old" data-id="{{$result['id']}}">Revert in old</button>
</div>

<form method="POST" id="find_template">
    <div style="min-height: 600px" class="form-group  col-md-12">
        <textarea style="min-height: 600px" name="" id="page_template">{{$result['html_template']}}</textarea>
    </div>
    <div class="form-group col-md-6">
        <button type="button" class="btn btn-primary save_page" data-id="{{$result['id']}}">Save Page</button>
    </div>
</form>