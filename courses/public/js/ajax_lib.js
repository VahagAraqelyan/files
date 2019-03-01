
function send_ajax(url, method, send_data, settings_obj){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(settings_obj.hasOwnProperty('abort') && settings_obj['abort'] == true) {
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
    }

    var async;

    if(settings_obj.hasOwnProperty('async') && settings_obj['async'] == 'false') {
        async = false;
    }

    xhr = $.ajax({
        url: url,
        type: method,
        data:  send_data,
        async: async,
        beforeSend: function() {
            if(settings_obj.hasOwnProperty('loader')) {
                $(settings_obj['loader']).show();
            }
            if(settings_obj.hasOwnProperty('beforsend')) {
                eval(settings_obj['beforsend']);
            }

            if(settings_obj.hasOwnProperty('show_loader')){
                $(settings_obj['answer']).html("<div class='cssload-square'><div class='cssload-square-part cssload-square-green'></div><div class='cssload-square-part cssload-square-pink'></div> <div class='cssload-square-blend'></div> </div>");
            }
        },
        complete: function() {
            if(settings_obj.hasOwnProperty('loader')) {
                $(settings_obj['loader']).hide();
            }
            if(settings_obj.hasOwnProperty('complete')) {
                eval(settings_obj['complete']);
            }
        },
        success: function(data){
            if(settings_obj.hasOwnProperty('handler')){

                data= data.replace(/'/gi, "`");
                data=eval(settings_obj['handler']+'(\''+data+'\')');
            }
            if(settings_obj.hasOwnProperty('answer')){
                $(settings_obj['answer']).html(data);
                $(settings_obj['answer']).show();
            }
            if(settings_obj.hasOwnProperty('success')) {
                eval(settings_obj['success']);
            }

        }
    });

}


