<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_ba_kas = $_POST['id_ba_kas'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_ba_kas SET  validasi='$validasi', catatan='$catatan' WHERE id_ba_kas='$id_ba_kas'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=ba_kas");
      }
}
 ?>