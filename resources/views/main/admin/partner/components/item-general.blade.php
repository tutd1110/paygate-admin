<div id="form_info">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="item-sort">Mã đối tác</label>
                <input type="hidden" id="idPartner" value="{{isset($item['id']) ? $item['id'] : ''}}" name="idPartner">
                @if(isset($item['code']))
                    <input type="text" id="item-code" name="code"
                           class="form-control col-md-10 item-code item-partner_code "
                           value="{{ $item['code'] }}" readonly>
                @else
                    <input type="text" id="item-code" name="code"
                           class="form-control col-md-10 item-code item-partner_code js-input-blur"
                           value="{{ old('code') }}" placeholder="Nhập mã đối tác">
                @endif
                <span class="text-danger validateJS valueCode_error "></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="item-name">Tên đối tác</label>
                <input type="text" id="item-name" name="name" class="form-control col-md-10 js-input-blur"
                       value="{{ old('name', isset($item['name']) ? $item['name'] : '') }}"
                       placeholder="Nhập tên đối tác">
                @error('name')
                <div class="validated">
                    <div class="invalid-feedback checkError">{{ $message }}</div>
                </div>
                @enderror
                <span class="text-danger validateJS valueName_error"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="item-name">Trạng thái</label> <br>
                <select name="status" id=""  class="form-control col-md-10">
                    <option
                        value="active" <?= isset($item['status']) && $item['status'] == 'active' ? 'selected' : '' ?> >
                        Hoạt động
                    </option>
                    <option
                        value="inactive" <?= isset($item['status']) && $item['status'] == 'inactive' ? 'selected' : '' ?> >
                        Không hoạt động
                    </option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Mô tả</label>
                <div class="kt-tinymce tinymce-h-200"  >
                <textarea id="myTextarea"  name="description" class="tinymce-mini" class="tox-target "
                          value="{{ old('description') }} "
                          placeholder="Mô tả đối tác">{{  isset($item['description']) ? $item['description'] : ''  }}</textarea>
                </div>
                @error('description')
                <div class="validated">
                    <div class="invalid-feedback checkError">{{ $message }}</div>
                </div>
                @enderror
                <span class="text-danger valueDescription_error "></span>
            </div>

        </div>
    </div>
</div>
<div class="row list_method" id="list_method">
    <div class="col-md-12" style="text-align: center">
        <h1>
            Danh sách cổng thanh toán
        </h1>
    </div>
    <div class="list_banking row">
        @foreach($listPayMerchant as $key => $payMerchant)
            @if($payMerchant['status'] == "active")
                <div class="form-check col-md-4">
                    <input class="form-check-input list_bank_input" data-id="{{$payMerchant['code']}}" type="checkbox"
                           value="{{$payMerchant['code']}}" name="payment_merchant[{{$payMerchant['code']}}]"
                    @if(isset($getIdMerchant))
                        {{ (in_array($payMerchant['id'],$getIdMerchant) ? 'checked':'') }}
                        @endif
                    >
                    <label class="form-check-label " for="flexCheckDefault">
                        {{$payMerchant['name']}}
                    </label>
                    <textarea cols="50" rows="4" data-id="{{$payMerchant['code']}}" id="text-area-{{$payMerchant['code']}}"
                              name="payment_merchant_business[{{$payMerchant['code']}}]"
                              class=" payment_merchant_business hidden form-control js-input-blur"
                              placeholder="Thông tin kết nối đến cổng thanh toán"><?php if (isset($getMerchant)) {
                            foreach ($getMerchant as $businessMerchant) {
                                if ($payMerchant['id'] == $businessMerchant['payment_merchant_id']) {
                                    echo $businessMerchant['business'];
                                }
                            }
                        } ?></textarea>
                    @error('payment_merchant_business')
                    <div class="validated">
                        <div class="invalid-feedback">{{ $message }}</div>
                    </div>
                    @enderror
                </div>
            @endif
        @endforeach

    </div>
    @include('main.admin.partner.components.list-banking')
</div>







