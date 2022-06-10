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
                    <li><a href="<?= base_url() ?>Admin/setting_caption">
                            <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-seo.svg" alt="ic-seo" /></div><span>Caption Settings</span>
                        </a></li>
                    <li class="active"><a href="<?= base_url() ?>Admin/setting_seo">
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
                    <h3>Pengaturan SEO</h3>
                </div>
            </div>
            <div class="panel settings-seo">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a><a class="nav-item nav-link" id="nav-asclepedia-tab" data-toggle="tab" href="#nav-asclepedia" role="tab" aria-controls="nav-profile" aria-selected="false">Asclepedia</a><a class="nav-item nav-link" id="nav-asclepiogo-tab" data-toggle="tab" href="#nav-asclepiogo" role="tab" aria-controls="nav-contact" aria-selected="false">Asclepio GO</a><a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-contact" aria-selected="false">Tentang Kami</a></div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form action="<?= base_url() ?>Setting/seo_home" method="post">
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input class="form-control" type="text" name="meta_title_home" placeholder="Masukan meta title" value="<?= $home->meta_title ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords <small>(pisahkan dengan tanda koma)</small></label>
                                <input class="form-control" type="text" name="meta_keyword_home" placeholder="Masukan meta keywords" value="<?= $home->meta_keyword ?>" />
                            </div>
                            <div class=" form-group">
                                <label>Meta Desc</label>
                                <textarea class="form-control" name="meta_desc_home" placeholder="Masukan meta desc" rows="5"><?= $home->meta_desc ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-asclepedia" role="tabpanel" aria-labelledby="nav-asclepedia-tab">
                        <form action="<?= base_url() ?>Setting/seo_asclepedia" method="post">
                            <div class="form-group">
                                <label>Meta Title Asclepedia</label>
                                <input class="form-control" type="text" name="meta_title_asclepedia" placeholder="Masukan meta title asclepedia" value="<?= $asclepedia->meta_title ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords Asclepedia <small>(pisahkan dengan tanda koma)</small></label>
                                <input class="form-control" type="text" name="meta_keyword_asclepedia" placeholder="Masukan meta keywords asclepedia" value="<?= $asclepedia->meta_keyword ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Desc Asclepedia</label>
                                <textarea class="form-control" name="meta_desc_asclepedia" placeholder="Masukan meta desc asclepedia" rows="5"><?= $asclepedia->meta_desc ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-asclepiogo" role="tabpanel" aria-labelledby="nav-asclepiogo-tab">
                        <form action="<?= base_url() ?>Setting/seo_asclepio_go" method="post">
                            <div class="form-group">
                                <label>Meta Title Asclepio GO</label>
                                <input class="form-control" type="text" name="meta_title_asclepio_go" placeholder="Masukan meta title asclepio go" value="<?= $asclepio_go->meta_title ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords Asclepio GO <small>(pisahkan dengan tanda koma)</small></label>
                                <input class="form-control" type="text" name="meta_keyword_asclepio_go" placeholder="Masukan meta keywords asclepio go" value="<?= $asclepio_go->meta_keyword ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Desc Asclepio GO</label>
                                <textarea class="form-control" name="meta_desc_asclepio_go" placeholder="Masukan meta desc asclepio go" rows="5"><?= $asclepio_go->meta_desc ?></textarea>
                            </div>
                            <div class="btn-wrap text-right">
                                <button class="btn btn-primary btn-large" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        <form action="<?= base_url() ?>Setting/seo_about" method="post">
                            <div class="form-group">
                                <label>Meta Title Tentang</label>
                                <input class="form-control" type="text" name="meta_title_about" placeholder="Masukan meta title tentang" value="<?= $about->meta_title ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords Tentang <small>(pisahkan dengan tanda koma)</small></label>
                                <input class="form-control" type="text" name="meta_keyword_about" placeholder="Masukan meta keywords tentang" value="<?= $about->meta_keyword ?>" />
                            </div>
                            <div class="form-group">
                                <label>Meta Desc Tentang</label>
                                <textarea class="form-control" name="meta_desc_about" placeholder="Masukan meta desc tentang" rows="5"><?= $about->meta_desc ?></textarea>
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