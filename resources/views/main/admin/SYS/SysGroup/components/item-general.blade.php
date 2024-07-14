<div class="row">
    <div class="col-md-12">
        <h2>Thông tin nhóm :</h2>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name"> Tên nhóm:</label>
                <input type="text" id="item-group_name" name="group_name" class="form-control col-md-10 js-input-blur"
                       value="{{ old('group_name',isset($item['name']) ? $item['name'] : '') }}"
                       placeholder="Nhập tên nhóm">
                @error('group_name')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name">Trạng thái</label> <br>
                <select name="status" id="" class="form-control col-md-10">
                    <option value="" selected>Chọn trạng thái</option>
                    <option value="active"
                            <?= isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' ?>>
                        Hoạt động
                    </option>
                    <option value="inactive"
                            <?= isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '' ?>>
                        Không hoạt động
                    </option>
                </select>
                @error('status')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label>Đối tác</label>
                <select id="value" class="form-control select2 kt-select2" name="partner_code">
                    <option value="" selected>Chọn Mã đối tác</option>
                        @foreach ($listPartner as $key => $items )
                            <option
                                {{ isset($item['partner_code']) &&  $item['partner_code'] == $items['code'] ? 'selected' : ''}} value="{{ $items['code']}}"
                                style="display: none;"> {{$items['code']}} </option>
                        @endforeach
                </select>
                @error('partner_code')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Mô tả</label>
            <div class="kt-tinymce tinymce-h-200">
                <textarea id="myTextarea" name="description" class="tinymce-mini" class="tox-target "
                          value="{{ old('description') }} "
                          placeholder="Mô tả">{{  old('description',isset($item['description']) ? $item['description'] : '')  }}</textarea>
            </div>
            @error('description')
            <div class="validated">
                <div class="invalid-feedback checkError">{{ $message }}</div>
            </div>
            @enderror
        </div>

    </div>
</div>

