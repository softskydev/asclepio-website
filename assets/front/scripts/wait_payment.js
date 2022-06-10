$(document).ready(function () {
    $('.countdown__time ul').countdown({
        date: exp,
        offset: +7,
        hour: null,
        hours: null,
        minute: null,
        minutes: null,
        second: null,
        seconds: null

    }, function () {
        window.location.href
    });
});


function cekStatus(code) {
    $.ajax({
        type: "get",
        url: global_url + "wait_payment/",
        data: "data",
        dataType: "dataType",
        success: function (response) {

        }
    });
}

const copyBtn = document.getElementById('copyBtn')
const copyText = document.getElementById('noRek')

copyBtn.onclick = () => {
    copyText.select(); // Selects the text inside the input
    document.execCommand('copy'); // Simply copies the selected text to clipboard
    alert('Kode Berhasil disalin');

}

const copyBtnBiller = document.getElementById('copyBtnBiller')
const copyTextBiller = document.getElementById('biller')

copyBtnBiller.onclick = () => {
    copyTextBiller.select(); // Selects the text inside the input
    document.execCommand('copy'); // Simply copies the selected text to clipboard
    alert('Kode Perusahaan Berhasil disalin');

}

function resend_email(email, order_id) {
    $("#btn_resend").text('Sedang mengirim, harap tunggu...');
    $.ajax({
        type: "post",
        url: global_url + "Booking/resend_email",
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
            $("#btn_resend").text('Kirim ulang Link dan Receipt');
        }
    });
}