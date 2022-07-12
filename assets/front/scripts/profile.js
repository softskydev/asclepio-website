$(document).ready(function () {
    getUniv();
    getProvinsi();
    setTimeout(() => {
        getKota();
        $("select[id='select_kota']").selectpicker('refresh');
    }, 1000);
    changeLinkMateri();

});

function edit() {
    $("#editprofile").modal('show');
    // $.ajax({
    //     type: "get",
    //     url: global_url + "Profile/get_detail/" + id,
    //     dataType: "json",
    //     success: function (response) {
    //         $("#provinsi_name").val(response.provinsi_name);
    //         $("#provinsi_id").val(response.provinsi_id);
    //     }
    // });
}


function getProvinsi() {
    $.ajax({
        type: "get",
        url: "https://ibnux.github.io/data-indonesia/propinsi.json",
        dataType: "json",
        success: function (response) {
            var len = response.length;
            var select = $("select[id='select_provinsi']");
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var selected = '';
                var nama = response[i]['nama'];
                if (select.attr('value') == id) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + id + "' " + selected + ">" + nama + "</option>");

            }
            $(select).selectpicker('refresh');

        }
    });
}
$("select[id='select_provinsi']").on('change', function () {
    getKota();
    $("#provinsi_name").val($("select[id='select_provinsi'] option:selected").text());

});

function getKota() {
    var id = $("select[id='select_provinsi']").val();
    $("select[id='select_kota']").empty();
    $.ajax({
        type: "get",
        url: "https://ibnux.github.io/data-indonesia/kabupaten/" + id + ".json",
        dataType: "json",
        success: function (response) {
            var len = response.length;
            var select = $("select[id='select_kota']");

            for (var i = 0; i < len; i++) {
                var selected = '';
                var nama = response[i]['nama'];

                if (select.attr('value') == nama) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + nama + "' " + selected + ">" + nama + "</option>");

            }
            $(select).selectpicker('refresh');


        },
    });
}

function getUniv() {
    $.ajax({
        type: "get",
        url: global_url + "Front/univ",
        dataType: "json",
        success: function (response) {
            var len = response.data.length;
            var select = $("select[id='select_univ']");
            for (var i = 0; i < len; i++) {
                // var id = response.data[i]['id'];
                var selected = '';
                var nama_univ = response.data[i]['nama_univ'];

                if (select.attr('value') == nama_univ) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + nama_univ + "' " + selected + ">" + nama_univ + "</option>");

            }
            $(select).selectpicker('refresh');
        }
    });
}

function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function () {
            $("#previewImg").attr("src", reader.result);
        }

        reader.readAsDataURL(file);
    }
}

var limit_topik = 3;
$('.topik').on('change', function (evt) {
    if ($(this).siblings(':checked').length >= limit_topik) {
        this.checked = false;
    }
});

function get_detail_voucher(id) {
    $.ajax({
        type: "get",
        url: global_url + "Voucher/detail_voucher/" + id,
        dataType: "json",
        success: function (response) {
            $("#img_voucher").attr('src', global_url + 'assets/uploads/voucher/' + response.thumbnail);
            $("#voucher_code").val(response.code);

            $("#expired_voucher").text(response.expired);
            $("#desc_voucher").text(response.deskripsi);
            if (response.limit_status == 'limited') {
                $("#limit_voucher").text(response.limit + ' kali pakai');
                $("#sisa_voucher").text('Sisa ' + response.sisa + 'x Penggunaan');
            } else {
                $("#limit_voucher").text('Unlimited Voucher');
                $("#sisa_voucher").text('');
            }

        }
    });
}

const copyBtn = document.getElementById('copyBtn')
const copyText = document.getElementById('voucher_code')

copyBtn.onclick = () => {
    copyText.select(); // Selects the text inside the input
    document.execCommand('copy'); // Simply copies the selected text to clipboard
    alert('Kode Berhasil disalin');

}



function openModal() {
    var link = $("#select_rekaman").val();
    $("#modal-video").modal('show');
    $("#video-yt").attr("src", "https://www.youtube.com/embed/" + link + "?autoplay=1&cc_load_policy=1&disablekb=1&enablejsapi=1&modestbranding=1");
}

function changeLinkMateri() {
    var link = $("#select_materi").val();
    $("#link_materi").attr("href", link);
}

function listLinkKelas(id){
    $("#linkKelasBanyak").modal('show');

    $.ajax({
        type: "GET",
        url: global_url + "Asclepedia/link_kelas_materi/"+id,
        dataType: "html",
        success: function (response) {
            $("#tbodyLink").html(response)
        }
    });

}

function getVoucher(code) {
    var user = $("#user_id").val();
    $.ajax({
        type: "get",
        url: global_url + "Profile/get_voucher/" + code,
        dataType: "json",
        success: function (response) {
            $("#box_voucher").empty();
            var box = $("#box_voucher");
            if (response.status == 200) {
                var len = response.data.length;

                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var thumbnail = response.data[i]['thumbnail'];
                    var code_voucher = response.data[i]['code_voucher'];
                    var status = response.data[i]['is_redeem'];
                    if (status == 1) {
                        var button = "<small>Voucher telah habis</small>";
                    } else {
                        var button = "<button class='btn btn-primary btn-small' onclick='redeem(" + user + "," + id + ")'>Tukar</button>";
                    }

                    var html = "<div class='benefits__item'>" +
                        "<div class='benefits__panel'>" +
                        "<div class='benefits__head wrap-box-card listview'>" +
                        "<div class='box-card'>" +
                        "<div class='box-card__img'><img src='" + global_url + "assets/uploads/voucher/" + thumbnail + "' /></div>" +
                        "<div class='box-card__content'>" +
                        "<div class='box-card__text'>" +
                        "<h4>" + code_voucher + "</h4>" +
                        "<div class='btn-group'>" +
                        button +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $(box).append(html);
                }
            } else {
                $(box).html('Kode Voucher <b class="text-success" style="text-transform:uppercase">' + code + '</b> tidak ditemukan');
            }
        }
    });
}
$('#modal-redeem').on('shown.bs.modal', function () {
    $('#search').focus();
})

function redeem(user, id) {
    $.ajax({
        type: "post",
        url: global_url + "Profile/redeem",
        data: {
            user: user,
            id: id
        },
        dataType: "json",
        success: function (response) {
            Swal.fire({
                title: response.msg,
                icon: response.msg_type
            }).then(function (isConfirm) {
                if (isConfirm) {
                    window.location.reload();
                } else {}
            });
        }
    });
}