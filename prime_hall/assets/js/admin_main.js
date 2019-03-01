menu_nestable = '';
thisDropzone = '';
Table_data = '';
offer_Table_data = '';
ck_editor = '';

(function($){
    $.fn.datepicker.dates['hy'] = {
        days: ["Կիրակի", "Երկուշաբթի", "Երեքշաբթի", "Չորեքշաբթի", "Հինգշաբթի", "Ուրբաթ", "Շաբաթ"],
        daysShort: ["Կիր", "Երկ", "Երե", "Չոր", "Հին", "Ուրբ", "Շաբ"],
        daysMin: ["Կի", "Եկ", "Եք", "Չո", "Հի", "Ու", "Շա"],
        months: ["Հունվար", "Փետրվար", "Մարտ", "Ապրիլ", "Մայիս", "Հունիս", "Հուլիս", "Օգոստոս", "Սեպտեմբեր", "Հոկտեմբեր", "Նոյեմբեր", "Դեկտեմբեր"],
        monthsShort: ["Հնվ", "Փետ", "Մար", "Ապր", "Մայ", "Հուն", "Հուլ", "Օգս", "Սեպ", "Հոկ", "Նոյ", "Դեկ"],
        today: "Այսօր",
        clear: "Ջնջել",
        format: "dd.mm.yyyy",
        weekStart: 1,
        monthsTitle: 'Ամիսներ'
    };
}(jQuery));

$('.calendar_class').datepicker({
    autoclose:true,
    language: 'hy',
    startDate: "dateToday",
    format:'yyyy-mm-dd'
});

