"use strict";

var Format = function () {

    return {
        removeSecondString(time) {
            if (typeof time == 'undefined' || !time) {
                return '';
            }
            if (time.length == 8) {
                return time.slice(0, 5);
            }
            return time;
        }
    };
}();

// webpack support
if (typeof module !== 'undefined') {
    module.exports = Format;
}
