<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right">
        <a class="btn btn-link" href="javascript:void(0)" >Edit Kelas ini</a>
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
            <img src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $data->thumbnail ?>">
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="judulKelas">Judul Kelas </label>
                <input type="text" name="judul_kelas" value="<?= $data->judul_kelas ?>" class="form-control" id="judul_kelas" aria-describedby="judulKelas">
            </div>
            <div class="form-group">
                <label >Topik Kelas </label>
                <select class="selectpicker form-control" data-live-search="true" >
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
            </div>
            
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="judulKelas"> Google Form </label>
                <input type="text" name="judul_kelas" value="<?= $data->gform_url ?>" class="form-control" id="judul_kelas" aria-describedby="judulKelas">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Deskripsi</label>
                <textarea class="form-control" placeholder="Masukan deskripsi kelas" name="deskripsi_kelas" rows='3'></textarea>
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
    <div class="row wrap-box-card">
        <div class="col-md-4">
            <div class="form-group">
                <label >Pemateri </label>
                <select class="selectpicker form-control" multiple data-live-search="true" >
                    <?php foreach ($list_pemateri as $keys): ?>
                        <option value="<?= $keys->id ?>" <?= (in_array($keys->id, $data_pemateri)) ? 'selected':''; ?>><?= $keys->nama_pemateri ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label >Tanggal Kelas </label>
                <input type="date" name="tanggal_kelas" value="<?= $data->tgl_kelas ?>" class="form-control" id="tanggal_kelas" aria-describedby="tanggalKelas">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label >Waktu Start </label>
                <input type="time" name="waktu_mulai" value="<?= $data->waktu_mulai ?>" class="form-control" id="waktu_start" aria-describedby="waktuStart">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label >Waktu End </label>
                <input type="time" name="waktu_akhir" value="<?= $data->waktu_akhir ?>" class="form-control" id="waktu_end" aria-describedby="waktuEnd">
            </div>
        </div>
    </div>
    <div class="row wrap-box-card">
        <div class="col-md-4">
            <div class="form-group">
                <label >Limit Transaksi </label>
                <input type="number" name="limit" value="<?= $data->limit ?>" class="form-control" id="limit" aria-describedby="limit">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label >Link Zoom Meeting </label>
                <input type="text" name="link_zoom" value="<?= $data->link_zoom ?>" class="form-control" id="linkzoom" aria-describedby="linkZoom">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label >Link Youtube</label>
                <input type="text" name="youtube" value="<?= $data->youtube ?>" class="form-control" id="linkyoutube" aria-describedby="yT">
            </div>
        </div>
    </div>
</section>
<div class="section-heading">
    <div class="left">
        <h3>Materi & Benefit  </h3>
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
                      <th>Jadwal Materi </th>
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
                              <button class="btn btn-sm btn-info" > <i class="fa fa-trophy"></i> Sertifikat</button>
                              <button class="btn btn-sm btn-success" > <i class="fa fa-play"></i> Rekaman</button>
                              <button class="btn btn-sm btn-secondary" > <i class="fa fa-book"></i> Materi</button>
                              
                          </td>
                      </tr>
                  <?php endforeach ?>
              </tbody>
          </table>
    </div>
</div>