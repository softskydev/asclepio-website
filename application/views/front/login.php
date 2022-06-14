<section class="login-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <div class="login-page__wrap">
                    <h2>Masuk Asclepio</h2>
                    <div class="form-login">
                        <form action="<?= base_url() ?>Auth/login" method="post">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" value="<?= get_cookie('asclepio_email') ?>" />
                            </div>
                            <input type="hidden" name="url" value="<?= (isset($_GET['url'])) ? $_GET['url'] : '' ?>">
                            <div class="form-group">
                                <label>Password</label>
                                <!-- <input class="form-control" type="password" name="password" placeholder="Password" /> -->
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" name="password" placeholder="Password" value="<?= get_cookie('asclepio_password') ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href=""><i class="far fa-eye" aria-hidden="true"></i></a></span>
                                        <!-- <a href=""><i class="far fa-eye-slash" aria-hidden="true"></i></a> -->
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="<?= $_GET['token'] ?? '' ?>" name="token">
                            <div class="rememberme">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberme" type="checkbox" name="remember"/>
                                    <label class="custom-control-label" for="rememberme">Ingat saya</label>
                                </div>
                                <div class="lostpasswrd"><a href="#mdl_lost" data-toggle="modal" data-target="#mdl_lost">Lupa password ?</a></div>
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary" type="submit">Masuk</button>
                            </div>
                        </form>
                    </div>
                    <div class="register-now">
                        <p>Belum punya akun? <a href="<?= base_url() ?>register"> Daftar sekarang </a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-4">
                <?php
                $img = $this->query->get_data_simple('image_auth', ['page' => 'login'])->row()->image;
                ?>
                <img src="<?= base_url() ?>assets/front/images/<?= $img ?>" alt="login-image" class="w-100" />
            </div>
        </div>
    </div>

</section>

<div class="modal mdl_lost" id="mdl_lost" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Lupa Password</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/front/images/ic-xclose.svg" /></a>
                <form action="<?= base_url() ?>Auth/reset_password" method="post">
                    <div class="form-group">
                        <label for="">Masukkan Email Anda <small>(email baru anda akan dikirim ke email)</small></label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>