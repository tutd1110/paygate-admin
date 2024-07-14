"use strict";

var MyDate = function () {


    var dateDefaultFormat = 'DD/MM/YYYY';

    return {
        getDateDefaultFormat() {
            return dateDefaultFormat;
        },

        getDayOfWeek(day) {
            switch (day) {
                case 0:
                    return "Chủ nhật";
                case 1:
                    return "Thứ 2";
                case 2:
                    return "Thứ 3";
                case 3:
                    return "Thứ 4";
                case 4:
                    return "Thứ 5";
                case 5:
                    return "Thứ 6";
                case 6:
                    return "Thứ 7";
            }
        }

    };
}();

// webpack support
if (typeof module !== 'undefined') {
    module.exports = MyDate;
}
