<div class="following-class">
    <div class="container">
        <div class="page_title" style="display: block;">
            <h2>Kelas yang sudah diikuti</h2><br>
            <p id="if_not"></p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="wrap-box-card listview" id="card_list">
                </div>
                <div class="pagination-box">
                    <div class="pag-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal mdlulasan" id="mdlulasan" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h3>Review Kelasmu</h3>
                </div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/front/images/ic-xclose.svg" /></a>
                <div class="box-review">
                    <div id="modal_label"></div>
                    <div class="item-name">
                        <h4 id="modal_judul"></h4>
                    </div>
                    <div class="author" id="modal_pemateri">
                        <!-- <div class="pp"><img src="<?= base_url() ?>assets/front/images/pp-author.png" /></div><span>Dr. Ahman Jayadi</span> -->
                    </div>
                    <div class="input-review">
                        <label id="kepuasan">Lumayan lah</label>
                        <div class="img-star">
                            <img src="<?= base_url() ?>assets/front/images/ic-star.svg" class="star star1" data-value="1" />
                            <img src="<?= base_url() ?>assets/front/images/ic-star.svg" class="star star2" data-value="2" />
                            <img src="<?= base_url() ?>assets/front/images/ic-star.svg" class="star star3" data-value="3" />
                            <img src="<?= base_url() ?>assets/front/images/ic-star-grey.svg" class="star star4" data-value="4" />
                            <img src="<?= base_url() ?>assets/front/images/ic-star-grey.svg" class="star star5" data-value="5" />
                        </div>

                        <input type="hidden" name="rating" id="rating" value="3">
                        <input type="hidden" name="kelas_id" id="kelas_id">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" id="ulasan" placeholder="Tulis deskripsimu tentang asclepio"></textarea>
                    </div>
                    <div class="btn-wrap text-right"><button class="btn btn-primary btn-long" type="button" onclick="addReview()">Kirim</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal mdlulasan-success" id="mdlulasan_success" tabindex="-1">
    <div class="modal-dialog modal-dialog--centered modal-dialog--md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title"></div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/front/images/ic-xclose.svg" /></a>
                <div class="box-review">
                    <div class="img-box"><img src="<?= base_url() ?>assets/front/images/img-ulasan-success.png" /></div>
                    <div class="text-box">
                        <h4>Terima kasih ya!</h4>
                        <p>Jangan ketinggalan kelas menarik lainnya ya. Ayo gabung kelas lagi bersama kami!</p>
                    </div>
                    <div class="btn-wrap text-center"><a class="btn btn-primary" href="#">Lihat kelas lainnya</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var user_id = <?= $this->session->userdata('id') ?>
</script>