$(document).ready(function () {

    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    "use strict";

    [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function (el) {
        new SelectFx(el);
    });

    jQuery('.selectpicker').selectpicker;


    $('#menuToggle').on('click', function (event) {
        $('body').toggleClass('open');
    });

    $('.search-trigger').on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').removeClass('open');
    });

    // $('.user-area> a').on('click', function(event) {
    // 	event.preventDefault();
    // 	event.stopPropagation();
    // 	$('.user-menu').parent().removeClass('open');
    // 	$('.user-menu').parent().toggleClass('open');
    // });

    if (action == 'menu->create_menu') {

        var options = {
            'json': json_data,
            callback: function(l,e){
                save_menu();
            }

        };

        menu_nestable = $('#nestable-json').nestable(options).
        on('dragEnd', function(event, item, source, destination) {
            console.log(item, source, destination);
        });

        $('#nestable-json>.dd-list>li li .dd-handle .dd_add_menu').remove();

        $(document).on('mouseover', '.dd_add_menu', function () {

            var parent = $(this).parents('div');
            parent.removeClass('dd-handle');
        });

        $(document).on('mouseout', '.dd_add_menu', function () {
            var parent = $(this).parent('div');
            parent.addClass('dd-handle');
        });

        $(document).on('mouseover', '.dd-delete', function () {
            var parent = $(this).parent('div');
            parent.removeClass('dd-handle');
        });

        $(document).on('mouseout', '.dd-edit', function () {
            var parent = $(this).parent('div');
            parent.addClass('dd-handle');
        });

        $(document).on('mouseover', '.dd-edit', function () {
            var parent = $(this).parent('div');
            parent.removeClass('dd-handle');
        });

        $(document).on('mouseout', '.dd-delete', function () {
            var parent = $(this).parent('div');
            parent.addClass('dd-handle');
        });


        $(document).on('click', '.dd_add_menu', function () {

            $('.add_or_edit_main').removeClass('dis_none');
            $('#add_edit_menu input[type = "text"]').val('');
            var parent = $(this).parent('div').parent('li');
            $('#child_id').val($(parent).attr('data-id'));
            $('#add_or_edit').attr('data_foo_type','no');
        });

        $(document).on('click', '#add_or_edit', function () {

            var beforeSend = "$('#add_or_edit').prop('disabled', true);";
            var data = $('#add_edit_menu').serializeArray();
            data.push({'name':'data_food_type','value':$(this).attr('data_foo_type')});
            send_ajax(base_url + 'menu/ax_add_or_edit_menu', 'post', data, {handler:'add_or_edit_handler',beforsend:beforeSend});
        });


        $(document).on('click','.dd-delete',function () {

            var parent = $(this).parent('div').parent('li');
            var food_type_id = $(parent).parents('li').attr('data-id');
            var menu_id = $(parent).attr('data-id');
            var data = {};
            var mess = '';

            if(typeof food_type_id == 'undefined'){

               data = {'food_type_id':menu_id,'type_id':$('#type_id').val()};
                mess = 'Ջնջելով այս տիպը դուք ջնջում եք նաև իր բոլոր ճաշատեսակները։ Դուք համոզված եք?';
            }else{

                data = {'menu_id':menu_id,'type_id':$('#type_id').val()};
                mess = 'Դուք համոզված եք, որ ցանկանում եք ջնջել այս  ճաշատեսակը?';
            }

            bootbox.confirm({
                message: mess,
                buttons: {
                    confirm: {
                        label: 'Այո',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Ոչ',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result == true) {

                        var doc_id = data;
                        var url = base_url + 'menu/ax_remove_menu';
                        send_ajax(url, 'post', data, {handler:'add_or_edit_handler'});

                    }
                }
            });

        });

        $(document).on('click', '.add_menu_type', function () {

            $('.add_or_edit_main').removeClass('dis_none');
            $('#child_id').val('');
            $('#menu_id').val('');
            $('#price_div').addClass('dis_none');
            $('#add_or_edit').attr('data_foo_type','ok');
        });

        $(document).on('click','.dd-edit',function () {

            $('.add_or_edit_main').removeClass('dis_none');
            var parent = $(this).parent('div').parent('li');
            var food_type_id = $(parent).parents('li').attr('data-id');

            if(typeof food_type_id == 'undefined'){

                $('#child_id').val($(parent).attr('data-id'));
                $('#menu_id').val('');
                $('#price_div').addClass('dis_none');
                $('#add_or_edit').attr('data_foo_type','ok')
            }else{

                $('#child_id').val(food_type_id);
                $('#menu_id').val($(parent).attr('data-id'));
                $('#price').val($(parent).attr('data-price'));
                $('#price_div').removeClass('dis_none');
                $('#add_or_edit').attr('data_foo_type','no');
            }

            $('#name_am').val($(parent).attr('data-name_am'));
            $('#name_ru').val($(parent).attr('data-name_ru'));
            $('#name_en').val($(parent).attr('data-name_en'));

        });

        function save_menu() {

            var data = {json_data: JSON.stringify(menu_nestable.nestable('serialize'))};

            data['type_id'] = $('#type_id').val();
            send_ajax(base_url + 'menu/ax_save_menu', 'post', data, {handler:'submit_handler'});
        }
    }



    if (action == 'adm_gallery->add_gallery') {

        var myDropzone1 = new Dropzone("div#drop", {

            url:  base_url + "adm_gallery/upload_file",
            renameFile:true,
            init: function() {
                thisDropzone = this;
                this.on("maxfilesexceeded", function(file) { this.removeAllFiles(); this.addFile(file); });
                this.on("success", function(file, response) {
                    var obj = jQuery.parseJSON(response);

                    if(obj['errors'].length>0){

                        bootbox.alert({
                            message: obj['errors'][0],
                            backdrop: true
                        });

                        var _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                    }else{

                        $(file.previewElement).attr('data-name',obj['info']['id'])

                    }

                });
            },
            addRemoveLinks: true,
            removedfile: function(file) {
                var _ref;

                if(typeof $(file.previewElement).attr('data-name') == 'undefined'){

                        var removed_image_id = $(file.previewElement).find('img').attr('alt');


                }else{

                    var removed_image_id = $(file.previewElement).find('img').attr('data-name');
                }

                delete_gallery_images(removed_image_id);

                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
        });

        myDropzone1.on('sending', function(file, xhr, formData){
            formData.append('type_id', $('#image_type_id').val());
        });

        galery_mock();

        function galery_mock() {

           if(typeof gallery_images == 'undefined' || gallery_images.length<= 2){
               return false;
           }

           var obj = $.parseJSON(gallery_images);
            for(let i = 0; i<obj.length; i++){

                var mockFile = { name: obj[i]['id']};
                myDropzone1.options.addedfile.call(myDropzone1, mockFile);
                myDropzone1.files.push(mockFile);
                myDropzone1.options.thumbnail.call(myDropzone1, mockFile, base_url +"tmp/"+obj[i]['name']);
            }

        }

        function delete_gallery_images(id) {

            if(typeof id == 'undefined' || id == 0){

                location.reload();
            }

            var url = base_url + 'gallery/ax_remove_image';
            send_ajax(url, 'post', {'id':id}, {});
        }

    }

    if (action == 'reservetion->get_reservetion') {

        Table_data = $('#admin_reservetion').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax": {
                url: base_url+ "reservetion/ax_get_all_reservetion",
                data:{'type':$('#search_crt').val(),'searching_type':$('#search_val').val()},
                type:"POST",
                complete: function (data) {
                }
            },
            searching: false,
            "order": [[ 1, "ASC" ]],
            "columnDefs":[
                {
                    "target":[1]
                },
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 3}
            ]
        });

        function data_table() {

            var settings = $("#admin_reservetion").dataTable().fnSettings();

            settings.ajax.data = {'type':$('#search_crt').val(),'searching_type':$('#search_val').val()};

            Table_data.api().ajax.url(base_url+ "reservetion/ax_get_all_reservetion").load();
        }

        $('.search_reservetion_butt').click(function () {

            $('#search_div *').removeClass('error_red_class');

            var all_data  = {
                status:{errorname:' Փնտրման տեսակ', required: true},
                search_val:{errorname:'Փնտրման արժեք ', required: true}
            };

            var log = true;
            var error = '';

            $.each(all_data, function( index, value ) {

                error = valid_fields(index,value);

                if(error != ''){

                    log = false;

                    return false;
                }

            });

            $("#show_error_my_profile").html('');
            $("#show_error_my_profile").removeClass('error_class');
            $("#show_upload_error_img").removeClass('error_img');


            if (!log ){

                $('#upload_modal').modal('show');
                $("#show_error_my_profile").addClass('error_class');
                $('#show_upload_error_img').addClass('error_img');
                $("#show_error_my_profile").html(error);
            }
            else{

                data_table();
            }
        });

        $('#search_crt').change(function () {

            if($(this).val() == 'date'){

                $('#search_val').addClass('admin_search_reserv');

                $('.admin_search_reserv').datepicker({
                    autoclose:true,
                    language: 'hy',
                    startDate: "dateToday",
                    format:'yyyy-mm-dd'
                });


            }else{

                $('#search_val').removeClass('admin_search_reserv');
                $('#search_val').datepicker("destroy");
            }
        });
    }

    if (action == 'offer->get_all_offer') {

        offer_Table_data = $('#admin_offer_table').dataTable({
            "processing":true,
            "serverSide":true,
            "ajax": {
                url: base_url+ "offer/ax_get_all_offer",
                data:{'type':$('#offer_search_crt').val(),'searching_type':$('#offer_search_val').val()},
                type:"POST",
                complete: function (data) {
                }
            },
            searching: false,
            "order": [[ 3, "ASC" ]],
            "columnDefs":[
                {
                    "target":[1]
                },
                { "orderable": false, "targets": 0 },
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 },
                { "orderable": false, "targets": 4 },
                { "orderable": false, "targets": 5}
            ]
        });


        $('.add_offer_btn').click(function () {

            $('#add_offer_modal').modal('show');

            if(!CKEDITOR.instances.add_paragraph_desc_am){
                CKEDITOR.replace('add_paragraph_desc_am');
            }else{
                CKEDITOR.instances.add_paragraph_desc.setData('')
            }
            if(!CKEDITOR.instances.add_paragraph_desc_ru){
                CKEDITOR.replace('add_paragraph_desc_ru');
            }else{
                CKEDITOR.instances.add_paragraph_desc.setData('')
            }
            if(!CKEDITOR.instances.add_paragraph_desc_en){
                CKEDITOR.replace('add_paragraph_desc_en');
            }else{
                CKEDITOR.instances.add_paragraph_desc_en.setData('')
            }
        });

        $('#add_new_offer').click(function () {

            $('#add_offer_form > *').find('input').removeClass('error_red_class');

            $(".reservetion-error").html('');

            var log = true;
            var error = [];

            var fields  = {
                image:{errorname:'Լուսանկար', required: true}
            };


            $.each(fields, function (index, value) {

                if(valid_fields(index, value)[0] != undefined){

                    error.push(valid_fields(index, value)[0]);
                }

                if (error != '') {

                    log = false;
                }
            });


            if (!log) {

                for (var i = 0;i<error.length; i++) {

                    $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
                }



                return false;
            }
            var data = $('#add_offer_form').serializeArray();

            var file_data = new FormData;

            var input search_statistic= $('#offer_image');

            file_data.append('upload_file', input[0].files[0]);
            file_data.append('title_am', $('#title_am').val());
            file_data.append('title_ru', $('#title_ru').val());
            file_data.append('title_en', $('#title_en').val());
            file_data.append('offer_am', CKEDITOR.instances['add_paragraph_desc_am'].getData());
            file_data.append('offer_ru', CKEDITOR.instances['add_paragraph_desc_ru'].getData());
            file_data.append('offer_en', CKEDITOR.instances['add_paragraph_desc_en'].getData());


            var url =  base_url+'offer/ax_add_offer';
            ax_upload_file_ajax(file_data,url,add_offer_success);
        });

        function add_offer_success(data) {

            $(".reservetion-error").html('');
            var obj = data;

            if (obj['errors'].length > 0) {

                $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' +  obj['errors'] + '</span></div>');
            } else {

                $('#add_offer_modal').modal('hide');
                $('#add_offer_form > *').find('input').val('');

                offer_data_table();
            }
        }


        $(document).on('click','#edit_new_offer', function () {

            $('#add_offer_form > *').find('input').removeClass('error_red_class');

            $(".reservetion-error").html('');

            var log = true;
            var error = [];

            var id = $('#offer_id').val();
            var cke_id_am = 'edit_paragraph_desc_am_'+id+'';
            var cke_id_ru = 'edit_paragraph_desc_ru_'+id+'';
            var cke_id_en = 'edit_paragraph_desc_en_'+id+'';


            if (!log) {

                for (var i = 0;i<error.length; i++) {

                    $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
                }

                return false;
            }

            var file_data = new FormData;

            var input = $('#edit_offer_image');

            var bool_upload = true;

            if(typeof input[0].files[0] == 'undefined'){

                bool_upload = false;
            }

            var status_check = 2;

            if($('#status_check').prop('checked') == true){

                status_check = 1;
            }

            file_data.append('upload_file', input[0].files[0]);
            file_data.append('title_am', $('#edit_title_am').val());
            file_data.append('title_ru', $('#edit_title_ru').val());
            file_data.append('title_en', $('#edit_title_en').val());
            file_data.append('editable', true);
            file_data.append('up_file', bool_upload);
            file_data.append('offer_id', $('#offer_id').val());
            file_data.append('status_check',status_check);
            file_data.append('offer_am', CKEDITOR.instances[''+cke_id_am+''].getData());
            file_data.append('offer_ru', CKEDITOR.instances[''+cke_id_ru+''].getData());
            file_data.append('offer_en', CKEDITOR.instances[''+cke_id_en+''].getData());


            var url =  base_url+'offer/ax_add_offer';
            ax_upload_file_ajax(file_data,url,edit_offer_handler);
        });

        function edit_offer_handler(data) {

            $(".reservetion-error").html('');
            var obj = data;

            if (obj['errors'].length > 0) {

                $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' +  obj['errors'] + '</span></div>');
            } else {

                $('#edit_offer_modal').modal('hide');
                $('#edit_add_offer_form > *').find('input').val('');

                offer_data_table();
            }
        }

        $(document).on('click','.delete_offer',function () {

            var id = $(this).attr('data-id');

            bootbox.confirm({
                message: 'Դուք համոզված եք, որ ցանկանում եք ջնջել այս  առաջարկը?',
                buttons: {
                    confirm: {
                        label: 'Այո',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Ոչ',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result == true) {

                        var url = base_url + 'offer/ax_delete_offer';
                        send_ajax(url, 'post', {'id':id}, {handler:'delete_offer_handler'});

                    }
                }
            });

        });

        function offer_data_table() {

            var settings = $("#admin_offer_table").dataTable().fnSettings();

            settings.ajax.data = {'type':$('#offer_search_crt').val(),'searching_type':$('#offer_search_val').val()};

            offer_Table_data.api().ajax.url(base_url+ "offer/ax_get_all_offer").load();
        }

        $('.search_offer_butt').click(function () {
            offer_data_table();
        });

        $(document).on('click','.edit_offer',function () {

            var id = $(this).attr('data-id');
            $('#edit_offer_modal').modal('show');

            var suc_script = "if(!CKEDITOR.instances.edit_paragraph_desc_"+id+"){CKEDITOR.replace('edit_paragraph_desc_am_"+id+"');};" +
                "if(!CKEDITOR.instances.edit_paragraph_desc_"+id+"){CKEDITOR.replace('edit_paragraph_desc_ru_"+id+"');}" +
                "if(!CKEDITOR.instances.edit_paragraph_desc_"+id+"){CKEDITOR.replace('edit_paragraph_desc_en_"+id+"');}";

            var url = base_url + 'offer/ax_get_single_offer';
            send_ajax(url, 'post', {'id':id}, {answer:'.edit_offer_answer',success:suc_script});
        });

        $(document).on('click','.paragraph_desc_view',function () {

            var lang = $(this).attr('data-lang');
            var id   = $(this).attr('data-id');
            $('#view_offer_modal').modal('show');

            var ajax_url = base_url + "offer/view_offer";
            send_ajax(ajax_url, 'post', {'lang':lang,'id':id}, {answer: '.view_offer_answer'});
        });
    }

    if (action == 'admin->get_admin') {

        $('.add_admin_btn').click(function () {

            $('#add_admin_modal').modal('show');

            var ajax_url = base_url + "admin/add_admin";
            send_ajax(ajax_url, 'post', {}, {answer: '.view_admin_answer'});
        });

        $(document).on('click','#add_new_admin',function () {

            $('#add_edit_admin_form > *').find('input').removeClass('error_red_class');

            $(".reservetion-error").html('');

            var log = true;
            var error = [];

            var fields  = {
                name:{errorname:'Անուն', required: true,formid:'#add_edit_admin_form'},
                email:{errorname:'Էլ․ Հասցե', required:  true, emailvalid:true, formid:'#add_edit_admin_form'},
                password:{errorname:'Գաղտնաբառ', required: true, minlength:8, formid:'#add_edit_admin_form'},
                confirm_password:{errorname:'Կրկնել Գաղտնաբառ', required: true,  equalTo:'password', minlength:8,formid:'#add_edit_admin_form'}
            };


            $.each(fields, function (index, value) {

                if(valid_fields(index, value)[0] != undefined){

                    error.push(valid_fields(index, value)[0]);
                }

                if (error != '') {

                    log = false;
                }
            });

            if (!log) {

                for (var i = 0;i<error.length; i++) {

                    $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
                }

                return false;
            }

            var data = $('#add_edit_admin_form').serializeArray();

            var ajax_url = base_url + "admin/ax_save_admin";
            send_ajax(ajax_url, 'post', data, {handler:'add_edit_admin_handler'});

        });

        $('.edit_admin').click(function () {

            $('#edit_admin_modal').modal('show');
            var id = $(this).attr('data_id');

            var ajax_url = base_url + "admin/ax_edit_admin";
            send_ajax(ajax_url, 'post', {'id':id}, {answer: '.edit_admin_answer'});
        });

        $(document).on('click','#save_edit_admin',function () {

            $('#edit_admin_form > *').find('input').removeClass('error_red_class');

            $(".reservetion-error").html('');

            var log = true;
            var error = [];

            var fields  = {
                name:{errorname:'Անուն', required: true,formid:'#edit_admin_form'},
                email:{errorname:'Էլ․ Հասցե', emailvalid:true, required: true,formid:'#edit_admin_form'},
                password:{errorname:'Գաղտնաբառ', required: true,  minlength:8, formid:'#edit_admin_form'},
                confirm_password:{errorname:'Կրկնել Գաղտնաբառ', required: true, equalTo:'password', minlength:8,formid:'#edit_admin_form'}
            };


            $.each(fields, function (index, value) {

                if(valid_fields(index, value)[0] != undefined){

                    error.push(valid_fields(index, value)[0]);
                }

                if (error != '') {

                    log = false;
                }
            });

            var data = $('#edit_admin_form').serializeArray();

            if (!log) {

                for (var i = 0;i<error.length; i++) {

                    $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
                }

                return false;
            }


            var ajax_url = base_url + "admin/ax_save_edit_admin";
            send_ajax(ajax_url, 'post', data, {handler:'add_edit_admin_handler'});


        });

        $('.delete_admin').click(function () {

            var id   = $(this).attr('data_id');

            bootbox.confirm({
                message: 'Դուք համոզված եք, որ ցանկանում եք ջնջել այս  ադմինին?',
                buttons: {
                    confirm: {
                        label: 'Այո',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Ոչ',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result == true) {

                        var url = base_url + 'admin/ax_delete_admin';
                        send_ajax(url, 'post', {'id':id}, {handler:'delete_admin_handler'});

                    }
                }
            });
        });
    }
});


