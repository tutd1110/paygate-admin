@extends('main.layout.master')
@section('title', 'Danh sách các cổng thanh toán mà đối tác đăng ký')

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
                        <a href="{{route('pgw_partner_resgistri_merchant.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách các cổng thanh toán mà đối tác đăng ký</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div class="btn-group">
                            <a href="{{route('pgw_partner_resgistri_merchant.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                            Danh sách các cổng thanh toán mà đối tác đăng ký
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    {{--                    @include("main.admin.news.components.item-search")--}}
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                           style="margin-top: 10px">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th><b>Payment Merchant ID</b></th>
                            <th><b>Mã đối tác</b></th>
                            <th><b>Thứ tự sắp xếp</b></th>
                            <th><b>Business</b></th>
                            <th><b>Action</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listPartnerResMerchant as $item)
                            <tr>
                                <td style="text-align: center">{!! $item['id'] !!}</td>
                                <td style="text-align: left;">{!! $item['payment_merchant_id'] !!}</td>
                                <td style="text-align: left">{!! $item['partner_code'] !!} </td>
                                <td style="text-align: left">{!! $item['sort'] !!} </td>
                                <td style="text-align: left">{!! $item['business'] !!} </td>
                                <td width="12%" style="vertical-align:middle;text-align: center">
                                    <form id="delete-form-{{$item['id']}}"
                                          action="{{ route('pgw_partner_resgistri_merchant.destroy', $item['id'])}}" method="post"
                                          style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:void(0);" title="Xóa" style="padding:10px"
                                           id="kt_sweetalert_demo_9" onclick="deleteAction({{$item['id']}})">
                                            <i class="fa fa-trash-alt"></i>

                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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
                if (result.value) {
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>
@stop
