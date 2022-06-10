<div class="page-freebox pembayaran__waiting">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page_title">
                    <div class="countdown">
                        <h3>Selesaikan pembayaran pada</h3>
                        <div class="countdown__time">
                            <style>
                                .countdown__time ul li {
                                    display: inline-block;
                                }
                            </style>
                            <ul>
                                <li><span class="hours">00</span>
                                </li>
                                <li class="seperator">:</li>
                                <li><span class="minutes">00</span>
                                </li>
                                <li class="seperator">:</li>
                                <li><span class="seconds">00</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="expired">
                        <p>Batas akhir pembayaran</p><span><?= format_indo(date("Y-m-d", strtotime($data->transaction_time)))  ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="pembayaran__selected">
                    <?php
                    if ($data->payment_type == 'bank_transfer') {
                        if (property_exists($data, 'permata_va_number')) {
                            $payment = 'Bank Transfer Permata';
                            $pay_to = $data->permata_va_number;
                            $label = 'Virtual Account';
                        } else {
                            $payment = 'Bank Transfer ' . strtoupper($data->va_numbers[0]->bank);
                            $pay_to = $data->va_numbers[0]->va_number;
                            $label = 'Virtual Account';
                        }
                    } else if ($data->payment_type == 'cstore') {
                        $payment = $data->store;
                        $pay_to = $data->payment_code;
                        $label = 'Kode Pembayaran';
                    } else if ($data->payment_type == 'echannel') {
                        $payment = $data->payment_type;
                        $pay_to = $data->bill_key;
                        $label = 'Kode Pembayaran';
                    } else if ($data->payment_type == 'gopay') {
                        $payment = 'Gopay';
                    } else if ($data->payment_type == 'qris') {
                        $payment = 'QRIS';
                    } ?>
                    <div class="left">
                        <label><?= $payment ?></label>
                    </div>
                </div>
                <div class="panel pembayaran__account">
                    <?php
                    if ($data->payment_type == 'echannel') { ?>
                        <div class="pembayaran__account-item">
                            <label>Kode Perusahaan</label>
                            <div class="account_no"><input type="text" id="biller" value="<?= $data->biller_code ?>" class="form-control text-center" style="font-size: 30px;font-weight:bold" readonly></div>
                            <a class="copy" href="javascript:void(0)" id="copyBtnBiller">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Salin</span>
                            </a>
                        </div>
                        <div class="pembayaran__account-item">
                            <label><?= $label ?></label>
                            <div class="account_no" id="rekening"><input type="text" id="noRek" value="<?= $pay_to ?>" class="form-control text-center" style="font-size: 30px;font-weight:bold" readonly></div>
                            <a class="copy" href="javascript:void(0)" id="copyBtn">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Salin</span>
                            </a>
                        </div>
                    <?php } ?>
                    <?php
                    if ($data->payment_type == 'gopay') { ?>
                        <div class="pembayaran__account-item">
                            <label>QR Code</label>
                            <center>
                                <img src="https://api.veritrans.co.id/v2/gopay/<?= $data->transaction_id ?>/qr-code" alt="" style="width: 80%;">
                            </center>
                        </div>
                    <?php } ?>
                    <?php
                    if ($data->payment_type == 'qris') { ?>
                        <div class="pembayaran__account-item">
                            <label>QR Code</label>
                            <center>
                                <img src="https://api.veritrans.co.id/v2/qris/shopeepay/sppq_<?= $data->transaction_id ?>/qr-code" alt="" style="width: 80%;">
                            </center>
                        </div>
                    <?php } ?>
                    <?php
                    if ($data->payment_type == 'bank_transfer' || $data->payment_type == 'cstore') { ?>
                        <div class="pembayaran__account-item">
                            <label><?= $label ?></label>
                            <div class="account_no" id="rekening"><input type="text" id="noRek" value="<?= $pay_to ?>" class="form-control text-center" style="font-size: 30px;font-weight:bold" readonly></div>
                            <a class="copy" href="javascript:void(0)" id="copyBtn">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Salin</span>
                            </a>
                        </div>
                    <?php } ?>

                    <div class="pembayaran__account-item">
                        <label>Total pembayaran</label>
                        <div class="total">Rp <?= rupiah($data->gross_amount) ?>,-</div>
                    </div>
                </div>
                <div class="panel pembayaran__invoice">
                    <div class="content">
                        <div class="icon"><img src="<?= base_url() ?>assets/front/images/invoice-logo.svg" /></div>
                        <h4>Receipt dan Link Zoom meeting akan dikirim ke email kamu</h4>
                        <p>Begitu kamu selesai melakukan pembayaran, Asclepio akan mengirim email ke kamu yang berisikan receipt pembayaran serta link zoom meeting dari webinar yang kamu pesan</p>
                    </div>
                    <div class="notif-box">
                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-alert-circle.svg" /></div>
                        <div class="text">
                            <p>khusus untuk pemesanan kelas expert dan private, kamu akan diarahkan menuju whatsapp asclepio setelah kamu menyelesaikan pembayaran.</p>
                        </div>
                    </div>
                </div>
                <div class="btn-wrap"><a class="btn btn-primary" href="javascript:void(0)" onclick="window.location.reload()">Cek Status Pemesanan</a></div>
            </div>
        </div>
    </div>
</div>
<?php
if ($data->payment_type == 'bank_transfer' || $data->payment_type == 'cstore' || $data->payment_type == 'echannel' || $data->payment_type == 'gopay') {
?>
    <script type="text/javascript">
        var exp = '<?= date("m/d/Y H:i:s", strtotime("+3 hour", strtotime($data->transaction_time)));  ?>';
    </script>
<?php } else if ($data->payment_type == 'qris') {
    $payment = $data->payment_type;
?>
    <script type="text/javascript">
        var exp = '<?= date("m/d/Y H:i:s", strtotime("+1 hour", strtotime($data->transaction_time)));  ?>';
    </script>
<?php } ?>