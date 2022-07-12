function addCartTerusan(user, id) {
    if (user == '') {
        window.location.href = global_url + 'login';
    } else {
        $.ajax({
            type: "post",
            url: global_url + "Booking/addCartTerusan",
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
                        }
                    })
    
                }
    
            }
        });
    }
    

}