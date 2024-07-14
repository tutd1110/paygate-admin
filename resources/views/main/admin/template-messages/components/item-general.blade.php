<div class="row">
    <label for=""><h3>I. Đơn hàng</h3></label>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Tên SMS Template :</label>
            <div class="">
                <input placeholder="Nhập Template Name" class="form-control" name="template_name"
                       value="{{ old('template_name', isset($item['template_name']) ? $item['template_name'] : '') }}">
            </div>
            @error('template_name')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label> LandingPage </label>
            <select data-placeholder="Chọn LandingPage" id="id_landing_page_id" class="form-control kt-select2"
                    data-minimum-results-for-search="Infinity" name="landing_page_id">
                <option value="" selected> Chọn Landing Page</option>
                @foreach($dataLDP as $key => $landingPage)
                    @if(!empty($item['landing_page_id']))
                        @if(!empty($item['landing_page_id'])||$item['landing_page_id'] == \App\Http\Controllers\Admin\MessageTemplateController::DEFAULT_LDP_ID)
                        <option
                            {{($item['landing_page_id'] == $landingPage['id']) ? 'selected' : ''}}  value="{{$landingPage['id']}}">
                            ({{$landingPage['id']}}) {{$landingPage['domain_name']}}</option>
                        @endif
                    @else
                        <option value="{{$landingPage['id']}}">({{$landingPage['id']}}
                            ) {{$landingPage['domain_name']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    {{--    @endif--}}
    @error('landing_page_id')
    <div class="validated">
        <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
    </div>
    @enderror
</div>
<div class="row">
    @if(isset($templateMessages))
        <div class="col-md-3">
            <div class="form-group">
                <label> Trạng Thái: </label>
                <select class="status form-control" name="status">
                    <option
                        value="active" {{$templateMessages['status'] == 'active' ? 'selected' : '' }} >
                        Hoạt động
                    </option>
                    <option
                        value="inactive" {{ $templateMessages['status'] == 'inactive' ? 'selected' : '' }}>
                        Không hoạt động
                    </option>
                </select>
            </div>
        </div>
    @else
        <div class="col-md-3">
            <div class="form-group">
                <label> Trạng Thái: </label>
                <select class="status form-control" name="status">
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>
        </div>
    @endif
    <div class="col-md-3">
        <div class="form-group">
            <label>Code:</label>
            <div class="">
                <input placeholder="Nhập mã code" class="form-control" name="code"
                       value="{{ old('code', isset($item['code']) ? $item['code'] : '') }}">
            </div>
            @error('code')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Mã sự kiện:</label>
            <div class="">
                <input placeholder="Nhập mã sự kiện" class="form-control" name="event"
                       value="{{ old('event', isset($item['event']) ? $item['event'] : '') }}">
            </div>
            @error('event')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Bind Param:</label>
            <div class="">
                <input placeholder="Nhập bind param" class="form-control" name="bind_param"
                       value="{{ old('bind_param', isset($item['bind_param']) ? $item['bind_param'] : '') }}">
            </div>
            @error('bind_param')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Nội dung SMS: </label>
            <div class="kt-tinymce tinymce-h-200">
                <textarea class="tinymce-mini extra_textarea" name="content" placeholder="Nhập nội dung">
                    {{ old('content', isset($item['content']) ? $item['content'] : '') }}
                </textarea>
            </div>
            @error('content')
            <div class="validated">
                <div class="invalid-feedback" style="font-size: 12px">{{ $message }}</div>
            </div>
            @enderror
        </div>
    </div>
</div>
