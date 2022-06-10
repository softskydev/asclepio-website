<section class="page-heading">
    <div class="left">
        <h2>Transaksi</h2>
    </div>
    <div class="right">
        <a href="<?= base_url() ?>Transaksi/export" class="btn btn-transparent">
            <div class="icon">
                <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
            </div>
            <span>Download Data Transaksi</span>
        </a>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Stat</h3>
        </div>
        <div class="right">
            <select class="select" id="orderSummary" onchange="setOrder(this.value)">
                <option value="today">Hari ini</option>
                <option value="month">Bulan ini</option>
                <option value="year">Tahun ini</option>
            </select>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>Total Pemasukan</h4><b>Rp, <font id="pemasukan"></font></b>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>Jumlah Orderan Masuk</h4><b>
                    <font id="order"></font>
                </b>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>User yang belum bayar</h4><b>
                    <font id="unpaid"></font>
                </b>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>List Transaksi</h3>
        </div>
        <div class="right">
            <select class="select" onchange="sort(this.value)">
                <option value="terbaru">Terbaru</option>
                <option value="terlama">Terlama</option>
            </select>
            <div class="search-box">
                <div class="search">
                    <input class="form-control" type="text" id="search" onkeyup="search(this.value)" placeholder="Search" />
                </div>
            </div>
        </div>
    </div>
    <div class="benefits-table">
        <table class="table">
            <thead>
                <tr>
                    <th><span>Member</span></th>
                    <th><span>No WA</span></th>
                    <th width="25%"><span>Order Kelas</span></th>
                    <th><span>Pembayaran</span></th>
                    <th><span>Tanggal Order</span></th>
                    <th><span>Action</span></th>
                    <!-- <th class="action"><span>Action</span></th> -->
                </tr>
            </thead>
            <tbody id="table_body">
                <!-- <tr>
                    <td>
                        <div class="author">
                            <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Sonya Soraya</span>
                        </div>
                    </td>
                    <td>
                        <p>Siap Tanggapi Trauma Urogenital</p><small>Good Morning Knowledge • 20 Agustus 2020</small>
                    </td>
                    <td><span class="tag tag-blue">Sukses</span></td>
                    <td>18-09-2021</td>
                    <td>Rp, 650.000</td>
                    <td>
                        <div class="action"><a href="#detailTransaksi" data-toggle="modal"><img src="<?= base_url() ?>assets/admin/images/ic-document.svg" /></a></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="author">
                            <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Sonya Soraya</span>
                        </div>
                    </td>
                    <td>
                        <p>Siap Tanggapi Trauma Urogenital</p><small>Good Morning Knowledge • 20 Agustus 2020</small>
                    </td>
                    <td><span class="tag tag-brown">Belum dibayar</span></td>
                    <td>18-09-2021</td>
                    <td>Rp, 650.000</td>
                    <td>
                        <div class="action"><a href="#detailTransaksi" data-toggle="modal"><img src="<?= base_url() ?>assets/admin/images/ic-document.svg" /></a></div>
                    </td>
                </tr> -->
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

<div class="modal detrans" id="detailTransaksi" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body"><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title">
                    <h3>Detail Transaksi</h3>
                </div>
                <div class="wrap-box-card listview">
                    <label>Kelas</label>
                    <div class="box-card">
                        <div class="box-card__content">
                            <div class="box-card__text">
                                <h4 id="detail_judul">Siap Tanggapi Trauma Urogenital serta pengenalan...</h4><small><span id="detail_kategori"></span> • <span id="detail_tgl"></span></small>
                                <div class="box-card__footer">
                                    <div class="author">
                                        <div class="pp"><img src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span>
                                    </div>
                                    <div class="price" id="detail_price">Rp. 150,000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row detrans-col">
                    <div class="col-md-4">
                        <label>Member</label>
                        <div class="author">
                            <div class="pp"><img id="detail_user" src="<?= base_url() ?>assets/admin/images/pp-author.png" /></div><span id="detail_username">Dr. Ahman Jayadi</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal Order</label>
                        <p id="detail_order">10 Agustus 2021</p>
                    </div>
                    <div class="col-md-4">
                        <label>Pembayaran</label>
                        <div id="detail_label"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>