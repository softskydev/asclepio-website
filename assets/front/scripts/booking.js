$(document).ready(function () {
    countAll();
});


var harga = $("#harga").val();
// var diskon = $("#diskon").val();
var product_id = $("#product_id").val();
// var code_voucher = $("#code_voucher").val();
// var total = harga - diskon;
// var total = harga;

function countAll() {
    var sum = 0;
    $('.harga_total').each(function () {
        sum += parseFloat($(this).val());
    });

    $("#total").val(sum);
    $("#text_total").text('Rp ' + numeral(sum).format('0,0'));
}

function addToCart(user, id) {
    if (user == '') {
        window.location.href = global_url + 'login';
    } else {
        $.ajax({
            type: "post",
            url: global_url + "Booking/addtocart",
            data: {
                user_id: user,
                product_id: id,
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    window.location.href = global_url + 'cart';
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        icon: 'error',
                        text: response.msg
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            if (response.status == 402) {
                                window.location.href = global_url + 'login';
                            } else if (response.status == 401) {
                                window.location.href = global_url + 'cart';
                            } else if (response.status == 403) {
                                window.location.href;
                            }
                            // else if (response.status == 405) {
                            //     window.location.href = global_url + 'profile/tiket';
                            // }
                        }
                    })
    
                }
    
            }
        });
    }
    

}

function makeTransaction(user) {
    // var diskon = $('#diskon').val();
    var total = $('#total').val();
    var product_id = $("input[name='product_id[]']");
    var harga = $("input[name='harga[]']");
    var diskon = $("input[name='diskon[]']");
    var harga_total = $("input[name='harga_total[]']");
    var code_voucher = $("input[name='voucher[]']");

    var product_ar = [];
    var harga_ar = [];
    var diskon_ar = [];
    var harga_total_ar = [];
    var code_voucher_ar = [];

    $.each(product_id, function (index, value) {
        product_ar.push($(this).val());
    });
    $.each(harga, function (index, value) {
        harga_ar.push($(this).val());
    });
    $.each(diskon, function (index, value) {
        diskon_ar.push($(this).val());
    });
    $.each(harga_total, function (index, value) {
        harga_total_ar.push($(this).val());
    });
    $.each(code_voucher, function (index, value) {
        code_voucher_ar.push($(this).val());
    });
    // console.log(product_ar, harga_ar);
    // return false;
    // var code_voucher = $("#code_voucher").val();
    // console.log(user)
    // console.log(product_ar)
    // console.log(harga_ar)
    // console.log(diskon_ar)
    // console.log(harga_total_ar)
    // console.log(total)
    // console.log(code_voucher)
    // return false;

    Swal.fire({
        title: 'Yakin ingin melanjutkan ke pembayaran?',
        text: "Kelas yang sudah dibeli akan terhapus dari daftar tiket",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yakin',
        confirmButtonColor: '#75B248'
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // alert(user + ',' + product_id + ',' + harga + ',' + diskon + ',' + total);
            if (total == 0) {
                var url = global_url + "Booking/quickBuy";
            } else {
                var url = global_url + "Booking/makeTransaction";
                $(".btn-checkout").attr('disabled', 'disabled');
                $(".btn-checkout").text('Sedang Proses');
            }


            $.ajax({
                type: "post",
                url: url,
                data: {
                    user_id: user,
                    product_id: product_ar,
                    harga: harga_ar,
                    diskon: diskon_ar,
                    harga_total: harga_total_ar,
                    total: total,
                    code_voucher: code_voucher_ar,
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        if (total == 0) {
                            window.location.href = global_url + 'profile/pemesanan/semua';
                        } else {
                            window.location.href = global_url + 'payment/' + response.code_transaction;
                        }

                    } else {
                        Swal.fire({
                            title: 'Gagal melanjutkan',
                            icon: 'error',
                        })
                    }
                }
            });

        }
    })

}

function makePayment(code) {
    // var payment = $("input[name='method_pay']:checked").data('name');
    $.ajax({
        type: "post",
        url: global_url + "Booking/makePayment",
        data: {
            code_transaction: code,
        },
        dataType: "json",
        success: function (response) {
            // if (response.status_code == 201) {
            //     window.location.href = global_url + 'payment_status/' + code;
            // } else {
            //     Swal.fire({
            //         title: 'Gagal',
            //         icon: 'error',
            //     })
            // }
            window.snap.pay(response.token);
        }
    });
}

