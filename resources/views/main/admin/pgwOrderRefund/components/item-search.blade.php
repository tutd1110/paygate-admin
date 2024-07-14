<form action="{{route('pgw_order_refund.index')}}" id="orderRefundSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <input id="id_code" type="text" name="code" class="form-control" value="{{$filter['code']??''}}"
                       placeholder="Nhập mã đơn hàng">
            </div>
        </div>
        @if(session('partner_code'))
            <div class="col-lg-3">
                <div style="align-items: center;" class="form-group">
                    <select disabled id="id_partner_code" class="form-control" name="partner_code[]">
                        <option value="{{session('partner_code')}}" selected> {{session('partner_code')}}</option>
                    </select>
                </div>
            </div>
        @elseif(empty(session('partner_code')))
            <div class="col-lg-3">
                <div style="align-items: center;" class="form-group">
                    <select data-placeholder="Chọn Mã đối tác" id="id_partner_code" multiple="multiple" class="form-control select2 kt-select2" name="partner_code[]">
                        @foreach($dataPartner as $key => $partner)
                            @if(isset($filter['partner_code']))s
                            <option {{ in_array($partner['code'],$filter['partner_code'])  ? 'selected' : ''}}  value="{{$partner['code']}}">({{$partner['id']}}) {{$partner['code']}}</option>
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
                    <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" multiple="multiple" class="form-control select2 kt-select2" name="landing_page_id[]">
                        @if(isset($dataPartner))
                            @foreach($dataLDP as $key => $landingPage)
                                @if(isset($filter['landing_page_id']))
                                    <option {{  in_array($landingPage['id'],$filter['landing_page_id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>
                                @else
                                    <option value="{{$landingPage['id']}}">({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        @endif
        <div class="col-lg-3">
            <div style="align-items: center;" class="form-group">
                <select style="-webkit-appearance: none !important;" id="id_status" class="form-control kt-select2" data-minimum-results-for-search="Infinity"
                        name="status">
                    <option selected value="">Chọn trạng thái</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'request' ? 'selected' : ''}}  value='request'>Request</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'refused' ? 'selected' : ''}}  value='refused'>Refused</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'appoved' ? 'selected' : ''}}  value='appoved'>Appoved</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'finish' ? 'selected' : ''}} value='finish'>Finish</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-2 date_flex d-flex justify-content-around align-items-baseline">
            <label for="">Ngày bắt đầu</label>
            <div class="form-group">
                <input id="id_start_date" type="date" name="start_date" class="form-control" value="{{$filter['start_date']??''}}"
                        placeholder="Nhập ngày bắt đầu">
            </div>
        </div>
        <div class="col-2 date_flex d-flex justify-content-around align-items-baseline">
            <label for="">Ngày kết thúc</label>
            <div class="form-group">
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



