<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login si-bandid</title>

  <!-- Custom fonts for this template-->
  <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="asset/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Favicon-->
  <link rel="shortcut icon" href="asset/img/icon_bandit.png" type="image/x-icon">

</head>

<body class="bg-gradient-dark">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="mt-5 col-md-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="asset/img/logo_demak.png" width="80" height="100">
                    <br><br>
                    <h1 class="h4 text-gray-900 mb-4">Login Si-Bandid</h1>
                    <br><center><p>Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a></p></center>
                    
                  </div>
                  <form action="cek_login.php" class="user" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" placeholder="Masukkan Username" required="" autofocus>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Masukkan Password" required="">
                    </div>
                    <div class="form-group">
                      <!-- tahun diganti untuk tes tampilkan data sesuai tahun yang dipilih -->
                      <select name="tahun" id="" class="form-control">
                        <?php
                        $year = date('Y');
                        for ($i = $year; $i >= 2020; $i--) {
                        ?>
                          <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <input value="Login" type="submit" name="login" class="btn btn-primary btn-user btn-block">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="asset/vendor/jquery/jquery.min.js"></script>
  <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="asset/js/sb-admin-2.min.js"></script>

</body>

</html>