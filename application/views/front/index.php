<div class="home">
    <section class="home-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-7">
                    <div class="home-banner__text">
                        <h2><?= $caption->title_home ?></h2>
                        <div class="subtitle">
                            <p><?= $caption->desc_home ?></p>
                        </div>
                        <div class="button-wrap">
                            <a class="btn btn-primary" href="<?= base_url() ?>asclepedia">Daftar Asclepedia</a>
                            <a class="btn btn-border" href="<?= base_url() ?>asclepiogo">Daftar Asclepio GO</a> <br>
                            <a class="btn btn-border mt-3" href="https://wa.me/6281253241846" target="_blank">Pesan Asclepio Tools</a>
                            <a class="btn btn-border mt-3" href="#mdligyt" data-toggle="modal" data-target="#mdligyt">Konten Gratis Asclepio</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="home-banner__aksen"><img src="<?= base_url() ?>assets/front/images/banner-img.png" /></div>
                </div>
            </div>
        </div>
    </section>
    <?php
    if ($this->session->userdata('id') != '') { ?>
        <section class="section">
            <div class="container">
                <div class="section__heading">
                    <h3>Rekomendasi Kelas Untuk Kamu</h3>
                </div>
                <div class="row wrap-box-card slider" data-items="4">
                    <?php
                    $txt = "select * from kelas ";
                    $user_id = $this->session->userdata('id');

                    $query = $this->db->query("select t.id from user_topik ut join topik t on ut.topik_id = t.id where ut.user_id = $user_id ");

                    if ($query->num_rows() > 0) {
                        $txt .= ' where tgl_kelas > CURDATE() AND is_delete = 0 AND in_public = 1 AND (';
                        $count = 1;
                        foreach ($query->result() as $data) {

                            $txt .= " topik_id = $data->id ";

                            if ($count == $query->num_rows()) {
                                $txt .= ' ';
                            } else {
                                $txt .= ' OR ';
                            }


                            $count++;
                        }
                        $txt .= ' ) order by public_date desc';
                    }

                    $ontopik = $this->db->query($txt)->result();
                    // echo $this->db->last_query();

                    foreach ($ontopik as $ot) {
                        $today_time = strtotime(date("Y-m-d H:i"));
                        // $expire_time = strtotime($ot->tgl_kelas);
                        // $expire_time = strtotime("-1 day", strtotime($ot->tgl_kelas));
                        $expire_time = strtotime($ot->tgl_kelas . ' ' . $ot->waktu_mulai);
                        // echo 'today = ' . $today_time . 'expired = ' . $expire_time;
                        $date = $ot->public_date;
                        $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                        if ($ot->jenis_kelas == 'asclepedia') {
                            $jenis_kelas = 'asclepedia';
                        } else {
                            $jenis_kelas = 'asclepiogo';
                        }

                        if ($new_date > date('Y-m-d')) {
                            $new_price = $ot->early_price;
                        } else {
                            $new_price = $ot->late_price;
                        }
                        if ($new_price == 0) {
                            $harga = 'FREE';
                        } else {
                            $harga = 'Rp ' . rupiah($new_price);
                        }

                        $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $ot->id")->row();
                        if ($ot->jenis_kelas == 'asclepedia') {
                            if ($ot->kategori_kelas == 'good morning knowledge') {
                                $label = '<span class="tag tag">Good Morning Knowledge</span>';
                                if ($expire_time <= $today_time) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                }
                            } else {
                                $label = '<span class="tag tag-scndry">Skills Lab</span>';
                                if ($expire_time <= $today_time) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    if ($ot->limit != 0) {
                                        if ($cek_transaksi->total >= $ot->limit) {
                                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                            $button = '';
                                        } else {
                                            $ribbon = '';
                                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                        }
                                    } else {
                                        $ribbon = '';
                                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                    }
                                }
                            }
                        } else {
                            if ($ot->kategori_go == 'open') {
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
                                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                    } else {
                                        if ($ot->limit != 0) {
                                            if ($cek_transaksi->total >= $ot->limit) {
                                                $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                                $button = '';
                                            } else {
                                                $ribbon = '';
                                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                            }
                                        } else {
                                            $ribbon = '';
                                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                        }
                                    }
                                }
                            } elseif ($ot->kategori_go == 'expert') {
                                $label = '<span class="tag tag-expert">Expert Class</span>';
                                if ($expire_time <= $today_time) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    if ($new_price == 0) {
                                        $ribbon = '';
                                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                    } else {
                                        if ($ot->limit != 0) {
                                            if ($cek_transaksi->total >= $ot->limit) {
                                                $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                                $button = '';
                                            } else {
                                                $ribbon = '';
                                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                            }
                                        } else {
                                            $ribbon = '';
                                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ot->id . ')">Daftar</button>';
                                        }
                                    }
                                }
                            }
                        }

                    ?>
                        <div class="col-md-3 slider__item">

                            <div class="box-card">
                                <?= $ribbon ?>
                                <a href="<?= base_url() ?><?= $jenis_kelas ?>/<?= $ot->slug ?>">
                                    <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $ot->jenis_kelas ?>/<?= $ot->thumbnail ?>" class="thumbnail" />
                                        <div class="rating">
                                            <?php
                                            $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $ot->id")->row()->rating;
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
                                        <h4><?= $ot->judul_kelas ?></h4>
                                        <div class="author">
                                            <?php
                                            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $ot->id")->result();
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

    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Kelas Populer</h3>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <?php
                foreach ($onrating as $or) {
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($or->tgl_kelas));
                    $expire_time = strtotime($or->tgl_kelas . ' ' . $or->waktu_mulai);
                    $date = $or->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($or->jenis_kelas == 'asclepedia') {
                        $jenis_kelas = 'asclepedia';
                    } else {
                        $jenis_kelas = 'asclepiogo';
                    }

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
                    if ($or->jenis_kelas == 'asclepedia') {
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
                    } else {
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
                        } else if ($or->kategori_go == 'expert') {
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
                        // else if ($or->kategori_go == 'expert') {
                        //     $label = '<span class="tag tag-expert">Expert Class</span>';
                        // } else {
                        //     $label = '<span class="tag tag-private">Private Class</span>';
                        // }
                    }

                ?>
                    <div class="col-md-3 slider__item">

                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?><?= $jenis_kelas ?>/<?= $or->slug ?>">
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
    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3><img src="<?= base_url() ?>assets/front/images/aped.png" style="height: 30px;display:inline" alt=""> Asclepedia</h3><a class="see-more" href="<?= base_url() ?>asclepedia">Lihat semua</a>
            </div>
            <div class="row wrap-box-card slider" data-items="3">
                <?php
                foreach ($asclepedia as $a) {
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($a->tgl_kelas));
                    $expire_time = strtotime($a->tgl_kelas . ' ' . $a->waktu_mulai);

                    $date = $a->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $a->early_price;
                    } else {
                        $new_price = $a->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                    }


                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $a->id")->row();
                    if ($a->kategori_kelas == 'good morning knowledge') {
                        $label = '<span class="tag">Good morning knowledge</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            $ribbon = '';
                            $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $a->id . ')">Daftar</button>';
                        }
                    } else {
                        $label = '<span class="tag tag-scndry">Skills Lab</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            if ($a->limit != 0) {
                                if ($cek_transaksi->total >= $a->limit) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $a->id . ')">Daftar</button>';
                                }
                            } else {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $a->id . ')">Daftar</button>';
                            }
                        }
                    }


                ?>
                    <div class="col-md-4 slider__item">

                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?><?= $a->jenis_kelas ?>/<?= $a->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $a->jenis_kelas ?>/<?= $a->thumbnail ?>" class="thumbnail" />
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $a->id")->row()->rating;
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
                                    <h4><?= $a->judul_kelas ?></h4>
                                    <div class="author">
                                        <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $a->id")->result();
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
    <section class="section asclepio_go">
        <div class="aksen-1"><img src="<?= base_url() ?>assets/front/images/aksen-01.png" /></div>
        <div class="aksen-2"><img src="<?= base_url() ?>assets/front/images/aksen-02.png" /></div>
        <div class="container">
            <div class="section__heading">
                <h3><img src="<?= base_url() ?>assets/front/images/ago.png" style="height: 30px;display:inline" alt=""> Asclepio GO </h3>

                <a class="see-more" href="<?= base_url() ?>asclepiogo">Lihat semua</a>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <?php
                foreach ($asclepio_go as $ag) {
                    $today_time = strtotime(date("Y-m-d H:i"));
                    // $expire_time = strtotime("-1 day", strtotime($ag->tgl_kelas));
                    $expire_time = strtotime($ag->tgl_kelas . ' ' . $ag->waktu_mulai);
                    $date = $ag->public_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                    if ($new_date > date('Y-m-d')) {
                        $new_price = $ag->early_price;
                    } else {
                        $new_price = $ag->late_price;
                    }
                    if ($new_price == 0) {
                        $harga = 'FREE';
                        $tag = 'FREE';
                    } else {
                        $harga = 'Rp ' . rupiah($new_price);
                        $tag = 'PREMIUM';
                    }
                    $cek_transaksi = $this->query->get_query("SELECT COUNT(d.id) as total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $ag->id")->row();
                    if ($ag->kategori_go == 'open') {
                        $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            if ($new_price == 0) {
                                $ribbon = '';
                                $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ag->id . ')">Daftar</button>';
                            } else {
                                if ($ag->limit != 0) {
                                    if ($cek_transaksi->total >= $ag->limit) {
                                        $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                        $button = '';
                                    } else {
                                        $ribbon = '';
                                        $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ag->id . ')">Daftar</button>';
                                    }
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $ag->id . ')">Daftar</button>';
                                }
                            }
                        }
                    } else if ($ag->kategori_go == 'expert') {
                        $label = '<span class="tag tag-expert">Expert Class</span>';
                        if ($expire_time <= $today_time) {
                            $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                            $button = '';
                        } else {
                            if ($ag->limit != 0) {
                                if ($cek_transaksi->total >= $ag->limit) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<a href="https://wa.me/6281370225009?text=Saya tertarik dengan kelas ini ' . base_url('asclepiogo/' . $ag->slug . '') . '" target="_blank" class="btn text-white btn-small" style="background:#25d366;">Whatsapp</a>';
                                }
                            } else {
                                $ribbon = '';
                                $button = '<a href="https://wa.me/6281370225009?text=Saya tertarik dengan kelas ini ' . base_url('asclepiogo/' . $ag->slug . '') . '" target="_blank" class="btn text-white btn-small" style="background:#25d366;">Whatsapp</a>';
                            }
                        }
                    }

                ?>
                    <div class="col-md-3 slider__item">
                        <div class="box-card">
                            <?= $ribbon ?>
                            <a href="<?= base_url() ?>asclepiogo/<?= $ag->slug ?>">
                                <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $ag->jenis_kelas ?>/<?= $ag->thumbnail ?>" class="thumbnail" />
                                    <div class="rating">
                                        <?php
                                        $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $ag->id")->row()->rating;
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
                                    <h4><?= $ag->judul_kelas ?></h4>
                                    <div class="author">
                                        <?php
                                        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $ag->id")->result();
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
                <?php }  ?>
                <!-- <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-5.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-expert">Expert Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div>
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div>
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-6.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-private">Private Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-7.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-4.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Upcoming Class</h3>
            </div>
            <div class="row wrap-box-card slider" data-items="4">
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-4.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-5.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-6.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 slider__item">
                    <div class="box-card">
                        <div class="box-card__img"><img src="<?= base_url() ?>assets/front/images/card-thumbnail-7.png" />
                            <div class="rating">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-star.png" /></div><span>4.9</span>
                            </div>
                        </div>
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4><a href="#">Siap Tanggapi Trauma Urogenital</a></h4>
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                        </div>
                        <div class="box-card__footer">
                            <div class="price">Free</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <?php
    $ongoing = $this->query->get_query("SELECT id,judul_kelas,waktu_mulai,waktu_akhir FROM kelas WHERE CURTIME() BETWEEN waktu_mulai AND waktu_akhir AND tgl_kelas = CURDATE() ORDER BY waktu_mulai DESC")->result();
    // echo $ongoing;
    if ($ongoing) {
    ?>
        <section class="section ongoing">
            <div class="aksen aksen-1" style="bottom: 25px;left: -25px;"><img src="<?= base_url() ?>assets/front/images/aksen-ongoin-class-01.svg" /></div>
            <div class="aksen aksen-2" style="right: -70px;bottom: 0;"><img src="<?= base_url() ?>assets/front/images/aksen-ongoin-class-02.svg" /></div>
            <div class="container">

                <div class="row justify-content-center slider" data-items="1">
                    <?php foreach ($ongoing as $og) { ?>
                        <div class="col-md-7 slider__item">
                            <div class="ongoing__content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Ongoing Class</h4>
                                    </div>
                                    <div class="col-md-6"><span class="tag-live">Live Zoom Meeting</span></div>
                                </div>
                                <h3><?= $og->judul_kelas ?></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="author">
                                            <?php
                                            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $og->id")->result();
                                            foreach ($pemateri as $p) {
                                            ?>
                                                <div class="pp"><img src="<?= base_url() ?>assets/uploads/pemateri/<?= $p->foto ?>" /></div><span><?= $p->nama_pemateri ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6"><span class="time"><?= $og->waktu_mulai ?> - <?= $og->waktu_akhir ?> WIB</span></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </section>
    <?php
    } ?>
    <section class="section testimoni">
        <div class="aksen aksen-1" style="top: 0;left: -25px;"><img src="<?= base_url() ?>assets/front/images/ic-quote.svg" /></div>
        <div class="aksen aksen-2" style="right: -25px;bottom: 0;"><img src="<?= base_url() ?>assets/front/images/ic-quote-2.svg" /></div>
        <div class="container">
            <div class="section__heading">
                <h3>Testimoni dari Asclepian</h3>
            </div>
            <div class="row slider slider__testimoni" data-items="3">
                <?php foreach ($testimoni as $testi) { ?>
                    <div class="col-md-4 slider__item">
                        <div class="testimoni-card">
                            <h3><?= $testi->judul_kelas ?></h3>
                            <p>“<?= $testi->ulasan ?>”</p>
                            <div class="writer-rating">
                                <div class="rating"><?= start_created($testi->rating) ?></div>
                                <div class="writer">
                                    <div class="name"><?= $testi->nama_lengkap ?></div>
                                    <div class="position"><?= $testi->universitas ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section section-ig">
        <div class="container">
            <div class="section__heading">
                <h3>Instagram @asclepio.masterclass</h3>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="gallery-ig">
                        <div class="row" id="gallery_ig">
                        </div>
                        <div class="btn-wrap"><a class="see-more" href="https://www.instagram.com/asclepio.masterclass/" target="_blank">Lihat Instagram Asclepio</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2><b>Video Tutorial Registrasi.</b></h2> <br>
                    <h3 style="font-weight: 300;">Asclepian mau ikut kelas Asclepedia & Asclepio GO? Yuk registrasi dulu! PIYO kasih tau caranya registrasi dan pesan kelas di video tutorial ini. Gampang kok!
                    </h3><br>

                </div>
                <div class="col-md-10 col-xs-12 offset-md-1">
                    <!-- <div style="position: absolute;width:100%;height:100%;background:transparent"></div> -->
                    <video width="100%" height="340" controls oncontextmenu="return false;" controlsList="nodownload">
                        <source src="<?= base_url() ?>assets/video/demo_asclepio.mp4" type="video/mp4">
                    </video>
                    <!-- <iframe width="100%" height="480" type="text/html" oncontextmenu="return false;" src="https://www.youtube.com/embed/K2BQBm6jrlk?&cc_load_policy=1&disablekb=1&enablejsapi=1&modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>

                    </iframe> -->

                </div>
            </div>
        </div>
    </section>
    <section class="section home-faq">
        <div class="container">
            <div class="section__heading">
                <h3>FAQ</h3>
            </div>
            <div class="home-faq__wrapper">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading-1">
                            <h5 class="mb-0" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">Apa itu Asclepedia?</h5>
                        </div>
                        <div class="collapse show" id="collapse-1" aria-labelledby="heading-1" data-parent="#accordion">
                            <div class="card-body">Kelas online kedokteran yang berupa webinar, diskusi interaktif dan workshop online yang diisi oleh pembicara dari berbagai macam departemen kedokteran (e.g. pediatri, bedah, obsgyn, anestesi, etc) untuk meningkatkan hard skill dan knowledge sebagai seorang dokter.</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading-2">
                            <h5 class="mb-0" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">Apa itu Asclepio GO?</h5>
                        </div>
                        <div class="collapse" id="collapse-2" aria-labelledby="heading-2" data-parent="#accordion">
                            <div class="card-body">Bimbingan belajar untuk fakultas kedokteran yang diberikan secara online dengan berbagai kurikulum kedokteran (e.g. anatomi, fisiologi, pendekatan penyakit, pendekatan klinis, etc) yang dapat dipesan kelasnya dalam bentuk kelas besar (Asclepio GO Open Class), kelas kecil (Asclepio GO Expert Class), dan kelas privat (Asclepio GO Private Class)</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading-3">
                            <h5 class="mb-0" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">Bagaimana cara daftar kelas Asclepedia dan Asclepio GO?
                            </h5>
                        </div>
                        <div class="collapse" id="collapse-3" aria-labelledby="heading-3" data-parent="#accordion">
                            <div class="card-body">Registrasi dahulu untuk membuat akun Asclepian di klik Daftar Akun. Ikuti langkah registrasi di video tutorial. Jika sudah memiliki akun silahkan klik Masuk, masukan email dan password.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="heading-4">
                            <h5 class="mb-0" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">Dimana saya bisa mendapat link zoom atau link youtube?
                            </h5>
                        </div>
                        <div class="collapse" id="collapse-4" aria-labelledby="heading-4" data-parent="#accordion">
                            <div class="card-body">Pada profile klik bagian tiket saya, lalu lihat kelas yang sudah dibeli / daftar, ada tombol Link kelas. klik tombol tersebut untuk masuk zoom atau melihat melalui youtube</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section join-webinar">
        <div class="aksen-1"><img src="<?= base_url() ?>assets/front/images/join-aksen-01.png" /></div>
        <div class="aksen-2"><img src="<?= base_url() ?>assets/front/images/join-aksen-02.png" /></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="join-webinar__text">
                        <h3>Yuk Asclepian Daftar Asclepedia dan Asclepio GO Sekarang!</h3>
                        <div class="btn-wrap"><a class="btn btn-primary" href="<?= base_url() ?>asclepedia">Daftar Asclepedia</a><a class="btn btn-border" href="<?= base_url() ?>asclepiogo">Daftar Asclepio GO</a></div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 d-lg-block d-none">
                    <div class="join-webinar__img">
                        <div class="img_aksen"><img src="<?= base_url() ?>assets/front/images/banner-img.png" /></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>