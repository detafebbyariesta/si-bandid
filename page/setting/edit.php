<?php 
include "../../asset/inc/config.php";

if (isset($_POST['edit'])) {
	$id_user = $_POST['id_user'];
	$username = $_POST['username'];
  $nama_user = $_POST['nama_user'];

	$query = "UPDATE tb_user SET  username='$username', nama_user='$nama_user' WHERE id_user='$id_user'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../index.php?page=user");
      }
}
 ?>