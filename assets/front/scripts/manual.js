function makeTransactionManual(){
    var bank           = $("#nama_bank").val();
        namarekening   = $("#rekening_bank").val();
        norekening     = $("#norek_bca").val();
        fd             = new FormData();
        bukti_pay      = $("#image_bukti")[0].files;
        kode_transaksi = $("#kode_transaksi").val();

        console.log(bukti_pay);
        // alert(bukti_pay.length);

    if(bank == '' || bukti_pay.length == 0 ||  norekening == '' || namarekening== '' ){
        
        Swal.fire(
            'Warning!',
            'Form Tidak boleh Kosong',
            'error'
        );

    } else {
    
        fd.append('manual_no_rekening', norekening );
        fd.append('manual_nama_rekening', namarekening);
        fd.append('manual_nama_bank', bank);
        fd.append('bukti_tf', bukti_pay[0]);

        $.ajax({
            url        : global_url+'Booking/manualTransaction/'+kode_transaksi,
            method     : 'POST',
            contentType: false,
            processData: false,
            dataType   : 'json',
            data       : fd,
            success:function(response){
              if (response.status == 200){
                Swal.fire(
                     'Success',
                      response.msg,
                     'success'
                );
                setTimeout(() => { window.location.reload()}, 2500);
                window.location.href=response.redirected_url;
              } else {
                Swal.fire(
                   'Error',
                    response.msg,
                   'error'
                );
              }
            }
        });
    }

}


