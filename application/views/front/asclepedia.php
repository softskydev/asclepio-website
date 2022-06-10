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
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($or->tgl_kelas));
                    $expire_time = strtotime($or->tgl_kelas . ' ' . $or->waktu_mulai);
                    $date = $or->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $or->early_price;
                    } else {
                        $new_price = $or->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }

                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $or->id")->row();
                    if ($or->kategori_kelas == 'good morning knowledge') {
                        $label = '<span class="tag tag">Good Morning Knowledge</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
                        }
                    } else {
                        $label = '<span class="tag tag-scndry">Skills Lab</span>';
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

                ?>
                    <div class="col-lg-3 col-md-6 slider__item">

                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?><?= $or->jenis_kelas ?>/<?= $or->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $or->jenis_kelas ?>/<?= $or->thumbnail ?>" class="thumbnail" />
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
                foreach ($morning as $m) {
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($m->tgl_kelas));
                    $expire_time = strtotime($m->tgl_kelas . ' ' . $m->waktu_mulai);
                    $date = $m->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $m->early_price;
                    } else {
                        $new_price = $m->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }

                    if ($expire_time <= $today_time) {
                        $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                        $button = '';
                    } else {
                        $ribbon = '';
                        $button = '<button class="btn btn-primary" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $m->id . ')">Daftar</button>';
                    }
                ?>
                    <div class="col-lg-4 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?>asclepedia/<?= $m->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepedia/<?= $m->thumbnail ?>" class="thumbnail" />
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $m->id")->row()->rating;
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
                                    <h4><?= $m->judul_kelas ?></h4>

                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $m->id")->result();
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
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($s->tgl_kelas));
                    $expire_time = strtotime($s->tgl_kelas . ' ' . $s->waktu_mulai);
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