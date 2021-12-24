<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_habis_pakai = $_POST['id_habis_pakai'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_habis_pakai SET  validasi='$validasi', catatan='$catatan' WHERE id_habis_pakai='$id_habis_pakai'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=habis_pakai");
      }
}
 ?>