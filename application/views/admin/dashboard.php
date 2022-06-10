<section class="page-heading">
    <div class="left">
        <h2>Dashboard Summary</h2>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Stat</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="box-card card-stat">
                <?php
                $pemasukan = $this->query->get_query("SELECT SUM(d.total_harga) AS pemasukan FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success' AND MONTH(t.tgl_pembelian)=MONTH(now())")->row()->pemasukan;
                ?>
                <h4>Total Pemasukan Bulan ini</h4><b>Rp, <?= rupiah($pemasukan) ?></b>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box-card card-stat">
                <?php
                $member = $this->query->get_query('SELECT COUNT(id) as member FROM user')->row()->member;
                ?>
                <h4>Total Member</h4><b><?= rupiah($member) ?></b>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box-card card-stat">
                <?php
                $pemateri = $this->query->get_query('SELECT COUNT(id) as pemateri FROM pemateri WHERE is_delete = 0')->row()->pemateri;
                ?>
                <h4>Total Pembicara</h4><b><?= rupiah($pemateri) ?></b>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box-card card-stat">
                <?php
                $kelas = $this->query->get_query('SELECT COUNT(id) as kelas FROM kelas WHERE is_delete = 0')->row()->kelas;
                ?>
                <h4>Total kelas yang dibuat</h4><b><?= rupiah($kelas) ?></b>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="row">

        <div class="col-md-6">
            <div class="section-heading">
                <div class="left">
                    <h3>Best seller class</h3>
                </div>
                <!-- <div class="right">
                    <select class="select" title="All Title">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                    </select>
                </div> -->
            </div>

            <div class="panel best-seller">
                <?php
                $best = $this->query->get_query("SELECT k.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id GROUP BY k.`judul_kelas` ORDER BY COUNT(d.`product_id`) DESC LIMIT 3")->result();
                foreach ($best as $b) {
                    if ($b->jenis_kelas == 'asclepedia') {
                        $kategori = $b->kategori_kelas;
                    } else {
                        $kategori = $b->kategori_go;
                    }
                ?>
                    <div class="best-seller__item">
                        <div class="class_name">
                            <h4><a href="#"><?= $b->judul_kelas ?></a></h4>
                            <div class="cate-date"><small><?= $kategori ?></small><small><?= format_indo($b->tgl_kelas) ?></small></div>
                        </div>
                        <div class="buyer">
                            <label>Pembeli</label><b><?php echo $this->query->get_query("SELECT COUNT(t.`user_id`) as pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` WHERE t.status = 'paid' AND d.status = 'success' AND d.product_id = $b->id")->row()->pembeli ?></b>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section-heading">
                <div class="left">
                    <h3>Total penjualan hari ini</h3>
                </div>
            </div>
            <div class="panel">
                <div class="pendapatan">
                    <?php $income_today = $this->query->get_query("SELECT SUM(total) AS total FROM transaksi WHERE `status` = 'paid' AND DATE(tgl_pembelian) = CURDATE()")->row()->total ?>
                    <label>Pendapatan hari ini</label><b>Rp, <?= rupiah($income_today) ?></b>
                </div>
                <div class="wrap-box-card listview most-buyclass">
                    <h4>Kelas terbeli terbanyak hari ini</h4>
                    <div class="box-card">
                        <div class="box-card__content">
                            <div class="box-card__text">
                                <?php $terlaris = $this->query->get_query("SELECT k.id,k.`judul_kelas`,k.`jenis_kelas`,k.`kategori_kelas`,k.`kategori_go`,k.`tgl_kelas`,SUM(t.total) AS total, COUNT(t.user_id) AS pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.status = 'paid' AND DATE(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id ORDER BY pembeli DESC")->row();
                                if (!$terlaris) {
                                ?>
                                    <h4>Belum ada data hari ini</h4>
                                <?php } else {
                                    if ($terlaris->jenis_kelas == 'asclepedia') {
                                        $kategori = $terlaris->kategori_kelas;
                                    } else {
                                        $kategori = $terlaris->kategori_go;
                                    }
                                ?>
                                    <h4><?= $terlaris->judul_kelas ?></h4><small><?= $kategori ?> • <?= format_indo($terlaris->tgl_kelas) ?></small>
                                    <div class="box-card__footer">
                                        <div class="author">
                                            <?php
                                            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $terlaris->id")->result();
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
                                            <!-- <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="section-heading">
                <div class="left">
                    <h3>Total Peserta 2021</h3>
                </div>
            </div>
            <div class="panel">
                <canvas id="myChart" width="100%"></canvas>
            </div>

        </div>
    </div>
</section>