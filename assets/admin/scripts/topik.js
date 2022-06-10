$(document).ready(function () {
    var topik = $('.menu-list-topik ul li.active').data('value');
    getKelas(topik);
});
$(document).on("click", function (event) {
    // alert('halo');
    var $trigger = $(".menu-list-topik");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
        $('ul li').removeClass('open_menu');
    }
});
// Click function
$('.menu-list-topik ul li').click(function () {
    $('.menu-list-topik ul li').removeClass('active');
    // $('.menu-list-topik ul li').removeClass('open_menu');
    $(this).addClass('active');
});
$('.menu-list-topik ul li a .option_menu').click(function () {
    $('.menu-list-topik ul li').removeClass('open_menu');
    $(this).parent().parent().addClass('open_menu');

});

function getKelas(topik) {
    $.ajax({
        type: "get",
        url: global_url + "Topik/get_kelas/" + topik,
        dataType: "json",
        success: function (response) {
            var box = $("#box_kelas");
            if (response.status == 200) {
                var len = response.data.length;
                $(box).empty();
                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var jenis = response.data[i]['jenis'];
                    var thumbnail = response.data[i]['thumbnail'];
                    var judul = response.data[i]['judul'];
                    var kategori = response.data[i]['kategori'];
                    var waktu_mulai = response.data[i]['waktu_mulai'];
                    var waktu_akhir = response.data[i]['waktu_akhir'];
                    var harga = response.data[i]['harga'];
                    var tgl_kelas = response.data[i]['tgl_kelas'];
                    var img = '';
                    if (kategori == 'Open Class') {
                        var label = "<span class='tag tag-open'>" + kategori + "</span>"
                    } else if (kategori == 'Private Class') {
                        var label = "<span class='tag tag-private'>" + kategori + "</span>"
                    } else if (kategori == 'Expert Class') {
                        var label = "<span class='tag tag-expert'>" + kategori + "</span>"
                    } else if (kategori == 'Good morning knowledge') {
                        var label = "<span class='tag'>" + kategori + "</span>"
                    } else {
                        var label = "<span class='tag tag-scndry'>" + kategori + "</span>"
                    }

                    if (response.data[i]['pemateri'].length > 1) {
                        for (var x = 0; x < response.data[i]['pemateri'].length; x++) {
                            img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + response.data[i]['pemateri'][x]['foto'] + "' /></div>";
                        }
                    } else {
                        for (var x = 0; x < response.data[i]['pemateri'].length; x++) {
                            img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + response.data[i]['pemateri'][x]['foto'] + "' /></div><span>" + response.data[i]['pemateri'][x]['nama_pemateri'] + "</span>";
                        }
                    }

                    var html = "<div class='box-card'>" +
                        "<div class='box-card__img'><img src='" + global_url + "assets/uploads/kelas/" + jenis + "/" + thumbnail + "' /></div>" +
                        "<div class='box-card__content'>" +
                        "<div class='box-card__text'>" + label +
                        "<h4>" + judul + ".</h4>" +
                        "<ul class='schedule'>" +
                        "<ul>" +
                        "<li>" +
                        "<div class='ic'><img src='" + global_url + "assets/admin/images/ic-date.svg' /></div><span>" + tgl_kelas + "</span>" +
                        "</li>" +
                        "<li>" +
                        "<div class='ic'><img src='" + global_url + "assets/admin/images/ic-time.svg' /></div><span>" + waktu_mulai + " - " + waktu_akhir + " WIB</span>" +
                        "</li>" +
                        "</ul>" +
                        "</ul>" +
                        "</div>" +
                        "<div class='box-card__footer'>" +
                        "<div class='author'>" +
                        img +
                        "</div>" +
                        "<div class='price'>" + harga + "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $(box).append(html);

                }
                $("#count_kelas").text(len);
            } else {
                $(box).text('Tidak ada kelas di topik ini');
                $("#count_kelas").text('0');
            }


        }
    });
}

function edit(id) {
    $("#editTopik").modal('show');
    $.ajax({
        type: "get",
        url: global_url + "Topik/detail/" + id,
        // data: "data",
        dataType: "json",
        success: function (response) {
            $("#nama_topik_edit").val(response.nama_topik);
            $("#id_topik_edit").val(id);
        }
    });
}