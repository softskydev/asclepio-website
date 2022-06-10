<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
    <div class="right">
        <form action="<?= base_url() ?>User/export/" method="POST">
            <button class="btn btn-transparent" type="submit">
                <input type="hidden" id="last_query" name="q">
                <div class="icon">
                    <img class="svg" src="<?= base_url() ?>assets/admin/images/ic_download.svg" alt="ic-download" />
                </div>
                <span>Download Data User</span>
            </button>
        </form>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Semua Peserta</h3>
            <p><?php $query = $this->query->get_data_simple('user', null)->result();
                echo rupiah(count($query)) ?> akun telah terdaftar</p>
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
    <div class="benefits-table" style="overflow-x: scroll;">
        <table class="table" style="width: 125%;">
            <thead>
                <tr>
                    <th><span>Nama Peserta</span></th>
                    <th><span>Universitas</span></th>
                    <th><span>Instansi</span></th>
                    <th><span>Nomor WA</span></th>
                    <th><span>Instagram</span></th>
                    <th><span>Asal Kota</span></th>
                    <th><span>Asclepedia</span></th>
                    <th><span>Asclepio Go</span></th>
                    <th class="total-class"><span>Total class purchased</span></th>
                </tr>
            </thead>
            <tbody id="table_body">
                <!-- <tr>
                    <td>
                        <p>Caca Tsabita</p><small>cacatsabita@email.com</small>
                    </td>
                    <td><span>081209487865</span></td>
                    <td><span>Yogyakarta</span></td>
                    <td class="total-class"><span>2</span></td>
                </tr> -->
            </tbody>
        </table>
        <div class="pagination-box">
            <div class="pag-list"></div>
            <select class="select" onchange="setLimit(this.value)">
                <option value="4">4 items</option>
                <option value="8">8 items</option>
                <option value="12">12 items</option>
                <option value="16">16 items</option>
            </select>
        </div>
    </div>
</section>

<div class="modal" tabindex="-1" role="dialog" id="modal-kelas">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kelas yang sudah diikuti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="w-100">
                    <tr>
                        <td>Asclepedia : <span id="total-ascped"></span></td>
                        <td>Asclepio Go : <span id="total-ascgo"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Kelas yang diikuti : <span id="total-all-class"></span> </td>
                    </tr>
                    <tr>
                        <td colspan="2"> <hr></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Total Pembelian : Rp <span id="total-nominal"></span></b> </td>
                    </tr>
                </table>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Voucher</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="table-kelas">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>