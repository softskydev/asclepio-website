function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin menghapus data ini?',
        text: "data yang sudah dihapus tidak dapat dipulihkan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: global_url + "Pemateri/delete/" + id,
                type: "POST",
                dataType: "json",
                success: function (response) {
                    Swal.fire(
                        response.msg,
                        '',
                        response.msg_type
                    )
                    window.location.reload();
                }
            });
        }
    })
}

function do_edit(pemateri_id) {



    $.ajax({
        url: global_url + 'Pemateri/do_edit/' + pemateri_id,
        type: 'POST',
        dataType: 'json',
        success: function (resp) {
            console.log(resp);

            // alert(resp.row.nama_pemateri);
            $("#editPemateri").modal('show');
            $("#image_edit").attr('src', global_url + 'assets/uploads/pemateri/' + resp.row.foto);
            $("#form_edit").attr('action', global_url + 'Pemateri/save_pemateri/' + pemateri_id);
            $("#nama_pemateri_edit").val(resp.row.nama_pemateri);
            $("#speciality").val(resp.row.spesialis);
            $("#speciality").selectpicker('refresh');
        }
    });


}

photo_upload.onchange = evt => {
    const [file] = photo_upload.files
    if (file) {
        image_edit.src = URL.createObjectURL(file)
    }
}