<style>
    .card-payment{
        padding: 20px 30px;
    }

    .rounded-md{
        border-radius: 15px;
    }

    .payment-image{
        max-width: 100px;
    }

    .text-13{
        font-size: 13px;
    }

    .text-14{
        font-size: 14px;
    }
    .fw-bold{
        font-weight: bold;
    }

    .text-underline{
        text-decoration: underline;
    }
    
    .rekening-payment{
        transition: .4s ease-in-out;
    }

    .rekening-payment:hover,.rekening-payment.active{
        box-shadow: 0px 0px 10px rgba(0, 0, 0, .3);
    }
</style>
<input type="hidden" id="kode_transaksi" value="<?= $this->uri->segment(2) ?>">
<div class="w-100 px-md-5 px-3">
    <div class="row my-5 pt-5">
        <div class="col-md-8 col-12">
            <div class="card card-payment rounded-md shadow">
                <div class="header-card">
                    <div class="row mx-0 align-items-center">
                        <h2>Pembayaran</h2>
                        <!-- <div class="bg-primary rounded ml-auto p-2 text-white"> -->
                            <!-- <p>Bayar Sebelum 13 April 2022</p>   -->
                        <!-- </div> -->
                    </div>
                </div>
                <div class="body-card pt-md-4">
                    <div class="row mx-0">
                        <!-- <div class="col-md-6 col-12 p-1">
                            <label class="card p-3 mb-2 rekening-payment" for="payment-bri">
                                <input type="radio" name="payment_channel" id="payment-bri" class="d-none" value="bca">
                                <div class=" payment-image">
                                    <img src="<?= base_url('assets/front/images/logo-bank-bri.png')?>" alt="payment-channel" class="w-100">
                                </div>
                                <div class="d-flex mt-4 mb-3">
                                    <div class="col-6 pl-md-0">
                                        <div class="text-secondary text-13">
                                            Nama Rekening
                                        </div>
                                        <div class="text-14 text-dark">
                                            <b>-- nama --</b> 
                                        </div>
                                    </div>
                                    <div class="col-6 pr-md-0">
                                        <div class="text-secondary text-13">
                                            Nomor Rekaning
                                        </div>
                                        <div class="text-14 text-dark">
                                            <b>-- 123 --</b> 
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div> -->
                        <div class="col-md-6 col-12 p-1">
                            <h4 class="text-capitalize">Rekening tujuan</h4>

                            <label class="card p-3 mb-2 rekening-payment" for="payment-bca">
                                <input type="radio" checked name="payment_channel" id="payment-bca" class="d-none" value="bca">
                                <div class=" payment-image">
                                    <img src="<?= base_url('assets/front/images/logo-bank-bca.png')?>" alt="payment-channel" class="w-100">
                                </div>
                                <div class="d-flex mt-4 mb-3" for="payment-bca">
                                    <div class="col-6 pl-md-0">
                                        <div class="text-secondary text-13">
                                            Nama Rekening
                                        </div>
                                        <div class="text-14 text-dark">
                                            <b>Asclepio Edukasi Medika Indonesia</b> 
                                        </div>
                                    </div>
                                    <div class="col-6 pr-md-0">
                                        <div class="text-secondary text-13">
                                            Nomor Rekaning
                                        </div>
                                        <div class="text-14 text-dark">
                                            <b>4727101020</b> 
                                        </div>
                                        <!-- font awesome copy icon -->
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6 col-6 p-md-2">
                            <h4 class="text-capitalize">Bayar dengan kode QR </h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#qr-modal">Tampilkan Kode QR</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-0 mt-2 my-md-5">
                        <div class="col-md-3 form-group">
                            <label for="nama_bank">Nama Bank</label>
                            <input type="text" placeholder="Nama Bank" class="form-control" value="<?= $user->manual_nama_bank ?>" id="nama_bank">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="rekening_bank">Nama Rekening Pengirim</label>
                            <input type="text" placeholder="Rekening Pengirim" class="form-control" value="<?= $user->manual_nama_rekening ?>" id="rekening_bank">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="norek_bca">Nomor Rekening</label>
                            <input type="text" placeholder="" class="form-control" value="<?= $user->manual_no_rekening ?>" id="norek_bca">
                        </div>
                    </div>
                   
                    <div class="my-md-3 mb-1">
                        <h3 class="text-capitalize">unggah bukti pembayaran</h3>
                        <p class="text-14">*Unggah bukti pembayaran untuk mempermudah verifikasi.</p>
                    </div>
                    <input class="btn btn-success btn-upload" type="file" name="image_bukti" id="image_bukti">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow rounded-md p-3 p-md-4">
                <h4 class="text-capitalize mb-2">rincian pembayaran</h4>
                <hr>
                <table width="100%" class="border-0">
                <?php $total = 0;?>
                <?php foreach($response['transaksi_det'] as $row){ ?>

                    <?php if ($row->diskon != 0){ ?>
                        <tr>
                            <td class="text-13 fw-bold"><?= $row->name ?></td>
                            <td class="text-13 text-right" style="text-decoration:line-through">Rp. <?= number_format($row->harga) ?></td>
                        </tr>
                        <tr>
                            <td class="text-13 fw-bold">Voucher : <?= strtoupper($row->code_voucher) ?></td>
                            <td class="text-13 text-right">Rp. <?= number_format($row->diskon) ?></td>
                        </tr>
                    <?php } else { ?>
                        
                        <tr>
                            <td class="text-13 fw-bold"><?= $row->name ?></td>
                            <td class="text-13 text-right">Rp. <?= number_format($row->total_harga) ?></td>
                        </tr>

                    <?php } ?>
                    <?php $total +=  $row->total_harga ?>

                <?php } ?>
                    <tr>
                        <td colspan="2" class="border-bottom py-3"></td>
                    </tr>
                    <tr>
                        <td class="text-13 fw-bold">Harga Total</td>
                        <td class="text-13 text-right">Rp. <?= number_format($total) ?></td>
                    </tr>


                </table>
                <!-- <a href="#" class=" text-13 text-dark text-underline">Unduh Kwitansi Pembayaran</a> -->
                <button class="btn btn-primary mt-3" type="button" onclick="makeTransactionManual()">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="qr-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Transaksi Dengan kode QR </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row mx-0">
          <div class="col-md-8 mx-auto">
              <img src="<?= base_url('assets/front/images/qr-code.jpg')?>" class="text-center mt-2" alt="">
          </div>
      </div>
    </div>
  </div>
</div>