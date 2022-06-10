// var page = 0;
var limit = 4;
var sortBy = 'terbaru';
var search_input = $("#search").val();

$(document).ready(function() {
    get_summary();
});

function setOrder(item) {
    order = item;
    get_summary();
    loadPagination(global_url + 'Transaksi/get_transaksi/0');
}

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Transaksi/get_transaksi/0');
}

function sort(item) {
    sortBy = item;
    loadPagination(global_url + 'Transaksi/get_transaksi/0');
}
function search(item) {
    search_input = item;
    loadPagination(global_url + 'Transaksi/get_transaksi/0');
}
$(document).on("click", ".pagination li a", function(event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


loadPagination(global_url + 'Transaksi/get_transaksi/0');

function loadPagination(pagno) {
    var order = $('#orderSummary').val();
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            limit: limit,
            sort: sortBy,
            search: search_input,
            order: order,
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
    $.each(response.data, function(i, item) {
        if (item.status == 'paid') {
            $label = "<span class='tag tag-blue'>Sukses</span>";
        } else if (item.status == 'expired') {
            $label = "<span class='tag tag-brown'>Expired</span>";
        } else {
            $label = "<span class='tag tag-brown'>Belum Bayar</span>";
        }
        if (item.payment_method == 'manual' && item.status != 'paid') {
            $act = "<span class='tag tag-success' style='cursor:pointer' onclick='confirm(" + item.id + ")'>Konfirmasi Pembayaran</span>";
        } else {
            $act = "";
        }
        html += "<tr>" +
            "<td>" +
            "<div class='author'>" +
            `<div class='pp'><img src=" ${item.foto_profil} " onerror="this.src=' ${item.img_error}'"/></div><span> ${item.nama_lengkap}</span>` +
            "</div>" +
            "</td>" +
            "<td>" +
            item.no_wa +
            "</td>" +
            "<td>" +
            "<p>" + item.judul_kelas + "</p><small>" + item.kategori + " • " + item.tgl_kelas + "</small>" +
            "</td>" +
            "<td>" + $label + "</td>" +
            "<td>" + item.tgl_pembelian + "</td>" +
            "<td>" + $act + "</td>" +
            // "<td>" +
            // "<div class='action'><a style='cursor:pointer' onclick='detailTransaksi(" + item.id + ")'><img src='" + global_url + "assets/admin/images/ic-document.svg' /></a style='cursor:pointer'></div>" +
            // "</td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
}

function confirm(id) {
    $.ajax({
        type: "post",
        url: global_url + "Booking/accPayment/" + id,
        // data: "data",
        dataType: "json",
        success: function(response) {
            Swal.fire({
                title: response.msg,
                icon: response.msg_type
            });
            window.location = global_url + "Admin/transaksi";
        }
    });
}

function get_summary() {
    var order = $('#orderSummary').val();
    $.ajax({
        type: "get",
        url: global_url + "Transaksi/summary/" + order,
        dataType: "json",
        success: function(response) {
            $("#pemasukan").text(numeral(response.pemasukan).format('0,0'));
            $("#order").text(response.order);
            $("#unpaid").text(response.unpaid);
        }
    });
}

function detailTransaksi(id) {
    $("#detailTransaksi").modal('show');
    $.ajax({
        type: "get",
        url: global_url + "Transaksi/detail/" + id,
        dataType: "json",
        success: function(response) {
            if (response.status == 'paid') {
                $label = "<span class='tag tag-blue'>Sukses</span>";
            } else if (response.status == 'expired') {
                $label = "<span class='tag tag-brown'>Expired</span>";
            } else {
                $label = "<span class='tag tag-brown'>Belum Bayar</span>";
            }
            $('#detail_judul').text(response.judul_kelas);
            $('#detail_price').text(response.harga);
            $('#detail_kategori').text(response.kategori);
            $('#detail_tgl').text(response.tgl_kelas);
            $('#detail_user').attr('src', response.foto_profil);
            $('#detail_username').text(response.nama_lengkap);
            $('#detail_order').text(response.tgl_pembelian);
            $('#detail_label').html($label);
        }
    });
}


initFireBase();
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
function initFireBase() {
    var firebaseConfig = {
        apiKey: "AIzaSyDSFWFu-rRkxcJZ7-JosSoVoBA1S1uYc-I",
        authDomain: "asclepio-f7668.firebaseapp.com",
        projectId: "asclepio-f7668",
        storageBucket: "asclepio-f7668.appspot.com",
        messagingSenderId: "292416050558",
        appId: "1:292416050558:web:3888c0b4337d23e0c50f2f",
        measurementId: "G-DMLJ2W34J8"
    };
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    Notification.requestPermission().then(function(permission) {
        console.log("permiss", permission);
    });
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function() {
            return messaging.getToken();
        }).then(function(tkn) {
            console.log(tkn);
            $.ajax({
                url: global_url + "Auth/save_token",
                type: "POST",
                data: {
                    token: tkn,
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response.status);
                },
                error: function(err) {
                    console.log(" Can't do because: " + err);
                },
            });
        })
        .catch(function(err) {
            console.log("Unable to get permission to notify.", err);
        });
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        // var data_qna = JSON.parse(payload.data.data);
        new Notification(noteTitle, noteOptions);
        // const audio = new Audio(
        //     global_url +
        //     "/assets/sound/sound.mp3"
        // );
        // audio.play();
        loadPagination(global_url + 'Transaksi/get_transaksi/0');
        get_summary();
        // alert('hahaha');
    });
}