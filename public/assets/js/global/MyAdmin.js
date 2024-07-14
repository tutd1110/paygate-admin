"use strict";

var MyAdmin = function () {


    var initDateRangePicker = function () {
        $('.my-daterange').daterangepicker({
            opens: 'left',
            "alwaysShowCalendars": true,
            customRange: 'Chọn ngày',
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Ngày trước': [moment().subtract(6, 'days'), moment()],
                '30 Ngày trước': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Xác nhận",
                "cancelLabel": "Huỷ",
                "fromLabel": "Từ",
                "toLabel": "Tới",
                "customRangeLabel": "Chọn Ngày",
                "weekLabel": "Tuần",
                "daysOfWeek": [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12",
                ],
                "firstDay": 1
            },
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    }

    return {
        init: function () {
            initDateRangePicker();
        }
    };
}();

// webpack support
if (typeof module !== 'undefined') {
    module.exports = MyAdmin;
}

KTUtil.ready(function () {
    MyAdmin.init();
});
