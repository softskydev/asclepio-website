<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<section class="page-heading">
    <div class="left">
        <h2><?= ucwords($title) ?></h2>
    </div>
    <div class="right">
        <button class="btn btn-sm btn-info" > <i class="fa fa-trophy"></i> Sertifikat</button>
        <a id="btnEdit" onclick="editButton()" class="btn btn-link" href="javascript:void(0)" >Edit Kelas ini</a>
        <a id="btnSave" style="display:none;" class="btn btn-link" href="javascript:void(0)" onclick="savethisClass()" >Simpan </a>
        <a id="btnCancel" onclick="cancelButton()" style="display:none;" class="btn btn-link" href="javascript:void(0)" >Cancel </a>
        <!-- <a class="btn btn-primary" href="#addAsclepedia" data-toggle="modal" data-target="#addAsclepedia"></a> -->
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Detail Kelas </h3>
        </div>
        <div class="right">
            <!-- <select onchange="getUpcoming()" class="select" id="filter_kategori">
                <option value="semua">Semua Kategori</option>
                <option value="good morning knowledge">Good Morning Knowledge</option>
                <option value="skill labs">Skills Lab</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" type="text" id="search_upcoming" placeholder="Cari kelas" onkeyup="getUpcoming()" />
                </div>
            </div> -->
        </div>
    </div>
    <div class="row wrap-box-card">
        <div class="col-md-4">
            <img id="image_upload_preview" src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $data->thumbnail ?>">
            <br>
            <input type="file" name="cover_kelas"  id="image_upload"  class="form-control do-disabled" >
            <input type="hidden" id="kelas_id" name="kelas_id" value="<?= $data->id ?>">
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="judulKelas">Judul Kelas </label>
                <input type="text" name="judul_kelas" value="<?= $data->judul_kelas ?>" class="form-control do-readonly" id="judul_kelas" aria-describedby="judulKelas">
            </div>
            <div class="form-group">
                <label >Topik Kelas </label>
                <select class="selectpicker form-control do-disabled" id="topik_id" data-live-search="true" >
                    <?php foreach ($topik as $keys): ?>
                        <option value="<?= $keys->id ?>" <?= ($keys->id == $data->topik_id ) ? 'selected':''; ?>><?= $keys->nama_topik ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label >Kategori Kelas </label>
                <div class="form-check">
                  <input class="form-check-input" id="gmk" type="radio" name="kategori_kelas" value="good morning knowledge" <?= $data->kategori_kelas == 'good morning knowledge' ? 'checked' : '';?>>
                  <label class="form-check-label" for="gmk">
                    Good Morning Knowledge
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" id="sl" type="radio" name="kategori_kelas" value="skill labs" <?= $data->kategori_kelas == 'skill labs' ? 'checked' : '';?>>
                  <label class="form-check-label" for="sl">
                    Skill Lab
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" id="dtc" type="radio" name="kategori_kelas" value="drill the case" <?= $data->kategori_kelas == 'drill the case' ? 'checked' : '';?>>
                  <label class="form-check-label" for="dtc">
                    Drill the Case
                  </label>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> Status Publish </label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" disabled class="do-disabled custom-control-input" value="1" id="status_unpublish" <?= $data->in_public == 1 ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="status_unpublish"> <span id="publish-status"><?= $data->in_public == 1 ? 'Sudah terpublish' : 'Tidak Terpublish'; ?></span></label>
                </div>
            </div>

            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea class="form-control do-readonly" placeholder="Masukan deskripsi kelas" name="deskripsi_kelas" rows='6'><?= $data->deskripsi_kelas ?></textarea>
            </div>
            <!-- <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button> -->
            <div class="form-group">
                <label >Tipe Pertemuan </label>
                 <div class="form-check">
                  <input class="form-check-input" id="exampleRadios1" type="radio" name="tipe_kelas_sekali_or_banyak" value="sekali_pertemuan" <?= $data->tipe_kelas == 'sekali_pertemuan' ? 'checked' : '';?>>
                  <label class="form-check-label" for="exampleRadios1">
                    Sekali Pertemuan
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" id="exampleRadios2" type="radio" name="tipe_kelas_sekali_or_banyak" value="banyak_pertemuan" <?= $data->tipe_kelas == 'banyak_pertemuan' ? 'checked' : '';?>>
                  <label class="form-check-label" for="exampleRadios2">
                    Banyak Pertemuan
                  </label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row wrap-box-card">
        <div class="col-md-4">
            <div class="form-group">
                <label >Pemateri </label>
                <select class="selectpicker form-control do-disabled" multiple data-live-search="true" name="pemateri[]" id="pemateri_doctor" >
                    <?php foreach ($list_pemateri as $keys): ?>
                        <option value="<?= $keys->id ?>" <?= (in_array($keys->id, $data_pemateri)) ? 'selected':''; ?>><?= $keys->nama_pemateri ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group hide_when_banyak">
                <label >Tanggal Kelas </label>
                <input type="date" name="tanggal_kelas" value="<?= $data->tgl_kelas ?>" class="form-control do-readonly" id="tanggal_kelas" aria-describedby="tanggalKelas">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group hide_when_banyak">
                <label >Waktu Start </label>
                <input type="time" name="waktu_mulai" value="<?= $data->waktu_mulai ?>" class="form-control do-readonly" id="waktu_start" aria-describedby="waktuStart">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group hide_when_banyak">
                <label >Waktu End </label>
                <input type="time" name="waktu_akhir" value="<?= $data->waktu_akhir ?>" class="form-control do-readonly" id="waktu_end" aria-describedby="waktuEnd">
            </div>
        </div>
    </div>
    <div class="row wrap-box-card">
        <div class="col-md-4">
            <div class="form-group">
                <label >Limit Transaksi </label>
                <input type="number" name="limit" value="<?= $data->limit ?>" class="form-control do-readonly" id="limit" aria-describedby="limit">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label >Link Zoom Meeting </label>
                <input type="text" name="link_zoom" value="<?= $data->link_zoom ?>" class="form-control do-readonly" id="linkzoom" aria-describedby="linkZoom">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label >Link Youtube</label>
                <input type="text" name="youtube" value="<?= $data->youtube ?>" class="form-control do-readonly" id="linkyoutube" aria-describedby="yT">
            </div>
        </div>
    </div>
    <div class="row wrap-box-card">
        <div class="col-md-3">
            <div class="form-group">
                <label >Setup Daterange Early</label>
                <input type="text" name="date_early" value="<?= $data->early_daterange ?>" class="form-control do-readonly daterange" id="daterange_early" aria-describedby="daterange_early">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label >Early Bird </label>
                <input type="text" name="price_early" onkeyup="onchange_num(this.id,this.value)" value="<?= number_format($data->late_price) ?>" class="form-control do-readonly" id="price_early" aria-describedby="linkZoom">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label >Setup Daterange Late</label>
                <input type="text" name="date_late" value="<?= $data->late_daterange ?>" class="form-control do-readonly daterange" id="daterange_late" aria-describedby="daterange_late">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label >Late Bird</label>
                <input type="text" name="price_late" onkeyup="onchange_num(this.id,this.value)" value="<?= number_format($data->early_price) ?>" class="form-control do-readonly" id="price_late" aria-describedby="limit">
            </div>
        </div>
    </div>
    <div class="row wrap-box-card">
        <div class="col-md-3">
            <div class="form-group">
                <label >Harga Tools</label>
                <input type="text" onkeyup="onchange_num(this.id,this.value)" name="tools_price" value="<?= number_format($data->tools_price) ?>" class="form-control do-readonly" id="tools_price" aria-describedby="tools_price">
            </div>
        </div>
    </div>
