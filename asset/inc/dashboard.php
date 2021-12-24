<div class="jumbotron">
  <h3 class="display-6">Selamat datang,  
    <?php
    $nama = $_SESSION['nama_user'] == "Admin";
    if ($nama == "Admin") {
      echo "Administrator!";
    }  else {
      echo "Desa ".$_SESSION['nama_user']."!";
    }
    ?>
  </h3>
  <p class="lead"><b>Si Bandid</b> merupakan aplikasi yang disediakan Kecamatan Mranggen guna memberikan kemudahan kepada Camat mengontrol Perencanaan, Pelaksanaan dan Pelaporan Anggaran Desa.</p>
  <hr class="my-4">
  <p>Tim IT Kecamatan Mranggen</p>
</div>