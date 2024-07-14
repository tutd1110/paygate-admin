<form action="{{route('randomGift.index')}}" id="orderSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_full_name" type="text" name="full_name" class="form-control"
                value="{{ $filter['full_name']??'' }}" placeholder="Nhập họ và tên">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_email" type="email" name="email" class="form-control" value="{{ $filter['email']??'' }}" placeholder="Nhập email">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_phone" type="text" name="phone" class="form-control" value="{{ $filter['phone']??'' }}" placeholder="Nhập số điện thoại">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_bill_code" type="text" name="bill_code" class="form-control" value="{{ $filter['bill_code']??'' }}" placeholder="Mã bill">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <select data-placeholder="Chọn loại quà" id="id_gift" multiple="multiple" class="form-control select2 kt-select2" name="gift_id[]">
                    @foreach($listGiftInfo as $key => $giftInfo)
                        @if(isset($filter['gift_id']))
                        <option {{ in_array($giftInfo['id'],$filter['gift_id'])  ? 'selected' : ''}}  value="{{$giftInfo['id']}}">({{$giftInfo['id']}}) {{$giftInfo['name']}}</option>
                        @else
                            <option value="{{$giftInfo['id']}}">({{$giftInfo['id']}}) {{$giftInfo['name']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_medium" type="text" name="utm_medium" class="form-control" value="{{ $filter['utm_medium']??'' }}" placeholder="Nhập medium">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_source" type="text" name="utm_source" class="form-control" value="{{ $filter['utm_source']??'' }}" placeholder="Nhập source">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_campaign" type="text" name="utm_campaign" class="form-control" value="{{ $filter['utm_campaign']??'' }}" placeholder="Nhập campaign">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <select id="id_supplier_code" class="form-control kt-select2" data-minimum-results-for-search="Infinity"
                        name="supplier_code" style="-moz-appearance: none;-webkit-appearance:none;appearance: none;">
                    <option selected value="">Chọn BU</option>
                    <option {{ isset($filter['supplier_code']) && $filter['supplier_code'] == 'HOCMAI' ? 'selected' : ''}}  value='HOCMAI'>HOCMAI</option>
                    <option {{ isset($filter['supplier_code']) && $filter['supplier_code'] == 'ICANTECH' ? 'selected' : ''}}  value='ICANTECH'>ICANTECH</option>
                    <option {{ isset($filter['supplier_code']) && $filter['supplier_code'] == 'ICANCONNECT' ? 'selected' : ''}}  value='ICANCONNECT'>ICANCONNECT</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 d-flex justify-content-around align-items-baseline">
            <div><label for="id_start_date">Ngày kết thúc</label></div>
            <div class="form-group">
                <input id="id_start_date" type="date" name="start_date" class="form-control"
                value="{!! isset($filter['start_date']) ? $filter['start_date'] : '' !!}"
                    placeholder="Nhập ngày quay">
            </div>
        </div>
        <div class="col-lg-2 d-flex justify-content-around align-items-baseline">
            <div><label for="id_end_date">Ngày kết thúc</label></div>
            <div style="align-items: center;" class="form-group">
                <input id="id_end_date" type="date" name="end_date" class="form-control"
                    value="{!! isset($filter['end_date']) ? $filter['end_date'] : '' !!}"
                    placeholder="Nhập ngày kết thúc">
            </div>
        </div>
        <div class="col-lg-5" style="margin-bottom: 30px">
            <input id="search_submit" type="submit" class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status"
                   value="Tìm kiếm">
            <button type="button" onclick="resetSearch()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: lightgrey">Bỏ lọc
            </button>
            <button type="submit" name="export" value="1" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: darkgreen;color: white;right: 0">Export
            </button>
{{--            <button type="button" onclick="exportExcel()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"--}}
{{--                    style="background-color: darkgreen;color: white;right: 0">Export--}}
{{--            </button>--}}
        </div>

    </div>
</form>



