@extends('main.layout.master')
@section('title', 'Danh sách ngân hàng ')

@section('style')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
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
                        <a href="" class="kt-subheader__breadcrumbs-link">Danh sách ngân hàng </a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div class="btn-group">
                            <a href="{{ route('pgw_listbanking.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                            Danh sách ngân hàng
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    {{--                    @include("main.admin.news.components.item-search") --}}
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                        style="margin-top: 10px">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><b>Mã ngân hàng</b></th>
                                <th><b>Tên ngân hàng</b></th>
                                <th><b>Ảnh</b></th>
                                <th><b>Trạng thái</b></th>
                                <th><b>Hành động</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listBanking as $item)
                                <tr>
                                    <td style="text-align: center">{!! $item['id'] !!}</td>
                                    <td style="text-align: left;">{!! $item['code'] !!}</td>
                                    <td style="text-align: left">{!! $item['name'] !!} </td>
                                    <td style="text-align: left"><img src="{!! asset($item['thumb_path']) !!}" alt=""
                                            style="max-width: 10rem;display: block;margin: 0 auto;"> </td>
                                    @if ($item['status'] == 'active')
                                        <td style="text-align: center;">
                                            <p class="btn-success">{!! $item['status'] !!}</p>
                                        </td>
                                    @elseif($item['status'] == 'inactive')
                                        <td style="text-align: center;">
                                            <p class="btn-danger">{!! $item['status'] !!}</p>
                                        </td>
                                    @endif
                                    <td width="12%" style="vertical-align:middle;text-align: center">
                                        <a href="{!! route('pgw_listbanking.edit', $item['id']) !!}" title="Sửa" style="padding:10px">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form id="delete-form-{{ $item['id'] }}"
                                            action="{{ route('pgw_listbanking.destroy', $item['id']) }}" method="post"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0);" title="Xóa" style="padding:10px"
                                                id="kt_sweetalert_demo_9" onclick="deleteAction({{ $item['id'] }})">
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            }).then(function(result) {
                if (result.value) {
                    $('#delete-form-' + id).submit();
                }
            });
        }
    </script>

@stop
