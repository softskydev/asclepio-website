<div class="class-detail">
    <section class="section class-detail__banner">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="class-detail__thumbnail"><img src="<?= base_url() ?>assets/uploads/kelas_terusan/<?= $data->image ?>" /></div>
                </div>
                <div class="col-md-7">
                    <div class="class-detail__banner-content">
                        
                        <div class="class-type"><span> Kelas Terusan </span></div>
                        <div class="class-title">
                            <h1><?= $data->judul_kelas_terusan ?></h1>
                        </div>
                        <div class="class-pricerate">
                        <div class="class-price" style="text-decoration-line: line-through;color:red"><b>Rp <?= number_format($data->price_actual) ?></b></div>
                        <div class="class-price "><b>Rp <?= number_format($data->price_kelas_terusan) ?></b></div>
                        </div>
                        <div class="class-btnwrap">
                            <button class="btn btn-primary" onclick="addCartTerusan('<?= $this->session->userdata('id') ?>' ,  <?= $data->id ?>)">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section class-detail__info">
        <div class="container">
            <div class="section__heading">
                <h3>Informasi Kelas</h3>
            </div>
            <div class="detail-info__wrap">
                <div class="row">
                    <div class="col-md-7">
                        <div class="left">
                            <h4>Deskripsi Kelas</h4>
                            <p><?= $data->deskripsi_tiket_terusan ?></p>
                            <!-- <a class="btn-link" href="#">Baca lebih</a> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="right">
                            
                            <div class="timeplace">
                                <h4>Waktu & Tempat</h4>
                                <ul>
                                    <li>
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-tp-location.svg" /></div><span>Zoom Meeting</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section class-detail__rundown">
        <div class="container">
            <div class="section__heading">
                <h3>Daftar Kelas </h3>
            </div>
            <div class="rundown__wrap">
                <?php
                $no = 1;
                $kelas = $this->query->get_query("SELECT a.* , b.judul_kelas , b.deskripsi_kelas FROM kelas_terusan_detail a join kelas b on a.kelas_id = b.id  
                WHERE a.kelas_terusan_id  = $data->id ORDER BY id ASC")->result();
                foreach ($kelas as $m) { ?>
                    <div class="rundown__item">
                        <div class="rundown__item-title">
                            <h4><?= $no++ ?>. <?= $m->judul_kelas ?></h4>
                            <!-- <div class="duration">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-time.svg" /></div><span><?= $m->durasi_materi ?> menit</span>
                            </div> -->
                        </div>
                        <div class="rundown__item-text">
                            <p><?= $m->deskripsi_kelas ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    
    
</div>