var table;
function search(elm, path, columns) {
    table = elm.DataTable({
        dom: `<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        responsive: true,
        lengthMenu: [10, 25, 50, 100],
        pageLength: 25,
        pagingType: 'full_numbers',
        language: {
            'lengthMenu': '<span>Hiển thị</span> _MENU_',
            'info': 'Hiển thị _START_ - _END_ trên tổng số _TOTAL_',
            'infoEmpty': 'Hiển thị _END_ trên tổng số _TOTAL_',
            'processing': 'Đang tải.....',
            'emptyTable': 'Không có bản ghi nào được tìm thấy',
            "paginate": {
                "first": '<i class="fa fa-angle-double-left"></i>',
                "last": '<i class="fa fa-angle-double-right"></i>',
                "next": '<i class="fa fa-angle-right"></i>',
                "previous": '<i class="fa fa-angle-left"></i>'
            }
        },
        // scrollY: 'calc(100vh - 550px)',
        // scrollCollapse: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: path + '/search',
            data: function( query ) {
                var filter = $('#formSearch').serialize();
                filter += '&start=' + query.start;
                filter += '&length=' + query.length;

                return filter;
            },
            dataSrc: 'items',
            error: handleAjaxError
        },
        columns: columns,
        columnDefs: [
            {
                targets: -3,
                render: function(data) {
                    if (data === 1 || data === 'active') {
                        return '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">Hiển thị</span>';
                    } else if (data === 0 || !data) {
                        return '<span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill">Ẩn</span>';
                    } else {
                        return '<span">'+data+'</span>';
                    }
                },
            },
            {
                targets: -2,
                render: function(data) {
                    return getFormattedDate(new Date(data));
                },
            },
            {
                targets: -1,
                render: function(data) {
                    return '' +
                        '<a href="'+path+"/"+data+'" class="btn btn-sm btn-font-primary btn-icon" title="Chỉnh sửa">' +
                        '<i class="fa fa-edit"></i>' +
                        '</a>' +
                        '<a href="javascript:;" onclick="removeItem(\''+path+"/"+data+'\')" class="btn btn-sm btn-font-primary btn-icon" title="Xóa bỏ">' +
                        '<i class="fa fa-trash-alt"></i>' +
                        '</a>';
                },
            }
        ]
    });
}

function handleAjaxError(e) {
    toastr.error(e.responseJSON.message);
}

function getFormattedDate(date) {
  var year = date.getFullYear();

  var month = (1 + date.getMonth()).toString();
  month = month.length > 1 ? month : '0' + month;

  var day = date.getDate().toString();
  day = day.length > 1 ? day : '0' + day;

  return day + '/' + month + '/' + year;
}

function sortChange(id, path, _this) {
    if (!id) {
        return false;
    }
    $('.dataTables_processing').show();
    var sort = $(_this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'PUT',
        url: path + '/' + id + '/sort',
        data: {sort: sort},
        success: function (res) {

        },
        error: function (xhr, status, error) {
            var res = eval("(" + xhr.responseText + ")");
            if (res && res.message) {
                toastr.error(res.message);
            }
        },
        complete: function (xhr) {
            $('.dataTables_processing').hide();
        }
    });
}

function removeItem(uri) {
    swal.fire({
        title: 'Xóa bỏ',
        text: 'Bạn có chắc muốn xóa bỏ bản ghi này?',
        type: 'question',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-danger',
        confirmButtonText: 'Xác nhận!',
        cancelButtonText: 'Hủy',
        cancelButtonClass: 'btn btn-secondary'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: uri,
                success: function (res) {
                    table.ajax.reload();
                    toastr.success("Xóa bỏ thành công!");
                },
                error: function (xhr, status, error) {
                    var res = eval("(" + xhr.responseText + ")");
                    if (res && res.message) {
                        toastr.error(res.message);
                    }
                }
            });
        }
    });
}

function tableSearch() {
    table.ajax.reload();
}

function tableResetSearch() {
    $('#formSearch').trigger('reset');
    table.ajax.reload();
}
