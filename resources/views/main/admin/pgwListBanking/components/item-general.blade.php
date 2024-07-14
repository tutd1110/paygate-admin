<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-name">Mã của ngân hàng</label>
            @if (isset($item['code']))
                <input type="text" id="item-code" name="code"
                    class="form-control col-md-10 js-input-blur " value="{{ $item['code'] }}" readonly>
            @else
                <input type="text" id="item-code" name="code"
                    class="form-control col-md-10 js-input-blur " value="{{ old('code') }}"
                    placeholder="Nhập mã ngân hàng">
            @endif
            @error('code')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-name">Tên ngân hàng</label>
            <input type="text" id="item-name" name="name" class="form-control col-md-10 js-input-blur"
                value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}" placeholder="Nhập tên ngân hàng">
            @error('name')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" id="item-thumb_path" name="thumb_path_input" value="{{ old('thumb_path') }}">
            <label class="title_img_filed">Ảnh đại diện
                <span class="fa fa-info-circle" style="color: #017EFA" data-toggle="kt-popover" data-placement="right"
                    data-content="Kích thước khuyến nghị: 1920x600. Dung lượng khuyến nghị: 400KB"></span>
            </label>
            <div class="banner_img_bound" id="image_preview_thumb_path"
                onclick="document.getElementById('thumb_path').click();">
                <img
                    src="{{ asset(old('thumb_path', isset($item['thumb_path']) ? asset($item['thumb_path']) : asset('assets/media/bg/default_image.png'))) }}">
            </div>
            <input type="button" id="loadFileXml" value="Chọn Ảnh"
                onclick="document.getElementById('thumb_path').click();" style="display: block;margin-top: 1vw;" />
            <input type="file" style="display:none;" id="thumb_path" name="thumb_path"
                onclick="previewBannerImage('thumb_path')" />
            @error('thumb_path')
                <div class="form-group validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-name">Trạng thái</label> <br>
            <select name="status" id="" class="form-control col-md-10">
                <option value="active" <?= isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' ?>>
                    Hoạt động
                </option>
                <option value="inactive"
                    <?= isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '' ?>>
                    Không hoạt động
                </option>
            </select>
        </div>
    </div>
</div>
