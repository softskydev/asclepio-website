<style>
    .box-card__img {
        padding-top: 100% !important;
    }

    .box-card__img .thumbnail {
        position: absolute !important;
        top: 0;
    }
</style>
<div class="page-profile">
    <section class="section">
        <div class="container">
            <div class="section__heading">
                <h3>Profile</h3>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="page-profile__informasi">
                        <div class="section__heading">
                            <h4>Informasi</h4>
                        </div>
                        <div class="informasi-box">
                            <div class="informasi-box-profile">
                                <div class="informasi-box__photo"><img src="<?= base_url() ?>assets/uploads/member/<?= $profile->foto_profil ?>" onerror="this.src='<?= base_url() ?>assets/uploads/member/profile_default.png'" /></div>
                                <div class="informasi-box__name">
                                    <h3><?= $this->session->userdata('nama_lengkap') ?></h3>
                                    <p><?= $profile->universitas ?></p>
                                </div><button class="btn btn-border" onclick="edit(<?= $profile->id ?>)">Edit Profile</button>
                            </div>
                            <hr />
                            <?php
                            $follow = $this->query->get_query("SELECT k.*,t.total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.user_id = " . $this->session->userdata('id') . " AND k.tgl_kelas <= CURDATE() AND t.status = 'paid' AND d.status = 'success'")->result();
                            $ticket_data = $this->query->get_query("SELECT k.*,t.total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.user_id = " . $this->session->userdata('id') . " AND k.tgl_kelas <= CURDATE() AND t.status = 'paid' AND d.status = 'success'")->result();
                            $count_follow = count($follow);
                            $count_ticket = count($ticket_data);
                            ?>
                            <div class="list-group profile_menu">
                                <a href="<?= base_url() ?>profile" class="list-group-item list-group-item-action" aria-current="true">
                                    Ringkasan
                                </a>
                                <a href="<?= base_url() ?>profile/pemesanan/semua" class="list-group-item list-group-item-action">Status Pemesanan</a>
                                <a href="<?= base_url() ?>profile/tiket" class="list-group-item list-group-item-action active">Tiket Saya </a>
                                <a href="<?= base_url() ?>profile/kelas" class="list-group-item list-group-item-action">Kelas yang sudah diikuti <div class="badge badge-success mt-1" style="float: right;"><?= $count_follow ?></div></a>
                                <a href="<?= base_url() ?>profile/voucher" class="list-group-item list-group-item-action">Voucher</a>
                            </div>
                            <hr>
                            <ul class="informasi-box__detail">
                                <li>
                                    <label>Tentang saya</label>
                                    <p><?= $profile->tentang ?></p>
                                </li>
                                <li>
                                    <label>Email</label>
                                    <p><?= $profile->email ?></p>
                                </li>
                                <li>
                                    <label>Asal Kota</label>
                                    <p><?= $profile->kota ?></p>
                                </li>
                                <li class="topik">
                                    <label>Topik favorite</label>

                                    <div class="topik__wrap">
                                        <?php
                                        $user_topik = array();
                                        $topik = $this->query->get_query("SELECT t.id,t.nama_topik FROM user_topik ut JOIN topik t ON ut.`topik_id` = t.`id` WHERE ut.`user_id` = " . $this->session->userdata('id') . "")->result();
                                        foreach ($topik as $t) {
                                            $user_topik[] = $t->id;
                                        ?>
                                            <a class="tag-topik" href="#"><?= $t->nama_topik ?></a>
                                        <?php } ?>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="section followedclass">
                        <div class="section__heading">
                            <h4>Tiket Saya</h4>
                        </div>
                        <div class="row wrap-box-card" id="box_following_class" data-items="4">
                            <script>
                                var user_id = <?= $this->session->userdata('id') ?>;
                            </script>
                            <?php
                            $tiket = $this->query->get_query("SELECT row_number() over (ORDER BY t.tgl_pembelian ASC) AS urutan, k.*,d.total_harga, d.status,d.status_link FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.user_id = " . $this->session->userdata('id') . " AND k.tgl_kelas >= CURDATE() AND t.status = 'paid' ORDER BY t.tgl_pembelian DESC")->result();
                            if (count($tiket) > 0) {
                             
                                foreach ($tiket as $t) {
                                    $early_daterange     = $t->early_daterange;
                                    $early_date1         = explode(' - ', $early_daterange)[0];
                                    $early_date2         = explode(' - ', $early_daterange)[1];
                                    $early_convert_date1 = date('Y-m-d', strtotime($early_date1));
                                    $early_convert_date2 = date('Y-m-d', strtotime($early_date2));
                                    if ((date('Y-m-d') >= $early_convert_date1) && (date('Y-m-d') <= $early_convert_date2)) {
                                        $new_price = $t->early_price;
                                    }else {
                                        $new_price = $t->late_price;
                                    }
                                   
                                    if ($new_price == 0) {
                                        $harga = 'FREE';
                                    } else {
                                        $harga = 'Rp ' . rupiah($new_price);
                                    }

                                    $cek_limit = $this->query->get_data('limit', 'kelas', ['id' => $t->id])->row();
                                    if ($t->jenis_kelas == 'asclepedia') {

                                        if ($t->kategori_kelas == 'good morning knowledge') {
                                            $label = '<span class="tag tag">Good Morning Knowledge</span>';
                                            if ($t->status == 'pending') {
                                                $zoom = '<small><a href="' . $t->gform_url . '" target="_blank">Harap isi Google Form untuk mendapatkan Link Kelas</a></small>';
                                            } else if ($t->status == 'success') {
                                                if ($t->status_link == 'zoom') {
                                                    $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                                } else if ($t->status_link == 'youtube') {
                                                    $zoom = '<a class="btn btn-primary btn-small" href="' . $t->youtube . '" target="_blank">Link Kelas</a>';
                                                } else {
                                                    $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                                }
                                            }
                                        } else {
                                            $label = '<span class="tag tag-scndry">Skills Lab</span>';
                                            if ($t->status == 'pending') {
                                                $zoom = '';
                                            } else if ($t->status == 'success') {
                                                if ($t->tipe_kelas == 'banyak_pertemuan'){
                                                    $zoom = '<a class="btn btn-primary btn-small" href="javascript:void(0)" onclick="listLinkKelas('.$t->id.')">Link Kelas</a>';
                                                } else {
                                                    $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                                }
                                            }
                                        }
                                    } else {
                                        if ($t->kategori_go == 'open') {
                                            if ($new_price == 0) {
                                                $tag = 'FREE';
                                            } else {
                                                $tag = 'PREMIUM';
                                            }
                                            $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';

                                            if ($t->total_harga == 0 && $t->status == 'pending') {
                                                $zoom = '<small><a href="' . $t->gform_url . '">Harap isi Google Form untuk mendapatkan Link Kelas</a></small>';
                                            } else if ($t->total_harga == 0 && $t->status == 'success') {
                                                $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                            } else if ($t->total_harga != 0 && $t->status == 'pending') {
                                                $zoom = '';
                                            } else if ($t->total_harga != 0 && $t->status == 'success') {
                                                $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                            }
                                        } else if ($t->kategori_go == 'expert') {
                                            $label = '<span class="tag tag-expert">Expert Class</span>';
                                        } else {
                                            $label = '<span class="tag tag-private">Private Class</span>';
                                        }
                                    }
                            ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="box-card">
                                            <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $t->jenis_kelas ?>/<?= $t->thumbnail ?>" class="thumbnail" />
                                                <div class="rating">
                                                    <?php
                                                    $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $t->id")->row()->rating;
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
                                                <h4><a href="#"><?= $t->judul_kelas ?></a></h4>
                                                <div class="ic mb-3" style="display: flex;">
                                                    <img src="<?= base_url() ?>assets/front/images/ic-date.svg" alt=""> &nbsp;&nbsp;
                                                    <small><?= format_indo($t->tgl_kelas) ?></small>
                                                </div>
                                                <div class="ic mb-3" style="display: flex;">
                                                    <img src="<?= base_url() ?>assets/front/images/ic-time.svg" alt=""> &nbsp;&nbsp;
                                                    <small><?= $t->waktu_mulai ?> - <?= $t->waktu_akhir ?></small>
                                                </div>
                                                <div class="author">
                                                    <?php
                                                    $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $t->id")->result();
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
                                                </div>
                                                <div class="mt-3 ">
                                                    <?php
                                                    // if ($t->total_harga == 0) {
                                                    //     echo $zoom;
                                                    // } else {
                                                    //     $new_time = strtotime("-1 hour", strtotime($t->waktu_mulai));

                                                    //     $today = strtotime(date("H:i"));
                                                    //     if ($t->tgl_kelas == date("Y-m-d") && $today >= $new_time) {
                                                    //         echo $zoom;
                                                    //     } else {
                                                    //         echo "<small>Link kelas akan muncul 1 jam sebelum kelas dimulai</small>";
                                                    //     }
                                                    // }
                                                    if ($t->kategori_kelas == null) {
                                                        $zoom = '<a class="btn btn-primary btn-small" href="' . $t->link_zoom . '" target="_blank">Link Kelas</a>';
                                                    }
                                                    echo $zoom;


                                                    ?>


                                                </div>
                                            </div>
                                        </div>
                                    </div> <?php }
                                    } else { ?>

                        </div>
                        <p>Belum ada kelas yang diikuti</p>
                    <?php }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
