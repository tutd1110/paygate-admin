<form action="" action="" id="requestSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="kt-input-icon kt-input-icon--right">
                    <input type="text" name="name" class="form-control"
                           placeholder="Nhập tên nhóm"
                           id="name" >
                    <span class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="partner_code" name="partner_code">
                    <option value="" selected>Chọn mã đối tác</option>
                        @foreach ($listPartner as $key => $items )
                            <option {{ isset($filter['partner_code']) &&  $filter['partner_code'] == $items['code'] ? 'selected' : ''}} value="{{ $items['code']}}" > {{$items['code']}} </option>
                        @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control" id="status" name="status">
                    <option value="">Chọn trạng thái</option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'active' ? 'selected' : ''}} value='active'> Hoạt động </option>
                    <option {{ isset($filter['status']) && $filter['status'] == 'inactive' ? 'selected' : ''}} value='inactive'> Không hoạt động </option>
                </select>
            </div>
        </div>
        <div class="date_flex col-md-3 d-flex justify-content-around align-items-baseline">
            <label>Ngày tạo</label>
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
        <div class="col-lg-4">
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
