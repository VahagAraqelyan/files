$(document).on('keypress', '.not_string', function (key) {
    if (key.charCode > 65 || key.charCode > 90) {

        return false;
    }

});

$(document).on('change', '.not_string', function (key) {

    if (!$.isNumeric($(this).val())) {

        $(this).val('');
    }

});


console.log(action);

if (action == 'AppHttpControllersAdminSubjectController@add_subject') {

    $('.save_subject').click(function () {

        var url = base_url + "/ax_save_subject";
        send_ajax(url, 'post', {'name': $('#nameInp').val()}, {handler: 'add_subject_handler'});
    });

    function add_subject_handler(data) {

        location.replace(base_url + '/admin/all_subject');
    }
}


if (action == 'AppHttpControllersAdminSubjectController@subject_type') {

    $('.save_subject_type').click(function () {

        var url = base_url + "/ax_save_subject_type";
        var data = $('#subject_type_form').serializeArray();
        send_ajax(url, 'post', data, {handler: 'add_subject_type_handler'});
    });

    function add_subject_type_handler(data) {

        location.replace(base_url + '/admin/all_subject_type');
    }
}

if (action == 'AppHttpControllersAdminLessonController@add_lesson') {

    if (!CKEDITOR.instances.lesson_text) {
        CKEDITOR.replace('lesson_text', {
            extraPlugins: 'colorbutton,colordialog,pastefromword,widget,font,justify,print,tableresize,pastefromword,liststyle',

        });
    }

    $('#lesson_video_upload').addClass('dis_none');

    $(document).on('change', '#lesson_type', function () {

        if($(this).val() == 2){

            $('#lesson_video_upload').removeClass('dis_none');
        }else{
            $('#lesson_video_upload').addClass('dis_none');
        }
    });

    myDropzone = new Dropzone("div#drop", {

        url: base_url + "/upload_file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        renameFile: true,
        init: function () {
            thisDropzone = this;
            this.on("maxfilesexceeded", function (file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on("success", function (file, response) {
                response = $.parseJSON(response);

                $(file.previewElement).find('img').attr('alt', response['inf']);

                if ($('#image_name').val() == '' || typeof $('#image_name').val() == 'undefined') {

                    $('#image_name').val(response['inf']);
                } else {

                    $('#image_name').val($('#image_name').val() + ',' + response['inf']);
                }
            });
        },
        addRemoveLinks: true,
        removedfile: function (file) {
            var _ref;

            if (typeof $(file.previewElement).attr('data-name') == 'undefined') {

                var removed_image_id = $(file.previewElement).find('img').attr('alt');


            } else {

                var removed_image_id = $(file.previewElement).find('img').attr('data-name');
            }

            //delete_gallery_images(removed_image_id);

            var images = $('#image_name').val();

            images = images.split(',');

            $.each(images, function (index, val) {

                if (val == removed_image_id) {

                    images.splice(images[index], 1);
                    return;
                }
            });

            var new_img_val = images.join(',');

            $('#image_name').val(new_img_val);

            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
    });

    /*  myDropzone.on('sending', function(file, xhr, formData){
          formData.append('type_id', $('#image_type_id').val());
      });*/

    function delete_gallery_images(id) {

        if (typeof id == 'undefined' || id == 0) {

            location.reload();
        }

        var url = base_url + 'gallery/ax_remove_image';
        send_ajax(url, 'post', {'id': id}, {});
    }

    $(document).on('click', '.save_lesson', function () {

        var fields = {
            options: {selector: '.show_error', single: false, form_id: '#add_lesson_form'},
            name: {errorname: 'Name', required: true},
            title: {errorname: 'Lesson title', required: true},
        };

        if ($('#lesson_type').val() == 2) {

            fields.video_name = {errorname: 'Video', required: true};
        } else {
            delete (fields.video_name);
        }

        var validation = new validation_lib(fields);

        if (!validation.validate_field()) {

            $('html,body').animate({
                    scrollTop: $('.admin_main_content').offset().top
                },
                'slow');

            return false;
        }

        var data = $("#add_lesson_form").serializeArray();

        data.push({name: 'lesson_text', value: CKEDITOR.instances['lesson_text'].getData()});
        var url = base_url + "/ax_save_lesson";
        send_ajax(url, 'post', data, {handler: 'save_lesson_handler'});
    });

    function save_lesson_handler(data) {

        location.reload();
    }

    $(document).on('change', '#lesson_video', function () {

        var file_data = new FormData;

        var input = $('#lesson_video');


        var file = input[0].files[0];

        var file_type = file.type.split('/');

        if (file_type[0] != 'video') {

            alert('Please choose video file');
        }

        file_data.append('lesson_video', input[0].files[0]);
        var url = base_url + '/ax_upload_video';
        ax_upload_file_ajax(file_data, url, upload_lesson_video);

    })

    function upload_lesson_video(data) {

        var obj = data;

        $('#video_name').val(obj['inf']);
        $('.procent').css('width', 0);
        $('.lds-dual-ring').addClass('dis_none')
    }
}


if (action == 'AppHttpControllersAdminQuizController@add_quiz') {

    $('.plus').click(function () {

        var radio = ' <input type="radio" name="right_answer" value="">';

        var count_radio = parseInt($('.answer_multi').length) + 1;

        $(radio).val(count_radio);

        var html = '' +
            '  <div class="form-group answer_multi">' +
            '                <label for="formGroupExampleInput">Answer</label>' +
            '                <input type="text" class="form-control" id="answer" placeholder="" name="answer[]">' +
            '            </div>' +
            radio +
            '<br>' +
            '<span class="delete_answer">-</span>';

        $('.append_answer_main').append(html);
    });

    $(document).on('click', '.delete_answer', function () {

        $(this).parent().remove();
    });

    $(document).on('click', '.add_new_question', function () {

        var quest_html = $('.copy_div').clone();
        $(quest_html).find('input').val('');
        $(quest_html).removeClass('copy_div');
        $(quest_html).find('button').removeClass('save_quiz_1');
        $(quest_html).find('form').removeClass('quiz_form_1');
        var count = parseInt($('.question_main').length) + 1;
        $(quest_html).find('button').addClass('save_quiz_' + count);
        $(quest_html).find('form').addClass('quiz_form_' + count);
        $('.new_question').append(quest_html);
    });

    $(document).on('click', '.save_all', function () {

        $('.save_quiz_1').trigger('click');
    });

    $(document).on('click', '.save_quiz', function () {

        var form_count_arr = $('#form_uniq').val().split('_');

        var form_count = form_count_arr[form_count_arr.length - 1];

        var form_uniq = '.quiz_form_' + form_count;

        var data = $(form_uniq).serializeArray();

        /*var add_steersman_fields  = {
            options:{selector:'.show_error', single:false, form_id:form_uniq},
            name:{errorname:'Name',  required: true }
        };

        var validation = new validation_lib(add_steersman_fields);

        if(!validation.validate_field()){

            return false;
        }*/

        var url = base_url + "/ax_save_quiz";
        send_ajax(url, 'post', data, {handler: 'save_quiz'});
    });

    function save_quiz(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length != 0) {

            alert(obj['errors'][0]);

        } else {

            var count_arr = $('#form_uniq').val().split('_');

            var count = count_arr[count_arr.length - 1];
            var el_count = parseInt($('.question_main').length);

            if (count == el_count) {
                location.reload();
                return false;
            }

            var uniq_count = parseInt(count) + 1;
            var uniq_val = 'save_quiz_' + uniq_count;
            $('#form_uniq').val(uniq_val);

            var classes = $('#form_uniq').val();
            $('.' + classes).trigger('click');

        }
    }

    $(document).on('click', '.save_right_answer', function () {

        var url = base_url + "/ax_save_right_answer";
        send_ajax(url, 'post', {
            right_answer: $('#right_answer').val(),
            quiz_id: $('#right_answer').attr('data-quiz')
        }, {handler: 'save_right_answer_handler'});
    });

    function save_right_answer_handler(data) {

        location.reload();

    }

    $(document).on('change', '#question_file', function () {

        var file_data = new FormData;

        var input = $('#question_file');

        file_data.append('question_file', input[0].files[0]);

        var url = base_url + '/ax_upload_quiz_file';
        ax_upload_file_ajax(file_data, url, upload_quiz_file);
    });

    function upload_quiz_file(data) {

        $('#image_name').val(data['image_name']);
    }

    $('#quiz_type').change(function () {

        if ($(this).val() == '2') {

            $('.subject_main').find('select').prop('name', 'example_id');
            $('.subject_main').removeClass('dis_none');

            $('.lesson_main').find('select').prop('name', '');
            $('.lesson_main').addClass('dis_none');
        } else {
            $('.subject_main').addClass('dis_none');
            $('.subject_main').find('select').prop('name', '');

            $('.lesson_main').find('select').prop('name', 'lesson');
            $('.lesson_main').removeClass('dis_none');
        }
    });
}

if (action == 'AppHttpControllersAdminQuizController@add_example') {

    $('.save_exam').click(function () {
        var data = $('#exam_form').serializeArray();
        var url = base_url + "/ax_save_exam";
        send_ajax(url, 'post', data, {handler: 'save_exam_handler'});
    });

    function save_exam_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length != 0) {

            alert(obj['errors'][0]);

        } else {

            location.reload();
        }
    }
}

