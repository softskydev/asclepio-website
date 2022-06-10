<section class="page-heading">
    <div class="left">
        <h2>Settings</h2>
    </div>
</section>
<section class="section settings">
    <div class="row">
        <div class="col-md-3">
            <div class="section-heading">
                <div class="left">
                    <h3>Opsi</h3>
                </div>
            </div>
            <div class="menu-settings">
                <ul>
                    <li class="active"><a href="<?= base_url() ?>Admin/setting_auth">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-home.svg" alt="ic-auth" /></div><span>Register/Login</span>
                        </a></li>
                    <li><a href="<?= base_url() ?>Admin/setting_caption">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-seo.svg" alt="ic-seo" /></div><span>Caption Settings</span>
                        </a></li>
                    <li><a href="<?= base_url() ?>Admin/setting_seo">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-seo.svg" alt="ic-seo" /></div><span>SEO Settings</span>
                        </a></li>
                    <!-- <li><a href="#">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-kuisioner.svg" alt="ic-kuisioner" /></div><span>Kuisioner</span>
                        </a></li> -->
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="section-heading">
                <div class="left">
                    <h3>Register & Login Photo Settings</h3>
                </div>
            </div>
            <div class="panel settings-change-img">
                <form action="<?= base_url() ?>Setting/auth" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Register | Existing</label>
                            <img src="<?= base_url() ?>assets/front/images/<?= $register->image ?>" style="height: 300px;" alt="">
                            <label for="">Upload jika ingin mengubah gambar</label>
                            <div class="drop-box">
                                <input class="inputfile" id="imgRegister" type="file" name="register" />
                                <div class="placeholder">
                                    <div class="ic-upload"><img src="<?= base_url() ?>assets/admin/images/ic-upload.svg" /></div>
                                    <div class="box-btn">
                                        <label class="btn-add-photo" for="imgRegister">Drag & drop multiple file or <a class='btn-add-photo' for="imgRegister"> browse </a> file here</label><span>files required .png .jpg</span>
                                    </div>
                                </div>
                                <div class="image-preview" style="background-image: url()"></div><a class="del-btn">Hapus</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Login | Existing</label>
                            <img src="<?= base_url() ?>assets/front/images/<?= $login->image ?>" style="height: 300px;" alt="">
                            <label for="">Upload jika ingin mengubah gambar</label>
                            <div class="drop-box">
                                <input class="inputfile" id="imgLogin" type="file" name="login" />
                                <div class="placeholder">
                                    <div class="ic-upload"><img src="<?= base_url() ?>assets/admin/images/ic-upload.svg" /></div>
                                    <div class="box-btn">
                                        <label class="btn-add-photo" for="imgLogin">Drag & drop multiple file or <a class='btn-add-photo' for="imgLogin"> browse </a> file here</label><span>files required .png .jpg</span>
                                    </div>
                                    <div class="image-preview" style="background-image: url()"></div>
                                </div>
                                <div class="image-preview" style="background-image: url()"></div><a class="del-btn">Hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn-wrap text-right"><button type="submit" class="btn btn-primary btn-large">Simpan Perubahan</button></div>
                </form>

            </div>
        </div>
    </div>
</section>