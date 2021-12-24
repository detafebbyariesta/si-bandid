<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_lppd = $_POST['id_lppd'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_lppd SET  validasi='$validasi', catatan='$catatan' WHERE id_lppd='$id_lppd'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=lppd");
      }
}
 ?>