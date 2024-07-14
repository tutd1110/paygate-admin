@extends('main.layout.master')
@section('title', 'Danh sách Email Template')

@section('style')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/pgw_orders/orders.css">
    <style>
        .button_status {
            cursor: pointer;
        }
        p{
            margin-bottom: 0px;
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
                        <a href="{{route('emailTemplate.index')}}" class="kt-subheader__breadcrumbs-link">Danh sách
                            Email Template</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div id="button_add" class="btn-group">
                            <a href="{{ route('emailTemplate.create') }}"
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
                            Danh sách Email Template
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    @include("main.admin.template-email.components.item-search")
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="item-list"
                               style="margin-top: 10px">
                            <thead>
                            <tr>
                                <th style="vertical-align: middle">ID</th>
                                <th style="vertical-align: middle">Code</th>
                                <th style="vertical-align: middle"><b>Email Name</b></th>
                                <th style="vertical-align: middle"><b>Subject</b></th>
                                <th style="vertical-align: middle"><b>Mô tả</b></th>
                                <th style="vertical-align: middle"><b>Nội dung</b></th>
                                <th style="vertical-align: middle"><b>Trạng thái</b></th>
                                <th style="vertical-align: middle"><b>Action</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listTemplateEmails as $listTemplateEmail)
                                <tr>
                                    <td style="text-align: center;vertical-align: middle;">{!! $loop->iteration !!}</td>
                                    <td style="text-align: center;vertical-align: middle;">{!! $listTemplateEmail['code'] !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listTemplateEmail['name'] !!}</td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listTemplateEmail['subject'] !!} </td>
                                    <td style="text-align: left;vertical-align: middle;">{!! $listTemplateEmail['description']!!} </td>
                                    <td style="text-align: center;vertical-align: middle;">
                                        <span class="kt-badge kt-badge--inline kt-badge--brand" style="cursor: pointer;" id="showPreview_{{$listTemplateEmail['id']}}"
                                        onclick="showPreview({{ $listTemplateEmail['id']}})">
                                        <i class="fa fa-eye" style="margin-right: 4px"></i>Preview
                                        </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        @if($listTemplateEmail['status'] == \App\Http\Controllers\Admin\EmailTemplateController::DEFAULT_STATUS_ACTIVE )
                                            <span class="kt-badge kt-badge--inline kt-badge--success button_status">Active</span>
                                        @else
                                            <span class="kt-badge kt-badge--inline kt-badge--danger button_status">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="width:100px;vertical-align: middle; vertical-align:middle;text-align: center;">
                                        <a href="{{route('emailTemplate.edit',['id'=> $listTemplateEmail['id']])}}"
                                           style="padding:10px;"><i
                                                class="fa fa-edit"></i></a>
                                        <form id="delete-form-{{$listTemplateEmail['id']}}"
                                              action="{{ route('emailTemplate.destroy', $listTemplateEmail['id'])}}"
                                              method="post"
                                              style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0);" title="Xóa" style="padding:10px"
                                               id="kt_sweetalert_demo_9"
                                               onclick="deleteAction({{$listTemplateEmail['id']}})">
                                                <i class="fa fa-trash-alt" style="color: red"></i>
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
        <div class="modal fade" id="preview_modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" style="overflow-x: hidden;
        overflow-y: auto;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" id="preview_content"></div>
                    <br>
                </div>
            </div>
        </div>
    </div>
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
        function setLimit() {
            var limit = $('#set_limit').val();
            $('#id_limit').val(limit);
            $('#templateSearch').submit();
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

        $('.select2[multiple]').select2({
            width: '100%',
            closeOnSelect: false
        })
        function resetSearch() {
            $("#id_code").val("");
            $("#id_name").val("");
            $("#id_limit").val("");
            $("#id_page").val("");
            window.location.href = "/emailTemplate";
        }
        function turnOnModalLoading() {
            $('#modal-loading').modal('show');
        };

        function turnOffModalLoading() {
            $('#modal-loading').modal('hide');
        }
        var loading = document.getElementById("modal-loading");
        function showPreview(id) {
            loading.classList.remove("loading");
            turnOnModalLoading();
            $.ajax({
                url: '{{route('emailTemplate.show_contact',$listTemplateEmail['id'] ?? 0) }}',
                type: 'GET',
                data: {
                    id: id,
                },
                success: function (data) {
                    loading.classList.add("loading");
                    $(".modal-backdrop").hide();
                    turnOffModalLoading();
                    document.getElementById("preview_content").innerHTML = decodeEntities(data['data'][0]['content']);
                    $('#preview_modal').modal('show');
                    $(".modal-backdrop").attr('show');

                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }
        function decodeEntities(encodedString) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = encodedString;
            return textArea.value;
        }
    </script>
@stop
