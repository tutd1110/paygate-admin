"use strict";

var Menu = (function () {
    var currentId = 0;
    var editId = 0;
    var menuId = 0;
    var deleteId = 0;
    var editId = 0;

    var createFormElm = {
        title: $('#create-form #title'),
        link: $('#create-form #link'),
    };
    var menuListElm = $('#menu_list');
    var menuListUlElm = $('#menu_list>ol');

    var createdMenuLang = {};

    var createSuccess = function () {
        createFormElm.title.val('');
        createFormElm.link.val('');
        addMenuToList(createdMenuLang.id, createdMenuLang.title);
    };

    var addMenuToList = function (id, title) {
        var li = $('<li>');
        li.addClass('dd-item');
        li.addClass('dd3-item');
        li.attr('data-id', id);
        var div = $('<div>');
        div.addClass('dd-handle');
        div.addClass('dd3-handle');
        div.append('<i class="fa fa-arrows"></i>');

        var divContent = $('<div>');
        divContent.addClass('dd3-content');
        divContent.text(title);


        var divTools = $('<div>');
        divTools.addClass('pull-right');

        var editButton = $('<button>');
        editButton.attr('data-id', id);
        editButton.addClass('btn');
        editButton.addClass('btn-sm');
        editButton.addClass('btn-outline-success');
        editButton.addClass('edit-menu');
        editButton.append('Sửa');

        var deleteButton = $('<button>');
        deleteButton.attr('data-id', id);
        deleteButton.addClass('btn');
        deleteButton.addClass('btn-sm');
        deleteButton.addClass('btn-outline-danger');
        deleteButton.addClass('btn-delete');
        deleteButton.addClass('delete-menu');
        deleteButton.append('Xóa');

        divTools.append(editButton);
        divTools.append(deleteButton);


        divContent.append(divTools);

        li.append(div);
        li.append(divContent);
        menuListUlElm.append(li);

        addEvent();
    };

    var showDeleteModal = function (elm) {
        deleteId = $(elm).data('id');
        $('#modal-deleteMenu').modal('show');

    };

    var deleteMenu = function () {
        $.ajax({
            url: '/admin/ajax/menu-details/' + deleteId,
            type: 'post',
            dataType: 'json',
            data: {
                _method: 'DELETE'
            },
            success: function (result) {
                deleteSuccess(deleteId);
            },
            error: function (result) {

            }
        });
    };

    var showEditModal = function (elm) {
        editId = $(elm).data('id');
        $.ajax({
            url: '/admin/ajax/menu-details/' + editId,
            type: 'get',
            dataType: 'json',
            data: {},
            success: function (result) {
                $('#edit-form #title').val(result.data.menuLang.title);
                $('#edit-form #link').val(result.data.menuLang.link);
                $('#modal-editMenu').modal('show');
            },
            error: function (result) {

            }
        });

    };

    var saveEditedMenu = function () {
        $.ajax({
            url: '/admin/ajax/menu-details/' + editId,
            type: 'post',
            dataType: 'json',
            data: {
                _method: "PUT",
                title: $('#edit-form #title').val(),
                link: $('#edit-form #link').val(),
            },
            success: function (result) {
                if (result.code == 200) {
                    window.location.reload();
                    $('#modal-editMenu').modal('hide');
                } else {
                    alert(result.message)
                }

            },
            error: function (result) {

            }
        });
    };


    var deleteSuccess = function (id) {
        $('.dd-item[data-id="' + id + '"]').remove();
        $('#modal-deleteMenu').modal('hide');
        NDNotification.success('Xoá thành công!')
    };

    var addEvent = function () {
        console.log('add-event');
        $('.delete-menu').click(function (e) {
            showDeleteModal(this);
        });

        $('.edit-menu').click(function (e) {
            showEditModal(this);
        });
    }

    return {
        init: function (param) {

            // activate Nestable for list 1
            $('#menu_list').nestable({
                maxDepth: 3
            }).on('change', function (e) {
                console.log($('#menu_list').nestable('serialize'));
            });

            menuId = param.menuId;


            $('.save-edit-menu').click(function () {
                saveEditedMenu();
            });
            $('.confirm-delete-menu').click(function () {
                deleteMenu();
            });

            addEvent();

        },

        create: function () {
            $.ajax({
                url: '/admin/ajax/menu-details',
                type: 'post',
                dataType: 'json',
                data: {
                    title: createFormElm.title.val(),
                    link: createFormElm.link.val(),
                    menu_id: menuId,
                },
                success: function (result) {
                    if (result.code == 200) {
                        createdMenuLang = result.data.menu;
                        createSuccess();

                    } else {
                        NDNotification.error(result.message);
                    }

                },
                error: function (result) {

                }
            });
        },

        saveOrder: function () {
            var data = $('#menu_list').nestable('serialize');
            $.ajax({
                url: '/admin/menus/save-order',
                type: 'post',
                dataType: 'json',
                data: {
                    _method: 'PUT',
                    dataOrder: data,
                },
                success: function (result) {
                    if (result.code == 200) {
                        NDNotification.success('Lưu thành công');
                    } else {
                        NDNotification.error('Lưu thất bại');
                    }
                },
                error: function (result) {

                }
            });
        }
    }
})();
module.exports = Menu;
