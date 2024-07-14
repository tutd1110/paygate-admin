<form action="" id="orderSearch" method="GET">
    <input id="id_limit" type="number" name="limit" value="" hidden>
    <input id="id_page" type="number" name="page" value="" hidden>
    <div style="" class="row">
        <div class="col-lg-5">
            <div class="form-group">
                    <input id="id_name" type="text" name="value" class="form-control" value="{{ request('value')  }}"
                           placeholder="Nhập tên, mã đối tác">
            </div>
        </div>
        <div class="col-lg-4" >
            <label class="col-form-label" style="text-align: center"></label>
            <input id="search_submit"  type="submit" class="col-sm-3 btn btn-brand btn-elevate btn-icon-sm button_status"
                   value="Tìm kiếm">
        </div>

    </div>

</form>


