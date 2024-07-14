$('#item-classes').select2({
    placeholder: 'Chọn lớp học'
});

var topics = [];
if ($('#item-additional_info').val()) {
    var topics = JSON.parse($('#item-additional_info').val());
    if (topics) {
        renderTopic();
    }
}


function topicConfirm() {
    var name = $('#topic-name').val();
    var item_per_row = $('#topic-item_per_row').val();
    var maxTopic = $("div[data-topic-id^='6']").val();
    if (!name) {
        toastr.error('Tên đề mục không xác định');
        return false;
    }
    if (maxTopic == '') {
        toastr.error('Số Đề mục tối đa là 7!');
        return false;
    }
    if (topicIndex != null) {

        if (!topics[topicIndex] || topics[topicIndex] === 'undefined') {
            toastr.error('Lỗi dữ liệu');
            return false;
        }

        topics[topicIndex].name = name;
        topics[topicIndex].item_per_row = item_per_row;
        console.log(topics[topicIndex]);
    } else {
        topics.push({
            name: name,
            item_per_row: item_per_row,
            items: []
        });
    }

    renderTopic();
    $('#modalTopic').modal('hide');

    return false;
}

$('#modalTopic').on('hidden.bs.modal', function () {
    topicIndex = null;
    $('#topic-name').val('');
    $('#topic-item_per_row').val(1).trigger('change');
    $('#characters_topic-name').hide();
    $('#characters_part-title').hide();
});

function renderTopic() {
    var html = '';
    if (topics && topics.length > 0) {
        $.each(topics, function(k, v){
            html += renderTopicRow(k, v);
        });
    }

    $('#topic__block').html('');
    $('#topic__block').html(html);
}

function renderTopicRow(id, data) {
    var partHtml = '';
    if (data.items && data.items.length > 0) {
        partHtml = renderPart(data.items, data.item_per_row);
    }
    var row = '\
        <div class="alert alert-outline-dark d-block topic-item my-2 p-3" data-topic-id="'+id+'">\
            <div class="d-flex justify-content-between">\
                <div class="topic-name font-weight-bold text-info">'+data.name+'</div>\
                <div class="d-flex">\
                    <a href="javascript:;" class="btn btn-sm btn-icon topic-add" title="Thêm thành phần"><i class="fa fa-plus"></i></a>\
                    <a href="javascript:;" class="btn btn-sm btn-icon topic-edit" title="Sửa thành phần"><i class="fa fa-edit"></i></a>\
                    <a href="javascript:;" class="btn btn-sm btn-icon topic-remove" title="Xóa thành phần"><i class="fa fa-trash-alt"></i></a>\
                </div>\
            </div>\
            <div class="topic-part">'+partHtml+'</div>\
        </div>\
    ';
    return row;
}

function renderPart(items, item_per_row) {
    if (!items || items.length == 0) {
        return '';
    }

    var html = '<div class="row">';
    $.each(items, function(k, v){
        let className = 'col-md-12';
        if (item_per_row == 2) {
            className = 'col-md-6';
        } else if (item_per_row == 3) {
            className = 'col-md-4';
        } else if (item_per_row == 4) {
            className = 'col-md-3';
        }
        html += renderPartRow(k, v, className);
    });
    html += '</div>';
    return html;
}

function renderPartRow(id, data, className) {
    var html = '\
        <div class="'+className+' mb-2 part-item" data-part-id="'+id+'">\
            <div class="alert alert-outline-brand d-block h-100 p-3 position-relative text-reset">\
                <div class="part-title">\
                    <h5 class="text-center"><strong>'+data.title+'</strong></h5>\
                </div>\
                <hr>\
                <div class="part-content">'+data.content+'</div>\
                <div class="bg-light position-absolute part-action" style="right: 0;top:0;display:none">\
                    <a href="javascript:;" class="btn btn-sm btn-icon part-edit"><i class="fa fa-edit"></i></a>\
                    <a href="javascript:;" class="btn btn-sm btn-icon part-remove"><i class="fa fa-trash-alt"></i></a>\
                </div>\
            </div>\
        </div>\
    ';
    return html;
}

