$(document).ready(function () {
    // getPemateri(x);
    // $("#addAsclepedia").modal('show');
    getTopik();
    $("#box_materi").hide();
    $('#addAsclepedia').on('shown.bs.modal', function () {
        $("#box_materi").hide();
        $("#box_add").show();
        $("#form_add").trigger("reset");
        $("#box_early").hide();
        $("#box_late").hide();
    });
    getUpcoming();
    getFinished();
    getUnbenefit();

    $("input[type=radio][name='tipe_kelas_sekali_or_banyak'").change(function() {
        if (this.value == 'sekali_pertemuan') {
             $(".hide_when_banyak").show();
             $(".show_on_banyak").hide();
        }
        else if (this.value == 'banyak_pertemuan') {
             $(".hide_when_banyak").hide();
             $(".show_on_banyak").show();
             
        }
    });
    var today = new Date(); 
    var dd = today.getDate(); 
    var mm = today.getMonth()+1; //January is 0! 
    var yyyy = today.getFullYear(); 
    if(dd<10){ dd='0'+dd } 
    if(mm<10){ mm='0'+mm } 
    var today = dd+'/'+mm+'/'+yyyy;
    $('.daterange').daterangepicker({
        minDate: today,
    });
    $('.hide_when_banyak').show();
    $('.show_on_banyak').hide();


});
let dokter = [];

function change_val(val) {
    if (val == 'good morning knowledge') {
        $("#link_gform").show();
        $("#link_gform_edit").show();
        $("#box_early").hide();
        $("#box_late").hide();
        $("#box_early_edit").hide();
        $("#box_late_edit").hide();
        $("#early_price").val(0);
        $("#late_price").val(0);
    } else {
        $("#link_gform").hide();
        $("#link_gform_edit").hide();
        $("#box_early").show();
        $("#box_late").show();
        $("#box_early_edit").show();
        $("#box_late_edit").show();
        $("#early_price").val('');
        $("#late_price").val('');
    }
}


function show_materi() {
    $("#box_materi").show();
    $("#box_add").hide();
}

// function getPemateri(x) {

//     $.ajax({
//         type: "get",
//         url: global_url + "Asclepedia/get_pemateri",
//         dataType: "json",
//         success: function (response) {
//             var len = response.data.length;
//             var select = $("select[id='select_pemateri" + x + "']");
//             var idx = select.val();
//             if (x == 1) {
//                 for (var i = 0; i < len; i++) {
//                     var id = response.data[i]['id'];

//                     var selected = '';
//                     var nama_pemateri = response.data[i]['nama_pemateri'];
//                     // alert(id);

//                     if (select.attr('value') == id) {
//                         var selected = 'selected';
//                     }

//                     $(select).append("<option value='" + id + "' " + selected + ">" + nama_pemateri + "</option>");

//                 }
//                 $(select).selectpicker('refresh');

//             } else {

//                 for (var i = 0; i < len; i++) {
//                     var id = response.data[i]['id'];

//                     var selected = '';
//                     var nama_pemateri = response.data[i]['nama_pemateri'];

//                     if (select.attr('value') == id) {
//                         var selected = 'selected';
//                     }
//                     if (jQuery.inArray(idx, dokter) !== -1) {
//                         // alert('ada');
//                     } else {
//                         // alert('ga ada');
//                         $(select).append("<option value='" + id + "' " + selected + ">" + nama_pemateri + "</option>");
//                     }
//                 }
//                 $(select).selectpicker('refresh');

//             }
//             // $(select).trigger('change');

//         }
//     });
// }

function getTopik() {


    $.ajax({
        type: "get",
        url: global_url + "Asclepedia/get_topik",
        dataType: "json",
        success: function (response) {
            var len = response.data.length;
            var select = $("#topik");
            for (var i = 0; i < len; i++) {
                var id = response.data[i]['id'];
                var selected = '';
                var nama_topik = response.data[i]['nama_topik'];

                if (select.attr('value') == id) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + id + "' " + selected + ">" + nama_topik + "</option>");
            }
            $(select).selectpicker('refresh');
        }
    });
}


