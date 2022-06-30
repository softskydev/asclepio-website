<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="theme-color" content="#4C9F70" />
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= base_url() ?>assets/favicon.ico" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/styles/plugins.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/styles/main.css" />
    <link href="<?= base_url() ?>assets/font-awesome-pro-master/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>

<body>
    <div id="wrap">
        <main>
            <aside class="sidebar" id="sidebar" style="overflow-y: scroll;">
                <h1 class="logo"><a class="sidebar__logo" href="#"><img src="<?= base_url() ?>assets/admin/images/logo-ascelpio.png" alt="logo-ascelpio" /><span><?= $this->session->userdata('name') ?></span></a></h1>
                <nav class="sidemenu">
                    <ul>
                    
                        <?php
                        if ($this->session->userdata('access') == 'direksi') { ?>
                            <li class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/dashboard"><span>Dashboard</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'asclepedia') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/asclepedia"><span>Asclepedia</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'asclepio_go') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/asclepio_go"><span>Asclepio GO</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'cek_transaksi') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/cek_transaksi"><span>Check Pembayaran</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'pemateri') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/pemateri"><span>Pemateri</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user"><span>User</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'testimoni') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/testimoni"><span>Testimoni</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'topik') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/topik"><span>Master Topik</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'voucher') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/voucher"><span>Voucher</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'transaksi') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/transaksi"><span>Transaksi</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'laporan_keuangan') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/laporan_keuangan"><span>Laporan Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user_analytics') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user_analytics"><span>Analisa Peserta</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'income_analytics') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/income_analytics"><span>Analisa Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'setting_seo' || $this->uri->segment(2) == 'setting_caption') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/setting_caption"><span>Settings</span></a></li>
                        <?php } else if ($this->session->userdata('access') == 'marketing') { ?>
                            <li class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/dashboard"><span>Dashboard</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user"><span>User</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'testimoni') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/testimoni"><span>Testimoni</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'voucher') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/voucher"><span>Voucher</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user_analytics') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user_analytics"><span>Analisa Peserta</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'income_analytics') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/income_analytics"><span>Analisa Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'setting_seo' || $this->uri->segment(2) == 'setting_caption') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/setting_caption"><span>Settings</span></a></li>
                        <?php } else if ($this->session->userdata('access') == 'finance') { ?>
                            <li class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/dashboard"><span>Dashboard</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user"><span>User</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'transaksi') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/transaksi"><span>Transaksi</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'laporan_keuangan') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/laporan_keuangan"><span>Laporan Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'income_analytics') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/income_analytics"><span>Analisa Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user_analytics') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user_analytics"><span>Analisa Peserta</span></a></li>
                        <?php } else if ($this->session->userdata('access') == 'operasional') { ?>
                            <li class="<?php echo ($this->uri->segment(2) == 'asclepedia') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/asclepedia"><span>Asclepedia</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'asclepio_go') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/asclepio_go"><span>Asclepio GO</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'pemateri') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/pemateri"><span>Pemateri</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user"><span>User</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'topik') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/topik"><span>Master Topik</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'transaksi') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/transaksi"><span>Transaksi</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'laporan_keuangan') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/laporan_keuangan"><span>Laporan Keuangan</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'user_analytics') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user_analytics"><span>Analisa Peserta</span></a></li>
                        <?php } else { ?>
                            <li class="<?php echo ($this->uri->segment(2) == 'user') ? 'current-menu-item' : ''; ?>"><a href=" <?= base_url() ?>Admin/user"><span>User</span></a></li>
                            <li class="<?php echo ($this->uri->segment(2) == 'transaksi') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>Admin/transaksi"><span>Transaksi</span></a></li>
                        <?php } ?>
                       
                        <li class=""><a href="<?= base_url() ?>Admin/do_logout"><span>Logout</span></a></li>
                    </ul>
                </nav>
            </aside>
            <div class="admin-content">
                <?= $content ?>
            </div>
        </main>
        <footer class="footer" id="footer">
            <div class="footer__main">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-3"><a class="header__logo" href="#"><img src="<?= base_url() ?>assets/admin/images/logo-ascelpio.png" /></a></div>
                        <div class="col-md-3">
                            <div class="cpyright">Copyright <?php echo date("Y"); ?> Asclepio</div>
                        </div>
                        <div class="col-md-3"><span>Admin</span></div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal" id="modalNotes" tabindex="-1">
        <div class="modal-dialog modal-dialog--centered modal-dialog--sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">
                        <Tulis>Catatan</Tulis>
                    </div>
                    <form>
                        <div class="form-group">
                            <input class="form-control" type="Text" value="" />
                        </div>
                        <div class="form-action text-right"><a class="btn btn--noborder" href="#" data-dismiss="modal">Cancel</a><a class="btn btn--primary" href="#">Simpan</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var global_url = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url() ?>assets/admin/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/admin/plugins/bootstrap-select/bootstrap-select.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/lity/lity.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/jquery-marquee/jquery.marquee.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>
    <script src="<?= base_url() ?>assets/admin/scripts/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/font-awesome-pro-master/js/pro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    
    <?php
    if (isset($script)) {
        $count = sizeof($script);
        $ver = date('l jS \of F Y h:i:s A');
        for ($i = 0; $i < $count; $i++) {
            echo '<script src="' . $script[$i] . '?version=' . $ver . '"></script>';
        }
    }
    ?>

    
    <?php
    if ($this->session->flashdata('msg_type')) {
    ?>
        <script type="text/javascript">
            Swal.fire({
                title: '<?= $this->session->flashdata('msg') ?>',
                icon:  '<?= $this->session->flashdata('msg_type') ?>',
            })
        </script>

    <?php
    }
    ?>
    <script type="text/javascript">
        function onchange_num(id, val) {

            var x = numeral(val).format('0,0');
            $("#" + id).val(x);
        }
    </script>
     <?php if ($this->session->flashdata('msg')): ?>
        <script type="text/javascript">
          toastr["<?= $this->session->flashdata('msg_t') ?>"]("<?= $this->session->flashdata('msg') ?>")
        </script>
    <?php endif ?>
    <script>
        window.editors = {};

        document.querySelectorAll('.editor').forEach((node, index) => {
            ClassicEditor
                .create(node, {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'blockQuote',
                            'insertTable',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'id',
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    },
                    licenseKey: '',
                })
                .then(newEditor => {
                    window.editors[index] = newEditor
                });
        });
    </script>
</body>

</html>