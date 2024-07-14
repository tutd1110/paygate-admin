@extends('main.layout.master')
@section('title', 'Thêm mới người dùng ')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('sys_user.index') }}" class="kt-subheader__breadcrumbs-link">Danh sách người
                            dùng </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Thêm mới người dùng</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('sys_user.index') }}" class="btn btn-clean kt-margin-r-10">
                            <i class="la la-arrow-left"></i>
                            <span class="kt-hidden-mobile">Quay lại</span>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-save btn-brand" onclick="SubmitForm()">
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
                            <form class="px-5 py-3 kt-form kt-form--label-right" id="formProgram" method="post"
                                  action="{{ route('sys_user.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    @include('main.admin.SYS.SysUser.components.item-general', [
                                        'item' => [],
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
    <script src="{{asset('assets/js/changeOwnerUser.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        function SubmitForm() {
            $('#formProgram').submit();
        }

        $('#thumb_path').change(e => {
            if ($('#thumb_path').prop('files')[0].name) {
                $('#item-thumb_path_input').val($('#thumb_path').prop('files')[0].name);
            }
        })
        const inputBlurs = $('.js-input-blur');
        [...inputBlurs].forEach(inputBlur => {
            $(inputBlur).focus(e => {
                let parentInputChecked = $(inputBlur).parent();
                let validatedElement = $(parentInputChecked).children('.validated');
                if ($(validatedElement).attr('class') && $(validatedElement).attr('class') == 'validated') {
                    $(validatedElement).remove();
                }
            })
        })
        $('.select2').select2({
            width: '100%',
            closeOnSelect: false
        })
        function getvaluePartner() {
            $('#value_name_group').html('');
            var conceptName = $('#value_partner_code').val();
            document.getElementById("valueNamePartner").value = conceptName;
            // kiểm tra xem có tổn tại owner ở dạng yes hay không
            const checkbox = document.getElementById("ownerYes");
            if (checkbox.checked) {
                document.getElementById("ownerYes").checked = false;
            }
            $.ajax({
                method: 'POST',
                url: '/get_name_group',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {partner_code: conceptName},
                success: function (data) {
                    var getData = data.listData;
                    getData.forEach(e => {
                        $('#value_name_group').append(`<option value=${e.id}>
                                       ${e.name}
                                  </option>`);
                    })
                },
            });
        }
        var conceptName = $('#value_partner_code').val();
        $.ajax({
            method: 'POST',
            url: '/get_name_group',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {partner_code: conceptName},
            success: function (data) {
                var getData = data.listData;
                getData.forEach(e => {
                    $('#value_name_group').append(`<option value=${e.id}>
                                       ${e.name}
                                  </option>`);
                })
            },
        });
    </script>
@stop