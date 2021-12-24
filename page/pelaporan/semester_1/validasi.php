<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_smt_1 = $_POST['id_smt_1'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_smt_1 SET  validasi='$validasi', catatan='$catatan' WHERE id_smt_1='$id_smt_1'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=smt1");
      }
}
 ?>