</section>
<div class="section-heading">
    <div class="left">
        <h3>Materi & Benefit  </h3>
    </div>
    <div class="right">
        <button class="btn btn-small btn-warning" onclick="addMateri()"> <i class="fa fa-plus"></i> &nbsp;Materi Baru</button>
    </div>
</div>
<div class="row wrap-box-card">
    <div class="col-md-12">
          <table class="table table-bordered table-hovered" id="materi_tbl">
              <thead>
                  <tr>
                      <th>No </th>
                      <th>Materi </th>
                      <th>Deskripsi </th>
                      <th>Link Materi</th>
                      <th width="30%">Jadwal Materi </th>
                      <th>Benefit Action </th>
                  </tr>
              </thead>
              <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($materi as $key): ?>
                      <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $key->judul_materi ?></td>
                          <td><?= $key->deskripsi_materi ?></td>
                          <td><?= $key->zoom_materi ?></td>
                          <td><?= set_date($key->date_materi) . '<br>'.$key->hour_materi. ' ('.$key->durasi_materi.' Menit)'  ?></td>
                          <td>
                              
                             
                              <button title="Benefit Materi & Rekaman" style="border-radius: 10px;" class=" btn-sm btn-secondary" onclick="addCourse(<?= $key->id ?>)"> <i class="fa fa-book"></i> </button>
                              
                              <button title="Edit Materi ini" style="border-radius: 10px;" class=" btn-sm btn-warning" onclick="editRecord(<?= $key->id ?>)" > <i class="fa fa-edit"></i> </button>
                              
                              <button title="Hapus Materi ini"style="border-radius: 10px;" class=" btn-sm btn-danger" onclick="deleteRecord(<?= $data->id ?> , <?= $key->id ?>)" > <i class="fa fa-trash"></i></button>
                              
                              
                          </td>
                      </tr>
                  <?php endforeach ?>
              </tbody>
          </table>
    </div>
