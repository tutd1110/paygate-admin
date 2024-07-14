@extends('main.layout.master')
@section('title', 'Thêm mới hoá đơn')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Danh sách</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('pgw_partner.index') }}" class="kt-subheader__breadcrumbs-link">Danh sách hoá
                            đơn </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Thêm mới hoá đơn</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="{{ route('invoices.index') }}" class="btn btn-clean kt-margin-r-10">
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
                            <form class="px-5 py-3 kt-form kt-form--label-right" id="addOrders"
                                  action="{{route('invoices.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    @include('main.admin.invoice.components.item-general')
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="viewAddProduct" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" style="width: 100%;padding: 10% 3%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelInfo">Thêm sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <br>
                            <div class="row">
                                <div class="col-2 form-control" style="border: none;text-align: center"><h5>Loại sản
                                        phẩm :</h5></div>
                                <div class="col-9">
                                    <select data-placeholder="Chọn loại sản phẩm" id="product_type_id"
                                            class="form-control">
                                        <option value="combo">Combo</option>
                                        <option value="package">Package</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-2 form-control" style="border: none;text-align: center"><h5>Mã sản phẩm
                                        :</h5></div>
                                <div class="col-9"><input id="code_product_id" required placeholder="Nhập mã sản phẩm"
                                                          class="form-control" type="number">
                                    <span id="error_required_code_product" hidden
                                       style="font-size: 12px;color: #fd397a">Mã sản phẩm không hợp lệ.
                                    </span></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-2 form-control" style="border: none;text-align: center"><h5>Tên sản phẩm
                                        :</h5></div>
                                <div class="col-9"><input id="name_product_id" required placeholder="Nhập tên sản phẩm"
                                                          class="form-control" type="text">
                                    <span id="error_required_name_product" hidden
                                         style="font-size: 12px;color: #fd397a">Tên sản phẩm không hợp lệ.
                                    </span></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-2 form-control" style="border: none;text-align: center"><h5>Đơn Giá
                                        (VND): :</h5></div>
                                <div class="col-9"><input id="price_product_id" required placeholder="Nhập đơn giá(VND)"
                                                          class="form-control" type="number">
                                    <span id="error_required_price_product" hidden
                                         style="font-size: 12px;color: #fd397a">Đơn Giá không hợp lệ.
                                    </span></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-2 form-control" style="border: none;text-align: center"><h5>Số lượng
                                        :</h5></div>
                                <div class="col-9"><input id="quality_product_id" required placeholder="Nhập số lượng"
                                                          class="form-control" type="number">
                                    <span id="error_required_quality_product" hidden
                                         style="font-size: 12px;color: #fd397a">Số lượng không hợp lệ.
                                    </span></div>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="id_button_add_product" onclick="addProduct()" style="margin-right: 2rem"
                                    type="button"
                                    class="btn btn-secondary btn-primary"
                                    data-bs-dismiss="modal">Thêm mới
                            </button>
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

        function deleteAction(id) {
            swal.fire({
                title: 'Xóa bỏ',
                text: "Bạn có chắc chắn muốn xóa?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    console.log(id);
                    $('.product_' + id).remove();
                }
            });
        }

        var listProduct = [];

        function showAddProduct() {
            $('#viewAddProduct').modal('show')
            $('#code_product_id').val('');
            $('#price_product_id').val('');
            $('#name_product_id').val('');
            $('#quality_product_id').val('1');
            ['product_type','code_product','price_product','name_product','quality_product'].forEach(function (value) {
                $("#error_required_"+value).attr('hidden',true);
            });
            $('#code_product_id').on( "keypress", function(evt) {
                if (evt.which < 48 || evt.which > 57)
                {
                    evt.preventDefault();
                }
            });
        }

        function SubmitForm() {
            var full_name_id = $('#full_name_id').val();
            var phone_id = $('#phone_id').val();
            if (full_name_id !== '' || phone_id !== '') {
                if (full_name_id.length != 0 && phone_id.length != 0) {
                    $('#error_required_full_name_id').text('')
                    $('#error_required_phone_id').text('')
                    if (listProduct.length == 0) {
                        $('#error_product_list').removeAttr('hidden');
                    }
                    else{
                        $('#addOrders').submit();
                    }
                }
            }else{
                $('#error_required_full_name_id').text('Tên không được để trống')
                $('#error_required_phone_id').text('Số điện thoại không được để trống')
            }
        }
        function addProduct() {
            var error = '';
            ['product_type','code_product','price_product','name_product','quality_product'].forEach(function (value){
                var id = value+'_id';
                var checkValue = $("#"+id).val();
                if(checkValue == '' || checkValue < 0){
                    $("#error_required_"+value).removeAttr('hidden');
                     error = true;
                }else{
                    $("#error_required_"+value).attr('hidden',true);
                }
            });
            if(!error){
            var product = [];
            product['typeProduct'] = $('#product_type_id').val();
            product['codeProduct'] = $('#code_product_id').val();
            product['priceProduct'] = $('#price_product_id').val();
            product['nameProduct'] = $('#name_product_id').val();
            product['qualityProduct'] = $('#quality_product_id').val();
            product['sumPrice'] = product['priceProduct'] * product['qualityProduct'];

                listProduct.push(product);
                $('#viewAddProduct').modal('hide');
                $('#addOrders').append(
                    '<input hidden class="product_' + listProduct.length + '" type="text" value="' + product['typeProduct'] + '" name="item_product_type[]">' +
                    '<input hidden class="product_' + listProduct.length + '" type="text" value="' + product['codeProduct'] + '" name="item_product_id[]">' +
                    '<input hidden class="product_' + listProduct.length + '" type="text" value="' + product['nameProduct'] + '" name="item_product_name[]">' +
                    '<input hidden class="product_' + listProduct.length + '" type="text" value="' + product['qualityProduct'] + '" name="item_quantity[]">' +
                    '<input hidden class="product_' + listProduct.length + '" type="number" value="' + product['sumPrice'] + '" name="item_price[]">'
                )
                var table = document.getElementById("productList");
                table.innerHTML +=
                    '<tr>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + listProduct.length + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + listProduct[listProduct.length - 1]['codeProduct'] + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + listProduct[listProduct.length - 1]['nameProduct'] + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + listProduct[listProduct.length - 1]['typeProduct'] + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + new Intl.NumberFormat().format(listProduct[listProduct.length - 1]['priceProduct']) + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + listProduct[listProduct.length - 1]['qualityProduct'] + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" >' + new Intl.NumberFormat().format(listProduct[listProduct.length - 1]['sumPrice'])  + '</td>' +
                    '<td style="text-align: center" class="product_' + listProduct.length + '" id="" onclick="deleteAction(' + listProduct.length + ')"><i class="fa fa-trash-alt" style="color:red;"></i></td>'
                $('#error_product_list').attr("hidden", true);
            }
        }

        function selectSearch(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }
            // Return `null` if the term should not be displayed
            return null;
        }
        $(".selectSearch").select2({
        matcher: selectSearch
        });
    </script>

@stop
