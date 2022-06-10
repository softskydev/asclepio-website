<section class="page-heading">
    <div class="left">
        <h2>Laporan Keuangan</h2>
    </div>
    <div class="right">
        <form action="<?= base_url() ?>Keuangan/export/" method="POST">
            <button class="btn btn-transparent" type="submit">
                <input type="hidden" id="q_filter" name="q">
                <div class="icon">
                    <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
                </div>
                <span>Download Laporan</span>
            </button>
            <a class="btn btn-white" href="#filterLaporan" data-toggle="modal" data-target="#filterLaporan">
                <div class="icon"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-filter.svg" alt="ic-filter" /></div><span>Filter</span>
            </a>
        </form>

    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Stat</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>Pemasukan</h4><b>Rp <font id="income"></font></b>
                <div class="periode"><b>Periode :</b><span></span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>Jumlah Peserta</h4><b id="peserta"></b>
                <div class="periode"><b>Periode :</b><span></span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box-card card-stat">
                <h4>Kelas terlaris</h4>
                <div class="box-kelas">
                    <span id="judul_terlaris">-</span>
                    <small>
                        <font id="kategori_terlaris"></font>•<font id="tgl_terlaris"></font>
                    </small>
                </div>
                <div class="periode"><b>Periode :</b><span></span></div>
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
                    <th><span>Kelas</span></th>
                    <th><span>Jumlah Peserta</span></th>
                    <th><span>Total Income</span></th>
                    <th><span>Action</span></th>
                </tr>
            </thead>
            <tbody id="table_body">
                <!-- <tr>
                    <td>
                        <p>Siap Tanggapi Trauma Urogenital</p><small>Good Morning Knowledge • 20 Agustus 2020</small>
                    </td>
                    <td>20 Peserta</td>
                    <td>Rp, 5.000.000</td>
                </tr> -->
            </tbody>
        </table>
        <div class="pagination-box">
            <div class="pag_list"></div>
            <!-- <ul class="pagination">
                <li class="prev"><a href="#"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-chevron-left.svg" /></a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li class="next"><a href="#"><img class="svg" src="<?= base_url() ?>assets/admin/images/ic-chevron-left.svg" /></a></li>
            </ul> -->
            <select class="select" onchange="setLimit(this.value)">
                <option value="4">4 items</option>
                <option value="8">8 items</option>
                <option value="12">12 items</option>
            </select>
        </div>
    </div>
</section>

<div class="modal mdlDownloadLap" id="filterLaporan" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body"><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title">
                    <h3>Filter</h3>
                </div>
                <div class="form-group">
                    <label>Periode</label>
                    <div class="period__list">
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_0" type="radio" onchange="change_val(this.value)" value="semua" name="period" checked="checked" />
                                <label class="custom-control-label" for="period_0">Semua</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_1" type="radio" onchange="change_val(this.value)" value="today" name="period" />
                                <label class="custom-control-label" for="period_1">Hari ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_2" type="radio" onchange="change_val(this.value)" value="this_week" name="period" />
                                <label class="custom-control-label" for="period_2">Minggu ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_3" type="radio" onchange="change_val(this.value)" value="this_month" name="period" />
                                <label class="custom-control-label" for="period_3">Bulan ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_4" type="radio" onchange="change_val(this.value)" value="custom" name="period" />
                                <label class="custom-control-label" for="period_4">Custom</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="box_date">
                    <div class="datetodate">
                        <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" style="width: 40%;" id="date_1" onchange="set_date()" class="form-control">
                        <div class="to">to</div>
                        <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" style="width: 40%;" id="date_2" onchange="set_date()" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategori Kelas</label>
                    <div class="period__list">
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_0" type="radio" name="kategori" checked="checked" value="semua" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_0">Semua</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_1" type="radio" name="kategori" value="good morning knowledge" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_1">Asclepedia Good Morning Knowledge</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_2" type="radio" name="kategori" value="skill labs" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_2">Asclepedia Skills Lab</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_3" type="radio" name="kategori" value="open_free" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_3">Asclepio GO Open Class Free</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_4" type="radio" name="kategori" value="open_premium" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_4">Asclepio GO Open Class Premium</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="kategori_5" type="radio" name="kategori" value="expert" onchange="change_kategori(this.value)" />
                                <label class="custom-control-label" for="kategori_5">Asclepio GO Expert Class</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label>Range Harga kelas</label>
                    <div class="range-slider" id="range_harga" data-min="0" data-max="500">
                        <div class="val val-min">Free</div>
                        <div class="val val-max">500k</div>
                    </div>
                </div> -->
                <!-- <div class="btn-wrap text-right"><a class="btn btn-transparent" href="#">Save Filter</a></div> -->
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal mdlDownloadLap" id="downloadLaporan" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body"><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/admin/images/ic-xclose.svg" /></a>
                <div class="modal-title">
                    <h3>Download Laporan</h3>
                </div>
                <div class="form-group">
                    <label>Periode</label>
                    <div class="period__list">
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_1" type="radio" name="period" />
                                <label class="custom-control-label" for="period_1">Hari ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_2" type="radio" name="period" />
                                <label class="custom-control-label" for="period_2">Minggu ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_3" type="radio" name="period" />
                                <label class="custom-control-label" for="period_3">Bulan ini</label>
                            </div>
                        </div>
                        <div class="period-item">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="period_4" type="radio" name="period" checked="checked" />
                                <label class="custom-control-label" for="period_4">Custom</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="datetodate">
                        <select class="select" title="Pilih Tanggal Mulai">
                            <option>10 September 2021</option>
                            <option selected="selected">11 September 2021</option>
                            <option>12 September 2021</option>
                            <option>13 September 2021</option>
                            <option>14 September 2021</option>
                            <option>15 September 2021</option>
                            <option>16 September 2021</option>
                        </select>
                        <div class="to">to</div>
                        <select class="select" title="Pilih Tanggal Akhir">
                            <option>10 September 2021</option>
                            <option>11 September 2021</option>
                            <option>12 September 2021</option>
                            <option>13 September 2021</option>
                            <option>14 September 2021</option>
                            <option>15 September 2021</option>
                            <option selected="selected">16 September 2021</option>
                        </select>
                    </div>
                </div>
                <div class="btn-wrap text-right"><a class="btn btn-transparent" href="#">Download</a></div>
            </div>
        </div>
    </div>
</div> -->
