<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$idretribusi = $_POST['idretribusi'];
	$validasi = $_POST['debug'];
	$catat = $_POST['catat'];

	$query = "UPDATE tb_retribusi SET  validasi='$validasi', catatan='$catat' WHERE id_retribusi='$idretribusi'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=retribusi");
      }
}
 ?>