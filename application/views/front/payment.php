<?php
$this->load->helper('text');
// $product_name = $this->query->get_data('judul_kelas', 'kelas', ['id' => $transaction->product_id])->row()->judul_kelas;
$product  = $this->query->get_query("SELECT k.judul_kelas,d.total_harga FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.id = d.product_id AND t.kode_transaksi = '" . $this->uri->segment('2') . "' ")->result();
$order_id = $this->uri->segment(2);
$email    = $this->query->get_data('email', 'user', ['id'  => $this->session->userdata('id')])->row()->email;
?>
<div class="page-freebox cart pembayaran">
    <div class="container">
        <div class="page_title">
            <h2>Pembayaran</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel pembayaran__invoice">
                    <div class="content">
                        <div class="icon"><img src="<?= base_url() ?>assets/front/images/invoice-logo.svg" /></div>
                        <h3>Invoice akan dikirim ke email kamu</h3>
                        <p>Begitu kamu selesai melakukan pembayaran, Asclepio akan mengirim email ke kamu yang berisikan receipt pembayaran serta link zoom meeting dari webinar yang kamu pesan.</p>
                    </div>
                    <div class="not-recived-email text-center"><span>Belum menerima email Invoice?</span><a class="btn btn-link" id="btn_resend" href="javascript:void(0)" onclick="resend_invoice('<?= $email ?>','<?= $order_id ?>')">Kirim ulang Invoice</a></div>
                    <div class="notif-box">
                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-alert-circle.svg" /></div>
                        <div class="text">
                            <p>khusus untuk pemesanan kelas <b>expert</b> dan <b>private</b>, kamu akan diarahkan menuju whatsapp asclepio setelah kamu menyelesaikan pembayaran.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="panel pembayaran__method">
                    <div class="panel__title">
                        <h3>Pilih metode pembayaran</h3>
                        <div class="pembayaran__method-item">
                            <p>Bank Transfer</p>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="methode_bni" type="radio" name="method_pay" data-name="bni" />
                                <label class="custom-control-label" for="methode_bni">
                                    <div class="name">Bank BNI</div>
                                    <div class="logo"><img src="<?= base_url() ?>assets/front/images/logo-bank-bni.png" /></div>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="methode_bca" type="radio" name="method_pay" data-name="bca" />
                                <label class="custom-control-label" for="methode_bca">
                                    <div class="name">Bank BCA</div>
                                    <div class="logo"><img src="<?= base_url() ?>assets/front/images/logo-bank-bca.png" /></div>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="methode_bri" type="radio" name="method_pay" data-name="bri" />
                                <label class="custom-control-label" for="methode_bri">
                                    <div class="name">Bank BRI</div>
                                    <div class="logo"><img src="<?= base_url() ?>assets/front/images/logo-bank-bri.png" /></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="col-md-4">
                <!-- <?php
                        if ($transaction->code_voucher != '') { ?>
                    <div class="panel voucher">
                        <div class="form-group voucher__used">
                            <label>Voucher Kamu</label>
                            <p>Voucher <?= $transaction->code_voucher ?> telah berhasil digunakan!</p>
                        </div>
                    </div>
                <?php } ?> -->
                <div class="panel cart__total">
                    <h3>Total</h3>
                    <ul class="total__detail">
                        <?php
                        foreach ($product as $p) { ?>
                            <li>
                                <div class="left"><span><?= character_limiter($p->judul_kelas, 20)  ?></span></div>
                                <div class="right text-right"><span>Rp <?= rupiah($p->total_harga) ?></span></div>
                            </li>
                        <?php } ?>
                        <!-- <?php
                                if ($transaction->code_voucher != '') { ?>
                            <li class="discount">
                                <div class="left"><span><?= $transaction->code_voucher ?></span></div>
                                <div class="right text-right"><span>Rp -<?= rupiah($transaction->diskon) ?></span></div>
                            </li>
                        <?php } ?> -->
                        <li class="grandtotal">
                            <div class="left"><span>Total Harga</span></div>
                            <div class="right text-right"><span>Rp <?= rupiah($transaction->total) ?></span></div>
                        </li>
                    </ul>
                    <!-- <a href="<?= base_url() ?>Booking/manualPayment/<?= $order_id ?>" class="btn text-white btn-block" style="background:#25d366;">Pembayaran Manual</a> <br> -->
                    <a class="btn btn-primary btn-block" href="javascript:void(0)" onclick="makePayment('<?= $transaction->kode_transaksi ?>')">Bayar</a>
                </div>
            </div>
        </div>
    </div>
</div>