function editTopik(id) {

    $.ajax({
        type: "get",
        url: global_url + "Asclepedia/get_topik",
        dataType: "json",
        success: function (response) {
            var len = response.data.length;
            var select = $("#topik_edit");
            for (var i = 0; i < len; i++) {
                var idx = response.data[i]['id'];
                var selected = '';
                var nama_topik = response.data[i]['nama_topik'];

                if (response.data[i]['id'] == id) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + idx + "' " + selected + ">" + nama_topik + "</option>");
            }
            $(select).selectpicker('refresh');
        }
    });

}


var wrapper_materi = $(".main_materi"); //Input fields wrapper
var add_materi = $("#add_materi"); //Add button class or ID
var y = 1;
var tambahan = `<div class="form-group show_on_banyak">
                    <label>Link Materi </label>
                    <input class="form-control" type="text" value="" name="link_materi[]" placeholder="Tuliskan Link Zoom untuk Materi ini" />
                </div>
                <div class="form-group show_on_banyak">
                    <label>Tanggal Materi </label>
                    <input class="form-control" type="date" value="" name="tanggal_materi[]" placeholder="Masukan Tanggal Materi" />
                </div>
                <div class="form-group show_on_banyak">
                    <label>Waktu Materi </label>
                    <input class="form-control" type="time" value="" name="time_materi[]"  />
                </div>`;
var max_fields = 10;
//When user click on add input button
$(add_materi).click(function (e) {
    e.preventDefault();
    //Check maximum allowed input fields
    if (y < max_fields) {
        y++; //input field increment
        //add input field
        var input_materi = '<div class="box-form-materi">' +
            '<h4>Materi ' + y + '<a class="delete-materi remove_field" href="javascript:void(0)"><img src="' + global_url + 'assets/admin/images/ic-delete-grey.svg" /></a></h4>' +
            '<div class="form-group">' +
            '<label>Judul materi</label>' +
            '<input class="form-control" type="text" value="" name="judul_materi[]" placeholder="Masukan judul materi" />' +
            '</div>' +
            '<div class="form-group">' +
            '<label>Deskripsi</label>' +
            '<textarea class="form-control" rows="4" placeholder="Masukan deskripsi materi" name="deskripsi_materi[]"></textarea>' +
            '</div>' ;
            
            if ($("[name='tipe_kelas_sekali_or_banyak']:checked").val() == 'banyak_pertemuan') {
                 input_materi += tambahan;
             
            } 
            input_materi +=  '<div class="form-group waktu"><div class="row"><div class="col-3"><label>Durasi</label>' +
                               '<select class="select" name="durasi_materi[]">' +
                                    '<option value="60">60 menit</option>' +
                                    '<option value="90">90 menit</option>' +
                                    '<option value="120">120 menit</option>' +
                                    '<option value="180">180 menit</option>' +
                                '</select>' +
                                '</div>' +
                            '</div>' +
                         '</div>' +
                    '</div>';
        $(wrapper_materi).append(input_materi);
        console.log(input_materi)
        $('.select').selectpicker('refresh');
    }
});

//when user click on remove button
$(wrapper_materi).on("click", ".remove_field", function (e) {
    e.preventDefault();
    $(this).parent('h4').parent('div').remove(); //remove inout field
    y--; //inout field decrement
})


// function addIdDokter(id) {

//     if (jQuery.inArray(id, dokter) !== -1) {

//     } else {
//         dokter.push(id);
//     }
//     console.log(dokter);
// }