$(document).on('click', '#change-captcha', function () {
    var ajax_url = base_url + "admin/get_new_captcha";
    send_ajax(ajax_url, 'post', {}, {answer: '#captcha-div'});

});

$(document).on('change','#status_check',function () {
    var txt = '';
    var clss = '';
    if($(this).prop('checked') == true){
        txt = 'Active';
        clss = 'blue';

    }else{

        txt = "In Active";
        clss = 'grey';
    }
    $('.status_checkbox').html(txt);
    $('.status_checkbox').removeClass('blue');
    $('.status_checkbox').removeClass('grey');
    $('.status_checkbox').addClass(clss);
});



function add_or_edit_handler(data) {

    var obj = JSON.parse(data);

    if (obj['errors'].length > 0) {

        bootbox.alert({
            message: obj['errors'],
            backdrop: true,
            className: 'menu_error_color'
        });
    } else {
        bootbox.alert({
            message: obj['success'],
            backdrop: true,
            className: 'menu_success_color'
        });
        setTimeout(function () {
            location.reload();
        }, 1500);
    }
}

function submit_handler(data) {

    var obj = JSON.parse(data);

    if (obj['errors'].length > 0) {
        bootbox.alert({
            message: obj['errors'][0],
            backdrop: true,
            className: 'menu_error_color'
        });
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

            $('#mass_upload_file_name').val(obj_upload['file_name']);

            $('.progressbar .proc_span').html('');
            $('.progressbar .procent').css('width', '0');
            $('#mass_upload_inp').val('');
        }
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}
function delete_offer_handler() {

    var settings = $("#admin_offer_table").dataTable().fnSettings();

    settings.ajax.data = {'type':$('#offer_search_crt').val(),'searching_type':$('#offer_search_val').val()};

    offer_Table_data.api().ajax.url(base_url+ "offer/ax_get_all_offer").load();
}

