$('#upload_file_butt').click(function () {
    var input = $('#pdf_file');

    if(typeof input.prop('files')[0] == 'undefined'){
        bootbox.alert({
            message:'File is required',
            backdrop: true
        });

        return false;
    }

    var file_type = input.prop('files')[0].name.split('.');

    if(file_type.length == 2){

        file_type = file_type[1]

    }else{
        file_type = '';
    }



    var file_data = new FormData;
    file_data.append('upload_file', input[0].files[0]);
    file_data.append('file_name',$('#file_name').val());
    file_data.append('_token',$('#token').val());
    var url =  base_url + "/home/ax_save_file";
    ax_upload_file_ajax(file_data,url,image_upload_success);

});


function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}

function image_upload_success(data) {

   if(data){
       location.replace(base_url);
   }
}

function ax_upload_file_ajax(file_data,url,handler) {

    var widget = this;
    widget.queuePos++;
    $.ajax({
        url: url,
        type: 'post',
        data: file_data,
        cache: false,
        contentType: false,
        processData: false,
        forceSync: false,
        dataType: 'json',
        xhr: function () {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;

                    var total = event.total || e.totalSize;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);

                    }

                    processing(percent);

                }, false);
            }

            return xhrobj;
        },
        success: function (data) {

            var obj_upload = data;

            if(handler != ''){
                eval(handler(data))
            }

            $('.progressbar .proc_span').html('');
            $('.progressbar .procent').css('width', '0');
            $('#mass_upload_inp').val('');
        }
    });
}

$('#search').keyup(function () {

    var url =  base_url + "/home/ax_search_file";
    send_ajax(url, 'post', {'search':$(this).val(),'_token':$('#token').val()},{answer:'#search_answer'});
});