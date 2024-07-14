<div class="row">
    <div class="col-md-12">
        <h1>Thông tin cá nhân :</h1>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name"> Họ và tên:</label>
                <input type="text" id="item-fullname" name="fullname" class="form-control col-md-10 js-input-blur"
                       value="{{ old('fullname', isset($item['name']) ? $item['name'] : '') }}"
                       placeholder="Nhập họ và tên">
                @error('fullname')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input type="hidden" id="item-thumb_path_input" name="thumb_path_input"
                       value="{{ old('thumb_path',isset($item['thumb_path']) ? $item['thumb_path'] : '')}}">
                <label class="title_img_filed ">Ảnh đại
                    diện
                    <span class="fa fa-info-circle" style="color: #017EFA" data-toggle="kt-popover"
                          data-placement="right"
                          data-content="Kích thước khuyến nghị: 1920x600. Dung lượng khuyến nghị: 400KB"></span>
                </label>
                <div class="banner_img_bound " id="image_preview_thumb_path"
                     onclick="document.getElementById('thumb_path').click();">
                    <img class="image_old"
                         src="{{ asset(old('thumb_path',isset($item['thumb_path']) ? asset($item['thumb_path']) : asset('assets/media/bg/default_image.png')))  }}">
                </div>
                <input type="button" id="loadFileXml" value="Chọn Ảnh"
                       onclick="document.getElementById('thumb_path').click();"
                       style="display: block;margin-top: 1vw;"/>
                <input type="file" style="display:none;" id="thumb_path" name="thumb_path"
                       onclick="previewBannerImage('thumb_path')"/>
                @error('thumb_path')
                <div class="form-group validated ">
                    <div class="invalid-feedback ">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name">Email:</label>
                <input type="email" id="item-email" name="email" class="form-control col-md-10 js-input-blur"
                       value="{{ old('email', isset($item['email']) ? $item['email'] : '') }}"
                       placeholder="Nhập địa chỉ email">
                @error('email')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name">Sô điện thoại:</label>
                <input type="number" id="item-phone" name="phone" min="9" max="12"
                       class="form-control col-md-10 js-input-blur"
                       value="{{ old('phone', isset($item['phone']) ? $item['phone'] : '') }}"
                       placeholder="Nhập số điện thoại">
                @error('phone')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="item-name">Địa chỉ:</label>
                <input type="text" id="item-address" name="address" class="form-control col-md-10 js-input-blur"
                       value="{{ old('address', isset($item['address']) ? $item['address'] : '') }}"
                       placeholder="Nhập địa chỉ ">
                @error('address')
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
        <h1>Một số thông tin trên hệ thống :</h1>
    </div>
    <input type="hidden" id="idSysUser" value="{{isset($item['id']) ? $item['id'] : ""}}">
    <div class="col-md-6">
        <div class="col-md-10">
            <div class="form-group">
                <label>Đối tác</label>
                @if(session('partner_code') == null)
                    <select id="value_partner_code" onchange="getvaluePartner();"
                            class="form-control select2 kt-select2"
                            name="partner_code">
                        <option value="" selected>Chọn Mã đối tác</option>
                        @foreach ($listPartner as $key => $items )
                            <option
                                {{ (old('partner_code') == $items['code']) ? 'selected' : (isset($item['partner_code']) &&  $item['partner_code'] == $items['code'] ? 'selected' : '' )}} value="{{ $items['code']}}"
                                style="display: none;"> {{$items['code']}} </option>
                        @endforeach
                    </select>
                @else
                    <input type="text" id="value_partner_code" name="partner_code"
                           class="form-control js-input-blur"
                           value="{{ session('partner_code') }}" readonly>
                @endif
                @error('partner_code')
                <div class="validated">
                    <div class="invalid-feedback">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-10">
            <div class="form-group">
                <label>Nhóm</label>
                <select id="value_name_group" multiple="multiple" class="form-control select2 kt-select2 "
                        name="name_group[]">
                    <option>Chọn nhóm</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label>Trạng thái</label> <br>
                <select name="status" id="" class="form-control col-md-10">
                    <option value="" selected>Chọn trạng thái</option>
                    <option value="active"
                        {{ (old('status') == 'active') ? 'selected' : (isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' ) }}>
                        Hoạt động
                    </option>
                    <option value="inactive"
                        {{ (old('status') == 'inactive') ? 'selected' : (isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '') }}>
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
    @if(session('owner') == "yes" && session('partner_code') == null)
        <div class="col-md-5">
            <div class="form-group" style="margin-top: 0.5rem;">
                <label>Owner</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                        <input type="radio" name="owner"
                               value="yes"
                               {{ (old('owner') == 'yes') ? 'checked' : (isset($item['owner']) && $item['owner'] == 'yes' ? 'checked' : "")  }} onclick="changeOwner();"
                               id="ownerYes">
                        Yes
                        <span></span>
                    </label>
                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                        <input type="radio" name="owner"
                               value="no" {{  (old('owner') == 'no') ? 'checked' : (isset($item['owner']) && $item['owner'] == 'no' ? 'checked' : "" ) }} >
                        No
                        <span></span>
                    </label>
                    @error('owner')
                    <div class="validated">
                        <div class="invalid-feedback">{{ $message }}</div>
                    </div>
                    @enderror
                    <input type="hidden" value="" id="valueNamePartner">

                </div>
            </div>
        </div>
    @endif

</div>
<div class="row">
    <div class="col-md-12">
        <h1>Langding Pages :</h1>
        <div class="">
            <input type="text" id="filterInput" class="form-control col-md-12 js-input-blur"
                   placeholder="Nhập để tìm kiếm LandingPage">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group" style="margin-left: 1rem;">
            <div class="row">
                @foreach($langingPages as $key => $langingPage)
                    <div class="col-md-4 filter_landing" style="padding-bottom: 2rem;">
                        <input class="form-check-input list_modules_input"
                               type="checkbox"
                               value="{{$langingPage['id']}}"
                               name="landing_page[]"
                               style="height: 1.6rem;margin-top: 8px;"
                        @if(isset($getIdLandingPage))
                            {{ (in_array($langingPage['id'],$getIdLandingPage) ? 'checked':'') }}
                        @endif >
                        <label class="form-check-label item-name " for="flexCheckDefault"
                               style="font-size: 1.5rem;color:#646c9a;">{{$langingPage['id'] . '-' . $langingPage['code']}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



