// var checkOwner = $('#checkOwner').val();
// var nameOwner = $('#name_owner').val();
function changeOwner() {
    const checkOwner = $('#valueNamePartner').val();
    if (checkOwner) {
        $.ajax({
            method: 'POST',
            url: '/checkOwner',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {data: checkOwner},
            success: function (data) {
                console.log(data);
                if (data.status == 1) {
                    swal.fire({
                        text: "Owner đã tồn tại với người dùng '" + data.nameWithOwner + "' .Bạn có muốn đổi Owner ?",
                        showCancelButton: true,
                        confirmButtonText: 'Đồng ý',
                        cancelButtonText: 'Hủy',
                        reverseButtons: true
                    }).then(function (result) {
                        if (result.value == true) {
                            console.log(data.idUser);
                            $.ajax({
                                method: 'POST',
                                url: '/changOwner',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {idUser: data.idUser},
                                success: function (data) {
                                    if (data.status == 1) {
                                        swal.fire({
                                            text: "Xóa Owner thành công !",
                                            confirmButtonText: 'Đồng ý',
                                        })
                                    } else {
                                        swal.fire({
                                            text: "Xóa Owner thất bại !",
                                            confirmButtonText: 'Đồng ý',
                                        })
                                    }
                                },
                            });
                        }
                    });
                }else {
                    swal.fire({
                        text: "Đối tác '" + checkOwner + "' .Chưa có Owner nào !",
                        confirmButtonText: 'Đồng ý',
                    })
                }
            }
        })
    }
}
const filterInput = document.getElementById('filterInput');
const filterLandingDivs = document.querySelectorAll('.filter_landing');
filterInput.addEventListener('input', filterDivs);

function filterDivs() {
    const filterText = filterInput.value.toLowerCase();

    // Lặp qua các phần tử div có class "filter_landing"
    filterLandingDivs.forEach(div => {
        const label = div.querySelector('label');
        const labelText = label.textContent.toLowerCase();
        if (labelText.includes(filterText)) {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    });
}



