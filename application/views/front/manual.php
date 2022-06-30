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

<div class="w-100 px-md-5 px-3">
    <div class="row my-5 pt-5">
        <div class="col-md-8 col-12">
            <div class="card card-payment rounded-md shadow">
                <div class="header-card">
                    <div class="row mx-0 align-items-center">
                        <h2>Pembayaran</h2>
                        <div class="bg-primary rounded ml-auto p-2 text-white">
                            <p>Bayar Sebelum 13 April 2022</p>  
                        </div>
                    </div>
                </div>
                <div class="body-card pt-md-4">
                    <h4 class="text-capitalize">Rekening tujuan</h4>
                    <div class="row mx-0">
                        <div class="col-md-6 col-12 p-1">
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
                                        <!-- font awesome copy icon -->
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6 col-12 p-1">
                            <label class="card p-3 mb-2 rekening-payment" for="payment-bca">
                                <input type="radio" name="payment_channel" id="payment-bca" class="d-none" value="bca">
                                <div class=" payment-image">
                                    <img src="<?= base_url('assets/front/images/logo-bank-bca.png')?>" alt="payment-channel" class="w-100">
                                </div>
                                <div class="d-flex mt-4 mb-3" for="payment-bca">
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
                                        <!-- font awesome copy icon -->
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-0 mt-2 my-md-5">
                        <div class="col-md-6">
                            <h4>Dari Bank</h4>
                            <img src="<?= base_url('assets/front/images/logo-bank-bca.png')?>" alt="from_bank" class="payment-image">
                        </div>
                        <div class="col-md-6">
                            <h4>Nomor Rekening</h4>
                            <h6 class="text-secondary">0092189310219847</h6>
                        </div>
                    </div>
                    <div class="mt-2 mt-md-5 mb-md-5">
                        <h4 class="text-capitalize">Harga Total</h4>
                        <h3 class="text-capitalize px-4 py-1 bg-secondary text-white col-md-4 col-8 text-center rounded">Rp. 998.000,00</h3>
                    </div>
                    <div class="my-md-3 mb-1">
                        <h3 class="text-capitalize">unggah bukti pembayaran</h3>
                        <p class="text-14">*Unggah bukti pembayaran untuk mempermudah verifikasi.</p>
                    </div>
                    <input class="btn btn-success btn-upload" type="file" name="" id="">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow rounded-md p-3 p-md-4">
                <h4 class="text-capitalize mb-2">rincian pembayaran</h4>
                <hr>
                <table width="100%" class="border-0">
                    <tr>
                        <td class="text-13 fw-bold">Product name</td>
                        <td class="text-13 text-right">Rp. 1.000.000,00</td>
                    </tr>
                    <tr>
                        <td class="text-13 fw-bold">Voucher</td>
                        <td class="text-13 text-right">Rp. 2.000,00</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border-bottom py-3"></td>
                    </tr>
                    <tr>
                        <td class="text-13 fw-bold">Total</td>
                        <td class="text-13 text-right">Rp. 998.000,00</td>
                    </tr>
                </table>
                <a href="#" class=" text-13 text-dark text-underline">Unduh Kwitansi Pembayaran</a>
                <button class="btn btn-primary mt-3">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>
</div>
