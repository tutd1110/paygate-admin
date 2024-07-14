<div class="overlay " id="overlay"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item-sort">Mã đối tác</label> <br>
            <select name="partner_code" id="partner_code" style="width: 83%;height: 40px">
                <option value="">Chọn đối tác</option>
                @foreach($ListPayMent as $key => $listpayment)
                    <option
                        value="{{$listpayment['id']}}" <?= $listpayment['id'] == isset($item['partner_code']) ? 'selected' : '' ?>>{{$listpayment['code']}}</option>
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
                <option value="">Chọn cổng thanh toán</option>
                @foreach($ListPayMerchant as $items)
                    <option
                        value=" {{$items['id']}}" <?= $items['id'] == isset($item['payment_merchant_id']) ? 'selected' : '' ?> >{{$items['name']}}</option>
                @endforeach
            </select>
            @error('payment_merchant')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="hidden" id="show_sort">
    <div class="row ">
        <div class="col-md-6">
            <div class="form-group">
                <label for="item-name">Sắp xếp</label>
                <input type="number" id="item-sort" name="sort" class="form-control col-md-10"
                       value="{{ old('sort', isset($item['sort']) ? $item['sort'] : '') }}">
                @error('sort')
                <div class="validated">
                    <div class="invalid-feedback" style="font-size: 12px" id="error">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="item-sort">Thông tin kết nối đến các cổng thanh toán của từng đối tác</label>
                <input type="text" id="item-business" name="business" class="form-control col-md-10"
                       value="{{ old('business', isset($item['business']) ? $item['business'] : '') }}">
                @error('business')
                <div class="validated">
                    <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>
