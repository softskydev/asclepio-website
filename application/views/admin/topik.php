<section class="page-heading">
    <div class="left">
        <h2>Master Topik</h2>
    </div>
    <div class="right">
        <!-- <a class="btn btn-transparent" href="#editTopik" data-toggle="modal" data-target="#editTopik">Edit Topik</a> -->
        <a class="btn btn-primary" href="#addTopik" data-toggle="modal" data-target="#addTopik">Tambah Topik</a>
    </div>
</section>
<section class="section">
    <div class="row">
        <div class="col-md-3">
            <div class="section-heading">
                <div class="left">
                    <h3>List Topik</h3>
                </div>
            </div>
            <style>
                .topik_option {
                    position: absolute;
                    right: 0;
                    margin: auto;
                    width: 100px;
                    height: auto;
                    /* border: 1px solid grey; */
                    margin-top: -50px;
                    margin-right: -100px;
                    z-index: 99;
                    background: white !important;
                    display: none;
                }

                .menu-list-topik li.open_menu .topik_option {
                    display: block;
                }

                .topik_option li a {
                    background: white !important;
                    color: black;
                }
            </style>
            <div class="menu-list-topik">
                <ul>
                    <?php
                    $query = $this->query->get_data_simple('topik', ['is_delete' => 0])->result();
                    $count = 1;
                    foreach ($query as $t) {
                    ?>
                        <li class="<?= ($count == 1) ? 'active' : ''; ?>" data-value="<?= $t->id ?>">
                            <a onclick="getKelas(<?= $t->id ?>)"><?= $t->nama_topik ?> <i class="far fa-ellipsis-h fa-rotate-90 option_menu" style="float: right;margin-top:3px"></i></a>
                            <ul class="topik_option">
                                <li><a href="#" onclick="edit(<?= $t->id ?>)">Edit</a></li>
                                <li><a href="<?= base_url() ?>Topik/delete/<?= $t->id ?>" class="text-danger">Remove</a></li>
                            </ul>
                        </li>
                    <?php
                        $count++;
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="wrap-box-card listview">
                <div class="section-heading">
                    <div class="left">
                        <h3>Kelas</h3>
                    </div>
                    <div class="right"><small>
                            <font id="count_kelas"></font> kelas ditemukan
                        </small></div>
                </div>
                <div id="box_kelas"></div>
                <!-- <div class="box-card">
                    <div class="box-card__img"><img src="<?= base_url() ?>assets/admin/images/img-thumbnail-semisquare-01.png" /></div>
                    <div class="box-card__content">
                        <div class="box-card__text"><span class="tag tag-open">Open Class</span>
                            <h4>Siap Tanggapi Trauma Urogenital serta aplikasi desain website.</h4>
                            <ul class="schedule">
                                <ul>
                                    <li>
                                        <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-date.svg" /></div><span>16 Aug 2020</span>
                                    </li>
                                    <li>
                                        <div class="ic"><img src="<?= base_url() ?>assets/admin/images/ic-time.svg" /></div><span>20:00 - 22:30 WIB</span>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                        <div class="box-card__footer">
                            <div class="author">
                                <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                            </div>
                            <div class="price">Rp. 150,000</div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<div class="modal" id="addTopik" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Menambahkan Topik</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <form method="post" action="<?= base_url() ?>Topik/save">
                    <div class="form-group">
                        <label>Nama Topik</label>
                        <input class="form-control" type="text" placeholder="Masukan nama topik baru" name="nama_topik" />
                    </div>
                    <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Cancel</a><button class="btn btn-primary" type="submit">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal edit-topik" id="editTopik" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Edit Topik</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <form method="post" action="<?= base_url() ?>Topik/update/">
                    <div class="form-group">
                        <label>Nama Topik</label>
                        <input type="hidden" name="id_topik_edit" id="id_topik_edit">
                        <input class="form-control" type="text" name="nama_topik_edit" id="nama_topik_edit" />
                    </div>
                    <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Cancel</a><button class="btn btn-primary" type="submit">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal delete-topik" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="icon"><img src="<?= base_url() ?>assets/admin/images/logo-delete.svg" alt="icon-delete" /></div>
                <div class="text">
                    <h3>Hapus Topik?</h3>
                    <p>Anda akan menghapus 4 topik. Apakah anda yakin?</p>
                </div>
                <div class="btn-wrap"><a class="btn btn-link" href="#">Batal</a><a class="btn btn-primary" href="#" data-dismiss="modal">Hapus</a></div>
            </div>
        </div>
    </div>
</div>