<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$idlain_lain = $_POST['idlain_lain'];
	$validasi = $_POST['debug'];
	$catat = $_POST['catat'];

	$query = "UPDATE tb_lain SET  validasi='$validasi', catatan='$catat' WHERE id_lain_lain='$idlain_lain'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=lain_lain");
      }
}
 ?>