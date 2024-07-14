<form action="" action="" id="requestSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div class="row">
        <div class="col-md-3">
            <div style="align-items: center;" class="form-group">
                <select id="value"  class="form-control select2 kt-select2" name="partner_code">
                    <option value="" selected>Chọn Mã đối tác</option>
                    @foreach($listPartner as $key => $partner)
                        @foreach ($listPartner as $key => $items )
                            <option {{ isset($filter['partner_code']) &&  $filter['partner_code'] == $items['id'] ? 'selected' : ''}} value="{{ $items['id']}}" > {{$items['code']}} </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control" id="status" name="paid_status">
                    <option value="">Chọn trạng thái</option>
                    <option
                        {{ isset($filter['paid_status']) && $filter['paid_status'] == 'success' ? 'selected' : ''}}  value='success'>
                        Success
                    </option>
                    <option
                        {{ isset($filter['paid_status']) && $filter['paid_status'] == 'unsuccess' ? 'selected' : ''}}  value='unsuccess'>
                        Unsuccess
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="list_merchant" name="merchant_id">
                    <option value="" selected>Chọn phương thức thanh toán</option>
                    @foreach ($listPaymentMerchant as $key => $items )
                        <option {{ isset($filter['merchant_id']) &&  $filter['merchant_id'] == $items['id'] ? 'selected' : ''}} value="{{ $items['id']}}"> {{$items['code']}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="list_banking"  name="banking_id">
                    <option value="" selected>Chọn ngân hàng</option>
                    @foreach ($listBanking as $key => $items )
                        <option {{ isset($filter['banking_id']) &&  $filter['banking_id'] == $items['id'] ? 'selected' : ''}} value="{{ $items['id']}}" > {{$items['code']}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="kt-input-icon kt-input-icon--right">
                    <input type="text" name="payment_code" class="form-control" placeholder="Nhập Mã thanh toán"
                           id="payment_code" value="{{$filter['payment_code']??''}}">
                    <span class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="kt-input-icon kt-input-icon--right">
                    <input type="text" name="transsion_id" class="form-control" placeholder="Nhập transsion"
                           id="transsion" value="{{$filter['transsion_id']??''}}">
                    <span class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 date_flex d-flex justify-content-around align-items-baseline">
            <label>Ngày</label>
            <div class="form-group row">
                <div style="margin-left: 10px;">
                    <div class="input-daterange input-group">
                        <input type="date" class="form-control" id="day_start" name="start_date"
                               value="{{$filter['start_date']??''}}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="date" class="form-control" id="day_end" name="end_date"
                               value="{{$filter['end_date']??''}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <input id="search_submit" type="submit"
                   class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status" value="Tìm kiếm">
            <button type="button" onclick="resetSearch()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: lightgrey">Bỏ lọc
            </button>
        </div>
    </div>


</form>