if (action == 'AppHttpControllersAdminCheckController@get_all_user_check') {

    $(document).on('click', '.check_img', function () {

        $('#img_zoom_modal').modal('show');
        $('.img_zoom').find('img').attr('src', $(this).attr('src'));
    });

    $(document).on('click', '.check_coupon', function () {

        var el = $('.edit_delete_user');
        var checked_arr = [];

        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val());
            }
        });

        if (checked_arr.length == 0) {

            alert('Please set user(s)');
            return false;
        }

        $('#check_coupon_modal').modal('show');

        var url = base_url + "/ax_check_coupon";
        send_ajax(url, 'post', {users: checked_arr}, {answer: '.check_coupon_answer'});
    });

    $(document).on('click', '.save_check_coupon', function () {

        var url = base_url + "/ax_save_check_coupon";
        var data = $('#save_coupon_form').serializeArray();
        send_ajax(url, 'post', data, {handler: 'save_check_coupon_handler'});
    });

    function save_check_coupon_handler(data) {

        location.reload();
    }

    $(document).on('click', '.delete_user', function () {

        var el = $('.edit_delete_user');
        var checked_arr = [];

        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val());
            }
        });

        if (checked_arr.length == 0) {

            alert('Please set user(s)');
            return false;
        }

        var url = base_url + "/ax_delete_user";
        send_ajax(url, 'post', {users: checked_arr}, {handler: 'save_check_coupon_handler'});
    });
}

