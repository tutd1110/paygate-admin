@extends('main.layout.master')
@section('title', 'Danh sách các ngân hàng đối tác đăng ký chuyển khoản')

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
                        <a href="{{route('pgw_partner_resgistri_banking.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách các ngân hàng đối tác đăng ký chuyển khoản</a>
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
                            Danh sách các ngân hàng đối tác đăng ký chuyển khoản
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
                            <th><b>Code</b></th>
                            <th><b>Id ngân hàng</b></th>
                            <th><b>Mô tả</b></th>
                            <th><b>Mã đối tác</b></th>
                            <th><b>Tên chủ tài khoản</b></th>
                            <th><b>Số tài khoản</b></th>
                            <th><b>Chi nhánh của tài khoản</b></th>
                            <th><b>Thông tin kết nối đến ngân hàng </b></th>
                            <th><b>Trạng thái </b></th>
                            <th><b>Thứ tự sắp xếp</b></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listPartnerResBank as $item)
                            <tr>
                                <td style="text-align: center">{!! $item['code'] !!}</td>
                                <td style="text-align: left;">{!! $item['banking_list_id'] !!}</td>
                                <td style="text-align: left">{!! $item['description'] !!} </td>
                                <td style="text-align: left">{!! $item['partner_code'] !!} </td>
                                <td style="text-align: left">{!! $item['owner'] !!} </td>
                                <td style="text-align: left">{!! $item['bank_number'] !!} </td>
                                <td style="text-align: left">{!! $item['branch'] !!} </td>
                                <td style="text-align: left">{!! $item['business'] !!} </td>
                                <td style="text-align: left">{!! $item['type'] !!} </td>
                                <td style="text-align: left">{!! $item['sort'] !!} </td>

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
