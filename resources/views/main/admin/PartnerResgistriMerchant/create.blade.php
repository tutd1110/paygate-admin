@extends('main.layout.master')
@section('title', 'Danh sách các cổng thanh toán mà đối tác đăng ký')

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
                        <a href="{{ route('pgw_partner_resgistri_merchant.index') }}"
                           class="kt-subheader__breadcrumbs-link">Danh sách các cổng thanh toán mà đối tác đăng ký</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Thêm mới danh sách đối tác</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('pgw_partner_resgistri_merchant.index') }}"
                           class="btn btn-clean kt-margin-r-10">
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
                                  action="{{ route('pgw_partner_resgistri_merchant.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    @include('main.admin.PartnerResgistriMerchant.components.item-general', [
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
    <script type="text/javascript">
        function SubmitForm() {
            $('#formProgram').submit();
        }
    </script>
    <script type="text/javascript">
        const confirm = document.getElementById('confirm');
        const show_form = document.getElementById('show_form');
        const openPopup = () => {
            document.getElementById('registri_banking').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }
        const closePopup = () => {
            document.getElementById('registri_banking').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
        const openButton = () => {
            document.getElementById('show_button').style.display = 'inline';
        }
        const closeButton = () => {
            document.getElementById('show_button').style.display = 'none';
        }
        const openshowSort = () => {
            document.getElementById('show_sort').style.display = 'inline';
        }
        const closeshowSort = () => {
            document.getElementById('show_sort').style.display = 'none';
        }
        confirm.addEventListener("click", (e) => {
            e.preventDefault();
            closePopup();
        })
        var select = document.querySelector("#partner_code");
        select.addEventListener("change", (e) => {
            var getOption = $("#partner_code option:selected").val();
            if (getOption != ""){
                var getTextOption = $("#partner_code option:selected").text();
                document.getElementById("item-partner_code").value = getTextOption;
            }
        });
        // var getOption = $("#payment_merchant option:selected").val();
        //        const options = payment_merchant.options;
        const payment_merchant = document.querySelector('#payment_merchant');
        payment_merchant.addEventListener('change', (e) => {
            var getOption = $("#payment_merchant option:selected").val();
            if (getOption == 8) {
                openPopup();
                openButton();
                closeshowSort();
            }
            else {
                openshowSort();
                closeButton();
            }
        })
        show_form.addEventListener('click', (e) => {
            e.preventDefault();
            openPopup();
        });
        var checkError = $('.checkError').text();
        if (checkError) {
            openPopup();
        }
    </script>
@stop
