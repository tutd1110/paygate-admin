@extends('main.layout.master')
@section('title', 'Danh sách SMS Template')

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
                        <a href="{{route('template_messages.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách
                            SMS Template</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div id="button_add" class="btn-group">
                            <a href="{{ route('template_messages.create') }}"
                               class="btn btn-brand btn-elevate btn-icon-sm">
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
                            Danh sách SMS Template
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include("main.admin.template-messages.components.item-search")
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                               style="margin-top: 10px">
                            <thead>
                            <tr>
                                <th style="vertical-align: middle">ID</th>
                                <th style="vertical-align: middle"><b>Template Name</b></th>
                                <th style="vertical-align: middle"><b>Code</b></th>
                                <th style="vertical-align: middle"><b>Event</b></th>
                                <th style="vertical-align: middle"><b>Content</b></th>
                                <th style="vertical-align: middle"><b>Bind Param</b></th>
                                <th style="vertical-align: middle"><b>Trạng thái</b></th>
                                <th style="vertical-align: middle"><b>Landing Page</b></th>
                                <th style="vertical-align: middle"><b>Ngày tạo</b></th>
                                <th style="vertical-align: middle"><b>Ngày cập nhật</b></th>
                                <th style="vertical-align: middle"><b>Action</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listTemplatMessages as $templateMessages)
                                <tr>
                                    <td style="text-align: center;vertical-align: middle;">{!! $templateMessages['id'] !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $templateMessages['template_name'] !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $templateMessages['code'] !!} </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $templateMessages['event']!!} </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $templateMessages['content'] !!} </td>
                                    <td style="text-align: left;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;vertical-align: middle;">{!! $templateMessages['bind_param'] !!} </td>
                                    {{--                                <td style="text-align: left">{!! $listOrderRefund['status'] !!} </td>--}}
                                    <td style="text-align: center; vertical-align: middle"
                                        class="active_col_{{ $templateMessages['id'] }}">
                                        @if($templateMessages['status'] == \App\Http\Controllers\Admin\MessageTemplateController::DEFAULT_STATUS_ACTIVE )
                                            <span class="kt-badge kt-badge--inline kt-badge--success button_status"
                                                  id="StatusAction_{{ $templateMessages['id'] }}"
                                                  onclick="statusChange({{ $templateMessages['id'] }}, 'inactive')">Active</span>
                                        @else
                                            <span class="kt-badge kt-badge--inline kt-badge--danger button_status"
                                                  id="StatusAction_{{ $templateMessages['id'] }}"
                                                  onclick="statusChange({{ $templateMessages['id'] }}, 'active')">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $templateMessages['landing_page']['domain_name'] ?? ''!!} </td>
                                    {{--                                <td style="text-align: left">{!! $listPayment['sort'] !!}</td>--}}
                                    <td style="text-align: center;vertical-align: middle;">{!! date('d-m-Y H:i',strtotime($templateMessages['created_at'])) !!}</td>
                                    <td style="text-align: center;vertical-align: middle;">{!! date('d-m-Y H:i',strtotime($templateMessages['updated_at'])) !!}</td>
                                    {{--                                --}}
                                    <td style="width:100px;vertical-align: middle; vertical-align:middle;text-align: center;">
                                        <a href="{{route('template_messages.edit',['id'=> $templateMessages['id']])}}"
                                           style="padding:10px;"><i
                                                class="fa fa-edit"></i></a>
                                        <form id="delete-form-{{$templateMessages['id']}}"
                                              action="{{ route('template_messages.destroy', $templateMessages['id'])}}"
                                              method="post"
                                              style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0);" title="Xóa" style="padding:10px"
                                               id="kt_sweetalert_demo_9"
                                               onclick="deleteAction({{$templateMessages['id']}})">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </form>
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
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        function statusChange(id, status) {
            console.log(id, status)
            if (status == 0) {
                status = 'inactive'
            }
            if (status == 1) {
                status = 'active';
            }
            $.ajax({
                url: '{{ route('template_messages.statusChange') }}',
                type: 'POST',
                data: {id: id, status: status},

                success: function (data) {
                    var data = data.messageTemplate;
                    console.log(data);
                    if (data) {
                        $(".active_col_" + id + " #StatusAction_" + id).remove();
                        if (data.status == 'active') {
                            $(".active_col_" + id).append('<span class="kt-badge kt-badge--inline kt-badge--success button_status" id="StatusAction_' + id + '" onclick="statusChange(' + id + ', 0)">Active</span>');
                        } else {
                            $(".active_col_" + id).append('<span class="kt-badge kt-badge--inline kt-badge--danger button_status" id="StatusAction_' + id + '" onclick="statusChange(' + id + ', 1)">Inatcive</span>');
                        }
                        return;
                    }
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
                $('#templateSearch').submit();
            } else {
                alert("Đã hết số trang");
            }
        });

        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#templateSearch').submit();
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
            $("#search_submit").click();
        }
    </script>
@stop
