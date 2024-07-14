<div class="row">
    <label for=""><h3>I. Đơn hàng</h3></label>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label> LandingPage </label>
            <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" class="form-control selectSearch"
                    name="landing_page_id">
                @foreach($dataLDP as $key => $landingPage)
                    @if(isset($filter['landing_page_id']))
                        <option
                            {{  in_array($landingPage['id'],$filter['landing_page_id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">
                            ({{$landingPage['id']}}) {{$landingPage['code']}}</option>
                    @else
                        <option value="{{$landingPage['id']}}">({{$landingPage['id']}}
                            ) {{$landingPage['domain_name']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <label for=""><h3>II. Thông Tin Khách Hàng:</h3></label>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Tên khách hàng :</label>
            <div class="">
                <input placeholder="Nhập tên khách hàng" class="form-control" name="full_name" value="" id="full_name_id">
                <span id="error_required_full_name_id" style="font-size: 12px;color: #fd397a">
                </span>
            </div>
            @error('full_name')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Số Điện Thoại:</label>
            <div class="">
                <input placeholder="Nhập số điện thoại" class="form-control" name="phone" value="" id="phone_id">
                <span id="error_required_phone_id" style="font-size: 12px;color: #fd397a"></span>
            </div>
            @error('phone')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Email Khách Hàng:</label>
            <div class="">
                <input placeholder="Nhập email khách hàng" class="form-control" name="email" value="">
            </div>
            @error('email')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Địa Chỉ:</label>
            <div class="">
                <input placeholder="Nhập địa chỉ" class="form-control" name="address" value="">
            </div>
            @error('address')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <label for=""><h3>III. Sản phẩm:</h3></label>
</div>
<div class="row">

    <div class="table-responsive">
        <table id="id_table_product" class="table table-bordered"
               style="font-family: Arial;vertical-align: middle;">
            <thead style="text-align: center; vertical-align: middle">
            <tr>
                <th style="vertical-align: middle;">STT</th>
                <th style="vertical-align: middle;">ID</th>
                <th style="vertical-align: middle;">Tên Sản Phẩm</th>
                <th style="vertical-align: middle;">Loại Sản Phẩm</th>
                <th style="vertical-align: middle;">Đơn Giá (VND)</th>
                <th style="vertical-align: middle;">Số Lượng</th>
                <th style="vertical-align: middle;">Tổng Giá (VND)</th>
                <th style="vertical-align: middle;">Thao tác</th>
            </tr>
            </thead>
            <tbody id="productList">
            </tbody>
        </table>
    </div>
    <div class="col text-center" id="add_product_id" onclick="showAddProduct()">
        <label for=""><h4><i class="fa fa-plus-circle" style="color:#3498db;"></i></h4></label>
        <p hidden id="error_product_list" style="font-size: 18px;color: #fd397a">Product List is currently empty !</p>
    </div>

</div>
<div class="row">
    <label for=""><h3>IV. Thông Tin Thêm:</h3></label>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Mã Giảm Giá:</label>
            <div class="">
                <input placeholder="Nhập mã giảm giá" class="form-control" name="item_discount[]" value="">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>URL Return True:</label>
            <div class="">
                <input placeholder="Nhập URL Return True..." class="form-control" name="return_url_true" value="">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>URL Return False:</label>
            <div class="">
                <input placeholder="Nhập URL Return Fasle..." class="form-control" name="return_url_false" value="">
            </div>
        </div>
    </div>
</div>













