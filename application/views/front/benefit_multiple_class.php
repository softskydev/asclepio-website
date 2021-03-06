<div class="benefits">
    <div class="container">
        <div class="page_title" style="display: block;">
            <h2>Benefits</h2><br>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="benefits__item">
                        <div class="panel benefits__panel">
                            <div class="benefits__head wrap-box-card listview">
                                <div class="box-card">
                                    <div class="box-card__img"><img src="<?= base_url() ?>assets/uploads/kelas/<?= $data->jenis_kelas ?>/<?= $data->thumbnail ?>" /></div>
                                    <?php 
                                     if ($data->jenis_kelas == 'asclepedia') {
                                        $kategori = $data->kategori_kelas;
                                        if ($kategori == 'good morning knowledge') {
                                            $label = '<span class="tag">Good morning knowledge</span>';
                                        } else {
                                            $label = '<span class="tag tag-scndry">Skills Lab</span>';
                                        }
                                    } else {
                                        $kategori = $data->kategori_go;
                                        if ($kategori == 'open') {
                                            $label = '<span class="tag tag-open">Open Class</span>';
                                        } else if ($kategori == 'expert') {
                                            $label = '<span class="tag tag-expert">Expert Class</span>';
                                        } else {
                                            $label = '<span class="tag tag-private">Private Class</span>';
                                        }
                                    }
                                    ?>
                                    <div class="box-card__content">
                                        <div class="box-card__text">
                                            <h4><?= ucwords($data->judul_kelas) ?></h4>
                                             <?= $label ?><br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary" onclick="openModal()"><i class="fa fa-play"></i> Tonton Video </button>
                                                </div>

                                                <div class="col-md-8">
                                                    <select name="" id="select_rekaman" class="form-control">
                                                       <?php foreach ($materi as $key) { ?>
                                                       <option value="<?= str_replace('https://www.youtube.com/watch?v=','',$key->link_materi_youtube) ?>"> <?= $key->judul_materi ?></option>
                                                       <?php } ?>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a href="" class="btn btn-primary" id="link_materi" target="_blank"><i class="fa fa-paperclip"></i> Link Materi </a>
                                                </div>

                                                <div class="col-md-8">
                                                    <select name="" id="select_materi" class="form-control">
                                                       <?php foreach ($materi as $key) { ?>
                                                       <option value="<?= $key->link_materi_rekaman ?>"> <?= $key->judul_materi ?></option>
                                                       <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($data->certificate_image != null){ ?>
                                            <div class="row mt-5">
                                                <div class="col-md-12">
                                                    <a href="<?= base_url() ?>Profile/download_certificate/<?= $data->id ?>" target="_blank" class="btn btn-success btn-small" id="link_sertifikat" ><i class="fa fa-download"></i> Unduh Sertifikat </a>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                                Sertifikat belum terupload. Mohon tunggu dulu yaa~ 
                                            <?php } ?>
                                            <?php foreach ($materi as $key) { ?>
                                            <div class="form-group can-copy mt-3">
                                                <label>Password Materi <?= $key->judul_materi ?></label>
                                                <input class="form-control form-control-sm" type="text" value="<?= $key->password_materi ?>" />
                                                <div class="copy">
                                                    <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Copy</span>
                                                </div>
                                            </div>
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="benefits__link">
                                <div class="form-group can-copy">
                                    <label>Link video rekaman</label>
                                    <input class="form-control" type="text" value="<?= $data->link_rekaman ?>" />
                                    <div class="copy">
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Copy</span>
                                    </div>
                                </div>
                                <div class="form-group can-copy">
                                    <label>Link Materi</label>
                                    <input class="form-control" type="text" value="<?= $data->link_materi ?>" />
                                    <div class="copy">
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Copy</span>
                                    </div>
                                </div>
                                <div class="form-group can-copy">
                                    <label>Password Materi</label>
                                    <input class="form-control" type="text" value="<?= $data->password_materi ?>" />
                                    <div class="copy">
                                        <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-copy.svg" /></div><span>Copy</span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>

<div class="modal" id="modal-video" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog--xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title">Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="overflow: hidden;position:relative">
                    <div class="d-none d-md-block d-lg-block d-xl-block" style="position: absolute;width: 100%;top:0;left:0;height:450px;"></div>
                    <div class="d-block d-md-none d-lg-none d-xl-none" style="position: absolute;width: 100%;top:0;left:0;height:100px;"></div>
                    <iframe width="100%" height="500" id="video-yt" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allownetworking="internal" allowfullscreen></iframe>
                </div>

            </div>
        </div>
    </div>
</div>