$(document).ready(function () {
    table_body_tools_only();
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