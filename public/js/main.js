function addChecklist(){
    var checklistContainer = $("#checklist-bound");
    var html = '' ;

    html = '<div class="form-group row">';
    html += '<label for="example-text-input" class="col-2 col-form-label"></label>';
    html += '<div class="col-4">';
    html += '<input type="text" name="check_list[]" class="form-control" placeholder="check list">';
    html += '</div>';
    html += '<span><a href="javascript:void(0)" onclick="removeChecklist(this)" style="line-height: 36px; color: red">Hủy</a></span>';
    html += '</div>';
    checklistContainer.append(html);

}

function removeChecklist(item){
    $(item).parent().parent().remove();
}

function previewBannerImage(imageId){
    $("#" + imageId).change(function(){
        $('#image_preview_' + imageId).html("");
        var total_file=document.getElementById(imageId).files.length;
        for(var i=0;i<total_file;i++)
        {
            $('#image_preview_' + imageId).append("<img src='"+URL.createObjectURL(event.target.files[i])+"' class='banner_img_preview'>");
        }
    });
}
