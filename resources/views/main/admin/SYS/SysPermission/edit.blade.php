@extends('main.layout.master')

@section('title', 'Danh sách ngân hàng ')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
@stop
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Danh sách ngân hàng </h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('sys_permission.index') }}" class="kt-subheader__breadcrumbs-link">Danh sách
                            các ngân hàng </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:" class="kt-subheader__breadcrumbs-link"></a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('sys_permission.index') }}" class="btn btn-clean kt-margin-r-10">
                            <i class="la la-arrow-left"></i>
                            <span class="kt-hidden-mobile">Quay lại</span>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-save btn-brand" onclick="$('#formClass').submit()">
                                <i class="la la-check mr-1"></i>
                                <span class="kt-hidden-mobile"> Lưu</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-grid kt-wizard-v3--white" id="kt_wizard_v3" data-ktwizard-state="step-first">

                        <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3 kt-wizard-v3__wrapper">
                            <form class="px-5 py-3 kt-form kt-form--label-right" id="formClass" method="post"
                                  action="{{ route('sys_permission.update', $getListPermision['id']) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="item-name">Tên quyền:</label>
                                                <input type="text" id="item-code" name="name"
                                                       class="form-control col-md-10 js-input-blur " value="{{ $getListPermision['name'] }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="item-name">Tên quyền Alias:</label>
                                                <input type="text" id="item-name" name="name_alias" class="form-control col-md-10 js-input-blur"
                                                       value="{{ old('name_alias', isset($getListPermision['name_alias']) ? $getListPermision['name_alias'] : '') }}"
                                                       placeholder="Nhập tên ngân hàng">
                                                @error('name_alias')
                                                <div class="validated">
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </div>
@stop
@section('script')
    <script src="{{asset('assets/js/check-list.js?v=1.0.1')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/program.js?v=1.0.3')}}" type="text/javascript"></script>
    <script type="text/javascript">

    </script>
@stop
