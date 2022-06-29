<div class="class-detail">
    <section class="section class-detail__banner">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="class-detail__thumbnail"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $data->jenis_kelas ?>/<?= $data->thumbnail ?>" /></div>
                </div>
                <div class="col-md-7">
                    <div class="class-detail__banner-content">
                        <?php
                        $date = $data->public_date;
                        $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));
                        $tipe_kelas = $data->tipe_kelas;
                        if ($new_date > date('Y-m-d')) {
                            $new_price = $data->early_price;
                        } else {
                            $new_price = $data->late_price;
                        }
                        if ($new_price == 0) {
                            $harga = 'FREE';
                        } else {
                            $harga = 'Rp.' . rupiah($new_price);
                        }

                        if ($data->jenis_kelas == 'asclepedia') {
                            $kategori = $data->kategori_kelas;
                            if ($kategori == 'good morning knowledge') {
                                $label = '<span class="tag tag">Good Morning Knowledge</span>';
                            } else if($kategori == 'drill the case'){
                                $label = '<span class="tag tag">Drill the Case</span>';
                            } else {
                                $label = '<span class="tag tag-scndry">Skills Lab</span>';
                            } 
                        } else {
                            $kategori = $data->kategori_go;
                            if ($kategori == 'open') {
                                if ($new_price == 0) {
                                    $tag = 'FREE';
                                } else {
                                    $tag = 'PREMIUM';
                                }
                                $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                            } else {
                                $label = '<span class="tag tag-expert">Expert Class</span>';
                            }
                        }
                        ?>
                        <div class="class-type"><span><?= $label ?></span></div>
                        <div class="class-title">
                            <h1><?= $data->judul_kelas ?></h1>
                        </div>
                        <div class="class-pricerate">
                            <div class="class-rating">
                                <?php
                                $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $data->id")->row()->rating;
                                if ($rating == '') {
                                    $rating = 0;
                                } else {
                                    $rating = $rating;
                                }
                                echo start_created($rating) . ' ' . '<div class="mt-3"><span class="btn btn-success btn-small">' . $rating . ' / 5 <small>Dari seluruh ulasan Asclepian</small></span></div>';
                                ?>
                            </div>
                            <div class="class-price mt-5"><b><?= $harga ?></b></div>
                        </div>
                        <div class="class-btnwrap">
                            <?php
                            $cek_status = $this->query->get_query("SELECT t.* FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id WHERE d.`product_id` = $data->id AND t.`user_id` = '" . $this->session->userdata('id') . "'")->row();
                            if ($cek_status) {
                                echo 'Kamu sudah terdaftar di kelas ini, <a class="link-primary" href="' . base_url() . 'profile/tiket">Lihat Tiket</a>';
                            } else {
                                if ($data->jenis_kelas == 'asclepedia') {
                                    // if ($kategori == 'good morning knowledge') {
                                    //     echo '<a href="' . $data->gform_url . '" target="_blank" class="btn btn-primary">Daftar</a>';
                                    // } else {

                                    // }
                                    echo '<button class="btn btn-primary" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $data->id . ')">Daftar</button>';
                                } else {
                                    if ($kategori == 'open') {
                                        if ($new_price == 0) {
                                            echo '<a href="' . $data->gform_url . '" target="_blank" class="btn btn-primary">Daftar</a>';
                                        } else {
                                            echo '<button class="btn btn-primary" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $data->id . ')">Daftar</button>';
                                        }

                                        // echo '<button class="btn btn-primary" onclick="addToCart(' . $this->session->userdata('id') . ',' . $data->id . ')">Daftar</button>';
                                    } else {
                                        echo '<a href="https://wa.me/6281370225009?text=Saya tertarik dengan kelas ini ' . current_url() . '" target="_blank" class="btn text-white" style="background:#25d366;">Whatsapp</a>';
                                    }
                                }
                            }

                            ?>
                            <!-- <button class="btn btn-primary" onclick="addToCart('<?= $this->session->userdata('id') ?>',<?= $data->id ?>)">Book Class</button> -->
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
                            <p>Link zoom meeting akan dikirim melalui email mu setelah kamu menyelesaikan pemesanan webinar.</p>
                            <p><?= $data->deskripsi_kelas ?></p>
                            <!-- <a class="btn-link" href="#">Baca lebih</a> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="right">
                            <h4>Tutor Piyo</h4>
                            <div class="presenter">
                                <?php
                                $pemateri = $this->query->get_query("SELECT kp.id,p.nama_pemateri,p.spesialis,p.foto FROM pemateri p JOIN kelas_pemateri kp ON kp.pemateri_id = p.id WHERE kp.kelas_id = $data->id ORDER BY kp.id ASC")->result();
                                foreach ($pemateri as $p) { ?>
                                    <div class="presenter-item">
                                        <div class="pp"><img src="<?= base_url() ?>assets/uploads/pemateri/<?= $p->foto ?>" /></div>
                                        <div class="text">
                                            <label><?= $p->nama_pemateri ?></label><span><?= $p->spesialis ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- <div class="presenter-item">
                                    <div class="pp"><img src="<?= base_url() ?>assets/front/images/pemateri-2.png" /></div>
                                    <div class="text">
                                        <label>Dr. Sasa Tsabita Murtiono</label><span>Dokter Spesialis Gigi</span>
                                    </div>
                                </div> -->
                            </div>
                            <div class="timeplace">
                                <h4>Waktu & Tempat</h4>
                                <ul>
                                    <li>
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-tp-location.svg" /></div><span>Zoom Meeting</span>
                                    </li>
                                    
                                        <?php 
                                            if ($tipe_kelas == 'banyak_pertemuan') {
                                                $jadwal = $this->query->get_query("select * from kelas_materi where kelas_id = ".$data->id)->result();
                                                foreach ($jadwal as $tgl) { 
                                                    ?>
                                                    <li>
                                                        <div class="ic">
                                                            <img src="<?= base_url() ?>assets/front/images/ic-tp-date.svg" />
                                                        </div>
                                                        <span><?= format_indo($tgl->date_materi) ?> - <?= substr($tgl->hour_materi,0,-3); ?></span>
                                                    </li>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <li>
                                                    <div class="ic">
                                                        <img src="<?= base_url() ?>assets/front/images/ic-tp-date.svg" />
                                                    </div>
                                                    <span><?= format_indo($data->tgl_kelas) ?></span>
                                                </li>
                                                <?php
                                            }
                                            
                                         ?>
                                        
                                       
                                        
                                    
                                    <li>
                                        <?php 
                                        if ($tipe_kelas == 'banyak_pertemuan') {

                                        } else {
                                            ?>
                                            <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-tp-date.svg" /></div><span><?= $data->waktu_mulai ?> - <?= $data->waktu_akhir ?> WIB</span>
                                            <?php
                                        }
                                        ?>
                                        
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
                <h3>Materi yang akan dibahas?</h3>
            </div>
            <div class="rundown__wrap">
                <?php
                $no = 1;
                $materi = $this->query->get_query("SELECT * FROM kelas_materi WHERE kelas_id = $data->id ORDER BY id ASC")->result();
                foreach ($materi as $m) { ?>
                    <div class="rundown__item">
                        <div class="rundown__item-title">
                            <h4><?= $no++ ?>. <?= $m->judul_materi ?></h4>
                            <div class="duration">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-time.svg" /></div><span><?= $m->durasi_materi ?> menit</span>
                            </div>
                        </div>
                        <div class="rundown__item-text">
                            <p><?= $m->deskripsi_materi ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section section__rating">
        <div class="container">
            <div class="section__heading">
                <h3>Ulasan Asclepian</h3>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="rate-box">
                        <div class="rate"><b><?= $rating ?><small>/5</small></b></div>
                        <div class="rate-img"><?= start_created($rating) ?></div>
                        <div class="rate-total"><span><?= $this->query->get_query("SELECT COUNT(id) as total FROM ulasan WHERE kelas_id = $data->id")->row()->total ?> review</span></div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="rate-card__list">
                        <?php
                        $query = $this->db->query("SELECT u.nama_lengkap,r.rating,r.ulasan,r.date FROM ulasan r JOIN `user` u ON r.`user_id` = u.`id` WHERE r.`kelas_id` = $data->id ORDER BY r.`date` DESC");
                        if ($query->num_rows() == 0) {
                            echo 'Belum ada ulasan';
                        } else {
                            $this->load->helper('date');
                            $review = $query->result();

                            foreach ($review as $r) {
                                $post_date = strtotime($r->date);
                                $now = time();
                                $units = 1;
                                $newtime = timespan($post_date, $now, $units);


                        ?>
                                <div class="rate-card">
                                    <div class="rate-img"><?= start_created($r->rating) ?></div>
                                    <div class="rate-text">
                                        <p><?= $r->ulasan ?></p>
                                    </div>
                                    <div class="rate-writer"><b><?= $r->nama_lengkap ?></b>
                                        <div class="time"><?= $newtime ?></div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <!-- <div class="btn-wrap"><a class="see-more" href="#">Muat lebih banyak</a></div> -->
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Kelas yang disarankan</h3>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <?php
                $querys = "SELECT * FROM kelas WHERE id != '$data->id'";
                if ($data->topik_id != null) {
                    $querys .= "AND topik_id = $data->topik_id";
                }
                $querys .= " AND tgl_kelas > CURDATE() AND is_delete = 0 AND in_public = 1";
                $saran = $this->query->get_query($querys)->result();
                foreach ($saran as $s) {
                    $date = $s->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $s->early_price;
                    } else {
                        $new_price = $s->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }
                    if ($s->jenis_kelas == 'asclepedia') {
                        $jenis_kelas = 'asclepedia';
                        if ($s->kategori_kelas == 'good morning knowledge') {
                            $label = '<span class="tag tag">Good Morning Knowledge</span>';
                        } else {
                            $label = '<span class="tag tag-scndry">Skills Lab</span>';
                        }
                    } else {
                        $jenis_kelas = 'asclepiogo';
                        if ($s->kategori_go == 'open') {
                            if ($new_price == 0) {
                                $tag = 'FREE';
                            } else {
                                $tag = 'PREMIUM';
                            }
                            $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                        } else if ($s->kategori_go == 'expert') {
                            $label = '<span class="tag tag-expert">Expert Class</span>';
                        } else {
                            $label = '<span class="tag tag-private">Private Class</span>';
                        }
                    }

                ?>
                    <div class="col-md-3 slider__item">
                        <div class="box-card">
                            <a href="<?= base_url() ?><?= $jenis_kelas ?>/<?= $s->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $s->jenis_kelas ?>/<?= $s->thumbnail ?>" class="thumbnail" />
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $s->id")->row()->rating;
                                        if ($rating == '') {
                                            $rating = 0;
                                        } else {
                                            $rating = $rating;
                                        }
                                        ?>
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                    </div>
                                </div>
                                <div class="box-card__text"><?= $label ?>
                                    <h4><?= $s->judul_kelas ?></h4>
                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $s->id")->result();
                                        if (count($pemateri) > 1) {
                                            foreach ($pemateri as $p) {
                                                echo '<div class="pp"><img src="' . base_url() . 'assets/uploads/pemateri/' . $p->foto . '" /></div>';
                                            }
                                        } else {
                                            foreach ($pemateri as $p) {
                                                echo '<div class="pp"><img src="' . base_url() . 'assets/uploads/pemateri/' . $p->foto . '" /></div><span>' . $p->nama_pemateri . '</span>';
                                            }
                                        }
                                        ?>
                                        <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
                                    </div>
                                </div>
                            </a>
                            
                            <div class="box-card__footer">
                                <div class="price"><?= $harga ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>