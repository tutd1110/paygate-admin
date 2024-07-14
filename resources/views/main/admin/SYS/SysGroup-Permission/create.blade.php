@extends('main.layout.master')
@section('title', 'Phân quyền')

@section('style')
    <link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Phân quyền</a>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <div class="btn-group">
                            <button type="button" class="btn btn-save btn-brand" onclick="SubmitForm()">
                                <i class="la la-check mr-1"></i>
                                <span class="kt-hidden-mobile"> Lưu</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Content Head -->
        <!-- begin:: Content -->

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-grid kt-wizard-v3--white" id="kt_wizard_v3" data-ktwizard-state="step-first">
                        <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3 kt-wizard-v3__wrapper">
                            <form class="px-5 py-3 kt-form kt-form--label-right" id="formProgram" method="post"
                                  action="{{ route('sys_permission.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                     data-ktwizard-state="current">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>Thông tin nhóm :</h2>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="item-name" style="font-size: 1.5rem;"> Đối tác:</label>
                                                    <select id="partner" class="form-control select2 kt-select2"
                                                            name="partner" onchange="getvaluePartner();" >
                                                        <option value="" selected>Chọn đối tác</option>
                                                        @foreach ($listPartner as $key => $items )
                                                            <option
                                                                value="{{ $items['code']}}"> {{$items['code']}} </option>
                                                        @endforeach
                                                    </select>
                                                    @error('group_name')
                                                    <div class="validated">
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="item-name" style="font-size: 1.5rem;"> Tên nhóm:</label>
                                                    <select id="group" class="form-control select2 kt-select2"
                                                            name="group" onchange="getvalueGroup();">
                                                        <option value="" selected>Chọn nhóm</option>
                                                    </select>
                                                    @error('group_name')
                                                    <div class="validated">
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <h2>Bảng phân quyền :</h2>
                                            </div>
                                            <div class="kt-subheader__toolbar col-md-6 hide" id="updatePermiss" >
                                                <div class="kt-subheader__wrapper" style="float: right">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-save btn-brand" >
                                                            <i class="la la-check mr-1"></i>
                                                            <span class="kt-hidden-mobile" onclick="updatePermiss()"> Cập nhật quyền</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="list_modules row" id="list_modules" >

                                            </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </div>
@stop
@section('script')
    <script src="{{asset('assets/js/check-list.js?v=1.0.1')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/program.js?v=1.0.3')}}" type="text/javascript"></script>
    <script type="text/javascript">
        function SubmitForm() {
            $('#formProgram').submit();
        }

        $('#thumb_path').change(e => {
            if ($('#thumb_path').prop('files')[0].name) {
                $('#item-thumb_path_input').val($('#thumb_path').prop('files')[0].name);
            }
        })
        const inputBlurs = $('.js-input-blur');
        [...inputBlurs].forEach(inputBlur => {
            $(inputBlur).focus(e => {
                let parentInputChecked = $(inputBlur).parent();
                let validatedElement = $(parentInputChecked).children('.validated');
                if ($(validatedElement).attr('class') && $(validatedElement).attr('class') == 'validated') {
                    $(validatedElement).remove();
                }
            })
        })
        $('.select2').select2({
            width: '100%',
            closeOnSelect: false
        })
        function updatePermiss(){
            $.ajax({
                method: 'GET',
                url: '{{route('scanModulePerission')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    getvalueGroup();
                    swal.fire({
                        text: "Câp nhật thành công !",
                        confirmButtonText: 'Đồng ý',
                        reverseButtons: true
                    })
                },
            });
        }
        function getvaluePartner() {
            $('#group').html('');
            $('#list_modules').html('');
            var idPartner = $('#partner').find(":selected").val();
            $.ajax({
                method: 'POST',
                url: '/get_name_group',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {partner_code:idPartner},
                success: function (data) {
                    var listGroup = data.listData;
                    $('#group').prepend(`<option value="" selected>Chọn nhóm</option>`);
                    listGroup.forEach(e => {
                        $('#group').append(`<option value=${e.id}> ${e.name} </option>`);
                        })
                },
            });
        }
        function getvalueGroup() {
            $('#list_modules').html('');
            var idGroup = $('#group').find(":selected").val();
            if (idGroup){
                $.ajax({
                    method: 'GET',
                    url: '{{route('sys_permission.create')}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {id: idGroup},
                    success: function (data) {
                        var getDatalistGroupPermiss = data.listGroupPermiss;
                        var getDatalistModules = data.listModules;
                        console.log(getDatalistModules);

                        getDatalistModules.forEach(e => {
                            $('#list_modules').append(`
                            <div class="form-check col-md-12" >
                               <table class="table table-bordered">
                               <div class="row">
                                    <td class="col-md-3" style="padding-left: 20px;" >
                                        <input class="form-check-input list_modules_input"
                                               id=list_modules_${e.id}
                                               type="checkbox"
                                               value=${e.id}
                                               name="list_modules[${e.module_alias}]"
                                               >
                                            <label class="form-check-label item-name " for="flexCheckDefault"
                                                   style="color:blue;">
                                                ${e.module_alias}
                                            </label>
                                    </td>
                                    <td class="col-md-9">
                                        <div class="row" id="list_permission_${e.id}">

                                        </div>
                                    </td>

                                </div>
                               </table>
                            </div>
                    `);

                            var listPermission = e.sys_permissions;
                            listPermission.forEach(items => {
                                $('#list_permission_' + e.id).append(`
                                <div class="col-md-4" style="padding-left: 50px;">
                                                <input class="form-check-input" type="checkbox"
                                               value=${items.module_id}
                                               data-parent=${e.id}
                                               name="list_permission[${items.id}]"
                                               id=modules_${items.id}
                                               ${checkedExistId(getDatalistGroupPermiss, items.id) ? 'checked' : ''}
                                        >
                                            <label class="form-check-label " for="flexCheckDefault"
                                                   style="color:#646c9a;">
                                                ${items.name_alias}
                                            </label>
                                        </div>
                                `);
                            });
                            $("#list_modules_" + e.id).click(function () {
                                var text_val = $('#list_permission_' + e.id + " :input");
                                if($(this).is(':checked')) {
                                    [...text_val].forEach(child => {
                                        if(!$(child).is(':checked')){
                                            $(child).prop('checked',true)
                                        }
                                    })
                                }else{
                                    [...text_val].forEach(child => {
                                        if($(child).is(':checked')){
                                            $(child).prop('checked',false)
                                        }
                                    })
                                }

                            });
                        })

                    },
                });
            }

        }
        const checkedExistId = (list, id) =>{
            const foundId = list.find(item => item.permission_id == id);
            if(foundId){
                return true;
            }
            return false;
        }

    </script>
@stop
