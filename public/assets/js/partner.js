

const base_info = document.getElementById('base_info');

const boxBankinhList = document.querySelectorAll('.box-banking');
const openListMethod = () => {
    $('#list_method').show()
}
const openFormBanking = () => {
    // $('#registri_banking').show()
}
const closeFormInfo = () => {
    $('#form_info').hide()
}
base_info.addEventListener("click", (e) => {
    e.preventDefault();
    $('#list_method').hide();
    $('#form_info').show();
})

boxBankinhList.forEach(banking => {
    banking.querySelectorAll('.bank-item').forEach(bank => {
        bank.addEventListener('click', (e) => {
            e.preventDefault();
            const bankCode = bank.querySelector('.banks_code').getAttribute('value');
            banking.querySelector("#item-banking_code").value = bankCode;
            const bankId = bank.querySelector('.banks_id').getAttribute('value');
            banking.querySelector("#item-banking_id").value = bankId;
        })
    })
})
$.each($(".list_bank_input"), function () {
    $(this).val();
    var getBank = $(this).val();
    const isChecked = $(this).prop('checked');
    if (isChecked && getBank && getBank != "transfer") {
        let pay_id = $(this).attr('data-id');
        $('textarea#text-area-' + pay_id).show();
    }
    if (getBank == "transfer" && isChecked) {
        $('#registri_banking').show();
    }

});
$(".list_bank_input").click(function () {
    let $this = $(this);
    const isChecked = $(this).prop('checked');
    var getBank = $(this).val();

    if (!isChecked) {
        let pay_id = $this.attr('data-id');
        document.querySelector('textarea#text-area-' + pay_id).value = "";
    }
    if (isChecked && getBank != "transfer") {
        let pay_id = $this.attr('data-id');
        $('textarea#text-area-' + pay_id).show();

    }
    if (!isChecked && getBank != "transfer") {
        let pay_id = $this.attr('data-id');
        $('textarea#text-area-' + pay_id).hide();
    }
    if (getBank == "transfer" && isChecked) {
        document.getElementById("text-area-transfer").value = "Thanh toán chuyển khoản";
        $('#registri_banking').show();
        $('#create_banking').show();
        var getValueCode = document.getElementById("item-code").value;
        document.getElementById("item-partner_code").value = getValueCode;
    }
    if (getBank == "transfer" && !isChecked) {
        $('#registri_banking').hide();
        document.getElementById("text-area-transfer").value = "";

    }
});
function checkParner(){
    tinyMCE.triggerSave();
    var valueCode = $("#item-code").val();
    var valueName = $("#item-name").val();
    var idPartner = $("#idPartner").val();
    var valueDescription = $("textarea#myTextarea").val();
    $.ajax({
        method: 'GET',
        url: '/pgw_partner/checkvaluePart',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {valueCode:valueCode, valueName:valueName, valueDescription:valueDescription,idPartner:idPartner},
        success: function(data) {
            if(data.status == 0 && !$.isEmptyObject(data.error)){
                $.each(data.error, function (prefix,val){
                    $('span.'+prefix+'_error').text(val[0]);
                });
            }else {
                $('#list_method').show();
                $('#form_info').hide();
                $('.list_method_payment').addClass('active');
            }
        },
    });
}
