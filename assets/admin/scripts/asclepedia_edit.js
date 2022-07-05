$(document).ready(function($) {
  $("#materi_tbl").DataTable();
	var today = new Date();
	$('.daterange').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        }
    });
    $(".do-readonly").attr('readonly', true);
    $(".do-disabled").attr('disabled' , true);
    checkTipeKelas();
});

function addMateri(){
	$("#addMateri").modal('show');
}

$("input[name='tipe_kelas_sekali_or_banyak']").change(function() {
    if (this.value == 'sekali_pertemuan') {
         $(".hide_when_banyak").show();
         $(".show_on_banyak").hide();
    }
    else if (this.value == 'banyak_pertemuan') {
         $(".hide_when_banyak").hide();
         $(".show_on_banyak").show();
    }
});

function checkTipeKelas(){

  if ($("input[name='tipe_kelas_sekali_or_banyak']:checked").val() == 'sekali_pertemuan') {
         $(".hide_when_banyak").show();
         $(".show_on_banyak").hide();
  }
  else if ($("input[name='tipe_kelas_sekali_or_banyak']:checked").val() == 'banyak_pertemuan') {
       $(".hide_when_banyak").hide();
       $(".show_on_banyak").show();
  }
}

function editButton(){
	$(".form-control").attr('readonly', false);
	$("#btnEdit").hide()
	
	$("#btnSave").show()
	$("#btnCancel").show()
  $(".do-disabled").attr('disabled' , false); 
}

function cancelButton(){
	$(".form-control").attr('readonly', true);
	$("#btnSave").hide()
	$("#btnCancel").hide()
	$("#btnEdit").show()
  $(".do-disabled").attr('disabled' , true);
}

$("#status_unpublish").change(function(event) {
  /* Act on the event */
  if ($("#status_unpublish").is(':checked')) {
    $("#publish-status").text('Sudah terpublish');
  } else {
    $("#publish-status").text('Tidak Terpublish');
  }
});

image_upload.onchange = evt => {
  const [file] = image_upload.files
  if (file) {
    image_upload_preview.src = URL.createObjectURL(file)
  }
}

function savethisClass(){


  // var doctors = [];

  // console.log($("#pemateri_doctor").val());

  var fd                          = new FormData();
  var foto_kelas                  = $("#image_upload")[0].files;
  var judul_kelas                 = $("#judul_kelas").val();
  var kategori_kelas              = $("input[name='kategori_kelas']:checked").val();
  var deskripsi_kelas             = $("textarea[name='deskripsi_kelas']").val();
  var tipe_kelas_sekali_or_banyak = $("input[name='tipe_kelas_sekali_or_banyak']:checked").val();
  // var pemateri_doctor             = $("#pemateri_doctor").val();
  $('#pemateri_doctor option').each(function(i) {
      if (this.selected == true) {
        // console.log(this.value);
          fd.append('pemateri_edit[]', this.value);
      }
  });
  var limit                       = $("#limit").val();
  var linkzoom                    = $("#linkzoom").val();
  var linkyoutube                 = $("#linkyoutube").val();
  var daterange_early             = $("#daterange_early").val();
  var price_early                 = $("#price_early").val();
  var daterange_late              = $("#daterange_late").val();
  var price_late                  = $("#price_late").val();
  var kelas_id                    = $("#kelas_id").val();
  var price_tools                 = $("#tools_price").val();
 
  fd.append('foto_kelas', foto_kelas[0]);
  fd.append('judul_kelas', judul_kelas);
  fd.append('kategori_kelas', kategori_kelas);
  fd.append('deskripsi_kelas', deskripsi_kelas);
  fd.append('price_tools', price_tools);
  fd.append('tipe_kelas_sekali_or_banyak', tipe_kelas_sekali_or_banyak);
 
  fd.append('linkzoom', linkzoom);
  fd.append('linkyoutube', linkyoutube);
  fd.append('daterange_early', daterange_early);
  fd.append('price_early', price_early);
  fd.append('daterange_late', daterange_late);
  fd.append('price_late', price_late);
  fd.append('limit', limit);
  if ($("input[name='tipe_kelas_sekali_or_banyak']:checked").val() == 'sekali_pertemuan') {
    fd.append('tanggal_kelas', $("#tanggal_kelas").val());
    fd.append('waktu_start', $("#waktu_start").val());
    fd.append('waktu_end', $("#waktu_end").val());
  }
   if ($("#status_unpublish").is(':checked')) {
     fd.append('status_publish', '1');
  } else {
     fd.append('status_publish', '0');
  }


  $.ajax({
    url: global_url+'Asclepedia/do_edit/'+kelas_id,
    method: 'POST',
    contentType: false,
    processData: false,
    dataType: 'json',
    data: fd,
    success:function(response){
      if (response.status == 200){
        toastr['success'](response.msg);
        setTimeout(() => {window.location.reload()}, 2500);
      } else {
        toastr['error'](response.msg);
      }
    }
  });
  
}

function addCourse(course_id){
  $("#editBenefit").modal('show');
  $("#materi_id").val(course_id);
  $.ajax({
    url: global_url + 'Asclepedia/course_detail/'+course_id,
    type: 'GET',
    dataType: 'json',
    success:function(response){
      if (response.status == 200 ) {
        $("#link_materi_rekaman").val(response.data.link_materi_rekaman);
        $("#video_materi").val(response.data.link_materi_youtube);
        $("#password_materi").val(response.data.password_materi);
      }
    }
  });
}

function deleteRecord(kelas_id , materi_id ){
  
  $.ajax({
    url: global_url+ "Asclepedia/delete_only_course/",
    method: "POST",
    data: {
      kelas_id:kelas_id,
      materi_id:materi_id,
    },
    dataType: "json",
    success: function (response) {
      if(response.status == 200){
        toastr['error'](response.msg);
        setTimeout(() => {window.location.reload()}, 2500);
      }
    }
  });

}

function editRecord(course_id){
  $("#editMateri").modal('show');
  $("#materi_id_edit").val(course_id);
  $.ajax({
    url: global_url + 'Asclepedia/course_detail/'+course_id,
    type: 'GET',
    dataType: 'json',
    success:function(response){
      if (response.status == 200 ) {
        $("#judul_materi_edit").val(response.data.judul_materi);
        $("#deskripsi_materi_edit").val(response.data.deskripsi_materi);
        $("#link_materi_edit").val(response.data.zoom_materi);
        $("#tanggal_materi_edit").val(response.data.date_materi);
        $("#time_materi_edit").val(response.data.hour_materi);
        $("#durasi_materi_edit").val(response.data.durasi_materi);
        $("#durasi_materi_edit").selectpicker("refresh");
      }
    }
  });
}

function saveCourse(){
  var course_id = $("#materi_id").val();
  $.ajax({
    url: global_url + 'Asclepedia/save_course_link/'+course_id,
    type: 'POST',
    data : {
      link_materi_rekaman : $("#link_materi_rekaman").val(),
      link_materi_youtube : $("#video_materi").val(),
      password_materi : $("#password_materi").val(),
    },
    dataType: 'json',
    success:function(response){
      if (response.status == 200 ) {
        toastr['success'](response.msg);
        $("#editBenefit").modal('hide');
      } else {
        toastr['error'](response.msg);
      }
    }
  });
}