function getUpcoming() {

    var kategori = $("#filter_kategori").val();
    var search_upcoming = $("#search_upcoming").val();

    $.ajax({
        type: "GET",
        url: global_url + "Asclepedia/get_upcoming/" + kategori,
        dataType: "json",
        data: {
            type: kategori,
            search: search_upcoming,
        },
        success: function (response) {
            $("#box_upcoming").empty();
            var box = $("#box_upcoming");
            if (response.status == 200) {
                var len = response.data.length;

                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var thumbnail = response.data[i]['thumbnail'];
                    var judul = response.data[i]['judul'];
                    var kategori = response.data[i]['kategori'];
                    var waktu_mulai = response.data[i]['waktu_mulai'];
                    var waktu_akhir = response.data[i]['waktu_akhir'];
                    var harga = response.data[i]['harga'];
                    var tgl_kelas = response.data[i]['tgl_kelas'];
                    var verif = global_url + 'Front/verif_kelas/';
                    if (response.data[i]['in_public'] == 0) {
                        var public = 'Publish';
                        var btn_edit = "<li><a href='javascript:void(0)' onclick='edit_kelas(" + id + ")'>Edit Kelas</a></li>";
                    } else {
                        var public = 'Unpublish';
                        var btn_edit = " ";
                    }
                    var img = '';
                    if (kategori == 'Good morning knowledge') {
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


                    var html = "<div class='col-md-3 mb-3'>" +
                        "<div class='box-card'>" +
                        "<div class='box-card__img'><img src='" + global_url + "assets/uploads/kelas/asclepedia/" + thumbnail + "' class='thumbnail'/></div>" +
                        "<div class='box-card__text'>" + label +
                        "<h4><a href='#'>" + judul + "</a></h4>" +
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
                        "<div class='author'>" +
                        img +
                        "</div>" +
                        "</div>" +
                        "<div class='box-card__footer'>" +
                        "<div class='price'>" + harga + "</div>" +
                        "<div class='action'>" +
                        "<div class='dot'><img src='" + global_url + "assets/admin/images/ic-three-dots.svg'/></div>" +
                        "<div class='action-sub'>" +
                        "<ul>" +
                        // "<li><a href='javascript:void(0)' onclick='edit_kelas(" + id + ")'>Edit Kelas</a></li>" +
                        btn_edit +
                        "<li><input type='text' value='" + verif + "" + response.data[i]['token'] + "'></li>" +
                        "<li class='dlt'><a href='" + global_url + "Asclepedia/delete_kelas/" + id + "'>Delete Kelas</a></li>" +
                        "<li class='dlt'><a href='" + global_url + "Asclepedia/publish_kelas/" + id + "'>" + public + " Kelas</a></li>" +
                        "<li class='dlt'><a href='" + global_url + "Admin/do_reminder/" + id + "'> Reminder Kelas </a></li>" +
                        "</ul>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $(box).append(html);
                }
            } else {
                $(box).html('Tidak ada data');
            }
        }
    });
}

