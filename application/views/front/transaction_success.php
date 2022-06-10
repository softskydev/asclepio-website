<?php
$kelas = $this->query->get_query("SELECT k.*, d.total_harga FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.kode_transaksi = '$data->order_id'")->result();
?>
<div class="page-freebox cart pembayaran success">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel pembayaran__invoice">
                    <h3 class="text-center">Transaksi Sukses!</h3>
                    <div class="icon"><img src="<?= base_url() ?>assets/front/images/invoice-logo.svg" /></div>
                    <div class="content">
                        <?php
                        $user = $this->query->get_query("SELECT u.email FROM transaksi t JOIN user u ON t.user_id = u.id WHERE t.kode_transaksi = '$data->order_id'")->row();
                        ?>
                        <h4>Receipt dan Link Zoom meeting telah dikirim ke email kamu</h4>
                        <p>Transaksi kamu sukses! Asclepio telah mengirim email ke kamu yang berisikan recepit pembayaran serta link zoom meeting dari webinar yang telah kamu pesan. Email akan dikirim kepada <a href="#" class="mail"><?= $user->email ?></a></p>
                    </div>

                    <div class="not-recived-email"><span>Belum menerima email?</span><a class="btn btn-link" id="btn_resend" href="javascript:void(0)" onclick="resend_email('<?= $user->email ?>','<?= $data->order_id ?>')">Kirim ulang Link dan Receipt</a></div>
                    <div class="message-info">
                        <h4>Informasi pemesanan</h4>
                        <div class="row">
                            <div class="col">
                                <div class="ic-label">
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-date.svg" /></div>
                                    <label>Tanggal Order</label>
                                </div><b><?= format_indo(date("Y-m-d", strtotime($data->transaction_time))) ?></b>
                            </div>
                            <div class="col">
                                <div class="ic-label">
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-date.svg" /></div>
                                    <label>Order Pukul</label>
                                </div><b><?= date("H:i", strtotime($data->transaction_time)) ?> WIB</b>
                            </div>
                            <div class="col">
                                <div class="ic-label">
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-date.svg" /></div>
                                    <label>Pembayaran</label>
                                </div>
                                <?php
                                if ($data->payment_type == 'bank_transfer') {
                                    $payment = 'Bank Transfer ' . strtoupper($data->va_numbers[0]->bank);
                                } else if ($data->payment_type == 'credit_card') {
                                    $payment = 'Credit Card' . ' ' . strtoupper($data->bank);
                                } else if ($data->payment_type == 'cstore') {
                                    $payment = $data->store;
                                } else {
                                    $payment = $data->payment_type;
                                }
                                ?>
                                <b><?= $payment ?></b>
                            </div>
                            <div class="col">
                                <div class="ic-label">
                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-date.svg" /></div>
                                    <label>Invoice</label>
                                </div><b><?= $data->order_id ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="webinar">
                        <h4>Webinar yang dipesan</h4>
                        <div class="wrap-box-card listview">
                            <?php

                            foreach ($kelas as $k) {
                                if ($k->jenis_kelas == 'asclepedia') {
                                    $kategori = $k->kategori_kelas;
                                    if ($k->kategori_kelas == 'good morning knowledge') {
                                        $label = '<span class="tag tag">Good Morning Knowledge</span>';
                                    } else {
                                        $label = '<span class="tag tag-scndry">Skills Lab</span>';
                                    }
                                } else {
                                    $kategori = $k->kategori_go;
                                    if ($k->kategori_go == 'open') {
                                        if ($data->gross_amount == 0) {
                                            $tag = 'FREE';
                                        } else {
                                            $tag = 'PREMIUM';
                                        }
                                        $label = '<span class="tag tag-open">Open Class | ' . $tag . '</span>';
                                    } else if ($k->kategori_go == 'expert') {
                                        $label = '<span class="tag tag-expert">Expert Class</span>';
                                    } else {
                                        $label = '<span class="tag tag-private">Private Class</span>';
                                    }
                                }
                            ?>
                                <div class="box-card">
                                    <div class="box-card__content">
                                        <div class="box-card__text"><?= $label ?>
                                            <h4><?= $k->judul_kelas ?></h4>
                                        </div>
                                        <div class="box-card__footer">
                                            <div class="author">
                                                <?php
                                                $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
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
                                                <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
                                            </div>
                                            <div class="price">Rp <?= rupiah($k->total_harga) ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>