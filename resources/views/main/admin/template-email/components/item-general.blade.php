<div class="row">
    <label for=""><h3>Add Email Template</h3></label>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Code :</label>
            <div class="">
                <input placeholder="Nhập Code Template" class="form-control" name="code"
                       value="{{ old('code', isset($item['code']) ? $item['code'] : '') }}">
            </div>
            @error('code')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Name:</label>
            <div class="">
                <input placeholder="Nhập Name Template" class="form-control" name="name"
                       value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
            </div>
            @error('name')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Subject:</label>
            <div class="">
                <input placeholder="Nhập subject Template" class="form-control" name="subject"
                       value="{{ old('subject', isset($item['subject']) ? $item['subject'] : '') }}">
            </div>
            @error('subject')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
        <div class="col-md-3">
            <div class="form-group">
                <label> Trạng Thái: </label>
                <select class="status form-control" name="status">
                    <option
                        value="active" {{isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' }} >
                        Hoạt động
                    </option>
                    <option
                        value="inactive" {{ isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '' }}>
                        Không hoạt động
                    </option>
                </select>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nội dung:</label>
            <div class="kt-tinymce tinymce-h-400">
                <textarea name="content" class="tinymce-mini" class="tox-target "
                          value="{{ old('content') }} "
                          placeholder="Nhập nội dung">{{ old('content', isset($item['content']) ? $item['content'] : '') }}</textarea>
            </div>
            @error('content')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Mô tả :</label>
            <div class="kt-tinymce tinymce-h-400">
                <textarea name="description" class="tinymce-mini" class="tox-target"
                          value="{{ old('description') }} "
                          placeholder="Nhập mô tả">{{ old('description', isset($item['description']) ? $item['description'] : '') }}</textarea>
            </div>
            @error('description')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tập tin đính kèm</label>
            <div></div>
            <div class="custom-file">
                <input type="file" name="attachment_files" class="custom-file-input" id="attachment_files">
                <label style="text-align:left;" class="custom-file-label" for="attachment_files">{{ isset($item['attachment_files']) ? $item['attachment_files'] : 'Choose file' }}</label>
            </div>
        </div>
    </div>
</div>