function getFinished() {
    var kategori_finish = $("#filter_finished").val();
    var search_finished = $("#search_finished").val();

    $.ajax({
        type: "get",
        url: global_url + "Asclepedia/get_finished/" + kategori_finish,
        data: {
            type: kategori_finish,
            search: search_finished
        },
        dataType: "json",
        success: function (response) {
            $("#box_finished").empty();
            var box = $("#box_finished");
            if (response.status == 200) {
                var len = response.data.length;
                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var thumbnail = response.data[i]['thumbnail'];
                    var judul = response.data[i]['judul'];
                    var kategori = response.data[i]['kategori'];
                    var waktu_mulai = response.data[i]['waktu_mulai'];
                    var waktu_akhir = response.data[i]['waktu_akhir'];
                    var harga = response.data[i]['harga'];
                    var tgl_kelas = response.data[i]['tgl_kelas'];
                    var verif = global_url + 'Front/verif_kelas/';
                    if (response.data[i]['in_public'] == 0) {
                        var public = 'Publish';
                        var btn_edit = "<li><a href='javascript:void(0)' onclick='edit_kelas(" + id + ")'>Edit Kelas</a></li>";
                    } else {
                        var public = 'Unpublish';
                        var btn_edit = " ";
                    }
                    var img = '';
                    if (kategori == 'Good morning knowledge') {
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
                    var html = "<div class='col-md-3 mb-3'>" +
                        "<div class='box-card'>" +
                        "<div class='box-card__img'><img src='" + global_url + "assets/uploads/kelas/asclepedia/" + thumbnail + "' class='thumbnail'/></div>" +
                        "<div class='box-card__text'>" + label +
                        "<h4><a href='#'>" + judul + "</a></h4>" +
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
                        "<div class='author'>" +
                        img +
                        "</div>" +
                        "</div>" +
                        "<div class='box-card__footer'>" +
                        "<div class='price'>" + harga + "</div>" +
                        "<div class='action'>" +
                        "<div class='dot'><img src='" + global_url + "assets/admin/images/ic-three-dots.svg' /></div>" +
                        "<div class='action-sub'>" +
                        "<ul>" +
                        // "<li><a href='javascript:void(0)' onclick='edit_kelas(" + id + ")'>Edit Kelas</a></li>" +
                        btn_edit +
                        "<li><input type='text' value='" + verif + "" + response.data[i]['token'] + "'></li>" +
                        "<li class='dlt'><a href='" + global_url + "Asclepedia/delete_kelas/" + id + "'>Delete Kelas</a></li>" +
                        "<li class='dlt'><a href='" + global_url + "Asclepedia/publish_kelas/" + id + "'>" + public + " Kelas</a></li>" +
                        "</ul>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $(box).append(html);
                }
            } else {
                $(box).html('Tidak ada data');
            }

        }
    });
}

function edit_kelas(id) {

    window.open(global_url+'admin/kelas_detail/'+id , '_blank')

    // $.ajax({
    //     url: global_url + 'Asclepedia/get_kelas_detail/' + id,
    //     method: 'GET',
    //     dataType: 'JSON',
    //     success: function (resp) {

    //         console.log(resp);
    //         var date = resp.data.tgl_kelas;
    //         var arr = date.split('-');
    //         console.log(arr[1]);

    //         $("#editAsclepedia").modal('show');
    //         $("#kelas_id").val(id);
    //         if (resp.data.kategori_kelas == 'good morning knowledge') {
    //             $("#kat_gmk").attr('checked', true);
    //             $("#link_gform_edit").show();
    //             $("#link_gform_edit input").val(resp.data.gform_url);
    //             $("#box_early_edit").hide();
    //             $("#box_late_edit").hide();
    //         } else {
    //             $("#kat_sl").attr('checked', true);
    //             $("#link_gform_edit").hide();
    //             $("#box_early_edit").show();
    //             $("#box_late_edit").show();
    //         }
    //         $("#date").val(parseInt(arr[2], 10));
    //         $("#date").selectpicker('refresh');
    //         $("#month").val(parseInt(arr[1], 10));
    //         $("#month").selectpicker('refresh');
    //         $("#year").val(arr[0]);
    //         $("#year").selectpicker('refresh');
    //         // $("input[name='topik']").val(
    //         editTopik(resp.data.topik_id);
    //         $("#existing_image").attr('src', global_url + 'assets/uploads/kelas/asclepedia/' + resp.data.thumbnail);
    //         $("#judul_kelas_edit").val(resp.data.judul_kelas);
    //         $("#deskripsi_kelas_edit").val(resp.data.deskripsi_kelas);
    //         load_pemateri_edit(id);
    //         load_materi_edit(id);
    //         $("#time_start").val(resp.data.waktu_mulai);
    //         $("#time_end").val(resp.data.waktu_akhir);
    //         $("#early_price_edit").val(numeral(resp.data.early_price).format('0,0'));
    //         $("#late_price_edit").val(numeral(resp.data.late_price).format('0,0'));
    //         $("#link_zoom_edit").val(resp.data.link_zoom);
    //         $("#youtube_edit").val(resp.data.youtube);
    //         $("#limit_edit").val(resp.data.limit);
    //         $("#limit_edit").val(resp.data.limit);
    //         $("#link_log_edit").attr('href',global_url+'Admin/log_history/'+id);
    //         select_profile_member(id);
    //     }
    // });
}

