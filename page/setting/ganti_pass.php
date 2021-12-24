<?php 
session_start();
include "../../asset/inc/config.php";

if (isset($_POST['submit'])) {
  $id_user = $_SESSION['id_user'];
  $pass_lama = $_POST['pass_lama'];
  $pass_baru = $_POST['pass_baru'];
  $konfirmasi = $_POST['konfirmasi'];
  $hash = password_hash($pass_baru, PASSWORD_DEFAULT);

  $query = "SELECT *from tb_user WHERE id_user='$id_user'";
  $result = mysqli_query($koneksi, $query);
  while($data = mysqli_fetch_assoc($result)){
    $hasil = $data["password"];
    $verf= password_verify($pass_lama, $hasil);
    if ($verf == true) {
      mysqli_query($koneksi,"UPDATE tb_user set password='$hash' WHERE id_user='$id_user'");
      echo "<script>
          alert('berhasil')</script>";
    }else{
      echo "<script>
          alert('gagal')</script>";
    }
  }
}
 ?>

<div class="row">
  <div class="col-4 offset-4">
    <div class="card">
      <div class="card-header">
        Ganti Password
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="id_user" id="iduser">
        <div class="form-group">
          <label for="pass_lama">Password Lama</label>
          <input type="password" name="pass_lama" class="form-control" id="pass_lama">
        </div>
        <div class="form-group">
          <label for="pass_baru">Password Baru</label>
          <input type="password" name="pass_baru" class="form-control" id="pass_baru">
        </div>
        <div class="form-group">
          <label for="konfirmasi">Konfrimasi Password</label>
          <input type="password" name="konfirmasi" class="form-control" id="konfirmasi">
        </div>
        <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>