$('#voucher_msg').hide();
$('#text_diskon_container').hide();

function cek_voucher() {

    var voucher = $('#code_voucher').val();
    var card_id = $("input[name='card_id[]']");
    var card_jenis = $("input[name='card_jenis[]']");
    var card_harga = $("input[name='card_harga[]']");

    var card_id_ar = [];
    var card_jenis_ar = [];
    var card_harga_ar = [];

    $.each(card_id, function (index, value) {
        card_id_ar.push($(this).val());
    });
    $.each(card_jenis, function (index, value) {
        card_jenis_ar.push($(this).val());
    });
    $.each(card_harga, function (index, value) {
        card_harga_ar.push($(this).val());
    });
    $.ajax({
        type: "post",
        url: global_url + "Booking/cek_voucher/" + voucher,
        dataType: "json",
        success: function (response) {
            var msg = 'Voucher tidak dapat digunakan pada kelas yang Anda pilih';

            if (response.status == 200) {

                $('#potongan').val(response.discount);
                $('#sisa').val(response.sisa_voucher);
                $('#jenis_voucher').val(response.jenis_voucher);
                // $('#diskon').val(discount);
                // $('#text_diskon').text("- Rp " + numeral(discount).format('0,0'));
                $('#voucher_name').text("(" + voucher + ")");
                $('#text_diskon_container').slideDown();
                if (response.jenis_kelas == 'asclepedia') {
                    if (response.is_spesifik == 1) {
                        for (let index = 0; index < response.spesifik.length; index++) {
                            $.each(card_id, function (i, value) {
                                card_id_ar.push($(this).val());
                                var id = $(this).val();
                                if (id === response.spesifik[index].kelas_id) {
                                    $("#btn-select" + id).css('display', 'block');
                                    if (response.voucher_type != 'free') {
                                        msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                                    } else {
                                        msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                                    }
                                }

                            });
                        }
                    } else {
                        $.each(card_id, function (i, value) {
                            card_id_ar.push($(this).val());
                            var id = $(this).val();
                            var jenis_kelas = $("#card_jenis" + id).val();
                            if (jenis_kelas === response.jenis_kelas) {
                                $("#btn-select" + id).css('display', 'block');
                                if (response.voucher_type != 'free') {
                                    msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                                } else {
                                    msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                                }
                            }

                        });
                    }
                } else if (response.jenis_kelas == 'asclepio_go') {
                    if (response.is_spesifik == 1) {
                        for (let index = 0; index < response.spesifik.length; index++) {
                            $.each(card_id, function (i, value) {
                                card_id_ar.push($(this).val());
                                var id = $(this).val();
                                if (id === response.spesifik[index].kelas_id) {
                                    $("#btn-select" + id).css('display', 'block');
                                    if (response.voucher_type != 'free') {
                                        msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                                    } else {
                                        msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                                    }
                                }

                            });
                        }
                    } else {
                        $.each(card_id, function (i, value) {
                            card_id_ar.push($(this).val());
                            var id = $(this).val();
                            var jenis_kelas = $("#card_jenis" + id).val();
                            if (jenis_kelas === response.jenis_kelas) {
                                $("#btn-select" + id).css('display', 'block');
                                if (response.voucher_type != 'free') {
                                    msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                                } else {
                                    msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                                }
                            }

                        });
                    }
                } else {
                    if (response.is_spesifik == 1) {
                        for (let index = 0; index < response.spesifik.length; index++) {
                            $.each(card_id, function (i, value) {
                                card_id_ar.push($(this).val());
                                var id = $(this).val();
                                if (id === response.spesifik[index].kelas_id) {
                                    $("#btn-select" + id).css('display', 'block');
                                    if (response.voucher_type != 'free') {
                                        msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                                    } else {
                                        msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                                    }
                                }

                            });
                        }
                    } else {
                        $.each(card_id, function (i, value) {
                            card_id_ar.push($(this).val());
                            var id = $(this).val();
                            $("#btn-select" + id).css('display', 'block');
                            if (response.voucher_type != 'free') {
                                msg = "Anda mendapat diskon sebesar " + response.discount + "%, silahkan pilih kelas yang ingin diberi potongan";
                            } else {
                                msg = "Anda mendapat diskon sebesar 100%, silahkan pilih kelas yang ingin diberi potongan";
                            }
                        });
                    }
                }

            }



            $('#voucher_msg p').text(msg);
            $('#data_voucher').val(voucher);
            $('#voucher_msg').show();
            $('#voucher_input').hide();
            countAll();
        }
    });
}

