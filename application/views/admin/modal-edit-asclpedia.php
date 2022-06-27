<div class="modal" id="editAsclepedia" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <form action="<?= base_url()  ?>Asclepedia/do_edit" method="post" id="form_edit" enctype="multipart/form-data">
                <div class="modal-body" id="box_add">
                    <h3 class="modal-title">Edit Asclepedia</h3>
                    <a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                    <h4>Informasi Kelas</h4>

                    <div class="form-group">
                        <label>Thumbnail</label>
                        <img src="" id="existing_image" style="height:auto;width: 50%;">
                    </div>

                    <div class="form-group">
                        <label>Edit Thumbnail</label>
                        <small> Kosongkan bila tidak ingin mengupdate thumbnail </small>
                        <div class="drop-box">
                            <input class="inputfile" id="thumbnail_edit" type="file" name="thumbnail_edit" />
                            <div class="ic-upload"><img src="<?= base_url() ?>assets/admin/images/ic-upload.svg" /></div>
                            <div class=" box-btn">
                                <label class="btn-add-photo" for="thumbnail">Drag & drop file or <a class='btn-add-photo' for="thumbnail"> browse </a> file here</label><span>files required .png .jpg</span>
                            </div>
                            <div class="image-preview" style="background-size:cover ;background-image: url()"></div><a class="del-btn">Hapus</a>
                        </div>
                    </div>


                    <input type="hidden" id="kelas_id" name="kelas_id">
                    <div class="form-group cstm-btnradio">
                        <label>Kategori</label>
                        <div class="form-check-inline">
                            <input onchange="change_val(this.value)" class="form-check-input " id="kat_gmk" type="radio" name="kategori_edit" value="good morning knowledge" checked="" required />
                            <label class="form-check-label" for="kat_gmk">Good morning knowledge</label>
                        </div>
                        <div class="form-check-inline">
                            <input onchange="change_val(this.value)" class="form-check-input " id="kat_sl" type="radio" name="kategori_edit" value="skill labs" required />
                            <label class="form-check-label" for="kat_sl">Skill Lab</label>
                        </div>
                    </div>
                    <div class="form-group" id="link_gform_edit">
                        <label>Link Google Form</label>
                        <input type="text" id="link_gform_edit" class="form-control" value="" name="gform_edit">
                    </div>
                    <div class="form-group">
                        <label>Topik Kelas</label>
                        <select class="select" id="topik_edit" data-live-search="true" data-size="5" name="topik_edit" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul webinar</label>
                        <input class="form-control" id="judul_kelas_edit" type="text" maxlength="50" value="" name="judul_kelas_edit" placeholder="Masukan judul webinar" required />
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_kelas_edit" rows="4" placeholder="Masukan deskripsi kelas" name="deskripsi_kelas_edit" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Pemateri </label>
                        <select class="select" id="select_pemateri_edit" multiple name="pemateri_edit[]" required>

                        </select>
                    </div>
                    <div class="form-group tgl">
                        <label>Tanggal</label>
                        <div class="row">
                            <div class="col-3">
                                <select class="select" id="date" name="date_edit" required>
                                    <?php $max_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ?>
                                    <?php for ($i = 1; $i <= $max_date; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" id="month" name="month_edit" required>

                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" id="year" name="year_edit" required>

                                    <?php for ($i = 2000; $i <= date('Y') + 1; $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group waktu">
                        <div class="row">
                            <div class="col-4">
                                <label>Waktu Mulai</label>
                                <input type="time" id="time_start" class="form-control" name="waktu_mulai_edit" required>
                            </div>
                            <div class="col-4">
                                <label>Waktu Selesai</label>
                                <input type="time" id="time_end" class="form-control" name="waktu_akhir_edit" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Limit Transaksi </label>
                        <input type="number" name="limit_edit" id="limit_edit" class="form-control">
                    </div>
                    <div class="form-group" id="box_early_edit">
                        <label>Early Bird - Harga Webinar</label>
                        <input class="form-control" id="early_price_edit" name="early_price_edit" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukan harga early bird" /><small>*input harga hanya angka, Contoh 200:000</small>
                    </div>
                    <div class="form-group" id="box_late_edit">
                        <label>Late Bird - Harga Webinar</label>
                        <input class="form-control" id="late_price_edit" name="late_price_edit" onkeyup="onchange_num(this.id,this.value)" type="text" placeholder="Masukan harga late bird" /><small>*input harga hanya angka, Contoh 200:000</small>
                    </div>
                    <!-- <div class="form-group">
                        <label>Harga webinar</label>
                        <input class="form-control" type="text" name="harga" placeholder="Masukan angka harga" required /><small>*input harga hanya angka, Contoh 200:000</small>
                    </div> -->
                    <div class="form-group">
                        <label>Link Zoom Meeting</label>
                        <input class="form-control" id="link_zoom_edit" type="text" name="link_zoom_edit" placeholder="Masukan link zoom meeting" required />
                        <small><a href="" id="link_log_edit" target="_blank">Lihat history link zoom</a></small>
                    </div>
                    <div class="form-group">
                        <label>Link Youtube</label>
                        <input class="form-control" id="youtube_edit" type="text" name="youtube_edit" placeholder="Masukan link youtube" />
                    </div>
                    <h4>Tambah member gratis</h4>
                    <p>Berikut adalah form untuk menambah member yang akan mendapatkan fitur gratis kelas ini.</p>
                    <div class="form-group">
                        <select class="select select-wphoto" title="Pilih Member" id="x_member_gratis" multiple="multiple" name="free_member_edit[]" data-live-search="true" data-size="8">
                        </select>
                    </div>
                    <hr />
                    <!-- <h4>Materi yang akan dibahas</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Durasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_materi">
                            </tbody>
                        </table>
                    </div> -->
                    <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Cancel</a><button class="btn btn-primary" type="submit">Simpan</button> <button class="btn btn-primary" type="submit" formaction="<?= base_url()  ?>Asclepedia/do_edit/1" formmethod="post" formenctype="multipart/form-data">Simpan dan Publish Kelas</button></div>
                </div>
            </form>
        </div>
    </div>
</div>