function select_profile_member(transaksi_id) {

    $.ajax({
        url: global_url + 'Asclepedia/select_member/' + transaksi_id,
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $("#x_member_gratis").html(response);
            $("#x_member_gratis").selectpicker('refresh');
        }
    });

}




function load_pemateri_edit(kelas_id) {

    $.ajax({
        url: global_url + 'Asclepedia/load_khusus_pemateri/' + kelas_id,
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $("#select_pemateri_edit").html(response);
            $("#select_pemateri_edit").selectpicker('refresh');

        }
    });

}

function load_materi_edit(kelas_id) {

    $.ajax({
        url: global_url + 'Asclepedia/load_materi/' + kelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            $.each(response, function (i, item) {
                html += "<tr>" +
                    "<td>" +
                    "<input type='text' class='form-control' value='" + item.judul_materi + "'>" +
                    "</td>" +
                    "<td>" +
                    "<textarea name='' id='' rows='3' class='form-control' style='width: 150px;'>" + item.deskripsi_materi + "</textarea>" +
                    "</td>" +
                    "<td>" +
                    "<input type='text' class='form-control' style='width: 50px;' value='" + item.durasi_materi + "'>" +
                    "</td>" +
                    "<td>" +
                    "<a href='#'><img src='" + global_url + "assets/admin/images/ic-action-delete.svg' /></a>" +
                    "</td>" +
                    "</tr>";
            });

            tableBody = $("#table_materi");
            tableBody.html(html);
        }
    });

}