if (action == 'AppHttpControllersAdminSubjectController@all_subject') {

    $(document).on('click', '.edit_subject', function () {

        var el = $('.edit_delete_subject');

        var checked_arr = [];


        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set subject');
            return false;
        }

        $('#edit_subjects_modal').modal('show');

        var url = base_url + "/ax_update_subject";

        send_ajax(url, 'post', {check_arr: checked_arr}, {answer: '.edit_subjects_answer'});
    });

    $(document).on('click', '.save_edit_subject', function () {

        var url = base_url + "/ax_save_edit_subject";
        var data = $('#save_edit_subj_form').serializeArray();
        send_ajax(url, 'post', data, {handler: 'save_check_coupon_handler'});
    });

    function save_check_coupon_handler(data) {

        location.reload();
    }

    $(document).on('click', '.delete_subject', function () {

        var el = $('.edit_delete_subject');

        var checked_arr = [];


        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set subject');
            return false;
        }

        var url = base_url + "/ax_delete_subject";

        send_ajax(url, 'post', {check_arr: checked_arr}, {handler: 'save_check_coupon_handler'});
    });
}

if (action == 'AppHttpControllersAdminSubjectController@all_subject_type') {

    $(document).on('click', '.edit_subject_type', function () {

        var el = $('.edit_delete_subject_type');

        var checked_arr = [];


        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set subject type(s)');
            return false;
        }

        $('#edit_subject_type_modal').modal('show');

        var url = base_url + "/ax_update_subject_type";

        send_ajax(url, 'post', {check_arr: checked_arr}, {answer: '.edit_subjects_answer'});
    });

    $(document).on('click', '.save_edit_subject_type', function () {

        var url = base_url + "/ax_save_edit_subject_type";
        var data = $('#save_edit_subj_form').serializeArray();
        send_ajax(url, 'post', data, {handler: 'save_check_coupon_handler'});
    });

    function save_check_coupon_handler(data) {

        location.reload();
    }

    $(document).on('click', '.delete_subject_type', function () {

        var el = $('.edit_delete_subject_type');

        var checked_arr = [];

        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set subject type(s)');
            return false;
        }

        var url = base_url + "/ax_delete_subject_type";

        send_ajax(url, 'post', {check_arr: checked_arr}, {handler: 'save_check_coupon_handler'});
    });
}

