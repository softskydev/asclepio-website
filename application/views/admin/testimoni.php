<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right">
        <a href="<?= base_url() ?>Testimoni/export_rating" class="btn btn-transparent">
            <div class="icon">
                <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
            </div>
            <span>Download Data Rating</span>
        </a>
        <a href="<?= base_url() ?>Testimoni/export" class="btn btn-transparent">
            <div class="icon">
                <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
            </div>
            <span>Download Data Testimoni</span>
        </a>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Data Rating</h3>
        </div>
        <div class="right">
            <select class="select" id="sort" onchange="sortBy(this.value)">
                <option value="terbaru">Terbaru</option>
                <option value="terlama">Terlama</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" type="text" placeholder="Search" id="search" onkeyup="search(this.value)" />
                </div>
            </div>

        </div>
    </div>
    <div class="benefits-table">
        <table class="table">
            <thead>
                <tr>
                    <th><span>Judul Kelas</span></th>
                    <th><span>Rating</span></th>
                    <th><span>Jumlah Pengulas</span></th>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
        <div class="pagination-box">
            <div class="pag-list"></div>
            <select class="select" onchange="setLimit(this.value)">
                <option value="4">4 items</option>
                <option value="8">8 items</option>
                <option value="12">12 items</option>
            </select>
        </div>
    </div>
</section>
<section class="section benefits-table">
    <div class="row wrap-box-card">
        <div class="row" id="box-testi">
            <!-- <?php foreach ($testimoni as $testi) { ?>
                <div class="col-md-3 mb-3">
                    <div class="box-card card-pemateri">
                        <div class="box-card__namepos">
                            <h3><?= $testi->judul_kelas ?></h3>
                            <p>“<?= $testi->ulasan ?>”</p>
                            <div class="writer-rating">
                                <div class="rating" style="display: inline-flex;"><?= start_created($testi->rating) ?></div>
                                <div class="writer">
                                    <div class="name"><?= $testi->nama_lengkap ?></div>
                                    <small class="position"><?= $testi->universitas ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="action">
                            <div class="dot"><img src="<?= base_url() ?>assets/admin/images/ic-three-dots.svg" /></div>
                            <div class="action-sub">
                                <ul>
                                    <li class="dlt"><a href="<?= base_url() ?>Testimoni/delete_testi/<?= $testi->id ?>">Remove</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?> -->
        </div>
        <div class="pagination-box">
            <div class="pag-list-testi"></div>
        </div>
    </div>
</section>