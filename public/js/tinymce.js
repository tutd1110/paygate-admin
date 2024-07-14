function image_upload_handler (blobInfo, success, failure, progress) {
  var xhr, formData;

  xhr = new XMLHttpRequest();
  xhr.withCredentials = false;
  xhr.open('POST', '/upload');
  xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

  xhr.upload.onprogress = function (e) {
    progress(e.loaded / e.total * 100);
  };

  xhr.onload = function() {
    var json;

    if (xhr.status === 403) {
      failure('HTTP Error: ' + xhr.status, { remove: true });
      return;
    }

    if (xhr.status < 200 || xhr.status >= 300) {
      failure('HTTP Error: ' + xhr.status);
      return;
    }

    json = JSON.parse(xhr.responseText);

    if (!json || typeof json.location != 'string') {
      failure('Invalid JSON: ' + xhr.responseText);
      return;
    }

    success(json.location);
  };

  xhr.onerror = function () {
    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
  };

  formData = new FormData();
  formData.append('file', blobInfo.blob(), blobInfo.filename());

  xhr.send(formData);
};
function init_key_callback (editor) {
    editor.on('keyup', function(e) {

        var id_name = $(this).attr('id');
        var cs = tinymce.get(id_name).getContent().length;
        var title;
        var max_cs ;
        var arr_1000 = ['item-description'];
        if(arr_1000.includes(id_name)){
            max_cs = 1011;
            title = "1000";
        } else {
            max_cs = 511;
            title = "500";
        }
        if (cs > max_cs){
            $('#characters_'+id_name).hide();
            $('#characters_'+id_name+'_error').show();
        }
        else if(cs == 0){
            $('#characters_'+id_name).text("");
        }
        else{
            $('#characters_'+id_name).text(cs-11+"/"+title);
            $('#characters_'+id_name).show();
            $('#characters_'+id_name+'_error').hide();
        }
    });
};
function init_key_course_callback (editor) {
    editor.on('keyup', function(e) {

        var id_name = $(this).attr('id');
        console.log(id_name);
        var cs = tinymce.get(id_name).getContent().length;
        var title;
        var max_cs ;
        var arr_1000 = ['item-description'];
        var arr_500  = ['item-input_requirement'];
        var arr_200 = ['item-target_object'];
        var arr_100 = ['outstanding-content','checklist-content'];
        if(arr_1000.includes(id_name)){
            max_cs = 1011;
            title = "1000";
        }else if(arr_500.includes(id_name)){
            max_cs = 511;
            title = "500";
        } else if(arr_200.includes(id_name)){
            max_cs = 211;
            title = "200";
        } else if(arr_100.includes(id_name)){
            max_cs = 111;
            title = "100";
        } else{
            max_cs = 91;
            title = "80";
        }
        if (cs > max_cs){
            $('#characters_course_'+id_name).hide();
            $('#characters_course_'+id_name+'_error').show();
        }
        else if(cs == 0){
            $('#characters_course_'+id_name).text("");
        }
        else{
            $('#characters_course_'+id_name).text(cs-11+"/"+title);
            $('#characters_course_'+id_name).show();
            $('#characters_course_'+id_name+'_error').hide();
        }
    });
};
var KTTinymce = function () {
    // Private functions
    var demos = function () {

        tinymce.init({
            selector: '#kt-tinymce-1',
            toolbar: false,
            statusbar: false
        });

        tinymce.init({
            selector: '#kt-tinymce-2'
        });

        tinymce.init({
            selector: '#kt-tinymce-3',
            toolbar: 'advlist | autolink | link image | lists charmap | print preview',
            plugins : 'advlist autolink link image lists charmap print preview'
        });

        tinymce.init({
            selector: '.tinymce-full',
            forced_root_block : "div",
            toolbar: ['styleselect fontselect fontsizeselect',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount imagetools',
            image_dimensions: false,
            content_style: "body {font-size: 14px;}",
            fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 24px 32px 36px 48px 64px',
            images_upload_handler: image_upload_handler,
            init_instance_callback: init_key_callback,

        });
        tinymce.init({
            selector: '.tinymce-full-contact-exams',
            forced_root_block : "div",
            toolbar: ['styleselect fontselect fontsizeselect',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount imagetools',
            image_dimensions: false,
            images_upload_handler: image_upload_handler,
            init_instance_callback: init_key_course_callback,

        });

        tinymce.init({
            selector: '.tinymce-mini',
            menubar: false,
            forced_root_block : "div",
            plugins: 'code advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount imagetools',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | link image | alignleft aligncenter ' +
                'alignright alignjustify code | bullist numlist outdent indent  | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 24px 32px 36px 48px 64px',
            image_dimensions: false,
            images_upload_handler: image_upload_handler,
            content_style: "body {font-size: 14px;}",
            fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 24px 32px 36px 48px 64px'
        });
        tinymce.init({
            selector: '.tinymce-mini-contact-exams',
            menubar: false,
            forced_root_block : "div",
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount imagetools',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | link image | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            image_dimensions: false,
            images_upload_handler: image_upload_handler,
            init_instance_callback: init_key_course_callback,
        });
    };

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTTinymce.init();
});
