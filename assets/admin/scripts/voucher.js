// var page = 0;
var limit = 4;
var sort = 'terbaru';
var search_input = $("#search").val();
// $(document).ready(function () {
//     get_data(page, limit);

// });

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Voucher/get_voucher/0');
}

function sortBy(item) {
    sort = item;
    loadPagination(global_url + 'Voucher/get_voucher/0');
}

function search(item) {
    search_input = item;
    loadPagination(global_url + 'Voucher/get_voucher/0');
}

$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


loadPagination(global_url + 'Voucher/get_voucher/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            sort: sort,
            search: search_input,
            limit: limit
        },
        dataType: "json",
        success: function (response) {
            $('.pag-list').html(response.pagination);
            createTable(response);
        }
    });
}


function createTable(response) {
    var html = '';
    $.each(response.data, function (i, item) {
        html += "<tr>" +
            "<td><span>" + item.code_voucher + "</span></td>" +
            "<td><span>" + item.jenis_voucher + "</span></td>" +
            "<td><span>" + item.limit_voucher + " kali</span></td>" +
            "<td><span>" + item.pemakaian_voucher + " kali" + item.pengguna_voucher + "</span></td>" +
            "<td><span>" + item.expired_date + "</span></td>" +
            "<td>" +
            "<div class='action'><a href='#' onclick='confirmDelete(" + item.id + ")'><img src='" + global_url + "assets/admin/images/ic-action-delete.svg' /></a></div>" +
            "</td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
}

var jenis_kelas = 'all';
$(document).ready(function () {

    get_kelas(jenis_kelas);
    $("#form-discount").hide();

});

$('#jenis_voucher').on('change', function () {
    if (this.value == 'free') {
        $("#form-discount").hide();
    } else {
        $("#form-discount").show();
    }
});

$('#limit_status').change(function () {
    if ($(this).is(":checked")) {
        $("#limit_voucher").hide();
        $("#limit_voucher").val('0');
    } else {
        $("#limit_voucher").show();
    }
});


function get_kelas(jenis_kelas) {
    $.ajax({
        type: "get",
        url: global_url + "Voucher/get_kelas/" + jenis_kelas,
        dataType: "json",
        success: function (response) {
            if (response.status == 200) {
                var len = response.data.length;
                var select = $("select[id='kelas_spesifik']");
                $(select).empty();
                $(select).append("<option value='' disabled> Semua Kelas </option>");
                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var nama_kelas = response.data[i]['judul_kelas'];

                    $(select).append("<option value='" + id + "'>" + nama_kelas + "</option>");

                }
                $(select).selectpicker('refresh');
            }
        }
    });
}
function cekData(code_voucher) {
$.ajax({
    type: "post",
    url: global_url + "Voucher/check_data",
    data: {
        code_voucher: code_voucher,
    },
    dataType: "json",
    success: function (response) {
        Swal.fire(
            response.msg,
            '',
            response.msg_type
        )
    }
});
}
function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin menghapus data ini?',
        text: "data yang sudah dihapus tidak dapat dipulihkan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: global_url + "Voucher/delete/" + id,
                type: "POST",
                dataType: "json",
                success: function (response) {
                    Swal.fire(
                        response.msg,
                        '',
                        response.msg_type
                    )
                    window.location.reload();
                }
            });
        }
    })
}