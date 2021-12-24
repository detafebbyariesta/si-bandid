<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_realisasi_apbdes_dana = $_POST['id_realisasi_apbdes_dana'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_realisasi_apbdes_dana SET  validasi='$validasi', catatan='$catatan' WHERE id_realisasi_apbdes_dana='$id_realisasi_apbdes_dana'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=rekap_sumberdana");
      }
}
 ?>