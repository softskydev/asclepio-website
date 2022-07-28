// var page = 0;
var limit = 4;
var sort = 'terbaru';
var search_input = $("#search").val();
// $(document).ready(function () {
//     get_data(page, limit);

// });

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'User/get_user/0');
}

function sortBy(item) {
    sort = item;
    loadPagination(global_url + 'User/get_user/0');
}

function search(item) {
    search_input = item;
    loadPagination(global_url + 'User/get_user/0');
}


$(document).on("click", ".pagination li a", function(event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


loadPagination(global_url + 'User/get_user/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            sort: sort,
            search: search_input,
            limit: limit,
        },
        dataType: "json",
        success: function(response) {
            $('.pag-list').html(response.pagination);
            createTable(response);
        }
    });
}

function createTable(response) {
    var html = '';
    var link = global_url + 'User/delete';
    $.each(response.data, function(i, item) {
        html += "<tr>" +
            "<td>"+
            '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data '+item.nama_lengkap+'?\')" href="'+link+'/'+item.id+'">'
            +'<i class="fa fa-trash" style="color:white;"></i></a>'
            +"</td>" +
            "<td>" +
            "<p>" + item.nama_lengkap + "</p><small>" + item.email + "</small>" +
            "</td>" +
            "<td><span>" + item.universitas + "</span></td>" +
            "<td><span>" + item.instansi + "</span></td>" +
            "<td><span>" + item.no_wa + "</span></td>" +
            "<td><span>" + item.instagram + "</span></td>" +
            "<td><span>" + item.kota + "</span></td>" +
            "<td><span>" + item.asclepedia + " kelas</span></td>" +
            "<td><span>" + item.asclepio_go + " kelas</span></td>" +
            "<td class='total-class'><span style='cursor:pointer' onclick='getClass(" + item.id + ")'>" + item.total + "</span></td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
    $("#last_query").val(response.last_query);
}

function getClass(id) {
    $.ajax({
        type: "get",
        url: global_url + "User/getClass/" + id,
        // data: "data",
        dataType: "json",
        success: function(response) {
            $("#modal-kelas").modal('show');
            $("#total-ascped").text(response.ascped + ' Kelas');
            $("#total-ascgo").text(response.ascgo + ' Kelas');
            $("#total-all-class").text(response.total + ' Kelas');
            $("#total-nominal").text(numeral(response.total_out).format('0,0'));
            // alert(response.data[0]['judul_kelas']);
            html = "";
            if (response.code == 200) {
                for (var x = 0; x < response.data.length; x++) {
                    html += "<tr>" +
                        "<td>" + response.data[x]['judul_kelas'] + "</td>" +
                        "<td>" + response.data[x]['code_voucher'] + "</td>" +
                        "<td>Rp " + numeral(response.data[x]['total_harga']).format('0,0') + "</td>" +
                        "</tr>";
                }

            } else {
                html += '<tr><td colspan="3">Belum ada kelas diikuti</td></tr>';
            }

            $("#table-kelas").html(html);
        }
    });
}