<!DOCTYPE html>
<html lang="en">
<?php
$this->load->helper('text');
?>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Asclepio" />
    <meta name="theme-color" content="#FFEDBC" />
    <meta name="facebook-domain-verification" content="qryb4tjqa99q3ltfs3mwn9pg5jduo0" />
    <?php
    $e = array(
        'general' => true, //description
        'og' => true,
        'twitter' => true,
        'robot' => true
    );
    meta_tags($e, $title_meta = $meta_title, $desc = $meta_desc, $imgurl = $meta_img, $keyword = $meta_keyword, $url = $meta_url);
    ?>
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= base_url() ?>assets/favicon.ico" />
    <link rel="icon" href="<?= base_url() ?>assets/favicon.ico" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/styles/plugins.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/styles/main.css?v=<?= date("YmdHis") ?>" />
    <link href="<?= base_url() ?>assets/font-awesome-pro-master/css/all.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/front/styles/mfb.css"> -->
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-qJ37Um-z9rWxhaXU"></script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1751101601916260');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1751101601916260&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body>
    <!-- <div class="modal fade" id="modal-maintenance" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <center>
                        Maaf, untuk saat ini website sedang mangalami maintenance. <br><br>
                        Tunggu beberapa saat hingga website berfungsi kembali.
                    </center>
                </div>
            </div>
        </div>
    </div> -->
    <!-- <?php
            $today_time = strtotime(date("Y-m-d"));
            $launch_time = strtotime(date("2022-02-02"));
            if ($today_time < $launch_time) { ?>
        <section class="prelaunch">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-2 col-6 mb-5 mt-5">
                        <img src="<?= base_url() ?>assets/front/images/logo-ascelpio.png" class="w-100" alt="">
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-2 col-3 mb-3">
                        <div class="pre-day">
                            <h1 id="pre-day">00</h1>
                            <span>Hari</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 mb-3">
                        <div class="pre-day">
                            <h1 id="pre-hour">00</h1>
                            <span>Jam</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 mb-3">
                        <div class="pre-day">
                            <h1 id="pre-min">00</h1>
                            <span>Menit</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 mb-3">
                        <div class="pre-day">
                            <h1 id="pre-sec">00</h1>
                            <span>Detik</span>
                        </div>
                    </div>
                </div>
                <div class="row text-left justify-content-center mt-5">
                    <div class="col-md-8">
                        <form action="<?= base_url() ?>Front/subscribe" method="post">
                            <div class="form-group">
                                <label for="">Dapatkan Info Terkini Mengenai Website Asclepio</label>
                                <div class="input-group">

                                    <input type="email" class="form-control" placeholder="Masukkan Email" name="email">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Subscribe</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <a class="icon_socmed" href="https://www.instagram.com/asclepio.masterclass/" target="_blank">
                            <img src="<?= base_url() ?>assets/front/images/ic-ig.png" style="width: 40px;display:inline-block" alt="">
                        </a>
                        <a class="icon_socmed" href="https://www.youtube.com/channel/UC6e_Sbow0u5ydHsb_YRACjw" target="_blank">
                            <img src="<?= base_url() ?>assets/front/images/ic-youtube.png" style="width: 40px;display:inline-block" alt="">
                        </a>
                        <a class="icon_socmed" href="https://www.linkedin.com/company/asclepio-edukasi-medika-indonesia" target="_blank">
                            <img src="<?= base_url() ?>assets/front/images/ic-linkedin.png" style="width: 40px;display:inline-block" alt="">
                        </a>
                        <a class="icon_socmed" href="https://vt.tiktok.com/ZSekPy9os/" target="_blank">
                            <img src="<?= base_url() ?>assets/front/images/ic-tiktok.png" style="width: 40px;display:inline-block" alt="">
                        </a>
                    </div>

                </div>
            </div>
            <center>
                <div class="box_img_piyo">
                    <img src="<?= base_url() ?>assets/front/images/banner-img.png" class="w-100" alt="">
                </div>
            </center>
        </section>
    <?php } ?> -->

    <?php
    if ($this->uri->segment(1) != 'login') { ?>
        <!-- <div class="preloader">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div> -->
    <?php } ?>
    <!-- <?php
            if ($this->uri->segment(1) == 'asclepedia') { ?>
        <a href="https://wa.me/6282141383060" style="position: fixed;right:20px;bottom:50px;z-index:99">
            <img src="https://www.vectorico.com/wp-content/uploads/2018/02/Whatsapp-Icon.png" style="width: 50px;" alt="">
        </a>
    <?php } else { ?>
        <a href="https://wa.me/6281370225009" style="position: fixed;right:20px;bottom:50px;z-index:99">
            <img src="https://www.vectorico.com/wp-content/uploads/2018/02/Whatsapp-Icon.png" style="width: 50px;" alt="">
        </a>
    <?php } ?> -->
    <div id="menu">
        <!-- <a href="https://wa.me/6281346294614" target="_blank" class="buttons" tooltip="Admin ASCLEPIO TOOLS">
            <i class="fab fa-whatsapp" style="font-size: 30px;"></i>
        </a>

        <a href="https://wa.me/6281370225009" target="_blank" class="buttons" tooltip="Admin ASCLEPIO GO">
            <i class="fab fa-whatsapp" style="font-size: 30px;"></i>
        </a>

        <a href="https://wa.me/6282141383060" target="_blank" class="buttons" tooltip="Admin ASCLEPEDIA">
            <i class="fab fa-whatsapp" style="font-size: 30px;"></i>
        </a> -->

        <a href="https://wa.me/6281327257373" class="buttons" tooltip="Tim CS PIYO">
            <i class="fab fa-whatsapp" style="font-size: 30px;"></i>
        </a>
    </div>
    <!-- <ul id="menu" class="mfb-component--br mfb-slidein-spring" data-mfb-toggle="hover" style="z-index: 999;">
        <li class="mfb-component__wrap">
            <a href="javascript:void(0)" class="mfb-component__button--main" data-mfb-label="Butuh bantuan? chat PIYO yuk">
                <i class="mfb-component__main-icon--resting fab fa-whatsapp" style="font-size: 30px;"></i>
                <i class="mfb-component__main-icon--active fab fa-whatsapp" style="font-size: 30px;"></i>
            </a>
            <ul class="mfb-component__list">
                <li>
                    <a href="https://wa.me/6281253241846" target="_blank" data-mfb-label="Admin ASCLEPIO TOOLS" class="mfb-component__button--child">
                        <i class="mfb-component__child-icon fab fa-whatsapp" style="font-size: 30px;"></i>
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/6281370225009" target="_blank" data-mfb-label="Admin ASCLEPIO GO" class="mfb-component__button--child">
                        <i class="mfb-component__child-icon fab fa-whatsapp" style="font-size: 30px;"></i>
                    </a>
                </li>

                <li>
                    <a href="https://wa.me/6282141383060" target="_blank" data-mfb-label="Admin ASCLEPEDIA" class="mfb-component__button--child">
                        <i class="mfb-component__child-icon fab fa-whatsapp" style="font-size: 30px;"></i>
                    </a>
                </li>
            </ul>
        </li>
    </ul> -->
    <div id="wrap">
        <?php
        if ($this->uri->segment(1) == 'login' || $this->uri->segment(1) == 'register') { ?>
            <header class="header header-auth" id="header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"><a class="header__logo" href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/front/images/logo-ascelpio.png" /></a></div>
                        <!-- <div class="col-md-10">
                            <div class="header__right">
                                <div class="play-music"><span>Musik</span>
                                    <div class="btnply switch">
                                        <label>
                                            <input type="checkbox" /><span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="language"><a href="#">EN</a><span></span><a class="active" href="#">ID</a></div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </header>
        <?php } else {

        ?>
            <header class="header" id="header">
                <div class="container">
                    <div class="icon-menu"><span></span><span></span><span></span></div>
                    <div class="row">
                        <div class="col-md-7"><a class="header__logo" href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/front/images/logo-ascelpio.png" /></a>
                            <nav class="header__menu">
                                <ul>
                                    <li class="<?php echo ($this->uri->segment(1) == '') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>">Home</a></li>
                                    <li class="<?php echo ($this->uri->segment(1) == 'asclepedia') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>asclepedia">Asclepedia</a></li>
                                    <li class="<?php echo ($this->uri->segment(1) == 'asclepiogo') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>asclepiogo">Asclepio Go</a></li>
                                    <li class="<?php echo ($this->uri->segment(1) == 'about') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>about">Tentang Kami</a></li>
                                    <li class="<?php echo ($this->uri->segment(1) == 'faq') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>faq">FAQ</a></li>
                                </ul>
                            </nav>
                        </div>
                        <?php


                        if ($this->session->userdata('nama_lengkap') != '') {
                            $follow = $this->query->get_query("SELECT k.*,t.total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.user_id = " . $this->session->userdata('id') . " AND k.tgl_kelas <= CURDATE() AND t.status = 'paid' AND d.status = 'success'")->result();
                            $count_follow = count($follow);
                        ?>

                            <div class="col-md-5 ">
                                <div class="row">
                                    <div class="col-md-4 text-right">
                                        <a href="<?= base_url() ?>cart" class="btn-link" style="display: inline-flex;"><i class="fa fa-shopping-cart"></i></a> 
                                        <?php $count_cart = $this->query->get_query("SELECT COUNT(id) AS count_cart FROM cart WHERE `user_id` = " . $this->session->userdata('id') . " ")->row()->count_cart; ?>
                                        <?php if ($count_cart != 0) { ?>
                                            <label class="badge badge-danger"><?= $count_cart ?></label>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-2 d-none d-md-block">
                                            <a href="<?= base_url() ?>cart" class="btn-link" style="display: inline-flex;"><i class="fa fa-bell"></i></a> 
                                            <label class="badge badge-danger">0</label>
                                        <!-- <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu border-0 py-0 shadow" style="width: 300px;" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item border-bottom" href="#">Action</a>
                                            <a class="dropdown-item border-bottom" href="#">Another action</a>
                                            <a class="dropdown-item border-bottom" href="#">Something else here</a>
                                        </div> -->
                                    </div>
                                    <div class="col-md-6 d-none d-md-block">
                                        <div class="header__right">

                                            <div class="account-user">

                                                <div class="account-photo"><img src="<?= base_url() ?>assets/uploads/member/<?= $this->session->userdata('foto_profil') ?>" onerror="this.src='<?= base_url() ?>assets/uploads/member/profile_default.png'" /></div>
                                                <div class=" account-name"><?= character_limiter($this->session->userdata('nama_lengkap'), 16)  ?></div>
                                                <div class="account-submenu">
                                                    <ul>
                                                        <li><a href="<?= base_url() ?>profile"><img src="<?= base_url() ?>assets/front/images/ic-menu-profile.svg"> <span>Profile</span></a></li>
                                                        <li><a href="<?= base_url() ?>profile"><i class="fa fa-shopping-cart"></i> <span> &nbsp;&nbsp;&nbsp;&nbsp;Keranjang Saya</span></a></li>
                                                        <li><a href="<?= base_url() ?>profile/kelas"><img src="<?= base_url() ?>assets/front/images/ic-menu-following-class.svg"><span>Kelas yang sudah diikuti</span>
                                                                <u class="count"><?= $count_follow ?></u></a></li>
                                                        <li class="logout"><a href="<?= base_url() ?>Auth/logout_cust"><img src="<?= base_url() ?>assets/front/images/ic-menu-logout.svg"> <span>Log out</span></a></li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        <?php } else { ?>
                            <div class="col-md-4">
                                <div class="header__right">
                                    <a class="btn btn-border" href="<?= base_url() ?>login">Masuk</a><a class="btn btn-primary" href="<?= base_url() ?>register">Daftar
                                        Akun</a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="box-navmobile">
                    <div class="box-navmobile__close"><img src="<?= base_url() ?>assets/front/images/ic-close-menu.svg" /></div>
                    <?php if ($this->session->userdata('nama_lengkap') != '') { ?>
                        <div class="box-navmobile__profile">
                            <div class="account-user mobile">
                                <div class="account-photo"><img src="<?= base_url() ?>assets/uploads/member/<?= $this->session->userdata('foto_profil') ?>" /></div>
                                <div class="account-name"><?= $this->session->userdata('nama_lengkap') ?></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <a class="btn btn-border" href="<?= base_url() ?>login">Masuk</a><a class="btn btn-primary" href="<?= base_url() ?>register">Daftar Akun</a>
                    <?php } ?>

                    <hr />
                    <nav class="header__menu-mobile">
                        <ul>
                            <li class="<?php echo ($this->uri->segment(1) == '') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>">Home</a></li>
                            <li class="<?php echo ($this->uri->segment(1) == 'asclepedia') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>asclepedia">Asclepedia</a></li>
                            <li class="<?php echo ($this->uri->segment(1) == 'asclepiogo') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>asclepiogo">Asclepio Go</a></li>
                            <li class="<?php echo ($this->uri->segment(1) == 'about') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>about">Tentang Kami</a></li>
                            <li class="<?php echo ($this->uri->segment(1) == 'faq') ? 'current-menu-item' : ''; ?>"><a href="<?= base_url() ?>faq">FAQ</a></li>
                            <?php if ($this->session->userdata('nama_lengkap') != '') { ?>
                                <hr />
                                <li><a href="<?= base_url() ?>profile"><img src="<?= base_url() ?>assets/front/images/ic-menu-profile.svg"><span>Profile</span></a></li>
                                <li><a href="<?= base_url() ?>cart"><i class="fa fa-shopping-cart"></i> <span> &nbsp;&nbsp;&nbsp;&nbsp;Keranjang Saya</span></a></li>
                                <!-- <li><a href="#">Status pemesanan</a></li> -->
                                <li><a href="<?= base_url() ?>profile/kelas"><img src="<?= base_url() ?>assets/front/images/ic-menu-following-class.svg" alt=""> <span>Kelas yang sudah diikuti</span>
                                        <u class="count"><?= $count_follow ?></u></a></li>
                                <!-- <li><a href="<?= base_url() ?>benefit"><img src="<?= base_url() ?>assets/front/images/ic-menu-benefit.svg" alt=""> <span>Benefit</span>
                                        <u class="count"><?= $count_benefit ?></u></a></li> -->
                                <!-- <li><a href="<?= base_url() ?>setting"><img src="<?= base_url() ?>assets/front/images/ic-menu-setting.svg" alt=""> <span>Pengaturan</span></a></li> -->
                                <li class="logout"><a href="<?= base_url() ?>Auth/logout_cust"><img src="<?= base_url() ?>assets/front/images/ic-menu-logout.svg" alt=""> <span>Log out</span></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </header>
        <?php } ?>

        <main>

            <?= $content ?>

        </main>
        <?php
        if ($this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'register') { ?>
            <footer class="footer" id="footer">
                <div class="footer__main">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="footer__logo">
                                    <img src="<?= base_url() ?>assets/front/images/footer-logo.png" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="footer__nav-wrap">
                                    <div class="footer__menu" style="max-width: 100% !important;">
                                        <table class="w-100 table_footer">
                                            <tr>
                                                <td colspan="2">
                                                    <a href="#" style="color: white !important;"><b>Asclepio Edukasi Medika Indonesia</b></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <i class="fas fa-map-marker-alt text-white"></i>
                                                </td>
                                                <td>
                                                    <small><a href="https://g.page/asclepioedukasimedika?share" target="_blank">Jl. Pondok Wiyung Indah Timur III/Blok MX-18 RT 05 RW 07 <br> Kota Surabaya, Jawa Timur 60115</a></small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-phone text-white"></i>
                                                </td>
                                                <td>
                                                    <small><a href="tel:+6282141383060">+6282141383060</a></small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-envelope text-white"></i>
                                                </td>
                                                <td>
                                                    <small><a href="mailto:info.cs@asclepio.id">info.cs@asclepio.id</a></small>
                                                </td>
                                            </tr>
                                        </table>
                                        <ul>

                                        </ul>
                                    </div>
                                    <div class="footer__menu">
                                        <h4>Asclepedia</h4>

                                        <ul>
                                            <li><small><a href="<?= base_url() ?>asclepedia#good_morning">Good morning knowledge</a></small></li>
                                            <li><small><a href="<?= base_url() ?>asclepedia#skill_labs">Skills Lab</a></small></li>
                                        </ul>
                                        <a class="icon_socmed" href="https://www.instagram.com/asclepio.masterclass/" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-ig.png" alt="">
                                        </a>
                                        <a class="icon_socmed" href="https://t.me/asclepio_asclepedia" target="_blank">
                                            <!-- <img src="<?= base_url() ?>assets/front/images/ic-tele.png" alt=""> -->
                                        </a>

                                    </div>
                                    <div class="footer__menu">
                                        <h4>Asclepio GO</h4>

                                        <ul>
                                            <li><small><a href="<?= base_url() ?>asclepiogo#open_class">Open Class</a></small></li>
                                            <li><small><a href="<?= base_url() ?>asclepiogo#expert_class">Expert Class</a></small></li>
                                            <li><small><a href="<?= base_url() ?>asclepiogo#private_class">Private Class</a></small></li>
                                        </ul>
                                        <a class="icon_socmed" href="https://www.instagram.com/asclepio.classroom/" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-ig.png" alt="">
                                        </a>
                                        <a class="icon_socmed" href="https://t.me/ascpioclassroom" target="_blank">
                                            <!-- <img src="<?= base_url() ?>assets/front/images/ic-tele.png" alt=""> -->
                                        </a>
                                    </div>
                                    <div class="footer__menu">
                                        <h4>Asclepio Tools</h4>

                                        <ul>
                                            <li><small><a href="#">PIYO Scrubs</a></small></li>
                                            <li><small><a href="#">PIYO Tools</a></small></li>
                                            <li><small><a href="#">PIYO Books</a></small></li>
                                        </ul>
                                        <a class="icon_socmed" href="https://www.instagram.com/asclepio.tools/" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-ig.png" alt="">
                                        </a>
                                        <a class="icon_socmed" href="https://t.me/ascpiotools" target="_blank">
                                            <!-- <img src="<?= base_url() ?>assets/front/images/ic-tele.png" alt=""> -->
                                        </a>
                                    </div>
                                    <div class="footer__menu">
                                        <h4>Resources</h4>
                                        <ul>
                                            <li><small><a href="<?= base_url() ?>faq">FAQ</a></small></li>
                                        </ul>
                                        <h4>Ikuti Kami</h4>
                                        <a class="icon_socmed" href="https://www.youtube.com/channel/UC6e_Sbow0u5ydHsb_YRACjw" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-youtube.png" alt="">
                                        </a>
                                        <a class="icon_socmed" href="https://www.linkedin.com/company/asclepio-edukasi-medika-indonesia" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-linkedin.png" alt="">
                                        </a>
                                        <a class="icon_socmed" href="https://vt.tiktok.com/ZSekPy9os/" target="_blank">
                                            <img src="<?= base_url() ?>assets/front/images/ic-tiktok.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="language">
                            <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-globe.png" /></div>
                            <select class="select sel-language">
                                <option>Indonesia</option>
                                <option>English</option>
                            </select>
                        </div> -->
                        <div class="footer__cpyright">Copyright ©2021 Asclepio Edukasi Medika Indonesia</div>
                    </div>
                </div>
            </footer>
        <?php } ?>

    </div>
    <div class="modal mdligyt" id="mdligyt" tabindex="-1">
        <div class="modal-dialog modal-dialog--centered modal-dialog--md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title"></div><a class="close" href="#" data-dismiss="modal" aria-label="Close"><img src="<?= base_url() ?>assets/front/images/ic-xclose.svg" /></a>
                    <div class="box-igyt">
                        <div class="img-box"><img src="<?= base_url() ?>assets/front/images/img-mdl-igyt.png" /></div>
                        <div class="text-box">
                            <h4>Yuk Mampir ke Asclepio!</h4>
                            <p>Follow instagram, join channel telegram dan subscribe youtube Asclepio biar kamu ga ketinggalan acara Asclepedia dan Asclepio GO terbaru! Ada konten buat kita belajar kedokteran SERU bareng PIYO! Buruan mampir!</p>
                        </div>
                        <div class="btn-wrap text-center">
                            <a class="btn btn-border mt-3" href="https://www.instagram.com/asclepio.masterclass/" target="_blank">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-ig-colored.svg" /></div><span>Follow @asclepio.masterclass</span>
                            </a>
                            <a class="btn btn-border mt-3" href="https://www.instagram.com/asclepio.classroom/" target="_blank">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-ig-colored.svg" /></div><span>Follow
                                    asclepio.classroom</span>
                            </a>
                            <a class="btn btn-border mt-3" href="https://www.instagram.com/asclepio.tools/" target="_blank">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-ig-colored.svg" /></div><span>Follow
                                    asclepio.tools</span>
                            </a>
                            <a class="btn btn-border mt-3" href="https://t.me/asclepio_asclepedia" target="_blank">
                                <div class="ic"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/2048px-Telegram_logo.svg.png" style="width: 20px;" /></div><span>Join
                                    asclepio_asclepedia</span>
                            </a>
                            <a class="btn btn-border mt-3" href="https://www.youtube.com/channel/UC6e_Sbow0u5ydHsb_YRACjw" target="_blank">
                                <div class="ic"><img src="<?= base_url() ?>assets/front/images/ic-yt-colored.svg" /></div><span>Subscribe Asclepio Masterclass</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php if ($this->session->userdata('id') != '') { ?>

        <div class="modal fade" id="modal_topik" tabindex="-1" data-backdrop="static">
            <div class="modal-dialog modal-dialog--lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container page-topik">
                            <div class="row justify-content-center">
                                <form action="<?= base_url() ?>Front/save_topik" method="post">
                                    <div class="col-md-12">
                                        <div class="page-topik__title">
                                            <h1>Pilih minimal 3 topik yang kamu suka</h1>
                                            <!-- <p><span id="tc">0</span> dari 3 topik terpilih</p> -->
                                        </div>
                                        <div class="page-topik__list">
                                            <?php
                                            $topik = $this->query->get_data_simple('topik', null)->result();
                                            foreach ($topik as $t) { ?>
                                                <div class="topik-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="topik_<?= $t->id ?>" type="checkbox" value="<?= $t->id ?>" name="topik[]" />
                                                        <label class="custom-control-label" for="topik_<?= $t->id ?>"><?= $t->nama_topik ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="page-topik__bottom">
                                            <div class="notes">
                                                <p>*Topik yang telah dipilih dapan diganti setiap saat <br>melalui halaman profile</p>
                                            </div>
                                            <div class="btn-wrap">
                                                <button class="btn btn-primary" disabled type="submit">Lanjutkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>



    <script type="text/javascript">
        var global_url = '<?= base_url() ?>';
        var user_id = '<?= $this->session->userdata('id') ?>';
    </script>
    <!-- <script src="<?= base_url() ?>assets/front/plugins/jquery/jquery-3.4.1.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/front/scripts/mfb.js"></script> -->
    <script src="<?= base_url() ?>assets/front/plugins/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/front/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>assets/front/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="<?= base_url() ?>assets/front/plugins/datepicker/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/front/plugins/datepicker/daterangepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/front/plugins/powerful-calendar/calendar.min.js"></script>
    <script src="<?= base_url() ?>assets/front/scripts/main.js"></script>
    <script src="<?= base_url() ?>assets/front/scripts/jquery.countdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/front/scripts/mfb.js"></script> -->
    <script src="<?= base_url() ?>assets/font-awesome-pro-master/js/pro.js"></script>
    <!-- <script src="<?= base_url() ?>assets/font-awesome-pro-master/js/free.js"></script> -->
    <script src="https://cdn.jsdelivr.net/gh/stevenschobert/instafeed.js@2.0.0rc1/src/instafeed.min.js"></script>
    <script>
        <?php
        $cek_topik = $this->query->get_data_simple('user_topik', ['user_id' => $this->session->userdata('id')])->result();
        if (!$cek_topik) { ?>
            $(document).ready(function() {
                $('#modal_topik').modal('show', {
                    backdrop: 'static'
                });
            });
        <?php } ?>

        // $(document).ready(function() {
        //     $('#modal-maintenance').modal('show');
        // });
        $('.page-topik').each(function() {
            var t = $(this),
                cb = t.find('input:checkbox'),
                tc = t.find('#tc'),
                cbc = t.find('input:checkbox:checked'),
                bp = t.find('.btn-primary');
            var c = 0;
            console.log(tc);
            cb.each(function() {
                $(this).change(function() {
                    if ($(this).is(':checked')) {
                        c = c + 1;
                        tc.html(c);
                    } else {
                        c = c - 1;
                        tc.text(c);
                    }
                    if (c >= 3) {
                        bp.removeAttr('disabled');
                        // t.find('input:checkbox:not(:checked)').attr("disabled", true);
                    } else {
                        bp.attr('disabled', 'disabled');
                        // t.find('input:checkbox:not(:checked)').removeAttr("disabled");
                    }
                })


            })

        });
    </script>
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
                icon: '<?= $this->session->flashdata('msg_type') ?>',
            })
        </script>

    <?php
    }
    ?>
    <script type="text/javascript">
        var userFeed = new Instafeed({
            get: 'user',
            target: "gallery_ig",
            resolution: 'high_resolution',
            template: '<div class="col-md-4"><a href="{{link}}" target="_blank"><img title="{{caption}}" src="{{image}}" /></a></div>',
            // template: '<div class="col-md-4"><a href="javascript:void(0)"><img title="{{caption}}" src="{{image}}" /></a></div>',
            accessToken: 'IGQVJWbVFuSjZAMamxfek0zMmZAOZADJOakZAjdzdCaFVHY282MUhpblBLeGZAYNzlITVRra0dKdi15anEzeWVRZA21zanI5RjAwNGJqbWUyaWNVQWlvdlNnR1NhdkNQaXlEdmJ0NDhDYmk4YnlzUkZAyS3R1egZDZD'
        });
        userFeed.run();
    </script>
    <script>
        $(document).ready(function() {
            $(window).on("resize", function(e) {
                checkScreenSize();
            });

            checkScreenSize();

            function checkScreenSize() {
                var newWindowWidth = $(window).width();
                if (newWindowWidth < 767) {
                    $("#menu").click(function(e) {
                        $(this).toggleClass("menu_hover");

                    });
                }
            }
        });
        // $("#menu").hover(function() {
        //     $(this).addClass("menu_hover");

        // }, function() {
        //     $(this).removeClass("menu_hover");
        // });
    </script>
    <!-- <script>
        // Set the date we're counting down to
        var countDownDate = new Date("feb 02, 2022 00:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("pre-day").innerHTML = days;
            document.getElementById("pre-hour").innerHTML = hours;
            document.getElementById("pre-min").innerHTML = minutes;
            document.getElementById("pre-sec").innerHTML = seconds;

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                $(".prelaunch").hide();
            }
        }, 1000);
    </script> -->
</body>

</html>