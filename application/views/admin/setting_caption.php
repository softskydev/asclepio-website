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
                    <li><a href="<?= base_url() ?>Admin/setting_auth">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-home.svg" alt="ic-auth" /></div><span>Register/Login</span>
                        </a></li>
                    <li class="active"><a href="<?= base_url() ?>Admin/setting_caption">
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
                    <h3>Pengaturan Caption</h3>
                </div>
            </div>
            <div class="panel settings-seo">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a><a class="nav-item nav-link" id="nav-asclepedia-tab" data-toggle="tab" href="#nav-asclepedia" role="tab" aria-controls="nav-profile" aria-selected="false">Asclepedia</a><a class="nav-item nav-link" id="nav-asclepiogo-tab" data-toggle="tab" href="#nav-asclepiogo" role="tab" aria-controls="nav-contact" aria-selected="false">Asclepio GO</a><a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-contact" aria-selected="false">Tentang Kami</a></div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form action="<?= base_url() ?>Setting/capt_home" method="post">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title_home" placeholder="Masukan title" value="<?= $data->title_home ?>" />
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea id="" rows="5" name="desc_home" class="form-control editor"><?= $data->desc_home ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-asclepedia" role="tabpanel" aria-labelledby="nav-asclepedia-tab">
                        <form action="<?= base_url() ?>Setting/capt_asclepedia" method="post">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title_asclepedia" placeholder="Masukan title" value="<?= $data->title_asclepedia ?>" />
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea id="" rows="5" name="desc_asclepedia" class="form-control editor"><?= $data->desc_asclepedia ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-asclepiogo" role="tabpanel" aria-labelledby="nav-asclepiogo-tab">
                        <form action="<?= base_url() ?>Setting/capt_asclepiogo" method="post">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title_asclepiogo" placeholder="Masukan title" value="<?= $data->title_asclepiogo ?>" />
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea id="" rows="5" name="desc_asclepiogo" class="form-control editor"><?= $data->desc_asclepiogo ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        <form action="<?= base_url() ?>Setting/capt_about" method="post">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title_about" placeholder="Masukan title" value="<?= $data->title_about ?>" />
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea id="" rows="5" name="desc_about" class="form-control editor"><?= $data->desc_about ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>