function add_edit_admin_handler(data) {

    var obj = JSON.parse(data);

    $(".reservetion-error").html('');

    if (obj['errors'].length > 0) {

        $(".reservetion-error").append('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][0] + '</span></div>');

    }else{

        $('#add_admin_modal').modal('hide');
        location.reload();
    }
}

function delete_admin_handler(data) {

    var obj = JSON.parse(data);

    if (obj['errors'].length > 0) {
        bootbox.alert({
            message: obj['errors'][0],
            backdrop: true,
            className: 'menu_error_color'
        });

    }else{
        location.reload()
    }
}

$('#save_edit_profile').click(function () {

    $('#edit_info_form > *').find('input').removeClass('error_red_class');

    $("#answer_upload").html('');

    var log = true;
    var error = [];

    var fields  = {
        name:{errorname:'Անուն', required: true,formid:'#edit_info_form'},
        email:{errorname:'Էլ․ Հասցե', emailvalid:true, required: true,formid:'#edit_info_form'},
        password:{errorname:'Գաղտնաբառ', required: true, minlength:8, formid:'#edit_info_form'},
        confirm_password:{errorname:'Կրկնել Գաղտնաբառ', required: true, equalTo:'password', minlength:8,formid:'#edit_info_form'}
    };


    $.each(fields, function (index, value) {

        if(valid_fields(index, value)[0] != undefined){

            error.push(valid_fields(index, value)[0]);
        }

        if (error != '') {

            log = false;
        }
    });

    var data = $('#edit_info_form').serializeArray();

    if (!log) {
        $('#upload_modal').modal('show');
        for (var i = 0;i<error.length; i++) {

            $("#answer_upload").append('<div><span class="error_img"></span> <span class="error_class">' + error[i] + '</span></div>');
        }

        return false;
    }


    var ajax_url = base_url + "admin/save_edit_profile";
    send_ajax(ajax_url, 'post', data, {handler:'add_edit_admin_handler'});

});
