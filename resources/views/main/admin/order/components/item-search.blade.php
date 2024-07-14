<form action="{{route('pgw_orders.index')}}" id="orderSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <input id="id_code" type="text" name="code" class="form-control" value="{{$filter['code']??''}}"
                       placeholder="Nhập Mã đơn hàng">
            </div>
        </div>
        @if(session('partner_code'))
        <div class="col-lg-2">
            <div style="align-items: center;" class="form-group">
                <select style="-webkit-appearance: none;" disabled id="id_partner_code" class="form-control" name="partner_code[]">
                    <option value="{{session('partner_code')}}" selected> {{session('partner_code')}}</option>
                </select>
            </div>
        </div>
        @elseif(empty(session('partner_code')))
            <div class="col-lg-2">
                <div style="align-items: center;" class="form-group">
                    <select data-placeholder="Chọn Mã đối tác" id="id_partner_code" multiple="multiple" class="form-control select2 kt-select2" name="partner_code[]">
                        @foreach($dataPartner as $key => $partner)
                            @if(isset($filter['partner_code']))
                            <option {{ is_array($filter['partner_code']) && in_array($partner['code'], $filter['partner_code']) ? 'selected' : ''}} value="{{$partner['code']}}">({{$partner['id']}}) {{$partner['code']}}</option>
                            @else
                                <option value="{{$partner['code']}}">({{$partner['id']}}) {{$partner['code']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        @if(!empty(session('landing_page')))
            <div class="col-lg-4">
                <div class="form-group">
                    <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" multiple="multiple"
                            class="form-control select2 kt-select2" name="landing_page_id[]">
                        @foreach($dataLDP as $key => $landingPage)
                            @if(isset($filter['landing_page_id']) && !empty($filter['search_submit']))
                                <option
                                    {{  in_array($landingPage['id'],$filter['landing_page_id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">
                                    ({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>
                            @else
                                <option value="{{$landingPage['id']}}">({{$landingPage['id']}}
                                    ) {{$landingPage['domain_name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <div class="col-lg-4">
                <div class="form-group">
                    <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" multiple="multiple"
                            class="form-control select2 kt-select2" name="landing_page_id[]">
                        @foreach($dataLDP as $key => $landingPage)
                            @if(isset($filter['landing_page_id']))
                                <option
                                    {{  in_array($landingPage['id'],$filter['landing_page_id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">
                                    ({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>
                            @else
                                <option value="{{$landingPage['id']}}">({{$landingPage['id']}}
                                    ) {{$landingPage['domain_name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        <div class="col-lg-2">
            <select data-placeholder="Chọn Phương thức thanh toán" id="id_merchant_banking_code" multiple="multiple" class="form-control select2 kt-select2"  name="merchant_banking_code[]">
                @foreach($dataMerchant as $key => $paymentMerchant)
                    @if(isset($filter['merchant_banking_code']))
                        <option
                            {{  in_array($paymentMerchant['code'],$filter['merchant_banking_code']) ? 'selected' : ''}}  value="{{$paymentMerchant['code']}}">{{$paymentMerchant['code']}}</option>
                        @if($paymentMerchant['code'] == 'transfer')
                            @foreach($paymentMerchant['banking'] as $banking)
                                <option
                                    {{in_array($paymentMerchant['code'].','.$banking['code'],$filter['merchant_banking_code']) ? 'selected' : ''}} value="{{$paymentMerchant['code']}},{{$banking['code']}}">{{$paymentMerchant['code']}}
                                    ({{$banking['code']}})
                                </option>
                            @endforeach
                        @endif
                    @elseif($paymentMerchant['code'] == 'transfer')
                        @foreach($paymentMerchant['banking'] as $banking)
                            <option
                                value="{{$paymentMerchant['code']}},{{$banking['code']}}">{{$paymentMerchant['code']}}
                                ({{$banking['code']}})
                            </option>
                        @endforeach
                    @else
                        <option value="{{$paymentMerchant['code']}}">{{$paymentMerchant['code']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <input id="order_client_id" type="text" name="order_client_id" class="form-control" value="{{$filter['order_client_id']??''}}"
                       placeholder="Nhập Client ID">
            </div>
        </div>
    </div>
    <div class="row mt-table">
        <div class="col-lg-2">
            <div class="form-group">
                <input id="id_vpc_MerchTxnRef" type="text" name="vpc_MerchTxnRef" class="form-control" value="{{$filter['vpc_MerchTxnRef']??''}}"
                       placeholder="Nhập Mã thanh toán">
            </div>
        </div>
        <div class="col-lg-2">
            <div style="align-items: center;" class="form-group">
                <select id="id_status" class="form-control kt-select2" data-minimum-results-for-search="Infinity"
                        name="status">
                    <option selected value="">Chọn trạng thái</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'new' ? 'selected' : ''}}  value='new'>New</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'processing' ? 'selected' : ''}}  value='processing'>Processing</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'waiting' ? 'selected' : ''}}  value='waiting'>Waiting</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'paid' ? 'selected' : ''}} value='paid'>Paid</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'refund' ? 'selected' : ''}} value='refund'>Refund</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'cancel' ? 'selected' : ''}} value='cancel'>Cancel</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'expired' ? 'selected' : ''}} value='expired'>Expired</option>
                </select>
            </div>
        </div>
        <div class="date_flex col-lg-2 d-flex justify-content-around align-items-baseline">
                <div><label for="id_start_date">Ngày bắt thúc</label></div>
                <div class="form-group">
                    <input id="id_start_date" type="date" name="start_date" class="form-control" value="{{$filter['start_date']??''}}"
                        placeholder="Nhập ngày bắt đầu">
                </div>
        </div>
        <div class="date_flex  col-lg-2 d-flex justify-content-around align-items-baseline">
                <div><label for="id_end_date">Ngày kết thúc</label></div>
                <div style="align-items: center;" class="form-group">
                    <input id="id_end_date" type="date" name="end_date" class="form-control" value="{{$filter['end_date']??''}}"
                        placeholder="Nhập ngày kết thúc">
                </div>
        </div>
        <div class="col-lg-4" style="margin-bottom: 30px">
            <input id="search_submit" type="submit" class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status"
                   value="Tìm kiếm">
            <button type="button" onclick="resetSearch()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: lightgrey">Bỏ lọc
            </button>
            <button type="button" onclick="exportExcel()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: darkgreen;color: white;right: 0">Export
            </button>
        </div>
    </div>
</form>



