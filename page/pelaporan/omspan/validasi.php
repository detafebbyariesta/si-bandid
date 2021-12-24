<?php 
include "../../../asset/inc/config.php";

if (isset($_POST['validasi'])) {
	$id_omspan = $_POST['id_omspan'];
	$validasi = $_POST['debug'];
	$catatan = $_POST['catatan'];

	$query = "UPDATE tb_omspan SET  validasi='$validasi', catatan='$catatan' WHERE id_omspan='$id_omspan'";
      $result = mysqli_query($koneksi, $query);
      // periska query apakah ada error
      if(!$result){
          die ("Query gagal dijalankan: ".mysqli_errno($koneksi).
               " - ".mysqli_error($koneksi));
      } else {

        header("Location:../../../index.php?page=omspan");
      }
}
 ?>