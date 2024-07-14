@extends('main.layout.master')
@section('title', 'Danh sách hoàn trả đơn hàng')

@section('style')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">
    <style>
        .button_status {
            cursor: pointer;
        }
    </style>
@stop

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Danh sách</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{route('pgw_order_refund.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách
                            hoàn trả đơn hàng</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        {{--                        <div class="btn-group">--}}
                        {{--                            <a href="{{route('pgw_order_refund.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">--}}
                        {{--                                <i class="la la-plus"></i>--}}
                        {{--                                Thêm mới--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-line-chart"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Danh sách hoàn trả đơn hàng
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include("main.admin.pgwOrderRefund.components.item-search")
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                               style="margin-top: 10px">
                            <thead>
                            <tr>
                                <th style="vertical-align: middle">ID</th>
                                <th style="vertical-align: middle"><b>Mã đơn hàng</b></th>
                                <th style="vertical-align: middle"><b>Mã đối tác</b></th>
                                <th style="vertical-align: middle"><b>Landing Page</b></th>
                                <th style="vertical-align: middle"><b>Số tiền hoàn trả <br>(VND)</b></th>
                                <th style="vertical-align: middle"><b>Mô tả</b></th>
                                <th style="vertical-align: middle"><b>Trạng thái</b></th>
                                <th style="vertical-align: middle"><b>Ngày tạo</b></th>
                                <th style="vertical-align: middle"><b>Ngày cập nhật</b></th>
                                <th style="vertical-align: middle"><b>Action</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listOrderRefunds as $listOrderRefund)
                                <tr>
                                    <td style="text-align: center;vertical-align: middle;">{!! $listOrderRefund['id'] !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listOrderRefund['order']['code'] ?? '' !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listOrderRefund['partner_code'] !!} </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listOrderRefund['landing_page']['domain_name'] ?? ''!!} </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listOrderRefund['refund_value'] !!} </td>
                                    <td style="width: 200px; text-align: left;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;vertical-align: middle;">{!! $listOrderRefund['description'] !!} </td>
                                    {{--                                <td style="text-align: left">{!! $listOrderRefund['status'] !!} </td>--}}
                                    <td style="width: 200px">
                                        <select onchange="statusRefundChange({{$listOrderRefund['id']}})"
                                                id="id_status_{{$listOrderRefund['id']}}" class="status form-control"
                                                name="status" data-id="{!! $listOrderRefund['id'] !!}">
                                            <option
                                                value="request" {{$listOrderRefund['status'] == 'request' ? 'selected' : '' }} >
                                                Request
                                            </option>
                                            <option
                                                value="refused" {{ $listOrderRefund['status'] == 'refused' ? 'selected' : '' }}>
                                                Refused
                                            </option>
                                            <option
                                                value="appoved" {{ $listOrderRefund['status'] == 'appoved' ? 'selected' : '' }}>
                                                Appoved
                                            </option>
                                            <option
                                                value="finish" {{$listOrderRefund['status'] == 'finish' ? 'selected' : '' }}>
                                                Finish
                                            </option>

                                        </select>
                                    </td>
                                    {{--                                <td style="text-align: left">{!! $listPayment['sort'] !!}</td>--}}
                                    <td style="text-align: center;vertical-align: middle;">{!! date('d-m-Y H:i',strtotime($listOrderRefund['created_at'])) !!}</td>
                                    <td style="text-align: center;vertical-align: middle;">{!! date('d-m-Y H:i',strtotime($listOrderRefund['updated_at'])) !!}</td>
                                    {{--                                --}}
                                    <td style="vertical-align: middle; vertical-align:middle;text-align: center;">
                                            <span style="padding:10px;" id="showOrder_{{$listOrderRefund['order_id']}}"
                                                  onclick="showOrderRefund({{ $listOrderRefund['order_id']}})"><i
                                                    class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5"></div>
                    <div class="col-sm-12 col-md-7 dataTables_pager">
                        <div class="dataTables_length" id="item-list_length">
                            <label>
                                <span>Hiển thị</span>
                                <select id="set_limit" onchange="setLimit()"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                    @foreach($listPage as $limitPage)
                                        <option id="option_limit"
                                                value="{{$limitPage}}" {{$limit == $limitPage ? 'selected' : ''}}>{{$limitPage}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="dataTables_paginate paging_full_numbers" id="item-list_paginate">
                            <div class="dataTables_paginate paging_full_numbers" id="item-list_paginate">
                                <ul class="pagination" style="cursor: pointer">
                                    <li class="paginate_button page-item first disabled page-link"
                                        id="item-list_first" value="1"><i style="color: #646c9a"
                                                                          class="fa fa-angle-double-left"></i>
                                    </li>
                                    <li class="paginate_button page-item previous disabled page-link"
                                        id="item-list_previous" value="{{$paginate['current_page']-1}}"><i
                                            style="color: #646c9a" class="fa fa-angle-left"></i></li>
                                    @if($paginate['last_page'] == 1)
                                        <li class="paginate_button page-item previous disabled page-link"
                                            style="color: #fcfcfc;background: #5867dd"
                                            id="num_page_current" value="1">1
                                        </li>
                                    @elseif($paginate['last_page'] == 2)
                                        <li class="paginate_button page-item previous disabled page-link"
                                            style="color: {{$paginate['current_page'] == 1 ? '#fcfcfc' : "" }}; background:{{$paginate['current_page'] == 1 ? '#5867dd' : "" }}"
                                            id="num_page_current" value="1">1
                                        </li>
                                        <li class="paginate_button page-item previous disabled page-link"
                                            style="color: {{$paginate['current_page'] == 2 ? '#fcfcfc' : "" }}; background:{{$paginate['current_page'] == 2 ? '#5867dd' : "" }}"
                                            id="num_page_next" value="2">2
                                        </li>
                                    @elseif($paginate['last_page'] > 2)
                                        @if($paginate['last_page'] == $paginate['current_page'])
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_current"
                                                value="{{$paginate['current_page']-2}}">{{$paginate['current_page']-2}}</li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['current_page']-1}}">{{$paginate['current_page']-1}}</li>
                                            <li class="paginate_button page-item previous disabled page-link">
                                                ...
                                            </li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['current_page']}}"
                                                style="color: #fcfcfc;background: #5867dd">{{$paginate['current_page']}}</li>
                                        @elseif($paginate['last_page'] - 1 ==  $paginate['current_page'])
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_current"
                                                value="{{$paginate['last_page']-2}}">{{$paginate['last_page']-2}}</li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['last_page']-1}}"
                                                style="color: #fcfcfc;background: #5867dd">{{$paginate['last_page']-1}}</li>
                                            <li class="paginate_button page-item previous disabled page-link">
                                                ...
                                            </li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['last_page']}}">{{$paginate['last_page']}}</li>
                                        @elseif($paginate['last_page'] != $paginate['current_page'])
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_current"
                                                value="{{$paginate['current_page']}}"
                                                style="color: #fcfcfc;background: #5867dd">{{$paginate['current_page']}}</li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['current_page']+1}}">{{$paginate['current_page']+1}}</li>
                                            <li class="paginate_button page-item previous disabled page-link">
                                                ...
                                            </li>
                                            <li class="paginate_button page-item previous disabled page-link"
                                                id="num_page_next"
                                                value="{{$paginate['last_page']}}">{{$paginate['last_page']}}</li>
                                        @endif
                                    @endif
                                    <li class="paginate_button page-item next disabled page-link"
                                        id="item-list_next" value="{{$paginate['current_page']+1}}"><i
                                            style="color: #646c9a" class="fa fa-angle-right"></i></li>
                                    <li class="paginate_button page-item last disabled page-link"
                                        id="item-list_last" value="{{$paginate['last_page']}}"><i
                                            style="color: #646c9a" class="fa fa-angle-double-right"></i></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>
        <div class="modal fade kt-invoice-1" id="ViewModal" tabindex="-1" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" style="width: 100%;padding: 10% 3%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelInfo">Chi tiết Hoàn trả</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div style="">
                            {{--                                --}}{{--                            <div class="row">--}}
                            {{--                                --}}{{--                                <label class="col-lg-8 col-form-label  text-left" for=""><b></b></label>--}}
                            {{--                                --}}{{--                                <label class="col-lg-8 col-form-label" id=""></label>--}}
                            {{--                                --}}{{--                            </div>--}}
                            {{--                                --}}{{--                            <br>--}}
                            {{--                                --}}{{--                        <div class="row">--}}
                            {{--                                --}}{{--                            <label class="col-lg-8 col-form-label" for="bill_code"><b>Mã đơn hàng:</b></label>--}}
                            {{--                                --}}{{--                            <label class="col-lg-8 col-form-label" id="label_code"></label>--}}
                            {{--                                --}}{{--                        </div>--}}
                            {{--                                <br>--}}
                            <div class="row">
                                <div class="col-2">
                                    <label class="row col-form-label" for="partner_name" style="padding-left: 15px"><b>Mã
                                            đối
                                            tác:</b></label>
                                    <label class="row  col-form-label" id="label_partner_code"
                                           style="word-break: break-word;padding-left: 15px">></label>
                                </div>
                                <div class="col-3">
                                    <label class="row col-form-label"
                                           for="landing_page"><b>LandingPage:</b></label>
                                    <label class="row col-form-label" data-value=""
                                           id="label_landing_page" style="word-break: break-word;"></label>
                                </div>
                                <div class="col-2">
                                    <label class="row col-form-label" for="contact_full_name"><b>Tên khách
                                            hàng:</b></label>
                                    <label class="row col-form-label" id="label_contact_full_name"
                                           style="word-break: break-word;"></label>
                                </div>
                                <div class="col-3">
                                    <label class="row col-form-label" for="contact_email"
                                           style="word-break: break-word;"><b>Email khách
                                            hàng</b></label>
                                    <label class="row col-form-label" id="label_contact_email"
                                           style="word-break: break-word;"></label>
                                </div>
                                <div class="col-2">
                                    <label class="row col-form-label" for="contact_phone"
                                           style="word-break: break-word;"><b>Số điện
                                            thoại:</b></label>
                                    <label class="row col-form-label" id="label_contact_phone"></label>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="id_table_orders" class="table table-bordered"
                                       style="font-family: Arial;vertical-align: middle;">
                                    <thead style="text-align: center; vertical-align: middle">
                                    <tr>
                                        <th style="vertical-align: middle;">ID Sản phẩm</th>
                                        <th style="vertical-align: middle;">ID Đơn hàng</th>
                                        <th style="vertical-align: middle;">Mã đơn hàng</th>
                                        <th style="vertical-align: middle;">Loại sản phẩm</th>
                                        <th style="vertical-align: middle;">Tên sản phẩm</th>
                                        <th style="vertical-align: middle;">Số lượng</th>
                                        <th style="vertical-align: middle;">Tổng tiền</th>
                                        <th style="vertical-align: middle;">Ngày tạo đơn</th>
                                        <th style="vertical-align: middle;">Lần Cập Nhật Cuối</th>
                                    </tr>
                                    </thead>
                                    <tbody id="orderRefundDetail">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <table hidden class="table table-striped- table-bordered table-hover table-checkable"
                   id="table2excel">
                <thead>
                <tr>
                    <td style="vertical-align: middle;"><b>ID</b></td>
                    <td style="vertical-align: middle;"><b>Mã Đơn Hàng</b></td>
                    <td style="vertical-align: middle;"><b>Mã đối tác</b></td>
                    <td style="vertical-align: middle;"><b>Landing Page</b></td>
                    <td style="vertical-align: middle;"><b>Số tiền hoàn trả(VND)</b></td>
                    <td style="vertical-align: middle;"><b>Mô tả</b></td>
                    <td style="vertical-align: middle;"><b>Trạng thái</b></td>
                    <td style="vertical-align: middle;"><b>Ngày tạo</b></td>
                    <td style="vertical-align: middle;"><b>Ngày cập nhật</b></td>
                </tr>
                </thead>
                <tbody id="tbody_export">
                </tbody>
            </table>
        </div>
        <!-- end:: Content -->
    </div>

