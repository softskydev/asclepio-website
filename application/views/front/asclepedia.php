
<div class="asclepedia">
    <section class="banner__small">
        <div class="aksen aksen-1" style="bottom: -38px;left: 0;"><img src="<?= base_url() ?>assets/front/images/aksen-banner-asclepedia1.svg" />
        </div>
        <div class="aksen aksen-2" style="bottom: -27px;right: 0;"><img src="<?= base_url() ?>assets/front/images/aksen-banner-faq-1.svg" /></div>
        <div class="container">
            <div class="banner__small-content">
                <h2><img src="<?= base_url() ?>assets/front/images/aped.png" style="height: 100px;display:inline" alt=""></h2>
                <div><?= $caption->desc_asclepedia ?></div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Asclepedia Terpopuler</h3>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <?php
                foreach ($onrating as $or) {
                    $new_price = 0;
                    if ( $or->early_daterange != null) {
                        $early_daterange     = $or->early_daterange;
                        $early_date1         = explode(' - ', $early_daterange)[0];
                        $early_date2         = explode(' - ', $early_daterange)[1];
                        $early_convert_date1 = date('Y-m-d', strtotime($early_date1));
                        $early_convert_date2 = date('Y-m-d', strtotime($early_date2));
                        if ((date('Y-m-d') >= $early_convert_date1) && (date('Y-m-d') <= $early_convert_date2)) {
                            $new_price = $or->early_price;
                        }else {
                            $new_price = $or->late_price;
                        }
                    } 
                    $label = '<span class="tag tag-scndry">'.ucwords($or->kategori_kelas).'</span>';
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }
                    if ($or->tipe_kelas == 'sekali_pertemuan') {
                        $today_time = strtotime(date("Y-m-d H:i"));
                        // $expire_time = strtotime("-1 day", strtotime($or->tgl_kelas));
                        $expire_time = strtotime($or->tgl_kelas . ' ' . $or->waktu_mulai);
                        $date = $or->public_date;
                        $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));
                        $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $or->id")->row();
                        if ($or->kategori_kelas == 'good morning knowledge') {
                           
                            if ($expire_time <= $today_time) {
                                $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                $button = '';
                            } else {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
                            }
                        } else {
                            
                            if ($harga == '?') {
                                 $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Pendaftaran belum dibuka</div></div>";
                                 $button = '';
                            } else {
                                if ($expire_time <= $today_time) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    if ($or->limit != 0) {
                                        if ($cek_transaksi->total >= $or->limit) {
                                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                            $button = '';
                                        } else {
                                            $ribbon = '';
                                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
                                        }
                                    } else {
                                        $ribbon = '';
                                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
                                    }
                                }
                            }
                            
                         }
                     } else {
                        $ribbon = '';
                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
                        
                     }

                ?>
                    <div class="col-lg-3 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?><?= $or->jenis_kelas ?>/<?= $or->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $or->jenis_kelas ?>/<?= $or->thumbnail ?>" class="thumbnail" />
                                    <div class="position-absolute" style="left: 14px;bottom:10px">
                                        <img src="<?= base_url()?>assets/idi-logo.png" style="width:30px"  alt="">
                                    </div>
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $or->id")->row()->rating;
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
                                    <h4><?= $or->judul_kelas ?></h4>
                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $or->id")->result();
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
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section" id="good_morning">
        <div class="container">
            <div class="section__heading">
                <h3>Asclepedia : Good morning knowledge</h3>
            </div>
            <div class="row wrap-box-card">
                <?php
                foreach ($morning as $morning_knowledge) {
                    $new_price = 0;
                    if ( $morning_knowledge->early_daterange != '') {
                        $early_daterange     = $morning_knowledge->early_daterange;
                        $early_date1         = explode(' - ', $early_daterange)[0];
                        $early_date2         = explode(' - ', $early_daterange)[1];
                        $early_convert_date1 = date('Y-m-d', strtotime($early_date1));
                        $early_convert_date2 = date('Y-m-d', strtotime($early_date2));
                        if ((date('Y-m-d') >= $early_convert_date1) && (date('Y-m-d') <= $early_convert_date2)) {
                            $new_price = $morning_knowledge->early_price;
                        }else {
                            $new_price = $morning_knowledge->late_price;
                        }
                    }
                    $label = '<span class="tag tag-scndry">'.ucwords($morning_knowledge->kategori_kelas).'</span>';
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }
                    if ($morning_knowledge->tipe_kelas == 'sekali_pertemuan') {
                        $today_time     = strtotime(date("Y-m-d H:i"));
                        // $expire_time = strtotime("-1 day", strtotime($m->tgl_kelas));
                        $expire_time    = strtotime($morning_knowledge->tgl_kelas . ' ' . $morning_knowledge->waktu_mulai);
                        $date           = $morning_knowledge->public_date;
                        $new_date       = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                
                        

                        // if ($new_date > date('Y-m-d')) {
                        //     $new_price = $morning_knowledge->early_price;
                        // } else {
                        //     $new_price = $morning_knowledge->late_price;
                        // }
                        

                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $morning_knowledge->id . ')">Daftar</button>';
                        }
                    } else {
                         $ribbon = '';
                         $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $morning_knowledge->id . ')">Daftar</button>';
                         
                    }
                ?>
                    <div class="col-lg-4 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?>asclepedia/<?= $morning_knowledge->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $morning_knowledge->thumbnail ?>" class="thumbnail" />
                                    <div class="position-absolute" style="left: 14px;bottom:10px">
                                        <img src="<?= base_url()?>assets/idi-logo.png" style="width:30px"  alt="">
                                    </div>
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $morning_knowledge->id")->row()->rating;
                                        if ($rating == '') {
                                            $rating = 0;
                                        } else {
                                            $rating = $rating;
                                        }
                                        ?>
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                    </div>
                                </div>
                                <div class="box-card__text"><span class="tag">Good morning knowledge</span>
                                    <h4><?= $morning_knowledge->judul_kelas ?></h4>

                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $morning_knowledge->id")->result();
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
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>
    <section class="section highlight" id="skill_labs">
        <div class="aksen aksen-1" style="bottom: calc(50% - 146px);left: -51px;"><img src="<?= base_url() ?>assets/front/images/aksen-asclepedia-highlight1.svg" /></div>
        <div class="aksen aksen-2" style="top: calc(50% - 118px);right: -39px;"><img src="<?= base_url() ?>assets/front/images/aksen-asclepedia-highlight2.svg" /></div>
        <div class="container">
            <div class="section__heading">
                <h3>Asclepedia : Skills Lab</h3>
            </div>
            <div class="row wrap-box-card">
                <?php foreach ($skill as $s) {
                    $new_price = 0;
                    if ( $s->early_daterange != null) {
                        $early_daterange     = $s->early_daterange;
                        $early_date1         = explode(' - ', $early_daterange)[0];
                        $early_date2         = explode(' - ', $early_daterange)[1];
                        $early_convert_date1 = date('Y-m-d', strtotime($early_date1));
                        $early_convert_date2 = date('Y-m-d', strtotime($early_date2));
                        $today_time          = date("Y-m-d");
                        $expire_time         = date("Y-m-d", strtotime("+20 day", strtotime($s->tgl_kelas)));
                        // $expire_time    = strtotime($s->tgl_kelas . ' ' . $s->waktu_mulai);
                        // $date           = $s->public_date;
                        // if ($new_date > date('Y-m-d')) {
                        //     $new_price = $s->early_price;
                        // } else {
                        //     $new_price = $s->late_price;
                        // }
                        if ((date('Y-m-d') >= $early_convert_date1) && (date('Y-m-d') <= $early_convert_date2)) {
                            $new_price = $s->early_price;
                        }else {
                            $new_price = $s->late_price;
                        }
                        if ($new_price == 0) {
                            $harga = 'FREE';
                        } else {
                            $harga = 'Rp ' . rupiah($new_price);
                        }
                    }
                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $s->id")->row();
                    if ($expire_time <= $today_time) {
                        
                        $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                        $button = '';
                    } else {
                        if ($s->limit != 0) {
                            if ($cek_transaksi->total >= $s->limit) {
                                $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                $button = '';
                            } else {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $s->id . ')">Daftar</button>';
                            }
                        } else {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $s->id . ')">Daftar</button>';
                        }
                    }

                    ?>
                    <div class="col-lg-3 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?>asclepedia/<?= $s->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $s->thumbnail ?>" class="thumbnail" />
                                    <div class="position-absolute" style="left: 14px;bottom:10px">
                                        <img src="<?= base_url()?>assets/idi-logo.png" style="width:30px"  alt="">
                                    </div>
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
                                <div class="box-card__text"><span class="tag tag-scndry">Skills Lab</span>
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
                                <div class="price"><?= $harga ?></div> <?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>
    </section>
    
    <!-- TIKET TERUSAN -->
    <section class="section highlight" id="tiket_terusan">
        <div class="aksen aksen-1" style="bottom: calc(50% - 146px);left: -51px;"><img src="<?= base_url() ?>assets/front/images/aksen-asclepedia-highlight1.svg" /></div>
        <div class="aksen aksen-2" style="top: calc(50% - 118px);right: -39px;"><img src="<?= base_url() ?>assets/front/images/aksen-asclepedia-highlight2.svg" /></div>
        <div class="container">
            <div class="section__heading">
                <h3>Asclepedia : Tiket Terusan</h3>
            </div>
            <div class="row wrap-box-card">
                <?php foreach ($terusan as $data) { 
                ?>
                    <div class="col-lg-3 col-md-6 slider__item">
                        <div class="box-card">
                            <a href="<?= base_url() ?>kelas-terusan/<?= strtoupper(md5($data->code_kelas)) ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas_terusan/<?= $data->image ?>" class="thumbnail" />
                                    <div class="position-absolute" style="left: 14px;bottom:10px">
                                        <img src="<?= base_url()?>assets/idi-logo.png" style="width:30px"  alt="">
                                    </div>
                                    <!-- <div class="rating">
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                    </div> -->
                                </div>
                                <div class="box-card__text"><span class="tag tag-scndry">Tiket Terusan </span>
                                    <h4><?= $data->judul_kelas_terusan ?></h4>
                                </div>
                            </a>
                            
                            <div class="box-card__footer">
                                <div class="price" style="text-decoration:line-through">Rp <?= number_format($data->price_actual) ?></div> 
                                <div class="price">Rp <?= number_format($data->price_kelas_terusan) ?></div> 
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?= count($drill); ?>
    <?php if(count($drill)>0) { ?>
    <section class="section" id="drill_the_case">
        <div class="container">
            <div class="section__heading">
                <h3>Asclepedia : Drill the Case</h3>
            </div>
            <div class="row wrap-box-card">
                <?php
                foreach ($drill as $drillthecase) {
                    $new_price = 0;
                    $label = '<span class="tag tag-scndry">'.ucwords($drillthecase->kategori_kelas).'</span>';
                    if ( $drillthecase->early_daterange != null) {
                        $early_daterange     = $drillthecase->early_daterange;
                        $early_date1         = explode(' - ', $early_daterange)[0];
                        $early_date2         = explode(' - ', $early_daterange)[1];
                        $early_convert_date1 = date('Y-m-d', strtotime($early_date1));
                        $early_convert_date2 = date('Y-m-d', strtotime($early_date2));
                        if ((date('Y-m-d') >= $early_convert_date1) && (date('Y-m-d') <= $early_convert_date2)) {
                            $new_price = $drillthecase->early_price;
                        }else {
                            $new_price = $drillthecase->late_price;
                        }
                        if ($new_price == 0) {
                            $harga = 'FREE';
                        } else {
                            $harga = 'Rp ' . rupiah($new_price);
                        }
                    }
                    if ($drillthecase->tipe_kelas == 'sekali_pertemuan') {
                        $today_time     = strtotime(date("Y-m-d H:i"));
                        // $expire_time = strtotime("-1 day", strtotime($m->tgl_kelas));
                        $expire_time    = strtotime($drillthecase->tgl_kelas . ' ' . $drillthecase->waktu_mulai);
                        $date           = $drillthecase->public_date;
                        $new_date       = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $drillthecase->id . ')">Daftar</button>';
                        }
                    } else {
                         $ribbon = '';
                         $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $drillthecase->id . ')">Daftar</button>';
                        
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?>asclepedia/<?= $drillthecase->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $drillthecase->thumbnail ?>" class="thumbnail" />
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $drillthecase->id")->row()->rating;
                                        if ($rating == '') {
                                            $rating = 0;
                                        } else {
                                            $rating = $rating;
                                        }
                                        ?>
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                    </div>
                                </div>
                                <div class="box-card__text"><span class="tag">Good morning knowledge</span>
                                    <h4><?= $drillthecase->judul_kelas ?></h4>

                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $drillthecase->id")->result();
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
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>
    <?php } ?>
    <section class="section jadwal">
        <div class="container">
            <div class="section__heading">
                <h3>Jadwal Asclepedia</h3>
                <div id="jadwalFilter_mobile"></div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <div class="box-calendar" id="calendar-wrapper"></div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <input type="hidden" id="input_filter" name="" id="">
                    <input type="hidden" id="input_date" name="" id="">
                    <div class="jadwal__filter">
                        <ul>
                            <li class="title"><span>Filter : </span></li>
                            <li class="filter-item active" value="all"><a href="javascript:void(0)">Semua</a></li>
                            <li class="filter-item" value="morning"><a href="javascript:void(0)">Good Morning Knowledge</a></li>
                            <li class="filter-item" value="skill"><a href="javascript:void(0)">Skills Lab</a></li>
                        </ul>
                    </div>
                    <div class="wrap-box-card listview" id="box_jadwal">
                        <!-- <div class="box-card"><a class="box-card__link" href="#">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/thumbnail-square-1.png" /></div>
                                <div class="box-card__content">
                                    <div class="rating">
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                                    </div>
                                    <div class="box-card__text"><span class="tag">Good morning knowledge</span>
                                        <h4>Siap Tanggapi Trauma Urogenital serta aplikasi desain website.</h4>
                                    </div>
                                    <div class="box-card__footer">
                                        <div class="author">
                                            <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                                        </div>
                                        <div class="date">16 Aug 2020</div>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                    </div>
                    <div class="bg-gradient"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var jenis = '<?= $this->uri->segment(1) ?>';
</script>