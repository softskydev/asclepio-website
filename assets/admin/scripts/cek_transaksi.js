$(document).ready(function () {
    table_body_tools_only();
	table_loads_manual_transaction();
});

function table_body_tools_only(){

    $('#table_body_tools_only').DataTable({
	    destroy: true,
	    "processing": true,
	    "serverSide": true,
	    ajax: {
	      url: global_url+'Asclepedia/load_data_transaction_tools/'
	    },
	    "columns": [
	      {"name": "b.nama_lengkap"},
	      {"name": "a.kode_transaksi"},
	      {"name": "a.status"},
	      {"name": "a.tgl_pembelian"},
	      {"name": "action","orderable": false,"searchable": false,"className": "text-center"},
	    ],
	    "order": [
	      [0, 'desc']
	    ],
	    "scrollX" : scrollX ,
	    "iDisplayLength": 10,  
	});

}

function table_loads_manual_transaction(){

    $('#table_body').DataTable({
	    destroy: true,
	    "processing": true,
	    "serverSide": true,
	    ajax: {
	      url: global_url+'Asclepedia/load_manual_transaction/'
	    },
	    "columns": [
	      {"name": "b.nama_lengkap"},
	      {"name": "a.kode_transaksi"},
	      {"name": "a.status"},
	      {"name": "a.tgl_pembelian"},
	      {"name": "action","orderable": false,"searchable": false,"className": "text-center"},
	    ],
	    "order": [
	      [0, 'desc']
	    ],
	    "scrollX" : scrollX ,
	    "iDisplayLength": 10,  
	});

}


function load_detail(transaksi_id){
    
    $.ajax({
        type: "GET",
        url: global_url + 'Asclepedia/load_transaksi_detail/'+transaksi_id,
        dataType: "json",
        success: function (response) {
                $("#transaksi_id").val(response.id);
                $("#nama_member").val(response.nama_lengkap);
                $("#nama_kelas").val(response.name);
                $("#kode_pos").val(response.postal_code);
                $("#alamat_lengkap").html(response.address);
        }
    });


}
function set_ongkir(transaksi_id){
    load_detail(transaksi_id);
    $("#addOngkir").modal('show');
}

function liat_detail(id){
	$("#verifyPayment").modal('show');
	$.ajax({
        type: "GET",
        url: global_url + 'Asclepedia/load_transaksi_detail/'+id,
        dataType: "json",
        success: function (response) {
            $("#bukti_transfer").attr('src' , global_url+'assets/uploads/bukti_transfer/'+response.picture_image);
            $("#metode_pembayaran").html(response.metode_pembayaran)
            $("#tagihan_nominal").val(numeral(response.total).format('0,0'));
			$("#acc_button").attr('onclick' , 'processTransaction("'+response.kode_transaksi+'","success")')
			$("#dec_button").attr('onclick' , 'processTransaction("'+response.kode_transaksi+'","fail")')
        }
    });
}

function processTransaction(code , status){

	$.ajax({
		type: "POST",
		url: global_url + 'Booking/manualTransactionProcess/',
		data: {
			status:status,
			code : code,
		},
		dataType: "JSON",
		success: function (response) {
			if(response.payment == 'acc'){
				toastr['success'](response.msg);
			} else {
				toastr['error'](response.msg);
			}
			$("#verifyPayment").modal('hide');
			table_body_tools_only()
 			table_loads_manual_transaction()
		}
	});

}