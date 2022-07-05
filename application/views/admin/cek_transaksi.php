<section class="page-heading">
    <div class="left">
        <h2>Cek Transaksi</h2>
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
        <table class="table" id="table_body">
            <thead>
                <tr>
                    <th><span>Member </span></th>
                    <th><span>NO Transaksi</span></th>
                    <th><span>Pembayaran</span></th>
                    <th><span>Tanggal Order</span></th>
                    <th><span>Action</span></th>
                    <!-- <th class="action"><span>Action</span></th> -->
                </tr>
            </thead>
            <tbody >
                
            </tbody>
        </table>
        
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <div class="left"> 
            <h3>Set Ongkir Transaksi (Khusus Bundling / Tools)</h3>
        </div>
        <div class="right">
            
        </div>
    </div>
    <div class="benefits-table">
        <table class="table"  id="table_body_tools_only">
            <thead>
                <tr>
                    <th><span>Member</span></th>
                    <th><span>Kode Transaksi</span></th>
                    <th><span>Status</span></th>
                    <th><span>Tanggal Order</span></th>
                    <th><span>Action</span></th>
                    <!-- <th class="action"><span>Action</span></th> -->
                </tr>
            </thead>
            <tbody >
                
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
<div class="modal fade bd-example-modal-lg" id="addOngkir" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="<?= base_url() ?>Asclepedia/input_ongkir/" method="POST">
        <div class="modal-header">
            <h5 class="modal-title"> Detail Ongkir Transaksi   </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="box-form-materi">
            <input type="hidden" id="transaksi_id" name="transaksi_id" >
            <div class="form-group">
                <label> Nama Member </label>
                <input class="form-control" id="nama_member" name="nama_member" type="text" readonly/>
            </div>
            <div class="form-group">
                <label> Kelas Tools yang dipilih Member </label>
                <input class="form-control" id="nama_kelas" name="nama_kelas"  type="text"  readonly/>
            </div>
            <div class="form-group">
                <label> Kode Pos</label>
                <input class="form-control" id="kode_pos" name="kode_pos" type="text"  />
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea class="form-control" id="alamat_lengkap" name="adress_lengkap" value="address_lengkap" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Nominal Ongkir</label>
                <input type="text" class="form-control" id="ongkir" name="ongkir" value="" onkeyup="onchange_num(this.id,this.value)"/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="verifyPayment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="<?= base_url() ?>Asclepedia/input_ongkir/" method="POST">
        <div class="modal-header">
            <h5 class="modal-title"> Detail Ongkir Transaksi   </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>   
            </button>
        </div>
        <div class="box-form-materi">
            <div class="form-group">
                <img src="" id="bukti_transfer" alt="">
            </div>
            <div class="form-group">
                <label> Nilai Tagihan harus dibayar </label>
                <input class="form-control" id="tagihan_nominal" name="tagihan_nominal"  type="text"  readonly/>
            </div>
            <div class="form-group">
                <label>Informasi Pengirim </label>
                <textarea class="form-control" readonly id="metode_pembayaran" rows="4"></textarea>
            </div>
            <!-- <div class="form-group">
                <label> Keterangan Pembayaran </label>
                <table>
                    <tr>
                        <th>
                            <td>Nama Bank </td>
                            <td>:</td>
                            <td id="nama_bank"></td>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <td>Nomor Rekneing </td>
                            <td>:</td>
                            <td id="norek"></td>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <td>Nama Pengirim </td>
                            <td>:</td>
                            <td id="nama_pemilik_rekening"></td>
                        </th>
                    </tr>
                </table>
            </div> -->
            
        </div>
        <div class="modal-footer">
            <button type="button" id="acc_button" class="btn btn-success">Terima Pembayaran</button>
            <button type="button" id="dec_button" class="btn btn-danger">Tolak Pembayaran</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
  </div>
</div>