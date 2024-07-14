"use strict";
var MyProfile = function () {
    var initData = null;
    var update = function () {
        var name = $('#update-profile-form input[name="name"]').val();
        var phone = $('#update-profile-form input[name="phone"]').val();
        var profile_phone_path = $('#update-profile-form input[name="profile_phone_path"]').val();
        NDNotification.info('Updating');
        $.ajax({
            type: 'post',
            url: NDBase.getRouter('profile.update'),
            data: {
                'name': name,
                'phone': phone,
            },
            success: function (result) {
                NDNotification.success(result.message);
            },
            error: function (result) {
                NDNotification.error(result.responseJSON.error);
            }
        });
    }

    var updateProfileImage = function () {
        NDNotification.info('Updating!');
        var formData = new FormData();
        var inputImage = $('#profile_avatar_input');
        /**
         *
         */

        formData.append('image', inputImage[0].files[0]);

        $.ajax({
            url: NDBase.getRouter('profile.uploadProfileImage'),
            type: 'post',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: (result) => {
                NDNotification.success('Update done!');
                $('#profile_avatar_target').css('background-image', `url(${result.data.user.profile_photo_url})`);
            },
            error: function (result) {
                NDNotification.error('Error! Refresh and Retry!');
            }
        });
    }

    return {
        init: function (param) {
            initData = param;
            $('#update-profile-form .save-button').click(() => {
                update();
            });

            console.log('1');
            $('#profile_avatar_input').change(() => {
                updateProfileImage();
            });
        }
    };
}();
module.exports = MyProfile;