</div>

<div class="modal" id="editprofile" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Edit Profile</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/front/images/ic-xclose.svg" /></a>
                <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>Profile/edit/<?= $profile->id ?>">
                    <div class="form-group photo">
                        <div class="pp">
                            <center><img src="<?= base_url() ?>assets/uploads/member/<?= $profile->foto_profil ?>" id="previewImg" style="height: 94px;width:100%;object-fit:cover;object-position:top" onerror="this.src='<?= base_url() ?>assets/uploads/member/profile_default.png'" /></center>
                        </div>
                        <input type="file" id="pp" name="foto_profil" onchange="previewFile(this);" />
                        <label for="pp" onchange="previewFile(this);">Ganti foto profile</label>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input class="form-control" type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= $profile->nama_lengkap ?>" />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="gender" id="" class="form-control">
                            <option value="laki-laki" <?= $profile->gender == 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="perempuan" <?= $profile->gender == 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tentang Saya</label>
                        <textarea class="form-control" placeholder="Tentang saya" rows="5" name="tentang"><?= $profile->tentang ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Universitas</label>
                        <select class="select" title="Pilih Universitas" id="select_univ" name="univ" value="<?= $profile->universitas ?>" data-live-search="true" data-size="5">

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="<?= $profile->email ?>" />
                    </div>
                    <div class="form-group">
                        <label>Asal Provinsi</label>
                        <select class="select" title="Pilih asal provinsi" name="provinsi_id" value="<?= $profile->provinsi_id ?>" id="select_provinsi" data-live-search="true" data-size="5">
                        </select>
                        <input type="hidden" name="provinsi_name" id="provinsi_name" value="<?= $profile->provinsi_name ?>">
                    </div>
                    <div class="form-group">
                        <label>Asal Kota</label>
                        <select class="select" title="Pilih asal kota" id="select_kota" name="kota" value="<?= $profile->kota ?>" data-live-search="true" data-size="5">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Instansi</label>
                        <input class="form-control" type="text" name="instansi" value="<?= $profile->instansi ?>" />
                    </div>
                    <div class="form-group">
                        <label>No Whatsapp</label>
                        <input class="form-control" type="text" placeholder="No Whatsapp" name="no_wa" value="<?= $profile->no_wa ?>" />
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input class="form-control" type="text" placeholder="Instagram" name="ig" value="<?= $profile->ig ?>" />
                    </div>
                    <div class="form-group">
                        <label>Password <small>(kosongi bila tidak ingin mengganti)</small></label>
                        <input class="form-control" type="text" placeholder="Password Baru" name="password" />
                    </div>
                    <div class="form-group page-topik small">
                        <div class="heading">
                            <label>Topik favorite</label>
                        </div>
                        <div class="page-topik__list">
                            <?php
                            $topik = $this->query->get_data_simple('topik', null)->result();
                            foreach ($topik as $t) { ?>
                                <div class="topik-item">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="topik_<?= $t->id ?>" value="<?= $t->id ?>" type="checkbox" class="topik" name="topik[]" <?= (in_array($t->id, $user_topik)) ? 'checked' : ''; ?> />
                                        <label class="custom-control-label" for="topik_<?= $t->id ?>"><?= $t->nama_topik ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Batal</a><button class="btn btn-primary" type="submit">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    table, th, td {
    border: 1px solid black;
    }
</style>
<div class="modal fade bd-example-modal-lg" id="linkKelasBanyak" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Link Kelas  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="modal-body">
            
            <table > 
                <thead>
                    <tr>
                        <th> Jadwal</th>
                        <th> Nama Materi</th>
                        <th> Link</th>
                    </tr>
                </thead>
                <tbody id="tbodyLink">

                </tbody>
            </table>

        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>