</div>
    
<div class="modal fade bd-example-modal-lg" id="addMateri" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="<?= base_url() ?>Asclepedia/save_only_course/" method="POST">
        <div class="modal-header">
            <h5 class="modal-title"> Materi Baru  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="box-form-materi">
            <input type="hidden" name="kelas_id" value="<?= $data->id ?>">
            <div class="form-group">
                <label>Judul materi</label>
                <input class="form-control" id="judul_materi"  type="text" value="" name="judul_materi" placeholder="Masukan judul materi" />
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" id="deskripsi_materi" rows="4" placeholder="Masukan deskripsi materi" name="deskripsi_materi" required></textarea>
            </div>
            <div class="form-group show_on_banyak">
                <label>Link Materi </label>
                <input class="form-control" id="link_materi" type="text" value="" name="link_materi" placeholder="Tuliskan Link Zoom untuk Materi ini" />
            </div>
            <div class="form-group show_on_banyak">
                <label>Tanggal Materi </label>
                <input class="form-control" id="tanggal_materi" type="date" value="" name="tanggal_materi" placeholder="Masukan Tanggal Materi" />
            </div>
            <div class="form-group show_on_banyak">
                <label>Waktu Materi </label>
                <input class="form-control" id="time_materi" type="time" value="" name="time_materi"  />
            </div>
            <div class="form-group waktu">
                <div class="row">
                    <div class="col-3">
                        <label>Durasi</label>
                        <select class="select" id="durasi_materi" name="durasi_materi">
                            <option value="60">60 menit</option>
                            <option value="90">90 menit</option>
                            <option value="120">120 menit</option>
                            <option value="180">180 menit</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="editMateri" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="<?= base_url() ?>Asclepedia/save_only_course/"  method="POST">
        <div class="modal-header">
            <h5 class="modal-title"> Update Materi   </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="box-form-materi">
            <div class="form-group">
                <label>Judul materi</label>
                <input type="hidden" id="materi_id_edit" name="materi_id">
                <input class="form-control" id="judul_materi_edit"  type="text" value="" name="judul_materi" placeholder="Masukan judul materi" />
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" id="deskripsi_materi_edit" rows="4" placeholder="Masukan deskripsi materi" name="deskripsi_materi" required></textarea>
            </div>
            <div class="form-group show_on_banyak">
                <label>Link Materi </label>
                <input class="form-control" id="link_materi_edit" type="text" value="" name="link_materi" placeholder="Tuliskan Link Zoom untuk Materi ini" />
            </div>
            <div class="form-group show_on_banyak">
                <label>Tanggal Materi </label>
                <input class="form-control" id="tanggal_materi_edit" type="date" value="" name="tanggal_materi" placeholder="Masukan Tanggal Materi" />
            </div>
            <div class="form-group show_on_banyak">
                <label>Waktu Materi </label>
                <input class="form-control" id="time_materi_edit" type="time" value="" name="time_materi"  />
            </div>
            <div class="form-group waktu">
                <div class="row">
                    <div class="col-3">
                        <label>Durasi</label>
                        <select class="select" id="durasi_materi_edit" name="durasi_materi">
                            <option value="60">60 menit</option>
                            <option value="90">90 menit</option>
                            <option value="120">120 menit</option>
                            <option value="180">180 menit</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
  </div>
</div>

<!--  -->

<div class="modal fade bd-example-modal-lg" id="editBenefit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="#" method="POST">
        <div class="modal-header">
            <h5 class="modal-title"> Update Rekaman dan Materi  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="box-form-materi">
            <input type="hidden" id="materi_id" name="">
            <div class="form-group">
                <label>Link Download Materi</label>
                <input class="form-control" id="link_materi_rekaman"  type="text" value="" placeholder="Masukan Link materi" />
            </div>
            <div class="form-group">
                <label>Password Materi</label>
                <input class="form-control" id="password_materi"  type="text" value="" placeholder="Masukan Password Materi" />
            </div>
            <div class="form-group">
                <label>Video Materi (Youtube)</label>
                <input class="form-control" id="video_materi"  type="text" value="" placeholder="Masukan Link Video Materi" />
            </div>
    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="saveCourse()">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
  </div>
</div>