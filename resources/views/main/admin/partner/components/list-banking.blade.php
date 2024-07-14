<div class="registri_banking hidden " id="registri_banking">
    <div class="row">
        <div class="table-responsive">
            <table id="id_table_banking" class="table table-bordered"
                   style="font-family: Arial;vertical-align: middle;">
                <thead style="text-align: center; vertical-align: middle">
                <tr>
                    <th style="vertical-align: middle;">Mã ngân hàng</th>
                    <th style="vertical-align: middle;">Chủ tài khoản</th>
                    <th style="vertical-align: middle;">Đầu mã kết nối</th>
                    <th style="vertical-align: middle;">Số tài khoản</th>
                    <th style="vertical-align: middle;">Mã đối tác
                    </th>
                    <th style="vertical-align: middle;">Chi nhánh</th>
                    <th style="vertical-align: middle;">Vị trí sắp xếp</th>
                    <th style="vertical-align: middle;">Loại thanh toán</th>
                    <th style="vertical-align: middle;">Thông tin kết nối đến ngân hàng</th>
                    <th style="vertical-align: middle;">Mô tả</th>
                    <th style="vertical-align: middle;">Action</th>
                </tr>
                </thead>
                @if(!empty($getRegisBanking))
                    @foreach($getRegisBanking as $key => $items)
                        <input type="hidden" value="{{$items['id']}}" readonly="" name="id_transfer[]">
                        <tbody id="bankingList_{{$items['id']}}">
                        <td style="display:none" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="banking_list_id">{{$items['banking_list_id']}}</td>
                        <td style="display:none" class="idBank bank_{{$items['id']}}" id="idBank" >{{$items['id']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}} getDataId" data-id="{{$items['id']}}"
                            data-type="banking_list_code">{{$items['banking_list']['code']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="owner">{{$items['owner']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="code_res_bank">{{$items['code']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="bank_number">{{$items['bank_number']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="code">{{$getPartner['code']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="branch">{{$items['branch']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="sort">{{$items['sort']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="type">{{$items['type']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="business">{{$items['business']}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}" data-id="{{$items['id']}}"
                            data-type="description">{{strip_tags($items['description'])}}</td>
                        <td style="text-align: center" class="bank_{{$items['id']}}"><i class="fa fa-trash-alt"
                                                                            onclick="deleteBank('{{$items['id']}}')"></i> <i
                                class="fa fa-edit" onclick="openFormBank({{$items['id']}})"></i></td>
                        </tbody>

                    @endforeach
                @endif
            </table>
        </div>
        <div class="col text-center" id="add_banking_id" onclick="showAddBanking()">
            <label for=""><h4><i class="fa fa-plus-circle"></i></h4></label>
        </div>

    </div>
    <div class="modal fade" id="viewAddBanking" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="false">
        <div class="modal-dialog modal-xl" style="width: 100%;padding: 8% 3%;margin-top:-7%;">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0.5rem 1.25rem !important;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="hidden" id="create_banking">
                        <h1 style="text-align: center;">Form đăng ký chuyển khoản</h1>
                        <div id="box_list_banking_wrapper" aria-hidden="true">
                            <div class="box-banking row">
                                <div class="box_list_banking col-md-8" id="box_list_banking" style="margin-left: 2vw;">
                                    <h5>Chọn ngân hàng</h5>
                                    <div class=" row">
                                        @if(!empty($listBanks))
                                            @foreach($listBanks as $listBanks)
                                                @if($listBanks['status'] == "active")
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <a href="" class="bank-item">
                                                                <img src="{{asset($listBanks['thumb_path'])}}"
                                                                     class="img-thumbnail list_img_banking"
                                                                     alt="..."
                                                                     style="display: block;margin: 0 auto;">
                                                                <input type="hidden" class="banks_code"
                                                                       value="{{$listBanks['code']}}">
                                                                <input type="hidden" class="banks_id"
                                                                       value="{{$listBanks['id']}}">

                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" id="check_id"
                                       readonly>
                                <input type="hidden" id="check_idBanking"
                                       readonly>
                                <div class="box_form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Mã ngân hàng đối tác đăng ký chuyển
                                                            khoản </label>
                                                        <input type="text" id="item-banking_code"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               readonly>
                                                        <input type="hidden" id="item-banking_id"
                                                               value=""
                                                               readonly>

                                                        <span class="text-danger validateJS banking_code_error"></span>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Đầu mã kết nối</label>
                                                        <input type="text" id="item-code_res_bank"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               placeholder="Nhập mã code ">
                                                        <span class="text-danger validateJS code_res_bank_error"></span>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Mã đối tác</label>
                                                        <input type="text" id="item-partner_code"
                                                               class="form-control col-md-10 item-partner_code "
                                                               value=""
                                                               readonly>
                                                        @error('')
                                                        <div class="validated">
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Vị trí sắp xếp</label>
                                                        <input type="number" id="item-sort_bank"
                                                               class="form-control col-md-10 form_text"
                                                               value=""
                                                               placeholder="Nhập thứ tự">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Thông tin kết nối đến ngân hàng</label>
                                                        <input type="text" id="item-bank_business"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               placeholder="Nhập thông tin kết nối đến ngân hàng">
                                                        <span class="text-danger validateJS bank_business_error"></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form_right">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Tên của chủ tài khoản</label>
                                                        <input type="text" id="item-owner"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               placeholder="Nhập tên chủ tài khoản">
                                                        <span class="text-danger validateJS owner_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Số tài khoản</label>
                                                        <input type="number" id="item-bank_number"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               placeholder="Nhập số tài khoản">
                                                        <span class="text-danger validateJS bank_number_error"></span>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Chi nhánh của tài khoản</label>
                                                        <input type="text" id="item-branch"
                                                               class="form-control col-md-10 form_text js-input-blur"
                                                               value=""
                                                               placeholder="Nhập chi nhánh tài khoản">
                                                        <span class="text-danger validateJS branch_error"></span>

                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item-name">Loại thanh toán</label> <br>
                                                        <select id="item-type"
                                                                class="form-control col-md-10 ">
                                                            <option
                                                                value="billing" <?= isset($getRegisBanking['type']) && $getRegisBanking['type'] == 'billing' ? 'selected' : '' ?>>
                                                                Hóa đơn
                                                            </option>
                                                            <option
                                                                value="topup" <?= isset($getRegisBanking['type']) && $getRegisBanking['type'] == 'topup' ? 'selected' : '' ?>>
                                                                Nạp tiền
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <div class="kt-tinymce tinymce-h-200">
                            <textarea class="tinymce-mini" id="description_bank"
                                      class="tox-target form_text"
                                      value=""
                                      placeholder="Nhập mô tả"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="extra_form">
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer" style="margin-top: -4%;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="id_button_add_product" onclick="addProduct()" style="margin-right: 2rem"
                            type="button"
                            class="btn btn-secondary btn-primary"
                            data-bs-dismiss="modal">Thêm mới
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="valueBanking">
    </div>
</div>
