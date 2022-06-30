$('#form-bundling').submit(function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Yakin?',
        text: "Apakah alamat dan nomor telfon sudah benar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
            $(this).unbind('submit').submit()
        }
    })
})
