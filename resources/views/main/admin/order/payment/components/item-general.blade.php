<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-sort">Mã đối tác</label>
            <input type="text" id="item-code" name="code" class="form-control col-md-10"
                   value="{{ old('code', isset($item['code']) ? $item['code'] : '') }}">

            @error('code')

            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-name">Tên đối tác</label>
            <input type="text" id="item-name" name="name" class="form-control col-md-10"
                   value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
            @error('name')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Mô tả</label>
            <div class="kt-tinymce tinymce-h-200">
                <textarea class="tinymce-mini" name="description" class="tox-target"
                          value="{{ old('description') }}">{{  isset($item['description']) ? $item['description'] : ''  }}</textarea>
            </div>
        </div>

    </div>
</div>







