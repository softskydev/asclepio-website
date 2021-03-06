
<style>
    #box_upcoming .box-card__img {
        padding-top: 100%;
    }

    #box_upcoming .box-card__img .thumbnail {
        position: absolute;
        top: 0;
    }

    #box_finished .box-card__img {
        padding-top: 100%;
    }

    #box_finished .box-card__img .thumbnail {
        position: absolute;
        top: 0;
    }
</style>
<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right">
        <a class="btn btn-link" href="#addAsclepediaBenefit" data-toggle="modal" data-target="#addAsclepediaBenefit">Tambah Benefit</a>
        <a class="btn btn-primary" href="#addAsclepedia" data-toggle="modal" data-target="#addAsclepedia">Buat Asclepedia</a>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <h3>Upcoming Class</h3>
        <div class="left">
            </div>
        <div class="right">
            <select onchange="getUpcoming()" class="select" id="filter_kategori">
                <option value="semua">Semua Kategori</option>
                <option value="good morning knowledge">Good Morning Knowledge</option>
                <option value="skill labs">Skills Lab</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" type="text" id="search_upcoming" placeholder="Cari kelas" onkeyup="getUpcoming()" />
                </div>
            </div>
        </div>
    </div>
    <div class="row wrap-box-card" id="box_upcoming">
        <!-- <div class="col-md-3">
            <div class="box-card">
                <div class="box-card__img"><img src="<?= base_url() ?>assets/admin/images/img-card-01.png" /></div>
                <div class="box-card__text"><span class="tag">Good morning knowledge</span>
                    <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                    <ul class="schedule">
                        <ul>
                            <li>
                                <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-date.svg" /></div><span>16 Aug 2020</span>
                            </li>
                            <li>
                                <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-time.svg" /></div><span>20:00 - 22:30 WIB</span>
                            </li>
                        </ul>
                    </ul>
                    <div class="author">
                        <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                    </div>
                </div>
                <div class="box-card__footer">
                    <div class="price">Free</div>
                    <div class="action">
                        <div class="dot"><img src="<?= base_url() ?>assets/admin/images/ic-three-dots.svg" /></div>
                        <div class="action-sub">
                            <ul>
                                <li><a href="#">Edit Kelas</a></li>
                                <li class="dlt"><a href="#">Delete Kelas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <h3>Tiket Terusan</h3>
        <div class="left">
            </div>
        <div class="right">
           
            
        </div>
    </div>
    <div class="row wrap-box-card" id="box_tiket_terusan">
        <!-- <div class="col-md-3">
            <div class="box-card">
                <div class="box-card__img"><img src="<?= base_url() ?>assets/admin/images/img-card-01.png" /></div>
                <div class="box-card__text"><span class="tag">Good morning knowledge</span>
                    <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                    <ul class="schedule">
                        <ul>
                            <li>
                                <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-date.svg" /></div><span>16 Aug 2020</span>
                            </li>
                            <li>
                                <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-time.svg" /></div><span>20:00 - 22:30 WIB</span>
                            </li>
                        </ul>
                    </ul>
                    <div class="author">
                        <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                    </div>
                </div>
                <div class="box-card__footer">
                    <div class="price">Free</div>
                    <div class="action">
                        <div class="dot"><img src="<?= base_url() ?>assets/admin/images/ic-three-dots.svg" /></div>
                        <div class="action-sub">
                            <ul>
                                <li><a href="#">Edit Kelas</a></li>
                                <li class="dlt"><a href="#">Delete Kelas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Benefits Class</h3>
        </div>
        <div class="right">
            <select class="select" onchange="sort(this.value)">
                <option value="terbaru">Terbaru</option>
                <option value="terlama">Terlama</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" type="text" placeholder="Cari kelas" id="search_benefit" onkeyup="cari_benefit(this.value)">
                </div>
            </div>
        </div>
    </div>
    <div class="benefits-table">
        <table class="table">
            <thead>
                <tr>
                    <th><span>Benefit untuk kelas</span></th>
                    <th><span>Link Video</span></th>
                    <th><span>Link Materi</span></th>
                    <th><span>Action</span></th>
                </tr>
            </thead>
            <tbody id="table_body">
                <!-- <tr>
                    <td>
                        <p>Siap Tanggapi Trauma Urogenital</p><small>Good Morning Knowledge ??? 20 Agustus 2020</small>
                    </td>
                    <td><a href="https://www.youtube.com/" target="_blank">www.youtube.com</a></td>
                    <td><a href="http://www.google.drive.com/" target="_blank">www.google.drive.com</a></td>
                    <td>
                        <div class="action"><a href="#addAsclepediaBenefit" data-toggle="modal" data-target="#addAsclepediaBenefit"><img src="<?= base_url() ?>assets/admin/images/ic-action-edit.svg" /></a><a href="#"><img src="<?= base_url() ?>assets/admin/images/ic-action-delete.svg" /></a></div>
                    </td>
                </tr> -->
            </tbody>
        </table>
        <div class="pagination-box">
            <div class="pag-list">

            </div>
            <select class="select" onchange="setLimit(this.value)">
                <option value="4">4 items</option>
                <option value="8">8 items</option>
                <option value="12">12 items</option>
            </select>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Finished Class</h3>
        </div>
        <div class="right">
            <select class="select" onchange="getFinished()" id="filter_finished">
                <option value="semua">Semua</option>
                <option value="good morning knowledge">Good Morning Knowledge</option>
                <option value="skill labs">Skill Lab</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" id="search_finished" type="text" placeholder="Cari kelas" onkeyup="getFinished()" />
                </div>
            </div>
        </div>
    </div>
    <div class="row wrap-box-card" id="box_finished">
    </div>