if (action == 'AppHttpControllersAdminLessonController@all_lesson') {

    $(document).on('click', '.edit_lesson', function () {

        var el = $('.edit_delete_lesson');

        var checked_arr = [];


        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set lesson(s)');
            return false;
        }

        $('#edit_lesson_modal').modal('show');

        var url = base_url + "/ax_update_lesson";

        send_ajax(url, 'post', {check_arr: checked_arr}, {answer: '.edit_lesson_answer'});
    });

    $(document).on('click', '.save_updated_lesson', function () {

        var url = base_url + "/ax_save_update_lesson";
        var data = $('#edit_lesson_form').serializeArray();

        send_ajax(url, 'post', data, {handler: 'update_handler'});
    });

    function update_handler(data) {

        location.reload();
    }

    $(document).on('click', '.delete_lesson', function () {

        var el = $('.edit_delete_lesson');

        var checked_arr = [];


        $.each(el, function (index, val) {

            if ($(val).prop('checked') == true) {

                checked_arr.push($(val).val())
            }
        });

        if (checked_arr.length == 0) {
            alert('Please set lesson(s)');
            return false;
        }

        var url = base_url + "/ax_delete_lesson";

        send_ajax(url, 'post', {check_arr: checked_arr}, {handler: 'save_check_coupon_handler'});
    });

    function save_check_coupon_handler(data) {

        location.reload();
    }
}

if (action == 'AppHttpControllersAdminQuizController@all_quiz') {

    $(document).on('click', '.edit_quiz', function () {

        var id = $(this).attr('data-id');

        if (id == '') {
            return false;
        }

        $('#edit_quiz_modal').modal('show');

        var url = base_url + "/ax_update_quiz";

        send_ajax(url, 'post', {id: id}, {answer: '.edit_quiz_answer'});
    });

    $(document).on('click', '.save_edit_quiz', function () {

        var url = base_url + "/ax_save_update_quiz";
        var data = $('#save_edit_quiz_form').serializeArray();
        var id = $('#quiz_file').attr('data-id');
        data.push({name: 'id', value: id});
        send_ajax(url, 'post', data, {handler: 'update_handler'});

        var file_data = new FormData;

        var input = $('#quiz_file');

        file_data.append('file', input[0].files[0]);
        file_data.append('id', id);

        var url = base_url + '/ax_upload_updatet_quiz_file';
        ax_upload_file_ajax(file_data, url, update_handler);
    });

    function update_handler(data) {

        // location.reload();
    }
}