function pilih_voucher(id, harga) {
    var sisa = $("#sisa").val();
    var jenis = $("#jenis_voucher").val();
    var potongan = $("#potongan").val();
    var btn_length = $(".btn-unselect").length;
    if (btn_length >= sisa) {
        alert('Anda mencapai batas penggunaan voucher, voucher Anda dibatasi ' + sisa + ' kali pengunaan');
        return false
    }
    if (jenis == 'discount') {
        var diskon = harga * potongan / 100;
    } else {
        var diskon = harga;
    }
    var total_harga = harga - diskon;
    $("#diskon" + id).val(diskon);
    $("#harga_total" + id).val(total_harga);
    $("#voucher" + id).val($("#code_voucher").val());
    $("#text_harga_before" + id).css("text-decoration", "line-through");
    $("#text_harga_after" + id).css("display", "block");
    $("#text_harga_after" + id).text("Rp " + numeral(total_harga).format('0,0'));
    $("#btn-select" + id).removeClass('btn-primary');
    $("#btn-select" + id).addClass('btn-danger');
    $("#btn-select" + id).html('<i class="fa fa-times"></i> &nbsp;&nbsp;&nbsp;&nbsp;Batalkan');
    $("#btn-select" + id).attr("onclick", "unselect_voucher(" + id + "," + harga + ")");
    $("#btn-select" + id).removeClass("btn-select");
    $("#btn-select" + id).addClass("btn-unselect");
    $("#text_potongan" + id).css("display", "block");
    $("#text_potongan" + id).text("Potongan sebesar Rp " + numeral(diskon).format('0,0'));
    countAll();
}

function unselect_voucher(id, harga) {
    $("#diskon" + id).val(0);
    $("#harga_total" + id).val(harga);
    $("#voucher" + id).val('');
    $("#text_harga_before" + id).css("text-decoration", "none");
    $("#text_harga_after" + id).css("display", "none");
    $("#text_harga_after" + id).text("Rp " + numeral(harga).format('0,0'));
    $("#btn-select" + id).removeClass('btn-danger');
    $("#btn-select" + id).addClass('btn-primary');
    $("#btn-select" + id).html('<i class="fa fa-ticket" style="transform: rotate(-45deg);"></i> &nbsp;&nbsp;&nbsp;&nbsp;Gunakan Voucher');
    $("#btn-select" + id).attr("onclick", "pilih_voucher(" + id + "," + harga + ")");
    $("#btn-select" + id).removeClass("btn-unselect");
    $("#btn-select" + id).addClass("btn-select");
    $("#text_potongan" + id).css("display", "none");
    $("#text_potongan" + id).text("");
    countAll();
}

function unset_voucher() {
    var price = $('#harga').val();
    $('#code_voucher').val('');
    $('#voucher_msg').hide();
    $('#voucher_input').show();
    $('#text_diskon').text("- Rp " + 0);
    $('#voucher_name').text("");
    $('#text_diskon_container').slideUp();
    $('#diskon').val(0);
    $('#total').val(price);
    $('#text_total').text("Rp " + numeral(price).format('0,0'));
}

function resend_invoice(email, order_id) {
    $("#btn_resend").text('Sedang mengirim, harap tunggu...');
    $.ajax({
        type: "post",
        url: global_url + "Booking/resend_invoice",
        data: {
            email: email,
            order_id: order_id,
        },
        dataType: "json",
        success: function (response) {
            Swal.fire({
                title: response.msg,
                icon: response.msg_type
            });
            $("#btn_resend").text('Kirim ulang Invoice');
        }
    });
}