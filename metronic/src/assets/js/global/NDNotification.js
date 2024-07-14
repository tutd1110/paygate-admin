"use strict";
var NDNotification = function () {
    return {
        success: function ($message) {
            return toastr.success($message, {
                showDuration: 0,
            });
        },
        error: function ($message) {
            return toastr.error($message, {
                showDuration: 0
            });
        },
        info: function (message) {
            return toastr.info(message, {
                showDuration: 0
            });
        }
    };
}();

module.exports = NDNotification;