var topicIndex = null;
$('#topic__block').on('click', '.topic-edit', function(){
    topicIndex = $(this).closest('.topic-item').data('topic-id');
    if (!topics[topicIndex] || topics[topicIndex] === 'undefined') {
        toastr.error('Lỗi dữ liệu');
        return false;
    }

    $('#topic-name').val(topics[topicIndex].name);
    $('#topic-item_per_row').val(topics[topicIndex].item_per_row).trigger('change');

    $('#modalTopic').modal('show');
    $('#characters_topic-name').hide();
    $('#characters_part-title').hide();
});

$('#topic__block').on('click', '.topic-remove', function(){
    var index = $(this).closest('.topic-item').data('topic-id');
    if (index != null) {
        if (!topics[index] || topics[index] === 'undefined') {
            toastr.error('Lỗi dữ liệu');
            return false;
        }

        topics.splice(index, 1);
        renderTopic();
    }
});

$('#topic__block').on('click', '.topic-add', function(){
    topicIndex = $(this).closest('.topic-item').data('topic-id');
    $('#modalPart').modal('show');
    $('#characters_topic-name').hide();
    $('#characters_part-title').hide();
    $('#characters_part-content').hide();
});

function partConfirm() {
    var title = $('#part-title').val();
    var content = tinymce.get("part-content").getContent();
    if (!title) {
        toastr.error('Tiêu đề không xác định');
        return false;
    }

    if (!content) {
        toastr.error('Nội dung không xác định');
        return false;
    }

    if (topicIndex == null || topicIndex == 'undefined') {
        toastr.error('Đề mục không xác định');
        return false;
    }

    if (topics[topicIndex] === 'undefined') {
        toastr.error('Lỗi dữ liệu thành phần');
        return false;
    }

    if (partIndex == null || partIndex == 'undefined') {
        topics[topicIndex].items.push({
            title: title,
            content: content
        });
    } else {
        if (topics[topicIndex].items[partIndex] === 'undefined') {
            toastr.error('Lỗi dữ liệu thành phần');
            return false;
        }

        topics[topicIndex].items[partIndex].title = title;
        topics[topicIndex].items[partIndex].content = content;
    }

    renderTopic();
    $('#modalPart').modal('hide');

    return false;
}

$('#modalPart').on('hidden.bs.modal', function () {
    topicIndex = null;
    partIndex = null;
    $('#part-title').val('');
    tinymce.get("part-content").setContent('');
});

var partIndex = null;
$('#topic__block').on('click', '.part-edit', function(){
    topicIndex = $(this).closest('.topic-item').data('topic-id');
    partIndex = $(this).closest('.part-item').data('part-id');
    if (!topics || topics[topicIndex] === 'undefined') {
        toastr.error('Lỗi dữ liệu đề mục');
        return false;
    }

    if (!topics[topicIndex].items || topics[topicIndex].items[partIndex] === 'undefined') {
        toastr.error('Lỗi dữ liệu thành phần');
        return false;
    }

    $('#part-title').val(topics[topicIndex].items[partIndex].title);
    if (topics[topicIndex].items[partIndex].content) {
        tinymce.get("part-content").setContent(topics[topicIndex].items[partIndex].content);
    }
    $('#modalPart').modal('show');
});

$('#topic__block').on('click', '.part-remove', function(){
    var indexT = $(this).closest('.topic-item').data('topic-id');
    var indexP = $(this).closest('.part-item').data('part-id');
    if (!topics || topics[indexT] === 'undefined') {
        toastr.error('Lỗi dữ liệu');
        return false;
    }

    if (!topics[indexT].items || topics[indexT].items[indexP] === 'undefined') {
        toastr.error('Lỗi dữ liệu thành phần');
        return false;
    }

    topics[indexT].items.splice(indexP, 1);
    renderTopic();
});

$('#formProgram').submit(function() {
    $('#item-additional_info').val(JSON.stringify(topics));
});
