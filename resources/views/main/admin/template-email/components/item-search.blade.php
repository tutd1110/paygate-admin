<form action="{{route('emailTemplate.index')}}" id="templateSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_code" type="text" maxlength="50" name="code" class="form-control" value="{{$filter['code']??''}}"
                       placeholder="Nhập mã code">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input id="id_name" type="text" maxlength="30" name="name" class="form-control" value="{{$filter['name']??''}}"
                       placeholder="Nhập email name">
            </div>
        </div>
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
        {{-- <div class="col-lg-3">
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
        </div> --}}
    </div>
</form>



