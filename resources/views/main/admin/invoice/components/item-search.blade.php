<form action="{{route('invoices.index')}}" id="orderSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_code" type="text" name="code" class="form-control" value="{{$filter['code']??''}}"
                       placeholder="Nhập mã đơn hàng">
            </div>
        </div>
        <div class="col-lg-2">
            <div style="align-items: center;" class="form-group">
                <input id="id_phone" type="text" name="phone" class="form-control" value="{{$filter['phone']??''}}"
                placeholder="Nhập số điện thoại">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select data-placeholder="Chọn Phòng Ban" id="department_id" multiple="multiple"
                class="form-control select2 kt-select2" name="department_id[]" >
                   @foreach($datasDepartment as $key => $department)
                        @if(isset($filter['department_id']))
                            <option
                            {{  in_array($department['id'],$filter['department_id']) ? 'selected' : ''}}  value="{{$department['id']}}">
                            ({{$department['id']}}) {{$department['domain_name']}}</option>
                        @else
                            <option value="{{$department['id']}}">({{$department['id']}}
                                ) {{$department['domain_name']}}</option>
                        @endif
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-lg-2">
            <select data-placeholder="Chọn Phương thức thanh toán" id="id_merchant_banking_code" multiple="multiple" class="form-control select2 kt-select2"  name="merchant_code[]">
                @foreach($datasMerchant as $key => $paymentMerchant)
                    @if(isset($filter['merchant_code']))
                        <option {{  in_array($paymentMerchant['code'],$filter['merchant_code']) ? 'selected' : ''}}  value="{{$paymentMerchant['code']}}">{{$paymentMerchant['code']}}</option>
                    @if($paymentMerchant['code'] == 'transfer')
                        @foreach($paymentMerchant['banking'] as $banking)
                        <option {{in_array($paymentMerchant['code'].','.$banking['code'],$filter['merchant_code']) ? 'selected' : ''}} value="{{$paymentMerchant['code']}},{{$banking['code']}}">{{$paymentMerchant['code']}}({{$banking['code']}})</option>
                        @endforeach
                        @endif
                    @elseif($paymentMerchant['code'] == 'transfer')
                        @foreach($paymentMerchant['banking'] as $banking)
                            <option value="{{$paymentMerchant['code']}},{{$banking['code']}}">{{$paymentMerchant['code']}}({{$banking['code']}})</option>
                        @endforeach
                    @else
                        <option value="{{$paymentMerchant['code']}}">{{$paymentMerchant['code']}}</option>
                    @endif
                @endforeach
            </select>
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
                </select>
            </div>
        </div>

    </div>
    <div class="row">
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
        <div class="col-lg-2 date_flex d-flex justify-content-around align-items-baseline">
            <label>Ngày bắt đầu</label>
            <div class="form-group">
                <input id="id_start_date" type="date" name="start_date" class="form-control" value="{{$filter['start_date']??''}}"
                            placeholder="Nhập ngày bắt đầu">
            </div>
        </div>
        <div class="col-lg-2 date_flex d-flex justify-content-around align-items-baseline">
            <label>Ngày kết thúc</label>
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



