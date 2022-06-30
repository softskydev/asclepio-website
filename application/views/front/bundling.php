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
        <div class="col-md-8 col-12 mx-auto">
            <div class="card card-payment rounded-md shadow">
                <div class="header-card">
                    <div class=" text-center">
                        <h2>Aclepedia Bundling</h2>
                    </div>
                </div>
                <div class="body-card pt-md-4">
                    <form action="<?= base_url() ?>Booking/buyBundling/" method="POST" id="form-bundling">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="full_name">Full name</label>
                                <input type="text" class="form-control" value="<?= $detail->nama_lengkap ?>" id="full_name" name="full_name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" value="<?= $detail->email ?>" id="email" name="email" placeholder="email@example.com" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone_number">Number Phone</label>
                                <input type="text" class="form-control" id="phone_number" value="<?= $detail->no_wa ?>" name="phone_number" placeholder="" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postcode">Post Code</label>
                                <input type="text" class="form-control" id="postcode"  value="<?= $detail->postal_code ?>" name="postcode" placeholder="" required>
                            </div>

                            <input type="hidden" name="kelas_id" id="kelas_id" value="<?= $kelas_id ?>">
                            <div class="form-group col-md-6">
                                <label for="expedition"> Expedition</label>
                                <select class="form-control" id="expedition" name="expedition" required>
                                    <option Value="0" disabled selected>Select Expedition</option>
                                    <option Value="j&t">J&T</option>
                                    <option Value="sicepat">SiCepat</option>
                                </select>
                            </div>
                            <div class="form-check col-md-6" style="padding-left: 1rem">
                                <label for="">Methode Checkout</label>
                                <br>
                                <input class="form-check-inputmr-" required type="radio" name="metode_pembayaran" id="manual" value="manual" >
                                <label class="form-check-label" for="manual">
                                    Manual (Mengirim Bukti Transfer)
                                </label>
                                <br>

                                <input class="form-check-inputmr-" required type="radio" name="metode_pembayaran" id="oto" value="otomatis" >
                                <label class="form-check-label" for="oto">
                                    Otomatis (Di Cek Otomatis)
                                </label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" required minlength="10" rows="6" name="address" placeholder="Full Address"><?= $detail->address ?></textarea>
                            </div>
                            <div class="ml-auto px-3">
                                <button type="submit" class="btn btn-primary px-5 mt-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
