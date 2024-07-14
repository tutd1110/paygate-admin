<form action="{{route('template_messages.index')}}" id="templateSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <input type="text" maxlength="50" name="code" class="form-control" value="{{$filter['code']??''}}"
                       placeholder="Nhập mã code">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input type="text" maxlength="30" name="event" class="form-control" value="{{$filter['event']??''}}"
                       placeholder="Nhập mã đơn hàng">
            </div>
        </div>
{{--        @if(!empty(session('landing_page')))--}}
{{--            <div class="col-lg-3">--}}
{{--                <div class="form-group">--}}
{{--                    <label> Landing Page </label>--}}
{{--                    <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" multiple="multiple"--}}
{{--                            class="form-control select2 kt-select2" name="landing_page_id[]">--}}
{{--                        @foreach($dataLDP as $key => $landingPage)--}}
{{--                            @if(isset($filter['landing_page_id']) && !empty($filter['search_submit']))--}}
{{--                                <option--}}
{{--                                    {{  in_array($landingPage['id'],$filter['landing_page_id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">--}}
{{--                                    ({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>--}}
{{--                            @else--}}
{{--                                <option value="{{$landingPage['id']}}">({{$landingPage['id']}}--}}
{{--                                    ) {{$landingPage['domain_name']}}</option>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @else--}}
            <div class="col-lg-3">
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
{{--        @endif--}}
        <div class="col-lg-3">
            <div style="align-items: center;" class="form-group">
                <select id="id_status" class="form-control kt-select2" data-minimum-results-for-search="Infinity"
                        name="status">
                    <option selected value="">Chọn trạng thái</option>
                    <option
                        {{ isset($filter['status']) && $filter['status'] == 'active' ? 'selected' : ''}}  value='active'>
                        Hoạt động
                    </option>
                    <option
                        {{ isset($filter['status']) && $filter['status'] == 'inactive' ? 'selected' : ''}}  value='inactive'>
                        Không hoạt động
                    </option>

                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4" style="margin-bottom: 30px">
            <input id="search_submit" type="submit" class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status"
                   value="Tìm kiếm">
            <button type="button" onclick="resetSearch()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                    style="background-color: lightgrey">Bỏ lọc
            </button>
            {{--            <button type="button" onclick="exportExcel()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"--}}
            {{--                    style="background-color: darkgreen;color: white;right: 0">Export--}}
            {{--            </button>--}}
        </div>
    </div>
    <div class="row">

    </div>
</form>



