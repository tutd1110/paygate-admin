<form action="" action="" id="requestSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="kt-input-icon kt-input-icon--right">
                    <input type="text" name="module_alias" class="form-control"
                           placeholder="Nhập module alias"
                           id="module_alias" value="{{ request('value')}}">
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
        <div class="col-md-3">
            <div>
                <input id="search_submit" type="submit"
                       class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status" value="Tìm kiếm">
                <button type="button" onclick="resetSearch()" class="btn btn-light col-sm-3 btn-elevate btn-icon-sm"
                        style="background-color: lightgrey">Bỏ lọc
                </button>
            </div>
        </div>

    </div>

</form>
