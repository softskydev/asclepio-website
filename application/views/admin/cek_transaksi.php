<section class="page-heading">
    <div class="left">
        <h2>Cek Transaksi</h2>
    </div>
    <div class="right">
        <a href="<?= base_url() ?>Transaksi/export" class="btn btn-transparent">
            <div class="icon">
                <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
            </div>
            <span></span>
        </a>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left"> 
            <h3>Pembayaran Manual Transaksi</h3>
        </div>
        <div class="right">
            
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
                
            </tbody>
        </table>
        
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