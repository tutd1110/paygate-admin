@extends('main.layout.master')

@section('title', 'Quản lý Môn học')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Môn Học</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('subject.index') }}" class="kt-subheader__breadcrumbs-link">Quản lý môn học </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">{{ $getSubjects['name']}}</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('subject.index') }}" class="btn btn-clean kt-margin-r-10">
                            <i class="la la-arrow-left"></i>
                            <span class="kt-hidden-mobile">Quay lại</span>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-save btn-brand" onclick="$('#formSubjects').submit()">
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
                        <div class="kt-grid__item kt-wizard-v3">

                            <!--begin: Navigations -->
                            <div class="kt-wizard-v3__nav">
                                <div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
                                    <div class="kt-wizard-v3__nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                                        <div class="kt-wizard-v3__nav-body">
                                            <div class="kt-wizard-v3__nav-label">
                                                Thông tin cơ bản
                                            </div>
                                            <div class="kt-wizard-v3__nav-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Navigations -->
                        </div>
                        <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3 kt-wizard-v3__wrapper">
                            <form class="px-5 py-3 kt-form kt-form--label-right" id="formSubjects" method="post" action="{{ route('subject.update', $getSubjects['id']) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="item-id" name="id" value="{{ $getSubjects ? $getSubjects['id'] : 0 }}">

                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                    @include('main.admin.subject.components.item-general', [
                                        'item' => $getSubjects,
                                    ])
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
