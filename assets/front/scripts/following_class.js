var limit = 4;

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Profile/get_following/' + user_id + '/0');
}


$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


loadPagination(global_url + 'Profile/get_following/' + user_id + '/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            user_id: user_id,
            limit: limit,
        },
        dataType: "json",
        success: function (response) {
            if (response.status == 200) {
                $('.pag-list').html(response.pagination);
                createView(response);
            } else {
                $('#if_not').text('Belum ada kelas yang selesai');
            }

        }
    });
}

function createView(response) {
    var html = '';
    var img = '';
    $.each(response.data, function (i, item) {
        if (item.kategori == 'good morning knowledge') {
            var label = "<span class='tag'>" + item.kategori + "</span>";
        } else if (item.kategori == 'skill labs') {
            var label = "<span class='tag tag-scndry'>" + item.kategori + "</span>";
        } else if (item.kategori == 'open') {
            var label = "<span class='tag tag-open'>Open Class</span>";
        } else if (item.kategori == 'expert') {
            var label = "<span class='tag tag-expert'>Expert Class</span>";
        } else {
            var label = "<span class='tag tag-private'>Private Class</span>";
        }
        if (item['pemateri'].length > 1) {
            for (var x = 0; x < item['pemateri'].length; x++) {
                img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + item['pemateri'][x]['foto'] + "' /></div>";
            }
        } else {
            for (var x = 0; x < item['pemateri'].length; x++) {
                img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + item['pemateri'][x]['foto'] + "' /></div><span>" + response.data[i]['pemateri'][x]['nama_pemateri'] + "</span>";
            }
        }

        if (item.is_rated == 1) {
            var action = item.rating;
        } else {
            var action = "<button class='btn btn-primary btn-small' onclick='review(" + item.kelas_id + ")'>Beri Ulasan</button>";
        }
        //
        html += "<div class='box-card'>" +
            "<div class='box-card__img semisquare'><img src='" + global_url + "assets/uploads/kelas/" + item.jenis_kelas + "/" + item.thumbnail + "' /></div>" +
            "<div class='box-card__content'>" +
            "<div class='box-card__text'>" + label +
            "<h4>" + item.judul_kelas + "</h4>" +
            "<ul class='schedule'>" +
            "<ul>" +
            "<li>" +
            "<div class='ic'><img src='" + global_url + "assets/front/images/ic-date.svg' /></div><span>" + item.tgl_kelas + "</span>" +
            "</li>" +
            "<li>" +
            "<div class='ic'><img src='" + global_url + "assets/front/images/ic-time.svg' /></div><span>" + item.waktu_mulai + " - " + item.waktu_akhir + " WIB</span>" +
            "</li>" +
            "</ul>" +
            "</ul>" +
            "</div>" +
            "<div class='box-card__footer'>" +
            "<div class='author'>" +
            img +
            "</div>" +
            "<div class='right'>" + action + "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    });

    Body = $("#card_list");
    Body.html(html);
}

$("#ulasan").on('keyup', function () {
    if ($(this).val() == '') {
        $(".btn-add-review").attr("disabled", "disabled");
    } else {
        $(".btn-add-review").removeAttr("disabled");
    }
});

function review(id) {
    $("#mdlulasan").modal('show');
    var html = '';
    $.ajax({
        type: "get",
        url: global_url + "Profile/kelas_detail/" + id,
        dataType: "json",
        success: function (response) {
            $("#modal_pemateri").empty();
            if (response.data.kategori == 'good morning knowledge') {
                var label = "<span class='tag'>" + response.data.kategori + "</span>";
            } else if (response.data.kategori == 'skill labs') {
                var label = "<span class='tag tag-scndry'>" + response.data.kategori + "</span>";
            } else if (response.data.kategori == 'open') {
                var label = "<span class='tag tag-open'>Open Class</span>";
            } else if (response.data.kategori == 'expert') {
                var label = "<span class='tag tag-expert'>Expert Class</span>";
            } else {
                var label = "<span class='tag tag-private'>Private Class</span>";
            }
            $("#modal_label").html(label);
            $("#modal_judul").text(response.data.judul);
            $("#kelas_id").val(response.data.id);
            $.each(response.data.pemateri, function (i, pemateri) {
                html += "<div class='pp'><img src='" + global_url + "assets/uploads/pemateri/" + pemateri.foto + "' /></div><span>" + pemateri.nama_pemateri + "</span>&nbsp;&nbsp;&nbsp;";

            });
            $("#modal_pemateri").append(html);
        }
    });
}

function addReview() {
    $.ajax({
        type: "post",
        url: global_url + "Profile/add_review",
        data: {
            user_id: user_id,
            kelas_id: $("#kelas_id").val(),
            rating: $("#rating").val(),
            ulasan: $("#ulasan").val(),
        },
        dataType: "json",
        success: function (response) {
            if (response.status == 200) {
                $("#mdlulasan").modal('hide');
                $("#mdlulasan_success").modal('show');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }
    });
}