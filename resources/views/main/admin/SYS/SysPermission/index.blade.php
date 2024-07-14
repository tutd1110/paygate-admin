@extends('main.layout.master')
@section('title', 'Danh sách quyền')

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
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{route('sys_permission.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách quyền </a>
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
                            Danh Sách Quyền
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include("main.admin.SYS.SysPermission.components.item-search")
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                               style="margin-top: 10px">
                            <thead>
                            <tr>
                                <th><b>ID</b></th>
                                <th><b>Tên quyền</b></th>
                                <th><b>Quyền Alias</b></th>
                                <th><b>Tên Module</b></th>
                                <th><b>Ngày được tạo</b></th>
                                <th><b>Ngày cập nhật </b></th>
                                <th><b>Hành động</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $listPermiss)
                                <tr>
                                    <td style="text-align: center">{!! $listPermiss['id'] !!}</td>
                                    <td style="text-align: left;">{!! $listPermiss['name'] !!} </td>
                                    <td style="text-align: left;">{!! $listPermiss['name_alias'] !!} </td>
                                    <td style="text-align: center;">{!! $listPermiss['module']['module'] !!} </td>
                                    <td style="text-align: center"> {!! date("d-m-Y H:i:s", strtotime($listPermiss['created_at'])) !!}</td>
                                    <td style="text-align: center"> {!! date("d-m-Y H:i:s", strtotime($listPermiss['updated_at'])) !!}</td>
                                    <td style="vertical-align:middle;text-align: center;">
                                        <a href="{!! route('sys_permission.edit',$listPermiss['id']) !!}" title="Sửa" style="font-size: 1.5rem"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                $('#requestSearch').submit();
            } else {
                alert("Đã hết số trang");
            }
        });

        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#requestSearch').submit();
        }
        $('.select2').select2({
            width: '100%',
            closeOnSelect: false
        })
        function resetSearch() {
            $("#name_alias").val("");
            $("#list_module").val("");
            $("#day_start").val("");
            $("#day_end").val("");
            window.location.href = "/sys_permission";
        }
    </script>

@stop
