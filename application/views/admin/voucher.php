<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right"><a class="btn btn-primary" href="#addVoucher" data-toggle="modal" data-target="#addVoucher">Tambah Voucher</a></div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Code Voucher</h3>
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
                    <th><span>Code</span></th>
                    <th><span>Jenis Kupon</span></th>
                    <th><span>Kuota/user</span></th>
                    <th><span>Telah dipakai</span></th>
                    <th><span>Expired Date</span></th>
                    <th><span>Action</span></th>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
        <div class="pagination-box">
            <div class="pag-list">

            </div>
            <select class="select" onchange="setLimit(this.value)">
                <option value="4">4 items</option>
                <option value="8">8 items</option>
                <option value="12">12 items</option>
            </select>
        </div>
    </div>
</section>

<div class="modal" id="addVoucher" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Tambah Voucher</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <h4>Voucher</h4>
                <form method="post" action="<?= base_url() ?>Voucher/save" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Thumbnail Voucher</label>
                        <div class="drop-box">
                            <input class="inputfile" id="thumbnail" type="file" name="thumbnail" required />
                            <div class="ic-upload"><img src="<?= base_url() ?>assets/admin/images/ic-upload.svg" /></div>
                            <div class=" box-btn">
                                <label class="btn-add-photo" for="thumbnail">Drag & drop file or <a class='btn-add-photo' for="thumbnail"> browse </a> file here</label><span>files required .png .jpg</span>
                            </div>
                            <div class="image-preview" style="background-size:cover ;background-image: url()"></div><a class="del-btn">Hapus</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Code Voucher</label>
                        <input class="form-control" type="text" value="" placeholder="Masukan Code Voucher" name="code_voucher" onkeyup="cekData(this.value)" />
                    </div>
                    <div class="form-group">
                        <label>Jenis Voucher</label>
                        <select class="select" name="jenis_voucher" id="jenis_voucher" required>
                            <option value="free">FREE</option>
                            <option value="discount">Discount</option>
                        </select>
                    </div>
                    <div class="form-group" id="form-discount">
                        <label>Persentase Discount</label>
                        <input type="number" name="discount" class="form-control" style="width: 100px;">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelas</label>
                        <select class="select" name="jenis_kelas" id="jenis_kelas" onchange="get_kelas(this.value)" required>
                            <option value="all">Semua</option>
                            <option value="asclepedia">Asclepedia</option>
                            <option value="asclepio_go">Asclepio Go</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas spesifik</label>
                        <select class="select" name="kelas_spesifik[]" multiple="multiple" id="kelas_spesifik">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Pemakaian Kupon/user</label>
                        <input type="checkbox" name="limit_status" id="limit_status" value="no_limit">Tanpa Limit
                        <input type="number" value="0" name="limit_voucher" id="limit_voucher" class="form-control" style="width: 100px;" required>
                        <!-- <small> Isi 0 bila tidak dilmit</small> -->
                    </div>
                    <div class="form-group tgl">
                        <label>Expired date</label>
                        <div class="row">
                            <div class="col-3">
                                <select class="select" name="expired_date" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" name="expired_month" required>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label></label>
                                <select class="select" name="expired_year" required>

                                    <?php for ($i = 1990; $i <= date('Y'); $i++) { ?>
                                        <option <?= ($i == date('Y')) ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Kupon</label>
                        <textarea class="form-control" palecholder="Tulis deskripsi kupon" rows="4" name="deskripsi" required></textarea>
                    </div>
                    <div class="form-action text-right"><a class="btn btn-link" href="#" data-dismiss="modal">Batal</a><button class="btn btn-primary" type="submit">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</div>