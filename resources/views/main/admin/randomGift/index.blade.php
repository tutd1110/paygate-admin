@extends('main.layout.master')
@section('title', 'Vòng quay may mắn')
@section('style')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/pgw_orders/orders.css">
    <link rel="stylesheet" href="assets/fahasa/style.css">
@stop

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Danh sách</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{route('randomGift.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách vòng quay </a>
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
                            Danh sách vòng quay
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-portlet__container">
                        @include("main.admin.randomGift.components.item-search")
                        @if (!empty($countRandomGiftContact))
                            <div>
                                <span class="count_random--top">Tổng số: {{ $countRandomGiftContact }}</span>
                            </div>
                        @endif
                        @if (!empty($listRandomGiftContact))
                            <div class="scroll_bar">
                                <div class="scroll_bar--top"></div>
                            </div>
                            <div class="scroll_bar--bottom">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover kt-datatable-me" id="item-list">
                                        <thead>
                                        <tr style="background-color: #b2c6ce">
                                            <th class="align-middle"><b>STT</b></th>
                                            <th class="align-middle"><b>Họ tên</b></th>
                                            <th class="align-middle"><b>Email</b></th>
                                            <th class="align-middle"><b>Số điện thoại</b></th>
                                            <th class="align-middle"><b>Mã bill</b></th>
                                            <th class="align-middle"><b>Giá trị bill</b></th>
                                            <th class="align-middle"><b>Nhà sách</b></th>
                                            <th class="align-middle"><b>Đối tác</b></th>
                                            <th class="align-middle"><b>Loại quà</b></th>
                                            <th class="align-middle"><b>Mã voucher</b></th>
                                            <th class="align-middle"><b>Medium</b></th>
                                            <th class="align-middle"><b>Source</b></th>
                                            <th class="align-middle"><b>Campaign</b></th>
                                            <th class="align-middle"><b>Lock</b></th>
                                            <th class="align-middle"><b>Scan</b></th>
                                            <th class="align-middle" width="5%"><b>Scan Number</b></th>
                                            <th class="align-middle"><b>Thời gian quay</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listRandomGiftContact as $randomGiftContact)
                                            <tr>
                                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['contact']) ? $randomGiftContact['contact']['full_name'] : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['contact']) ? $randomGiftContact['contact']['email'] : '' !!}</td>
                                                <td class="text-center align-middle">{!! !empty($randomGiftContact['contact']) ? $randomGiftContact['contact']['phone'] : '' !!}</td>
                                                <td class="text-center align-middle">{!! !empty($randomGiftContact['ticket']) ? $randomGiftContact['ticket']['bill_code'] : '' !!}</td>
                                                <td class="text-right align-middle">{!! !empty($randomGiftContact['ticket']) ? number_format($randomGiftContact['ticket']['bill_value']) : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['ticket']) ? $randomGiftContact['ticket']['store_name'] : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['gift']) ? $randomGiftContact['gift']['supplier_code'] : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['gift']) ? $randomGiftContact['gift']['name'] : '' !!}</td>
                                                <td class="text-left align-middle">{!! $randomGiftContact['coupon_code'] ?  $randomGiftContact['coupon_code'] : '' !!}</td>
                                                <td class="text-left align-middle">{!! $randomGiftContact['contact'] ?  ucwords($randomGiftContact['contact']['utm_medium']) : '' !!}</td>
                                                <td class="text-left align-middle">{!! $randomGiftContact['contact'] ?  ucwords($randomGiftContact['contact']['utm_source']) : '' !!}</td>
                                                <td class="text-left align-middle">{!! $randomGiftContact['contact'] ?  ucwords($randomGiftContact['contact']['utm_campaign']) : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['ticket']) ? ucwords($randomGiftContact['ticket']['lock']) : '' !!}</td>
                                                <td class="text-left align-middle">{!! !empty($randomGiftContact['ticket']) ? ucwords($randomGiftContact['ticket']['scan']) : '' !!}</td>
                                                <td class="text-center align-middle">{!! !empty($randomGiftContact['ticket']) ? $randomGiftContact['ticket']['scan_number'] : '' !!}</td>
                                                <td class="text-center align-middle">{!! date('d-m-Y H:i:s',strtotime($randomGiftContact['created_at'])) !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div>không có dữ liệu</div>
                        @endif
                        {{-- pagination --}}
                        <div class="row">
                            @if (!empty($countRandomGiftContact))
                            <div class="col-sm-12 col-md-5 d-flex align-items-center">
                                <span class="count_random">Tổng số: {{ !empty($countRandomGiftContact) ? $countRandomGiftContact : ''  }}</span>
                            </div>
                            @else
                                <div class="col-sm-12 col-md-5"></div>
                            @endif
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
                        {{-- end pagination --}}
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
       {{-- export --}}
        <div class="modal fade" id="orderRefundModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <table class="table table-striped table-bordered table-hover kt-datatable-me"
                   id="table2excel">
                <thead>
                    <tr style="background-color: #b6cad2">
                        <th class="align-middle"><b>STT</b></th>
                        <th class="align-middle"><b>Họ tên</b></th>
                        <th class="align-middle"><b>Email</b></th>
                        <th class="align-middle"><b>Số điện thoại</b></th>
                        <th class="align-middle"><b>Mã bill</b></th>
                        <th class="align-middle"><b>Giá trị bill</b></th>
                        <th class="align-middle"><b>Nhà sách</b></th>
                        <th class="align-middle"><b>Đối tác</b></th>
                        <th class="align-middle"><b>Loại quà</b></th>
                        <th class="align-middle"><b>Mã voucher</b></th>
                        <th class="align-middle"><b>Medium</b></th>
                        <th class="align-middle"><b>Source</b></th>
                        <th class="align-middle"><b>Campaign</b></th>
                        <th class="align-middle"><b>Thời gian quay</b></th>
                    </tr>
                </thead>
                <tbody id="tbody_export">
                </tbody>
            </table>
        </div>
       {{-- end export --}}
       <div class="modal fade" id="modal-loading" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loading-spinner mb-2"></div>
                    <div>Loading</div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('script')
    <script>
        function resetSearch() {
            $("#id_full_name").val("");
            $("#id_email").val("");
            $("#id_phone").val("");
            $("#id_gift").val("");
            $("#id_bill_code").val("");
            $("#id_start_date").val("");
            $("#id_end_date").val("");
            $("#id_medium").val("");
            $("#id_source").val("");
            $("#id_campaign").val("");
            $("#id_supplier_code").val("");
            $("#search_submit").click();
        }
        $(document).on('click', '.paginate_button', function () {

            var page = $(this).val();
            if (page > 0 && page <= {{$paginate['last_page']}}) {
                var limit = $('#set_limit').val();
                var a = $('#id_limit').val(limit);
                $('#id_page').val(page);
                $('#orderSearch').submit();
            } else {
                messageError('Đã hết số trang!')
            }
        });

        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#orderSearch').submit();
        }
        function hideError() {
            $(".message").attr("hidden", true);
        }

        function messageSuccess(message) {
            toastr.success(message);
        }

        function messageError(message) {
            toastr.error(message);
        }
        function turnOnModalLoading() {
            $('#modal-loading').modal('show');
        };

        function turnOffModalLoading() {
            $('#modal-loading').modal('hide');
        }

        // export
        function exportExcel() {
            turnOnModalLoading();
            var full_name  = $("#id_full_name").val();
            var email = $("#id_email").val();
            var phone = $("#id_phone").val();
            var gift = $("#id_gift").val();
            var bill_code = $("#id_bill_code").val();
            var start_date = $("#id_start_date").val();
            var end_date = $("#id_end_date").val();
            var utm_medium = $("#id_medium").val();
            var utm_source = $("#id_source").val();
            var utm_campaign = $("#id_campaign").val();
            var supplier_code = $("#id_supplier_code").val();
            var datetime = moment(new Date()).format('DD/MM/YYYY');

            $.ajax({
                url: '{{route('randomGift.export') }}',
                type: 'GET',
                data: {
                    full_name: full_name,
                    email: email,
                    phone: phone,
                    gift_id: gift,
                    bill_code: bill_code,
                    start_date:start_date,
                    end_date: end_date,
                    utm_medium: utm_medium,
                    utm_source : utm_source,
                    utm_campaign : utm_campaign,
                    supplier_code:supplier_code
                },

                success: function (datas) {
                    var table = document.getElementById("tbody_export");
                    table.innerHTML = "";
                    datas.forEach(function orderExport(data) {
                        table.innerHTML +=
                            '<tr>' +
                                '<td>' + data.id + '</td>' +
                                '<td>' + (data.contact ? data.contact.full_name : '') + '</td>' +
                                '<td>' + (data.contact ? data.contact.email : '') + '</td>' +
                                '<td>' + (data.contact ? data.contact.phone : '')  + '</td>' +
                                '<td>' + (data.ticket ? data.ticket.bill_code : '') + '</td>' +
                                '<td>' + (data.ticket ? data.ticket.bill_value.toLocaleString('en-US') : '') + '</td>'+
                                '<td>' + (data.ticket ? data.ticket.store_name : '') + '</td>' +
                                '<td>' + (data.gift ? data.gift.supplier_code : '') + '</td>' +
                                '<td>' + (data.gift.name ?? '') + '</td>' +
                                '<td>' + (data.coupon_code ?? '') + '</td>' +
                                '<td>' + (data.contact ? data.contact.utm_medium : '') + '</td>' +
                                '<td>' + (data.contact ? data.contact.utm_source : '') + '</td>' +
                                '<td>' + (data.contact ? data.contact.utm_campaign : '') + '</td>' +
                                '<td>' + (data['created_at'] ? moment(data['created_at']).format('MM/DD/YYYY h:mm a') : '') + '</td>' +
                            '</tr>';
                    });
                    setTimeout(() => {
                        $("#table2excel").table2excel({
                            exclude: ".noExl",
                            name: "randomGirt Name",
                            filename: "Export_RandomGift_" + datetime + ".xls",
                            fileext: ".xls",
                            preserveColors: true
                        });
                    }, 500);
                    turnOffModalLoading();
                    messageSuccess('Export thành công!')
                },
                error: function (e) {
                    console.log(e.message);
                    $('#ViewModal').modal('hide');
                    $('#orderRefundModal').modal('hide');
                    messageError('Lỗi!')
                }
            });
        };
        $(function () {
            $(".scroll_bar").scroll(function () {
                $(".scroll_bar--bottom").scrollLeft($(".scroll_bar").scrollLeft());
            });
            $(".scroll_bar--bottom").scroll(function () {
                $(".scroll_bar").scrollLeft($(".scroll_bar--bottom").scrollLeft());
            });
        });
    </script>
@stop
