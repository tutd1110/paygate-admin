function showAddBanking() {
    $('#viewAddBanking').modal('show');
    $('#create_banking').removeClass('hidden');
    $('#viewAddBanking').find('.form_text').val('');
    $('#check_id').val('');
    $('#check_idBanking').val('');
    tinymce.get('description_bank').setContent("");
}

var listBankNumber = [];

function addProduct() {
    var valueDescript = tinymce.get('description_bank').getContent();
    $.ajax({
        method: 'POST',
        url: '/checkBankingPartner',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            banking_code: $("#item-banking_id").val() ? $("#item-banking_id").val() : $("#check_idBanking").val(),
            owner: $("#item-owner").val(),
            branch: $("#item-branch").val(),
            bank_number: $("#item-bank_number").val(),
            bank_business: $("#item-bank_business").val(),
            code_res_bank: $("#item-code_res_bank").val(),
            check_id: $('#check_id').val(),
        },
        success: function (data) {
            if (data.status == 0 && !$.isEmptyObject(data.error)) {
                $.each(data.error, function (prefix, val) {
                    $('span.' + prefix + '_error').text(val[0]);
                });
            } else {
                var data = data.data;
                var table = document.getElementById("id_table_banking");
                if (listBankNumber.length === 0) {
                    listBankNumber.push(data.bank_number);
                } else if (listBankNumber.includes(data.bank_number) && data.check_id == null) {
                    $('span.bank_number_error').text("Bạn đã nhập số tài khoản này trước đó rồi ");
                    return;
                } else {
                    listBankNumber.push(data.bank_number);
                }
                var nameBanking = $("#item-banking_code").val();
                var partnerCode = $("#item-partner_code").val();
                var sort = $("#item-sort_bank").val();
                var type = $("#item-type").val();
                var IdBanking = $("#item-banking_id").val();
                /* Lấy ra dataID */
                var arrDataId = [];
                var tdElements = document.querySelectorAll(".getDataId");
                if (tdElements){
                    tdElements.forEach(function (tdElement) {
                        var dataIdValue = tdElement.getAttribute("data-id");
                        arrDataId.push(dataIdValue);
                    });
                }
                if (arrDataId.includes(data.check_id)) {
                    /* lấy danh sách các thẻ td trùng với check_id */
                    const listTd = document.querySelectorAll(`td[data-id="${data.check_id}"]`);
                    /* Gán giá trị mới cho từng thẻ td theo data-type */
                    listTd.forEach(td => {
                        const dataAttribute = td.getAttribute('data-type');
                        switch (dataAttribute) {
                            case 'banking_list_code':
                                td.textContent = nameBanking;
                                break;
                            case 'owner':
                                td.textContent = data.owner;
                                break;
                            case 'code_res_bank':
                                td.textContent = data.code_res_bank;
                                break;
                            case 'bank_number':
                                td.textContent = data.bank_number;
                                break;
                            case 'branch':
                                td.textContent = data.branch;
                                break;
                            case 'sort':
                                td.textContent = sort;
                                break;
                            case 'type':
                                td.textContent = type;
                                break;
                            case 'business':
                                td.textContent = data.bank_business;
                                break;
                            case 'description':
                                td.textContent = valueDescript;
                                break;
                            default:
                                break;
                        }
                    });
                    if (data.bank_business.includes('"')) {
                        data.bank_business = data.bank_business.replace(/"/g, "'");
                    }
                    $("#valueBanking").append(
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.banking_code + '" name="banking_code[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.owner + '" name="owner[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.code_res_bank + '" name="code_res_bank[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.bank_number + '" name="bank_number[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.branch + '" name="branch[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + sort + '" name="sort_bank[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + type + '" name="type[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.bank_business + '" name="bank_business[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + valueDescript + '" name="description_bank[]">',
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.check_id + '" name="check_id[]">'
                    );
                    var spanToRemove = document.querySelectorAll(".text-danger");
                    spanToRemove.forEach(function(span) {
                        span.remove();
                    });
                } else {
                    table.innerHTML +=
                        '<tr>' +
                        '<td style="text-align: center" class=" idBank bank_' + nameBanking + '">' + nameBanking + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + data.owner + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + data.code_res_bank + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + data.bank_number + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + partnerCode + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + data.branch + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + sort + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + type + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + data.bank_business + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '">' + valueDescript + '</td>' +
                        '<td style="text-align: center" class="bank_' + nameBanking + '" id="" onclick="deleteAction(\'' + nameBanking + '\')"><i class="fa fa-trash-alt"></i></td>';
                    if (data.bank_business.includes('"')) {
                        data.bank_business = data.bank_business.replace(/"/g, "'");
                    }
                    $("#valueBanking").append(
                        '<input hidden class="bank_' + nameBanking + '"  value="' + IdBanking + '" name="banking_code[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + data.owner + '" name="owner[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + data.code_res_bank + '" name="code_res_bank[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + data.bank_number + '" name="bank_number[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + data.branch + '" name="branch[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + sort + '" name="sort_bank[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + type + '" name="type[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + data.bank_business  + '" name="bank_business[]">' +
                        '<input hidden class="bank_' + nameBanking + '"  value="' + valueDescript + '" name="description_bank[]">' +
                        '<input hidden class="bank_' + data.check_id + '"  value="' + data.check_id + '" name="check_id[]">'
                    );

                }
                $('#viewAddBanking').modal('hide');
                $('#viewAddBanking').find('.form_text').val('');
                tinymce.get('description_bank').setContent("");
                $('.modal-backdrop').removeClass('show');
            }
        }
    });
}

function deleteAction(name) {
    $('.bank_' + name).remove();
}
function deleteBank(id) {
    var confirmed = confirm('Bạn có chắc chắn muốn xóa không?');
    if (confirmed) {
        $.ajax({
            method: 'GET',
            url: '/pgw_partner_resgistri_banking_delete',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {id: id},
            success: function (data) {
                if (data.status == 1 ){
                    alert("Đã xóa thành công");
                    $('.bank_' + id).remove();
                    var element = document.querySelectorAll('.idBank');
                    if (element.length < 1) {
                        var checkboxElement = document.querySelector('input[data-id="transfer"]');
                        checkboxElement.checked = false;
                        $('#registri_banking').hide()
                    }
                }
            },
        });
    }
}
function openFormBank(id) {
    var bankingListIdCode = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='banking_list_id']").textContent;
    $('#check_idBanking').val(bankingListIdCode);
    var bankingListCode = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='banking_list_code']").textContent;
    var owner = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='owner']").textContent;
    var bankNumber = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='bank_number']").textContent;
    var codeResBank = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='code_res_bank']").textContent;
    var code = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='code']").textContent;
    var branch = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='branch']").textContent;
    var sort = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='sort']").textContent;
    var type = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='type']").textContent;
    var business = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='business']").textContent;
    var description = document.querySelector(".bank_" + id + "[data-id='" + id + "'][data-type='description']").textContent;

    // Điền dữ liệu vào form
    document.getElementById("item-banking_code").value = bankingListCode;
    document.getElementById("item-owner").value = owner;
    document.getElementById("item-bank_number").value = bankNumber;
    document.getElementById("item-code_res_bank").value = codeResBank;
    document.getElementById("item-partner_code").value = code;
    document.getElementById("item-branch").value = branch;
    document.getElementById("item-sort_bank").value = sort;
    document.getElementById("item-type").value = type;
    document.getElementById("item-bank_business").value = business;
    tinymce.get('description_bank').setContent(description);

    $('#check_id').val(id);
    $('#viewAddBanking').modal('show');
    $('#create_banking').removeClass('hidden');
}
const inputBlurs = $('.js-input-blur');
[...inputBlurs].forEach(inputBlur => {
    $(inputBlur).focus(e => {
        let parentInputChecked = $(inputBlur).parent();
        let validatedElement = $(parentInputChecked).children('.validated');
        let validateJS = $(parentInputChecked).children('.validateJS');
        if ($(validatedElement).attr('class') && $(validatedElement).attr('class') == 'validated') {
            validatedElement[0].textContent = '';
        }
        if ($(validateJS)) {
            validateJS[0].textContent = '';
        }
    })
})


