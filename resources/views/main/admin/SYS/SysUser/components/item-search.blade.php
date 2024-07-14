<form action="" action="" id="requestUser" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="kt-input-icon kt-input-icon--right">
                    <input type="text" name="name_email" class="form-control"
                           placeholder="Nhập tên hoặc email người dùng cần tìm"
                           id="" value="{{ request('name_email')}}">
                    <span class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span><i class="la la-search"></i></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="list_merchant" name="group_id">
                    <option value="" selected>Chọn nhóm quyền</option>
                    @if(isset($arrConstant['listGroup']))
                    @foreach ($arrConstant['listGroup'] as $key => $listGroup )
                        <option {{ isset($arrConstant['filter']['group_id']) &&  $arrConstant['filter']['group_id'] == $listGroup['id'] ? 'selected' : ''}} value="{{ $listGroup['id']}}"> {{$listGroup['name']}} </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control" id="status" name="status">
                    <option value="" selected>Chọn trạng thái</option>
                    <option {{ isset($arrConstant['filter']['status']) && $arrConstant['filter']['status'] == 'active' ? 'selected' : ''}} value='active'> Hoạt động</option>
                    <option {{ isset($arrConstant['filter']['status']) && $arrConstant['filter']['status'] == 'inactive' ? 'selected' : ''}} value='inactive'> Không hoạt động</option>
                    <option {{ isset($arrConstant['filter']['status']) && $arrConstant['filter']['status'] == 'deleted' ? 'selected' : ''}} value='deleted'> Ngừng hoạt động</option>
                </select>
            </div>
        </div>
        @if(session('owner') == "yes" && session('partner_code') == null)
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="" name="partner_code">
                    <option value="" selected>Chọn mã đối tác</option>
                    @if(isset($arrConstant['listPartner']))
                    @foreach($arrConstant['listPartner'] as $key => $items)
                            <option
                                {{ isset($arrConstant['filter']['partner_code']) &&  $arrConstant['filter']['partner_code'] == $items['code'] ? 'selected' : ''}} value="{{ $items['code']}}"> {{$items['code']}} </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-3 date_flex d-flex justify-content-around align-items-baseline">
            <label>Ngày</label>
            <div class="form-group row">
                <div style="margin-left: 10px;">
                    <div class="input-daterange input-group">
                        <input type="date" class="form-control" id="day_start" name="start_date"
                               value="{{$arrConstant['filter']['start_date']??''}}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="date" class="form-control" id="day_end" name="end_date"
                               value="{{$arrConstant['filter']['end_date']??''}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2 kt-select2" id="" name="landing_page">
                    <option value="" selected>Chọn landingpage</option>
                @if(isset($arrConstant['listLandingPage']))
                    @foreach($arrConstant['listLandingPage'] as $key => $items)
                            <option
                                {{ isset($arrConstant['filter']['landing_page']) &&  $arrConstant['filter']['landing_page'] == $items['id'] ? 'selected' : ''}} value="{{ $items['id']}}"> {{$items['code']}} </option>
                        @endforeach
                    @endif
                </select>
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