@stop
@section('script')
    <script>

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
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        function statusRefundChange(id) {
            var statusRefund = $('#id_status_' + id).find(":selected").val();
            $.ajax({
                url: '{{ route('pgw_order_refund.statuChange')}}',
                type: 'PUT',
                data: {
                    id: id,
                    status: statusRefund
                },
                success: function (data) {
                    return true;
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }

        $(document).on('click', '.paginate_button', function () {
            var page = $(this).val();
            if (page > 0 && page <= {{$paginate['last_page']}}) {
                var limit = $('#set_limit').val();
                var a = $('#id_limit').val(limit);
                $('#id_page').val(page);
                $('#orderRefundSearch').submit();
            } else {
                alert("Đã hết số trang");
            }
        });

        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#orderRefundSearch').submit();
        }

        $('.select2[multiple]').select2({
            width: '100%',
            closeOnSelect: false
        })

        function resetSearch() {
            $("#id_code").val("");
            $("#id_partner_code").val("");
            $("#id_start_date").val("");
            $("#id_end_date").val("");
            $("#id_landing_page_id").val("");
            $("#id_status").val("");
            window.location.href = '/pgw_order_refund';
        }

        function exportExcel() {
            var code = $("#id_code").val();
            var partner_code = $("#id_partner_code").val();
            var start_date = $("#id_start_date").val();
            var end_date = $("#id_end_date").val();
            var landing_page_id = $("#id_landing_page_id").val();
            var status = $("#id_status").val();

            var datetime = moment(new Date()).format('DD/MM/YYYY');
            $.ajax({
                url: '{{route('pgw_order_refund.export') }}',
                type: 'GET',
                data: {
                    code: code,
                    partner_code: partner_code,
                    start_date: start_date,
                    end_date: end_date,
                    landing_page_id: landing_page_id,
                    status: status
                },

                success: function (datas) {
                    var table = document.getElementById("tbody_export");
                    table.innerHTML = "";

                    datas.forEach(function orderRefundExport(data) {

                        var dateStart = (new Date(data.created_at));
                        var dateEnd = (new Date(data.updated_at));
                        data.code = (!data.code) ? '' : data.code;
                        data.description = (!data.description) ? '' : data.description;
                        var landingPage = (!data.landing_page) ? '' : data.landing_page.description;
                        table.innerHTML +=
                            '<tr>' +
                            '<td>' + data.id + '</td>' +
                            '<td>' + data.order.code + '</td>' +
                            '<td>' + data.partner_code + '</td>' +
                            '<td>' + landingPage + '</td>' +
                            '<td style="text-align: center">' + new Intl.NumberFormat().format(data.refund_value) + ' VND</td>' +
                            '<td style="text-align: center">' + data.description + '</td>' +
                            '<td style="text-align: center">' + data.status + '</td>' +
                            '<td style="text-align: center">' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '<td style="text-align: center">' + moment(dateEnd).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '</tr>';
                    });
                    setTimeout(() => {
                        $("#table2excel").table2excel({
                            exclude: ".noExl",
                            name: "Worksheet Name",
                            filename: "Export_Order_Refund" + datetime + ".xls",
                            fileext: ".xls",
                            preserveColors: true
                        });
                    }, 500);
                },
                error: function () {
                    console.log(e.message);
                }
            });
        };

        function showOrderRefund(id) {
            $('#id_refund_value').val("");
            $('#id_order_refund_decription').val("");
            $.ajax({
                url: '{{route('pgw_orders.show',$getListOrder['id'] ?? 0) }}',
                type: 'GET',
                data: {id: id},

                success: function (data) {
                    let dataOrder = data.data[0];
                    // console.log(dataOrder.status);
                    let dataOrderDetail = data.data[0].order_detail;
                    let informationContact = data.data[0].contact;
                    var landingPageID = dataOrder.landing_page ? dataOrder.landing_page.id : '';

                    document.getElementById("label_partner_code").innerText = dataOrder.partner ? dataOrder.partner.code : 'Không có thông tin!';
                    document.getElementById("label_landing_page").innerText = dataOrder.landing_page ? dataOrder.landing_page.domain_name : 'không có thông tin!';
                    $('#label_landing_page').attr('data-value', landingPageID);
                    ['full_name', 'phone', 'email'].forEach(function orderContact(field) {
                        if (informationContact) {
                            document.getElementById("label_contact_" + field).innerText = informationContact[field];
                        } else {
                            document.getElementById("label_contact_" + field).innerText = 'Không có thông tin!'
                        }
                    });
                    (dataOrder.status != 'paid') ? $('#id_button_return').attr("hidden", true) : $('#id_button_return').removeAttr('hidden');
                    $("#orderDetail tr").remove();
                    var arrayCheckbox = [];
                    var table = document.getElementById("orderRefundDetail");
                    table.innerHTML = "";
                    dataOrderDetail.forEach(function orderDetail(orderDetail) {
                        var dateStart = (new Date(orderDetail.created_at));
                        var dateEnd = (new Date(orderDetail.updated_at));


                        table.innerHTML +=
                            '<tr>' +
                            '<td style="text-align: center" id="order_detail_id" data-value=' + orderDetail.id + ' >' + orderDetail.id + '</td>' +
                            '<td style="text-align: center" id="order_id" data-value=' + orderDetail.order_id + ' >' + orderDetail.order_id + '</td>' +
                            '<td style="text-align: center" id="label_code" data-value=' + dataOrder.code + ' >' + dataOrder.code + '</td>' +
                            '<td style="text-align: center" id="order_detail_product_type" data-value=' + orderDetail.product_type + ' >' + orderDetail.product_type + '</td>' +
                            '<td style="text-align: center" id="order_detail_product_name" data-value=' + orderDetail.product_name + ' >' + orderDetail.product_name + '</td>' +
                            '<td style="text-align: center" id="order_detail_quantity" data-value=' + orderDetail.quantity + '>' + orderDetail.quantity + '</td>' +
                            '<td style="text-align: center" id="order_deatail_price" data-value=' + orderDetail.price + '>' + new Intl.NumberFormat().format(orderDetail.price) + ' VND</td>' +
                            '<td style="text-align: center" id="order_date_start" data-value=' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '> ' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '<td style="text-align: center" id="order_date_end" data-value=' + new Date() + '>' + moment(dateEnd).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '</tr>';
                    });
                    $('#ViewModal').modal('show');
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }
    </script>
@stop
