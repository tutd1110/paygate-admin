@extends('main.layout.master')
@section('title', 'Danh sách hoá đơn')

@section('style')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/pgw_orders/orders.css">
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
                        <a href="{{route('pgw_partner.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách hoá
                            đơn </a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div id="button_add" class="btn-group">
                            <a href="{{ route('pgw_orders.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Thêm mới
                            </a>
                            @if (session()->has('url_order'))
                                <input id="url_order_newtab_id" hidden value="{{ session('url_order') }}">
                            @endif
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
                            Danh sách hoá đơn
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-portlet__container">
                        @include("main.admin.order.components.item-search")
                        <div class="scroll_bar">
                            <div class="scroll_bar--top"></div>
                        </div>
                        <div class="scroll_bar--bottom">
                            <div class="table-responsive">
                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                       id="item-list">
                                    <thead>
                                    <tr style="background-color: #b2c6ce;">
                                        <th style="vertical-align: middle;width: 3%;"><b>ID</b></th>
                                        <th style="vertical-align: middle;width: 4%;"><b>Mã ĐH</b></th>
                                        <th style="vertical-align: middle;width: 4%;"><b>Client ID</b></th>
                                        <th style="vertical-align: middle;width: 4%;"><b>Mã ĐT</b></th>
                                        <th style="vertical-align: middle;width: 8%;"><b>Thông tin KH</b></th>
                                        <th style="vertical-align: middle;width: 10%;"><b>Landing Page</b></th>
                                        <th style="vertical-align: middle;text-align: center;width: 5%;"><b>Thanh Toán</b></th>
                                        <th style="vertical-align: middle;width: 3%;"><b>SL</b></th>
                                        <th style="vertical-align: middle;width: 4%;"><b>Trạng thái</b></th>
                                        <th style="vertical-align: middle;width: 4%;"><b>Tổng Tiền</b></th>
                                        <th style="vertical-align: middle;width: 5%;"><b>Giảm Giá</b></th>
                                        <th style="vertical-align: middle;width: 6%"><b>Mã KM</b></th>
                                        <th style="vertical-align: middle;width: 6%;"><b>Mã đặt chỗ</b></th>
                                        <th style="vertical-align: middle;width: 6%;"><b>Mã kích hoạt</b></th>
                                        <th style="vertical-align: middle;width: 8%;"><b>Mã thanh toán</b></th>
                                        <th style="vertical-align: middle;width: 8%;"><b>Transsion ID</b></th>
                                        <th style="vertical-align: middle;width: 6%;"><b>Ngày tạo</b></th>
                                        <th style="vertical-align: middle;width: 6%;"><b>Ngày cập nhật</b></th>
                                        <th style="vertical-align: middle;width: 3%;"><b>Action</b></th>
                                        @if(session('partner_code') == '' && session('owner') == 'yes')
                                            <th style="vertical-align: middle;width: 5%;"><b>Update</b></th>
                                            <th style="vertical-align: middle;width: 5%"><b>Update CRM</b></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($getListOrders as $getListOrder)
                                        <tr>
                                            <td style="text-align: center;vertical-align: middle;">{!! $getListOrder['id'] !!}</td>
                                            @if(in_array($getListOrder['status'],\App\Http\Controllers\Admin\PgwOrdersController::ARRAY_STATUS_NOT_REDIRECT))
                                                <td style="text-align: center;vertical-align: middle;">{!! $getListOrder['code'] !!}</td>
                                            @else
                                                <td style="vertical-align: middle; text-align: center;"><a
                                                        href="{{env('PAYGATE_URL').$getListOrder['bill_code']}}"
                                                        target="_blank">{!! $getListOrder['code'] !!}</a></td>
                                            @endif
                                            <td style="vertical-align: middle; text-align: center;width: 2%;">{!! $getListOrder['order_client_id'] ?? '' !!}</td>
                                            <td style="vertical-align: middle; text-align: center;width: 4%;">{!! $getListOrder['partner_code'] ?? '' !!}</td>
                                            <td style="vertical-align: middle; text-align: left; position: relative;">
                                                <div class="row">
                                                    <div class="col-12" title="{!! isset($getListOrder['contact']) ? $getListOrder['contact']['full_name'] : '' !!}" style="vertical-align: middle; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        <p style="color: #5867dd;cursor: pointer; margin-bottom:0px"
                                                           onclick="showContact({{$getListOrder['id']}})">{!! isset($getListOrder['contact']) ? $getListOrder['contact']['full_name'] : '' !!}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; text-align: left;">
                                                {!!$dataRedis['listLDP'][$getListOrder['landing_page_id']]['domain_name'] ?? '' !!}
                                            </td>
                                            @if($getListOrder['banking_code'])
                                                <td style="vertical-align: middle; text-align: center;">
                                                    @if(isset($dataRedis['listBanking'][$getListOrder['banking_code']]['thumb_path']))
                                                        <img style="height: 100%;width: 40%"
                                                             src="{{asset($dataRedis['listBanking'][$getListOrder['banking_code']]['thumb_path'])}}"
                                                             alt="">
                                                    @endif
                                                </td>
                                            @else
                                                <td style="vertical-align: middle; text-align: center;">
                                                    @if(isset($dataRedis['listMerchant'][$getListOrder['merchant_code']]['thumb_path']))
                                                        <img style="height: 100%;width: 40%"
                                                             src="{{asset($dataRedis['listMerchant'][$getListOrder['merchant_code']]['thumb_path'])}}"
                                                             alt=""><br>
                                                    @endif
                                                </td>
                                            @endif
                                            <td style="vertical-align: middle; text-align: center;">{!! $getListOrder['quantity'] !!}</td>
                                            @if($getListOrder['status'] == 'new')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                       class="btn-new">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'paid')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-primary" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'processing')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-success" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'waiting')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-warning" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'fail')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-danger" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'refund')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-dark" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @elseif($getListOrder['status'] == 'cancel' || $getListOrder['status'] == 'expired')
                                                <td style="vertical-align: middle; text-align: center;"><p
                                                        id="id_status_{{$getListOrder['id']}}"
                                                        class="btn-dark" style="margin-bottom: 0">{!! $getListOrder['status'] !!}</p>
                                                </td>
                                            @endif
                                            <td style="vertical-align: middle; text-align: center;">{!! number_format($getListOrder['amount']) !!}</td>
                                            <td style="vertical-align: middle; text-align: center;">{!! number_format($getListOrder['discount']) !!}</td>
                                            <td style="vertical-align: middle; text-align: center;">{!! $getListOrder['coupon_code'] !!}</td>
                                            <td style="vertical-align: middle; text-align: center;">{!! $getListOrder['code_reverse'] ?? '' !!}</td>
                                            <td style="vertical-align: middle; ">{!! !empty($getListOrder['active_code']) ? $getListOrder['active_code'] : ''  !!}</td>
                                            <td style="vertical-align: middle; text-align: left;">{!! !empty($getListOrder['payment_request']['request_merchant']) ? $getListOrder['payment_request']['request_merchant'][0]['vpc_MerchTxnRef'] : ''  !!}</td>
                                            <td style="vertical-align: middle; text-align: left">{!! (!empty($getListOrder['payment_request']) && !empty($getListOrder['payment_request']['transsion_id'])) ? $getListOrder['payment_request']['transsion_id'] : '' !!}</td>
                                            <td style="vertical-align: middle; text-align: center">{!! date('d-m-Y H:i:s',strtotime($getListOrder['created_at'])) !!}</td>
                                            <td style="vertical-align: middle; text-align: center">{!! date('d-m-Y H:i:s',strtotime($getListOrder['updated_at'])) !!}</td>
                                            <td style="vertical-align: middle;text-align: center;" title="Hiển thị chi tiết đơn hàng" onmouseover="this.style.color='#5d78ff';" onmouseout="this.style.color='';">
                                                <span style="padding:10px;" id="showOrder_{{$getListOrder['id']}}"
                                                      onclick="showOrder({{ $getListOrder['id']}})"><i
                                                        class="fa fa-edit"></i></span>
                                            </td>
                                            @if(session('partner_code') == '' && session('owner') == 'yes' && !in_array($getListOrder['status'],\App\Http\Controllers\Admin\PgwOrdersController::ARRAY_STATUS_NOT_REDIRECT) )
                                                <td style="vertical-align: middle;text-align: center;"
                                                    title="Cập nhật đơn hàng thành công">
                                                <span style="padding:10px;align-items: center;"
                                                      onmouseover="this.style.color='#5d78ff';"
                                                      onmouseout="this.style.color='';"
                                                      id="updateOrderPaid_{{$getListOrder['id']}}"
                                                      onclick="updateOrderPaid({{$getListOrder['id']}})"><i
                                                        class="fa fa-sharp fa-solid fa-file-invoice-dollar"></i></span>
                                                </td>
                                                <td></td>
                                            @elseif(session('partner_code') == '' && session('owner') == 'yes' && $getListOrder['status'] == \App\Http\Controllers\Admin\PgwOrdersController::STATUS_PAID && $getListOrder['order_status'] == \App\Http\Controllers\Admin\PgwOrdersController::ORDER_CLIENT_STATUS_NOT_PAID
                                             && \Carbon\Carbon::parse($getListOrder['updated_at'])->setTimezone('+7:00')->addMinutes(\App\Http\Controllers\Admin\PgwOrdersController::TIME_LIMIT_ORDER_STATUS) < \Carbon\Carbon::now())
                                                <td></td>
                                                <td style="vertical-align: middle;text-align: center;"
                                                    title="Gửi lại thông tin đơn hàng cho CRM">
                                                <span style="padding:10px;align-items: center;"
                                                      onmouseover="this.style.color='#5d78ff';"
                                                      onmouseout="this.style.color='';"
                                                      id="updateOrderPaid_{{$getListOrder['id']}}"
                                                      onclick="updateOrderStatusToCRM({{$getListOrder['id']}})"><i
                                                        class="fa fa-sharp fa-solid fa-file-invoice-dollar"></i></span>
                                                </td>
                                            @elseif(session('partner_code') == '' && session('owner') == 'yes')
                                                <td></td>
                                                <td></td>
                                            @else
                                            @endif
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
                    <!--end::Form-->
                </div>

                <!--end::Portlet-->
            </div>
            <div class="modal fade kt-invoice-1" id="ViewModal" tabindex="-1" aria-labelledby="modalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelInfo">Chi tiết Hoá đơn</h5>
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
                                <div class="row justify-content-center">
                                    <div class="col-1">
                                        <label class="row col-form-label" for="partner_name" style="padding-left: 15px"><b>Mã
                                                đối
                                                tác:</b></label>
                                        <label class="row  col-form-label" id="label_partner_code"
                                               style="word-break: break-word;padding-left: 15px"></label>
                                    </div>
                                    <div class="col-2">
                                        <label class="row col-form-label" for="bill_code" style="padding-left: 15px"><b>Bill
                                                Code:</b></label>
                                        <label class="row  col-form-label" id="label_bill_code"
                                               style="word-break: break-word;padding-left: 15px"></label>
                                    </div>
                                    <div class="col-2">
                                        <label class="row col-form-label"
                                               for="landing_page"><b>Landing Page:</b></label>
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
                                <div class="table-responsive" id="table-responsive">
                                    <table id="id_table_orders" class="table table-bordered"
                                           style="font-family: Arial;vertical-align: middle;">
                                        <thead style="text-align: center; vertical-align: middle">
                                        <tr>
                                            <th style="vertical-align: middle;">Chọn</th>
                                            <th style="vertical-align: middle;">ID SP</th>
                                            <th style="vertical-align: middle;">ID ĐH</th>
                                            <th style="vertical-align: middle;">Mã ĐH</th>
                                            <th style="vertical-align: middle;">Loại SP</th>
                                            <th style="vertical-align: middle;">Tên SP</th>
                                            <th style="vertical-align: middle;">Mô tả</th>
                                            <th style="vertical-align: middle;">Số lượng</th>
                                            <th style="vertical-align: middle;">Tổng tiền</th>
                                            <th style="vertical-align: middle; width: 100px">Số tiền giảm giá</th>
                                            <th style="vertical-align: middle;">Ngày Tạo Đơn</th>
                                            <th style="vertical-align: middle;">Cập Nhật Cuối</th>
                                        </tr>
                                        </thead>
                                        <tbody id="orderDetail">
                                        </tbody>
                                    </table>
                                </div>
                                <div id="id_check_box_all" class="row"
                                     style="font-family: Arial;font-weight: bold;color:black"><input
                                        onclick="sumPriceTrue()" id="sum_price_checked" type="checkbox" checked
                                        style="margin-right: 15px;margin-left: 30px">Chọn tất cả
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="id_button_return" onclick="sumPrice()"
                                        type="button"
                                        class="btn btn-secondary btn-danger"
                                        data-bs-dismiss="modal">Hoàn Trả
                                </button>
                                <button id="id_button_cancel" onclick="cancelOrder()"
                                        style="margin-right: 2rem;color: white !important;" type="button"
                                        class="btn-dark kt-font-dark btn " data-bs-dismiss="modal">Cancel
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="viewContactModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelInfo">Thông tin khách hàng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <br>
                            <div style="" class="row">
                                <label class="col-lg-1 col-form-label text-left" for="id">ID khách hàng:</label>
                                <label class="col-lg-2 col-form-label text-left" for="full_name">Tên khách hàng:</label>
                                <label class="col-lg-3 col-form-label text-left" for="email">Email khách hàng</label>
                                <label class="col-lg-2 col-form-label text-left" for="phone">Số điện thoại:</label>
                                <label class="col-lg-2 col-form-label text-left" for="gender">Giới tính:</label>
                                <label class="col-lg-2 col-form-label text-left" for="coupon_code">Mã đặt chỗ:</label>
                            </div>

                            <div class="row">
                                <label class="col-lg-1 col-form-label" id="label_id"></label>
                                <label class="col-lg-2 col-form-label" id="label_full_name"></label>
                                <label class="col-lg-3 col-form-label" id="label_email"></label>
                                <label class="col-lg-2 col-form-label" id="label_phone"></label>
                                <label class="col-lg-2 col-form-label" id="label_gender"></label>
                                <label class="col-lg-2 col-form-label" id="label_coupon_code"></label>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="orderRefundModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-body-x-fit"
                 style="">
                <div class="modal-content" style="border: solid #0f9af0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelInfo">Hoàn trả đơn hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-form-label text-left" for="id_refund_value">Số tiền hoàn trả(VNĐ)</label>
                        </div>
                        <div class="row">
                            <input class="form-control" id="id_refund_value" required type="number">
                            <br>
                            <span hidden id="error_refund_value" class="message" style="color: #ff0000">Số tiền hoàn trả
                                không hợp lệ!</span>
                        </div>
                        <div class="row">
                            <label class=" col-form-label text-left" for="id_order_refund_decription">Mô tả:</label><br>
                        </div>
                        <div class="row">
                            <textarea id="id_order_refund_decription" required name="description"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <submit onclick="addOrderRefund()" style=""
                                    class="btn btn-secondary btn-success"
                                    data-bs-dismiss="modal">Xác Nhận
                            </submit>
                        </div>
                        <div>
                            <button onclick="$('#orderRefundModal').modal('hide');" style="" type="button"
                                    class="btn btn-secondary btn-danger"
                                    data-bs-dismiss="modal">Huỷ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="orderRefundModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <table class="table table-striped- table-bordered table-hover table-checkable"
                   id="table2excel">
                <thead>
                <tr>
                    <td style="vertical-align: middle;"><b>ID</b></td>
                    <td style="vertical-align: middle;"><b>Mã Hoá Đơn</b></td>
                    <td style="vertical-align: middle;"><b>Order Client Id</b></td>
                    <td style="vertical-align: middle;"><b>Mã đối tác</b></td>
                    <td style="vertical-align: middle;"><b>Thông tin khách hàng</b></td>
                    <td style="vertical-align: middle;"><b>Số điện thoại</b></td>
                    <td style="vertical-align: middle;"><b>Email</b></td>
                    <td style="vertical-align: middle;"><b>Landing Page</b></td>
                    <td style="vertical-align: middle;"><b>Đơn Vị Thanh Toán</b></td>
                    <td style="vertical-align: middle;"><b>Tổng Tiền(VND)</b></td>
                    <td style="vertical-align: middle;"><b>Giảm Giá</b></td>
                    <td style="vertical-align: middle;"><b>Mã khuyến mại</b></td>
                    <td style="vertical-align: middle;"><b>Số lượng</b></td>
                    <td style="vertical-align: middle;"><b>Transsion_Id</b></td>
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
    <div class="modal fade " id="modal-loading" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loading-spinner mb-2"></div>
                    <div>Loading</div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        var loading = document.getElementById("modal-loading");

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

        // var checkNavbarHidden = "";
        // var checkNavbarHiddenOrder = "";
        function turnOnModalLoading() {
            $('#modal-loading').modal('show');
        };

        function turnOffModalLoading() {
            $('#modal-loading').modal('hide');
        }

        function updateOrderPaid(id) {
            swal.fire({
                title: '<p style="font-size: 20px;color: #dc9124">CẬP NHẬT</p>',
                html: "<p style='font-size: 16px'>Bạn có chắc chắn muốn cập nhật đơn hàng <strong>"+id+"</strong>?</p>",
                type: 'success',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: '{{route('pgw_orders.updateOrderPaid')}}',
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function (data) {
                            if (data.check) {
                                var classStatusOrder = $('#id_status_' + id).attr('class');
                                if (classStatusOrder) {
                                    $('#id_status_' + id).removeClass(classStatusOrder);
                                }
                                $('#id_status_' + id).attr('class', 'btn-primary');
                                $('#id_status_' + id).text('paid');
                                messageSuccess('Cập nhật đơn hàng thành công!')
                            } else {
                                messageError(data.message)
                            }
                        },
                        error: function (e) {
                            console.log(e.message);
                        }
                    });
                }
            });
        }

        function updateOrderStatusToCRM(id) {
            swal.fire({
                title: '<p style="font-size: 20px;color: #dc9124">CẬP NHẬT</p>',
                html: "<p style='font-size: 16px'>Bạn có chắc chắn muốn gửi lại thông tin đơn hàng <strong>" + id + "</strong> cho CRM?</p>",
                type: 'success',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: '{{route('pgw_orders.updateOrderStatusToCRM')}}',
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function (data) {
                            if (data.check) {
                                messageSuccess('Gửi thông tin đơn hàng sang CRM thành công!')
                            } else {
                                messageError(data.message)
                            }
                        },
                        error: function (e) {
                            console.log(e.message);
                        }
                    });
                }
            });
        }

        function showOrder(id) {
            loading.classList.remove("loading");
            $(".modal-backdrop").show();
            turnOnModalLoading();
            $('#id_refund_value').val("");
            $('#id_order_refund_decription').val("");
            $.ajax({
                url: '{{route('pgw_orders.show')}}',
                type: 'POST',
                data: {
                    id: id,
                    getPartner: true,
                    getLandingPage: true,
                    getOrderDetail: true,
                    getContact: true
                },

                success: function (data) {
                    loading.classList.add("loading");
                    $(".modal-backdrop").hide();
                    let dataOrder = data.data[0];

                    let dataOrderDetail = data.data[0].order_detail;
                    let informationContact = data.data[0].contact;
                    var landingPageID = dataOrder.landing_page ? dataOrder.landing_page.id : '';

                    document.getElementById("label_partner_code").innerText = dataOrder.partner ? dataOrder.partner.code : 'Không có thông tin!';
                    document.getElementById("label_landing_page").innerText = dataOrder.landing_page ? dataOrder.landing_page.domain_name : 'không có thông tin!';
                    document.getElementById("label_bill_code").innerText = dataOrder.bill_code ? dataOrder.bill_code : 'không có thông tin!';

                    $('#label_landing_page').attr('data-value', landingPageID);
                    ['full_name', 'phone', 'email'].forEach(function orderContact(field) {
                        if (informationContact) {
                            document.getElementById("label_contact_" + field).innerText = informationContact[field];
                        } else {
                            document.getElementById("label_contact_" + field).innerText = 'Không có thông tin!'
                        }
                    });
                    (dataOrder.status != 'paid') ? $('#id_button_return').attr("hidden", true) : $('#id_button_return').removeAttr('hidden');
                    (['new', 'waiting', 'processing'].includes(dataOrder.status) == false) ? $('#id_button_cancel').attr("hidden", true) : $('#id_button_cancel').removeAttr('hidden');
                    $("#orderDetail tr").remove();
                    var arrayCheckbox = [];
                    var table = document.getElementById("orderDetail");
                    table.innerHTML += "";
                    dataOrderDetail.forEach(function orderDetail(orderDetail) {
                        var dateStart = (new Date(orderDetail.created_at));
                        var dateEnd = (new Date(orderDetail.updated_at));


                        table.innerHTML +=
                            '<tr>' +
                            '<td style="text-align: center" id="order_checkbox_detail_id" data-value=' + orderDetail.id + '><input id="checkbox_' + orderDetail.id + '"  class="sum_price"  onclick="sumPriceReset()" value=' + orderDetail.price + ' type="checkbox" data-id = ' + orderDetail.id + ' checked></td>' +
                            '<td style="text-align: center" id="order_detail_id"  data-value=' + orderDetail.product_id + ' >' + orderDetail.product_id + '</td>' +
                            '<td style="text-align: center" id="order_id" data-value=' + orderDetail.order_id + ' >' + orderDetail.order_id + '</td>' +
                            '<td style="text-align: center" id="label_code" data-value=' + dataOrder.code + ' >' + dataOrder.code + '</td>' +
                            '<td style="text-align: center" id="order_detail_product_type" data-value=' + orderDetail.product_type + ' >' + orderDetail.product_type + '</td>' +
                            '<td style="text-align: left" id="order_detail_product_name" data-value=' + orderDetail.product_name + ' >' + orderDetail.product_name + '</td>' +
                            '<td style="text-align: center" id="order_detail_description" data-value=' + orderDetail.description + ' >' + (orderDetail.description ? orderDetail.description : '') + '</td>' +
                            '<td style="text-align: center" id="order_detail_quantity" data-value=' + orderDetail.quantity + '>' + orderDetail.quantity + '</td>' +
                            '<td style="text-align: center" id="order_deatail_price" data-value=' + orderDetail.price + '>' + new Intl.NumberFormat().format(orderDetail.price) + '</td>' +
                            '<td style="text-align: center" id="order_deatail_discount" data-value=' + orderDetail.discount + '>' + new Intl.NumberFormat().format(orderDetail.discount) + '</td>' +
                            '<td style="text-align: center" id="order_date_start" data-value=' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '> ' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '<td style="text-align: center" id="order_date_end" data-value=' + new Date() + '>' + moment(dateEnd).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '</tr>';
                        if (orderDetail.is_refund == "yes") {
                            $('#order_checkbox_detail_id').prop('disabled', true);
                            $('#checkbox_' + orderDetail.id).prop('disabled', true);
                            $('#checkbox_' + orderDetail.id).attr('checked', false);
                        } else {
                            arrayCheckbox.push(orderDetail.id);
                        }
                    });

                    (arrayCheckbox.length == 0) ? $('#id_button_return').hide() : $('#id_button_return').show();
                    (arrayCheckbox.length == 0) ? $('#id_check_box_all').hide() : $('#id_check_box_all').show();
                    $('#ViewModal').modal('show');
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
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

        function sumPrice() {
            $('#orderRefundModal').modal('show');
            var sum_price = 0;
            $('input:checkbox.sum_price').each(function () {
                var sThisVal = (this.checked ? $(this).val() : 0);
                sum_price = parseInt(sThisVal) + sum_price;
            });
            $('#id_refund_value').val(sum_price);
        }

        function cancelOrder() {
            var order_id = $('#order_id').attr('data-value');
            $.ajax({
                url: '{{route('pgw_orders.changeStatus') }}',
                type: 'GET',
                data: {
                    id: order_id
                },
                success: function (data) {
                    if (data.data && data.status == 200) {
                        var valueStatus = document.getElementById('id_status_' + order_id);
                        valueStatus.textContent = data.data.status;
                        valueStatus.classList.remove(valueStatus.classList[0]);
                        valueStatus.classList.add("btn-dark");
                        turnOffModalLoading();
                        $('#ViewModal').modal('hide');
                        messageSuccess('Thay đổi trạng thái thành công!')
                    } else {
                        messageError('Bạn không có quyền cập nhật trạng thái đơn hàng!')
                    }
                }
            });
        }

        function addOrderRefund() {
            turnOnModalLoading();
            var order_id = $('#order_id').attr('data-value');
            var order_refund_value = $('#id_refund_value').val();
            var order_refund_decription = $('#id_order_refund_decription').val();
            var order_landing_page_id = $('#label_landing_page').attr('data-value');
            var partner_code = $("#label_partner_code").text();
            var arrayOrderDetailId = [];
            $('input:checkbox.sum_price').each(function () {
                var idOrderDetail = (this.checked ? $(this).attr('data-id') : null);
                (idOrderDetail) ? arrayOrderDetailId.push(idOrderDetail) : '';
            });
            if (order_refund_value <= 0 || !order_refund_value) {
                $('#error_refund_value').removeAttr('hidden');
                setTimeout(hideError, 6000);
                return false;
            }
            if (!partner_code || partner_code == 'Không có thông tin!') {
                $('#ViewModal').modal('hide');
                $('#orderRefundModal').modal('hide');
                messageError('Mã đối tác không hợp lệ!');
                return false;
            }
            $.ajax({
                url: '{{route('pgw_order_refund.store') }}',
                type: 'POST',
                data: {
                    order_id: order_id,
                    landing_page_id: order_landing_page_id,
                    partner_code: partner_code,
                    refund_value: order_refund_value,
                    description: order_refund_decription,
                    array_order_detail_id: arrayOrderDetailId,
                    status: 'request',
                },
                success: function (data) {
                    turnOffModalLoading();
                    $('#ViewModal').modal('hide');
                    $('#orderRefundModal').modal('hide');
                    messageSuccess('Hoàn trả thành công!')
                },
                error: function (e) {
                    console.log(e.message);
                    $('#ViewModal').modal('hide');
                    $('#orderRefundModal').modal('hide');
                    messageError('Hoàn trả thất bại!');
                }
            });
        }

        function resetSearch() {
            $("#id_code").val("");
            $("#id_partner_code").val("");
            $("#id_quantity").val("");
            $("#id_amount_first").val("");
            $("#id_amount_end").val("");
            $("#id_start_date").val("");
            $("#id_end_date").val("");
            $("#id_merchant_banking_code").val("");
            $("#id_landing_page_id").val("");
            $("#id_status").val("");
            window.location.href = '/pgw_orders';
        }

        $('.select2[multiple]').select2({
            width: '100%',
            closeOnSelect: false
        })

        function showContact(id) {
            loading.classList.remove("loading");
            turnOnModalLoading();
            $.ajax({
                url: '{{route('pgw_orders.show',$getListOrder['id'] ?? 0) }}',
                type: 'POST',
                data: {
                    id: id,
                    getContactReserveLogs: true,
                    getContact: true,
                },

                success: function (data) {
                    loading.classList.add("loading");
                    $(".modal-backdrop").hide();
                    let informationContact = data.data[0].contact;
                    let contactLeadProcessReserveLogs = data.data[0].contact_lead_process_reserve_logs;
                    if (contactLeadProcessReserveLogs && contactLeadProcessReserveLogs.landing_page_id) {
                        if (informationContact.landing_page_id == contactLeadProcessReserveLogs.landing_page_id) {
                            informationContact['coupon_code'] = contactLeadProcessReserveLogs.coupon_code ?? null;
                        }
                    } else {
                        informationContact['coupon_code'] = null;
                    }
                    ['full_name', 'phone', 'email', 'id', 'gender', 'coupon_code'].forEach(function orderDetail(field) {
                        if (informationContact[field]) {
                            document.getElementById("label_" + field).innerText = informationContact[field]
                        } else {
                            document.getElementById("label_" + field).innerText = 'Không có thông tin!'
                        }


                    });

                    $('#viewContactModal').modal('show');
                }
            });
        }

        function sumPriceTrue() {
            var checked = $('#sum_price_checked').is(":checked");
            if (checked == true) {
                $('.sum_price').prop('checked', true);
            } else {
                $('.sum_price').prop('checked', false);
            }
        }

        function sumPriceReset() {
            // var checked = $('.sum_price').is(":checked");
            // console.log(checked);
        }

        // function sumPriceFalse(){
        //     $('.sum_price').prop('checked', true);
        //     $('#sum_price_true').removeAttr('hidden');
        //     $('#sum_price_false').attr("hidden",true);
        // }

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

        function exportExcel() {
            turnOnModalLoading();
            var code = $("#id_code").val();
            var partner_code = $("#id_partner_code").val();
            var quantity = $("#id_quantity").val();
            var start_date = $("#id_start_date").val();
            var end_date = $("#id_end_date").val();
            var merchant_banking_code = $("#id_merchant_banking_code").val();
            var landing_page_id = $("#id_landing_page_id").val();
            var status = $("#id_status").val();

            var datetime = moment(new Date()).format('DD/MM/YYYY');
            $.ajax({
                url: '{{route('pgw_orders.export') }}',
                type: 'GET',
                data: {
                    code: code,
                    partner_code: partner_code,
                    quantity: quantity,
                    start_date: start_date,
                    end_date: end_date,
                    merchant_banking_code: merchant_banking_code,
                    landing_page_id: landing_page_id,
                    status: status,
                    getLandingPage: true,
                    getContact: true,
                    getPaymentRequest: true,
                },

                success: function (datas) {
                    var table = document.getElementById("tbody_export");
                    table.innerHTML = "";
                    datas.forEach(function orderExport(data) {
                        var dateStart = (new Date(data.created_at));
                        var dateEnd = (new Date(data.updated_at));
                        data.code = (!data.code) ? '' : data.code;
                        data.order_client_id = (!data.order_client_id) ? '' : data.order_client_id;
                        data.bankingCode = ((data.merchant_code) && (data.merchant_code != 'transfer')) ? data.merchant_code : data.banking_code;
                        data.landing_page = data.landing_page ? data.landing_page.domain_name : null;
                        var full_name = data.contact ? ((data.contact.full_name) ? data.contact.full_name : null) : null;
                        var phone = data.contact ? ((data.contact.phone) ? data.contact.phone : null) : null;
                        var email = data.contact ? ((data.contact.email) ? data.contact.email : null) : null;
                        var transsion_id = data.payment_request ? ((data.payment_request.transsion_id) ? data.payment_request.transsion_id : '') : '';
                        table.innerHTML +=
                            '<tr>' +
                            '<td>' + data.id + '</td>' +
                            '<td>' + data.code + '</td>' +
                            '<td>' + data.order_client_id + '</td>' +
                            '<td>' + data.partner_code + '</td>' +
                            '<td>' + full_name + '</td>' +
                            '<td>' + phone + '</td>' +
                            '<td>' + email + '</td>' +
                            '<td>' + data.landing_page + '</td>' +
                            '<td>' + data.bankingCode + '</td>' +
                            '<td style="text-align: center">' + new Intl.NumberFormat().format(data.amount) + ' VND</td>' +
                            '<td style="text-align: center">' + new Intl.NumberFormat().format(data.discount) + ' VND</td>' +
                            '<td style="text-align: center">' + data.coupon_code + '</td>' +
                            '<td style="text-align: center">' + data.quantity + '</td>' +
                            '<td>' + transsion_id + '</td>' +
                            '<td style="text-align: center">' + data.status ?? "" + '</td>' +
                            '<td style="text-align: center">' + moment(dateStart).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '<td style="text-align: center">' + moment(dateEnd).format('DD/MM/YYYY, h:mm:ss') + '</td>' +
                            '</tr>';
                    });
                    setTimeout(() => {
                        $("#table2excel").table2excel({
                            exclude: ".noExl",
                            name: "Worksheet Name",
                            filename: "Export_Order_" + datetime + ".xls",
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

        var url_order_newtab = $('#url_order_newtab_id').val();
        if (url_order_newtab) {
            window.open(url_order_newtab, "_blank");
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
