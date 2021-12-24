<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_sk = $_POST['id_sk'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_sk SET  validasi='$validasi', catatan='$catatan' WHERE id_sk='$id_sk'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=sk");
      }
}
 ?>