</section>

<div class="modal" id="addAsclepedia" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <form method="post" id="form_add" enctype="multipart/form-data">
                <div class="modal-body" id="box_add">
                    <h3 class="modal-title">Membuat Asclepedia</h3>
                    <a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                    <h4>Informasi Kelas</h4>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <div class="drop-box">
                            <input class="inputfile" id="thumbnail" type="file" name="thumbnail" required />
                            <div class="ic-upload"><img src="<?= base_url() ?>assets/admin/images/ic-upload.svg" /></div>
                            <div class=" box-btn">
                                <label class="btn-add-photo" for="thumbnail">Drag & drop file or <a class='btn-add-photo' for="thumbnail"> browse </a> file here</label><span>files required .png .jpg</span>
                            </div>
                            <div class="image-preview" style="background-size:cover ;background-image: url()"></div><a class="del-btn">Hapus</a>
                        </div>
                    </div>
                    <div class="form-group cstm-btnradio">
                        <label>Kategori</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check-inline col-md-4 mr-0">
                                <input onchange="change_val(this.value)" class="form-check-input " id="optkategori1" type="radio" name="kategori" value="good morning knowledge" checked="" required />
                                <label class="form-check-label min-w-auto w-100 h-100 d-flex align-items-center" for="optkategori1">Good morning knowledge</label>
                            </div>
                            <div class="form-check-inline col-md-4 mr-0">
                                <input onchange="change_val(this.value)" class="form-check-input " id="optkategori2" type="radio" name="kategori" value="skill labs" required />
                                <label class="form-check-label min-w-auto w-100 h-100 d-flex align-items-center" for="optkategori2">Skill Lab</label>
                            </div> 
                            <div class="form-check-inline col-md-4 mr-0">
                                <input onchange="change_val(this.value)" class="form-check-input " id="optkategori3" type="radio" name="kategori" value="drill the case" required />
                                <label class="form-check-label min-w-auto w-100 h-100 d-flex align-items-center" for="optkategori3">Drill the Case</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group cstm-btnradio">
                        <div class="d-flex flex-wrap">
                            <div class="form-check-inline col-md-12 mr-0">
                                <input onchange="change_val(this.value)" class="form-check-input " id="optkategori4" type="radio" name="kategori" value="tiket terusan" required />
                                <label class="form-check-label min-w-auto w-100 h-100 d-flex align-items-center" for="optkategori4">Tiket terusan</label>
                            </div>
                            
                        </div>
                    </div>
                    <div id="hideWhenTiketTerusan">
                    <div class="form-group" id="link_gform">
                        <label>Link Google Form</label>
                        <input type="text" class="form-control" value="" name="gform">
                    </div>
                    <div class="form-group">
                        <label for="">Banyak Pertemuan / Sekali Pertemuan </label>
                        
                        <div class="radiobutton" style="margin-left: 20px;">
                            <input id="val_sekali" type="radio" checked value="sekali_pertemuan" name="tipe_kelas_sekali_or_banyak" class="form-check-input">
                            <label class="form-check-label" for="val_sekali">Sekali Pertemuan</label>
                            <input id="val_banyak" type="radio" value="banyak_pertemuan" name="tipe_kelas_sekali_or_banyak" class="form-check-input"> 
                            <label for="val_banyak" class="form-check-label"> Banyak Pertemuan</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Apakah Sertifikat SKP IDI </label>
                        
                        <div class="radiobutton" style="margin-left: 20px;">
                            <input id="skp_idi" type="radio" checked value="1" name="skp_idi" class="form-check-input">
                            <label class="form-check-label" for="skp_idi"> Ber Sertifikat SKP - IDI </label>
                            <input id="non_skp_idi" type="radio" value="0" name="skp_idi" class="form-check-input"> 
                            <label for="non_skp_idi" class="form-check-label"> Non SKP - IDI</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Topik Kelas</label>
                        <select class="select" data-live-search="true" data-size="5" id="topik" name="topik" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul webinar</label>
                        <input class="form-control" type="text" value="" name="judul_kelas" maxlength="50" placeholder="Masukan judul webinar" required />
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" rows="4" placeholder="Masukan deskripsi kelas" name="deskripsi_kelas" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Pemateri </label>
                        <select class="select" id="select_pemateri" name="pemateri[]" multiple="multiple" required>
                            <?php
                            $pemateri = $this->query->get_data_simple('pemateri', ['is_delete' => 0])->result();
                            foreach ($pemateri as $p) { ?>
                                <option value="<?= $p->id ?>"><?= $p->nama_pemateri ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group tgl hide_when_banyak">
                        <label>Tanggal</label>
                        <div class="row">
                            <div class="col-3">
                                <select class="select" name="date">
                                    <?php $max_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ?>
                                    <?php for ($i = 1; $i <= $max_date; $i++) { ?>
                                        <option <?= ($i == date('d')) ? 'selected' : ''  ?> value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" name="month">

                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option <?= ($i == date('m')) ? 'selected' : ''  ?> value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" name="year">

                                    <?php for ($i = 2000; $i <= date('Y') + 1; $i++) { ?>
                                        <option <?= ($i == date('Y')) ? 'selected' : ''  ?> value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group waktu hide_when_banyak">
                        <div class="row">
                            <div class="col-4">
                                <label>Waktu Mulai</label>
                                <input type="time" class="form-control" name="waktu_mulai" >
                            </div>
                            <div class="col-4">
                                <label>Waktu Selesai</label>
                                <input type="time" class="form-control" name="waktu_akhir" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Limit Transaksi </label>
                        <input type="number" name="limit" class="form-control">
                    </div>
                    <div class="form-group" id="box_early">
                        <label>Early Bird - Harga Webinar</label>
                        <input autocomplete='off' class="form-control daterange" data-date-format="dd/mm/yy" name="date_early" type="text" />
                        <br>
                        <input class="form-control" id="early_price" name="early_price" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukan harga early bird" value="0" /><small>*input harga hanya angka, Contoh 200:000</small>
                    </div>
                    <div class="form-group" id="box_late">
                        <label>Late Bird - Harga Webinar</label>
                        <input autocomplete='off' class="form-control daterange" data-date-format="dd/mm/yy" name="date_late" type="text" />
                        <br>
                        <input class="form-control" id="late_price" name="late_price" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukan harga late bird" value="0" /><small>*input harga hanya angka, Contoh 200:000</small>
                    </div>
                    <div class="form-group" id="box_tool_price">
                        <label>Harga Bundling</label>
                        <input class="form-control" type="text" value="0"  id="tools_price" onkeyup="onchange_num(this.id,this.value)" name="harga_tools" placeholder="Masukan Harga Tools" required />
                        <small>Kosongkan bila tidak ada bundling tools</small>
                    </div>
                    <div class="form-group hide_when_banyak">
                        <label>Link Zoom Meeting</label>
                        <input class="form-control" type="text" name="link_zoom" placeholder="Masukan link zoom meeting"  />
                    </div>
                    <div class="form-group hide_when_banyak">
                        <label>Link Youtube</label>
                        <input class="form-control" type="text" name="youtube" placeholder="Masukan link youtube" />
                    </div>
                    <!-- <h4>Tambah member gratis</h4>
                    <p>Berikut adalah form untuk menambah member yang akan mendapatkan fitur gratis kelas ini.</p>
                    <div class="form-group">

                        <select class="select form-control" title="Pilih Member" multiple="multiple" name="free_member[]" data-live-search="true" data-size="8">
                            <?php
                            $query = $this->query->get_data_simple('user', null)->result();
                            foreach ($query as $d) { ?>
                                <option value="<?= $d->id ?>"><?= $d->nama_lengkap ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <hr /> -->
                    <h4>Materi yang akan dibahas</h4>
                    <div class="box-form-materi">
                        <h4>Pertemuan 1</h4>
                        <div class="form-group">
                            <label>Judul Pertemuan</label>
                            <input class="form-control" type="text" value="" name="judul_materi[]" placeholder="Masukan judul materi" />
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control deskripsi_materi" rows="4" placeholder="Masukan deskripsi materi" name="deskripsi_materi[]" required></textarea>
                        </div>
                        <div class="form-group show_on_banyak">
                            <label>Link Zoom </label>
                            <input class="form-control" type="text" value="" name="link_materi[]" placeholder="Tuliskan Link Zoom untuk Materi ini" />
                        </div>
                        <div class="form-group show_on_banyak">
                            <label>Tanggal Pertemuan </label>
                            <input class="form-control" type="date" value="" name="tanggal_materi[]" placeholder="Masukan Tanggal Materi" />
                        </div>
                        <div class="form-group show_on_banyak">
                            <label>Waktu Pertemuan </label>
                            <input class="form-control" type="time" value="" name="time_materi[]"  />
                        </div>
                        <div class="form-group waktu">
                            <div class="row">
                                <div class="col-3">
                                    <label>Durasi</label>
                                    <select class="select" name="durasi_materi[]">
                                        <option value="60">60 menit</option>
                                        <option value="90">90 menit</option>
                                        <option value="120">120 menit</option>
                                        <option value="180">180 menit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_materi">

                    </div>
                    <div class="addmore">
                        <a href="#" id="add_materi">
                            <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-plus-more.svg" /></div><span>Tambah Materi</span>
                        </a>
                    </div>
                    </div> <!-- for tiket terusan -->
                    <div id="showWhenTiketTerusan">
                        <div class="form-group">
                            <label>Judul Tiket Terusan</label>
                            <input class="form-control" id="judul_tiket_terusan " type="text" value="" name="judul_tiket_terusan" maxlength="50" placeholder="Juni Jago Pediatri" />
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" rows="4" placeholder="Masukan deskripsi TIket Terusan" name="desc_tiket_terusan" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">List Kelas</label>
                            <div class="list_">
                                <label class="text-danger">Tidak Ada Kelas</label>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label>Kelas Asclepedia  </label>
                            <select class="select" id="select_kelas" data-live-search="true" name="kelas_id[]" multiple="multiple" >
                                <?php
                                foreach ($kelas_terusan as $p) { ?>
                                    <option data-price='<?= $p['price'] ?>' value="<?= $p['id'] ?>"><?= $p['judul'] ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                       
                        <div class="form-group" >
                            <label>Total Harga Seharusnya</label>
                            <input class="form-control" name="price_actual" id="grandTotalPrice" reaedonly/>
                        </div>
                        <div class="form-group" >
                            <label>Harga Tiket Terusan</label>
                            <input class="form-control" id="tiket_terusan_price" name="tiket_terusan_price" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukkan Harga Tiket Terusan" value="0" />
                            <small>*input harga hanya angka, Contoh 200:000</small>
                        </div>
                    </div>

                    <div class="form-action text-right">
                        <a class="btn btn-link" href="javascript:void(0)" data-dismiss="modal">Cancel</a>
                        <button class="btn btn-primary" type="submit">Simpan Kelas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modalEditTIketTerusan" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--lg" id="modal_dlg">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?= base_url() .'Asclepedia/editTiketTerusan' ?>" enctype="multipart/form-data" method="POST">
                <a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title">
                     <h3> Tiket Terusan : <span id="titleTiketTerusan"></span></h3>
                     <input type="hidden" name="tiket_terusan_id" id="idTT">
                </div>
                <div class="form-group">
                    <img src="" style="height:420px;width:620px;" id="editImgTT" alt="">    
                    <br>
                    <br>
                    <input class="form-control" type="file" id="imageTT" name="thumbnail" >
                </div>
                <div class="form-group">
                    <label>Judul Tiket Terusan</label>
                    <input class="form-control" id="editTitleTT" type="text" value="" name="judul_tiket_terusan" maxlength="50" placeholder="Juni Jago Pediatri" required />
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" id="editDescTT" rows="4" placeholder="Masukan deskripsi TIket Terusan" name="desc_tiket_terusan" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">List Kelas</label>
                    <div class="list_kelas">
                        
                    </div>
                    
                </div>
                <div class="form-group">
                    <label>Kelas Asclepedia  </label>
                    <select class="select" id="editKelasTT" data-live-search="true" name="kelas_id[]" multiple="multiple" >
                        
                    </select>
                </div>
                <div class="form-group" >
                    <label>Total Harga Semua</label>
                    <input class="form-control" id="totalPriceTT" name="price_actual" style="text-decoration:line-through"  type="text" readonly />
                </div>
                <div class="form-group" >
                    <label>Harga Tiket Terusan</label>
                    <input class="form-control" id="editPriceTT" name="tiket_terusan_price" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukkan Harga Tiket Terusan" value="0" />
                    <small>*input harga hanya angka, Contoh 200.000</small>
                </div>
                
            </div>
            <div class="modal-footer">
                <div class="form-action text-right">
                    <a class="btn btn-link" href="#" data-dismiss="modal">Batal</a>
                    <button class="btn btn-primary" type="submit">Update Tiket Terusan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="addAsclepediaBenefit" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--lg" id="modal_dlg">
        <div class="modal-content">
            <div class="modal-body"><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title">
                    <h3>Pilih Kelas</h3>
                    <p>Pilih kelas untuk tambah benefit ke kelas yang sudah selesai</p>
                </div>
                <div class="modal-searchfilter">
                    <div class="search-box">
                        <div class="search">
                            <input id="search_unbenefit" onkeyup="getUnbenefit()" class="form-control" type="text" placeholder="Search" />
                        </div>
                    </div>
                    <div class="select-box">
                        <select class="select" id="filter_unbenefit" onchange="getUnbenefit()">
                            <option value="terbaru">Terbaru</option>
                            <option value="terlama">Terlama</option>
                        </select>
                    </div>
                </div>
                <div class="wrap-box-card listview" id="box_unbenefit">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="editBenefitLinkVideo" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--lg">
        <div class="modal-content">
            <div class="modal-body"><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title w-back"><a class="ic-back" href="#addAsclepediaBenefit" data-toggle="modal" data-dismiss="modal"><img src="<?= base_url() ?>assets/admin/images/ic-arrow-left.svg" /></a>
                    <h3>Benefit</h3>
                    <p>Tambah benefit ke kelas yang sudah selesai</p>
                </div>
                <div class="wrap-box-card listview" id="box_detail">
                    <h4>Kelas yang dipilih</h4>
                </div>
                <div class="wrap-addlink">
                    <h4>Tambahkan Link</h4>
                    <form action="<?= base_url() ?>Asclepedia/edit_benefit" method="post">
                        <input type="hidden" id="id_kelas" name="id_kelas">
                        <div class="form-group">
                            <label>Link Video Rekaman <small>Masukkan kode video dari youtube. Dan jika lebih dari 1, pisahkan dengan koma tanpa spasi</small></label>
                            <input class="form-control" type="text" name="link_rekaman" id="link_rekaman" placeholder="Masukan link video" />
                        </div>
                        <div class="form-group">
                            <label>Link materi <small>Masukkan link dan pisahkan dengan koma tanpa spasi</small></label>
                            <input class="form-control" type="text" name="link_materi" id="link_materi" placeholder="Masukan link materi" />
                        </div>
                        <div class="form-group">
                            <label>Link Sertifikat</label>
                            <input class="form-control" type="text" name="link_sertifikat" id="link_sertifikat" placeholder="Masukan link sertifikat" />
                        </div>
                        <div class="form-group">
                            <label>Password Materi</label>
                            <input class="form-control" type="text" name="password_materi" id="password_materi" placeholder="Masukan Password materi" />
                        </div>
                        <div class="form-action text-right">
                            <a class="btn btn-link" href="#" data-dismiss="modal">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
