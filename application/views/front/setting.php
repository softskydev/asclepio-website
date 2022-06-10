<div class="staticpage settings">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel__heading">
                        <h2>Pengaturan</h2>
                    </div>
                    <div class="panel__content">
                        <h3>Notifikasi Email</h3>
                        <p>Kirimkan saya notifikasi :</p>
                        <form class="settings__form" action="#">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="settings_1" type="checkbox" name="settings_1" />
                                <label class="custom-control-label" for="settings_1">Terdapat kelas baru yang telah diupload oleh Asclepio</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="settings_2" type="checkbox" name="settings_2" />
                                <label class="custom-control-label" for="settings_2">Jadwal kelas yang akan datang</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="settings_3" type="checkbox" name="settings_3" checked="checked" />
                                <label class="custom-control-label" for="settings_3">Pembayaran yang belum selesai</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="settings_4" type="checkbox" name="settings_4" />
                                <label class="custom-control-label" for="settings_4">Fitur baru dari Asclepio</label>
                            </div>
                        </form>
                    </div>
                    <div class="panel__content">
                        <h3>Hapus akun</h3>
                        <p>Hapus akun akan menghapus semua data-datamu serta menutup akunmu.</p>
                        <div class="btn btn-delete">
                            <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-delete-red.svg" /></div><b>Hapus Akun</b>
                        </div>
                    </div>
                    <div class="panel__footer text-right"><a class="btn btn-primary" href="settings-success.html">Simpan Perubahan</a></div>
                </div>
            </div>
        </div>
    </div>
</div>