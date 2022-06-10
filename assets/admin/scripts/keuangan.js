var periode = 'semua';
var kategori = 'semua';
var date_1 = '';
var date_2 = '';
$(document).ready(function() {
    $('#box_date').hide();

    $('.datepicker').datepicker();
    get_summary();
});


function change_val(val) {
    periode = val;
    if (val == 'custom') {
        $('#box_date').show();
    } else {
        $('#box_date').hide();
    }
    loadPagination(global_url + 'Keuangan/get_list/0');
    get_summary()
}

function change_kategori(val) {
    kategori = val;
    loadPagination(global_url + 'Keuangan/get_list/0');
    get_summary()
}

function set_date() {
    date_1 = $('#date_1').val();
    date_2 = $('#date_2').val();
    loadPagination(global_url + 'Keuangan/get_list/0');
    get_summary()
}

var limit = 4;
var search_input = $("#search").val();

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Keuangan/get_list/0');
}

function search(item) {
    search_input = item;
    loadPagination(global_url + 'Keuangan/get_list/0');
}

$(document).on("click", ".pagination li a", function(event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


loadPagination(global_url + 'Keuangan/get_list/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            limit: limit,
            search: search_input,
            periode: periode,
            kategori: kategori,
            date_1: date_1,
            date_2: date_2,
        },
        dataType: "json",
        success: function(response) {
            $("#q_filter").val(response.q);
            $('.pag_list').html(response.pagination);
            if (response.status == 200) {
                createTable(response);
            } else {
                $("#table_body").html('<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>');
            }

        }
    });
}

function createTable(response) {
    var html = '';
    $.each(response.data, function(i, item) {
        html += "<tr>" +
            "<td>" +
            "<p>" + item.judul_kelas + "</p><small>" + item.kategori + " • " + item.tgl_kelas + "</small>" +
            "</td>" +
            "<td>" + item.peserta + " Peserta</td>" +
            "<td>Rp " + numeral(item.income).format('0,0') + "</td>" +
            "<td><a href='" + global_url + "Keuangan/export_item/" + item.kelas_id + "/"+item.param_export+"' title='Export to excel'><i class='fas fa-file-excel'></i></a> <a href='" + global_url + "Admin/ringkasan_peserta/" + item.kelas_id + "/" + item.param_export + "' title='Ringkasan Peserta' target='_blank'><i class='fas fa-file' ></i></a></td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
}

function get_summary() {
    $.ajax({
        type: "post",
        url: global_url + "Keuangan/get_summary",
        data: {
            periode: periode,
            kategori: kategori,
            date_1: date_1,
            date_2: date_2,
        },
        dataType: "json",
        success: function(response) {
            if (response.status == 200) {
                $('#income').text(response.data.income);
                $('#peserta').text(response.data.peserta);
                $('#judul_terlaris').text(response.data.terlaris_judul);
                $('#kategori_terlaris').text(response.data.terlaris_kategori);
                $('#tgl_terlaris').text(response.data.terlaris_tgl_kelas);
                $('.periode span').text(response.data.periode);

            }
        }
    });
}