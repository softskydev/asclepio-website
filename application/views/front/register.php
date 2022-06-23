<section class="login-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <div class="login-page__wrap">
                    <h2>Daftar Asclepio</h2>
                    <div class="form-login">
                        <form action="<?= base_url() ?>Auth/register" method="post">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select name="gelar" id="gelar_doctor" class="form-control" required>
                                            <option value="dr.">dr.</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="S.Keb">S.Keb</option>
                                            <option value="Apt.">Apt.</option>
                                            <option value="Ns.">Ns.</option>
                                            <option value="Bd.">Bd. </option>
                                            <option value="A.Md.Keb">A.Md.Keb</option>
                                            <option value="A.Md.Kep">A.Md.Kep</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <input class="form-control" type="text" name="nama_lengkap" placeholder="Masukan nama lengkap" required />
                                </div>
                                <small id="text-noted" style="color:red;display:none"> *Langsung tulis nama beserta gelar anda </small>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Kelamin</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="gender" class="custom-control-input" value="laki-laki">
                                    <label class="custom-control-label" for="customRadioInline1">Laki-Laki</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="gender" class="custom-control-input" value="perempuan">
                                    <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <label>Nomor WhatsApp</label>
                                <input class="form-control" type="text" name="no_wa" placeholder="Masukan No. WA anda" required />
                            </div>
                            <!-- <div class="form-group">
                                <label>Instagram <small>(optional)</small></label>
                                <input class="form-control" type="text" name="ig" placeholder="Masukan nama instagram anda" />
                            </div> -->
                            <div class="form-group">
                                <label>Asal Provinsi</label>
                                <select class="select" title="Pilih asal provinsi" name="provinsi_id" id="select_provinsi" data-live-search="true" data-size="5" required>
                                </select>
                                <input type="hidden" name="provinsi_name" id="provinsi_name">
                            </div>
                            <div class="form-group">
                                <label>Asal Kota</label>
                                <select class="select" title="Pilih asal kota" id="select_kota" name="kota" data-live-search="true" data-size="5" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Instansi</label>
                                <input class="form-control" type="text" name="instansi" placeholder="Masukan nama instansi asal anda" required />
                            </div>
                            <div class="form-group">
                                <label>Universitas</label>
                                <select class="select" title="Pilih Universitas" id="select_univ" name="univ" data-live-search="true" data-size="5" required>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" id="Password" name="password" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href=""><i class="far fa-eye" aria-hidden="true"></i></a></span>
                                        <!-- <a href=""><i class="far fa-eye-slash" aria-hidden="true"></i></a> -->
                                    </div>
                                </div>
                                <!-- <input class="form-control" type="password" name="password" placeholder="Password" /> -->
                            </div>
                            <div class="form-group">
                                <label>Ketik Ulang Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" id="ConfirmPassword" type="password" name="" placeholder="Ketik Ulang Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href=""><i class="far fa-eye" aria-hidden="true"></i></a></span>
                                        <!-- <a href=""><i class="far fa-eye-slash" aria-hidden="true"></i></a> -->
                                    </div>

                                </div>
                                <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                                <!-- <input class="form-control" type="password" name="password" placeholder="Password" /> -->
                            </div>
                            <!-- <div class="rememberme">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="subs" type="checkbox" />
                                    <label class="custom-control-label" for="subs">Langganan berita asclepio melalui email</label>
                                </div>
                            </div> -->
                            <div class="form-footer">
                                <button class="btn btn-primary btn-register" disabled type="submit">Daftar Akun Baru</button>
                            </div>
                        </form>
                    </div>
                    <div class="register-now">
                        <p>Sudah punya akun? <a href="<?= base_url() ?>login"> Login sekarang </a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-4">
                <?php
                $img = $this->query->get_data_simple('image_auth', ['page' => 'register'])->row()->image;
                ?>
                <img src="<?= base_url() ?>assets/front/images/<?= $img ?>" alt="register-image" class="w-100" />
            </div>
        </div>
    </div>

</section>

<script type="text/javascript">
    
</script>