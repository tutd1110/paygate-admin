<div class="overlay " id="overlay"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-sort">Mã đối tác</label> <br>
            <select name="partner_code" id="partner_code" style="width: 83%;height: 40px">
                <option>Chọn đối tác</option>
                @foreach($ListPayMent as $listpayment)
                <option value="{{$listpayment['id']}}" <?= $listpayment['id'] == isset($item['partner_code']) ? 'selected' : '' ?>>{{$listpayment['code']}}</option>
                @endforeach
            </select>
            @error('partner_code')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-sort">Danh sách cổng thanh toán</label> <br>
            <select name="payment_merchant" id="payment_merchant" style="width: 83%;height: 40px">
                <option>Chọn cổng thanh toán</option>
                @foreach($ListPayMerchant as $items)
                <option value="{{$items['id']}}" <?= $items['id'] == isset($item['payment_merchant_id']) ? 'selected' : '' ?> onclick="abc();">{{$items['name']}}</option>
                @endforeach
            </select>
            @error('code')
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
            <label for="item-name">Sắp xếp</label>
            <input type="text" id="item-sort" name="sort" class="form-control col-md-10" value="{{ old('sort', isset($item['sort']) ? $item['sort'] : '') }}">
            @error('sort')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-sort">Thông tin kết nối đến các cổng thanh toán của từng đối tác</label>
            <input type="text" id="item-business" name="business" class="form-control col-md-10" value="{{ old('business', isset($item['business']) ? $item['business'] : '') }}">
            @error('business')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="registri_banking hidden" id="registri_banking">
    <h1 style="text-align: center;margin-top: 2rem;">Form đăng ký chuyển khoản</h1>
    <div class="box_form">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Mã cổng thanh toán</label>
                            <input type="text" id="item-code" name="code" class="form-control col-md-10" value="{{ old('code', isset($item['code']) ? $item['code'] : '') }}">
                            @error('code')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Mã đối tác</label>
                            <input type="text" id="item-partner_code" name="item-partner_code" class="form-control col-md-10" value="{{ old('item-partner_code', isset($item['code']) ? $item['code'] : '') }}"  readonly>
                            @error('')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Tên của chủ tài khoản</label>
                            <input type="text" id="item-name" name="name" class="form-control col-md-10" value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
                            @error('name')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Chi nhánh của tài khoản</label>
                            <input type="text" id="item-name" name="name" class="form-control col-md-10" value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
                            @error('name')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="item-thumb_path" name="thumb_path" value="{{ old('thumb_path', isset($item['thumb_path']) ? $item['thumb_path'] : '') }}">
                            <label class="title_img_filed">Ảnh đại diện ngân hàng
                                <span class="fa fa-info-circle" style="color: #017EFA" data-toggle="kt-popover" data-placement="right" data-content="Kích thước khuyến nghị: 1920x600. Dung lượng khuyến nghị: 400KB"></span>
                            </label>
                            <div class="banner_img_bound" id="image_preview_thumb_path">
                                <img src="{{ isset($item['thumb_path']) ? asset($item['thumb_path']) : asset('assets/media/bg/default_image.png') }}">
                            </div>
                            <span class="banner_attach_img">
                                <input type="file" id="thumb_path" name="thumb_path" onclick="previewBannerImage('thumb_path')">
                            </span>
                            @error('thumb_path')
                            <div class="form-group validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 form_right">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Tên cổng thanh toán</label>
                            <input type="text" id="item-name" name="name" class="form-control col-md-10" value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
                            @error('name')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Số tài khoản</label>
                            <input type="text" id="item-name" name="name" class="form-control col-md-10" value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
                            @error('name')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Thông tin kết nối đến ngân hàng</label>
                            <input type="text" id="item-name" name="name" class="form-control col-md-10" value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}">
                            @error('name')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Trạng thái</label> <br>
                            <select name="status" id="" style="width: 83%;height: 37px">
                                <option value="active" <?= isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' ?>>
                                    Active
                                </option>
                                <option value="inactive" <?= isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '' ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item-name">Vị trí sắp xếp</label>
                            <input type="text" id="item-sort" name="sort" class="form-control col-md-10" value="{{ old('sort', isset($item['sort']) ? $item['sort'] : '') }}" >
                            @error('sort')
                            <div class="validated">
                                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Mô tả</label>
                    <div class="kt-tinymce tinymce-h-200">
                        <textarea class="tinymce-mini" name="description" class="tox-target" value="{{ old('description') }}">{{ isset($item['description']) ? $item['description'] : ''  }}</textarea>
                    </div>
                </div>

            </div>
        </div>
        <div class="confirm">
            <h2 id="confirm">Xác nhận</h2>
        </div>
    </div>
</div>
