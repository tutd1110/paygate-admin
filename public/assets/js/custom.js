var KTWizard3 = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var wizard;

    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        if ($('#kt_wizard_v3').length > 0) {
            wizard = new KTWizard('kt_wizard_v3', {
                startStep: 1, // initial active step number
                clickableSteps: true  // allow step clicking
            });

            // Change event
            wizard.on('change', function(wizard) {
                KTUtil.scrollTop();
            });
        }
    };

    return {
        // public functions
        init: function() {
            wizardEl = KTUtil.get('kt_wizard_v3');
            formEl = $('#kt_form');

            initWizard();
        }
    };
}();

jQuery(document).ready(function() {
    KTWizard3.init();
});

function numberFormat(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function utf8ToUnicode(str) {
    str = str.toLowerCase();
    str = str
		.normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
		.replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

    // Thay ký tự đĐ
	str = str.replace(/[đĐ]/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // xóa phần dư - ở đầu & cuối
	str = str.replace(/^-+|-+$/g, '');

    // return
	return str;
}
$('.select2[multiple]').select2({
    width: '100%',
    closeOnSelect: false
});
