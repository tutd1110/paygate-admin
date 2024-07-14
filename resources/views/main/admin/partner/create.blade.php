@extends('main.layout.master')
@section('title', 'Danh sách đối tác')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
@stop

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-grid__item kt-wizard-v3">

            <!--begin: Navigations -->
            <div class="kt-wizard-v3__nav">
                <div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
                    <div class="kt-wizard-v3__nav-item" data-ktwizard-type="step"
                         data-ktwizard-state="current" id="base_info">
                        <div class="kt-wizard-v3__nav-body nav-tabs">
                            <div class="kt-wizard-v3__nav-label ">
                                Thông tin cơ bản
                            </div>
                            <div class="nav_bar_select active"></div>
                        </div>
                    </div>
                    <div class="kt-wizard-v3__nav-item " id="list_method_payment" data-ktwizard-type="step"
                         data-ktwizard-state="current">
                        <div class="kt-wizard-v3__nav-body nav-tabs" onclick="checkParner();">
                            <div class="kt-wizard-v3__nav-label ">
                                Các cổng thanh toán
                            </div>
                            <div class="nav_bar_select list_method_payment"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end: Navigations -->
        </div>
        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('pgw_partner.index') }}" class="kt-subheader__breadcrumbs-link">Danh sách đối
                            tác thanh toán</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Thêm mới đối tác</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('pgw_partner.index') }}" class="btn btn-clean kt-margin-r-10">
                            <i class="la la-arrow-left"></i>
                            <span class="kt-hidden-mobile">Quay lại</span>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-save btn-brand" id="js-button-submit">
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
                                  action="{{ route('pgw_partner.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    @include('main.admin.partner.components.item-general', [
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
    <script src="{{asset('assets/js/partner.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/addBanking.js')}}" type="text/javascript"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <script type="text/javascript">

        $("#item-code").change(function () {
            var getValueCode = document.getElementById("item-code").value;
            document.getElementById("item-partner_code").value = getValueCode;
        });
        let buttonSubmit = $('#js-button-submit');
        buttonSubmit.click((e) => {
            console.log(1);
            e.preventDefault();
            $(buttonSubmit).prop('disabled', true);
            if ([...$('.validated')].length) {
                [...$('.validated')].forEach(item => {
                    item.remove();
                })
            }
            tinyMCE.triggerSave();
            console.log($('#formProgram').serializeArray());
            $.ajax({
                method: 'POST',
                url: '/pgw_partner',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                    data: $('#formProgram').serializeArray(),
                success: function (response) {
                    $(buttonSubmit).prop('disabled', false);
                    if (response.status == 3) {
                        swal.fire({
                            text: "Bạn chọn thanh toán chuyển khoản nhưng không tạo ngân hàng chuyển khoản",
                            type: 'warning',
                            confirmButtonText: 'Đồng ý',
                            reverseButtons: true
                        });
                        return;
                    }
                    if (response.status == 2) {
                        let validates = [];
                        var response = response.dataError;
                        Object.keys(response).map(item => {
                            if (item.includes('.')) {
                                let splitKey = item.split('.');
                                validates[`${splitKey[0]}[][${splitKey[1]}]`] = response[item][0];
                            } else {
                                validates[item] = response[item][0]
                            }
                        })
                        const paymentMerchantBusiness = $('.payment_merchant_business');
                        [...paymentMerchantBusiness].forEach(paymentBusiness => {
                            if ($(paymentBusiness).attr('data-id') != "transfer") {
                                handleMessageSingleFieldValidate(paymentBusiness, validates, 'form-check');
                            }
                        })
                    } else if (response.type === 'error') {
                        swal.fire({
                            text: "Bạn chưa chọn phương thức thanh toán",
                            type: 'warning',
                            confirmButtonText: 'Đồng ý',
                            reverseButtons: true
                        });
                    } else {
                        KTUtil.ready(function () {
                            NDNotification.success(`${response.message}`);
                        });
                        window.location.href = "/pgw_partner";
                    }
                },
                error: function (e) {
                    $(buttonSubmit).prop('disabled', false);
                    console.log('Error');
                }
            })
        })
        const formCheckedInput = $('.form-check-input');
        [...formCheckedInput].forEach(inputChecked => {
            $(inputChecked).click(e => {
                if (!inputChecked.checked) {
                    let parentInputChecked = $(inputChecked).parent();
                    let validatedElement = $(parentInputChecked).children('.validated');
                    if ($(validatedElement).attr('class') && $(validatedElement).attr('class') == 'validated') {
                        $(validatedElement).remove();
                    }
                }

            })
        })
        const handleMessageSingleFieldValidate = (input, validates, parentClassName) => {
            let nameInput = $(input).attr('name');
            let parent = $(input).closest(`.${parentClassName}`);
            if (validates[nameInput]) {
                parent.append(`<div class="validated">
                                <div class="invalid-feedback">${validates[nameInput]}</div>
                            </div>`);
            }
        }
        tinymce.init({
            selector: 'textarea#myTextarea',
            init_instance_callback: function (editor) {
                editor.on('click', function (e) {
                    var errorDescrip = $('.valueDescription_error').text();
                    if (errorDescrip) {
                        $('.valueDescription_error').remove();
                    }
                });
            }
        });
    </script>
@stop
