<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$idrealisasi_pad = $_POST['idrealisasi_pad'];
	$validasi = $_POST['debug'];
	$catat = $_POST['catat'];

	$query = "UPDATE tb_realisasi_pad SET  validasi='$validasi', catatan='$catat' WHERE id_realisasi_pad='$idrealisasi_pad'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=p_pad");
      }
}
 ?>