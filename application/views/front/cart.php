<div class="page-freebox cart">
    <div class="container">
        <div class="page_title">
            <h2>Keranjang kamu</h2>
        </div>
        <?php
        if (!$data) { ?>
            <div class="row">
                <div class="col-md-12">
                    <p>Kamu belum memiliki Tiket</p>
                    <div class="join-webinar__text" style="color: #75B248 !important;">
                        <div class="button-wrap"><a class="btn btn-primary" href="<?= base_url() ?>asclepedia">Daftar Asclepedia</a>&nbsp;&nbsp;<a class="btn btn-border" href="<?= base_url() ?>asclepio_go">Daftar Asclepio GO</a></div>
                    </div>
                </div>
            </div>
        <?php } else {
        ?>
            <div class="row">

                <div class="col-md-8">
                    <?php
                    foreach ($data as $d) {
                    ?>
                        <div class="wrap-box-card listview">
                            <?php
                            $this->load->helper('text');
                            if ($d->jenis_kelas == 'asclepedia') {
                                $jenis_kelas = 'asclepedia';
                                if ($d->kategori_kelas == 'good morning knowledge') {
                                    $label = "<span class='tag'>Good morning knowledge</span>";
                                } else {
                                    $label = "<span class='tag tag-scndry'>Skill Lab</span>";
                                }
                            } else {
                                $jenis_kelas = 'asclepiogo';
                                if ($d->kategori_go == 'open') {
                                    $label = "<span class='tag tag-open'>Open Class</span>";
                                } else if ($d->kategori_go == 'private') {
                                    $label = "<span class='tag tag-private'>Private Class</span>";
                                } else {
                                    $label = "<span class='tag tag-expert'>Expert Class</span>";
                                }
                            }

                            $date = $d->public_date;
                            $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                            if ($new_date > date('Y-m-d')) {
                                $new_price = $d->early_price;
                            } else {
                                $new_price = $d->late_price;
                            }
                            if ($new_price == 0) {
                                $harga = 'FREE';
                            } else {
                                $harga = 'Rp ' . rupiah($new_price);
                            }
                            ?>
                            <div class="box-card"><a class="box-card__link" href="javascript:void(0)">
                                    <input type="hidden" id="card_id<?= $d->id ?>" name="card_id[]" value="<?= $d->id ?>">
                                    <input type="hidden" id="card_jenis<?= $d->id ?>" name="card_jenis[]" value="<?= $d->jenis_kelas ?>">
                                    <input type="hidden" id="card_harga<?= $d->id ?>" name="card_harga[]" value="<?= $new_price ?>">
                                    <div class="box-card__img">
                                        <img src="<?= base_url() ?>assets/uploads/kelas/<?= $d->jenis_kelas ?>/<?= $d->thumbnail ?>" />
                                    </div>

                                    <div class="box-card__content">
                                        <div class="box-card__text"><?= $label ?>
                                            <h4><?= $d->judul_kelas ?></h4>

                                            <ul class="schedule">
                                                <li>
                                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-date.svg" /></div><span><?= format_indo($d->tgl_kelas)  ?></span>
                                                </li>
                                                <li>
                                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-time.svg" /></div><span><?= $d->waktu_mulai ?> - <?= $d->waktu_akhir ?> WIB</span>
                                                </li>
                                                <li>
                                                    <div class="ic"><i class="fas fa-eye text-success" onclick="window.location.href='<?= base_url() ?><?= $jenis_kelas ?>/<?= $d->slug ?>'"></i></div>
                                                    <!-- <a href="<?= base_url() ?><?= $d->jenis_kelas ?>/<?= $d->slug ?>" class="text-success">
                                                        Detail kelas
                                                    </a> -->
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="box-card__footer">
                                            <div class="author">
                                                <?php
                                                $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $d->id")->result();
                                                if (count($pemateri) > 1) {
                                                    foreach ($pemateri as $pem) {
                                                        echo '<div class="pp"><img src="' . base_url() . 'assets/uploads/pemateri/' . $pem->foto . '" /></div>';
                                                    }
                                                } else {
                                                    foreach ($pemateri as $pem) {
                                                        echo '<div class="pp"><img src="' . base_url() . 'assets/uploads/pemateri/' . $pem->foto . '" /></div><span>' . $pem->nama_pemateri . '</span>';
                                                    }
                                                }
                                                ?>
                                                <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pemateri-1.png" /></div><span>Dr. Ahman Jayadi</span> -->
                                            </div>
                                            <div class="price"><?= $harga ?></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-select btn-small mt-3" style="display: none;float:right" id="btn-select<?= $d->id ?>" onclick="pilih_voucher(<?= $d->id ?>,<?= $new_price ?>)"><i class="fa fa-ticket" style="transform: rotate(-45deg);"></i> &nbsp;&nbsp;&nbsp;&nbsp;Gunakan Voucher</button>
                                </a>
                                <div class="action">
                                    <div class="dot"><img src="<?= base_url() ?>assets/front/images/ic-three-dots.svg" /></div>
                                    <div class="action-sub">
                                        <ul>
                                            <li class="dlt"><a href="<?= base_url() ?>Booking/delete_cart/<?= $this->session->userdata('id') ?>/<?= $d->id ?>">
                                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-delete-basket.svg" /></div>Hapus dari keranjang
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-4">
                    <div class="panel voucher">
                        <div class="form-group">
                            <label>Voucher Kamu</label>
                            <input type="hidden" id="sisa">
                            <input type="hidden" id="jenis_voucher">
                            <div id="voucher_input">
                                <input class="form-control" type="text" name="code_voucher" id="code_voucher" />
                                <button type="button" class="btn btn-link" onclick="cek_voucher()">Gunakan</button>
                            </div>
                            <div id="voucher_msg">
                                <p></p><a href="<?= current_url() ?>" class="remove" style="cursor: pointer;"><img src="<?= base_url() ?>/assets/front/images/ic-remove.svg" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel cart__total">
                        <h3>Total</h3>
                        <input type="hidden" id="potongan">
                        <ul class="total__detail">
                            <?php
                            foreach ($data as $d) {
                                $date = $d->public_date;
                                $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                                if ($new_date > date('Y-m-d')) {
                                    $new_price = $d->early_price;
                                } else {
                                    $new_price = $d->late_price;
                                }
                                if ($new_price == 0) {
                                    $harga = 'FREE';
                                } else {
                                    $harga = 'Rp ' . rupiah($new_price);
                                } ?>
                                <li>
                                    <div class="left"><span><?= character_limiter($d->judul_kelas, 20)  ?></span></div>
                                    <div class="right text-right" id="text_harga_before<?= $d->id ?>"><span><?= $harga ?></span></div>
                                    <small class="text-success" style="display: none;" id="text_potongan<?= $d->id ?>"></small>
                                    <font class="text-success text-right right" style="display: none;" id="text_harga_after<?= $d->id ?>"></font>
                                </li>
                                <li>
                                    <input type="hidden" class="harga" name="harga[]" value="<?= $new_price ?>" id="harga<?= $d->id ?>">
                                    <input type="hidden" class="voucher" name="voucher[]" id="voucher<?= $d->id ?>">
                                    <input type="hidden" value="<?= $d->id ?>" name="product_id[]" id="product_id<?= $d->id ?>">
                                    <input type="hidden" placeholder="diskon" name="diskon[]" value="0" id="diskon<?= $d->id ?>">
                                    <input type="hidden" class="harga_total" value="<?= $new_price ?>" placeholder="harga_total" name="harga_total[]" id="harga_total<?= $d->id ?>">
                                </li>
                            <?php } ?>
                            <li class="grandtotal">
                                <input type="hidden" id="total">
                                <div class="left"><span>Total Harga</span></div>
                                <div class="right text-right"><span id="text_total"></span></div>
                            </li>
                        </ul><button class="btn btn-primary btn-block btn-checkout" onclick="makeTransaction(<?= $this->session->userdata('id') ?>)">Checkout</button>
                    </div>
                </div>
            </div>
            <?php
            $cek_cart = $this->query->get_query("SELECT k.id,c.product_id,k.late_price FROM cart c JOIN kelas k ON c.product_id = k.id WHERE c.user_id = " . $this->session->userdata('id') . " ORDER BY c.id DESC")->row();
            if ($cek_cart->late_price == 0) {
                $saran = $this->query->get_query("SELECT * FROM kelas WHERE late_price = 0 AND tgl_kelas >= CURDATE() AND id != $cek_cart->id")->result();
            } else {
                $saran = $this->query->get_query("SELECT * FROM kelas WHERE late_price != 0 AND tgl_kelas >= CURDATE() AND id != $cek_cart->id")->result();
            } ?>

            <div class="section">
                <div class="section__heading">
                    <h4>Kelas yang disarankan</h4>
                </div>
                <div class="row wrap-box-card slider" data-items="4">
                    <?php
                    foreach ($saran as $s) {
                        $today_time = strtotime(date("Y-m-d"));
                        $expire_time = strtotime($s->tgl_kelas);

                        $date = $s->public_date;
                        $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

                        if ($s->jenis_kelas == 'asclepedia') {
                            $jenis_kelas = 'asclepedia';
                        } else {
                            $jenis_kelas = 'asclepiogo';
                        }

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
                        if ($s->jenis_kelas == 'asclepedia') {
                            if ($s->kategori_kelas == 'good morning knowledge') {
                                $label = '<span class="tag">Good morning knowledge</span>';
                                if ($expire_time < $today_time) {
                                    $ribbon = "<div class='box-ribbon'><div class='corner-ribbon top-left red shadow'>Sold</div></div>";
                                    $button = '';
                                } else {
                                    $ribbon = '';
                                    $button = '<button class="btn btn-primary btn-small" onclick="addToCart(\'' . $this->session->userdata('id') . '\',' . $s->id . ')">Daftar</button>';
                                }
                            } else {
                                $label = '<span class="tag tag-scndry">Skills Lab</span>';
                                if ($expire_time < $today_time) {
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
                            }
                        } else {
                            if ($s->kategori_go == 'open') {
                                if ($new_price == 0) {
                                    $tag = 'FREE';
                                } else {
                                    $tag = 'PREMIUM';
                                }
                                $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                                if ($expire_time < $today_time) {
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
                            }
                        }


                    ?>
                        <div class="col-md-4 slider__item">

                            <div class="box-card">
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
                                    <h4><a href="<?= base_url() ?><?= $jenis_kelas ?>/<?= $s->slug ?>"><?= $s->judul_kelas ?></a></h4>
                                    <div class="author">
                                        <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
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
        <?php
        } ?>

    </div>

</div>