if (action == 'AppHttpControllersAdminAdminController@dashboard') {

    function get_statistic() {

        var url = base_url + '/ax_get_statistic';
        var data = {'mounth': $('.chart_date').val()};
        send_ajax(url, 'post', data, {answer: '.statistic_answer'});
    }

    $(document).ready(function () {
        /*        $('.chart_date').datepicker({
                    format: "yyyy-mm",
                    viewMode: "months",
                    minViewMode: "months",
                    endDate: "dateToday"
                });*/
        get_statistic();
    });

    $('.search_statistic').click(function () {

        get_statistic();
    });
}

$(document).on('change', '#enable_disable_work', function () {

    var url = base_url + "/ax_update_enable";
    send_ajax(url, 'post', {enabling: $(this).val()}, {handler: 'update_enabling_handler'});
});

function update_enabling_handler() {

    location.reload();
}

if (action == 'AppHttpControllersAdminCheckController@add_user') {

    $('.save_user').click(function () {

        var user_fields = {
            options: {selector: '.show_error', single: false, form_id: '#add_user_form'},
            name: {errorname: 'Name', required: true},
            email: {errorname: 'Email', required: true, emailvalid: true},
            password: {errorname: 'Password', required: true, minlength: 8},
        };

        var validation = new validation_lib(user_fields);

        if (!validation.validate_field()) {

            return false;
        }

        var data = $('#add_user_form').serializeArray();
        var url = base_url + "/ax_save_user";
        send_ajax(url, 'post', data, {handler: 'save_user_handler'});
    });

    function save_user_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {
            alert(obj['errors']);

        } else {
            location.reload();
        }
    }
}

if (action == 'AppHttpControllersAdminPageTemplateController@update_template') {

    $(document).ready(function () {


    });

    $('.find_url').click(function () {

        var page = $('#find_url_select').val();
        var suc_script = "if (!CKEDITOR.instances.page_template) {CKEDITOR.replace('page_template', {extraPlugins: 'uploadimage,image2,colorbutton,colordialog,pastefromword,widget,font,justify,print,tableresize,pastefromword,liststyle',allowedContent:true});}";
        var url = base_url + "/ax_parse_html";
        send_ajax(url, 'post', {"page": page}, {answer: '.html_builder_main_answer', success: suc_script});
    });

    function find_url_handler(data) {
        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {
            alert(obj['errors']);

        } else {

            CKEDITOR.instances.page_template.insertHtml(obj['result']['html_template']);
            $('.html_builder_main').removeClass('dis_none');
        }
    }

    $(document).on('click', '.save_page', function () {

        var page = CKEDITOR.instances.page_template.getData();

        var id = $(this).attr('data-id');

        var url = base_url + "/ax_save_page";
        send_ajax(url, 'post', {page: page, id: id}, {handler: 'save_page_handler'});
    });

    function save_page_handler(data) {

        var obj = $.parseJSON(data);

        if (obj['errors'].length > 0) {
            alert(obj['errors']);

        } else {

            location.reload();
        }
    }

    $(document).on('click', '.revert_old', function () {

        var id = $(this).attr('data-id');

        var url = base_url + "/ax_revert_page";
        send_ajax(url, 'post', {id: id}, {handler: 'save_page_handler'});
    });
}

function ax_upload_file_ajax(file_data, url, handler) {

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
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend:function(){
            $('.lds-dual-ring').removeClass('dis_none');
        },
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

            if (handler != '') {
                eval(handler(data))
            }

            $('#mass_upload_file_name').val(obj_upload['file_name']);

            $('.progressbar .proc_span').html('');
            $('.progressbar .procent').css('width', '0');
            $('#mass_upload_inp').val('');
        }
    }).catch((err)=>{
        $('.lds-dual-ring').addClass('dis_none');
        $('.progressbar .procent').css('width', '0');
        $('.proc_span').html('');
        alert(err.statusText+'Please repeat upload file');
        return false;
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}