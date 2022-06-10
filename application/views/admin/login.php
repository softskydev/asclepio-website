<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="theme-color" content="#4C9F70" />
  <title>Asclepio</title>
  <link rel="shortcut icon" href="<?= base_url() ?>assets/favicon.ico" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/admin/styles/plugins.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/admin/styles/main.css" />
</head>

<body>
  <div id="wrap">
    <header class="header" id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-2"><a class="header__logo" href="#"><img src="<?= base_url() ?>assets/admin/images/logo-ascelpio.png" /></a></div>
          <div class="col-md-10">
            <div class="header__right">
              <!-- <div class="play-music"><span>Musik</span> -->
              <div class="btnply switch">
                <label>
                  <!-- <input type="checkbox"/><span class="slider"></span> -->
                </label>
              </div>
            </div>
            <!-- <div class="language"><a href="#">EN</a><span></span><a class="active" href="#">ID</a></div> -->
          </div>
        </div>
      </div>
  </div>
  </header>
  <main>
    <section class="login-page">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-8">
            <div class="login-page__wrap">
              <h2>Masuk Admin Asclepio</h2>
              <div class="form-login">


                <form action="<?= base_url() ?>Admin/do_login" method="post">
                  <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="text" name="username" placeholder="username" />
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="userpassword" placeholder="Password" />
                  </div>
                  <div class="rememberme">
                    <div class="custom-control custom-checkbox">
                      <!-- <input class="custom-control-input" id="rememberme" type="checkbox"/> -->
                      <!-- <label class="custom-control-label" for="rememberme">Ingat saya</label> -->
                    </div>
                    <!-- <div class="lostpasswrd"><a href="#">Lost password ?</a></div> -->
                  </div>
                  <div class="form-footer">
                    <button class="btn btn-primary" type="submit">Masuk</button>
                  </div>
                </form>
              </div>
              <div class="register-now">
                <!-- <p>Belum punya akun? <a href="register.html"> Daftar sekarang </a></p> -->
              </div>
            </div>
          </div>
          <div class="col-lg-7"></div>
        </div>
      </div>
      <div class="login-page__image"><img src="<?= base_url() ?>assets/admin/images/image-loginpage.png" alt="login-image" /></div>
    </section>
  </main>
  </div>
  <script src="<?= base_url() ?>assets/admin/jquery/jquery-3.4.1.min.js"></script>


  <script src="<?= base_url() ?>assets/admin/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/admin/bootstrap-select/bootstrap-select.min.js"></script>
  <script src="<?= base_url() ?>assets/admin/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?= base_url() ?>assets/admin/lity/lity.min.js"></script>
  <script src="<?= base_url() ?>assets/admin/jquery-marquee/jquery.marquee.min.js"></script>
  <script src="<?= base_url() ?>assets/admin/scripts/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function($) {
      $("#badge_session").fadeOut('400');
    });
  </script>
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
</body>

</html