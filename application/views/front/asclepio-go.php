<div class="asclepio_go">
    <section class="banner__small">
        <div class="aksen aksen-1" style="bottom: 60px;left: -47px;"><img src="<?= base_url() ?>assets/front/images/aksen-banner-faq-1.svg" /></div>
        <div class="container">
            <div class="banner__small-content">
                <h2><img src="<?= base_url() ?>assets/front/images/ago.png" style="height: 100px;display:inline" alt=""></h2>
                <div><?= $caption->desc_asclepiogo ?></div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Asclepio Go Terpopuler</h3>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <?php
                foreach ($onrating as $or) {
                    $today_time = strtotime(date("Y-m-d"));
                    $expire_time = strtotime("-1 day", strtotime($or->tgl_kelas));
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
                    if ($or->kategori_go == 'open') {
                        if ($new_price == 0) {
                            $tag = 'FREE';
                        } else {
                            $tag = 'PREMIUM';
                        }
                        $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            if ($new_price == 0) {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
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
                    } else {
                        $label = '<span class="tag tag-expert">Expert Class</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            if ($new_price == 0) {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $or->id . ')">Daftar</button>';
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

                ?>
                    <div class="col-lg-3 col-md-6 slider__item">

                        <div class="box-card">
                            <?= $ribbon ?>
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
                                <h4><a href="<?= base_url() ?><?= $or->jenis_kelas ?>/<?= $or->slug ?>"><?= $or->judul_kelas ?></a></h4>
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
                            <div class="box-card__footer">
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section" id="open_class">
        <div class="container">
            <div class="section__heading">
                <h3>Asclepio Go : Open Class</h3>
            </div>
            <div class="row wrap-box-card">
                <?php
                foreach ($open as $o) {
                    $today_time = strtotime(date("Y-m-d"));
                    $expire_time = strtotime("-1 day", strtotime($o->tgl_kelas));
                    $date = $o->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $o->early_price;
                    } else {
                        $new_price = $o->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                        $tag = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                        $tag = 'PREMIUM';
                    }
                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $o->id")->row();
                    if ($expire_time <= $today_time) {
                        $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                        $button = '';
                    } else {
                        if ($new_price == 0) {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $o->id . ')">Daftar</button>';
                        } else {
                            if ($o->limit != 0) {
                                if ($cek_transaksi->total >= $o->limit) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $o->id . ')">Daftar</button>';
                                }
                            } else {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $o->id . ')">Daftar</button>';
                            }
                        }
                    }
                ?>
                    <div class="col-md-3 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepio_go/<?= $o->thumbnail ?>" class="thumbnail" />
                                <div class="rating">
                                    <?php
                                    $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $o->id")->row()->rating;
                                    if ($rating == '') {
                                        $rating = 0;
                                    } else {
                                        $rating = $rating;
                                    }
                                    ?>
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                </div>
                            </div>
                            <div class="box-card__text"><span class="tag tag-open">Open Class | <?= $tag ?></span>
                                <h4><a href="<?= base_url() ?>asclepio_go/<?= $o->slug ?>"><?= $o->judul_kelas ?></a></h4>
                                <div class="author">
                                    <?php
                                    $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $o->id")->result();
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
                            <div class="box-card__footer">
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>
    <section class="section highlight" id="expert_class">
        <div class="aksen aksen-2" style="bottom: calc(50% - 139px);right: -70px;"><img src="<?= base_url() ?>assets/front/images/aksen-asclepedia-highlight3.svg" /></div>
        <div class="container">
            <div class="section__heading">
                <h3>Asclepio Go : Expert Class</h3>
            </div>
            <div class="row wrap-box-card">
                <?php
                foreach ($expert as $e) {
                    $today_time = strtotime(date("Y-m-d"));
                    $expire_time = strtotime("-1 day", strtotime($e->tgl_kelas));
                    $date = $e->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $e->early_price;
                    } else {
                        $new_price = $e->late_price;
                    }
                    $harga = 'Rp ' . rupiah($new_price);
                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $e->id")->row();
                    if ($expire_time <= $today_time) {
                        $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                        $button = '';
                    } else {
                        if ($new_price == 0) {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $e->id . ')">Daftar</button>';
                        } else {
                            if ($e->limit != 0) {
                                if ($cek_transaksi->total >= $e->limit) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $e->id . ')">Daftar</button>';
                                }
                            } else {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $e->id . ')">Daftar</button>';
                            }
                        }
                    }
                ?>
                    <div class="col-lg-3 col-md-6 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/asclepio_go/<?= $e->thumbnail ?>" class="thumbnail" />
                                <div class="rating">
                                    <?php
                                    $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $e->id")->row()->rating;
                                    if ($rating == '') {
                                        $rating = 0;
                                    } else {
                                        $rating = $rating;
                                    }
                                    ?>
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span><?= $rating ?></span>
                                </div>
                            </div>
                            <div class="box-card__text"><span class="tag tag-open">Expert Class</span>
                                <h4><a href="<?= base_url() ?>asclepio_go/<?= $e->slug ?>"><?= $e->judul_kelas ?></a></h4>
                                <div class="author">
                                    <?php
                                    $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $e->id")->result();
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
                            <div class="box-card__footer">
                                <div class="price"><?= $harga ?></div><?= $button ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="right">
                        <h4>Informasi</h4>
                        <p>Ingin buat Expert Class kamu sendiri ? Silahkan hubungi Whatsapp kami</p>
                        <a href="https://wa.me/6281370225009?text=Saya tertarik dengan Expert Class" target="_blank" class="btn text-white btn-large" style="background:#25d366;">Whatsapp</a>
                    </div>
                </div>
            </div>
        </div>

</div>
</section>
<section class="section" id="private_class">
    <div class="container">
        <div class="section__heading">
            <h3>Asclepio Go : Private Class</h3>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="left">
                    <div>
                        PIYO menyediakan bimbingan belajar online untuk Asclepian yang pengen belajar lebih privat dan lebih fokus. <br>
                        Asclepian bisa mendaftar dalam kelompok <b>1-3 orang</b> dan <b>4-5 orang</b> dan terdapat pilihan <b>2 jam</b> dan <b>3 jam</b>. Asclepian bisa <b>Bebas</b> memilih kurikulum / materi sesuai dengan kebutuhan. PIYO menyediakan kurikulum / materi <b>Anatomi, Fisiologi, Biokimia, pendekatan klinis per departemen, persiapan KOAS, persiapan INTERNSHIP, UKMPPD.</b>
                    </div>

                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="right">
                    <h4>Informasi</h4>
                    <p>Untuk informasi mengenai Private Class, silahkan hubungi Whatsapp kami</p>
                    <a href="https://wa.me/6281370225009?text=Saya tertarik dengan Private Class" target="_blank" class="btn text-white btn-large" style="background:#25d366;">Whatsapp</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section jadwal">
    <div class="container">
        <div class="section__heading">
            <h3>Jadwal Asclepio Go</h3>
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
                        <li class="title"><span>Filter :</span></li>
                        <li class="filter-item active" value="all"><a href="javascript:void(0)">Semua</a></li>
                        <li class="filter-item" value="open"><a href="javascript:void(0)">Open Class</a></li>
                        <li class="filter-item" value="expert"><a href="javascript:void(0)">Expert Class</a></li>
                        <!-- <li class="filter-item" value="private"><a href="javascript:void(0)">Private Class</a></li> -->
                    </ul>
                </div>
                <div class="wrap-box-card listview" id="box_jadwal">
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