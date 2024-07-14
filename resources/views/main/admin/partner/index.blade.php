@extends('main.layout.master')
@section('title', 'Danh sách đối tác thanh toán')

@section('style')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/pgw_orders/orders.css">
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
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{route('pgw_partner.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách đối
                            tác thanh toán </a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div class="btn-group">
                            &nbsp;
                            <a href="{{ route('pgw_partner.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Thêm mới
                            </a>
                        </div>
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
                            Danh Sách Đối Tác Thanh Toán
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include("main.admin.partner.components.item-search")
                    <div class="scroll_bar">
                        <div class="scroll_bar--top"></div>
                    </div>
                    <div class="scroll_bar--bottom">
                    <div class="table-responsive" style="min-width: 110% !important;">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                               style="margin-top: 10px">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th><b>Mã đối tác</b></th>
                                <th><b>Tên đối tác</b></th>
                                <th><b>Thông tin mô tả</b></th>
                                <th><b>Cổng thanh toán kết nối</b></th>
                                <th><b>Ngân hàng đăng ký</b></th>
                                <th><b>Ngày cập nhật cuối cùng</b></th>
                                <th><b>Trạng thái</b></th>
                                <th><b>Hành động</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $listPartner)
                                <tr>
                                    <td style="text-align: center">{!! $listPartner['id'] !!}</td>
                                    <td style="text-align: center;">{!! $listPartner['code'] !!}</td>
                                    <td style="text-align: center;width: 12rem;">{!! $listPartner['name'] !!} </td>
                                    <td style="text-align: left;width: 22rem;">{!! $listPartner['description'] !!} </td>
                                    <td style="text-align: left;width: 14rem;">
                                        @if(isset($listPartner['resgistri_merchant']))
                                            @foreach($listPartner['resgistri_merchant'] as $resMerchant)
                                                {!! ($resMerchant['payment_merchant_list']['name']) ?? ""  !!} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="text-align: left">
                                        @if(isset($listPartner['registri_banking']))
                                            @foreach($listPartner['registri_banking'] as $resBanking)
                                                {!! ($resBanking['banking_list']['code'] . "-" . $resBanking['bank_number'] . "-" .   $resBanking['owner'] . "-" . "<br>" . $resBanking['business'] )  !!}
                                                <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="text-align: center"> {!! date("d-m-Y H:i:s", strtotime($listPartner['updated_at'])) !!}
                                    </td>
                                    @if($listPartner['status'] == 'active')
                                        <td style="text-align: center;"><p
                                                class="btn-success">{!! $listPartner['status'] !!}</p>
                                        </td>
                                    @elseif($listPartner['status'] == 'inactive')
                                        <td style="text-align: center;"><p
                                                class="btn-danger">{!! $listPartner['status'] !!}</p>
                                        </td>
                                    @endif
                                    <td style="vertical-align:middle;text-align: center;">
                                        <a href="{!! route('pgw_partner.edit',$listPartner['id']) !!}" title="Sửa">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form id="delete-form-{{$listPartner['id']}}"
                                              action="{{ route('pgw_partner.destroy', $listPartner['id'])}}"
                                              method="post"
                                              style="display: inline-block">
                                            @csrf
                                        </form>
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
                </div>


            </div>
            <!--end::Form-->
        </div>
                <!--end::Form-->
            </div>

            <!--end::Portlet-->
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
                console.log(result.value);
                if (result.value) {
                    $('#delete-form-' + id).submit();
                }
            });
        }
        $(document).on('click', '.paginate_button', function () {
            var page = $(this).val();
            if (page > 0 && page <= {{$paginate['last_page']}}) {
                var limit = $('#set_limit').val();
                var a = $('#id_limit').val(limit);
                $('#id_page').val(page);
                $('#orderSearch').submit();
            } else {
                alert("Đã hết số trang");
            }
        });

        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#orderSearch').submit();
        }
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