function getUnbenefit() {
    var sort = $("#filter_unbenefit").val();
    var search_unbenefit = $("#search_unbenefit").val();
    $.ajax({
        type: "get",
        url: global_url + "Asclepedia/get_unbenefit",
        data: {
            search: search_unbenefit,
            sort: sort,
        },
        dataType: "json",
        success: function (response) {

            $("#box_unbenefit").empty();
            var box = $("#box_unbenefit");
            if (response.status == 200) {
                var len = response.data.length;
                for (var i = 0; i < len; i++) {
                    var id = response.data[i]['id'];
                    var thumbnail = response.data[i]['thumbnail'];
                    var judul = response.data[i]['judul'];
                    var kategori = response.data[i]['kategori'];
                    var waktu_mulai = response.data[i]['waktu_mulai'];
                    var waktu_akhir = response.data[i]['waktu_akhir'];
                    var harga = response.data[i]['harga'];
                    var tgl_kelas = response.data[i]['tgl_kelas'];
                    var img = '';
                    if (kategori == 'Good Morning Knowledge') {
                        var label = "<span class='tag tag'>" + kategori + "</span>"
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
                        "<a class='box-card__link' onclick='kelasDetail(" + id + ")'>" +
                        "<div class='box-card__img'><img src='" + global_url + "assets/uploads/kelas/asclepedia/" + thumbnail + "' /></div>" +
                        "<div class='box-card__content'>" +
                        "<div class='box-card__text'>" + label +
                        "<h4>" + judul + "</h4>" +
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
                        "</div>" +
                        "<div class='price'>" + harga + "</div>" +
                        "</div>" +
                        "</div>" +
                        "</a>" +
                        "</div>";
                    $(box).append(html);
                }
            } else {
                $(box).html('Tidak ada data');
            }

        }
    });
}

function kelasDetail(id) {
    $("#addAsclepediaBenefit").modal('hide');
    $("#editBenefitLinkVideo").modal('show');
    $.ajax({
        type: "get",
        url: global_url + "Asclepedia/detail/" + id,
        dataType: "json",
        success: function (response) {
            // var len = response.data.length;
            var box = $("#box_detail");
            var id = response.data[0]['id'];
            var thumbnail = response.data[0]['thumbnail'];
            var judul = response.data[0]['judul'];
            var kategori = response.data[0]['kategori'];
            var waktu_mulai = response.data[0]['waktu_mulai'];
            var waktu_akhir = response.data[0]['waktu_akhir'];
            var harga = response.data[0]['harga'];
            var tgl_kelas = response.data[0]['tgl_kelas'];
            var link_rekaman = response.data[0]['link_rekaman'];
            var link_materi = response.data[0]['link_materi'];
            var link_sertifikat = response.data[0]['link_sertifikat'];
            var password_materi = response.data[0]['password_materi'];

            var img = '';
            if (kategori == 'Good Morning Knowledge') {
                var label = "<span class='tag tag'>" + kategori + "</span>"
            } else {
                var label = "<span class='tag tag-scndry'>" + kategori + "</span>"
            }
            if (response.data[0]['pemateri'].length > 1) {
                for (var x = 0; x < response.data[0]['pemateri'].length; x++) {
                    img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + response.data[0]['pemateri'][x]['foto'] + "' /></div>";
                }
            } else {
                for (var x = 0; x < response.data[0]['pemateri'].length; x++) {
                    img += "<div class='pp'><img style='display:inline-block' src='" + global_url + "assets/uploads/pemateri/" + response.data[0]['pemateri'][x]['foto'] + "' /></div><span>" + response.data[0]['pemateri'][x]['nama_pemateri'] + "</span>";
                }
            }


            var html = "<div class='box-card'>" +
                "<a class='box-card__link'>" +
                "<div class='box-card__img'><img src='" + global_url + "assets/uploads/kelas/asclepedia/" + thumbnail + "' /></div>" +
                "<div class='box-card__content'>" +
                "<div class='box-card__text'>" + label +
                "<h4>" + judul + "</h4>" +
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
                "</a>" +
                "</div>";
            $(box).html(html);
            $("#id_kelas").val(id);
            $("#link_rekaman").val(link_rekaman);
            $("#link_materi").val(link_materi);
            $("#link_sertifikat").val(link_sertifikat);
            $("#password_materi").val(password_materi);
        }
    });

}

function select_benefit(kelas_id) {
    $.ajax({
        url: global_url + 'Asclepedia/get_kelas_detail/' + kelas_id,
        method: 'GET',
        dataType: 'JSON',
        success: function (resp) {
            $("#modal_dlg").scrollTop(400);
            $("#add_link").show();
        }
    });
}

// TABLE BENEFIT

var limit = 4;

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Asclepedia/get_with_benefit/0');
}


$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});


var search_benefit = '';
var sortBy = 'terbaru';

function sort(item) {
    sortBy = item;
    loadPagination(global_url + 'Asclepedia/get_with_benefit/0');
}

function cari_benefit(item) {
    search_benefit = item;
    loadPagination(global_url + 'Asclepedia/get_with_benefit/0');
}


loadPagination(global_url + 'Asclepedia/get_with_benefit/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            limit: limit,
            search: search_benefit,
            sort: sortBy,
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
            "<td>" +
            "<p>" + item.judul_kelas + "</p><small>" + item.kategori + " • " + item.tgl_kelas + "</small>" +
            "</td>" +
            "<td><a href='' target='_blank'>" + item.link_rekaman + "</a></td>" +
            "<td><a href='' target='_blank'>" + item.link_materi + "</a></td>" +
            "<td>" +
            "<div class='action'><a href='javascript:void(0)' onclick='kelasDetail(" + item.id + ")'><img src='" + global_url + "assets/admin/images/ic-action-edit.svg' /></a></div>" +
            "</td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
}