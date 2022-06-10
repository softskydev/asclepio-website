<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right"><a class="btn btn-primary" href="#addPemateri" data-toggle="modal" data-target="#addPemateri">Tambah Pemateri</a></div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Semua pemateri</h3>
        </div>
        <div class="right"></div>
    </div>
    <div class="row wrap-box-card cards-pemateri">
        <?php
        foreach ($data as $d) { ?>
            <div class="col-md-3">
                <div class="box-card card-pemateri">
                    <div class="box-card__photo"><img src="<?= base_url() ?>assets/uploads/pemateri/<?= $d->foto ?>" /></div>
                    <div class="box-card__namepos">
                        <h4><a href="#"><?= $d->nama_pemateri ?></a></h4>
                        <div class="pos"><span><?= $d->spesialis ?></span></div>
                    </div>
                    <div class="action">
                        <div class="dot"><img src="<?= base_url() ?>assets/admin/images/ic-three-dots.svg" /></div>
                        <div class="action-sub">
                            <ul>
                                <li><a href="javascript:void()" onclick="do_edit(<?= $d->id ?>)">Edit</a></li>
                                <li class="dlt"><a href="#" onclick="confirmDelete(<?= $d->id ?>)">Remove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div class="modal" id="addPemateri" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Menambahkan Pemateri</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <form action="<?= base_url() ?>Pemateri/save_pemateri" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload-pp">
                                <div class="drop-box">
                                    <div style="margin:40px 0px 0px 30px" class="image-preview"></div>
                                    <input class="inputfile" id="photo" type="file" name="foto" required />
                                    <div class="box-btn">
                                        <label class="btn-add-photo" for="photo">Unggah Profile</label>
                                    </div><a class="del-btn"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Pemateri</label>
                                <input class="form-control" type="text" value="" placeholder="Masukan nama pemateri" name="nama_pemateri" required />
                            </div>
                            <div class="form-group">
                                <label>Spesialisasi</label>
                                <select class="select" name="spesialis" required>
                                    <option value="Dokter Spesialis Anak / Pediatri">Dokter Spesialis Anak / Pediatri</option>
                                    <option value="Dokter Spesialis Obstetri dan Ginekologi">Dokter Spesialis Obstetri dan Ginekologi</option>
                                    <option value="Dokter Spesialis Orthopaedi dan Traumatologi">Dokter Spesialis Orthopaedi dan Traumatologi</option>
                                    <option value="Dokter Spesialis Anestesi dan Reanimasi">Dokter Spesialis Anestesi dan Reanimasi</option>
                                    <option value="Dokter Spesialis Kulit dan Kelamin / Dermatovenerologi">Dokter Spesialis Kulit dan Kelamin / Dermatovenerologi</option>
                                    <option value="Dokter Spesialis Bedah Umum">Dokter Spesialis Bedah Umum</option>
                                    <option value="Dokter Spesialis Bedah Plastik Rekonstruksi dan Estetik">Dokter Spesialis Bedah Plastik Rekonstruksi dan Estetik</option>
                                    <option value="Dokter Spesialis Bedah Thoraks Kardiovaskular">Dokter Spesialis Bedah Thoraks Kardiovaskular</option>
                                    <option value="Dokter Spesialis Penyakit Dalam">Dokter Spesialis Penyakit Dalam</option>
                                    <option value="Dokter Spesialis Mata">Dokter Spesialis Mata</option>
                                    <option value="Dokter Spesialis THT-KL">Dokter Spesialis THT-KL</option>
                                    <option value="Dokter Spesialis Okupasi Klinik">Dokter Spesialis Okupasi Klinik</option>
                                    <option value="Dokter Spesialis Kedokteran Olahraga">Dokter Spesialis Kedokteran Olahraga</option>
                                    <option value="Dokter Spesialis Rehabilitasi Medik">Dokter Spesialis Rehabilitasi Medik</option>
                                    <option value="Dokter Spesialis Urologi">Dokter Spesialis Urologi</option>
                                    <option value="Dokter Spesialis Paru">Dokter Spesialis Paru</option>
                                    <option value="Dokter Spesialis Radiologi">Dokter Spesialis Radiologi</option>
                                    <option value="Dokter Spesialis Mikrobiologi Klinik">Dokter Spesialis Mikrobiologi Klinik</option>
                                    <option value="Dokter Spesialis Patologi Klinik">Dokter Spesialis Patologi Klinik</option>
                                    <option value="Dokter Spesialis Patologi Anatomi">Dokter Spesialis Patologi Anatomi</option>
                                    <option value="Dokter Spesialis Neurologi">Dokter Spesialis Neurologi</option>
                                    <option value="Dokter Spesialis Kedokteran Jiwa">Dokter Spesialis Kedokteran Jiwa</option>
                                    <option value="Dokter Spesialis Jantung dan Pembuluh Darah">Dokter Spesialis Jantung dan Pembuluh Darah</option>
                                    <option value="Dokter Spesialis Forensik dan Medikolegal">Dokter Spesialis Forensik dan Medikolegal</option>
                                    <option value="Dokter Spesialis Bedah Saraf">Dokter Spesialis Bedah Saraf</option>
                                    <option value="Dokter Spesialis Farmakologi Klinik">Dokter Spesialis Farmakologi Klinik</option>
                                    <option value="Dokter Spesialis Onkologi Radiasi">Dokter Spesialis Onkologi Radiasi</option>
                                    <option value="Dokter Spesialis Kedokteran Penerbangan">Dokter Spesialis Kedokteran Penerbangan</option>
                                    <option value="Dokter Spesialis Gizi Klinik">Dokter Spesialis Gizi Klinik</option>
                                    <option value="Dokter Spesialis Parasitologi Klinik">Dokter Spesialis Parasitologi Klinik</option>
                                    <option value="Dokter Spesialis Akupuntur Medik">Dokter Spesialis Akupuntur Medik</option>
                                    <option value="Aesthetics">Aesthetics</option>
                                    <option value="TOEFL Class">TOEFL Class</option>
                                    <option value="Topik Umum">Topik Umum</option>
                                    <option value="Scientific Class">Scientific Class</option>
                                    <option value="Tutor Asclepio">Tutor Asclepio</option>
                                </select>
                            </div>
                            <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Batal</a><button class="btn btn-primary" type="submit">Simpan</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editPemateri" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Edit Pemateri</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <form action="<?= base_url() ?>Pemateri/save_pemateri" id="form_edit" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload-pp">
                                <img style="margin:40px 0px 0px 30px;width: 94px;height: 94px;" class="image-preview" id="image_edit">
                                <div class="drop-box">

                                    <input class="inputfile" id="photo_upload" type="file" name="foto" />
                                    <div class="box-btn">
                                        <label class="btn-add-photo" for="photo">Unggah Profile</label>
                                    </div><a class="del-btn"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Pemateri</label>
                                <input class="form-control" type="text" value="" id="nama_pemateri_edit" placeholder="Masukan nama pemateri" name="nama_pemateri" required />
                            </div>
                            <div class="form-group">
                                <label>Spesialisasi</label>
                                <select class="select" name="spesialis" id="speciality" required>
                                    <option value="Dokter Spesialis Anak / Pediatri">Dokter Spesialis Anak / Pediatri</option>
                                    <option value="Dokter Spesialis Obstetri dan Ginekologi">Dokter Spesialis Obstetri dan Ginekologi</option>
                                    <option value="Dokter Spesialis Orthopaedi dan Traumatologi">Dokter Spesialis Orthopaedi dan Traumatologi</option>
                                    <option value="Dokter Spesialis Anestesi dan Reanimasi">Dokter Spesialis Anestesi dan Reanimasi</option>
                                    <option value="Dokter Spesialis Kulit dan Kelamin / Dermatovenerologi">Dokter Spesialis Kulit dan Kelamin / Dermatovenerologi</option>
                                    <option value="Dokter Spesialis Bedah Umum">Dokter Spesialis Bedah Umum</option>
                                    <option value="Dokter Spesialis Bedah Plastik Rekonstruksi dan Estetik">Dokter Spesialis Bedah Plastik Rekonstruksi dan Estetik</option>
                                    <option value="Dokter Spesialis Bedah Thoraks Kardiovaskular">Dokter Spesialis Bedah Thoraks Kardiovaskular</option>
                                    <option value="Dokter Spesialis Penyakit Dalam">Dokter Spesialis Penyakit Dalam</option>
                                    <option value="Dokter Spesialis Mata">Dokter Spesialis Mata</option>
                                    <option value="Dokter Spesialis THT-KL">Dokter Spesialis THT-KL</option>
                                    <option value="Dokter Spesialis Okupasi Klinik">Dokter Spesialis Okupasi Klinik</option>
                                    <option value="Dokter Spesialis Kedokteran Olahraga">Dokter Spesialis Kedokteran Olahraga</option>
                                    <option value="Dokter Spesialis Rehabilitasi Medik">Dokter Spesialis Rehabilitasi Medik</option>
                                    <option value="Dokter Spesialis Urologi">Dokter Spesialis Urologi</option>
                                    <option value="Dokter Spesialis Paru">Dokter Spesialis Paru</option>
                                    <option value="Dokter Spesialis Radiologi">Dokter Spesialis Radiologi</option>
                                    <option value="Dokter Spesialis Mikrobiologi Klinik">Dokter Spesialis Mikrobiologi Klinik</option>
                                    <option value="Dokter Spesialis Patologi Klinik">Dokter Spesialis Patologi Klinik</option>
                                    <option value="Dokter Spesialis Patologi Anatomi">Dokter Spesialis Patologi Anatomi</option>
                                    <option value="Dokter Spesialis Neurologi">Dokter Spesialis Neurologi</option>
                                    <option value="Dokter Spesialis Kedokteran Jiwa">Dokter Spesialis Kedokteran Jiwa</option>
                                    <option value="Dokter Spesialis Jantung dan Pembuluh Darah">Dokter Spesialis Jantung dan Pembuluh Darah</option>
                                    <option value="Dokter Spesialis Forensik dan Medikolegal">Dokter Spesialis Forensik dan Medikolegal</option>
                                    <option value="Dokter Spesialis Bedah Saraf">Dokter Spesialis Bedah Saraf</option>
                                    <option value="Dokter Spesialis Farmakologi Klinik">Dokter Spesialis Farmakologi Klinik</option>
                                    <option value="Dokter Spesialis Onkologi Radiasi">Dokter Spesialis Onkologi Radiasi</option>
                                    <option value="Dokter Spesialis Kedokteran Penerbangan">Dokter Spesialis Kedokteran Penerbangan</option>
                                    <option value="Dokter Spesialis Gizi Klinik">Dokter Spesialis Gizi Klinik</option>
                                    <option value="Dokter Spesialis Parasitologi Klinik">Dokter Spesialis Parasitologi Klinik</option>
                                    <option value="Dokter Spesialis Akupuntur Medik">Dokter Spesialis Akupuntur Medik</option>
                                    <option value="Aesthetics">Aesthetics</option>
                                    <option value="TOEFL Class">TOEFL Class</option>
                                    <option value="Topik Umum">Topik Umum</option>
                                    <option value="Scientific Class">Scientific Class</option>
                                    <option value="Tutor Asclepio">Tutor Asclepio</option>
                                </select>
                            </div>

                            <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Batal</a><button class="btn btn-primary" type="submit">Simpan</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>